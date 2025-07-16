<?php
	include 'agents.php';
	
	$id = $_POST['id'];
	$agentName = $_POST['agentName'];
	$realName = $_POST['realName'];
	$gender = $_POST['gender'];
	$age = $_POST['age'];
	$role = $_POST['role'];
	
	$servername = "localhost";
	$username = "AdminLab11";
	$password = "4VPnroTOC6wOU3mn";
	$dbname = "agents";
	
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error . "<br>");
	}


	$sql = "UPDATE `agents` SET `agentName`='$agentName', `realName`='$realName', `gender`='$gender', `age`='$age', `role`='$role' WHERE `id`='$id'";
	$conn->query($sql);

	$conn->close();
?>