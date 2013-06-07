<?php include 'header.php'; ?>
<?php include 'category.php'; ?>

<script type="text/javascript" src="assets/js/jquery.jwysiwyg.js"></script>
<script type="text/javascript">
$(function() {
  $("#wysiwyg").wysiwyg();
});
</script>

<?php
	$discription = $resourcedescription;
	$message="";
	$con = mysqli_connect("ec2-54-243-13-79.compute-1.amazonaws.com","openai","theaiisclosed","openair");
	if (mysqli_connect_errno($con))
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	if(isset($_POST['edited'])){
		$discription = addslashes($_POST['edited']);
		$result = mysqli_query($con, "UPDATE category SET description='$discription' WHERE name='$resourcetitle'");
		if($result)
			$message = "<div class='alert alert-success'><strong>Thanks!</strong> " . $resourcetitle . " discription has been updated.<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
		else
			$message = "<div class='alert alert-failure'>" . $resourcetitle . " discription could not be updated.<button type='button' class='close' data-dismiss='alert'>&times;</button></div>";
	}
?>

<style>textarea{width:50%;}</style>
<div id="right" class="span7">
	<h2>Editing Topic: <?php echo $resourcetitle ?></h2>
	<?php echo $message; ?>
	<form id='edit-category' method="POST" >
    <input name='cat' type='hidden' value="<?php echo $cat ?>"></input>

    <textarea id="wysiwyg" rows='7' name='edited' wrap='virtual'><?php echo $discription; ?></textarea><br>
	
    <button type="submit" class="btn">Save</button>
	</form>
</div>

<?php include 'footer.php'; ?>