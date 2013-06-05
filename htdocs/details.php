<?php include "header.php"; ?>
<?php include 'category.php'; ?>
<div class=span8>
<?php
  $id=$_GET["id"];
  $r=mysql_query("
    SELECT r.id, r.name, r.description, 
           r.owner,
           rt.name rtname, lt.name ltname,
           r.approved_date
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt
     WHERE r.id=rc.resource_id 
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND rc.category_id=-1
       AND r.id = $id
     ");

   $row = mysql_fetch_assoc($r);

   echo "<h2>".$row{'name'}."</h2>";
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
?>
</div>
<?php include 'footer.php'; ?>
