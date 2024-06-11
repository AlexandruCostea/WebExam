<?php
session_start();

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
        $sql = "SELECT * FROM project";
        $result = $conn->query($sql);
    
        $projects = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }
        }
    
        echo json_encode(array('projects' => $projects));
}
?>
