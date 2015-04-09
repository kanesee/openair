<?php ob_start() ?>

<?php
include "utils.php";

$activepage = $_SERVER["REQUEST_URI"];

if (isAdmin()) {
  $adminMessage = "Welcome admin. <a href=/pending.php>Pending</a>&nbsp;|&nbsp;<a href=/admin/logout.php>Exit Admin Mode</a>";

  if (!strncmp($activepage, '/pending.php', strlen('/pending.php'))) {
    $adminMessage = "Welcome admin. <a href=/index.php>Active</a>&nbsp;|&nbsp;<a href=/admin/logout.php>Exit Admin Mode</a>";
  }

  echo "<div class=admin-bar>";
  echo $adminMessage;
  echo "</div>";
}
?>

<!-- Le styles -->
<!-- <link href="/assets/css/bootstrap.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="all" href="assets/css/style.css">
<link rel="stylesheet" href="/assets/css/main.css" type="text/css">
<!-- <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->

<!-- Le javascript -->
<script src="/assets/js/jquery-1.9.1.min.js"></script>
<!-- <script src="/assets/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.jstree.js"></script>
<script src="/assets/js/jquery.select-hierarchy.js"></script>
<script src="/assets/js/main.js"></script>

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


<!-- ################ Category related headers ###################-->
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
	$resourcedescription = "This site contains a community-curated directory of open source code and open access data for AI researchers. You can navigate through the directory via the menu on the left or the search box  below. Please help us grow the directory by using the the \"Submit an Entry\" button (see the upper right corner of this page) to send us information about open AI resources (code or data) that are not listed here. ";

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