<?php

function LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$year,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file,$geo,$poc)

{
   global $ROWBYROW,$from_file ; 
   global $emp_added_cnt,  $emp_updated_cnt,  $usr_added_cnt,  $usr_updated_cnt,  $usremp_added_cnt; 
   global       $usremp_updated_cnt,  $usr_edu_added_cnt,  $usr_edu_updated_cnt, $usr_clearance_added_cnt; 
    global      $usr_clearance_updated_cnt,  $usr_app_added_cnt, $usr_app_updated_cnt, $job_added_cnt;
    global      $job_updated_cnt, $job_skills_added_cnt, $job_skill_updated_cnt, $job_certs_added_cnt; 
    global      $job_certs_updated_cnt,  $job_agencies_added_cnt,   $job_agencies_updated_cnt;


        $thisemp_id = 0;
          $thisemp_id  = QV($chkdupeSQL);
       if ($thisemp_id > 0)  
        {
            
            

         
         $updateSQL= "UPDATE emp".$ROWBYROW . " SET emp_email='" .$newfed_email."',emp_name ='". $newfed_company."',emp_contact='".$contact."',emp_contact_email='". $email."',emp_update_date=CURRENT_TIMESTAMP() 
         ,update_FBO_Feed = '".$from_file."'      where emp_id = ".$thisemp_id  . "" ;
            // 	echo "<br><br> line 148 emp  updateSQL: " .$updateSQL ;
           $empupdate = QU($updateSQL) ; // returns 
           $emp_updated_cnt = $emp_updated_cnt + 1;
           
           	 $insertedemp = 0;
       	   $updatedemp = 1;
            ////   
          } else
           { 

               $thisemp_id = 0;

   $insertSQL="INSERT INTO emp".$ROWBYROW."(fed_id, emp_name,emp_contact,emp_email,emp_contact_email,emp_insert_date,insert_FBO_Feed)
                  VALUES($newfed_id,'".$newfed_company."','".$contact."','".$newfed_email."','". $email."',CURRENT_TIMESTAMP(),'".$from_file."'  )";  

       	    $thisemp_id = QI($insertSQL);
       	   
       	   $insertedemp = 1;
       	   $updatedemp = 0;
       	   $emp_added_cnt = $emp_added_cnt + 1;

         }   
         

      $thisusr_password = '7110eda4d09e062aa5e4a390b0a572ac0d2c0220';

        $chkdupeSQL =  "SELECT usr_id FROM usr".$ROWBYROW . " where usr_fullname like '".$newfed_company . "' "; 


         $thisusr_id = 0;
		$thisusr_id = QV($chkdupeSQL);

        if ($thisusr_id > 0)    // if fed-usr already there update it
          {    
   
           $updateSQL="UPDATE usr".$ROWBYROW. " SET usr_email='".$newfed_email."',usr_contact_email='".$email."',usr_firstname='FBO',usr_lastname='".$agency."',
           usr_fullname= '".$newfed_company."',usr_company=".$thisemp_id . ",usr_contact='".$contact."',usr_update_date=CURRENT_TIMESTAMP()
            ,update_FBO_Feed = '".$from_file."'  where usr_id = ".$thisusr_id . " "   ;
          $usrupdate = QU($updateSQL) ; 
          	 $insertedusr = 0;
       	   $updatedusr = 1;
       	    $usr_updated_cnt =  $usr_updated_cnt + 1;
           } else
           {
		   $thisusr_id = 0;
$insertSQL="INSERT INTO usr".$ROWBYROW."(fed_id, usr_email,usr_contact_email, usr_firstname, usr_lastname, usr_fullname, usr_password, usr_auth, usr_company,usr_contact, usr_type,usr_insert_date,insert_FBO_Feed)
	          VALUES(".$newfed_id.",'".$newfed_email."','".$email."','FBO','".$agency."','".$newfed_company."','".$thisusr_password."','2',".$thisemp_id.",'".$contact."','0',CURRENT_TIMESTAMP(),'".$from_file."')";

	   $thisusr_id = QI($insertSQL);
	       $usr_added_cnt = $usr_added_cnt + 1;
	      
	    $insertedusr = 1;
       	   $updatedusr = 0;

         }   

       $chkdupeSQL =  "SELECT usremp_id FROM usr_emp".$ROWBYROW. " where usremp_usr_id =" .  $thisusr_id. " and usremp_emp_id = ".$thisemp_id . ""; 

         $thisusremp_id = 0;
		$thisusremp_id = QV($chkdupeSQL);

        if ($thisusremp_id > 0)    // if  usremp  already no need to update it
          {    
		    	        
           $usremp_updated_cnt = $usremp_updated_cnt;

          }
         else 
          {     
            $thisusremp_id = 0;
 	$query = "INSERT INTO usr_emp".$ROWBYROW." (usremp_usr_id, usremp_emp_id, usremp_auth, usremp_type,usremp_usr_assignedusr_id,usremp_insert_date,insert_FBO_Feed )
 	                                    VALUES (". $thisusr_id.", ".$thisemp_id.",'*','0',".$thisusr_id.",CURRENT_TIMESTAMP(),'".$from_file."')"; 
 	                                   
 	       $thisusremp_id = QI($query);
 	           $usremp_added_cnt =  $usremp_added_cnt+1; 
 	           
 	           
 	           //echo "DELETE FROM usr_emp_registration WHERE usr_id = '".$thisusr_id."' and emp_id = '".$thisemp_id."'<br>\r\n";
         
    }  

    
   if ( $updatedusr == 1  )
    {
        $usr_clearance_updated_cnt = $usr_clearance_updated_cnt;
    }
    else 
    {    
	$query = "insert into usr_clearance".$ROWBYROW." (usrclr_usr_id, usrclr_clr_id, usrclr_title,usrclr_insert_date,insert_FBO_Feed)  
	VALUES(".$thisusr_id.",'4','None',CURRENT_TIMESTAMP(),'".$from_file."')";
	  $thisusrclr_id  = QI($query);
	   $usr_clearance_added_cnt =  $usr_clearance_added_cnt+1;

    }

    if ( $updatedusr == 1  )
    { //  
        //usr was updated No Update to usr_edu needed nothing will have changed:  
        $usr_edu_updated_cnt = $usr_edu_updated_cnt;
    }
    else 
    
    {     
	$query = "INSERT into usr_edu".$ROWBYROW." (usredu_usr_id, usredu_edu_id,usredu_insert_date,insert_FBO_Feed) VALUES(".$thisusr_id.",'1',CURRENT_TIMESTAMP(),'".$from_file."')";  	
     $thisusredu_id  = QI($query);
        $usr_edu_added_cnt=$usr_edu_added_cnt+1;

    }


	 if ( $updatedusr == 1  )
    {

        $usr_app_updated_cnt=$usr_app_updated_cnt;
    }
    else 
    {     
     $query = "insert into usr_app".$ROWBYROW." (usrapp_usr_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance,usrapp_insert_date,insert_FBO_Feed)
     VALUES(". $thisusr_id.",'1','0','1','0',CURRENT_TIMESTAMP(),'".$from_file."' )";
     
	$thisusrapp_id  = QI($query);
	   $usr_app_added_cnt=$usr_app_added_cnt+1;

    }

    
     $chkdupeSQL =  "SELECT job_id FROM job".$ROWBYROW . " where job_solicitation like '".$solnbr."' "; 

         $thisjob_id = 0;
		$thisjob_id = QV($chkdupeSQL);

        if ($thisjob_id > 0)   
          {    
		   $updateSQL="UPDATE job".$ROWBYROW." SET fed_id=".$newfed_id.",job_contact='".$contact."' ,job_email_address='".$newfed_email."',job_contact_email='".$email."',
             job_buying_office='".$agency."',job_title='".$subject."',job_details='".$subject."',job_solicitation='".$solnbr."',
             job_due_date=STR_TO_DATE('".$respdate."','%m-%d-%y'),job_solicitation_link='".$url."', job_update_date=CURRENT_TIMESTAMP()
              ,update_FBO_Feed = '".$from_file."'  WHERE job_id=".$thisjob_id."";


          $jobupdate = QU($updateSQL) ;
          $job_updated_cnt=$job_updated_cnt+1;
          	 $insertedjob = 0;
       	   $updatedjob = 1;

           } else
           {
		     $thisjob_id = 0;
		     $insertedjob = 1;
       	   $updatedjob = 0;
       	   
       	   
       	   
$insertSQL=  "INSERT into job".$ROWBYROW."
                       (fed_id,job_contact, job_email_address,job_contact_email, job_buying_office, job_title, job_details, job_solicitation, job_due_date, job_solicitation_link
                            , job_ava_id, job_clearance, job_edu_level, job_status,job_created_by, job_emp_id,job_insert_date,insert_FBO_Feed) 
         VALUES(".$newfed_id.",'".$contact."','".$newfed_email."','".$email."','".$agency."','".$subject."','".$subject."','".$solnbr."',STR_TO_DATE('".$respdate."','%m-%d-%y'),'".$url."'
                        	, '0','0','0','1','FBO',"." $thisusr_id ". ",CURRENT_TIMESTAMP(),'".$from_file."')";
                        	
     $thisjob_id = QI($insertSQL);
     if ($thisjob_id)
        {$job_added_cnt=$job_added_cnt+1;}
      
         }   

	   if ($updatedjob==1) 
	      {    
  $updateSQL="UPDATE job_skills".$ROWBYROW." SET jobskl_skl_id=".$naics_id.",jobskl_desc=".$naics_desc.",jobskl_update_date=CURRENT_TIMESTAMP()
                ,update_FBO_Feed = '".$from_file."'  WHERE jobskl_job_id=".$thisjob_id."";
             $jobskillupdate = QU($updateSQL) ; //
          	 $insertedjob_skills = 0;
       	      $updatedjob_skills = 1;
       	      $job_skill_updated_cnt=$job_skill_updated_cnt +1;

	      } else
	      {
	        if ($thisjob_id)
	          {	 $insertedjob_skills = 1;
       	      $updatedjob_skills = 0;
	   	$insertSQL = "insert into job_skills".$ROWBYROW." (jobskl_job_id     , jobskl_skl_id,     jobskl_desc, jobskl_status,jobskl_insert_date,insert_FBO_Feed) 
	                                                             VALUES(".$thisjob_id.",".$naics_id.",".$naics_desc.",'1',CURRENT_TIMESTAMP(),'".$from_file."')";
     	$thisjobskl_id = QI($insertSQL);
     	  $job_skills_added_cnt =  $job_skills_added_cnt + 1;  
	          }
	      }

	   if ($updatedjob==1) 
	      {    ////update job_skill
	  $updateSQL="UPDATE job_agencies".$ROWBYROW." SET jobskl_skl_id=".$ageny_id.",jobskl_desc=".$agency_desc.",jobagencies_update_date=CURRENT_TIMESTAMP() 
	      ,update_FBO_Feed = '".$from_file."'   WHERE jobskl_job_id=".$thisjob_id."";
             $jobagenciesupdate = QU($updateSQL) ; 
          	 $insertedjob_agencies = 0;
       	      $updatedjob_agencies = 1;
       	      $job_agencies_updated_cnt=$job_agencies_updated_cnt+1;
	      } else
	      {
	       if ($thisjob_id)
	      { $insertedjob_agencies = 1;
       	      $updatedjob_agencies = 0;
	   	$insertSQL = "insert into job_agencies".$ROWBYROW."  (jobskl_job_id, jobskl_skl_id, jobskl_desc,jobagencies_insert_date,insert_FBO_Feed) 
	   	                                   VALUES (" .$thisjob_id.",".$ageny_id.",".$agency_desc.",CURRENT_TIMESTAMP(),'".$from_file."')";

          $thisjobagencies_id_ = QI($insertSQL);
           $job_agencies_added_cnt =  $job_agencies_added_cnt+1;
	      } 
 
         }   
 

	   if ($updatedjob==1) 
	      {    ////update job_skill
	  $updateSQL="UPDATE job_certs".$ROWBYROW." SET jobcrt_crt_id=".$bc2_cert_id.",jobcrt_desc='".$bc2_cert_desc."',jobcrt_update_date=CURRENT_TIMESTAMP()
	              ,update_FBO_Feed = '".$from_file."'   WHERE jobcrt_job_id=".$thisjob_id.""; 
               $jobscertsupdate = QU($updateSQL) ; //
              
          $job_certs_updated_cnt=  $job_certs_updated_cnt + 1;  
          	 $insertedjob_certs = 0;
       	      $updatedjob_certs = 1;
 	      } else
	      {// insert job skill
	         if ($thisjob_id)
	      {
	   	$insertSQL = "insert into job_certs".$ROWBYROW."   	 (jobcrt_job_id, jobcrt_crt_id, jobcrt_desc,jobcrt_insert_date,insert_FBO_Feed) 
	   	               VALUES (" .$thisjob_id.",".$bc2_cert_id.",'".$bc2_cert_desc."',CURRENT_TIMESTAMP(),'".$from_file."')";

          $thisjobcrt_id = QI($insertSQL);
           $job_certs_added_cnt= $job_certs_added_cnt+1; 
	      }
         }   
         
         
         //UPDATE `job_geos` SET `jobskl_id`=[value-1],`jobskl_job_id`=[value-2],`jobskl_skl_id`=[value-3],`jobskl_desc`=[value-4],`jobskl_reqplus`=[value-5] WHERE 1
         
         
 	$query = "update FBO_IMPORT".$ROWBYROW." set fbo_file_processed = 1 where fed_id = ".$newfed_id . " "; 
	mysql_query($query);

	$query = "update usr".$ROWBYROW." set fbo_file_processed = 1 where usr_id =" . $thisusr_id . "";  
	mysql_query($query);

  /*******  ADD CODE TO DELETE JOB CERT = 53 and usr_emp_registration false entries *******/
  
  $rem53 =  Q("DELETE FROM job_certs WHERE jobcrt_crt_id = 53");
  
  $remFalse = Q("DELETE FROM usr_emp_registration WHERE usr_id in (SELECT usr_id FROM usr WHERE usr_firstname = 'FBO')");
  
  /************************************************/
    
}

	// debugging
function debug($debugdata) {
//	try { @$_SESSION['debugDATA'] .= $debugdata; }
//	catch (Exception $dx) { $_SESSION['debugDATA'] = $debugdata; }
}

	// database / queries
function Q($query){ // Global query (result = mysql_result OR false if (0 rows OR error))
	global $reqDebug;
	$q = mysql_query($query) or debug(mysql_error()." in QUERY=".$query."<br/>");
	if ($q) {
		try { if (@mysql_num_rows($q) == 0) $q = false; }
		catch (Exception $exc) { 
			debug("Failed.  Exception: ".$exc." in QUERY=".$query."<br/>");
			try { 

			} catch (Execption $exxc) { debug("Could not record in error log!<br/>"); }
		}
	} else debug("Failed query =".$query."<br/>");
	return $q;
}

function QV($query) { // Query get single value or NULL
	global $reqDebug;
	$qv = Q($query);
	if ($qv) {
		if (mysql_num_rows($qv)>0) {
			$datrow = mysql_fetch_row($qv);
			debug('Fetched Row Value:'.$datrow[0].'<br/>');
			return $datrow[0];
		} else return null;
	} else return null;
}

function Q2R($queryObject) { // Query string or object to row (array) or false
	global $reqDebug;
	if (gettype($queryObject)=="resource" && $queryObject != false) return mysql_fetch_assoc($queryObject);
	else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		if ($realQueryObject) return mysql_fetch_assoc($realQueryObject);
		else return false;
	}
}

function Q2T($queryObject) { // Query string or object to table (array of array) or false
	$dataOut = array();
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		while ($datRow = mysql_fetch_assoc($queryObject)) array_push($dataOut, $datRow);
		return $dataOut;
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		if ($realQueryObject) {
			while ($datRow = mysql_fetch_assoc($realQueryObject)) array_push($dataOut, $datRow);
			return $dataOut;
		}
		else return false;
	}
}

function QI($queryString) {
	global $reqDebug;
	$qO = mysql_query($queryString);
	if ( $qO != false ) return mysql_insert_id();
	else return false;
}

function QU($queryObject) {
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		return mysql_affected_rows();
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		return mysql_affected_rows();
	}
	return false;
}


// Database
//DEMO
/*
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";
*/

//DEV
/*
$server="localhost";
$db="cccsol81_bc2dev";
$user="cccsol81_bc2dev";
$password="bc2dev.ccc818";
*/

//bc2prod
/**/
$server="localhost";
$db="cccsol81_bc2prod";
$user="cccsol81_bc2prod";
$password="bc2prod.ccc818";



mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
mysql_select_db($db) or die('Could not select the specified database.');


foreach($search_res as $res) {

		if (is_int($rcnt/2))
			$cellbgcolor = "#FFFFFF";
		else
			$cellbgcolor = "#E8E8E8";
		
		
		$dashboard = '[<a href="bc2members.php?usr='.$res['usr_id'].
		
}
?>



