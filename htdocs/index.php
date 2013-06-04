
<?php include 'header.php'; ?>
<?php include 'category.php'; ?>
	<div id="right" class="span7">
		<div id="resourceinfo">
			<div id="resourcetitle"><?php echo $resourcetitle ?></div>
			<div id="resourcedescription"><?php echo $resourcedescription ?></div>
		</div>

		<div id="search">
			<form id="searchform" method="GET" action=".">
				<input name='q' type='text' value='Search across all topics'></input>
				<input type='submit' value='search'></input>
				<?php if(!empty($cat)) { ?>
					<br><input name='topic' type='checkbox'>only within <?php echo $resourcetitle ?></input>
				<?php } ?>
				<input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
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
$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }

if(empty($query)) {
	//TODO this is the case where we get the "top items in this category"

}
else {
	//TODO this is the case where they are searching across ALL categories
	$count = 0;
	$r = mysql_query("SELECT * FROM resource r, resource_category rc WHERE rc.category_id > -2 AND r.id = rc.resource_id AND r.name like '%".$query."%'");
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
