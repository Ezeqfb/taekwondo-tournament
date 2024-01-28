<?php
    class Database {
        
        private $connection;
        public function __construct(){
            try {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];
                
                $this->connection = new PDO("mysql:host=localhost;dbname=usuarios", 'root', '', $options);
                $this->connection->exec("SET CHARACTER SET UTF8");
            } catch (PDOException $e) {
                die("Error en la conexión: " . $e->getMessage());
            }
        }
        public function getConnection(){
            return $this->connection;
        }

        public function closeConnection(){
            $this->connection = null;
        }
    }
?>
