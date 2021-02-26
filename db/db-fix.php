 <?php

	// debugging
function debug($debugdata) {
//	try { @$_SESSION['debugDATA'] .= $debugdata; }
//	catch (Exception $dx) { $_SESSION['debugDATA'] = $debugdata; }
}

	// database / queries
function Q($query){ // Global query (result = mysql_result OR false if (0 rows OR error))
	global $reqDebug;
	$q = mysql_query($query) or debug(mysql_error()." in QUERY=".$query."<br/>");
	if ($q) {
		try { if (@mysql_num_rows($q) == 0) $q = false; }
		catch (Exception $exc) { 
			debug("Failed.  Exception: ".$exc." in QUERY=".$query."<br/>");
			try { 
//				mysql_query("INSERT INTO Errors (err_session, err_details) VALUES ('".session_id()."','".mysql_real_escape_string($query)."');");
			} catch (Execption $exxc) { debug("Could not record in error log!<br/>"); }
		}
	} else debug("Failed query =".$query."<br/>");
	return $q;
}

function QV($query) { // Query get single value or NULL
	global $reqDebug;
	$qv = Q($query);
	if ($qv) {
		if (mysql_num_rows($qv)>0) {
			$datrow = mysql_fetch_row($qv);
			debug('Fetched Row Value:'.$datrow[0].'<br/>');
			return $datrow[0];
		} else return null;
	} else return null;
}

function Q2R($queryObject) { // Query string or object to row (array) or false
	global $reqDebug;
	if (gettype($queryObject)=="resource" && $queryObject != false) return mysql_fetch_assoc($queryObject);
	else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		if ($realQueryObject) return mysql_fetch_assoc($realQueryObject);
		else return false;
	}
}

function Q2T($queryObject) { // Query string or object to table (array of array) or false
	$dataOut = array();
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		while ($datRow = mysql_fetch_assoc($queryObject)) array_push($dataOut, $datRow);
		return $dataOut;
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		if ($realQueryObject) {
			while ($datRow = mysql_fetch_assoc($realQueryObject)) array_push($dataOut, $datRow);
			//while ($datRow = mysql_unbuffered_query($realQueryObject)) array_push($dataOut, $datRow);
			return $dataOut;
		}
		else return false;
	}
}

function QI($queryString) { // Insert and safely return id or false
	global $reqDebug;
	$qO = mysql_query($queryString);
	if ( $qO != false ) return mysql_insert_id();
	else return false;
}

function QU($queryObject) {
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		return mysql_affected_rows();
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		return mysql_affected_rows();
	}
	return false;
}


// Database
//DEMO
/*
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";
*/

//DEV
//$server="localhost";
//$db="cccsol81_bc2dev";
//$user="cccsol81_bc2dev";
//$password="bc2dev.ccc818";


//bc2prod
/**/
$server="localhost";
$db="cccsol81_bc2prod";
$user="cccsol81_bc2prod";
$password="bc2prod.ccc818";



mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
mysql_select_db($db) or die('Could not select the specified database.');


$usrData = Q2T("SELECT fed_id, sam_id, usr_id, usr_addr, usr_addr1, usr_addr2, usr_addr3, usr_city, usr_state, usr_zip, usr_country, usr_phone, usr_phone2, usr_fax FROM usr WHERE usr_auth <> 9");

if ($usrData) 
{
    foreach($usrData as $usr) 
    {

        //echo $usr['usr_id'];
	    //exit();
	    
	    $updContact = "Update usr_emp set usremp_addr='".$usr['usr_addr']."',usremp_addr1='".$usr['usr_addr1']."',usremp_addr2='".$usr['usr_addr2']."',usremp_addr3='".$usr['usr_addr3']."',
	                    usremp_city='".$usr['usr_city']."',usremp_state='".$usr['usr_state']."',usremp_zip='".$usr['usr_zip']."',usremp_country='".$usr['usr_country']."',usremp_phone='".$usr['usr_phone']."',
	                    usremp_phone2='".$usr['usr_phone2']."',usremp_fax='".$usr['usr_fax']."' WHERE usremp_usr_id = ".$usr['usr_id'];

	   $status = Q($updContact);

        $cnt += 1;	    
    }
}
echo $cnt . "<br>";
echo "<br>I am done";
?>



