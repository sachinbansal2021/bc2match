<?php

/* Load and process agencies
   Load and process certs
*/
/* 111/29/18 when run as a cron job the fob directory is not found with relative paths
will try absolute patchs  lloyd
*/ 

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

/*
*/
/* UPDATE table_name SET column1=value, column2=value2,...WHERE some_column=some_value   */
////function  LoadData ()  
// 				$query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,load_date) 
//				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$year."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$naics."',".$naics_id.",".$naics_desc.",'".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."',CURRENT_TIMESTAMP())";

//			VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$year."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$naics."',".$naics_id.",".$naics_desc.",'".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."',CURRENT_TIMESTAMP())";
//	        $newfed_id 
//function   LoadDataROWBYROW ($newfed_id,$newfed_company)  ////   LoadData.$ROWBYROW  //LoadDataROWBYROW     //// function  LoadData () ()
//function
function LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$year,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file)

{
   global $ROWBYROW,$from_file ; 
   global $emp_added_cnt,  $emp_updated_cnt,  $usr_added_cnt,  $usr_updated_cnt,  $usremp_added_cnt; 
   global       $usremp_updated_cnt,  $usr_edu_added_cnt,  $usr_edu_updated_cnt, $usr_clearance_added_cnt; 
    global      $usr_clearance_updated_cnt,  $usr_app_added_cnt, $usr_app_updated_cnt, $job_added_cnt;
    global      $job_updated_cnt, $job_skills_added_cnt, $job_skill_updated_cnt, $job_certs_added_cnt; 
    global      $job_certs_updated_cnt,  $job_agencies_added_cnt,   $job_agencies_updated_cnt;

 // echo " <br><br><br> ". date('Y-m-d H:i:s')." Entered  LoadData". $ROWBYROW . ", newfed_id: "  . $newfed_id . ", newfed_company: "  . $newfed_company .", email: " . $email;
  /// emp
 ////	$query = "INSERT INTO emp(fed_id, emp_name, emp_email) SELECT fed_id, fed_company, fed_email FROM FBO_IMPORT  WHERE fbo_file_processed = 0";
       ///// $updateFBOvalues = " SELECT  emp_id,fed_company, fed_email,contact_email FROM FBO_IMPORT  WHERE fed_id = " . $newfed_id ;
        $chkdupeSQL =  "SELECT emp_id FROM emp". $ROWBYROW . " where emp_name like '".$newfed_company . "'"; 
 //      echo "<br><br> line 133 emp  chkdupeSQL: " .$chkdupeSQL ;       //
        $thisemp_id = 0;
          $thisemp_id  = QV($chkdupeSQL);
       if ($thisemp_id > 0)  
        {
            
            
          //     echo "<br>line 143 thisemp_id : " . $thisemp_id ;          ////exit("<br>leave LoadData".$ROWBYROW. " after emp dupe check line 138");
         // if fed-company already there update it 
         
         $updateSQL= "UPDATE emp".$ROWBYROW . " SET emp_email='" .$newfed_email."',emp_name ='". $newfed_company."',emp_contact='".$contact."',emp_contact_email='". $email."',emp_update_date=CURRENT_TIMESTAMP() 
         ,update_FBO_Feed = '".$from_file."'      where emp_id = ".$thisemp_id  . "" ;
            // 	echo "<br><br> line 148 emp  updateSQL: " .$updateSQL ;
           $empupdate = QU($updateSQL) ; // returns 
           $emp_updated_cnt = $emp_updated_cnt + 1;
           
   //      //  	echo " <br>line 152 emp iupdate emp updateSQL: " .$updateSQL . ",  empupdate return code(count: ".  $empupdate. "<br><br>";  ,emp_contact='".$contact."' ,emp_contact .$contact
           	 $insertedemp = 0;
       	   $updatedemp = 1;
            ////   
          } else
           { 

               $thisemp_id = 0;
	     ////	$insertquery = "INSERT INTO emp".$ROWBYROW."(fed_id, emp_name, emp_email) SELECT fed_id, fed_company, fed_email   FROM FBO_IMPORT  WHERE fbo_file_processed = 0";
	   /////    $insertSQL = "INSERT INTO emp".$ROWBYROW."(fed_id, emp_name, emp_email) SELECT fed_id, fed_company, fed_email   FROM FBO_IMPORT  WHERE fed_id = " .$newfed_id . "" ;
   $insertSQL="INSERT INTO emp".$ROWBYROW."(fed_id, emp_name,emp_contact,emp_email,emp_contact_email,emp_insert_date,insert_FBO_Feed)
                  VALUES($newfed_id,'".$newfed_company."','".$contact."','".$newfed_email."','". $email."',CURRENT_TIMESTAMP(),'".$from_file."'  )";  
	        ///////SELECT fed_id, fed_company, fed_email   FROM FBO_IMPORT  WHERE fed_id = " .$newfed_id . "" ;
       	    $thisemp_id = QI($insertSQL);
       	   
       	   $insertedemp = 1;
       	   $updatedemp = 0;
       	   $emp_added_cnt = $emp_added_cnt + 1;
       	//   echo "<br>line 160 , thisemp_id: ". $thisemp_id. " emp insert emp  insertSQL: " . $insertSQL ;
       	  // exit("..line 160 <br>leave LoadData".$ROWBYROW. " after emp insert check ");
         }   
         
    /* *******************************************************************************/    
	///usr**********************************************************************888888
	/// usr
 ///usr**********************************************************************888888
    /*	$query = "INSERT INTO usr".$ROWBYROW." (fed_id, usr_email, usr_firstname, usr_lastname, usr_fullname, usr_password, usr_auth, usr_company, usr_type)
     	Select S.fed_id, fed_email, 'FBO', Buying_Office, fed_company, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2', E.emp_id,'0' FROM FBO_IMPORT  S JOIN emp E on S.fed_id = E.fed_id  and S.fbo_file_processed = 0";
	////mysql$usr_password_query($query); 	echo " insert usr query: " . $query . "<br><br>";      */
      $thisusr_password = '7110eda4d09e062aa5e4a390b0a572ac0d2c0220';
     ///// $updateFBOvalues = "SELECT fed_email,contact_email,usr_firstname, usr_lastname,Buying_Office,fed_company,usr_password,usr_auth,usr_company,usr_type FROM FBO_IMPORT WHERE fed_id = ". $newfed_id ." " ;
        $chkdupeSQL =  "SELECT usr_id FROM usr".$ROWBYROW . " where usr_fullname like '".$newfed_company . "' "; 
//		 echo "<br><br> line 184 usr  chkdupeSQL: " .$chkdupeSQL ;       //
             // 		$dupeCHK 
         $thisusr_id = 0;
		$thisusr_id = QV($chkdupeSQL);
 //          echo "<br><br>  thisusr_id: " . $thisusr_id . "<br>";
        if ($thisusr_id > 0)    // if fed-usr already there update it
          {    
		    ////$usrrow =  $dupeCHK;             $thisusr_id = $usrrow['usr_id'];	        
           $updateSQL="UPDATE usr".$ROWBYROW. " SET usr_email='".$newfed_email."',usr_contact_email='".$email."',usr_firstname='FBO',usr_lastname='".$agency."',
           usr_fullname= '".$newfed_company."',usr_company=".$thisemp_id . ",usr_contact='".$contact."',usr_update_date=CURRENT_TIMESTAMP()
            ,update_FBO_Feed = '".$from_file."'  where usr_id = ".$thisusr_id . " "   ;
          $usrupdate = QU($updateSQL) ; //
          	 $insertedusr = 0;
       	   $updatedusr = 1;
       	    $usr_updated_cnt =  $usr_updated_cnt + 1;
       	  
  //         	echo " emp iupdate usr updateSQL: " .$updateSQL . ",  usrupdate return code: ".  $usrupdate. "<br><br>";
           } else
           {
		   $thisusr_id = 0;
$insertSQL="INSERT INTO usr".$ROWBYROW."(fed_id, usr_email,usr_contact_email, usr_firstname, usr_lastname, usr_fullname, usr_password, usr_auth, usr_company,usr_contact, usr_type,usr_insert_date,insert_FBO_Feed)
	          VALUES(".$newfed_id.",'".$newfed_email."','".$email."','FBO','".$agency."','".$newfed_company."','".$thisusr_password."','2',".$thisemp_id.",'".$contact."','0',CURRENT_TIMESTAMP(),'".$from_file."')";
     //	Select S.fed_id, fed_email, 'FBO', Buying_Office, fed_company, '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '2', E.emp_id,'0' FROM FBO_IMPORT  S JOIN emp E on S.fed_id = E.fed_id  and S.fbo_file_processed = 0";
	   $thisusr_id = QI($insertSQL);
	       $usr_added_cnt = $usr_added_cnt + 1;
	      
	    $insertedusr = 1;
       	   $updatedusr = 0;
  //     	   echo " <br> usr  insertusr  insertSQL: " . $insertSQL ;
  //     	   echo "<br>line 160 , thisusr_id : ". $thisusr_id. "<br><br>";
	////
         }   
   //     echo ("leaving LoadData".$ROWBYROW.") after if dupCHK : " .  $dupeCHK . " if >0 update  usr else add usr");  
      
  
    /* *******************************************************************************/ 
   
       // exit("..line 194 <br>leave LoadData".$ROWBYROW. " after usr update or insert check ");
 
 // usr_emp  ******************************************************************************************
 /* lloyd assign value to usremp_usr_assignedusr_id
     $query = "INSERT INTO usr_emp (usremp_usr_id, usremp_emp_id, usremp_auth, usremp_type) Select usr_id, usr_company,'*','0' from usr where fed_id > 0 and fbo_file_processed = 0";
     only add an usr_emp if added an emp 
     actually need to check for emp_id and the usr_id - minght not have entered both */
      $chkdupeSQL =  "SELECT usremp_id FROM usr_emp".$ROWBYROW. " where usremp_usr_id =" .  $thisusr_id. " and usremp_emp_id = ".$thisemp_id . ""; 
	//	 echo "<br><br> line 184 usr  chkdupeSQL: " .$chkdupeSQL ;       //
             // 		$dupeCHK 
         $thisusremp_id = 0;
		$thisusremp_id = QV($chkdupeSQL);
   //        echo "<br><br>  thisusremp_id: " . $thisusremp_id . "<br>";
        if ($thisusremp_id > 0)    // if  usremp  already no need to update it
          {    
		    	        
           $usremp_updated_cnt = $usremp_updated_cnt;
    //       	echo " <br>usremp no need to update <br><br>";
            // did update for emp and usr 
                     //No Update to usr_emp needed nothing will have changed:  $updateSQL="UPDATE usr_emp $ROWBYROW SET usremp_usr_id, usremp_emp_id, usremp_auth, usremp_type,usremp_usr_assignedusr_id
          }
         else 
          {     //did emp usr insert so do usr_emp insert   $insertedemp  ==1
            $thisusremp_id = 0;
 	$query = "INSERT INTO usr_emp".$ROWBYROW." (usremp_usr_id, usremp_emp_id, usremp_auth, usremp_type,usremp_usr_assignedusr_id,usremp_insert_date,insert_FBO_Feed )
 	                                    VALUES (". $thisusr_id.", ".$thisemp_id.",'*','0',".$thisusr_id.",CURRENT_TIMESTAMP(),'".$from_file."')"; 
 	                                   //Select usr_id, usr_company,'*','0',usr_id from usr where fed_id > 0 and fbo_file_processed = 0"; 
 	          
 	       $thisusremp_id = QI($query);
 	           $usremp_added_cnt =  $usremp_added_cnt+1; 
         
 	//       echo "<br> line 239 Insert usr_emp  query: ".$query . ", thisusremp_id: " . $thisusremp_id ." <br><br>";
	//
    }  
  //       echo ("<br>line 242 leaving LoadData".$ROWBYROW." usr_emp; if thisusremp_id was  0 after first query did insert  resulting in  thisusremp_id: " .  $thisusremp_id . " if <> 0 no update needed")  ;
         
      
    
// /* usr_clearance **************************************************888	
   if ( $updatedusr == 1  )
    { //  
        //usr was updated No Update to usr_clearance needed nothing will have changed:  
        $usr_clearance_updated_cnt = $usr_clearance_updated_cnt;
    }
    else 
    {     //did  usr insert so do usr_Clearance  insert
	$query = "insert into usr_clearance".$ROWBYROW." (usrclr_usr_id, usrclr_clr_id, usrclr_title,usrclr_insert_date,insert_FBO_Feed)  
	VALUES(".$thisusr_id.",'4','None',CURRENT_TIMESTAMP(),'".$from_file."')";
	//select usr_id, '4','None' from usr where fed_id > 0 and fbo_file_processed = 0";
//"insert into usr_clearance (usrclr_usr_id, usrclr_clr_id, usrclr_title) select usr_id, '4','None' from usr where fed_id > 0 and fbo_file_processed = 0";	
	  $thisusrclr_id  = QI($query);
	   $usr_clearance_added_cnt =  $usr_clearance_added_cnt+1;
	//echo $query . "$thisusrclr_id <br><br>";
    }
//	   echo ("<br>line 258leaving LoadData".$ROWBYROW . "; usr_clearance if thisusrclr_id: " . $thisusrclr_id . " if updatedusr: " .$updatedusr." <> 1 then did an insert");
	/* usr_edu */
	  if ( $updatedusr == 1  )
    { //  
        //usr was updated No Update to usr_edu needed nothing will have changed:  
        $usr_edu_updated_cnt = $usr_edu_updated_cnt;
    }
    else 
    
    {     //did emp usr insert so do usr_edu insert
	$query = "INSERT into usr_edu".$ROWBYROW." (usredu_usr_id, usredu_edu_id,usredu_insert_date,insert_FBO_Feed) VALUES(".$thisusr_id.",'1',CURRENT_TIMESTAMP(),'".$from_file."')";  	//select usr_id, '1' from usr where fed_id > 0 and fbo_file_processed = 0";'1'
     $thisusredu_id  = QI($query);
        $usr_edu_added_cnt=$usr_edu_added_cnt+1;
	 //"insert into usr_edu (usredu_usr_id, usredu_edu_id) select usr_id, '1' from usr where fed_id > 0 and fbo_file_processed = 0";
    }
//	   echo ("<br>line 271 leaving LoadData".$ROWBYROW . "usr_edu if thisusredu_id: " . $thisusredu_id . " if 1 <> updatedusr: ". $updatedusr . "then did an insert");

 	/* usr_app */
	 if ( $updatedusr == 1  )
    { //  
        //usr was updated No Update to usr_app needed nothing will have changed: 
        $usr_app_updated_cnt=$usr_app_updated_cnt;
    }
    else 
    {     //did   usr insert so do usr_app insert
     $query = "insert into usr_app".$ROWBYROW." (usrapp_usr_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance,usrapp_insert_date,insert_FBO_Feed)
     VALUES(". $thisusr_id.",'1','0','1','0',CURRENT_TIMESTAMP(),'".$from_file."' )";
     //select usr_id,'1','0','1','0' from usr where fed_id > 0 and fbo_file_processed = 0";
	$thisusrapp_id  = QI($query);
	   $usr_app_added_cnt=$usr_app_added_cnt+1;
	  //insert into usr_app (usrapp_usr_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) select usr_id,'1','0','1','0' from usr where fed_id > 0 and fbo_file_processed = 0";

	 
//	 echo ("<br>line 28 leaving LoadData".$ROWBYROW . " usr_app if " .$thisusrapp_id . "<> 0  did insert  no update needed if 1 = $updatedusr: " .$$updatedusr );  
 
    }
//  echo ("<br><br>..line 287 <br>returning from LoadData".$ROWBYROW. " after emp".$ROWBYROW. ", usr".$ROWBYROW. "".$ROWBYROW. ", usr_emp".$ROWBYROW. ", usr_clearance".$ROWBYROW. "
    //    usr_edu".$ROWBYROW. ", usr_app".$ROWBYROW. "update or insert check <br>");
                 // echo("<br>!!!!*** Processed count so far: " .$processed_cnt + 1) ; /* */
    
    
    /*********************************************************************************8888888
//	$query = "insert into job (fed_id, job_email_address, job_buying_office, job_title, job_details, job_solicitation, job_due_date, job_solicitation_link, job_ava_id, job_clearance, job_edu_level, job_status,job_created_by, job_emp_id) 
//select F.fed_id, F.fed_email, F.Buying_Office, F.Job_title, F.Job_title, F.Solicitation_num, F.Due_Date, F.Solicitation_Link, '0','0','0','1','FBO', U.usr_id from FBO_IMPORT F JOIN usr U ON F.fed_id = U.fed_id where F.fed_id > 0 and F.fbo_file_processed = 0";
// 1/2/19  reformat due date fro fbo_import mm-dd-yy to mysql date field yyyy-mm-dd  STR_TO_DATE(F.Due_Date,'%m-%d-%y')
/************job *******************/
// job
  // echo "<br><br>entered job 319 insert if solnbr: ".$solnbr."  already in job table, set updatedjob to 1 and insertedjob to 0, otherwise set insertedjob to 1,updatedjob to 0 <br><br>";

     $chkdupeSQL =  "SELECT job_id FROM job".$ROWBYROW . " where job_solicitation like '".$solnbr."' "; 
	//	 echo "<br> line 301 job  chkdupeSQL: " .$chkdupeSQL ;       //
             // 		$dupeCHK 
         $thisjob_id = 0;
		$thisjob_id = QV($chkdupeSQL);
     //      echo "<br><br> line 288  thisjob_id: =>|" . $thisjob_id . "| <= exists if have value here<br>";
     //,emp_contact='".$contact."' ,emp_contact .$contact  ,job_contact='".$contact."' 
        if ($thisjob_id > 0)    // if job solnbr already there update it
          {    
		   $updateSQL="UPDATE job".$ROWBYROW." SET fed_id=".$newfed_id.",job_contact='".$contact."' ,job_email_address='".$newfed_email."',job_contact_email='".$email."',
             job_buying_office='".$agency."',job_title='".$subject."',job_details='".$subject."',job_solicitation='".$solnbr."',
             job_due_date=STR_TO_DATE('".$respdate."','%m-%d-%y'),job_solicitation_link='".$url."', job_update_date=CURRENT_TIMESTAMP()
              ,update_FBO_Feed = '".$from_file."'  WHERE job_id=".$thisjob_id."";

 /*(fed_id, job_email_address, job_buying_office, job_title, job_details, job_solicitation, job_due_date, job_solicitation_link
	, job_ava_id, job_clearance, job_edu_level, job_status,job_created_by, job_emp_id) 
	select F.fed_id, F.fed_email, F.Buying_Office, F.Job_title, F.Job_title, F.Solicitation_num,  STR_TO_DATE(F.Due_Date,'%m-%d-%y'), F.Solicitation_Link
	, '0','0','0','1','FBO', U.usr_id 
	usr_lastname='".$agency."',usr_fullname= '".$newfed_company."',usr_company=".$thisemp_id . ",usr_update_date=CURRENT_TIMESTAMP() where usr_id = ".$thisusr_id . " "   ;*/
          $jobupdate = QU($updateSQL) ; //
          $job_updated_cnt=$job_updated_cnt+1;
          	 $insertedjob = 0;
       	   $updatedjob = 1;
       //    	echo " <br> 305 job update jobupdateSQL: " .$updateSQL . ",  jobupdate return code(# affected): ".  $jobupdate. "<br><br>";
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
                        	
//echo "inserting job [fed_id] - Fed id [ ".$newfed_id." ] - QRY [ --- ".$insertSQL." ---] <br>"; 

                        	
                        	
                        	
 //echo ("<!-- br> trace 360 insertSQL for job: ".$insertSQL . "-->");
 /*"insert into job (fed_id, job_email_address, job_buying_office, job_title, job_details, job_solicitation, job_due_date, job_solicitation_link
 , job_ava_id, job_clearance, job_edu_level, job_status,job_created_by, job_emp_id) 
	select F.fed_id, F.fed_email, F.Buying_Office, F.Job_title, F.Job_title, F.Solicitation_num,  STR_TO_DATE(F.Due_Date,'%m-%d-%y'), F.Solicitation_Link, 
	'0','0','0','1','FBO', U.usr_id from FBO_IMPORT F JOIN usr U ON F.fed_id = U.fed_id where F.fed_id > 0 and F.fbo_file_processed = 0";
 */
                        	
	////select F.fed_id, F.fed_email, F.Buying_Office, F.Job_title, F.Job_title, F.Solicitation_num,  STR_TO_DATE(F.Due_Date,'%m-%d-%y'), F.Solicitation_Link
	////, '0','0','0','1','FBO', U.usr_id from FBO_IMPORT F JOIN usr U ON F.fed_id = U.fed_id where F.fed_id > 0 and F.fbo_file_processed = 0";

     $thisjob_id = QI($insertSQL);
     if ($thisjob_id)
        {$job_added_cnt=$job_added_cnt+1;}
      
    //  echo " <br> usr  insertjob  insertSQL: " . $insertSQL ;
      // 	   echo "<br>line 321 , thisjob_id: ". $thisjob_id. "<br><br>";
	////
         }   
     // echo ("<br>line 340leaving LoadData job".$ROWBYROW.") after if job insert thisjob_id: " . $thisjob_id." or udpate if  updatedjob: ".$updatedjob." >0 update job else add ");  
        ////return 0;
  
   
	/***********************job_skills *********************************/
	/* add only of new job added, insertedjob = 1 " ."  $insertedjob. ""  otherwise update job skills; thisjob_id : ". $thisjob_id used for update
	                                current values passed in for insert*/
	//   echo "<br><br>entered job_skills 333 insert if 1 = insertedjob:  " .$insertedjob."; Update if 1= updatedjob: " .$updatedjob." <br><br>";

	   if ($updatedjob==1) 
	      {    ////update job_skill
  $updateSQL="UPDATE job_skills".$ROWBYROW." SET jobskl_skl_id=".$naics_id.",jobskl_desc=".$naics_desc.",jobskl_update_date=CURRENT_TIMESTAMP()
                ,update_FBO_Feed = '".$from_file."'  WHERE jobskl_job_id=".$thisjob_id."";
             $jobskillupdate = QU($updateSQL) ; //
          	 $insertedjob_skills = 0;
       	      $updatedjob_skills = 1;
       	      $job_skill_updated_cnt=$job_skill_updated_cnt +1;
      //     	echo " 337 job update jobupdateSQL: " .$updateSQL . ",  jobupdate return code: ".  $jobupdate. "<br><br>";
	      } else
	      {// insert job skill
	        if ($thisjob_id)
	          {	 $insertedjob_skills = 1;
       	      $updatedjob_skills = 0;
	   	$insertSQL = "insert into job_skills".$ROWBYROW." (jobskl_job_id     , jobskl_skl_id,     jobskl_desc, jobskl_status,jobskl_insert_date,insert_FBO_Feed) 
	                                                             VALUES(".$thisjob_id.",".$naics_id.",".$naics_desc.",'1',CURRENT_TIMESTAMP(),'".$from_file."')";
     	$thisjobskl_id = QI($insertSQL);
     	  $job_skills_added_cnt =  $job_skills_added_cnt + 1;  
	          }
   /*	$query = "insert into job_skills".$ROWBYROW." (jobskl_job_id, jobskl_skl_id, jobskl_desc, jobskl_status)  
    select J.job_id, F.fed_naics_bc2, F.fed_naics_desc, '1' from job J JOIN FBO_IMPORT F ON J.fed_id = F.fed_id and F.fed_naics_bc2 <> '99' and F.fbo_file_processed = 0";*/
	      }
//echo (" <br> line 367 leaving jobskill;i, insertSQL: " . $insertSQL ." udpate if  updatedjob: ".$updatedjob . " >0  update job else add job, thisjobskl_id =" .$thisjobskl_id .""); 

	    
	   /* ************************ end jobskills******************************************************/
	   
	/*********************start job_agencies ***************************************/
    /*  insert into job_agencies". ROWBYROW  ." (jobskl_job_id, jobskl_skl_id, jobskl_desc); */
 //    echo "<br><br>line 372 entered job_agencies insert if 1=insertedjob: ".$insertedjob." , Update if  updatedjob: " .$updatedjob." = 1";
 //    echo "<br>add job_agencies only when new job added, otherwise update job agencies; thisjob_id : ". $thisjob_id." used for update, current values passed in for insert";
	   if ($updatedjob==1) 
	      {    ////update job_skill
	  $updateSQL="UPDATE job_agencies".$ROWBYROW." SET jobskl_skl_id=".$ageny_id.",jobskl_desc=".$agency_desc.",jobagencies_update_date=CURRENT_TIMESTAMP() 
	      ,update_FBO_Feed = '".$from_file."'   WHERE jobskl_job_id=".$thisjob_id."";
             $jobagenciesupdate = QU($updateSQL) ; 
          	 $insertedjob_agencies = 0;
       	      $updatedjob_agencies = 1;
       	      $job_agencies_updated_cnt=$job_agencies_updated_cnt+1;
   //        	echo " 382 job update jobupdateSQL: " .$updateSQL . ",  jobupdate return code: ".  $jobagenciesupdate. "<br><br>";
	      } else
	      {// insert job agencies
	       if ($thisjob_id)
	      { $insertedjob_agencies = 1;
       	      $updatedjob_agencies = 0;
	   	$insertSQL = "insert into job_agencies".$ROWBYROW."  (jobskl_job_id, jobskl_skl_id, jobskl_desc,jobagencies_insert_date,insert_FBO_Feed) 
	   	                                   VALUES (" .$thisjob_id.",".$ageny_id.",".$agency_desc.",CURRENT_TIMESTAMP(),'".$from_file."')";
	   	//// select J.job_id, F.agency_id, F.agency_desc from job J JOIN FBO_IMPORT F ON J.fed_id = F.fed_id and F.fbo_file_processed = 0";
//"insert into job_agencies (jobskl_job_id, jobskl_skl_id, jobskl_desc) select J.job_id, F.agency_id, F.agency_desc from job J JOIN FBO_IMPORT F ON J.fed_id = F.fed_id and F.fbo_file_processed = 0";
	   	
          $thisjobagencies_id_ = QI($insertSQL);
           $job_agencies_added_cnt =  $job_agencies_added_cnt+1;
	      } 
              //field names in job-agencies oare same as job_skills field names
//	    echo " <br> job agencies  insert jobsagencies  insertSQL: " . $insertSQL ;
    //   	   echo "<br>line 393 , thisjobagencies_id== thisjobskl_id : ". $thisjobagencies_id. "<br><br>";
	////
         }   
  //      echo ("<br>line 396 leaving LoadData".$ROWBYROW.") after if job agencies insert or udpate if  updatedjob: ".$updatedjob . " >0  update job else add job");  
      ////  return 0;
	   /***********end job agencies ************/
	
	/**********job_certs  *****/
//	$query = "insert into job_certs".$ROWBYROW." (jobcrt_job_id, jobcrt_crt_id, jobcrt_desc) select J.job_id, F.Cert_id, F.Cert_desc from job J JOIN FBO_IMPORT F ON J.fed_id = F.fed_id and F.fbo_file_processed = 0";
//	mysql_query($query);
	//echo $query . "<br><br>";
//	echo "entered job_certs 359 insert if insertedjob= 1: ".$insertedjob."; Update if  updatedjob: " .$updatedjob." is 1 <br><br>";
	/* add job_certs only of new job added, insertedjob = 1 " ."  $insertedjob. ""  otherwise update job certss; thisjob_id : ". $thisjob_id used for update
	                                current values passed in for insert*/
	   if ($updatedjob==1) 
	      {    ////update job_skill
	  $updateSQL="UPDATE job_certs".$ROWBYROW." SET jobcrt_crt_id=".$bc2_cert_id.",jobcrt_desc='".$bc2_cert_desc."',jobcrt_update_date=CURRENT_TIMESTAMP()
	              ,update_FBO_Feed = '".$from_file."'   WHERE jobcrt_job_id=".$thisjob_id.""; 
               $jobscertsupdate = QU($updateSQL) ; //
              
          $job_certs_updated_cnt=  $job_certs_updated_cnt + 1;  
          	 $insertedjob_certs = 0;
       	      $updatedjob_certs = 1;
 //          	echo " line four zer0 four job update job_certs updateSQL: " .$updateSQL . ",  jobupdate return code: ".  $jobscertsupdate. "<br><br>";
	      } else
	      {// insert job skill
	         if ($thisjob_id)
	      {
	   	$insertSQL = "insert into job_certs".$ROWBYROW."   	 (jobcrt_job_id, jobcrt_crt_id, jobcrt_desc,jobcrt_insert_date,insert_FBO_Feed) 
	   	               VALUES (" .$thisjob_id.",".$bc2_cert_id.",'".$bc2_cert_desc."',CURRENT_TIMESTAMP(),'".$from_file."')";
	   	//// select J.job_id, F.agency_id, F.agency_desc from job J JOIN FBO_IMPORT F ON J.fed_id = F.fed_id and F.fbo_file_processed = 0";
          $thisjobcrt_id = QI($insertSQL);
           $job_certs_added_cnt= $job_certs_added_cnt+1; 
	      }
  //       echo "<br>line 421 , thisjobcerts thisjobcrt_id : ". $thisjobcrt_id. "  <br> job certs  insert jobscerts  insertSQL: " . $insertSQL ;
         }   
   //     echo ("<br>line 425 leaving LoadData".$ROWBYROW.") after if job certs insert or udpate; if  updatedjob: ".$updatedjob . " >0  update job else add job");  
      ////  return 0;

  /**********end job_certs  *****/
	$query = "update FBO_IMPORT".$ROWBYROW." set fbo_file_processed = 1 where fed_id = ".$newfed_id . " "; //fbo_file_processed = 0";
	mysql_query($query);
 //echo "<br> <br> update fbo_import".$ROWBYROW." query: " .$query . "<br>";		
	
	$query = "update usr".$ROWBYROW." set fbo_file_processed = 1 where usr_id =" . $thisusr_id . "";  //  fed_id > 0 and  fbo_file_processed = 0";
	mysql_query($query);
//	 echo "line 432 update usr query to set fbo_fileprocessed: " .$query . "<br><br><br><br>";
	//   $runtotalprocessed = $runtotalprocessed  + 1;
      //   echo("<br><br> line 441 !!!!line  *** Processed count so far: " .$runtotalprocessed   ) ; 
  
  /*******  ADD CODE TO DELETE JOB CERT = 53 *******/
  
  $rem53 =  Q("DELETE FROM job_certs WHERE jobcrt_crt_id = 53");
  
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
			//while ($datRow = mysql_unbuffered_query($realQueryObject)) array_push($dataOut, $datRow);
			return $dataOut;
		}
		else return false;
	}
}

function QI($queryString) { // Insert and safely return id or false
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


//*******************************************************************
//  Access Fed Biz Opps Server and download yesterday's xml file with name FBOFBOFeedyyyymmdd  e,g,  FBOFeed20181002
//
// lloyd Jan 2019 do row by row insert conditionally test with <everything> || ROWBYROW
//DEMO
//$runfrom = "DEMO";
//$ROWBYROW = "";
//DEV
// server should keep session data for AT LEAST 1 hour
//ini_set('session.gc_maxlifetime', 4800);

// each client should remember their session id for EXACTLY 1 hour
//session_set_cookie_params(4800);	

 
$runfrom = "BC2DEMO";
$ROWBYROW = ""; //// "ROWBYROW";
$my_pagename = basename($_SERVER['PHP_SELF']);
echo "<br>[ ".$ROWBYROW." ]<br>";
 echo "<br>\r\n&nbsp;Starting program cron [". $ROWBYROW. "] " . $my_pagename . "in " . $runfrom . " at " .  date('Y-m-d H:i:s').  "<br>" ;
 //exit(0);
 //echo "starting program" . date('Y-m-d H:i:s')."<br>";

//folder
//DEMO
$parentpath = "/home/cccsol818/public_html/demo";

//DEV
//$parentpath = "/home/cccsol818/public_html/bc2dev";

// Database
//DEMO
//
$server="localhost";
//
$db="cccsol81_bc2demo";
//
$user="cccsol81_bc2demo";
//
$password="bc2demo.ccc818";

//DEV
//$server="localhost";
//$db="cccsol81_bc2dev";
//$user="cccsol81_bc2dev";
//$password="bc2dev.ccc818";


mysql_connect($server, $user, $password) or die('Could not connect to the MySQL database server');
mysql_select_db($db) or die('Could not select the specified database.');




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


$fed_count = Q2R("SELECT fed_count FROM fed_email_counter".$ROWBYROW);

$start_usrcount = QV("SELECT COUNT(*) FROM usr".$ROWBYROW);
$start_jobcount = QV("SELECT COUNT(*) FROM job".$ROWBYROW);

$end_usrcount = QV("SELECT COUNT(*) FROM usr".$ROWBYROW);
$start_empcount = QV("SELECT COUNT(*) FROM emp".$ROWBYROW);


$end_empcount = QV("SELECT COUNT(*) FROM emp".$ROWBYROW);
$end_jobcount = QV("SELECT COUNT(*) FROM job".$ROWBYROW);

echo "<br> <br>\r\n\r\n Beginning usr count: " . $start_usrcount . " ";

echo "<br> \r\n  Beginning emp count: " . $start_empcount . " ";
echo "<br>  \r\n Beginning job count: " . $start_jobcount . "<br>";
$ecnt = $fed_count['fed_count'];
echo "<br>\r\nLast Email Count [ ".$ecnt." ]<br>";


$processed_cnt = 0;

$emp_added_cnt = 0;
$emp_updated_cnt=0;
$usr_added_cnt = 0;
$usr_updated_cnt=0;
$usremp_added_cnt = 0;
$usremp_updated_cnt=0;
$usr_edu_added_cnt = 0;
$usr_edu_updated_cnt=0;
$usr_clearance_added_cnt = 0;
$usr_clearance_updated_cnt=0;
$usr_app_added_cnt = 0;
$usr_app_updated_cnt=0;
$job_added_cnt = 0;
$job_updated_cnt=0;
$job_skills_added_cnt = 0;
$job_skill_updated_cnt=0;
$job_certs_added_cnt = 0;
$job_certs_updated_cnt=0;
$job_agencies_added_cnt = 0;
$job_agencies_updated_cnt=0;
//run total
$emp_added_cntruntotal = 0;
$emp_updated_cntruntotal=0;
$usr_added_cntruntotal = 0;
$usr_updated_cntruntotal=0;
$usremp_added_cntruntotal = 0;
$usremp_updated_cntruntotal=0;
$usr_edu_added_cntruntotal = 0;
$usr_edu_updated_cntruntotal=0;
$usr_clearance_added_cntruntotal = 0;
$usr_clearance_updated_cntruntotal=0;
$usr_app_added_cntruntotal = 0;
$usr_app_updated_cntruntotal=0;
$job_added_cntruntotal = 0;
$job_updated_cntruntotal=0;
$job_skills_added_cntruntotal = 0;
$job_skill_updated_cntruntotal=0;
$job_certs_added_cntruntotal = 0;
$job_certs_updated_cntruntotal=0;
$job_agencies_added_cntruntotal = 0;
$job_agencies_updated_cntruntotal=0;



//$fbo_dir    = $parentpath."/fbo".$ROWBYROW;   
//$fboprocessed_dir = $parentpath.'/fbo'.$ROWBYROW. 'processed';
//echo " <br>\r\nline 829 fbo_dir: " . $fbo_dir  . ", fboprocessed_dir: " . $fboprocessed_dir;
//$fbo_files = scandir($fbo_dir);
//$file_cnt = count($fbo_files);
//$ftbp = $file_cnt - 2;
//echo ("<br><br># files to be processed[".$ftbp."]<br><br>");
$emp_added_cnt = 0;
$emp_updated_cnt=0;
$usr_added_cnt = 0;
$usr_updated_cnt=0;
$usremp_added_cnt = 0;
$usremp_updated_cnt=0;
$usr_edu_added_cnt = 0;
$usr_edu_updated_cnt=0;
$usr_clearance_added_cnt = 0;
$usr_clearance_updated_cnt=0;
$usr_app_added_cnt = 0;
$usr_app_updated_cnt=0;
$job_added_cnt = 0;
$job_updated_cnt=0;
$job_skills_added_cnt = 0;
$job_skill_updated_cnt=0;
$job_certs_added_cnt = 0;
$job_certs_updated_cnt=0;
$job_agencies_added_cnt = 0;
$job_agencies_updated_cnt=0;

//run total
$emp_added_cntruntotal = 0;
$emp_updated_cntruntotal=0;
$usr_added_cntruntotal = 0;
$usr_updated_cntruntotal=0;
$usremp_added_cntruntotal = 0;
$usremp_updated_cntruntotal=0;
$usr_edu_added_cntruntotal = 0;
$usr_edu_updated_cntruntotal=0;
$usr_clearance_added_cntruntotal = 0;
$usr_clearance_updated_cntruntotal=0;
$usr_app_added_cntruntotal = 0;
$usr_app_updated_cntruntotal=0;
$job_added_cntruntotal = 0;
$job_updated_cntruntotal=0;
$job_skills_added_cntruntotal = 0;
$job_skill_updated_cntruntotal=0;
$job_certs_added_cntruntotal = 0;
$job_certs_updated_cntruntotal=0;
$job_agencies_added_cntruntotal = 0;
$job_agencies_updated_cntruntotal=0;
$loaded_cnt=0;
$loaded_cnt_total=0;


ob_flush();  
flush();  
$processed_cnt = 0;
$loaded_cnt = 0;
$emp_added_cnt = 0;
$emp_updated_cnt=0;
$usr_added_cnt = 0;
$usr_updated_cnt=0;
$usremp_added_cnt = 0;
$usremp_updated_cnt=0;
$usr_edu_added_cnt = 0;
$usr_edu_updated_cnt=0;
$usr_clearance_added_cnt = 0;
$usr_clearance_updated_cnt=0;
$usr_app_added_cnt = 0;
$usr_app_updated_cnt=0;
$job_added_cnt = 0;
$job_updated_cnt=0;
$job_skills_added_cnt = 0;
$job_skill_updated_cnt=0;
$job_certs_added_cnt = 0;
$job_certs_updated_cnt=0;
$job_agencies_added_cnt = 0;
$job_agencies_updated_cnt=0;

//$postedDate = $_REQUEST['date'];

//$postedDay = QV("select day from fbo_load");

//$postedDay += 1;
//$processedDate = $postedDay;

$today = Date(Y)."-".Date(m)."-".Date(d);

$date = date_create($today);
date_sub($date,date_interval_create_from_date_string("1 days"));
$mon = date_format($date,"m");
$year = date_format($date,"Y");
$day = date_format($date,"d");
//$day = "4";

//if ($day < 10)
//    $day = "0".$day;

$postedDate = $mon."/".$day."/".$year;
echo "Posted Date: ".$postedDate."<br>";

$content .= "<br>Yesterday: ".$postedDate;
echo ("<br>start fbo: " . date('Y-m-d H:i:s'))."<br>";

$runstarttime = date('Y-m-d H:i:s');
 

/**
if ($postedDay > 31)
{
    echo "I am done";
    exit();
}    

if ($postedDay < 10)
    $postedDay = "0".$postedDay;
    

$postedDate = "01/".$postedDay."/2020";
$postedDate = "02/27/2020";
**/

//$postedDate1 = "05/05/2020";
//$postedDate2 = "05/05/2020";

$url = "https://api.sam.gov/prod/opportunities/v1/search?limit=1000&api_key=2IdRLrPPkqnenuQxVwSkxQbGOei17JDV41geBRO8&postedFrom=".$postedDate."&postedTo=".$postedDate;
//exit();
$data = file_get_contents($url); // put the contents of the file into a variable
$fields = json_decode($data,true); // decode the JSON feed
//echo $data;
//exit();

echo "<br>";
$totalrecs = $fields[totalRecords];
echo "[totals] - ".$totalrecs."<br>";

echo $postedDate."==>".$postedDate."<br>";


$total_to_process =0;
$total_not_to_process = 0;

/*
for ($x = 0; $x < 1000; $x++) {
	$type = $fields[opportunitiesData][$x]['type'];
	if (($type == "Solicitation") || ($type == "Presolicitation") || ($type == "Combined Synopsis/Solicitation") || ($type == "Sources Sought"))
		$total_to_process += 1;
	else
		$total_not_to_process += 1;		
}
echo "[total to process][ ".$total_to_process."]<br>[total_not_to_process][ ".$total_not_to_process."]<br>";
*/


$total_processed = 0;
$total_not_processed = 0;

//if ($totalrecs > 1000)
//    $totalrecs = 1000;


$x = 0;
$y = 0;
$z = 0;
$offset = 0;


echo "<br>============>offset [".$offset."]<br>";


for ($z = 0; $z < $totalrecs; $z++) 
{
    
    if ($y == 1000)
    {
        $y = 0;
        $x = 0;
        $offset += 1000;
        echo "<br>============>offset [".$offset."]<br>";
        $url = "https://api.sam.gov/prod/opportunities/v1/search?limit=1000&api_key=2IdRLrPPkqnenuQxVwSkxQbGOei17JDV41geBRO8&postedFrom=".$postedDate."&postedTo=".$postedDate."&offset=".$offset;
        $data = file_get_contents($url); // put the contents of the file into a variable
        $fields = json_decode($data,true); // decode the JSON feed
        $totalrecs2 = $fields[totalRecords];
        echo "<br>[totals] - ".$totalrecs2."<br>";
    }
    
    
	
	$type = $fields[opportunitiesData][$x]['type'];
	
	if (($type == "Solicitation") || ($type == "Presolicitation") || ($type == "Combined Synopsis/Solicitation") || ($type == "Sources Sought"))
	{	

	//***case "DATE>": -> postedDate (YYYY-MM-DD)
	$pdate = $fields[opportunitiesData][$x]['postedDate'];
	            $pdate = substr($pdate,5,2).substr($pdate,8,2);	

	//***case "YEAR>": -> postedDate (YYYY-MM-DD)
	$year = $fields[opportunitiesData][$x]['postedDate'];
	$year = substr($year,2,2);

	//***case "AGENCY>": -> subTier
	$agency = $fields[opportunitiesData][$x]['subTier'];
	//echo $agency."<br>";
	
	$agency_id_qry = "select catagen_id from cat_agencies where catagen_label = '".$agency."'";
	$agency_id = QV($agency_id_qry);
	
	if (is_null($agency_id)) 
	{
		$agencyqry = "INSERT INTO cat_agencies(catagen_label, catagen_text) VALUES ('".$agency."','".$agency."')";
		//echo $agencyqry."---";
		$result = QI($agencyqry);
		echo "adding agency to table - ".$agency."<br>";
    }		

	$agency_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
	//***case "OFFICE>": -> office
	$office = $fields[opportunitiesData][$x]['office'];

	
	//***case "LOCATION>":->officeAddress -> city, ->officeAddress -> state
	$location = $fields[opportunitiesData][$x][officeAddress][0]['city'];
	$location .= ", ".$fields[opportunitiesData][$x][officeAddress][0]['state'];

	//*** case "ZIP>":  officeAddress->zipcode
	$zip = $fields[opportunitiesData][$x][officeAddress][0]['zipcode'];
	
	
	//***case "CLASSCOD>": -> classificationCode
	$classcod = $fields[opportunitiesData][$x]['classificationCode'];

	
	//***case "NAICS>": // NAICS   -> naicsCode
	$naics = $fields[opportunitiesData][$x]['naicsCode'];
	
	//***case "OFFADD>":	
	$offadd = "NO DATA";
	
	//***case "SUBJECT>": //Job Title ->title
	$subject = $fields[opportunitiesData][$x]['title'];

	
	//***case "SOLNBR>": //Solicitation # -> solicitationNumber
	$solnbr = $fields[opportunitiesData][$x]['solicitationNumber'];

	
	//***case "ARCHDATE>":  -> archiveDate
	$archdate = $fields[opportunitiesData][$x]['archiveDate'];
	
	//***case "CONTACT>": //Contact + E-mail / Tel-> pointOfContact -> fullName
	$contact = $fields[opportunitiesData][$x][pointOfContact][0]['countryCode']; 
	
	//***case "LINK>":
	$link = $fields[opportunitiesData][$x]['uiLink'];
	
	//***case "URL>": //Solicititation Link  ->uiLink
	$url = $fields[opportunitiesData][$x]['uiLink'];
	
	//***case "SETASIDE>": //Certs    ->typeOfSetAsideDescription
	$setaside = $fields[opportunitiesData][$x]['typeOfSetAsideDescription'];

	if (strlen($setaside) > 0)
	{
		$pos = strpos($setaside, ' Set-Aside');
		$setaside = substr($setaside,0,$pos);
	}
	else
		$setaside = "N/A";
	
	//***case "POPCOUNTRY>":  officeAddress -> countryCode
	$popcountry = $fields[opportunitiesData][$x][officeAddress][0]['countryCode'];

	
	//***case "POPADDRESS>":
	$popaddress = "NO DATA";

	//***case "RESPDATE>": ->responseDeadLine
	$respdate = $fields[opportunitiesData][$x]['responseDeadLine'];
	
	//2020-02-02
	//0123456789
	
	$setaside = substr($setaside,0,$pos);
	
	$mon = substr($respdate,5,2);
	$day = substr($respdate,8,2);
	$year = substr($respdate,0,4);
	
	$respdate = $mon."-".$day."-".$year;
	
	//echo "Due Date - [ ".$respdate." ]<br>";


	//***case "EMAIL>": ->pointOfContact->email
	$email = $fields[opportunitiesData][$x][pointOfContact][0]['email'];

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
				$naics_id = "(select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			    $naics_desc = "(select catskl_text from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			}
			else
			{	
				$naics_id = 99;
				$naics_desc = "''";
			}
				
			$bc2_cert_desc = MapCerts ($setaside, $agency);		
			$bc2_cert_id = "(SELECT catcrt_id FROM cat_certs WHERE catcrt_desc = '".$bc2_cert_desc."' )";	
					
			$ageny_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
		    $agency_desc = "(select catagen_label from cat_agencies where catagen_label = '".$agency."' )";
			
			
				$query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,load_date) 
				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$year."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$naics."',".$naics_id.",".$naics_desc.",'".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."',CURRENT_TIMESTAMP())";
			//echo "Solicitation:<br>".$query;
			//exit();
						
	        $newfed_id  = QI($query);
		  $loaded_cnt=$loaded_cnt+1;
          $loaded_cnt_total=$loaded_cnt_total+1;
		 	$newfed_email = 'fed'.$ecnt.'_'.$office.'@bc2.com';
		 	$newfed_company = $agency."-".$office;

 LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$year,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file);
	
			$query = '';
			
			$current_tag = '';
			$pdate = '';$year = '';$agency = '';$office = '';$location = '';$zip = '';$classcod = '';$naics = '';$offadd = '';$subject = '';$solnbr = '';$archdate = '';$contact = '';$link = '';$url = '';$setaside = '';$popcountry = '';$popaddress = '';$respdate = '';$email = ''; $naics_id = ''; $naics_desc = ''; $bc2_cert_desc =''; $bc2_cert_id =''; $ageny_id.''; $agency_desc = '';
			break;
					
		case "Sources Sought":
			$ecnt = $ecnt + 1;
			$processed_cnt = $processed_cnt + 1;
			$SRCSGT = 2;
			
			if ((strlen($naics)) == 6)
			{
				$naics_id = "(select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			    $naics_desc = "(select catskl_text from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			}
			else
			{	
				$naics_id = 99;
				$naics_desc = "''";
			}
			
			$bc2_cert_desc = MapCerts ($setaside, $agency);		
			$bc2_cert_id = "(SELECT catcrt_id FROM cat_certs WHERE catcrt_desc = '".$bc2_cert_desc."' )";		
			
			//echo "SRCSGT [ ".$naics_id." ][ ".$naics_desc." ]<br>";
			
			$ageny_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
		    $agency_desc = "(select catagen_label from cat_agencies where catagen_label = '".$agency."' )";
			
				$query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,load_date) 
				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$year."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$naics."',".$naics_id.",".$naics_desc.",'".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."',CURRENT_TIMESTAMP())";
		    //echo "Sources Sought:<br>".$query;
			//exit();  

		   $newfed_id  = QI($query);
		   $loaded_cnt=$loaded_cnt+1;
          $loaded_cnt_total=$loaded_cnt_total+1;

			$newfed_email = 'fed'.$ecnt.'_'.$office.'@bc2.com';
		 	$newfed_company = $agency."-".$office;

			LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$year,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file);

		
			$current_tag = '';
			$pdate = '';$year = '';$agency = '';$office = '';$location = '';$zip = '';$classcod = '';$naics = '';$offadd = '';$subject = '';$solnbr = '';$archdate = '';$contact = '';$link = '';$url = '';$setaside = '';$popcountry = '';$popaddress = '';$respdate = '';$email = ''; $naics_id = ''; $naics_desc = ''; $bc2_cert_desc =''; $bc2_cert_id =''; $ageny_id.''; $agency_desc = '';
			break;
			break;
				
		case "Combined Synopsis/Solicitation":
			$ecnt = $ecnt + 1;
			$processed_cnt = $processed_cnt + 1;
			$COMBINE = 2;
						
			if ((strlen($naics)) == 6)
			{
				$naics_id = "(select catskl_id from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			    $naics_desc = "(select catskl_text from cat_skills where substr(catskl_label,1,6) = ".$naics." )";
			}
			else
			{	
				$naics_id = 99;
				$naics_desc = "''";
			}
				
			$bc2_cert_desc = MapCerts ($setaside, $agency);		
			$bc2_cert_id = "(SELECT catcrt_id FROM cat_certs WHERE catcrt_desc = '".$bc2_cert_desc."' )";	
					
			$ageny_id = "(select catagen_id from cat_agencies where catagen_label = '".$agency."' )";
		    $agency_desc = "(select catagen_label from cat_agencies where catagen_label = '".$agency."' )";
	
			$query = "INSERT INTO FBO_IMPORT".$ROWBYROW ." (fed_company, fed_email,contact_email, File_Date, File_YY, Buying_Office, Agency_id, Agency_desc, Buying_Office_Address, NAICS, fed_naics_bc2, fed_naics_desc, Job_Title, Solicitation_num, Due_Date, Solicitation_Link, Setaside, Cert_desc, Cert_id,fed_contact,fbo_tag,file_name,load_date) 
				VALUES ('".$agency."-".$office."','fed".$ecnt."_".$office."@bc2.com','".$email."','".$pdate."','".$year."','".$agency."',".$ageny_id.",".$agency_desc.",'".$offadd."','".$naics."',".$naics_id.",".$naics_desc.",'".$subject."','".$solnbr."','".$respdate."','".$url."','".$setaside."','".$bc2_cert_desc."',".$bc2_cert_id.",'".$contact."','".$current_tag."','".$from_file."',CURRENT_TIMESTAMP())";
			//echo "Combined:<br>".$query;
			//exit();
				
		      $newfed_id  = QI($query);
		      $loaded_cnt=$loaded_cnt+1;
          $loaded_cnt_total=$loaded_cnt_total+1;
		 	$newfed_email = 'fed'.$ecnt.'_'.$office.'@bc2.com';
		 	$newfed_company = $agency."-".$office;

 LoadDataROWBYROW($newfed_id,$newfed_company,$newfed_email,$email,$pdate,$year,$agency,$ageny_id,$agency_desc,$offadd,$naics,$naics_id,$naics_desc,$subject,$solnbr,$respdate,$url,$setaside,$bc2_cert_desc,$bc2_cert_id,$contact,$current_tag,$from_file);


			$query = '';
		           		
			$current_tag = '';
			$pdate = '';$year = '';$agency = '';$office = '';$location = '';$zip = '';$classcod = '';$naics = '';$offadd = '';$subject = '';$solnbr = '';$archdate = '';$contact = '';$link = '';$url = '';$setaside = '';$popcountry = '';$popaddress = '';$respdate = '';$email = ''; $naics_id = ''; $naics_desc = ''; $bc2_cert_desc =''; $bc2_cert_id =''; $ageny_id.''; $agency_desc = '';
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
		$total_not_processed += 1;
		$y += 1;
		$x += 1;
		//echo "[total NOT processed y] = [".$y."]===>";
		//echo "[ ".$type." ]<br>";
	}
}

$result = Q("update fbo_load set day = ".$processedDate);

echo "[fbo_load has been updated]<br><br>";

echo "[total processed][ ".$total_processed."]<br>[total_not_processed][ ".$total_not_processed."]<br>";
 
$end_usrcount = QV("SELECT COUNT(*) FROM usr".$ROWBYROW);
$end_empcount = QV("SELECT COUNT(*) FROM emp".$ROWBYROW);
$end_jobcount = QV("SELECT COUNT(*) FROM job".$ROWBYROW);  
	   
echo "<br> <br> After this file usr count: " . $end_usrcount . "";
echo "  <br> After this file emp count: " . $end_empcount . "";
echo "  <br> After this file job count: " . $end_jobcount . "<br>";

echo  "\r\n \r\n <BR>End Processing for :  ".$FBOfile." << -- For This file, " .$processed_cnt."] were processed; ".$loaded_cnt. " records were loaded to FBO_IMPORT".$ROWBYROW. "<br>". date('Y-m-d H:i:s')."<br><br>";
 echo "\r\n<br>--------Also for FBO_IMPORT"        .$ROWBYROW. ", the following table counts were loaded: ";
 echo "\r\n<br>-----------emp_added_cnt: "     .	$emp_added_cnt;
 echo "\r\n<br>-----------emp_updated_cnt: "     .	$emp_updated_cnt;		
 echo "\r\n<br>----------usr_added_cnt: "        .	$usr_added_cnt;	
 echo "\r\n<br>-----------usr_updated_cnt: "      .	$usr_updated_cnt;		
 echo "\r\n<br>-----------usremp_added_cnt: "      . $usremp_added_cnt;	
 echo "\r\n<br>-----------usremp_updated_cnt: "      . $usremp_updated_cnt;
 echo "\r\n<br>---------- usr_edu_added_cnt: "      . $usr_edu_added_cnt;		
 echo "\r\n<br>----------usr_edu_updated_cnt: "      .	  $usr_edu_updated_cnt;		
 echo "\r\n<br>---------usr_clearance_added_cnt: "   .  $usr_clearance_added_cnt;		
 echo "\r\n<br>---------usr_clearance_updated_cnt: "  .	$usr_clearance_updated_cnt;		
 echo "\r\n<br>---------usr_app_added_cnt: "          . $usr_app_added_cnt;			
echo "\r\n<br>--------- usr_app_updated_cnt: "        .	$usr_app_updated_cnt;		
echo "\r\n<br>--------- job_added_cnt: "              .  $job_added_cnt;	
echo "\r\n<br>--------- job_updated_cnt: "            .	 $job_updated_cnt;	
echo "\r\n<br>--------- job_skills_added_cnt: "       .$job_skills_added_cnt;			
echo "\r\n<br>--------- job_skill_updated_cnt"        .$job_skill_updated_cnt;			
echo "\r\n<br>--------- job_certs_added_cnt:  "       .$job_certs_added_cnt;		
echo "\r\n<br>--------- job_certs_updated_cnt: "      .$job_certs_updated_cnt;		
echo "\r\n<br>---------  job_agencies_added_cnt: "    . $job_agencies_added_cnt;		
 echo "\r\n<br>---------  job_agencies_updated_cnt: " . $job_agencies_updated_cnt;	

      ob_flush();  
   flush(); 

//run running totals
$TotalRecordsLoaded = $TotalRecordsLoaded + $loaded_cnt;
$emp_added_cntruntotal =  $emp_added_cntruntotal + $emp_added_cnt;	
$emp_updated_cntruntotal= $emp_updated_cntruntotal+ $emp_updated_cnt;		
$usr_added_cntruntotal =  $usr_added_cntruntotal + $usr_added_cnt;		
$usr_updated_cntruntotal= $usr_updated_cntruntotal+ $usr_updated_cnt;		
$usremp_added_cntruntotal =  $usremp_added_cntruntotal + $usremp_added_cnt;		
$usremp_updated_cntruntotal= $usremp_updated_cntruntotal +  $usremp_updated_cnt;		
$usr_edu_added_cntruntotal = $usr_edu_added_cntruntotal + $usr_edu_added_cnt;		
$usr_edu_updated_cntruntotal= $usr_edu_updated_cntruntotal+ $usr_edu_updated_cnt;		
$usr_clearance_added_cntruntotal =  $usr_clearance_added_cntruntotal + $usr_clearance_added_cnt;		
$usr_clearance_updated_cntruntotal= $usr_clearance_updated_cntruntotal+$usr_clearance_updated_cnt;		
$usr_app_added_cntruntotal =  $usr_app_added_cntruntotal + $usr_app_added_cnt;		
$usr_app_updated_cntruntotal= $usr_app_updated_cntruntotal+$usr_app_updated_cnt;		
$job_added_cntruntotal =  $job_added_cntruntotal +$job_added_cnt;		
$job_updated_cntruntotal= $job_updated_cntruntotal+ $job_updated_cnt;		
$job_skills_added_cntruntotal =  $job_skills_added_cntruntotal +$job_skills_added_cnt;		
$job_skill_updated_cntruntotal= $job_skill_updated_cntruntotal+$job_skill_updated_cnt;		
$job_certs_added_cntruntotal = $job_certs_added_cntruntotal + $job_certs_added_cnt;		
$job_certs_updated_cntruntotal= $job_certs_updated_cntruntotal+$job_certs_updated_cnt;		
$job_agencies_added_cntruntotal =  $job_agencies_added_cntruntotal + $job_agencies_added_cnt;		
$job_agencies_updated_cntruntotal= $job_agencies_updated_cntruntotal+ $job_agencies_updated_cnt;		


$NumFilesProcessed = $NumFilesProcessed + 1;
$TotalFilesLoaded = $TotalFilesLoaded +1 ;


 
 $jobposttimes_insertSQL = "insert into jobposts_times (jobposttimes_job_id,jobposttimes_time,jobposttimes_type, jobposttimes_source) 
	   	                                         VALUES ('" .$end_jobcount."',CURRENT_TIMESTAMP(),'FBO', '". $FBOfile."')";
 $jobpost_times_new_id = QI($jobposttimes_insertSQL);
 echo "<br>\r\n 1510   jobpost_times_new_id: ".  $jobpost_times_new_id . " with " . $jobposttimes_insertSQL. "";
 
  	 rename ($FBOfile,	$fboprocessed_dir."/".$FBOprocessedfile); 



$query = "update fed_email_counter".$ROWBYROW." set fed_count = ".$ecnt;
mysql_query($query);

 echo ("\r\n \r\n <br>  Total Records processed for this run of FBO_IMPORT".$ROWBYROW. ": " . $TotalRecordsLoaded);

 echo ("<br> fed_count = ".$ecnt);    

$end_usrcount = QV("SELECT COUNT(*) FROM usr".$ROWBYROW);
$end_empcount = QV("SELECT COUNT(*) FROM emp".$ROWBYROW);
$end_jobcount = QV("SELECT COUNT(*) FROM job".$ROWBYROW);
echo "\r\n<br> <br> End of run  usr count: " . $end_usrcount . " ";
echo " \r\n <br> End of run emp count: " . $end_empcount . " ";
echo " \r\n <br> End of run job count: " . $end_jobcount . "<br>";

echo "\r\n<br> <br> Start of of run  usr count: " . $start_usrcount . "";

echo " \r\n<br> Start of of run emp count: " . $start_empcount . "";
echo "\r\n <br> Start of of run  job count: " . $start_jobcount . "<br>";


 echo "\r\n\r\n<br>---------Also for FBO_IMPORT"        .$ROWBYROW. ", the following total table load counts across all FBO files: " ;
 echo "\r\n\r\n<br>---------- emp_added_cntruntotal: "      . $emp_added_cntruntotal ;	
 echo "\r\n<br>----------emp_updated_cntruntotal: "     .	$emp_updated_cntruntotal;		
 echo "\r\n<br>----------usr_added_cntruntotal: "        .	$usr_added_cntruntotal;	
 echo "\r\n<br>----------usr_updated_cntruntotal: "      .	$usr_updated_cntruntotal;		
 echo "\r\n<br>----------usremp_added_cntruntotal: "     . $usremp_added_cntruntotal;	
 echo "\r\n<br>----------usremp_updated_cntruntotal: "     . $usremp_updated_cntruntotal;	
 echo "\r\n<br>--------- usr_edu_added_cntruntotal: "     . $usr_edu_added_cntruntotal;		
 echo "\r\n<br>---------usr_edu_updated_cntruntotal: "      .	  $usr_edu_updated_cntruntotal;		
 echo "\r\n<br>---------usr_clearance_added_cntruntotal: "   .  $usr_clearance_added_cntruntotal;		
 echo "\r\n<br>---------usr_clearance_updated_cntruntotal: " .	$usr_clearance_updated_cntruntotal;		
 echo "\r\n<br>---------usr_app_added_cntruntotal: "         . $usr_app_added_cntruntotal;			
echo "\r\n<br>--------- usr_app_updated_cntruntotal: "        .	$usr_app_updated_cntruntotal;		
echo "\r\n<br>--------- job_added_cntruntotal: "              .  $job_added_cntruntotal;	
echo "\r\n<br>--------- job_updated_cntruntotal: "            .	 $job_updated_cntruntotal;	
echo "\r\n<br>--------- job_skills_added_cntruntotal: "       .$job_skills_added_cntruntotal;			
echo "\r\n<br>--------- job_skill_updated_cntruntotal: "      .$job_skill_updated_cntruntotal;			
echo "\r\n<br>--------- job_certs_added_cntruntotal:  "       .$job_certs_added_cntruntotal;		
echo "\r\n<br>--------- job_certs_updated_cntruntotal: "      .$job_certs_updated_cntruntotal;		
echo "\r\n<br>---------  job_agencies_added_cntruntotal: "    . $job_agencies_added_cntruntotal;		
 echo "\r\n<br>---------  job_agencies_updated_cntruntotal: " . $job_agencies_updated_cntruntotal;	
 
 
echo ("\r\n\r\n\r\n<br><br><br>EOJ: Total Number of FBO Files Processed: " .  $NumFilesProcessed  . "  run done at". date('Y-m-d H:i:s')." ");
echo ("\r\n<br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;          runstarttime: " .$runstarttime);//.yrow to test email and contact capture; do not do other table updates

?>



