<?php
include 'utils.php';

if($_POST['dbname'] != '' AND $_POST['link'] != '' AND $_POST['description'] != '' AND $_POST['resource'] != '' 
AND isset($_POST['license']) AND isset($_POST['significance']) AND isset($_POST['submitter']) AND $_POST['email'] != ''
AND isset($_POST['drilldown']) AND $_POST['drilldown'] != ''){
	$con = mysqli_connect("ec2-54-243-13-79.compute-1.amazonaws.com","openai","theaiisclosed","openair");
	if (mysqli_connect_errno($con)){
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}

	$result = mysqli_query($con, "SELECT * FROM resource_type WHERE name='$_POST[resource]'");
	$row = mysqli_fetch_array($result);
	$resource = $row['id'];
	$result = mysqli_query($con, "SELECT * FROM license_type WHERE name='$_POST[license]'");
	$row = mysqli_fetch_array($result);
	$license = $row['id'];
	$result = mysqli_query($con, "SELECT * FROM significance_type WHERE name='$_POST[significance]'");
	$row = mysqli_fetch_array($result);
	$significance = $row['id'];

	$dbname = addslashes($_POST['dbname']);
	$link = addslashes($_POST['link']);
	$description = addslashes($_POST['description']);
	$submitter = addslashes($_POST['submitter']);
	$email = addslashes($_POST['email']);
	$owner = addslashes($_POST['owner']);

	$result = mysqli_query($con, "INSERT INTO resource (name, link, description, resource_type, license_type, 
	significance_type, submitters_name, submitters_email, owner) 
	VALUES ('$dbname', '$link', '$description', '$resource', '$license', 
	'$significance', '$submitter', '$email', '$owner')");
	$resource_id = mysqli_insert_id($con);

	mysqli_query($con, "INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown])");

	mysqli_close($con);
	if($result)
		redirect('http://ec2-54-243-13-79.compute-1.amazonaws.com/index.php');
}
redirect('http://ec2-54-243-13-79.compute-1.amazonaws.com/submit.php');
?>