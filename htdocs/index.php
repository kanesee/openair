<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
  
  <link rel="stylesheet" href="/assets/css/comments.css" type="text/css">
  <script src="/assets/js/comments.js"></script>
  <script>
    var category_json = <?=buildJSTreeJson($cat, true, 'approved_count')?>;
  </script>
  
<?php
$query = "";
if(isset($_GET['q'])) { $query = $_GET['q']; }

$MAX_RESULTS = 10;
$page = 1;
if (isset($_GET['p'])) { $page=$_GET['p']; }
$startIdx = ($page-1) * $MAX_RESULTS;

$urlAdd = "";
if(!empty($query)) {
  $urlAdd = "&q=".$query;
}
if(!empty($cat)) {
  $urlAdd .= "&cat=".$cat;
}

$numResult = countResults($subcatString, $query);
$totalPages = ceil($numResult / $MAX_RESULTS);

$catTitle = getTopicName($cat);
$catdescription = getTopicDesc($cat);
$catImg = getTopicImg($cat);

?>

<?php
//ONLY PRINT THIS JAVASCRIPT IF THEY ARE AN ADMIN
if(isAdmin()) {
?>
<script>
	function deleteCategory() {
		var r=confirm("Are you sure you want to delete <?= $catTitle; ?> and all of the child categories beneath it?");
		if (r==true) {
			window.location.href = window.location.origin+"/services/delete_category.php?cat="+cat;
		}
		else{
		}
	}
</script>

<?php
}
?>
  
  <title>Open AIR Home</title>

</head>
  
<body>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>
  
<div id="heading" class="hero-unit">
  <div class="row">
    <img class="topic-img" src="<?= $catImg ?>">
    <div id="topic-name">
      <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span>
      <span class="topic-name-text"><?= $catTitle ?></span>
      
<?php if( isAdmin() && $cat>0 ) { ?>
      <a href='javascript:deleteCategory()' >
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
      </a>
<?php } ?>
    </div>
    <div id="editors">
      <div class="editor-heading">Editors: </div>
      
<!--
      <div class="editor"><img src="http://abs.twimg.com/sticky/default_profile_images/default_profile_5_normal.png"></div>
      <div class="editor"><img src="https://graph.facebook.com/10152673886552261/picture?type=square"></div>
      <div class="editor"><img src="/assets/img-3rd/unknownuser.png"></div>
-->

      <img class="editor" src="http://abs.twimg.com/sticky/default_profile_images/default_profile_5_normal.png">
      <img class="editor" src="https://graph.facebook.com/10152673886552261/picture?type=square">
      <img class="editor" src="/assets/img-3rd/unknownuser.png">
    </div>

    <div id="topic-desc">
      <?= $catdescription ?>
<?php if( isAdmin() && $cat>0 ) { ?>
      <a href='edit_category.php?cat=<?=$cat?>'>
        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
      </a>
<?php } ?>
    </div>
    
    <div id="search">
      <form id="searchform" class="form-search form-group" method="GET" action=".">
        <div class="input-append">
          <input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
          <button type="submit" class="btn btn-danger">Search</button>
          <input type="text" class="search-query input-xxlarge form-control" name='q' value="<?= $query ?>" placeholder="Search within <?= $catTitle ?>">
        </div>
      </form>
    </div>
    <br style="clear: both">
    
  </div>
</div> <!-- end id=heading -->
<div class="arrow_box"></div>
  
  
<!-- search results -->  
<div class="container">
  <div class="row row-offcanvas row-offcanvas-left">
    
    <div id="main" class="col-xs-12 col-sm-12">
      <div id="index" class="span7">
<?php
if($totalPages>0) {
?>
<!--
        <div class="page-controls">
          <div class="row-fluid">
            <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
            <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
            <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
          </div>
        </div>
-->
<?php
}
?>
  
        <table id='searchresults' class="table">
          <thead>
            <tr>
              <th colspan="2" id="totalResult"><?= $numResult ?> results</th>
            </tr>
          </thead>
          <tbody>

<?php
// ########## print search results
$count = 0;
$sqlStatement = getResourceSearchSQL($subcatString, $query, $startIdx, $MAX_RESULTS);

$rs = mysql_query($sqlStatement);
while ($row = mysql_fetch_array($rs)) {
  $count++;
  
  $types = explode(",", $row{'resource_type'});
  $typeHtml = '';
  foreach($types as $type) {
    $type = trim($type);
    $typeColor = stringToColorCode($type);
    $typeHtml .= "<span class='label' style='background-color: $typeColor'>
                    $type
                  </span>";
  }
  
    $catRs = mysql_query("
      SELECT c.id, c.name FROM resource_category rc
      LEFT JOIN category c ON rc.category_id = c.id
      WHERE rc.resource_id = ".$row{'id'});

    $catPath = '';
    while($catRow = mysql_fetch_array($catRs)) {
      if( !empty($catPath) ) { $catPath .= " | "; }
      $catPath .= '<a href="?cat='.$catRow{'id'}.'">'.$catRow{'name'}.'</a>';
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
          <tr class="resource-container">
            <td class="meta-resource-column">
              <a class="link" href="<?=$row{'link'}?>" target='_blank'>
                <span class="glyphicon glyphicon-link" aria-hidden="true">Project</span>
              </a>
              <a class="link" href="<?=$row{'paper_url'}?>" target='_blank'>
                <span class="glyphicon glyphicon-link" aria-hidden="true">Paper</span>
              </a>
              
              <div class="action-list">
                <span class="glyphicon glyphicon-thumbs-up like <?=$likedClass?>" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"> <?=$row{'num_likes'}?></span>
                <span class="glyphicon glyphicon-comment comment" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"> <?=$row{'num_comments'}?></span>
              </div>
              
            </td>
            <td class="resource-column">
              <div class="resource">
                <div class="resource-title">
                  <a href="details.php?id=<?=$row{'id'}?>"><?=$row{'name'}?></a>
                  <span class="resource-type"><?= $typeHtml ?></span>
                </div>

                <div class="resource-desc"><?=htmlspecialchars($row{'description'})?></div>
                
                <div class="view"><?=$row{'num_views'}?> views</div>

                <div class="submission">
                  Submitted by <img class="submitter" src="<?=$row{'image_url'}?>"> on <?=$row{'approved_date'}?>
                </div>
              </div>

              <!-- ######### comments ############# -->
              <div class="cmt-container">
                <div class="new-com-cnt">
                  <textarea class="the-new-com"></textarea>
                  <div data-resource-id="<?=$row{'id'}?>" class="bt-add-com">Post comment</div>
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
                  <img src="<?= $commenter_img ?>" />
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
<?php
} // end while
?>

<?php
// ########## If no search results
if($count==0) {
	if(empty($query)) {
		echo "There are no entries in ".$catTitle.".";
	}
	else {
	    echo "No results for '".$query."' in the ".$catTitle." category.";
	}
}
?>
                </td>
              </tr>
            </tbody>
          </table> <!-- id=searchresults -->

<?php
if($totalPages>0) {
?>
<!--
            <div class="page-controls">
              <div class="row-fluid">
                <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
                <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
                <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
              </div>
            </div>
-->
<?php
}
?>
      
      
        </div> <!-- id=index -->
      </div> <!-- id=main -->
    </div> <!-- class=row -->
  </div> <!-- class=container -->
  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
  
</body>
</html>

<?php ob_flush() ?>
