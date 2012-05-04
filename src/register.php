<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/api/core/auth.php');
	//session_start();

	$error=false;
	$errmsg=NULL;
	$auth=new auth();


	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		do{
			if(!isset($_POST['username']) || strlen(trim($_POST['username'])) < 1){
				$error=true;
				$errmsg='Missing username';
				break;
			}

			if(!isset($_POST['password1']) || strlen(trim($_POST['password1'])) < 1){
				$error=true;
				$errmsg='Missing password (first)';
				break;
			}

			if(!isset($_POST['password2']) || strlen(trim($_POST['password2'])) < 1){
				$error=true;
				$errmsg='Missing password (second)';
				break;
			}

			if($_POST['password1'] != $_POST['password2']){
				$error=true;
				$errmsg='Passwords do not match';
				break;
			}

			if($auth->register($_POST['username'],$_POST['password1'])){
				header('Location: /');
				die();
				
			}else{
				$error=true;
				$errmsg='Could not register user';
				break;
			}

		}while(false);
	}





?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Jambusters</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="../assets/css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
		</style>
		<link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="../assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	</head>

	<body>

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">Jambusters</a>

					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-user"></i> 
<?php
	if($auth->is_login()){
		echo htmlentities($auth->name());
	}else{
		echo 'anonymous';
	}
?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
<?php
	if($auth->is_login()){
?>
							<li>
							<a href="/logout.php">Logout</a>
							</li>
<?php
	}else{
?>
							<li>
							<a href="/login.php">Login</a>
							</li>
							<li>
							<a href="/register.php">Register</a>
							</li>
<?php
	}
?>
						</ul>
					</div>

				</div>
			</div>
		</div>

		<div class="container">

			<!-- Example row of columns -->
			<div class="row">

				<div class="span4 offset4 well">
					<h1>Please register</h1>
<?php
	if(isset($error) && $error == true && isset($errmsg)){
?>
<div class="alert alert-error">
	<button class="close" data-dismiss="alert">×</button>
	<strong>Error!</strong> 
<?php
//Change a few things up and try submitting again.
	echo htmlentities($errmsg);
?>
</div>
<?php
	}
?>


					<form method="post" action="">
						<fieldset>
							<div class="controls">
								<p>
								<div class="input-prepend">
									<span class="add-on">
										<i class="icon-user"></i>
									</span><input name="username" class="span3" type="text" placeholder="desired username">
								</div>
								</p>

								<p>
								<div class="input-prepend">
									<span class="add-on">
										<i class="icon-asterisk"></i>
									</span><input name="password1" class="span3" type="password" placeholder="password">
								</div>
								</p>

								<p>
								<div class="input-prepend">
									<span class="add-on">
										<i class="icon-asterisk"></i>
									</span><input name="password2" class="span3" type="password" placeholder="password (one more time)">
								</div>
								</p>

								<button type="submit" name="login" class="btn btn-primary">Register »</button>

							</div>
						</fieldset>
					</form>

					<!-- </div> -->
			</div>
		</div>

		<footer>
		<p>&copy; Jambusters 2012</p>
		</footer>

	</div> <!-- /container -->

	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="../assets/js/jquery.js"></script>
	<script src="../assets/js/bootstrap-transition.js"></script>
	<script src="../assets/js/bootstrap-alert.js"></script>
	<script src="../assets/js/bootstrap-modal.js"></script>
	<script src="../assets/js/bootstrap-dropdown.js"></script>
	<script src="../assets/js/bootstrap-scrollspy.js"></script>
	<script src="../assets/js/bootstrap-tab.js"></script>
	<script src="../assets/js/bootstrap-tooltip.js"></script>
	<script src="../assets/js/bootstrap-popover.js"></script>
	<script src="../assets/js/bootstrap-button.js"></script>
	<script src="../assets/js/bootstrap-collapse.js"></script>
	<script src="../assets/js/bootstrap-carousel.js"></script>
	<script src="../assets/js/bootstrap-typeahead.js"></script>

</body>
</html>

