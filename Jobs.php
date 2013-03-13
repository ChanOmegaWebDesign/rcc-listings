<?php
	$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'] .'/libraries/connect.php';
	if(isset($_GET['jobNum'])){ // a job was clicked
		$jobNum = stripslashes($_GET['jobNum']); 
		//	$jobNum is used by '/models/oneJob.php' to look up only the job selected
		//	and it's presence triggers the detail view further down the page 
		include_once $_SESSION['LocalRoot'] .'/models/oneJob.php'; // looks up the job
		$telCom = $jobs['telecommute']; // used in edit form
	}else{ // list all jobs
		if($_GET['sort']){ // sorting order selected
			$sort = stripslashes($_GET['sort']);
		}else{ // sorting order NOT selected, default to newest first
			$sort = ""; // "" sets default, newest first
		}
		$jobSorts = array("alpha", "zulu", "old", ""); // "" is default, newest first
		if(!in_array($sort, $jobSorts)) $sort = ""; // unrecognized sorting option, default to newest first
		include_once $_SESSION['LocalRoot'] . '/models/' . $sort . 'Jobs.php';
	}
    if($db){
        $dbStatus = 'The database is connected.';
    } else {
    	$dbStatus = 'The database is NOT connected.';
    }
	
	$AdminAccess = FALSE;
	if((isset($_GET['key']))&&(isset($_GET['jobNum']))){ // admin link clicked
		$title = "Confirm / Edit / Delete Listing";
		if(($_GET['key'] == $jobs[0]['edit_key'])){
			$AdminAccess = TRUE;
			
		}
		echo "<p>AdminAccess == " . var_dump($AdminAccess) . "</p>\n";
		//echo "<pre>\n";
		//var_dump($jobs);
		//echo "</pre>";
	}else{
    	$title = 'Job Listings';
	}
	if($AdminAccess === TRUE){
		$edit = TRUE;
		$formDisplay = TRUE;
	}
	

?>
<!DOCTYPE html>
<?php //include_once $_SESSION['LocalRoot'] .'/partials/head.php'; ?>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" href="css/foundation.min.css">
	<link rel="stylesheet" href="css/default.css">
	<script src="js/foundation/modernizr.foundation.js"></script>
	<style>
	.req{
		color:#FF0000;
		font-family:"Arial Black", Gadget, sans-serif;
		font-weight:900;
		font-size:1.5em;
	}
	</style>
</head>

<body>
    <?php include_once $_SESSION['LocalRoot'] .'/partials/titleblock.php'; ?>
	<div id="menu" class="row">
		<ul class="nav-bar">
			<li class=""><a href="index.php">Home</a></li>
			<li class=""><a href="blog.php">Blog</a></li>
			<li class="active"><a href="Jobs.php">Jobs</a></li>
		</ul>
	</div>
	<div class="row">
		<div class="twelve columns">
			<?php 
				if($jobNum){ // one job is selected for detail view
					//echo "<form action='editJob.php' method='post'>\n";
									if($edit){ // job poster is back to confirm||edit||delete listing, display job as form inputs
										if(isset($_POST['submit'])){ // changes have been submitted
											try{
												$sql = "UPDATE jobs \nSET "
													. "title='" . urlencode($_POST['title']) . "', "
													. "description='" . urlencode($_POST['description']) . "', "
													. "company='" . urlencode($_POST['company']) . "', "
													. "`contact`='" . urlencode($_POST['contact']) . "', "
													. "`location`='" . urlencode($_POST['location']) . "', ";
												if($_POST['telecommute'] != ''){
													$sql .= "telecommute='" . $_POST['telecommute'] . "', ";
												}
												$sql .= "`pays`='" . urlencode($_POST['pays']) . "' "
													. "\nWHERE id=" . $jobNum . " AND edit_key='" . $_GET['key'] . "'";
												$result = $db->query($sql);
												echo "<p>Listing has been Updated.</p>\n";
												include_once $_SESSION['LocalRoot'] .'/models/oneJob.php'; // looks up the updated job
												$formDisplay = FALSE;
												
											} catch (PDOException $e) {
												echo "<p>ERROR - Unable to update listing.</p>\n";
												die($e->getMessage());
											}

										}else{
											echo "<p>Your email address is now confirmed and your listing is published.</p>\n";
										}
									}
										
					foreach ($jobs as $job){ 
						if($edit){ // job poster is back to confirm||edit||delete listing, display job as form inputs
						?>                    	
									
						<div class="row">
							<div class="nine columns panel">
								<?php 
									if($formDisplay == TRUE){
										?>
											<h3><?php echo urldecode($job['title']); ?></h3>
											<div class="content offset-by-one">
												<form action="Jobs.php?<?php echo "key=" . $_GET['key'] . "&jobNum=" . $jobNum ; ?>" method="post">				
													<p><span class="req">*</span>Job Title: <input name="title" type="text" value="<?php echo urldecode($job['title']); ?>"></p>
                    								<p><span class="req">*</span>Contact Name: <input name="contact" type="text" value="<?php echo urldecode($job['contact']); ?>"></p>
                   									<p>Contact Email: <?php echo urldecode($job['contact_email']); ?>"></p>
                    								<p>Company Name: <input name="company" type="text" value="<?php echo urldecode($job['company']); ?>"></p>
													<p><span class="req">*</span>Is this a paid position? If so, how much?: <input name="pays" type="text" value="<?php echo urldecode($job['pays']); ?>"></p>
                    								<p><span class="req">*</span>Location: 
														<input type="text" name="location" value="<?php echo urldecode($job['location']); ?>">
													</p>
                    								<p><span class="req">*</span>Telecommute? 
                    									<input type="radio" name="telecommute" value="yes" <?php echo ($job['telecommute'] == 'yes') ? 'checked' : ''; ?>>Yes &nbsp;
                    									<input type="radio" name="telecommute" value="no" <?php echo ($job['telecommute'] == 'no') ? 'checked' : ''; ?>>No &nbsp;
                    									<input type="radio" name="telecommute" value="maybe" <?php echo ($job['telecommute'] == 'maybe') ? 'checked' : ''; ?>>Maybe
                    								</p>
                   									<p><span class="req">*</span>Job Description: <textarea name="description"><?php echo urldecode($job['description']); ?></textarea></p>
                									<div class="panel">
                    									<a href="Jobs.php"><div class="button">Cancel Changes and Exit</div></a> &nbsp;
                    									<input type="submit" name="submit" value="Save Changes" class="success button" />
													</div>
												</form>
									
										<?php
									}
                                    	echo "<ul>\n" . "<li><strong>Listed:</strong>" 
											. urldecode($job['listed']) 
											. "</li>\n" . "<li><strong>Contact:</strong> " 
											. urldecode($job['contact']) 
											. "</li>\n" . "<li><strong>Email:</strong> " 
											. urldecode($job['contact_email']) 
											. "</li>\n" . "<li><strong>Pay:</strong> " 
											. urldecode($job['pays']) 
											. "<br>\n" . "<li><strong>Working for:</strong> " 
											. urldecode($job['company']) 
											. "</li>\n" . "</ul>\n"
											. "<div class=\"nine columns panel offset-by-one\">"
											. urldecode($job['description']);
									}else{
										?>
						<div class="row">
							<div class="nine columns panel">
								<h3><?php echo urldecode($job['title']); ?></h3>
								<div class="content offset-by-one">
										<?php
										echo "<ul>\n" . "<li><strong>Listed:</strong> " 
											. urldecode($job['listed']) 
											. "</li>\n" . "<li><strong>Contact:</strong> " 
											. urldecode($job['contact']) 
											. "</li>\n" . "<li><strong>Email:</strong> " 
											. urldecode($job['contact_email']) 
											. "</li>\n" . "<li><strong>Pay:</strong> " 
											. urldecode($job['pays']) 
											. "<br>\n" . "<li><strong>Working for:</strong> " 
											. urldecode($job['company']) 
											. "</li>\n" . "</ul>\n"
											. "<div class=\"nine columns panel offset-by-one\">"
											. urldecode($job['description']);
									}
									?>
                           		</div>
                                <br>
                                <div class="three columns offset-by-three">
                                	<h6><a href="Jobs.php"><i>-Back to list-</i></a></h6>
                                </div>
							</div>
						</div>
					</div>
					<?php
					}
					echo "</form>";
				}else{ // no job selected, view full list
					?>
						<div class="row">
            				<ul class="nav-bar nine columns">
								<li class="<?php if((!$sort)||($sort == "")) echo "active"; ?>"><a href="Jobs.php?sort=default">New-Old</a></li>
								<li class="<?php if($sort == "old") echo "active"; ?>"><a href="Jobs.php?sort=old">Old-New</a></li>
								<li class="<?php if($sort == "alpha") echo "active"; ?>"><a href="Jobs.php?sort=alpha">A-Z</a></li>
                                <li class="<?php if($sort == "zulu") echo "active"; ?>"><a href="Jobs.php?sort=zulu">Z-A</a></li>
								<li class=""><a href="post-new-job.php">Post a Job</a></li>
							</ul>
            				<?php include_once $_SESSION['LocalRoot'] .'/partials/sideNote.ssi'; ?>
           				</div>
					<?php foreach ($jobs as $job){
						if($job['email_confirmed']){ ?>
						<div class="row">
							<div class="nine columns panel">
								<h3><?php echo "<a href='Jobs.php?jobNum=" . $job['id'] . "'>" . urldecode($job['title']) . "</a>"; ?></h3>
                                <strong>Listed:</strong> <?php echo $job['listed']; ?>
                                <br>
								<strong>Company Name:</strong> <?php echo ($job['company'] == '') ? "--Withheld--" : urldecode($job['company']); ?>
								<br>
								<strong>Location:</strong> <?php echo urldecode($job['location']) . "\n"; ?>
								<div class="content">
									<?php //echo $job['description']; ?>
								</div>
							</div>
						</div>
						<?php
						}
                    } 
				} 
			?>
		</div>
	</div>
<?php
	if(($edit) && (!$jobs[0]['email_confirmed'])){ // job poster is back to confirm
		$sql = "UPDATE jobs SET email_confirmed=1 WHERE id=" . $jobNum . " AND edit_key='" . $_GET['key'] . "'";
		$result = $db->query($sql);
		var_dump($result);
	}
?>
</body>
</html>

