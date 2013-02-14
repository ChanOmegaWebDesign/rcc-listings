<?php
	$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'].'/libraries/connect.php';

    if($db){
        $dbStatus = 'The database is connected.';
    } else {
    	$dbStatus = 'The database is NOT connected.';
    }

    echo '<h4>'.$dbStatus.'</h4>';

    

// Additional sample job data

    try{
	    $stuff = "<p>Third Job description! With lots and lots of text to fill up lots and lots of space so we can see what happens. We want the main job board to truncate this stuff after so many characters, so that you have to click the link to read more.</p>";
		$sql = "INSERT INTO jobs (title, description, company, contact, contact_email, pays) "
			. "VALUES ('Third Job Title', '" . $stuff . "', 'Business', 'Manager', 'contact@sample.com', '\$500.00')";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try{
	    $sql = "INSERT INTO jobs (title, description, company, contact, contact_email, pays) "
			. "VALUES ('My other Job Title', '<p>Second Job description!</p>', 'That Place', 'This Guy', 'this_guy@sample_2.com', '\$1,500 - \$2,000')";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	
	
	/*// Put your SQL installation code here:

    try{
	    $sql = "DROP TABLE IF EXISTS your_table_name";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try{
		$sql = "CREATE TABLE IF NOT EXISTS your_table_name (
			your_field_data_here
		)";
		$result = $db->query($sql);
		var_dump($result);
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	*/

?>