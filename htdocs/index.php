<!DOCTYPE html>
<html lang="en">
<head>

  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/header.php'); ?>
  
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
//$catdescription = getTopicDesc($cat);
$catImg = getTopicImg($cat);

$topicImageElement = "";
if( !empty($catImg) ) {
  $topicImageElement = "<img class='topic-img' src='$catImg'>";
} else {
  $topicBgColor = stringToColorCode($catTitle);
  $topicText = substr($catTitle, 0, 1);
  $topicImageElement = "<div class='topic-img-none' style='background: $topicBgColor'>
                          $topicText
                        </div>";
}
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
  
  
  <script>
    $(function () {
      $('.pagination').twbsPagination({
          totalPages: <?= $totalPages ?>,
          visiblePages: 3,
          href: '?p={{number}}<?=$urlAdd?>#results'
      });

      if (typeof $.cookie('visited') === 'undefined'){
//        $.cookie('visited', 'true', { expires: 365 });
        $('#intro-modal').modal('show');
      }
    });
  </script>
  
  <title>Open AIR Home</title>

</head>
  
<body>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/nav.php'); ?>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/intro.php'); ?>

  
  <div id="heading" class="hero-unit">
    <div class="row">
      <div class="col-xs-9">
        <div id="topic-name">
  <?php if( isAdmin() && $cat>0 ) { ?>
          <a href='javascript:deleteCategory()' >
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          </a>
  <?php } ?>
          <span class="topic-name-text"><?= $catTitle ?></span>
        
          <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/category.php'); ?>
        </div>

        <!-- ############## Editors ############## -->
<?php
        $editorRs = mysql_query("
          SELECT image_url, profile_url FROM editor e, user u
          WHERE category_id = $cat
          AND e.editor_id = u.id");
        if( !empty($cat) && $cat != 0 && mysql_num_rows($editorRs) ) {
?>
        <div id="editors">
          <div class="editor-heading">Editors: </div>
<?php     while($editorRow = mysql_fetch_array($editorRs)) { ?>
          <a href="<?=$editorRow{'profile_url'}?>">
            <img class="editor" src="<?=$editorRow{'image_url'}?>">
          </a>
<?php     } // while($editorRow = mysql_fetch_array($editorRs) ?>
        </div>
<?php   } // if( !empty($cat) && $cat != 0 ) ?>

      </div>
      <div class="col-xs-3">
        <?= $topicImageElement ?>
      </div>
    </div>
    
    <!-- ############### search bar ################## -->
    <div class="row">
      <div id="search" class="col-xs-12">
        <form id="searchform" class="form-search form-group" method="GET" action=".">
          <div class="row">
            <div class="col-lg-12">
              <div class="input-group">
                <input name='cat' type='hidden' value="<?php echo $cat ?>"></input>
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-danger">Search</button>
                </span>
                <input type="text" class="form-control" name='q' value="<?= $query ?>" placeholder="Search within <?= $catTitle ?>">
              </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
          </div><!-- /.row -->
        </form>
      </div>
    </div>
  
  </div> <!-- end id=heading -->
  <div class="arrow_box"></div>
  
  
<!-- search results -->  
<div class="container">
  <span class="anchor" id="results"></span>
  <div class="row row-offcanvas row-offcanvas-left">
    
    
    <div id="main" class="col-xs-12 col-sm-12">
      <div id="index" class="span7">
          
        <table id='searchresults' class="table table-striped">
          <thead>
            <tr>
              <th id="result-header" colspan="2">
                <div id="page-control-top">
                  <ul class="pagination pagination-sm"></ul>
                </div>
                <div id="resultTotal"><?= $numResult ?> results in "<?= $catTitle ?>"</div>
              </th>
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
              <span class="glyphicon glyphicon-thumbs-up like <?=$likedClass?>" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"> <?=$row{'num_likes'}?></span>
              <a href="details.php?id=<?=$row{'id'}?>&cat=<?=$cat?>#comments">
                  <span class="glyphicon glyphicon-comment comment" aria-hidden="true" data-resource-id="<?=$row{'id'}?>"> <?=$row{'num_comments'}?></span>
              </a>
            </td>
            <td class="resource-column">
              <div class="resource">
                <div class="resource-title">
                  <a href="details.php?id=<?=$row{'id'}?>&cat=<?=$cat?>"><?=$row{'name'}?></a>
                  <span class="resource-type"><?= $typeHtml ?></span>
                </div>

<?php         if( !empty($row{'link'}) ) { ?>
                <a class="link" href="<?=$row{'link'}?>" target='_blank'>
                  <?=$row{'link'}?>
                </a>
<?php          } ?>

<?php
                $desc = htmlspecialchars($row{'description'});
                if( strlen($desc) > 100 ) {
                  $desc = substr($desc, 0, 100) . "...";
                }
?>
                <div class="resource-desc">
                  <?= $desc ?>
                </div>
                
                <div class="view"><?=$row{'num_views'}?> views</div>

                <div class="submission">
                  Submitted by
                  <a href="<?=$row{'profile_url'}?>">
                    <img class="submitter" src="<?=$row{'image_url'}?>">
                  </a>
                  on <?= date('M d Y', strtotime($row{'approved_date'})) ?>
                </div>
              </div>

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
          <ul id="page-control-bottom" class="pagination pagination-sm"></ul>      
      
        </div> <!-- id=index -->
      </div> <!-- id=main -->
    </div> <!-- class=row -->
  </div> <!-- class=container -->
  <?php include ($_SERVER['DOCUMENT_ROOT'].'/includes/footer.php'); ?>
  
</body>
</html>

<?php ob_flush() ?>
