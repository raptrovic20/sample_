<?php
	include("conn.php");
	
	$username = $_POST['reg_username'];
	$password = md5($_POST['reg_password']);
	$fname = $_POST['reg_fname'];
	$lname = $_POST['reg_lname'];
	$email = $_POST['reg_email'];
	
	$check_user = mysql_query("select * from users where user_name = '{$username}'");
	
	if(mysql_num_rows($check_user) > 0){
		echo "Username already taken";
	}
	else{
		$insert = "insert into users(
										user_name,
										password,
										first_name,
										last_name,
										email
									)
									VALUES
									(
										'{$username}',
										'{$password}',
										'{$fname}',
										'{$lname}',
										'{$email}'
									)";
		mysql_query($insert);
		echo "ok";
	}
?>