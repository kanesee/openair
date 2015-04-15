<?php
include ($_SERVER['DOCUMENT_ROOT'].'/includes/utils.php');
include ($_SERVER['DOCUMENT_ROOT'].'/services/login-required.php');

if( !empty($_POST['id'])
&&  !empty($_POST['dbname'])
&&  !empty($_POST['link'])
&&  !empty($_POST['description'])
&&  !empty($_POST['categories'])
&&  !empty($_POST['type']) 
&&  !empty($_POST['license'])
) {

//	$result = mysql_query("SELECT * FROM resource_type WHERE name='$_POST[resource]'");
//	$row = mysql_fetch_array($result);
//	$resource = $row['id'];
//	$result = mysql_query("SELECT * FROM license_type WHERE name='$_POST[license]'");
//	$row = mysql_fetch_array($result);
//	$license = $row['id'];
//	$result = mysql_query("SELECT * FROM significance_type WHERE name='$_POST[significance]'");
//	$row = mysql_fetch_array($result);
//	$significance = $row['id'];

	$id = $_POST['id'];
	$dbname = addslashes($_POST['dbname']);
	$prog_lang = addslashes($_POST['prog_lang']);
	$dataformat = addslashes($_POST['dataformat']);
	$type = addslashes($_POST['type']);
	$license = addslashes($_POST['license']);
	$description = addslashes($_POST['description']);
	$link = addslashes($_POST['link']);
	$paperurl = addslashes($_POST['paperurl']);  
	$author = addslashes($_POST['author']);
	$owner = addslashes($_POST['owner']);
    $user_id = $_SESSION["user"]->id;

    $insertSql = "INSERT INTO resource (name, link, description, resource_type, license_type, 
	submitter_id, programming_lang, data_format, paper_url, owner, author) 
	VALUES ('$dbname', '$link', '$description', '$type', '$license', 
	$user_id, '$prog_lang', '$dataformat', '$paperurl', '$owner', '$author')";
  
	$result = mysql_query($insertSql);
	$resource_id = mysql_insert_id();
	
//	if($_POST['drilldown'] != '')
//		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown])");
//	if($_POST['drilldown1'] != '')
//		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown1])");
//	if($_POST['drilldown2'] != '')
//		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown2])");
//	if($_POST['drilldown3'] != '')
//		mysql_query("INSERT INTO resource_category (resource_id, category_id) VALUES ($resource_id, $_POST[drilldown3])");

	// mysqli_close($con);
	if($result)
		redirect('/submit-success.php');
}
//redirect('/submit.php');
?>