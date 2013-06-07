<?php include 'header.php'; ?>
<?php include 'category.php'; ?>
<div id="right" class="span7">
  <h2>Submit an entry</h2>

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
	if(fields["resource"].value==""){
		pass = false;
		document.getElementById("resocheck").innerHTML=" *Required";
	}
	else
		document.getElementById("resocheck").innerHTML="";
	if(fields["license"].value==""){
		pass = false;
		document.getElementById("licecheck").innerHTML=" *Required";
	}
	else
		document.getElementById("licecheck").innerHTML="";
	if(fields["significance"].value==""){
		pass = false;
		document.getElementById("signcheck").innerHTML=" *Required";
	}
	else
		document.getElementById("signcheck").innerHTML="";
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

<form name="form" action="insert-resource.php" onsubmit="return validate()" method="POST">

Resource Name: <br><input type="text" name="dbname" required="required"><sup id="namecheck" style="color:red"></sup>
<br>Link to data website: <br><input type="url" name="link" required="required"><sup id="linkcheck" style="color:red"></sup>
<br>Short Description: <br>
<textarea cols="30" rows="5" wrap="virtual" name="description" required="required"></textarea><sup id="disccheck" style="color:red"></sup>
<br>

<?php
$con = mysqli_connect("ec2-54-243-13-79.compute-1.amazonaws.com","openai","theaiisclosed","openair");
if (mysqli_connect_errno($con)){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

echo "Resource Type:<br>";
$result = mysqli_query($con, "SELECT name FROM resource_type");
echo '<select name="resource" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysqli_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select><sup id=resocheck style="color:red"></sup>';

echo "<br>License Type: <br>";
$result = mysqli_query($con, "SELECT name FROM license_type");
echo '<select name="license" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysqli_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select><sup id=licecheck style="color:red"></sup>';

echo "<br>Significance: <br>";
$result = mysqli_query($con, "SELECT name FROM significance_type");
echo '<select name="significance" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysqli_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select><sup id=signcheck style="color:red"></sup>';

// BA ADDED CATEGORY
echo "<br>Category: <br>";
echo buildCategorySelect(false);
?>

<script type="text/javascript">
  $('select.drilldown').selectHierarchy({ hideOriginal: true });
</script>

<br>
Submitter's Name: <br><input type="text" name="submitter" required="required"><sup id=submcheck style="color:red"></sup><br>
Email: <br><input type="text" name="email" required="required"><sup id=mailcheck style="color:red"></sup><br>
Owner: <br><input type="text" name="owner"><br>
<button type="submit" class="btn">Submit</button>


</form>
</div>
<?php include 'footer.php'; ?>