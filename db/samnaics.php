<?php

    require '/home/cccsol818/public_html/phpMailer/class.phpmailer.php';
    require '/home/cccsol818/public_html/phpMailer/class.smtp.php';
	
function sendmail($subject = null, $body = null, $to = null){
	$mail = new PHPMailer;
	$mail->setFrom('larryf@bc2match.com');
	$mail->addAddress($to);
    	$mail->isHTML(true); 
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->IsSMTP();
	$mail->SMTPSecure = 'starttls';
	$mail->Host = 'tls://smtp.office365.com';
	$mail->SMTPAuth = true;
	$mail->Port = 587;

	//Set your existing gmail address as user name
	$mail->Username = 'larryf@bc2match.com';
	//Set the password of your gmail address here
	$mail->Password = 'ljf$bc22021';
	if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	  echo '<br/>';
	} else { echo $to; echo '<br/>';
	  echo 'Email has been sent.';
	  echo '<br/>';
	}https://www.google.com/aclk?sa=l&ai=DChcSEwjX-r_ew-_tAhUB47MKHXYTBWcYABAPGgJxbg&sig=AOD64_1Q-fou0N3qBZ3N1za9XTh3Q4X0PQ&adurl=&ctype=5&q=&nb=9&rurl=https%3A%2F%2Fwww.bestbuy.com%2F&nm=69&nx=73&ny=78&is=1500x415	
}	


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


//DEMO
$parentpath = "/home/cccsol818/public_html/demo";

// Database
//DEMO
/*
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";
*/

//bc2test
/*
$server="localhost";
$db="cccsol81_bc2test";
$user="cccsol81_bc2test";
$password="bc2test.ccc818";
*/


//bc2prod
/* */
$server="localhost";
$db="cccsol81_bc2prod";
$user="cccsol81_bc2prod";
$password="bc2prod.ccc818";


$conn = mysqli_connect($server, $user, $password, $db) or die('Could not connect to the MySQL database server');


$results = Q2T("SELECT sam_id, naics as company_naics FROM sam2021 where sam_id >= 200000");

$record_cnt = 0;

$runstarttime = date('Y-m-d H:i:s');

$content = "NAICS Load Process Started<br>\n";
$content .= "Start time: ".$runstarttime."<br>\n";
$content .= "Total to process: [".COUNT($results)."]<br>\n<br>\n<br>\n";

echo $content;

$to = "larryf@bc2match.com";
$subject = "Started - SAM NAICS Load [ ".date('m-d-Y')." ]";
$body = $content;
sendmail($subject, $body, $to);


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
		
		$userID = QV("select usr_id from usr where sam_id = ".$res['sam_id']);
		$empID = QV("select emp_id from emp where sam_id = ".$res['sam_id']);
		
		//if ($uid_res){
		//	foreach ($uid_res as $uidres) {
		//		$uid = $uidres['usr_id'];
		//	}
		//}
		
		for ($x = 0; $x < $mynaics_cnt; $x++){
				//$content .= $mynaics[$x]."<br>";
				$naics_res = Q2T("SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."'");		
				//$content .= "SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."'";
				if ($naics_res){
					foreach ($naics_res as $naicsres) {
						$usrskl_usr_id = $userID;
						$usrskl_emp_id = $empID;
						$usrskl_skl_id = $naicsres['catskl_id'];
						$usrskl_title = $naicsres['catskl_label'];
						$usrskl_comment = $naicsres['catskl_text'];
						
						//$content .= "catskl_id [ ".$naicsres['catskl_id']." ] catskl_label [ ".$naicsres['catskl_label']." ] <br>";

						//$content .= "Insert into usr_skills (usrskl_usr_id, usrskl_skl_id, usrskl_title, usrskl_comment) values ('".$usrskl_usr_id."','".$usrskl_skl_id."','".$usrskl_title."','".$usrskl_comment."')";
						
						$samsklid = QI("Insert into usr_skills_SAM2 (usrskl_usr_id, usrskl_emp_id, usrskl_skl_id, usrskl_title, usrskl_comment, sam_id) values ('".$usrskl_usr_id."','".$usrskl_emp_id."','".$usrskl_skl_id."','".$usrskl_title."','".$usrskl_comment."','".$res['sam_id']."')");
						
					}
				}
				else
					$content .= "Failed:  SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."' <br>\n";
		}
		
		$record_cnt = $record_cnt + 1;
		
//		if ($record_cnt % 1000 == 0)
//			$content .= "Total records processed [ ".$record_cnt." ]<br>\n";
			
		
	}
}

$content2 = "<br>\n<br>\nProcessing Complete<br>\n";
$content2 .="Total Count: [".$record_cnt."]<br>\n";
$runendtime = date('Y-m-d H:i:s');
$content2 .= "Start time: ".$runendtime."]<br>\n<br>\n<br>\n";

echo $content2;

$to = "larryf@bc2match.com";
$subject = "Finished - SAM NAICS Load [ ".date('m-d-Y')." ]";
$body = $content.$content2;
sendmail($subject, $body, $to);




?>