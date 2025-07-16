<?php
	include 'agents.php';
	$servername = "localhost";
    $username = "AdminLab11";
    $password = "4VPnroTOC6wOU3mn";
    $dbname = "agents";
	
	$conn = new mysqli($servername, $username, $password, $dbname);
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