<?php
session_start();
?>
<html>
	<head>
		<meta charset="utf-8">
		<title>The Hive</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<script src="js/jquery-2.0.0.min.js"></script>
		<script src="js/jquery_form.js"></script>
		<script src="js/bootstrap.js"></script>
		<script src="js/bootbox.js"></script>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container">
                  <a href="#" class="brand">The Hive</a>
				  <h4>WELCOME! <?php echo $_SESSION['first_name']?></h4>
				</div>
              </div><!-- /navbar-inner -->
            </div>
		<div id='content' class='row-fluid column-fluid'>
			<div class='span10 navbar-inner' id="posts">
			</div>
			<div class="span2 offset10 affix">
				<a href="#myModal" role="button" class="btn" data-toggle="modal">Add Post</a>
			</div>
		</div>
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Add post</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form_add_post" name="form_add_post">
					<div class="alert alert-block alert-error fade in" id="reg-error" style="display:none;">
						<button type="button" class="close">×</button>
						<div id="reg_error_msg"></div>
					</div>
					<div class="alert alert-block alert-success fade in" id="reg-success" style="display:none;">
						<button type="button" class="close">×</button>
						<div id="reg_error_msg">Success</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="title">Title</label>
						<div class="controls">
							<input type="text" id="title" name="title" placeholder="Title">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="content">Content</label>
						<div class="controls">
							<textarea rows="5" id="add_content" name="add_content" placeholder="Content"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<a href="#" role="button" class="btn" onclick="verify_post();">Save</a>
			</div>
		</div>
	</body>
</html>
<script type="text/javascript">
$('#login-error .close').click(function(e) {
	$(this).parent().hide();
});

$('#reg-error .close').click(function(e) {
	$(this).parent().hide();
});
$(document).ready(function(){
	$.ajax({
		url:"functions/get_posts.php",
		async: false,
		success: function(data){
			$("#posts").html(data);
		}
	});	
});

function refresh(){
	$.ajax({
		url:"functions/get_posts.php",
		async: false,
		success: function(data){
			$("#posts").html(data);
		}
	});
}

function verify_post(){
	if($("#title").val() == ""){
		$("#reg_error_msg").html("Title required");
		$("#reg-error").show();
		return false;
	}
	
	if($("#add_content").val() == ""){
		$("#reg_error_msg").html("Content required");
		$("#reg-error").show();
		return false;
	}
	
	var post_data = $("#form_add_post").serialize();
	
	$.ajax({
		url:"functions/add_post.php",
		type : "POST",
		data: post_data,
		async: false,
		success: function(data){
			if(data != "ok"){
				$("#reg_error_msg").html(data);
				$("#reg-error").show();
				$("#reg-success").hide();
				return false;
			}
			else{
				$("#reg-success").show();
				$("#reg-error").hide();
				refresh();
			}
		}
	});
}

function delete_post(id){
	$.ajax({
		url:"functions/delete_post.php",
		type : "POST",
		data: 'id='+id,
		async: false,
		success: function(data){
			$("#dataConfirmModal").hide();
			$('#dataConfirmModal').modal({show:false});
			refresh();
		}
	});
}

function delete_dialog(id){
	// var onclick = delete_post(id);

	if (!$('#dataConfirmModal').length) {
		$('body').append('<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h3 id="dataConfirmLabel">Please Confirm</h3></div><div class="modal-body"></div><div class="modal-footer"><button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button><a class="btn btn-primary" id="dataConfirmOK">OK</a></div></div>');
	} 
	$('#dataConfirmModal').find('.modal-body').text($(this).attr('data-confirm'));
	$('#dataConfirmOK').attr('onclick', 'delete_post('+id+')');
	$('#dataConfirmModal').modal({show:true});
	return false;
}
</script>