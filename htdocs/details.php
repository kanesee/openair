<?php include "header.php"; ?>

<?php
  $id=$_GET["id"];

   if(isAdmin()) {
     //TODO do the update statement if drilldown exists in the post
      $drilldown = "";
      $message = "";
      if(isset($_POST['drilldown'])) {
        $drilldown = $_POST['drilldown'];
      }

      if(!empty($drilldown)) {
        $result = mysql_query("UPDATE resource_category SET category_id=$drilldown WHERE resource_id=$id");
        if($result) {
          $message = "<div class='alert alert-success'><strong>Update successful!</strong><button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
        }
        else {
          $message = "<div class='alert alert-failure'><strong>Update failed!</strong><button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
        }
      }
    }
?>

<?php include 'category.php'; ?>
<div id="right" class="span7">
<?php
  $r=mysql_query("
    SELECT r.id, r.name, r.link, r.description, 
           r.owner,
           rt.name rtname, lt.name ltname,
           r.approved_date
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt
     WHERE r.id=rc.resource_id 
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND r.id = $id
     ");

   $row = mysql_fetch_assoc($r);

   echo "<h2><a href='".$row{'link'}."'>".$row{'name'}."</a></h2>";
   echo "<div class=about>";
   echo $row{'description'};
   echo "</div>";
   echo "<table class=features>";
   echo "<tr>";
   echo "<td><b>Resource type:</b>&nbsp;".$row{'rtname'}."</td>";
   echo "<td><b>License type:</b>&nbsp;".$row{'ltname'}."</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td><b>Owner:</b>&nbsp;".$row{'owner'}."</td>";
   echo "</tr>";
   echo "</table>";
   echo "<div class=added>Added on ".$row{'approved_date'}."</div>";

   if(isAdmin()) {
?>
  <div id="changecategoryform">
    <?php echo $message ?>
    <form id='change-category' method="POST" >
      <?php echo buildCategorySelect(false); ?><br>
      <button type="submit" class="btn">Change Category</button>
    </form>
  </div>
<?php
   }

?>
</div>

<script type="text/javascript">
  $('select.drilldown').selectHierarchy({ hideOriginal: true });
</script>
<?php include 'footer.php'; ?>
