<?php
include ($_SERVER['DOCUMENT_ROOT'].'/includes/utils.php');
//include ($_SERVER['DOCUMENT_ROOT'].'/services/admin-required.php');

$pending = false;

if (isAdmin()) {
  //TODO now we can delete this category (and redirect to index anyway)
  $id = "";
  if(isset($_GET['id'])) { $id = $_GET['id']; }
  
  if(!empty($id)) {
  	//Find out if this is a pending resource
  	$r = mysql_query("SELECT approved_date FROM resource WHERE id = ".$id);
  	$row = mysql_fetch_array($r);
  	if($row['approved_date'] == ''){
  		$pending = true;
  	}

    //First delete from the resource_category table
	$r = mysql_query("DELETE FROM resource_category WHERE resource_id = ".$id);
	if(!$r) {
		echo("ERROR running UPDATE");
	}

    //Then delete this actual entry
	$r = mysql_query("DELETE FROM resource WHERE id = ".$id);
	if(!$r) {
		echo("ERROR running UPDATE");
	}
  }
}

//Redirect to pending page if resource was pending
if($pending){
	header('location: /pending.php');
} else { //Otherwise redirect to index
	header('Location: /index.php');
}
?>