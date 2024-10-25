<?php

// dotenv
// idea general son distintos phps que se postean a si mismos con nombres de accion en el form
// switch que elija accion y listo, tipo un $_POST["action"]
// tiene sentido una estructura de microservicios? para mi nao... pero no se
class abm // extends clase tipo core con conexion a DB, etc? 
{
    // sin constructor por ahora, solo metodos de a/b/m para ir incluyendo

    /*
        BASIC UTILITIES
    */
    // db connection for queries -> vamos a tener esta clase o vamos a tener un core que nuclee todo?
    public function db() {
        if($this->db == null){
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
        return $this->db;
    }

    // add project
    public function addProject($values){}

    // edit project
    public function editProject($values){}


    // delete project (delete posta o bool?)
    public function deleteProject($values){}
}
