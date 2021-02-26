<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Job ScoreCard Match: Member Profile";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$template = "jobcon"; 
$response = "content"; 
require "inc/core.php";
//require_once('tcpdf/tcpdf.php');
$_SESSION['$usempempid'] = "";   ////"_empid";
$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
/////$template = "jobcon_empid" ;  ////.$usempempid; 
/////$response = "content"; 
$usempempid = $_SESSION['$usempempid'];// "_empid";   //".$usempempid."
/////require "inc/core_empid.php";
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
   if (isset($_REQUEST['usr']) ) 
  {
      $userID= $_REQUEST['usr'];
     $_SESSION['passprofile_usr'] = $userID;
  } 
  if (isset($_REQUEST['emp_id'])) {
      $userCompany = $_REQUEST['emp_id'];   // the $Rempid profile copmay 
       $_SESSION['passprofile_emp'] = $userCompany;
  }
   if (isset($_REQUEST['usr']) ) 
  {$userID= $_REQUEST['usr'];}else{$userID=$_SESSION['usr_id'];}
     $_SESSION['passprofile_usr'] = $userID; 
  if (isset($_REQUEST['emp_id'])) {
      $usrCompany = $_REQUEST['emp_id'];}else { $userCompany = $_SESSION['usr_company'];}
       $_SESSION['passprofile_emp'] =$userCompany;
  
$userID= $_SESSION['passprofile_usr'];  //= $userID;set im dashboard bc2memmbers lloys profileusremp
$emp_ID= $_SESSION['passprofile_emp'];  //=$userCompany;
$thisuserType = QV ("Select usr_type from usr where usr_id=".$userID);
$emp_level = QV("SELECT emp_level from emp where emp_id =" . $emp_ID. "");
  $content .= "<!--  br>b!-- br> trace 38 b4 use req vars now userID = " .$userID . ", userCompany = " . $userCompany . " ( -->";
 $content .= "<!-- br> trace 56 thisuserType: " . $thisuserType . ", userType: " . $userType . ", userID: " . $userID .", userCompany" . $userCompany ."-->";

$content .= "<!-- br> trace 32 userType: " . $userType . ", userID: " . $userID .", userCompany" . $userCompany ."-->";
$thisempname = QV ("Select emp_name from emp where emp_id = ".$emp_ID."");
 $fnamelname = Q("SELECT usr_firstname,usr_lastname from  usr where usr_id = " . $userID. " ");
 $namesrow = mysqli_fetch_array($fnamelname, MYSQLI_ASSOC);
$thisusrfirstname =$namesrow['usr_firstname'];
$thisusrlastname = $namesrow['usr_lastname'];
/////$profilecompanyname=  QV ("Select emp_name from emp where emp_id = ".$_REQUEST['profile_company_id']."");
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
$RempID = CleanI($_REQUEST['profile_company_id']); //=395260
if ($RempID)
{
}else
{
 $RempID = CleanI($_REQUEST['company_id']);
    
}
$RempName = QV("Select emp_name from emp where emp_id = '".$RempID."'");
$jobID = CleanI($_REQUEST['jobID']);


//$jobID = "296555";

/*
if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}
*/

if (($userType == 0) && ($usrData['usr_type'] == 1)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
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
<tr>';
//echo "[ ".CleanI($_REQUEST['usr'])." ][ ".CleanI($_REQUEST['profileID'])." ][".$RuserID."]"; exit();
if (CleanI($_REQUEST['usr']) <> $RuserID)
{
if ($emp_level > 0)
{
    $content .= '<td><a href="/'.$_SESSION['env'].'/p_admins.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Search Members</a></td>';
    $content .= '<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Build Your Team</a></td>';
}
$content .= '<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$_SESSION['passprofile_usr'].'&empID='.$_SESSION['passprofile_emp'].'&company_id='.$_SESSION['passprofile_emp'].'">Return to Dashboard</a></td>';

$content .='<td><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$userID.'&usrCompany='.$_SESSION['passprofile_emp'].'&company_id='.$_SESSION['passprofile_emp'].'.&ptype=admin">Manage Account</a></td>';

//usr='.$_SESSION['passprofile_usr'].'&usrCompany='.$_SESSION['passprofile_emp'].'&company_id='.$_SESSION['passprofile_emp'].'"

//$content .='<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'&company_id='.$userCompany.'">Return to Dashboard</a></td>';
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

$union = QV("SELECT C.catedu_text FROM cat_edu C LEFT JOIN usr_edu U ON U.usredu_edu_id = C.catedu_id WHERE U.usredu_usr_id ='".$RuserID."' and U.usredu_emp_id= '".$RempID."' ");
$clr = QV("SELECT usrclr_title from usr_clearance where usrclr_usr_id = '".$RuserID."'  and usrclr_emp_id= '".$RempID."'");

$content .= '<div style="text-align:center;"><h3 style="text-align: center;"><span style="background-color: #ffffff;"><strong - >Partner Scorecard Match – Member Profile</strong></span></h3>';
$content .= '</div>';

$content .= '<table align="center"><tr><td>';
$content .= '<strong>Member Name: </strong>' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] ;
$content .= '<br><strong>Company: </strong>' . $RempName; //$profilecompanyname
$content .= '<br><strong>Email: </strong>' . $usrData['usr_email'] ;
$content .= '<br><strong>Phone: </strong>' . $usrData['usr_phone'] ;
$content .= '</td></tr></table>';
$content .= '<br>';

// <div style="text-align:center;">
$content .= '<center><table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';
//font color = "#11fe27"
$content .='
<tr><td bgcolor="#FFFFFF" style="padding:10px"><font color = "blue">*A <strong>BLUE </strong> highlight indicates the criteria that this member MATCHED on.</font></td></tr>';


$content .= '</tbody>
</table>
</td>
</tr>
</tbody>
</table><br></center>';




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
//5/9/19 now passed 431pmhttp://www.bc2match.com/bc2dev/bc2membersprofile.php?usr=43468&company_id=43089&profileID=43468
//  need to pass the searcher's usr and emp id in ?usr and in &company_id and the $RuserID in &profileID as above and $RempID in &profileCompany from p_admins
// also need to put up member profile dashboard and job profile and manage account menu items aboe he for searcher's usr and company
//Naics:
$sklData=Q2T("SELECT U.*, C.* FROM usr_skills U LEFT JOIN cat_skills C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' and U.usrskl_emp_id='".$RempID."' ");
$sklcnt = QV(" select count(*)  as cnt  FROM usr_skills WHERE usrskl_usr_id = '".$RuserID."' and usrskl_emp_id='".$RempID."' ");
$scrollit = $sklcnt * 16;
$content .= "<!--br> trace 281 skldata query: 
    SELECT U.*, C.* FROM usr_skills U LEFT JOIN cat_skills C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' and U.usrskl_emp_id='".$RempID."' --> ";
$content .= "<!--br> sklcnt: " . $sklcnt. "from select count(*)  FROM usr_skills WHERE usrskl_usr_id = '".$RuserID."' and usrskl_emp_id='".$RempID."' --> ";    
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
	foreach ($sklData as $pd){ 
		$num = $num + 1; 

        //echo "Select count(*) as cnt from usr_skills U LEFT JOIN job_skills J ON U.usrskl_skl_id = J.jobskl_skl_id where U.usrskl_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrskl_skl_id = '".$pd['usrskl_skl_id']."'";
        //echo "<br>";
	
		$mcnt = QV("Select count(*) as cnt from usr_skills U LEFT JOIN job_skills J ON U.usrskl_skl_id = J.jobskl_skl_id where U.usrskl_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrskl_skl_id = '".$pd['usrskl_skl_id']."'");
		
		
		$fcolor = "black";
		
		if ($mcnt > 0)
			$fcolor = "blue" ; // "#11fe27";  //"red";	
		
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['usrskl_title']."</font><br>"; 
	}
	//exit();
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
$agenciesData = Q2T("SELECT U.*, C.* FROM usr_agencies U LEFT JOIN cat_agencies C ON C.catagen_id = U.usragen_skl_id WHERE U.usragen_usr_id = '".$RuserID."' and U.usragen_emp_id='".$RempID."'");
$agencnt = QV("select count(*) as cnt FROM usr_agencies WHERE usragen_usr_id = '".$RuserID."' and usragen_emp_id='".$RempID."' ");

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
		$num = $num + 1; 
		
		$mcnt = QV("Select count(*) as cnt from usr_agencies U LEFT JOIN job_agencies J ON U.usragen_skl_id = J.jobskl_skl_id where U.usragen_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usragen_skl_id = '".$pd['usragen_skl_id']."'");
		echo $mcnt;
		
		$fcolor = "black";
		
		if ($mcnt > 0)
			$fcolor = "blue";  //"#11fe27"; // "red";		
		
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['usragen_title']."</font><br>"; 
	}
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
$vehiclesData = Q2T("SELECT U.*, C.* FROM usr_vehicles U LEFT JOIN cat_vehicles C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' and U.usrskl_emp_id='".$RempID."' ");

$vehcnt = QV("select count(*) as cnt FROM usr_vehicles WHERE usrskl_usr_id = '".$RuserID."' and usrskl_emp_id='".$RempID."' ");

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
	foreach ($vehiclesData as $pd){ 
		$num = $num + 1; 
		
		$mcnt = QV("Select count(*) as cnt from usr_vehicles U LEFT JOIN job_vehicles J ON U.usrskl_skl_id = J.jobskl_skl_id where U.usrskl_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrskl_skl_id = '".$pd['usrskl_skl_id']."'");
		
		$fcolor = "black";
		
		if ($mcnt > 0)
			$fcolor = "blue" ; // "#11fe27"; //"red";		
		
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['usrskl_title']."</font><br>"; 
	}
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

$proflicsData = Q2T("SELECT U.*, C.* FROM usr_proflics U LEFT JOIN cat_proflics C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' and U.usrskl_emp_id='".$RempID."' ");

$proflicscnt = QV("select count(*) as cnt FROM usr_proflics WHERE usrskl_usr_id = '".$RuserID."'  and usrskl_emp_id='".$RempID."'");

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
		$num = $num + 1; 
		
		$mcnt = QV("Select count(*) as cnt from usr_proflics U LEFT JOIN job_proflics J ON U.usrskl_skl_id = J.jobskl_skl_id where U.usrskl_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrskl_skl_id = '".$pd['usrskl_skl_id']."'");
		
		$fcolor = "black";
		
		if ($mcnt > 0)
			$fcolor = "blue"; //"#11fe27" ;// "red";		
		
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['usrskl_title']."</font><br>"; 
	}
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
$crtData = Q2T("SELECT U.*, C.* FROM usr_certs U LEFT JOIN cat_certs C ON C.catcrt_id = U.usrcrt_crt_id WHERE U.usrcrt_usr_id = '".$RuserID."' and U.usrcrt_emp_id='".$RempID."' ");

$crtcnt = QV("select count(*) as cnt FROM usr_certs WHERE usrcrt_usr_id = '".$RuserID."' and usrcrt_emp_id='".$RempID."' ");

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
		$num = $num + 1; 
		
		$mcnt = QV("Select count(*) as cnt from usr_certs U LEFT JOIN job_certs J ON U.usrcrt_crt_id = J.jobcrt_crt_id where U.usrcrt_usr_id = '".$RuserID."' and J.jobcrt_job_id = '".$jobID."' and U.usrcrt_crt_id = '".$pd['usrcrt_crt_id']."'");
		
		//echo "[Select count(*) as cnt from usr_certs U LEFT JOIN job_skills J ON U.usrcrt_crt_id = J.jobskl_skl_id where U.usrcrt_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrcrt_crt_id = '".$pd['usrcrt_crt_id']."']<br>";
		
		$fcolor = "black";
		
		if ($mcnt > 0)
			$fcolor = "blue" ; ///"#11fe27"; // "red";		
		
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['usrcrt_title']."</font><br>"; 
	} 
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
$geoData = Q2T("SELECT U.*, C.* FROM usr_geos U LEFT JOIN cat_geos C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' and U.usrskl_emp_id='".$RempID."' ");

$geocnt = QV("select count(*) as cnt FROM usr_geos WHERE usrskl_usr_id = '".$RuserID."' and usrskl_emp_id='".$RempID."' ");

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
		$num = $num + 1; 
		
		$mcnt = QV("Select count(*) as cnt from usr_geos U LEFT JOIN job_geos J ON U.usrskl_skl_id = J.jobskl_skl_id where U.usrskl_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrskl_skl_id = '".$pd['usrskl_skl_id']."'");
		
		//echo "Select count(*) as cnt from usr_geos U LEFT JOIN job_geos J ON U.usrskl_skl_id = J.jobskl_skl_id where U.usrskl_usr_id = '".$RuserID."' and J.jobskl_job_id = '".$jobID."' and U.usrskl_skl_id = '".$pd['usrskl_skl_id']."'"; exit();
		
		$fcolor = "black";
		
		if ($mcnt > 0)
			$fcolor = "blue"; //"#11fe27"; // "red";
		else {
			
			$stateID = Q2T("SELECT C.* FROM job_geos J LEFT JOIN cat_geos C ON C.catskl_id = J.jobskl_skl_id WHERE J.jobskl_job_id = '".$jobID."' ");
			
			if ($stateID){
								
				foreach ($stateID as $row) {
							
					$all = Q2T("SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."'");
						
					if ($all){
						foreach ($all as $id) {
							$JobstateAbbr = substr($id['catskl_label'],0,2);
							$UsrstateAbbr = substr($pd['usrskl_title'],0,2);
							$abbrALL = $JobstateAbbr."-ALL";

							if ($id['catskl_all_ind'] == 1) {
								//$JobstateAbbr = substr($id['catskl_label'],0,2);
								//$UsrstateAbbr = substr($pd['usrskl_title'],0,2);
							
								if ($JobstateAbbr == $UsrstateAbbr)
									$fcolor = 'red';
							}
							else {
								//echo "abbrALL[ ".$abbrALL." ]<br>usrskl_title[ ".$pd['usrskl_title']." ]<br>";
								if ($pd['usrskl_title'] == $abbrALL)
									$fcolor = 'red';
							}
						}
					}
				}
			}
		}
		
		
		$shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['usrskl_title']."</font><br>"; 
	}
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
