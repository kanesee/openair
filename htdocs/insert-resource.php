<?php
include 'utils.php';

if($_POST['dbname'] != '' AND $_POST['link'] != '' AND $_POST['description'] != '' AND $_POST['resource'] != '' 
AND isset($_POST['license']) AND isset($_POST['significance']) AND isset($_POST['submitter']) AND $_POST['email'] != ''
AND ($_POST['drilldown'] != '' OR $_POST['drilldown1'] != '' OR $_POST['drilldown2'] != '' OR $_POST['drilldown3'] != '')){
	// $con = mysqli_connect("ec2-54-243-13-79.compute-1.amazonaws.com","openai","theaiisclosed","openair");
	// if (mysqli_connect_errno($con)){
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }

	$result = mysql_query("SELECT * FROM resource_type WHERE name='$_POST[resource]'");
	$row = mysql_fetch_array($result);
	$resource = $row['id'];
	$result = mysql_query("SELECT * FROM license_type WHERE name='$_POST[license]'");
	$row = mysql_fetch_array($result);
	$license = $row['id'];
	$result = mysql_query("SELECT * FROM significance_type WHERE name='$_POST[significance]'");
	$row = mysql_fetch_array($result);
	$significance = $row['id'];

	$dbname = addslashes($_POST['dbname']);
	$link = addslashes($_POST['link']);
	$description = addslashes($_POST['description']);
	$submitter = addslashes($_POST['submitter']);
	$email = addslashes($_POST['email']);
	$owner = addslashes($_POST['owner']);

	$result = mysql_query("INSERT INTO resource (name, link, description, resource_type, license_type, 
	significance_type, submitters_name, submitters_email, owner) 
	VALUES ('$dbname', '$link', '$description', '$resource', '$license', 
	'$significance', '$submitter', '$email', '$owner')");
	$resource_id = mysql_insert_id();
	
	if($_POST['drilldown'] != '')
		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown])");
	if($_POST['drilldown1'] != '')
		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown1])");
	if($_POST['drilldown2'] != '')
		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown2])");
	if($_POST['drilldown3'] != '')
		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown3])");

	// mysqli_close($con);
	if($result)
		redirect('index.php');
}
redirect('submit.php');
?>