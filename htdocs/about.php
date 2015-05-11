<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>

  <style>
    .arrow_box {
      margin-bottom: 70px;
    }

    .arrow_box:after {
      border-top-color: #8D8F8F;
    }    
  </style>
  <title>About</title>
</head>
  
<body>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>

  <div id="about-heading" class="hero-unit">
    <div class="row">
      <div id="about-desc">
        <p>This directory is a community resource that seeks to provide access to all available open source artificial intelligence related software and data. This site was initially developed by InferLink Corporation and we are soliciting contributions by the AI community.  For more information, please feel free to contact us at ...</p>
        <p>Please also consider making a donation to help our cause:<br>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="padding: 5px;"><input type="hidden" name="cmd" value="_s-xclick">   <input type="hidden" name="hosted_button_id" value="9W2ECGFRDNLGW"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> </form>        </p>
      </div>
    </div>
  </div> <!-- end id=heading -->
  <div class="arrow_box"></div>
  
  
  
  
  <div id="about-content" class="container">
    <!-- ############### Sponsors ############### -->
    <div class="row">
      <div id="sponsor-heading" class="col-xs-12 col-sm-12">
        <h2>Sponsors</h2>
      </div>
    </div>
    <div id="sponsors" class="row">
      <div class="col-xs-12 col-sm-3">
        <a href="http://www.aaai.org/" target="_blank">
<!--          Association for the Advancement of Artificial Intelligence-->
          <br><img src="http://www.aaai.org/Graphics/Logos/aaai-logo.png">
        </a>
      </div>
      <div class="col-xs-12 col-sm-6">
        <a href="http://www.jair.org/" target="_blank">
<!--          Journal of Artificial Intelligence Research-->
          <br><img src="/assets/img-3rd/jair-logo.jpg">
        </a>
      </div>
      <div class="col-xs-12 col-sm-3">
        <a href="http://www.inferlink.com/" target="_blank">
<!--          InferLink-->
          <br><img src="http://static1.squarespace.com/static/53cede1ae4b0de9f6e919b11/t/53cee0eae4b007d752955c2d/1422520719771/?format=1500w">
          
        </a>
      </div>
    </div>
    
    <!-- ############### Editors ############### -->
	<div class="row">
      <div class="col-xs-6">
        <h3>Editors</h3>
        <p>Much of the content on Open AIR has been contributed or managed by our editors below. If you are interested in participating in the editorial work at Open AIR, please contact us at <img src="/assets/img/openai-email.png" width="175">.</p>
        <div class="row">
<?php
        $editorRs = mysql_query("
          SELECT image_url, profile_url FROM user u
          WHERE privilege != 'xadmin' and image_url != '/assets/img-3rd/unknownuser.png'");

        while($editorRow = mysql_fetch_array($editorRs)) {
?>
          <div class="col-xs-1">
            <a href="<?=$editorRow{'profile_url'}?>">
              <img class="editor" src="<?=$editorRow{'image_url'}?>">
            </a>
          </div>
<?php
        }
?>
        </div>
      </div>
      <div class="col-xs-6">
        <h3>Chair</h3>
        <ul>
          <li>Steve Minton</li>
          <li>Isaac Cowhey</li>
        </ul>
      </div>
	</div>
    
    
  </div>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>

</body>
</html>

<?php ob_flush() ?>
