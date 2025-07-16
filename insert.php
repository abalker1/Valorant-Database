<?php
include 'agents.php';

$agentName = $_POST['newAgentName'];
$realName = $_POST['newRealName'];
$gender = $_POST['newGender'];
$age = $_POST['newAge'];
$role = $_POST['newRole'];
$img = $_POST['newImg'];

if (isset($_FILES['imgUpload']) && $_FILES['imgUpload']['error'] == UPLOAD_ERR_OK) {
    $img = base64_encode(file_get_contents($_FILES['imgUpload']['tmp_name']));
}

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

// Get the maximum value from the `id` column
$sqlMaxId = "SELECT MAX(`id`) AS maxId FROM `agents`";
$resultMaxId = $conn->query($sqlMaxId);

// Check if there are results
if ($resultMaxId) {
    $rowMaxId = $resultMaxId->fetch_assoc();
    $maxId = $rowMaxId['maxId'];

    // Alter the table to set the auto-increment value
    $sqlAlterAutoIncrement = "ALTER TABLE `agents` AUTO_INCREMENT = " . ($maxId + 1);
    $resultAlterAutoIncrement = $conn->query($sqlAlterAutoIncrement);

    if (!$resultAlterAutoIncrement) {
        echo "Error resetting auto-increment: " . $conn->error;
        $conn->close();
        exit;
    }
} else {
    echo "Error fetching maximum ID: " . $conn->error;
    $conn->close();
    exit;
}

// Insert new agent
//check if male or female
function genderToBoolean($gender) {
    // Convert the gender string to lowercase for case-insensitive comparison
    $lowercaseGender = strtolower($gender);

    // Check if the lowercase gender is "male", return true if it is, otherwise return false
    return $lowercaseGender === 'male';
}
$isMale = genderToBoolean($gender);


$sql = "INSERT INTO agents (agentName, realName, gender, age, role, img) VALUES ('".$agentName."','".$realName."','".$isMale."','".$age."','".$role."','".$img."')";

if ($conn->query($sql) == TRUE) {
    echo "Inserted!";
} else {
    echo "Error: " . $sql . " <br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
