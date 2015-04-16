<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>

  <link rel="stylesheet" href="/assets/css/comments.css" type="text/css">
  <script src="/assets/js/comments.js"></script>
  
<?php
  incrementViewCount($id);
    
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
   
  <title>Open Air</title>
</head>
  
<body>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>

  <div id="main" class="container">
    <div class="row">

          <div class="resource-comment">
            <div class="resource">
              <div class=title>
                <a href="details.php?id=<?=$row{'id'}?>"><?=$row{'name'}?></a>
<?php if( isAdmin() ) { ?>
                <a href='javascript:deleteResource()' >
                  <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                </a>
<?php } ?>
              </div>
              <div class="link">
                <b>Project</b>: </b><a href="<?=$row{'link'}?>" target='_blank'><?=$row{'link'}?></a>
              </div>
              <div class="paper-link">
                <b>Paper</b>: <a href="<?=$row{'paper_url'}?>" target='_blank'><?=$row{'paper_url'}?></a>
              </div>
              
              <div class="">
                <pre class="about"><?=htmlspecialchars($row{'description'})?></pre>
              </div>
              <table class=features>
                <tr>
                  <td><b>Resource type:</b>&nbsp;<?=$row{'resource_type'}?></td>
                  <td><b>License type:</b>&nbsp;<?=$row{'license_type'}?></td>
                </tr>
                <tr>
                  <td><b>Categories:</b>&nbsp;<?=$catPath?></td>
                  <td><b>Owner:</b>&nbsp;<?=$row{'owner'}?></td>
                </tr>
                <tr>
                  <td><b>Author:</b>&nbsp;<?=$row{'author'}?></td>
                </tr>
              </table>
              <div class=added>Added on <?=$row{'approved_date'}?></div>
              <div class="action-list">
                <span class="glyphicon glyphicon-eye-open view" aria-hidden="true"><?=$row{'num_views'}?></span>
                <span class="glyphicon glyphicon-thumbs-up like <?=$likedClass?>" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"><?=$row{'num_likes'}?></span>
                <span class="glyphicon glyphicon-comment comment" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"><?=$row{'num_comments'}?></span>
              </div>
            </div>

<!-- ######### comments ############# -->
              <div class="cmt-container">

                <!-- comment form -->
                <!--
                <div class="new-com-bt">
                  <span>Write a comment ...</span>
                </div>
                -->
                <div class="new-com-cnt">
                  <textarea class="the-new-com"></textarea>
                  <div data-resource-id="<?=$row{'id'}?>" class="bt-add-com">Post comment</div>
<!--                  <div class="bt-cancel-com">Cancel</div>-->
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
    $comment = $affcom['comment'];
    $date = $affcom['date'];
?>
                <div class="cmt-cnt">
                  <img src="<?= $commenter_img; ?>" />
                  <div class="thecom">
                    <h5><?= $commenter_name; ?></h5>
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
            </div> <!-- class=resource-comment -->
    </div> <!-- class=row -->
  </div> <!-- class=container -->

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>

<script type="text/javascript">
//  $('select.drilldown').selectHierarchy({ hideOriginal: true });
</script>

<?php
//ONLY PRINT THIS JAVASCRIPT IF THEY ARE AN ADMIN
if(isAdmin()) {
?>
<script>
  function deleteResource() {
    var r=confirm("Are you sure you want to delete this resource?");
    if (r==true) {
      window.location.href = window.location.origin+"/services/delete_resource.php?id=<?= $id ?>";
    }
    else{
    }
  }
</script>
<?php } ?>


</body>
</html>

<?php ob_flush() ?>
