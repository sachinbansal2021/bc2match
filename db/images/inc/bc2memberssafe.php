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

$content .= '<br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="555" align="center">
<tbody>
<tr>
<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'">Member Profile</a></td>
<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Post a Job</a></td>';
/**<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'">Search</a></td>
//<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'">Show ECAs*</a></td>';**/

$userPrimary = '';

//echo $userCompany.' - '.$userType;exit();

//echo 'userType [ '. $userType . ' ] <br>';
//echo 'usrData [ '. $usrData['usr_type'] . ' ]';
//exit();

if ($usrData['usr_type'] == 0) {
	//$_SESSION['usr_auth'] = 8;
	$userPrimary = '<td><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$userID.'&ptype=admin">Manage Account</a></td>';
}

$content .= $userPrimary.$systemAdmin.'</tr>
</tbody>
</table>
</div>';
$content .= '<br><br><center><div><h1 style="text-align: center;"><span style="background-color: #ffffff;"><strong>BC2 Match Dashboard</strong></span></h1>';

if (($usrData['usr_firstname'] == 'TESTING') && ($usrData['usr_lastname'] == 'TESTING')) {
	
	
$content .= '<a href="http://www.bizconnectonline.com/bc2dev/bc2dev_samnaics.php">Run SamNaics</a><br><br>';

$content .= '<br><br><table width="1004">
<thead>
<tr>
    <th width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></th>
    <th>Head 2</th>
    <th>Head 3</th>
    <th>Head 4</th>
    <th>Head 5</th>
</tr>
</thead>
<tbody height: 100px; display: inline-block; width: 100%; overflow: auto;>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>

</tbody>

</table><br><br>';
}



/*******************************************************************************
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
				$matches[$x] = array('matchpercentage' => $matchPercentage,'matchid' => $matchjobid,'matchtitle' => $matchTitle,'matchagency' => $matchAgency,'matchrating' => $matchRating,'matchdeadline' => $matchDeadline);
		/
		
		
		if (is_int($rcnt/2))
			$cellbgcolor = "#FFFFFF";
		else
			$cellbgcolor = "#E8E8E8";
		
/*		
		$content .= '<tr>
		<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matchjobid.'" >'.$matchTitle.'</td>		
		<td width="300" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchAgency.'</td>
		<td width="65" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matchRating.'</td>
		<td width="45" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchDeadline.'</td>
		<td width="40" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchPercentage.'</td>
		</tr>';
/		
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
			/
			
			
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
************************************************************/

/*******SCROLL BEGIN******/

//$scrollit = 380;
$scrollit = 240;

$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: 60px;">
<table cellspacing="1" class="winner-table"  >
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Government/Commercial Matches</strong></td>
</tr>
<tr>
<td width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
<td width="280" bgcolor="#808080" align="left"><font color="#ffffff"><strong>&nbsp;AGENCY/PRIME</strong></font></td>
<td width="85" bgcolor="#808080" align="center"><font color="#ffffff"><strong>YOUR RATING</strong></font><br></td>
<td width="85" bgcolor="#808080" align="right"><font color="#ffffff"><strong>DUE DATE</strong></font></td>
</tr>';
$content .= '</tbody>
</table>
<div>
</td>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">
<table cellspacing="0" class="winner-table"> <!--wascellspacing="1" lloyd--> 
<tbody>';
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
				$matches[$x] = array('matchpercentage' => $matchPercentage,'matchid' => $matchjobid,'matchtitle' => $matchTitle,'matchagency' => $matchAgency,'matchrating' => $matchRating,'matchdeadline' => $matchDeadline);
		*/
		
		
		if (is_int($rcnt/2))
			$cellbgcolor = "#FFFFFF";
		else
			$cellbgcolor = "#E8E8E8";
		
/*		
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
			<td width="550" class="title-field" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matches[$i][1].'" >'.$matches[$i][2].'</td>		
			<td width="287" valign="Top" bgcolor="'.$cellbgcolor.'">&nbsp;'.$matches[$i][3].'</td>
			<td width="85" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matches[$i][4].'</td>
			<td width="72" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matches[$i][5].'<a></td>
			</tr>';
			
			$rcnt = $rcnt + 1;
			
		}

$content .= '</div>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: 42px;">
<table cellspacing="1">
<tbody>
<tr><td align="center" width="990" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
<div>
</td>
</tr>
</tbody>
</table>';

$content .='</div>';

/******* SCROLL END *******/

/******************************************************
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
//			$matchTable = getMatches($row['job_id']);
			$totMatches = 0;
			$matchNames = "Testing";
/*** remove matches
			$matchNames = "No Matches";
			
			if ($matchTable) foreach($matchTable as $roe) {
					if ($roe['match_cnt'] <> 0){
						$matchNames = "Click here to view matches";
					    $totMatches = $roe['match_cnt'];
					}

			}
remove matches*/			
			
/*			if ($matchTable) foreach($matchTable as $roe) { 
				//$totMatches = $totMatches + $roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos'];
				//$totMatches = $totMatches + $roe['sum'];
				$totMatches = $totMatches + 1;								
				if ($cnt <= 2) {
					if ($cnt == 0) 
						$matchNames = '<a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
					else
						//$matchNames = $matchNames . ', <a href="employers?op=pdfRes&res='.$roe['usr_id'].'" target="_blank" >'.$roe['usr_lastname'].'</a>';
						$matchNames = $matchNames . ', <a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
					}
					$cnt = $cnt + 1;
				}   
/			
			if (is_int($rcnt/2))
				$cellbgcolor = "#FFFFFF";
			else
				$cellbgcolor = "#E8E8E8";
			
			$content .= '
				<tr>
				<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2myjobprofile.php?usr='.$userID.'&profileID='.$row['job_id'].'" >'.$row['job_title'].'</td>
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

/****************************************************************************/

/*******SCROLL BEGIN******/


$prows = 160;

$jobcnt = QV("select count(*) as cnt FROM job J WHERE J.job_emp_id = '".$userID."' ");
$scrollit = $jobcnt * 16;

/*
if ($scrollit > $prows)
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;
*/
	
if ($scrollit == 0)
	$scrollit = 16;	
else
	$scrollit = $prows;


$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: 42px;">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Your Job Postings</strong></td>
</tr>
<tr>
<td width="990" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
</tr>';

/*<td width="100" bgcolor="#808080" align="center"><font color="#ffffff"><strong>#MATCHES</strong></font></td>
<td width="350" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TOP 3 MATCHES</strong></font></td>
</tr>';*/

$content .= '</tbody>
</table>
<div>
</td>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: '.$scrollit.'px; overflow-y: scroll;">
<table cellspacing="1">
<tbody>';
$rcnt = 1;
$pstTable = getPosts();

		if ($pstTable) foreach($pstTable as $row) {
			$cnt = 0;
//			$matchTable = getMatches($row['job_id']);
			$totMatches = 0;
			$matchNames = "Testing";
/*** remove matches
			$matchNames = "No Matches";
			
			if ($matchTable) foreach($matchTable as $roe) {
					if ($roe['match_cnt'] <> 0){
						$matchNames = "Click here to view matches";
					    $totMatches = $roe['match_cnt'];
					}

			}
remove matches*/			
			
/*			if ($matchTable) foreach($matchTable as $roe) { 
				//$totMatches = $totMatches + $roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos'];
				//$totMatches = $totMatches + $roe['sum'];
				$totMatches = $totMatches + 1;								
				if ($cnt <= 2) {
					if ($cnt == 0) 
						$matchNames = '<a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
					else
						//$matchNames = $matchNames . ', <a href="employers?op=pdfRes&res='.$roe['usr_id'].'" target="_blank" >'.$roe['usr_lastname'].'</a>';
						$matchNames = $matchNames . ', <a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
					}
					$cnt = $cnt + 1;
				}   
*/			
			if (is_int($rcnt/2))
				$cellbgcolor = "#FFFFFF";
			else
				$cellbgcolor = "#E8E8E8";
			
			$content .= '
				<tr>
				<td width="990" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2myjobprofile.php?usr='.$userID.'&profileID='.$row['job_id'].'" >'.$row['job_title'].'</td>
				</tr>';
				/*
				<td width="100" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$totMatches.'</td>
				<td width="350" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchNames.'</td>
				</tr>';*/
				
					
			$rcnt = $rcnt + 1;
		}
		else
			$content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Job Post Found<br><br></strong></td></tr>';

$content .= '</div>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: 42px;">
<table cellspacing="1">
<tbody>
<tr><td align="center" width="990" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
<div>
</td>
</tr>
</tbody>
</table>';

$content .='</div>';

/******* SCROLL END *******/






//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

function getPosts() {
	global $userID,$empID;
	return Q2T("SELECT J.* FROM job J WHERE J.job_emp_id = '".$userID."' ORDER BY J.job_submitted_date ");
}

function getMatches($id) {
	global $userID;

	//clear match table
	
	/*
	Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'"); 
	
	//rerun match routines
	updateCertMatchesJP($id);
	updateSkillMatchesJP($id);
	updateAgencyMatchesJP($id);
	updateProflicMatchesJP($id);
	updateGeoMatchesJP($id);
	updateVehiclesMatchesJP($id);	
	*/
	
	//return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC");
	
	return Q2T("SELECT count(*) as match_cnt FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."'");
}

function getUSRMatches() {
    global $userID;

	/* Matching */
		updateSkillMatchesMP($userID); 
		//echo "skill " . date("h:i:sa")."<br>";
		updateCertMatchesMP($userID); 
		//echo "Certs " . date("h:i:sa")."<br>";
		updateFunctionMatchesMP($userID);
		//echo "Functions " . date("h:i:sa")."<br>";		
		updateAgencyMatchesMP($userID); 
		//echo "Agency " . date("h:i:sa")."<br>";
		updateProflicMatchesMP($userID);
		//echo "Proflic " . date("h:i:sa")."<br>";
		updateVehiclesMatchesMP($userID);
		//echo "Vehicle " . date("h:i:sa")."<br>";
		updateGeoMatchesMP($userID);
		//echo "Geos " . date("h:i:sa")."<br>";
/* End Matching */
	
//	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE U.usr_id ='".$userID."' ORDER BY sum DESC");
	
	return Q2T("SELECT S.sysmat_job_id,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S where S.sysmat_usr_id ='".$userID."'");	
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
