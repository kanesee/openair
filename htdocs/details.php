<!DOCTYPE html>
<html lang="en">
<head>

  <?php include "header.php"; ?>
  <?php include "admin-required.php"; ?>

<?php
  $r=mysql_query(getResourceSQL($id));

  $row = mysql_fetch_assoc($r);

    $catStmt="
    SELECT c.id, c.name FROM resource_category rc
    LEFT JOIN category c ON rc.category_id = c.id
    WHERE rc.resource_id = ".$row{'id'};
  
    $catRs = mysql_query($catStmt);

    $catPath = '';
    while($catRow = mysql_fetch_array($catRs)) {
      if( !empty($catPath) ) { $catPath .= " | "; }
      $catPath .= '<a href="/?cat='.$catRow{'id'}.'">'.$catRow{'name'}.'</a>';
    }

?>
   
  <title>Open Air</title>
</head>
  
<body>

<?php include 'nav.php'; ?>

  <div id="main" class="container">
    <div class="row">

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
              <div class=added>Added on <?=$row{'approved_date'}?></div>
            </div>
<?php
//   echo "<head><title>".$row{'name'}."</title></head>";
//
//   echo "<h2>".$row{'name'};
//   if(isAdmin()) {
//    echo "<a href='javascript:deleteResource()' ><i class='icon-trash'></i></a>";
//    echo "<a href='edit_resource.php?id=$id'><i class='icon-edit'></i></a>";
//   }
//   echo "</h2>";
//   echo "<div class=resource>";   
//   echo "<div class=about>";
//   echo $row{'description'};
//   echo "</div>";
//   echo "<table class=features>";
//   echo "<tr>";
//   echo "<td><b>Resource type:</b>&nbsp;".$row{'rtname'}."</td>";
//   echo "<td><b>License type:</b>&nbsp;".$row{'ltname'}."</td>";
//   echo "</tr>";
//   echo "<tr>";
//   echo "<td><b>Usage level:</b>&nbsp;".$row{'stname'}."</td>";
//   echo "<td><b>Owner:</b>&nbsp;".$row{'owner'}."</td>";
//   echo "</tr>";
//   echo "<tr>";
//   echo "<td><b>Link:</b>&nbsp;<a href='".$row{'link'}."' target='_blank'>".$row{'link'}."</a></td>";
//   echo "<td><b>Category:</b>&nbsp;".$catpath."</td>";
//   echo "</tr>";
//   if(isAdmin()) {
//     echo "<tr>";
//	 echo "<td><b>Submitter:</b>&nbsp;".$row{'subname'}."</td>";
//	 echo "<td><b>Submitter's email:</b>&nbsp;".$row{'subemail'}."</td>";
//	 echo "</tr>";
//   }
//   echo "</table>";
//   echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
//   echo "</div>";

?>

    </div> <!-- class=row -->
  </div> <!-- class=container -->

<script type="text/javascript">
//  $('select.drilldown').selectHierarchy({ hideOriginal: true });
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

<?php include "footer.php"; ?>

</body>
</html>

<?php ob_flush() ?>
