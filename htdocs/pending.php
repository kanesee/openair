<?php include "header.php"; ?>
<?php include 'category.php'; ?>
<h2>Pending projects</h2>
<div class=span8>
<?php
  $r=mysql_query("
    SELECT r.id, r.name, r.description, 
           r.owner,
           rt.name rtname, lt.name ltname,
           r.approved_date
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt
     WHERE r.id=rc.resource_id 
       AND r.approved_date is null
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND rc.category_id=-1
     ");

   $pc=0;
   while ($row = mysql_fetch_array($r)) {
     $pc=$pc+1;
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
     echo "<td><b>Owner:</b>&nbsp;".$row{'owner'}."</td>";
     echo "</tr>";
     echo "</table>";
     echo "<form method=post action=pending-approve.php>";
     echo "<input type=hidden name=id value=".$row{'id'}." />";
     echo "<input type=submit value=Approve />";
     echo "</form>";
     echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
     echo "</div>";
   }
   if ($pc < 1) {
     echo "No pending projects.";
   }

?>
</div>
<?php include 'footer.php'; ?>
