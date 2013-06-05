<?php include "header.php"; ?>
<?php
  $id=$_POST['id'];
  $r=mysql_query("
    UPDATE resource 
       SET approved_date = now()
     WHERE id=$id
     ");
  redirect("/pending.php");
?>
<?php include 'footer.php'; ?>
