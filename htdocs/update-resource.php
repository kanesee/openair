<?php
include 'utils.php';
include 'admin-required.php';

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

    $updateSql =
      "UPDATE resource SET"
      ." name='$dbname'"
      .", programming_lang='$prog_lang'"
      .", data_format='$dataformat'"
      .", resource_type='$type'"
      .", license_type='$license'"
      .", description='$description'"
      .", link='$link'"
      .", paper_url='$paperurl'"
      .", author='$author'"
      .", owner='$owner'"
      ." WHERE id=$id";

	$result = mysql_query($updateSql);
  
  
    // Manage resource categories
    mysql_query("DELETE FROM resource_category WHERE resource_id = $id");
  
  	$categories = addslashes($_POST['categories']);  
    $catPieces = explode(',', $categories);
    foreach($catPieces as $cat) {
      mysql_query("INSERT INTO resource_category(resource_id,category_id)"
                 ." VALUES($id,'$cat')");
    }

//	if($_POST['drilldown'] != '') {
//		mysql_query("UPDATE resource_category SET category_id = $_POST[drilldown] where resource_id = '$id'");
//	}
//		
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