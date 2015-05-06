<?php ob_start() ?>

<?php
include ($_SERVER['DOCUMENT_ROOT']."/includes/utils.php");

$activepage = $_SERVER["REQUEST_URI"];

//if (isAdmin()) {
//  $adminMessage = "Welcome admin. <a href=/pending.php>Pending</a>&nbsp;|&nbsp;<a href=/admin/logout.php>Exit Admin Mode</a>";
//
//  if (!strncmp($activepage, '/pending.php', strlen('/pending.php'))) {
//    $adminMessage = "Welcome admin. <a href=/index.php>Active</a>&nbsp;|&nbsp;<a href=/admin/logout.php>Exit Admin Mode</a>";
//  }
//
//  echo "<div class=admin-bar>";
//  echo $adminMessage;
//  echo "</div>";
//}
?>

<!-- Le styles -->
 <link href="/assets/css/bootstrap-3.3.4.min.css" rel="stylesheet"> 
<!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
<link rel="stylesheet" type="text/css" media="all" href="/assets/css/style.css">
<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
<!-- <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->

<!-- Le javascript -->
<script src="/assets/js/jquery-1.9.1.min.js"></script>
 <script src="/assets/js/bootstrap-3.3.4.min.js"></script> 
<!--<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>-->
<script src="/assets/js/main.js"></script>

<!-- ################ Topic related headers ###################-->
<link rel="stylesheet" type="text/css" href="/assets/css/topic-tree.css">

<!--<script src="/assets/js/jquery.jstree-1.0.js"></script>-->
<!--<script src="/assets/js/jquery.select-hierarchy.js"></script>-->
<script src="/assets/js/jquery.twbsPagination.min.js"></script>
<script src="/assets/js/topic-tree.js"></script>

<?php

$id = "";
if(isset($_GET['id'])) { $id = $_GET['id']; }

$cat = "";
if(isset($_GET['cat'])) { $cat = $_GET['cat']; }

echo "<script>var cat = \"".$cat."\";</script>";

$subcatString = buildSubCatSqlCondition($cat);

?>
