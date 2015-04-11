<!DOCTYPE html>
<html lang="en">
<head>

  <title>Pending Projects in <?php echo $resourcetitle; ?></title>
  <?php include "header.php"; ?>

<?php
if(!isAdmin()) {
  redirect("/not-authorized.php");
}
?>

</head>
  
<body>

  <?php include 'nav.php'; ?>

  <?php include 'category.php'; ?>

<div id=index class=span7>
<h2>Pending projects for <?php echo $resourcetitle; ?></h2>
<?php
  $MAX_RESULTS = 10;
  $page = 1;
  if (isset($_GET['p'])) { $page=$_GET['p']; }
  $startIdx = ($page-1) * $MAX_RESULTS;
  $totalPages = ceil(countPendingResults($subcatString) / $MAX_RESULTS);

  $r=mysql_query("
    SELECT r.id, r.name, r.link, r.description, 
           r.owner,
           rt.name rtname, lt.name ltname, st.name stname, 
           r.approved_date, c.name cname, c.parent cparent
      FROM resource r, resource_category rc,
           resource_type rt, license_type lt,
           significance_type st, category c
     WHERE r.id=rc.resource_id 
       AND r.approved_date is null
       AND r.resource_type=rt.id
       AND r.license_type=lt.id
       AND r.significance_type=st.id 
       AND rc.category_id=c.id
       AND rc.category_id IN $subcatString
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
    $catparent = $row{'cparent'};
    $catpath = $row{'cname'};
    while ($catparent != 0) {
      $rparent = mysql_query("SELECT * FROM category WHERE id = ".$catparent);
      $rowparent = mysql_fetch_array($rparent);
      $catpath = $rowparent{'name'}."/".$catpath;
      $catparent = $rowparent{'parent'};
    }
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
     echo "<td><b>Usage level:</b>&nbsp;".$row{'stname'}."</td>";
     echo "<td><b>Owner:</b>&nbsp;".$row{'owner'}."</td>";
     echo "</tr>";
     echo "<tr>";
     echo "<td><b>Link:</b>&nbsp;<a href='".$row{'link'}."' target='_blank'>".$row{'link'}."</a></td>";
     echo "<td><b>Category:</b>&nbsp;".$catpath."</td>";
     echo "</tr>";
     echo "</table>";
     echo "<div class=row>";
     echo "<form method=post action=pending-approve.php>";
     echo "<input type=hidden name=id value=".$row{'id'}." />";
     echo "<button type=submit name=approve class='btn span2'>Approve</button>";
     echo '<button type=button onclick="resourceAction('.$row{'id'}.', \'edit\')" name=edit class="btn span2">Edit</button>';
     echo '<button type=button onclick="resourceAction('.$row{'id'}.', \'deny\')" name=deny class="btn span2">Deny</button>';
     echo "</form>";
     echo "</div>";
     echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
     echo "</div>";
   }
   if ($pc < 1) {
     echo "No pending projects.";
   }

if($totalPages>0) {
?>
      <div id="searchcontrols">
        <div class="row-fluid">
          <div class="span3 text-right"><?php if ($page > 1) {echo "<a href=pending.php?p=".($page-1).">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
          <div class="span6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
          <div class="span3"><?php if ($page < $totalPages) {echo "<a href=pending.php?p=".($page+1).">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
        </div>
      </div>
<?php } ?>
</div>
</div>
<script>
  function resourceAction(id, action) {
    if(action == "deny"){
      var r=confirm("Are you sure you want to delete this resource?");
      if (r==true) {
        window.location = window.location.origin+"/delete_resource.php?id="+id;
      }
    }
    else if(action == "edit"){
      window.location = window.location.origin+"/edit_resource.php?id="+id;
    }
  }
</script>
  
<?php include 'footer.php'; ?>
</body>
</html>

<?php ob_flush() ?>
