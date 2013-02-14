<?php
$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'] .'/libraries/connect.php';

//	$_SESSION['LocalRoot'] .'/models/oldJobs.php';
//	Sort jobs OLD-NEW by `listed` date.
	try{
		$sql = "SELECT * FROM `jobs` ORDER BY listed";
		$result = $db->query($sql);
		$cols = $result->fetchAll();
		$jobs = $cols;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
