<?php
include 'agents.php';

$ag1 = new Agent("Reyna", "Zyanya", false, 25, "Duelist", "Reyna.png");
$ag2 = new Agent("Jett", "Sunwoo", false, 20, "Duelist", "Jett.png");
$agentArray = array($ag1, $ag2);

$servername = "localhost";
$username = "AdminLab11";
$password = "4VPnroTOC6wOU3mn";
$dbname = "agents";

// Create a connection to MySQL server
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS " . $dbname;
if ($conn->query($sql) === TRUE) {
    echo "Database " . $dbname . " created or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->close();

// Open a new connection to the created database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}

// Create the Agent table
$sql = "CREATE TABLE IF NOT EXISTS Agent (
    id INT(20) PRIMARY KEY,
    agent_name VARCHAR(30) NOT NULL,
    real_name VARCHAR(30) NOT NULL,
    gender BOOLEAN,
    age INT(10) NOT NULL,
    role VARCHAR(30) NOT NULL,
	img VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Agent created or already exists<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>
