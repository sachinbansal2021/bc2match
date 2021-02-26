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


//$results = Q2T("SELECT sam_id, company_naics FROM `TABLE 43` WHERE sam_id between 1 and 2010");
//$results = Q2T("SELECT sam_id, company_naics FROM `a_sam2019` WHERE sam_id > 0");

//$results = Q2T("SELECT sam_id, GOVPOCEMAIL as email, Company, ADDR1, naicsstr as company_naics FROM `a_sam2019` where `GOVPOCEMAIL` = 'luis.seijido@akima.com'");

$results = Q2T("SELECT sam_id, GOVPOCEMAIL as email, Company, ADDR1, naicsstr as company_naics FROM `a_sam2019`");

$record_cnt = 0;

if ($results) {
	foreach ($results as $res){
		//$content .= "<br><br>sam_id [ ".$res['sam_id']." ] company_naics [ ".$res['company_naics']." ]<br><br>";
		
		$mynaics = explode("~", $res['company_naics']);
		
		$mynaics_cnt = count($mynaics);
		
		//$content .= "mynaics_cnt [ ".$mynaics_cnt." ]<br>Before:<br>";
		
		for ($x = 0; $x < $mynaics_cnt; $x++){
				//$content .= $mynaics[$x]."<br>";
				$mynaics[$x] = substr($mynaics[$x],0,6);
		}
		
		$mynaics_cnt = count($mynaics);
		
		//$content .= "mynaics_cnt [ ".$mynaics_cnt." ]<br>After:<br>";
		
		$uid_res = Q2T("select usr_id from usr where sam_id = '".$res['email']."'");
		
		if ($uid_res){
			foreach ($uid_res as $uidres) {
				$uid = $uidres['usr_id'];
			}
		}
		
		for ($x = 0; $x < $mynaics_cnt; $x++){
				//$content .= $mynaics[$x]."<br>";
				$naics_res = Q2T("SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."'");		
				//$content .= "SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."'";
				if ($naics_res){
					foreach ($naics_res as $naicsres) {
						$usrskl_usr_id = $uid;
						$usrskl_emp_id = QV("Select emp_id from emp where emp_email = '".$res['email']."' and emp_name = '".$res['Company']."' and emp_address = '".$res['ADDR1']."'");
						$usrskl_skl_id = $naicsres['catskl_id'];
						$usrskl_title = $naicsres['catskl_label'];
						$usrskl_comment = $naicsres['catskl_text'];
						
						//$content .= "catskl_id [ ".$naicsres['catskl_id']." ] catskl_label [ ".$naicsres['catskl_label']." ] <br>";

						//$content .= "Insert into usr_skills (usrskl_usr_id, usrskl_skl_id, usrskl_title, usrskl_comment) values ('".$usrskl_usr_id."','".$usrskl_skl_id."','".$usrskl_title."','".$usrskl_comment."')";
						
						$samsklid = QI("Insert into usr_skills_ADD (usrskl_usr_id, usrskl_emp_id, usrskl_skl_id, usrskl_title, usrskl_comment) values ('".$usrskl_usr_id."','".$usrskl_emp_id."','".$usrskl_skl_id."','".$usrskl_title."','".$usrskl_comment."')");
						
					}
				}
				else
					$content .= "Failed:  SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."' <br>\n";
		}
		
		$record_cnt = $record_cnt + 1;
		
		if ($record_cnt % 1000 == 0)
			$content .= "Total records processed [ ".$record_cnt." ]<br>\n";
			
		
	}
}

$content .= "<br>Processing Complete<br>Total records processed [ ".$record_cnt." ]";

//$myfile = fopen("sam_cert_Load.txt", "w") or die("Unable to open file!");
//fwrite($myfile, $content);
//fclose($myfile);

echo $content;




//******************
// Functions
//
//******************



?>