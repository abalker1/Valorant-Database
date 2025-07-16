<?php
include 'agents.php';

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

// Fetch all agents from the database
$sql = "SELECT * FROM `agents`";
$result = $conn->query($sql);

// Check if there are results
if ($result) {
    $allAgents = array();

    if ($result->num_rows > 0) {
        // Fetch all rows of data
        while ($row = $result->fetch_assoc()) {
            $agentName = $row['agentName'];
            $realName = $row['realName'];
            $gender = $row['gender'] == 0 ? 'Male' : 'Female';
            $age = $row['age'];
            $role = $row['role'];
            $img = $row['img'];

            $agentData = array($agentName, $realName, $gender, $age, $role, $img);
            $allAgents[] = $agentData;
        }
    }

    // Return the array of agents as JSON
    echo json_encode($allAgents);
} else {
    echo json_encode(["error" => $conn->error]); // Return an error message
}

// Close the database connection
$conn->close();
?>
