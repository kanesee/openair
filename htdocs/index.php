<?php include 'header.php'; ?>
<?php include 'category.php'; ?>

<head>
	<title>Open AIR Home</title>
</head>

<?php

function countResults($subcatString, $query) {
	$sqlStatmement = "SELECT count(*)
	  FROM resource r, resource_category rc,
	       resource_type rt, license_type lt,
	       significance_type st
	 WHERE rc.category_id IN ".$subcatString."
	   AND r.id=rc.resource_id 
	   AND r.approved_date is not null
	   AND r.resource_type=rt.id
	   AND r.license_type=lt.id
	   AND r.significance_type=st.id
	";
	if(!empty($query)) {
		$sqlStatmement.=" AND r.name like '%".$query."%'";
	}

	$r = mysql_query($sqlStatmement);
	$row = mysql_fetch_row($r);
	return $row[0];
}

$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }

$MAX_RESULTS = 10;
$page = 1;
if (isset($_GET['p'])) { $page=$_GET['p']; }
$startIdx = ($page-1) * $MAX_RESULTS;

?>

	<div id="index" class="span7">
		<div id="resourceinfo">
			<div id="resourcetitle"><?php echo $resourcetitle ?> <?php if(isAdmin() && $cat>0 ) {echo "<a href='javascript:deleteCategory()' ><i class='icon-trash'></i></a>";}?></div>
			<div id="resourcedescription"><?php echo $resourcedescription ?><?php if(isAdmin() && $cat>0 ) {echo "<a href='edit_category.php?cat=$cat'><i class='icon-edit'></i></a>";}?></div>
		</div>

		<div id="search">
			<form id="searchform" class="form-search" method="GET" action=".">
				<div class="input-append">
					<input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
					<input type="text" class="search-query input-xxlarge" name='q' value="<?php echo $query ?>" placeholder="Search within <?php echo $resourcetitle ?>">
					<button type="submit" class="btn">Search</button>
				</div>
			</form>
		</div>
<?php

$sqlStatmement="
SELECT r.id, r.name, r.description, 
       r.owner, r.link,
       rt.name rtname, lt.name ltname, st.name stname,
       r.approved_date
  FROM resource r, resource_category rc,
       resource_type rt, license_type lt,
       significance_type st
 WHERE rc.category_id IN ".$subcatString."
   AND r.id=rc.resource_id 
   AND r.approved_date is not null
   AND r.resource_type=rt.id
   AND r.license_type=lt.id
   AND r.significance_type=st.id
";

$urlAdd = "";
if(!empty($query)) {
	$sqlStatmement.=" AND r.name like '%".$query."%'";
	$urlAdd = "&q=".$query;
}
$sqlStatmement.=" ORDER BY st.order, r.name LIMIT ".$startIdx.", ".$MAX_RESULTS;

$totalPages = floor(countResults($subcatString, $query) / $MAX_RESULTS);
if($totalPages>0) {
?>
			<div id="searchcontrols">
				<div class="row-fluid">
					<div class="span3 text-right"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
					<div class="span6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
					<div class="span3"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
				</div>
			</div>
<?php
}
echo "<div id='searchresults'>";
$count = 0;
$r = mysql_query($sqlStatmement);
while ($row = mysql_fetch_array($r)) {
	$count++;
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
	echo "</tr>";
	echo "</table>";
	echo "<div class=added>Added on ".$row{'approved_date'}."</div>";
	echo "</div>";
}
if($count==0) {
	if(empty($query)) {
		echo "There are no entries in ".$resourcetitle.".";
	}
	else {
	    echo "No results for '".$query."' in the ".$resourcetitle." category.";
	}
}
?>
		</div>
	</div>



<?php
//ONLY PRINT THIS JAVASCRIPT IF THEY ARE AN ADMIN
if(isAdmin()) {
?>
<script>
	function deleteCategory() {
		var r=confirm("Are you sure you want to delete <?php echo $resourcetitle; ?> and all of the child categories beneath it?");
		if (r==true) {
			window.location.href = window.location.origin+"/delete_category.php?cat="+cat;
		}
		else{
		}
	}
</script>

<?php
}
?>

<?php include 'footer.php'; ?>
