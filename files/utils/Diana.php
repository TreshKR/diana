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
    public function event_list( array $filters = [], string $grouping = null ) {

        //$grouping = "day";
        
        // Each array contains strings to be imploded while building the final sql query
        $sql = [
            "CTE"       => [],
            "SELECT"    => [],
            "JOINS"     => [],
            "WHERE"     => [],
            "GROUP"     => [],
            "ORDER"     => []
        ];

        // STATIC VALUES - these never change no matter the method's behaviour
        $sql["JOINS"][] = "LEFT JOIN events_tags et ON e.id = et.event_id";
        $sql["JOINS"][] = "LEFT JOIN tags ON et.tag_id = tags.id";
        $sql["SELECT"][] = "STRING_AGG(DISTINCT tags.name, ', ') as tags";
        // DYNAMIC VALUES such as project_id, dates and other filters
        $params = [];

        // FILTERS
        // PROJECT is the only REQUIRED filter so far
        if ( empty($filters["project_id"]) ) die("HORRIBLE DEATH");
        $sql["WHERE"][] = "e.project_id = :project_id";
        $params["project_id"] = $filters["project_id"];
        unset($filters["project_id"]); // Unset the special filter from the filters
        // TAGS - They work with a CTE
        if ( !empty($filters["tags"]) ) {
            $sql["CTE"][] = "events_with_required_tags AS (
                SELECT events.id
                FROM events
                JOIN events_tags et ON events.id = et.event_id
                JOIN tags ON et.tag_id = tags.id
                WHERE tags.name IN ('".implode( "', '", $filters["tags"]    )."')
                GROUP BY events.id
            )";
            $sql["JOINS"][] = "JOIN events_with_required_tags ewrt ON e.id = ewrt.id ";
            unset($filters["tags"]); // Unset the special filter from the filters
        }
        // DATE - Contains start and end date
        if ( !empty($filters["date"]) ) {
            $sql["WHERE"][] = "e.display_timestamp BETWEEN :start::date AND :end::date";
            $params["start"] = $filters["date"][0];
            $params["end"] = $filters["date"][1];
            unset($filters["date"]);
        }
        // OTHER FILTERS - The can be anything, as long as the events table has the corresponding column
        foreach ( $filters AS $key => $value ) {
            $sql["WHERE"][] = "e.$key = :$key";
            $params[$key] = $value;
        }
        // FILTERS - END

        // GROUPING AND ORDERING
        // With default grouping we dont group, and ordering is simply by display date
        if ( empty($grouping) ) {
            $sql["SELECT"][] = "e.*";
            $sql["SELECT"][] = "null AS _period";
            $sql["SELECT"][] = "null AS period";
            $sql["GROUP"][] = "e.id";
            $sql["ORDER"][] = "e.display_timestamp DESC";
        }
        // All three grouping modes work the same
        // Set a time period (year, month, day) and group by that period.
        else if ( $grouping == "year" ) {
            $sql["SELECT"][] = "'year' AS _period";
            $sql["SELECT"][] = "TO_CHAR(e.display_timestamp, 'YYYY') AS period";
            $sql["SELECT"][] = "COUNT(*) as event_count";
            $sql["GROUP"][] = "TO_CHAR(e.display_timestamp, 'YYYY')";
            $sql["ORDER"][] = "period DESC";
        }
        // Grouping by month really means by year then month
        else if ( $grouping == "month" ) {
            $sql["SELECT"][] = "'month' AS _period";
            $sql["SELECT"][] = "TO_CHAR(e.display_timestamp, 'YYYY-MM') AS period";
            $sql["SELECT"][] = "COUNT(*) as event_count";
            $sql["GROUP"][] = "TO_CHAR(e.display_timestamp, 'YYYY-MM')";
            $sql["ORDER"][] = "period DESC";
        }
        // Same thing here; by year, then month, then day
        else if ( $grouping == "day" ) {
            $sql["SELECT"][] = "'day' AS _period";
            $sql["SELECT"][] = "TO_CHAR(e.display_timestamp, 'YYYY-MM-DD') AS period";
            $sql["SELECT"][] = "COUNT(*) as event_count";
            $sql["GROUP"][] = "TO_CHAR(e.display_timestamp, 'YYYY-MM-DD')";
            $sql["ORDER"][] = "period DESC";
        }
        else die("HORRIBLE GROUPING DEATH");
        // END GROUPING AND ORDERING

        // SQL QUERY GENERATION
        // Its just imploding whatever we put into the $sql array
        $query = "";
        // CTE statement
        if (!empty($sql["CTE"])) $query .= "WITH " . implode( ", ", $sql["CTE"] ) . " ";
        // SELECT statement - columns
        $query .= "SELECT " . implode( ", ", $sql["SELECT"] ) . " ";
        // FROM statement
        $query .= "FROM events e" . " ";
        // JOIN statements
        if (!empty($sql["JOINS"])) $query .= implode( " ", $sql["JOINS"] ) . " ";
        // WHERE statement - conditions
        if (!empty($sql["WHERE"])) $query .= "WHERE " . implode(" AND ", $sql["WHERE"]) . " ";
        // GROUP BY statement
        $query .= "GROUP BY " . implode( ", ", $sql["GROUP"] ) . " ";
        // ORDER BY statement
        $query .= "ORDER BY " . implode( ", ", $sql["ORDER"] ) . " ";
        
        try {
            /*
            // Esto imprime el SQL masomenos formateado (un toque cabeza pero anda)
            $query = preg_replace('/\b(SELECT|FROM|WHERE|AND|OR|ORDER BY|GROUP BY)\b/i', "<br/>$1", $query);
            echo $query;
            die();  
            */
            $list = $this->db->prepare($query);
            // Use the params array to complete the prepared statement
            $list->execute($params);
            return $list->fetchAll();
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }
    public function _event_list( $filters = [] ) {

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
}
