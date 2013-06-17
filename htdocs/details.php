<?php include "header.php"; ?>

<?php
  $id=$_GET["id"];

   if(isAdmin()) {
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
           rt.name rtname, lt.name ltname, st.name stname,
           r.approved_date
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt,
           significance_type st
     WHERE r.id=rc.resource_id 
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND r.id = $id
     ");

   $row = mysql_fetch_assoc($r);

   echo "<h2>".$row{'name'};
   if(isAdmin()) {echo "<a href='javascript:deleteResource()' ><i class='icon-trash'></i></a>";}
   echo "</h2>";
   echo "<div class=resource>";   
   echo "<div class=about>";
   echo $row{'description'};
   echo "</div>";
   echo "<table class=features>";
   echo "<tr>";
   echo "<td><b>Resource type:</b>&nbsp;".$row{'rtname'}."</td>";
   echo "<td><b>License type:</b>&nbsp;".$row{'ltname'}."</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td><b>Usage level:</b>&nbsp;".$row{'stname'}."</td>";
   echo "<td><b>Owner:</b>&nbsp;".$row{'owner'}."</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td><b>Link:</b>&nbsp;<a href='".$row{'link'}."' target='_blank'>".$row{'link'}."</a></td>";
   echo "</tr>";
   echo "</table>";
   echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
   echo "</div>";

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

<?php
//ONLY PRINT THIS JAVASCRIPT IF THEY ARE AN ADMIN
if(isAdmin()) {
?>
<script>
  function deleteResource() {
    var r=confirm("Are you sure you want to delete this resource?");
    if (r==true) {
      window.location.href = window.location.origin+"/delete_resource.php?id=<?php echo $id; ?>";
    }
    else{
    }
  }
</script>
<?php } ?>

<?php include 'footer.php'; ?>
