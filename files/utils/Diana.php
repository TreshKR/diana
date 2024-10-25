<?php

// dotenv
// idea general son distintos phps que se postean a si mismos con nombres de accion en el form
// switch que elija accion y listo, tipo un $_POST["action"]
// tiene sentido una estructura de microservicios? para mi nao... pero no se
class Diana
{
    public $db = null
    /*
        BASIC UTILITIES
    */
    // 
    public function __constructor( $db_conn ) {
        if( $db_conn !== null ){ $this->db = $db_conn }
        else {
            try {    
                $pdo = new PDO("mysql:host=".POSTGRES_HOST.";dbname=".POSTGRES_DB, POSTGRES_USER, POSTGRES_PASSWORD);
            
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

    //  $values = [column => value, column => value,...]            

    // PROJECTS
    // getter - single project
    public function project_get($id){}

    // getter - list of projects
    public function project_list($ids){}

    // add Project
    public function project_add($values){}

    // edit Project
    public function project_edit($values){}

    // delete Project (delete posta o bool?) --> delete posta
    public function project_delete($values){}

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
}
