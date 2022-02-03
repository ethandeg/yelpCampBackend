<?php
require_once PROJECT_ROOT_PATH . "/inc/sqlFunctions.php";
class Database
{
    protected $connection = null;

    public function __construct()
    {
        try {
            $this->connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE_NAME);
    	
            if ( mysqli_connect_errno()) {
                throw new Exception("Could not connect to database.");   
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());   
        }			
    }

    public function select($query = "" , $params = [])
    {
        try {
            $stmt = $this->executeStatement( $query , $params );
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);				
            $stmt->close();

            return $result;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }
        return false;
    }

    public function insert($query = "", $params = []){
        //like above function, but make for an insert
        try {
            // echo $query;
            // print_r($params);
            // exit;
            $stmt = $this->executeStatement($query, $params);
            $stmt->close();
        } catch (Exception $e){
            throw New Exception($e->getMessage());
        }
        return false;
    }

    private function executeStatement($query = "" , $params = [])
    {
        try {
            $stmt = $this->connection->prepare( $query );
            if($stmt === false) {
                die("prepare failed (" . $this->connection->errno . ")" . " " . $this->connection->error . "Query: " . $query);
                throw New Exception("Unable to do prepared statement: " . $query);
            }

            if( $params ) {
                ///should be
                // [0], [1...]
                $values = array_slice($params,1);
                $stmt->bind_param($params[0], ...$values);
            }

            $stmt->execute();

            return $stmt;
        } catch(Exception $e) {
            throw New Exception( $e->getMessage() );
        }	
    }
}