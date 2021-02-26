<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Member Profile";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$template = "jobcon"; 
$response = "content"; 
require "inc/core.php";

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


$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".$userID."'");

if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/bc2dev/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}

$content .= '<br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="555" align="center">
<tbody>
<tr>
<td><a href="/bc2dev/applicants.php?usr='.$userID.'">Member Profile</a></td>
<td><a href="/bc2dev/employers.php?usr='.$userID.'">Post a Job</a></td>
<td><a href="/bc2dev/bc2members.php?usr='.$userID.'">Search</a></td>
<td><a href="/bc2dev/bc2members.php?usr='.$userID.'">Show ECAs*</a></td>';

$userPrimary = '';

//echo $userCompany.' - '.$userType;exit();

//echo 'userType [ '. $userType . ' ] <br>';
//echo 'usrData [ '. $usrData['usr_type'] . ' ]';
//exit();

if ($usrData['usr_type'] == 0) {
	//$_SESSION['usr_auth'] = 8;
	$userPrimary = '<td><a href="/bc2dev/admin_usr.php?usr='.$userID.'&ptype=admin">Manage Account</a></td>';
}

$content .= $userPrimary.$systemAdmin.'</tr>
</tbody>
</table>
</div>';
$content .= '<br><br><center><div><h1 style="text-align: center;"><span style="background-color: #ffffff;"><strong>BC2 Match Dashboard</strong></span></h1>';

$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Government/Commercial Matches</strong></td>
</tr>
<tr>
<td width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
<td width="300" bgcolor="#808080" align="left"><font color="#ffffff"><strong>&nbsp;AGENCY/PRIME</strong></font></td>
<td width="65" bgcolor="#808080" align="center"><font color="#ffffff"><strong>YOUR RATING</strong></font></td>
<td width="85" bgcolor="#808080" align="right"><font color="#ffffff"><strong>DUE DATE</strong></font></td>
</tr>';

$usrTable = getUSRMatches();
$rcnt = 1;

$x = 0;

$matches = array();	
$match_jobid = array("first");
$match_title = array("first");
$match_agency = array("first");
$match_rating = array("first");
$match_deadline = array("first");
$match_percentage = array("first");
		
	if ($usrTable) foreach($usrTable as $usr) {
			
		$job = getJobInfo($usr['sysmat_job_id']);
		
		if ($job) foreach($job as $match) {
			$matchjobid = $match['job_id'];
			$matchTitle = $match['job_title'];
			$matchAgency = $match['job_buying_office'];
			$matchDeadline = $match['job_due_date'];
		}
		
		$totalCriteria = 0;
		
		$rating = getRating($usr['sysmat_job_id']);
		
		if ($rating) foreach($rating as $match) {
			$totalCriteria = $totalCriteria + $match['sum'];
		}

		$matchRating = $usr['sum']."/".$totalCriteria;
		$matchPercentage = $usr['sum'] / $totalCriteria;

		$matches[$x] = array($matchPercentage,$matchjobid,$matchTitle,$matchAgency,$matchRating,$matchDeadline);
		
/*		
		if (is_int($rcnt/2))
			$cellbgcolor = "#FFFFFF";
		else
			$cellbgcolor = "#E8E8E8";
		
		
		$content .= '<tr>
		<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matchjobid.'" >'.$matchTitle.'</td>		
		<td width="300" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchAgency.'</td>
		<td width="65" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matchRating.'</td>
		<td width="45" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchDeadline.'</td>
		<td width="40" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchPercentage.'</td>
		</tr>';
*/		
		$rcnt = $rcnt + 1;
		$x = $x + 1;
	}
	else
			$content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Matches Found<br><br></strong></td></tr>';


	array_multisort($matches,SORT_DESC);
	$rcnt = 1;
	
	for($i = 0; $i < $x; $i++) {

			if (is_int($rcnt/2))
				$cellbgcolor = "#FFFFFF";
			else
				$cellbgcolor = "#E8E8E8";


			/***** matches array reference key ***
			$matches[$i][0] = $matchPercentage
			$matches[$i][1] = $matchjobid
			$matches[$i][2] = $matchTitle
			$matches[$i][3] = $matchAgency
			$matches[$i][4] = $matchRating
			$matches[$i][5] = $matchDeadline
			**************************************/
			
			
			$content .= '<tr>
			<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matches[$i][1].'" >'.$matches[$i][2].'</td>		
			<td width="300" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matches[$i][3].'</td>
			<td width="65" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matches[$i][4].'</td>
			<td width="85" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matches[$i][5].'</td>
			</tr>';
			
			$rcnt = $rcnt + 1;
			
		}


$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br><br><br>';


$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Your Job Postings</strong></td>
</tr>
<tr>
<td width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
<td width="100" bgcolor="#808080" align="center"><font color="#ffffff"><strong>#MATCHES</strong></font></td>
<td width="350" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TOP 3 MATCHES</strong></font></td>
</tr>';

$rcnt = 1;
$pstTable = getPosts();

		if ($pstTable) foreach($pstTable as $row) {
			$cnt = 0;
			$matchTable = getMatches($row['job_id']);
			$totMatches = 0;
			$matchNames = "No Matches";
			if ($matchTable) foreach($matchTable as $roe) { 
				//$totMatches = $totMatches + $roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos'];
				//$totMatches = $totMatches + $roe['sum'];
				$totMatches = $totMatches + 1;								
				if ($cnt <= 2) {
					if ($cnt == 0) 
						$matchNames = '<a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'" >'.$roe['usr_lastname'].'</a>';
					else
						//$matchNames = $matchNames . ', <a href="employers?op=pdfRes&res='.$roe['usr_id'].'" target="_blank" >'.$roe['usr_lastname'].'</a>';
						$matchNames = $matchNames . ', <a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'" >'.$roe['usr_lastname'].'</a>';
					}
					$cnt = $cnt + 1;
				}   
			
			if (is_int($rcnt/2))
				$cellbgcolor = "#FFFFFF";
			else
				$cellbgcolor = "#E8E8E8";
			
			$content .= '
				<tr>
				<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$row['job_id'].'" >'.$row['job_title'].'</td>
				<td width="100" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$totMatches.'</td>
				<td width="350" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchNames.'</td>
				</tr>';
				
					
			$rcnt = $rcnt + 1;
		}
		else
			$content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Job Post Found<br><br></strong></td></tr>';

		
		

$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></div></center>';//</div></div>';

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
