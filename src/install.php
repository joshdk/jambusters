<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/api/core/config.inc.php');

	$db=new PDO(
		'mysql:host='.$config['host'].';port='.$config['port'].';dbname='.$config['db'],
		$config['user'],
		$config['pass']
	);

	$sqlfile='../schema/database.sql';

	if(!file_exists($sqlfile)){
		echo 'No schema file to import!';
		die();
	}

	$sql=file_get_contents($sqlfile);

	//echo '<pre>';
	//echo $sql;
	//echo '</pre>';

	$res=$db->query($sql);

	if($res == false){
		echo 'Failed to import!';
		die();
	}

	#import was successful
	header('Location: /');

?>
