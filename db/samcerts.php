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

//$results = Q2T("SELECT sam_id, bustypstr FROM `a_sam2019` WHERE sam_id between 3247 and 4461");
//$results = Q2T("SELECT sam_id, bustypstr  FROM `a_sam2019` where `GOVPOCEMAIL` = 'abrown@tmamgroup.com'");
//$results = Q2T("SELECT A.sam_id, bustypstr, A.GOVPOCEMAIL as email FROM `a_sam2019` A inner join emp E ON E.emp_email = A.`GOVPOCEMAIL` and E.emp_name = A.`COMPANY` where A.`GOVPOCEMAIL` = 'luis.seijido@akima.com'");

//$results = Q2T("SELECT bustypstr, GOVPOCEMAIL as email, Company, ADDR1  FROM `a_sam2019` where `GOVPOCEMAIL` = 'luis.seijido@akima.com'");
//$results = Q2T("SELECT bustypstr, GOVPOCEMAIL as email, Company, ADDR1  FROM `a_sam2019`");
$results = Q2T("Select bus_type as bustypstr, sam_id from sam2021 where sam_id >= 200000");


$record_cnt = 0;

$runstarttime = date('Y-m-d H:i:s');

$content = "Cert Load Process Started<br>\n";
$content .= "Start time: ".$runstarttime."<br>\n";
$content .= "Total to process: [".COUNT($results)."]<br>\n<br>\n<br>\n";

echo $content;

$to = "larryf@bc2match.com";
$subject = "Started - SAM Cert Load [ ".date('m-d-Y')." ]";
$body = $content;
sendmail($subject, $body, $to);

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
		
		$usr_id = QV("SELECT u.usr_id FROM sam2021 s join usr u on s.sam_id = u.sam_id where s.sam_id = ".$res['sam_id']);
		$emp_id = QV("SELECT e.emp_id FROM sam2021 s join emp e on s.sam_id = e.sam_id where s.sam_id = ".$res['sam_id']);
		
		
	//echo "SELECT u.usr_id, e.emp_id FROM sam2021 s join usr u on s.sam_id = u.sam_id join emp e on s.sam_id = e.sam_id where s.sam_id = ".$res['sam_id'];

    		//echo "Select emp_id from emp where emp_email = '".$res['email']."' and emp_name = '".$res['Company']."' and emp_address = '".$res['ADDR1']."'<br>";
		
		    
		    //echo "Select usr_id, E.emp_id,'4','None' from usr U inner join emp E ON U.usr_email = E.emp_email where U.sam_id = 99899 and U.usr_email = '".$res['email']."'"; exit();
		
	    	//$content .= $res['sam_id'].",".$usr_id.",".$emp_id.",";
		
		    //$content .= $res['email'].",".$usr_id.",".$emp_id.",";

		    //echo $usr_id." --- ".$emp_id; exit();
		    
		    //echo $content;
		
		    for ($x = 0; $x < $mycerts_cnt; $x++)
		    {
				//echo $mycerts[$x]."-".$usr_id."-".$emp_id."<br>";
				
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

		$record_cnt = $record_cnt + 1;

	}
}

$content2 = "<br>\n<br>\nProcessing Complete<br>\n";
$content2 .="Total Count: [".$record_cnt."]<br>\n";
$runendtime = date('Y-m-d H:i:s');
$content2 .= "Start time: ".$runendtime."]<br>\n<br>\n<br>\n";

echo $content2;

$to = "larryf@bc2match.com";
$subject = "Finished - SAM Cert Load [ ".date('m-d-Y')." ]";
$body = $content.$content2;
sendmail($subject, $body, $to);



?>