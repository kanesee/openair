<?php include "header.php"; ?>
<h2>Pending projects</h2>
<?php
  $r=mysql_query("
    SELECT r.id, r.name, r.description, r.submitters_name,
           rt.name rtname, lt.name ltname
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt
     WHERE r.id=rc.resource_id 
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND rc.category_id=-1
     ");

   while ($row = mysql_fetch_array($r)) {
     echo "<div class=resource>";
     echo "<div class=title>".$row{'name'}."</div>";
     echo "<div class=about>";
     echo "<b>About:</b>".$row{'description'};
     echo "</div>";
     echo "<table class=features>";
     echo "<tr>";
     echo "<td><b>Resource type:</b>".$row{'rtname'}."</td>";
     echo "<td><b>License type:</b>".$row{'ltname'}."</td>";
     echo "</table>";
     echo "</div>";
   }

?>
