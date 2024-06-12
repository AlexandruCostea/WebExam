<?php
session_start();

require_once 'db_config.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $start_id = $_GET['start_id'];
    $stop_id = $_GET['stop_id'];

    $sql = "SELECT * FROM avatars WHERE id >= $start_id AND id <= $stop_id";
    $result = $conn->query($sql);

    $avatars = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $avatars[] = $row;
        }
    }

    if (count($avatars) == 0) {
        echo json_encode(array('success' => false, 'message' => 'No avatars found.'));
    } else {
        echo json_encode(array('success' => true, 'avatars' => $avatars));
    }
}
?>
