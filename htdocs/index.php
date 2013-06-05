
<?php include 'header.php'; ?>
<?php include 'category.php'; ?>
	<div id="right" class="span7">
		<div id="resourceinfo">
			<div id="resourcetitle"><?php echo $resourcetitle ?></div>
			<div id="resourcedescription"><?php echo $resourcedescription ?></div>
		</div>

		<div id="search">
			<form id="searchform" class="form-search" method="GET" action=".">
				<input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
				<input type="text" class="input-xxlarge" name='q' placeholder="Search within <?php echo $resourcetitle ?>">
				<button type="submit" class="btn">Search</button>
			</form>
		</div>
		<div id="searchresults">
			<div id="searchresultstitle">Search Results</div>
			<div id="searchcontrols">
				<div class="row-fluid">
					<div class="span3 text-right">&lt; Previous Page</div>
					<div class="span6 text-center">Page 1 of 1</div>
					<div class="span3">Next Page &gt;</div>
				</div>
			</div>
<?php

function getSubCats($catId) {
	$subcats = array();
	$r = mysql_query("SELECT id FROM category WHERE parent=".$catId);
	while ($row = mysql_fetch_array($r)) {
		$subcats[] = $row{'id'};

		$subSubCats = getSubCats($row{'id'});

		foreach ($subSubCats as &$value) {
			$subcats[] = $value;
		}
	}

	$subcats = array_diff($subcats, array(-1));

	return $subcats;
}

$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }


//first get all the categories that we should be searching on
$subcats = getSubCats($cat);
$subcats[] = $cat;
$subcatString = "";
foreach ($subcats as &$value) {
	if(empty($subcatString)) {
		$subcatString.="(";
	}
	else {
		$subcatString.=",";
	}
	$subcatString.=$value;
}
$subcatString.=")";
print_r($subcatString);


if(empty($query)) {
	//TODO this is the case where we get the "top items in this category"

}
else {
	//TODO this is the case where they are searching across ALL categories
	$count = 0;

	$r = mysql_query("SELECT * FROM resource r, resource_category rc WHERE rc.category_id IN ".$subcatString." AND r.id = rc.resource_id AND r.name like '%".$query."%'");
	while ($row = mysql_fetch_array($r)) {
		echo $row{'name'} . " <br>";
		$count++;
	}
	if($count==0) {
		echo "No results for '".$query."'.";
	}
}
?>

			<div id="searchcontrols">
				<div class="row-fluid">
					<div class="span3 text-right">&lt; Previous Page</div>
					<div class="span6 text-center">Page 1 of 1</div>
					<div class="span3">Next Page &gt;</div>
				</div>
			</div>
		</div>
	</div>


<?php include 'footer.php'; ?>
