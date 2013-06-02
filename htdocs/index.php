<?php include 'header.php'; ?>
<?php

$cat = "";
if(isset($_GET['cat'])) { $cat = $_GET['cat']; }

$MAIN_JSON = '{ 
		"json_data" : {
			"data" : [
				THE_DATA
			]
		},
		"plugins" : [ "themes", "json_data", "ui" ],
		"ui" : { "initially_select" : [ OPEN_REPLACE ] }
	}';

function createData($row) {
	$id = $row{'id'};
	$name = $row{'name'};
	$singleData = str_replace("NAME_REPLACE", $name, '{ "data" : "NAME_REPLACE", "attr": { "id": "ID_REPLACE"}, "metadata" : { id : ID_REPLACE }, "children" : [ CHILDREN_REPLACE ] }');
	$singleData = str_replace("ID_REPLACE", $id, $singleData);

	$children = "";
	//Now do the query for the children
	$r_sub = mysql_query("SELECT id, name, description, parent from category where id > 0 and parent=".$id);
	while ($row_sub = mysql_fetch_array($r_sub)) {
		if(!empty($children)) {
			$children .= ",";
		}
		$children .= createData($row_sub);
	}

	return str_replace("CHILDREN_REPLACE", $children, $singleData);
}

$data = "";

$r = mysql_query("SELECT id, name, description, parent from category where id > 0 and parent=0");
while ($row = mysql_fetch_array($r)) {
	if(!empty($data)) {
		$data .= ",";
	}
	$singleData = createData($row);
	$data .= $singleData;
}

$json = str_replace("THE_DATA", $data, $MAIN_JSON);

//TODO we need to switch if the category exists or not...
$resourcetitle = "";
$resourcedescription = "";

if(empty($cat)) {
	$resourcetitle = "Main Page";
	$resourcedescription = "This is the main page. Not quite sure what to put in here just yet.";
	$json = str_replace("OPEN_REPLACE", "", $json);
}
else {
	$r = mysql_query("SELECT id, name, description, parent from category where id=".$cat);
	$row = mysql_fetch_array($r);
	if(is_null($row)) {
		$resourcedescription = "The category does not exist.";
	}
	else {
		$resourcetitle = $row{'name'};
		$resourcedescription = $row{'description'};
	}

	$json = str_replace("OPEN_REPLACE", "\"".$cat."\"", $json);
}

echo "<script>var category_json = ".$json.";</script>";
echo "<script>var cat = \"".$cat."\";</script>";
?>

<div id="main">
	<div id="category">
		<div id='cattitle'>Choose Your Topic</div>
		<div id='catbrowser'></div>
	</div>

	<div id="right">
		<div id="resourceinfo">
			<div id="resourcetitle"><?php echo $resourcetitle ?></div>
			<div id="resourcedescription"><?php echo $resourcedescription ?></div>
		</div>

		<div id="search">
			<form id="searchform" method="GET" action=".">
				<input name='q' type='text' value='Search across all topics'></input>
				<input type='submit' value='search'></input><br>
				<input name='topic' type='checkbox'>Search Within This Topic</input>
			</form>
		</div>
		<div id="searchresults">
			<div id="searchresultstitle">Search Results</div>
<?php
$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }
	echo $query;
?>
		</div>
	</div>
</div>