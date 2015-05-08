<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
  
  <style>
    .arrow_box {
      margin-bottom: 30px;
    }
    
    .action-link {
      padding-left: 10px;
      padding-right: 5px;
      vertical-align: super;
    }
  </style>

  <link rel="stylesheet" href="/assets/css/comments.css" type="text/css">
  <script src="/assets/js/comments.js"></script>
  
  <script>
    $(function () {
      if( window.location.href.indexOf('#comments') > -1 ) {
        $('a[href="#comments"]').tab('show');
        $('#comment-area').focus();
      }
    });
  </script>
<?php
  incrementViewCount($id);

  $catTitle = getTopicName($cat);

    
  $r=mysql_query(getResourceSQL($id));

  $row = mysql_fetch_assoc($r);

  $catStmt="
  SELECT c.id, c.name FROM resource_category rc
  LEFT JOIN category c ON rc.category_id = c.id
  WHERE rc.resource_id = ".$row{'id'};

  $catRs = mysql_query($catStmt);

  $catPath = '';
  while($catRow = mysql_fetch_array($catRs)) {
    if( !empty($catPath) ) { $catPath .= " | "; }
    $catPath .= '<a href="/?cat='.$catRow{'id'}.'">'.$catRow{'name'}.'</a>';
  }

  $likedClass = '';
  if( isLoggedIn() ) {
    $user_id = $_SESSION["user"]->id;

    $likedRs = mysql_query("
      SELECT COUNT(*) as cnt FROM resource_likes
      WHERE resource_id=".$row{'id'}."
      AND user_id=$user_id
      ");
    $likedRow = mysql_fetch_array($likedRs);
    if( $likedRow{'cnt'} > 0 ) {
      $likedClass='liked';
    }
  }
?>
   
  <title><?=$row{'name'}?></title>
</head>
  
<body>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>

  <div id="detail-heading" class="hero-unit">
    <div class="row">
      <div id="search-detail">
        <form id="searchform" class="form-search form-group" method="GET" action=".">
          <div class="input-append">
            <input name='cat' type='hidden' value="<?= $cat ?>"></input>
            <button type="submit" class="btn btn-danger">Search</button>
            <input type="text" class="search-query input-xxlarge form-control" name='q' value="" placeholder="Search within <?= $catTitle ?>">
            <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/category.php'); ?>
          </div>
        </form>
      </div>
      <br style="clear: both">

    </div>
  </div> <!-- end id=heading -->
  <div class="arrow_box"></div>
  
  <div class="container">
    
    <div id="detail-brief">
    
    <!-- ############## Title ############### -->
    <div class="row">
      <div class="col-xs-12">
        <h2 id="detail-title">
  <?php if( isAdmin() ) { ?>
          <a href="edit_resource.php?id=<?=$row{'id'}?>">
            <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
          </a>
          <a href='javascript:deleteResource()' >
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          </a>
  <?php } ?>
          <?=$row{'name'}?>
        </h2>
      </div>
    </div>
    
    <!-- ############## Project & Paper Links ############### -->
<?php
    $attribution = "";
    if( !empty($row{'author'}) )
        $attribution = "by ".$row{'author'}." ";
    if( !empty($row{'owner'}) )
        $attribution .= "from ".$row{'owner'};
?>
    <div class="row">
<?php   if( !empty($row{'link'}) ) { ?>
      <div class="col-xs-6">
        Project: <a class="link" href="<?=$row{'link'}?>" target='_blank'>
          <?=$row{'link'}?>
        </a>
      </div>
<?php   } ?>
<?php   if( !empty($row{'paper_url'}) ) { ?>
      <div class="col-xs-6">
        Paper: <a class="link" href="<?=$row{'paper_url'}?>" target='_blank'>
          <?=$row{'paper_url'}?>
        </a>
      </div>
<?php   } ?>
    </div>

    <!-- ############## Author/ Owner ############### -->
    <div class="row">
      <div class="col-xs-12">
        <?= $attribution ?>
      </div>
    </div>

    <!-- ############## Submitter ############### -->
    <div class="row detail-submission">
      <div class="col-xs-12">
        Submitted by
        <a href="<?=$row{'profile_url'}?>">
          <img class="submitter" src="<?=$row{'image_url'}?>">
        </a>
        on <?= date('M d Y', strtotime($row{'approved_date'})) ?>
      </div>
    </div>
  </div>
    
    <!-- ############## Links and Meta ############### -->
<?php
  $mailto = 'admin@inferlink.com';
  $subject = 'Post-' . $row{'id'} . ' Flagged';
  $who = "";
  if( isLoggedIn() ) {
    $who = $_SESSION["user"]->name . ' (' . $_SESSION["user"]->id . ') has';
  } else {
    $who = "I have";
  }
    $body = "$who the following comment about this post: ";
    $mail_link = 'mailto:'.$mailto.'?subject='.$subject.'&body='.$body;
?>    
    <div class="row">
      <div class="col-xs-12">
        <span class="glyphicon glyphicon-thumbs-up action-link like <?=$likedClass?>" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"> <?=$row{'num_likes'}?></span>
      
        <a href="https://twitter.com/share" class="twitter-share-button" data-via="OpenAIResources">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        
        <a id="flag-resource" href="<?=$mail_link?>">
          <span class="glyphicon glyphicon-flag" aria-hidden="true"></span>
          Suggest Revision
        </a>
      </div>
    </div>
    
    
    <!-- ############## Tab Area ############### -->
    <div id="detail-tabpanel" class="row">
      <div class="col-xs-12">
        
        <div role="tabpanel">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
              <a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Summary</a>
            </li>
            <li role="presentation">
              <a href="#comments" aria-controls="comments" role="tab" data-toggle="tab">Comments (<span id="comment-count"><?=$row{'num_comments'}?></span>)</a>
            </li>
          </ul>
        </div>

        <div class="tab-content">

          <!-- ############## Summary ############### -->
          <div role="tabpanel" class="tab-pane active" id="summary">

            <!-- ############## Resource Types / License ############### -->
<?php
            $types = explode(",", $row{'resource_type'});
            $typeHtml = '';
            foreach($types as $type) {
              $type = trim($type);
              $typeColor = stringToColorCode($type);
              $typeHtml .= "<span class='label' style='background-color: $typeColor'>
                              $type
                            </span>";
            }
?>
            <div class="row">
              <div class="col-xs-2 detail-field">Type:</div>
              <div class="col-xs-4">
                <span class="resource-type"><?= $typeHtml ?></span>
              </div>
              <div class="col-xs-2 detail-field">License:</div>
              <div class="col-xs-4">
                <?= $row{'license_type'} ?>
              </div>
            </div>

            <!-- ############## Programming Language  / Data Format ############### -->
            <div class="row">
              <div class="col-xs-2 detail-field">Language:</div>
              <div class="col-xs-4">
                <?= $row{'programming_lang'} ?>
              </div>
              <div class="col-xs-2 detail-field">Data Format:</div>
              <div class="col-xs-4">
                <?= $row{'data_format'} ?>
              </div>
            </div>

            <!-- ############## Description ############### -->
            <div class="row">
              <div class="col-xs-12 detail-field">
                <h4>Description</h4>
              </div>
            </div>
            <div id="detail-desc" class="row">
              <div class="col-xs-12">
                <?= htmlspecialchars($row{'description'}) ?>
              </div>
            </div>

            <!-- ############## Topic ############### -->
            <div class="row">
              <div class="col-xs-12 detail-field">
                Categorized in: <?=$catPath?>
              </div>
            </div>

          </div> <!-- tabpanel=summary -->

          <!-- ############## Comments ############### -->
          <div role="tabpanel" class="tab-pane" id="comments">

            <!-- comment form -->
            <div class="new-com-cnt">
              <textarea id="comment-area" class="the-new-com"></textarea>
              <div data-resource-id="<?=$row{'id'}?>" class="bt-add-com">Post comment</div>
              <div class="bt-cancel-com">Cancel</div>
            </div>
            <div class="clear"></div>

            <!-- previous comments -->
<?php 

            $sql = mysql_query("SELECT * FROM comments c
                                LEFT JOIN user u ON c.userid=u.id
                                WHERE resource_id = ".$row{'id'}
                              ." ORDER BY c.date DESC")
                    or die(mysql_error());;
            while($affcom = mysql_fetch_assoc($sql)){
              $commenter_name = $affcom['name'];
              $commenter_img = $affcom['image_url'];
              $commenter_profile = $affcom['profile_url'];
              $comment = $affcom['comment'];
              $date = $affcom['date'];
?>
              <div class="cmt-cnt">
                <?php if( !empty($commenter_profile) ) { ?><a href="<?= $commenter_profile ?>"><?php } ?>
                  <img src="<?= $commenter_img ?>" />
                <?php if( !empty($commenter_profile) ) { ?></a><?php } ?>
                <div class="thecom">
                  <h5>
                    <?php if( !empty($commenter_profile) ) { ?><a href="<?= $commenter_profile ?>"><?php } ?>
                      <?= $commenter_name; ?>
                    <?php if( !empty($commenter_profile) ) { ?></a><?php } ?>
                  </h5>
                  <span data-utime="1371248446" class="com-dt"><?php echo $date; ?></span>
                  <br/>
                  <p>
                    <?php echo $comment; ?>
                  </p>
                </div>
              </div><!-- end "cmt-cnt" -->
<?php 
            } // end while
?>
            </div> <!-- class=comments -->
            <!-- ######### end comments ############# -->
        </div> <!-- tabpanel contents -->
      </div> <!-- tab panel -->
    </div>
  </div> <!-- class=container -->

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>


</body>
</html>

<?php ob_flush() ?>
