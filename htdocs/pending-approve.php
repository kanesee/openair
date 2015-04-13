<?php include "utils.php"; ?>

<?php
if(!isAdmin()) {
  redirect("/not-authorized.php");
}
?>

<?php
	if(isset($_POST['approve'])){
	  $id=$_POST['id'];
	  $r=mysql_query("
	    UPDATE resource 
	       SET approved_date = now()
	     WHERE id=$id
	     ");
	}
  	redirect("/pending.php");

?>
