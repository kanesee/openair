<!DOCTYPE html>
<html lang="en">
<head>

  <?php include 'header.php'; ?>
<?php
$pending = false;
if(!isAdmin() || !isset($_GET['id'])) {
  redirect("/not-authorized.php");
}
  
$id = $_GET['id'];

$r = mysql_query("SELECT * FROM resource WHERE id = ".$id);
$resource = mysql_fetch_array($r);


?>  
  <title>Edit <?= $resource['name'] ?></title>
  

<script>
function validate(){
	var pass = true;
	var fields = document.forms["form"];
	if(fields["dbname"].value==""){
		pass = false;
		document.getElementById("namecheck").innerHTML=" *Required";
	}
	else
		document.getElementById("namecheck").innerHTML="";
	if(fields["link"].value==""){
		pass = false;
		document.getElementById("linkcheck").innerHTML=" *Required";
	}
	else
		document.getElementById("linkcheck").innerHTML="";
	if(fields["description"].value==""){
		pass = false;
		document.getElementById("disccheck").innerHTML=" *Required";
	}
	else
		document.getElementById("disccheck").innerHTML="";
	if(fields["submitter"].value==""){
		pass = false;
		document.getElementById("submcheck").innerHTML=" *Required";
	}
	else
		document.getElementById("submcheck").innerHTML="";
	var atpos=fields["email"].value.indexOf("@");
	var dotpos=fields["email"].value.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=fields["email"].length){
		document.getElementById("mailcheck").innerHTML=" *Not a valid e-mail address";
		pass = false;
	}
	else
		document.getElementById("mailcheck").innerHTML="";
	if(fields["email"].value==""){
		pass = false;
		document.getElementById("mailcheck").innerHTML=" *Required";
	}
	return pass;
}
</script>

  </head>
  
<body>

<?php include 'nav.php'; ?>


<div class="container">
  <div class="row row-offcanvas row-offcanvas-left">
  	<h2>Edit <?php echo $resource['name']; ?></h2>

  	<form name="form" action="update-resource.php" onsubmit="validate()" method="POST">
      <input type=hidden name="id" value="<?= $id ?>">
      
      <div class="form-group">
        <label for="dbname">Resource Name:</label>
        <input type="text" class="form-control" name="dbname" required="required" value="<?= $resource['name'] ?>">
        <sup id="namecheck" style="color:red"></sup>
      </div>
      
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="prog_lang">Programming Language:<br></label>
            <input type="text" class="form-control" name="prog_lang" required="required" value="<?= $resource['programming_lang'] ?>">
            <sup id="prog_langcheck" style="color:red"></sup>
          </div>
        </div>

        <div class="col-sm-6">
           <div class="form-group">
            <label for="dataformat">Data Format:<br></label>
            <input type="text" class="form-control" name="dataformat" required="required" value="<?= $resource['data_format'] ?>">
            <sup id="dataformatcheck" style="color:red"></sup>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label for="type">Entry Type:<br></label>
            <input type="text" class="form-control" name="type" required="required" value="<?= $resource['resource_type'] ?>">
            <sup id="typecheck" style="color:red"></sup>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-group">
            <label for="license">License Type:<br></label>
            <input type="text" class="form-control" name="license" required="required" value="<?= $resource['license_type'] ?>">
            <sup id="licensecheck" style="color:red"></sup>
          </div>
        </div>
      </div>
      
      <div class="form-group">
        <label for="description">Short Description:</label>
        <textarea class="form-control" rows="5" wrap="virtual" name="description" required="required">
          <?= $resource['description'] ?>
        </textarea>
        <sup id="disccheck" style="color:red"></sup>
      </div>

      <h2>References</h2>
      <hr>
      
      <div class="form-group">
        <label for="link">Link to data website:</label>
        <input type="url" class="form-control" name="link" required="required" value="<?= $resource['link'] ?>">
        <sup id="linkcheck" style="color:red"></sup>
      </div>

      <div class="form-group">
        <label for="paperurl">Link to paper:</label>
        <input type="url" class="form-control" name="paperurl" required="required" value="<?= $resource['paper_url'] ?>">
        <sup id="paperurlcheck" style="color:red"></sup>
      </div>


      <h2>Attribution</h2>
      <hr>

       <div class="form-group">
        <label for="author">Author:<br></label>
        <input type="text" class="form-control" name="author" required="required" value="<?= $resource['author'] ?>">
        <sup id="authorcheck" style="color:red"></sup>
      </div>

      <div class="form-group">
        <label for="owner">Owner:<br></label>
        <input type="text" class="form-control" name="owner" required="required" value="<?= $resource['owner'] ?>">
        <sup id="ownercheck" style="color:red"></sup>
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
  $('.drilldown').selectHierarchy({ hideOriginal: true });
</script>

  </body>
</html>

<?php ob_flush() ?>
