<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/utils.php'); ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/services/admin-required.php'); ?>


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
