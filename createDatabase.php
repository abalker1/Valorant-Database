<?php
include 'agents.php';

$ag1 = new Agent("Reyna", "Zyanya", false, 25, "Duelist", "Reyna.png");
$ag2 = new Agent("Jett", "Sunwoo", false, 20, "Duelist", "Jett.png");
$agentArray = array($ag1, $ag2);

$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");

// Open a new connection to the created database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}

// Create the Agent table
$sql = "CREATE TABLE IF NOT EXISTS agents (
    id INT(20) PRIMARY KEY,
    agent_name VARCHAR(30) NOT NULL,
    real_name VARCHAR(30) NOT NULL,
    gender BOOLEAN,
    age INT(10) NOT NULL,
    role VARCHAR(30) NOT NULL,
	img VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table agents created or already exists<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
?>
