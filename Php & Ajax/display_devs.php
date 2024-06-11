<?php
session_start();

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
        $sql = "SELECT * FROM softwaredeveloper";
        $result = $conn->query($sql);
    
        $devs = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $devs[] = $row;
            }
        }
    
        echo json_encode(array('devs' => $devs));
}
?>
