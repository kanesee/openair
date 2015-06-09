<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>

  <style>
    body {
/*
      background-image: url('http://www.adweek.com/files/imagecache/node-blog/blogs/istock-unfinished-business-hed-2015.jpg');
      background-repeat: no-repeat;
      background-size: contain;
*/
    }

    .section-odd {
      background-color: white;
    }

    .section-even {
      background-color: rgba(0, 0, 0, 0.63);
    }
    
    #about-content .row {
      margin-left: 0;
      margin-right: 0;
    }
  </style>
  <title>About</title>
</head>
  
<body>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>

  
  
<div id="about-content" class="">
  <!-- ############### About Us ############### -->
  <div id="about-us" class="about-section section-odd">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="section-header">About Us</h2>
      </div>
      <div class="col-xs-12 about-desc">
        <p>Open AI Resources is a directory of open source software and open access data for the AI research community. The site was initially developed by the <a href="http://allenai.org/">Allen Institute for Artificial Intelligence</a> and <a href="http://www.inferlink.com">InferLink Corporation</a>, and is currently managed by <a href="https://www.jair.org/aiaf.html">AI Access Foundation</a>. Please consider helping us out by submitting a new resource, becoming an editor, or making a financial contribution.</p>
      </div>
      <div class="about-anchor-link col-xs-12 col-sm-4"><a href="#editor">Our Editors</a></div>
      <div class="about-anchor-link col-xs-12 col-sm-4"><a href="#advisory-board">Our Advisory Board</a></div>
      <div class="about-anchor-link col-xs-12 col-sm-4"><a href="#sponsors">Our Sponsors</a> </div>
    </div>
    <div class="section-footer row">
      <div class="col-xs-12">
      <!-- anchor placed here so Editor section shows up just below nav -->
      <a name="editor"> </a>
      </div>
    </div>
  </div>

  <!-- ############### Editors ############### -->
  <div class="about-section section-even">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="section-header">Editors</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12 about-desc">
        <p>The content on Open AI Research is curated and reviewed by our  editor, all of whom contribute their time on a volunteer basis.  If you are interested in becoming and editor of open AI  and have experience in the field, contact us at<img src="/assets/img/openai-email.png" width="175"></p>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="section-subheader">Managing Editor</div>
        <div class="row">
          <div class="list-item col-xs-12">
            Isaac Cowhey
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="section-subheader">Editors</div>
        <div class="row">
          <div class="list-item col-xs-6">
            Alfred Krzywicki
          </div>
          <div class="list-item col-xs-6">
            Bianca Pereira
          </div>
        </div>
        <div class="row">
          <div class="list-item col-xs-6">
            Jonathan May
          </div>
          <div class="list-item col-xs-6">
            David Rajaratnam
          </div>
        </div>
      </div>
    </div>
    <div class="section-footer row">
      <div class="col-xs-12">
      <!-- anchor placed here so Advisory Board section shows up just below nav -->
      <a name="advisory-board"> </a>
      </div>
    </div>
  </div>

  <!-- ############### Advisory Board ############### -->
  <div class="about-section section-odd">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="section-header">Advisory Board</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="section-subheader">Co-Chairs</div>
        <div class="row">
          <div class="list-item col-xs-6">Oren Etzioni</div>
          <div class="list-item col-xs-6">Steven Minton</div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="section-subheader">Advisors</div>
        <div class="row">
          <div class="list-item col-xs-6">Wolfram Burgard</div>
          <div class="list-item col-xs-6">Eric Horvitz</div>
        </div>
        <div class="row">
          <div class="list-item col-xs-6">Leslie Kaebling</div>
          <div class="list-item col-xs-6">Craig Knoblock</div>
        </div>
        <div class="row">
          <div class="list-item col-xs-6">Peter Norvig</div>
          <div class="list-item col-xs-6">David Smith</div>
        </div>
        <div class="row">
          <div class="list-item col-xs-6">Manuela Veloso</div>
          <div class="list-item col-xs-6">Toby Walsh</div>
        </div>
        <div class="row">
          <div class="list-item col-xs-6">Dan Weld</div>
          <div class="list-item col-xs-6">Chris White</div>
        </div>
      </div>
    </div>
    <div class="section-footer row">
      <div class="col-xs-12">
      <!-- anchor placed here so Sponsors section shows up just below nav -->
      <a name="sponsors"> </a>
      </div>
    </div>
  </div>
  
  <!-- ############### Sponsors ############### -->
  <div class="sponsor-section section-even">
    <div class="row">
      <div class="col-xs-12">
        <h2 class="section-header">Sponsors</h2>
      </div>
      <div class="col-xs-12 about-desc">
        <p>Our sponsors include <a href="http://www.inferlink.com">InferLink Corporation</a>, which developed the initial site,  the <a href="http://allenai.org/">Allen Institute for Artificial Intelligence</a>, which collected the directory of resources.
        </p>
        <p>Please consider supporting our work.  Contributions to <a href="https://www.jair.org/aiaf.html">AI Access Foundation</a> will help support the site. AI Access Foundation is a  tax-exempt 501(c)(3) public benefit corporation.</p>
        <center>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" style="padding: 5px;"><input type="hidden" name="cmd" value="_s-xclick">   <input type="hidden" name="hosted_button_id" value="9W2ECGFRDNLGW"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"> <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"> </form>
        </center>
      </div>
    </div>
    <div class="section-footer row">
      <div class="col-xs-12">
      <!-- anchor placed here so Editor section shows up just below nav -->
      <a name="editor"> </a>
      </div>
    </div>
  </div>

  <div class="row">
    <div id="about-author" class="col-xs-12">Site designed and developed by staff at InferLink, lead by Kane See</div>
  </div>
</div>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>

</body>
</html>

<?php ob_flush() ?>
