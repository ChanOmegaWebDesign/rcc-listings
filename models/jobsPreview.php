<?php 
$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'] .'/libraries/connect.php';

	// find the last three jobs listed if email is confirmed
	try{
		$sql = "SELECT * FROM `jobs` WHERE email_confirmed=1 ORDER BY listed DESC LIMIT 3";
		$result = $db->query($sql);
		$cols = $result->fetchAll();
		$jobs = $cols;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
