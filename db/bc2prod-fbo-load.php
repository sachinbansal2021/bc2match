<?php

    require '/home/cccsol818/public_html/phpMailer/class.phpmailer.php';
    require '/home/cccsol818/public_html/phpMailer/class.smtp.php';
	
function sendmail($subject = null, $body = null, $to = null){
	$mail = new PHPMailer;
	$mail->setFrom('larryf@bc2match.com');
	$mail->addAddress($to);
    	$mail->isHTML(true); 
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->IsSMTP();
	$mail->SMTPSecure = 'starttls';
	$mail->Host = 'tls://smtp.office365.com';
	$mail->SMTPAuth = true;
	$mail->Port = 587;

	//Set your existing gmail address as user name
	$mail->Username = 'larryf@bc2match.com';
	//Set the password of your gmail address here
	$mail->Password = 'bc2Franklin';
	if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	  echo '<br/>';
	} else { echo $to; echo '<br/>';
	  echo 'Email has been sent.';
	  echo '<br/>';
	}https://www.google.com/aclk?sa=l&ai=DChcSEwjX-r_ew-_tAhUB47MKHXYTBWcYABAPGgJxbg&sig=AOD64_1Q-fou0N3qBZ3N1za9XTh3Q4X0PQ&adurl=&ctype=5&q=&nb=9&rurl=https%3A%2F%2Fwww.bestbuy.com%2F&nm=69&nx=73&ny=78&is=1500x415	
}	

function SaveLine ($field, $line, $tlen, $same)
{
	$llen = strlen($line);
	
	if ($same == 0)
	{
		//echo "[".substr($line,$tlen,$llen-$tlen-1)."][".$llen."]<br>";
		$datafield = substr($line,$tlen,$llen-$tlen-1);
	}
	else
	{
		//echo "[".substr($line,0,$llen-1)."][".$llen."]---ELSE Section<br>";
		$datafield = $field." ".substr($line,0,$llen-7);
	}
	
	return $datafield;	
}	



function MapCerts ($setaside, $agency)
{
    global $conn;
//** Assign to this category if <SETASIDE>= 'Service-Disabled Veteran-Owned Small Business' AND <AGENCY>='Department of Veterans Affairs"
//* Assign to this category if <SETASIDE>= 'Veteran-Owned Small Business' AND <AGENCY>='Department of Veterans Affairs"

	switch ($setaside)
	{
		case "Economically Disadvantaged Woman Owned Small Business":
			$cert = "Economically-disadvantaged woman-owned small business -EDWOSB";
			break;

		case "Indian Economic Enterprises":
			$cert = "Indian Economic Enterprises";
			break;

		case "Indian Small Business Economic Enterprises":
			$cert = "Indian Small Business Economic Enterprises";
			break;

		case "N/A":
			$cert = "NONE";
			break;

		case "Partial Small Business":
			$cert = "NONE";
			break;

		case "Competitive 8(a)":
			$cert = "SBA-certified 8(a) small business";
			break;
		
		case "8(a)":
			$cert = "SBA-certified 8(a) small business";
			break;		

		case "HUBZone":
			$cert = "SBA-certified HUBZone small business";
			break;
        
		case "Service-Disabled Veteran-Owned Small Business (SDVOSB)":
			//** Assign to this category if <SETASIDE>= 'Service-Disabled Veteran-Owned Small Business' AND <AGENCY>='Department of Veterans Affairs"
			
			if ($agency == "Department of Veterans Affairs")
				$cert = "CVE-certified service-disabled veteran-owned small business -SDVOSB";
			else
				$cert = "Self -certified service-disabled veteran-owned small business -SDVOSB";
			
			break;
			
		case "Service-Disabled Veteran-Owned Small Business":
			//** Assign to this category if <SETASIDE>= 'Service-Disabled Veteran-Owned Small Business' AND <AGENCY>='Department of Veterans Affairs"
			
			if ($agency == "Department of Veterans Affairs")
				$cert = "CVE-certified service-disabled veteran-owned small business -SDVOSB";
			else
				$cert = "Self -certified service-disabled veteran-owned small business -SDVOSB";
			
			break;

		case "Veteran-Owned Small Business (VOSB)":
		    //* Assign to this category if <SETASIDE>= 'Veteran-Owned Small Business' AND <AGENCY>='Department of Veterans Affairs"
			
			if ($agency == "Department of Veterans Affairs")
				$cert = "CVE-certified veteran-owned small business -VOSB";
			else
				$cert = "Self-certified veteran-owned small business -VOSB";	

			break;			

		case "Veteran-Owned Small Business":
		    //* Assign to this category if <SETASIDE>= 'Veteran-Owned Small Business' AND <AGENCY>='Department of Veterans Affairs"
			
			if ($agency == "Department of Veterans Affairs")
				$cert = "CVE-certified veteran-owned small business -VOSB";
			else
				$cert = "Self-certified veteran-owned small business -VOSB";	

			break;

		case "Total Small Business":
			$cert = "Small business";
			break;

		case "Emerging Small Business":
			$cert = "Small business";
			break;

		case "Very Small Business":
			$cert = "Small business";
			break;

		case "Woman Owned Small Business (WOSB)":
			$cert = "Woman-owned small business (WOSB)";
			break;
			
		case "Woman Owned Small Business":
			$cert = "Woman-owned small business (WOSB)";
			break;
			
		default:
			$cert = "NONE";
			break;


	}
	
	return $cert;


}

function LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$pyear,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file,$geo,$poc,$notice_id)

{
    global $conn;
    
   global $ROWBYROW,$from_file ; 
   global $emp_added_cnt,  $emp_updated_cnt,  $usr_added_cnt,  $usr_updated_cnt,  $usremp_added_cnt; 
   global       $usremp_updated_cnt,  $usr_edu_added_cnt,  $usr_edu_updated_cnt, $usr_clearance_added_cnt; 
    global      $usr_clearance_updated_cnt,  $usr_app_added_cnt, $usr_app_updated_cnt, $job_added_cnt;
    global      $job_updated_cnt, $job_skills_added_cnt, $job_skill_updated_cnt, $job_certs_added_cnt; 
    global      $job_certs_updated_cnt,  $job_agencies_added_cnt,   $job_agencies_updated_cnt;
    global      $job_error_cnt;
    global      $exceptions;


/*        $thisemp_id = 0;
        echo ("(".$chkdupeSQL.")");
        $chkdupeSQL = "test";
        
          $thisemp_id  = QV($chkdupeSQL);
*/          



       if ($thisemp_id > 0)  
        {
            
            

         
         $updateSQL= "UPDATE emp".$ROWBYROW . " SET emp_email='" .$newfed_email."',emp_name ='". $newfed_company."',emp_contact='".$contact."',emp_contact_email='". $email."',emp_update_date=CURRENT_TIMESTAMP() 
         ,update_FBO_Feed = '".$from_file."'      where emp_id = ".$thisemp_id  . "" ;
            // 	echo "<br><br> line 148 emp  updateSQL: " .$updateSQL ;
           //$empupdate = QU($updateSQL) ;
           mysqli_query($conn, $updateSQL); // returns 
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
          //$usrupdate = QU($updateSQL) ; 
          mysqli_query($conn, $updateSQL);
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
     
    
        if($respdate  == "--")
        {
            $respdate_duedate = "CURRENT_TIMESTAMP()";
        }
        else
        {
            //07-23-2019
            $duedate_m = substr($respdate,0,2);
            $duedate_d = substr($respdate,3,2);
            $duedate_y = substr($respdate,6,4);
            
            $respdate_duedate = "STR_TO_DATE('".$duedate_y.",".$duedate_m.",".$duedate_d."','%Y,%m,%d')";
        } 
        
        
        //$respdate_duedate = "STR_TO_DATE('".$respdate."','%m-%d-%y')";
     


         $thisjob_id = 0;
		$thisjob_id = QV($chkdupeSQL);

        if ($thisjob_id > 0)   
          {    

/**
		   $updateSQL="UPDATE job".$ROWBYROW." SET fed_id=".$newfed_id.",job_contact='".$contact."' ,job_email_address='".$newfed_email."',job_contact_email='".$email."',
             job_buying_office='".$agency."',job_title='".$subject."',job_details='".$subject."',job_solicitation='".$solnbr."',
             job_due_date=".$respdate_duedate.",job_solicitation_link='".$url."', job_update_date=CURRENT_TIMESTAMP()
              ,update_FBO_Feed = '".$from_file."'  WHERE job_id=".$thisjob_id."";
 **/
 
           $updateSQL='UPDATE job'.$ROWBYROW.' SET fed_id='.$newfed_id.',job_contact="'.$contact.'" ,job_email_address="'.$newfed_email.'",job_contact_email="'.$email.'",
             job_buying_office="'.$agency.'",job_title="'.$subject.'",job_details="'.$subject.'",job_solicitation="'.$solnbr.'",
             job_due_date='.$respdate_duedate.',job_solicitation_link="'.$url.'", job_update_date=CURRENT_TIMESTAMP()
              ,update_FBO_Feed = "'.$from_file.'"  WHERE job_id='.$thisjob_id.'';

            //echo "UPDATE|".$updateSQL."|".$solnbr."|".$notice_id."<br><br>";
            //echo "UPDATE|".$solnbr."|".$notice_id."<br><br>";

          //$jobupdate = QU($updateSQL) ;
          mysqli_query($conn, $updateSQL);
          $job_updated_cnt=$job_updated_cnt+1;
          	 $insertedjob = 0;
       	   $updatedjob = 1;
       	   
       	   
       	   

           } else
           {
		     $thisjob_id = 0;
		     $insertedjob = 1;
       	   $updatedjob = 0;
       	   
       	   
       	   
/**
$insertSQL=  "INSERT into job".$ROWBYROW."
                       (fed_id,job_contact, job_email_address,job_contact_email, job_buying_office, job_title, job_details, job_solicitation, job_due_date, job_solicitation_link
                            , job_ava_id, job_clearance, job_edu_level, job_status,job_created_by, job_emp_id,job_insert_date,insert_FBO_Feed) 
         VALUES(".$newfed_id.",'".$contact."','".$newfed_email."','".$email."','".$agency."','".$subject."','".$subject."','".$solnbr."',".$respdate_duedate.",'".$url."'
                        	, '0','0','0','1','FBO',"." $thisusr_id ". ",CURRENT_TIMESTAMP(),'".$from_file."')";

**/

$insertSQL=  'INSERT into job'.$ROWBYROW.'
                       (fed_id,job_contact, job_email_address,job_contact_email, job_buying_office, job_title, job_details, job_solicitation, job_due_date, job_solicitation_link
                            , job_ava_id, job_clearance, job_edu_level, job_status,job_created_by, job_emp_id,job_insert_date,insert_FBO_Feed) 
         VALUES('.$newfed_id.',"'.$contact.'","'.$newfed_email.'","'.$email.'","'.$agency.'","'.$subject.'","'.$subject.'","'.$solnbr.'",'.$respdate_duedate.',"'.$url.'"
                        	, "0","0","0","1","FBO",'.$thisusr_id. ',CURRENT_TIMESTAMP(),"'.$from_file.'")';                        	
 
                        	
     $thisjob_id = QI($insertSQL);
     if (!$thisjob_id)
        {
            $exceptions .= "JOB_ERROR|".$insertSQL."|".$solnbr."|".$notice_id."<br>\r\n<br>\r\n";
            echo "JOB_ERROR|".$insertSQL."|".$solnbr."|".$notice_id."<br><br>";
            //echo "ERROR|".$solnbr."|".$notice_id."<br><br>";
            $job_error_cnt=$job_error_cnt+1;
        }
        else
        {
            $job_added_cnt=$job_added_cnt+1;
            //echo "INSERT|".$insertSQL."|".$solnbr."|".$notice_id."<br><br>";
            //echo "INSERT|".$solnbr."|".$notice_id."<br><br>";
        } 
        

      
    }   

	   if ($updatedjob==1) 
	      {    
  $updateSQL="UPDATE job_skills".$ROWBYROW." SET jobskl_skl_id=".$naics_id.",jobskl_desc='".$naics_desc."',jobskl_update_date=CURRENT_TIMESTAMP()
                ,update_FBO_Feed = '".$from_file."'  WHERE jobskl_job_id=".$thisjob_id."";
             //$jobskillupdate = QU($updateSQL) ; //
             mysqli_query($conn, $updateSQL);
          	 $insertedjob_skills = 0;
       	      $updatedjob_skills = 1;
       	      $job_skill_updated_cnt=$job_skill_updated_cnt +1;

	      } else
	      {
	        if ($thisjob_id)
	          {	 $insertedjob_skills = 1;
       	      $updatedjob_skills = 0;
	   	$insertSQL = "insert into job_skills".$ROWBYROW." (jobskl_job_id     , jobskl_skl_id,     jobskl_desc, jobskl_status,jobskl_insert_date,insert_FBO_Feed) 
	                                                             VALUES(".$thisjob_id.",".$naics_id.",'".$naics_desc."','1',CURRENT_TIMESTAMP(),'".$from_file."')";
     	$thisjobskl_id = QI($insertSQL);
     	  $job_skills_added_cnt =  $job_skills_added_cnt + 1;  
	          }
	      }

	   if ($updatedjob==1) 
	      {    ////update job_skill
	  $updateSQL="UPDATE job_agencies".$ROWBYROW." SET jobskl_skl_id=".$ageny_id.",jobskl_desc=".$agency_desc.",jobagencies_update_date=CURRENT_TIMESTAMP() 
	      ,update_FBO_Feed = '".$from_file."'   WHERE jobskl_job_id=".$thisjob_id."";
             //$jobagenciesupdate = QU($updateSQL) ; 
             mysqli_query($conn, $updateSQL);
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
               //$jobscertsupdate = QU($updateSQL) ; //
               mysqli_query($conn, $updateSQL);
              
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
 	
// 	echo $query." (update query)<br><br><br>"; exit();
 	
//	mysql_query($query);
	mysqli_query($conn, $query);

	$query = "update usr".$ROWBYROW." set fbo_file_processed = 1 where usr_id =" . $thisusr_id . "";  
//	mysql_query($query);
    mysqli_query($conn, $query);

  /*******  ADD CODE TO DELETE JOB CERT = 53 and usr_emp_registration false entries *******/
  
  $rem53 =  Q("DELETE FROM job_certs WHERE jobcrt_crt_id = 53");
  
  $remFalse = Q("DELETE FROM usr_emp_registration WHERE usr_id in (SELECT usr_id FROM usr WHERE usr_firstname = 'FBO')");
  
  /************************************************/
    
}

function Clean($param,$length=false) {     // escapes and optionally trims input
    global $conn;
	if ($length!=false)  return mysql_real_escape_string(substr($param, 0, $length)); 
	else  return mysqli_real_escape_string($conn, $param);        //
 }
 
 function CleanS($param){ // returns first space-delimited word (use with caution - very strict)
	$safe=explode(" ",$param);
	return Clean($safe[0]);
}


function CleanI($param){ // returns cleaned INT value
	return intval(CleanS($param));
}

function CleanJS($param) {
	return htmlspecialchars(addcslashes($param,"\\\'\"&\n\r<>"));
}


	// debugging
function debug($debugdata) {
//	try { @$_SESSION['debugDATA'] .= $debugdata; }
//	catch (Exception $dx) { $_SESSION['debugDATA'] = $debugdata; }
}

	// database / queries
function Q($query){ // Global query (result = mysql_result OR false if (0 rows OR error))
	global $reqDebug;
	global $conn;
	
	if ($query == "test") echo "Empty String: (".$query.")<br>";
	
	$q = mysqli_query($conn, $query) or debug(mysqli_error($conn)." in QUERY=".$query."<br/>");
	if ($q) {
		try { if (@mysqli_num_rows($q) == 0) $q = false; }
		catch (Exception $exc) { 
			debug("Failed.  Exception: ".$exc." in QUERY=".$query."<br/>");
			try { 
//				mysql_query("INSERT INTO Errors (err_session, err_details) VALUES ('".session_id()."','".mysql_real_escape_string($query)."');");
			} catch (Execption $exxc) { debug("Could not record in error log!<br/>"); }
		}
	} else debug("Failed query =".$query."<br/>");
	return $q;
}

function QV($query) { // Query get single value or NULL
	global $reqDebug;
	$qv = Q($query);
	if ($qv) {
		if (mysqli_num_rows($qv)>0) {
			$datrow = mysqli_fetch_row($qv);
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
		if ($realQueryObject) return mysqli_fetch_assoc($realQueryObject);
		else return false;
	}
}

function Q2T($queryObject) { // Query string or object to table (array of array) or false
	$dataOut = array();
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		while ($datRow = mysqli_fetch_assoc($queryObject)) array_push($dataOut, $datRow);
		return $dataOut;
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		if ($realQueryObject) {
			while ($datRow = mysqli_fetch_assoc($realQueryObject)) array_push($dataOut, $datRow);
			//while ($datRow = mysql_unbuffered_query($realQueryObject)) array_push($dataOut, $datRow);
			return $dataOut;
		}
		else return false;
	}
}

function QI($queryString) { // Insert and safely return id or false
	global $reqDebug;
	global $conn;
	$qO = mysqli_query($conn, $queryString);
	if ( $qO != false ) return mysqli_insert_id($conn);
	else return false;
}

function QU($queryObject) {
    global $conn;
	if (gettype($queryObject)=="resource" && $queryObject != false) {
		return mysqli_affected_rows($conn);
	} else {
		if ($queryObject == false) return false;
		$realQueryObject = Q($queryObject);
		return mysqli_affected_rows($conn);
	}
	return false;
}



 
$runfrom = "BC2PROD";
echo "<br>\r\nStarting FBO LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n<br>\r\n" ;
$loadstats = "<br>\r\nStarting FBO LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n<br>\r\n" ;
$loadstatsTest = "<br><br>\r\nRecord Details\r\n\r\n<br><br>";

//DEMO 
//$parentpath = "/home/cccsol818/public_html/bc2demo";

//DEV
//$parentpath = "/home/cccsol818/public_html/bc2dev";


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


//bc2test
/*
$server="localhost";
$db="cccsol81_bc2test";
$user="cccsol81_bc2test";
$password="bc2test.ccc818";
*/


//mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
//mysql_select_db($db) or die('Could not select the specified database.');

$conn = mysqli_connect($server, $user, $password, $db) or die('Could not connect to the MySQL database server');


$PRESOL = 0;
$SRCSGT = 0;
$COMBINE = 0;


// Output one line until end-of-file

$current_tag = '';
$last_tag = ''; //used to skip all lines after <DESC> tag until the next tag is found.
$same_field = 0;
$ignore_tag = 0;
$ecnt = 0;
$TotalFilesLoaded = 0;
$TotalRecordsLoaded = 0;

$GrandTotalFilesLoaded = 0;
$GrandTotalRecordsLoaded = 0;
$NumFilesProcessed = 0;


$processed_cnt = 0;

//$postedDate = $_REQUEST['date'];

//$postedDay = QV("select day from fbo_load");

//$postedDay += 1;
//$processedDate = $postedDay;

$today = Date('Y')."-".Date('m')."-".Date('d');

$date = date_create($today);
date_sub($date,date_interval_create_from_date_string("1 days"));
$mon = date_format($date,"m");
$year = date_format($date,"Y");
$day = date_format($date,"d");
//$day = "4";

//if ($day < 10)
//    $day = "0".$day;

$postedDate = $mon."/".$day."/".$year;


if (isset($_REQUEST['postedDate'])){
    $postedDateFrom = $_REQUEST['postedDate'];
    $postedDate = $postedDateFrom;
}

if (isset($_REQUEST['postedDate2']))
    $postedDateTo = $_REQUEST['postedDate2'];  
    
if (isset($_REQUEST['enddate']))
    $enddate = $_REQUEST['enddate']; 
    
//echo "Posted Date: ".$postedDateFrom." - ".$postedDateTo."<br>\r\n<br>\r\n";   

/** Manual FBO Load - comment out when not in use **/
//***************************************************
//$postedDate = "12/13/2020";
//***************************************************

/*** Bulk Automated Load ***
$enddate = 19;

$rundate_qry = "select day from fbo_load";
$day = QV($rundate_qry);

if ($day == 99)
{
    echo "No more days to process! Day is equal to 99.";
    
    $loadstats .= "No more days to process! Day is equal to 99.";
    $to = "larryf@bc2match.com";
    $subject = "FBO Load Stats [ ".date('m-d-Y')." ]";
    $body = $loadstats;
    sendmail($subject, $body, $to);
    
    exit();
}
else 
{
    $day = $day + 1;
}

$postedDate = "01/".$day."/2021";

echo "Posted Date: ".$postedDate."<br>\r\n<br>\r\n";

if ($day > $enddate)
{
    echo "No more days to process! Setting day equal to 99.";
    $updateRunDateQry = "Update fbo_load set day = 99";
    mysqli_query($conn, $updateRunDateQry);
    
    $loadstats .= "No more days to process! Setting day equal to 99.";
    $to = "larry@ljfenterprises.com";
    $subject = "FBO Load Stats [ ".date('m-d-Y')." ]";
    $body = $loadstats;
    sendmail($subject, $body, $to);
    
    
    exit();
}
else
{
    $updateRunDateQry = "Update fbo_load set day = ".$day;
    //echo $updateRunDateQry; exit();
    mysqli_query($conn, $updateRunDateQry);
}

******************************************/


$loadstats .= "Posted Date: ".$postedDate."<br>\r\n<br>\r\n";

$content .= "<br>Yesterday: ".$postedDate;

$runstarttime = date('Y-m-d H:i:s');
 

//$postedDate = "01/18/2021";
//$postedDate2 = "01/18/2021";


$api_key = QV("SELECT * FROM fbo_load_key");

$duedate_validate = '';

$url = "https://api.sam.gov/prod/opportunities/v1/search?limit=1000&api_key=".$api_key."&postedFrom=".$postedDate."&postedTo=".$postedDate;
//echo $url."<br>";
//$url = "https://api.sam.gov/prod/opportunities/v1/search?limit=1000&api_key=".$api_key."&postedFrom=01/12/2021&postedTo=01/12/2021";
echo $url; //exit();
$loadstats .= $url."<br><br>\r\n\r\n";

$duedate_validate .= $url."<br>\r\n";

//echo (ini_get('allow_url_fopen')); exit;

/**
if( ini_get('allow_url_fopen') ) {
    die('allow_url_fopen is enabled. file_get_contents should work well');
} else {
    die('allow_url_fopen is disabled. file_get_contents would not work');
}
**/

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    $data = curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
//    if ($retcode == 200) {
  //      return $data;
  //  } else {
    //    return null;
//    }



//echo $data."<br>";


//$data = file_get_contents($url); // put the contents of the file into a variable
$fields = json_decode($data,true); // decode the JSON feed
//echo $data;
//exit();

echo "<br>\r\n";
$loadstats .= "<br>\r\n";
$totalrecs = 0;
$totalrecs = $fields['totalRecords'];

echo "<br>\r\nTotal Records in File - ".$totalrecs."<br>\r\n<br>\r\n";
$loadstats .= "<br>\r\nTotal Records in File - ".$totalrecs."<br>\r\n<br>\r\n";

echo $postedDate."==>".$postedDate."<br>\r\n<br>\r\n";
$loadstats .= $postedDate."==>".$postedDate."<br>\r\n<br>\r\n";




$total_to_process =0;
$total_not_to_process = 0;

$total_processed = 0;
$total_not_processed = 0;
$fbo_added_cnt = 0;
$fbo_error_cnt = 0;
$job_error_cnt = 0;
$job_added_cnt = 0;
$job_updated_cnt = 0;
$exceptions = '';

$x = 0;
$y = 0;
$z = 0;
$offset = 0;


for ($z = 0; $z < $totalrecs; $z++) 
{
    
    if ($y == 1000)
    {
        $y = 0;
        $x = 0;
        $offset += 1000;
        echo "<br>\r\n============>offset [".$offset."]<br>\r\n";
        $loadstats .= "<br>\r\n============>offset [".$offset."]<br>\r\n";
        
        $url = "https://api.sam.gov/prod/opportunities/v1/search?limit=1000&api_key=".$api_key."&postedFrom=".$postedDate."&postedTo=".$postedDate."&offset=".$offset;

        //$data = file_get_contents($url); // put the contents of the file into a variable

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36');
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $data = curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);


        $fields = json_decode($data,true); // decode the JSON feed
        $totalrecs2 = $fields['totalRecords'];
        //echo "<br>\r\n[totals] - ".$totalrecs2."<br>\r\n";
    }
    
    
	
	$notice_id = $fields['opportunitiesData'][$x]['noticeId'];
	$type = $fields['opportunitiesData'][$x]['type'];
	
	if (($type == "Solicitation") || ($type == "Presolicitation") || ($type == "Combined Synopsis/Solicitation") || ($type == "Sources Sought"))
	{	

	//***case "DATE>": -> postedDate (YYYY-MM-DD)
	$pdate = $fields['opportunitiesData'][$x]['postedDate'];
	            $pdate = substr($pdate,5,2).substr($pdate,8,2);	

	//***case "YEAR>": -> postedDate (YYYY-MM-DD)
	$year = $fields['opportunitiesData'][$x]['postedDate'];
	$pyear = substr($year,2,2);

	//***case "AGENCY>": -> subTier
	$agency = $fields['opportunitiesData'][$x]['subTier'];
	//echo $agency."<br>";
	
	$agency_id_qry = "select catagen_id from cat_agencies where catagen_label = '".$agency."'";
	$agency_id = QV($agency_id_qry);
	
	//if (is_null($agency_id) || $fedco == "VETERANS AFFAIRS, DEPARTMENT OF-247-NETWORK CONTRACT OFFICE 7 (36C247)") 
	if (is_null($agency_id)) 	
	{
	
		
		$agencyqry = "INSERT INTO cat_agencies(catagen_label, catagen_text) VALUES ('".$agency."','".$agency."')";
		echo $agencyqry."---"; 
		$result = QI($agencyqry);
		echo "adding agency to table - ".$agency."<br>\r\n";
		$loadstats .= "adding agency to table - ".$agency."<br>\r\n";
    }		

	$agency_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
	//***case "OFFICE>": -> office
	$office = $fields['opportunitiesData'][$x]['office'];

	
	//***case "LOCATION>":->'officeAddress' -> city, ->'officeAddress' -> state
	$location = $fields['opportunitiesData'][$x]['officeAddress']['city'];
	$location .= ", ".$fields['opportunitiesData'][$x]['officeAddress']['state'];
	$bstate = $fields['opportunitiesData'][$x]['officeAddress']['state'];
	$popstate = $fields['opportunitiesData'][$x]['placeOfPerformance']['state']['code'];
	
//	echo "[".$bstate."]<br>[".$popstate."]<br>[".$location."]<br>";
	
	if ($popstate <> "")
	    $geo = $popstate."- ALL";
	else if ($bstate <> "")
	    $geo = $bstate."- ALL";
	else
	    $geo = "NONE";
	    
	//echo $geo."<br>";

	//*** case "ZIP>":  'officeAddress'->zipcode
	$zip = $fields['opportunitiesData'][$x]['officeAddress'][0]['zipcode'];
	
	
	//***case "CLASSCOD>": -> classificationCode
	$classcod = $fields['opportunitiesData'][$x]['classificationCode'];

	
	//***case "NAICS>": // NAICS   -> naicsCode
	$naics = $fields['opportunitiesData'][$x]['naicsCode'];
	
	//***case "OFFADD>":	
	$offadd = "NO DATA";
	
	//***case "SUBJECT>": //Job Title ->title
	$subject = $fields['opportunitiesData'][$x]['title'];

	
	//***case "SOLNBR>": //Solicitation # -> solicitationNumber
	$solnbr = $fields['opportunitiesData'][$x]['solicitationNumber'];

	
	//***case "ARCHDATE>":  -> archiveDate
	$archdate = $fields['opportunitiesData'][$x]['archiveDate'];
	
	//***case "CONTACT>": //Contact + E-mail / Tel-> 'pointOfContact' -> fullName
	$contact = $fields['opportunitiesData'][$x]['pointOfContact'][0]['countryCode']; 
	
	$poc0 = $fields['opportunitiesData'][$x]['pointOfContact'][0]['type'];
	
	if ($poc0 <> "")
	{
	    $poc = "[".$fields['opportunitiesData'][$x]['pointOfContact'][0]['type'];
	    $poc .=" - ".$fields['opportunitiesData'][$x]['pointOfContact'][0]['fullName'];
	    $poc .=" - ".$fields['opportunitiesData'][$x]['pointOfContact'][0]['email'];
	    $poc .=" - ".$fields['opportunitiesData'][$x]['pointOfContact'][0]['phone'];
	    $poc .="] ";
	}
	
	$poc1 = $fields['opportunitiesData'][$x]['pointOfContact'][1]['type'];
	
	if ($poc1 <> "")
	{
	    $poc .= "[".$fields['opportunitiesData'][$x]['pointOfContact'][1]['type'];
	    $poc .=" - ".$fields['opportunitiesData'][$x]['pointOfContact'][1]['fullName'];
	    $poc .=" - ".$fields['opportunitiesData'][$x]['pointOfContact'][1]['email'];
	    $poc .=" - ".$fields['opportunitiesData'][$x]['pointOfContact'][1]['phone'];
	    $poc .="] ";
	}
	
//	echo "[".$poc."]"; 
	//exit();
	
	//***case "LINK>":
	$link = $fields['opportunitiesData'][$x]['uiLink'];
	
	//***case "URL>": //Solicititation Link  ->uiLink
	$url = $fields['opportunitiesData'][$x]['uiLink'];
	
	//***case "SETASIDE>": //Certs    ->typeOfSetAsideDescription
	$setaside = $fields['opportunitiesData'][$x]['typeOfSetAsideDescription'];

	if (strlen($setaside) > 0)
	{
		$pos = strpos($setaside, ' Set-Aside');
		$setaside = substr($setaside,0,$pos);
	}
	else
		$setaside = "N/A";
	
	//***case "POPCOUNTRY>":  'officeAddress' -> countryCode
	$popcountry = $fields['opportunitiesData'][$x]['officeAddress'][0]['countryCode'];

	
	//***case "POPADDRESS>":
	$popaddress = "NO DATA";

	//***case "RESPDATE>": ->responseDeadLine
	$respdate = $fields['opportunitiesData'][$x]['responseDeadLine'];
	
	//2020-02-02
	//0123456789
	
	$setaside = substr($setaside,0,$pos);
	
	$mon = substr($respdate,5,2);
	$day = substr($respdate,8,2);
	$year = substr($respdate,0,4);
	
	$respdate = $mon."-".$day."-".$year;
	
	$email = $fields['opportunitiesData'][$x]['pointOfContact'][0]['email'];

	$current_tag = $type;
	$from_file = "api.sam.gov";
	
	switch ($type)
	{
		case "Solicitation":
		case "Presolicitation":
			$ecnt = $ecnt + 1;
			$processed_cnt = $processed_cnt + 1;
			$PRESOL = 2;
			
			if ((strlen($naics)) == 6)
			{
	
			    $chkidSQL =  "select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics; 
			    $chkdescSQL = "select catskl_text from cat_skills where substr(catskl_label,1,6) = ".$naics;
			    
                $chkid = QV($chkidSQL);
                $chkdesc = QV($chkdescSQL);

                if ($chkid > 0)
                { 
                    $naics_id = $chkid; //"(select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			        $naics_desc = $chkdesc; // from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
		    	}
                else 
                { 
                    $naics_id = "99-".$naics;
                    $naics_desc = "NAICS not in BC2";
                }
			}
			else
			{	
				$naics_id = 99;
				$naics_desc = "''";
			}
				
			$bc2_cert_desc = MapCerts ($setaside, $agency);	
			
			if ($bc2_cert_desc == "NONE")
			    $bc2_cert_id = "53";
			else
			    $bc2_cert_id = "(SELECT catcrt_id FROM cat_certs WHERE catcrt_desc = '".$bc2_cert_desc."' )";	
					
			$ageny_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
		    $agency_desc = "(select catagen_label from cat_agencies where catagen_label = '".$agency."' )";
			
			/**
				$query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, placeOfPerformance, contact_info, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,notice_id,load_date) 
				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$pyear."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$geo."','".$poc."','".$naics."',".$naics_id.",'".$naics_desc."','".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."','".$notice_id."',CURRENT_TIMESTAMP())";
            **/
                $query = 'INSERT INTO FBO_IMPORT'.$ROWBYROW .' (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, placeOfPerformance, contact_info, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,notice_id,load_date) 
				VALUES ("'.$agency.'-'.$office.'","fed'.$ecnt.'_'.$office.'@bc2.com","'.$email.'","'.$pdate.'","'.$pyear.'","'.$agency.'",'.$ageny_id.','.$agency_desc.',"'.$offadd.'","'.$geo.'","'.$poc.'","'.$naics.'",'.$naics_id.',"'.$naics_desc.'","'.$subject.'","'.$solnbr.'","'.$respdate.'","'.$url.'","'.$setaside.'","'.$bc2_cert_desc.'",'.$bc2_cert_id.',"'.$contact.'","'.$current_tag.'","'.$from_file.'","'.$notice_id.'",CURRENT_TIMESTAMP())';


//echo "(sol - pre-sol)<br>".$query."<br><br>";
//echo "(sol - pre-sol)<br>";
$duedate_validate .= $type."|".$pdate."|".$pyear."|".$respdate."\r\n<br>";
						
	       $newfed_id  = QI($query);
	       
	    if (!$newfed_id)
	    {
	        $exceptions .= "FBO-ERROR-SOL-PRESOL|".$query."|".$solnbr."|".$notice_id."<br>\r\n<br>\r\n";
            echo "FBO-ERROR-SOL-PRESOL|".$query."|".$solnbr."|".$notice_id."<br><br>";
            //echo "ERROR|".$solnbr."|".$notice_id."<br><br>";
            $fbo_error_cnt=$fbo_error_cnt+1;
        }
        else
        {
            //echo "FBO-INSERT|".$query."|".$solnbr."|".$notice_id."<br><br>";
            //echo "FBO-INSERT|".$solnbr."|".$notice_id."<br><br>";
            $fbo_added_cnt=$fbo_added_cnt+1;
        }
        

	       
	        

	        $fedco = $agency."-".$office;
	        $coemail = $email;
	        
	        	$query2 = "INSERT INTO FBO_IMPORT_TB".$ROWBYROW ." (fed_company,contact_email, File_Date, File_YY, notice_id, load_date) 
				VALUES ('".$agency."-".$office."','".$email."','".$pdate."','".$pyear."','".$notice_id."',CURRENT_TIMESTAMP())";
/*************************************************	        
	        	if ($fedco == "VETERANS AFFAIRS, DEPARTMENT OF-247-NETWORK CONTRACT OFFICE 7 (36C247)" && $coemail == "Mariah.Delaney-Mack@va.gov")
	        	{
	        	    echo $query."<br><br>";
	        		echo $query2."<br><br>";
	        		exit();
	        	}
*************************************************/
	        	$newfed_id  = QI($query2);	        
	        
	        
		  $loaded_cnt=$loaded_cnt+1;
          $loaded_cnt_total=$loaded_cnt_total+1;
		 	$newfed_email = 'fed'.$ecnt.'_'.$office.'@bc2.com';
		 	$newfed_company = $agency."-".$office;

  LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$pyear,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file,$geo,$poc,$notice_id);
 //echo "[".$type."]  ".$newfed_company." [".$naics."]<br>\r\n";
 $loadstatsTest .= "[".$type."]  ".$newfed_company." [".$naics."]<br>\r\n";
			$query = '';
			
			$current_tag = '';
			$pdate = '';$pyear = '';$agency = '';$office = '';$location = '';$zip = '';$classcod = '';$naics = '';$offadd = '';$subject = '';$solnbr = '';$archdate = '';$contact = '';$link = '';$url = '';$setaside = '';$popcountry = '';$popaddress = '';$respdate = '';$email = ''; $naics_id = ''; $naics_desc = ''; $bc2_cert_desc =''; $bc2_cert_id =''; $ageny_id.''; $agency_desc = ''; $geo = ''; $poc = '';
			$notice_id = '';
			break;
					
		case "Sources Sought":
			$ecnt = $ecnt + 1;
			$processed_cnt = $processed_cnt + 1;
			$SRCSGT = 2;
			
			if ((strlen($naics)) == 6)
			{
	
			    $chkidSQL =  "select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics; 
			    $chkdescSQL = "select catskl_text from cat_skills where substr(catskl_label,1,6) = ".$naics;
			    
                $chkid = QV($chkidSQL);
                $chkdesc = QV($chkdescSQL);

                if ($chkid > 0)
                { 
                    $naics_id = $chkid; //"(select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			        $naics_desc = $chkdesc; // from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
		    	}
                else 
                { 
                    $naics_id = "99-".$naics;
                    $naics_desc = "NAICS not in BC2";
                }
			}
			else
			{	
				$naics_id = 99;
				$naics_desc = "''";
			}
			
			$bc2_cert_desc = MapCerts ($setaside, $agency);		

			if ($bc2_cert_desc == "NONE")
			    $bc2_cert_id = "53";
			else
			    $bc2_cert_id = "(SELECT catcrt_id FROM cat_certs WHERE catcrt_desc = '".$bc2_cert_desc."' )";
			
			//echo "SRCSGT [ ".$naics_id." ][ ".$naics_desc." ]<br>\r\n";
			
			$ageny_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
		    $agency_desc = "(select catagen_label from cat_agencies where catagen_label = '".$agency."' )";
		    /**	
				$query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, placeOfPerformance, contact_info, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,notice_id,load_date) 
				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$pyear."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$geo."','".$poc."','".$naics."',".$naics_id.",'".$naics_desc."','".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."','".$notice_id."',CURRENT_TIMESTAMP())";
            **/
                $query = 'INSERT INTO FBO_IMPORT'.$ROWBYROW .' (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, placeOfPerformance, contact_info, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,notice_id,load_date) 
				VALUES ("'.$agency.'-'.$office.'","fed'.$ecnt.'_'.$office.'@bc2.com","'.$email.'","'.$pdate.'","'.$pyear.'","'.$agency.'",'.$ageny_id.','.$agency_desc.',"'.$offadd.'","'.$geo.'","'.$poc.'","'.$naics.'",'.$naics_id.',"'.$naics_desc.'","'.$subject.'","'.$solnbr.'","'.$respdate.'","'.$url.'","'.$setaside.'","'.$bc2_cert_desc.'",'.$bc2_cert_id.',"'.$contact.'","'.$current_tag.'","'.$from_file.'","'.$notice_id.'",CURRENT_TIMESTAMP())';



//echo "(ss)<br>".$query."<br><br>";
//echo "(ss)<br>";
$duedate_validate .= $type."|".$pdate."|".$pyear."|".$respdate."\r\n<br>";

		   $newfed_id  = QI($query);
	    if (!$newfed_id)
	    {
	        $exceptions .= "FBO-ERROR-SOL-PRESOL|".$query."|".$solnbr."|".$notice_id."<br>\r\n<br>\r\n";
            echo "FBO-ERROR-SOL-PRESOL|".$query."|".$solnbr."|".$notice_id."<br><br>";
            //echo "ERROR|".$solnbr."|".$notice_id."<br><br>";
            $fbo_error_cnt=$fbo_error_cnt+1;
        }
        else
        {
            //echo "FBO-INSERT|".$query."|".$solnbr."|".$notice_id."<br><br>";
            //echo "FBO-INSERT|".$solnbr."|".$notice_id."<br><br>";
            $fbo_added_cnt=$fbo_added_cnt+1;
        }
		   
	        $fedco = $agency."-".$office;
	        $coemail = $email;
	        
	        	$query2 = "INSERT INTO FBO_IMPORT_TB".$ROWBYROW ." (fed_company,contact_email, File_Date, File_YY, notice_id, load_date) 
				VALUES ('".$agency."-".$office."','".$email."','".$pdate."','".$pyear."','".$notice_id."',CURRENT_TIMESTAMP())";
/*************************************************	        
	        	if ($fedco == "VETERANS AFFAIRS, DEPARTMENT OF-247-NETWORK CONTRACT OFFICE 7 (36C247)" && $coemail == "Mariah.Delaney-Mack@va.gov")
	        	{
	        	    echo $query."<br><br>";
	        		echo $query2."<br><br>";
	        		exit();
	        	}
*************************************************/
	        	$newfed_id  = QI($query2);	        
		   
		   $loaded_cnt=$loaded_cnt+1;
          $loaded_cnt_total=$loaded_cnt_total+1;

			$newfed_email = 'fed'.$ecnt.'_'.$office.'@bc2.com';
		 	$newfed_company = $agency."-".$office;

LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$pyear,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file,$geo,$poc,$notice_id);
//echo "[".$type."]  ".$newfed_company." [".$naics."]<br>\r\n";
$loadstatsTest .= "[".$type."]  ".$newfed_company." [".$naics."]<br>\r\n";
		
			$current_tag = '';
			$pdate = '';$pyear = '';$agency = '';$office = '';$location = '';$zip = '';$classcod = '';$naics = '';$offadd = '';$subject = '';$solnbr = '';$archdate = '';$contact = '';$link = '';$url = '';$setaside = '';$popcountry = '';$popaddress = '';$respdate = '';$email = ''; $naics_id = ''; $naics_desc = ''; $bc2_cert_desc =''; $bc2_cert_id =''; $ageny_id.''; $agency_desc = '';$geo = ''; $poc = '';
			$notice_id = '';
			break;
			break;
				
		case "Combined Synopsis/Solicitation": 
			$ecnt = $ecnt + 1;
			$processed_cnt = $processed_cnt + 1;
			$COMBINE = 2;
						
			if ((strlen($naics)) == 6)
			{
	
			    $chkidSQL =  "select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics; 
			    $chkdescSQL = "select catskl_text from cat_skills where substr(catskl_label,1,6) = ".$naics;
			    
                $chkid = QV($chkidSQL);
                $chkdesc = QV($chkdescSQL);

                if ($chkid > 0)
                { 
                    $naics_id = $chkid; //"(select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			        $naics_desc = $chkdesc; // from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
		    	}
                else 
                { 
                    $naics_id = "99-".$naics;
                    $naics_desc = "NAICS not in BC2";
                }
			}
			else
			{	
				$naics_id = 99;
				$naics_desc = "''";
			}
				
			$bc2_cert_desc = MapCerts ($setaside, $agency);	
			
			if ($bc2_cert_desc == "NONE")
			    $bc2_cert_id = "53";
			else
				$bc2_cert_id = "(SELECT catcrt_id FROM cat_certs WHERE catcrt_desc = '".$bc2_cert_desc."' )";	
					
			$ageny_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
		    $agency_desc = "(select catagen_label from cat_agencies where catagen_label = '".$agency."' )";
	
	       /**
			    $query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, placeOfPerformance, contact_info, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,notice_id,load_date) 
				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$pyear."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$geo."','".$poc."','".$naics."',".$naics_id.",'".$naics_desc."','".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."','".$notice_id."',CURRENT_TIMESTAMP())";
            **/
                $query = 'INSERT INTO FBO_IMPORT'.$ROWBYROW .' (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, placeOfPerformance, contact_info, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,notice_id,load_date) 
				VALUES ("'.$agency.'-'.$office.'","fed'.$ecnt.'_'.$office.'@bc2.com","'.$email.'","'.$pdate.'","'.$pyear.'","'.$agency.'",'.$ageny_id.','.$agency_desc.',"'.$offadd.'","'.$geo.'","'.$poc.'","'.$naics.'",'.$naics_id.',"'.$naics_desc.'","'.$subject.'","'.$solnbr.'","'.$respdate.'","'.$url.'","'.$setaside.'","'.$bc2_cert_desc.'",'.$bc2_cert_id.',"'.$contact.'","'.$current_tag.'","'.$from_file.'","'.$notice_id.'",CURRENT_TIMESTAMP())';





//echo "(cs/s)<br>".$query."<br><br>";
//echo "(cs/s)<br>";

$duedate_validate .= $type."|".$pdate."|".$pyear."|".$respdate."\r\n<br>";
				
		      $newfed_id  = QI($query);
	    if (!$newfed_id)
	    {
	        $exceptions .= "FBO-ERROR-SOL-PRESOL|".$query."|".$solnbr."|".$notice_id."<br>\r\n<br>\r\n";
            echo "FBO-ERROR-SOL-PRESOL|".$query."|".$solnbr."|".$notice_id."<br><br>";
            //echo "ERROR|".$solnbr."|".$notice_id."<br><br>";
            $fbo_error_cnt=$fbo_error_cnt+1;
        }
        else
        {
            //echo "FBO-INSERT|".$query."|".$solnbr."|".$notice_id."<br><br>";
            //echo "FBO-INSERT|".$solnbr."|".$notice_id."<br><br>";
            $fbo_added_cnt=$fbo_added_cnt+1;
        } 
		      
	        $fedco = $agency."-".$office;
	        $coemail = $email;
	        
	        	$query2 = "INSERT INTO FBO_IMPORT_TB".$ROWBYROW ." (fed_company,contact_email, File_Date, File_YY, notice_id, load_date) 
				VALUES ('".$agency."-".$office."','".$email."','".$pdate."','".$pyear."','".$notice_id."',CURRENT_TIMESTAMP())";
/*************************************************	        
	        	if ($fedco == "VETERANS AFFAIRS, DEPARTMENT OF-247-NETWORK CONTRACT OFFICE 7 (36C247)" && $coemail == "Mariah.Delaney-Mack@va.gov")
	        	{
	        	    echo $query."<br><br>";
	        		echo $query2."<br><br>";
	        		exit();
	        	}
*************************************************/
	        	$newfed_id  = QI($query2);	        
		      
		      $loaded_cnt=$loaded_cnt+1;
          $loaded_cnt_total=$loaded_cnt_total+1;
		 	$newfed_email = 'fed'.$ecnt.'_'.$office.'@bc2.com';
		 	$newfed_company = $agency."-".$office;

LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$pyear,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file,$geo,$poc,$notice_id);
//echo "[".$type."]  ".$newfed_company." [".$naics."]<br>\r\n";
$loadstatsTest .= "[".$type."]  ".$newfed_company." [".$naics."]<br>\r\n";

			$query = '';
		           		
			$current_tag = '';
			$pdate = '';$pyear = '';$agency = '';$office = '';$location = '';$zip = '';$classcod = '';$naics = '';$offadd = '';$subject = '';$solnbr = '';$archdate = '';$contact = '';$link = '';$url = '';$setaside = '';$popcountry = '';$popaddress = '';$respdate = '';$email = ''; $naics_id = ''; $naics_desc = ''; $bc2_cert_desc =''; $bc2_cert_id =''; $ageny_id.''; $agency_desc = '';$geo = ''; $poc = '';
			$notice_id = '';
			break;
					
		default:
			break;
		}
		
		$total_processed += 1;
		$y += 1;
		$x += 1;
		//echo "[total processed y] = [".$y."]<br>";
	}
	else {
	    //echo "NOT PROCESSED - [".$type."] <br>";
		$total_not_processed += 1;
		$y += 1;
		$x += 1;
	}
}

if ($exceptions == '')
{
    $exceptions = "None";
}

$yeartodateSQL = "Select count(*) from job where date(job_insert_date) >= '2021-01-02'";
$yeartodate = QV($yeartodateSQL);

echo "<br>\r\nTotal processed [ ".$total_processed."]";
echo "<br>\r\n==> Job Table<br>\r\n   ========> New [".$job_added_cnt."] <br>\r\n   ========> Updates [".$job_updated_cnt."] <br>\r\n   ========> Load Failures [".$job_error_cnt."]<br>\r\n<br>\r\n";
echo "<br>\r\n==> FBO-IMPORT Table<br>\r\n   ========> New [".$fbo_added_cnt."] <br>\r\n   ========> Load Failures [".$fbo_error_cnt."]<br>\r\n<br>\r\n";
echo "Total_not_processed [ ".$total_not_processed."]<br>\r\n<br>\r\nExceptions: <br>\r\n".$exceptions."<br>\r\n<br>\r\n";
echo "Year to Date Job Table Load Total [".$yeartodate."]<br>\r\n<br>\r\n";

$loadstats .= "<br>\r\nTotal processed [ ".$total_processed."]";
$loadstats .= "<br>\r\n==> Job Table<br>\r\n   ========> New [".$job_added_cnt."] <br>\r\n   ========> Updates [".$job_updated_cnt."] <br>\r\n   ========> Load Failures [".$job_error_cnt."]<br>\r\n<br>\r\n";
$loadstats .= "<br>\r\n==> FBO-IMPORT Table<br>\r\n   ========> New [".$fbo_added_cnt."] <br>\r\n   ========> Load Failures [".$fbo_error_cnt."]<br>\r\n<br>\r\n";
$loadstats .= "Total_not_processed [ ".$total_not_processed."]<br>\r\n"; 
$loadstats .= "Year to Date Job Table Load Total [".$yeartodate."]<br>\r\n<br>\r\n";
 

echo "<br>\r\nStopping FBO LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n" ;
$loadstats .= "<br>\r\nStopping FBO LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n" ;



$body = $loadstats;
$subject = "FBO Load Stats [ ".date('m-d-Y')." ]";

$to = "larryf@bc2match.com";
sendmail($subject, $body, $to);

$to = "tjohnson@bc2match.com";
sendmail($subject, $body, $to);

$to = "jonr@bc2match.com";
sendmail($subject, $body, $to);


$to = "larryf@bc2match.com";
$subject = "FBO Load Stats [ ".date('m-d-Y')." ] - With  With Exceptions";
$body = $loadstats."\r\n\r\n<br><br>Exceptions: <br>\r\n".$exceptions."<br>\r\n<br>\r\n";
sendmail($subject, $body, $to);

/**
$to = "larry@ljfenterprises.com";
$subject = "FBO DUE DATE";
$body = $duedate_validate;
sendmail($subject, $body, $to);

echo $duedate_validate;
**/
?>



