<?php

function Clean($param,$length=false) {     // escapes and optionally trims input
    global $conn;
	if ($length!=false)  return mysql_real_escape_string(substr($param, 0, $length)); 
	else  return mysqli_real_escape_string($conn, $param);        //
 }
 
 function CleanS($param){ // returns first space-delimited word (use with caution - very strict)
	$safe=explode(" ",$param);
	return Clean($safe[0]);
}


function CleanI($param){ // returns cleaned INT value
	return intval(CleanS($param));
}

function CleanJS($param) {
	return htmlspecialchars(addcslashes($param,"\\\'\"&\n\r<>"));
}


	// debugging
function debug($debugdata) {
//	try { @$_SESSION['debugDATA'] .= $debugdata; }
//	catch (Exception $dx) { $_SESSION['debugDATA'] = $debugdata; }
}

	// database / queries
function Q($query){ // Global query (result = mysql_result OR false if (0 rows OR error))
	global $reqDebug;
	global $conn;
	
	if ($query == "test") echo "Empty String: (".$query.")<br>";
	
	$q = mysqli_query($conn, $query) or debug(mysqli_error($conn)." in QUERY=".$query."<br/>");
	if ($q) {
		try { if (@mysqli_num_rows($q) == 0) $q = false; }
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
		if (mysqli_num_rows($qv)>0) {
			$datrow = mysqli_fetch_row($qv);
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
		if ($realQueryObject) return mysqli_fetch_assoc($realQueryObject);
		else return false;
	}
}

function Q2T($queryObject) { // Query string or object to table (array of array) or false
	$dataOut = array();
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		while ($datRow = mysqli_fetch_assoc($queryObject)) array_push($dataOut, $datRow);
		return $dataOut;
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		if ($realQueryObject) {
			while ($datRow = mysqli_fetch_assoc($realQueryObject)) array_push($dataOut, $datRow);
			//while ($datRow = mysql_unbuffered_query($realQueryObject)) array_push($dataOut, $datRow);
			return $dataOut;
		}
		else return false;
	}
}

function QI($queryString) { // Insert and safely return id or false
	global $reqDebug;
	global $conn;
	$qO = mysqli_query($conn, $queryString);
	if ( $qO != false ) return mysqli_insert_id($conn);
	else return false;
}

function QU($queryObject) {
    global $conn;
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		return mysqli_affected_rows($conn);
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		return mysqli_affected_rows($conn);
	}
	return false;
}



 
$runfrom = "BC2PROD";
echo "<br>\r\nStarting Vehicle LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n<br>\r\n" ;

//DEMO 
//$parentpath = "/home/cccsol818/public_html/bc2demo";

//DEV
//$parentpath = "/home/cccsol818/public_html/bc2dev";


// Database
//DEMO
/*
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";
*/

//DEV
/*
$server="localhost";
$db="cccsol81_bc2dev";
$user="cccsol81_bc2dev";
$password="bc2dev.ccc818";
*/

//bc2prod
/**/
$server="localhost";
$db="cccsol81_bc2prod";
$user="cccsol81_bc2prod";
$password="bc2prod.ccc818";



//mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
//mysql_select_db($db) or die('Could not select the specified database.');

$conn = mysqli_connect($server, $user, $password, $db) or die('Could not connect to the MySQL database server');


$vehicles = [];

$h = fopen("vehicle_update_sample.csv","r");

while (($data = fgetcsv($h, 1000,",")) !== FALSE)
{
    $vehicles[] = $data;
}

$num = count($vehicles);

//echo $num;

$co_cnt = 0;

for ($i=1; $i < $num; $i++)
{
    //echo "[".$vehicles[$i][0]."] - ";
    //echo "[".$vehicles[$i][1]."] - ";
    //echo "[".$vehicles[$i][2]."]<br>";
    
    $reccnt = $reccnt + 1;
    
    $v_code = $$vehicles[$i][0];
    $v_name = $vehicles[$i][1];
    $v_company = $vehicles[$i][2];
    $v_state = $vehicles[$i][3];
    
    $v_emp_id = QV("SELECT emp_id FROM emp WHERE emp_name = '".$v_company."'");
    
    $result = Q2T("SELECT usremp_usr_id FROM usr_emp WHERE usremp_emp_id = ".$v_emp_id);
    
    if ($result)
    {
        
        
        foreach ($result as $match)
        {
	        $v_usr_id = $match["usremp_usr_id"];
	    
	        /** check the vehicle table to see if this combo is in there **/
	        
	        $cnt = QV("SELECT count(*) as cnt FROM usr_vehicles WHERE usrskl_usr_id = ".$v_usr_id." and usrskl_emp_id = ".$v_emp_id." and usrskl_skl_id = 110");
	        
	        
	        if ($cnt == 0)
	        {
	            
	            //echo "INSERT INTO usr_vehicles (usrskl_usr_id, usrskl_emp_id, usrskl_skl_id, usrskl_title, usrskl_comment) VALUES ('".$v_usr_id."', '".$v_emp_id."', 110, 'CIO-SP3 Small Business','TEST')"; exit();	
	                $inres = QI("INSERT INTO usr_vehicles (usrskl_usr_id, usrskl_emp_id, usrskl_skl_id, usrskl_title, usrskl_comment) VALUES ('".$v_usr_id."', '".$v_emp_id."', 110, 'CIO-SP3 Small Business','TEST')");
                                    
	                echo "LOADED [".$v_company."] [".$v_emp_id."] [".$v_usr_id."] [".$v_state."] <br>";
	                $co_cnt = $co_cnt + 1;
	        }
	        else
	        {
	            echo "Row found <br>";
	        }
	        
        }
	 
    }
    else
    {
       echo "Not Loaded: ".$v_state."<br>"; 
    }
    
}

echo "Total Records Loaded: ".$co_cnt."<br>";
echo "Total Records in File: ".$reccnt."<br>";

fclose($h);
?>



