<?php
	include("conn.php");
	
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	
	$query = "select * from users where user_name = '{$username}' and password = '{$password}'";
	// print_r($query);
	$result = mysql_query($query);
	$row=mysql_fetch_assoc($result);
	
	if(mysql_num_rows($result) > 0){
		ob_start();
		session_start();
		$_SESSION['user_id'] = $row['user_id'];
		$_SESSION["first_name"]=$row['first_name'];
		echo "1";
	}
	else{
		echo "0";
	}
?>