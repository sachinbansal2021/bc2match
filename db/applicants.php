<?php 

// Job Applicants

//-- page settings
define('C3cms', 1);
$title = "Member Profile";
$pageauth = 1;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
//$template = "jobcon"; 
//$response = "content"; 
//require "inc/core.php";
$_SESSION['$usempempid'] = ""; // ""; 
$usempempid = $_SESSION['$usempempid'];// ""; //".$usempempid."
$template = "jobcon".$usempempid; 
$response = "content"; 
////$usempempid = $_SESSION['$usempempid'];// ""; //".$usempempid."
require "inc/core".$usempempid.".php";
//-- define content ----------------------------------------------------------------- 1 to unsuppress dasboard 
// set    $_SESSION['mymemberprofilechanged'] = 1; to unsuppress dasboard 

$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/tooltip.css" />';

$content .= "<!--br> trace 18 usempempid " .$usempempid . " -->" ;
$userID = 0;
  if (isset($_REQUEST['usr']) ) 
  {$userID= $_REQUEST['usr'];
     $_SESSION['passprofile_usr'] = $userID;} 
  if (isset($_REQUEST['company_id'])) {
      $userCompany = $_REQUEST['company_id'];
       $_SESSION['passprofile_emp'] =$userCompany;
  }
$userID= $_SESSION['passprofile_usr'];  //= $userID;set im dashboard bc2memmbers lloys profileusremp
$emp_ID= $_SESSION['passprofile_emp'];  //=$userCompany;
////$userType = $_SESSION['usr_type'];

////if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
////else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; $_SESSION['view_id'] = $userID;

$userType = QV("SELECT usr_type from usr where usr_id =" . $userID. "");
$emp_level = QV("SELECT emp_level from emp where emp_id =" . $emp_ID. "");
$thisuserType = $userType; //QV ("Select usr_type from usr where usr_id=".$userID);
// add company id the user is signed in with to define the profile 3/12/19 lloyd  tie in company
$userCompany = $emp_ID;  //// $_REQUEST['company_id'];
/////$emp_ID = $userCompany;


$tempemp_ID = $emp_ID;
$content .= "<!--br> trace 36 emp_level=".$emp_level. " _SESSION['passprofile_usr']  = ". $_SESSION['passprofile_usr'] . ", _SESSION['passprofile_emp'] = " . $_SESSION['passprofile_emp'];
$content .= "<br> trace 37 userCompany = ". $userCompany . ", userID = " . $userID. ",userType: ". $userType. " emp_ID = ". $emp_ID .", tempemp_ID = ".$tempemp_ID > "-->";
//  ?usr='$userID'&company_id='.. $emp_ID .'
// 3/15/19 modify for profile identity by usr AND company logged in to	      $tempemp_ID = $emp_ID;($userID==26804
////if (! ($user_ID == 000000) )  // 400329 only implement for lloyd and   tojo     and usxxx_emp_id ='". $emp_ID."' 
 ////  {
////       $emp_ID = 0;
////    }	
//  do after the cases  ->>$emp_ID = $tempemp_ID;    
$appSection=@$_REQUEST['appSection'] or $appSection=@$_SESSION['appSection'] or $appSection="pro"; $_SESSION['appSection']=$appSection;

$opRec = CleanI($_REQUEST['rec']);


$trainingTable = Q2T("SELECT cattrn_id AS 'id', cattrn_desc as 'label' FROM cat_training");
	//force getting updated user data lloyd
$content.="<!--br>trace 59 SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id WHERE U.usr_id = '".$userID."'and UA.usrapp_emp_id='". $emp_ID."' -->";
	$usrData = Q2R("SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id WHERE U.usr_id = '".$userID."' and UA.usrapp_emp_id='". $emp_ID."'");   // tie in do not change
$usrempData = Q2R("SELECT * FROM usr_emp WHERE usremp_usr_id = '".$userID."' and usremp_emp_id='". $emp_ID."'");

$content.="<!-- br>trace 61  _REQUEST['op']: ". $_REQUEST['op'] . "-->";


//echo "[".Clean($_REQUEST['op'])."]<br>";
//echo "I am here";
switch(Clean($_REQUEST['op'])) {
	case "updatePro": 
	
		$did =  Q("UPDATE usr SET usr_firstname='".Clean($_REQUEST['FirstName'])."', usr_lastname='".Clean($_REQUEST['LastName'])."', usr_email='".Clean($_REQUEST['Email'])."', usr_prefix='".Clean($_REQUEST['Prefix'])."', usr_updated='".date('Y-m-d H:i:s')."' WHERE usr_id = '".$userID."' ");
	    $did =  Q("UPDATE usr_emp SET usremp_addr='".Clean($_REQUEST['Address1'])."', usremp_addr1='".Clean($_REQUEST['Address2'])."', usremp_addr2='".Clean($_REQUEST['Address3'])."', usremp_city='".Clean($_REQUEST['City'])."', usremp_state='".Clean($_REQUEST['State'])."', usremp_zip='".Clean($_REQUEST['Zip'])."', usremp_phone='".Clean($_REQUEST['Phone'])."', usremp_phone2='".Clean($_REQUEST['Phone2'])."', usremp_fax='".Clean($_REQUEST['Fax'])."', usremp_update_date='".date('Y-m-d H:i:s')."' WHERE usremp_usr_id = '".$userID."' and usremp_emp_id = '".$emp_ID."' ");

        //echo "UPDATE usr_emp SET usremp_addr='".Clean($_REQUEST['Address1'])."', usremp_addr1='".Clean($_REQUEST['Address2'])."', usremp_addr2='".Clean($_REQUEST['Address3'])."', usremp_city='".Clean($_REQUEST['City'])."', usremp_state='".Clean($_REQUEST['State'])."', usremp_zip='".Clean($_REQUEST['Zip'])."', usremp_phone='".Clean($_REQUEST['Phone'])."', usremp_phone2='".Clean($_REQUEST['Phone2'])."', usremp_fax='".Clean($_REQUEST['Fax'])."', usremp_update_date='".date('Y-m-d H:i:s')."' WHERE usremp_usr_id = '".$userID."' and usremp_emp_id = '".$emp_ID."' ";
    
    
    //leave alone for usr company profile identity
    $content .= "<!--br> trace 66...did update result did: ".$did. " using query ->|
UPDATE usr SET usr_firstname='".Clean($_REQUEST['FirstName'])."', usr_lastname='".Clean($_REQUEST['LastName'])."', 
usr_email='".Clean($_REQUEST['Email'])."', usr_prefix='".Clean($_REQUEST['Prefix'])."', usr_addr='".Clean($_REQUEST['Address1'])."', usr_addr1='".Clean($_REQUEST['Address2'])."
', usr_addr2='".Clean($_REQUEST['Address3'])."', usr_city='".Clean($_REQUEST['City'])."', usr_state='".Clean($_REQUEST['State'])."', usr_zip='".Clean($_REQUEST['Zip'])."
', usr_phone='".Clean($_REQUEST['Phone'])."', usr_phone2='
".Clean($_REQUEST['Phone2'])."', usr_fax='".Clean($_REQUEST['Fax'])."', usr_updated='".date('Y-m-d H:i:s')."' WHERE usr_id = '".$userID."' --> ";
    //leave alone "
     if(1 )
     {$_SESSION['usr_email'] = Clean($_REQUEST['Email']); } // 2/14/19 lloyd  - other wise gets priary privilege

	//	$did2 = Q("UPDATE usr_app SET usrapp_ava_id = '".CleanI($_REQUEST['Availability'])."' WHERE usrapp_usr_id = '".$userID."'");
	// lloyd don't need	3/14/15	$did2 = 
	
 
 
	Q("UPDATE usr_app SET usrapp_ava_id = '".CleanI($_REQUEST['Availability'])."' WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id = '".$emp_ID."'" );
	
 	
		//force getting updated user data
$usrData = Q2R("SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id WHERE U.usr_id = '".$userID."' and UA.usrapp_emp_id='". $emp_ID."'" );
$usrempData = Q2R("SELECT * FROM usr_emp WHERE usremp_usr_id = '".$userID."' and usremp_emp_id='". $emp_ID."'");

		$_SESSION['mymemberprofilechanged'] = 1;
		
		break;
	case "updateEdu":
	    
	/*    
	    "updateClr":
	    $rec = CleanI($_REQUEST['rec']);
		$clearanceTitle = QV("SELECT catclr_title FROM cat_clearance WHERE catclr_id='".CleanI($_REQUEST['A_'.$rec.'_clrTitle'])."'");
		$did = Q("UPDATE usr_clearance SET usrclr_clr_id='".CleanI($_REQUEST['A_'.$opRec.'_clrTitle'])."', usrclr_title='".$clearanceTitle."', usrclr_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_clrDate'])))."', usrclr_comment='".Clean($_REQUEST['A_'.$opRec.'_clrComments'])."', usrclr_modified='".date('Y-m-d H:i:s')."'
		WHERE usrclr_id='".$opRec."' AND usrclr_usr_id='".$userID."' and usrclr_emp_id ='". $emp_ID."' ");
		$topClearance = QV("SELECT catclr_rank FROM cat_clearance WHERE catclr_id='".CleanI($_REQUEST['A_'.$rec.'_clrTitle'])."'");
		//$topClearance = QV("SELECT C.catclr_rank FROM cat_clearance C LEFT JOIN usr_clearance U ON U.usrclr_clr_id = C.catclr_id WHERE U.usrclr_usr_id = '".$userID."' ORDER BY C.catclr_rank DESC LIMIT 0,1");
		if ($topClearance) Q("UPDATE usr_app SET usrapp_clearance = '".$topClearance."' WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id ='". $emp_ID."'  ");
		else  Q("UPDATE usr_app SET usrapp_clearance = '0' WHERE usrapp_usr_id = '".$userID."'  and usrapp_emp_id ='". $emp_ID."'");
	  */
	  
	    $rec = CleanI($_REQUEST['rec']);
	    $cateduid = CleanI($_REQUEST['A_'.$rec.'_eduDegree']);  
	    //$u_nu_val = QV("SELECT catedu_level from cat_edu WHERE catedu_id ='".$cateduid."'");
	    
	    //echo "SELECT catedu_level from cat_edu WHERE catedu_id ='".$cateduid."'<br><br>";
	   //echo "UPDATE usr_edu SET usredu_edu_id='".$u_nu_val."' WHERE usredu_id ='".$rec."' and usredu_usr_id='".$userID."'and usredu_emp_id ='". $emp_ID."' "; exit();
	    
	    $did = Q("UPDATE usr_edu SET usredu_edu_id='".$cateduid."' WHERE usredu_usr_id='".$userID."'and usredu_emp_id ='". $emp_ID."' ");
	    

	
		Q("UPDATE usr_app SET usrapp_edu_level=".QV("SELECT C.catedu_level FROM cat_edu C LEFT JOIN usr_edu U ON C.catedu_id = U.usredu_edu_id 
		WHERE U.usredu_usr_id = '".$userID."' and U.usredu_emp_id = '".$emp_ID."' ORDER BY catedu_level DESC LIMIT 1")."
		WHERE usrapp_usr_id = '".$userID."'and usrapp_emp_id = '".$emp_ID."'");
		//  don't need applicants runs ...matchesMP  so don't need$_Session['mymemberprofilechanged'] = 1;   // need to run dash
		$response = "ajax";
		$eduTable = getEducat();
		eduBlock();
		$my_pagename = basename($_SERVER['PHP_SELF']);
	$footerScript .= '$("#appTab_edu").load("applicants.php",{ op: "eduMenu"});';
		//	$footerScript .= '$("#appTab_edu").load("$my_pagename",{ op: "eduMenu"});';
		Q("DELETE from sys_match where sysmat_usr_id = '".$userID."'  and sysmat_emp_id ='".$emp_ID."'");
		updateSkillMatchesMP($userID,$emp_ID); 
		updateCertMatchesMP($userID,$emp_ID); 
		updateFunctionMatchesMP($userID,$emp_ID); 
		updateAgencyMatchesMP($userID,$emp_ID); 
		updateProflicMatchesMP($userID,$emp_ID);
		updateVehiclesMatchesMP($userID,$emp_ID);
		updateGeoMatchesMP($userID,$emp_ID);
	    $_SESSION['mymemberprofilechanged'] = 1  ; //$_Session['mymemberprofilechanged'] = 1;  //$_Session['mymemberprofilechanged'] = 0;
		require "inc/transmit.php"; die();
		break;
	case "deleteEdu":

        //echo "UPDATE usr_edu SET usredu_edu_id ='1' WHERE usredu_usr_id = '".$userID."' and usredu_emp_id ='". $emp_ID."'; <br>";
        //echo "UPDATE usr_app SET usrapp_edu_level='0' WHERE usrapp_usr_id = '".$userID."'and usrapp_emp_id ='". $emp_ID."';  ";
       //exit();
        
	    //$did = Q("DELETE FROM usr_edu WHERE usredu_id = '".CleanI($_REQUEST['eduID'])."' AND usredu_usr_id = '".$userID."' and usredu_emp_id ='". $emp_ID."' "); 
		$did = Q("UPDATE usr_edu SET usredu_edu_id ='1' WHERE usredu_usr_id = '".$userID."' and usredu_emp_id ='". $emp_ID."' ");
		Q("UPDATE usr_app SET usrapp_edu_level='1' WHERE usrapp_usr_id = '".$userID."'and usrapp_emp_id ='". $emp_ID."'  ");
		$response = "ajax";
		$eduTable = getEducat();
		eduBlock();
		$footerScript .= '$("#appTab_edu").load("applicants.php",{ op: "eduMenu"});';
	//	Q("DELETE from sys_match where sysmat_usr_id = '".$userID."' and sysmat_emp_id ='".$emp_ID."'");
	//	updateSkillMatchesMP($userID); 
	//	updateCertMatchesMP($userID); 
	//	updateFunctionMatchesMP($userID); 
    //updateAgencyMatchesMP($userID); 
	//	updateProflicMatchesMP($userID);
	//	updateVehiclesMatchesMP($userID);
	//	updateGeoMatchesMP($userID);
	/*	updateSkillMatchesMP($userID,$emp_ID); 
		updateCertMatchesMP($userID,$emp_ID); 
		updateFunctionMatchesMP($userID,$emp_ID); 
		updateAgencyMatchesMP($userID,$emp_ID); 
		updateProflicMatchesMP($userID,$emp_ID);
		updateVehiclesMatchesMP($userID,$emp_ID);
		updateGeoMatchesMP($userID,$emp_ID);
	*/
		
		$_SESSION['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; die();
		break;
	case "newEdu": 
		$did = QI("INSERT INTO usr_edu (usredu_usr_id,usredu_emp_id,usredu_edu_id, usredu_school, usredu_location, usredu_start, usredu_end, usredu_present, usredu_concentrations, usredu_comments ) 
		VALUES ('".$userID."','".$emp_ID."' ,'".CleanI($_REQUEST['A_new_eduDegree'])."', '".Clean($_REQUEST['A_new_eduSchool'])."','".Clean($_REQUEST['A_new_eduLocation'])."','".date('Y-m-d',strtotime($_REQUEST['A_new_eduStart']))."','".date('Y-m-d',strtotime($_REQUEST['A_new_eduEnd']))."','".CleanS($_REQUEST['A_new_eduPresent'])."','".Clean($_REQUEST['A_new_eduConcen'])."','".Clean($_REQUEST['A_new_eduComments'])."') "); 
		Q("UPDATE usr_app SET usrapp_edu_level=".QV("SELECT C.catedu_level FROM cat_edu C LEFT JOIN usr_edu U ON C.catedu_id = U.usredu_edu_id
		WHERE U.usredu_usr_id = '".$userID."'and U.usredu_emp_id ='". $emp_ID."'  ORDER BY catedu_level DESC LIMIT 1")."
		WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id ='". $emp_ID."' ");
		$response = "ajax";
		$eduTable = getEducat();
		eduBlock();
		$footerScript .= '$("#appTab_edu").load("applicants.php",{ op: "eduMenu"});setTimeout(function(){$("#A_'.$did.'_eduBlock > h3").click();},500);';
	 /*	Q("DELETE from sys_match where sysmat_usr_id = '".$userID."' and sysmat_emp_id ='".$emp_ID."' ");
		updateSkillMatchesMP($userID,$emp_ID); 
		updateCertMatchesMP($userID,$emp_ID); 
		updateFunctionMatchesMP($userID,$emp_ID); 
		updateAgencyMatchesMP($userID,$emp_ID); 
		updateProflicMatchesMP($userID,$emp_ID);
		updateVehiclesMatchesMP($userID,$emp_ID);
		updateGeoMatchesMP($userID,$emp_ID);
		*/
	   $_SESSION['mymemberprofilechanged'] = 1;  // $_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; die();
		break;
	case "updateSkl": 
		$skillID = CleanI($_REQUEST['A_'.$opRec.'_sklID']);
		if ($skillID==0) $skillID = QI("INSERT INTO cat_skills (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_'.$opRec.'_sklTitle'])."','".Clean($_REQUEST['A_'.$opRec.'_sklComments'])."')");
		$did = Q("UPDATE usr_skills SET usrskl_skl_id='".$skillID."', usrskl_emp_id='".$emp_ID."', usrskl_title='".Clean($_REQUEST['A_'.$opRec.'_sklTitle'])."',
		usrskl_comment='".Clean($_REQUEST['A_'.$opRec.'_sklComments'])."', usrskl_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_sklDate'])))."',
		usrskl_modified='".date('Y-m-d H:i:s')."' WHERE usrskl_id='".$opRec."' AND usrskl_usr_id='".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
		$content.= "<br trace 175 skill update query:
		UPDATE usr_skills SET usrskl_skl_id='".$skillID."', usrskl_emp_id='".$emp_ID."', usrskl_title='".Clean($_REQUEST['A_'.$opRec.'_sklTitle'])."',
		usrskl_comment='".Clean($_REQUEST['A_'.$opRec.'_sklComments'])."', usrskl_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_sklDate'])))."',
		usrskl_modified='".date('Y-m-d H:i:s')."' WHERE usrskl_id='".$opRec."' AND usrskl_usr_id='".$userID."' and usrskl_emp_id ='". $emp_ID."' -->" ; 
	////	updateSkillMatchesMP($userID,$emp_ID); // updateSkillMatchesMP($userID);
		$response = "ajax";
		$sklTable = getSkills();
		sklBlock();
		$my_pagename = basename($_SERVER['PHP_SELF']);
	 	$footerScript .= '$("#appTab_skl").load("applicants.php",{ op: "sklMenu"});';
		//	$footerScript .= '$("#appTab_skl").load($my_pagename ,{ op: "sklMenu"});';
	  $_SESSION['mymemberprofilechanged'] = 1 ; // $_Session['mymemberprofilechanged'] = 1;
		////$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; die();
		break;
	case "newSkl": 
		$skillID = CleanI($_REQUEST['A_new_sklID']);
		if ($skillID==0) $skillID = QI("INSERT INTO cat_skills (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_new_sklTitle'])."','".Clean($_REQUEST['A_new_sklComments'])."')");
		
		//echo "[ ".Clean($_REQUEST['A_new_sklTitle'])." ]";exit();
	//	echo("<!--  5/7/19  trace 196 check if NAICS already there or any skill  -->" );
		$qc ="SELECT usrskl_skl_id from usr_skills where usrskl_usr_id = '".$userID."' and usrskl_emp_id='".$emp_ID."' and usrskl_skl_id = '".$skillID."'";
	///	echo ("<!-- br> trace 198 qc: " .$qc ." -->");
		$isskillthere = QV($qc);
	///	echo("<!--br> trace 200 skill   isskillthere?: ". $isskillthere . "-->");
		if ($isskillthere)
		{ 
	///	  echo("<!--br> trace 202 skill already there isskillthere: ". $isskillthere . " -->");
   //  echo (" <script type='text/javascript'><!-- alreadythereSkl(".$isskillthere.")  //-->   </script>  ");
       $content .= "<script type='text/javascript'><!-- alreadythereSkl(".$isskillthere.") //-->    </script>  ";
    /// $content.=  "<!--br> trace 202 skill already there isskillthere: ". $isskillthere. " --> ";
       $response = "ajax";
		$sklTable = getSkills();
		sklBlock();
			$footerScript .= '$("#appTab_skl").load("applicants.php",{ op: "sklMenu"});setTimeout(function(){$("#A_'.$did.'_sklBlock > h3").click();},500);';
	    //$_SESSION['mymemberprofilechanged'] = 1;
      	require "inc/transmit.php"; 
		break;
		} else
        {	
      	///  echo("<!--br> trace 214 skill already not there ??isskillthere: ". $isskillthere . "-->");
     	$q= "INSERT INTO usr_skills (usrskl_usr_id,usrskl_emp_id, usrskl_skl_id, usrskl_title, usrskl_comment, usrskl_date, usrskl_modified)
		VALUES ('".$userID."','".$emp_ID."' ,'".$skillID."','".Clean($_REQUEST['A_new_sklTitle'])."','".Clean($_REQUEST['A_new_sklComments'])."','".date("Y-m-d H:i:s"
		,strtotime(Clean($_REQUEST['A_new_sklDate'])))."','".date('Y-m-d H:i:s')."') ";
		$did = QI($q);
        	$content.= "<!-- trace 201 did new skill: ".$did. ", new skill query: INSERT INTO usr_skills (usrskl_usr_id,usrskl_emp_id, usrskl_skl_id, usrskl_title, usrskl_comment, usrskl_date, usrskl_modified)
		VALUES ('".$userID."','".$emp_ID."' ,'".$skillID."','".Clean($_REQUEST['A_new_sklTitle'])."','".Clean($_REQUEST['A_new_sklComments'])."','".date("Y-m-d H:i:s"
		,strtotime(Clean($_REQUEST['A_new_sklDate'])))."','".date('Y-m-d H:i:s')."') --> "; 
	////	updateSkillMatchesMP($userID,$emp_ID);
		$response = "ajax";
		$sklTable = getSkills();
		sklBlock();
			$my_pagename = basename($_SERVER['PHP_SELF']);
         //	$footerScript .= '$("#appTab_skl").load($my_pagename,{ op: "sklMenu"});setTimeout(function(){$("#A_'.$did.'_sklBlock > h3").click();},500);';
	 	$footerScript .= '$("#appTab_skl").load("applicants.php",{ op: "sklMenu"});setTimeout(function(){$("#A_'.$did.'_sklBlock > h3").click();},500);';
		//updateSkillMatchesMP($userID);
	////	updateSkillMatchesMP($userID,$emp_ID); // updateSkillMatchesMP($userID);
    	$_SESSION['mymemberprofilechanged'] = 1; //$_Session['mymemberprofilechanged'] = 1;
        }
		require "inc/transmit.php"; 
		break;
	case "deleteSkl":
	    $did = Q("DELETE FROM usr_skills WHERE usrskl_id = '".CleanI($_REQUEST['sklID'])."' AND usrskl_usr_id = '".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
	     $content .= "<!-- trace applicants 248  ccalling updateSkillMatches in core  --> ";
	   ////	updateSkillMatchesMP($userID,$emp_ID);  
		$response = "ajax";
		$sklTable = getSkills();
		sklBlock();
			$my_pagename = basename($_SERVER['PHP_SELF']);
         //$footerScript .= '$("#appTab_skl").load($my_pagename,{ op: "sklMenu"});';
	
		$footerScript .= '$("#appTab_skl").load("applicants.php",{ op: "sklMenu"});';
		//updateSkillMatchesMP($userID);
		   $content .= "<!-- trace applicants 248  ccalling updateSkillMatches in core  --> ";

		$_SESSION['mymemberprofilechanged'] = 1;  ////$_Session['mymemberprofilechanged'] = 1;
	
		require "inc/transmit.php"; 
		break;
	case "updateCrt": 
		$certID = CleanI($_REQUEST['A_'.$opRec.'_crtID']);
		if ($certID==0) $certID = QI("INSERT INTO cat_certs (catcrt_name,catskl_desc)
		VALUES ('".Clean($_REQUEST['A_'.$opRec.'_crtTitle'])."','".Clean($_REQUEST['A_'.$opRec.'_crtComments'])."')");
		$did = Q("UPDATE usr_certs SET usrcrt_crt_id='".$certID."', usrcrt_title='".Clean($_REQUEST['A_'.$opRec.'_crtTitle'])."', usrcrt_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_crtDate'])))."', usrcrt_comment='".Clean($_REQUEST['A_'.$opRec.'_crtComments'])."', usrcrt_modified='".date('Y-m-d H:i:s')."'
		WHERE usrcrt_id='".$opRec."' AND usrcrt_usr_id='".$userID."' and usrcrt_emp_id ='". $emp_ID."' ");
		$response = "ajax";
		$crtTable = getCerts();
		////updateCertMatchesMP($userID,$emp_ID);  
		
		crtBlock();
		$footerScript .= '$("#appTab_crt").load("applicants.php",{ op: "crtMenu" });';
		$_SESSION['mymemberprofilechanged'] = 1;   ////$_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
	case "newCrt": 
	    $content .= "<!--br> trace newCrt got to newCrt -->";
		$certID = CleanI($_REQUEST['A_new_crtID']);
		if ($certID==0) $certID = QI("INSERT INTO cat_certs (catcrt_name,catskl_desc) VALUES ('".Clean($_REQUEST['A_new_crtTitle'])."','".Clean($_REQUEST['A_new_crtComments'])."')");
			//echo "[ ".Clean($_REQUEST['A_new_sklTitle'])." ]";exit();	//	echo("<!--  5/8/19  trace 266 check if Cert already there   -->" );
		$qc ="SELECT usrcrt_crt_id from usr_certs where usrcrt_usr_id = '".$userID."' and usrcrt_emp_id='".$emp_ID."' and usrcrt_crt_id = '".CleanI($_REQUEST['A_new_crtID'])."'";
	///	
	$content .= "<!-- br> trace 270 qc: " .$qc ." -->";
		$iscertthere = QV($qc);
	///	echo("<!--br> trace 200 skill   iscertthere?: ". $iscertthere . "-->");
		if ($iscertthere)
		{ 	///
	$content .="<!--br> trace 273 cert already there there: ". $iscertthere . " -->";
   //  echo (" <script type='text/javascript'><!-- alreadythereCrt(".$iscertthere.")  //-->   </script>  "); //	function alreadythereCrt(crtID)
       $content .= "<script type='text/javascript'><!-- alreadythereCrt(".$iscertthere.") //-->    </script>  ";
    /// $content.=  "<!--br> trace 275 cert already there iscertthere: ". $iscertthere. " --> ";
       $response = "ajax";
       
		$sklTable = getCerts();
		crtBlock();
			$footerScript .= '$("#appTab_crt").load("applicants.php",{ op: "crtMenu" });setTimeout(function(){$("#A_'.$did.'_crtBlock > h3").click();},500);';
      	require "inc/transmit.php"; 
		break;
		} else
        {	
		$q="INSERT INTO usr_certs (usrcrt_usr_id,usrcrt_emp_id,usrcrt_crt_id, usrcrt_title, usrcrt_date, usrcrt_comment, usrcrt_modified)
		VALUES ('".$userID."','". $emp_ID."','".CleanI($_REQUEST['A_new_crtID'])."','".Clean($_REQUEST['A_new_crtTitle'])."','".date("Y-m-d",strtotime(Clean($_REQUEST['A_new_crtDate'])))."','".Clean($_REQUEST['A_new_crtComments'])."','".date('Y-m-d H:i:s')."')"; 
			/////$did = QI($q); 
	   $did = QI($q);
	   $content .= "<!-- br> trace 270newCrt q: ".$q .", did : ". $did. "-->";
		$response = "ajax";
		$crtTable = getCerts();
	////	updateCertMatchesMP($userID,$emp_ID); 	
		
		crtBlock();
		$footerScript .= '$("#appTab_crt").load("applicants.php",{ op: "crtMenu" });setTimeout(function(){$("#A_'.$did.'_crtBlock > h3").click();},500);';
	    $_SESSION['mymemberprofilechanged'] = 1; //	$_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
        }
	case "deleteCrt": 
		$did = Q("DELETE FROM usr_certs WHERE usrcrt_id = '".CleanI($_REQUEST['crtID'])."' AND usrcrt_usr_id = '".$userID."' and usrcrt_emp_id ='". $emp_ID."'");
		$response = "ajax";
		$crtTable = getCerts();
	////	updateCertMatchesMP($userID,$emp_ID);  
		
		crtBlock();
	
		$footerScript .= '$("#appTab_crt").load("applicants.php",{ op: "crtMenu"  });';
	    $_SESSION['mymemberprofilechanged'] = 1;	////$_Session['mymemberprofilechanged'] = 1;	
		require "inc/transmit.php"; 
		break;
	case "updateClr":
	    $rec = CleanI($_REQUEST['rec']);
		$clearanceTitle = QV("SELECT catclr_title FROM cat_clearance WHERE catclr_id='".CleanI($_REQUEST['A_'.$rec.'_clrTitle'])."'");
		$did = Q("UPDATE usr_clearance SET usrclr_clr_id='".CleanI($_REQUEST['A_'.$opRec.'_clrTitle'])."', usrclr_title='".$clearanceTitle."', usrclr_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_clrDate'])))."', usrclr_comment='".Clean($_REQUEST['A_'.$opRec.'_clrComments'])."', usrclr_modified='".date('Y-m-d H:i:s')."'
		WHERE usrclr_id='".$opRec."' AND usrclr_usr_id='".$userID."' and usrclr_emp_id ='". $emp_ID."' ");
		$topClearance = QV("SELECT catclr_rank FROM cat_clearance WHERE catclr_id='".CleanI($_REQUEST['A_'.$rec.'_clrTitle'])."'");
		//$topClearance = QV("SELECT C.catclr_rank FROM cat_clearance C LEFT JOIN usr_clearance U ON U.usrclr_clr_id = C.catclr_id WHERE U.usrclr_usr_id = '".$userID."' ORDER BY C.catclr_rank DESC LIMIT 0,1");
		if ($topClearance) Q("UPDATE usr_app SET usrapp_clearance = '".$topClearance."' WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id ='". $emp_ID."'  ");
		else  Q("UPDATE usr_app SET usrapp_clearance = '0' WHERE usrapp_usr_id = '".$userID."'  and usrapp_emp_id ='". $emp_ID."'");
		$response = "ajax";
		$clrTable = getClearances();
		$clrListTable = getAllClearances();
		clrBlock();
		$footerScript .= '$("#appTab_clr").load("applicants.php",{ op: "clrMenu"});';
		////Q("DELETE from sys_match where sysmat_usr_id = '".$userID."'  and sysmat_emp_id ='".$emp_ID."'");
		
	///updateSkillMatchesMP($userID);
//echo "update [ ".$userID." ]";exit();		
		/*updateCertMatchesMP($userID); 
		updateFunctionMatchesMP($userID); 
		updateAgencyMatchesMP($userID); 
		updateProflicMatchesMP($userID);
		updateVehiclesMatchesMP($userID);
		updateGeoMatchesMP($userID);  */
/*		updateSkillMatchesMP($userID,$emp_ID); 
		updateCertMatchesMP($userID,$emp_ID); 
		updateFunctionMatchesMP($userID,$emp_ID); 
		updateAgencyMatchesMP($userID,$emp_ID); 
		updateProflicMatchesMP($userID,$emp_ID);
		updateVehiclesMatchesMP($userID,$emp_ID);
		updateGeoMatchesMP($userID,$emp_ID);
		/////$emp_ID = $tempemp_ID; 
*/
		$_SESSION['mymemberprofilechanged'] = 1;  ///$_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
	case "newClr": 
		$clearanceTitle = QV("SELECT catclr_title FROM cat_clearance WHERE catclr_id='".CleanI($_REQUEST['A_new_clrTitle'])."'");
		$q="INSERT INTO usr_clearance (usrclr_usr_id, usrclr_emp_id,usrclr_clr_id, usrclr_title, usrclr_date, usrclr_comment, usrclr_modified) 
		VALUES ('".$userID."', '". $emp_ID."','".CleanI($_REQUEST['A_new_clrTitle'])."','".$clearanceTitle."','".date("Y-m-d",strtotime(Clean($_REQUEST['A_new_clrDate'])))."','".Clean($_REQUEST['A_new_clrComments'])."','".date('Y-m-d H:i:s')."')"; 
//echo "q = [ ".$q." ]"; exit();usrclr_emp_id ='". $emp_ID."' "
		$did = QI($q); 		
		//$topClearance = QV("SELECT C.catclr_rank FROM cat_clearance C LEFT JOIN usr_clearance U ON U.usrclr_clr_id = C.catclr_id WHERE U.usrand usrapp_emp_id ='". $emp_ID."'clr_usr_id = '".$userID);
		$topClearance = QV("SELECT catclr_rank FROM cat_clearance WHERE catclr_id='".CleanI($_REQUEST['A_new_clrTitle'])."'");
//echo "topClearance = [ ".$topClearance." ]"; exit();
		if ($topClearance) Q("UPDATE usr_app SET usrapp_clearance = '".$topClearance."' WHERE usrapp_usr_id = '".$userID."'and usrapp_emp_id ='". $emp_ID."' ");
		else  Q("UPDATE usr_app SET usrapp_clearance = '0' WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id ='". $emp_ID."' ");
		$response = "ajax";
		$clrTable = getClearances();
		$clrListTable = getAllClearances();
		clrBlock();
		$footerScript .= '$("#appTab_clr").load("applicants.php",{ op: "clrMenu"});setTimeout(function(){$("#A_'.$did.'_clrBlock > h3").click();},500);';
	////Q("DELETE from sys_match where sysmat_usr_id = '".$userID."'  and sysmat_emp_id ='".$emp_ID."' ");

	///	updateSkillMatchesMP($userID); 
//echo " new [ ".$userID." ]";exit();		
	/*	updateCertMatchesMP($userID); 
		updateFunctionMatchesMP($userID); 
		updateAgencyMatchesMP($userID); 
		updateProflicMatchesMP($userID);
		updateVehiclesMatchesMP($userID);
		updateGeoMatchesMP($userID);
		*/
/*		updateSkillMatchesMP($userID,$emp_ID); 
		updateCertMatchesMP($userID,$emp_ID); 
		updateFunctionMatchesMP($userID,$emp_ID); 
		updateAgencyMatchesMP($userID,$emp_ID); 
		updateProflicMatchesMP($userID,$emp_ID);
		updateVehiclesMatchesMP($userID,$emp_ID);
		updateGeoMatchesMP($userID,$emp_ID);
*/
		$_SESSION['mymemberprofilechanged'] = 1; ////$_Session['mymemberprofilechanged'] = 1;
	  /////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
	case "deleteClr": 
		//$did = Q("DELETE FROM usr_clearance WHERE usrclr_id = '".CleanI($_REQUEST['clrID'])."' AND usrclr_usr_id = '".$userID."' AND usrclr_emp_id = '".$emp_ID."' ");
		$did = Q("UPDATE usr_clearance SET usrclr_clr_id = '4', usrclr_title = 'None' 
		WHERE usrclr_id = '".CleanI($_REQUEST['clrID'])."' AND usrclr_usr_id = '".$userID."' and usrclr_emp_id ='". $emp_ID."' ");
		//$topClearance = QV("SELECT C.catclr_rank FROM cat_clearance C LEFT JOIN usr_clearance U ON U.usrclr_clr_id = C.catclr_id WHERE U.usrclr_usr_id = '".$userID."' ORDER BY C.catclr_rank DESC LIMIT 0,1");
		//if ($topClearance) Q("UPDATE usr_app SET usrapp_clearance = '".$topClearance."' WHERE usrapp_usr_id = '".$userID."' ");
		//else  
		Q("UPDATE usr_app SET usrapp_clearance = '0' WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id ='". $emp_ID."' ");
		$response = "ajax";
		$clrTable = getClearances();
		$clrListTable = getAllClearances();
		clrBlock();
		$footerScript .= '$("#appTab_clr").load("applicants.php",{ op: "clrMenu"});';
	////	Q("DELETE from sys_match where sysmat_usr_id = '".$userID."'  and sysmat_emp_id ='".$emp_ID."'  ");

		///updateSkillMatchesMP($userID); 
//echo "delete [ ".$userID." ]";exit();		
	/*	updateCertMatchesMP($userID); 
		updateFunctionMatchesMP($userID); 
		updateAgencyMatchesMP($userID); 
		updateProflicMatchesMP($userID);
		updateVehiclesMatchesMP($userID);
		updateGeoMatchesMP($userID);*/
	/*		updateSkillMatchesMP($userID,$emp_ID); 
		updateCertMatchesMP($userID,$emp_ID); 
		updateFunctionMatchesMP($userID,$emp_ID); 
		updateAgencyMatchesMP($userID,$emp_ID); 
		updateProflicMatchesMP($userID,$emp_ID);
		updateVehiclesMatchesMP($userID,$emp_ID);
		updateGeoMatchesMP($userID,$emp_ID);
		////$emp_ID = $tempemp_ID; 
	*/	
		$_SESSION['mymemberprofilechanged'] = 1; //$_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
		break;
	case "updateExp": 
		$days = (((strtotime($_REQUEST['A_'.$opRec.'_expEnd']) - strtotime($_REQUEST['A_'.$opRec.'_expStart'])) / 60 ) / 60 ) * 24;
		$expID = QV("SELECT catexp_id FROM cat_exp WHERE catexp_days <= '".$days."' ORDER BY catexp_days DESC LIMIT 0,1");
		$did = Q("UPDATE usr_exp SET usrexp_exp_id='".$expID."', usrexp_employer='".Clean($_REQUEST['A_'.$opRec.'_expEmployer'])."', usrexp_title='".Clean($_REQUEST['A_'.$opRec.'_expTitle'])."', usrexp_location='".Clean($_REQUEST['A_'.$opRec.'_expLocation'])."', usrexp_start='".date('Y-m-d',strtotime($_REQUEST['A_'.$opRec.'_expStart']))."', usrexp_end='".date('Y-m-d',strtotime($_REQUEST['A_'.$opRec.'_expEnd']))."', usrexp_comment='".Clean($_REQUEST['A_'.$opRec.'_expComments'])."'
		WHERE usrexp_id='".$opRec."' AND usrexp_usr_id='".$userID."' and usrexp_emp_id ='".$emp_ID."'"); 
		$response = "ajax";
		$expTable = getExper();
		expBlock();
		$footerScript .= '$("#appTab_exp").load("applicants.php",{ op: "expMenu"});';
		/////$emp_ID = $tempemp_ID;
		$_SESSION['mymemberprofilechanged'] = 1; //$_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
		break;		
	case "newExp": $did = QI("INSERT INTO usr_exp (usrexp_usr_id,usrexp_emp_id, usrexp_employer, usrexp_title, usrexp_location, usrexp_start, usrexp_end, usrexp_comment)
	VALUES ('".$userID."','".$emp_ID."','".Clean($_REQUEST['A_new_expEmployer'])."','".Clean($_REQUEST['A_new_expTitle'])."','".Clean($_REQUEST['A_new_expLocation'])."','".date('Y-m-d',strtotime($_REQUEST['A_new_expStart']))."','".date('Y-m-d',strtotime($_REQUEST['A_new_expEnd']))."','".Clean($_REQUEST['A_new_expComments'])."')"); 
		$response = "ajax";
		$expTable = getExper();
		expBlock();
		$footerScript .= '$("#appTab_exp").load("applicants.php",{ op: "expMenu"});setTimeout(function(){$("#A_'.$did.'_expBlock > h3").click();},500);';
	  ////	$emp_ID = $tempemp_ID;
	 $_SESSION['mymemberprofilechanged'] = 1;// $_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
		break;	
	case "deleteExp": $did = Q("DELETE FROM usr_exp WHERE usrexp_id = '".CleanI($_REQUEST['expID'])."' AND usrexp_usr_id = '".$userID."'  and usrexp_emp_id ='".$emp_ID."' "); 
		// there is not table usr_edu_func,lloydif ($did) $did = Q("DELETE FROM usr_edu_func WHERE usredufnc_usrexp_id = '".CleanI($_REQUEST['expID'])."' "); 
		$response = "ajax";
		$expTable = getExper();
		expBlock();
		$footerScript .= '$("#appTab_exp").load("applicants.php",{ op: "expMenu"});';
		$emp_ID = $tempemp_ID;
		$_SESSION['mymemberprofilechanged'] = 1;// $_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
		break;
	case "updateFunc": 
		$funcID = CleanI($_REQUEST['catID']);
		if ($funcID==0) $funcID = QI("INSERT INTO cat_func (catfnc_title,catfnc_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");
		$did = Q("UPDATE usr_exp_func SET usrexpfnc_fnc_id='".$funcID."', usrexpfnc_title='".Clean($_REQUEST['title'])."', usrexpfnc_trn_id='".Clean($_REQUEST['training'])."', usrexpfnc_comment='".Clean($_REQUEST['comments'])."', usrexpfnc_modified='".date('Y-m-d H:i:s')."' WHERE usrexpfnc_usrexp_id='".CleanI($_REQUEST['expID'])."' AND usrexpfnc_id = '".CleanI($_REQUEST['funcID'])."' 
		AND usrexpfnc_usrexp_id IN (SELECT usrexp_id FROM usr_exp WHERE usrexp_usr_id =  '".$userID."'  and usrexp_emp_id ='".$emp_ID."') ");
		$response = "ajax";
		$expRow = Q2R("SELECT DISTINCT U.*,C.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id 
		LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id
		WHERE U.usrexp_id = '".CleanI($_REQUEST['expID'])."' AND U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='".$emp_ID."' ORDER BY U.usrexp_end DESC ");
		$expFncTable = getFuncs(CleanI($_REQUEST['expID']));
		$content .= renderExpFunction($expRow, $expFncTable); $headerScript = ''; //alert("hit");';
	////	updateFunctionMatchesMP($userID,$emp_ID);
	    	$_SESSION['mymemberprofilechanged'] = 1;   ///$_Session['mymemberprofilechanged'] = 1;
	/////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;
	case "newFunc": 
		$funcID = CleanI($_REQUEST['catID']);
		if ($funcID==0) $funcID = QI("INSERT INTO cat_func (catfnc_title,catfnc_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");
		$did = Q("INSERT INTO usr_exp_func (usrexpfnc_usrexp_id, usrexpfnc_fnc_id, usrexpfnc_title, usrexpfnc_trn_id, usrexpfnc_modified, usrexpfnc_comment) 
		VALUES ('".CleanI($_REQUEST['expID'])."','".$funcID."','".Clean($_REQUEST['title'])."','".Clean($_REQUEST['training'])."','".date('Y-m-d H:i:s')."','".Clean($_REQUEST['comments'])."')"); 
		$response = "ajax";
		$expRow = Q2R("SELECT DISTINCT U.*,C.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id
		LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id WHERE U.usrexp_id = '".CleanI($_REQUEST['expID'])."'
		AND U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='".$emp_ID."' ORDER BY U.usrexp_end DESC ");
		$expFncTable = getFuncs(CleanI($_REQUEST['expID']));
		$content .= renderExpFunction($expRow, $expFncTable); $headerScript = ''; //alert("hit");';
	////	updateFunctionMatchesMP($userID,$emp_ID);
		$_SESSION['mymemberprofilechanged'] = 1; ///$_Session['mymemberprofilechanged'] = 1;
	////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;
	case "deleteFunc":
		$idOk = QV("SELECT E.usrexp_id FROM usr_exp E LEFT JOIN usr_exp_func F ON F.usrexpfnc_usrexp_id = E.usrexp_id 
		WHERE E.usrexp_usr_id='".$userID."'and E.usrexp_emp_id ='".$emp_ID."' AND F.usrexpfnc_id = '".CleanI($_REQUEST['funcID'])."' ");
		if (intval($idOk) > 0) $did = Q("DELETE FROM usr_exp_func WHERE usrexpfnc_id = '".CleanI($_REQUEST['funcID'])."' "); 
		$response = "ajax";
		$expRow = Q2R("SELECT DISTINCT U.*,C.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id 
		LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id 
		LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id
		WHERE U.usrexp_id = '".CleanI($_REQUEST['expID'])."' AND U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='".$emp_ID."' ORDER BY U.usrexp_end DESC ");
		$expFncTable = getFuncs(CleanI($_REQUEST['expID']));
		$content .= renderExpFunction($expRow, $expFncTable); $headerScript = ''; //alert("hit");';
	////	updateFunctionMatchesMP($userID,$emp_ID);
	  $_SESSION['mymemberprofilechanged'] = 1;  ////	$_Session['mymemberprofilechanged'] = 1;
	////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;
	case "updateSumdeleted": 
	////	$did = Q("UPDATE usr_app SET usrapp_summary='".Clean($_REQUEST['elmSummary'])."' 
	////	WHERE usrapp_id='".QV("SELECT usrapp_id FROM usr_app WHERE usrapp_usr_id='".$userID."' and usrapp_emp_id ='". $emp_ID."' LIMIT 0,1")."'"); break;
      break;
	case "updateAgcy": 
		$agencyID = CleanI($_REQUEST['A_'.$opRec.'_agenID']);
		if ($agencyID==0) $agencyID = QI("INSERT INTO cat_agencies (catagen_label,catagen_text) VALUES ('".Clean($_REQUEST['A_'.$opRec.'_sklTitle'])."','".Clean($_REQUEST['A_'.$opRec.'_agenComments'])."')");
		$did = Q("UPDATE usr_agencies SET usragen_skl_id='".$agencyID."', usragen_title='".Clean($_REQUEST['A_'.$opRec.'_agenTitle'])."', usragen_comment='".Clean($_REQUEST['A_'.$opRec.'_agenComments'])."', usragen_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_agenDate'])))."', usragen_modified='".date('Y-m-d H:i:s')."' 
		WHERE usragen_id='".$opRec."' AND usragen_usr_id='".$userID."' and usragen_emp_id ='". $emp_ID."'"); 
		$response = "ajax";
		$agcyTable = getAgency();
		agcyBlock();
		$footerScript .= '$("#appTab_agen").load("applicants.php",{ op: "agenMenu"});';
	////	updateAgencyMatchesMP($userID,$emp_ID);
	   $_SESSION['mymemberprofilechanged'] = 1; ////	$_Session['mymemberprofilechanged'] = 1;
	////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; die();
		break;
	case "newAgcy": 
		$agencyID = CleanI($_REQUEST['A_new_agenID']);
		if ($agencyID==0) $agencyID = QI("INSERT INTO cat_agencies (catagen_label,catagen_text) VALUES ('".Clean($_REQUEST['A_new_agenTitle'])."','".Clean($_REQUEST['A_new_agenComments'])."')");
		$qag ="SELECT usragen_skl_id from usr_agencies where usragen_usr_id = '".$userID."' and usragen_emp_id='".$emp_ID."' and usragen_skl_id = '".CleanI($_REQUEST['A_new_agenID'])."'";
	///		alreadythereAgcy(agenID) usragen_skl_id
		///	
	$content .= "<!-- br> trace 513 qag: " .$qag ." -->";
		$isagenthere = QV($qag);
	///	echo("<!--br> trace 515 skill   isagenthere?: ". $isagenthere . "-->");
		if ($isagenthere)
		{ 	///
	$content .="<!--br> trace 518 agency already there there: ". $isagenthere . " -->";
   //  echo (" <script type='text/javascript'><!-- alreadythereCrt(".$iscertthere.")  //-->   </script>  "); //	function alreadythereCrt(crtID)
       $content .= "<script type='text/javascript'><!-- alreadythereAgcy(".$isagenthere.") //-->    </script>  ";
    /// $content.=  "<!--br> trace 521 agency already there isagenthere: ". $isagenthere. " --> ";
       $response = "ajax";
		$agcyTable =getAgency();
		agcyBlock();    ////		getCerts(); 		crtBlock();
			$footerScript .= '$("#appTab_agen").load("applicants.php",{ op: "agenMenu"});setTimeout(function(){$("#A_'.$did.'_agcyBlock > h3").click();},500);';
	////	$_SESSION['mymemberprofilechanged'] = 1;	
      	require "inc/transmit.php"; 
		break;
		} else
        {	
		$q= "INSERT INTO usr_agencies (usragen_usr_id,usragen_emp_id, usragen_skl_id, usragen_title, usragen_comment, usragen_date, usragen_modified) 
		VALUES ('".$userID."', '". $emp_ID."', '".$agencyID."','".Clean($_REQUEST['A_new_agenTitle'])."','".Clean($_REQUEST['A_new_agenComments'])."','".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_new_agenDate'])))."','".date('Y-m-d H:i:s')."') "; 
		$did = QI($q); 
		$response = "ajax";
		$agcyTable = getAgency();
		agcyBlock();
		$footerScript .= '$("#appTab_agen").load("applicants.php",{ op: "agenMenu"});setTimeout(function(){$("#A_'.$did.'_agcyBlock > h3").click();},500);';
	////	updateAgencyMatchesMP($userID,$emp_ID);
	    $_SESSION['mymemberprofilechanged'] = 1;//	 $_Session['mymemberprofilechanged'] = 1;
		require "inc/transmit.php"; 
        }
		break;
	case "deleteAgcy": $did = Q("DELETE FROM usr_agencies WHERE usragen_id = '".CleanI($_REQUEST['agenID'])."' AND usragen_usr_id = '".$userID."' and usragen_emp_id ='". $emp_ID."' "); 
		$response = "ajax";
		$agcyTable = getAgency();
		agcyBlock();
		$footerScript .= '$("#appTab_agen").load("applicants.php",{ op: "agenMenu"});';
	////	updateAgencyMatchesMP($userID,$emp_ID);
	     $_SESSION['mymemberprofilechanged'] = 1;  ///	$_Session['mymemberprofilechanged'] = 1;
	////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;	
	case "updateProflic": 
		$proflicID = CleanI($_REQUEST['A_'.$opRec.'_proflicID']);
		if ($proflicID==0) $proflicID = QI("INSERT INTO cat_proflics (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_'.$opRec.'_proflicTitle'])."','".Clean($_REQUEST['A_'.$opRec.'_proflicComments'])."')");
		$did = Q("UPDATE usr_proflics SET usrskl_proflic_id='".$proflicID."', usrskl_title='".Clean($_REQUEST['A_'.$opRec.'_proflicTitle'])."', usrskl_comment='".Clean($_REQUEST['A_'.$opRec.'_proflicComments'])."', usrskl_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_proflicDate'])))."', usrskl_modified='".date('Y-m-d H:i:s')."' 
		WHERE usrskl_id='".$opRec."' AND usrskl_usr_id='".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
		$response = "ajax";
		$proflicTable = getProflics();
		proflicBlock();
		$footerScript .= '$("#appTab_proflic").load("applicants.php",{ op: "proflicMenu"});';
	////	updateProflicMatchesMP($userID,$emp_ID);
		 $_SESSION['mymemberprofilechanged'] = 1;   // $_Session['mymemberprofilechanged'] = 1;
	  ////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; die();
		break;
	case "newProflic":
		$proflicID = CleanI($_REQUEST['A_new_proflicID']);
		if ($proflicID==0) $proflicID = QI("INSERT INTO cat_proflics (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_new_proflicTitle'])."','".Clean($_REQUEST['A_new_proflicComments'])."')");
		$q= "INSERT INTO usr_proflics (usrskl_usr_id, usrskl_emp_id,usrskl_skl_id, usrskl_title, usrskl_comment, usrskl_date, usrskl_modified) 
		VALUES ('".$userID."','". $emp_ID."' ,'".$proflicID."','".Clean($_REQUEST['A_new_proflicTitle'])."','".Clean($_REQUEST['A_new_proflicComments'])."','".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_new_proflicDate'])))."','".date('Y-m-d H:i:s')."') "; 
		$did = QI($q);
		$response = "ajax";
		$proflicTable = getProflics();		
		proflicBlock();
		$footerScript .= '$("#appTab_proflic").load("applicants.php",{ op: "proflicMenu"});setTimeout(function(){$("#A_'.$did.'_proflicBlock > h3").click();},500);';
	////	updateProflicMatchesMP($userID,$emp_ID);
	   $_SESSION['mymemberprofilechanged'] = 1;  //	$_Session['mymemberprofilechanged'] = 1;
	  ////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;
	case "deleteProflic": 
		$did = Q("DELETE FROM usr_proflics WHERE usrskl_id = '".CleanI($_REQUEST['proflicID'])."' AND usrskl_usr_id = '".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
		$response = "ajax";
		$proflicTable = getProflics();
		proflicBlock();
		$footerScript .= '$("#appTab_proflic").load("applicants.php",{ op: "proflicMenu"});';
	////	updateProflicMatchesMP($userID,$emp_ID);
		$_SESSION['mymemberprofilechanged'] = 1;  // $_Session['mymemberprofilechanged'] = 1;
		////$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;
	case "updateGeo": 
		$geoID = CleanI($_REQUEST['A_'.$opRec.'_geoID']);
		if ($geoID==0) $geoID = QI("INSERT INTO cat_geos (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_'.$opRec.'_geoTitle'])."','".Clean($_REQUEST['A_'.$opRec.'_geoComments'])."')");
		$did = Q("UPDATE usr_geos SET usrskl_geo_id='".$geoID."', usrskl_title='".Clean($_REQUEST['A_'.$opRec.'_geoTitle'])."', usrskl_comment='".Clean($_REQUEST['A_'.$opRec.'_geoComments'])."', usrskl_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_geoDate'])))."', usrskl_modified='".date('Y-m-d H:i:s')."'
		WHERE usrskl_id='".$opRec."' AND usrskl_usr_id='".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
		$response = "ajax";
		$geoTable = getGeos();
		geoBlock();
		$footerScript .= '$("#appTab_geo").load("applicants.php",{ op: "geosMenu"});';
	////	updateGeoMatchesMP($userID,$emp_ID);
		$_SESSION['mymemberprofilechanged'] = 1; //$_Session['mymemberprofilechanged'] = 1;
	////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; die();
		break;
	case "newGeo": 
		$geoID = CleanI($_REQUEST['A_new_geoID']);
			$content.="<!--br>trace 515 case newgeo, $geoID: ". $$geoID ." <br>-->";
		if ($geoID==0) $geoID = QI("INSERT INTO cat_geos (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_new_geoTitle'])."','".Clean($_REQUEST['A_new_geoComments'])."')");
		$qgeo ="SELECT usrskl_skl_id from usr_geos where usrskl_usr_id = '".$userID."' and usrskl_emp_id='".$emp_ID."' and usrskl_skl_id = '".$geoID."'";
	///		alreadythere		///	
	$content .= "<!-- br> trace 610 qgeo: " .$qgeo ." -->";
		$isgeothere = QV($qgeo);
	///	echo("<!--br> trace 612 skill   isgeothere?: ". $isgeothere . "-->");
		if ($isgeothere)
		{ 	/// // alreadythereGeo(geoID) $isgeothere
	$content .="<!--br> trace 615 agency already there there: ". $isagenthere . " qgeo: " . $qgeo. " -->";
   //  echo (" <script type='text/javascript'><!-- alreadythereCrt(".$iscertthere.")  //-->   </script>  "); //	function alreadythereCrt(crtID)
       $content .= "<script type='text/javascript'><!-- alreadythereGeo(".$isgeothere.") //-->    </script>  ";    /// $content.=  "<!--br> trace 618 aplace,geo already there isgeohere: ". $isgeothere. " --> ";
       $response = "ajax";
		$geoTable = getGeos();
		geoBlock();
		$footerScript .= '$("#appTab_geo").load("applicants.php",{ op: "geosMenu"});setTimeout(function(){$("#A_'.$did.'_geoBlock > h3").click();},500);';		
      	require "inc/transmit.php"; 
		break;
		} else
        {	
		$q= "INSERT INTO usr_geos (usrskl_usr_id, usrskl_emp_id,usrskl_skl_id, usrskl_title, usrskl_comment, usrskl_date, usrskl_modified) 
		VALUES ('".$userID."','". $emp_ID."', '".$geoID."','".Clean($_REQUEST['A_new_geoTitle'])."','".Clean($_REQUEST['A_new_geoComments'])."','".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_new_geoDate'])))."','".date('Y-m-d H:i:s')."') "; 
		$content.="<!--br>trace 520 case newgeo, q: ". $q ." <br>-->";
		$did = QI($q); 
		$content .="<!--br>trace 629 newGeo did: " .$did . " --> ";
		$response = "ajax";
		$geoTable = getGeos();
		geoBlock();
		$footerScript .= '$("#appTab_geo").load("applicants.php",{ op: "geosMenu"});setTimeout(function(){$("#A_'.$did.'_geoBlock > h3").click();},500);';
		////updateGeoMatchesMP($userID,$emp_ID);
		$_SESSION['mymemberprofilechanged'] = 1; //$_Session['mymemberprofilechanged'] = 1;
        ////$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
         break;
            
        }
		
	case "deleteGeo": $did = Q("DELETE FROM usr_geos WHERE usrskl_id = '".CleanI($_REQUEST['geoID'])."' AND usrskl_usr_id = '".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
	    //echo "DELETE FROM usr_geos WHERE usrskl_id = '".CleanI($_REQUEST['geoID'])."' AND usrskl_usr_id = '".$userID."' and usrskl_emp_id ='". $emp_ID."' ";
		$response = "ajax";
		$geoTable = getGeos();
		geoBlock();
		$footerScript .= '$("#appTab_geo").load("applicants.php",{ op: "geosMenu"});';
		//// updateGeoMatchesMP($userID,$emp_ID);
	     $_SESSION['mymemberprofilechanged'] = 1;  //	$_Session['mymemberprofilechanged'] = 1;
		 ////$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;		
	case "updateVehicles": 
		$vehiclesID = CleanI($_REQUEST['A_'.$opRec.'_vehiclesID']);
		if ($vehiclesID==0) $vehiclesID = QI("INSERT INTO cat_vehicles (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_'.$opRec.'_vehiclesTitle'])."','".Clean($_REQUEST['A_'.$opRec.'_vehiclesComments'])."')");
		$did = Q("UPDATE usr_vehicles SET usrskl_vehicles_id='".$vehiclesID."', usrskl_title='".Clean($_REQUEST['A_'.$opRec.'_vehiclesTitle'])."', usrskl_comment='".Clean($_REQUEST['A_'.$opRec.'_vehiclesComments'])."', usrskl_date='".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_'.$opRec.'_vehiclesDate'])))."', usrskl_modified='".date('Y-m-d H:i:s')."' 
		WHERE usrskl_id='".$opRec."' AND usrskl_usr_id='".$userID."' and usrskl_emp_id ='". $emp_ID."' "); 
		$response = "ajax";
		$vehiclesTable = getVehicles();
		vehiclesBlock();
		$footerScript .= '$("#appTab_vehicles").load("applicants.php",{ op: "vehiclesMenu"});';
		//// updateVehiclesMatchesMP($userID,$emp_ID);
		  $_SESSION['mymemberprofilechanged'] = 1;   // $_Session['mymemberprofilechanged'] = 1;
		////$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; die();
		break;
	case "newVehicles":
		$vehiclesID = CleanI($_REQUEST['A_new_vehiclesID']);
		if ($vehiclesID==0) $vehiclesID = QI("INSERT INTO cat_vehicles (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['A_new_vehiclesTitle'])."','".Clean($_REQUEST['A_new_vehiclesComments'])."')");
		$q= "INSERT INTO usr_vehicles (usrskl_usr_id, usrskl_emp_id , usrskl_skl_id, usrskl_title, usrskl_comment, usrskl_date, usrskl_modified) 
		VALUES ('".$userID."', '". $emp_ID."', '".$vehiclesID."','".Clean($_REQUEST['A_new_vehiclesTitle'])."','".Clean($_REQUEST['A_new_vehiclesComments'])."','".date("Y-m-d H:i:s",strtotime(Clean($_REQUEST['A_new_vehiclesDate'])))."','".date('Y-m-d H:i:s')."') "; 
    
		$did = QI($q);
			$content.= "<!-- br> trace newVehicles q=". $q .", did: ". $did. "|<< -->";
		$response = "ajax";
		$vehiclesTable = getVehicles();		
		vehiclesBlock();
		$footerScript .= '$("#appTab_vehicles").load("applicants.php",{ op: "vehiclesMenu"});setTimeout(function(){$("#A_'.$did.'_vehiclesBlock > h3").click();},500);';
		//// updateVehiclesMatchesMP($userID,$emp_ID);
		$_SESSION['mymemberprofilechanged'] = 1; // $_Session['mymemberprofilechanged'] = 1;
	    ////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;
	case "deleteVehicles": 
		$did = Q("DELETE FROM usr_vehicles WHERE usrskl_id = '".CleanI($_REQUEST['vehiclesID'])."' AND usrskl_usr_id = '".$userID."' and usrskl_emp_id ='". $emp_ID."'  "); 
		$response = "ajax";
		$vehiclesTable = getVehicles();
		vehiclesBlock();
		$footerScript .= '$("#appTab_vehicles").load("applicants.php",{ op: "vehiclesMenu"});';
		//// updateVehiclesMatchesMP($userID,$emp_ID);
		$_SESSION['mymemberprofilechanged'] = 1;  // $_Session['mymemberprofilechanged'] = 1;
	////	$emp_ID = $tempemp_ID; 
		require "inc/transmit.php"; 
		break;		
	case "geosMenu":
		$response = "ajax";
		$geoTable = getGeos();
		$content .= appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id',true);
		////$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;		
	case "proflicMenu":
		$response = "ajax";
		$proflicTable = getProflics();
		$content .= appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id',true);
		////$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;		
	case "vehiclesMenu":
		$response = "ajax";
		$vehiclesTable = getVehicles();
		$content .= appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id',true);
		////$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;		
	case "eduMenu":
		$response = "ajax";
		$eduTable = getEducat();
		$content .= appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id',true);
		////$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;
	case "sklMenu":
		$response = "ajax";
		$sklTable = getSkills();
		$content .= appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id',true);
	////	$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;
	case "agenMenu":
		$response = "ajax";
		$agcyTable = getAgency();
		$content .= appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id',true);
	////	$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;		
	case "expMenu":
		$response = "ajax";
		$expTable = getExper();
		$content .= appTab('Experience', 'exp', $expTable,'usrexp_title','usrexp_id',true);
	   ////	$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;
	case "crtMenu":
		$response = "ajax";
		$crtTable = getCerts();
		$content .= appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id',true);
		 //$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;
	case "clrMenu":
		$response = "ajax";
		$clrTable = getClearances();
		$content .= appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id',true);
		  ////$emp_ID = $tempemp_ID;
		require "inc/transmit.php";
		break;
	
		
}
////$emp_ID = $tempemp_ID;
if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_app.php\';\" >Return to Applicants List</div>");';



$footerScript .= <<<__EOS
	function numVal(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		if (key == 8 || key == 9 || key == 116) return;
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
__EOS;

$footerScript .= "
	function menuSwitch(obj){
		$(obj).parent().find('.appNavItemActive').each(function(){ $(this).css({'background':'#AED0EA','color':'#000'});});
		$(obj).css({'background':'#2694ff','color':'#fff'});
	}
$(function(){
	$('#pageContent').css('height',(parseInt($('#appNav').css('height').replace('px',''))+80)+'px');
});

";
	
$scriptLinks .= '	<script type="text/javascript" src="js/jquery.sortGrid.js"></script>
					<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>';
$cssInline .= '
	.appNavBlock { font-size:16px; font-weight:800; padding:8px; border-radius:5px;margin-bottom:10px;}
	.appNavBlock div { font-size:14px; font-weight:normal; cursor:pointer; border:1px solid #2779AA; padding:5px;text-align:right; border-radius:4px;margin-bottom:3px;}
	.applicantProfileBlock { zoom: 1; min-width:700px; }
	.appNavItemInactive {  }
	.appNavItemActive { cursor:default; }
';


//$content .= '<div class="appNavBlock ui-state-default" style="display:inline-block;width:180px;text-align:center;float:left;margin-right:-220px;margin-top:20px;margin-left:20px;">
//		<a style="display:inline-block;width:180px;" href="applicants.php?op=pdfResume" target="_blank">Download Resume</a>
//	</div>';

$content .= DBContent();
$eduTable = getEducat();
$sklTable = getSkills();
$expTable = getExper();
$crtTable = getCerts();
$clrTable = getClearances();
$clrListTable = getAllClearances();
$agcyTable = getAgency();
$proflicTable = getProflics();	
$geoTable = getGeos();
$vehiclesTable = getVehicles();

////$summary = QV("SELECT usrapp_summary FROM usr_app WHERE usrapp_usr_id = '".$userID."' and usrapp_emp_id ='". $emp_ID."'");
$usrData = Q2R("SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id WHERE U.usr_id = '".$userID."' and UA.usrapp_emp_id ='". $emp_ID."' ");
//echo("applicant line 521 here? SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id WHERE U.usr_id = " .$userID) ;
$company = Q2R("select * FROM emp where emp_id = '". $emp_ID."'");  ////'".$usrData['usr_company']."'");
$usrnames = Q2R("select * FROM usr where usr_id = '". $userID."'");
if (($userType == 0) && ($usrData['usr_type'] == 1)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}

if ($userType == 99) {
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/bc2_admins.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';	
}

//******************************************************************

   $empname = QV("SELECT emp_name from emp where emp_id = '".$emp_ID."';"); 
    $emplevel = QV("SELECT emp_level from emp where emp_id = '".$emp_ID."';"); 
/**    
    echo $empname."<br>";
    echo $emplevel."<br>";
    echo $userID;
    exit();
**/

 //$content .= ' <br> trace 106 _REQUEST[noop]: '.  $_REQUEST['noop'];
 $usr_welcome_flagSQL = "select usr_welcome_flag from usr where usr_id =".$userID."";
 $usr_welcome_flag = QV($usr_welcome_flagSQL);
 $content .= "<!-- br> br>trace 113 bc2members; usr_welcome_flag: " .$usr_welcome_flag . " < !--, usr_welcome_flagSQL: ". $usr_welcome_flagSQL ."-->";
 
 /* $content .= '<div style="text-align:center;display:block" id="showwelcomeDIV" >';
 
 $content .= '<button onmouseover="myshowhideFunction()">Show Welcome</button  > 
 </div> ';<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Government/Commercial Matches</strong>
*/
switch ($userType)
   {
     case 0:
         $showusertype = 'Primary';
         break;
     case 1: default:
         $showusertype = 'Regular';
         break;
    }     
 switch ( $emplevel)
 			     {
 			         case 1:
 			           $subleveldesc = "Silver";
 			            //$levelcolor = "#f2f2f2";
 			             $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
 			           break;
 			         case 2:   
 			          $subleveldesc = "Gold";
 			          // $levelcolor = "#FFD700";
 			            $levelfgcolor = "#FFD700";
 			          break;
 			         case 3:
 			             $subleveldesc = "Platinum";
 			             // $levelcolor 
 			              $levelfgcolor == "#F4F4F4";   // White Smile
 			             break;
 			         default:
 			            $subleveldesc = "Gold";
 			          // $levelcolor = "#FFD700";
 			            $levelfgcolor = "#FFD700";   break;      
 			     } 
 	// $userType $empname $emplevel
 $content .='<br><div align="center">';
  if ($usr_welcome_flag ==0)
 {      		     
 $content .= ' <div align="center" style="text-align:center;display:none;background-color:#9fcfff; border-radius: 10px 10px 10px 10px;width:500px;" id="mywelcomeDIV" >
         <br>  Welcome to BC2Match, first time '.$showusertype . ' Member!';
        if ($userType==0)
         {$content .= '<table align="center">
         <tr><td>
         As a '.$showusertype . ' member you  
          <ul align="left">  
         <li>will see the dashboard below </li>
         <li>can edit your profile </li>
         <li> can create other members</li>
         <li> can manage your account</li>
         <li> can buy more seats</li>';
         if ($emplevel<=1)
         {
            
            $content .= '  <li> Upgrade your company subscription level</li>';
         }
         $content .= '</ul>
         </td></tr></table>
         ';
          $content .= ' Your company, '. $empname. ' is at subscription level ' .  $subleveldesc .'.'; // <span style="background-color:'.$levelfgcolor.' "></span>';
 			          // $levelcolor = "#FFD700";   			            $levelfgcolor = "#FFD700";
 			if ($emplevel== 1)
 			{
 			     $content .= '<br> At this  <span style="background-color:'.$levelfgcolor.';"> level you may see a dashboard of opportunities that match your profile.</span>';
 			} elseif ($emplevel== 2)
 			 {
 			  	 $content .= ' <br>At this  <span style="background-color:$levelfgcolor "> level </span>you ';
 			     $content .= '<table align="center">
                   <tr><td>
                   <ul align="left">   
 			  	  <li>   may see a dashboard of opportunities that match your profile.</li>
 			  	  <li>  click on an opportunity in the dashboard to see details.</li>
 			  	  
 			  	  <li>  can build your team/opportunity.</li>';
 			  	  if ($userType==0)
 			  	  {
 			  	      $content .= '<li>can see solicitation emails and contact information.</li>
 			  	      <li> can see any other member dashboards.</li>
 			  	      <li> can see matching company  scorecards.</li>
 			  	      <li> can build your team.</li>';
 			  	  }
 			  	    $content .= '</ul>
               </td></tr></table>
 			  	 
 			  	  ';
 		   	 }
 			// } //??
         } elseif ($userType==1)
         {
             $content .= ' <table align="center">
         <tr><td>
         As a '.$showusertype . ' member you  
          <ul align="left">  
         <li>be will see the dashboard below </li>
         <li>can edit your profile </li>
          
         </ul>
         </td></tr></table>
         ';    
             
         }
    $content .= '<!-- br><button onclick="myhidewelcomeFunction()">Dismiss Welcome</button> 
     <br --></div> ';

    //echo ' myshowhideFunction() ';
 }elseif  ($usr_welcome_flag >=1) 
     { 
       // $content .= '<div align="center" style="text-align:center;display:none;background-color:#9fcfff; border-radius: 10px 10px 10px 10px;width:600px;" id="mywelcomeDIV" >
 
         //<br> Welcome to BC2Match, first time Primary user!';
         
    // $content .= '<br><button onclick="myhidewelcomeFunction()">Dismiss Welcome</button> 
 //</div> ';
 }
  $content .= '</div>';
  $uppdatewelcomeflag=  $usr_welcome_flagupdate +1;
  $usr_welcome_flagupdate = "update usr set usr_welcome_flag = ".$uppdatewelcomeflag." where usr_id =".$userID."";
 $usr_welcome_update = Q( $usr_welcome_flagupdate );
 $content.= '<!-- br> trace 239 usr_welcome_update: ' .$usr_welcome_update . ' -->';



//******************************************************************

////$content .= '<br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div>';
$content .= '<br><div style="text-align:center;">' . $usrnames['usr_firstname'] . ' ' . $usrnames['usr_lastname'] . '</div>';  //  $usrnames
$content .= '<div style="text-align:center;">' . $company['emp_name'] . '</div><br/>';


//<table style="height: 21px;" width="555" align="right">
$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="600" align="center">
<tbody>
<tr>';
//<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'">Member Profile</a></td>
//// $_SESSION['passprofile_usr'];    $_SESSION['passprofile_emp']; 
if ($emp_level > 1)
{
    $content .= '<td><a href="/'.$_SESSION['env'].'/p_admins.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Search Members</a></td>';
    $content .= '<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Build Your Team</a></td>';
}
//<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'">Search</a></td>
//<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'">Show ECAs*</a></td>   // $_SESSION['passprofile_usr'];    $_SESSION['passprofile_emp'];  
$content .= '<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$_SESSION['passprofile_usr'].'&empID='.$_SESSION['passprofile_emp'].'&company_id='.$_SESSION['passprofile_emp'].'">Return to Dashboard</a></td>';

if ( $emp_level > 0)
{
	//$_SESSION['usr_auth'] = 8;  ?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].
	$content .= '<td><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$_SESSION['passprofile_usr'].'&ptype=admin&userCompany='.$_SESSION['passprofile_emp'].'">Manage Account</a></td>';
}
	
if ($userType == 0)
{
	$company_cnt = QV("select count(*) as cnt from usr_emp where usremp_usr_id =".$_SESSION['passprofile_usr']);
	
    if ($company_cnt > 1)
    {
       $content .= '<td><a href="/'.$_SESSION['env'].'/bc2companydashboard'.$_SESSION['$usempempid'].'.php">Your Company List</a></td>';
	}	
}
$content .= $systemAdmin.'</tr>
</tbody>
</table>
</div><br>';
$content .= '<center><h2 style="text-align: center;"><span style="background-color: #ffffff;"><strong>Member Profile</strong></span></h2>';

switch ($appSection) {
	default: case "pro":
		$content .= DBContent('','Profile').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-active"  >Contact Information
					<div class="appNavItemActive" style="background:#2694ff;color:#fff;"><span style="">Editing</span></div>		
				</div>' ;
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	/////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	//	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////sum	else $content .= '	<div onclick="$.post( \'applicants.php'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
		$usrData = Q2R("SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id WHERE U.usr_id = '".$userID."' and UA.usrapp_emp_id ='". $emp_ID."' ");
 	$content .= "<!-- br> trace 764  <br>$ usrData query:  SELECT U.*, UA.* FROM usr U LEFT JOIN usr_app UA ON U.usr_id = UA.usrapp_usr_id 
 	             WHERE U.usr_id = ".$userID. "   and UA.usrapp_emp_id= ".$emp_ID." <br> -->";
	///// 	$content .= 	'	</div>';
      //				<div class="appNavBlock ui-state-default" style="display:inline-block;width:180px;text-align:center;">
//					<a id="appTab_pdf"  style="display:inline-block;width:180px;" href="applicants.php?op=pdfResume" target="_blank">Download Resume</a>
//				</div>
		$content .= '</div>';
		 
		$content .= '	<div id="accordionHolder" >';
		profileBlock();
		$content .= '
			</div>
		</div>';	
		break;
	case "edu":
		$content .= DBContent('','Union/Non-Union?').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id',true).'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	////sum	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php'?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
	//	$content .= '				</div>';
//				<div class="appNavBlock ui-state-default" style="display:inline-block;width:180px;text-align:center;">
//					<a id="appTab_pdf"  style="display:inline-block;width:180px;" href="applicants.php?op=pdfResume" target="_blank">Download Resume</a>
//				</div>
		$content .= '</div>';  //edu
		$content .= '	<div id="accordionHolder" >';
		eduBlock();
		$content .= '
			</div>
		</div>';
		break;
	case "skl":
		$content .= DBContent('','Skills').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id',true).'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////sum	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	////	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
	//////	$content .= '				</div>';
//				<div class="appNavBlock ui-state-default" style="display:inline-block;width:180px;text-align:center;">
//					<a id="appTab_pdf"  style="display:inline-block;width:180px;" href="applicants.php?op=pdfResume" target="_blank">Download Resume</a>
//				</div>
		$content .= '</div>';// skl
		$content.='	<div id="accordionHolder" >';
		sklBlock();
		$content .= '
			</div>
		</div>';
		break;
	case "proflic":
		$content .= DBContent('','Licenses').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id',true).'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////summ	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	////	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
	//////	$content .= ' 				</div>
		$content .= ' 		</div>
			<div id="accordionHolder" >';
		proflicBlock();
		$content .= '
			</div>
		</div>';
		break;	
	case "geo":
		$content .= DBContent('','Place').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id',true).'</div>';
	////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	//	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
	//  geo	
	$content .= ' 			</div>';
			$content .= ' 		<div id="accordionHolder" >';
		geoBlock();
		$content .= '			</div>';
	 	$content .= '	</div>';
		break;
		
	case "agen":
		$content .= DBContent('','Agencies').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id',true).'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	////	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
		$content .= '
			</div>
			<div id="accordionHolder" >';
		agcyBlock();
		$content .= '
			</div>
		</div>';
		break;				
	case "exp":
		$content .= DBContent('','Experience').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	//	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	//	else $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
		$content .= '		</div>
			<div id="accordionHolder" >';
		expBlock();
		$content .= '
			</div>
		</div>';
		break;
	case "crt":
		$content .= DBContent('','Certs').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\'   }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id',true).'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	//	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	//	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	//	else $content .= '	<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
		$content .= '
			</div>
			<div id="accordionHolder" >';
		crtBlock();
		$content .= '
			</div>
		</div>';
		break;
	case "vehicles":
		$content .= DBContent('','Licenses').'
		<div style="height:2000px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id',true).'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	////	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
		$content .= '
			</div>
			<div id="accordionHolder" >';
		vehiclesBlock();
		$content .= '
			</div>
		</div>';
		break;	
	case "clr":
		$content .= DBContent('','Clearances').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" 
					class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id',true).'</div>';	
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';	
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';
	////	$content .= '<div class="appNavBlock ui-state-default" >Summary';
	////	if ($summary) $content .= '	<div onclick="$.post( \'applicants.php?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Completed</span></div>';
	////	else $content .= '	<div onclick="$.post( \'applicants.php?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'sum\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div>';
		$content .= '
			</div>
			<div id="accordionHolder" >';
		clrBlock();
		$content .= '
			</div>
		</div>';
		break;

	case "summarydeleted":
		$content .= DBContent('','Summary').'
		<div style="height:1200px;">
			<div class="" id="appNav" style="float:left;width:200px;margin-left:20px;">
				<div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'applicants.php?usr='.$userID.'&company_id='. $emp_ID.'\', { \'appSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>
				</div>';
		$content .= '<div id="appTab_edu">'.appTab('Union/Non-Union?', 'edu', $eduTable,'catedu_text','usredu_id').'</div>';
		$content .= '<div id="appTab_skl">'.appTab('NAICS', 'skl', $sklTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_proflic">'.appTab('Licenses', 'proflic', $proflicTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_geo">'.appTab('Places', 'geo', $geoTable,'usrskl_title','usrskl_id').'</div>';		
		$content .= '<div id="appTab_agen">'.appTab('Agencies', 'agen', $agcyTable,'usragen_title','usragen_id').'</div>';
		$content .= '<div id="appTab_crt">'.appTab('Certs', 'crt', $crtTable,'usrcrt_title','usrcrt_id').'</div>';	
		$content .= '<div id="appTab_vehicles">'.appTab('Vehicles', 'vehicles', $vehiclesTable,'usrskl_title','usrskl_id').'</div>';
		$content .= '<div id="appTab_clr">'.appTab('Clearances', 'clr', $clrTable,'usrclr_title','usrclr_id').'</div>';
		$content .= '<div class="appNavBlock ui-state-active" >Summary';
		if ($summary) $content .= '	<div class="appNavItemInactive" style="background:#2694ff;color:#fff;"><span style="">Completed</span></div>';
		else $content .= '<div class="appNavItemActive" style="background:#2694ff;color:#fff;"><span style="">Editing</span></div>';		
		$content .= '
				</div>
			</div>
			<div id="accordionHolder" >
				<div id="accordion" style="float:left;margin-left:20px;">
				<div class="applicantProfileBlock">
					<h3>Summary</h3>
					<div style="padding:0px 0px 50px 0px ">
						<form method="post" action="#">
							<textarea id="elmSummary" rows="3" cols="36" style="width:650px;height:300px;">'.$summary.'</textarea> <br/>
							<input type="submit" value="Add" />
							<input type="hidden" name="op" value="updateSum" />
						</form>
					</div>
				</div>
				</div>
			</div>
		</div>';
  
		$scriptLinks .= '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>';
		$footerScript .= <<<XJS
		tinyMCE.init({
			// General options
	        mode : "exact",
	        elements : "elmSummary",
			theme : "advanced",
			skin : "default",
			width: "700",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
	
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,|,print,|,ltr,rtl,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,pagebreak,restoredraft,fullscreen",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : false,
	
			// Example word content CSS (should be your site CSS) this one removes paragraph margins
			content_css : "/new/css/edit.css",
	
			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "/bc2dev/inc/link_list.php",
			external_image_list_url : "/bc2dev/inc/image_list.php",
			media_external_list_url : "/bc2dev/inc/media_list.php",
	
			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});					
XJS;
		accordion();
		break;
}

$content .= '</center>';

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

//-- functions ---------------------------------------------------------------

function appTab($tabTitle, $tabAcronym, $tabTable, $tabDataField,$tabKeyField,$tabActive = false){
	global $appSection,$usempempid,$content;
////	$content .= "<!--br> trace 1093 apptab tabTitle=". $tabTitle. ", tabAcronym=". $tabAcronym. ", tabDataField=".$tabDataField. ", tabActive=". $tabActive ."|<< <br-->" ; 
	$first = 0;
	
	if ($tabActive) {
	    $help_image = 'help-15-trans.png';
	}
	else {
	    $help_image = 'help-15-trans.png';
	}
	
	switch ($tabTitle){
	    case "Union/Non-Union?": $index = 15; break;
	    case "Clearances": $index = 20; break;
	    case "NAICS": $index = 25; break;
	    case "Agencies": $index = 30; break;
	    case "Vehicles": $index = 35; break;
	    case "Licenses": $index = 40; break;
	    case "Certs": $index = 45; break;
	    case "Places": $index = 50; break;
	    case "Contact Information": $index = 10; break;
	}
	
	$help_message = QV ("Select help_message from contextual_help where help_pagename = 'applicant.php' and help_index = $index");
	
	file_put_contents("a_Pagename", "Select help_message from contextual_help where help_pagename = '$my_pagename' and help_index = $index");  
	
	$subBuffer = '<div id="appNavMenu_'.$tabAcronym.'" class="appNavBlock ui-state-'.($tabActive?'active':'default').'" >'.$tabTitle.' <div class="tooltip"><img src="images/'.$help_image.'" class="tooltip"><span class="tooltiptext">'.$help_message.'</span></div>';
	if ($tabActive) {
	    	if ($tabTable) {
	        	foreach($tabTable as $row)
	    	      { $subBuffer .= '<div id="menuEntry_'.$row[$tabKeyField].'" 
		           onclick="$(\'#A_'.$row[$tabKeyField].'_'.$tabAcronym.'Block > h3\').click();menuSwitch(this);" 
	   	           class="appNavItemActive" style="'.(!$first++?"background:#2694ff;color:#fff;":"background:#aed0ea;color:#000;").'">
	        	   <span style="">'.$row[$tabDataField].'</span></div>';
	    	      }
		         if (($tabAcronym == 'clr') || ($tabAcronym == 'edu')){
		        	$subBuffer .= '</div>';
	         	 }
	    	 	else {
			        $subBuffer .= '<div id="menuEntry_new" class="appNavItemActive" onclick="$(\'#A_add_'.$tabAcronym.'Block > h3\').click();menuSwitch(this);" 
		        	style="'.(!$first++?"background:#2694ff;color:#fff;":"background:#aed0ea;color:#000;").'" ><span style="">Add/Change</span></div></div>';
		          	  //+ Add
		        }
		        }  else {
			  $subBuffer .= '<div onclick="$.post( \'applicants.php\', { appSection : \''.$tabAcronym.'\' },
			  function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Add/Change</span></div></div>';
		       }
	   	      
	  } 
	else {
	   //// $content .= "<!--br> trace 1111  apptab  tabTable: " . $tabTable. "||<< <br><br-->";
		if ($tabTable) 
		 {
		     foreach($tabTable as $row)
		    { 
		       ////$content .= "<!--br><br>!!!!!!!! trace 1113 row[$tabDataField] =>|".$row[$tabDataField]."|<<!!!!!!!!!!!!!<br -->";
	        	$subBuffer .= '<div onclick="$.post( \'applicants.php\', { appSection : \''.$tabAcronym.'\' },
		        function() { window.location.href = \'?\'; });" 
		       class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">'.$row[$tabDataField].'</span></div>';
		     }
		     if (($tabAcronym == 'clr') || ($tabAcronym == 'edu')){
		    	$subBuffer .= '</div>';
	         }
	    	  else {
			  $subBuffer .= '<div onclick="$.post( \'applicants.php\', { appSection : \''.$tabAcronym.'\' },
			  function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Add/Change</span></div></div>';
	     	}
		 } else {
			  $subBuffer .= '<div onclick="$.post( \'applicants.php\', { appSection : \''.$tabAcronym.'\' },
			  function() { window.location.href = \'?\'; });" class="appNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Add/Change</span></div></div>';
		 }
	}	
	return $subBuffer;
}

function accordion() {
	global $footerScript;
	$footerScript .= <<<__EOS
		$(function() {
			try { $( "#accordion" ).accordion("destroy");} catch (x) {}
			$( "#accordion" )
				.accordion({ 
					header: "> div > h3",
					heightStyle: "content"
				})
		});
__EOS;
	/*			.sortable({
				axis: "y",
				handle: "h3",
				stop: function( event, ui ) { ui.item.children( "h3" ).triggerHandler( "focusout" ); }
			})*/
}

function renderExpFunction($row, $expFncTable) {
	global $trainingTable, $content, $footerScript;
	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Experience</th><th>Training</th><th>Description</th><th></th></tr></thead>
					<tbody>';
	if ($expFncTable) foreach($expFncTable as $roe) if ($row['usrexp_id']==$roe['usrexpfnc_usrexp_id']) {
		$content .= '<tr><td><input type="hidden" id="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_expID" name="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_expID" value="'.$row['usrexp_id'].'" /> 
					<input type="hidden" id="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_catID" name="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_fncID" value="'.$roe['usrexpfnc_id'].'" />
					<input type="text" id="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_title" name="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_title" class="func_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_exp" value="'.$roe['usrexpfnc_title'].'"  title="Enter keywords here to search job functions." /></td>
					<td>'.DropDown('jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_training', 'jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_training', $trainingTable, 'class="func_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_exp" onclick="$(\'#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					<td><textarea id="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_comments" name="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_comments" class="func_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_exp" rows="3" cols="36" style="width:300px">'.$roe['usrexpfnc_comment'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteExpFunction(\''.$row['usrexp_id'].'\',\''.$roe['usrexpfnc_id'].'\');" /><br/><input type="button" value="Add" style="display:none;" id="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_saveEdit" name="jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_saveEdit"  onclick="saveExpFunction(\''.$row['usrexp_id'].'\',\''.$roe['usrexpfnc_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".func_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_exp").change(function(){$("#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_saveEdit").show(1000);});
			$( "#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "functions-app", search: $( "#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "functions-app-select", search: ui.item.id }).done(	function(data) { $("#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_comments")[0].value = data; } );
					$("#jobfunc_'.$row['usrexp_id'].'_'.$roe['usrexpfnc_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobfunc_'.$row['usrexp_id'].'_new_expID" name="jobfunc_'.$row['usrexp_id'].'_new_expID" value="'.$row['usrexp_id'].'" />
			<input type="hidden" id="jobfunc_'.$row['usrexp_id'].'_new_catID" name="jobfunc_'.$row['usrexp_id'].'_new_catID" value="" />
			<input type="text" id="jobfunc_'.$row['usrexp_id'].'_new_title" name="jobfunc_'.$row['usrexp_id'].'_new_title" value="" title="Enter keywords here to search job functions."/></td>
			<td>'.DropDown('jobfunc_'.$row['usrexp_id'].'_new_training', '', $trainingTable).'</td>
			<td><textarea id="jobfunc_'.$row['usrexp_id'].'_new_comments" name="jobfunc_'.$row['usrexp_id'].'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveExpFunction(\''.$row['usrexp_id'].'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#A_'.$row['usrexp_id'].'_expStart").datepicker({ changeYear: true });$("#A_'.$row['usrexp_id'].'_expEnd").datepicker({ changeYear: true });
		$(".'.$row['usrexp_id'].'_exp").change(function(){$("#A_'.$row['usrexp_id'].'_expSave").show(1000);});
		$( "#jobfunc_'.$row['usrexp_id'].'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "functions-app", search: $( "#jobfunc_'.$row['usrexp_id'].'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobfunc_'.$row['usrexp_id'].'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "functions-app-select", search: ui.item.id }).done(	function(data) { $("#jobfunc_'.$row['usrexp_id'].'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

function profileBlock() {
	global $usrempData, $usrData, $content, $footerScript,$company,  $userID,$usempempid	,$usrnames,$emp_ID;
	// $_SESSION['passprofile_usr'];    $_SESSION['passprofile_emp'];  
	$content .='
			<div id="accordion" style="float:left;margin-left:20px;">
				<div class="applicantProfileBlock">
					<h3>Profile</h3>
					<div style="padding:20px">
						<form method="post" action="applicants.php">
						<div style="float:right;margin-right:280px;margin-top:140px;">
						 <!--tojo tidbits 10/1918	'.DropDown("Availability", "Availability", Q2T("SELECT catava_id AS 'id', catava_label AS 'label' FROM cat_avail"), " ", intval($usrData['usrapp_ava_id'])).'
						-->    </div>
					
						<div style="float:left:>
							Prefix: <input type="text" name="Prefix" value="'.$usrData['usr_prefix'].'" style="width:90px;" /><br/>
							First Name: <input type="text" name="FirstName" value="'.$usrData['usr_firstname'].'" /><br/>
							Last Name:&nbsp;<input type="text" name="LastName"  value="'.$usrData['usr_lastname'].'" /><br/>
							Company:&nbsp;&nbsp; <input type="text" name="Company"   value="'.$company['emp_name'] .'" /><br/>
							<br/><br/>
							
							<!-- Email: <input type="text" name="Email" value="'.$usrData['usr_email'].'"/>  //$usrnames -->
								Email: <input type="text" name="Email" value="'.$usrnames['usr_email'].'"/>
							<br/><br/>
							Address<br/>
							<input type="text" name="Address1" value="'.$usrempData['usremp_addr'].'" /><br/>
							<input type="text" name="Address2" value="'.$usrempData['usremp_addr1'].'" /><br/>
							<input type="text" name="Address3" value="'.$usrempData['usremp_addr2'].'"/><br/>
							City:<input type="text" name="City" value="'.$usrempData['usremp_city'].'" />, <select name="State"><option value="">...</option>';
		foreach(Q2T("SELECT * FROM res_states") as $row) $content.='<option '.($row['resst_code']==$usrempData['usremp_state']?'selected="selected" ':'').' 
		value="'.$row['resst_code'].'">'.$row['resst_code'].'</option>';		
		$content .= '</select>
							Zip: <input type="text" name="Zip" value="'.$usrempData['usremp_zip'].'" />
							<br/><br/>
							Phone: <input type="text" name="Phone" value="'.$usrempData['usremp_phone'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000<br/>
							Phone Alt: <input type="text" name="Phone2" value="'.$usrempData['usremp_phone2'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000
							<br/><br/>
							Fax: <input type="text" name="Fax" value="'.$usrempData['usremp_fax'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000
							<br/><br/>
							<input type="submit" value="Add" />
							<input type="hidden" name="op" value="updatePro" />
						</div>
						</form>
					</div>
				</div>
			</div>';
	accordion();
}


//<option value="">Select</option>'

function eduBlock() {
	global $eduTable, $content, $footerScript,$userID,$usempempid,$emp_ID;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($eduTable) foreach($eduTable as $row) {
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usredu_id'].'_eduBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usredu_id'].'\')[0]);" >Union/Non-Union?</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usredu_id'].'_edu" >
							<table border="0">
								<tr><td>Union/Non-Union?</td><td><select class="'.$row['usredu_id'].'_edu" id="A_'.$row['usredu_id'].'_eduDegree" name="A_'.$row['usredu_id'].'_eduDegree" >';
			foreach(Q2T("SELECT * FROM cat_edu order by catedu_level") as $roe) $content.='<option '.(intval($roe['catedu_id'])==intval($row['usredu_edu_id'])?'selected="selected" ':'').' value="'.$roe['catedu_id'].'">'.$roe['catedu_text'].'</option>';
			$content .= '		</select></td></tr>							
							</table>
							<div>
								<input type="button" value="Reset to Either" onclick="deleteEdu(\''.$row['usredu_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usredu_id'].'_eduSave" style="display:none;">
                                <input type="button" value="Update" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usredu_id'].'_edu\').serialize());"/>  
                                </span>
				 		<input type="hidden" name="op" value="updateEdu" />
				 		<input type="hidden" name="rec" value="'.$row['usredu_id'].'" />  
				 		</form>
					</div>
				</div>';
			$footerScript .= '$("#A_'.$row['usredu_id'].'_eduStart").datepicker({ changeYear: true });$("#A_'.$row['usredu_id'].'_eduEnd").datepicker({ changeYear: true });$(".'.$row['usredu_id'].'_edu").change(function(){$("#A_'.$row['usredu_id'].'_eduSave").show(1000);});';

		}
		$footerScript .= '$("#A_new_eduStart").datepicker({ changeYear: true });$("#A_new_eduEnd").datepicker({ changeYear: true });
		function deleteEdu(eduID) {
		 // global $userID,$usempempid,$emp_ID;
			var sure = confirm("Are you sure you want to update your Union/Non-Union entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteEdu", eduID: eduID} );
		}';
/*
		$content .= '
				<div class="applicantProfileBlock" id="A_add_eduBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Union/Non-Union?</h3>
					<div>
						<form method="post" action="#" id="form_new_edu">
							<table border="0">
								<tr><td>Union/Non-Union?</td><td><select class="new_edu" id="A_new_eduDegree" name="A_new_eduDegree" ><option value="">Select</option>';
			foreach(Q2T("SELECT * FROM cat_edu order by catedu_level") as $row) $content.='<option value="'.$row['catedu_id'].'">'.$row['catedu_text'].'</option>';
			$content .= '		</select></td></tr>								
							</table>
							<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_new_edu\').serialize());"/>
							<input type="hidden" name="op" value="newEdu" />
						</form>
					</div>
				</div>
			</div>';
*/			
	accordion();
}
function sklBlock() {
	global $sklTable, $content, $footerScript, $usempempid;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($sklTable) foreach($sklTable as $row) { 
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrskl_id'].'_sklBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrskl_id'].'\')[0]);">'.$row['usrskl_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrskl_id'].'_skl" >
							<table border="0">
								<tr><td><input type="hidden" class="new_skl" id="'.$row['usrskl_id'].'_skl_id" name="'.$row['usrskl_id'].'_skl_id" />
									NAICS</td><td><input type="text" class="'.$row['usrskl_id'].'_skl" id="A_'.$row['usrskl_id'].'_sklTitle" name="A_'.$row['usrskl_id'].'_sklTitle" style="width:300px" value="'.$row['usrskl_title'].'" />
								</td></tr>
								<tr><td></td><td><input type="hidden" class="'.$row['usrskl_id'].'_skl" id="A_'.$row['usrskl_id'].'_sklDate" name="A_'.$row['usrskl_id'].'_sklDate" style="width:100px" value="'.$row['usrskl_date'].'" /></td></tr>								
							</table>
                            Description (optional) <br/><textarea class="'.$row['usrskl_id'].'_skl" id="A_'.$row['usrskl_id'].'_sklComments" name="A_'.$row['usrskl_id'].'_sklComments" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrskl_comment'].'</textarea><br/>
							<div>
								<input type="button" value="Delete" onclick="deleteSkl(\''.$row['usrskl_id'].'\');" />&nbsp;&nbsp;&nbsp;					
								<span id="A_'.$row['usrskl_id'].'_sklSave" style="display:none;">								
									<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrskl_id'].'_skl\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div>
							<input type="hidden" name="A_'.$row['usrskl_id'].'_sklID" value="'.$row['usrskl_skl_id'].'" />
							<input type="hidden" name="rec" value="'.$row['usrskl_id'].'"/>
							<input type="hidden" name="op" value="updateSkl" />
						</form>
					</div>
				</div>';
			$footerScript .= '$(".'.$row['usrskl_id'].'_skl").change(function(){$("#A_'.$row['usrskl_id'].'_sklSave").show(1000);});
				$("#A_'.$row['usrskl_id'].'_sklDate").datepicker({ changeYear: true });
				$("#A_'.$row['usrskl_id'].'_sklTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "skills-app", search: $( "#A_'.$row['usrskl_id'].'_sklTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usrskl_id'].'_sklID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "skills-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usrskl_id'].'_sklComments")[0].value = data; } );
						$("#A_'.$row['usrskl_id'].'_sklSave").show(1000);
					}
				});';
			}			
		$content .= '
				<div class="applicantProfileBlock" id="A_add_sklBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add NAICS</h3>
					<div>
						<form method="post" action="#" id="form_new_skill">
							<table border="0">
								<td><input type="hidden" class="new_skl" id="A_new_sklID" name="A_new_sklID" />
								</td></tr>
								<tr><td>							
									NAICS</td><td><input type="text" class="new_skl" id="A_new_sklTitle" name="A_new_sklTitle" style="width:300px"/></td></tr>
								<tr><td></td><td><input type="hidden" class="new_skl" id="A_new_sklDate" name="A_new_sklDate" style="width:10px" /> </td></tr>
								<tr><td>Description</td><td><input type="text" class="new_skl" id="A_new_sklComments" name="A_new_sklComments" style="width:400px"/></td></tr>
							</table>
							<input type="button" value="Add" onclick="newSkl();"/>
							<input type="hidden" name="op" value="newSkl" />
						</form>
					</div>
				</div>
			</div>';
		$footerScript .= '
		$("#A_new_sklDate").datepicker({ changeYear: true });
		function deleteSkl(sklID) {
			var sure = confirm("Are you sure you want to delete this skill entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteSkl", sklID: sklID} );
		}
		function alreadythereSkl(sklID)
		{
		   ID = document.getElementById("form_new_skill").elements[0].value;
		    	var sure = confirm("Skill entry already exists - enter new one");
			//if (sure == true ) $("#accordion").load("applicants.php", $(\'#form_new_skill\').serialize(), {  ); 
		
			//$("#accordion").load("applicants.php", { op: "newSkl", sklID: sklID} );
			///$("#accordion").load("applicants.php", $(\'#form_new_skill\').serialize(), { op: "newSkl", sklID: ID} );
			///$("#accordion").load("applicants.php", { op: "newSkl", sklID: sklID} );
			//$("#accordion").load("applicants.php", $(\'#form_new_skill\').serialize(), { op: "newSkl", sklID: ID} ); 
			
		}
		
		function newSkl() {
			ID = document.getElementById("form_new_skill").elements[0].value;
			if (ID == 0)
				confirm("You must select a value from the list. Clear the search box and try again.");				
			else 
				$("#accordion").load("applicants.php", $(\'#form_new_skill\').serialize(), { op: "newSkl", sklID: ID} );
		}		
		$( "#A_new_sklTitle" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "skills-app", search: $( "#A_new_sklTitle" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
						$("#A_new_sklID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "skills-app-select", search: ui.item.id }).done( function(data) { $("#A_new_sklComments")[0].value = data; } );
						$("#A_new_sklSave").show(1000);			}
		});';
	accordion();
}

function vehiclesBlock() {
	global $vehiclesTable, $content, $footerScript, $usempempid;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($vehiclesTable) foreach($vehiclesTable as $row) {
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrskl_id'].'_vehiclesBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrskl_id'].'\')[0]);">'.$row['usrskl_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrskl_id'].'_vehicles" >
							<table border="0">
								<tr><td><input type="hidden" class="new_vehicles" id="'.$row['usrskl_id'].'_vehicles_id" name="'.$row['usrskl_id'].'_vehicles_id" />
									Vehicle</td><td><input type="text" class="'.$row['usrskl_id'].'_vehicles" id="A_'.$row['usrskl_id'].'_vehiclesTitle" name="A_'.$row['usrskl_id'].'_vehiclesTitle" style="width:300px" value="'.$row['usrskl_title'].'" />
								</td></tr>
								<tr><td></td><td><input type="hidden" class="'.$row['usrskl_id'].'_vehicles" id="A_'.$row['usrskl_id'].'_vehiclesDate" name="A_'.$row['usrskl_id'].'_vehiclesDate" style="width:100px" value="'.$row['usrskl_date'].'" /></td></tr>
							</table>
							Description (optional) <br/><textarea class="'.$row['usrskl_id'].'_vehicles" id="A_'.$row['usrskl_id'].'_vehiclesComments" name="A_'.$row['usrskl_id'].'_vehiclesComments" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrskl_comment'].'</textarea><br/>
							<div>
								<input type="button" value="Delete" onclick="deleteVehicles(\''.$row['usrskl_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usrskl_id'].'_vehiclesSave" style="display:none;">
									<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrskl_id'].'_vehicles\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div>							
							<input type="hidden" name="A_'.$row['usrskl_id'].'_vehiclesID" value="'.$row['usrskl_vehicles_id'].'" />
							<input type="hidden" name="rec" value="'.$row['usrskl_id'].'"/>
							<input type="hidden" name="op" value="updateVehicles" />
						</form>
					</div>
				</div>';
			$footerScript .= '$(".'.$row['usrskl_id'].'_vehicles").change(function(){$("#A_'.$row['usrskl_id'].'_vehiclesSave").show(1000);});
				$("#A_'.$row['usrskl_id'].'_vehiclesDate").datepicker({ changeYear: true });
				$("#A_'.$row['usrskl_id'].'_vehiclesTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "vehicles-app", search: $( "#A_'.$row['usrskl_id'].'_vehiclesTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usrskl_id'].'_vehiclesID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "vehicles-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usrskl_id'].'_vehiclesComments")[0].value = data; } );
						$("#A_'.$row['usrskl_id'].'_vehiclesSave").show(1000);
					}
				});';
			}			
		$content .= '
				<div class="applicantProfileBlock" id="A_add_vehiclesBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Vehicle</h3>
					<div>
						<form method="post" action="#" id="form_new_vehicles">
							<table border="0">
								<td><input type="hidden" class="new_skl" id="A_new_vehiclesID" name="A_new_vehiclesID" />
								</td></tr>
								<tr><td>							
									Vehicle</td><td><input type="text" class="new_skl" id="A_new_vehiclesTitle" name="A_new_vehiclesTitle" style="width:300px"/></td></tr>
								<tr><td></td><td><input type="hidden" class="new_skl" id="A_new_vehiclesDate" name="A_new_vehiclesDate" style="width:10px" /> </td></tr>
								<tr><td>Description</td><td><input type="text" class="new_skl" id="A_new_vehiclesComments" name="A_new_vehiclesComments" style="width:400px"/></td></tr>
							</table>
							<input type="button" value="Add" onclick="newVehicle();"/>
							<input type="hidden" name="op" value="newVehicles" />
						</form>
					</div>
				</div>
			</div>';
		$footerScript .= '
		$("#A_new_vehiclesDate").datepicker({ changeYear: true });
		function deleteVehicles(vehiclesID) {
			var sure = confirm("Are you sure you want to delete this Vehicle entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteVehicles", vehiclesID: vehiclesID} );
		}
		function newVehicle() {
			ID = document.getElementById("form_new_vehicles").elements[0].value;
			if (ID == 0) 
				confirm("You must select a value from the list. Clear the search box and try again.");				
			else 				
				$("#accordion").load("applicants.php", $(\'#form_new_vehicles\').serialize(), { op: "newVehicles", A_new_vehiclesID: ID} );
		}		
		
		$( "#A_new_vehiclesTitle" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "vehicles-app", search: $( "#A_new_vehiclesTitle" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
						$("#A_new_vehiclesID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "vehicles-app-select", search: ui.item.id }).done( function(data) { $("#A_new_vehiclesComments")[0].value = data; } );
						$("#A_new_vehiclesSave").show(1000);			}
		});';
	accordion();
}

function proflicBlock() {
	global $proflicTable, $content, $footerScript, $usempempid;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($proflicTable) foreach($proflicTable as $row) { 
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrskl_id'].'_proflicBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrskl_id'].'\')[0]);">'.$row['usrskl_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrskl_id'].'_proflic" >
							<table border="0">
								<tr><td><input type="hidden" class="new_proflic" id="'.$row['usrskl_id'].'_proflic_id" name="'.$row['usrskl_id'].'_proflic_id" />
									License</td><td><input type="text" class="'.$row['usrskl_id'].'_proflic" id="A_'.$row['usrskl_id'].'_proflicTitle" name="A_'.$row['usrskl_id'].'_proflicTitle" style="width:300px" value="'.$row['usrskl_title'].'" />
								</td></tr>
								<tr><td></td><td><input type="hidden" class="'.$row['usrskl_id'].'_proflic" id="A_'.$row['usrskl_id'].'_proflicDate" name="A_'.$row['usrskl_id'].'_proflicDate" style="width:100px" value="'.$row['usrskl_date'].'" /></td></tr>
							</table>
							Description (optional) <br/><textarea class="'.$row['usrskl_id'].'_proflic" id="A_'.$row['usrskl_id'].'_proflicComments" name="A_'.$row['usrskl_id'].'_proflicComments" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrskl_comment'].'</textarea><br/>
							<div>
								<input type="button" value="Delete" onclick="deleteProflic(\''.$row['usrskl_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usrskl_id'].'_proflicSave" style="display:none;">
									<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrskl_id'].'_proflic\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div>
							<input type="hidden" name="A_'.$row['usrskl_id'].'_proflicID" value="'.$row['usrskl_proflic_id'].'" />
							<input type="hidden" name="rec" value="'.$row['usrskl_id'].'"/>
							<input type="hidden" name="op" value="updateProflic" />
						</form>
					</div>
				</div>';
			$footerScript .= '$(".'.$row['usrskl_id'].'_proflic").change(function(){$("#A_'.$row['usrskl_id'].'_proflicSave").show(1000);});
				$("#A_'.$row['usrskl_id'].'_proflicDate").datepicker({ changeYear: true });
				$("#A_'.$row['usrskl_id'].'_proflicTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "proflics-app", search: $( "#A_'.$row['usrskl_id'].'_proflicTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usrskl_id'].'_proflicID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "proflics-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usrskl_id'].'_proflicComments")[0].value = data; } );
						$("#A_'.$row['usrskl_id'].'_proflicSave").show(1000);
					}
				});';
			}			
		$content .= '
				<div class="applicantProfileBlock" id="A_add_proflicBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add License</h3>
					<div>
						<form method="post" action="#" id="form_new_proflic">
							<table border="0">
								<td><input type="hidden" class="new_skl" id="A_new_proflicID" name="A_new_proflicID" />
								</td></tr>
								<tr><td>							
									License</td><td><input type="text" class="new_skl" id="A_new_proflicTitle" name="A_new_proflicTitle" style="width:300px"/></td></tr>
								<tr><td></td><td><input type="hidden" class="new_skl" id="A_new_proflicDate" name="A_new_proflicDate" style="width:10px" /> </td></tr>
								<tr><td>Description</td><td><input type="text" class="new_skl" id="A_new_proflicComments" name="A_new_proflicComments" style="width:400px"/></td></tr>
							</table>
							<input type="button" value="Add" onclick="newProflic();"/>
							<input type="hidden" name="op" value="newProflic" />
						</form>
					</div>
				</div>
			</div>';
		$footerScript .= '
		$("#A_new_proflicDate").datepicker({ changeYear: true });
		function deleteProflic(proflicID) {
			var sure = confirm("Are you sure you want to delete this Licenses entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteProflic", proflicID: proflicID} );
		}
		function newProflic() {
			ID = document.getElementById("form_new_proflic").elements[0].value;
			if (ID == 0) 
				confirm("You must select a value from the list. Clear the search box and try again.");				
			else 				
				$("#accordion").load("applicants.php", $(\'#form_new_proflic\').serialize(), { op: "newProflic", A_new_proflicID: ID} );
		}
		$( "#A_new_proflicTitle" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "proflics-app", search: $( "#A_new_proflicTitle" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
						$("#A_new_proflicID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "proflics-app-select", search: ui.item.id }).done( function(data) { $("#A_new_proflicComments")[0].value = data; } );
						$("#A_new_proflicSave").show(1000);			}
		});';
	accordion();
}		

function geoBlock() {
	global $geoTable, $content, $footerScript,$usempempid;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($geoTable) foreach($geoTable as $row) { 
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrskl_id'].'_geoBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrskl_id'].'\')[0]);">'.$row['usrskl_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrskl_id'].'_geo" >
							<table border="0">
								<tr><td><input type="hidden" class="new_geo" id="'.$row['usrskl_id'].'_geo_id" name="'.$row['usrskl_id'].'_geo_id" />
									Place</td><td><input type="text" class="'.$row['usrskl_id'].'_geo" id="A_'.$row['usrskl_id'].'_geoTitle" name="A_'.$row['usrskl_id'].'_geoTitle" style="width:300px" value="'.$row['usrskl_title'].'" />
								</td></tr>
								<tr><td></td><td><input type="hidden" class="'.$row['usrskl_id'].'_geo" id="A_'.$row['usrskl_id'].'_geoDate" name="A_'.$row['usrskl_id'].'_geoDate" style="width:100px" value="'.$row['usrskl_date'].'" /></td></tr>
							</table>
							Description (optional) <br/><textarea class="'.$row['usrskl_id'].'_geo" id="A_'.$row['usrskl_id'].'_geoComments" name="A_'.$row['usrskl_id'].'_geoComments" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrskl_comment'].'</textarea><br/>
							<div>
								<input type="button" value="Delete" onclick="deleteGeo(\''.$row['usrskl_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usrskl_id'].'_geoSave" style="display:none;">
									<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrskl_id'].'_geo\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div>
							<input type="hidden" name="A_'.$row['usrskl_id'].'_geoID" value="'.$row['usrskl_geo_id'].'" />
							<input type="hidden" name="rec" value="'.$row['usrskl_id'].'"/>
							<input type="hidden" name="op" value="updateGeo" />
						</form>
					</div>
				</div>';
			$footerScript .= '$(".'.$row['usrskl_id'].'_geo").change(function(){$("#A_'.$row['usrskl_id'].'_geoSave").show(1000);});
				$("#A_'.$row['usrskl_id'].'_geoDate").datepicker({ changeYear: true });
				$("#A_'.$row['usrskl_id'].'_geoTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "geos-app", search: $( "#A_'.$row['usrskl_id'].'_geoTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usrskl_id'].'_geoID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "geos-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usrskl_id'].'_geoComments")[0].value = data; } );
						$("#A_'.$row['usrskl_id'].'_geoSave").show(1000);
					}
				});';
			}			
		$content .= '
				<div class="applicantProfileBlock" id="A_add_geoBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Place</h3>
					<div>
						<form method="post" action="#" id="form_new_geo">
							<table border="0">
								<td><input type="hidden" class="new_skl" id="A_new_geoID" name="A_new_geoID" />
								</td></tr>
								<tr><td>							
									Place</td><td><input type="text" class="new_skl" id="A_new_geoTitle" name="A_new_geoTitle" style="width:300px"/></td></tr>
								<tr><td></td><td><input type="hidden" class="new_skl" id="A_new_geoDate" name="A_new_geoDate" style="width:10px" /> </td></tr>
								<tr><td>Description</td><td><input type="text" class="new_skl" id="A_new_geoComments" name="A_new_geoComments" style="width:400px"/></td></tr>
							</table>
							<input type="button" value="Add" onclick="newGeo();"/>
							<input type="hidden" name="op" value="newGeo" />
						</form>
					</div>
				</div>
			</div>';
		$footerScript .= '
		$("#A_new_geoDate").datepicker({ changeYear: true });
		function deleteGeo(geoID) {
			var sure = confirm("Are you sure you want to delete this Place entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteGeo", geoID: geoID} );
		}
			function alreadythereGeo(geoID)
		{
		   ID = document.getElementById("form_new_geo").elements[0].value;
		    	var sure = confirm("Place entry already exists - enter new one");
		}
		function newGeo() {
			ID = document.getElementById("form_new_geo").elements[0].value;
			if (ID == 0) 
				confirm("You must select a value from the list. Clear the search box and try again.");				
			else 				
				$("#accordion").load("applicants.php", $(\'#form_new_geo\').serialize(), { op: "newGeo", A_new_geoID: ID} );
		}
		$( "#A_new_geoTitle" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "geos-app", search: $( "#A_new_geoTitle" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
						$("#A_new_geoID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "geos-app-select", search: ui.item.id }).done( function(data) { $("#A_new_geoComments")[0].value = data; } );
						$("#A_new_geoSave").show(1000);			}
		});';
	accordion();
}		


	function agcyBlock() {
	global $agcyTable, $content, $footerScript, $usempempid;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($agcyTable) foreach($agcyTable as $row) { 
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usragen_id'].'_agcyBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usragen_id'].'\')[0]);">'.$row['usragen_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usragen_id'].'_agen" >
							<table border="0">
								<tr><td><input type="hidden" class="new_skl" id="'.$row['usragen_id'].'_agen_id" name="'.$row['usragen_id'].'_agen_id" />
									Agency</td><td><input type="text" class="'.$row['usragen_id'].'_agen" id="A_'.$row['usragen_id'].'_agenTitle" name="A_'.$row['usragen_id'].'_agenTitle" style="width:300px" value="'.$row['usragen_title'].'" />
								</td></tr>
								<tr><td></td><td><input type="hidden" class="'.$row['usragen_id'].'_agen" id="A_'.$row['usragen_id'].'_agenDate" name="A_'.$row['usragen_id'].'_agenDate" style="width:100px" value="'.$row['usragen_date'].'" /></td></tr>
							</table>
							Description (optional) <br/><textarea class="'.$row['usragen_id'].'_agen" id="A_'.$row['usragen_id'].'_agenComments" name="A_'.$row['usragen_id'].'_agenComments" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usragen_comment'].'</textarea><br/>
							<div>
								<input type="button" value="Delete" onclick="deleteAgcy(\''.$row['usragen_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usragen_id'].'_agenSave" style="display:none;">
									<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usragen_id'].'_agen\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div>
							<input type="hidden" name="A_'.$row['usragen_id'].'_agenID" value="'.$row['usragen_skl_id'].'" />
							<input type="hidden" name="rec" value="'.$row['usragen_id'].'"/>
							<input type="hidden" name="op" value="updateAgcy" />
						</form>
					</div>
				</div>';
			$footerScript .= '$(".'.$row['usragen_id'].'_agen").change(function(){$("#A_'.$row['usragen_id'].'_agenSave").show(1000);});
				$("#A_'.$row['usragen_id'].'_agenDate").datepicker({ changeYear: true });
				$("#A_'.$row['usragen_id'].'_agenTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "agencies-app", search: $( "#A_'.$row['usragen_id'].'_agenTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usragen_id'].'_agenID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "agencies-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usragen_id'].'_agenComments")[0].value = data; } );
						$("#A_'.$row['usragen_id'].'_agenSave").show(1000);
					}
				});';
			}			
		$content .= '
				<div class="applicantProfileBlock" id="A_add_agcyBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Agency</h3>
					<div>
						<form method="post" action="#" id="form_new_agency">
							<table border="0">
								<td><input type="hidden" class="new_skl" id="A_new_agenID" name="A_new_agenID" />
								</td></tr>
								<tr><td>							
									Agency</td><td><input type="text" class="new_skl" id="A_new_agenTitle" name="A_new_agenTitle" style="width:300px"/></td></tr>
								<tr><td></td><td><input type="hidden" class="new_skl" id="A_new_agenDate" name="A_new_agenDate" style="width:10px" /> </td></tr>
								<tr><td>Description</td><td><input type="text" class="new_skl" id="A_new_agenComments" name="A_new_agenComments" style="width:400px"/></td></tr>
							</table>
							<input type="button" value="Add" onclick="newAgcy();"/>
							<input type="hidden" name="op" value="newAgcy" />
						</form>
					</div>
				</div>
			</div>';
			$footerScript .= '
		$("#A_new_agenDate").datepicker({ changeYear: true });
		function deleteAgcy(agenID) {
			var sure = confirm("Are you sure you want to delete this agency entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteAgcy", agenID: agenID} );
		}
			function alreadythereAgcy(agenID)
		{
		   ID = document.getElementById("form_new_agency").elements[0].value;
		    	var sure = confirm("Agency entry already exists - enter new one");
		}
		function newAgcy() {
			ID = document.getElementById("form_new_agency").elements[0].value;
			if (ID == 0) 
				confirm("You must select a value from the list. Clear the search box and try again.");				
			else 				
				$("#accordion").load("applicants.php", $(\'#form_new_agency\').serialize(), { op: "newAgcy", A_new_agenID: ID} );
		}
		$( "#A_new_agenTitle" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "agencies-app", search: $( "#A_new_agenTitle" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
						$("#A_new_agenID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "agencies-app-select", search: ui.item.id }).done( function(data) { $("#A_new_agenComments")[0].value = data; } );
						$("#A_new_agenSave").show(1000);			}
		});';
	accordion();
}

function expBlock() {
	global $expTable, $content, $footerScript, $userID,$usempempid,$emp_ID;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($expTable) foreach($expTable as $row) {
			$expFncTable = getFuncs($row['usrexp_id']);
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrexp_id'].'_expBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrexp_id'].'\')[0]);">'.$row['usrexp_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrexp_id'].'_exp">
							<table border="0">
								<tr><td>Employer </td><td><input type="text" class="'.$row['usrexp_id'].'_exp" id="A_'.$row['usrexp_id'].'_expEmployer" name="A_'.$row['usrexp_id'].'_expEmployer" style="width:300px" value="'.$row['usrexp_employer'].'" /></td>
									<td style="text-align:right">Started:<input type="text" id="A_'.$row['usrexp_id'].'_expStart" name="A_'.$row['usrexp_id'].'_expStart" class="'.$row['usrexp_id'].'_exp" style="width:90px" value="'.$row['usrexp_start'].'" title="yyyy-mm-dd"/> yyyy-mm-dd</td>
								</tr>
								<tr><td>Job Title</td><td><input type="text" class="'.$row['usrexp_id'].'_exp" id="A_'.$row['usrexp_id'].'_expTitle" name="A_'.$row['usrexp_id'].'_expTitle" style="width:300px" value="'.$row['usrexp_title'].'" /></td>
									<td style="text-align:right">Ended: <input type="text" id="A_'.$row['usrexp_id'].'_expEnd" name="A_'.$row['usrexp_id'].'_expEnd" class="'.$row['usrexp_id'].'_exp" style="width:90px" value="'.$row['usrexp_end'].'" title="yyyy-mm-dd"/> yyyy-mm-dd</td>
								</tr>
								<tr><td>Location </td><td><input type="text" class="'.$row['usrexp_id'].'_exp" id="A_'.$row['usrexp_id'].'_expLocation" name="A_'.$row['usrexp_id'].'_expLocation" style="width:300px" value="'.$row['usrexp_location'].'" /></td>
									<td style="text-align:right"><!--input type="checkbox" name="A_'.$row['usrexp_id'].'_expEmpPresent" />(presently employed)--></td>
								</tr>
							</table>
							Description (optional) <br/><textarea name="A_'.$row['usrexp_id'].'_expComments" class="'.$row['usrexp_id'].'_exp" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrexp_comment'].'</textarea><br/><br/>
							<div>
								<input type="button" value="Delete Job Entry" onclick="deleteExp(\''.$row['usrexp_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usrexp_id'].'_expSave" style="display:none;">
									<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrexp_id'].'_exp\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div><br/>
							<div id="jobfunc_'.$row['usrexp_id'].'">';
				$content .= renderExpFunction($row,$expFncTable);
				$content .= '							
							</div>
							<input type="hidden" name="rec" value="'.$row['usrexp_id'].'"/>
							<input type="hidden" name="op" value="updateExp" />
						</form>
					</div>
				</div>';
			$footerScript .= '
				function saveExpFunction(expID,funcID) {
					$("#jobfunc_"+expID).load("applicants.php", {
						op: (funcID=="new"?"newFunc":"updateFunc"),
						expID: expID,
						funcID: funcID,
						catID: $("#jobfunc_"+expID+"_"+funcID+"_catID")[0].value,
						title: $("#jobfunc_"+expID+"_"+funcID+"_title")[0].value,
						training: $("#jobfunc_"+expID+"_"+funcID+"_training")[0].value,
						comments: $("#jobfunc_"+expID+"_"+funcID+"_comments")[0].value,
					}); 
				}
				function deleteExp(expID) {
					var sure = confirm("Are you sure you want to delete this entire job entry and any functions listed below?");
					if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteExp", expID: expID} );
				}
				function deleteExpFunction(expID,funcID) {
					var sure = confirm("Are you sure you want to delete this job function entry?");
					if (sure == true ) $("#jobfunc_"+expID).load("applicants.php", {
						op: "deleteFunc",
						expID: expID,
						funcID: funcID
					}); 
				}
				';
		}
		$footerScript .= '$("#A_new_expStart").datepicker({ changeYear: true });$("#A_new_expEnd").datepicker({ changeYear: true });';
		$content .= '
				<div class="applicantProfileBlock" id="A_add_expBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Experience</h3>
					<div>
						<form method="post" action="#" id="form_new_exp">
							<table border="0">
								<tr><td>Employer </td><td><input type="text" id="A_new_expEmp" name="A_new_expEmployer" style="width:300px"/></td>
									<td style="text-align:right">Started:<input type="text" id="A_new_expStart" name="A_new_expStart" style="width:90px" title="yyyy-mm-dd"/> yyyy-mm-dd</td>
								</tr>
								<tr><td>Job Title</td><td><input type="text" id="A_new_expTitle" name="A_new_expTitle" style="width:300px"/></td>
									<td style="text-align:right">Ended: <input type="text" id="A_new_expEnd" name="A_new_expEnd" style="width:90px" title="yyyy-mm-dd"/> yyyy-mm-dd</td>
								</tr>
								<tr><td>Location </td><td><input type="text" id="A_new_expLocation" name="A_new_expLocation" style="width:300px"/></td>
									<td style="text-align:right"><input type="checkbox" name="A_new_expEmpPresent" />(presently employed)</td>
								</tr>
								<tr><td colspan="3">Description (optional) <br/><textarea name="A_new_expComments" rows="6" cols="60" style="width:500px;height:100px;"></textarea></td></tr>
							</table>
							<br/>
							<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_new_exp\').serialize());"/>
							<input type="hidden" name="op" value="newExp" />
						</form>
					</div>
				</div>
			</div>';
	accordion();
}
function crtBlock() {
	global $crtTable, $content, $footerScript,$usempempid,$userID,$emp_ID;
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($crtTable) foreach($crtTable as $row) {
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrcrt_id'].'_crtBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrcrt_id'].'\')[0]);">'.$row['usrcrt_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrcrt_id'].'_crt" >
							<table border="0">
								<input type="hidden" id="A_'.$row['usrcrt_id'].'_crtID" name="A_'.$row['usrcrt_id'].'_crtID" style="width:300px" value="'.$row['usrcrt_crt_id'].'" />
								<tr><td>Cert</td><td><input type="text" class="'.$row['usrcrt_id'].'_crt" id="A_'.$row['usrcrt_id'].'_crtTitle" name="A_'.$row['usrcrt_id'].'_crtTitle" style="width:300px" value="'.$row['usrcrt_title'].'" /></td></tr>
								<tr><td></td><td><input type="hidden" id="A_'.$row['usrcrt_id'].'_crtDate" class="'.$row['usrcrt_id'].'_crt" name="A_'.$row['usrcrt_id'].'_crtDate" style="width:90px" value="'.date("Y-m-d",strtotime($row['usrcrt_date'])).'" title="yyyy-mm-dd" /></td></tr>
							</table>
							Description (optional) <br/><textarea name="A_'.$row['usrcrt_id'].'_crtComments" id="A_'.$row['usrcrt_id'].'_crtComments" class="'.$row['usrcrt_id'].'_crt" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrcrt_comment'].'</textarea><br/>
							<div> 
								<input type="button" value="Delete" onclick="deleteCrt(\''.$row['usrcrt_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usrcrt_id'].'_crtSave" style="display:none;">
								<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrcrt_id'].'_crt\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>
							</div>
							<input type="hidden" name="rec" value="'.$row['usrcrt_id'].'"/>
							<input type="hidden" name="op" value="updateCrt" />
						</form>
					</div>
				</div>';
			$footerScript .= '$("#A_'.$row['usrcrt_id'].'_crtDate").datepicker({ changeYear: true });$(".'.$row['usrcrt_id'].'_crt").change(function(){$("#A_'.$row['usrcrt_id'].'_crtSave").show(1000);});
				$( "#A_'.$row['usrcrt_id'].'_crtTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "certifications-app", search: $( "#A_'.$row['usrcrt_id'].'_crtTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usrcrt_id'].'_crtID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "certifications-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usrcrt_id'].'_crtComments")[0].value = data; } );
						$("#A_'.$row['usrcrt_id'].'_crtSave").show(1000);
					}
				});';
		}
		$footerScript .= '$("#A_new_crtDate").datepicker({ changeYear: true });
				$( "#A_new_crtTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "certifications-app", search: $( "#A_new_crtTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_new_crtID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "certifications-app-select", search: ui.item.id }).done( function(data) { $("#A_new_crtComments")[0].value = data; } );
						$("#A_new_crtSave").show(1000);			
					}
				});
			function alreadythereCrt(crtID)
		{
		   ID = document.getElementById("form_new_crt").elements[0].value;
		    	var sure = confirm("Certification entry already exists - enter new one");
			//if (sure == true )$("#accordion").load("applicants.php",  $(\'#form_new_cert\').serialize(), {  );
			//{ op: "newCrt", crtID: crtID} );		 ///ID = document.getElementById("form_new_skill").elements[0].value;
		    ////	var sure = confirm("Skill entry already exists - enter new one");
		    //if (sure == true ) $("#accordion").load("applicants.php", $(\'#form_new_skill\').serialize(), {  ); 
		}		
		function deleteCrt(crtID) {
			var sure = confirm("Are you sure you want to delete this certification entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteCrt", crtID: crtID} );
		}';
		$content .= '
				<div class="applicantProfileBlock" id="A_add_crtBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Cert</h3>
					<div>
						<form method="post" action="#" id="form_new_crt">
							<table border="0">
								<tr><td><input type="hidden" class="new_crt" id="A_new_crtID" name="A_new_crtID" />
								</td></tr>
								<tr><td>Cert</td><td><input type="text" class="new_crt" id="A_new_crtTitle" name="A_new_crtTitle" style="width:300px"/></td></tr>
								<tr><td></td><td><input type="hidden" id="A_new_crtDate" class="new_crt" name="A_new_crtDate" style="width:90px" /></td></tr>							
								<tr><td>Description</td><td><input type="text" class="new_crt" id="A_new_crtComments" name="A_new_crtComments" style="width:400px"/></td></tr>
							</table>
							<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_new_crt\').serialize());"/>
							<input type="hidden" name="op" value="newCrt" />
						</div>
					</form>
				</div>
			</div>';
	accordion();
}


							    //<tr><td>Description (optional) <br/><textarea name="A_new_crtComments" id="A_new_crtComments" class="new_crt" rows="6" cols="60" style="width:500px;height:100px;"></textarea><br/>


function clrBlock() {
	global $clrTable,$clrListTable, $content, $footerScript,$usempempid;

//DropDown('A_new_clrTitle', 'A_new_clrTitle', $clrListTable, 'class="new_clr" ',0)
	
//function DropDown($id, $name, $dataTable, $inline = '', $selected = '') {
//	$subBuffer = "<select id='".$id."' name='".$name."' ".$inline." >";
//	foreach ($dataTable as $row) $subBuffer .= "<option ".($row['id']==$selected?'selected="selected"':'')." value='".$row['id']."'>".$row['label']."</option>";
//	$subBuffer .= "</select>";
//	return $subBuffer;
//} 	
		$content .='<div id="accordion" style="float:left;margin-left:20px;">';
		if ($clrTable) foreach($clrTable as $row) {
			$content .= '
				<div class="applicantProfileBlock" id="A_'.$row['usrclr_id'].'_clrBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrclr_id'].'\')[0]);">'.$row['usrclr_title'].'</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrclr_id'].'_clr" >
							<table border="0">
								<input type="hidden" id="A_'.$row['usrclr_id'].'_clrID" name="A_'.$row['usrclr_id'].'_clrID" style="width:300px" value="'.$row['usrclr_clr_id'].'" />'
								//<tr><td>Title</td><td><select type="text" class="'.$row['usrclr_id'].'_clr" id="A_'.$row['usrclr_id'].'_clrTitle" name="A_'.$row['usrclr_id'].'_clrTitle" style="width:300px" value="'.$row['usrclr_title'].'" /></td></tr>
								.'<tr><td>Title</td><td>'.DropDown('A_'.$row['usrclr_id'].'_clrTitle', 'A_'.$row['usrclr_id'].'_clrTitle', $clrListTable, 'class="'.$row['usrclr_id'].'_clr" ',$row['catclr_id']).'</td></tr>
								<tr><td></td><td><input type="hidden" id="A_'.$row['usrclr_id'].'_clrDate" class="'.$row['usrclr_id'].'_clr" name="A_'.$row['usrclr_id'].'_clrDate" style="width:90px" value="'.date("Y-m-d",strtotime($row['usrclr_date'])).'" title="yyyy-mm-dd" /></td></tr>
							</table>';
							//Description (optional) <br/><textarea name="A_'.$row['usrclr_id'].'_clrComments" id="A_'.$row['usrclr_id'].'_clrComments" class="'.$row['usrclr_id'].'_clr" rows="6" cols="60" style="width:500px;height:100px;">'.$row['usrclr_comment'].'</textarea><br/>
							//<input type="reset" value="Reset" />
				$content .= '<div> 
								<input type="button" value="Reset to None" onclick="deleteClr(\''.$row['usrclr_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="A_'.$row['usrclr_id'].'_clrSave" style="display:none;">
								<input type="button" value="Update" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_'.$row['usrclr_id'].'_clr\').serialize());"/>&nbsp;&nbsp;
								</span>
							</div>
							<input type="hidden" name="rec" value="'.$row['usrclr_id'].'"/>
							<input type="hidden" name="op" value="updateClr" />
						</form>
					</div>
				</div>';
			$footerScript .= '$("#A_'.$row['usrclr_id'].'_clrDate").datepicker({ changeYear: true });$(".'.$row['usrclr_id'].'_clr").change(function(){$("#A_'.$row['usrclr_id'].'_clrSave").show(1000);});
				$( "#A_'.$row['usrclr_id'].'_clrTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "clearance-app", search: $( "#A_'.$row['usrclr_id'].'_clrTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_'.$row['usrclr_id'].'_clrID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "clearance-app-select", search: ui.item.id }).done( function(data) { $("#A_'.$row['usrclr_id'].'_clrComments")[0].value = data; } );
						$("#A_'.$row['usrclr_id'].'_clrSave").show(1000);
					}
				});';
		}
		$footerScript .= '$("#A_new_clrDate").datepicker({ changeYear: true });
				$( "#A_new_clrTitle" ).autocomplete({
					source: function(request, response) {
						$.getJSON("inc/autocomplete.php", { sec: "clearance-app", search: $( "#A_new_clrTitle" )[0].value }, response);
					}, minLength: 2,
					select: function( event, ui ) {
						$("#A_new_clrID")[0].value=ui.item.id;
						$.get("inc/autocomplete.php", {sec: "clearance-app-select", search: ui.item.id }).done( function(data) { $("#A_new_clrComments")[0].value = data; } );
						$("#A_new_clrSave").show(1000);			
					}
				});
		function deleteClr(clrID) {
			var sure = confirm("Are you sure you want to update this clearance entry?");
			if (sure == true ) $("#accordion").load("applicants.php", { op: "deleteClr", clrID: clrID} );
		}';
/*		$content .= '
				<div class="applicantProfileBlock" id="A_add_clrBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Clearance</h3>
					<div>
						<form method="post" action="#" id="form_new_clr">
							<table border="0">
								<input type="hidden" class="new_clr" id="A_new_clrID" name="A_new_clrID" />'
//								<tr><td>Title</td><td><input type="text" class="new_clr" id="A_new_clrTitle" name="A_new_clrTitle" style="width:300px"/></td></tr>
								.'<tr><td>Title</td><td>'.DropDown('A_new_clrTitle', 'A_new_clrTitle', $clrListTable, 'class="new_clr" ',0).'</td></tr>
								<tr><td></td><td><input type="hidden" id="A_new_clrDate" class="new_clr" name="A_new_clrDate" style="width:90px" /></td></tr>
							</table>
							Description (optional) <br/><textarea name="A_new_clrComments" id="A_new_clrComments" class="new_clr" rows="6" cols="60" style="width:500px;height:100px;"></textarea><br/>
								<input type="button" value="Add" onclick="$(\'#accordion\').load(\'applicants.php\', $(\'#form_new_clr\').serialize());"/>
							<input type="hidden" name="op" value="newClr" />
						</div>
					</form>
				</div>
			</div>';
*/			
	accordion();
}


function getSkills() {
	//global $userID;
		global $userID,$emp_ID,$content;
 $content.= "<!--  br> trace 2062 getSkills query:
     SELECT U.*,C.* FROM usr_skills U LEFT JOIN cat_skills C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."' and U.usrskl_emp_id ='". $emp_ID."' 
     ORDER BY C.catskl_label,C.catskl_text  -->";
  
	return Q2T("SELECT U.*,C.* FROM usr_skills U LEFT JOIN cat_skills C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."' and U.usrskl_emp_id ='". $emp_ID."' 
	ORDER BY C.catskl_label,C.catskl_text");
  
}
function getProflics() {
		//global $userID;
		global $userID,$emp_ID, $content;
 $content.= "<!-- br> trace getProflics
 SELECT U.*,C.* FROM usr_proflics U LEFT JOIN cat_proflics C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."' and U.usrskl_emp_id ='". $emp_ID."'  
 ORDER BY C.catskl_text -->";

 ;
 
return Q2T("SELECT U.*,C.* FROM usr_proflics U LEFT JOIN cat_proflics C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."' and U.usrskl_emp_id ='". $emp_ID."'   ORDER BY C.catskl_text");

}
function getVehicles() {
			//global $userID;
		global $userID,$emp_ID ,$content;
 $content.= "<!--br> trace getVehicles:
 SELECT U.*,C.* FROM usr_vehicles U LEFT JOIN cat_vehicles C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."'  and U.usrskl_emp_id ='". $emp_ID."' 
 ORDER BY C.catskl_text -->";
    

	return Q2T("SELECT U.*,C.* FROM usr_vehicles U LEFT JOIN cat_vehicles C ON U.usrskl_skl_id = C.catskl_id
	WHERE U.usrskl_usr_id = '".$userID."'  and U.usrskl_emp_id ='". $emp_ID."' ORDER BY C.catskl_text");
    
}
function getGeos() {
				//global $userID;
		global $userID,$emp_ID ,$content;
 $content.= "<!-- br> trace getGeos query:
 SELECT U.*,C.* FROM usr_geos U LEFT JOIN cat_geos C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."' and U.usrskl_emp_id ='". $emp_ID."' 
 ORDER BY C.catskl_text --> ";
 
	return Q2T("SELECT U.*,C.* FROM usr_geos U LEFT JOIN cat_geos C ON U.usrskl_skl_id = C.catskl_id WHERE U.usrskl_usr_id = '".$userID."' and U.usrskl_emp_id ='". $emp_ID."'  ORDER BY C.catskl_text");
 
}
function getAgency(){
	//global $userID;
		global $userID,$emp_ID, $content;
 $content.= "<!--br> trace getAgency:
 SELECT U.*,C.* FROM usr_agencies U LEFT JOIN cat_agencies C ON U.usragen_skl_id = C.catagen_id WHERE U.usragen_usr_id = '".$userID."'and U.usragen_emp_id ='". $emp_ID."' 
 ORDER BY C.catagen_text-->";
     
 
	return Q2T("SELECT U.*,C.* FROM usr_agencies U LEFT JOIN cat_agencies C ON U.usragen_skl_id = C.catagen_id WHERE U.usragen_usr_id = '".$userID."'and U.usragen_emp_id ='". $emp_ID."'  ORDER BY C.catagen_text");
     
}
function getCerts() {
	global $userID,$emp_ID,$content ;
  
    $qemp_ID= $emp_ID;
      

    $content.= "<!--br> trace 2002 from getCerts get certs is: SELECT U.*,C.* FROM usr_certs U LEFT JOIN cat_certs C ON U.usrcrt_crt_id = C.catcrt_id 
	WHERE U.usrcrt_usr_id = '".$userID."' and U.usrcrt_emp_id ='". $qemp_ID."'  ORDER BY U.usrcrt_date -->";

	return Q2T("SELECT U.*,C.* FROM usr_certs U LEFT JOIN cat_certs C ON U.usrcrt_crt_id = C.catcrt_id 
	WHERE U.usrcrt_usr_id = '".$userID."' and U.usrcrt_emp_id ='". $qemp_ID."'  ORDER BY U.usrcrt_date ");
  
}	
function getClearances() {
		global $userID,$emp_ID, $tempemp_ID,$content;
		   $content.= "<!--br> trace 2009 from getClearances  userID: ". $userID .", emp_ID: ".$emp_ID . " --> ";
 
  
  $content.= "<!--br> trace  2013 get from usr_clearance sql: SELECT U.*,C.* FROM usr_clearance U LEFT JOIN cat_clearance C ON U.usrclr_clr_id = C.catclr_id 
  WHERE U.usrclr_usr_id = '".$userID."' and U.usrclr_emp_id ='". $emp_ID."'  ORDER BY U.usrclr_date -->";
  
	return Q2T("SELECT U.*,C.* FROM usr_clearance U LEFT JOIN cat_clearance C ON U.usrclr_clr_id = C.catclr_id WHERE U.usrclr_usr_id = '".$userID."' and U.usrclr_emp_id ='". $emp_ID."'  ORDER BY U.usrclr_date");
     
}
function getAllClearances() {
	return Q2T("SELECT C.catclr_id as 'id', C.catclr_title as 'label' FROM cat_clearance C ORDER BY C.catclr_rank");
	//return Q2T("SELECT catclr_rank as 'id', catclr_title as 'label' FROM cat_clearance ORDER BY catclr_rank");
	       //Q2T("SELECT catclr_rank as 'id', catclr_title as 'label', catclr_desc as 'tooltip', catclr_rank FROM cat_clearance order by catclr_rank");
}
function getExper() {
			global $userID,$emp_ID, $content;
 $content.= "<!--br> trace get
  SELECT DISTINCT U.*,C.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id 
  LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id
  WHERE U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='". $emp_ID."' ORDER BY U.usrexp_end DESC -->";
   
	return Q2T("SELECT DISTINCT U.*,C.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id WHERE U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='". $emp_ID."' ORDER BY U.usrexp_end DESC ");
   
}
function getEducat() {
	global $userID,$emp_ID, $tempemp_ID, $content;
 	
 	$content .= "<!--br> trace 2036 getEducat; userID: " . $userID .", emp_ID: ". $emp_ID;
 	
    $content .= "<br> trace 2038 query SELECT U.*,C.* FROM usr_edu U LEFT JOIN cat_edu C ON U.usredu_edu_id = C.catedu_id
    WHERE U.usredu_usr_id = '".$userID."' and U.usredu_emp_id ='". $emp_ID."' ORDER BY U.usredu_end -->";
  
	return Q2T("SELECT U.*,C.* FROM usr_edu U LEFT JOIN cat_edu C ON U.usredu_edu_id = C.catedu_id WHERE U.usredu_usr_id = '".$userID."' and U.usredu_emp_id ='". $emp_ID."' ORDER BY U.usredu_end ");
     
}
function getFuncs($expID) {
    			global $userID,$emp_ID , $content;
 $content.= "<!--br> trace get
   SELECT UF.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id
   LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id
   WHERE U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='". $emp_ID."'  AND U.usrexp_id = '".$expID."' ORDER BY U.usrexp_order -->";
    
	 
	return Q2T("SELECT UF.* FROM usr_exp U LEFT JOIN cat_exp C ON U.usrexp_exp_id = C.catexp_id LEFT JOIN usr_exp_func UF ON UF.usrexpfnc_usrexp_id = U.usrexp_id LEFT JOIN cat_func F ON UF.usrexpfnc_fnc_id = F.catfnc_id LEFT JOIN cat_training T ON UF.usrexpfnc_trn_id = T.cattrn_id WHERE U.usrexp_usr_id = '".$userID."' and U.usrexp_emp_id ='". $emp_ID."'  AND U.usrexp_id = '".$expID."' ORDER BY U.usrexp_order ");
    
}

/*
function updateCertMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_usr_id = '".$userIdentity."' ");

	$q = "select group_concat(C.usrcrt_crt_id SEPARATOR ',') as 'x', 
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_certs C ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";
	$certReqs = Q2R($q);
	$buffer = '';
		if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>updCertUsr '.$userIdentity.' = '.$q.'<br/>'.print_r($certReqs,true); //$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
//find jobs with matching certs
	if ($certReqs) {
		// update existing matches
		$xq = "SELECT J.job_id as 'job', count(JC.jobcrt_crt_id) as 'certs', S.sysmat_id  as 'matchID' FROM job_certs JC
		LEFT JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."'
		AND J.job_edu_level <= '".$certReqs['edu']."'
		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";

		// insert new matches
		$iq = "SELECT JC.jobcrt_job_id as 'job', count(JC.jobcrt_crt_id) as 'certs' FROM job_certs JC
		LEFT JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."')
		AND JC.jobcrt_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id=JC.jobcrt_job_id)
		AND J.job_edu_level <= '".$certReqs['edu']."'	
		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";
	
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/>'.$xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true).$q; 
			$did = Q($q);
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$q = "INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] user='.$userIdentity.', '.print_r($matchRow,true).$q;
			$did = Q($q);
		}
	}
	deleteOldMatches();
	return $buffer;
}


function updateSkillMatchesMP($userIdentity) {
	global $userID;
	//LARRYF
	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_skills C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";
	
		//echo "q[ ".$q." ]<br><br>";
		//exit();
	
	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_skills JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_skills JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

		//echo "q[ ".$q." ]<br><br>";
		//echo "xq[ ".$xq." ]<br><br>";
		//echo "iq[ ".$iq." ]<br><br>";
		//exit();
		
		
		
		if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	deleteOldMatches();
	return $buffer;
}


function updateAgencyMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usragen_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_agencies C ON A.usrapp_usr_id=C.usragen_usr_id 
	WHERE C.usragen_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
	
	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_agencies JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_agencies JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			//echo "updatematches";
			//exit();
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			//echo "newmatches";
			//exit();
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		}

	}
	deleteOldMatches();
	return $buffer;
}


function updateFunctionMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_functions='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$q = "SELECT group_concat(C.usrexpfnc_fnc_id SEPARATOR ',') as 'x', 
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A 
	LEFT JOIN usr_exp E ON E.usrexp_usr_id = A.usrapp_usr_id
	LEFT JOIN usr_exp_func C ON C.usrexpfnc_usrexp_id = E.usrexp_id 
	WHERE C.usrexpfnc_fnc_id > 0 AND A.usrapp_usr_id = '" . $userIdentity . "' 
	GROUP BY A.usrapp_usr_id";
	$funcReqs = Q2R($q);
	$buffer = ''; 
	if ($funcReqs) {
		if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>'.$q.'<br/>'.print_r($funcReqs,true).'<hr/>';
	
		$xq = "SELECT J.job_id as 'job', count(JF.jobfnc_fnc_id) as 'funcs', S.sysmat_id as 'matchID' FROM job_func JF 
	LEFT JOIN job J ON J.job_id = JF.jobfnc_job_id
	LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id 
	LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
	WHERE JF.jobfnc_fnc_id IN (".$funcReqs['x'].") 
	AND S.sysmat_usr_id = '".$userIdentity."' 
	AND J.job_edu_level <= '".$funcReqs['edu']."' 
	AND N.catclr_rank <= '".$funcReqs['clr']."'
	GROUP BY JF.jobfnc_job_id";

		$iq = "SELECT JF.jobfnc_job_id as 'job', count(JF.jobfnc_fnc_id) as 'funcs' FROM job_func JF 
	LEFT JOIN job J ON J.job_id = JF.jobfnc_job_id
	LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
	WHERE JF.jobfnc_fnc_id IN (".$funcReqs['x'].")
	AND JF.jobfnc_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JF.jobfnc_job_id)
	AND J.job_edu_level <= '".$funcReqs['edu']."' 
	AND N.catclr_rank <= '".$funcReqs['clr']."'
	GROUP BY JF.jobfnc_job_id";
	
		if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>' . $iq . '<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);

		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_functions = '".$matchRow['funcs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] '.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_functions, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['funcs']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateProflicMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_proflics='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_proflics C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

		
	if ($skillReqs) {
		
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_proflics JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		
	//print "[ ".$skillReqs['x']." ][ ".$skillReqs['edu']." ][ ".$skillReqs['clr']." ]";
	//exit();
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_proflics JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	
			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_proflics = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_proflics, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateGeoMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_geos C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_geos JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_geos JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	
			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	deleteOldMatches();
	return $buffer;
}

function updateVehiclesMatchesMP($userIdentity) {
	Q("UPDATE sys_match SET sysmat_vehicles='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_vehicles C ON A.usrapp_usr_id=C.usrskl_usr_id 
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' 
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
		if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

		
	if ($skillReqs) {
		
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_vehicles JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' 
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		
	//print "[ ".$skillReqs['x']." ][ ".$skillReqs['edu']." ][ ".$skillReqs['clr']." ]";
	//exit();
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_vehicles JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND J.job_edu_level <= '".$skillReqs['edu']."' 
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	
			if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_vehicles = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_vehicles, sysmat_matched_date, sysmat_status) VALUES ('".$userIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	deleteOldMatches();
	return $buffer;
}

function deleteOldMatches(){
	Q("DELETE FROM sys_match WHERE (sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
}
*/
?>
