<?php
require_once('connect.php');

class MySqlDatabase{
    private $conn, $result, $result_set, $last_query, $variable, $db_conn;

    function __construct(){
        $this->start_server();
    }

    public function start_server(){ 
        $this->conn = mysqli_connect(HOST, USER, PASS, DB);
        if(mysqli_connect_errno()){
            exit('Database connection failed: '.mysqli_connect_error());
        }
    }

    public function escape($variable){
        $result = mysqli_real_escape_string($this->conn, $variable);
        return $result;
    }

    public function query($query){
        $this->last_query = $query;
        $result = mysqli_query($this->conn, $query);
        $this->confirm_query($result);
        return $result;
    }

    public function fetch_array($result){
        $this->result_set = mysqli_fetch_array($result);
        return $this->result_set;
    }

    public function num_rows($result_set){
        return mysqli_num_rows($result_set);
    }
    
    public function insert_id(){
        return mysqli_insert_id($this->conn);
    }
    
    public function affected_rows(){
        return mysqli_affected_rows($this->conn);
    }
    
    private function confirm_query($result){
        if(!$result){
            $output = "Database query failed: " . $result . "<br><br>";
            $output .= "Last SQL query: " . $this->last_query;
           exit($output);
        }
    }

    public function close_server(){
        if(isset($this->conn)){
            mysqli_close($this->conn);
            unset($this->conn);
        }
    }
}
$db_init = new MySqlDatabase();
?>