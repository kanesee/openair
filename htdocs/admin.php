<!DOCTYPE html>
<html lang="en">
<head>

  <title>Open AIR Admin</title>
  <?php include "header.php"; ?>

<?php
if(!isAdmin()) {
  redirect("/not-authorized.php");
}
?>

  </head>
  
<body>

<?php include 'nav.php'; ?>


<div id="" class="container">
  <div class="row">
	<h2>Welcome Admin</h2>
	<div class="row-fluid">
		<a class="span6" href="/index.php">Click here for active entries</a><br>
		<a class="span6" href="/pending.php">Click here for pending entries</a>
	</div>
  </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>

<?php ob_flush() ?>
