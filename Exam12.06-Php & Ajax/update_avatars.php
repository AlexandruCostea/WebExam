<?php
session_start();

require_once 'db_config.php';

if (!isset($_SESSION['userId'])) {
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    return;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatesString = $_POST['updates'];
    $updates = json_decode($updatesString, true);

    foreach ($updates as $update) {
        $id = $update['id'];
        $name = $update['name'];
        $age = (int)$update['age'];
        $powers = $update['powers'];
        $rank = (int)$update['rank'];
        $timeOfUpdate = $update['timeOfUpdate'];

        $sql = "UPDATE avatars SET name='$name', age=$age, powers='$powers', rank=$rank WHERE id=$id";
        if ($conn->query($sql) == TRUE) {
            $sql = "INSERT INTO logs (log_date, log_text, userId) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $timeOfUpdate, $sql, $_SESSION['userId']);
            $stmt->execute();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Error updating avatar.'));
            return;
        }
    }
    echo json_encode(array('success' => true, 'message' => 'Avatars updated successfully.'));
}
?>
