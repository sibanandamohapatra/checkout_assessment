<?php
    /*
    * PDO Database Class
    * Create a Prepared Statement
    * Bind Values
    * Return Rows and Results
    */

    class Database {
        private $host = DB_HOST;
        private $username = DB_USER;
        private $password = DB_PASSWORD;
        private $db_name = DB_NAME;

        private $dbh; //db handeler
        private $stmt; // prepare statemnt
        private $error;

        public function __construct(){
            try{
                // Create DSN
                $dsn = "mysql:host=$this->host;dbname=$this->db_name";
                // Cretate Attribute Option array ATTR_PERSISTENT => its increase performance 
                $option = [
                    PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ];
                // Create a pdo instance
                $this->dbh = new PDO($dsn, $this->username, $this->password);
            }
            catch(PDOException $e){
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }

        // Prepare statement with query
        public function query($sql){
            $this->stmt = $this->dbh->prepare($sql);
        }

        // Bind Values
        public function bind($param, $value, $type = NULL){
            if(is_null($type)){
                switch(true){
                    case is_int($type):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($type):
                        $type = PDO::PARAM_BOOL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

        // Execute the prepared statement
        public function execute(){
            return $this->stmt->execute();
        }

        // Get results set arrau of object
        public function resultSet(){
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_OBJ);
        }

        // Get a single record as oblect
        public function result(){
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }

        // Get the result Count
        public function rowcount(){
            return $this->stmt->rowCount();
        }
    }
