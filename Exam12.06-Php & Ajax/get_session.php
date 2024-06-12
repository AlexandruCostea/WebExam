<?php
session_start();

require_once 'db_config.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_SESSION['userId'])) {
        echo json_encode(array('success' => true));
    } else {
        echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    }
}
?>
