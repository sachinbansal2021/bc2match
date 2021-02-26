<?php 

// Employer Members

//-- page settings 
define('C3cms', 1);
$title = "Change Member Password";
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
//$usrData = Q2R("SELECT * FROMusr WHERE usr_id = '".CleanI($_REQUEST['changepassword']). "'");     //  '".CleanI($_REQUEST['profileID'])."'");
 $usrData =  Q2R("Select usr.usr_id, usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type , emp.emp_name, emp.emp_id" 
			 . " from usr usr left join emp emp on usr.usr_company =  emp.emp_id " 
			  . "where usr_id = '".CleanI($_REQUEST['changepassword']). "'");
$RuserID =  CleanI($_REQUEST['changepassword']) ; // CleanI($_REQUEST['profileID']);


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
<tr>';

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

if (isset($_REQUEST['op'])) {
	switch ($_REQUEST['op']) {
		case "passwordUpdate":
			$ut = Q2R("SELECT * FROM usr WHERE usr_id = '".CleanI($_REQUEST['usr'])."'");
			if (isset($_REQUEST['sendMessage'])) {
					$tmp_content = "\nYour account password has been changed.  \n\nYour new password is:  " . Clean($_REQUEST['pass']) . "\n\n";
					mail($ut['usr_email'],"BC2Match Password Reset",$tmp_content,'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() );
			}
			
			$did = Q("UPDATE usr SET usr_password = '".sha1($_REQUEST['pass'])."' WHERE usr_id ='".CleanI($_REQUEST['usr'])."' ");
            $content .= '<br><div style="text-align:center;"><strong>Password for: </strong>' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] .' ('.$usrData['emp_name']. ') has been changed to: {'.$_REQUEST['pass'].' }</div><br>';
	}
}
else {

// re-uses Member profile 
$content .= '<div><h2 style="text-align: center;"><span style="background-color: #ffffff;"><strong>Change Member Password </strong></span></h2>';
//$content .= '<br><div style="text-align:center;"><strong>Password for: </strong>' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . ' has been changed</div><br>';
//$content .= '<br><div style="text-align:center;">Change password for user :  ' .$RuserID.  '</div><br>';
//$content .= '<br><div style="text-align:center;"> from Company:  ' .$usrData['emp_name'] . ' with ID ' .$usrData['emp_id'] .  '</div><br>';
$content .= '<div><center><div>
 &nbsp;
</center>';
$content .= '<center><form method="post">
				<table style="display:inline-block;vertical-align:top;">
					<tbody>
						<tr><td>User:</td><td>'.$usrData['usr_firstname'].' '.$usrData['usr_lastname'].' ('.$usrData['emp_name'].')</td></tr>
						<tr><td>New Password:</td><td><input type="text" style="width:150px;" name="pass" value="" /><input type="hidden" name="usr" value="'.$RuserID.'" /></td></tr>
					</tbody>
				</table><br/><br/>
				Send Email message to user with new password: <input type="checkbox" name="sendMessage" value="SEND" checked="checked" /><br/><br/>
				<input type="hidden" name="op" value="passwordUpdate" /><input type="submit" value="Save / Send" />
				</form>
			</center>';

$content .='<center><div> ';




$content .='</div></center> ';
$content .= '</div>';
}
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 


