<?php
include 'agents.php';

// Retrieve the JSON data from the POST request
$data = json_decode($_POST['mynewdata'], true);

$servername = "localhost";
$username = "AdminLab11";
$password = "4VPnroTOC6wOU3mn";
$dbname = "agents";

// Create a new connection to MySQL server
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Loop through each agent in the data array and insert into the database
foreach ($data as $agent) {
    $agent_name = $conn->real_escape_string($agent['agentName']);
    $real_name = $conn->real_escape_string($agent['realName']);
    $gender = $agent['gender'] ? 1 : 0; // Convert boolean to integer
    $age = $conn->real_escape_string($agent['age']);
    $role = $conn->real_escape_string($agent['role']);
    $img = $conn->real_escape_string($agent['img']);

    // Insert the agent into the database
    $sql = "INSERT INTO agents (agent_name, real_name, gender, age, role, img) 
            VALUES ('$agentName', '$realName', '$gender', '$age', '$role', '$img')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error inserting agent: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
