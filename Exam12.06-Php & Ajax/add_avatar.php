<?php
session_start();

require_once 'db_config.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = (int)$_POST['age'];
    $powers = $_POST['powers'];
    $rank = (int)$_POST['rank'];
    $timeOfCreation = $_POST['timeOfCreation'];


    $sql = "INSERT INTO avatars (name, age, powers, rank) VALUES ('$name', $age, '$powers', $rank)";
    if ($conn->query($sql) === TRUE) {
        $userId = $_SESSION['userId'];
        $sql2 = "INSERT INTO logs (log_date, log_text, userId) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("ssi", $timeOfCreation, $sql, $userId);
        $stmt->execute();
        echo json_encode(array('success' => true, 'message' => 'Avatar added successfully.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Error adding avatar.'));
    }
}
?>
