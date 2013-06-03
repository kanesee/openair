
<?php include 'header.php'; ?>
<?php include 'category.php'; ?>
	<div id="right" class="span8">
		<div id="resourceinfo">
			<div id="resourcetitle"><?php echo $resourcetitle ?></div>
			<div id="resourcedescription"><?php echo $resourcedescription ?></div>
		</div>

		<div id="search">
			<form id="searchform" method="GET" action=".">
				<input name='q' type='text' value='Search across all topics'></input>
				<input type='submit' value='search'></input><br>
				<input name='topic' type='checkbox'>Search Within This Topic</input>
				<input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
			</form>
		</div>
		<div id="searchresults">
			<div id="searchresultstitle">Search Results</div>
			<div id="searchcontrols">
				
			</div>
<?php
$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }

if(empty($query)) {
}
else {
	//TODO this is the case where they are searching across ALL categories
	$count = 0;
	$r = mysql_query("SELECT * FROM resource r, resource_category rc WHERE rc.category_id > 0 AND r.id = rc.resource_id");
	while ($row = mysql_fetch_array($r)) {
		echo $row{'name'} . " <br>";
		$count++;
	}
	if($count==0) {
		echo "No results for '".$query."'.";
	}
}
?>
		</div>
	</div>


<?php include 'footer.php'; ?>
