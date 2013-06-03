<?php include "header.php"; ?>
<?php include 'category.php'; ?>
<h2>Pending projects</h2>
<div class=span8>
<?php
  $r=mysql_query("
    SELECT r.id, r.name, r.description, 
           r.submitters_name, r.submitters_org,
           rt.name rtname, lt.name ltname,
           r.approved_date
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt
     WHERE r.id=rc.resource_id 
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND rc.category_id=-1
     ");

   while ($row = mysql_fetch_array($r)) {
     echo "<div class=resource>";
     echo "<div class=title><a href=details.php?id=".$row{'id'}.">";
     echo $row{'name'}."</a></div>";
     echo "<div class=about>";
     echo $row{'description'};
     echo "</div>";
     echo "<table class=features>";
     echo "<tr>";
     echo "<td><b>Resource type:</b>&nbsp;".$row{'rtname'}."</td>";
     echo "<td><b>License type:</b>&nbsp;".$row{'ltname'}."</td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td><b>Author:</b>&nbsp;".$row{'submitters_name'}."</td>";
     echo "<td><b>Organization:</b>&nbsp;".$row{'submitters_org'}."</td>";
     echo "</tr>";
     echo "</table>";
     echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
     echo "</div>";
   }

?>
</div>
<?php include 'footer.php'; ?>
