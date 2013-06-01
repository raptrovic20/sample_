<html>
	<head>
		<meta charset="utf-8">
		<title>The Hive</title>
		<link rel="stylesheet" href="css/bootstrap.css">
		<script src="js/jquery-2.0.0.min.js"></script>
		<script src="js/jquery_form.js"></script>
		<script src="js/bootstrap.js"></script>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
              <div class="navbar-inner">
                <div class="container">
                  <a href="#" class="brand">The Hive</a>
				</div>
              </div><!-- /navbar-inner -->
		</div>
		<div id='content' class='row-fluid column-fluid'>
			<div class='span3 container-fluid container'>
				<form method="post" action="" id="form_login" name="form_login">
					<table class="table">
						<tr>
							<td>
								Username:
							</td>
							<td>
								<input type="text" placeholder="Username" name="username" id="username">
							</td>
						</tr>
						<tr>
							<td>
								Password:
							</td>
							<td>
								<input type="password" placeholder="Password" name="password" id="password">
							</td>
						</tr>
						<tr>
							<td>
								<a href="#" role="button" class="btn" onclick="verify_login();">Log In</a>
							</td>
							<td align="right">
								<a href="#myModal" role="button" class="btn" data-toggle="modal">Register</a>
							</td>
						</tr>
				</form>
			</div>
		</div>
		<!-- Modal -->
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Register</h3>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" id="form_register" name="form_register">
					<div class="alert alert-block alert-error fade in" id="reg-error" style="display:none;">
						<button type="button" class="close">×</button>
						<div id="reg_error_msg"></div>
					</div>
					<div class="alert alert-block alert-success fade in" id="reg-success" style="display:none;">
						<button type="button" class="close">×</button>
						<div id="reg_error_msg">Success</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="reg_username">Username</label>
						<div class="controls">
							<input type="text" id="reg_username" name="reg_username" placeholder="Username">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="reg_password">Password</label>
						<div class="controls">
							<input type="password" id="reg_password" name="reg_password" placeholder="Password">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="reg_fname">First Name</label>
						<div class="controls">
							<input type="text" id="reg_fname" name="reg_fname" placeholder="First Name">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="reg_lname">Last Name</label>
						<div class="controls">
							<input type="text" id="reg_lname" name="reg_lname" placeholder="Last Name">
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="reg_email">E-Mail</label>
						<div class="controls">
							<input type="text" id="reg_email" name="reg_email" placeholder="E-Mail">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
				<a href="#" role="button" class="btn" onclick="verify_register();">Save</a>
			</div>
		</div>
		<div class="alert alert-block alert-error fade in" id="login-error" style="display:none;">
			<button type="button" class="close">×</button>
			<div id="error_msg">Wrong Username or Password</div>
		</div>
	</body>
</html>

<script type="text/javascript">
$(document).ready(function(){
	$('#form_login').ajaxForm({
		beforeSubmit: function(){
			verify_login(); 
			return false; 
		},
		  success: function(data){
		}
	});
});

$('#login-error .close').click(function(e) {
	$(this).parent().hide();
});

$('#reg-error .close').click(function(e) {
	$(this).parent().hide();
});

function verify_login(){
	// var base_url = "<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>;
	if($("#username").val() == ""){
		$("#error_msg").html("Username Required");
		$("#login-error").show();
		return false;
	}

	if($("#password").val() == ""){
		$("#error_msg").html("Password Required");
		$("#login-error").show();
		return false;
	}
	
	var user_data = $("#form_login").serialize();
	$.ajax({
		url:"functions/verify_login.php",
		type : "POST",
		data: user_data,
		async: false,
		success: function(data){
			if(data == "0"){
				$("#error_msg").html("Wrong Username or Password");
				$("#login-error").show();
			}
			else{
				window.location = "<?php echo $_SERVER['REQUEST_URI'];?>home";
			}
		}
	});
}

function verify_register(){
	if($("#reg_username").val() == ""){
		$("#reg_error_msg").html("Username Required");
		$("#reg-error").show();
		return false;
	}
	if($("#reg_password").val() == ""){
		$("#reg_error_msg").html("Password Required");
		$("#reg-error").show();
		return false;
	}
	if($("#reg_fname").val() == ""){
		$("#reg_error_msg").html("First Name Required");
		$("#reg-error").show();
		return false;
	}
	
	if($("#reg_lname").val() == ""){
		$("#reg_error_msg").html("Last Name Required");
		$("#reg-error").show();
		return false;
	}
	
	if($("#reg_email").val() == ""){
		$("#reg_error_msg").html("Email Required");
		$("#reg-error").show();
		return false;
	}
	
	var reg_data = $("#form_register").serialize();
	$.ajax({
		url:"functions/register.php",
		type : "POST",
		data: reg_data,
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
			}
		}
	});
}


</script>