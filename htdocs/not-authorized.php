<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'header.php'; ?>
  <title>Unauthorized</title>

</head>
  
<body>

  <?php include 'nav.php'; ?>

  <?php include 'category.php'; ?>

<div id="index" class="span7">
	<div id="resourceinfo">
		<div id="resourcetitle">Sorry</div>
		<div id="resourcedescription">
          You are not authorized to view that page.<br>
          Please sign in with an account that is authorized to view that page.
		</div>
	</div>

<?php include 'footer.php'; ?>

</body>
</html>

<?php ob_flush() ?>
