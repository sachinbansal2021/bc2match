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



$con = mysqli_connect($server, $user, $password, $db);
$conn = $con;


//$usrData = Q2T("SELECT fed_id, sam_id, usr_id, usr_addr, usr_addr1, usr_addr2, usr_addr3, usr_city, usr_state, usr_zip, usr_country, usr_phone, usr_phone2, usr_fax FROM usr WHERE usr_auth <> 9");

//$usrData = Q2T("SELECT UR.usr_id, UR.emp_id, usr_firstname, usr_lastname, usr_email, usr_phone FROM usr_emp_registration UR inner join usr U ON UR.usr_id = U.usr_id");

$usrData = Q2T("SELECT usr_id, emp_id FROM usr_emp_registration group by usr_id, emp_id");

$content = "<b>(*) denotes Regular Member</b><br><b>All others are Primary Members</b><br>";
$content .= "<table>";
$content .= "<tr>";
$content .= "<td><b>Company</b></td>";
$content .= "<td><b>First Name</b></td>";
$content .= "<td><b>Last Name</b></td>";
$content .= "<td><b>Email</b></td>";
$content .= "<td><b>Phone</b></td>";
$content .= "<td><b>NAICS</b></td>";
$content .= "<td><b>CERTS</b></td>";
$content .= "<td><b>AGENCIES</b></td>";
$content .= "<td><b>LOCATION</b></td>";
$content .= "<td><b>VEHICLES</b></td>";
$content .= "<td><b>Profile Complete %</b></td>";
$content .= "</tr>";

if ($usrData) 
{
    foreach($usrData as $usr_reg) 
    {


        $usrempData = Q2T("SELECT usremp_usr_id as usr_id, usremp_emp_id as emp_id, usremp_phone as phone FROM usr_emp where usremp_emp_id = ".$usr_reg['emp_id']);

        foreach($usrempData as $usr) 
        {
    
        $ccnt = 0;
        

        $agencies = QV("select count(*) from usr_agencies where usragen_usr_id = ".$usr['usr_id']." and usragen_emp_id = ".$usr['emp_id']);
        $certs = QV("select count(*) from usr_certs where usrcrt_usr_id = ".$usr['usr_id']." and usrcrt_emp_id = ".$usr['emp_id']);
        $skills = QV("select count(*) from usr_skills where usrskl_usr_id = ".$usr['usr_id']." and usrskl_emp_id = ".$usr['emp_id']);
        $geos = QV("select count(*) from usr_geos where usrskl_usr_id = ".$usr['usr_id']." and usrskl_emp_id = ".$usr['emp_id']);
        $vehicles = QV("select count(*) from usr_vehicles where usrskl_usr_id = ".$usr['usr_id']." and usrskl_emp_id = ".$usr['emp_id']);
        
        $usr_type = QV("select usr_type from usr where usr_id = ".$usr['usr_id']);
        
        if (($usr_type != 0) && ($usr_type != 99))
            $usr_type_display = "<b>*</b>";
        else
            $usr_type_display = "&nbsp;&nbsp;";
        
        $firstname = QV("select usr_firstname from usr where usr_id = ".$usr['usr_id']);
        $lastname = QV("select usr_lastname from usr where usr_id = ".$usr['usr_id']);
        $email = QV("select usr_email from usr where usr_id = ".$usr['usr_id']);
        
    
        //$phone = QV("select usremp_phone from usr_emp where usremp_usr_id = ".$usr['usr_id']." and usremp_emp_id = ".$usr['emp_id']);  
        
        $phone = $usr['phone'];        
        $phone1 = $phone;
        
        if (strlen($phone) == 10)
        {
            $phone = substr($phone,0,3)."-".substr($phone,3,3)."-".substr($phone,6,4);
        }
        
        $company = QV("select emp_name from emp where emp_id = '".$usr['emp_id']."'");
        
/*        
        echo $agencies."-";
        echo $certs."-";
        echo $skills."-";
        echo $vehicles."-";
        echo $geos."<br>";
*/

        if ($agencies > 0) $ccnt = $ccnt + 1;
        if ($certs > 0) $ccnt = $ccnt + 1;
        if ($skills > 0) $ccnt = $ccnt + 1;
        if ($vehicles > 0) $ccnt = $ccnt + 1;
        if ($geos > 0) $ccnt = $ccnt + 1;
        
        $pctcomplete = $ccnt." of 5";
        
        
        $content .= "<tr>";
        $content .= "<td>".strtoupper($company)."</td>";
        $content .= "<td>".$usr_type_display.strtoupper($firstname)."</td>";
        $content .= "<td>".strtoupper($lastname)."</td>";
        $content .= "<td>".$email."</td>";
        $content .= "<td>".$phone."</td>";
        $content .= "<td>".$skills."</td>";
        $content .= "<td>".$certs."</td>";
        $content .= "<td>".$agencies."</td>";
        $content .= "<td>".$geos."</td>";
        $content .= "<td>".$vehicles."</td>";
        $content .= "<td>".$pctcomplete."</td>";
        $content .= "</tr>";
     

//	   $status = Q($updContact);
        }

    }
    
    $content .= "</table>";
    
    echo $content;
}
echo $cnt . "<br>";
echo "<br>I am done";
?>



