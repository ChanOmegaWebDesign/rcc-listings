<?php
	$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'] .'/libraries/connect.php';
	
	if($db){
        $dbStatus = 'The database is connected.';
    } else {
    	$dbStatus = 'The database is NOT connected.';
    }

    $title = 'Post a New Job Listing';

?>
<!DOCTYPE html>
<?php include_once $_SESSION['LocalRoot'] .'/partials/head.php'; ?>

<link href="css/foundation.min.css" rel="stylesheet" type="text/css">
<body>
	<?php include_once $_SESSION['LocalRoot'] .'/partials/titleblock.php'; ?>
	<div id="menu" class="row">
		<ul class="nav-bar">
			<li class=""><a href="index.php">Home</a></li>
			<li class=""><a href="blog.php">Blog</a></li>
			<li class="active"><a href="Jobs.php">Jobs</a></li>
		</ul>
	</div>
	<div class="twelve columns">
    	<div class="row">
        	
        <?php include_once $_SESSION['LocalRoot'] .'/partials/sideNote.ssi'; ?>
            
        </div>
    	<div class="row">
        	<div class="six columns panel offset-by-three">
            	<?php if(isset($_POST['submit'])){
					$errorCount = 0;
					foreach($_POST as $data){
						$data = stripslashes($data);
						if($data == '') ++$errorCount;
					}
					if($errorCount > 0){
						echo "<div class=\"panel\">\n\t<label class=\"error\">ERROR - Job has not been listed. "
							. $errorCount . "  blank fields detected. "
							. "Please review the form and Re-Submit Listing.</label>\n</div>";
					}
					echo "<div class=\"panel\">\n\t<label class=\"error\">ERROR - Job has not been listed. "
							. "Still under construction.</label>\n</div>";
				} ?>
                <form action="post-new-job.php" method="post">                
                	<p>Job Title: <input name="title" type="text" value="<?php echo $_POST['title']; ?>"></p>
                    <p>Contact Name: <input name="contact" type="text" value="<?php echo $_POST['contact']; ?>"></p>
                    <p>Contact Email: <input name="contact_email" type="email" value="<?php echo $_POST['contact_email']; ?>"></p>
                    <p>Is this a paid position? If so, how much?: <input name="pays" type="text" value="<?php echo $_POST['pays']; ?>"></p>
                    <p>Location: <input type="text" name="location" value="<?php echo $_POST['location']; ?>"></p>
                    <p>Telecommute? <?php if($_POST['telecommute'])$telCom = $_POST['telecommute']; // need to move this ?> 
                    	<input type="radio" name="telecommute" value="yes" <?php echo ($telCom == 'yes') ? 'checked' : ''; ?>>Yes &nbsp;
                    	<input type="radio" name="telecommute" value="no" <?php echo ($telCom === 'no') ? 'checked' : ''; ?>>No &nbsp;
                    	<input type="radio" name="telecommute" value="maybe" <?php echo ($telCom == 'maybe') ? 'checked' : ''; ?>>Maybe
                    </p>
                    <p>Job Description: <textarea name="description"><?php echo $_POST['description']; ?></textarea></p>
                	<div class="panel">
                    	<input type="reset" name="reset" value="Clear Form" class="alert button" /> &nbsp;
                    	<input type="submit" name="submit" value="<?php echo (!$errorCount) ? 'List Job' : 'Re-Submit Listing' ?>" class="success button" />
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</body>
</html>
