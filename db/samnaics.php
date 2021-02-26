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

/*
Get sam_id, company_naics from Table 43

parse the company_naics if there is a "~"

strip the letter off the end of the naics

find the naics in the naics (skills) table

if naics is in the skill table put it in the usr skill table (find the user based on the sam_id)

if not put it in the naics dump table to research
*/

//$results = Q2T("SELECT sam_id, company_naics FROM `TABLE 43` WHERE sam_id between 1 and 2010");
$results = Q2T("SELECT sam_id, company_naics FROM `a_sam2019` WHERE sam_id > 0");
$record_cnt = 0;

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
		
		$uid_res = Q2T("select usr_id from usr where sam_id = '".$res['sam_id']."'");
		
		if ($uid_res){
			foreach ($uid_res as $uidres) {
				$uid = $uidres['usr_id'];
			}
		}
		
		for ($x = 0; $x < $mynaics_cnt; $x++){
				//$content .= $mynaics[$x]."<br>";
				$naics_res = Q2T("SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."'");		
				//$content .= "SELECT catskl_id, catskl_label, catskl_text FROM cat_skills WHERE substr(catskl_label,1,6) = '".$mynaics[$x]."'";
				if ($naics_res){
					foreach ($naics_res as $naicsres) {
						$usrskl_usr_id = $uid;
						$usrskl_skl_id = $naicsres['catskl_id'];
						$usrskl_title = $naicsres['catskl_label'];
						$usrskl_comment = $naicsres['catskl_text'];
						
						//$content .= "catskl_id [ ".$naicsres['catskl_id']." ] catskl_label [ ".$naicsres['catskl_label']." ] <br>";

						//$content .= "Insert into usr_skills (usrskl_usr_id, usrskl_skl_id, usrskl_title, usrskl_comment) values ('".$usrskl_usr_id."','".$usrskl_skl_id."','".$usrskl_title."','".$usrskl_comment."')";
						
						$samsklid = QI("Insert into usr_skills (usrskl_usr_id, usrskl_skl_id, usrskl_title, usrskl_comment) values ('".$usrskl_usr_id."','".$usrskl_skl_id."','".$usrskl_title."','".$usrskl_comment."')");
						
					}
				}
				else
					$content .= "I am Here and failed<br>";
		}
		
		$record_cnt = $record_cnt + 1;
		
		if ($record_cnt % 1000 == 0)
			$content .= "Total records processed [ ".$record_cnt." ]<br>";
			
		
	}
}

$content .= "<br>Processing Complete<br>Total records processed [ ".$record_cnt." ]";

//exit();

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

