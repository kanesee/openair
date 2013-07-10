<?php include "header.php"; ?>
<?php include 'category.php'; ?>

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

<?php
$pending = false;
if(isAdmin() && isset($_GET['id'])){
	$id = $_GET['id'];

  	$r = mysql_query("SELECT * FROM resource WHERE id = ".$id);
  	$row = mysql_fetch_array($r);
  	echo "<head><title>Edit ".$row['name']."</title></head>";

  	?>
  	<div id="right" class="span7">
  	<h2>Edit <?php echo $row['name']; ?></h2>

  	<form name="form" action="update-resource.php" onsubmit="validate()" method="POST">
  		<input type=hidden name=id value=<?php echo $id; ?>>
  		Entry Name: <br><input type="text" name="dbname" required="required" value=<?php echo $row['name']; ?>><sup id="namecheck" style="color:red"></sup>
  		<br>Link to data website: <br><input type="url" name="link" required="required" value=<?php echo $row['link']; ?>><sup id="linkcheck" style="color:red"></sup>
  		<br>Short Description: <br>
		<textarea cols="30" rows="5" wrap="virtual" name="description" required="required"><?php echo $row['description']; ?></textarea><sup id="disccheck" style="color:red"></sup><br>

		<?php
		echo "Entry Type:<br>";
		$result = mysql_query("SELECT * FROM resource_type");
		echo '<select name="resource" required="required">';
		while($line = mysql_fetch_array($result)){
			echo '<option value="' . $line['name'] . '"';
			if($line['id'] == $row['resource_type']){
				echo ' selected="selected"';
			}
			echo '>'.$line['name'].'</option>';
		}
		echo '</select><br>';

		echo "License Type:<br>";
		$result = mysql_query("SELECT * FROM license_type");
		echo '<select name="license" required="required">';
		while($line = mysql_fetch_array($result)){
			echo '<option value="' . $line['name'] . '"';
			if($line['id'] == $row['license_type']){
				echo ' selected="selected"';
			}
			echo '>'.$line['name'].'</option>';
		}
		echo '</select><br>';

		echo "Significance:<br>";
		$result = mysql_query("SELECT * FROM significance_type");
		echo '<select name="significance" required="required">';
		while($line = mysql_fetch_array($result)){
			echo '<option value="' . $line['name'] . '"';
			if($line['id'] == $row['significance_type']){
				echo ' selected="selected"';
			}
			echo '>'.$line['name'].'</option>';
		}
		echo '</select><br>';
		?>
	Submitter's Name: <br><input type="text" name="submitter" required="required" value=<?php echo $row['submitters_name'] ?>><sup id=submcheck style="color:red"></sup><br>
	Email: <br><input type="email" name="email" required="required" value=<?php echo $row['submitters_email'] ?>><sup id=mailcheck style="color:red"></sup><br>
	Owner: <br><input type="text" name="owner" value=<?php echo $row['owner']; ?>><br>
	<button type="submit" class="btn">Submit Changes</button>
	</form>
	</div>
  	<?php
}

else{
	redirect("index.php");
}
?>
<?php include 'footer.php'; ?>