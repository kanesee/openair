<?php
include 'utils.php';

if(!empty($_POST['id']) AND !empty($_POST['dbname']) AND !empty($_POST['link']) AND !empty($_POST['description']) AND isset($_POST['resource']) 
AND isset($_POST['license']) AND isset($_POST['significance']) AND !empty($_POST['submitter']) AND !empty($_POST['email'])){

	$result = mysql_query("SELECT * FROM resource_type WHERE name='$_POST[resource]'");
	$row = mysql_fetch_array($result);
	$resource = $row['id'];
	$result = mysql_query("SELECT * FROM license_type WHERE name='$_POST[license]'");
	$row = mysql_fetch_array($result);
	$license = $row['id'];
	$result = mysql_query("SELECT * FROM significance_type WHERE name='$_POST[significance]'");
	$row = mysql_fetch_array($result);
	$significance = $row['id'];

	$id = $_POST['id'];
	$dbname = addslashes($_POST['dbname']);
	$link = addslashes($_POST['link']);
	$description = addslashes($_POST['description']);
	$submitter = addslashes($_POST['submitter']);
	$email = addslashes($_POST['email']);
	$owner = addslashes($_POST['owner']);

	$result = mysql_query("UPDATE resource SET name='$dbname', link='$link', description='$description', resource_type='$resource', license_type='$license', significance_type='$significance', submitters_name='$submitter', submitters_email='$email', owner='$owner' WHERE id='$id'");

	if($_POST['drilldown'] != '') {
		mysql_query("UPDATE resource_category SET category_id = $_POST[drilldown] where resource_id = '$id'");
	}
		
	$r = mysql_query("SELECT * FROM resource WHERE id ='$id'");
  	$row = mysql_fetch_array($r);
  	if($result && $row['approved_date'] == '')
  		redirect("pending.php");
	else if($result)
		redirect("details.php?id=".$id);
}
if(isset($_POST['id'])){
	redirect("edit_resource.php?id=".$_POST['id']);
}
redirect("index.php");
?>