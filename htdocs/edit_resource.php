<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'header.php'; ?>
  <?php include 'admin-required.php'; ?>
  <script src="/assets/js/select-categories.js"></script>

<?php
$json = buildJSTreeJson($cat, false);
echo "<script>var category_json = ".$json.";</script>";
?>

<?php
$pending = false;
  
$id = $_GET['id'];

$r = mysql_query("SELECT * FROM resource WHERE id = ".$id);
$resource = mysql_fetch_array($r);

?>
  
  <script>
    function preprocessForm() {
      var catIds = '';
      $('.category').each(function(i, cat) {
        if( catIds ) catIds += ',';
        catIds += $(cat).attr('data-catid');
      });
      $('#categories').val(catIds);
      return true; 
    }
  </script>
  <title>Edit <?= $resource['name'] ?></title>
  
  </head>
  
<body>

<?php include 'nav.php'; ?>


<div class="container">
  <div class="row row-offcanvas row-offcanvas-left">
  	<h2>Edit <?= $resource['name']; ?></h2>

  	<form name="form" action="update-resource.php" method="POST" onsubmit="return preprocessForm();">
      <input type=hidden name="id" value="<?= $id ?>">
      
      <div class="form-group">
        <label for="dbname">Resource Name:</label>
        <input type="text" class="form-control" name="dbname" required="required" value="<?= $resource['name'] ?>">
      </div>
      
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="prog_lang">Programming Language:<br></label>
            <input type="text" class="form-control" name="prog_lang" value="<?= $resource['programming_lang'] ?>">
          </div>
        </div>

        <div class="col-sm-6">
           <div class="form-group">
            <label for="dataformat">Data Format:<br></label>
            <input type="text" class="form-control" name="dataformat" value="<?= $resource['data_format'] ?>">
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="type">Entry Type:<br></label>
            <input type="text" class="form-control" name="type" required="required" value="<?= $resource['resource_type'] ?>">
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="license">License Type:<br></label>
            <input type="text" class="form-control" name="license" required="required" value="<?= $resource['license_type'] ?>">
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label for="description">Short Description:</label>
        <textarea class="form-control" rows="5" wrap="virtual" name="description" required="required">
          <?= $resource['description'] ?>
        </textarea>
      </div>
      
<?php
  $categories = '';
  $rs = mysql_query("SELECT c.* FROM resource_category rc ".
                    "LEFT JOIN category c ON rc.category_id=c.id ".
                    "WHERE rc.resource_id = " . $resource['id'] );
  while ($cat = mysql_fetch_array($rs)) {
    $categories .= '<a class="category" data-catid="'.$cat['id'].'" onclick="return removeMe(this);">'
                   .'['.$cat['name'].'] </a>';
  }
?>
      <div class="form-group">
        <label for="categories">Select one or more Categories:</label>
        <input id="categories" type="hidden" name="categories">
        <div id='catbrowser'></div>
        <div id="categoryInput" class="form-control"><?= $categories ?></div>
      </div>

      <h2>References</h2>
      <hr>
      
      <div class="form-group">
        <label for="link">Link to data website:</label>
        <input type="url" class="form-control" name="link" required="required" value="<?= $resource['link'] ?>">
      </div>

      <div class="form-group">
        <label for="paperurl">Link to paper:</label>
        <input type="url" class="form-control" name="paperurl" value="<?= $resource['paper_url'] ?>">
      </div>


      <h2>Attribution</h2>
      <hr>

       <div class="form-group">
        <label for="author">Author:<br></label>
        <input type="text" class="form-control" name="author" value="<?= $resource['author'] ?>">
      </div>

      <div class="form-group">
        <label for="owner">Owner:<br></label>
        <input type="text" class="form-control" name="owner" value="<?= $resource['owner'] ?>">
      </div>

<?php
  $submitter = 'N/A';
  $rs = mysql_query("SELECT * FROM user WHERE id = " . $resource['submitter_id'] );
  $user = mysql_fetch_array($rs);
  if( $user ) {
    $submitter = '<div>'.$user['name'].'</div>'.'<img src="'.$user['image_url'].'">';
  }
?>
      <div class="form-group">
        <label for="submitter">Submitter:<br></label>
        <br><?= $submitter ?>
      </div>

      <button type="submit" class="btn">Submit Changes</button>
    </form>
  </div> <!-- class=row -->  
</div> <!-- class=container -->
  
<?php include 'footer.php'; ?>
  
<script type="text/javascript">
//  $('.drilldown').selectHierarchy({ hideOriginal: true });
</script>

  </body>
</html>

<?php ob_flush() ?>
