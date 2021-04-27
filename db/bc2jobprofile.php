<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Job Profile";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
//$template = "jobcon"; 
//$response = "content"; 
//require "inc/core.php";
$_SESSION['$usempempid'] = ""; //  "_empid"; 
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

$_SESSION['view_id'] = $userID;

//echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'].'<br><br>';   $_SESSION['passprofile_usr']  $_SESSION['passprofile_emp']

$userCompany = $_SESSION['usr_company'];
if ($_REQUEST['emp_id']){ 
    $userCompany= $_REQUEST['emp_id'];
    $emp_ID =  $_REQUEST['emp_id'];
    $_SESSION['passprofile_emp'] = $emp_ID;
    
} else
{  
 $userCompany= $_SESSION['passprofile_emp'];
    $emp_ID =  $_SESSION['passprofile_emp'];
}
    
 if ($_REQUEST['usr']){     
    $userID= $_REQUEST['usr'];
     $_SESSION['passprofile_usr'] = $userID;
    
} else
{  
   $userID =  $_SESSION['passprofile_usr'];
}
//echo $userCompany.' - '.$userType;exit();
$passprofile_usr  =  $_SESSION['passprofile_usr'] ;
$passprofile_emp = $_SESSION['passprofile_emp'];   //  usr  $passprofile_usr    company_id  $passprofile_emp

$emp_level = QV("SELECT emp_level from emp where emp_id =" . $emp_ID. "");
//echo $_SESSION['usr_auth'];
//exit();

if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_emp.php\';\" >Return to Employers List</div>");';

$empSection=@$_REQUEST['empSection'] or $empSection=@$_SESSION['empSection'] or $empSection="pst"; $_SESSION['empSection']=$empSection;

//$content .= "!!!!" . $empSection . "!!!!" . print_r($_REQUEST,true). print_r($_SESSION,true);

$opRec = CleanI($_REQUEST['rec']);
//echo "SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'";
//exit();
//$empID = QV("SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'");
$empID = $emp_ID;
//echo $empID; exit();

$content .= DBContent();


$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".CleanI($_REQUEST['profileID'])."'");
$RuserID = CleanI($_REQUEST['profileID']);
$empname = QV("SELECT emp_name from emp where emp_id = '".$empID."';");
/*
if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}
*/
//$content .= ' <br/><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname']. '<br/> ' ; 
 $content .= ' <br/><div style="text-align:center;">' . $_SESSION['usr_firstname'] . ' ' . $_SESSION['usr_lastname']. '<br/> ' ; 

$content .=  $empname .  '</div>';  
if (($userType == 0) && ($usrData['usr_type'] == 1)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}

if ($userType == 99) {
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/bc2_admins.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';	
}

//$content .= '<br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="555" align="center">
<tbody>
<tr>
<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'&company_id='.$emp_ID.' ">Member Profile</a></td>
<td><a href="/'.$_SESSION['env'].'/bc2members'.$usempempid.'.php?usr='.$passprofile_usr.'&company_id='.$passprofile_emp.' ">Return to Dashboard</a></td>';

if (($emp_level > 1) || $userType==99 )
{
$content .= '<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$passprofile_usr.'&company_id='.$passprofile_emp.'">Build Your Team</a></td>';

$content .= '<td><a href="/'.$_SESSION['env'].'/p_admins.php?usr='.$passprofile_usr.'&company_id='.$passprofile_emp.'">Search Members</a></td>';
}

//<!--td><a href="/'.$_SESSION['env'].'/bc2members'.$usempempid.'.php?usr='.$passprofile_usr.'&company_id='.$passprofile_emp.'">Return to Dashboard</a></td>';  //  usr  $passprofile_usr    company_id  $passprofile_emp -->

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
$company = Q2R("select E.* from emp E LEFT JOIN usr_emp U ON E.emp_id = U.usremp_emp_id where U.usremp_usr_id in (select job_emp_id from job where job_id = '".$RuserID."' )");
//$contact_info =QV("SELECT fed_contact FROM FBO_IMPORT WHERE Solicitation_num like '". $jobdetails['job_solicitation']. "' ;"); //  'FA483019Q0014';

echo $contact_info;

$content .= "<!--  br> trace 137 contact_info query: SELECT fed_contact FROM FBO_IMPORT WHERE Solicitation_num like '". $jobdetails['job_solicitation']. "' " ."resulting in " . $contact_info. " -->";
$content .= "<!--  br> trace 138 company query: select E.* from emp E 
      LEFT JOIN usr_emp U ON E.emp_id = U.usremp_emp_id where U.usremp_usr_id in (select job_emp_id from job where job_id = '".$RuserID."' )  -->";
$union = QV("select C.catedu_text from cat_edu C LEFT JOIN job J ON C.catedu_level = J.job_edu_level where J.job_id = '".$RuserID."' ");
$clr = QV("select C.catclr_title from cat_clearance C LEFT JOIN job J ON C.catclr_rank = J.job_clearance where J.job_id = '".$RuserID."' ");

$content .= '<center><div><h2 style="text-align: center;"><span style="background-color: #ffffff;"><strong>Job Profile</strong></span></h2>';
$content .= '<div style="text-align:center;"><strong>Title: </strong>' . $jobdetails['job_title'] . '</div><br><br>';


$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';
// ""#11fe27">*A <strong>GREEN "#11fe27"  for red RED
$content .='
<tr><td bgcolor="#FFFFFF" style="padding:10px"><font color =  "blue" >*A <strong>BLUE</strong> hightlight indicates that you MATCHED on that criteria.</font></td></tr>';
	
$content .= '</tbody>
</table></tbody>
</table><br>';




$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990" style="min-height: 250px;">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="2" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Company Information</strong></td>
</tr>
<tr><td width="990" colspan="2" bgcolor="#808080" align="left">&nbsp;</td></tr>
<tr>';
if ( !( $company['fed_id'] ) || ($company['fed_id'] == 0))
 { $displayCompanylabel = "Company Name";
  } else
  { $displayCompanylabel = "Agency-Office";   //lloyf 2/12/19 tojo request
  }
$content .='
<tr><td bgcolor="#E8E8E8" style="padding:10px;min-height: 200px;"><strong>'.$displayCompanylabel.':</strong> '.$company['emp_name'].'</td></tr>';
/* commented at at tojo request <tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Address:</strong> '.$company['emp_address'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Email:</strong> '.$company['emp_email'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Phone:</strong> '.$company['emp_phone'].'</td></tr>
<tr><td bgcolor="#E8E8E8" style="padding:10px"><strong>Fax:</strong> '.$company['emp_fax'].'</td></tr>';	
	*/	
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
		
		 //// ""#11fe27">*A <strong>GREEN  for red RED BLUE for green
			$content .= '<p>&nbsp;<strong>Solicitation URL:</strong> <br>&nbsp;<a href="'.$jobdetails['job_solicitation_link'].'" target="_blank"><b><font color="blue" >'.$jobdetails['job_solicitation_link'].'</font></b></a></p>';
		}
		else
		{
			$content .= '<p>&nbsp;<strong>Solicitation URL:</strong> <b><font color="blue">N/A</font></b></p>';
		}	
		/*  lloyd 12/20/18 lloyd*/
		//$matchDeadline = str_replace("-","",$match['job_due_date']);  //str_replace(find,replace,string,count)  for sort will format later
			/* while duedate format is still 20dd-mm-yy need to reformat as
			    yy-mm-dd  */
			    /* 1/3/19 now it is yyyy-mm-dd */
			 $reformatDeadline  = $jobdetails['job_due_date'] ;  /////$match['job_due_date'];    //20dd-mm-yy
			 $reformatDeadline = str_replace("-","",$reformatDeadline);   // now 20ddmmyy
			 /* -> Here:  ROMOVE WHEN DATE FIXED*/
			  $displayDay = substr($reformatDeadline,6,2);
			      $displayMonth =  substr($reformatDeadline,4,2);
			       $displayYear =  substr($reformatDeadline,2,2);
			     $reformatDeadline =   $displayMonth. '-'. $displayDay. '-'. $displayYear;    //  $displayYear. $displayMonth. $displayDay;     //now yymmdd
		/* $content .= '<br>jobprof line190 reformatDeadline: '. $reformatDeadline . 'displayMonth-displayDay-displayYear: ' .  $displayMonth. '-'. $displayDay. '-'. $displayYear .'<br>';    
		  to here */
         /* and replace this $content .='<p>&nbsp;<strong>Due Date:</strong> '.$jobdetails['job_due_date'].'</p> with this: */
$content .='<p>&nbsp;<strong>Due Date:</strong> '. $reformatDeadline.'</p>
        <p>&nbsp;<strong>Buying Office:</strong> '.$jobdetails['job_buying_office'].'</p></td>
		
<td width="470" bgcolor="#E8E8E8" align="left" valign="top">';
//  if ($contact_info)                                        //( ( $company['emp_contact'] ) && ($company['emp_contact'] <> '') && ($company['emp_contact'] <> ' '))
// {
//		$content .='<p>&nbsp;<strong>Contact Information:</strong></p> 	';//  <p>'. $company['emp_contact']. '</p>'		  ;
//		$content .="<p> ". $contact_info . "";  
// }
    if ($jobdetails['fed_id'] == 0)
    {
	    $content .='<p>&nbsp;<strong>First Name:</strong> '.$jobdetails['job_first_name'].'</p>
            <p>&nbsp;<strong>Last Name:</strong> '.$jobdetails['job_last_name'].'</p>
            <p>&nbsp;<strong>Email Address:</strong> '.$jobdetails['job_email_address'].'</p>
            <p>&nbsp;<strong>Phone:</strong> '.$jobdetails['job_phone'].'</p></td>';
    }
    else
     {

       $contact_info =QV("SELECT contact_info FROM FBO_IMPORT WHERE fed_id = '". $jobdetails['fed_id']. "' ;");
       
       //echo $contact_info."<br>"; exit();
       
       $content .='<p>&nbsp;<strong>Contact Info:<br><br></strong> '.$contact_info.'</p>';
       
     /**  
       if ($jobdetails['job_contact_email'] != "")
            $content .='<p>&nbsp;<strong>Email Address:</strong> '.$jobdetails['job_contact_email'].'</p>';
            
       if ($jobdetails['job_phone'] != "")
            $content .='<p>&nbsp;<strong>Phone:</strong> '.$jobdetails['job_phone'].'</p>';
       
     **/
     
       $content .='</td';
       
    }

		
$content .=' </td></tr>
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
$sklcnt = QV("select count(*) as cnt FROM job_skills WHERE jobskl_job_id = '".$RuserID."' ");
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
//echo 'NAICS [ '.$pd['catskl_id'].' ] USERID [ '.$userID.' ]'; exit();

$num = 0;
if ($sklData) {
	foreach ($sklData as $pd){ 
		$mcnt = QV("SELECT count(*) as cnt FROM usr_skills WHERE usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and usrskl_skl_id = '".$pd['catskl_id']."'");
		$fcolor = "black";
		if ($mcnt > 0)
			$fcolor = "blue" ; // "#11fe27"; //"red";	
		 //// ""#11fe27">*A <strong>blue for GREEN  for red RED
	
		$num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catskl_label']."</font><br>"; }
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
			$fcolor = "blue"; // "#11fe27"; // "red";	
	
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
			$fcolor = "blue" ; //  "#11fe27"; // "red";

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
		if ($mcnt > 0 )
			$fcolor = "blue" ; // "#11fe27"; // "red";
		
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


if ($crtData) {
    foreach ($crtData as $pd){
	    if ($pd['jobcrt_desc'] == 'NONE')
	    {
	       $crtcnt = 0;
	    }
    }
}


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
	    if ($pd['jobcrt_desc'] != 'NONE')
	    {
		    $mcnt = QV("SELECT count(*) as cnt FROM usr_certs WHERE usrcrt_usr_id = '".$userID."' and usrcrt_emp_id = '".$emp_ID. "' and usrcrt_crt_id = '".$pd['catcrt_id']."'");
		    $fcolor = "black";
		    if ($mcnt > 0)
			    $fcolor = "blue" ; // "#11fe27"; // "red";
	        $num = $num + 1; $shownum = $num; if ($shownum < 10) $shownum = "0".$shownum; $content .= "&nbsp;<b>(".$shownum.") - </b>&nbsp;<font color='".$fcolor."'>".$pd['catcrt_name']."</font><br>"; 
	    } 
	    else
	    {
	        $content .= "&nbsp;No Certifications selected";
	    }
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
		
	    $allcnt = QV("SELECT count(*) as cnt FROM usr_geos WHERE usrskl_title like '%- ALL%' and usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and substring(usrskl_title,1,2) IN (SELECT substring(catskl_label,1,2) FROM cat_geos WHERE catskl_id = '".$pd['catskl_id']."')");

		//echo "SELECT count(*) as cnt FROM usr_geos WHERE usrskl_title like '%- ALL%' and usrskl_usr_id = '".$userID."' and usrskl_emp_id = '".$emp_ID. "' and substring(usrskl_title,1,2) IN (SELECT substring(catskl_label,1,2) FROM cat_geos WHERE catskl_id = '".$pd['catskl_id']."')";
		
		$fcolor = "black";
		if (($mcnt > 0) || ($allcnt > 0))
			$fcolor = "blue"; // "#11fe27"; // "red";
		
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
