<?php
	$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'] .'/libraries/connect.php';
	if($_GET['jobNum']){ // a job was clicked
		$jobNum = stripslashes($_GET['jobNum']); 
		//	$jobNum is used by '/models/oneJob.php' to look up only the job selected
		//	and it's presence triggers the detail view further down the page 
		include_once $_SESSION['LocalRoot'] .'/models/oneJob.php'; // looks up the job
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

    $title = 'Jobs';

?>
<!DOCTYPE html>
<?php include_once $_SESSION['LocalRoot'] .'/partials/head.php'; ?>

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
					foreach ($jobs as $job){ ?>                    	
                    	<div class="row">
							<div class="nine columns panel">
								<h3><?php echo $job['title']; ?></h3>
								<div class="content">
									<?php
                                    	echo "<ul>\n"
											. "<li><strong>Listed:</strong> " . $job['listed'] . "</li>\n"
											. "<li><strong>Contact:</strong> " . $job['contact'] . "</li>\n"
											. "<li><strong>Email:</strong> " . $job['contact_email'] . "</li>\n"
											. "<li><strong>Pay:</strong> " . $job['pays'] . "<br>\n"
											. "<li><strong>Working for:</strong> " . $job['company'] . "</li>\n"
											. "</ul>\n";
									?>
                                    <div class="nine columns panel offset-by-one">
                                    	<?php
											echo $job['description'];
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
					<?php foreach ($jobs as $job){ ?>
						<div class="row">
							<div class="nine columns panel">
								<h3><?php echo "<a href='jobs.php?jobNum=" . $job['id'] . "'>" . $job['title'] . "</a>"; ?></h3>
                                <strong>Listed:</strong> <?php echo $job['listed']; ?>
                                <br>
								<div class="content">
									<?php echo $job['description']; ?>
								</div>
							</div>
						</div>
						<?php
                    } 
				} 
			?>
		</div>
	</div>

</body>
</html>

