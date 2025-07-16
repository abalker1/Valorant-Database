<?php
include 'agents.php';

$index = $_POST['index'];


    $servername = "localhost";
    $username = "AdminLab11";
    $password = "4VPnroTOC6wOU3mn";
    $dbname = "agents";

    // Create a new connection to the MySQL server
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch agent data from the database
    $sql = "SELECT * FROM `agents` WHERE `id` =" . $index;
    $result = $conn->query($sql);

    // Check if there are results
    if ($result) {
        if ($result->num_rows > 0) {
            // Fetch the row of data
            $row = $result->fetch_assoc();



			$agentName=$row['agentName'];
			$realName = $row['realName'];
			$gender = $row['gender'] == 0 ? 'Male' : 'Female';
			$age = $row['age'];
			$role = $row['role'];
			$img = $row['img'];
			
			$arr = array($agentName, $realName, $gender, $age, $role, $img);

            echo json_encode($arr);
        } else {
            echo json_encode([]); // Return an empty JSON array
        }
    } else {
        echo json_encode(["error" => $conn->error]); // Return an error message
    }

    // Close the database connection
    $conn->close();

?>
