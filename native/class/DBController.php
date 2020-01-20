<?php
class DBController {
    private $host = "192.168.1.211";
    private $user = "root";
    private $password = "20@Oa#15";
    private $database = "intranet_db";
    private $conn;
    
    function __construct() {
        $this->conn = $this->connectDB();
    }   
    
    function connectDB() {
        $conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
        return $conn;
    }
    
    function runBaseQuery($query) {

        $result = $this->conn->query($query);   
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }
        if(!empty($resultset)) {
            return $resultset;
        }

    }
    
}
?>