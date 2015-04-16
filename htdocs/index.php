<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
  
  <link rel="stylesheet" href="/assets/css/comments.css" type="text/css">
  <script src="/assets/js/comments.js"></script>
  
  <title>Open AIR Home</title>

<?php
$json = buildJSTreeJson($cat, true);
echo "<script>var category_json = ".$json.";</script>";
?>
  
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

$totalPages = ceil(countResults($subcatString, $query) / $MAX_RESULTS);

$catTitle = getCategoryTitle($cat);
$catdescription = getCategoryDesc($cat);

?>

<?php
//ONLY PRINT THIS JAVASCRIPT IF THEY ARE AN ADMIN
if(isAdmin()) {
?>
<script>
	function deleteCategory() {
		var r=confirm("Are you sure you want to delete <?= $catTitle; ?> and all of the child categories beneath it?");
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

</head>
  
<body>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>

<div class="container">
  <div class="row row-offcanvas row-offcanvas-left">
    
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/category.php'); ?>

    <div id="main" class="col-xs-12 col-sm-9">
      <div id="index" class="span7">
        <div id="resourceinfo">
          <div id="resourcetitle">
            <?= $catTitle ?>
<?php if( isAdmin() && $cat>0 ) { ?>
            <a href='javascript:deleteCategory()' >
              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
            </a>
<?php } ?>
          </div>
          <div id="resourcedescription">
            <?= $catdescription ?>
<?php if( isAdmin() && $cat>0 ) { ?>
            <a href='edit_category.php?cat=<?=$cat?>'>
              <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
            </a>
<?php } ?>
          </div>
        </div>

        <div id="search">
          <form id="searchform" class="form-search form-group" method="GET" action=".">
            <div class="input-append">
              <input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
              <input type="text" class="search-query input-xxlarge form-control" name='q' value="<?= $query ?>" placeholder="Search within <?= $catTitle ?>">
              <button type="submit" class="btn">Search</button>
            </div>
          </form>
        </div>

<?php
if($totalPages>0) {
?>
        <div id="searchcontrols">
          <div class="row-fluid">
            <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
            <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
            <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
          </div>
        </div>
<?php
}
?>
  
        <div id='searchresults'>

  
<?php
// ########## print search results
$count = 0;
$sqlStatement = getResourceSearchSQL($subcatString, $query, $startIdx, $MAX_RESULTS);

$rs = mysql_query($sqlStatement);
while ($row = mysql_fetch_array($rs)) {
	$count++;
  
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
            <div class="resource-comment">
              <div class="resource">
                <div class=title>
                  <a href="details.php?id=<?=$row{'id'}?>"><?=$row{'name'}?></a>
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
  
<?php
if($totalPages>0) {
?>
            <div id="searchcontrols">
              <div class="row-fluid">
                <div class="col-xs-3 text-left"><?php if ($page > 1) {echo "<a href=index.php?p=".($page-1).$urlAdd.">&lt; Previous Page</a>";} else { echo "&lt; Previous Page";} ?></div>
                <div class="col-xs-6 text-center">Page <?php echo $page." of ". $totalPages; ?> </div>
                <div class="col-xs-3 text-right"><?php if ($page < $totalPages) {echo "<a href=index.php?p=".($page+1).$urlAdd.">Next Page &gt;</a>";} else { echo "Next Page &gt;";} ?></div>
              </div>
            </div>
<?php
}
?>
      
      
          </div> <!-- id=searchresults -->
      
        </div> <!-- id=index -->
      </div> <!-- id=main -->
    </div> <!-- class=row -->
  </div> <!-- class=container -->
  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
  
</body>
</html>

<?php ob_flush() ?>
