<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
  <?php include ($_SERVER['DOCUMENT_ROOT'].'/services/admin-required.php'); ?>

  <script>
    var category_json = <?=buildJSTreeJson($cat, true, 'pending_count')?>;
  </script>

<?php
$MAX_RESULTS = 10;
$page = 1;
if (isset($_GET['p'])) { $page=$_GET['p']; }
$startIdx = ($page-1) * $MAX_RESULTS;
$totalPages = ceil(countPendingResults($subcatString) / $MAX_RESULTS);

$catTitle = getCategoryTitle($cat);

$urlAdd = "";
if(!empty($cat)) {
  $urlAdd = "&cat=".$cat;
}

?>
  
  <title>Pending Projects in <?= $catTitle ?></title>

</head>
  
<body>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>


<div class="container">
  <div class="row row-offcanvas row-offcanvas-left">

    <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/category.php'); ?>

    <div id="main" class="col-xs-12 col-sm-9">
      <h2>Pending projects for <?= $catTitle ?></h2>

<?php
if($totalPages>0) {
?>
      <div class="searchcontrols">
        <div class="row-fluid">
          <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=pending.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
          <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
          <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=pending.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
        </div>
      </div>
<?php
}
?>
   <div id="pendingresults">

<?php
  $sqlStatement = getPendingResourceSQL($subcatString, $startIdx, $MAX_RESULTS);
  $rs=mysql_query($sqlStatement);
  $pc=0;
  while ($row = mysql_fetch_array($rs)) {
    $pc=$pc+1;

    $catStmt="
    SELECT c.id, c.name FROM resource_category rc
    LEFT JOIN category c ON rc.category_id = c.id
    WHERE rc.resource_id = ".$row{'id'};

    $catRs = mysql_query($catStmt);

    $catPath = '';
    while($catRow = mysql_fetch_array($catRs)) {
      if( !empty($catPath) ) { $catPath .= " | "; }
      $catPath .= '<a href="?cat='.$catRow{'id'}.'">'.$catRow{'name'}.'</a>';
    }

?>
            <div class=resource>
              <div class=title>
                <a href="details.php?id=<?=$row{'id'}?>"><?=$row{'name'}?></a>
              </div>
              <div class="link">
                <b>Project</b>: </b><a href="<?=$row{'link'}?>" target='_blank'><?=$row{'link'}?></a>
              </div>
              <div class="paper-link">
                <b>Paper</b>: <a href="<?=$row{'paper_url'}?>" target='_blank'><?=$row{'paper_url'}?></a>
              </div>
              
              <div class="">
                <pre class="about"><?=htmlspecialchars($row{'description'})?></pre>
              </div>
              <table class=features>
                <tr>
                  <td><b>Resource type:</b>&nbsp;<?=$row{'resource_type'}?></td>
                  <td><b>License type:</b>&nbsp;<?=$row{'license_type'}?></td>
                </tr>
                <tr>
                  <td><b>Categories:</b>&nbsp;<?=$catPath?></td>
                  <td><b>Owner:</b>&nbsp;<?=$row{'owner'}?></td>
                </tr>
                <tr>
                  <td><b>Author:</b>&nbsp;<?=$row{'author'}?></td>
                </tr>
              </table>
<!--              <div class=added>Added on <?=$row{'approved_date'}?></div>-->
              <form method=post action=./services/pending-approve.php>
                <input type=hidden name=id value="<?= $row{'id'} ?>" />
                <button type=submit name=approve class='btn span2'>Approve</button>
                <button type=button onclick="resourceAction('<?=$row{'id'}?>', 'edit')" name=edit class="btn span2">Edit</button>
                <button type=button onclick="resourceAction('<?=$row{'id'}?>', 'deny')" name=deny class="btn span2">Deny</button>
              </form>
            </div> <!-- class=resource -->
<?php
   } // end while
?>

<?php
// ########## If no pending resources
 if ($pc < 1) {
   echo "No pending projects.";
 }
?>
      
<?php
if($totalPages>0) {
?>
      <div class="searchcontrols">
        <div class="row-fluid">
          <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=pending.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
          <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
          <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=pending.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
        </div>
      </div>
<?php
}
?>
     
      </div> <!-- id=pendingresults -->
    </div> <!-- id=main -->
  </div> <!-- class=row -->
</div> <!-- class=container -->
  
<script>
  function resourceAction(id, action) {
    if(action == "deny"){
      var r=confirm("Are you sure you want to delete this resource?");
      if (r==true) {
        window.location = window.location.origin+"./services/delete_resource.php?id="+id;
      }
    }
    else if(action == "edit"){
      window.location = window.location.origin+"/edit_resource.php?id="+id;
    }
  }
</script>
  
<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
</body>
</html>

<?php ob_flush() ?>
