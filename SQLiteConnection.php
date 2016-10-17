<?php
class SQLiteConnection {
   
    private $pdo;
 
    /**
     * return in instance of the PDO object that connects to the SQLite database
     * @return \PDO
     */
    public function connect() {
        if ($this->pdo == null) {
            try {
               $this->pdo = new \PDO("sqlite:protocol.db");
            } catch (\PDOException $e) {
               // handle the exception here
            }
        }
        return $this->pdo;
    }
}