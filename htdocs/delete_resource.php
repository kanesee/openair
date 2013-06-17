<?php
include "utils.php";

if (isAdmin()) {
  //TODO now we can delete this category (and redirect to index anyway)
  $id = "";
  if(isset($_GET['id'])) { $id = $_GET['id']; }
  
  if(!empty($id)) {
    //First delete from the resource_category table
	$r = mysql_query("DELETE FROM resource_category WHERE resource_id = ".$id);
	if(!$result) {
		echo("ERROR running UPDATE");
	}

    //Then delete this actual entry
	$r = mysql_query("DELETE FROM resource WHERE id = ".$id);
	if(!$result) {
		echo("ERROR running UPDATE");
	}
	
  }
}

// No matter what redirect at the end
header('Location: index.php');
?>