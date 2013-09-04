<?php
include "../header.php";
session_start();
session_unset($_SESSION['auth']);
//session_destroy();
//session_write_close();
header("Location: /index.php", TRUE, 301);
?>
