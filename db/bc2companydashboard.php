<?php 
//   companies dashboard
//-- page settings
session_start();
   

define('C3cms', 1);
$title = "Member Company Dashboard";
$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
//$template = "jobcon".$_SESSION['$usempempid'] ; 
$response = "content"; 
$_SESSION['$usempempid'] = ""; ////  "_empid";
$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
$template = "jobcon"; 

require "inc/core.php";


//-- define content -----------------------------------------------------------------
 
$userID = 0;
$userType = $_SESSION['usr_type'];
$userCompany = 0;
if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; 
$_SESSION['view_id'] = $userID;
$sess_email = $_SESSION['usr_email'] ;
$userCompany = $_SESSION['usr_company']; 
// $content .="<br> sess comdash_exists: " .$_SESSION['$comdash_exists'] . "<br>";
//$content .= "Hello, You have reached Company Dashboard -not yet implemented <br/>";/////$content .= "<br>Session variables: <br>" . $_SESSION  . " ||||<br> "  ;//print _r($ _ SESSION);
//$content .=  DBContent(); 


   	$content.= "<!-- SESSION['randashbdusrMatches'] before unset: >>|" .$_SESSION['randashbdusrMatches'] . "|<<  -->";

	if (isset($_SESSION['randashbdusrMatches'])) unset  ($_SESSION['randashbdusrMatches']);
	$content.= "<!-- SESSION['randashbdusrMatches'] after unset: >>|" .$_SESSION['randashbdusrMatches'] . "|<<-->";
  
/************************************************************/
/*******SCROLL BEGIN******/
$scrollit = 360;
$link_color="#cccccc";
 $linkbgcolor="#aaaaaa";
 $headerheight ="80";
 $halfheaderheight="40";
 $height="60";
 $content .= DBContent();
 $content .="<div>";
$content .= '<table align="center" width="700">
<tbody>
<tr>
<td valign="Top" width="700" align="center"> ';
 
 $content .= DBContent();
 $content .= '<div class="container" style="border:0px solid #ccc; width:700px; height: '.$scrollit.'px; overflow-y: scroll;">';

$content .= '<table cellspacing="1" class="winner-table"  >
<tbody>
 
<tr><td> <!-- SESSION[usr_auth]: '.  $_SESSION['usr_auth'].', sess comdash_exists: ' .$_SESSION['$comdash_exists'] . ', my_pagename: ' .  basename($_SERVER['PHP_SELF']) . ' --></td></tr>
<tr><td align="center" width="100%" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;"><strong>Your Company Dashboard</strong>'; 
 /*  old
$getcompanylistquery =" select usr.usr_id, usr.usr_firstname,usr.usr_lastname,usr.usr_prefix,usr.usr_auth,usr.usr_company,usr.usr_type ";
$getcompanylistquery .= " ,emp.emp_id , emp.emp_name, usemp.usremp_usr_assignedusr_id,usr.usr_id, usemp.usremp_usr_id ";
 $getcompanylistquery .= " from usr usr inner join emp emp on usr.usr_company=emp.emp_id 
                          inner join usr_emp usemp on usemp.usremp_usr_id = usr.usr_id  ";
  $getcompanylistquery .= " where usemp.usremp_usr_assignedusr_id = ". $_SESSION['usremp_usr_assignedusr_id'] ;*/
  
  $getcompanylistquery =" select usr.usr_id, usr.usr_firstname,usr.usr_lastname,usr.usr_prefix,usr.usr_auth,usr.usr_company,usr.usr_type ";
$getcompanylistquery .= " ,emp.emp_id , emp.emp_name, usemp.usremp_usr_assignedusr_id,usr.usr_id, usemp.usremp_usr_id ";
 $getcompanylistquery .= " from usr_emp usemp inner join emp emp on usemp.usremp_emp_id =emp.emp_id 
                          inner join usr usr on usemp.usremp_usr_assignedusr_id = usr.usr_id /*inner join usr_emp usemp on*/ and  usemp.usremp_emp_id=emp.emp_id ";
  $getcompanylistquery .= " where emp.emp_level > 0 and usemp.usremp_usr_assignedusr_id = ". $_SESSION['usremp_usr_assignedusr_id'] ;

  
 $content .= "<!--  br> trace 54 getcompanylistquery: " .  $getcompanylistquery . " -->";
   if ($result=mysqli_query($conn, $getcompanylistquery)){    // 1
	  if (mysqli_num_rows($result)>0) {//2	
	  
                        
			           	    
	      $numrows = mysqli_num_rows($result);
		  $rcnt = 1;
		  $bool1 = 1;
	$content .= ' <br/>  Click one of the '. $numrows.' companies below to log in to with your login name: '.$sess_email. ' </td> </tr> '; 
	//<br>  Click on a company link below to log in to  that company; your login name: '.$sess_email. ' </td> </tr> '; <br> 
	// Click on a company link below to log in to  that company; your login name: '.$sess_email. ' </td> </tr> ';
		  while ($co_dashrow = mysqli_fetch_array($result, MYSQLI_ASSOC))      {    // 3                          if ($  a & 1) {    echo 'odd';} else {    echo 'even';}  
		    if ($rcnt & $bool1 )	 //  if (is_int($rcnt/2))
			  {$linkbgcolor = "#cccccc"; 
		       } else 
		       {$linkbgcolor = "#999999";
		       }
 			    //frombc2codash
 			    $thiscompanyname = $co_dashrow['emp_name'];
 			     $strcompanyname = str_replace("&", "AND",$thiscompanyname,  $cocount);//
 			    $content .=  '<tr ><td  width="640" height="40"  bgcolor="'.$linkbgcolor.'" align="center"><font color="'.$link_color.'"><strong>
 			                  <a href="index'.$_SESSION['$usempempid'].'.php?ptype=frombc2codash&noop=frombc2codash&company_id='.$co_dashrow['emp_id'].
 			                 '&assignedusr_id='.$co_dashrow['usremp_usr_assignedusr_id'].'&usr_firstname='.$co_dashrow['usr_firstname'].'&usr_lastname='.$co_dashrow['usr_lastname'].
 			                 '&usr_prefix='.$co_dashrow['usr_prefix'].'&usr_auth='.$co_dashrow['usr_auth'].'&usr_auth_orig='.$co_dashrow['usr_auth'].
 			                  '&usr_type='.$co_dashrow['usr_type'].'&emp_name='.$strcompanyname.'">'.$co_dashrow['emp_name'].'</a></strong></font></td></tr>';
 			                  
 			    
 			    	//$_SESSION['usr_id'] = $co_dashrow['usr_id'];				         //	$_SESSION['usr_firstname'] = $co_dashrow['usr_firstname'];
				         //	$_SESSION['usr_lastname'] = $co_dashrow['usr_lastname'];				         //	$_SESSION['usr_prefix'] = $co_dashrow['usr_prefix'];
				         //	$_SESSION['usr_auth'] = $co_dashrow['usr_auth'];				         //	$_SESSION['usr_auth_orig'] = $co_dashrow['usr_auth'];
				         	//echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';				        //	$_SESSION['usr_company'] = $co_dashrow['usr_company'];
				         //	$_SESSION['usr_type'] = $co_dashrow['usr_type'];			         		//$_SESSION['admin_user'] = 0;
 			    
 			    
 			    $rcnt +=   1 ;
		      } //3
		} //2
    } // 1   
    
$content .= '<tr><td align="center" width="100%" colspan="1" height="'.$halfheaderheight.'" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';
 
////$content .= DBContent();
 $content .= '    </td></tr>';
$content .= '</td></tr></tbody>
</table>';

$content .=  '</div>';

$content .= '</td></tr></tbody></table>';
/******* SCROLL END *******/
//} // 1==1      2
////$content .= DBContent();
$content .= '<div>';
 //$content .= DBContent();
$content .= '</div>';
$content .= '</div>';
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; ?>


