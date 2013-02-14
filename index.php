<?php
	$_SESSION['LocalRoot'] = $_SERVER['DOCUMENT_ROOT'] . "/rcc-listings-master"; // fix for localhost dev
    include_once $_SESSION['LocalRoot'] .'/libraries/connect.php';

    if($db !== FALSE){
        $dbStatus = 'The database is connected.';
		include_once $_SESSION['LocalRoot'] . "/models/jobsPreview.php"; // finds the last three jobs listed
    } else {
    	$dbStatus = 'The database is NOT connected.';
    }

    $title = 'RCC Job Listings';

?>

<!DOCTYPE html>

<!-- 
	TODO: seperate everything below this comment, and above the <body> tag,
	and put it into partials/head.php, then include it here. 
-->

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


    <?php include_once $_SESSION['LocalRoot'] .'/partials/titleblock.php'; ?>
    <?php include_once $_SESSION['LocalRoot'] .'/partials/menu.php'; ?>
    <div class="row">
    <div class="twelve columns">
    	<div class="three columns offset-by-nine clearing-main-right">
        	<div class="panel">
        
    		<h4>Latest Job Listings</h4>
        	<?php 
			foreach ($jobs as $job){ ?>
				<div class="row">
					
						<h5><a href="Jobs.php"><?php echo $job['title']; ?></a></h5>
						<a href="Jobs.php"><strong>Listed:</strong> <?php echo $job['listed']; ?></a>					
					
				</div>
			<?php } ?> 
            </div>
            <h4>Please Note:</h4>
            	<div class="alert-box">
                	<p>Jobs and projects posted here are for registered RCC Student developers only.</p>
                </div>
        
    	</div>
    </div>
	</div>
	

</body>
</html>

