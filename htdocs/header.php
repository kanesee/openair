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

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://static.jstree.com/v.1.0pre/jquery.jstree.js"></script>
<script src="js/main.js"></script>

<link rel="stylesheet" href="css/main.css" type="text/css">

<div id='header'>
	<img src='img/openailogo.png'/>
	<div id="navcontainer">
		<ul id="navlist">
			<li <?php if($activepage != '/about.php' && $activepage != '/contact.php' && $activepage != '/faq.php' && $activepage != '/donations.php' && $activepage != '/submit.php') { echo "class='active'"; } ?>><a href="index.php" id="current">Home</a></li>
			<li <?php if($activepage == '/about.php') { echo "class='active'"; } ?>><a href="about.php">About</a></li>
			<li <?php if($activepage == '/contact.php') { echo "class='active'"; } ?>><a href="contact.php">Contact</a></li>
			<li <?php if($activepage == '/faq.php') { echo "class='active'"; } ?>><a href="faq.php">FAQ</a></li>
			<li <?php if($activepage == '/donations.php') { echo "class='active'"; } ?>><a href="donations.php">Donations</a></li>
			<li class="hidden"></a></li>
			<li class="submit <?php if($activepage == '/submit.php') { echo "active"; } ?>"><a href="submit.php">Submit an Entry</a></li>
		</ul>
	</div>
</div>


<div id='footer'>
Copyright &copy; 2013, InferLink Corporation.  All rights reserved.
</div>
