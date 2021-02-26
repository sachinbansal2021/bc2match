<?php
if (!defined('C3cms')) die('');
define('C3cmsCore', 1);
// Initiliaztion ---------------------------------------------------------------------
	// Variables
	
//lloyd contact us
$my_pagename = basename($_SERVER['PHP_SELF']);
//echo (" $my_pagename" . $my_pagename  . " - " . basename($_SERVER['PHP_SELF']) );
	$corefindme   = 'contactus';
    $corepos = strpos($my_pagename , $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($corepos === false) {
   // echo "The string '$findme' was not found in the string '$my_pagename'";
   $_SESSION['contactus'] = 0;
} else {
   // echo "The string '$findme' was found in the string '$mystring'";
   //  echo " and exists at position $pos";
  // So contactus is the page
  $corepos = 1;
   $_SESSION['contactus'] = 1;
}
//echo ("<br>from core line 25  $ _ SESSION [ contactus]: " .  $_SESSION['contactus']);

$siteTmpPath = '/home/cccsol818/tmp/';
$buffer = ''; $content = ''; $reqDebug = ''; 
$headerScript = ''; $footerScript = ''; $scriptLinks = '';
$adminNav=''; $nav1=''; $nav2='';
$cssInline=''; $cssLinks='';
//$sessionPath = '/home/upojobco/tmp';
	// Session
//session_save_path($sessionPath);
//ini_set('session.gc_maxlifetime',28800); // 8 hours (in seconds) [default 1440 == 24 minutes]
//ini_set('session.gc_probability',1);
//ini_set('session.gc_divisor',1);
//if (!isset($_SESSION['usr_id'])) 
	

session_start();

/***************************
When moving from DEV to DEMO
1. Change ENVIRONMENT VARIABLES
2. Change Database Connection Info
***************************/

//$_SESSION['env'] = 'bc2dev';
$_SESSION['env'] = 'demo';

$siteWebRoot = 'http://www.bc2match.com/'.$_SESSION['env'].'/';
$siteFileRoot = '/home/cccsol818/public_html/'.$_SESSION['env'].'/';

//echo "webroot = ".$siteWebRoot."<br>fileroot = ".$siteFileRoot;


$activepage = $_REQUEST['page'] or $activepage = $_SESSION['sys_activepage'] or $activepage = '';


// Database
//DEMO
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";

//DEV
//$server="localhost";
//$db="cccsol81_bc2dev";
//$user="cccsol81_bc2dev";
//$password="bc2dev.ccc818";


mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
mysql_select_db($db) or die('Could not select the specified database.');

			
// Login --------------------------------------------------------------------
if (isset($_REQUEST['op'])) {
	if ($_REQUEST['op']=='login') {
		$query = "SELECT * FROM usr WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
		if ($result=mysql_query($query)) {
			if (mysql_num_rows($result)>0) {
				$row = mysql_fetch_array($result);
				$_SESSION['usr_id'] = $row['usr_id'];
				$_SESSION['usr_firstname'] = $row['usr_firstname'];
				$_SESSION['usr_lastname'] = $row['usr_lastname'];
				$_SESSION['usr_prefix'] = $row['usr_prefix'];
				$_SESSION['usr_auth'] = $row['usr_auth'];
				$_SESSION['usr_auth_orig'] = $row['usr_auth'];
				//echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
				$_SESSION['usr_company'] = $row['usr_company'];
				$_SESSION['usr_type'] = $row['usr_type'];
				//$_SESSION['admin_user'] = 0;
				if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_type'] == 99)) $_SESSION['admin_user'] = $_SESSION['usr_id'];
				//echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'];exit();
				$resultlogin = Q("UPDATE usr SET usr_lastlogin = '" . date('Y-m-d H:i:s') . "', usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id = '" . $_SESSION['usr_id'] . "';");	
				$_SESSION['u-search_results'] = 0;
				$_SESSION['newcompany'] = 0;
				switch($_SESSION['usr_auth']) {
					case "1": header("Refresh: 1; url=/".$_SESSION['env']."/applicants.php"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/employers"); die(); break;
					case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members.php"); die(); break;
					//case "1": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					case "3": header("Refresh: 1; url=/".$_SESSION['env']."/admin_app.php"); die(); break;
					case "4": header("Refresh: 1; url=/".$_SESSION['env']."/admin_rep.php"); die(); break;
					case "5": case "6": header("Refresh: 1; url=/".$_SESSION['env']."/admin_emp.php"); die(); break;
					case "7": case "8": header("Refresh: 1; url=/".$_SESSION['env']."/admin_usr.php"); die(); break;
					case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;
					//case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members"); die(); break;
				}
				
			} 
		} 
	}
} else  Q("UPDATE usr SET usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id = '" . $_SESSION['usr_id'] . "';");

if ($_REQUEST['ptype'] == 'dashboard') $_SESSION['usr_auth'] = 2;

if ($_REQUEST['ptype'] == 'admin') {
	if ($_SESSION['usr_type'] == 99)
		$_SESSION['usr_auth'] = 9;
	else		
		$_SESSION['usr_auth'] = 8;
}	

//echo "number 245555 --- ".$_SESSION['usr_auth'];
//exit();

// Security ---------------------------------------------------------------------
if (!isset($_SESSION['usr_id'])) { // get authorization level of user
	$_SESSION['usr_id'] = 0; $_SESSION['usr_auth'] = 0;
	$_SESSION['usr_firstname'] = "Public"; $_SESSION['usr_lastname'] = "Visitor";
}

//echo "I am here in Core 1";
if( $_SESSION['contactus'] == 1) {$_SESSION['usr_lastname'] = "Visitor";require($siteFileRoot.'inc/templates/contactus.php');}
if ($_SESSION['usr_auth'] == 1) require($siteFileRoot.'inc/applicant.php'); 
if ($_SESSION['usr_auth'] == 0) require($siteFileRoot.'inc/applicant.php'); // lloyd 10/1/18
//if ($_SESSION['usr_auth'] == 2) require($siteFileRoot.'inc/employer.php'); 
if ($_SESSION['usr_auth'] == 2) require($siteFileRoot.'inc/bc2member.php');
if ($_SESSION['usr_auth'] == 3) require($siteFileRoot.'inc/manager.php'); 
if ($_SESSION['usr_auth'] == 4) require($siteFileRoot.'inc/ceo.php'); 
if ($_SESSION['usr_auth'] == 5) require($siteFileRoot.'inc/developer.php'); 
if ($_SESSION['usr_auth'] == 6) require($siteFileRoot.'inc/administrator.php'); 
if ($_SESSION['usr_auth'] == 7) require($siteFileRoot.'inc/administrator.php'); 
if ($_SESSION['usr_auth'] == 8) require($siteFileRoot.'inc/administrator.php');
if ($_SESSION['usr_auth'] == 9) require($siteFileRoot.'inc/bc2_admin.php');
//if ($_SESSION['usr_auth'] == 9) require($siteFileRoot.'inc/bc2_admin.php');
if ($pageauth > $_SESSION['usr_auth']) { header("Refresh: 1; url=/".$_SESSION['env'].""); die(); }// terminate page if unathorized
if ($template != '') require $siteFileRoot."inc/templates/".$template.".php";

// Global Functions  ---------------------------------------------------------------------
	// security
function Clean($param,$length=false){ // escapes and optionally trims input
	if ($length!=false) return mysql_real_escape_string(substr($param, 0, $length));
	else return mysql_real_escape_string($param);
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

function DBContent($areaName = '', $areaSub = '') {
	global $content, $title, $footerScript;
	$footerScript .= ' $("#adminNav").append("<div onclick=\"editPage(\''.QV("SELECT rescon_id FROM res_content WHERE rescon_area = '".$title."' AND rescon_sub='".$areaSub."' ").'\');\" >Edit '.($areaSub==''?'Page':'\"'.$areaSub.'\"').'</div>");';
	if ($areaName == '') $areaName = $title;
	//return QV("SELECT rescon_content FROM res_content WHERE rescon_area='".$areaName."' AND rescon_sub='".$areaSub."' ");	
	$rescontent  = QV("SELECT rescon_content FROM res_content WHERE rescon_area='".$areaName."' AND rescon_sub='".$areaSub."' ");
//	echo ("rescon from DBContent: " .$rescontent);
	return $rescontent;	
}

function DropDown($id, $name, $dataTable, $inline = '', $selected = '') {
	$subBuffer = "<select id='".$id."' name='".$name."' ".$inline." >";
	foreach ($dataTable as $row) $subBuffer .= "<option ".($row['id']==$selected?'selected="selected"':'')." value='".$row['id']."'>".$row['label']."</option>";
	$subBuffer .= "</select>";
	return $subBuffer;
} 

function T2H($tableObject, $tableName = '', $tableExt = ''){
	global $content;
	$subbuffer = '<table '.($tableName==''?'':'id="'.$tableName.'"').' '.$tableExt.'>';
	$rowsubbuffer = '<tbody>'; $headerbuffer = '<thead><tr>'; $headerarray = array();
	if ($tableObject) foreach ($tableObject as $tRowK => $tRowV) {
		$rowsubbuffer .= '<tr id="'.$tableName.'_'.$tRowK.'">'; $tablerowcol = 0;
		foreach ($tRowV as $tCellK => $tCellV) { 
			$rowsubbuffer .= '<td id="'.$tableName.'_'.$tRowK.'_'.$tCellK.'">'.$tCellV.'</td>';
			$headerarray[$tablerowcol] = array();
			$headerarray[$tablerowcol]['col'] = $tCellK;
			$tablerowcol += 1;
		}
		$rowsubbuffer .= '</tr>';
	}
	if ($tableObject) foreach ($headerarray as $headerK => $headerV) $headerbuffer .= '<th>'.$headerV['col'].'</th>';
	$headerbuffer .= '</tr></thead>';
	$rowsubbuffer .= '</tbody>';
	$subbuffer .= $headerbuffer.$rowsubbuffer.'</table>';
	return $subbuffer;
}
function T2HR($tableObject, $tableName = '', $tableExt = ''){
	global $content;
	$subbuffer = '<table '.($tableName==''?'':'id="'.$tableName.'"').' '.$tableExt.'>';
	$rowsubbuffer = '<tbody>'; $headerbuffer = '<thead><tr style="background:#ffff00;">'; $headerarray = array();
	$toggle = true;
	if ($tableObject) foreach ($tableObject as $tRowK => $tRowV) {
		$rowsubbuffer .= '<tr id="'.$tableName.'_'.$tRowK.'" >'; $tablerowcol = 0;
		foreach ($tRowV as $tCellK => $tCellV) { 
			$rowsubbuffer .= '<td id="'.$tableName.'_'.$tRowK.'_'.$tCellK.'" style="'.($toggle?'background:#ffffff;':'background:#efefff;').'">'.$tCellV.'</td>';
			$headerarray[$tablerowcol] = array();
			$headerarray[$tablerowcol]['col'] = $tCellK;
			$tablerowcol += 1;
		}
		$toggle = !$toggle;
		$rowsubbuffer .= '</tr>';
	}
	if ($tableObject) foreach ($headerarray as $headerK => $headerV) $headerbuffer .= '<th style="background:#ffff00;">'.$headerV['col'].'</th>';
	$headerbuffer .= '</tr></thead>';
	$rowsubbuffer .= '</tbody>';
	$subbuffer .= $headerbuffer.$rowsubbuffer.'</table>';
	return $subbuffer;
}



//Matching Algorithms

/** Match - Applicants.php **/

function updateCertMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_usr_id = '".$userIdentity."' ");

	$q = "select group_concat(C.usrcrt_crt_id SEPARATOR ',') as 'x', 
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_certs C ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";
	$certReqs = Q2R($q);
	$buffer = '';
		if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>updCertUsr '.$userIdentity.' = '.$q.'<br/>'.print_r($certReqs,true); //$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
//find jobs with matching certs
	if ($certReqs) {
		// update existing matches
		$xq = "SELECT J.job_id as 'job', count(JC.jobcrt_crt_id) as 'certs', S.sysmat_id  as 'matchID' FROM job_certs JC
		LEFT JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."'
		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";

		// insert new matches
		$iq = "SELECT JC.jobcrt_job_id as 'job', count(JC.jobcrt_crt_id) as 'certs' FROM job_certs JC
		LEFT JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."')
		AND JC.jobcrt_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id=JC.jobcrt_job_id)
\		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";
	
		if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/>'.$xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);

		/*echo "q[ ".$q." ]<br><br>";
		echo "xq[ ".$xq." ]<br><br>";
		echo "iq[ ".$iq." ]<br><br>";
		exit();	*/	
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			/*if ($matchRow['job'] == '74'){
			echo '(updateMatches for - ['.$matchRow['job'].') - job = ['.$job_union['edu'].' and mem ['.$certReqs['edu'].']'; exit();}*/
			$union_logic = union_match($job_union['edu'], $certReqs['edu']); 
			if ($union_logic == '1'){			
			$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true).$q; 
			$did = Q($q);
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			/*if ($matchRow['job'] == '74'){
			echo '(newMatches - ['.$matchRow['job'].') - job = ['.$job_union['edu'].' and mem ['.$certReqs['edu'].']'; exit();}*/
			$union_logic = union_match($job_union['edu'], $certReqs['edu']); 
			if ($union_logic == '1'){
			$q = "INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] user='.$userIdentity.', '.print_r($matchRow,true).$q;
			$did = Q($q);
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}


function updateSkillMatchesMP($userIdentity) {
	global $userID;
	//LARRYF
	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_skills C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";
	
		//echo "q[ ".$q." ]<br><br>";
		//exit();
	
	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_skills JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_skills JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

		//echo "q[ ".$q." ]<br><br>";
		//echo "xq[ ".$xq." ]<br><br>";
		//echo "iq[ ".$iq." ]<br><br>";
		//exit();
		
		
		
		if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}


function updateAgencyMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usragen_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_agencies C ON A.usrapp_usr_id=C.usragen_usr_id 
	WHERE C.usragen_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
	
	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_agencies JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_agencies JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
				if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 	
			if ($union_logic == '1'){			
				if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}

	}
	deleteOldMatches();
	return $buffer;
}


function updateFunctionMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_functions='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$q = "SELECT group_concat(C.usrexpfnc_fnc_id SEPARATOR ',') as 'x', 
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A 
	LEFT JOIN usr_exp E ON E.usrexp_usr_id = A.usrapp_usr_id
	LEFT JOIN usr_exp_func C ON C.usrexpfnc_usrexp_id = E.usrexp_id 
	WHERE C.usrexpfnc_fnc_id > 0 AND A.usrapp_usr_id = '" . $userIdentity . "' 
	GROUP BY A.usrapp_usr_id";
	$funcReqs = Q2R($q);
	$buffer = ''; 
	if ($funcReqs) {
		if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>'.$q.'<br/>'.print_r($funcReqs,true).'<hr/>';
	
		$xq = "SELECT J.job_id as 'job', count(JF.jobfnc_fnc_id) as 'funcs', S.sysmat_id as 'matchID' FROM job_func JF 
	LEFT JOIN job J ON J.job_id = JF.jobfnc_job_id
	LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id 
	LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
	WHERE JF.jobfnc_fnc_id IN (".$funcReqs['x'].") 
	AND S.sysmat_usr_id = '".$userIdentity."' 
	AND J.job_edu_level <= '".$funcReqs['edu']."' 
	AND N.catclr_rank <= '".$funcReqs['clr']."'
	GROUP BY JF.jobfnc_job_id";

		$iq = "SELECT JF.jobfnc_job_id as 'job', count(JF.jobfnc_fnc_id) as 'funcs' FROM job_func JF 
	LEFT JOIN job J ON J.job_id = JF.jobfnc_job_id
	LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
	WHERE JF.jobfnc_fnc_id IN (".$funcReqs['x'].")
	AND JF.jobfnc_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JF.jobfnc_job_id)
	AND J.job_edu_level <= '".$funcReqs['edu']."' 
	AND N.catclr_rank <= '".$funcReqs['clr']."'
	GROUP BY JF.jobfnc_job_id";
	
		if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>' . $iq . '<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);

		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_functions = '".$matchRow['funcs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] '.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_functions, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['funcs']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateProflicMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_proflics='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_proflics C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

		
	if ($skillReqs) {
		
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_proflics JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		
	//print "[ ".$skillReqs['x']." ][ ".$skillReqs['edu']." ][ ".$skillReqs['clr']." ]";
	//exit();
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_proflics JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	
			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_proflics = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){		
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_proflics, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateGeoMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_geos C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
	
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
		$stateID = Q2T("SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].")");
		
		//echo "[ SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].") ]<br>"; exit();
		
		if ($stateID) {
			foreach ($stateID as $row) {
							
				$all = Q2T("SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."'");
				
				//echo "[ SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."' ]<br>"; exit();
				
				if ($all){
					foreach ($all as $id) {
						$stateAbbr = substr($id['catskl_label'],0,2);
						if ($id['catskl_all_ind'] == 1) {
							//$stateAbbr = substr($id['catskl_label'],0,2);
							$stateReqs = Q2R("SELECT group_concat(catskl_id SEPARATOR ',') as 'x' FROM cat_geos WHERE catskl_label like '".$stateAbbr."-%'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];

						}
						else{
							$stateReqs = Q2R("SELECT catskl_id FROM cat_geos WHERE catskl_label = '".$stateAbbr."-ALL'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['catskl_id'];							
						}
					}
				}
			}			
		}
				
		//echo "SkillReq[ ".$skillReqs['x']." ]<br>";
		//echo "StateReq[ ".$stateReqs['x']." ]<br>";
		//$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];
		//echo "[ ".$skillReqs['x']." ]<br>";
		//exit();
		
		

	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_geos JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_geos JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	
			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){		
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateVehiclesMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_vehicles='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_vehicles C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

		
	if ($skillReqs) {
		
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_vehicles JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		
	//print "[ ".$skillReqs['x']." ][ ".$skillReqs['edu']." ][ ".$skillReqs['clr']." ]";
	//exit();
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_vehicles JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	
			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_vehicles = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){		
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_vehicles, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}

/** Match - Employers.php **/

function updateCertMatchesJP($jobID) {
	global $userID;
		
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "select group_concat(C.jobcrt_crt_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' from job_certs C
	LEFT JOIN job J ON J.job_id = C.jobcrt_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank 
	WHERE C.jobcrt_crt_id > 0 AND C.jobcrt_job_id = '".$jobID."' GROUP BY C.jobcrt_job_id";
	$certReqs = Q2R($q);

	$buffer = '';
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.print_r($certReqs,true); //$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
	
	// update existing matches
	//	AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$xq = "SELECT C.usrcrt_usr_id as 'usr', count(C.usrcrt_crt_id) as 'certs', S.sysmat_id as 'matchID' FROM usr_certs C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrcrt_usr_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id";

	// insert new matches
	// AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$iq = "SELECT C.usrcrt_usr_id as 'usr', count(C.usrcrt_crt_id) as 'certs' FROM usr_certs C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0
	AND C.usrcrt_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id=C.usrcrt_usr_id)	
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id";

	/*echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit();*/
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($certReqs?$xq . '<hr/>'.$iq.'<hr/>':"");
	$updateMatches = Q2T($xq);
	$newMatches = Q2T($iq);

		
	if ($updateMatches) foreach ($updateMatches as $matchRow) {
		if ($matchRow['usr'] <> $userID){
		$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
		$union_logic = union_match($certReqs['edu'], $usr_app_union['edu']);
		if ($union_logic == '1'){		
		$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
		if (isset($_REQUEST['jobMatches'])) $buffer .= 'new'.print_r($matchRow,true).$q; 
		$did = Q($q);
		}
		}
	}
	if ($newMatches) foreach ($newMatches as $matchRow) {
		if ($matchRow['usr'] <> $userID){
		$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
		$union_logic = union_match($certReqs['edu'], $usr_app_union['edu']);
		if ($union_logic == '1'){		
		$q = "INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
		if (isset($_REQUEST['jobMatches'])) $buffer .= 'upd'.print_r($matchRow,true).$q;
		$did = Q($q);
		}
		}
	}

	deleteOldMatches();
	return $buffer;
}
//**************************
function updateSkillMatchesJPOLD($jobID) {
	global $userID;

	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_skills C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);
	
	//echo $q;
	//exit();

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM usr_skills C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills' FROM usr_skills C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	/* echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit(); */
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}



//***************************


function updateSkillMatchesJP($jobID) {
	global $userID;

	
	//Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_job_id = '".$jobID."' ");
	
	
	//Check for deleted NAICS
	$q = "Select job_delete_id, job_delete_jobid, job_delete_naics from job_delete where job_delete_jobid = '".$jobID."'";
	
	$del_naics = Q2T($q);
	
	if ($del_naics) {
		
		foreach ($del_naics as $matchRow){
				$q = "select usrskl_usr_id from usr_skills where usrskl_skl_id = '".$matchRow['job_delete_naics']."'";
				$find_usr = Q2T($q);
				
				if ($find_usr) {
					foreach ($find_usr as $usrRow){
						$skill_match = Q2T("SELECT sysmat_skills, sysmat_certifications FROM sys_match WHERE sysmat_usr_id = '".$usrRow['usrskl_usr_id']."' and sysmat_job_id ='".$matchRow['job_delete_jobid']."' ");
						
						if ($skill_match) {
							foreach($skill_match as $skillRow)
							{
								$skill_cnt = $skillRow['sysmat_skills'];
								$certs_cnt = $skillRow['sysmat_certifications'];
								
								if ($skill_cnt > 0) {
									//echo $skill_cnt." user=".$usrRow['usrskl_usr_id']." certs: ".$certs_cnt."<br>";				
									$skill_cnt = $skillRow['sysmat_skills'] - 1;
									//echo $skill_cnt." user=".$usrRow['usrskl_usr_id']."<br>";
						
									$did = Q("UPDATE sys_match SET sysmat_skills = '".$skill_cnt."' WHERE sysmat_usr_id = '".$usrRow['usrskl_usr_id']."' and sysmat_job_id ='".$matchRow['job_delete_jobid']."' ");
								}
							}
						}
					}
				}
		}
		
		//Remove 
		//echo "removing row from delete table<br>";
		$q = "Delete from job_delete where job_delete_id ='".$matchRow['job_delete_id']."'";
		$did = Q($q);
		//exit();
	}
	
	//echo "No Delete Changes";

	
	
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_skills C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' and jobskl_status = '0' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);
	
	
	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM usr_skills C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills' FROM usr_skills C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	/* echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit(); */
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$skill_cnt = QV("SELECT sysmat_skills FROM sys_match WHERE sysmat_id = '".$matchRow['matchID']."' ");
				$skill_cnt = $skill_cnt + $matchRow['skills'];
				$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
				//echo "update sys_match - skill cnt = [ ".$skill_cnt." ] [".$matchRow['matchID']."]<br>";
				$did = Q("Update job_skills SET jobskl_status = 1 where jobskl_job_id = '".$jobID."'");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
				//echo "insert into sys_match - skill cnt = [ ".$matchRow['skills']." ] [".$matchRow['matchID']."]<br>";
				$did = Q("Update job_skills SET jobskl_status = 1 where jobskl_job_id = '".$jobID."'");
			}
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateAgencyMatchesJP($jobID) {
	global $userID;
	
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_agencies C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usragen_usr_id as 'usr', count(C.usragen_skl_id) as 'agencies', S.sysmat_id as 'matchID' FROM usr_agencies C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usragen_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id";

	// 	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
	
		$iq = "SELECT C.usragen_usr_id as 'usr', count(C.usragen_skl_id) as 'agencies' FROM usr_agencies C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND C.usragen_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usragen_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id";
	
	/*
    echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit();
*/
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']); 
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['agencies']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['agencies']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateProflicMatchesJP($jobID) {
	global $userID;

			
	Q("UPDATE sys_match SET sysmat_proflics='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_proflics C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'proflics', S.sysmat_id as 'matchID' FROM usr_proflics C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'proflics' FROM usr_proflics C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_proflics = '".$matchRow['proflics']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 		
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_proflics, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['proflics']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}

	deleteOldMatches();
	return $buffer;
}

function updateGeoMatchesJP($jobID) {
	global $userID;
		
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_geos C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	
	//echo "[ ".$q." ]"; exit();
	
	$skillReqs = Q2R($q);
	
	
	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
		$stateID = Q2T("SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].")");
		
		//echo "[ SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].") ]<br>"; exit();
		
		if ($stateID) {
			foreach ($stateID as $row) {
							
				$all = Q2T("SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."'");
				
				//echo "[ SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."' ]<br>"; exit();
				
				if ($all){
					foreach ($all as $id) {
						$stateAbbr = substr($id['catskl_label'],0,2);
						if ($id['catskl_all_ind'] == 1) {
							//$stateAbbr = substr($id['catskl_label'],0,2);
							$stateReqs = Q2R("SELECT group_concat(catskl_id SEPARATOR ',') as 'x' FROM cat_geos WHERE catskl_label like '".$stateAbbr."-%'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];

						}
						else{
							$stateReqs = Q2R("SELECT catskl_id FROM cat_geos WHERE catskl_label = '".$stateAbbr."-ALL'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['catskl_id'];							
						}
					}
				}
			}			
		}
				
		//echo "[ ".$skillReqs['x']." ]<br>";
		//echo "[ ".$stateReqs['x']." ]<br>";
		//$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];
		//echo "[ ".$skillReqs['x']." ]<br>";
		//exit();


		//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'geos', S.sysmat_id as 'matchID' FROM usr_geos C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'geos' FROM usr_geos C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['geos']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['geos']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}

	deleteOldMatches();
	return $buffer;
}

function updateVehiclesMatchesJP($jobID) {
	global $userID;
		
	Q("UPDATE sys_match SET sysmat_vehicles='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_vehicles C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'vehicles', S.sysmat_id as 'matchID' FROM usr_vehicles C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'vehicles' FROM usr_vehicles C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_vehicles = '".$matchRow['vehicles']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 		
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_vehicles, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['vehicles']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
	deleteOldMatches();
	return $buffer;
}		



function updateFunctionMatchesJP($jobID) {
	Q("UPDATE sys_match SET sysmat_functions='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobfnc_fnc_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_func C 
	LEFT JOIN job J ON J.job_id = C.jobfnc_job_id LEFT JOIN cat_clearance L ON L.catclr_id = J.job_clearance
	WHERE C.jobfnc_fnc_id > 0 AND C.jobfnc_job_id = '" . $jobID . "' GROUP BY C.jobfnc_job_id";
	$funcReqs = Q2R($q);
	
	$buffer = ''; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($funcReqs?'<br/>'.print_r($funcReqs,true):'<br/>No Data.').'<hr/>';
	//	AND A.usrapp_ava_id = '".$funcReqs['ava']."'
	$xq = "SELECT E.usrexp_usr_id as 'usr', count(F.usrexpfnc_fnc_id) as 'funcs', S.sysmat_id as 'matchID' FROM usr_exp_func F 
	LEFT JOIN usr_exp E ON F.usrexpfnc_usrexp_id = E.usrexp_id
	LEFT JOIN sys_match S ON S.sysmat_usr_id = E.usrexp_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = E.usrexp_usr_id
	WHERE F.usrexpfnc_fnc_id IN (".$funcReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level >= '".$funcReqs['edu']."' 
	AND A.usrapp_clearance >= '".$funcReqs['clr']."'
	GROUP BY E.usrexp_usr_id";

	//	AND A.usrapp_ava_id = '".$funcReqs['ava']."'
	$iq = "SELECT E.usrexp_usr_id as 'usr', count(F.usrexpfnc_fnc_id) as 'funcs' FROM usr_exp_func F 
	LEFT JOIN usr_exp E ON F.usrexpfnc_usrexp_id = E.usrexp_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = E.usrexp_usr_id

	WHERE F.usrexpfnc_fnc_id IN (".$funcReqs['x'].")
	AND E.usrexp_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = E.usrexp_usr_id)
	AND A.usrapp_edu_level >= '".$funcReqs['edu']."' 
	AND A.usrapp_clearance >= '".$funcReqs['clr']."'
	GROUP BY E.usrexp_usr_id";
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($funcReqs?$xq . '<hr/>' . $iq . '<hr/>':'');
	$updateMatches = Q2T($xq);
	$newMatches = Q2T($iq);

	if ($updateMatches) foreach ($updateMatches as $matchRow) {
		if (isset($_REQUEST['jobMatches'])) $buffer .= print_r($matchRow,true); 
		$did = Q("UPDATE sys_match SET sysmat_functions = '".$matchRow['funcs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
	}
	if ($newMatches) foreach ($newMatches as $matchRow) {
		if (isset($_REQUEST['jobMatches'])) $buffer .= print_r($matchRow,true); 
		$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_functions, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['funcs']."','".date("Y-m-d H:i:s")."','1')");
	}
	deleteOldMatches();
	return $buffer;

}

function deleteOldMatches(){
	Q("DELETE FROM sys_match WHERE (sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
}

function union_match($job_union,$mem_union){
	$SEL_EITHER = 0;
	$SEL_NON_UNION = 1;
	$SEL_UNION = 2;
	
	$union_logic = '1';
		
	if (($mem_union == $SEL_UNION) and ($job_union == $SEL_NON_UNION))
		$union_logic = "0";	
			
	if (($mem_union == $SEL_NON_UNION) and ($job_union == $SEL_UNION))
		$union_logic = "0";
	
/*	if (($mem_union == $SEL_EITHER) or ($job_union == $SEL_EITHER))
		$union_logic = "1";	
*/	
	

	return $union_logic;
}



?>
