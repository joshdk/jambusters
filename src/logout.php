<?php
	include($_SERVER['DOCUMENT_ROOT'] . '/api/core/auth.php');

	$auth=new auth();
	$auth->logout();

	header('Location: /');
	die();
?>
