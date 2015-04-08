<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
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
<link rel="stylesheet" href="/assets/css/main.css" type="text/css">
<!-- <link href="assets/css/bootstrap-responsive.min.css" rel="stylesheet"> -->

<!-- Le javascript -->
<script src="/assets/js/jquery-1.9.1.min.js"></script>
<!-- <script src="/assets/js/bootstrap.min.js"></script> -->
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.jstree.js"></script>
<script src="/assets/js/jquery.select-hierarchy.js"></script>
<script src="/assets/js/main.js"></script>

</head>

<!--
<div class="navbar" id='header'>
  <div class="navbar-inner row-fluid">
    <div class="span2 offset1"><a class="brand" href="/index.php"><img src='/assets/img/openailogo.png'/></a></div>
    <div class="span5 offset1">
      <ul class="nav" id="navlist">
    		<li <?php if($activepage != '/about.php' && $activepage != '/contact.php' && $activepage != '/faq.php' && $activepage != '/donations.php' && $activepage != '/submit.php') { echo "class='active'"; } ?>><a href="/index.php" id="current">Home</a></li>
    		<li <?php if($activepage == '/about.php') { echo "class='active'"; } ?>><a href="/about.php">About</a></li>
    		<li <?php if($activepage == '/faq.php') { echo "class='active'"; } ?>><a href="/faq.php">FAQ</a></li>
    		<li <?php if($activepage == '/donations.php') { echo "class='active'"; } ?>><a href="/donations.php">Donations</a></li>
      </ul>
    </div>
    <ul class="rightnav span2" id="navlist">
    	<li class="submit <?php if($activepage == '/submit.php') { echo "active"; } ?>"><a href="/submit.php">Submit an Entry</a></li>
    </ul>

  </div>
</div>
-->

    <nav id="nav" class="navbar navbar-default navbar-fixed-top" role="navigation">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src='/assets/img/openairlogo.png'/></a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/">Home</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="faq.php">FAQ</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <?php if( !$_SESSION['user'] ) { ?>
                <a href="#" class="hide-after-auth dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  <span>Sign In</span>
                  <span class="caret"></span>
                </a>
                <?php } else { ?>
                <a href="#" class="show-after-auth dropdown-toggle headerProfile" data-toggle="dropdown" role="button" aria-expanded="false">
                  <img class="profileImg" src="<?= $_SESSION['user']['image'] ?>">
                  <span class="profileName"><?= $_SESSION['user']['name'] ?></span>
                  <span class="caret"></span>
                </a>
                <?php } ?>

              <ul class="inverse-dropdown dropdown-menu" role="menu">
                <?php if( !$_SESSION['user'] ) { ?>
                  <li class="hide-after-auth">
                    <a href="/auth/twitter">
                      <img id="twitterLoginBtn" src="/assets/img-3rd/sign-in-twitter.png">
                    </a>
                  </li>
                  <li class="hide-after-auth">
                    <a href="/auth/facebook">
                      <img id="facebookLoginBtn" src="/assets/img-3rd/sign-in-facebook.png">
                    </a>
                  </li>
                <?php } else { ?>
                  <li class="show-after-auth">
                    <a href="/logout">
                      Log Off
                    </a>
                  </li>
                <?php } ?>
                </ul>              
            </li>
          </ul>

        </div>
      </div>
    </nav>
    <div class="header-spacer"></div>
