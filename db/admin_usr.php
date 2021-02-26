<?php 

// Administrator Interface

//-- page settings
define('C3cms', 1);
$title = "Admin";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
//$template = "jobcon"; // standard, mobile, other, ... ?
$response = "content";    // content, ajax ... ?
////require "inc/core.php";
$template = "jobcon"; 
require "inc/core.php";

//-- define content -----------------------------------------------------------------
$footerScript .= " ";
$adminNav = "";
$scriptLinks .= '<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
				<script type="text/javascript" language="javascript" src="js/jquery.colorbox.js"></script>
				<script type="text/javascript" language="javascript" src="js/jquery.jeditable.js"></script>';
$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/colorbox.css" />';
				
$defaultShow = 'users'; if (isset($_REQUEST['show'])) $defaultShow = $_REQUEST['show'];
if (isset($_REQUEST['request'])) if ($_REQUEST['request']=='ajax') $response = "ajax";
// lloyd mult cos per usreump-assignedusr_id
// see request 
//$content .= print_r($_SESSION);
//$content .= '<br><br> '.print_r($_REQUEST);$userCompany = $_SESSION['usr_company']; // this may now of a different company rather than one origianally tied to the usr_id
//echo $userCompany.' - '.$userType;exit();
/*
http://www.bc2match.com/bc2dev/admin_usr.php?usr=810668&ptype=admin.&userCompany=790819
*/
$userCompany = $_SESSION['usr_company']; // this may now of a different company rather than one origianally tied to the session usr_id
$content .= "<!-- br> trace 29 b4 use reqa userID = " .$userID . ", userCompany = " . $userCompany . " (= sess usr_company)";
$content .= "<br> 30 rEQUEST [usr] = ". $_REQUEST['usr'] . ",  REQUEST [empid]= "  . $_REQUEST['empid'] ;
$content .= "<br> 34 SESSION['usr_auth']: ". $_SESSION['usr_auth'] ."-->";
  if (isset($_REQUEST['usr']) ) $userID= $_REQUEST['usr'];
  if (isset($_REQUEST['userCompany'])) $userCompany = $_REQUEST['userCompany'];
   if (isset($_REQUEST['empid'])) $userCompany = $_REQUEST['empid'];
 
  
  $content .= "<!-- br> trace 37b4 use req vars now userID = " .$userID . ", userCompany = " . $userCompany . " ( -->";

 


$thisusername =  QV("Select usr_email from usr where usr_id = ".$_REQUEST['usr'] . " ");
$thiscompany_name = QV("Select emp_name from emp where emp_id =". $userCompany . " ");
$thisusr_firstname = QV("Select usr_firstname from usr where usr_id = ".$_REQUEST['usr'] . " ");
$thisusr_lastname = QV("Select usr_lastname from usr where usr_id = ".$_REQUEST['usr'] . " ");
$thisusr_usrtype = QV("Select usr_type from usr where usr_id = ".$_REQUEST['usr'] . " ");


  //'  adm_usr line 25 userCompany: '.$userCompany. ', thiscompany_name: '. $thiscompany_name
 //$content .= ' <div style="font-size: 16px; font-family: arial; text-align:center; width:100%; ">'. $thisusr_firstname .' ' . $thisusr_lastname. 
 //                 ' <br>'. $thiscompany_name
 //                 .'</div>';
/* this goes as a subheader   !!!!
$usrData = Q2R(" Select   usr.usr_email, usr.usr_firstname as usr_firstname, usr.usr_lastname as usr_lastname , usr.usr_type ,emp.emp_id, emp.emp_name as emp_name
                  , usemp.usremp_usr_assignedusr_id as usr_id, usemp.usremp_emp_id 
                  from usr usr inner join emp emp on usr.usr_company =  emp.emp_id  
                               inner join usr_emp usemp on emp.emp_id  = usemp.usremp_emp_id  
                  WHERE usemp.usremp_usr_assignedusr_id ='".$usr_ID."' and emp.emp_id = '".$empID."' "  );
//$content .= ' <br/><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname']. '<br/> ' ; 
//$content .=  $usrData['emp_name'] .  '</div>';
session_status() 
Return Values ¶
PHP_SESSION_DISABLED if sessions are disabled.
PHP_SESSION_NONE if sessions are enabled, but none exists.
PHP_SESSION_ACTIVE if sessions are enabled, and one exists.
*/
//---------- sub navigation   >= change >=5 to >=2
/****
$nav2 = "  
	".(((intval($_SESSION['usr_auth']) >= 2)) ? "<span onclick='window.location.href=\"admin_usr.php\";'>User Management</span>" : "")."
	". ' <div style="font-size: 16px; font-family: arial; text-align:center; width:100%; ">'. $thisusr_firstname .' ' . $thisusr_lastname.'&nbsp;&nbsp;&nbsp; 
               &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
               <br>'. $thiscompany_name.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;</div>' . " 
	".(((intval($_SESSION['usr_auth_orig']) == 8)) ? "<span onclick='window.location.href=\"admin_emp.php\";'>Company Management</span>" : "");
	//".(((intval($_SESSION['usr_auth']) >= 4)) ? "<span onclick='window.location.href=\"admin_rep.php\";'>Reports</span>" : "");	
	//".(((intval($_SESSION['usr_auth']) >= 3)) ? "<span onclick='window.location.href=\"admin_app.php\";'>Applicants</span>" : "")."
	//".(((intval($_SESSION['usr_auth']) >= 3)) ? "<span onclick='window.location.href=\"admin_lst.php\";'>Lists</span>" : "")."
	//".(((intval($_SESSION['usr_auth']) >= 6)) ? "<span onclick='window.location.href=\"admin_con.php\";'>Page Content</span>" : "")."
	//".(((intval($_SESSION['usr_auth']) >= 6)) ? "<span onclick='window.location.href=\"admin_med.php\";'>Media / Images</span>" : "")."
	//".(((intval($_SESSION['usr_auth']) >= 4)) ? "<span onclick='window.location.href=\"admin_rep.php\";'>Reports</span>" : "");
***/


//---------- user view checkboxes
//$CBshowInactive=@$_REQUEST['CBshowInactive'] or $CBshowInactive=@$_SESSION['CBshowInactive'] or $CBshowInactive='true'; $_SESSION['CBshowInactive']=$CBshowInactive;
//$CBshowApp=@$_REQUEST['CBshowApp'] or $CBshowApp=@$_SESSION['CBshowApp'] or $CBshowApp='true'; $_SESSION['CBshowApp']=$CBshowApp;
$CBshowEmp=@$_REQUEST['CBshowEmp'] or $CBshowEmp=@$_SESSION['CBshowEmp'] or $CBshowEmp='true'; $_SESSION['CBshowEmp']=$CBshowEmp;
//$CBshowMan=@$_REQUEST['CBshowMan'] or $CBshowMan=@$_SESSION['CBshowMan'] or $CBshowMan='true'; $_SESSION['CBshowMan']=$CBshowMan;
//$CBshowCEO=@$_REQUEST['CBshowCEO'] or $CBshowCEO=@$_SESSION['CBshowCEO'] or $CBshowCEO='true'; $_SESSION['CBshowCEO']=$CBshowCEO; 
//$CBshowDev=@$_REQUEST['CBshowDev'] or $CBshowDev=@$_SESSION['CBshowDev'] or $CBshowDev='true'; $_SESSION['CBshowDev']=$CBshowDev; 
//$CBshowPro=@$_REQUEST['CBshowPro'] or $CBshowPro=@$_SESSION['CBshowPro'] or $CBshowPro='true'; $_SESSION['CBshowPro']=$CBshowPro; 
//$CBshowDir=@$_REQUEST['CBshowDir'] or $CBshowDir=@$_SESSION['CBshowDir'] or $CBshowDir='true'; $_SESSION['CBshowDir']=$CBshowDir; 
$CBshowAdm=@$_REQUEST['CBshowAdm'] or $CBshowAdm=@$_SESSION['CBshowAdm'] or $CBshowAdm='true'; $_SESSION['CBshowAdm']=$CBshowAdm; 


//---------- users table

$auths = array();
if ($CBshowInactive=="true") $auths[] = 0;
if ($CBshowApp=="true") $auths[] = 1;
if ($CBshowEmp=="true") $auths[] = 2;
if ($CBshowMan=="true") $auths[] = 3;
if ($CBshowCEO=="true") $auths[] = 4; 
if ($CBshowDev=="true") $auths[] = 5; 
if ($CBshowPro=="true") $auths[] = 6; 
if ($CBshowDir=="true") $auths[] = 7; 
if ($CBshowAdm=="true") $auths[] = 8; 
//if ($CBshowEmp=="true") $auths[] = 9;


$uauth_check = 99;

if ($_REQUEST['ptype'] == 'admin'){
	
	$uauth = "select * from usr where usr_id = ".CleanI($_REQUEST['usr']); 
	// need to join with usr_emp to get other usrs usr_if in usemp.usremp_usr_assignedusr_id as usr_id,
	
	$myval = Q2T($uauth);
	
	foreach($myval as $uauth_val){
	
		if ($uauth_val['usr_auth'] == 8)
			$sqlGetUsers = "SELECT * FROM usr WHERE usr_auth IN (".implode(",",$auths).")";
		else
			$sqlGetUsers = "SELECT * FROM usr WHERE usr_auth IN (".implode(",",$auths).") and usr_company ='".$uauth_val['usr_company']."'"; 
	
		$uauth_check = $uauth_val['usr_auth'];
	}
}
else {
		$sqlGetUsers = "SELECT * FROM usr WHERE usr_auth IN (".implode(",",$auths).")";
}		
////$sqlGetUsers = "SELECT u.*,ue.usremp_usr_assignedusr_id FROM usr u inner join usr_emp ue on u.usr_id= ue.usremp_usr_assignedusr_id 
  ////  where ue.usremp_emp_id = ". $userCompany . " ";



//echo "[ ".$user_type." ]"; exit();
if ($thisusr_usrtype == "1")
{
    // so admin can do a company not his lloyd 3/4/19  
    $sqlGetUsers = "SELECT u.*,ue.usremp_usr_assignedusr_id FROM usr u inner join usr_emp ue on u.usr_id= ue.usremp_usr_assignedusr_id 
        where ue.usremp_usr_assignedusr_id = ".$_REQUEST['usr']. " and ue.usremp_emp_id = ". $userCompany . " "; 
}
else
{
    // so admin can do a company not his lloyd 3/4/19  
    $sqlGetUsers = "SELECT u.*,ue.usremp_usr_assignedusr_id FROM usr u inner join usr_emp ue on u.usr_id= ue.usremp_usr_assignedusr_id 
        where ue.usremp_emp_id = ". $userCompany . " "; 
}
    

$content .= "<!-- br> 139!-- admin_usr 135 sqlGetUsers"  . $sqlGetUsers ." --> ";   
$userTable = Q2T($sqlGetUsers);


//** Removed Contact column - LJF **//
// <thead><tr><th>ID</th><th>Type</th><th>First Name</th><th >Last Name</th><th >Email</th><th >Contact</th><th style="width:195px;">Actions</th></tr></thead>
$users2 = '
<br/><table id="usersTable" class="grid" cellpadding="4" cellspacing="0" style="width:984px;">
	<thead><tr><th>ID</th><th>Type</th><th>First Name</th><th >Last Name</th><th >Email</th><th style="width:250px;">Actions</th></tr></thead>
	<tbody>';
	
if ($userTable) foreach($userTable as $ut) {
//	$userColor = ($ut['usr_active']=='A'?'cfc':($ut['usr_active']=='I'?'fcc':($ut['usr_active']=='P'?'ccf':'000'))); // use usr_auth instead

	$userColor = '';
//	switch($ut['usr_auth']) {
//		case '0': $userColor = 'aaa'; break;
//		case '1': $userColor = 'cfc'; break;
//		case '2': $userColor = 'ff0'; break;
//		case '3': $userColor = '0f0'; break;
//		case '4': $userColor = '40DF7E'; break;
//		case '5': $userColor = '99d'; break;
//		case '6': $userColor = '69E9FF'; break;
//		case '7': $userColor = 'dd99aa'; break;
//		case '8': $userColor = 'fff'; break;
//	}

	switch($ut['usr_type']) {
		case '0': $userColor = '0f0'; break;
		case '1': $userColor = 'ff0'; break;
		case '99': $userColor = 'fff'; break;
	}	

	$users2 .= '<tr style="background:#'.$userColor.'"><td>'.$ut['usr_id'].'</td><td>';
//	switch($ut['usr_auth']) {
//		case '0': $users2 .= 'Inactive'; break;
//		case '1': $users2 .= 'Applicant'; break;
//		case '2': $users2 .= 'Job Poster'; break;
//		case '3': $users2 .= 'Case Manager'; break;
//		case '4': $users2 .= 'CEO'; break;
//		case '5': $users2 .= 'Developer'; break;
//		case '6': $users2 .= 'Prog. Mgr.'; break;
//		case '7': $users2 .= 'Director'; break;
//		case '8': $users2 .= 'Admin'; break;
//	}
	switch($ut['usr_type']) {
		case '0': $users2 .= 'Primary'; break;
		case '1': $users2 .= 'User'; break;
		case '99': $users2 .= 'BC2 Admin'; break;
	}

	
	$users2 .= '</td><td>'.$ut['usr_firstname'].'</td><td>'.$ut['usr_lastname'].'</td><td>'.$ut['usr_email'].'</td>';
	
/** Removed Contact info popup - LJF 
	<td >
		<div onclick=\'
		if (this.offsetHeight>80) {
//			$(this).animate({height: "16", width: "50"}, 500 );
			$(this).find("div").hide(1000);
			$(this).find("div").find("div").hide(1000);
			$(this).find("span").show(1000);
		} else {
//			$(this).animate({height: "100", width: "220"}, 500 );
			$(this).find("div").show(1000);
			$(this).find("div").find("div").show(1000);
			$(this).find("span").hide(1000);
			}
		\'><span style=\'color:#00f;\'>&nbsp;&nbsp;&nbsp;View</span><div style=\'margin: -4px; padding: 4px;display:none;background:#fff;\'>'.
		($ut['usr_addr1']!=''?$ut['usr_addr1'].'<br/>':'').
		($ut['usr_addr2']!=''?$ut['usr_addr2'].'<br/>':'').
		($ut['usr_addr3']!=''?$ut['usr_addr3'].'<br/>':'').
		(($ut['usr_city']!='' && $ut['usr_state']!='' && $ut['usr_zip']!='')?$ut['usr_city'].', '.$ut['usr_state'].'&nbsp;&nbsp;'.$ut['usr_zip'].'<br/>':'').
		($ut['usr_phone']!=''?'<div style="background:#ffd;">Phone 1:'.$ut['usr_phone'].'</div>':'').
		($ut['usr_phone2']!=''?'<div style="background:#ddd;">Phone 2:'.$ut['usr_phone2'].'</div>':'').
		($ut['usr_fax']!=''?'<div style="background:#efe;">Fax: '.$ut['usr_fax'].'</div>':'').
		($ut['usr_website']!=''?'<div style="background:#ddf;">Website: '.$ut['usr_website'].'</div>':'').'</div>
		</div>
	</td>
	
***/

	$users2 .= '<td style = "width: 180px;" >';
	$holdusr_auth = $ut['usr_auth'];

//** Added condition to show Dashboard only if user_type = Primary LJF **//		
if (($thisusr_usrtype == "0") || ($_SESSION['usr_auth_orig'] == 8))	
{
	switch ($ut['usr_auth']){
		//case '1':$users2 .= '<a href="applicants.php?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Dashboard</a>';break;
		//case '9':$users2 .= '<a href="employers.php?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Dashboard</a>';break;
	    case '2': 
		//	if ((($ut['usr_type'] == 1) || ($ut['usr_type'] == 0) )  || ($_SESSION['usr_auth_orig'] == 8)){
		//	$users2 .= '<a href="bc2members.php?usr='.$ut['usr_id'].'&ptype=dashboard&empid='.$userCompany.'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Dashboard</a>';
		//	}
			break;
		case '3':$users2 .= '<a href="managers.php?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Manage</a>';break;
	}
}	
	//<a class="emailUser" href="admin_usr?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Email</a>
			    if ($_SESSION['usr_auth'] != '9')
				{
					//<a class="editUser" href="admin_usr?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">[Edit Contact Info]</a>
					$users2 .= '<a href="forgot.php?action=change&usr='.$_REQUEST['usr'].'&userCompany='.$userCompany.'&email='.$ut['usr_email'].'">[Change Password]</a>';
				}
				else
				{
					$users2 .= '[No actions for BC2 Admins]';
				}

//** Added condition to show Remove only if user_type = Primary - LJF **//		
	    if ($thisusr_usrtype == "0")
		    $user2 .= '<a class="removeUser" href="admin_usr?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Remove</a>';

$user2 .='
	</td>
</tr>';
}
$users2 .= '	</tbody>
</table>
';

//---------- compile content
					//<td style='background:#aaa'>Inactive<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowInactive' ".($CBshowInactive=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#cfc'>Applicants<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowApp' ".($CBshowApp=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#ff0'>Job Poster<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowEmp' ".($CBshowEmp=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#0f0'>Case Managers<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowMan' ".($CBshowMan=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#40DF7E'>CEO<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowCEO' ".($CBshowCEO=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#99d'>Developer<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowDev' ".($CBshowDev=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#69E9FF'>Program Manager<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowPro' ".($CBshowPro=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#dd99aa'>Director<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowDir' ".($CBshowDir=="true"?"checked='checked'":'')."/></td>
					//<td style='background:#fff'>Administrator<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowAdm' ".($CBshowAdm=="true"?"checked='checked'":'')."/></td>

//** Added condition to show Seat info only if the user_type is Primary - LJF **//

//if ($thisusr_usrtype == "0")
//{
$sqlGetEmpSeats = "SELECT emp_id, emp_name, emp_level,emp_seats_occupied,emp_number_seats  FROM emp where emp_id ='".$userCompany."'"; // lloyd 3/6/19$_SESSION['usr_company']."'";
 $thisrowseats =  Q2R($sqlGetEmpSeats);
 if ( $thisrowseats)
    { $emp_seats_occupied = $thisrowseats['emp_seats_occupied'];
      $emp_number_seats = $thisrowseats['emp_number_seats'];
      $emp_level =  $thisrowseats['emp_level'];
      $emp_name = $thisrowseats['emp_name'];
      
    }else { 
        $emp_seats_occupied =-99;
      $emp_number_seats  = -99;  // $emp_seats_occupied $emp_number_seats 
       $emp_level =  1;
       $emp_name = "Unknown";
    }
    $content .= "<!--br>257 userCompany =" . $userCompany ." 257 sqlGetempseats = " . $sqlGetEmpSeats . " emp_seats_occupied =" .$emp_seats_occupied . ",  emp_number_seats=" . $emp_number_seats. "-->";
    $levelquery = " SELECT MAX(subscription_level) as maxlevel,MIN(subscription_level) as minlevel FROM price_table ";
     $maxlevel =  QV($levelquery) ; // if (  $emp_level < $maxlevel)
   
    $thiscompany_name = str_replace(" ","%20",$thiscompany_name );
    $genericseatslevel='&generic_level='.$emp_level.'&generic_numseats='.$emp_number_seats.'&generic_numseatsoccupied='.$emp_seats_occupied;
	$genericnames= '&generic_usr_firstname='.$thisusr_firstname.'&generic_lastname='.$thisusr_lastname.'&generic_companyname='.$thiscompany_name;
	
	 
	$genericactioncompany ='&generic_actioncompany='.$genericactioncompanyaddseats;
	$genericactioncompanyaddseats='3';
	$genericactionupgradelevel='4';
    $thisptype=$_REQUEST['ptype'];
	$locationhref='location.href=';
// .'&empid='.$userCompany.'   lloyd 3/76/19 to admin another copany'
	$adduserlocationhref=$locationhref.'"joinnow.php?join_op=addnewuserexistcompany&frompage=manageaccount&usr='.$userID.'&ptype='.$thisptype.'&empid='.$userCompany.'&addnewuser_company_id='.$userCompany.'&addnewuser_assignedusr_id='.$userID.'&addnewuser_username='.$thisusername .'"'  ;
	 //upgradelevelexistcompany     addseatexistcompany  //&addnewuser_assignedusr_id='.$ut['usr_id'].'     $addnewuser_assignedusr_id
   	$genericactioncompanyupgrade='4';
	$genericactioncompany ='&generic_actioncompany='.$genericactioncompanyupgrade;

	// $upgradelevellocationhref=$locationhref.'"joinnow.php?join_op=upgradelevelexistcompany&frompage=manageaccount&ptype='.$thisptype;
//	 $upgradelevellocationhref.='&upgradelevel_company_id='.$userCompany.'&upgradelevel_assignedusr_id='.$ut['usr_id'].'&upgradelevel_username='.$ut['usr_email']   ;
	 	 $upgradelevellocationhref=$locationhref.'"joinnow.php?join_op=upgradelevelexistcompany&frompage=manageaccount&ptype='.$thisptype.'&usr='.$userID;
	 $upgradelevellocationhref.='&empid='.$userCompany.'&generic_company_id='.$userCompany.'&generic_assignedusr_id='.$userID.'&generic_username='.$thisusername   ;
  
    $upgradelevellocationhref.=$genericnames;
    $upgradelevellocationhref.= $genericseatslevel;
    $upgradelevellocationhref .= $genericactioncompany .'"';


//  $upgradelevel_company_id   $upgradelevel_assignedusr_id  $upgradelevel_username
	//// $addseatlocationhref=$locationhref.'"joinnow.php?join_op=addseatexistcompany&frompage=manageaccount&ptype='.$thisptype.'&addseat_company_id='.$userCompany.'&addseat_assignedusr_id='.$ut['usr_id'].'&addseat_username='.$ut['usr_email'] .'"'  ;
	$genericactioncompanyaddseats='3';
		$genericactioncompany ='&generic_actioncompany='.$genericactioncompanyaddseats;

$addseatlocationhref=$locationhref.'"joinnow.php?join_op=addseatexistcompany&frompage=manageaccount&ptype='.$thisptype.'&empid='.$userCompany.'&usr='.$userID;
	 $addseatlocationhref.='&generic_company_id='.$userCompany.'&generic_assignedusr_id='.$userID.'&generic_username='.$thisusername   ;
	  $addseatlocationhref.=$genericnames;
      $addseatlocationhref.= $genericseatslevel;
	 $addseatlocationhref .= $genericactioncompany .'"';
//$content .= ",<br>line 250; admin_usr addseatlocationhref:" . $addseatlocationhref;

//$content .= "<br><br>,line 252; admin_usr adduserlocationhref:" . $adduserlocationhref;

//$content .= "<br><br>,line 255; admin_usr upgradelevellocationhref:" .  $upgradelevellocationhref;
//$addseat_assignedusr_id   $addseat_company_id   $addnewuser_username


if ($thisusr_usrtype == 0)
{
$content .= "
  <div style='margin:10px;'>
	<div id='sec_users' style='display:block;'>
		<div>
			<table class='grid' cellpadding='4' cellspacing='0' style='display:inline-block;'>
				<tr><th colspan='9'>Display</th></tr>
				<tr id='userTypeControls' >
					<td style='background:#ff0'>Users<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowEmp' ".($CBshowEmp=="true"?"checked='checked'":'')."/></td>
					<td style='background:#fff'>Administrator<br/><input type='checkbox' onclick='CBtoggle(this);' name='CBshowAdm' ".($CBshowAdm=="true"?"checked='checked'":'')."/></td>
				</tr>
			</table>
			<table class='grid' cellpadding='4' cellspacing='0' style='display:inline-block;vertical-align:top;margin-left:5px;'>
				<thead><tr background:#cfc'><th colspan='4'>Admin Actions</th></tr></thead>
				<tbody><tr style='background:#cfc;'>
					<!--  td onclick='$(\"#addUserForm\").show(1000);$(\"#closeAddUBtn\").show(1000);'>Add User</td  -->";     //<tbody><tr style='background:#cfc;cursor:pointer;'>
	  if ($emp_seats_occupied < $emp_number_seats )	
         {
             $content .= '<td><input style="background-color:#cfc;cursor:pointer;border:0;" type="button" onClick='.$adduserlocationhref.' value="Add User" />  </td> ';	
         }else
         {
             $content .= '<td><input style="background-color:#cfc;border:0;" type="button"  disabled    />  
              <span style="text-decoration:line-through;font-size:10px;">Add User </span>
 		                            <br>  &nbsp;<span style="font-size:9px;">Need more seats</span></td> ';
 		                    
         }
         $ninespaces = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         $fivespaces = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
         

       $content .= '<td>';
       
         if ($emp_number_seats <> 5)
         {
             $content .= '<input type="button" style="background-color:#cfc;cursor:pointer;border:0;" onClick='.$addseatlocationhref.' value="Add Seat" />';
         }
                    $content .= '<br>&nbsp;<span style="font-size:9px;">Seats in Subscription: '. $emp_number_seats.'</span>  
                    <br>  &nbsp;<span style="font-size:9px;">Seats in Use: '.$ninespaces.$fivespaces.$emp_seats_occupied.'</span></td>';
        
        	
        if (  $emp_level < $maxlevel)
        { $content .= '<td><input type="button"  
           style="background-color:#cfc;border:0;" onClick='.$upgradelevellocationhref.' value="Upgrade Level" />  </td> ';
        }else
        {
           $content .= '<td><input type="button" disabled style="background-color:#cfc;border:0;"/>
            <span style="text-decoration:line-through;font-size:10px;">Upgrade Level </span>  
            <br> &nbsp;&nbsp; &nbsp;<span style="font-size:9px;">At max level</span></td> ';  
        }

	$content .= "					<!-- td onclick='$(\"#addSeatForm\").show(1000);$(\"#closeAddUBtn\").show(1000);'>Add Seat</td  -->
							<!-- td onclick='$(\"#upgradeLevelForm\").show(1000);$(\"#closeAddUBtn\").show(1000);'>UpgradeLevel</td -->
 '				</tbody></table>";
				
}	
else
{
$content .= "
  <div style='margin:10px;'>";

}				 

			//	$ content .= '	<table><tr><td > 
	 	//<a href="joinnow.php?join_op=addnewuserexistcompany&frompage=manageaccount&addnewuser_company_id='.$userCompany.'&addnewuser_username='.$ut['usr_email'].'"  >Add User</a></td>
	 		   
	 	//	 <td> <input type="button" onClick="'.$locationhref.'" value="Add User" /> Add User </td>  
        //            </tr>				</table> ';
		$content .= " 		</div>";
//} //End Show Primary - LJF
//else
//{  $content .= "<div style='margin:10px;'>";}


//if ($_SESSION['usr_auth_orig'] <> 8) 

switch($emp_level) {
		case '1': $LevelText = 'Silver'; $fillcolor='#C0C0C0'; break;
		case '2': $LevelText = 'Gold'; $fillcolor='#D4AF37'; break;
		case '3': $LevelText = 'Platinum'; $fillcolor='#E5E4E2'; break;
	}	
	
$content .= '<br><table width="555" border="2" cellpadding="5" align="center">
  <tbody>
    <tr>
      <th width="262" scope="col">Membership Level</th>
      <th width="259" bgcolor="'.$fillcolor.'" scope="col">'.$LevelText.'</th>
    </tr>
  </tbody>
</table>';



if (($uauth_check >= 2)||($holdusr_auth ==2) && ($_REQUEST['ptype'] == 'admin')){	
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="750" align="center">
<tbody>
<tr>
<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Member Profile</a></td>';
if (($emp_level > 1))
{	
$content .= '<td><a href="/'.$_SESSION['env'].'/p_admins.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Search Members</a></td>';
$content .= '<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Build Your Team</a></td>';
}
$content .='<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$_REQUEST['usr'].'&ptype=dashboard&empid='.$userCompany.'&company_id='.$userCompany.'">Return to Dashboard</a></td>';

if ($thisusr_usrtype == 0)
{
    $usremail = QV("select usr_email from usr where usr_id =".$_SESSION['passprofile_usr']);
    
	$company_cnt = QV("select count(*) as cnt from usr_emp where usremp_usr_id =".$_SESSION['passprofile_usr']);
	
    if ($company_cnt > 1)
    {
       $content .= '<td><a href="/'.$_SESSION['env'].'/bc2companydashboard'.$_SESSION['$usempempid'].'.php">Your Company List</a></td>';
	}	
	
	//if($emplevel > 1){
		$content .= '<td><a href="/'.$_SESSION['env'].'/joinnow'.$_SESSION['$usempempid'].'.php?join_op=startNewEmployer&usr='.$_SESSION['passprofile_usr'].'&contactEmail='.$usremail.'&userCompany='.$userCompany.'&membernewcompany=1">Add New Company</a></td>';
	//}
}



$content .= '</tr>
</tbody>
</table>
</div>';}
		
$content .= "<div id='addUserForm' style='display:none; margin:10px 0 5px 0; border:2px solid black; background:#cfc;border-radius:10px 0 0 0'>
			<form name='addUserForm' method='post' enctype='multipart/form-data' action='admin_usr.php' onsubmit='return validateForm()'>
				<input type='hidden' name='op' value='addUser' /><input type='hidden' name='show' value='users' />
				<table style='border:0px solid black;margin:5px;display:inline-block;vertical-align:top;'>".'
					<tbody>
					<tr  class="nonApp"><td>Prefix</td><td><input type="text" name="usr_prefix" value="" /></td></tr>
					<tr><td style="font-weight:800">First Name</td><td><input type="text" name="usr_firstname" value="" /></td></tr>
					<tr><td style="font-weight:800">Last Name</td><td><input type="text" name="usr_lastname" value="" /></td></tr>
					<tr><td style="font-weight:800">Email</td><td><input type="text" name="usr_email" value="" /></td></tr>
					<tr><td style="font-weight:800">Password</td><td><input type="text" name="usr_password" value="" /></td></tr>
					<tr><td style="font-weight:800">User Type</td><td>
						<select name="usr_type" onchange="if (this.value==0 || this.value==1) $(\'#newUserEmp\').show(1000); else $(\'#newUserEmp\').hide(1000);">
						    <option value="">--Select User Type--</option>
							<option value="1">User</option>
							<option value="0">Primary User</option>';
							if ($_SESSION['usr_auth_orig'] == 8) $content .= '<option value="99">BC2 Admin</option>';
							
						$content .= '</select>
						</td></tr>
					<tr id="newUserEmp" style="display:none;"><td style="font-weight:800">Company<hr/>Permissions</td>
						<td>
							<select name="usr_emp">';
							
$sqlGetEmp = "SELECT emp_id, emp_name FROM emp where emp_id ='".$_SESSION['usr_company']."'";
							
if ($_SESSION['usr_auth_orig'] == 8){
	$sqlGetEmp = "SELECT emp_id, emp_name FROM emp";
	$content .='<option value="">--Select Company--</option>';
}	

$valuetest = Q2T($sqlGetEmp);
//echo "[".$valuetest."]";

if (!empty($valuetest)){					
foreach(Q2T($sqlGetEmp) as $emp) $content.="<option value='".$emp['emp_id']."'>".$emp['emp_name']."</option>";
$content .='				</select><br/>
							<select name="emp_auth"><option value="*">Full Account</option><option value="ro">Read-Only</option></select>
						</td>
					</tr>';
}					
//					<tr id="newUserCaseManager" style="display:none;"><td style="font-weight:800">Case Manager</td>
//						<td>
//							<select name="usr_manager">
//							<option value="">--Select Case Manager--</option>';
//foreach(Q2T("SELECT usr_id, usr_firstname, usr_lastname FROM usr WHERE usr_auth = '3' ") as $mgr) $content.="<option value='".$mgr['usr_id']."'>".$mgr['usr_firstname']." ".$mgr['usr_lastname']."</option>";
//$content .='				</select>'.'
//						</td>
//					</tr>
$content .=' 	</tbody>
				</table>
				<table class="nonApp" style="border:0px solid black;margin:5px;display:inline-block;vertical-align:top;">
					<tbody>
					<tr><td>Address 1</td><td><input type="text" name="usr_addr1" value="" /></td></tr>
					<tr><td>Address 2</td><td><input type="text" name="usr_addr2" value="" /></td></tr>
					<tr><td>Address 3</td><td><input type="text" name="usr_addr3" value="" /></td></tr>
					<tr><td>City</td><td><input type="text" name="usr_city" value="" /></td></tr>
					<tr><td>State</td><td><input type="text" name="usr_state" value="" /></td></tr>
					<tr><td>Zip</td><td><input type="text" name="usr_zip" value="" /></td></tr>
					<tr><td>Country</td><td><input type="text" name="usr_country" value="" /></td></tr>
					</tbody>
				<table class="nonApp" style="border:0px solid black;margin:5px;display:inline-block;vertical-align:top;">
					<tbody>
					<tr><td>Phone</td><td><input type="text" name="usr_phone" value="" /> &nbsp;&nbsp;(000) 000-0000</td></tr>
					<tr><td>Phone 2</td><td><input type="text" name="usr_phone2" value="" /> &nbsp;&nbsp;(000) 000-0000</td></tr>
					<tr><td>Fax</td><td><input type="text" name="usr_fax" value="" /> &nbsp;&nbsp;(000) 000-0000</td></tr>
					<tr><td>Website</td><td><input type="text" name="usr_website" value="" /></td></tr>
					</tbody>
				</table>
				<div style="display:inline-block;vertical-align:top;margin:10px;">
					<input type="submit" value="Create User" /><input type="reset" value="Reset" /><input type="hidden" name="op" value="createUserSave" />
					Only bold fields are required! 
				</div>
			</form>
		</div>'.$users2."
	</div>
</div>";


$footerScript .= <<<EOS
$(document).ready(function() {
	$(".editUser").each(function() { $(this).colorbox({iframe:false, width:"650px", height:"600px", transition:"fade", scrolling: false, href: "admin_usr.php", data:{ op: "editUser", usr: getParameterByName($(this).attr("href"), "usr")  }})});
	$(".emailUser").each(function() { $(this).colorbox({iframe:false, width:"550px", height:"500px", transition:"fade", scrolling: false, href: "admin_usr.php", data:{ op: "emailUser", usr: getParameterByName($(this).attr("href"), "usr")  }})});
	$(".passwordUser").each(function() { $(this).colorbox({iframe:false, width:"450px", height:"300px", transition:"fade", scrolling: false, href: "admin_usr.php", data:{ op: "passwordUser", usr: getParameterByName($(this).attr("href"), "usr")  }})});
	$(".removeUser").each(function() { $(this).colorbox({iframe:false, width:"450px", height:"300px", transition:"fade", scrolling: false, href: "admin_usr.php", data:{ op: "removeUser", usr: getParameterByName($(this).attr("href"), "usr")  }})});
	var usersTable = $('#usersTable').dataTable( { iDisplayLength: 50 } );
	$( document ).tooltip();
} );

function getParameterByName(url, name){
  name = name.replace(/[\[]/,"\\\\\[").replace(/[\]]/,"\\\\\]");
  var regexS = "[\\\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec(url);
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function CBtoggle(obj){
	form = $("<form method='post'></form>");
	form.append('<input type="hidden" name="'+$(obj)[0].name+'" value="'+($(obj)[0].checked)+'" />');
	form.append('<input type="hidden" name="show" value="users" />');
	form.appendTo('body').submit();
}

function validateForm() {
    var x = document.forms["addUserForm"]["usr_emp"].value;
	var y = document.forms["addUserForm"]["usr_type"].value;
	
    if ((x == "") && (y != "99"))  {
        alert("You must select a company.");
        return false;
    }
}

EOS;

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; ?>
