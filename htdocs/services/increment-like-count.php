<?php
include ($_SERVER['DOCUMENT_ROOT'].'/includes/utils.php');
include ($_SERVER['DOCUMENT_ROOT'].'/services/login-required.php');

if( !empty($_GET['resource_id']) ) {

  $resource_id = $_GET['resource_id'];
  $user_id = $_SESSION["user"]->id;


  $insertSql =
    "INSERT INTO resource_likes(resource_id, user_id)"
    ." VALUES($resource_id,$user_id)";

  $result = mysql_query($insertSql);
  
  $updateSql =
    "UPDATE resource SET"
    ." num_likes = num_likes + 1"
    ." WHERE id=$resource_id";

  $result = mysql_query($updateSql);

} else {
  echo "Requires resource_id query parameter.";
}
?>