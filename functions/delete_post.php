<?php
	include("conn.php");
	
	mysql_query("delete from post where post_id = '{$_POST['id']}'");
?>