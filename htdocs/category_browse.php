<?php include 'header.php'; ?>
<?php

$MAIN_JSON = '{ 
		"json_data" : {
			"data" : [
				THE_DATA
			]
		},
		"plugins" : [ "themes", "json_data", "ui" ]
	}';

function createData($row) {
	$id = $row{'id'};
	$name = $row{'name'};
	$singleData = str_replace("NAME_REPLACE", $name, '{ "data" : "NAME_REPLACE", "metadata" : { id : ID_REPLACE }, "children" : [ CHILDREN_REPLACE ] }');
	$singleData = str_replace("ID_REPLACE", $id, $singleData);

	$children = "";
	//Now do the query for the children
	$r_sub = mysql_query("SELECT id, name, parent from category where id > 0 and parent=".$id);
	while ($row_sub = mysql_fetch_array($r_sub)) {
		if(!empty($children)) {
			$children .= ",";
		}
		$children .= createData($row_sub);
	}

	return str_replace("CHILDREN_REPLACE", $children, $singleData);
}

$data = "";

$r = mysql_query("SELECT id, name, parent from category where id > 0 and parent=0");
while ($row = mysql_fetch_array($r)) {
	if(!empty($data)) {
		$data .= ",";
	}
	$singleData = createData($row);
	$data .= $singleData;
}

$json = str_replace("THE_DATA", $data, $MAIN_JSON);

echo "<script>var category_json = ".$json.";</script>";
?>

<div id="category">
	<div id='cattitle'>Choose Your Topic</div>
	<div id='catbrowser'></div>
</div>
<div id="main">
</div>

