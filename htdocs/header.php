<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php
include "utils.php";

$activepage = $_SERVER["REQUEST_URI"];

if (isAdmin()) {
  $adminMessage = "Welcome admin. <a href=/pending.php>Pending</a>&nbsp;|&nbsp;<a href=/admin/logout.php>Exit Admin Mode</a>";

  if (!strncmp($activepage, '/pending.php', strlen('/pending.php'))) {
    $adminMessage = "Welcome admin. <a href=/index.php>Active</a>&nbsp;|&nbsp;<a href=/admin/logout.php>Exit Admin Mode</a>";
  }

  echo "<div class=admin-bar>";
  echo $adminMessage;
  echo "</div>";
}
?>

<!-- Le styles -->
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/main.css" type="text/css">
<!-- <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->

<!-- Le javascript -->
<script src="/assets/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.jstree.js"></script>
<script src="/assets/js/jquery.select-hierarchy.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>

</head>


<div class="navbar" id='header'>
  <div class="navbar-inner row-fluid">
    <div class="span2 offset1"><a class="brand" href="/index.php"><img src='/assets/img/openailogo.png'/></a></div>
    <div class=" span5 offset1"><ul class="nav" id="navlist">
		<li <?php if($activepage != '/about.php' && $activepage != '/contact.php' && $activepage != '/faq.php' && $activepage != '/donations.php' && $activepage != '/submit.php') { echo "class='active'"; } ?>><a href="/index.php" id="current">Home</a></li>
		<li <?php if($activepage == '/about.php') { echo "class='active'"; } ?>><a href="/about.php">About</a></li>
		<li <?php if($activepage == '/faq.php') { echo "class='active'"; } ?>><a href="/faq.php">FAQ</a></li>
		<li <?php if($activepage == '/donations.php') { echo "class='active'"; } ?>><a href="/donations.php">Donations</a></li>
    </ul></div>
    <ul class="rightnav span2" id="navlist">
    	<li class="submit <?php if($activepage == '/submit.php') { echo "active"; } ?>"><a href="/submit.php">Submit an Entry</a></li>
  </div>
</div>
