<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Job Profile";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
////$template = "jobcon"; 
$response = "content"; 
////require "inc/core.php";
$_SESSION['$usempempid'] = "";   ////"_empid";
$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
$template = "jobcon".$usempempid; 
$response = "content"; 
////$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
require "inc/core".$usempempid.".php";


//-- define content -----------------------------------------------------------------


$userID = 0;
$userType = $_SESSION['usr_type'];
$userCompany = 0;

if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; 
$sesusr_id= $_SESSION['usr_id'];
$_SESSION['view_id'] = $userID;

//echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'].'<br><br>';

$userCompany = $_SESSION['usr_company'];
 if (isset($_REQUEST['usr']) ) 
  {$userID= $_REQUEST['usr'];}else{$userID=$_SESSION['usr_id'];}
     $_SESSION['passprofile_usr'] = $userID; 
  if (isset($_REQUEST['company_id'])) {
      $userCompany = $_REQUEST['company_id'];} else { $userCompany = $_SESSION['usr_company'];}
       $_SESSION['passprofile_emp'] =$userCompany;
  
$userID= $_SESSION['passprofile_usr'];  //= $userID;set im dashboard bc2memmbers lloys profileusremp
$emp_ID= $_SESSION['passprofile_emp'];  //=$userCompany;
////$userType = $_SESSION['usr_type'];  //will use ?usr='.$userID'.'&compan_id='.$emp_ID    to pass to bc2membersprofile

////if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
////else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; $_SESSION['view_id'] = $userID;

$userType = QV("SELECT usr_type from usr where usr_id =" . $userID. "");

// add company id the user is signed in with to define the profile 3/12/19 lloyd  tie in company
$userCompany = $emp_ID;  //// $_REQUEST['company_id'];
$emp_level = QV("SELECT emp_level from emp where emp_id =" . $emp_ID. "");
/////$emp_ID = $userCompany;
//echo $userCompany.' - '.$userType;exit();  $result=mysql_query($check4dupeemail)) $co_dashrow mysql_fetch_array($result))  

$thisempname = QV ("Select emp_name from emp where emp_id = ".$emp_ID."");
 $fnamelname = Q("SELECT usr_firstname,usr_lastname from  usr where usr_id = " . $userID. " ");
 $namesrow = mysqli_fetch_array($fnamelname, MYSQLI_ASSOC);
$thisusrfirstname =$namesrow['usr_firstname'];
$thisusrlastname = $namesrow['usr_lastname'];

$cssLinks .= '<style>
            #footer{
                max-width: 1100px;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                border-left: 1px solid black;
                border-right: 1px solid black;
                box-shadow: 0px 0px 15px #000;
            }
            <style>';

//  $thisusrfirstname  $thisusrlastname  $thisempname
//echo $_SESSION['usr_auth'];
//exit();

if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_emp.php\';\" >Return to Employers List</div>");';

$empSection=@$_REQUEST['empSection'] or $empSection=@$_SESSION['empSection'] or $empSection="pst"; $_SESSION['empSection']=$empSection;

//$content .= "!!!!" . $empSection . "!!!!" . print_r($_REQUEST,true). print_r($_SESSION,true);

$opRec = CleanI($_REQUEST['rec']);
///no loger need $empID = QV("SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'");


$content .= DBContent();

$jobID = CleanI($_REQUEST['profileID']);
//echo $jobID;

$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".CleanI($_REQUEST['profileID'])."'");   // for the prfile id is the usr_id for the person listed
//                                                                  also need to get profilescompanyid from bc2members
$RuserID = CleanI($_REQUEST['profileID']);     // user in table of results what is cmompany??3/31/19  profileID is job_id of a job
                                          //^ this is job_id of the jpb profile
$RempID = CleanI($_REQUEST['profilecompany_id']); //=395260
               //^ this is jobemp_id of the job profile in request 
/*
if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}
*/

if (($userType == 0) && ($usrData['usr_type'] == 1)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr_emp_id.php?usr='.$adminUser.'&userCompany='.$sesusr_id.'&ptype=admin">ADMIN Panel</a></center></td>';
}

if ($userType == 99) {
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/bc2_admins.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';	
}

//$content .= '<br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';

//  $thisusrfirstname  $thisusrlastname  $thisempname
$content .= ' <br/><div style="text-align:center;">' .  $thisusrfirstname  . ' ' . $thisusrlastname . '<br/> ' ; 
$content .=  $thisempname .  '</div>'; 
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="555" align="center">
<tbody>
<tr>

<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'&company_id='.$emp_ID.' ">Member Profile</a></td>
<td><a href="/'.$_SESSION['env'].'/bc2members'.$usempempid.'.php?usr='.$userID.'&company_id='.$emp_ID.' ">Return to Dashboard</a></td>';

if (($emp_level > 0) || $userType==99 )
{
$content .= '<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'&company_id='.$emp_ID.'">Build Your Team</a></td>';

$content .= '<td><a href="/'.$_SESSION['env'].'/p_admins.php?usr='.$userID.'&company_id='.$emp_ID.'">Search Members</a></td>';
}
////  <td><a href="/'.$_SESSION['env'].'/bc2members'.$usempempid.'.php?usr='.$userID.'&company_id='.$emp_ID.' ">Return to Dashboard</a></td>';
if ( $emp_level > 0)
{
	//$_SESSION['usr_auth'] = 8;  ?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].
	$content .= '<td><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$_SESSION['passprofile_usr'].'&ptype=admin&userCompany='.$_SESSION['passprofile_emp'].'">Manage Account</a></td>';
}
$userPrimary = '';

//echo $userCompany.' - '.$userType;exit();

//echo 'userType [ '. $userType . ' ] <br>';
//echo 'usrData [ '. $usrData['usr_type'] . ' ]';
//exit();

/*
if ($usrData['usr_type'] == 0) {
	//$_SESSION['usr_auth'] = 8;
	$userPrimary = '<td><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$userID.'&ptype=admin">Manage Account</a></td>';
}
*/

$content .= $userPrimary.$systemAdmin.'</tr>
</tbody>
</table>
</div>';

$jobdetails = Q2R("select * from job where job_id ='".$RuserID."' ");
// 5/24/19 get \/ correct company addr$company = Q2R("select E.* from emp E LEFT JOIN usr_emp U ON E.emp_id = U.usremp_emp_id where U.usremp_usr_id in (select job_emp_id from job where job_id = '".$RuserID."' )");
$company = Q2R("select E.* from emp E  where E.emp_id = ".$RempID."");
$union = QV("select C.catedu_text from cat_edu C LEFT JOIN job J ON C.catedu_level = J.job_edu_level where J.job_id = '".$RuserID."' ");
$clr = QV("select C.catclr_title from cat_clearance C LEFT JOIN job J ON C.catclr_rank = J.job_clearance where J.job_id = '".$RuserID."' ");

$content .= '<center><div><h1 style="text-align: center; color: #000099;"><span style="background-color: #ffffff;"><strong>SCORECARD</strong></span></h2>';
$content .= '<div style="text-align:center;"><strong>Title: </strong>' . $jobdetails['job_title'] . '</div><br><br>';






//*********************************************************************

$jobFncTable = getFunctions($RuserID);
//$jobCrtTable = getCertifications($RuserID);
$jobCrtTable = getCertifications($RuserID,$RempID);
//$jobSklTable = getSkills($RuserID);
$jobSklTable = getSkills($RuserID,$RempID);
$jobAgcyTable = getAgencies($RuserID);
$jobPrlcTable = getProflics($RuserID);
$jobGeoTable = getGeos($RuserID);
$jobVehiclesTable = getVehicles($RuserID);
 $matchTable = getMatches2($RuserID);   //  $RempID
//// = getMatches2($RuserID,$RempID);    // lloyd profile has companyid  joremp_id  RuserID is job_id

$mCerts = 0;
$mSkills = 0;
$mFuncs = 0;
$mAgencies = 0;
$mProflics = 0;
$mGeos = 0;
$mVehicles = 0;


	//	$crtData = Q2T("SELECT J.*, C.* FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '".$id."' ");
		
	//	$crtSel = QV("SELECT J.jobcrt_desc FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '".$id."' ");
	//	$crtcnt = QV("SELECT count(*) FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '".$id."' ");





/**************NONE REVERSAL

if ($jobCrtTable) {
	$mCerts = count($jobCrtTable);
	
	if ($mCerts == 1)
	{
	    
	    foreach ($jobCrtTable as $crt){
	        
	        //echo "[".$crt['jobcrt_desc']."]"; exit();

	        if ($crt['jobcrt_desc'] == 'NONE')
	        {
	            $mCerts = 0;
	        }
	    }
	}
}

*****************************/


if ($jobCrtTable) {
	$mCerts = count($jobCrtTable);
}

if ($jobSklTable) {
	$mSkills = count($jobSklTable);
}
if ($jobAgcyTable) {
	$mAgencies = count($jobAgcyTable);
}
if ($jobPrlcTable) {
	$mProflics = count($jobPrlcTable);
}
if ($jobGeoTable) {
	$mGeos = count($jobGeoTable);
}			
if ($jobVehiclesTable) {
	$mVehicles = count($jobVehiclesTable);
}

//echo $mCerts." - ".$mSkills." - ".$mFuncs." - ".$mAgencies." - ".$mProflics." - ".$mGeos." - ".$mVehicles."<br><br>";


renderJobMatches($matchTable,$mCerts,$mSkills,$mFuncs,$mAgencies,$mProflics,$mGeos,$mVehicles,$RuserID);


//*********************************************************************#11fe27


$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';

$content .='
<tr><td bgcolor="#FFFFFF" style="padding:10px"><font color = "blue" >*A <strong>BLUE</strong> hightlight indicates the criteria that Members MATCHED on.</font></td></tr>';
	
$content .= '</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';




$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="2" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Company Information</strong></td>
</tr>
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>';

/// 5/24 showing wrong company info - it is one of user's companys but wrong one  **company**

$content .='
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Company Name:</strong> '.$company['emp_name'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Address:</strong> '.$company['emp_address'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Email:</strong> '.$company['emp_email'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Phone:</strong> '.$company['emp_phone'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Fax:</strong> '.$company['emp_fax'].'</td></tr>';	
		
$content .='
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';
$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="2" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Job Details</strong></td>
</tr>
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr><td width="990" colspan="2" bgcolor="#E8E8E8" align="left" style="padding:10px"><strong>Description:</strong><br><br>'.$jobdetails['job_details'].'<br><br></td></tr>
<tr>';
$content .='
<td width="510" bgcolor="#E8E8E8" align="left" valign="top">
		<p>&nbsp;<strong>Security Clearance:</strong> '.$clr.'<br></p>
        <p>&nbsp;<strong>Union/Non-Union:</strong> '.$union.'<br></p>
        <p>&nbsp;<strong>Solicitation #:</strong> '.$jobdetails['job_solicitation'].'</p>';
		if ($jobdetails['job_solicitation_link'] <> '')
		{
			$content .= '<p>&nbsp;<strong>Solicitation URL:</strong> <br>&nbsp;<a href="'.$jobdetails['job_solicitation_link'].'" target="_blank"><b><font color="red" >'.$jobdetails['job_solicitation_link'].'</font></b></a></p>';
		}
		else
		{
			$content .= '<p>&nbsp;<strong>Solicitation URL:</strong> <b><font color="blue">N/A</font></b></p>';
		}		
$content .='<p>&nbsp;<strong>Due Date:</strong> '.$jobdetails['job_due_date'].'</p>
        <p>&nbsp;<strong>Buying Office:</strong> '.$jobdetails['job_buying_office'].'</p></td>
		
<td width="470" bgcolor="#E8E8E8" align="left" valign="top">
		<p>&nbsp;<strong>Contact Information</strong></p>
		<p>&nbsp;<strong>First Name:</strong> '.$jobdetails['job_first_name'].'</p>
        <p>&nbsp;<strong>Last Name:</strong> '.$jobdetails['job_last_name'].'</p>
        <p>&nbsp;<strong>Email Address:</strong> '.$jobdetails['job_email_address'].'</p>
        <p>&nbsp;<strong>Phone:</strong> '.$jobdetails['job_phone'].'</p></td>';	

		
$content .=' </tr>
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>';		
$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';



//$content .= '<br><b>CRITERIA</b><br><br>';


/*

$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td width="990" bgcolor="#E8E8E8" align="left">
<div class="container" style="border:2px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">';	
		
$content .='	
</div>
</td>
</tr>';

$content .='
<tr><td bgcolor="#FFFFFF" style="padding:10px"><font color = "red">*Criteria in red indicates that you matched on that criteria.</font></td></tr>';
	
$content .= '</tbody>
</table>
</td>
</tr>
</tbody>
</table><br>';

*/


$prows = 160;

//Naics:
$sklData = Q2T("SELECT J.*, C.* FROM cat_skills C LEFT JOIN job_skills J ON C.catskl_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$RuserID."' ");
//$sklData = Q2T("SELECT J.*, C.* FROM cat_skills C RIGHT JOIN job_skills J ON C.catskl_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$RuserID."' ");

$sklcnt = QV("select count(*) as cnt FROM job_skills WHERE jobskl_job_id = '".$RuserID."' ");
$scrollit = $sklcnt * 16;

if ($scrollit > $prows) 
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 32;  //16
//$scrollit = 64;
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
//echo 'NAICS [ '.$pd['catskl_id'].' ] USERID [ '.$userID.' ]'; exit();

$num = 0;
if ($sklData) {
	foreach ($sklData as $pd){ 
	    
	    $content .= "<!-- br> trace 358 mcnt deerived from SELECT count(*) as cnt FROM usr_skills WHERE usrskl_usr_id = '".$userID."' 
	     and usrskl_emp_id = '".$emp_ID. "' and usrskl_skl_id = '".$pd['catskl_id']."' -->";
		$mcnt = QV("SELECT count(*) as cnt FROM usr_skills WHERE usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and usrskl_skl_id = '".$pd['catskl_id']."'");
		$content .= "<!--br> trace 360  mcnt : ". $mcnt. " -->";
		
		$fcolor = "black";
		
		if ($mcnt > 0)  $fcolor = "blue"; //  "#11fe27";  //green was"red";	
		
		$num = $num + 1;
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catskl_label']."</font><br>"; }
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
$agenciesData = Q2T("SELECT J.*, C.* FROM cat_agencies C LEFT JOIN job_agencies J ON C.catagen_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$RuserID."' ");
$agencnt = QV("select count(*) as cnt FROM job_agencies WHERE jobskl_job_id = '".$RuserID."' ");
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
	foreach ($agenciesData as $pd){ 
		$mcnt = QV("SELECT count(*) as cnt FROM usr_agencies WHERE usragen_usr_id = '".$userID."' and usragen_emp_id = '".$emp_ID. "' and usragen_skl_id = '".$pd['catagen_id']."'");
		$fcolor = "black";
		if ($mcnt > 0)
			$fcolor = "blue";  // "#11fe27"; // "red";	
	
		$num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catagen_label']."</font><br>"; }
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
$vehiclesData = Q2T("SELECT J.*, C.* FROM cat_vehicles C LEFT JOIN job_vehicles J ON C.catskl_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$RuserID."' ");
$vehcnt = QV("select count(*) as cnt FROM job_vehicles WHERE jobskl_job_id = '".$RuserID."' ");
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
//echo 'Vehicles [ '.$pd['catskl_id'].' ] USERID [ '.$userID.' ]'; exit();
$num = 0;
if ($vehiclesData) {
	foreach ($vehiclesData as $pd){ 
		$mcnt = QV("SELECT count(*) as cnt FROM usr_vehicles WHERE usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and usrskl_skl_id = '".$pd['catskl_id']."'");
		$fcolor = "black";
		if ($mcnt > 0)
			$fcolor =  "blue"; // "#11fe27"; // "red";

		$num = $num + 1; 
		$shownum = $num; 

		if ($shownum < 10) 
			$shownum = "0".$shownum; 
		$content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catskl_label']."</font><br>"; }
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
$proflicsData = Q2T("SELECT J.*, C.* FROM cat_proflics C LEFT JOIN job_proflics J ON C.catskl_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$RuserID."' ");
$proflicscnt = QV("select count(*) as cnt FROM job_proflics WHERE jobskl_job_id = '".$RuserID."' ");
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
	foreach ($proflicsData as $pd){
		$mcnt = QV("SELECT count(*) as cnt FROM usr_proflics WHERE usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and usrskl_skl_id = '".$pd['catskl_id']."'");
		$fcolor = "black";
		if ($mcnt > 0)
			$fcolor = "blue";  // "#11fe27"; //"red";
		
		$num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catskl_label']."</font><br>"; }
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
$crtData = Q2T("SELECT J.*, C.* FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '".$RuserID."' ");
$crtcnt = QV("select count(*) as cnt FROM job_certs WHERE jobcrt_job_id = '".$RuserID."' ");

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
	foreach ($crtData as $pd){
		$mcnt = QV("SELECT count(*) as cnt FROM usr_certs WHERE usrcrt_usr_id = '".$userID."' and usrcrt_emp_id = '".$emp_ID. "' and usrcrt_crt_id = '".$pd['catcrt_id']."'");
		$fcolor = "black";
		if ($mcnt > 0)
			$fcolor = "blue"; //"#11fe27"; // "red";
	$num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catcrt_name']."</font><br>"; } 
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
$geoData = Q2T("SELECT J.*, C.* FROM cat_geos C LEFT JOIN job_geos J ON C.catskl_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$RuserID."' ");
$geocnt = QV("select count(*) as cnt FROM job_geos WHERE jobskl_job_id = '".$RuserID."' ");
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
	foreach ($geoData as $pd){
		$mcnt = QV("SELECT count(*) as cnt FROM usr_geos WHERE usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and usrskl_skl_id = '".$pd['catskl_id']."'");
		$fcolor = "black";
		if ($mcnt > 0)
			$fcolor = "blue" ;  //""#11fe27"; // "red";
		
		$num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catskl_label']."</font><br>"; }
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




$content .= '</div></center>';

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

function getPosts() {
	global $userID,$empID;
	return Q2T("SELECT J.* FROM job J WHERE J.job_emp_id = '".$userID."' ORDER BY J.job_submitted_date ");
}

function getMatches($id) {  // does not seem to be called
	global $userID;

	//clear match table
/**	
	Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'"); 
	
	//rerun match routines
	updateCertMatchesJP($id);
	updateSkillMatchesJP($id);
	updateAgencyMatchesJP($id);
	updateProflicMatchesJP($id);
	updateGeoMatchesJP($id);
	updateVehiclesMatchesJP($id);	
**/		
	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC");
}

function getUSRMatches() {
    global $userID, $emp_ID, $content;
 /* delete sys-match entries for this usr company
	Q("DELETE FROM sys_match WHERE (sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
	
	*/
	// function deleteuser and company matches(){
	//$qdeleteusrco_sysmat="DELETE FROM sys_match WHERE  sysmat_usr_id= ".$userID. " and sysmat_emp_id = ". $emp_ID ."  "; 
 //	(sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
 //$content .= "<br>trace 672 getUSRMatches  qdeleteusrco_sysmat: ". $qdeleteusrco_sysmat . " --> ";

	/* Matching */
	/*	updateSkillMatchesMP($userID); 
		updateCertMatchesMP($userID); 
		updateFunctionMatchesMP($userID); 
		updateAgencyMatchesMP($userID); 
		updateProflicMatchesMP($userID);
		updateVehiclesMatchesMP($userID);
		updateGeoMatchesMP($userID); */
/* End Matching */
	$qsysmat="SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum 
	   FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE U.usr_id ='".$userID."' and S.sysmat_emp_id=".$emp_ID." ORDER BY sum DESC";
     $content.= "<br> trace getUSRmatched qsysmat: " . $qsysmat . " -->";
	return Q2T ($qsysmat); //("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE U.usr_id ='".$userID."' ORDER BY sum DESC");
}

function getJobInfo($id) {
	return Q2T("SELECT J.* FROM job J WHERE J.job_id ='".$id."' ORDER BY J.job_submitted_date");
}

function getRating($id, $empid) {
	return Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_certs where jobcrt_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_skills where jobskl_job_id ='".$id."'");
}

function getFunctions($id) { 
	return Q2T("SELECT F.*, C.* FROM job_func F LEFT JOIN cat_func C ON C.catfnc_id= F.jobfnc_fnc_id WHERE F.jobfnc_job_id = '".$id."' "); 
}

function getCertifications($id,$empid) {
	return Q2T("SELECT E.*, C.* FROM job_certs E LEFT JOIN cat_certs C ON C.catcrt_id = E.jobcrt_crt_id WHERE E.jobcrt_job_id = '".$id."'");
}

function getSkills($id,$empid) {
	return Q2T("SELECT S.*, C.* FROM job_skills S LEFT JOIN cat_skills C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getAgencies($id) {
	return Q2T("SELECT S.*, C.* FROM job_agencies S LEFT JOIN cat_agencies C ON C.catagen_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getProflics($id) {
	return Q2T("SELECT S.*, C.* FROM job_proflics S LEFT JOIN cat_proflics C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getGeos($id) {
	return Q2T("SELECT S.*, C.* FROM job_geos S LEFT JOIN cat_geos C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getVehicles($id) {
	return Q2T("SELECT S.*, C.* FROM job_vehicles S LEFT JOIN cat_vehicles C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getMatches2($id) {
	global $userID, $content,$emp_ID; // $RuserID the job_id  ,$RempID , the jobemp_id   ////,$empid)
	//clear match table
/*** */	
	//  this is overkill Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'"); 
 		
	//rerun match routines turned all but skills back on 4/19/19 lloyd skillls left on 
	
	//  4/19/19 do wee need to pass the company_id of the $ruser which is $RuserID passed into here as $id
//	updateCertMatchesJP($id);     //  was updateCertMatchesJP($id);	     //  was updateCertMatchesJP($id);     //$buffer =  
   
     updateCertMatchesJPnonzeroempid($id);
     
    // $buffer .=  "<!-- ";    $content.=  $buffer . "-->"; //	updateSkillMatchesJP($id);    //$buffer = "";

	 updateSkillMatchesJPnonzeroempid($id);   //updateSkillMatchesJPnonzeroempid //     $content.= "<!-- " .  $buffer . "-->";
      
	////updateAgencyMatchesJP($id);	$buffer=
	updateAgencyMatchesJPnonzeroempid($id);
	
	updateProflicMatchesJP($id);

	 

	 updateGeoMatchesJPnonzeroempid($id);
	  $content.= "<!-- " .  $buffer . "-->";	 $buffer .=  "<!--  --> ";   //// updateGeoMatchesJP($id);

	updateVehiclesMatchesJP($id);
	
   	deleteOldMatches();
    $oldcert_req = QV("SELECT count(*) as cnt FROM job_certs WHERE jobcrt_job_id = '".$id."'" );
////	$content .= "<!-- trace line 785 c2myjob... cert-req is " .  $cert_req . " ignoring it,
////	query is: SELECT count(*) as cnt FROM job_certs WHERE jobcrt_job_id = '".$id."' -->";
	////	$content .= "<!-- trace line 791 c2myjobskill and ... cert-query join  is  
	////	SELECT count(*) as cnt FROM job J inner join job_certs JC on J.job_id = JC.jobcrt_job_id 
	////  inner join job_skills JS on J.job_id = JS.jobskl_job_id  WHERE J.job_id = '".$id."' -->";
     
	////$skillandcert = QV("SELECT count(*) as cnt FROM job J inner join job_certs JC on J.job_id = JC.jobcrt_job_id 
	 //// inner join job_skills JS on J.job_id = JS.jobskl_job_id  WHERE J.job_id = '".$id."'");
	 
	 
	  $cert_req= QV("SELECT COUNT(*)  FROM sys_match WHERE sysmat_job_id = '".$id."' and (sysmat_certifications >0 and sysmat_skills > 0 )");
	 
	 //echo "SELECT COUNT(*)  FROM sys_match WHERE sysmat_job_id = '".$id."' and (sysmat_certifications > 0 and sysmat_skills > 0 )"; exit();
	 
	  $content .= "<!-- trace line 799 cert_req: ". $cert_req. " from query 
	  SELECT COUNT(*)  FROM sys_match WHERE sysmat_job_id = '".$id."' and (sysmat_certifications >0 and sysmat_skills > 0 )" ;
	  
	  //echo "[".$cert_req."]"; exit();

    
    $jobcrtcnt = QV("select count(*) as cnt from job_certs where jobcrt_job_id =".$id);
    
    //echo "select count(*) as cnt from job_certs where jobcrt_job_id =".$id; exit();
    
    //echo "[".$jobcrtcnt."]"; exit();
    
  
//	if ($cert_req > 0) 
	if ($jobcrtcnt > 0)
		$qry_end = ' AND S.sysmat_certifications > 0 ) ORDER BY sum DESC,  usr_lastname,usr_firstname';
	else
	{
		$qry_end = ' ) ORDER BY sum DESC,   usr_lastname,usr_firstname';
	}

	



	
///// reduce result size$qpullmats="SELECT S.sysmat_emp_id as aCompany  4/3/19
///// ,S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum 
 //// $qry_end = ' ) ORDER BY sum DESC,   usr_lastname,usr_firstname';
 $qpullmats="SELECT S.sysmat_emp_id as aCompany
 ,S.*,U.usremp__id,U.usr_company,U.usr_firstname, U.usr_lastname
 ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum 
	FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id 
	WHERE S.sysmat_job_id = '".$id."' and S.sysmat_skills > 0  " .$qry_end ;
	
//	echo $qpullmats."<br><br>";
	
	
$qpullmatUEs="SELECT S.sysmat_emp_id as aCompany
 ,S.*,UE.usremp_usr_assignedusr_id,UE.usremp_emp_id as usr_company,U.usr_firstname, U.usr_lastname,U.usr_id
 ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum 
	FROM sys_match S   left join usr_emp UE on UE.usremp_usr_assignedusr_id = S.sysmat_usr_id and UE.usremp_emp_id = S.sysmat_emp_id
	inner JOIN usr U ON  UE.usremp_usr_assignedusr_id = U.usr_id 
	WHERE S.sysmat_job_id = '".$id."' /*and jS.sysmat_emp_id >0 and UE.usremp_emp_id > 0 U.usr_company > 0 */ and (S.sysmat_skills > 0 " .$qry_end ;
	

//    echo $qpullmatUEs."<br><br>";
//    exit();

//	FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id 
//WHERE S.sysmat_job_id = '".$id."' and S.sysmat_skills > 0  " .$qry_end ;


  	////  /* for test only */WHERE S.sysmat_job_id = 213825 and ((S.sysmat_usr_id > 18695 and S.sysmat_usr_id < 18702) 
  ////	or ( S.sysmat_usr_id = 26803 or S.sysmat_usr_id =26804 or  S.sysmat_usr_id = 400329 or   S.sysmat_usr_id = 34275)) and S.sysmat_skills > 0  " .$qry_end ;	
 //	WHERE S.sysmat_job_id = '".$id."' and S.sysmat_skills > 0  " .$qry_end ;

  $content.= "<!-- trace 787 in getMatches2 qpullmatUEs: <br>" . $qpullmatUEs . " -->"; 
	// pull matches again
//	return Q2T("SELECT  S.sysmat_emp_id as aCompany,S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' and S.sysmat_skills > 0  and S.sysmat_usr_id = ".$userID. " " .$qry_end);	
//	  and S.sysmat_usr_id <> '".$userID.
//	  return Q2T($qpullmats);
return Q2T($qpullmatUEs);
}

function renderJobMatches($matchTable,$certs,$skills,$funcs,$agencies,$proflics,$geos,$vehicles,$job_id) {
	global $content, $footerScript, $userID,$emp_ID;
$scrollit = 420; // 360;
	//SAVE JUST IN CASE
	//<div style="height:20px;display:inline-block;margin:10px 0;padding:10px;"><button onclick="myFunction()">Update Matches</button><script>
//function myFunction() {
    //location.reload();
//}</script></div>

/*
	$content .= '	
<div>Legend: <div style="height:20px;display:inline-block;margin:10px 0px 10px 10px;padding:10px;background:#888;color:#fff;">No Match</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8a8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8b8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8c8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8d8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8e8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8e8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8e8;">&nbsp;</div>
<div style="height:20px;display:inline-block;margin:10px 0;padding:10px;background:#0f0;">Full Match</div>
</div><br>
*/
    $content .= '<div align="center"  width="958"><table cellpadding="4" cellspacing="0" class="functionsGrid" style="width:926px;">
					<thead>
					<tr style="color:#fff;width=940px;"><th style="width:346px;">&nbsp;Name<br/>Company</th><th style="width:80px;">NAICS</th><th style="width:80px;">
					Agencies</th><th style="width:80px;">Certs</th><th style="width:78px;">Licenses</th><th style="width:78px;">Places</th><th style="width:78px;">Vehicles</th><th style="width:78px;">Sum
					</th></tr>
					</thead>  </table> ';
				
	$content .= '  <div class="container" align="left" style="display:block;border:1px solid #c00; width:926px; height: '.$scrollit.'px; overflow-y: scroll;">
	             <table cellpadding="2" cellspacing="0" class="functionsGrid" style="width:900px;">
				 	<tbody>';										
	if ($matchTable) foreach($matchTable as $roe) {
/*
	$certVal = intval($roe['sysmat_certifications']); if ($certVal > intval($certs)) $certVal = intval($certs);
		$skillVal = intval($roe['sysmat_skills']); if ($skillVal > intval($skills)) $skillVal = intval($skills);
		$funcVal = intval($roe['sysmat_functions']); if ($funcVal > intval($funcs)) $funcVal = intval($funcs);
		$agcyVal = intval($roe['sysmat_agencies']); if ($agcyVal > intval($agencies)) $agcyVal = intval($agencies);	
		$proflicVal = intval($roe['sysmat_proflics']); if ($proflicVal > intval($proflics)) $proflicVal = intval($proflics);
		$geoVal = intval($roe['sysmat_geos']); if ($geoVal > intval($geos)) $geoVal = intval($geos);
		$vehiclesVal = intval($roe['sysmat_vehicles']); if ($vehiclesVal > intval($vehicles)) $vehiclesVal = intval($vehicles);
*/
 	$certVal = intval($roe['sysmat_certifications']);
		$skillVal = intval($roe['sysmat_skills']);
		$funcVal = intval($roe['sysmat_functions']);
		$agcyVal = intval($roe['sysmat_agencies']);
		$proflicVal = intval($roe['sysmat_proflics']);
		$geoVal = intval($roe['sysmat_geos']);
		$vehiclesVal = intval($roe['sysmat_vehicles']);
		
		$content .= "<!-- tr><td colspan='8'><br> trace 797 myjprf roe[sysmat_emp_id] = ". $roe['sysmat_emp_id'] .", aCompany: ".$roe['aCompany'] ."</td></tr>-->"; 
		
		$roecompany_id= $roe['aCompany'];  //intval($roe['sysmat_emp_id']);  many  will be 0 
	///	$roecompany_id = 0;
	///	if(intval($roe['sysmat_emp_id']) > 0)  		$roecompany_id = intval($roe['sysmat_emp_id']);
		$roecompanyname = "NA";
		if ($roecompany_id > 0) 		$roecompanyname = QV("SELECT emp_name from emp where emp_id=".$roecompany_id."");
		// won't need the below when all matches have emp_id's 4/2/19
		if ($roecompanyname == "NA") 
		{
	      	$anotherempid = $roe['usr_company']; ////QV(" select usr_company  from usr where usr_id = ".$roe['usr_id']." ");
	 	    $anothercompanyname ="NA";
	      	$anothercompanyname = QV(" Select emp_name from emp where emp_id = ". $anotherempid. "");
		   $roecompany_id = $anotherempid;  //replace with 	$roecompany_id= $roe['aCompany']; when go live but now not many jobs  have acompan id with them
	    	if (!($anothercompanyname == "NA" )) 		$roecompanyname = $anothercompanyname;
		}	
	$content .= "<!-- tr><td colspan='8'>  trace  824 roecompanyname: ". $roecompanyname. ", roecompany_id: ".  $roecompany_id. ", notherempid: " . $anotherempid 
            	. "<br>, anothercompanyname: ". $anothercompanyname. ",  roe['usr_id']: ". $roe['usr_id']. "</td></tr>-->"; 
        /////!!!Need to change the above to get the emp_id from usr_emp or just stop doing it and     	
		// $roecompany_id $roecompanyname
//		echo $certVal . "--" . $skillVal . "--" . $agcyVal . "--" . $proflicVal . "--" . $geoVal . "<br><br>";
//		echo $certs . "--" . $skills . "--" . $agencies . "--" . $proflics . "--" . $geos . "<br><br>";
//	echo "[ " . $job_id . " ] " . " [ " . $certVal . " ] " . " [ " . $certs . " ] " . " [ " . intval($certs) . " ] <br><br>";
//	exit();
		$sumVal = intval($roe['sum']);
		$certColor = '#8a8';
		$skillColor = '#888';
		$funcColor = '#888';
		$agcyColor = '#888';
		$proflicColor = '#888';
		$geoColor = '#888';
		$vehiclesColor = '#888';
		$sumColor = '#888';
		
		if ($certs > 0){
			if (dechex((($certVal / intval($certs))*8)+8)==10) $certColor = '#0f0';
			else $certColor = '#8'.dechex((($certVal / intval($certs))*8)+8).'8';
		}

		if ($skills > 0){
			if (dechex((($skillVal / intval($skills))*8)+8)==10) $skillColor = '#0f0';
			else $skillColor = '#8'.dechex((($skillVal / intval($skills))*8)+8).'8';
		}

		if ($funcs > 0){
			if (dechex((($funcVal / intval($funcs))*8)+8)==10) $funcColor = '#0f0';
			else $funcColor = '#8'.dechex((($funcVal / intval($funcs))*8)+8).'8';
		}

		if ($agencies > 0){	
			if (dechex((($agcyVal / intval($agencies))*8)+8)==10) $agcyColor = '#0f0';
			else $agcyColor = '#8'.dechex((($agcyVal / intval($agencies))*8)+8).'8';
		}
		if ($proflics > 0){		
			if (dechex((($proflicVal / intval($proflics))*8)+8)==10) $proflicColor = '#0f0';
			else $proflicColor = '#8'.dechex((($proflicVal / intval($proflics))*8)+8).'8';
		}
		if ($geos > 0){
			if (dechex((($geoVal / intval($geos))*8)+8)==10) $geoColor = '#0f0';
			else $geoColor = '#8'.dechex((($geoVal / intval($geos))*8)+8).'8';		
		}
		if ($vehicles > 0){
			if (dechex((($vehiclesVal / intval($vehicles))*8)+8)==10) $vehiclesColor = '#0f0';
			else $vehiclesColor = '#8'.dechex((($vehiclesVal / intval($vehicles))*8)+8).'8';			
		}
		$job_criteria_total = $certs+$skills+$agencies+$proflics+$geos+$vehicles;
		//echo $roe['usr_firstname'].' '.$roe['usr_lastname']."--[ ".$sumVal." ] - [ ".$certs."-".$skills."-".$agencies."-".$proflics."-".$geos."-".$vehicles." ][job_criteria_total = [ ".$job_criteria_total." ]<br>";
//echo $roe['usr_firstname'].' '.$roe['usr_lastname']."--[ ".$sumVal." ] - [ ".$certs."-".$skills."-".$agencies."-".$proflics."-".$geos."-".$vehicles." ][job_criteria = [ ".$job_criteria." ]<br>";
//echo $roe['usr_firstname'].' '.$roe['usr_lastname']."-- [ ".dechex((($sumVal / intval(($certs+$skills+$agencies+$proflics+$geos+$vehicles)))*8)+8)." ]<br>";
/*
		if (($job_criteria_total <> 0) and ($sumVal <> 0)) {
			if (dechex((($sumVal / intval(($certs+$skills+$agencies+$proflics+$geos+$vehicles)))*8)+8)==10) $sumColor = '#0f0;';
			else $sumColor = '#8'.dechex(((($sumVal/6) / intval(($certs+$skills+$agencies+$proflics+$geos+$vehicles)/6))*8)+8).'8';
		}
*/	
	$jobCrtTable1 = Q2T("SELECT count(*) as cnt FROM job_certs WHERE jobcrt_job_id = '".$job_id."'");
	$jobSklTable1 = Q2T("SELECT count(*) as cnt FROM job_skills WHERE jobskl_job_id = '".$job_id."'");
	$jobAgcyTable1 = Q2T("SELECT count(*) as cnt FROM job_agencies WHERE jobskl_job_id = '".$job_id."'");
	$jobPrlcTable1 = Q2T("SELECT count(*) as cnt FROM job_proflics WHERE jobskl_job_id = '".$job_id."'");
	$jobGeoTable1 = Q2T("SELECT count(*) as cnt FROM job_geos WHERE jobskl_job_id = '".$job_id."'");
	$jobVehiclesTable1 = Q2T("SELECT count(*) as cnt FROM job_vehicles WHERE jobskl_job_id = '".$job_id."'");
	$dcerts = "0";
	$dskills = "0";
	$dagencies = "0";
	$dproflics = "0";
	$dgeos = "0";
	$dvehicles = "0";
	
	/******************************************NONE REVERSAL
	if ($jobCrtTable1){
	    if ($certs != 0)
	    {
		    foreach ($jobCrtTable1 as $matchCnt) {$dcerts = $matchCnt['cnt'];}
	    }
	    else
	    {
	        $dcerts = $certs;
	    }

	}	
	***********************/
	
	if ($jobCrtTable1){
		foreach ($jobCrtTable1 as $matchCnt) {$dcerts = $matchCnt['cnt'];}
	}
	
	
	if ($jobSklTable1){
		foreach ($jobSklTable1 as $matchCnt) {$dskills = $matchCnt['cnt'];}
	} 
	if ($jobAgcyTable1){
		foreach ($jobAgcyTable1 as $matchCnt) ($dagencies = $matchCnt['cnt']);
	} 
	if ($jobPrlcTable1){
		foreach ($jobPrlcTable1 as $matchCnt) ($dproflics = $matchCnt['cnt']);
	} 
	if ($jobGeoTable1){
		foreach ($jobGeoTable1 as $matchCnt) ($dgeos = $matchCnt['cnt']);
	} 	
	if ($jobVehiclesTable1){
		foreach ($jobVehiclesTable1 as $matchCnt) ($dvehicles = $matchCnt['cnt']);
	} 
	$sumColor = "#ffffff";
	$skillColor = "#ffffff";
	$agcyColor = "#ffffff";
	$certColor = "#ffffff";
	$proflicColor = "#ffffff";
	$geoColor = "#ffffff";
	$vehiclesColor = "#ffffff";
	$vehiclesColor = "#ffffff";
	
                //$sumColor = "#5EC0EE";	// $roecompany_id $roecompanyname
// http://www.bc2match.com/bc2dev/bc2membersprofile.php?usr=400328&emp_id=395259&Rusrid=43304&profile_company_id=42925&profileID=43304  drop &jobID='.$roe['sysmat_job_id'].'
// '&company_id='.$emp_ID.

///http://www.bc2match.com/bc2dev/bc2membersprofile.php?usr=400328&emp_id=395259&Rusrid=43304&profile_company_id=42925&profileID=43304

		$content .= '<tr><td style="background:#ffffff;width:343px;word-break:break-all;">
		<a href="bc2membersprofile.php
	?usr='.$userID.'&empid='.$emp_ID.'&Rusrid='.$roe['usr_id'].'&jobID='.CleanI($_REQUEST['profileID']).'&profile_company_id='.$roecompany_id.'&profileID='.$roe['usr_id'].'&profilecompany_name='.$roecompanyname.'" >
		 &nbsp;' .$roe['usr_firstname'].'&nbsp;'.$roe['usr_lastname'].'</a><br> '.$roecompanyname.'</td>
					<td style="width:84px; text-align:center;background:'.$skillColor.'">'.$roe['sysmat_skills'].'/'.$dskills.'</td>
					<td style="width:86px;text-align:center;background:'.$agcyColor.'">'.$roe['sysmat_agencies'].'/'.$dagencies.'</td>
					<td style="width:82px;text-align:center;background:'.$certColor.'">'.$roe['sysmat_certifications'].'/'.$dcerts.'</td>
					<td style="width:88px;text-align:center;background:'.$proflicColor.'">'.$roe['sysmat_proflics'].'/'.$dproflics.'</td>	
					<td style="width:83px;text-align:center;background:'.$geoColor.'">'.$roe['sysmat_geos'].'/'.$dgeos.'</td>	
					<td style="width:78px;text-align:center;background:'.$vehiclesColor.'">'.$roe['sysmat_vehicles'].'/'.$dvehicles.'</td>
					<td style="width:70px;text-align:center;background:'.$sumColor.'">&nbsp;&nbsp;&nbsp;&nbsp;'.($roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos']+$roe['sysmat_vehicles']).'/'.($dcerts+$dskills+$dagencies+$dproflics+$dgeos+$dvehicles).'</td>	
					</tr>';
	}
	 	$content .=  '	</tbody></table></div>';
	 		$content .=  '<div style="text-align:center;width:932px; height:40px;background-color: #9fcfff; border-radius: 1px 1px 20px 20px;">&nbsp;</div>
          </div></div><br><br><br>  ';	
}

// --------------------------------------------------------------
