<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

// dotenv
// idea general son distintos phps que se postean a si mismos con nombres de accion en el form
// switch que elija accion y listo, tipo un $_POST["action"]
// tiene sentido una estructura de microservicios? para mi nao... pero no se
class Diana
{
    public $db = null;
    /*
        BASIC UTILITIES
    */
    // 
    public function __construct( $db_conn = [] ) {
        if( !empty($db_conn) ){ $this->db = $db_conn; }
        else {
            try {    
                $pdo = new PDO("pgsql:host=".getenv("POSTGRES_HOST").";dbname=".getenv("POSTGRES_DB"), getenv("POSTGRES_USER"), getenv("POSTGRES_PASSWORD"));
                // Set the PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                // guardo la conexion a db
                $this->db = $pdo;
                } catch(PDOException $e) {
                    die("Connection failed: " . $e->getMessage());
            }
        }
    }


    // PROJECTS
    // getter - single project
    public function project_get($id){
        try{
            $sql = "SELECT *
                    FROM 
                        projects p
                    -- LEFT JOIN 
                    --     events e ON p.id = e.project_id
                    -- LEFT JOIN 
                    --     event_tags et ON e.id = et.event_id
                    WHERE 
                        p.id = :id;";
            $list = $this->db->prepare($sql);
            $list->execute(["id" => $id]);
            return $list->fetch();
        } catch (Exception $e){
            die($e->getMessage());
        }
    }


    // getter - list of projects
    public function project_list($ids = []){
        try{
            /*
            $in  = str_repeat('?,', count($ids) - 1) . '?';
            $sql = "SELECT *
                    FROM 
                        projects p
                    -- LEFT JOIN 
                    --     events e ON p.id = e.project_id
                    -- LEFT JOIN 
                    --     event_tags et ON e.id = et.event_id
                    WHERE 
                        p.id IN ($in);";
            */
            $sql = "SELECT id, title, description FROM projects ORDER BY created_at ASC";
            $list = $this->db->prepare($sql);
            $list->execute($ids);
            return $list->fetchAll();
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    //  $values = [column => value, column => value,...]            
    // add Project
    public function project_add($values){
        try{
            $add_string = implode(", ", array_keys($values));
            $placeholder_string = ":" . implode(", :", array_keys($values));
            $sql = "INSERT INTO projects ($add_string) VALUES ($placeholder_string)";
            $insert = $this->db->prepare($sql)->execute($values);
            return $insert;
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    // edit title Project
    public function project_edit_title($id, $title){
        try{
            $sql = "UPDATE projects SET title = :title WHERE id = :id";
            $update = $this->db->prepare($sql)->execute(["id" => $id, "title" => $title]);
            return $update;
        } catch (Exception $e){
            die($e->getMessage());
        }
    }
    
    // edit description
    public function project_edit_description($id, $description){
        try{
            $sql = "UPDATE projects SET description = :description WHERE id = :id";
            $update = $this->db->prepare($sql)->execute(["id" => $id, "description" => $description]);
            return $update;
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    // delete Project (delete posta o bool?) --> delete posta
    public function project_delete($id){
        try{
            $sql = "DELETE FROM projects WHERE id = :id";
            $list = $this->db->prepare($sql)->execute(["id" => $id]);
            return $list;
        } catch (Exception $e){
            die($e->getMessage());
        }
    }

    // EVENTS
    public function event_list( $filters = [] ) {

        // TAGS are the only filter that have their own table. They behave in a special way
        $tags   = !empty($filters["tags"]) ? $filters["tags"] : null;
        unset($filters["tags"]);
        // OTHER FILTERS
        $conditions = [];   // we'll build a condition for each filter
        $params = [];       // and save whatever parameters the condition needs to work
        foreach ( $filters AS $key => $value ) {
            if (empty($value)) continue;
            // EXCEPTIONS: Filters that have specific behaviour
            // DATE
            if ( $key == "date" ) {
                $conditions[] = "e.display_timestamp BETWEEN :start::date AND :end::date";
                $params["start"] = $filters["date"][0];
                $params["end"] = $filters["date"][1];
            }
            // NORMAL BEHAVIOUR
            else {
                $conditions[] = "e.$key = :$key";
                $params[$key] = $value;
            }
        }

        $sql = "";
        // If we are looking for specific tags, we need to build a virtual table
        if ( !empty($tags) ) {
            $sql .= "WITH events_with_required_tags AS (
                        SELECT events.id
                        FROM events
                        JOIN events_tags et ON events.id = et.event_id
                        JOIN tags ON et.tag_id = tags.id
                        WHERE tags.name IN ('".implode( "', '", $tags)."')
                        GROUP BY events.id
                    ) ";
        }
        // Build the rest of the query
        $sql .= "SELECT e.*, STRING_AGG(tags.name, ', ') as tags FROM events e ";
        if ( !empty($tags) )$sql .= "JOIN events_with_required_tags ewrt ON e.id = ewrt.id ";
        $sql .= "LEFT JOIN events_tags et ON e.id = et.event_id
                    LEFT JOIN tags ON et.tag_id = tags.id ";
        // Include previously arranged conditions
        if ( !empty($conditions) ) $sql .= "WHERE ".implode( " AND ", $conditions) . " ";
        $sql .= "GROUP BY e.id
                ORDER BY e.display_timestamp DESC";
        try {
            $list = $this->db->prepare($sql);
            // Use the params array to complete the prepared statement
            $list->execute($params);
            return $list->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function event_add ( $payload = [] ) {
        try {
            // begin transaction
            $this->db->beginTransaction();
            // if new_tags
            $inserted_tags = [];
            if( !empty($payload["new_tags"])) {
                // insert into table tags   
                $inserted_tags = $this->db->tags_add( array_values($payload["new_tags"]) );
                // remove new_tags from payload for event insert
                // maybe could take them as separate param
                unset( $payload["new_tags"] ); 
            }
            // workaround. need to optimize the tags aspect of this
            $tags = array_merge($payload["tags"], $inserted_tags);
            unset( $payload["tags"] );
            // insert event
            $add_string = implode(", ", array_keys($payload));
            $placeholder_string = ":" . implode(", :", array_keys($payload));
            $sql = "INSERT INTO events ($add_string) VALUES ($placeholder_string)";
            $event_insert = $this->db->prepare($sql)->execute($payload);
            $event_id = $event_insert->lastInsertId(); // event_id for events_tags insert
            // insert into events_tags
            $pairs = [];
            $values = [];
            foreach( $tags as $tag_id ) {
                $pairs[] = '(?,?)';
                $values[] = $event_id;
                $values[] = $tag_id;
            }
            $sql = "INSERT INTO events_tags (event_id, tag_id) VALUES " . implode(',', $pairs);
            $et_insert = $this->db->prepare($sql)->execute($values);
            // commit transaction
            $this->db->commit();
            // return
        } catch ( Exception $e ) {
            // rollback transaction
            $this->db->rollBack();
            die($e->getMessage());

        }
    }

    // TAGS
    public function tag_list( $project_id = null ) {
        $sql = "SELECT tags.name, COUNT(DISTINCT events.id) as count
                FROM tags 
                JOIN events_tags ON tags.id = events_tags.tag_id 
                JOIN events ON events.id = events_tags.event_id 
                WHERE events.project_id = :project_id
                GROUP BY tags.name
                ORDER BY tags.name";
        try {
            $list = $this->db->prepare($sql);
            $list->execute([ "project_id" => $project_id ]);
            return $list->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function tags_add ($payload = [] ) {
        $placeholders = str_repeat('(?),', count($payload) - 1) . '(?)';
        $sql = "INSERT INTO tags (name) VALUES " . $placeholders. " RETURNING id"; // RETURNING id - saves the inserted id to an array
        try {
            $insert = $this->db->prepare( $sql );
            $insert->execute( $payload );
            return $insert->fetchAll(PDO::FETCH_COLUMN); // returns an array with the inserted tags' ids
        } catch ( Exception $e ) {
            throw new Exception("bad tags_add"); // possible idea for handling? just throw everything and have a big debug in try/catch loop in index.php ??
        }
    }

    // COLORS
    public function color_list( $project_id = null ) {
        $sql = "SELECT color, COUNT(DISTINCT id) as count FROM events
                WHERE project_id = :project_id
                GROUP BY color
                ORDER BY count DESC, color ASC";
        try {
            $list = $this->db->prepare($sql);
            $list->execute([ "project_id" => $project_id ]);
            return $list->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // ICONS
    public function icon_list( $project_id = null ) {
        $sql = "SELECT icon, COUNT(DISTINCT id) as count FROM events
                WHERE project_id = :project_id
                GROUP BY icon
                ORDER BY count DESC, icon ASC";
        try {
            $list = $this->db->prepare($sql);
            $list->execute([ "project_id" => $project_id ]);
            return $list->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    
    /*
    *
    *   UTILITIES
    *   functions that are to be used - non database related
    */
    // utility 4 payload filtering via required + optional fields
    function buildPayload( $requiredFields, $optionalFields, $postData ) {
        // First check for required fields
        $payload = [];
        foreach ($requiredFields as $field) {
            if (!isset($postData[$field])) {
                return false;  // Missing required field
            }
            $payload[$field] = $postData[$field];
        }

        // Then add any optional fields that are present
        foreach ($optionalFields as $field) {
            if (isset($postData[$field])) {
                $payload[$field] = $postData[$field];
            }
        }
        
        return $payload;
    }
}
