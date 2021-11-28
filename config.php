<?php
	$databaseHost = 'localhost';
	$databaseName = 'warnet';
	$databaseUsername = 'root';
	$databasePassword = '';
	$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

	if (mysqli_connect_errno()){
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
?>