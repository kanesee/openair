<?php include 'header.php'; ?>
<?php include 'category.php'; ?>
<div id="right" class="span7">
  <h2>Submit an entry</h2>
<html>
<body>
<form action="henry2.php" method="POST">
	
Resource Name: <br><input type="text" name="dbname" required="required"><br>
Link to data website: <br><input type="url" name="link" required="required"><br>
Short Description: <br>
<textarea cols="30" rows="5" wrap="virtual" name="description" required="required">
</textarea>
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
echo "</select>";

echo "<br>License Type: <br>";
$result = mysqli_query($con, "SELECT name FROM license_type");
echo '<select name="license" required="required">';
echo '<option value="" disabled="disabled" selected="selected">Select</option>';
while($row = mysqli_fetch_array($result)){
	echo '<option value = "' . $row['name'] . '">' . $row['name'] . '</option>';
}
echo '</select>';

mysqli_close($con);
?>

<br>
Submitter's Name: <br><input type="text" name="submitter" required="required"><br>
Email: <br><input type="text" name="email" required="required"><br>
Owner: <br><input type="text" name="owner"><br>
<input type="submit" value="Submit">

</form>
</div>
<?php include 'footer.php'; ?>
</body>
</html>