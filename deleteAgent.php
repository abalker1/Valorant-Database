<?php
	include 'agents.php';
	
	$servername = "localhost";
	$username = "AdminLab11";
	$password = "4VPnroTOC6wOU3mn";
	$dbname = "agents";

	$index = $_POST['index'];
// Create a connection to MySQL server
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error . "<br>");
	}
	
	$sqlMaxId = "SELECT MAX(id) AS maxId FROM agents";
	$resultMaxId = $conn->query($sqlMaxId);

	if ($resultMaxId === FALSE) {
		echo "Error getting maxId: " . $conn->error;
		$conn->close();
		exit();
	}

$row = $resultMaxId->fetch_assoc();
$maxId = $row['maxId'];
	
	$sql = "DELETE FROM `agents` WHERE `agents`.`id` = $index";
	
	if ($conn->query($sql) === TRUE) {
    echo "Agent deleted successfully";
	
	$sqlUpdateIDs = "SET @count = 0; UPDATE agents SET id = @count:= @count + 1;";
    $resultUpdateIDs = $conn->multi_query($sqlUpdateIDs);
	
	$sqlAlterAutoIncrement = "ALTER TABLE agents AUTO_INCREMENT = " . ($maxId);
    $resultAlterAutoIncrement = $conn->query($sqlAlterAutoIncrement);

    if ($resultAlterAutoIncrement === FALSE) {
        echo "Error altering AUTO_INCREMENT: " . $conn->error;
    }
	
	
} else {
    echo "Error deleting agent: " . $conn->error;
}

// Close the database connection
$conn->close();

?>