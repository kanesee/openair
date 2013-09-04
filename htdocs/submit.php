<?php include 'header.php'; ?>
<?php include 'category.php'; ?>

<head>
	<title>Submit Entry</title>
</head>

<div id="right" class="span7" style="overflow-y:scroll;">
  <h2>Entry Details</h2>

<script>
function validate(){
	var pass = true;
	var fields = document.forms["form"];
	if(fields["drilldown"].value==""){
		pass = false;
		document.getElementById("catcheck").innerHTML=" *Required";
	}
	else
		document.getElementById("catcheck").innerHTML="";
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

Entry Name: <br><input type="text" name="dbname" required="required"><sup id="namecheck" style="color:red"></sup>
<br>Link to Entry Website (e.g. http://mahout.apache.org/): <br><input type="url" name="link" required="required"><sup id="linkcheck" style="color:red"></sup>
<br>Brief Description (2-5 sentences suggested): <br>
<textarea rows="11" wrap="virtual" name="description" required="required" style="width: 325px;"></textarea><sup id="disccheck" style="color:red"></sup>
<br>

<?php
// $con = mysqli_connect("ec2-54-243-13-79.compute-1.amazonaws.com","openai","theaiisclosed","openair");
// if (mysqli_connect_errno($con)){
// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
// }

echo "Entry Type:<br>";
$result = mysql_query("SELECT name FROM resource_type ORDER BY resource_type.order");
echo '<select name="resource" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysql_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select><sup id=resocheck style="color:red"></sup>';

echo "<br>License Type: <br>";
$result = mysql_query("SELECT name FROM license_type ORDER BY license_type.order");
echo '<select name="license" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysql_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select><sup id=licecheck style="color:red"></sup>';

echo "<br>Significance: <br>";
$result = mysql_query("SELECT name FROM significance_type ORDER BY significance_type.order");
echo '<select name="significance" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysql_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select><sup id=signcheck style="color:red"></sup>';

// BA ADDED CATEGORY
echo '<br>Category:<br>';
echo buildCategorySelect(false, "drilldown").'<sup id=catcheck style="color:red"></sup><br>';
?>
<br>
<div>
Owner (Creator, Developer, or Organization Responsible): <br><input type="text" name="owner"><br>
<hr>
Submitter's Name: <br><input type="text" name="submitter" required="required"><sup id=submcheck style="color:red"></sup><br>
Email: <br><input type="text" name="email" required="required"><sup id=mailcheck style="color:red"></sup><br>
<button type="submit" class="btn">Submit</button>

</form>
</div>

<script type="text/javascript">
  $('.drilldown').selectHierarchy({ hideOriginal: true });
</script>
<?php include 'footer.php'; ?>