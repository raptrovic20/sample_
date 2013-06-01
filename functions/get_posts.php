<?php
	session_start();
	include("conn.php");
	$query = "SELECT
				  post.post_id,
				  post.content,
				  post.title,
				  post.date,
				  post.user_id,
				  users.user_name
				FROM post
				  INNER JOIN users
					ON post.user_id = users.user_id order by post.post_id desc";
	
	$res = mysql_query($query);	
	while($row=mysql_fetch_assoc($res)){
		$delete = '';
		
		if($row['user_id'] == $_SESSION['user_id'])
			// $delete = '<button type="button" class="close" onclick="confirm();" href="arvee.php">×</button>';
			$delete = '<a href="#" class="close" data-confirm="Are you sure you want to delete?" onclick="delete_dialog('.$row['post_id'].')">x</a>';
			
		echo '<p><a href="#">'.$row['title'].'</a> by '.$row['user_name'].' '.$row['date'].' '.' '.$delete.'</p>';
		echo '<p>'.$row['content'].'</p><br/>';
	}
?>