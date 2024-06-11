<?php
session_start();

require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dev_name = $_POST['dev_name'];
    $project_list = $_POST['project_list'];
    $project_list = explode(",", $project_list);
    $project_list = array_map('trim', $project_list);

    $sql = "SELECT * FROM softwaredeveloper WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $dev_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows < 1) {
        echo json_encode(array('success' => false, 'message' => 'User does not exist.'));
    } else {
        $sql = "SELECT * FROM project";
        $result = $conn->query($sql);

        $projects = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }
        }

        //loop the project_list, and for each project that exists in projects, add the dev_name to the members list
        //if the project does not exist, create a new project with the dev_name as the only member and all other fields empty
        foreach ($project_list as $project) {
            $project_exists = false;
            foreach ($projects as $p) {
                if ($p['name'] == $project) {
                    $project_exists = true;
                }
            }
            if (!$project_exists) {
                $sql = "INSERT INTO project (name, members) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $project, $dev_name);
                $stmt->execute();
            } else {
                $sql = "SELECT * FROM project WHERE name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $project);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $members = $row['members'];
                $members = explode(",", $members);
                $members = array_map('trim', $members);
                $members = array_filter($members);
                if (!in_array($dev_name, $members)) {
                    $members = $row['members'] . ", " . $dev_name;
                    $sql = "UPDATE project SET members = ? WHERE name = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $members, $project);
                    $stmt->execute();
                }
            }
        }
        echo json_encode(array('success' => true));
    }
}
?>
