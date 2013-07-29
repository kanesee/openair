<link rel="stylesheet" type="text/css" media="all" href="assets/css/style.css">
<?php

$cat = "";
if(isset($_GET['cat'])) { $cat = $_GET['cat']; }

//first get all the categories that we should be searching on
if(empty($cat)) {$cat = 0;}
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

$MAIN_JSON = '{ 
		"json_data" : {
			"data" : [
				{ "data" : "Artificial Intelligence", "attr": { "id": "0"}, "metadata" : { id : 0 }, "children" : [THE_DATA] }
			]
		},
		"plugins" : [ "themes", "json_data", "ui", "sort" ],
		"ui" : { "initially_select" : [ OPEN_REPLACE ] },
		"core": { "initially_open" : [ OPEN_REPLACE ] },
		"sort" : function (a, b) {return this.get_text(a) > this.get_text(b) ? 1 : -1; },
		"themes" : {
            "dots" : false
        }
	}';

function createData($row) {
	$id = $row{'id'};
	$name = $row{'name'};
	$singleData = str_replace("NAME_REPLACE", $name, '{ "data" : "NAME_REPLACE", "attr": { "id": "ID_REPLACE"}, "metadata" : { id : ID_REPLACE }, "children" : [ CHILDREN_REPLACE ] }');
	$singleData = str_replace("ID_REPLACE", $id, $singleData);

	$children = "";
	$filter_id = 0;
	$sqlQuery = "SELECT id, name, description, parent from category where parent=".$id;
	if (!isAdmin()) {
		$sqlQuery.= " AND id > 0";
	}
	$sqlQuery.= " ORDER BY id";

	$r_sub = mysql_query($sqlQuery);
	while ($row_sub = mysql_fetch_array($r_sub)) {
		if(!empty($children)) {
			$children .= ",";
		}
		$children .= createData($row_sub);
	}

	return str_replace("CHILDREN_REPLACE", $children, $singleData);
}

$data = "";

$sqlQuery = "SELECT id, name, description, parent from category where parent=0";
if (!isAdmin()) {
	$sqlQuery.= " AND id > 0";
}
$sqlQuery.= " ORDER BY id";
$r = mysql_query($sqlQuery);

while ($row = mysql_fetch_array($r)) {
	if(!empty($data)) {
		$data .= ",";
	}
	$singleData = createData($row);
	$data .= $singleData;
}

$json = str_replace("THE_DATA", $data, $MAIN_JSON);

$resourcetitle = "";
$resourcedescription = "";

if(empty($cat)) {
	$resourcetitle = "Artificial Intelligence";
	$resourcedescription = "Artificial Intelligence is pretty awesome.";

	$opencat = "0";
	if(isset($_GET['id']) && $_GET['id'] != '') {
		$r = mysql_query("SELECT category_id from resource_category where resource_id=".$_GET['id']);
		$row = mysql_fetch_array($r);
		if(!is_null($row)) {
			$opencat = "\"".$row{'category_id'}."\"";
		}
	}

	$json = str_replace("OPEN_REPLACE", $opencat, $json);
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
if(isset($_GET['cat']) && basename($_SERVER['PHP_SELF']) != "edit_category.php" && basename($_SERVER['PHP_SELF']) != "pending.php")
	echo "<head><title>$resourcetitle</title></head>";
?>
<div id="main" class="row-fluid">
	<div class="span12">
		<div id="category" class="span3 offset1">
			<div id='cattitle'>Choose Your Topic <?php if(isAdmin()) {echo "<a href='add_category.php'><i class='icon-plus-sign'></i></a>";}?></div>
			<div id='catbrowser'></div>
		</div>