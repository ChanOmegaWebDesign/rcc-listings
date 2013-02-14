<!DOCTYPE html>

<!--[if IE 8]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" lang="en"><!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="css/foundation.min.css">
	<link rel="stylesheet" href="css/default.css">
	<script src="js/foundation/modernizr.foundation.js"></script>
</head>

<body>
<div class="row">
<h5>Installation script:</h5>

<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/libraries/connect.php';

    if($db){
        echo '<div class="alert-box success">The database is connected.</div>';
    } else {
    	printError('The database is NOT connected.');
    }

    try{
	    $sql = "DROP TABLE IF EXISTS blogs";
		$result = $db->query($sql);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try{
		$sql = "CREATE TABLE IF NOT EXISTS blogs (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(200) NOT NULL,
			content TEXT NOT NULL
		)";
		$result = $db->query($sql);
		printMessage($result->queryString);
	} catch (PDOException $e) {
		die(printError($e->getMessage()));
	}

	// Arleigh's job table:

    try{
	    $sql = "DROP TABLE IF EXISTS jobs";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try{
		$sql = "CREATE TABLE IF NOT EXISTS jobs (
			id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(200) NOT NULL,
			description TEXT NOT NULL,
			listed TIMESTAMP DEFAULT NOW(),
			company VARCHAR(30),
			contact VARCHAR(30) NOT NULL,
			location VARCHAR(30) NOT NULL,
			telecommute VARCHAR(5) NOT NULL,
			contact_email VARCHAR(60) NOT NULL,
			pays VARCHAR(30),
			hired DATE,
			dev_id INT		
		)";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	/* Put your SQL installation code here:

    try{
	    $sql = "DROP TABLE IF EXISTS your_table_here";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try{
		$sql = "CREATE TABLE IF NOT EXISTS your_table_here (
			your_fields_here
		)";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	*/


	// Place any templrary sample data here:
// Temporary sample job data

    try{
	    $stuff = "<p>First Job description! With lots and lots of text to fill up lots and lots of space so we can see what happens. We want the main job board to truncate this stuff after so many characters, so that you have to click the link to read more.</p>";
		$sql = "INSERT INTO jobs (title, description, company, contact, contact_email, pays) "
			. "VALUES ('My First Job Title', '" . $stuff . "', 'Name of Sample Business', 'Contact', 'contact@sample.com', '\$500.00')";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try{
	    $sql = "INSERT INTO jobs (title, description, company, contact, contact_email, pays) "
			. "VALUES ('My Second Job Title', '<p>Second Job description!</p>', 'Name of Business 2', 'Contact 2', 'contact_2@sample_2.com', 'maybe')";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	
// samle blog data
    try{
	    $sql = "INSERT INTO blogs (title, content) VALUES ('My First Blog Title', '<p>Blog Content!</p>')";
		$result = $db->query($sql);
		printMessage($result->queryString);
	} catch (PDOException $e) {
		die(printError($e->getMessage()));
	}

	try{
	    $sql = "INSERT INTO blogs (title, content) VALUES ('My Second Blog Title', '<p>More Blog Content!</p>')";
		$result = $db->query($sql);
		printMessage($result->queryString);
	} catch (PDOException $e) {
		die(printError($e->getMessage()));
	}

	// Function to print each message
	function printMessage($message) {
		echo '<div class="panel">' . $message . '</div>';
	}

	// Function to print errors
	function printError($message) {
		echo '<div class="alert-box alert">' . $message . '</div>';
		echo '<h5>Please troubleshoot the error in red before continuing...</h5>';
	}
?>

<div class="panel">
	<a href="/">
		Installation completed successfully. Click here to return to the home page.
	</a>
</div>
</div>
</body>
</html>
