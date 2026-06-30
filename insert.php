<?php
include 'agents.php';

$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");
$port = getenv("DB_PORT");

// Create a new connection to the MySQL server
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Grab variables and escape them to prevent SQL syntax errors
$id = $conn->real_escape_string($_POST['id']);
$agentName = $conn->real_escape_string($_POST['newAgentName']);
$realName = $conn->real_escape_string($_POST['newRealName']);
$gender = $_POST['newGender'];
$age = $conn->real_escape_string($_POST['newAge']);
$role = $conn->real_escape_string($_POST['newRole']);
$img = $conn->real_escape_string($_POST['newImg']);

// Convert gender to a strict 1 or 0 for MySQL
function genderToBoolean($gender) {
    $lowercaseGender = strtolower($gender);
    return $lowercaseGender === 'male' ? 1 : 0;
}
$isMale = genderToBoolean($gender);

// Insert new agent including the ID passed from JavaScript
$sql = "INSERT INTO agents (id, agent_name, real_name, gender, age, role, img) 
        VALUES ('$id', '$agentName', '$realName', '$isMale', '$age', '$role', '$img')";

if ($conn->query($sql) === TRUE) {
    echo "Inserted!";
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
