<!DOCTYPE html>
<html lang="en">
<head>

  <title>Open AIR Home</title>
  <?php include "header.php"; ?>

<?php
if(!isAdmin()) {
  redirect("/not-authorized.php");
}
?>

	<title>Welcome Admin</title>
</head>
  
<body>

<?php include 'nav.php'; ?>


<div id="right" class="span7">
	<h2>Welcome Admin</h2>
	<div class="row-fluid">
		<a class="span6" href="/index.php">Click here for active entries</a><br>
		<a class="span6" href="/pending.php">Click here for pending entries</a>
	</div>
</div>

<?php include "footer.php"; ?>

</body>
</html>

<?php ob_flush() ?>
