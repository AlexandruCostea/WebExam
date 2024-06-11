<?php
session_start();

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $username = $_SESSION['username'];
        $sql = "SELECT * FROM project WHERE members LIKE '%$username%'";
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
