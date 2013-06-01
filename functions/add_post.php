<?php
	session_start();
	include("conn.php");
	$a = mysql_query("insert into post(
										user_id,
										title,
										content
									)
									Values
									(
										'{$_SESSION['user_id']}',
										'{$_POST['title']}',
										'{$_POST['add_content']}'
									)");
	if($a)
		echo "ok";
	else
		echo mysql_error();
?>