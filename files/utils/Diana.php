<?php

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
    public function project_list($ids){
        try{
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
    public function event_list($filters){
        try{
            $sql = "SELECT events.*,
                    STRING_AGG(tags.name, ', ') as tags
                    FROM events
                    LEFT JOIN events_tags et ON events.id = et.event_id
                    LEFT JOIN tags ON et.tag_id = tags.id
                    GROUP BY events.id
                    ORDER BY events.display_timestamp DESC";
                $list = $this->db->prepare($sql);
            $list->execute();
            return $list->fetchAll();
        } catch (Exception $e){
            die($e->getMessage());
        }    
    }

    // get tags
}
