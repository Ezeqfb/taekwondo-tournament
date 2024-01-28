<?php
    class Orm{
        protected $id;
        protected $table;
        protected $db;

        public function __construct($id, $table, PDO $conexion){

            $this->id = $id;
            $this->table = $table;
            $this->db = $conexion;
        }

        public function getAll(){
            $stm = $this->db->prepare("SELECT * FROM {$this->table}");
            $stm->execute();
            return $stm->fetchAll();
        }

        public function getUserByName($usuario){
            $stm = $this->db->prepare("SELECT * FROM {$this->table} WHERE usuario = :usuario");
            $stm->execute(array(":usuario" => $usuario));
            return $stm->fetch(PDO::FETCH_ASSOC);
        }

        public function getById($id){
            $stm = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = {$id}");
            $stm->execute();
            return $stm->fetch();
        }
        
        public function getByUserId($id){
            $stm = $this->db->prepare("SELECT * FROM {$this->table} WHERE usuario_id = {$id}");
            $stm->execute();
            return $stm->fetch();
        }

        //función crear cuenta
        public function insertUsuario($usuario, $contrasena) {
            $sql = "INSERT INTO {$this->table} (usuario, contrasena) VALUES (:usuario, :contrasena)";
            
            $stm = $this->db->prepare($sql);
            
            //Bind de los valores
            $stm->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stm->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            
            try {
                $stm->execute();
                //Variable de mensaje (Alert Js /registroORM): Exito
                $this->mensajeExito = "Tu cuenta ha sido creada con éxito.";
            } catch (PDOException $e) {
                //Variable de mensaje (Alert Js /registroORM:) Error
                $this->mensajeError = "Error en la inserción: " . $e->getMessage();
            }
        }
        
        public function insertEA($data){
            $stm = $this->db->prepare("INSERT INTO escuela_alumno (escuela_id, alumno_id) VALUES (:escuela_id, :alumno_id)");
            
            $stm->execute(array(":escuela_id" => $data['escuela_id'], ":alumno_id" => $data['alumno_id']));
            
            return $this->db->lastInsertId();
        }
    }
?>