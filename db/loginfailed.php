<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "BC2 Admin";
////$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
////$template = "jobcon"; 
////$response = "content"; 
////require "inc/core.php";

//$_SESSION['$usempempid'] = ""; ////  "_empid";
$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
$template = "jobcon".$usempempid; 

$response = "content"; 
////$usempempid = $_SESSION['$usempempid'];// "_empid";   //".$usempempid."
require "inc/core.php";

//-- define content -----------------------------------------------------------------

$content .= DBContent();

$content .= '<br><br><br><center>You username or password is invalid. Please try again.<br><br>or<br><br>Click here to <a href="../index.htm">return to the BC2Match home page.</a><br><br><br><br>';

$content .= '<form id="login" name="login" method="post" action="index.php">
        <div class="form-group">
 			 <input type="text" name="username" id="username" class="" placeholder="E-Mail Address" title="E-Mail Address" required><br><br>
			 <input type="text-right" name="password" id="password" title="Password" class="" placeholder="Password" required><input type="hidden" name="op" value="login"/><br><br><input type="submit" name="submit" id="submit" value="Sign In" title="Submit"><br><br>
			<a href="forgot.php">Forgot your password?</a>
        </div>
      </form></center>';




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
