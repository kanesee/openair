<!DOCTYPE html>
<html lang="en">
<head>
<?php
include "utils.php";

session_start();

$username = "root";
$password = "bitnami";
$hostname = "localhost"; 

$conn = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
$db = mysql_select_db("openair", $conn) or die("Could not select examples");

if (isAdmin()) {
  echo "<div class=admin-bar>";
  echo "Welcome admin. <a href=admin/logout.php>Logout</a>";
  echo "</div>";
}

$activepage = $_SERVER["REQUEST_URI"];
?>

<!-- Le styles -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/main.css" type="text/css">
<!-- <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->

</head>


<div class="navbar" id='header'>
  <div class="navbar-inner">
    <a class="brand" href="index.php"><img src='assets/img/openailogo.png'/></a>
    <ul class="nav" id="navlist">
		<li <?php if($activepage != '/about.php' && $activepage != '/contact.php' && $activepage != '/faq.php' && $activepage != '/donations.php' && $activepage != '/submit.php') { echo "class='active'"; } ?>><a href="index.php" id="current">Home</a></li>
		<li <?php if($activepage == '/about.php') { echo "class='active'"; } ?>><a href="about.php">About</a></li>
		<li <?php if($activepage == '/contact.php') { echo "class='active'"; } ?>><a href="contact.php">Contact</a></li>
		<li <?php if($activepage == '/faq.php') { echo "class='active'"; } ?>><a href="faq.php">FAQ</a></li>
		<li <?php if($activepage == '/donations.php') { echo "class='active'"; } ?>><a href="donations.php">Donations</a></li>
    </ul>
    <ul class="rightnav" id="navlist">
    	<li class="submit <?php if($activepage == '/submit.php') { echo "active"; } ?>"><a href="submit.php">Submit an Entry</a></li>
  </div>
</div>
