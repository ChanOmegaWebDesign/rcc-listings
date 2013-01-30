<?php

    include_once $_SERVER['DOCUMENT_ROOT'].'/libraries/connect.php';

    if($db){
        $dbStatus = 'The database is connected.';
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

	<div class="row">
		<div class="twelve columns panel">
			<h2><?php echo $title; ?></h2>
			<p><?php echo $dbStatus; ?></p>
		</div>
	</div>

	<!-- TODO: seperate the following menu into partials/menu.php, and include it here. -->
	<div id="menu" class="row">
		<ul class="nav-bar">
			<li class="active"><a href="index.php">Home</a></li>
			<li class=""><a href="blog.php">Blog</a></li>
		</ul>
	</div>

</body>
</html>

