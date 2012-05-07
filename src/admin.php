<?php
	include_once($_SERVER['DOCUMENT_ROOT'] . "/api/core/auth.php");

	$auth=new auth();

	if(!$auth->is_login() || !$auth->is_admin()){
		header('Location: /');
		die();
	}

	//session_start();

	//print_r($_SERVER);
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		//var_dump($_POST);
		if(isset($_POST['promote']) && isset($_POST['name']) && strlen(trim($_POST['name'])) > 0){
			$auth->promote($_POST['name'], true);

		}else if(isset($_POST['demote']) && isset($_POST['name']) && strlen(trim($_POST['name'])) > 0 && trim($_POST['name']) != $auth->name()){
			$auth->promote($_POST['name'], false);

		}else if(isset($_POST['delete']) && isset($_POST['name']) && strlen(trim($_POST['name'])) > 0 && trim($_POST['name']) != $auth->name()){
			$auth->delete($_POST['name']);

		}

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
		<link href="assets/css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}
		</style>
		<link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
	</head>

	<body>

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="/">Jambusters</a>

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



			<div class="row">

				<div class="span12 columns">
					<form method="post" action="">
						<fieldset>
							<div class="controls">
							<input type="text" name="name" class="input-xlarge" placeholder="enter a username">
							</div>
							<button type="submit" name="promote" class="btn btn-primary">Promote</button>
							<button type="submit" name="demote" class="btn btn-primary">Demote</button>
							<button type="submit" name="delete" class="btn btn-danger">Delete</button>
						</fieldset>
					</form>

				</div>
			</div>

			<footer>
			<p>&copy; Jambusters 2012</p>
			</footer>

		</div> <!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="assets/js/jquery.js"></script>
		<script src="assets/js/bootstrap-transition.js"></script>
		<script src="assets/js/bootstrap-alert.js"></script>
		<script src="assets/js/bootstrap-modal.js"></script>
		<script src="assets/js/bootstrap-dropdown.js"></script>
		<script src="assets/js/bootstrap-scrollspy.js"></script>
		<script src="assets/js/bootstrap-tab.js"></script>
		<script src="assets/js/bootstrap-tooltip.js"></script>
		<script src="assets/js/bootstrap-popover.js"></script>
		<script src="assets/js/bootstrap-button.js"></script>
		<script src="assets/js/bootstrap-collapse.js"></script>
		<script src="assets/js/bootstrap-carousel.js"></script>
		<script src="assets/js/bootstrap-typeahead.js"></script>

		<script src="assets/js/housing.js"></script>

	</body>
</html>
