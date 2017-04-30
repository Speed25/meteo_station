
<?php
	/* Attempt MySQL server connection. Assuming you are running MySQL
	server with default setting (user 'root' with no password) */
	$server = "";
	$user = "";
	$pwd = "";
	$dbname = "";
	
	$temp = $_POST['temp'];
    $humi = $_POST['humi'];
	$arduino = $_POST['arduino'];
	$pression = $_POST['pression'];
	$link = mysqli_connect($server, $user, $pwd, $dbname);
 
	// Check connection
	if($link === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	 
	// Attempt insert query execution
	$sql = "INSERT INTO sensor (temp, humi, arduino, pression) VALUES ('".$_GET["temp"]."','".$_GET["humi"]."','".$_GET["arduino"]."','".$_GET["pression"]."')";
	if(mysqli_query($link, $sql)){
		echo "Records added successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
	 
	// Close connection
	mysqli_close($link);
?>