<?php include "header.php"; ?>
<?php include 'category.php'; ?>

<?php
function countResults() {
  $r=mysql_query("
    SELECT count(*)
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt
     WHERE r.id=rc.resource_id 
       AND r.approved_date is null
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
     ");
  $row = mysql_fetch_row($r);
  return $row[0];
}

?>

<?php if (isAdmin()) { ?>
<div id=index class=span7>
<h2>Pending projects</h2>
<?php
  $MAX_RESULTS = 10;
  $page = 1;
  if (isset($_GET['p'])) { $page=$_GET['p']; }
  $startIdx = ($page-1) * $MAX_RESULTS;
  $totalPages = floor(countResults() / $MAX_RESULTS);

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
     LIMIT $startIdx, $MAX_RESULTS
     ");


if($totalPages>0) {
?>
      <div id="searchcontrols">
        <div class="row-fluid">
          <div class="span3 text-right"><?php if ($page > 1) {echo "<a href=pending.php?p=".($page-1).">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
          <div class="span6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
          <div class="span3"><?php if ($page < $totalPages) {echo "<a href=pending.php?p=".($page+1).">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
        </div>
      </div>
<?php
}
   echo "<div id=pendingresults>";

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
     echo "<button type=submit class=btn>Approve</button>";
     echo "</form>";
     echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
     echo "</div>";
   }
   if ($pc < 1) {
     echo "No pending projects.";
   }

?>
</div>
</div>
<?php } ?>
<?php include 'footer.php'; ?>
