<?php
include "../header.php";
include "../category.php";
if(!isset($_SESSION)){session_start();}	
$_SESSION["auth"]=true;
?>

<head>
	<title>Welcome Admin</title>
</head>

<div id="right" class="span7">
	<h2>Welcome Admin</h2>
	<div class="row-fluid">
		<a class="span6" href="/index.php">Click here for active entries</a>
		<a class="span6" href="/pending.php">Click here for pending entries</a>
	</div>
</div>

<?php include "../footer.php"; ?>

