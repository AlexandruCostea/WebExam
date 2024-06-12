<?php
session_start();

require_once 'db_config.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $sql = "SELECT * FROM avatars";
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
