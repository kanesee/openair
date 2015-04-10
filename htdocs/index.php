<!DOCTYPE html>
<html lang="en">
<head>

  <title>Open AIR Home</title>
  <?php include 'header.php'; ?>

<?php


$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }

$MAX_RESULTS = 10;
$page = 1;
if (isset($_GET['p'])) { $page=$_GET['p']; }
$startIdx = ($page-1) * $MAX_RESULTS;

//$sqlStatmement="
//SELECT r.id, r.name, r.description, 
//       r.owner, r.link,
//       rt.name rtname, lt.name ltname, st.name stname,
//       r.approved_date, c.name cname, c.parent cparent
//  FROM resource r, resource_category rc,
//       resource_type rt, license_type lt,
//       significance_type st, category c
// WHERE rc.category_id IN ".$subcatString."
//   AND r.id=rc.resource_id 
//   AND r.approved_date is not null
//   AND r.resource_type=rt.id
//   AND r.license_type=lt.id
//   AND r.significance_type=st.id
//   AND c.id=rc.category_id
//";
$sqlStatmement="
SELECT DISTINCT r.id, r.name, r.description, 
       r.owner, r.link,
       rt.name rtname, lt.name ltname, st.name stname,
       r.approved_date
  FROM resource r
LEFT JOIN resource_type rt ON r.resource_type=rt.id
LEFT JOIN license_type lt ON r.license_type=lt.id
LEFT JOIN significance_type st ON r.significance_type=st.id
LEFT JOIN resource_category rc ON r.id=rc.resource_id
WHERE r.approved_date is not null
AND rc.category_id IN ".$subcatString."
";

$urlAdd = "";
if(!empty($query)) {
	$sqlStatmement.=" AND (r.name like '%".$query."%' OR r.description like '%".$query."%')";
	$urlAdd = "&q=".$query;
}
$sqlStatmement.=" ORDER BY st.order, r.name LIMIT ".$startIdx.", ".$MAX_RESULTS;

$totalPages = ceil(countResults($subcatString, $query) / $MAX_RESULTS);
?>
  
</head>
  
<body>

<?php include 'nav.php'; ?>

<div class="container">
  <div class="row row-offcanvas row-offcanvas-left">
    
    <?php include 'category.php'; ?>

    <div id="main" class="col-xs-12 col-sm-9">
      <div id="index" class="span7">
        <div id="resourceinfo">
          <div id="resourcetitle">
            <?php echo $resourcetitle ?> <?php if(isAdmin() && $cat>0 ) {echo "<a href='javascript:deleteCategory()' ><i class='icon-trash'></i></a>";}?>
          </div>
          <div id="resourcedescription">
            <?php echo $resourcedescription ?><?php if(isAdmin() && $cat>0 ) {echo "<a href='edit_category.php?cat=$cat'><i class='icon-edit'></i></a>";}?>
          </div>
        </div>

        <div id="search">
          <form id="searchform" class="form-search form-group" method="GET" action=".">
            <div class="input-append">
              <input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
              <input type="text" class="search-query input-xxlarge form-control" name='q' value="<?php echo $query ?>" placeholder="Search within <?php echo $resourcetitle ?>">
              <button type="submit" class="btn">Search</button>
            </div>
          </form>
        </div>

<?php
if($totalPages>0) {
?>
        <div id="searchcontrols">
          <div class="row-fluid">
            <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
            <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
            <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
          </div>
        </div>
<?php
}
?>
  
        <div id='searchresults'>

  
<?php
// ########## print search results
$count = 0;
$rs = mysql_query($sqlStatmement);
while ($row = mysql_fetch_array($rs)) {
	$count++;
  
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

            <div class=resource>
              <div class=title>
                <a href="details.php?id=<?=$row{'id'}?>"><?=$row{'name'}?></a>
              </div>

              <div class=about>
                <?=$row{'description'}?>
              </div>
              <table class=features>
                <tr>
                  <td><b>Resource type:</b>&nbsp;<?=$row{'rtname'}?></td>
                  <td><b>License type:</b>&nbsp;<?=$row{'ltname'}?></td>
                </tr>
                <tr>
                  <td><b>Usage level:</b>&nbsp;<?=$row{'stname'}?></td>
                  <td><b>Owner:</b>&nbsp;<?=$row{'owner'}?></td>
                </tr>
                <tr>
                  <td><b>Link:</b>&nbsp;<a href="<?=$row{'link'}?>" target='_blank'><?=$row{'link'}?></a></td>
                  <td><b>Categories:</b>&nbsp;<?=$catPath?></td>
                </tr>
              </table>
              <div class=added>Added on <?=$row{'approved_date'}?></div>
            </div>
<?php
} // end while
?>

<?php
// ########## If no search results
if($count==0) {
	if(empty($query)) {
		echo "There are no entries in ".$resourcetitle.".";
	}
	else {
	    echo "No results for '".$query."' in the ".$resourcetitle." category.";
	}
}
?>
  
<?php
if($totalPages>0) {
?>
            <div id="searchcontrols">
              <div class="row-fluid">
                <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
                <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
                <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
              </div>
            </div>
<?php
}
?>
      
      
          </div> <!-- id=searchresults -->
      
        </div> <!-- id=index -->
      </div> <!-- id=main -->
    </div> <!-- class=row -->
  </div> <!-- class=container -->
  <?php include 'footer.php'; ?>
  
</body>
</html>

<?php ob_flush() ?>
