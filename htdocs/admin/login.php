<?php
include "../header.php";
session_start();
$_SESSION["auth"]=true;
redirect("/index.php");
?>
