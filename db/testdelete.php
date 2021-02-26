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


//DEMO
$parentpath = "/home/cccsol818/public_html/demo";

// Database
//DEMO
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";

mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
mysql_select_db($db) or die('Could not select the specified database.');


//$results = Q2T("SELECT sam_id, bustypstr FROM `a_sam2019` WHERE sam_id between 3247 and 4461");
$results = Q2T("SELECT sam_id, bustypstr  FROM `a_sam2019` WHERE sam_id > 0");
$record_cnt = 0;

$cnt53 = QV("Select count(*) as cnt from job_certs Where jobcrt_crt_id = 53");
echo "[".$cnt53."]";
$proc =  Q("DELETE FROM job_certs WHERE jobcrt_crt_id = 53");
$cnt53 = QV("Select count(*) as cnt from job_certs Where jobcrt_crt_id = 53");
echo "[".$cnt53."]";

exit();

$content .= "programming starting\n";

if ($results) {
	foreach ($results as $res){
		//$content .= "<br><br>sam_id [ ".$res['sam_id']." ] bustypstr [ ".$res['bustypstr']." ]<br><br>";
		
		$c37 = 0;
		$c44 = 0;
		$c45 = 0;
		$c47 = 0;
		
		$mycerts = explode("~", $res['bustypstr']);
		
		$mycerts_cnt = count($mycerts);
		
		//echo "mycerts_cnt: ".$mycerts_cnt."<br>";
		
		$usr_id = QV("select UE.usremp_usr_id from usr_emp UE inner join usr U on UE.usremp_usr_id = U.usr_id where sam_id = ".$res['sam_id']);
		$emp_id = QV("select UE.usremp_emp_id from usr_emp UE inner join usr U on UE.usremp_usr_id = U.usr_id where sam_id = ".$res['sam_id']);
		
		//$content .= $res['sam_id'].",".$usr_id.",".$emp_id.",";
		
		//echo $content;
		
		for ($x = 0; $x < $mycerts_cnt; $x++){
				
				
				switch ($mycerts[$x])
				{
				    case "27":
				    case "1D":
				    case "05":  if($c37 == 0){$sam_id = QI("INSERT INTO usr_certs_SAM2(usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','37','Small business','Small business','".$res['sam_id']."')"); $c37 = 1;}
				            break;

					case "8D":
					case "8E":	if($c37 == 0){$sam_id = QI("INSERT INTO usr_certs_SAM2(usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','37','Small business','Small business','".$res['sam_id']."')"); $c37 = 1;}

					            if($c45 == 0){$sam_id = QI("INSERT INTO usr_certs_SAM2 (usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','45','Economically-disadvantaged woman-owned small business -EDWOSB','Economically-disadvantaged woman-owned small business -EDWOSB','".$res['sam_id']."')");$c45 = 1;}

								if($c44 == 0){$sam_id = QI("INSERT INTO usr_certs_SAM2 (usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','44','Woman-owned small business (WOSB)','Woman-owned small business (WOSB)','".$res['sam_id']."')");$c44 = 1;}
							break;

					case "HQ":	if($c47 == 0) {$sam_id = QI("INSERT INTO usr_certs_SAM2 (usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','47','State-certified DBE small business','State-certified DBE small business','".$res['sam_id']."')"); $c47 = 1;}
							break;
						
					case "8C":
					case "8W":	if($c37 == 0){$sam_id = QI("INSERT INTO usr_certs_SAM2(usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','37','Small business','Small business','".$res['sam_id']."')"); $c37 = 1;}
					            if($c44 == 0){$sam_id = QI("INSERT INTO usr_certs_SAM2 (usrcrt_usr_id, usrcrt_emp_id, usrcrt_crt_id, usrcrt_title, usrcrt_comment, sam_id) VALUES ('".$usr_id."','".$emp_id."','44','Woman-owned small business (WOSB)','Woman-owned small business (WOSB)','".$res['sam_id']."')");$c44 = 1;}
							break;
						
					default:
					    //$content .= $mycerts[$x]."~";
						break;
				}				
		}
		
		$content .= "\n";
		
		$record_cnt = $record_cnt + 1;
		
		if ($record_cnt % 1000 == 0)
			$content .= "Total records processed [ ".$record_cnt." ]\n";
	}
}

$content .= "Processing Complete\n";
$content .="Total Count: ".$record_cnt;


$myfile = fopen("sam_cert_Load.txt", "w") or die("Unable to open file!");
fwrite($myfile, $content);
fclose($myfile);

//echo $content;




//******************
// Functions
//
//******************



?>