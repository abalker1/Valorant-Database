<?php
	include 'agents.php';
$servername = getenv("DB_HOST");
$username = getenv("DB_USER");
$password = getenv("DB_PASS");
$dbname = getenv("DB_NAME");
$port = getenv("DB_PORT");
	
	$conn = new mysqli($servername, $username, $password, $dbname, $port);
	$sql = "SELECT COUNT(*) as `count` FROM `agents`";
	
	if($conn->query($sql) == TRUE){
    $rsl = $conn->query($sql);
    

    $row = $rsl->fetch_object();
    
    $countN = $row->count;
    
    echo $countN;
    
    
}else{
    echo "Error: " . $sql . " <br>" . $conn->error;
}
$conn->close();
?>
