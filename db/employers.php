<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Post a Job";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
////$template = "jobcon"; 
////$response = "content"; 
////require "inc/core.php";
$_SESSION['$usempempid'] = "";  //// "_empid"; 
$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
$template = "jobcon".$usempempid; 
$response = "content"; 
////$usempempid = $_SESSION['$usempempid'];//  //_empid   $emp_ID   $userID "; //".$usempempid."
require "inc/core".$usempempid.".php";

//-- define content -----------------------------------------------------------------
// req variables usr=400329&company_id=409621

$content .= "<!--br> trace 18 usempempid " .$usempempid . " -->" ;
$userID = 0;
// profiles user and company specific 3/14/19
  if (isset($_REQUEST['usr']) ) 
  {
      $userID= $_REQUEST['usr'];
  }   elseif (isset($_SESSION['passprofile_usr']))
  {
      $userID= $_SESSION['passprofile_usr'];
  } else  
  {
      $userID=$_SESSION['usr_id']; 
     $_SESSION['passprofile_usr'] = $userID; 
 }
  $_SESSION['passprofile_usr'] = $userID;
  if (isset($_REQUEST['company_id'])) {
      $userCompany = $_REQUEST['company_id'];
  } elseif (isset( $_SESSION['passprofile_emp']) )
  {
     $userCompany =  $_SESSION['passprofile_emp'];
  } else 
    { $userCompany = $_SESSION['usr_company'];
 }
       $_SESSION['passprofile_emp'] =$userCompany;
$userID= $_SESSION['passprofile_usr'];  //= $userID;set im dashboard bc2memmbers lloys profileusremp
$emp_ID= $_SESSION['passprofile_emp'];  //=$userCompany;
 
$userType = $_SESSION['usr_type'];
$userType = QV("SELECT usr_type from usr where usr_id =" . $userID. "");


////if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
////else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; $_SESSION['view_id'] = $userID;

if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_emp.php\';\" >Return to Employers List</div>");';

$empSection=@$_REQUEST['empSection'] or $empSection=@$_SESSION['empSection'] or $empSection="pst"; $_SESSION['empSection']=$empSection;

//$content .= "!!!!" . $empSection . "!!!!" . print_r($_REQUEST,true). print_r($_SESSION,true);

$opRec = CleanI($_REQUEST['rec']);
////$empID = QV("SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'");

//$content .= "EMP:".$empID;

$trainingTable = Q2T("SELECT cattrn_id AS 'id', cattrn_desc as 'label' FROM cat_training");
$eduLevelTable = Q2T("SELECT catedu_level AS 'id' , group_concat(catedu_text SEPARATOR ', ') as 'label' FROM `cat_edu` GROUP BY catedu_level");
$clearanceTable = Q2T("SELECT catclr_rank as 'id', catclr_title as 'label', catclr_desc as 'tooltip', catclr_rank FROM cat_clearance order by catclr_rank");
$empData = Q2R("SELECT * FROM emp WHERE emp_id='".$empID."' ");

//_empid   $emp_ID   $userID 
switch(Clean($_REQUEST['op'])) {
	case "updatePro": 
		$did =  Q("UPDATE usr SET usr_firstname='".Clean($_REQUEST['FirstName'])."', usr_lastname='".Clean($_REQUEST['LastName'])."', usr_email='".Clean($_REQUEST['Email'])."', usr_updated='".date('Y-m-d H:i:s')."' WHERE usr_id = '".$userID."' "); 
		$did =  Q("UPDATE usr_emp SET usremp_addr='".Clean($_REQUEST['Address1'])."', usremp_addr1='".Clean($_REQUEST['Address2'])."', usremp_addr2='".Clean($_REQUEST['Address3'])."', usremp_city='".Clean($_REQUEST['City'])."', usremp_state='".Clean($_REQUEST['State'])."', usremp_zip='".Clean($_REQUEST['Zip'])."', usremp_phone='".Clean($_REQUEST['Phone'])."', usremp_phone2='".Clean($_REQUEST['Phone2'])."', usremp_fax='".Clean($_REQUEST['Fax'])."', usremp_update_date='".date('Y-m-d H:i:s')."' WHERE usremp_usr_id = '".$userID."' and usremp_emp_id = '".$userCompany."' ");
		
        echo "UPDATE usr_emp SET usremp_addr='".Clean($_REQUEST['Address1'])."', usremp_addr1='".Clean($_REQUEST['Address2'])."', usremp_addr2='".Clean($_REQUEST['Address3'])."', usremp_city='".Clean($_REQUEST['City'])."', usremp_state='".Clean($_REQUEST['State'])."', usremp_zip='".Clean($_REQUEST['Zip'])."', usremp_phone='".Clean($_REQUEST['Phone'])."', usremp_phone2='".Clean($_REQUEST['Phone2'])."', usremp_fax='".Clean($_REQUEST['Fax'])."', usremp_update_date='".date('Y-m-d H:i:s')."' WHERE usremp_usr_id = '".$userID."' and usremp_emp_id = '".$userCompany."' ";		
		break;

	case "updateCom": 
		$did =  Q("UPDATE emp SET emp_name='".Clean($_REQUEST['Company'])."', emp_address='".Clean($_REQUEST['Address'])."', emp_email='".Clean($_REQUEST['Email'])."', emp_phone='".Clean($_REQUEST['Phone'])."', emp_fax='".Clean($_REQUEST['Fax'])."', emp_reference_number='".Clean($_REQUEST['Reference'])."', emp_updated='".date('Y-m-d H:i:s')."' WHERE emp_id = '".$empID."' "); 
		$empData = Q2R("SELECT * FROM emp WHERE emp_id='".$empID."' ");
		/// y
		break;
	case "deadnewReq":
	    // not used
	    break;
		$did = Q("INSERT INTO usr_req (usrreq_usr_id,usrreq_req_id,usrreq_date,usrreq_request,usrreq_status) VALUES ('".$userID."','".CleanI($_REQUEST['E_new_reqType'])."','".date("Y-m-d H:i:s")."','".Clean($_REQUEST['E_new_reqRequest'])."','1')");
		$response = "ajax";
		$reqTable = getRequests();
		//deadreqBlock();
		$footerScript .= '$("#empTab_req").load("employers.php",{ op: "reqMenu"});';
		require "inc/transmit.php";
		// will not be used  lloyd by tojo 3/24/19
		break;
	case "deaddeleteReq":
	    break;
		$did = Q("DELETE FROM usr_req WHERE usrreq_id = '".CleanI($_REQUEST['rec'])."' AND usrreq_usr_id = '".$userID."' ");
		$response = "ajax";
		//dead$reqTable = getRequests();
		//deadreqBlock();
		$footerScript .= '$("#empTab_req").load("employers.php",{ op: "reqMenu"});';
		require "inc/transmit.php";
		break;
	case "deadreqMenu":
	    break;  // not used
		$response = "ajax";
		//dead$reqTable = getRequests();
		//dead$content .= appTab('Requests', 'req', $reqTable,'resreq_label','usrreq_id',true);
		require "inc/transmit.php";
		break;
	case "newJob":
	    //  _empid   $emp_ID   $userID 
		$q = "INSERT INTO job (job_emp_id,jobemp_id,job_title,job_details,job_clearance,job_edu_level,job_submitted_date) 
		  VALUES ('".$userID."','".$emp_ID."','".Clean($_REQUEST['E_new_jobTitle'])."','".Clean($_REQUEST['E_new_jobComments'])."','0','0','".date("Y-m-d H:i:s")."')";
		  $content.= " <!--  br> tracr newJob 115 q: <br>".$q . "-->";
		$did = QI($q); //$content .= $q;
		//Now post this job add time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$did."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newJob')";
	   	    $content.= "<!-- br>\r\n 119   new job jobpost_times_new_id: query: " . $jobposttimes_insertSQL. " --> ";
	   	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 121  new job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";

		$response = "ajax";
		$pstTable = getPosts();
		pstBlock();
		$footerScript .= '$("#empTab_pst").load("employers.php",{ op: "pstMenu"});setTimeout(function(){$("#E_'.$did.'_pstBlock > h3").click();},500);';
		require "inc/transmit.php";
		// y
		break;
	case "updateJob":
		$q = "UPDATE job SET job_title='".Clean($_REQUEST['E_title'])."' WHERE job_id = '".CleanI($_REQUEST['rec'])."' 
		and job_emp_id = '".$empID."' and jobemp_id ='".$emp_ID."' ";
		$did = Q($q);
			
    			//Now post this job update time
    // $jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	 //  	                                         VALUES ('" .$end_jobcount."',CURRENT_TIMESTAMP(),'FBO', '". $FBOfile."')";

	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['rec']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_updateJob')";
	   		 $content.= "<!--  br>\r\n 141   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 143  update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";

	   
		$response = "ajax";
		$pstTable = getPosts();
		pstBlock();
		$footerScript .= '$("#empTab_pst").load("employers.php",{ op: "pstMenu"});';
		// y
		require "inc/transmit.php";
		
		break;
	case "deleteJob":
		$q="DELETE FROM job WHERE job_emp_id = '".$userID."' AND job_id ='".CleanI($_REQUEST['jobID'])."' and jobemp_id ='".$emp_ID."' ";
		$did = Q($q);
		
	 			//Now post this job update time
  
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_deleteJob')";
	   		 $content.= "<!--  br>\r\n 164   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 166  update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";

		
		$response = "ajax";
		$pstTable = getPosts();
		pstBlock();
		$footerScript .= '$("#empTab_pst").load("employers.php",{ op: "pstMenu"});';
		require "inc/transmit.php";
		break;   //  _empid   $emp_ID   $userID 
	case "printJob":
		$q="SELECT * FROM job WHERE job_emp_id = '".$userID."' AND job_id ='".CleanI($_REQUEST['jobID'])."' and jobemp_id ='".$emp_ID."'";
		$did = Q($q);
		$response = "ajax";

		$pstTable = getPosts();
		pstBlock();

		$footerScript .= '$("#empTab_pst").load("employers.php",{ op: "pstMenu"});';
		require "inc/transmit.php";
		//y
		break;
	case "pstMenu":
		$response = "ajax";
		$pstTable = getPosts();
		$content .= appTab('Partner Postings', 'pst', $pstTable,'job_title','job_id',true);
		require "inc/transmit.php";
		break;
	case "editJobDetails":
		//$q="UPDATE job SET job_location='".Clean($_REQUEST['E_location'])."', job_edu_level='".CleanI($_REQUEST['E_job_edu'])."', job_clearance='".CleanI($_REQUEST['E_job_clearance'])."', job_ava_id = '".CleanI($_REQUEST['E_job_ava'])."', job_ind_id = '".CleanI($_REQUEST['E_job_ind'])."', job_details='".Clean($_REQUEST['E_details'])."' WHERE job_id = '".CleanI($_REQUEST['jobID'])."' AND job_emp_id = '".$empID."'"; //$content .= $q;
		$q="UPDATE job SET job_location='".Clean($_REQUEST['E_location'])."', job_edu_level='".CleanI($_REQUEST['E_job_edu'])."', job_clearance='".CleanI($_REQUEST['E_job_clearance'])."', job_ava_id = '".CleanI($_REQUEST['E_job_ava'])."', job_ind_id = '".CleanI($_REQUEST['E_job_ind'])."', job_details='".Clean($_REQUEST['E_details'])."',job_solicitation='".Clean($_REQUEST['E_solicitation'])."',job_due_date='".Clean($_REQUEST['E_due_date'])."',job_buying_office='".Clean($_REQUEST['E_buying_office'])."',job_first_name='".Clean($_REQUEST['E_first_name'])."',job_last_name='".Clean($_REQUEST['E_last_name'])."',job_email_address='".Clean($_REQUEST['E_email_address'])."',job_phone ='".Clean($_REQUEST['E_phone'])."'
		WHERE job_id = '".CleanI($_REQUEST['jobID'])."' AND job_emp_id = '".$userID."' and jobemp_id ='".$emp_ID."' "; //$content .= $q;
		$did = Q($q);
		
				
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editJobDetails')";
	   		 $content.= "<!--  br>\r\n 201   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 203  update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		$response = "ajax";
		$pstTable = getPosts();
		renderJobDetails(Q2R("SELECT * FROM job WHERE job_id = '".CleanI($_REQUEST['jobID'])."' AND job_emp_id = '".$userID."' and jobemp_id ='".$emp_ID."' "));
		require "inc/transmit.php";  //y
		break;                        //  _empid   $emp_ID   $userID 
	case "newPostExp":
		break;
	case "editPostExp":
		break;
	case "deletePostExp":
		break;
	case "newPostCert":
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_certs (catcrt_name,catcrt_desc) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");
		else $catID =CleanI($_REQUEST['catID']);
			//echo "[ ".Clean($_REQUEST['A_new_sklTitle'])." ]";exit();
	//	echo("<!--  5/8/19  trace 184 check if Cert  already there for the job   -->" );
		$qc ="SELECT jobcrt_crt_id from job_certs JC 
		       inner join job J on JC.jobcrt_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JC.jobcrt_crt_id = '".$catID."'";
   /*SELECT jobcrt_crt_id from job_certs JC inner join job J on JC.jobcrt_job_id = J.job_id where J.job_id = '272403' and J.job_emp_id='810737' and J.jobemp_ID = '790858' and JC.jobcrt_crt_id  = '38'
		       -*/
			$iscertthere = QV($qc);
	$content.=  "<!-- br> trace 188 is cert ther trying qc: ". $qc. "-->";
		if ($iscertthere)
		{ 
         $content .= "<script type='text/javascript'><!-- alreadythereCertification()//-->  </script>  "; //(".$isskillthere.") //-->    </script>  ";
    /// $content.=  "<!--br> trace 202 skill already there isskillthere: ". $isskillthere. " --> ";
       $response = "ajax";
	
		    $crtTable = getCertifications(CleanI($_REQUEST['jobID']));
		renderJobCertifications(CleanI($_REQUEST['jobID']),$crtTable);
		}else {
		$q="INSERT INTO job_certs (jobcrt_job_id, jobcrt_crt_id, jobcrt_desc) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."')";
		$did = Q($q); // $content .= $q;
						
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newPostCert')";
	   		 $content.= "<!--  br>\r\n 245   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 247 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		
		$response = "ajax";
	//	updateCertMatchesJP(CleanI($_REQUEST['jobID']));   //  _empid   $emp_ID   $userID 
		$crtTable = getCertifications(CleanI($_REQUEST['jobID']));
		renderJobCertifications(CleanI($_REQUEST['jobID']),$crtTable);
		}
		require "inc/transmit.php"; //na
		break;
	case "editPostCert":
		$did = Q("UPDATE job_certs SET jobcrt_desc = '".Clean($_REQUEST['text'])."', jobcrt_crt_id = '".CleanI($_REQUEST['catID'])."' WHERE jobcrt_id = '".CleanI($_REQUEST['jobcrtID'])."' ");

						
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobcrtID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editPostCert')";
	   		 $content.= "<!--  br>\r\n 266   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 268 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";



		$response = "ajax";
	//	updateCertMatchesJP(CleanI($_REQUEST['jobID']));
		$crtTable = getCertifications(CleanI($_REQUEST['jobID']));
		renderJobCertifications(CleanI($_REQUEST['jobID']),$crtTable);
		require "inc/transmit.php";
		break;  //na
	case "deletePostCert":
		$did = Q("DELETE FROM job_certs WHERE jobcrt_id = '".CleanI($_REQUEST['jobcrtID'])."' AND jobcrt_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."' )");
		
						
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobcrtID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_deletePostCert')";
	   		 $content.= "<!--  br>\r\n 266   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 268 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		$response = "ajax";
	//	updateCertMatchesJP(CleanI($_REQUEST['jobID']));
		$crtTable = getCertifications(CleanI($_REQUEST['jobID']));
		renderJobCertifications(CleanI($_REQUEST['jobID']),$crtTable);
		require "inc/transmit.php";
		break; ///na
	case "newPostSkill":
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_skills (catskl_label,catskl_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");	
		else $catID =CleanI($_REQUEST['catID']);
		//	echo("<!--  5/9/19  trace 229 check if Cert  already there for the job   -->" );
		$qskl ="SELECT jobskl_skl_id from job_skills JS
		       inner join job J on JS.jobskl_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JS.jobskl_skl_id = '".$catID."'";
   /*SELECT jobskl_skl_id from job_skills JS
		       inner join job J on JS.jobskl_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JS.jobskl_skl_id = '".$catID."'";      -*/
			$isskillthere = QV($qskl);
	$content.=  "<!--  br> !-- br> trace 237 is skill  there trying qskl: ". $qskl. "-->";
		if ($isskillthere)
		{ 
         $content .= "<script type='text/javascript'><!-- alreadythereSkill()//-->  </script>  "; //(".$isskillthere.") //-->    </script>  ";
    /// $content.=  "<!--br> trace 202 skill already there isskillthere: ". $isskillthere. " --> ";
       $response = "ajax";
			$sklTable = getSkills(CleanI($_REQUEST['jobID']));
		renderJobSkills(CleanI($_REQUEST['jobID']),$sklTable);
	}else {
		$q = "INSERT INTO job_skills (jobskl_job_id, jobskl_skl_id, jobskl_desc,jobskl_status) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."',0)";
		$did = Q($q);
		
				
						
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newPostSkill')";
	   		 $content.= "<!--  br>\r\n 325   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 327 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		$response = "ajax";
		//updateSkillMatchesJP(CleanI($_REQUEST['jobID']));		
		$sklTable = getSkills(CleanI($_REQUEST['jobID']));
		renderJobSkills(CleanI($_REQUEST['jobID']),$sklTable);
		}
		require "inc/transmit.php";  //na
		break;
	case "editPostSkill":
		$q = "UPDATE job_skills SET jobskl_desc = '".Clean($_REQUEST['comments'])."', jobskl_skl_id = '".CleanI($_REQUEST['catID'])."' WHERE jobskl_id = '".CleanI($_REQUEST['sklID'])."' ";
		$did = Q($q); //$content .= $q; 
		
				
				
						
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['sklID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editPostSkill')";
	   		 $content.= "<!--  br>\r\n 348   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 350 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";



		
		$response = "ajax";
		//updateSkillMatchesJP(CleanI($_REQUEST['jobID']));
		$sklTable = getSkills(CleanI($_REQUEST['jobID']));
		renderJobSkills(CleanI($_REQUEST['jobID']),$sklTable);
		require "inc/transmit.php";
		break;   // na
	case "deletePostSkill":
	    ////  _empid   $emp_ID   $userID   jobemp_ID
		$d_naics = QV("Select jobskl_skl_id from job_skills where jobskl_id = '".CleanI($_REQUEST['jobsklID'])."'");
	    $d = "Insert into job_delete (job_delete_jobid, job_delete_naics) values ('".CleanI($_REQUEST['jobID'])."','".$d_naics."')";
		$did = Q($d);	
		$q = "DELETE FROM job_skills WHERE jobskl_id = '".CleanI($_REQUEST['jobsklID'])."' AND jobskl_job_id = '".CleanI($_REQUEST['jobID'])."'
		AND jobskl_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."' and jobemp_ID = '".$emp_ID. "'  )";
		$did = Q($q);
								
	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobsklID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_editPostSkill')";
	   		 $content.= "<!--  br>\r\n 373   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 375 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";

		
		$response = "ajax";
		//updateSkillMatchesJP(CleanI($_REQUEST['jobID'])); nonzeroempid
		$sklTable = getSkills(CleanI($_REQUEST['jobID']));
		renderJobSkills(CleanI($_REQUEST['jobID']),$sklTable);
		require "inc/transmit.php";   //y
		break;
	case "newPostAgency":    
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_agencies (catagen_label,catagen_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");	
		else $catID =CleanI($_REQUEST['catID']);
			//	echo("<!--  5/10/19  trace 282 check if Cert  already there for the job   -->" );
		$qagency ="SELECT jobskl_skl_id from job_agencies JA
		       inner join job J on JA.jobskl_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JA.jobskl_skl_id = '".$catID."'";
   /*SELECT jobskl_skl_id from job_skills JS
		       inner join job J on JS.jobskl_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JS.jobskl_skl_id = '".$catID."'";      -*/
			$isagencythere = QV($qagency);
	$content.=  " <!-- br> trace 290 is agency already  there trying qagency: ". $qagency. "-->";
		if ($isagencythere)
		{ 
         $content .= "<script type='text/javascript'><!-- alreadythereAgency()//-->  </script>  "; //(".$isskillthere.") //-->    </script>  ";
        /// $content.=  "<!--br> trace 202 skill already there isskillthere: ". $isskillthere. " --> ";
      
    	}else {
		$q = "INSERT INTO job_agencies (jobskl_job_id, jobskl_skl_id, jobskl_desc) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."')";
		$did = Q($q);
    	}
    	
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newPostAgency')";
	   		 $content.= "<!--  br>\r\n 410   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 412 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


     //echo ($content);
     //flush();
     // break;
      //exit;
	   	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 314   new job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";
		$response = "ajax";
		//updateAgencyMatchesJP(CleanI($_REQUEST['jobID']));
		$agcyTable = getAgencies(CleanI($_REQUEST['jobID']));
		renderJobAgencies(CleanI($_REQUEST['jobID']),$agcyTable);
		require "inc/transmit.php";   //na
		break;
	case "editPostAgency":
		$q = "UPDATE job_agencies SET jobskl_desc = '".Clean($_REQUEST['comments'])."', jobskl_skl_id = '".CleanI($_REQUEST['catID'])."' WHERE jobskl_id = '".CleanI($_REQUEST['agcyID'])."' ";
		$did = Q($q); //$content .= $q; 
		
		   	
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['agcyID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editPostAgency')";
	   		 $content.= "<!--  br>\r\n 410   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 412 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		$response = "ajax";
		//updateAgencyMatchesJP(CleanI($_REQUEST['jobID']));
		$agcyTable = getAgencies(CleanI($_REQUEST['jobID']));
		renderJobAgencies(CleanI($_REQUEST['jobID']),$agcyTable);
		require "inc/transmit.php";
		break;
	case "deletePostAgency":
		$q = "DELETE FROM job_agencies WHERE jobskl_id = '".CleanI($_REQUEST['jobsklID'])."' AND jobskl_job_id = '".CleanI($_REQUEST['jobID'])."' 
		AND jobskl_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."' and jobemp_ID = '".$emp_ID. "' )";
		$did = Q($q);
		
				
		   	
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_deletePostAgency')";
	   		 $content.= "<!--  br>\r\n 457   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 459 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		$response = "ajax";
		//updateAgencyMatchesJP(CleanI($_REQUEST['jobID']));
		$agcyTable = getAgencies(CleanI($_REQUEST['jobID']));
		renderJobAgencies(CleanI($_REQUEST['jobID']),$agcyTable);
		require "inc/transmit.php";  //y
		break;	
	case "newPostProflic":   
	      ////  _empid   $emp_ID   $userID   jobemp_ID and jobemp_ID = '".$emp_ID. "' 
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_proflics (catagen_label,catagen_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");	
		else $catID =CleanI($_REQUEST['catID']);
		$q = "INSERT INTO job_proflics (jobskl_job_id, jobskl_skl_id, jobskl_desc) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."')";
		$did = Q($q);	   	


 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newPostProflic')";
	   		 $content.= "<!--  br>\r\n 478   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 480 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";

	
		
		$response = "ajax";
		//updateProflicMatchesJP(CleanI($_REQUEST['jobID']));
		$prlcTable = getProflics(CleanI($_REQUEST['jobID']));
		renderJobProflics(CleanI($_REQUEST['jobID']),$prlcTable);
		require "inc/transmit.php"; //na
		break;
	case "editPostProflic":
		$q = "UPDATE job_proflics SET jobskl_desc = '".Clean($_REQUEST['comments'])."', jobskl_skl_id = '".CleanI($_REQUEST['catID'])."'
		 WHERE jobskl_id = '".CleanI($_REQUEST['agcyID'])."' ";
		$did = Q($q); //$content .= $q; 
		
		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['agcyID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editPostProflic')";
	   		 $content.= "<!--  br>\r\n 502   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 504 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		$response = "ajax";
		//updateProflicMatchesJP(CleanI($_REQUEST['jobID']));
		$prlcTable = getProflics(CleanI($_REQUEST['jobID']));
		renderJobProflics(CleanI($_REQUEST['jobID']),$prlcTable);
		require "inc/transmit.php";
		break;
	case "deletePostProflic":
		$q = "DELETE FROM job_proflics WHERE jobskl_id = '".CleanI($_REQUEST['jobsklID'])."' AND jobskl_job_id = '".CleanI($_REQUEST['jobID'])."' 
		 AND jobskl_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."' and jobemp_ID = '".$emp_ID. "'  )";
		 	$did = Q($q);

		 		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_deletePostProflic')";
	   		 $content.= "<!--  br>\r\n 522   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 524 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		$response = "ajax";
		//updateProflicMatchesJP(CleanI($_REQUEST['jobID']));
		$prlcTable = getProflics(CleanI($_REQUEST['jobID']));
		renderJobProflics(CleanI($_REQUEST['jobID']),$prlcTable);
		require "inc/transmit.php"; //y
		break;	
	case "newPostVehicles":
		//echo "I am here in New post vehicles"; exit();
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_vehicles (catagen_label,catagen_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");	
		else $catID =CleanI($_REQUEST['catID']);
		$q = "INSERT INTO job_vehicles (jobskl_job_id, jobskl_skl_id, jobskl_desc) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."')";
		$did = Q($q);
		
				 		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newPostVehicles')";
	   		 $content.= "<!--  br>\r\n 546   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 548 add job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";



		
		
		$response = "ajax";
		//updateVehiclesMatchesJP(CleanI($_REQUEST['jobID']));
		$vehiclesTable = getVehicles(CleanI($_REQUEST['jobID']));
		renderJobVehicles(CleanI($_REQUEST['jobID']),$vehiclesTable);
		require "inc/transmit.php";
		break; //na
	case "editPostVehicles":
		$q = "UPDATE job_vehicles SET jobskl_desc = '".Clean($_REQUEST['comments'])."', jobskl_skl_id = '".CleanI($_REQUEST['catID'])."' WHERE jobskl_id = '".CleanI($_REQUEST['agcyID'])."' ";
		$did = Q($q); //$content .= $q; 
		
				
				 		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['agcyID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editPostVehicles')";
	   		 $content.= "<!--  br>\r\n 569   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 571 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";



		
		$response = "ajax";
		//updateVehiclesMatchesJP(CleanI($_REQUEST['jobID']));
		$vehiclesTable = getVehicles(CleanI($_REQUEST['jobID']));
		renderJobVehicles(CleanI($_REQUEST['jobID']),$vehiclesTable);
		require "inc/transmit.php";
		break;   // na
	case "deletePostVehicles":
		$q = "DELETE FROM job_vehicles WHERE jobskl_id = '".CleanI($_REQUEST['jobsklID'])."' AND jobskl_job_id = '".CleanI($_REQUEST['jobID'])."' 
		AND jobskl_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."' and jobemp_ID = '".$emp_ID. "'  )";
		$did = Q($q);
		
						
				 		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_deletePostVehicles')";
	   		 $content.= "<!--  br>\r\n 592   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 594 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";



		
		$response = "ajax";
		//updateVehiclesMatchesJP(CleanI($_REQUEST['jobID']));
		$vehiclesTable = getVehicles(CleanI($_REQUEST['jobID']));
		renderJobVehicles(CleanI($_REQUEST['jobID']),$vehiclesTable);
		require "inc/transmit.php";   // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "' 
		break;			  //y
	case "newPostGeo":    
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_geos (catagen_label,catagen_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");	
		else $catID =CleanI($_REQUEST['catID']);
					//	echo("<!--  5/10/19  trace 394 check if Cert  already there for the job   -->" );
		$qgeo ="SELECT JG.jobskl_skl_id from job_geos JG
		       inner join job J on JG.jobskl_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JG.jobskl_skl_id = '".$catID."'";
   /*SELECT jobskl_skl_id from job_geos JG
		       inner join job J on JA.jobskl_job_id = J.job_id where J.job_id = '".CleanI($_REQUEST['jobID'])."'
		       and J.job_emp_id='".$userID."' and J.jobemp_ID = '".$emp_ID."' and JG.jobskl_skl_id = '".$catID."'";		$isagencythere = QV($qagency);
		       */
	$content.=  " <!-- br> trace 290 is geo already  there trying qgeo: ". $qgeo. "-->";
	    $isgeothere=QV($qgeo);
		if ($isgeothere)
		{ 
         $content .= "<script type='text/javascript'><!-- alreadythereGeo() //-->  </script>  "; //(".$isskillthere.") //-->    </script>  ";
        /// $content.=  "<!--br> trace 406 geo already there isgeothere: ". $isgeothere. " --> ";
      
    	}else {
		$q = "INSERT INTO job_geos (jobskl_job_id, jobskl_skl_id, jobskl_desc) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."')";
		$did = Q($q);
		
						 		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'ADD', '". $userID."_".$emp_ID."_newPostGEO')";
	   		 $content.= "<!--  br>\r\n 632   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 634 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


    	}
		$response = "ajax";
		//updateGeoMatchesJP(CleanI($_REQUEST['jobID']));
		$geoTable = getGeos(CleanI($_REQUEST['jobID']));
		renderJobGeos(CleanI($_REQUEST['jobID']),$geoTable);
		require "inc/transmit.php";
		break;  //na
	case "editPostGeo":
		$q = "UPDATE job_geos SET jobskl_desc = '".Clean($_REQUEST['comments'])."', jobskl_skl_id = '".CleanI($_REQUEST['catID'])."' WHERE jobskl_id = '".CleanI($_REQUEST['agcyID'])."' ";
		$did = Q($q); //$content .= $q; 
		
								 		
 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['agcyID']."',CURRENT_TIMESTAMP(),'EDIT', '". $userID."_".$emp_ID."_editPostGEO')";
	   		 $content.= "<!--  br>\r\n 652   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 654 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		$response = "ajax";
		//updateGeoMatchesJP(CleanI($_REQUEST['jobID']));
		$geoTable = getGeos(CleanI($_REQUEST['jobID']));
		renderJobGeos(CleanI($_REQUEST['jobID']),$geoTable);
		require "inc/transmit.php";
		break;  //na
	case "deletePostGeo":
		$q = "DELETE FROM job_geos WHERE jobskl_id = '".CleanI($_REQUEST['jobsklID'])."' AND jobskl_job_id = '".CleanI($_REQUEST['jobID'])."' 
		AND jobskl_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."' and jobemp_ID = '".$emp_ID. "'  )";
		$did = Q($q);

 	 			//Now post this job update time
	$jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$_REQUEST['jobID']."',CURRENT_TIMESTAMP(),'DELETE', '". $userID."_".$emp_ID."_deletePostGEO')";
	   		 $content.= "<!--  br>\r\n 672   new job jobpost_times_new_id query: " . $jobposttimes_insertSQL. " --> "; 
	   	  	$jobpost_times_new_id = QI($jobposttimes_insertSQL);
      $content.= "<!-- br>\r\n 674 update job jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. " --> ";


		
		$response = "ajax";
		//updateGeoMatchesJP(CleanI($_REQUEST['jobID']));
		$geoTable = getGeos(CleanI($_REQUEST['jobID']));
		renderJobGeos(CleanI($_REQUEST['jobID']),$geoTable);
		require "inc/transmit.php";   // y
		break;			  // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "' 
	case "newPostFunc":
		$catID =0;
		if (CleanI($_REQUEST['catID'])==0) $catID = QI("INSERT INTO cat_func (catfnc_title,catfnc_text) VALUES ('".Clean($_REQUEST['title'])."','".Clean($_REQUEST['comments'])."')");	
		else $catID =CleanI($_REQUEST['catID']);
		$did = Q("INSERT INTO job_func (jobfnc_job_id, jobfnc_fnc_id, jobfnc_desc) VALUES ('".CleanI($_REQUEST['jobID'])."','".$catID."','".Clean($_REQUEST['comments'])."')");
		$response = "ajax";
		//updateFunctionMatchesJP(CleanI($_REQUEST['jobID']));
		$fncTable = getFunctions(CleanI($_REQUEST['jobID']));
		renderJobFunctions(CleanI($_REQUEST['jobID']),$fncTable);
		require "inc/transmit.php";  // na
		break;
	case "editPostFunc":
		$did = Q("UPDATE job_func SET jobfnc_desc='".Clean($_REQUEST['comments'])."', jobfnc_fnc_id = '".CleanI($_REQUEST['catID'])."' WHERE jobfnc_id = '".CleanI($_REQUEST['funcID'])."' ");
		$response = "ajax";
		//updateFunctionMatchesJP(CleanI($_REQUEST['jobID']));
		$fncTable = getFunctions(CleanI($_REQUEST['jobID']));
		renderJobFunctions(CleanI($_REQUEST['jobID']),$fncTable);
		require "inc/transmit.php";   // na
		break;
	case "deletePostFunc":
		$q = "DELETE FROM job_func WHERE jobfnc_id = '".CleanI($_REQUEST['jobfncID'])."'
		AND jobfnc_job_id IN (SELECT job_id FROM job WHERE job_emp_id = '".$userID."'  and jobemp_ID = '".$emp_ID. "'  )";
		$did = Q($q); //$content .= $q;
		$response = "ajax";
		//updateFunctionMatchesJP(CleanI($_REQUEST['jobID']));
		$fncTable = getFunctions(CleanI($_REQUEST['jobID']));
		renderJobFunctions(CleanI($_REQUEST['jobID']),$fncTable);
		require "inc/transmit.php";  // y
		break;       // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "' 
	case "pdfJob":
		require('inc/jobPDF.php');
		break;
	case "pdfRes":
		$_SESSION['resumePrint']=CleanI($_REQUEST['res']);
		require('inc/renderResume.php');
		break;
	case "myformtest":
		//echo "Processing Profile Update";
		$id = CleanI($_REQUEST['jobID']);
		$doMatches = getMatches($id);
		
//reset matches
/*
		$job = Q2T("select job_id from job where job_id > 92");
		
	if ($job) {
		foreach($job as $roe)
			$doMatches = getMatches($roe['job_id']);
	}
*/	
		$content .= DBContent();

$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".$userID."'");

if (($userType == 0) && ($usrData['usr_type'] == 1)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}

if ($userType == 99) {
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/bc2_admins.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';	
}

// ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "' 

//$reqTable = getRequests();
//$pstTable = getPosts();

$content .= '<div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div><br>';

$content .= '<br><div style="text-align:center;">
<table style="height: 21px;" width="555" align="center">
<tbody>
<tr>';

//$content .= '<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'&company_id='.$empID.'">Member Profile</a></td>';
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Build Your Team</a></td>';
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Search</a></td>
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Show ECAs*</a></td>
//$content .= '<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'&empid='.$empID.'&company_id='.$empID.'">Return to Dashboard</a></td>';

$content .= $systemAdmin.'</tr>
</tbody>
</table>
</div><br><br>';
$content .= '<center><h1>';
$content .= 'Criteria updates have been completed successfully.<br>';
$content .= '<a href="bc2myjobprofile.php?company_id='.$emp_ID.'&usr='.$userID.'&profileID='.$id.'" >Go to scorecard</a>';
$content .= '</h1></center>';
			
		require "inc/transmit.php"; 
		break;		
}

$footerScript .= <<<__EOS
	$(function() {
		$( "#accordion" )
			.accordion({ header: "> div > h3" });
//			.sortable({
//				axis: "y",
//				handle: "h3",
//				stop: function( event, ui ) { ui.item.children( "h3" ).triggerHandler( "focusout" ); }
//			});
	});
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
		$(obj).parent().find('.empNavItemActive').each(function(){ $(this).css({'background':'#AED0EA','color':'#000'});});
		$(obj).css({'background':'#2694ff','color':'#fff'});
	}";

$scriptLinks .= '	<script type="text/javascript" src="js/jquery.sortGrid.js"></script>';
$cssInline .= '
	.appNavBlock { font-size:16px; font-weight:800; padding:4px; border-radius:5px;margin-bottom:10px;}
	.appNavBlock div { font-size:14px; font-weight:normal; cursor:pointer; border:1px solid #2779AA; padding:5px;text-align:right; border-radius:4px;margin-bottom:3px;}
	.employerProfileBlock { zoom: 1; width:805px; }
	.empNavItemInactive {  }
	.empNavItemActive { cursor:default; }
	.jobPostTabHolder { width:761px;}
	.ui-autocomplete {
		max-height: 300px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		width:600px;
	}
';

$content .= DBContent();

// ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "' 

$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".$userID."'");
$company = Q2R("select * FROM emp where emp_id = '".$emp_ID."'"); ; /////   Q2R("select * FROM emp where emp_id = '".$usrData['usr_company']."'");
$emplevel = QV("SELECT emp_level from emp where emp_id = '".$emp_ID."';");
$usrempData = Q2R("SELECT * FROM usr_emp WHERE usremp_usr_id = '".$userID."' and usremp_emp_id='". $emp_ID."'");

if (($userType == 0) && ($usrData['usr_type'] == 1)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&userCompany='.$emp_ID.'&ptype=admin">ADMIN Panel</a></center></td>';
}

if ($userType == 99) {
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/bc2_admins.php?usr='.$adminUser.'&userCompany='.$emp_ID.'&ptype=admin">ADMIN Panel</a></center></td>';	
}



/////    - removed $reqTable = getRequests();
$pstTable = getPosts();

$content .= '<br><br><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '</div>';
$content .= '<div style="text-align:center;">' . $company['emp_name'] . '</div>';

// ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "' 

$content .= '<br><br><div style="text-align:center;">
<table style="height: 21px;" width="600" align="center">
<tbody>
<tr>
<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'&company_id='.$emp_ID.'">Member Profile</a></td>';

if ($emplevel > 0)
{
    $content .= '<td><a href="/'.$_SESSION['env'].'/p_admins.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Search Members</a></td>';
}

//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Build Your Team</a></td>';
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Search</a></td>
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Show ECAs*</a></td>
$content .= '<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'&empid='.$emp_ID.'&company_id='.$emp_ID.'">Return to Dashboard</a></td>';
//<td><a href="/'.$_SESSION['env'].'/applicants.php?usr='.$userID.'">Member Profile</a></td>
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Build Your Team</a></td>';
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Search</a></td>
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$userID.'">Show ECAs*</a></td>
//$content .= '<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'">Return to Dashboard</a></td>';
if ( $emplevel > 0)
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
$content .= '<center><h2 style="text-align: center;"><span style="background-color: #ffffff;"><strong>Build Your Team</strong></span></h2>';



// ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"

switch ($empSection) {
	default: case "pro":
		$content .= DBContent('','Profile').'
		<div style="height:1200px;">
			<div class="" style="float:left;width:175px;margin-left:10px;">
				<!-- <div class="appNavBlock ui-state-active" >Contact Information
					<div class="empNavItemActive"><span style="">Editing</span></div>		
				</div> -->
				<!-- <div class="appNavBlock ui-state-default" >Company Profile -->
	<!--div onclick="$.post( \'http://www.bizconnectonline.com/upodev/employers\', { \'empSection\' : \'com\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div -->
		
					<!-- <div onclick="$.post( \'employers.php\', { \'empSection\' : \'com\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>
				</div> --> ';
		$content .= '<div id="empTab_pst">'.appTab('Partner Postings', 'pst', $pstTable,'job_title','job_id').'</div>';
	 //// tojo:remove	$content .= '<div id="empTab_req">'.appTab('Requests', 'req', $reqTable,'resreq_label','usrreq_id').'</div>';
		$content .= '
			</div>
			<div id="accordion" style="float:left;margin-left:10px;">
				<div class="employerProfileBlock">
					<h3>Profile</h3>
					<div style="padding:20px">
						<form method="post">
							First Name: <input type="text" name="FirstName" value="'.$usrData['usr_firstname'].'" /><br/>
							Last Name: <input type="text" name="LastName" value="'.$usrData['usr_lastname'].'" /><br/><br/>
							Company:&nbsp;&nbsp; <input type="text" name="Company"   value="'.$company['emp_name'] .'" /><br/>
							Email: <input type="text" name="Email" value="'.$usrData['usr_email'].'"/><br/><br/>
							Address<br/>
							<input type="text" name="Address1" value ="'.$usrempData['usremp_addr'].'" /><br>
							<input type="text" name="Address2" value ="'.$usrempData['usremp_addr1'].'" /><br>
							<input type="text" name="Address3" value ="'.$usrempData['usremp_addr2'].'" /><br>
							City:<input type="text" name="City" value="'.$usrempData['usremp_city'].'" />, <select name="State"><option value="">...</option>';
		foreach(Q2T("SELECT * FROM res_states") as $row) $content.='<option '.($row['resst_code']==$usrempData['usremp_state']?'selected="selected" ':'').' value="'.$row['resst_code'].'">'.$row['resst_code'].'</option>';		
		$content .= '</select>
							Zip: <input type="text" name="Zip" value="'.$usrempData['usremp_zip'].'" />
							<br/><br/>
							Phone: <input type="text" name="Phone" value="'.$usrempData['usremp_phone'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000<br/>
							Phone Alt: <input type="text" name="Phone2" value="'.$usrempData['usremp_phone2'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000
							<br/><br/>
							Fax: <input type="text" name="Fax" value="'.$usrempData['usremp_fax'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000
							<br/><br/>
							<input type="submit" value="Save" />
							<input type="hidden" name="op" value="updatePro" />
						</form>
					</div>
				</div>
			</div>
		</div>';	
		$footerScript .= '$("form :input").on("keypress", function(e) { return e.keyCode != 13; });';
		break;   //y
	case "com":
	    // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"
		$content .= DBContent('','Company').'
		<div style="height:1200px;">
			<div class="" style="float:left;width:175px;margin-left:10px;">
				<!-- <div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'#\', { \'empSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div> -->
				<!-- <div class="appNavBlock ui-state-active" >Company Profile
					<div class="empNavItemActive"><span style="">Editing</span></div>		
				</div> -->';
		$content .= '<div id="empTab_pst">'.appTab('Partner Postings', 'pst', $pstTable,'job_title','job_id').'</div>';
	////	$content .= '<div id="empTab_req">'.appTab('Requests', 'req', $reqTable,'resreq_label','usrreq_id').'</div>';
		$content .= '
			</div>
			<div id="accordion" style="float:left;margin-left:10px;">
				<div class="employerProfileBlock">
					<h3>Company Information</h3>
					<div style="padding:20px">
						<div style="display:none;float:right;margin-top:15px;margin-right:100px;height:20px;">
							Industries
						</div><br/>
						<div style="border:1px solid #ddf;background:#eef;float:right;margin-top:5px;margin-right:10px;height:400px;width:250px;clear:right;">
						</div>
						<div>
						<form method="post">
							Company Name: <br/><input type="text" name="Company" value="'.$empData['emp_name'].'" style="width:300px;" /><br/><br/>
							Address: <textarea style="width:300px;" name="Address" >'.$empData['emp_address'].'</textarea><br/><br/>
							<input type="hidden" name="Reference" value="'.$empData['emp_reference_number'].'" />
							Email: <input type="text" name="Email" value="'.$empData['emp_email'].'"/><br/><br/>
							Phone: <input type="text" name="Phone" value="'.$empData['emp_phone'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000<br/><br/>
							Fax: <input type="text" name="Fax" value="'.$empData['emp_fax'].'" title="xxx-xxx-xxxx"/>&nbsp;&nbsp;(000) 000-0000<br/><br/>
							<input type="submit" value="Save" />
							<input type="hidden" name="op" value="updateCom" />Last updated: '.$empData['emp_updated'].'
						</form>
						</div>
					</div>
				</div>
			</div>
		</div>';	
		$footerScript .= '$("form :input").on("keypress", function(e) { return e.keyCode != 13; });';
		break;  //na
	case "pst":
	  // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"
		$content .= DBContent('','Partner Postings').'
		<div style="height:1200px;">
			<div class="" style="float:left;width:175px;margin-left:10px;">
				<!-- <div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'#\', { \'empSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div> -->
				<!-- <div class="appNavBlock ui-state-default" >Company Profile
					<div onclick="$.post( \'#\', { \'empSection\' : \'com\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>
				</div> -->';
		$content .= '<div id="empTab_pst">'.appTab('Partner Postings', 'pst', $pstTable,'job_title','job_id',true).'</div>';
	 ////	$content .= '<div id="empTab_req">'.appTab('Requests', 'req', $reqTable,'resreq_label','usrreq_id').'</div>';
		$content .= '
			</div>
			<div id="accordionHolder" >';
		pstBlock();
		$content .= '
			</div>
		</div>';		
		break;  //na y-req
	case "removethis_req":   // removing this 
		$content .= DBContent('','Requests').'
		<div style="height:1200px;">
			<div class="" style="float:left;width:175px;margin-left:10px;">
				<!-- <div class="appNavBlock ui-state-default" >Contact Information
					<div onclick="$.post( \'#\', { \'empSection\' : \'pro\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>		
				</div> -->
				<!-- <div class="appNavBlock ui-state-default" >Company Profile
					<div onclick="$.post( \'#\', { \'empSection\' : \'com\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">Edit</span></div>
				</div> -->';
		$content .= '<div id="empTab_pst">'.appTab('Partner Postings', 'pst', $pstTable,'job_title','job_id').'</div>';
		$content .= '<div id="empTab_req">'.appTab('Requests', 'req', $reqTable,'resreq_label','usrreq_id',true).'</div>';
		$content .= '
			</div>
			<div id="accordionHolder" >';
	//dead	reqBlock();
		$content .= '
			</div>
		</div>';
		break; //na  removing
}

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

   // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"

// -- functions / content rendering ------------------------------------------------------------


function appTab($tabTitle, $tabAcronym, $tabTable, $tabDataField,$tabKeyField,$tabActive = false){
	global $empSection;
	$first = 0;
	$subBuffer = '<div id="empNavMenu_'.$tabAcronym.'" class="appNavBlock ui-state-'.($tabActive?'active':'default').'" >'.$tabTitle;
	if ($tabActive) {
		if ($tabTable) foreach($tabTable as $row) $subBuffer .= '<div id="menuEntry_'.$row[$tabKeyField].'" onclick="$(\'#E_'.$row[$tabKeyField].'_'.$tabAcronym.'Block > h3\').click();menuSwitch(this);" class="empNavItemActive" style="'.(!$first++?"background:#2694ff;color:#fff;":"background:#AED0EA;color:#000;").'"><span style="">'.$row[$tabDataField].'</span></div>';
		$subBuffer .= '<div id="menuEntry_new" class="empNavItemActive" onclick="$(\'#E_add_'.$tabAcronym.'Block > h3\').click();menuSwitch(this);" style="'.(!$first++?"background:#2694ff;color:#fff;":"background:#AED0EA;color:#000;").'" ><span style="">+ Add</span></div></div>';
	} else {
		if ($tabTable) foreach($tabTable as $row) $subBuffer .= '<div onclick="$.post( \'employers.php?ts=\'+new Date().getMilliseconds(), { empSection : \''.$tabAcronym.'\' }, function() { window.location.href = \'?\'; });" class="empNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">'.$row[$tabDataField].'</span></div>';
		$subBuffer .= '<div onclick="$.post( \'employers.php?ts=\'+new Date().getMilliseconds(), { empSection : \''.$tabAcronym.'\' }, function() { window.location.href = \'?\'; });" class="emppNavItemInactive" style="background:#AED0EA;color:#000;"><span style="">+ Add</span></div></div>';
	}	
	return $subBuffer;  //y
}

// --------------------------------------------------------------

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
	/*		na	.sortable({
				axis: "y",
				handle: "h3",
				stop: function( event, ui ) { ui.item.children( "h3" ).triggerHandler( "focusout" ); }
			})*/
}

// --------------------------------------------------------------
 // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"


function pstBlock() {
	global $pstTable, $content, $footerScript, $userID, $emp_ID;
		//$content .='<div id="accordion" style="float:left;margin-left:1px;">';
		$content .='<div id="accordion" style="float:left;margin-left:8px;">';
		if ($pstTable) foreach($pstTable as $row) {
			$jobFncTable = getFunctions($row['job_id']);
			$jobCrtTable = getCertifications($row['job_id']);
			$jobSklTable = getSkills($row['job_id']);
			$jobExpTable = getExperience($row['job_id']);
			$jobAgcyTable = getAgencies($row['job_id']); //Add New Criteria
			$jobPrlcTable = getProflics($row['job_id']); //Add New Criteria
			$jobGeoTable = getGeos($row['job_id']); //Add New Criteria
			$jobVehiclesTable = getVehicles($row['job_id']); //Add New Criteria
						
			$jobFnc_cnt = getFunctions_cnt($row['job_id']);
			$jobCrt_cnt = getCertifications_cnt($row['job_id']);
			$jobSkl_cnt = getSkills_cnt($row['job_id']);
			$jobExp_cnt = getExperience_cnt($row['job_id']);
			$jobAgcy_cnt = getAgencies_cnt($row['job_id']); //Add New Criteria
			$jobPrlc_cnt = getProflics_cnt($row['job_id']); //Add New Criteria
			$jobGeo_cnt = getGeos_cnt($row['job_id']); //Add New Criteria
			$jobVehicles_cnt = getVehicles_cnt($row['job_id']); //Add New Criteria
			
			
			
			//$matchTable = getMatches($row['job_id']);			
//removed from form: <input type="button" value="Delete Job Entry" onclick="deleteJob(\''.$row['job_id'].'\');" />&nbsp;&nbsp;&nbsp;
//<a style="display:inline-block;width:180px;" href="employers.php?op=pdfJob&jobID='.$row['job_id'].'" target="_blank">Print Job</a>			
			$content .= '
				<div class="employerProfileBlock" id="E_'.$row['job_id'].'_pstBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['job_id'].'\')[0]);">'.$row['job_title'].'</h3>
												
					<div>
						<form method="post" action="#" id="form_'.$row['job_id'].'_job">
							<table border="0">
								<tr><td>Team Title</td><td><input type="text" class="E_'.$row['job_id'].'_job" id="E_'.$row['job_id'].'_title" name="E_title" style="width:300px" value="'.$row['job_title'].'" /></td>
									<td style="text-align:right">Submitted: '.$row['job_submitted_date'].'</td>
								</tr>
							</table>
							<div style="margin:10px 0px 0px 0px;">
								<input type="button" value="Delete Partner Post" onclick="deleteJob(\''.$row['job_id'].'\');" />&nbsp;&nbsp;&nbsp;
								<span id="E_'.$row['job_id'].'_jobSave" style="display:none;">
									<input type="button" value="Save" onclick="$(\'#accordion\').load(\'employers.php\', $(\'#form_'.$row['job_id'].'_job\').serialize());"/>&nbsp;&nbsp;<input type="reset" value="Reset" />
								</span>								
							</div>
							<input type="hidden" name="rec" value="'.$row['job_id'].'"/>
							<input type="hidden" name="op" value="updateJob" /><br/>
						</form>
														
							<form id="form1" name="form1" method="post">
  <input type="submit" name="submit" id="submit" value="Submit"/>
  <input type="hidden" name="op" value="myformtest"/>
  <input type="hidden" name="jobID" value="'.$row['job_id'].'"/><br/><br/>
</form>
						<div id="tabs_'.$row['job_id'].'" class="jobPostTabHolder">
							<ul> 
							    <!-- per jon tojo 41219li><a href="#tabs_'.$row['job_id'].'-8">Matches</a></li-->
								<li><a href="#tabs_'.$row['job_id'].'-1">Details</a></li>
								<!--li><a href="#tabs_'.$row['job_id'].'-2">Experience</a></li-->
								<li><a href="#tabs_'.$row['job_id'].'-4">NAICS</a></li>
								<li><a href="#tabs_'.$row['job_id'].'-5">Agencies</a></li>
								<li><a href="#tabs_'.$row['job_id'].'-9">Vehicles</a></li>
								<li><a href="#tabs_'.$row['job_id'].'-7">Licenses</a></li>
								<li><a href="#tabs_'.$row['job_id'].'-3">Certs</a></li>
								<li><a href="#tabs_'.$row['job_id'].'-6">Places</a></li>
							</ul>
							<div id="tabs_'.$row['job_id'].'-1">
								<div id="jobdetail_'.$row['job_id'].'">';
			renderJobDetails($row);
			$content .= '				</div>
							</div>							
							<div id="tabs_'.$row['job_id'].'-2">
								<div id="jobfuncs_'.$row['job_id'].'">';
			//renderJobFunctions($row['job_id'],$jobFncTable);
			$content .= '				</div>
							</div>							
							<div id="tabs_'.$row['job_id'].'-4">
								<div id="jobskills_'.$row['job_id'].'">';
			renderJobSkills($row['job_id'],$jobSklTable);
			$content .= '				</div>
							</div>
							<div id="tabs_'.$row['job_id'].'-5">
								<div id="jobagencies_'.$row['job_id'].'">';
			//renderJobExperience($row,$jobExpTable);
			renderJobAgencies($row['job_id'],$jobAgcyTable); //Add new Criteria
			$content .= '				</div>
							</div>
							<div id="tabs_'.$row['job_id'].'-3">
								<div id="jobcerts_'.$row['job_id'].'">';
			renderJobCertifications($row['job_id'],$jobCrtTable);
			$content .= '				</div>
							</div>							
							<div id="tabs_'.$row['job_id'].'-7">
								<div id="jobproflics_'.$row['job_id'].'">';
			renderJobProflics($row['job_id'],$jobPrlcTable); //Add new Criteria
			$content .= '				</div>
							</div>			
							<div id="tabs_'.$row['job_id'].'-6">
								<div id="jobgeos_'.$row['job_id'].'">';
			renderJobGeos($row['job_id'],$jobGeoTable); //Add new Criteria	
			$content .= '				</div>
							</div>
							<div id="tabs_'.$row['job_id'].'-9">
								<div id="jobvehicles_'.$row['job_id'].'">';
			renderJobVehicles($row['job_id'],$jobVehiclesTable); //Add new Criteria
			$content .= '				</div>
							</div>							
							<div id="tabs_'.$row['job_id'].'-8">
								<div id="jobmatch_'.$row['job_id'].'">';
								
								
	        renderJobMatches($matchTable,$jobCrt_cnt,$jobSkl_cnt,$jobFnc_cnt,$jobAgcy_cnt,$jobPrlc_cnt,$jobGeo_cnt,$jobVehicles_cnt,$row['job_id']);
	        
			//renderJobMatches($matchTable,count($jobCrtTable),count($jobSklTable),count($jobFncTable),count($jobAgcyTable),count($jobPrlcTable),count($jobGeoTable),count($jobVehiclesTable),$row['job_id']);	
			
			$content .= '				</div>
							</div>														
						</div>
					</div>
				</div>';
			$footerScript .= '
				$("#form_'.$row['job_id'].'_job :input").on("keypress", function(e) { return e.keyCode != 13; });
				$( function() { $("#tabs_'.$row['job_id'].'").tabs(); });
				$( function() { $(".E_'.$row['job_id'].'_job").change(function() { $("#E_'.$row['job_id'].'_jobSave").show(1000); }); });';
		}
		$footerScript .= '
				function saveJobFunction(jobID,funcID) {
					$("#jobfuncs_"+jobID).load("employers.php", {
						op: (funcID=="new"?"newPostFunc":"editPostFunc"),
						jobID: jobID,
						funcID: funcID,
						catID: $("#jobfunc_"+jobID+"_"+funcID+"_catID")[0].value,
						title: $("#jobfunc_"+jobID+"_"+funcID+"_title")[0].value,
						//training: $("#jobfunc_"+jobID+"_"+funcID+"_training")[0].value,
						comments: $("#jobfunc_"+jobID+"_"+funcID+"_comments")[0].value
					}); 
				}
				function saveJobCertification(jobID,crtID) {
					catID = $("#jobcert_"+jobID+"_"+crtID+"_catID")[0].value;
					if (catID == 0) {
					confirm("You must select a value from the list. Clear the search box and try again.");				
					}		
					else {
					$("#jobcerts_"+jobID).load("employers.php", {
						op: (crtID=="new"?"newPostCert":"editPostCert"),
						jobID: jobID,
						crtID: crtID,
						catID: $("#jobcert_"+jobID+"_"+crtID+"_catID")[0].value,
						title: $("#jobcert_"+jobID+"_"+crtID+"_title")[0].value,
						//training: $("#jobcert_"+jobID+"_"+crtID+"_training")[0].value,
						comments: $("#jobcert_"+jobID+"_"+crtID+"_comments")[0].value
					});}
				}
				function saveJobSkill(jobID,sklID) {
					catID = $("#jobskill_"+jobID+"_"+sklID+"_catID")[0].value;
					if (catID == 0) {
					confirm("You must select a value from the list. Clear the search box and try again.");				
					}
					else {
					$("#jobskills_"+jobID).load("employers.php", {
						op: (sklID=="new"?"newPostSkill":"editPostSkill"),
						jobID: jobID,
						sklID: sklID,
						catID: $("#jobskill_"+jobID+"_"+sklID+"_catID")[0].value,
						title: $("#jobskill_"+jobID+"_"+sklID+"_title")[0].value,
						//training: $("#jobskl_"+jobID+"_"+sklID+"_training")[0].value,
						comments: $("#jobskill_"+jobID+"_"+sklID+"_comments")[0].value
					});} 
				}												
				function saveJobAgency(jobID,agcyID) {
					catID = $("#jobagency_"+jobID+"_"+agcyID+"_catID")[0].value;
					if (catID == 0) {
					confirm("You must select a value from the list. Clear the search box and try again.");				
					}	
					else {
					$("#jobagencies_"+jobID).load("employers.php", {
						op: (agcyID=="new"?"newPostAgency":"editPostAgency"),
						jobID: jobID,
						agcyID: agcyID,
						catID: $("#jobagency_"+jobID+"_"+agcyID+"_catID")[0].value,
						title: $("#jobagency_"+jobID+"_"+agcyID+"_title")[0].value,
						//training: $("#jobskl_"+jobID+"_"+agcyID+"_training")[0].value,
						comments: $("#jobagency_"+jobID+"_"+agcyID+"_comments")[0].value
					});}
				}
				
				function saveJobProflic(jobID,prlcID) {	
					catID = $("#jobproflic_"+jobID+"_"+prlcID+"_catID")[0].value;
					if (catID == 0) {
					confirm("You must select a value from the list. Clear the search box and try again.");				
					}	
					else {
					$("#jobproflics_"+jobID).load("employers.php", {
						op: (prlcID=="new"?"newPostProflic":"editPostProflic"),
						jobID: jobID,
						agcyID: prlcID,
						catID: $("#jobproflic_"+jobID+"_"+prlcID+"_catID")[0].value,
						title: $("#jobproflic_"+jobID+"_"+prlcID+"_title")[0].value,
						//training: $("#jobskl_"+jobID+"_"+prlcID+"_training")[0].value,
						comments: $("#jobproflic_"+jobID+"_"+prlcID+"_comments")[0].value
					});} 
				}

				function saveJobGeo(jobID,geoID) {
					catID = $("#jobgeo_"+jobID+"_"+geoID+"_catID")[0].value;
					if (catID == 0) {
					confirm("You must select a value from the list. Clear the search box and try again.");				
					}	
					else {
					$("#jobgeos_"+jobID).load("employers.php", {
						op: (geoID=="new"?"newPostGeo":"editPostGeo"),
						jobID: jobID,
						agcyID: geoID,
						catID: $("#jobgeo_"+jobID+"_"+geoID+"_catID")[0].value,
						title: $("#jobgeo_"+jobID+"_"+geoID+"_title")[0].value,
						//training: $("#jobskl_"+jobID+"_"+geoID+"_training")[0].value,
						comments: $("#jobgeo_"+jobID+"_"+geoID+"_comments")[0].value
					});} 
				}
				
				function saveJobVehicles(jobID,vehiclesID) {
					catID = $("#jobvehicles_"+jobID+"_"+vehiclesID+"_catID")[0].value;
					if (catID == 0) {
					confirm("You must select a value from the list. Clear the search box and try again.");				
					}	
					else {
					$("#jobvehicles_"+jobID).load("employers.php", {
						op: (vehiclesID=="new"?"newPostVehicles":"editPostVehicles"),
						jobID: jobID,
						agcyID: vehiclesID,
						catID: $("#jobvehicles_"+jobID+"_"+vehiclesID+"_catID")[0].value,
						title: $("#jobvehicles_"+jobID+"_"+vehiclesID+"_title")[0].value,
						//training: $("#jobskl_"+jobID+"_"+vehiclesID+"_training")[0].value,
						comments: $("#jobvehicles_"+jobID+"_"+vehiclesID+"_comments")[0].value
					});}					
				}	

				function loadUrl(newLocation)
				{
					window.location = newLocation;
					return false;
				}
				function myRedirect(dashboard) { 
					window.location=dashboard;
				}
				
				
				function deleteFunction(jobID,jobfncID) {
					var sure = confirm("Are you sure you want to delete this job function entry?");
					if (sure == true ) $("#jobfuncs_"+jobID).load("employers.php", { op: "deletePostFunc", jobfncID: jobfncID, jobID: jobID} );
				}
				function deleteSkill(jobID,jobsklID) {
					var sure = confirm("Are you sure you want to delete this job skill entry?");
					if (sure == true ) $("#jobskills_"+jobID).load("employers.php", { op: "deletePostSkill", jobsklID: jobsklID, jobID: jobID} );
				}
			   function alreadythereSkill()
	           	{
		    	var sure = confirm("NAICS Skill entry already exists - enter new one");
	           	}
				function deleteAgency(jobID,jobsklID) {
					var sure = confirm("Are you sure you want to delete this job agency entry?");
					if (sure == true ) $("#jobagencies_"+jobID).load("employers.php", { op: "deletePostAgency", jobsklID: jobsklID, jobID: jobID} );				
				}
				   function alreadythereAgency()
	          	{
		    	var sure = confirm("Agency entry already exists - enter new one");
	           	}
			
				function deleteProflic(jobID,jobsklID) {
					var sure = confirm("Are you sure you want to delete this job Licenses entry?");
					if (sure == true ) $("#jobproflics_"+jobID).load("employers.php", { op: "deletePostProflic", jobsklID: jobsklID, jobID: jobID} );				
				}	
				
				function deleteGeo(jobID,jobsklID) {
					var sure = confirm("Are you sure you want to delete this job geography entry?");
					if (sure == true ) $("#jobgeos_"+jobID).load("employers.php", { op: "deletePostGeo", jobsklID: jobsklID, jobID: jobID} );				
				}					
			   function alreadythereGeo()
	           	{
		    	var sure = confirm("Place Geography entry already exists - enter new one");
	           	}
				
				
				function deleteCertification(jobID,jobcrtID) {
					var sure = confirm("Are you sure you want to delete this job certification entry?");
					if (sure == true ) $("#jobcerts_"+jobID).load("employers.php", { op: "deletePostCert", jobcrtID: jobcrtID, jobID: jobID} );
				}
                function alreadythereCertification()
	           	{
		           
		    	var sure = confirm("Certification entry already exists - enter new one");
	           	}
				function deleteVehicles(jobID,jobsklID) {
					var sure = confirm("Are you sure you want to delete this job Vehicles entry?");
					if (sure == true ) $("#jobvehicles_"+jobID).load("employers.php", { op: "deletePostVehicles", jobsklID: jobsklID, jobID: jobID} );				
				}	
				
				function deleteJob(jobDelID) {
					var sure = confirm("Are you sure you want to delete this job function entry?");
					if (sure == true ) $("#accordionHolder").load("employers.php", {
						op: "deleteJob",
						jobID: jobDelID
					}); 
				}';		
		$content .= '
				<div class="employerProfileBlock" id="E_add_pstBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">Add Partner Search</h3>
					<div>
						<form method="post" action="#" id="form_new_pst">
							<table border="0">
								<tr><td>Job Title</td><td><input type="text" id="E_new_jobTitle" name="E_new_jobTitle" style="width:300px"/></td></tr>
								<tr><td colspan="3">Description (optional) <br/><textarea name="E_new_jobComments" rows="6" cols="60" style="width:500px;height:100px;"></textarea></td></tr>
							</table>
							<br/>
							<input type="button" value="Save and Continue" onclick="$(\'#accordion\').load(\'employers.php\', $(\'#form_new_pst\').serialize());"/>
							<input type="hidden" name="op" value="newJob" />
						</form>
					</div>
				</div>
			</div>';
		$footerScript .= '$("#form_new_pst :input").on("keypress", function(e) { return e.keyCode != 13; });';
	
	accordion();
}

// --------------------------------------------------------------
 // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"


				
function renderJobDetails($row) { // covers Edu, Availability, other Details
	global $content, $footerScript, $clearanceTable, $eduLevelTable;
	$timeTable = getTimes();
	$industryTable = getIndust();
	//doMatchesUpdate($row['job_id']);
//*************
//function DropDown($id, $name, $dataTable, $inline = '', $selected = '') {
//	$subBuffer = "<select id='".$id."' name='".$name."' ".$inline." >";
//	foreach ($dataTable as $row) $subBuffer .= "<option ".($row['id']==$selected?'selected="selected"':'')." value='".$row['id']."'>".$row['label']."</option>";
//	$subBuffer .= "</select>";
//	return $subBuffer;
//} 

//$eduLevelTable = Q2T("SELECT catedu_level AS 'id' , group_concat(catedu_text SEPARATOR ', ') as 'label' FROM `cat_edu` GROUP BY catedu_level");
//$clearanceTable = Q2T("SELECT catclr_rank as 'id', catclr_title as 'label', catclr_desc as 'tooltip', catclr_rank FROM cat_clearance order by catclr_rank");

//*************	
	$content .= '
		<form id="form_'.$row['job_id'].'_jobDetails" action="#" method="post">
			<input type="hidden" id="job_ID" name="jobID" value="'.$row['job_id'].'" /><input type="hidden" name="op" value="editJobDetails" />

			Security Clearance: '.
		DropDown('job_'.$row['job_id'].'_clearance', 'E_job_clearance', $clearanceTable, 'class="E_'.$row['job_id'].'_jobDet" onclick="$(\'#job_'.$row['job_id'].'_jobDetailsSave\').show(1000);"',$row['job_clearance']).'<br/><br/>

			Union/Non-Union?: '.
		DropDown('job_'.$row['job_id'].'_edu', 'E_job_edu', $eduLevelTable, 'class="E_'.$row['job_id'].'_jobDet" onclick="$(\'#job_'.$row['job_id'].'_jobDetailsSave\').show(1000);"',$row['job_edu_level']).'<br/>
        <table width="630px" border="0">
		<tr>
		<td width="315px" valign="top">
			Due Date:
        <input type="text" name="E_due_date" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_due_date"  style="width:100px" value="'.$row['job_due_date'].'" />YYYY-MM-DD<br/><br/>
		</td>
		</tr><br><br>';
		$content .= '
		<tr>
		<td valign="top">
			Solicitation #:
        <input type="text" name="E_solicitation" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_solicitation"  style="width:100px" value="'.$row['job_solicitation'].'" /><br><br>';
		
		if ($row['job_solicitation_link'] <> '')
		{
			$content .= 'Solicitation URL:<br><a href="'.$row['job_solicitation_link'].'" target="_blank"><b><font color="red" >'.$row['job_solicitation_link'].'</font></b></a>';
		}
		else
		{
			$content .= 'Solicitation URL: <b><font color="blue">N/A</font></b>';
		}
				
		$content .=' </td>
		</tr>
		</table><br>';

		
		$content .= '
			Buying Office:
        <input type="text" name="E_buying_office" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_buying_office"  style="width:300px" value="'.$row['job_buying_office'].'" /><br/><br/>

			Contact Information:<br><br>
		<table width="630px" border="0">
		<tr>
		<td width="315px" valign="top">
			First Name:
        <input type="text" name="E_first_name" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_first_name"  style="width:200px" value="'.$row['job_first_name'].'" />
		</td>
		<td width="315px" valign="top">		
			Last Name:
        <input type="text" name="E_last_name" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_last_name"  style="width:200px" value="'.$row['job_last_name'].'" /><br/><br/>
		</td>
		</tr>
		</table>
			Email Address:
        <input type="text" name="E_email_address" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_email_address"  style="width:300px" value="'.$row['job_email_address'].'" /><br/><br/>

			Phone:
        <input type="text" name="E_phone" class="E_'.$row['job_id'].'_jobDet" id="E_'.$row['job_id'].'_phone"  style="width:300px" value="'.$row['job_phone'].'" /><br/><br/>
		Description: (Click outside the box to Save)<br/><textarea name="E_details" class="E_'.$row['job_id'].'_jobDet" rows="6" cols="60" style="width:500px;height:100px;">'.$row['job_details'].'</textarea><br/><br/>			<span id="E_'.$row['job_id'].'_jobDetailsSave" style="display:none;">
				<input type="button" value="Save" onclick="$(\'#jobdetail_'.$row['job_id'].'\').load(\'employers.php\', $(\'#form_'.$row['job_id'].'_jobDetails\').serialize());"/>&nbsp;&nbsp;
				<input type="reset" value="Reset" />
			</span>
		</form><br><br>';
	
	$footerScript .= '
		$(".E_'.$row['job_id'].'_jobDet").change(function(){$("#E_'.$row['job_id'].'_jobDetailsSave").show(1000);});
		$("#form_'.$row['job_id'].'_jobDetails :input").on("keypress", function(e) { return e.keyCode != 13; });';
}

// --------------------------------------------------------------
 // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"



function renderJobFunctions($jobID, $jobFncTable) {
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);
	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Title Search</th><th>Job Experience</th><th></th></tr></thead>
					<tbody>';
	if ($jobFncTable) foreach($jobFncTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_expID"  value="'.$jobID.'" />
					<input type="hidden" id="jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_catID"  value="'.$roe['jobfnc_id'].'" />
					<input type="text" id="jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_title" class="func_'.$jobID.'_'.$roe['jobfnc_id'].'" value="'.$roe['catfnc_title'].'" title="Search for descriptions here." /></td>'
					//<td>'.DropDown('jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_training', 'jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_training', $trainingTable, 'class="func_'.$jobID.'_'.$roe['jobfnc_id'].'" onclick="$(\'#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_comments" name="text" class="func_'.$jobID.'_'.$roe['jobfnc_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobfnc_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteFunction(\''.$jobID.'\',\''.$roe['jobfnc_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_saveEdit" name="jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_saveEdit"  onclick="saveJobFunction(\''.$jobID.'\',\''.$roe['jobfnc_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".func_'.$jobID.'_'.$roe['jobfnc_id'].'").change(function(){$("#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_saveEdit").show(1000);});
			$( "#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "functions-app", search: $( "#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "functions-app-select", search: ui.item.id }).done(	function(data) { $("#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_comments")[0].value = data; } );
					$("#jobfunc_'.$jobID.'_'.$roe['jobfnc_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobfunc_'.$jobID.'_new_expID" name="jobfunc_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobfunc_'.$jobID.'_new_catID" name="jobfunc_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobfunc_'.$jobID.'_new_title" name="jobfunc_'.$jobID.'_new_title" value="" title="Search for descriptions here."/></td>'
			//<td>'.DropDown('jobfunc_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobfunc_'.$jobID.'_new_comments" name="jobfunc_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobFunction(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$(".'.$jobID.'_exp").change(function(){$("#E_'.$jobID.'_expSave").show(1000);});
		$( "#jobfunc_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "functions-app", search: $( "#jobfunc_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobfunc_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "functions-app-select", search: ui.item.id }).done(	function(data) { $("#jobfunc_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function renderJobCertifications($jobID, $jobCrtTable) {
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);
	$content .= '   <table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Certification Search</th><th>Certification Details</th><th></th></tr></thead>
					<tbody>';
	if ($jobCrtTable) foreach($jobCrtTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_expID" name="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_catID" name="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_fncID" value="'.$roe['jobcrt_id'].'" />
					<input type="text" id="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_title" name="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_title" class="cert_'.$jobID.'_'.$roe['jobcrt_id'].'" value="'.$roe['catcrt_name'].'" /></td>'
					//<td>'.DropDown('jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_training', 'jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_training', $trainingTable, 'class="cert_'.$jobID.'_'.$roe['jobcrt_id'].'" onclick="$(\'#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_comments" name="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_comments" class="cert_'.$jobID.'_'.$roe['jobcrt_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobcrt_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteCertification(\''.$jobID.'\',\''.$roe['jobcrt_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_saveEdit" name="jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_saveEdit"  onclick="saveJobCertification(\''.$jobID.'\',\''.$roe['jobcrt_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".cert_'.$jobID.'_'.$roe['jobcrt_id'].'").change(function(){$("#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_saveEdit").show(1000);});
			$( "#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "certifications-app", search: $( "#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "certifications-app-select", search: ui.item.id }).done( function(data) { $("#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_comments")[0].value = data; } );
					$("#jobcert_'.$jobID.'_'.$roe['jobcrt_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobcert_'.$jobID.'_new_expID" name="jobcert_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobcert_'.$jobID.'_new_catID" name="jobcert_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobcert_'.$jobID.'_new_title" name="jobcert_'.$jobID.'_new_title" value="" /></td>'
			//<td>'.DropDown('jobcert_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobcert_'.$jobID.'_new_comments" name="jobcert_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobCertification(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$(".cert_'.$jobID.'").change(function(){$("#E_'.$jobID.'_expSave").show(1000);});
		$( "#jobcert_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "certifications-app", search: $( "#jobcert_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobcert_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "certifications-app-select", search: ui.item.id }).done( function(data) { $("#jobcert_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function renderJobExperience($jobID, $jobExpTable) { 
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);
	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Function</th><th>Training</th><th>Description</th><th></th></tr></thead>
					<tbody>';
	if ($jobExpTable) foreach($jobExpTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_expID" name="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_catID" name="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_fncID" value="'.$roe['jobexp_id'].'" />
					<input type="text" id="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_title" name="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_title" class="exp_'.$jobID.'_'.$roe['jobexp_id'].'" value="'.$roe['usrexpfnc_title'].'" /></td>
					<td>'.DropDown('jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_training', 'jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_training', $trainingTable, 'class="exp_'.$jobID.'_'.$roe['jobexp_id'].'" onclick="$(\'#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					<td><textarea id="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_comments" name="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_comments" class="exp_'.$jobID.'_'.$roe['jobexp_id'].'" rows="3" cols="36" style="width:300px">'.$roe['usrexpfnc_comment'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteExpFunction(\''.$jobID.'\',\''.$roe['jobexp_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_saveEdit" name="jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_saveEdit"  onclick="saveExpFunction(\''.$jobID.'\',\''.$roe['jobexp_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".exp_'.$jobID.'_'.$roe['jobexp_id'].'").change(function(){$("#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_saveEdit").show(1000);});
			$( "#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "functions-app", search: $( "#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "functions-app-select", search: ui.item.id }).done(	function(data) { $("#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_comments")[0].value = data; } );
					$("#jobexp_'.$jobID.'_'.$roe['jobexp_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobexp_'.$jobID.'_new_expID" name="jobexp_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobexp_'.$jobID.'_new_catID" name="jobexp_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobexp_'.$jobID.'_new_title" name="jobexp_'.$jobID.'_new_title" value="" /></td>
			<td>'.DropDown('jobexp_'.$jobID.'_new_training', '', $trainingTable).'</td>
			<td><textarea id="jobexp_'.$jobID.'_new_comments" name="jobexp_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveExpFunction(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$(".'.$jobID.'_exp").change(function(){$("#E_'.$jobID.'_expSave").show(1000);});
		$( "#jobexp_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "functions-app", search: $( "#jobexp_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobexp_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "functions-app-select", search: ui.item.id }).done(	function(data) { $("#jobexp_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function renderJobSkills($jobID, $jobSklTable) {
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);
	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>NAICS Search</th><th>NAICS Details</th><th></th></tr></thead>
					<tbody>';
	if ($jobSklTable) foreach($jobSklTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_expID" name="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_catID" name="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_fncID" value="'.$roe['jobskl_id'].'" />
					<input type="text" id="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_title" name="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_title" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" value="'.$roe['catskl_label'].'" /></td>'
					//<td>'.DropDown('jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_training', 'jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_training', $trainingTable, 'class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" onclick="$(\'#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_comments" name="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_comments" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobskl_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteSkill(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit" name="jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit"  onclick="saveJobSkill(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".skill_'.$jobID.'_'.$roe['jobskl_id'].'").change(function(){$("#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);});
			$( "#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "skills-app", search: $( "#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "skills-app-select", search: ui.item.id }).done( function(data) { $("#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_comments")[0].value = data; } );
					$("#jobskill_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobskill_'.$jobID.'_new_expID" name="jobskill_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobskill_'.$jobID.'_new_catID" name="jobskill_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobskill_'.$jobID.'_new_title" name="jobskill_'.$jobID.'_new_title" value="" /></td>'
			//<td>'.DropDown('jobskill_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobskill_'.$jobID.'_new_comments" name="jobskill_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobSkill(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$( "#jobskill_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "skills-app", search: $( "#jobskill_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobskill_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "skills-app-select", search: ui.item.id }).done( function(data) { $("#jobskill_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------
//function renderJobAgencies($jobID, $jobSklTable)
function renderJobAgencies($jobID, $jobAgcyTable) {
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);
	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Agency Search</th><th>Agency Description</th><th></th></tr></thead>
					<tbody>';
	if ($jobAgcyTable) foreach($jobAgcyTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_expID" name="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_catID" name="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_fncID" value="'.$roe['jobskl_id'].'" />
					<input type="text" id="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_title" name="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_title" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" value="'.$roe['catagen_label'].'" /></td>'
					//<td>'.DropDown('jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_training', 'jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_training', $trainingTable, 'class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" onclick="$(\'#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_comments" name="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_comments" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobskl_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteAgency(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit" name="jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit"  onclick="saveJobSkill(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".skill_'.$jobID.'_'.$roe['jobskl_id'].'").change(function(){$("#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);});
			$( "#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "agencies-app", search: $( "#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "agencies-app-select", search: ui.item.id }).done( function(data) { $("#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_comments")[0].value = data; } );
					$("#jobagency_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobagency_'.$jobID.'_new_expID" name="jobagency_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobagency_'.$jobID.'_new_catID" name="jobagency_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobagency_'.$jobID.'_new_title" name="jobagency_'.$jobID.'_new_title" value="" /></td>'
			//<td>'.DropDown('jobagency_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobagency_'.$jobID.'_new_comments" name="jobagency_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobAgency(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$( "#jobagency_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "agencies-app", search: $( "#jobagency_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobagency_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "agencies-app-select", search: ui.item.id }).done( function(data) { $("#jobagency_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function renderJobProflics($jobID, $jobSklTable) {
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);
	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>License Search</th><th>License Description</th><th></th></tr></thead>
					<tbody>';
	if ($jobSklTable) foreach($jobSklTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_expID" name="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_catID" name="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_fncID" value="'.$roe['jobskl_id'].'" />
					<input type="text" id="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_title" name="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_title" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" value="'.$roe['catskl_label'].'" /></td>'
					//<td>'.DropDown('jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_training', 'jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_training', $trainingTable, 'class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" onclick="$(\'#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_comments" name="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_comments" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobskl_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteProflic(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit" name="jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit"  onclick="saveJobProflic(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".skill_'.$jobID.'_'.$roe['jobskl_id'].'").change(function(){$("#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);});
			$( "#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "proflics-app", search: $( "#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "proflics-app-select", search: ui.item.id }).done( function(data) { $("#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_comments")[0].value = data; } );
					$("#jobproflic_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobproflic_'.$jobID.'_new_expID" name="jobproflic_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobproflic_'.$jobID.'_new_catID" name="jobproflic_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobproflic_'.$jobID.'_new_title" name="jobproflic_'.$jobID.'_new_title" value="" /></td>'
			//<td>'.DropDown('jobproflic_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobproflic_'.$jobID.'_new_comments" name="jobproflic_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobProflic(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$( "#jobproflic_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "proflics-app", search: $( "#jobproflic_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobproflic_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "proflics-app-select", search: ui.item.id }).done( function(data) { $("#jobproflic_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function renderJobGeos($jobID, $jobSklTable) {
	global $content, $footerScript, $trainingTable;
    //doMatchesUpdate($jobID);
	//$content .= '<table cellpadding="4" cellspacing="0" border="0" class="functionsGrid">';
	
	$content .= '   <table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Place Search</th><th>Place Description</th><th></th></tr></thead>
					<tbody>';
	if ($jobSklTable) foreach($jobSklTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_expID" name="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_catID" name="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_fncID" value="'.$roe['jobskl_id'].'" />
					<input type="text" id="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_title" name="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_title" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" value="'.$roe['catskl_label'].'" /></td>'
					//<td>'.DropDown('jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_training', 'jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_training', $trainingTable, 'class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" onclick="$(\'#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_comments" name="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_comments" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobskl_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteGeo(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit" name="jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit"  onclick="saveJobGeo(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".skill_'.$jobID.'_'.$roe['jobskl_id'].'").change(function(){$("#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);});
			$( "#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "geos-app", search: $( "#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "geos-app-select", search: ui.item.id }).done( function(data) { $("#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_comments")[0].value = data; } );
					$("#jobgeo_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobgeo_'.$jobID.'_new_expID" name="jobgeo_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobgeo_'.$jobID.'_new_catID" name="jobgeo_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobgeo_'.$jobID.'_new_title" name="jobgeo_'.$jobID.'_new_title" value="" /></td>'
			//<td>'.DropDown('jobgeo_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobgeo_'.$jobID.'_new_comments" name="jobgeo_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobGeo(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$( "#jobgeo_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "geos-app", search: $( "#jobgeo_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobgeo_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "geos-app-select", search: ui.item.id }).done( function(data) { $("#jobgeo_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function renderJobVehicles($jobID, $jobSklTable) {
	global $content, $footerScript, $trainingTable;
	//doMatchesUpdate($jobID);

	$content .= '	<table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th>Vehicle Search</th><th>Vehicle Description</th><th></th></tr></thead>
					<tbody>';
	if ($jobSklTable) foreach($jobSklTable as $roe) {
		$content .= '<tr><td><input type="hidden" id="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_expID" name="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_expID" value="'.$jobID.'" />
					<input type="hidden" id="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_catID" name="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_fncID" value="'.$roe['jobskl_id'].'" />
					<input type="text" id="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_title" name="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_title" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" value="'.$roe['catskl_label'].'" /></td>'
					//<td>'.DropDown('jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_training', 'jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_training', $trainingTable, 'class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" onclick="$(\'#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit\').show(1000);"',$roe['usrexpfnc_trn_id']).'</td>
					.'<td><textarea id="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_comments" name="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_comments" class="skill_'.$jobID.'_'.$roe['jobskl_id'].'" rows="3" cols="36" style="width:300px">'.$roe['jobskl_desc'].'</textarea></td>
					<td style="text-align:center"><input type="button" value="Delete" onclick="deleteVehicles(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /><br/><input type="button" value="Save" style="display:none;" id="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit" name="jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit"  onclick="saveJobVehicles(\''.$jobID.'\',\''.$roe['jobskl_id'].'\');" /></td></tr>';
		$footerScript .='
			$(".skill_'.$jobID.'_'.$roe['jobskl_id'].'").change(function(){$("#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);});
			$( "#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_title" ).autocomplete({
				source: function(request, response) {
					$.getJSON("inc/autocomplete.php", { sec: "vehicles-app", search: $( "#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_title" )[0].value }, response);
				}, minLength: 2,
				select: function( event, ui ) {
					$("#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_catID")[0].value=ui.item.id;
					$.get("inc/autocomplete.php", {sec: "vehicles-app-select", search: ui.item.id }).done( function(data) { $("#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_comments")[0].value = data; } );
					$("#jobvehicles_'.$jobID.'_'.$roe['jobskl_id'].'_saveEdit").show(1000);
				}
			});';
	}
	$content .= '<tr><td><input type="hidden" id="jobvehicles_'.$jobID.'_new_expID" name="jobvehicles_'.$jobID.'_new_expID" value="'.$jobID.'" />
			<input type="hidden" id="jobvehicles_'.$jobID.'_new_catID" name="jobvehicles_'.$jobID.'_new_catID" value="" />
			<input type="text" id="jobvehicles_'.$jobID.'_new_title" name="jobvehicles_'.$jobID.'_new_title" value="" /></td>'
			//<td>'.DropDown('jobvehicles_'.$jobID.'_new_training', '', $trainingTable).'</td>
			.'<td><textarea id="jobvehicles_'.$jobID.'_new_comments" name="jobvehicles_'.$jobID.'_new_comment" rows="3" cols="36" style="width:300px;"></textarea></td>
			<td><input type="button" value="Add" onclick="saveJobVehicles(\''.$jobID.'\',\'new\');" /></td>
						</tr>
					</tbody>
				</table>';
	$footerScript .= '$("#E_'.$jobID.'_expStart").datepicker();$("#E_'.$jobID.'_expEnd").datepicker();
		$( "#jobvehicles_'.$jobID.'_new_title" ).autocomplete({
			source: function(request, response) {
				$.getJSON("inc/autocomplete.php", { sec: "vehicles-app", search: $( "#jobvehicles_'.$jobID.'_new_title" )[0].value }, response);
			}, minLength: 2,
			select: function( event, ui ) {
				$("#jobvehicles_'.$jobID.'_new_catID")[0].value=ui.item.id;
				$.get("inc/autocomplete.php", {sec: "vehicles-app-select", search: ui.item.id }).done( function(data) { $("#jobvehicles_'.$jobID.'_new_comments")[0].innerHTML = data; } );
			}
		});';
}

// --------------------------------------------------------------

function doMatchesUpdate($job_id) {
	// this function is not called
	global $content;
	
	$jobFncTable = getFunctions($job_id);
	$jobCrtTable = getCertifications($job_id);
	$jobSklTable = getSkills($job_id);
	$jobExpTable = getExperience($job_id);
	$jobAgcyTable = getAgencies($job_id);
	$jobPrlcTable = getProflics($job_id);
	$jobGeoTable = getGeos($job_id);
	$matchTable = getMatches($job_id);	
	
	
	//$jobFncTable1 = Q2T("SELECT * FROM job_func WHERE jobfnc_job_id = '".$job_id."'");
	//$jobCrtTable1 = Q2T("SELECT * FROM job_certs WHERE jobcrt_job_id = '".$job_id."'");
	//$jobSklTable1 = Q2T("SELECT * FROM job_skills WHERE jobskl_job_id = '".$job_id."'");
	//$jobExpTable1 = Q2T("SELECT * FROM job_exp WHERE jobskl_job_id = '".$job_id."'");
	//$jobAgcyTable1 = Q2T("SELECT * FROM job_agencies WHERE jobskl_job_id = '".$job_id."'");
	//$jobPrlcTable1 = Q2T("SELECT * FROM job_proflics WHERE jobskl_job_id = '".$job_id."'");
	//$jobGeoTable1 = Q2T("SELECT * FROM job_geos WHERE jobskl_job_id = '".$job_id."'");
	
	//$fnc = intval($jobFncTable1['cnt']);
	//$crt = intval($jobCrtTable1['cnt']);
	//$skl = intval($jobSklTable1['cnt']);
	//$exp = intval($jobExpTable1['cnt']);
	//$agc = intval($jobAgcyTable1['cnt']);
	//$prlc = intval($jobPrlcTable1['cnt']);
	//$geo = intval($jobGeoTable1['cnt']);
	
	//echo count($job_id) . " " . count($crt) . " " . count($skl) . " " . count($agc) . " " . count($prlc) . " " . count($geo) . "<br><br><br>";
	//echo count($jobCrtTable) . " " . count($jobSklTable) . " " . count($jobAgcyTable) . " " . count($jobPrlcTable) . " " . count($jobGeoTable) . "<br><br><br>";
	//echo count($jobCrtTable1) . " " . count($jobSklTable1) . " "  . count($jobAgcyTable1) . " " . count($jobPrlcTable1) . " " . count($jobGeoTable1) . "<br><br><br>";
	//exit();

	
	//echo $jobCrtTable1 . "--" . $jobSklTable1 . "--" . $jobExpTable1 . "--" . $jobAgcyTable1 . "--" . $jobPrlcTable1 . "--" . $jobGeoTable1 . " mmmmmmmm \n";
	//echo count($jobCrtTable) . "--" . count($jobSklTable) . "--" . count($jobExpTable) . "--" . count($jobAgcyTable) . "--" . count($jobPrlcTable) . "--" . count($jobGeoTable);
	//echo intval($jobAgcyTable1['agcycnt']) . " ----- " . count($jobAgcyTable);
	//exit();
	
	
	//echo $jobSklTable;	
	//echo count($jobAgcyTable);
	//$jobAgcyTable = QV("SELECT count(*) FROM job_agencies WHERE jobskl_job_id = '".$job_id."'");
	//echo $jobAgcyTable;
	//exit();
     
	renderJobMatches($matchTable,count($jobCrtTable),count($jobSklTable),count($jobFncTable),count($jobAgcyTable),count($jobPrlcTable),count($jobGeoTable),count($jobVehiclesTable),$job_id);
	// na
}
 // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"


function renderJobMatches($matchTable,$certs,$skills,$funcs,$agencies,$proflics,$geos,$vehicles,$job_id) {
	global $content, $footerScript, $userID, $emp_ID;

	//SAVE JUST IN CASE
	//<div style="height:20px;display:inline-block;margin:10px 0;padding:10px;"><button onclick="myFunction()">Update Matches</button><script>
//function myFunction() {
    //location.reload();
//}</script></div>

	$content .= '<!--	
<div>Legend: <div style="height:20px;display:inline-block;margin:10px 0px 10px 10px;padding:10px;background:#888;color:#fff;">No Match</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8a8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8b8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8c8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8d8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8e8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8e8;">&nbsp;</div>
<div style="height:20px;width:10px;display:inline-block;margin:10px 0;padding:10px;background:#8e8;">&nbsp;</div>
<div style="height:20px;display:inline-block;margin:10px 0;padding:10px;background:#0f0;">Full Match</div>
</div><br><table cellpadding="4" cellspacing="0" class="functionsGrid">
					<thead><tr style="color:#fff"><th style="width:200px;">Name</th><th style="width:80px;">NAICS</th><th style="width:80px;">Agencies</th><th style="width:80px;">Certs</th><th style="width:80px;">Licenses</th><th style="width:80px;">Places</th><th style="width:80px;">Vehicles</th><th style="width:80px;">Sum</th></tr></thead>
					<tbody> -->';										
	if ($matchTable) foreach($matchTable as $roe) {
		$certVal = intval($roe['sysmat_certifications']); if ($certVal > intval($certs)) $certVal = intval($certs);
		$skillVal = intval($roe['sysmat_skills']); if ($skillVal > intval($skills)) $skillVal = intval($skills);
		$funcVal = intval($roe['sysmat_functions']); if ($funcVal > intval($funcs)) $funcVal = intval($funcs);
		$agcyVal = intval($roe['sysmat_agencies']); if ($agcyVal > intval($agencies)) $agcyVal = intval($agencies);	
		$proflicVal = intval($roe['sysmat_proflics']); if ($proflicVal > intval($proflics)) $proflicVal = intval($proflics);
		$geoVal = intval($roe['sysmat_geos']); if ($geoVal > intval($geos)) $geoVal = intval($geos);
		$vehiclesVal = intval($roe['sysmat_vehicles']); if ($vehiclesVal > intval($vehicles)) $geoVal = intval($vehicles);
		
//		echo $certVal . "--" . $skillVal . "--" . $agcyVal . "--" . $proflicVal . "--" . $geoVal . "<br><br>";
//		echo $certs . "--" . $skills . "--" . $agencies . "--" . $proflics . "--" . $geos . "<br><br>";
//	echo "[ " . $job_id . " ] " . " [ " . $certVal . " ] " . " [ " . $certs . " ] " . " [ " . intval($certs) . " ] <br><br>";
//	exit();
		
				$sumVal = intval($roe['sum']);
		$certColor = '';
		$skillColor = '';
		$funcColor = '';
		$agcyColor = '';
		$proflicColor = '';
		$geoColor = '';
		$vehiclesColor = '';
                $sumColor = '';	
			
		if (dechex((($certVal / intval($certs))*8)+8)==10) $certColor = '#0f0;';
		else $certColor = '#8'.dechex((($certVal / intval($certs))*8)+8).'8';

		if (dechex((($skillVal / intval($skills))*8)+8)==10) $skillColor = '#0f0';
		else $skillColor = '#8'.dechex((($skillVal / intval($skills))*8)+8).'8';

		if (dechex((($funcVal / intval($funcs))*8)+8)==10) $funcColor = '#0f0';
		else $funcColor = '#8'.dechex((($funcVal / intval($funcs))*8)+8).'8';
		
		if (dechex((($agcyVal / intval($agencies))*8)+8)==10) $agcyColor = '#0f0';
		else $agcyColor = '#8'.dechex((($agcyVal / intval($agencies))*8)+8).'8';
		
		if (dechex((($proflicVal / intval($proflics))*8)+8)==10) $proflicColor = '#0f0';
		else $proflicColor = '#8'.dechex((($proflicVal / intval($proflics))*8)+8).'8';

		if (dechex((($geoVal / intval($geos))*8)+8)==10) $geoColor = '#0f0';
		else $geoColor = '#8'.dechex((($geoVal / intval($geos))*8)+8).'8';		

		if (dechex((($vehiclesVal / intval($vehicles))*8)+8)==10) $vehiclesColor = '#0f0';
		else $vehiclesColor = '#8'.dechex((($vehiclesVal / intval($vehicles))*8)+8).'8';			
		

        if (dechex((($sumVal / intval(($certs+$skills+$agencies+$proflics+$geos+$vehicles)))*8)+8)==10) $sumColor = '#0f0;';
		else $sumColor = '#8'.dechex(((($sumVal/5) / intval(($certs+$skills+$agencies+$proflics+$geos+$vehicles)/5))*8)+8).'8';
		
	$jobCrtTable1 = Q2T("SELECT * FROM job_certs WHERE jobcrt_job_id = '".$job_id."'");
	$jobSklTable1 = Q2T("SELECT * FROM job_skills WHERE jobskl_job_id = '".$job_id."'");
	$jobAgcyTable1 = Q2T("SELECT * FROM job_agencies WHERE jobskl_job_id = '".$job_id."'");
	$jobPrlcTable1 = Q2T("SELECT * FROM job_proflics WHERE jobskl_job_id = '".$job_id."'");
	$jobGeoTable1 = Q2T("SELECT * FROM job_geos WHERE jobskl_job_id = '".$job_id."'");
	$jobVehiclesTable1 = Q2T("SELECT * FROM job_vehicles WHERE jobskl_job_id = '".$job_id."'");
	
	
	$dcerts = $certs;
	$dskills = $skills;
	$dagencies = $agencies;
	$dproflics = $proflics;
	$dgeos = $geos;
	$dvehicles = $vehicles;
	
	if (empty($jobCrtTable1)){
		$dcerts = 0;
	} 		
	if (empty($jobSklTable1)){
		$dskills = 0;
	} 
	if (empty($jobAgcyTable1)){
		$dagencies = 0;
	} 
	if (empty($jobPrlcTable1)){
		$dproflics = 0;
	} 
	if (empty($jobGeoTable1)){
		$dgeos = 0;
	} 
	
	if (empty($jobVehiclesTable1)){
		$dvehicles = 0;
	} 
			
                //$sumColor = "#5EC0EE";
		$content .= '<tr><td style="background:#ffffff;"><a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'" >'.$roe['usr_firstname'].' '.$roe['usr_lastname'].'</a></td>
					<td style="text-align:center;background:'.$skillColor.'">'.$roe['sysmat_skills'].'/'.$dskills.'</td>
					<td style="text-align:center;background:'.$agcyColor.'">'.$roe['sysmat_agencies'].'/'.$dagencies.'</td>
					<td style="text-align:center;background:'.$certColor.'">'.$roe['sysmat_certifications'].'/'.$dcerts.'</td>
					<td style="text-align:center;background:'.$proflicColor.'">'.$roe['sysmat_proflics'].'/'.$dproflics.'</td>	
					<td style="text-align:center;background:'.$geoColor.'">'.$roe['sysmat_geos'].'/'.$dgeos.'</td>	
					<td style="text-align:center;background:'.$vehiclesColor.'">'.$roe['sysmat_vehicles'].'/'.$dvehicles.'</td>
					<td style="text-align:center;background:'.$sumColor.'">'.($roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos']+$roe['sysmat_vehicles']).'/'.($dcerts+$dskills+$dagencies+$dproflics+$dgeos+$dvehicles).'</td>	
					</tr>';
	}
	$content .= '	</tbody>
				</table> <br><br><br>';	
}

// --------------------------------------------------------------

function deadpertojoreqBlock() {  // dead per tojo
	global $reqTable, $content, $footerScript;
		$content .='<div id="accordion" style="float:left;margin-left:10px;">';
		if ($reqTable) foreach($reqTable as $row) {
			$statusString = '';
			switch (intval($row['usrreq_status'])) {
				case 0: case 1: default: $statusString="Submitted"; break;
				case 2: $statusString = "Processing"; break;
				case 3: $statusString = "Replied"; break;
				case 4: $statusString = "Closed"; break;
			}
			$content .= '
				<div class="employerProfileBlock" id="E_'.$row['usrreq_id'].'_reqBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_'.$row['usrreq_id'].'\')[0]);" >Requests</h3>
					<div>
						<form method="post" action="#" id="form_'.$row['usrreq_id'].'_req" >
							<table border="0">
								<tr><td>Request Type:</td><td>'.$row['resreq_label'].'</td></tr>
								<tr><td>Status:</td><td>'.$statusString.'</td></tr>
								<tr><td>Date Submitted:</td><td>'.$row['usrreq_date'].'</td></tr>
								<tr><td>Request:</td><td>'.$row['usrreq_request'].'</td></tr>
							'.((intval($row['usrreq_status']) >= 3) ? '<tr><td>Response:</td><td>'.$row['usrreq_response'].'</td></tr>' : '').'
							</table>
							<div id="E_'.$row['usrreq_id'].'_reqSave" >
								'.((intval($row['usrreq_status']) < 3) ? '<input type="button" value="Cancel Request" onclick="$(\'#accordion\').load( \'employers.php\', $(\'#form_'.$row['usrreq_id'].'_req\').serialize());"/>':'').'
								'.((intval($row['usrreq_status']) == 4) ? '<input type="button" value="Remove" onclick="$(\'#accordion\').load( \'employers.php\', $(\'#form_'.$row['usrreq_id'].'_req\').serialize());"/>':'').'							</div>
							<input type="hidden" name="rec" value="'.$row['usrreq_id'].'"/>
							<input type="hidden" name="op" value="deleteReq" />
						</form>
					</div>
				</div>';
			$footerScript .= '$("#E_'.$row['usrreq_id'].'_reqBlock :input").on("keypress", function(e) { return e.keyCode != 13; });';				
		}
		$content .= '
				<div class="employerProfileBlock" id="E_add_reqBlock">
					<h3 onclick="menuSwitch($(\'#menuEntry_new\')[0]);">New Request</h3>
					<div>
						<form method="post" action="#" id="form_new_req">
							<table border="0">
								<tr><td>Request Type:</td><td><select class="new_req" id="E_new_reqType" name="E_new_reqType" ><option value="">...</option>';
			foreach(Q2T("SELECT * FROM res_request") as $row) $content.='<option value="'.$row['resreq_id'].'">'.$row['resreq_label'].'</option>';
			$content .= '		</select></td></tr>
								<tr><td>Request:</td><td><textarea class="new_req" id="E_new_reqRequest" name="E_new_reqRequest" rows="4" cols="60" style="width:500px;height:50px;"></textarea></td></tr>
							</table>
							<input type="button" value="Submit Request" onclick="$(\'#accordion\').load(\'employers.php\', $(\'#form_new_req\').serialize());"/>
							<input type="hidden" name="op" value="newReq" />
						</form>
					</div>
				</div>
			</div>';
		$footerScript .= '$("#form_new_req :input").on("keypress", function(e) { return e.keyCode != 13; });';
	accordion();
}

// --------------------------------------------------------------
// ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"

function getRequests() {   //no longer in use llyd 3/24/19
	global $userID;
	return Q2T("SELECT U.*,R.* FROM usr_req U LEFT JOIN res_request R ON U.usrreq_req_id = R.resreq_id WHERE U.usrreq_usr_id = '".$userID."' ORDER BY U.usrreq_date");
	//na
}

function getPosts() {
	global $userID,$emp_ID;
	return Q2T("SELECT J.* FROM job J WHERE J.job_emp_id = '".$userID."' and jobemp_ID = '".$emp_ID. "'  ORDER BY J.job_submitted_date ");
	//y
}

function getFunctions($id) { 
	return Q2T("SELECT F.*, C.* FROM job_func F LEFT JOIN cat_func C ON C.catfnc_id= F.jobfnc_fnc_id WHERE F.jobfnc_job_id = '".$id."' "); 
}  //na

function getCertifications($id) {
	return Q2T("SELECT E.*, C.* FROM job_certs E LEFT JOIN cat_certs C ON C.catcrt_id = E.jobcrt_crt_id WHERE E.jobcrt_job_id = '".$id."' ");
}  //na

function getSkills($id) {
	return Q2T("SELECT S.*, C.* FROM job_skills S LEFT JOIN cat_skills C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
} //na

function getAgencies($id) {
	return Q2T("SELECT S.*, C.* FROM job_agencies S LEFT JOIN cat_agencies C ON C.catagen_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}  //na

function getProflics($id) {
	return Q2T("SELECT S.*, C.* FROM job_proflics S LEFT JOIN cat_proflics C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
} //na

function getGeos($id) {
	return Q2T("SELECT S.*, C.* FROM job_geos S LEFT JOIN cat_geos C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getExperience($id) {
	return Q2T("SELECT E.*, C.* FROM job_exp E LEFT JOIN cat_exp C ON C.catexp_id = E.jobexp_exp_id WHERE E.jobexp_job_id = '".$id."' ");
}  //na

/*function getMatches($id) {
	return Q2T("SELECT S.*,U.* FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."'");
}*/
 // ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php"

  
function getMatches($id) {  // this seems not to be in use
	global $userID,$emp_ID;
	//clear match table    ?
	
/* 	Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'  and S.sysmat_emp_id = '".$emp_ID. "'  "); 
	
	//rerun match routines
	updateCertMatchesJP($id);
	updateSkillMatchesJP($id);
	updateAgencyMatchesJP($id);
	updateProflicMatchesJP($id);
	updateGeoMatchesJP($id);
	updateVehiclesMatchesJP($id);
*/

	//rerun match routines  do we need   $userID  $emp_ID  in core_empid
	// ////  _empid   $emp_ID   $userID   jobemp_ID  and jobemp_ID = '".$emp_ID. "'  "employers.php" nonzeroempid


	updateCertMatchesJPnonzeroempid($id);
	updateSkillMatchesJPnonzeroempid($id);
	updateAgencyMatchesJPnonzeroempid($id);
	updateProflicMatchesJP($id);
	updateGeoMatchesJPnonzeroempid($id);
	updateVehiclesMatchesJP($id);

	
/*****	
	echo "start certs: ". date("h:i:sa").'<br>';
	updateCertMatchesJP($id);
	echo "start naics: ". date("h:i:sa").'<br>';
	updateSkillMatchesJP($id);
	echo "start agency: ". date("h:i:sa").'<br>';
	updateAgencyMatchesJP($id);
	echo "start proflics: ". date("h:i:sa").'<br>';
	updateProflicMatchesJP($id);
	echo "start geos: ". date("h:i:sa").'<br>';
	updateGeoMatchesJP($id);
	echo "start vehicles: ". date("h:i:sa").'<br>';
	updateVehiclesMatchesJP($id);
	echo "end matches: ". date("h:i:sa").'<br>';
//**/

	
	// pull matches again
	$qret=" SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) 
	AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC";
	
	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) 
	AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC");	
	//"' and S.sysmat_usr_id <> '".$userID.
}  //na

function getTimes() {
	return Q2T("SELECT catava_id AS 'id', catava_label AS 'label' FROM cat_avail");
}

function getIndust() {
	return Q2T("SELECT 0 as 'id', '-Select an Industry-' as 'label' UNION SELECT catind_id AS 'id', catind_label AS 'label' FROM cat_ind");
}

function getVehicles($id) {
	return Q2T("SELECT S.*, C.* FROM job_vehicles S LEFT JOIN cat_vehicles C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}


/***** Get Criteria Count *****/

function getFunctions_cnt($id) { 
	return QV("SELECT count(*) as rec_cnt FROM job_func F LEFT JOIN cat_func C ON C.catfnc_id= F.jobfnc_fnc_id WHERE F.jobfnc_job_id = '".$id."' "); 
}  //na

function getCertifications_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_certs E LEFT JOIN cat_certs C ON C.catcrt_id = E.jobcrt_crt_id WHERE E.jobcrt_job_id = '".$id."' ");
}  //na


function getSkills_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_skills S LEFT JOIN cat_skills C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
} //na

function getAgencies_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_agencies S LEFT JOIN cat_agencies C ON C.catagen_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}  //na

function getProflics_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_proflics S LEFT JOIN cat_proflics C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
} //na

function getGeos_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_geos S LEFT JOIN cat_geos C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}

function getExperience_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_exp E LEFT JOIN cat_exp C ON C.catexp_id = E.jobexp_exp_id WHERE E.jobexp_job_id = '".$id."' ");
}  //na


function getVehicles_cnt($id) {
	return QV("SELECT count(*) as rec_cnt FROM job_vehicles S LEFT JOIN cat_vehicles C ON C.catskl_id = S.jobskl_skl_id WHERE S.jobskl_job_id = '".$id."' ");
}



/*****************************/



/*
function updateCertMatchesJP($jobID) {
	global $userID;
	$vc = QV("select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userID."')");
	
	if ($vc <> 1) {
		
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "select group_concat(C.jobcrt_crt_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' from job_certs C
	LEFT JOIN job J ON J.job_id = C.jobcrt_job_id LEFT JOIN cat_clearance L ON ON J.job_clearance = L.catclr_rank 
	WHERE C.jobcrt_crt_id > 0 AND C.jobcrt_job_id = '".$jobID."' GROUP BY C.jobcrt_job_id";
	$certReqs = Q2R($q);

	$buffer = '';
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.print_r($certReqs,true); //$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
	
	
	$SEL_EITHER = 0;
	$edu_logic = "=";
	
	if ($certReqs['edu'] == $SEL_EITHER)
		$edu_logic = ">=";
	
	
	// update existing matches
	//	AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$xq = "SELECT C.usrcrt_usr_id as 'usr', count(C.usrcrt_crt_id) as 'certs', S.sysmat_id as 'matchID' FROM usr_certs C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrcrt_usr_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_edu_level ".$edu_logic." '".$certReqs['edu']."'
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id";

	// insert new matches
	// AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$iq = "SELECT C.usrcrt_usr_id as 'usr', count(C.usrcrt_crt_id) as 'certs' FROM usr_certs C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0
	AND C.usrcrt_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id=C.usrcrt_usr_id)
	AND A.usrapp_edu_level ".$edu_logic." '".$certReqs['edu']."'	
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id";

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($certReqs?$xq . '<hr/>'.$iq.'<hr/>':"");
	$updateMatches = Q2T($xq);
	$newMatches = Q2T($iq);

	if ($updateMatches) foreach ($updateMatches as $matchRow) {
		$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
		if (isset($_REQUEST['jobMatches'])) $buffer .= 'new'.print_r($matchRow,true).$q; 
		$did = Q($q);
	}
	if ($newMatches) foreach ($newMatches as $matchRow) {
		$q = "INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
		if (isset($_REQUEST['jobMatches'])) $buffer .= 'upd'.print_r($matchRow,true).$q;
		$did = Q($q);
	}
	}
	deleteOldMatches();
	return $buffer;
}

function updateSkillMatchesJP($jobID) {
	global $userID;
	$vc = QV("select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userID."')");
	
	
	//echo "select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userID."')<br><br>";
	//echo 'VC = '.$vc;
	//exit();
	
	if ($vc <> 1) {
	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_skills C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);
	
	

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
	$SEL_EITHER = 0;
	$edu_logic = "=";
	
	if ($skillReqs['edu'] == $SEL_EITHER)
		$edu_logic = ">=";			

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM usr_skills C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills' FROM usr_skills C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."'  
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//echo '[q][ '.$q.' ]<br><br>';
	//echo '[xq][ '.$xq.' ]<br><br>';
	//echo '[iq][ '.$iq.' ]<br><br>';
	//exit();
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	}
	deleteOldMatches();
	return $buffer;
}

function updateAgencyMatchesJP($jobID) {
	global $userID;
	$vc = QV("select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userID."')");
	
	if ($vc <> 1) {	
	
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_agencies C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	$SEL_EITHER = 0;
	$edu_logic = "=";
	
	if ($skillReqs['edu'] == $SEL_EITHER)
		$edu_logic = ">=";
	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usragen_usr_id as 'usr', count(C.usragen_skl_id) as 'agencies', S.sysmat_id as 'matchID' FROM usr_agencies C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usragen_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id";

	// 	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
	
		$iq = "SELECT C.usragen_usr_id as 'usr', count(C.usragen_skl_id) as 'agencies' FROM usr_agencies C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND C.usragen_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usragen_usr_id)
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id";

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['agencies']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['agencies']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	}
	deleteOldMatches();
	return $buffer;
}

function updateProflicMatchesJP($jobID) {
	global $userID;
	$vc = QV("select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userID."')");
	
	if ($vc <> 1) {
		
	Q("UPDATE sys_match SET sysmat_proflics='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_proflics C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	$SEL_EITHER = 0;
	$edu_logic = "=";
	
	if ($skillReqs['edu'] == $SEL_EITHER)
		$edu_logic = ">=";		
		
		
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'proflics', S.sysmat_id as 'matchID' FROM usr_proflics C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'proflics' FROM usr_proflics C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_proflics = '".$matchRow['proflics']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 		
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_proflics, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['proflics']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	}
	deleteOldMatches();
	return $buffer;
}

function updateGeoMatchesJP($jobID) {
	global $userID;
	$vc = QV("select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userID."')");

	if ($vc <> 1) {
		
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_geos C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	$SEL_EITHER = 0;
	$edu_logic = "=";
	
	if ($skillReqs['edu'] == $SEL_EITHER)
		$edu_logic = ">=";	
		//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'geos', S.sysmat_id as 'matchID' FROM usr_geos C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'geos' FROM usr_geos C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['geos']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['geos']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	}
	deleteOldMatches();
	return $buffer;
}

function updateVehiclesMatchesJP($jobID) {
	global $userID;
	$vc = QV("select count(*) as valuecheck from job where job_id = '".$jobID."' and job_emp_id IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userID."')");
	
	if ($vc <> 1) {
		
	Q("UPDATE sys_match SET sysmat_vehicles='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_vehicles C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	$SEL_EITHER = 0;
	$edu_logic = "=";
	
	if ($skillReqs['edu'] == $SEL_EITHER)
		$edu_logic = ">=";		
		
		
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'vehicles', S.sysmat_id as 'matchID' FROM usr_vehicles C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'vehicles' FROM usr_vehicles C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_edu_level ".$edu_logic." '".$skillReqs['edu']."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_vehicles = '".$matchRow['vehicles']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 		
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_vehicles, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['vehicles']."','".date("Y-m-d H:i:s")."','1')");
		}
	}
	}
	deleteOldMatches();
	return $buffer;
}		



function updateFunctionMatchesJP($jobID) {
	Q("UPDATE sys_match SET sysmat_functions='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobfnc_fnc_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_func C 
	LEFT JOIN job J ON J.job_id = C.jobfnc_job_id LEFT JOIN cat_clearance L ON L.catclr_id = J.job_clearance
	WHERE C.jobfnc_fnc_id > 0 AND C.jobfnc_job_id = '" . $jobID . "' GROUP BY C.jobfnc_job_id";
	$funcReqs = Q2R($q);
	
	$buffer = ''; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($funcReqs?'<br/>'.print_r($funcReqs,true):'<br/>No Data.').'<hr/>';
	//	AND A.usrapp_ava_id = '".$funcReqs['ava']."'
	$xq = "SELECT E.usrexp_usr_id as 'usr', count(F.usrexpfnc_fnc_id) as 'funcs', S.sysmat_id as 'matchID' FROM usr_exp_func F 
	LEFT JOIN usr_exp E ON F.usrexpfnc_usrexp_id = E.usrexp_id
	LEFT JOIN sys_match S ON S.sysmat_usr_id = E.usrexp_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = E.usrexp_usr_id
	WHERE F.usrexpfnc_fnc_id IN (".$funcReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_edu_level >= '".$funcReqs['edu']."' 
	AND A.usrapp_clearance >= '".$funcReqs['clr']."'
	GROUP BY E.usrexp_usr_id";

	//	AND A.usrapp_ava_id = '".$funcReqs['ava']."'
	$iq = "SELECT E.usrexp_usr_id as 'usr', count(F.usrexpfnc_fnc_id) as 'funcs' FROM usr_exp_func F 
	LEFT JOIN usr_exp E ON F.usrexpfnc_usrexp_id = E.usrexp_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = E.usrexp_usr_id

	WHERE F.usrexpfnc_fnc_id IN (".$funcReqs['x'].")
	AND E.usrexp_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = E.usrexp_usr_id)
	AND A.usrapp_edu_level >= '".$funcReqs['edu']."' 
	AND A.usrapp_clearance >= '".$funcReqs['clr']."'
	GROUP BY E.usrexp_usr_id";
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($funcReqs?$xq . '<hr/>' . $iq . '<hr/>':'');
	$updateMatches = Q2T($xq);
	$newMatches = Q2T($iq);

	if ($updateMatches) foreach ($updateMatches as $matchRow) {
		if (isset($_REQUEST['jobMatches'])) $buffer .= print_r($matchRow,true); 
		$did = Q("UPDATE sys_match SET sysmat_functions = '".$matchRow['funcs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
	}
	if ($newMatches) foreach ($newMatches as $matchRow) {
		if (isset($_REQUEST['jobMatches'])) $buffer .= print_r($matchRow,true); 
		$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_functions, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['funcs']."','".date("Y-m-d H:i:s")."','1')");
	}
	deleteOldMatches();
	return $buffer;

}

function deleteOldMatches(){
	Q("DELETE FROM sys_match WHERE (sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
}
*/