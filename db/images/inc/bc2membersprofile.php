<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Member Profile";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$template = "jobcon"; 
$response = "content"; 
require "inc/core.php";
//require_once('tcpdf/tcpdf.php');

//-- define content -----------------------------------------------------------------


$userID = 0;
$userType = $_SESSION['usr_type'];
$userCompany = 0;

if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; 

$_SESSION['view_id'] = $userID;

//echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'].'<br><br>';

$userCompany = $_SESSION['usr_company'];

//echo $userCompany.' - '.$userType;exit();



//echo $_SESSION['usr_auth'];
//exit();

if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_emp.php\';\" >Return to Employers List</div>");';

$empSection=@$_REQUEST['empSection'] or $empSection=@$_SESSION['empSection'] or $empSection="pst"; $_SESSION['empSection']=$empSection;

//$content .= "!!!!" . $empSection . "!!!!" . print_r($_REQUEST,true). print_r($_SESSION,true);

$opRec = CleanI($_REQUEST['rec']);
$empID = QV("SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'");


$content .= DBContent();


$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".CleanI($_REQUEST['profileID'])."'");
$RuserID = CleanI($_REQUEST['profileID']);

if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/bc2dev/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}

//$content .= '<br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="555" align="center">
<tbody>
<tr>
<td><a href="/bc2dev/bc2members.php?usr='.$userID.'">Return to Dashboard</a></td>';

$userPrimary = '';

//echo $userCompany.' - '.$userType;exit();

//echo 'userType [ '. $userType . ' ] <br>';
//echo 'usrData [ '. $usrData['usr_type'] . ' ]';
//exit();

/*
if ($usrData['usr_type'] == 0) {
	//$_SESSION['usr_auth'] = 8;
	$userPrimary = '<td><a href="/bc2dev/admin_usr.php?usr='.$userID.'&ptype=admin">Manage Account</a></td>';
}
*/

$content .= $userPrimary.$systemAdmin.'</tr>
</tbody>
</table>
</div>';

$union = QV("SELECT C.catedu_text FROM cat_edu C LEFT JOIN usr_edu U ON U.usredu_edu_id = C.catedu_id WHERE U.usredu_usr_id ='".$RuserID."' ");
$clr = QV("SELECT usrclr_title from usr_clearance where usrclr_usr_id = '".$RuserID."' ");

$content .= '<div><h2 style="text-align: center;"><span style="background-color: #ffffff;"><strong>Member Profile</strong></span></h2>';
$content .= '<br><div style="text-align:center;"><strong>Name: </strong>' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';

$content .= '<center><table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="2" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>&nbsp;</strong></td>
</tr>
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>';
$content .='
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Union/Non-Union:</strong> '.$union.'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Security Clearance:</strong> '.$clr.'</td></tr>';

$content .='
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br></center>';



$content .='<center><div> ';
$prows = 160;

//Naics:
$sklData = Q2T("SELECT U.*, C.* FROM usr_skills U LEFT JOIN cat_skills C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' ");
$sklcnt = QV("select count(*) as cnt FROM usr_skills WHERE usrskl_usr_id = '".$RuserID."' ");
$scrollit = $sklcnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;

/***bgcolor="#808080"***/
$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>NAICS [ '.$sklcnt.' ]</strong></td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
$num = 0;
if ($sklData) {
	foreach ($sklData as $pd){ $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;".$pd['usrskl_title']."<br>"; }
}
else
		$content .= "&nbsp;No NAICS codes selected";
		
$content .='	
</div>
</td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';


//Agencies:
$agenciesData = Q2T("SELECT U.*, C.* FROM usr_agencies U LEFT JOIN cat_agencies C ON C.catagen_id = U.usragen_skl_id WHERE U.usragen_usr_id = '".$RuserID."' ");
$agencnt = QV("select count(*) as cnt FROM usr_agencies WHERE usragen_usr_id = '".$RuserID."' ");

$scrollit = $agencnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;

$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Agencies [ '.$agencnt.' ]</strong></td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
$num = 0;
if ($agenciesData) {
	foreach ($agenciesData as $pd){ $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;".$pd['usragen_title']."<br>"; }
}
else
		$content .= "&nbsp;No Agencies selected";
		
$content .='	
</div>
</td>
</tr><tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';


//Vehicles:
$vehiclesData = Q2T("SELECT U.*, C.* FROM usr_vehicles U LEFT JOIN cat_vehicles C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' ");

$vehcnt = QV("select count(*) as cnt FROM usr_vehicles WHERE usrskl_usr_id = '".$RuserID."' ");

$scrollit = $vehcnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;



$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Vehicles [ '.$vehcnt.' ]</strong></td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
$num = 0;
if ($vehiclesData) {
	foreach ($vehiclesData as $pd){ $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;".$pd['usrskl_title']."<br>"; }
}
else
		$content .= "&nbsp;No Vehicles selected";
		
$content .='	
</div>
</td>
</tr><tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';

//Licenses:

$proflicsData = Q2T("SELECT U.*, C.* FROM usr_proflics U LEFT JOIN cat_proflics C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' ");

$proflicscnt = QV("select count(*) as cnt FROM usr_proflics WHERE usrskl_usr_id = '".$RuserID."' ");

$scrollit = $proflicscnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;


$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Licenses [ '.$proflicscnt.' ]</strong></td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
$num = 0;
if ($proflicsData) {
	foreach ($proflicsData as $pd){ $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;".$pd['usrskl_title']."<br>"; }
}
else
		$content .= "&nbsp;No Licenses selected";
		
$content .='	
</div>
</td>
</tr><tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';

//Certs:
$crtData = Q2T("SELECT U.*, C.* FROM usr_certs U LEFT JOIN cat_certs C ON C.catcrt_id = U.usrcrt_crt_id WHERE U.usrcrt_usr_id = '".$RuserID."' ");

$crtcnt = QV("select count(*) as cnt FROM usr_certs WHERE usrcrt_usr_id = '".$RuserID."' ");

$scrollit = $crtcnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;

$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Certs [ '.$crtcnt.' ]</strong></td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
$num = 0;
if ($crtData) {
	foreach ($crtData as $pd){ $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;".$pd['usrcrt_title']."<br>"; } 
}
else
		$content .= "&nbsp;No Certifications selected";
		
$content .='	
</div>
</td>
</tr><tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';

//Places:
$geoData = Q2T("SELECT U.*, C.* FROM usr_geos U LEFT JOIN cat_geos C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' ");

$geocnt = QV("select count(*) as cnt FROM usr_proflics WHERE usrskl_usr_id = '".$RuserID."' ");

$scrollit = $geocnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;
	
	
$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Places [ '.$geocnt.' ]</strong></td>
</tr>
<tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
$num = 0;
if ($geoData) {
	foreach ($geoData as $pd){ $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;".$pd['usrskl_title']."<br>"; }
}
else
		$content .= "&nbsp;No Places selected";
		
$content .='	
</div>
</td>
</tr><tr><td width="990" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';



$content .='</div></center> ';
$content .= '</div>';

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

function getPosts() {
	global $userID,$empID;
	return Q2T("SELECT J.* FROM job J WHERE J.job_emp_id = '".$userID."' ORDER BY J.job_submitted_date ");
}

function getMatches($id) {
	global $userID;

	//clear match table
	
	Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'"); 
	
	//rerun match routines
	updateCertMatchesJP($id);
	updateSkillMatchesJP($id);
	updateAgencyMatchesJP($id);
	updateProflicMatchesJP($id);
	updateGeoMatchesJP($id);
	updateVehiclesMatchesJP($id);	
		
	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC");
}

function getUSRMatches() {
    global $userID;

	/* Matching */
		updateSkillMatchesMP($userID); 
		updateCertMatchesMP($userID); 
		updateFunctionMatchesMP($userID); 
		updateAgencyMatchesMP($userID); 
		updateProflicMatchesMP($userID);
		updateVehiclesMatchesMP($userID);
		updateGeoMatchesMP($userID);
/* End Matching */
	
	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE U.usr_id ='".$userID."' ORDER BY sum DESC");
}

function getJobInfo($id) {
	return Q2T("SELECT J.* FROM job J WHERE J.job_id ='".$id."' ORDER BY J.job_submitted_date");
}

function getRating($id) {
	return Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_certs where jobcrt_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_skills where jobskl_job_id ='".$id."'");
}
