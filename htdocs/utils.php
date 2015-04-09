<?php
include '_secret/mysql_pass.php';

session_start();


$conn = mysql_connect($hostname, $username, $password) or die("Unable to connect to MySQL");
$db = mysql_select_db($database, $conn) or die("Could not select examples");

function redirect($url, $permanent = false) {
  if ($permanent) {
    header('HTTP/1.1 301 Moved Permanently');
  }
  header('Location: '.$url);
  exit();
}

function isAdmin() {
  return isset($_SESSION["auth"]);
}

function getCategoryOptions($catId, $nameprefix) {
  $options = "";
  $result = mysql_query("SELECT * FROM category WHERE id != -1 AND parent=".$catId);
  while($row = mysql_fetch_array($result)){
    $options .= "<option value='".$row['id']."'>".$nameprefix." ".$row['name']."</option>";
    $options .= getCategoryOptions($row['id'], $nameprefix." ".$row['name']." &gt; ");
  }

  return $options;
}

function buildCategorySelect($withAI, $name = 'drilldown') {
  $select = "<select class='drilldown' name='".$name."'><option value=''>-- Select Category --</option>";
  if($withAI) {
    $select.="<option value='0'>Artificial Intelligence</option>";
  }
  $select .= getCategoryOptions(0, "");
  $select .= "</select>";
  return $select;
}

function getSubCats($catId) {
  $subcats = array();

  $r = mysql_query("SELECT id FROM category WHERE parent=".$catId);
  while ($row = mysql_fetch_array($r)) {
    $subcats[] = $row{'id'};

    $subSubCats = getSubCats($row{'id'});

    foreach ($subSubCats as &$value) {
      $subcats[] = $value;
    }
  }

  $subcats = array_diff($subcats, array(-1));

  return $subcats;
}

function countResults($subcatString, $query) {
	$sqlStatmement = "SELECT count(*)
	  FROM resource r, resource_category rc,
	       resource_type rt, license_type lt,
	       significance_type st
	 WHERE rc.category_id IN ".$subcatString."
	   AND r.id=rc.resource_id 
	   AND r.approved_date is not null
	   AND r.resource_type=rt.id
	   AND r.license_type=lt.id
	   AND r.significance_type=st.id
	";
	if(!empty($query)) {
		$sqlStatmement.=" AND r.name like '%".$query."%'";
	}

	$r = mysql_query($sqlStatmement);
	$row = mysql_fetch_row($r);
	return $row[0];
}

/***************
 * Inserts user into user table if not exist.
 * Otherwise, just updates lastLogin time.
 * Returns user along with privilege level.
 **************/
function loginUser($response) {
  if( $response['auth']['info'] ) {
    $id = $response['auth']['uid'];
    $provider = $response['auth']['provider'];
    $now = date(DATE_ATOM );

    $user = new stdClass;
    $user->id = $id;
    $user->login_type = $provider;
    $user->name = $response['auth']['info']['name'];
    $user->image = $response['auth']['info']['image'];

    $r = mysql_query("SELECT * FROM user WHERE id = ".$id." AND login_type = '".$provider."'");
    if($row = mysql_fetch_array($r)) {
      // if exists, update it
      mysql_query("UPDATE user SET"
                  ." name = '".$user->name."', "
                  ." image_url = '".$user->image."', "
                  ." lastLogin = '".$now."'");
    } else {
      mysql_query("INSERT INTO user(id, login_type, name, image_url, privilege, lastLogin)"
                  ." VALUES('".$id."','".$provider."','".$user->name."','".$user->image."','user','".$now."')");
    }

    return $user;
  } else {
    return null;
  }
}

?>
