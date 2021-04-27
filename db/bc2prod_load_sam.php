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
	$mail->Password = 'ljf$bc22021';
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

function LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$year,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file,$geo,$poc)

{
    global $conn;
    
   global $ROWBYROW,$from_file ; 
   global $emp_added_cnt,  $emp_updated_cnt,  $usr_added_cnt,  $usr_updated_cnt,  $usremp_added_cnt; 
   global       $usremp_updated_cnt,  $usr_edu_added_cnt,  $usr_edu_updated_cnt, $usr_clearance_added_cnt; 
    global      $usr_clearance_updated_cnt,  $usr_app_added_cnt, $usr_app_updated_cnt, $job_added_cnt;
    global      $job_updated_cnt, $job_skills_added_cnt, $job_skill_updated_cnt, $job_certs_added_cnt; 
    global      $job_certs_updated_cnt,  $job_agencies_added_cnt,   $job_agencies_updated_cnt;


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
echo "<br>\r\nStarting SAM LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n<br>\r\n" ;

$loadstats = "<br>\r\nStarting SAM LOAD for " . $runfrom . " at [ " .  date('m-d-Y')." ] [ ".date('H:i:s')." ]<br>\r\n<br>\r\n" ;

$body = $loadstats;
$subject = "SAM Load Starting - [ ".date('m-d-Y')." ]";
$to = "larryf@bc2match.com";
sendmail($subject, $body, $to);


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



//mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
//mysql_select_db($db) or die('Could not select the specified database.');

$conn = mysqli_connect($server, $user, $password, $db) or die('Could not connect to the MySQL database server');


$sam = [];

//$h = fopen("SAMNYNJGAFLPromoList.csv","r");
$h = fopen("sam2021_exception_fix.csv","r");

while (($data = fgetcsv($h, 1000,",")) !== FALSE)
{
    $sam[] = $data;
}

$num = count($sam);
$actualtot = $num - 1;

echo "Total Records to process: ".$actualtot."<br>";

$loadstats .= "Total Records to process: ".$actualtot."<br>\r\n";

//exit();

$co_cnt = 0;

$exceptions="";
$err_cnt = 0;


$sam_id_start = 246641;
$sam_id_cnt = 246641;

//for ($i=1; $i < $num ; $i++)
//for ($i=1; $i <= 2 ; $i++)
for ($i=1; $i < $num ; $i++)
{

    $reccnt = $reccnt + 1;
    
    //start    
    //Sam Record

    $company = $sam[$i][0];
    $dba = $sam[$i][1];
    $addr1 = $sam[$i][2];
    $addr2 = $sam[$i][3];
    $city = $sam[$i][4];
    $st = $sam[$i][5];
    $zip = $sam[$i][6];
    $region = $sam[$i][7];
    $startdt = $sam[$i][8];
    $url = $sam[$i][9];
    $structure = $sam[$i][10];
    $bus_typ_ctr = $sam[$i][11];
    $bus_type = $sam[$i][12];
    $pnaics = $sam[$i][13];
    $industry = $sam[$i][14];
    $naics_ct = $sam[$i][15];
    $naics = $sam[$i][16];
    $psc_ctr = $sam[$i][17];
    $psc = $sam[$i][18];
    $gov_poc_fn = $sam[$i][19];
    $gov_poc_mi = $sam[$i][20];
    $gov_poc_ln = $sam[$i][21];
    $title = $sam[$i][22];
    $gov_poc_tel = $sam[$i][23];
    $gov_poc_extn = $sam[$i][24];
    $gov_poc_fax = $sam[$i][25];
    $gov_poc_email = $sam[$i][26];
    $sb_typs_ctr = $sam[$i][27];
    $sb_typ = $sam[$i][28];
    $s8a = $sam[$i][29];
    $s8a_jv = $sam[$i][30];
    $sdb = $sam[$i][31];
    $hz = $sam[$i][32];
    $mnr = $sam[$i][33];
    $wob = $sam[$i][34];
    $cert = $sam[$i][35];

    //end
    
    //echo $company."<br>";

    /***
    $qrysamload = "insert into sam2021 (sam_id, company, dba, addr1, addr2, city, st, zip, region, startdt, url, structure, bus_typ_ctr, bus_type, pnaics, industry, naics_ct, naics, psc_ctr, psc, ";
    $qrysamload .= "gov_poc_fn, gov_poc_mi, gov_poc_ln, title, gov_poc_tel, gov_poc_extn, gov_poc_fax, gov_poc_email, sb_typs_ctr, sb_typ, s8a, s8a_jv, sdb, hz, mnr, wob, cert) values ";
    $qrysamload .= "(".$sam_id_cnt.", '".$company."', '".$dba."', '".$addr1."', '".$addr2."', '".$city."', '".$st."', '".$zip."', '".$region."', '".$startdt."', '".$url."',";
    $qrysamload .= "'".$structure."', '".$bus_typ_ctr."', '".$bus_type."', '".$pnaics."', '".$industry."', '".$naics_ct."', '".$naics."', '".$psc_ctr."', '".$psc."', '".$gov_poc_fn."', '".$gov_poc_mi."',";
    $qrysamload .= "'".$gov_poc_ln."', '".$title."', '".$gov_poc_tel."', '".$gov_poc_extn."', '".$gov_poc_fax."', '".$gov_poc_email."', '".$sb_typs_ctr."', '".$sb_typ."', '".$s8a."', '".$s8a_jv."', '".$sdb."', '".$hz."', '".$mnr."', '".$wob."', '".$cert."')";
    ***/

    $qrysamload = 'insert into sam2021 (sam_id, company, dba, addr1, addr2, city, st, zip, region, startdt, url, structure, bus_typ_ctr, bus_type, pnaics, industry, naics_ct, naics, psc_ctr, psc, ';
    $qrysamload .= 'gov_poc_fn, gov_poc_mi, gov_poc_ln, title, gov_poc_tel, gov_poc_extn, gov_poc_fax, gov_poc_email, sb_typs_ctr, sb_typ, s8a, s8a_jv, sdb, hz, mnr, wob, cert) values ';
    $qrysamload .= '('.$sam_id_cnt.', "'.$company.'", "'.$dba.'", "'.$addr1.'", "'.$addr2.'", "'.$city.'", "'.$st.'", "'.$zip.'", "'.$region.'", "'.$startdt.'", "'.$url.'",';
    $qrysamload .= '"'.$structure.'", "'.$bus_typ_ctr.'", "'.$bus_type.'", "'.$pnaics.'", "'.$industry.'", "'.$naics_ct.'", "'.$naics.'", "'.$psc_ctr.'", "'.$psc.'", "'.$gov_poc_fn.'", "'.$gov_poc_mi.'",';
    $qrysamload .= '"'.$gov_poc_ln.'", "'.$title.'", "'.$gov_poc_tel.'", "'.$gov_poc_extn.'", "'.$gov_poc_fax.'", "'.$gov_poc_email.'", "'.$sb_typs_ctr.'", "'.$sb_typ.'", "'.$s8a.'", "'.$s8a_jv.'", "'.$sdb.'", "'.$hz.'", "'.$mnr.'", "'.$wob.'", "'.$cert.'")';


    //echo "<br>".$qrysamload."<br>";
    $insam = QI($qrysamload);

    //echo $insam."<br>";

    if ($insam === false)
    {
        $exceptions .= "<br>ERROR [ ".$qrysamload." ]<br>";
        $err_cnt++;
    }
    else
    {
        $sam_emp = "INSERT INTO emp(sam_id, emp_name, emp_address,emp_dba, emp_url, emp_address2, emp_city, emp_st, emp_zip, emp_level) ";
        $sam_emp .= "SELECT sam_id, company, addr1, dba, url, addr2, city, st, zip, 2 FROM sam2021 where sam_id = ".$sam_id_cnt;
        $load_emp = QI($sam_emp);
        //echo $sam_emp.";<br><br>";


        //$sam_usr = "INSERT INTO usr (sam_id, usr_email, usr_firstname, usr_lastname, usr_title, usr_addr, usr_addr1, usr_city, usr_state, usr_zip, usr_phone, usr_fax, usr_password, usr_auth, usr_type, usr_company) ";
        //$sam_usr .= "SELECT sam_id, gov_poc_email, gov_poc_fn, gov_poc_ln, title, addr1, addr2, city, st, zip, `gov_poc_tel`, `gov_poc_fax`,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2', '0', E.emp_id FROM `sam2021` S JOIN emp E on S.sam_id - E.sam_id where S.sam_id >= $sam_id_start";

        $sam_usr = "INSERT INTO usr (sam_id, usr_email, usr_firstname, usr_lastname, usr_title, usr_addr, usr_addr1, usr_city, usr_state, usr_zip, usr_phone, usr_fax, usr_password, usr_auth, usr_type) ";
        $sam_usr .= "SELECT sam_id, gov_poc_email, gov_poc_fn, gov_poc_ln, title, addr1, addr2, city, st, zip, `gov_poc_tel`, `gov_poc_fax`,'7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2', '0' FROM sam2021 where sam_id = ".$sam_id_cnt;
        $load_usr = QI($sam_usr);
        //echo $sam_usr.";<br><br>";



        $sam_usremp = "INSERT INTO usr_emp (sam_id, usremp_usr_id, usremp_emp_id, usremp_auth, usremp_type) Select U.sam_id, U.usr_id, E.emp_id,'*','0' from emp E join usr U on E.sam_id = U.sam_id where U.sam_id = ".$sam_id_cnt;
        $load_usremp = QI($sam_usremp);
        //echo $sam_usremp.";<br><br>";


        $sam_clearance = "INSERT INTO usr_clearance (sam_id, usrclr_usr_id, usrclr_emp_id, usrclr_clr_id, usrclr_title) select U.sam_id, U.usr_id, E.emp_id, '4','None' from emp E join usr U on E.sam_id = U.sam_id where U.sam_id = ".$sam_id_cnt;
        $load_clearance = QI($sam_clearance);
        //echo $sam_clearance.";<br><br>";


        $sam_usr_edu = "insert into usr_edu (sam_id, usredu_usr_id, usredu_emp_id,usredu_edu_id) select U.sam_id, U.usr_id, E.emp_id, '1' from emp E join usr U on E.sam_id = U.sam_id where U.sam_id = ".$sam_id_cnt;
        $load_usr_edu = QI($sam_usr_edu);
        //echo $sam_usr_edu.";<br><br>";


        $sam_usr_app = "insert into usr_app (sam_id, usrapp_usr_id, usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) select U.sam_id, U.usr_id, E.emp_id, '1','0','1','0' from emp E join usr U on E.sam_id = U.sam_id where U.sam_id = ".$sam_id_cnt;
        $load_usr_app = QI($sam_usr_app);
        //echo $sam_usr_app.";<br><br>";        
        
        $sam_id_cnt++;
        $co_cnt++;
    }

}

echo "Total Records Loaded: ".$co_cnt."<br>";
echo "Total Records in File: ".$reccnt."<br>";
echo "Total Errors: ".$err_cnt."<br><br>";
echo "*** Error Start ***<br>".$exceptions."*** Error End ***<br>";


$loadstats .= "Total Records Loaded: ".$co_cnt."<br>\r\n";
$loadstats .= "Total Records in File: ".$reccnt."<br>\r\n";
$loadstats .= "Total Errors: ".$err_cnt."<br><br>\r\n";
$loadstats .= "*** Error Start ***<br>".$exceptions."*** Error End ***<br>\r\n";

$body = $loadstats;
$subject = "SAM Load Finished - [ ".date('m-d-Y')." ]";

$to = "larryf@bc2match.com";
sendmail($subject, $body, $to);

fclose($h);
?>



