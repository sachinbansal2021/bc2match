<?php
if (!defined('C3cms')) die('');
define('C3cmsCore', 1);
// Initiliaztion ---------------------------------------------------------------------
	// Variables
	
//lloyd contact
// to test company specif criteri
///$usempempid = "_empid";
$_SESSION['$usempempid'] = "";
$usempempid= $_SESSION['$usempempid'] ;
$my_pagename = basename($_SERVER['PHP_SELF']);
//echo (" $my_pagename" . $my_pagename  . " - " . basename($_SERVER['PHP_SELF']) );
	$corefindme   = 'contactus';
    $corepos = strpos($my_pagename , $corefindme);

file_put_contents("a_Pagename", $my_pagename);    

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($corepos === false) {
   // echo "The string '$findme' was not found in the string '$my_pagename'";
   $_SESSION['contactus'] = 0;
} else {
   // echo "The string '$findme' was found in the string '$mystring'";
   //  echo " and exists at position $pos";
  // So contactus is the page
  $corepos = 1;
   $_SESSION['contactus'] = 1;
}
//echo ("<br>from core line 25  $ _ SESSION [ contactus]: " .  $_SESSION['contactus']);

$siteTmpPath = '/home/cccsol818/tmp/';
$buffer = ''; $content = ''; $reqDebug = ''; 
$headerScript = ''; $footerScript = ''; $scriptLinks = '';
$adminNav=''; $nav1=''; $nav2='';
$cssInline=''; $cssLinks='';
//$sessionPath = '/home/upojobco/tmp';
	// Session
//session_save_path($sessionPath);
//ini_set('session.gc_maxlifetime',28800); // 8 hours (in seconds) [default 1440 == 24 minutes]
//ini_set('session.gc_probability',1);
//ini_set('session.gc_divisor',1);
//if (!isset($_SESSION['usr_id'])) 
// server should keep session data for AT LEAST 1 hour
//ini_set('session.gc_maxlifetime', 3600);

// each client should remember their session id for EXACTLY 1 hour
//session_set_cookie_params(3600);	

session_start();

/***********************************************
When moving from one environment to another
1. Change ENVIRONMENT VARIABLES
2. Change Database Connection Info
***********************************************/
/* 10/3/19 2051 Hey Lloyd,
 
Can you take a look at this for us. I believe that you did some work on the timeout settings for the bc2match application.
 
We would like the the following page to come up when the timeout occurs:     http://www.bc2match.com/index.htm
 
Also, can you tell me how you configured the setting that controls when to activate the timeout?
 
Thanks
 
-Larry
Lloyd: I will try the following

Top of every page (in core?):

if isset($_SESSION['bc2last_activity'] check_inactivetimeout();
check_inactivetimeout()
if( $_SESSION['bc2last_activity'] < time()-$_SESSION['bc2expire_time'] ) { //have we expired?
    //redirect to logout.php
    header('Location: http://yoursite.com/logout.php'); //change yoursite.com to the name of you site!!
    for dev,demo prod   --   
    header('Location: $_SESSION['env']/logout.php'); //change to the name of you site!!
  x for demo or prod header()
      xheader('Location: http://yoursite.com/logout.php'); //change yoursite.com to the name of you site!!
      x header('Location: /logout.php'); //change yoursite.com to the name of you site!!

} else{ //if we haven't expired:
    $_SESSION['bc2last_activity'] = time(); //this was the moment of last activity.
}
Top of page where land after successful loginin:
  set_inactivetimeout()
$_SESSION['bc2logged_in'] = true; //set you've logged in
$_SESSION['bc2last_activity'] = time(); //your last activity was now, having logged in.'inactive_time0ut'
$_SESSION['bc2inactive_timeout'] = 45; // 45 seconds // 30*60; 30 minutes     //3*60*60; 3 hours
$_SESSION['bc2expire_time'] = 3*60*60; //expire time in seconds: three hours (you must change this) = test with 30 secs
$_SESSION['bc2expire_time'] = $_SESSION['bc2inactive_timeout']; //expire time in seconds: test with 30 secs

 */
//bc2dev
//$ _ SESSION['env'] = 'bc2dev/db';

//bc2test
//$ _ SESSION['env'] = 'bc2test/db';

//bc2demo
//$ _ SESSION['env'] = 'bc2demo/db';

//bc2wp
//$_SESSION['env'] = 'bc2wp/db';

//bc2prod
$_SESSION['env'] = 'db';

$siteWebRoot = 'http://www.bc2match.com/'.$_SESSION['env'].'/';
$siteFileRoot = '/home/cccsol818/public_html/'.$_SESSION['env'].'/';

//echo "webroot = ".$siteWebRoot."<br>fileroot = ".$siteFileRoot;


$activepage = $_REQUEST['page'] or $activepage = $_SESSION['sys_activepage'] or $activepage = '';


// Database

//bc2dev
/*
$server="localhost";
$db="cccsol81_bc2dev";
$user="cccsol81_bc2dev";
$password="bc2dev.ccc818";
*/

//bc2test
/*
$server="localhost";
$db="cccsol81_bc2test";
$user="cccsol81_bc2test";
$password="bc2test.ccc818";
*/

//bc2demo
/*
$server="localhost";
$db="cccsol81_bc2demo";
$user="cccsol81_bc2demo";
$password="bc2demo.ccc818";
*/

//bc2prod
/**/
$server="localhost";
$db="cccsol81_bc2prod";
$user="cccsol81_bc2prod";
$password="bc2prod.ccc818";






//$link = mysqli_connect("localhost", "my_user", "my_password", "test", );

$conn = mysqli_connect($server, $user, $password, $db) or die('Could not connect to the MySQL database server');
//mysqli_select_db($link, $db) or die('Could not select the specified database.');
//print_r($_REQUEST);	
 // print_r($_SESSION);	
 //
 $content.= '<!-- _SESSION[env]: '. $_SESSION['env']. ' Location: '.$_SESSION['env']. '/logout.php  '
 .   'siteWebRoot: '.  $siteWebRoot .'-->';
 if (isset($_SESSION['bc2last_activity']))  check_inactivetimeout();
// Login --------------------------------------------------------------------
 
//$content.= '<!-- core line 84 re op=' .$_REQUEST['op'] .', get op=' . $_GET ['op']  .', post op=' . $_POST ['op']  . ', req ptype: ' .  $_REQUEST['ptype'] . ', get ptype: ' .  $_GET['ptype'] . ', post ptype: ' .  $_POST['ptype']  . '-->';
//$content .= "<!-- br> Session: ".$_SESSION. "<br> request: " . $_REQUEST . "<br>,  GET: " . $_GET . " <br> ,POST: " . $_POST . " -->";
if (!(isset($_SESSION['tracemy']))) $_SESSION['tracemy'] = 1 ; else  $_SESSION['tracemy'] += 1;
//// echo("<br> SESSION: "); 
 $_SESSION['tracemysess'] = print_r($_SESSION,true) . '<br>'; // echo("<br>"); echo("<br> REQUEST: ");
 $_SESSION['tracemyreq'] = print_r($_REQUEST,true) . '<br>'; //echo("<br>");  echo("<br>  GET: ");
  $_SESSION['tracemyget'] = print_r($_GET,true) . '<br>';  // echo("<br>");   echo("<br>  POST: ");
 $_SESSION['tracemypost'] = print_r($_POST,true) . '<br>';
// $content .= '<!-- br>line 92 core  Session: ';
 //$content .=  print_r($_SESSION,true) . '---br -->';  

 ////echo("<br>");
////echo ( "<br> core line 84: content = " . $content);
//////if (isset($_REQUEST['op']))  //-2
//////{
 // Login --------------------------------------------------------------------
 //echo "I am here  ".$_REQUEST['op'];exit();
 
 if (isset($_REQUEST['op'])) // -1
 {
   //  print_r($_REQUEST);	
if (($_REQUEST['op']=='login')||('tjohnson@setasidealert.com'==Clean($_REQUEST['username'])) ||('jonr@bc2match.com'==Clean($_REQUEST['username']))||('larry@ljfenterprises.com' == Clean($_REQUEST['username']))) //0
	{ 
	   	$_SESSION['$comdash_exists'] = 'no';
		$query = "SELECT * FROM usr WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
		
		

//		if ($result=mysql_query($query))  //1
        $result = Q($query);
        
        if ($result)
		{
			if  (mysqli_num_rows($result)>0)  //2
			{
			    set_inactivetimeout();
				$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$_SESSION['usr_id'] = $row['usr_id'];
				$_SESSION['usr_firstname'] = $row['usr_firstname'];
				$_SESSION['usr_lastname'] = $row['usr_lastname'];
				$_SESSION['usr_prefix'] = $row['usr_prefix'];
				$_SESSION['usr_auth'] = $row['usr_auth'];
				$_SESSION['usr_auth_orig'] = $row['usr_auth'];
				//echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
				$_SESSION['usr_company'] = $row['usr_company'];
				$_SESSION['usr_type'] = $row['usr_type'];
				//$_SESSION['admin_user'] = 0;
				if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_type'] == 99)) $_SESSION['admin_user'] = $_SESSION['usr_id']; //3 -3
				//echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'];exit();
				$resultlogin = Q("UPDATE usr SET usr_lastlogin = '" . date('Y-m-d H:i:s') . "', usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id = '" . $_SESSION['usr_id'] . "';");	
				$usr_login = QI("INSERT INTO usr_login (login_usr_id, login_date) VALUES (".$_SESSION['usr_id'].",'".date('Y-m-d H:i:s')."')");
				$_SESSION['u-search_results'] = 0;
				$_SESSION['newcompany'] = 0;
				
                
//echo ('line101 core.php ' . ', '.  $_REQUEST['username'] . ','.$_SESSION['usr_lastname'] .', '.$_SESSION['usr_firstname'].', '.$_SESSION['usr_auth'] .', '.$_SESSION['usr_company'].', '. $_SESSION['usr_type']);
	$content .= "  '<!--  <br>LINE 128 login core  Session: ";
	$content .= print_r($_SESSION,true) . 'br  -->';  
				switch($_SESSION['usr_auth']) { //3
					case "1": header("Refresh: 1; url=/".$_SESSION['env']."/applicants".$usempempid.".php"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/employers".$usempempid.".php"); die(); break;
					case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members.php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die(); break;
					//case "1": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					case "3": header("Refresh: 1; url=/".$_SESSION['env']."/admin_app.php"); die(); break;
					case "4": header("Refresh: 1; url=/".$_SESSION['env']."/admin_rep.php"); die(); break;
					case "5": case "6": header("Refresh: 1; url=/".$_SESSION['env']."/admin_emp.php"); die(); break;
					case "7": case "8": header("Refresh: 1; url=/".$_SESSION['env']."/admin_usr.php"); die(); break;
					case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;
					//case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members"); die(); break;
				} // end if 	switch($_SESSION['usr_auth'])      //-3
		  if ($_SESSION['usr_auth']==2  ) {	      header("Refresh: 1; url=".$_SESSION['env']."/bc2members".$usempempid.".php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die();} //lloyd 10/7/18  3 -3
			} //end	if ??? -// (mysql_num_rows($result)>0)  //2
		}   // end 	if ($result=mysql_query($query)))  //1
		else
		{
		    //echo "You username or password is invalid";
		    header("Refresh: 1; url=/".$_SESSION['env']."/loginfailed.php"); die();
    
		}

		    
	} elseif ( ($_REQUEST['op']=='newemaillogin') )  //|| ($_REQUEST['op']=='logintoexistco')) // used to be end 12/8 could use for joinnow login	if ($_REQUEST['op']=='login') 0
	                                                                     //^ if that we have company company_id and name emp_name REQUEST variables
	 
	   /*
	   http://bc2match.com/bc2dev/index.php
	                   ?ptype=coexistsjoin&op=loginexistco&company_id=409613&assignedusr_id=400329&usr_firstname=Lloyd&lastname=Palmer
	                   &usr_type=0&usr_auth=2&username=lloydpalmer@yahoo.com&emp_name=Palmer Assocates11
	   */
        {  //echo("<!-- core line132 req op=".$_REQUEST['op'] ."-->");
        //echo "I am here";exit();
        
            // check to see if email in system and if "so, authenticate its root usr_id usremp_usr_assignedusr_id  
       	  $checke_mailquery =" select emp.emp_id , emp.emp_name, usemp.usremp_usr_assignedusr_id,usr.usr_id, usemp.usremp_usr_id
            from usr usr inner join  emp emp on usr.usr_company = emp.emp_id
            inner join usr_emp usemp on usemp.usremp_usr_assignedusr_id = usr.usr_id
            /* inner join usr_emp usemp on usemp.usremp_usr_id = usr.usr_id */
            /* inner join usr_emp usemp on  usemp.usremp_emp_id =emp.emp_id */
			 where usr.usr_email = '" . Clean($_REQUEST['username']) . "'AND usr_password = '" . sha1($_REQUEST['password']) . "'" ;
file_put_contents("Troubleshoot", $checke_mailquery);			 
			 $_SESSION['usr_email'] = Clean($_REQUEST['username']);
			  $queryfirstco = $checke_mailquery;                   //echo( "query: " .  $query);
			   //echo("checke_mailquery: " . $checke_mailquery);exit();
			   
            //if ($resultfirstco=mysql_query($queryfirstco))  //1
            
            $resultfirstco=Q($queryfirstco);
            
            if ($resultfirstco)  //1
	           {
	               //echo "I am here [".$resultfirstco."]";exit();
	               //now we know we have a valid usrname and pwd - now get and show all of his/her companies if more than one
		         $numresultrows = mysqli_num_rows($resultfirstco);
		         if  (mysqli_num_rows($resultfirstco)> 0)   //+2  should be exactly  1
		           set_inactivetimeout();
		            $row = mysqli_fetch_array($resultfirstco, MYSQLI_ASSOC);
		            $_SESSION['usr_id'] = $row['usremp_usr_assignedusr_id'];
		            $_SESSION['usremp_usr_assignedusr_id']  =  $_SESSION['usr_id'] ;
		             ///// { $_SESSION['companydashboard_exists'] ="no";  // just one so do the old way no company dashboard
		             $_SESSION['linenum'] = 143;
		          /////    print_r($_SESSION);
                 	   $query = "SELECT * FROM usr WHERE usr_id =" .$_SESSION['usr_id']   ;  // get usr info to populate session vars
	        	       if ($result=mysqli_query($conn, $query)) //3
	                 	{
		         	     if  (mysqli_num_rows($result)>0)   //4
		                  {
			   	         	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
				         ////	$_SESSION['usr_id'] = $row['usr_id'];
				         	$_SESSION['usr_firstname'] = $row['usr_firstname'];
				         	$_SESSION['usr_lastname'] = $row['usr_lastname'];
				         	$_SESSION['usr_prefix'] = $row['usr_prefix'];
				         	$_SESSION['usr_auth'] = $row['usr_auth'];
				        //echo "Session Auth[ ".$_SESSION['usr_auth']." ]"; exit();
				         	$_SESSION['usr_auth_orig'] = $row['usr_auth'];
				         	//echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
				         	$_SESSION['usr_company'] = $row['usr_company'];
				         	$_SESSION['usr_type'] = $row['usr_type'];
			         		//$_SESSION['admin_user'] = 0;
			           	    if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_type'] == 99)) $_SESSION['admin_user'] = $_SESSION['usr_id']; // 5  -5
				              //echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'];exit();
			            	$resultlogin = Q("UPDATE usr SET usr_lastlogin = '" . date('Y-m-d H:i:s') . "', usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id = '" . $_SESSION['usr_id'] . "';");	
			            	$usr_login = QI("INSERT INTO usr_login (login_usr_id, login_date) VALUES (".$_SESSION['usr_id'].",'".date('Y-m-d H:i:s')."')");
				            $_SESSION['u-search_results'] = 0;
				            $_SESSION['newcompany'] = 0;
				            $_SESSION['linenum'] = 166;
				        ////    print_r($_SESSION);
                           //echo ('line101 core.php ' . ', '.  $_REQUEST['username'] . ','.$_SESSION['usr_lastname'] .', '.$_SESSION['usr_firstname'].', '.$_SESSION['usr_auth'] .', '.$_SESSION['usr_company'].', '. $_SESSION['usr_type']);
				            // 
                         
		                  }  //- 4
	                 	} //-3
	                 	//get the companies
	                 	/*
	                 	select usr.usr_id, usr.usr_firstname,usr.usr_lastname,usr.usr_prefix,usr.usr_auth,usr.usr_company,usr.usr_type  ,emp.emp_id 
	                 	, emp.emp_name, usemp.usremp_usr_assignedusr_id,usr.usr_id, usemp.usremp_emp_id,usemp.usremp_usr_id 
	                 	from usr_emp usemp   inner join emp emp on usemp.usremp_emp_id = emp.emp_id  
                          inner join usr usr on usemp.usremp_usr_id = usr.usr_id   where usemp.usremp_usr_assignedusr_id = 400329
	                 	*//*
	                 	/*	$getcompanylistquery =" select emp.emp_id , emp.emp_name, usemp.usremp_usr_assignedusr_id,usr.usr_id, usemp.usremp_usr_id ";
                         $getcompanylistquery .= " from usr usr inner join emp emp on usr.usr_company=emp.emp_id inner join usr_emp usemp on usemp.usremp_emp_id=emp.emp_id ";
                          $getcompanylistquery .= " where usemp.usremp_usr_assignedusr_id = '". $_SESSION['usremp_usr_assignedusr_id'] ."'";
	                  */
	                 	$getcompanylistquery =" select emp.emp_id , emp.emp_name, usemp.usremp_usr_assignedusr_id,usr.usr_id, usemp.usremp_usr_id ";
                         $getcompanylistquery .= " from usr_emp usemp inner join emp emp on usremp_emp_id = emp.emp_id 
                          inner join usr usr on usemp.usremp_usr_id=usr.usr_id ";
                          $getcompanylistquery .= " where usemp.usremp_usr_assignedusr_id = '". $_SESSION['usremp_usr_assignedusr_id'] ."'";
                          $content.= "<!-- br> trace core empid 232 getcompanylistquery: " . $getcompanylistquery . " --> ";
	                    //// $getcompanylistquery .= " where usr.usr_email='".Clean($_REQUEST['username']) . "'";
	                     $query_co =  $getcompanylistquery;
		             if ($result_co=mysqli_query($conn, $getcompanylistquery))   //3          
		 	         {  $mynumrowsco = mysqli_num_rows($result_co);   
		               $_SESSION ['multi_company']=$mynumrowsco;  
		 	          
		 	             $_SESSION['linenum'] = 180;
		 	        ////    print_r($_SESSION);
		 	           $usr_welcome_flagSQL = "select usr_welcome_flag from usr where usr_id =".$_SESSION['usr_id']."";
                       $usr_welcome_flag = QV($usr_welcome_flagSQL);
		 	           
		 	           if ($usr_welcome_flag == 0)
		 	                $startpage = "/applicants";
		 	           else
		 	                $startpage = "/bc2members";
		 	                
		 	                
                       if ($mynumrowsco==1)   //   we can just go to user first page  //4  _empid
		                {
		                    $_SESSION['$comdash_exists'] = 'no';
		                    	$content .= " '<!--<br>LINE 216 newemaillogin core one company Session: ";
                             	$content .= print_r($_SESSION,true) . 'br -->';  
                             	if(basename($_SERVER['PHP_SELF'])!="payment.php"){
    				                switch   ($_SESSION['usr_auth']) {    //5
        					           case "1": header("Refresh: 1; url=/".$_SESSION['env']."/applicants.".$usempempid."php"); die(); break;
        					          //case "2": header("Refresh: 1; url=/".$_SESSION['env']."/employers"); die(); break;
        					          case "2": header("Refresh: 1; url=/".$_SESSION['env'].$startpage.$usempempid.".php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die(); break;
        					           //case "1": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
        					          //case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
        					          case "3": header("Refresh: 1; url=/".$_SESSION['env']."/admin_app.php"); die(); break;
        					          case "4": header("Refresh: 1; url=/".$_SESSION['env']."/admin_rep.php"); die(); break;
        					          case "5": case "6": header("Refresh: 1; url=/".$_SESSION['env']."/admin_emp.php"); die(); break;
        					          case "7": case "8": header("Refresh: 1; url=/".$_SESSION['env']."/admin_usr.php"); die(); break;
        					          case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;
        					          //case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members"); die(); break;
    				                } // end if 	switch($_SESSION['usr_auth'])     -5  
    				                if ($_SESSION['usr_auth']==2  ) {  header("Refresh: 1; url=".$_SESSION['env'].$startpage.$usempempid.".php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die();} //lloyd 10/7/18 5 -5
                             	}
                       } else     //4   if  (mysql_num_rows($resultco)==1)  //4
                      { //at least two  companies  4
                        $pageName = basename($_SERVER['PHP_SELF']);
                         $_SESSION['linenum'] = '<br>core line 235';
		 	            $_SESSION['$mynumrowsco'] =$mynumrowsco ; 
		 	            
		 	            $_SESSION['$comdash_exists'] ='yes';
		 	            	$content .= "<!--  br>LINE 239 newemaillogin core many companyies Session: ";
                             	$content .= print_r($_SESSION,true) . 'br  -->';  
		 	            //// print_r($_SESSION);
                       // header("Refresh: 1; url=/".$_SESSION['env']."/bc2companydashboard.php"); die();  //show the ompany dashboard
                       if($pageName!="payment.php"){
                          header("Refresh: 1; url=bc2companydashboard".$_SESSION['$usempempid'].".php");// die();  //show the ompany dashboard
                       }
            
            
                        } //-4			     
                  } //end   if ($result_co=mysql_query($getcompanylist)) 3   
		       
                }      // 2 if ($result_co=mysql_query($query_co))
                else
		        {
		            //echo "You username or password is invalid";
		            header("Refresh: 1; url=/".$_SESSION['env']."/loginfailed.php"); die();
    
		        }
		       } // end if ($result_id=mysql_query($query_id)) 1  
		     // end if  (mysql_num_rows($result)>0) 1
	    
	} elseif  ($_GET['op']=='frombc2codash')    //0 frombc2codash  // (($_REQUEST['op']=='frombc2codash') ||shuld not happen
	 {
	     $content.= '<!--tracemygetcore line 251 if req op or get op frombc2codask  re op=' .$_REQUEST['op'] .', get op=' . $_GET ['op']. ' -->';
	     // $_SESSION['tracemyget'] .= $content; 
	 //    $content.= 'core line 83 re op=' .$_REQUEST['op'] .', get op=' . $_GET ['op'] . '-->';
// http://www.bc2match.com/bc2dev/index.php?op=frombc2codash&company_id=395260&assignedusr_id=400329&usr_firstname=Lloyd&usr_lastname=Palmer&usr_prefix=&usr_auth=2&usr_auth_orig=2&usr_type=99&emp_name=Carroll Publishing			    
 			    set_inactivetimeout();     
	    // get all user data except company id and nameso just need the switch
         $_SESSION['usr_id']        =   $_GET['assignedusr_id'];  // $_REQUEST ['assignedusr_id'];     //$row['usr_id'];
		         $_SESSION['usr_firstname']  = $_GET['usr_firstname'];   // $_REQUEST['usr_firstname'];        //   $row['usr_firstname'];
		         $_SESSION['usr_lastname']  =  $_GET['usr_firstname'];  //    $_REQUEST['usr_lastname'];         //$row['usr_lastname'];
		         $_SESSION['usr_prefix']    =   $_GET['usr_prefix'];  // $_REQUEST['usr_prefix'];           //$row['usr_prefix'];
		         $_SESSION['usr_auth']      = $_GET['usr_auth']; // $_REQUEST['usr_auth'];             //$row['usr_auth'];
		         $_SESSION['usr_auth_orig'] = $_GET['usr_auth']; // $_REQUEST['usr_auth'];             //$row['usr_auth'];     //echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
		         $_SESSION['usr_company']   = $_GET['company_id'];  //   $_REQUEST['company_id'];           //$row['usr_company'];
		         $_SESSION['usr_type']      = $_GET['usr_type'];   // $_REQUEST['usr_type'];             // $row['usr_type'];
		        //$_SESSION['admin_user'] = 0;
	        if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_type'] == 99)) $_SESSION['admin_user'] = $_SESSION['usr_id']; 
		        //echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'];exit();
		      $resultlogin=Q("UPDATE usr SET usr_lastlogin = '" . date('Y-m-d H:i:s')."', usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id='".$_SESSION['usr_id']."';");	
		      $usr_login = QI("INSERT INTO usr_login (login_usr_id, login_date) VALUES (".$_SESSION['usr_id'].",'".date('Y-m-d H:i:s')."')");
	        $_SESSION['u-search_results'] = 0;
	        $_SESSION['newcompany'] = 0;	    
	    		                    	$content .= "<!--  br>LINE 275 frombc2codash core   Session: ";
                             	$content .= print_r($_SESSION,true) . 'br -->';  
	       	//  print_r($_SESSION);
      	switch($_SESSION['usr_auth']) {  //1
					case "1": header("Refresh: 1; url=/".$_SESSION['env']."/applicants".$usempempid.".php"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/employers"); die(); break;
				//	case "2": header("Refresh: 1; url=bc2members".$usempempid.".php"); die(); break;
					//case "1": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					case "3": header("Refresh: 1; url=/".$_SESSION['env']."/admin_app.php"); die(); break;
					case "4": header("Refresh: 1; url=/".$_SESSION['env']."/admin_rep.php"); die(); break;
					case "5": case "6": header("Refresh: 1; url=/".$_SESSION['env']."/admin_emp.php"); die(); break;
					case "7": case "8": header("Refresh: 1; url=/".$_SESSION['env']."/admin_usr.php"); die(); break;
					case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;
					//case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members"); die(); break;
				    }  // 1
                   
				    if ($_SESSION['usr_auth']==2  ) {header("Refresh: 1; url=bc2members".$usempempid.".php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die();  } //lloyd 10/7/18 // 1 1
	 
    }   else     { set_inactivetimeout();
                 Q("UPDATE usr SET usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id = '" . $_SESSION['usr_id'] . "';"); //0  0 
    }
 if  ( $_REQUEST['ptype']=='frombc2codash')    ////(($_REQUEST['ptype']=='codash') || ($_GET['ptype']=='frombc2codash') || ( $_REQUEST['ptype']=='frombc2codash') )  //0
	 {
	        $content.= ' <!-- br>tracemygetcore line 292 if req op or get op frombc2codask  re ptype=' .$_REQUEST['ptype'] .', get ptype=' . $_GET ['ptype'] . ' --> ';
          // $_SESSION['tracemyget'] ;  
// http://www.bc2match.com/bc2d ev/index.php?op=frombc2codash&company_id=395260&assignedusr_id=400329&usr_firstname=Lloyd&usr_lastname=Palmer&usr_prefix=&usr_auth=2&usr_auth_orig=2&usr_type=99&emp_name=Carroll Publishing			    
 			        
	    // got all user data except company id and nameso just need the switch
                  $_SESSION['usr_id']        = $_REQUEST['assignedusr_id'];       //$row['usr_id'];assignedusr_id
		         $_SESSION['usr_firstname'] = $_REQUEST['usr_firstname'];        //   $row['usr_firstname'];
		         $_SESSION['usr_lastname']  = $_REQUEST['usr_lastname'];         //$row['usr_lastname'];
		         $_SESSION['usr_prefix']    = $_REQUEST['usr_prefix'];           //$row['usr_prefix'];
		         $_SESSION['usr_auth']      = $_REQUEST['usr_auth'];             //$row['usr_auth'];
		         $_SESSION['usr_auth_orig'] = $_REQUEST['usr_auth'];             //$row['usr_auth'];     //echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
		         $_SESSION['usr_company']   = $_REQUEST['company_id'];           //$row['usr_company'];
		         $_SESSION['usr_type']      = $_REQUEST['usr_type'];             // $row['usr_type'];
	
		        //$_SESSION['admin_user'] = 0;
		         set_inactivetimeout();
	        if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_type'] == 99)) $_SESSION['admin_user'] = $_SESSION['usr_id']; 
		        //echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'];exit();
		      $resultlogin=Q("UPDATE usr SET usr_lastlogin = '" . date('Y-m-d H:i:s')."', usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id='".$_SESSION['usr_id']."';");	
		      $usr_login = QI("INSERT INTO usr_login (login_usr_id, login_date) VALUES (".$_SESSION['usr_id'].",'".date('Y-m-d H:i:s')."')");
	        $_SESSION['u-search_results'] = 0;
	        $_SESSION['newcompany'] = 0;	    
	          	            	$content .= "<!--  br>LINE 317 ptype= frombc2codash core   Session: -->";
                             	$content .= '<!-- '. print_r($_SESSION,true) . ' --> ' ;  

	       	  //print_r($_SESSION);
      	switch($_SESSION['usr_auth']) {  //1
					case "1": header("Refresh: 1; url=/".$_SESSION['env']."/applicants".$usempempid.".php"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/employers"); die(); break;
				//	case "2": header("Refresh: 1; url=bc2members".$usempempid.".php"); die(); break;
					//case "1": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					case "3": header("Refresh: 1; url=/".$_SESSION['env']."/admin_app.php"); die(); break;
					case "4": header("Refresh: 1; url=/".$_SESSION['env']."/admin_rep.php"); die(); break;
					case "5": case "6": header("Refresh: 1; url=/".$_SESSION['env']."/admin_emp.php"); die(); break;
					case "7": case "8": header("Refresh: 1; url=/".$_SESSION['env']."/admin_usr.php"); die(); break;
					case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;
					//case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members"); die(); break;
				    }  // 1
        //echo "I am here"; exit();
				    if ($_SESSION['usr_auth']==2  ) {header("Refresh: 1; url=bc2members".$usempempid.".php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die();  } //lloyd 10/7/18 // 1 1  'frombc2codash'
	 }
if  ($_REQUEST['ptype']=='corelogintoexistco')  //0  we have a password for this
	 {	 
	  /*     */
	     $_SESSION['$comdash_exists']="yes";
/*
got here from joinnow login to existing company this should just work
*/	    
$coreassignedusr_id = $_REQUEST['assignedusr_id'];
$existco = $_REQUEST['companyid'];
            $corenumcos = $_REQUEST['numcos'];
        if  ($corenumcos >1 ) {  
            $_SESSION['$comdash_exists']="yes";  }
         else {$_SESSION['$comdash_exists']="no";}
		$query = "SELECT * FROM usr WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
	//	$query = "SELECT * FROM usr WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "' AND usr_company=";
	
		if ($result=mysqli_query($conn, $query))  //1
		{
			if  (mysqli_num_rows($result)>0)  //2
			{
			      set_inactivetimeout();
	    $_SESSION['usr_id']        = $_REQUEST['assignedusr_id'];       //$row['usr_id'];
		         $_SESSION['usr_firstname'] = $_REQUEST['usr_firstname'];        //   $row['usr_firstname'];
		         $_SESSION['usr_lastname']  = $_REQUEST['usr_lastname'];         //$row['usr_lastname'];
		         $_SESSION['usr_prefix']    = $_REQUEST['usr_prefix'];           //$row['usr_prefix'];  
		         //$_SESSION['usr_auth']      = $_REQUEST['usr_auth'];             //$row['usr_auth']; 

		         if ($_REQUEST['usr_auth'] == 2)
                    $_SESSION['usr_auth']      = 2;	
                    
                 if ($_REQUEST['usr_auth'] == 9)
                    $_SESSION['usr_auth']      = 9;	
                    
		         $_SESSION['usr_auth_orig'] = $_REQUEST['usr_auth'];             //$row['usr_auth'];      //echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
		         $_SESSION['usr_company']   = $_REQUEST['company_id'];           //$row['usr_company'];
		         $_SESSION['usr_type']      = $_REQUEST['usr_type'];             // $row['usr_type'];
		        //$_SESSION['admin_user'] = 0;
	        if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_type'] == 99)) $_SESSION['admin_user'] = $_SESSION['usr_id']; 
		        //echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'];exit();
		      $resultlogin=Q("UPDATE usr SET usr_lastlogin = '" . date('Y-m-d H:i:s')."', usr_live='".date('Y-m-d H:i:s')."' WHERE usr_id='".$_SESSION['usr_id']."';");	
		      $usr_login = QI("INSERT INTO usr_login (login_usr_id, login_date) VALUES (".$_SESSION['usr_id'].",'".date('Y-m-d H:i:s')."')");
		       set_inactivetimeout();
	        $_SESSION['u-search_results'] = 0;
	        $_SESSION['newcompany'] = 0;	    
	         	          	            	$content .= "<!-- br>LINE 371 ptype= corelogintoexistco core   Session: --> ";
                             	$content .= '<!--' . print_r($_SESSION,true) . 'br -->';  

	       	  //print_r($_SESSION);
      	switch($_SESSION['usr_auth']) {  //1
					case "1": header("Refresh: 1; url=/".$_SESSION['env']."/applicants".$usempempid.".php"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/employers"); die(); break;
				//	case "2": header("Refresh: 1; url=bc2members".$usempempid.".php"); die(); break;
					//case "1": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					//case "2": header("Refresh: 1; url=/".$_SESSION['env']."/bc2dashboards"); die(); break;
					case "3": header("Refresh: 1; url=/".$_SESSION['env']."/admin_app.php"); die(); break;
					case "4": header("Refresh: 1; url=/".$_SESSION['env']."/admin_rep.php"); die(); break;
					case "5": case "6": header("Refresh: 1; url=/".$_SESSION['env']."/admin_emp.php"); die(); break;
					case "7": case "8": header("Refresh: 1; url=/".$_SESSION['env']."/admin_usr.php"); die(); break;
					case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;
					//case "9": header("Refresh: 1; url=/".$_SESSION['env']."/bc2members"); die(); break;
				    }  // 1
                   
				    if ($_SESSION['usr_auth']==2  ) {header("Refresh: 1; url=bc2members".$usempempid.".php?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company'].""); die();  } //lloyd 10/7/18 // 1 1 
				} //end	if ??? -// (mysql_num_rows($result)>0)  //2
		}   // end 	if ($result=mysql_query($query)))  //1	    
	 }   // end if if  ($_REQUEST['ptype']=='coexistsjoin')  //0 
if ($_REQUEST['ptype'] == 'dashboard') $_SESSION['usr_auth'] = 2;   // 0 0

if ($_REQUEST['ptype'] == 'admin') {  //1
  	      if ($_SESSION['usr_type'] == 99) 		     $_SESSION['usr_auth'] = 9; //2 - 2
else		//1	
$_SESSION['usr_auth'] = 8;
}	// 1
////}   //  0
//		             }   // -1
//echo "number 245555 --- ".$_SESSION['usr_auth'];
//exit();
// Security ---------------------------------------------------------------------
if (!isset($_SESSION['usr_id'])) 
  { // get authorization level of user
	$_SESSION['usr_id'] = 0; $_SESSION['usr_auth'] = 0;
	$_SESSION['usr_firstname'] = "Public"; $_SESSION['usr_lastname'] = "Visitor";
   }

//echo "I am here in Core 1";
//if( $_SESSION['contactus'] == 1) {$_SESSION['usr_lastname'] = "Visitor";require($siteFileRoot.'inc/templates/contactus.php');
if ($_SESSION['usr_auth'] == 1) require($siteFileRoot.'inc/applicant.php'); 
//if ($_SESSION['usr_auth'] == 0) require($siteFileRoot.'inc/applicant.php'); // lloyd 10/1/18
//if ($_SESSION['usr_auth'] == 2) require($siteFileRoot.'inc/employer.php'); 
//if ($_SESSION['usr_auth'] == 2) require($siteFileRoot.'inc/bc2members.php');
//if ($_SESSION['usr_auth'] == 2) require($siteFileRoot.'/bc2members.php');
if ($_SESSION['usr_auth'] == 3) require($siteFileRoot.'inc/manager.php'); 
if ($_SESSION['usr_auth'] == 4) require($siteFileRoot.'inc/ceo.php'); 
if ($_SESSION['usr_auth'] == 5) require($siteFileRoot.'inc/developer.php'); 
if ($_SESSION['usr_auth'] == 6) require($siteFileRoot.'inc/administrator.php'); 
if ($_SESSION['usr_auth'] == 7) require($siteFileRoot.'inc/administrator.php'); 
if ($_SESSION['usr_auth'] == 8) require($siteFileRoot.'inc/administrator.php');
if ($_SESSION['usr_auth'] == 9) require($siteFileRoot.'inc/bc2_admin.php');
 
//if ($_SESSION['usr_auth'] == 9) require($siteFileRoot.'inc/bc2_admin.php');
if ($pageauth > $_SESSION['usr_auth']) { header("Refresh: 1; url=/".$_SESSION['env'].""); die(); }     // terminate page if unathorized
if ($template != '') require $siteFileRoot."inc/templates/".$template.".php";
 // if ($_SESSION['usr_auth']==2  ) {header("Refresh: 1; url=/".$_SESSION['env']."/bc2members.php"); die();  } //lloyd 10/7/18
 
// Global Functions  ---------------------------------------------------------------------  
	 
 
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

function DBContent($areaName = '', $areaSub = '') {
	global $content, $title, $footerScript;
	$footerScript .= ' $("#adminNav").append("<div onclick=\"editPage(\''.QV("SELECT rescon_id FROM res_content WHERE rescon_area = '".$title."' AND rescon_sub='".$areaSub."' ").'\');\" >Edit '.($areaSub==''?'Page':'\"'.$areaSub.'\"').'</div>");';
	if ($areaName == '') $areaName = $title;
	//return QV("SELECT rescon_content FROM res_content WHERE rescon_area='".$areaName."' AND rescon_sub='".$areaSub."' ");	
	$rescontent  = QV("SELECT rescon_content FROM res_content WHERE rescon_area='".$areaName."' AND rescon_sub='".$areaSub."' ");
 //echo ("rescon from DBContent: " .$rescontent);
	return $rescontent;	 
}

function DropDown($id, $name, $dataTable, $inline = '', $selected = '') {
	$subBuffer = "<select id='".$id."' name='".$name."' ".$inline." >";
	foreach ($dataTable as $row) $subBuffer .= "<option ".($row['id']==$selected?'selected="selected"':'')." value='".$row['id']."'>".$row['label']."</option>";
	$subBuffer .= "</select>";
	return $subBuffer;
} 

function T2H($tableObject, $tableName = '', $tableExt = ''){
	global $content;
	$subbuffer = '<table '.($tableName==''?'':'id="'.$tableName.'"').' '.$tableExt.'>';
	$rowsubbuffer = '<tbody>'; $headerbuffer = '<thead><tr>'; $headerarray = array();
	if ($tableObject) foreach ($tableObject as $tRowK => $tRowV) {
		$rowsubbuffer .= '<tr id="'.$tableName.'_'.$tRowK.'">'; $tablerowcol = 0;
		foreach ($tRowV as $tCellK => $tCellV) { 
			$rowsubbuffer .= '<td id="'.$tableName.'_'.$tRowK.'_'.$tCellK.'">'.$tCellV.'</td>';
			$headerarray[$tablerowcol] = array();
			$headerarray[$tablerowcol]['col'] = $tCellK;
			$tablerowcol += 1;
		}
		$rowsubbuffer .= '</tr>';
	}
	if ($tableObject) foreach ($headerarray as $headerK => $headerV) $headerbuffer .= '<th>'.$headerV['col'].'</th>';
	$headerbuffer .= '</tr></thead>';
	$rowsubbuffer .= '</tbody>';
	$subbuffer .= $headerbuffer.$rowsubbuffer.'</table>';
	return $subbuffer;
}
function T2HR($tableObject, $tableName = '', $tableExt = ''){
	global $content;
	$subbuffer = '<table '.($tableName==''?'':'id="'.$tableName.'"').' '.$tableExt.'>';
	$rowsubbuffer = '<tbody>'; $headerbuffer = '<thead><tr style="background:#ffff00;">'; $headerarray = array();
	$toggle = true;
	if ($tableObject) foreach ($tableObject as $tRowK => $tRowV) {
		$rowsubbuffer .= '<tr id="'.$tableName.'_'.$tRowK.'" >'; $tablerowcol = 0;
		foreach ($tRowV as $tCellK => $tCellV) { 
			$rowsubbuffer .= '<td id="'.$tableName.'_'.$tRowK.'_'.$tCellK.'" style="'.($toggle?'background:#ffffff;':'background:#efefff;').'">'.$tCellV.'</td>';
			$headerarray[$tablerowcol] = array();
			$headerarray[$tablerowcol]['col'] = $tCellK;
			$tablerowcol += 1;
		}
		$toggle = !$toggle;
		$rowsubbuffer .= '</tr>';
	}
	if ($tableObject) foreach ($headerarray as $headerK => $headerV) $headerbuffer .= '<th style="background:#ffff00;">'.$headerV['col'].'</th>';
	$headerbuffer .= '</tr></thead>';
	$rowsubbuffer .= '</tbody>';
	$subbuffer .= $headerbuffer.$rowsubbuffer.'</table>';
	return $subbuffer;
}



//Matching Algorithms

/** Match - Applicants.php **/
/* 3/14/19 lloyd added company id as part of profile identities   passed as  $empIdentity*/

// function updateCertMatchesMP($userIdentity) {
function updateCertMatchesMP($userIdentity,$empIdentity) {
    global $userID, $emp_ID,$content,$duedateageinterval;
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_usr_id = '".$userIdentity."'and sysmat_emp_id ='".$empIdentity."' ");

	$q = "select group_concat(C.usrcrt_crt_id SEPARATOR ',') as 'x', /*  prob not?*/ C.usrcrt_emp_id as 'emp',
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A 
	/* LEFT 5/1/19lloyd */ INNER JOIN usr_certs C ON A.usrapp_usr_id = C.usrcrt_usr_id and A.usrapp_emp_id = C.usrcrt_emp_id
	WHERE C.usrcrt_crt_id > 0  and C.usrcrt_emp_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' and A.usrapp_emp_id = '".$empIdentity."'   
	GROUP BY A.usrapp_usr_id,A.usrapp_emp_id";
	$content .= "<!-- core 643 query fri certs: " . $q . "    --> ";
	$certReqs = Q2R($q);
	//	$content .= " <!-- LENGTH RESULT: " . count($certReqs) . "|<< --> ";
	$buffer = '';
	////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>updCertUsr '.$userIdentity.','.$empIdentity. ' = '.$q.'<br/>'.print_r($certReqs,true); 
		//$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
//find jobs with matching certs
	if ($certReqs) {
		// update existing matches  $duedateageinterval  CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
		$xq = "SELECT J.job_id as 'job', count(JC.jobcrt_crt_id) as 'certs', S.sysmat_id  as 'matchID' FROM job_certs JC
			/* LEFT 5/1/19lloyd */ INNER  JOIN job J ON J.job_id = JC.jobcrt_job_id
			/* LEFT 5/1/19lloyd */ INNER JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. " DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))
		
		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."'  and usrcrt_emp_id ='".$empIdentity. "' )
		AND S.sysmat_usr_id = '".$userIdentity."' and sysmat_emp_id ='".$empIdentity."'
		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";
	   	$updateMatches = Q2T($xq);
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			/*if ($matchRow['job'] == '74'){
			echo '(updateMatches for - ['.$matchRow['job'].') - job = ['.$job_union['edu'].' and mem ['.$certReqs['edu'].']'; exit();}*/
			$union_logic = union_match($job_union['edu'], $certReqs['edu']); 
			if ($union_logic == '1'){			
			$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
		////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true).$q; 
			$did = Q($q);
			}
		}
	} // end if dertReqa	
		// insert new matches
		$iq = "SELECT JC.jobcrt_job_id as 'job', count(JC.jobcrt_crt_id) as 'certs' FROM job_certs JC
			 /*	LEFT 5/1/19  */ INNER JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."' and usrcrt_emp_id ='".$empIdentity. "')
		AND JC.jobcrt_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."'  and X.sysmat_emp_id ='".$empIdentity."' AND X.sysmat_job_id=JC.jobcrt_job_id)
\		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";
		   $content .= " <!-- -br> core trace 671 xq: ". $xq. ", iq: " .$iq ."--> ";
	      //echo ($content);
	     //  exit;
	////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/>'.$xq . '<hr/>'.$iq.'<hr/>';
	
		$newMatches = Q2T($iq);

		/*echo "q[ ".$q." ]<br><br>";
		echo "xq[ ".$xq." ]<br><br>";
		echo "iq[ ".$iq." ]<br><br>";
		exit();	*/	

		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			/*if ($matchRow['job'] == '74'){
			echo '(newMatches - ['.$matchRow['job'].') - job = ['.$job_union['edu'].' and mem ['.$certReqs['edu'].']'; exit();}*/
			$union_logic = union_match($job_union['edu'], $certReqs['edu']); 
			if ($union_logic == '1'){
			$q = "INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status)
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
		////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] user='.$userIdentity.', '.print_r($matchRow,true).$q;
			$did = Q($q);   //,sysmat_emp_id  ,'".$empIdentity."'
			}
		}
//  move up this end if derreqa	}
/// put in caller --> deleteOldMatches();
	$certReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

/* old certs */
function updateCertMatchesMPb4Inner($userIdentity,$empIdentity) {
    global $userID, $emp_ID,$content,$duedateageinterval;
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_usr_id = '".$userIdentity."'and sysmat_emp_id ='".$empIdentity."' ");

	$q = "select group_concat(C.usrcrt_crt_id SEPARATOR ',') as 'x', C.usrcrt_emp_id as 'emp',
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_certs C ON A.usrapp_usr_id = C.usrcrt_usr_id and A.usrapp_emp_id = C.usrcrt_emp_id
	WHERE C.usrcrt_crt_id > 0  and C.usrcrt_emp_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' and A.usrapp_emp_id = '".$empIdentity."'   
	GROUP BY A.usrapp_usr_id,A.usrapp_emp_id";
	$content .= "<!-- core 643 query fri certs: " . $q . "    --> ";
	$certReqs = Q2R($q);
		$content .= " <!-- LENGTH RESULT: " . count($certReqs) . "|<< --> ";
	$buffer = '';
	////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>updCertUsr '.$userIdentity.','.$empIdentity. ' = '.$q.'<br/>'.print_r($certReqs,true); 
		//$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
//find jobs with matching certs
	if ($certReqs) {
		// update existing matches  $duedateageinterval  CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
		$xq = "SELECT J.job_id as 'job', count(JC.jobcrt_crt_id) as 'certs', S.sysmat_id  as 'matchID' FROM job_certs JC
		LEFT JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. " DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))
		
		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."'  and usrcrt_emp_id ='".$empIdentity. "' )
		AND S.sysmat_usr_id = '".$userIdentity."' and sysmat_emp_id ='".$empIdentity."'
		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";

		// insert new matches
		$iq = "SELECT JC.jobcrt_job_id as 'job', count(JC.jobcrt_crt_id) as 'certs' FROM job_certs JC
		LEFT JOIN job J ON J.job_id = JC.jobcrt_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JC.jobcrt_crt_id IN (".$certReqs['x'].") 
		AND JC.jobcrt_crt_id > 0
		
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		AND J.job_emp_id NOT IN (SELECT usrcrt_usr_id FROM usr_certs WHERE usrcrt_usr_id ='".$userIdentity."' and usrcrt_emp_id ='".$empIdentity. "')
		AND JC.jobcrt_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."'  and X.sysmat_emp_id ='".$empIdentity."' AND X.sysmat_job_id=JC.jobcrt_job_id)
\		AND N.catclr_rank <= '".$certReqs['clr']."'
		GROUP BY JC.jobcrt_job_id";
		   $content .= " <!-- -br> core trace 671 xq: ". $xq. ", iq: " .$iq ."--> ";
	      //echo ($content);
	     //  exit;
	////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/>'.$xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);

		/*echo "q[ ".$q." ]<br><br>";
		echo "xq[ ".$xq." ]<br><br>";
		echo "iq[ ".$iq." ]<br><br>";
		exit();	*/	
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			/*if ($matchRow['job'] == '74'){
			echo '(updateMatches for - ['.$matchRow['job'].') - job = ['.$job_union['edu'].' and mem ['.$certReqs['edu'].']'; exit();}*/
			$union_logic = union_match($job_union['edu'], $certReqs['edu']); 
			if ($union_logic == '1'){			
			$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
		////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true).$q; 
			$did = Q($q);
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			/*if ($matchRow['job'] == '74'){
			echo '(newMatches - ['.$matchRow['job'].') - job = ['.$job_union['edu'].' and mem ['.$certReqs['edu'].']'; exit();}*/
			$union_logic = union_match($job_union['edu'], $certReqs['edu']); 
			if ($union_logic == '1'){
			$q = "INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status)
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
		////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] user='.$userIdentity.', '.print_r($matchRow,true).$q;
			$did = Q($q);   //,sysmat_emp_id  ,'".$empIdentity."'
			}
		}
	}
/// put in caller  //  deleteOldMatches();
	return $buffer;
}
function updateSkillMatchesMP($userIdentity,$empIdentity) {
	global $userID,$emp_ID,$content,$duedateageinterval;
	//LARRYF    //,sysmat_emp_id  $userIdentity ,'".$empIdentity."'
	//5/1 suppress nulls
	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_usr_id = '".$userIdentity."' and sysmat_emp_id = '".$empIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x' ,/* prob notlloyd 5/3,*/ A.usrapp_emp_id , A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A /*LEFT *5/1/19 */ inner  JOIN usr_skills C ON A.usrapp_usr_id=C.usrskl_usr_id and   A.usrapp_emp_id=C.usrskl_emp_id
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' and A.usrapp_emp_id = '".$empIdentity."'
	
	GROUP BY A.usrapp_usr_id,A.usrapp_emp_id";
	
	//echo $q; exit();
	
	
		//echo "q[ ".$q." ]<br><br>";
		//exit();
	
	//echo $q; exit();
	
	$skillReqs = Q2R($q);
	if(!is_array($skillReqs)){
		$skillReqs = array();
	}
		//if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
   $content .= "<!-- trace core 827 count skillReqs=" . count($skillReqs) ." with query: " . 	$q . " --> ";
	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_skills JS
	  /*	LEFT 5/1/19  */ INNER JOIN job J ON J.job_id = JS.jobskl_job_id
		 /*	LEFT 5/1/19  */ INNER JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		/*		 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0))) */
		
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."'  AND  usrskl_emp_id = '".$empIdentity."' )
		AND S.sysmat_usr_id = '".$userIdentity."' AND S.sysmat_emp_id =  '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		
			$updateMatches = Q2T($xq);
			  $content .= "<!--br> core trace 849 xq: ". $xq. " -->";
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."' ");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
	}
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_skills JS 
	 /*	LEFT 5/1/19  */ INNER JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

				AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."' AND  usrskl_emp_id = '".$empIdentity."' )
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."'  AND X.sysmat_emp_id =  '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
        $content .= "<!--br> core trace 757 xq: ". $xq. ", iq: " .$iq ."-->";
        ///
       // echo ($content);
       //// 
       //exit;
		//echo "q[ ".$q." ]<br><br>";
		//echo "xq[ ".$xq." ]<br><br>";
		//echo "iq[ ".$iq." ]<br><br>";
		//exit();
		
		
		
	/////	if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
	
		$newMatches = Q2T($iq);
	  ////,sysmat_emp_id  ,'".$empIdentity."'
		
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
		/////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) 
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	
// *put in caller deleteOldMatches();
	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

function updateSkillMatchesMPtoomany($userIdentity,$empIdentity) {
	global $userID,$emp_ID,$content,$duedateageinterval;
	//LARRYF    //,sysmat_emp_id  $userIdentity ,'".$empIdentity."'
	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_usr_id = '".$userIdentity."' and sysmat_emp_id = '".$empIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x',/* prob not 5/3lloydA.usrapp_emp_id,*/ A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_skills C ON A.usrapp_usr_id=C.usrskl_usr_id and   A.usrapp_emp_id=C.usrskl_emp_id
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' and A.usrapp_emp_id = '".$empIdentity."'
	
	GROUP BY A.usrapp_usr_id,A.usrapp_emp_id";
	
		//echo "q[ ".$q." ]<br><br>";
		//exit();
	
	$skillReqs = Q2R($q);
		//if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_skills JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		/*		 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0))) */
		
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."'  AND  usrskl_emp_id = '".$empIdentity."' )
		AND S.sysmat_usr_id = '".$userIdentity."' AND S.sysmat_emp_id =  '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_skills JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

				AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_skills WHERE usrskl_usr_id ='".$userIdentity."' AND  usrskl_emp_id = '".$empIdentity."' )
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."'  AND X.sysmat_emp_id =  '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
        $content .= "<!--br> core trace 757 xq: ". $xq. ", iq: " .$iq ."-->";
        ///
       // echo ($content);
       //// 
       //exit;
		//echo "q[ ".$q." ]<br><br>";
		//echo "xq[ ".$xq." ]<br><br>";
		//echo "iq[ ".$iq." ]<br><br>";
		//exit();
		
		
		
	/////	if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	  ////,sysmat_emp_id  ,'".$empIdentity."'
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."' ");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
		/////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) 
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	}
// *put in caller
deleteOldMatches();
	return $buffer;
}


function updateAgencyMatchesMP($userIdentity,$empIdentity) 
{
    global $userID,$emp_ID,$content,$duedateageinterval;
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_usr_id = '".$userIdentity."'  and sysmat_emp_id=   '".$empIdentity."'");
//	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usragen_skl_id SEPARATOR ',') as 'x',A.usrapp_emp_id as 'emp', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A /*LEFT*/ INNER JOIN usr_agencies C ON A.usrapp_usr_id=C.usragen_usr_id AND A.usrapp_emp_id = C.usragen_emp_id 
	WHERE C.usragen_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."'  AND A.usrapp_emp_id = '".$empIdentity."'
	GROUP BY A.usrapp_usr_id,A.usrapp_emp_id ";
  ////,AND sysmat_emp_id  ,'".$empIdentity."'
	$skillReqs = Q2R($q);
//	$content.= "<!--  core 1004 look for agencies query: " .$q . ", count(skillReqs: " .count($skillReqs) . "--> ";
	/////	if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
	
	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_agencies JS
		/* LEFT 5/1/19 lloyd */ INNER   JOIN job J ON J.job_id = JS.jobskl_job_id
	/* LEFT 5/1/19 lloyd */ INNER   JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
			AND JS.jobskl_skl_id > 0 
		  		
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

			/*	 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))
             */
		AND J.job_emp_id > 0 /*and J.jobemp_id > 0 */
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."' AND usragen_emp_id = '".$empIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."'  AND S.sysmat_emp_id =  '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
			$content.= "<!--  core 1034 have agency skillreqs xq: " . $xq. " --> ";
		$updateMatches = Q2T($xq);
			if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
			/////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
	} //  end if skillreqs
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_agencies JS 
		 /* LEFT  5/1/19 lloyd  */ INNER  JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
			AND JS.jobskl_skl_id > 0 
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		
		/*		 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0))) */
             
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."' AND usragen_emp_id = '".$empIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."'  AND X.sysmat_emp_id =  '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	//		if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
			$content .= "<!-- core 1066 match agencies update and insert xq: " . $xq . ",  iq: ".  $iq. " -->";
		
		$newMatches = Q2T($iq);
	 ////,AND sysmat_emp_id  ,'".$empIdentity."'
	
		
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 	
			if ($union_logic == '1'){			
			//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id , sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) 
				VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}

   /// skillreq	}
// *put in caller deleteOldMatches();
	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

function updateAgencyMatchesMPb4INNER($userIdentity,$empIdentity) 
{
    global $userID,$emp_ID,$content,$duedateageinterval;
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
//	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usragen_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_agencies C ON A.usrapp_usr_id=C.usragen_usr_id 
	WHERE C.usragen_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."'  AND A.usrapp_emp_id = '".$empIdentity."'
	GROUP BY A.usrapp_usr_id,A.usrapp_emp_id ";
  ////,AND sysmat_emp_id  ,'".$empIdentity."'
	$skillReqs = Q2R($q);
////	$content.= "<--  core 835 look for agencies query: " .$q . ", count(skillReqs: " .count($skillReqs) . "--> ";
	/////	if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
	
	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_agencies JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
			AND JS.jobskl_skl_id > 0 
		  		
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

			/*	 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))
             */
		AND J.job_emp_id > 0 /*and J.jobemp_id > 0 */
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."' AND usragen_emp_id = '".$empIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."'  AND S.sysmat_emp_id =  '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_agencies JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
			AND JS.jobskl_skl_id > 0 
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		
		/*		 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0))) */
             
		AND J.job_emp_id NOT IN (SELECT usragen_usr_id FROM usr_agencies WHERE usragen_usr_id ='".$userIdentity."' AND usragen_emp_id = '".$empIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."'  AND X.sysmat_emp_id =  '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	//		if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
			$content .= "<!-- core 870 match agencies update and insert xq: " . $xq . ",  iq: ".  $iq. " -->";
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	 ////,AND sysmat_emp_id  ,'".$empIdentity."'
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
			/////	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 	
			if ($union_logic == '1'){			
			//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id , sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) 
				VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}

	}
// *put in caller deleteOldMatches();
	return $buffer;
}



function updateFunctionMatchesMP($userIdentity,$empIdentity) {
    ////,AND sysmat_emp_id  = '".$empIdentity."'
	Q("UPDATE sys_match SET sysmat_functions='0' WHERE sysmat_usr_id = '".$userIdentity."' AND sysmat_emp_id  = '".$empIdentity."'");
	$q = "SELECT group_concat(C.usrexpfnc_fnc_id SEPARATOR ',') as 'x', 
	A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A 
	LEFT JOIN usr_exp E ON E.usrexp_usr_id = A.usrapp_usr_id and A.usrapp_emp_id = E.usrexp_emp_id 
	LEFT JOIN usr_exp_func C ON C.usrexpfnc_usrexp_id = E.usrexp_id 
	WHERE C.usrexpfnc_fnc_id > 0 AND A.usrapp_usr_id = '" . $userIdentity . "'   AND A.usrapp_emp_id = '".$empIdentity."'
	GROUP BY A.usrapp_usr_id";
	$funcReqs = Q2R($q);
	$buffer = ''; 
	if ($funcReqs) {
	//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<hr/><hr/>'.$q.'<br/>'.print_r($funcReqs,true).'<hr/>';
	
		$xq = "SELECT J.job_id as 'job', count(JF.jobfnc_fnc_id) as 'funcs', S.sysmat_id as 'matchID' FROM job_func JF 
	LEFT JOIN job J ON J.job_id = JF.jobfnc_job_id
	LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id 
	LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
	WHERE JF.jobfnc_fnc_id IN (".$funcReqs['x'].") 
	AND S.sysmat_usr_id = '".$userIdentity."' AND S.sysmat_emp_id  = '".$empIdentity."'
	AND J.job_edu_level <= '".$funcReqs['edu']."' 
	AND N.catclr_rank <= '".$funcReqs['clr']."'
	GROUP BY JF.jobfnc_job_id";
     	$updateMatches = Q2T($xq);
     	if ($updateMatches) foreach ($updateMatches as $matchRow) {
	//		if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_functions = '".$matchRow['funcs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
		}
	} //if ($  funcReqs) 
		$iq = "SELECT JF.jobfnc_job_id as 'job', count(JF.jobfnc_fnc_id) as 'funcs' FROM job_func JF 
	LEFT JOIN job J ON J.job_id = JF.jobfnc_job_id
	LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
	WHERE JF.jobfnc_fnc_id IN (".$funcReqs['x'].")
	AND JF.jobfnc_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_emp_id  = '".$empIdentity."' AND X.sysmat_job_id = JF.jobfnc_job_id)
	AND J.job_edu_level <= '".$funcReqs['edu']."' 
	AND N.catclr_rank <= '".$funcReqs['clr']."'
	GROUP BY JF.jobfnc_job_id";
	
	//	if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>' . $iq . '<hr/>';
	
		$newMatches = Q2T($iq);

		
		   ////,AND sysmat_emp_id  = '".$empIdentity."'

		if ($newMatches) foreach ($newMatches as $matchRow) {
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert] '.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_emp_id , sysmat_job_id, sysmat_functions, sysmat_matched_date, sysmat_status)
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['funcs']."','".date("Y-m-d H:i:s")."','1')");
		}
	// moved  up for if funcTeqs   }
// *put in caller	deleteOldMatches();
  $funcReqs = NULL;
	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

function updateProflicMatchesMP($userIdentity,$empIdentity) {
     ////,AND sysmat_emp_id  = '".$empIdentity."'
	Q("UPDATE sys_match SET sysmat_proflics='0' WHERE sysmat_usr_id = '".$userIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_proflics C ON A.usrapp_usr_id=C.usrskl_usr_id and A.usrapp_emp_id = C.usrskl_emp_id
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."'  AND A.usrapp_emp_id = '".$empIdentity."'
	GROUP BY A.usrapp_usr_id";

	$skillReqs = Q2R($q);
	//	if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

		
	if ($skillReqs) {
		
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_proflics JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userIdentity."' AND  usrskl_emp_id = '".$empIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."'  AND S.sysmat_emp_id  = '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
			//	if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
	
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_proflics = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
	//print "[ ".$skillReqs['x']." ][ ".$skillReqs['edu']." ][ ".$skillReqs['clr']." ]";
	//exit();
	   } //  end if ($   skillReqs)
	     	$newMatches = Q2T($iq);
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_proflics JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_proflics WHERE usrskl_usr_id ='".$userIdentity."' AND  usrskl_emp_id = '".$empIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_emp_id  = '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
     ////,AND sysmat_emp_id  = '".$empIdentity."'

	
	
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){		
	        	//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
		     	$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_emp_id.sysmat_job_id, sysmat_proflics, sysmat_matched_date, sysmat_status) 
		    	VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
		  	}
	  	}
	//?}
  //	}  // end if ($   skillReqs)
// *put in caller ->	deleteOldMatches();
 
	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;

	return $buffer;
}

function updateGeoMatchesMP($userIdentity,$empIdentity) {
     ////, AND sysmat_emp_id  = '".$empIdentity."'
     global $userID,$emp_ID, $content,$duedateageinterval;
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_usr_id = '".$userIdentity."' AND sysmat_emp_id  = '".$empIdentity."' ");
//	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x',A.usrapp_emp_id, A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_geos C ON A.usrapp_usr_id=C.usrskl_usr_id AND A.usrapp_emp_id = C.usrskl_emp_id
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."' AND A.usrapp_emp_id = '".$empIdentity."'
	GROUP BY A.usrapp_usr_id";

//echo $q."<br>";

	$skillReqs = Q2R($q);
	
	    //echo "[".$skillsReqs."]<br>";
	    
	//	if (isset($_REQUEST['usrMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
		$stateID = Q2T("SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].")");
		
		//echo "[ SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].") ]<br>";   //exit();
		
		if ($stateID) {
			foreach ($stateID as $row) {
							
				$all = Q2T("SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."'");
				
				//echo "[ SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."' ]<br>"; //exit();
				
				if ($all){
					foreach ($all as $id) {
						$stateAbbr = substr($id['catskl_label'],0,2);
						if ($id['catskl_all_ind'] == 1) {
							//$stateAbbr = substr($id['catskl_label'],0,2);
							$stateReqs = Q2R("SELECT group_concat(catskl_id SEPARATOR ',') as 'x' FROM cat_geos WHERE catskl_label like '".$stateAbbr."-%'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];

						}
						else{
							$stateReqs = Q2R("SELECT catskl_id FROM cat_geos WHERE catskl_label = '".$stateAbbr."-ALL'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['catskl_id'];							
						}
					}
				}
			}			
		}
				
		//echo "SkillReq[ ".$skillReqs['x']." ]<br>";
		//echo "StateReq[ ".$stateReqs['x']." ]<br>";
		//$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];
		//echo "[ ".$skillReqs['x']." ]<br>";
		//exit();
		
		  ////, AND sysmat_emp_id  = '".$empIdentity."'

	if ($skillReqs) {
		$xq = "SELECT J.job_id as 'job', count(JS.jobskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM job_geos JS
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN sys_match S ON S.sysmat_job_id = J.job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

			/*	 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))
             */
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userIdentity."' AND usrskl_emp_id ='".$empIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."' AND sysmat_emp_id  = '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		$updateMatches = Q2T($xq);
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
		///	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		
	 } // end if skillReqq
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_geos JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		
				
			 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL ".$duedateageinterval. "  DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))

		
			/*	 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' and CURDATE() <= DATE_ADD(J.job_due_date,INTERVAL 30 DAY)) 
             OR ((J.fed_id > 0 and J.job_due_date = '0000-00-00') OR (J.fed_id = 0 and J.jobemp_id <>0)))
             */
		
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_geos WHERE usrskl_usr_id ='".$userIdentity."' AND usrskl_emp_id ='".$empIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_emp_id  = '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";


		$newMatches = Q2T($iq);
		  ////, AND sysmat_emp_id  = '".$empIdentity."'
      	
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';

		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){		
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id. sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status) 
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
 //  moveved up  for if skillreq	}
// *put in caller	deleteOldMatches();
  
	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

function updateVehiclesMatchesMP($userIdentity,$empIdentity) {
     ////,AND sysmat_emp_id  = '".$empIdentity."'
	Q("UPDATE sys_match SET sysmat_vehicles='0' WHERE sysmat_usr_id = '".$userIdentity."' AND sysmat_emp_id  = '".$empIdentity."' ");
	$buffer = '<hr/><hr/>'; 
	$q = "SELECT group_concat(C.usrskl_skl_id SEPARATOR ',') as 'x', A.usrapp_edu_level as 'edu', A.usrapp_clearance as 'clr', A.usrapp_ava_id as 'ava'
	FROM usr_app A LEFT JOIN usr_vehicles C ON A.usrapp_usr_id=C.usrskl_usr_id  and A.usrapp_emp_id = C.usrskl_emp_id
	WHERE C.usrskl_skl_id > 0 AND A.usrapp_usr_id = '".$userIdentity."'   AND A.usrapp_emp_id = '".$empIdentity."'
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
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userIdentity."'  AND usrskl_emp_id = '".$empIdentity."')
		AND S.sysmat_usr_id = '".$userIdentity."'  AND sysmat_emp_id  = '".$empIdentity."'
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";
		
			$updateMatches = Q2T($xq);
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){			
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[update]'.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_vehicles = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
		}
		
	//print "[ ".$skillReqs['x']." ][ ".$skillReqs['edu']." ][ ".$skillReqs['clr']." ]";
	//exit();
	} // end if skillreqs
	
		$iq = "SELECT JS.jobskl_job_id as 'job', count(JS.jobskl_skl_id) as 'skills' FROM job_vehicles JS 
		LEFT JOIN job J ON J.job_id = JS.jobskl_job_id
		LEFT JOIN cat_clearance N ON N.catclr_rank = J.job_clearance
		WHERE JS.jobskl_skl_id IN (".$skillReqs['x'].") 
		AND JS.jobskl_skl_id > 0 
		AND J.job_emp_id NOT IN (SELECT usrskl_usr_id FROM usr_vehicles WHERE usrskl_usr_id ='".$userIdentity."' AND usrskl_emp_id = '".$empIdentity."')
		AND JS.jobskl_job_id NOT IN (SELECT X.sysmat_job_id FROM sys_match X WHERE X.sysmat_usr_id = '".$userIdentity."' AND X.sysmat_emp_id  = '".$empIdentity."' AND X.sysmat_job_id = JS.jobskl_job_id)
		AND N.catclr_rank <= '".$skillReqs['clr']."'
		GROUP BY JS.jobskl_job_id";

	   ////, AND sysmat_emp_id  = '".$empIdentity."'
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= $xq . '<hr/>'.$iq.'<hr/>';
	
		$newMatches = Q2T($iq);
	   
	   
		if ($newMatches) foreach ($newMatches as $matchRow) {
		//echo "[ " . $matchRow['job'] . "||" . $matchRow['skills'] . " ]";
		//exit();
			$job_union = Q2R("SELECT job_edu_level as 'edu' FROM job WHERE job_id = '".$matchRow['job']."'");
			$union_logic = union_match($job_union['edu'], $skillReqs['edu']); 
			if ($union_logic == '1'){		
		//	if (isset($_REQUEST['usrMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_emp_id,  sysmat_job_id, sysmat_vehicles, sysmat_matched_date, sysmat_status) 
			VALUES ('".$userIdentity."','".$empIdentity."','".$matchRow['job']."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
		}
	//   moved up for endif skillreqa}
// *put in caller	deleteOldMatches();
 
	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

/** Match - Employers.php **/

function updateCertMatchesJP($jobID) {
     ////,AND sysmat_emp_id  = '".$empIdentity."'
	global $userID,$emp_ID;
		
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "select group_concat(C.jobcrt_crt_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' from job_certs C
	LEFT JOIN job J ON J.job_id = C.jobcrt_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank 
	WHERE C.jobcrt_crt_id > 0 AND C.jobcrt_job_id = '".$jobID."' GROUP BY C.jobcrt_job_id";
	$certReqs = Q2R($q);

	$buffer = '';
	///	if (isset($_REQUEST['jobMatches'])) $buffer .= $q.print_r($certReqs,true); //$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
	
	// update existing matches
	//	AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$xq = "SELECT C.usrcrt_usr_id as 'usr', count(C.usrcrt_crt_id) as 'certs', S.sysmat_id as 'matchID' FROM usr_certs C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrcrt_usr_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id";

	// insert new matches
	// AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$iq = "SELECT C.usrcrt_usr_id as 'usr', count(C.usrcrt_crt_id) as 'certs' FROM usr_certs C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0
	AND C.usrcrt_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id=C.usrcrt_usr_id)	
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id";

	/*echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit();*/
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($certReqs?$xq . '<hr/>'.$iq.'<hr/>':"");
	$updateMatches = Q2T($xq);
	$newMatches = Q2T($iq);

		
	if ($updateMatches) foreach ($updateMatches as $matchRow) {
		if ($matchRow['usr'] <> $userID){
		$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
		$union_logic = union_match($certReqs['edu'], $usr_app_union['edu']);
		if ($union_logic == '1'){		
		$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' ";
		if (isset($_REQUEST['jobMatches'])) $buffer .= 'new'.print_r($matchRow,true).$q; 
		$did = Q($q);
		}
		}
	}
	if ($newMatches) foreach ($newMatches as $matchRow) {
		if ($matchRow['usr'] <> $userID){
		$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
		$union_logic = union_match($certReqs['edu'], $usr_app_union['edu']);
		if ($union_logic == '1'){		
		$q = "INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
		if (isset($_REQUEST['jobMatches'])) $buffer .= 'upd'.print_r($matchRow,true).$q;
		$did = Q($q);
		}
		}
	}

// notput in caller	 deleteOldMatches();
$certReqs=NULL;   //  $funcReqs = NULL;   //	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}
//**

/* 	updateCertMatchesJP($id,$empid); was function updateCertMatchesJP($jobID)  4/19/19  */
function updateCertMatchesJPnonzeroempid($jobID) {
// function updateCertMatchesJP($jobID) {
     ////,AND sysmat_emp_id  = '".$empIdentity."'  /* recall fbo does not update or add to usr_cert, so all valid entries in sur_certs should have nonzero usrcrt_emp_id
	global $userID,$emp_ID;
	$empid =	$emp_ID;
	$buffer = "";
	//	if (isset($_REQUEST['jobMatches']))$buffer .= "<!--br> trace 1220 updateCertMatchesJPnonzeroempid - update query is:
	  //  UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_job_id = '".$jobID."' -->" ; // and sysmat_job_emp_id = '".$empid."' -->  ";
	Q("UPDATE sys_match SET sysmat_certifications='0' WHERE sysmat_job_id = '".$jobID."'  ");
	$q = "select group_concat(C.jobcrt_crt_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' from job_certs C
	/*LEFT  lloyd 5/2/19*/ INNER JOIN job J ON J.job_id = C.jobcrt_job_id   LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank 
	WHERE C.jobcrt_crt_id > 0 AND C.jobcrt_job_id = '".$jobID."'   GROUP BY C.jobcrt_job_id";
   
	$certReqs = Q2R($q);
  // $content .= "<br> Trace 1229 update cert jp q: " .$q . "-->";
	//$buffer = '<!--';
	    ////	if (isset($_REQUEST['jobMatches']))$buffer .= "  <!--  br>trace1229"; 
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= $q.print_r($certReqs,true) . "-->"; //$did = Q("UPDATE sys_match SET sysmat_certifications = u WHERE sysmat_id = sysmat_id");
if ($certReqs) {
	// update existing matches
	//	AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$xq = "SELECT C.usrcrt_usr_id as 'usr', C.usrcrt_emp_id as 'emp',count(C.usrcrt_crt_id) as 'certs', S.sysmat_id as 'matchID' FROM usr_certs C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrcrt_usr_id and sysmat_emp_id = C.usrcrt_emp_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id and usrapp_emp_id =  C.usrcrt_emp_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0 /*AND C.usrcrt_emp_id > 0 */
	AND S.sysmat_job_id = '".$jobID."' /* AND S.sysmat_emp_id > 0  */
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id, C.usrcrt_emp_id ";

	// insert new matches
	// AND A.usrapp_ava_id = '".$certReqs['ava']."'
	$iq = "SELECT C.usrcrt_usr_id as 'usr', C.usrcrt_emp_id as 'emp', count(C.usrcrt_crt_id) as 'certs' FROM usr_certs C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrcrt_usr_id  and usrapp_emp_id =  C.usrcrt_emp_id
	WHERE C.usrcrt_crt_id IN (".$certReqs['x'].") 
	AND C.usrcrt_crt_id > 0 /*AND C.usrcrt_emp_id > 0*/
	AND C.usrcrt_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."'  AND X.sysmat_usr_id=C.usrcrt_usr_id AND X.sysmat_emp_id=C.usrcrt_emp_id )	
	AND A.usrapp_clearance >= '".$certReqs['clr']."'
	GROUP BY C.usrcrt_usr_id, C.usrcrt_emp_id ";

	/*echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit();*/
////if (isset($_REQUEST['jobMatches'])) $buffer .=  "<!--br> trace 1259 up cert jp, xq: " . $xq . "<br>, iq: " . $iq . "-->";
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= "<!--". ($certReqs?$xq . '<br/>'.$iq.'<br/>':" -->");
	$updateMatches = Q2T($xq);
	$newMatches = Q2T($iq);

		//> $matchRow['emp'] ??
	if ($updateMatches) foreach ($updateMatches as $matchRow) {
		if ($matchRow['usr'] <> $userID && $matchRow['emp'] <>$empid ){
		$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'  and usrapp_emp_id = '".$matchRow['emp']."'");
		////	if (isset($_REQUEST['jobMatches'])) $buffer .= "<!--br> select for updatematches is:
			////SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'  and usrapp_emp_id = '".$matchRow['emp']."' -->";
		
		$union_logic = union_match($certReqs['edu'], $usr_app_union['edu']);
		if ($union_logic == '1'){		
		$q = "UPDATE sys_match SET sysmat_certifications = '".$matchRow['certs']."' WHERE sysmat_id = '".$matchRow['matchID']."' and sysmat_emp_id = '".$matchRow['emp']."' ";
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= '<!--new'.print_r($matchRow,true).$q . "-->"; 
		$did = Q($q);
		////	if (isset($_REQUEST['jobMatches'])) $buffer .= "<!--br> 1273 update q:" .$q ."-->";
		}
		}
	}
	if ($newMatches) foreach ($newMatches as $matchRow) {
		if ($matchRow['usr'] <> $userID && $matchRow['emp'] <> $empid){
		$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '".$matchRow['emp']."'");
////	   	if (isset($_REQUEST['jobMatches'])) $buffer .= "<!--br>1281  for newmatchesselect is
////	   	  SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '".$matchRow['emp']."' -->";
		$union_logic = union_match($certReqs['edu'], $usr_app_union['edu']);
		if ($union_logic == '1'){		
		$q = "INSERT INTO sys_match (sysmat_usr_id, sysmat_emp_id, sysmat_job_id, sysmat_certifications, sysmat_matched_date, sysmat_status) 
		VALUES ('".$matchRow['usr']."','".$matchRow['emp']."','".$jobID."','".$matchRow['certs']."','".date("Y-m-d H:i:s")."','1')";
////		if (isset($_REQUEST['jobMatches'])) $buffer .= '1290upd'.print_r($matchRow,true).$q  . " ";
		$did = Q($q);
		}
	  	
		}
	}
////    if (isset($_REQUEST['jobMatches'])) $buffer .= "<!-- end upcertjp -->";
//// 	deleteOldMatches();
$certReqs=NULL; // $funcReqs = NULL; //	$skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}
}
//**************************
function updateSkillMatchesJPOLD($jobID) {
	global $userID;

	
	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_skills C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);
	
	//echo $q;
	//exit();

	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM usr_skills C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills' FROM usr_skills C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	/* echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit(); */
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
// *put in caller	deleteOldMatches();
	return $buffer;
}


//***************************


function updateSkillMatchesJPnonzeroempid($jobID) {
	global $userID,$emp_ID ,  $RempID,  $RuserID;  //RuserID passed as jobID

	  $empid= $emp_ID;
////	 if (isset($_REQUEST['jobMatches']))  $buffer .= '<br>core 1383 entered updateSkillMatchesJPnonzeroempid';
   //	Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_job_id = '".$jobID."' ");
		 
	
	//Check for deleted NAICS
	$q = "Select job_delete_id, job_delete_jobid, job_delete_naics from job_delete where job_delete_jobid = '".$jobID."'";
	
	$del_naics = Q2T($q);
	
	if ($del_naics) {
		
		foreach ($del_naics as $matchRow){
			$q = "select usrskl_usr_id from usr_skills where usrskl_skl_id = '".$matchRow['job_delete_naics']."'";
			$find_usr = Q2T($q);
				
			if ($find_usr) {
				foreach ($find_usr as $usrRow){
					$skill_match = Q2T("SELECT sysmat_skills, sysmat_certifications FROM sys_match WHERE sysmat_usr_id = '".$usrRow['usrskl_usr_id']."' and sysmat_job_id ='".$matchRow['job_delete_jobid']."' ");
						
					if ($skill_match) {
						foreach($skill_match as $skillRow)
						{
							$skill_cnt = $skillRow['sysmat_skills'];
							$certs_cnt = $skillRow['sysmat_certifications'];
								
							if ($skill_cnt > 0) {
								//echo $skill_cnt." user=".$usrRow['usrskl_usr_id']." certs: ".$certs_cnt."<br>";				
								$skill_cnt = $skillRow['sysmat_skills'] - 1;
								//echo $skill_cnt." user=".$usrRow['usrskl_usr_id']."<br>";
						
								$did = Q("UPDATE sys_match SET sysmat_skills = '".$skill_cnt."' WHERE sysmat_usr_id = '".$usrRow['usrskl_usr_id']."'
								           and sysmat_job_id ='".$matchRow['job_delete_jobid']."' ");
							}
						}
					}
				}
			}
		}
		
		//Remove 
		//echo "removing row from delete table<br>";
		$q = "Delete from job_delete where job_delete_id ='".$matchRow['job_delete_id']."'";
		$did = Q($q);
		//exit();
	}
	
	//echo "No Delete Changes";
    
  ////  if (isset($_REQUEST['jobMatches'])) $buffer .= "No Delete Changes";
	
	
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_skills C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' and jobskl_status = '0' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);
	
	//// 	if (isset($_REQUEST['jobMatches'])) $buffer .= "<br1439 upskilljp" .$q;
//// if (!($skillReqs)) 
///	/    if (isset($_REQUEST['jobMatches'])) $buffer.= ":,br> 1440 $skillreq is false ";
	if ($skillReqs) {
		//$buffer .='<br/><br/>'.$q; 
	////	if (isset($_REQUEST['jobMatches'])) $buffer .="<br> 1444 skillreqs exists, " . $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<br/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', C.usrskl_emp_id as 'emp',count(C.usrskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM usr_skills C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id and sysmat_emp_id = C.usrskl_emp_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id  and usrapp_emp_id =  C.usrskl_emp_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	  and  C.usrskl_skl_id  >  0 and  C.usrskl_emp_id > 0
	AND S.sysmat_job_id = '".$jobID."'  AND S.sysmat_emp_id > 0 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id, C.usrskl_emp_id ";
	

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', C.usrskl_emp_id as 'emp', count(C.usrskl_skl_id) as 'skills' FROM usr_skills C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id  and usrapp_emp_id =  C.usrskl_emp_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_skl_id > 0 AND C.usrskl_emp_id > 0
 AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id='".$jobID."' AND X.sysmat_usr_id=C.usrskl_usr_id AND X.sysmat_emp_id=C.usrskl_emp_id)	
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id, C.usrskl_emp_id ";

	/* echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit(); */
	
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= 'XQ: '.$xq . '<hr/>InsertQ:'.$iq.'<hr/>';
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID && $matchRow['emp'] <>$empid  ){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'  and usrapp_emp_id = '".$matchRow['emp']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
			////	if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$skill_cnt = QV("SELECT sysmat_skills FROM sys_match WHERE sysmat_id = '".$matchRow['matchID']."' and sysmat_emp_id = '".$matchRow['emp']."' ");
				$skill_cnt = $skill_cnt + $matchRow['skills'];
		$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."'and sysmat_emp_id = '".$matchRow['emp']."' ");
				//echo "update sys_match - skill cnt = [ ".$skill_cnt." ] [".$matchRow['matchID']."]<br>";
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= "<br/>1486 did update with UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."'
	////	               WHERE sysmat_id = '".$matchRow['matchID']."'and sysmat_emp_id = '".$matchRow['emp']."' "	;	
				$did = Q("Update job_skills SET jobskl_status = 1 where jobskl_job_id = '".$jobID."'");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID && $matchRow['emp']){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '".$matchRow['emp']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
			////	if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id,sysmat_emp_id,  sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) 
				           VALUES ('".$matchRow['usr']."','".$matchRow['emp']."','".$jobID."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
				//echo "insert into sys_match - skill cnt = [ ".$matchRow['skills']." ] [".$matchRow['matchID']."]<br>";
				$did = Q("Update job_skills SET jobskl_status = 1 where jobskl_job_id = '".$jobID."'");
			}
			}
		}
	}
// *put in callerno
   // deleteOldMatches();
//   $certReqs=NULL; // $funcReqs = NULL; //
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

//***************************


function updateSkillMatchesJP($jobID) {
	global $userID;

	
	//Q("UPDATE sys_match SET sysmat_skills='0' WHERE sysmat_job_id = '".$jobID."' ");
	
	
	//Check for deleted NAICS
	$q = "Select job_delete_id, job_delete_jobid, job_delete_naics from job_delete where job_delete_jobid = '".$jobID."'";
	
	$del_naics = Q2T($q);
	
	if ($del_naics) {
		
		foreach ($del_naics as $matchRow){
				$q = "select usrskl_usr_id from usr_skills where usrskl_skl_id = '".$matchRow['job_delete_naics']."'";
				$find_usr = Q2T($q);
				
				if ($find_usr) {
					foreach ($find_usr as $usrRow){
						$skill_match = Q2T("SELECT sysmat_skills, sysmat_certifications FROM sys_match WHERE sysmat_usr_id = '".$usrRow['usrskl_usr_id']."' and sysmat_job_id ='".$matchRow['job_delete_jobid']."' ");
						
						if ($skill_match) {
							foreach($skill_match as $skillRow)
							{
								$skill_cnt = $skillRow['sysmat_skills'];
								$certs_cnt = $skillRow['sysmat_certifications'];
								
								if ($skill_cnt > 0) {
									//echo $skill_cnt." user=".$usrRow['usrskl_usr_id']." certs: ".$certs_cnt."<br>";				
									$skill_cnt = $skillRow['sysmat_skills'] - 1;
									//echo $skill_cnt." user=".$usrRow['usrskl_usr_id']."<br>";
						
									$did = Q("UPDATE sys_match SET sysmat_skills = '".$skill_cnt."' WHERE sysmat_usr_id = '".$usrRow['usrskl_usr_id']."' and sysmat_job_id ='".$matchRow['job_delete_jobid']."' ");
								}
							}
						}
					}
				}
		}
		
		//Remove 
		//echo "removing row from delete table<br>";
		$q = "Delete from job_delete where job_delete_id ='".$matchRow['job_delete_id']."'";
		$did = Q($q);
		//exit();
	}
	
	//echo "No Delete Changes";

	
	
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_skills C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' and jobskl_status = '0' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);
	
	
	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills', S.sysmat_id as 'matchID' FROM usr_skills C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."'
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'skills' FROM usr_skills C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	/* echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit(); */
	
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$skill_cnt = QV("SELECT sysmat_skills FROM sys_match WHERE sysmat_id = '".$matchRow['matchID']."' ");
				$skill_cnt = $skill_cnt + $matchRow['skills'];
				$did = Q("UPDATE sys_match SET sysmat_skills = '".$matchRow['skills']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
				//echo "update sys_match - skill cnt = [ ".$skill_cnt." ] [".$matchRow['matchID']."]<br>";
				$did = Q("Update job_skills SET jobskl_status = 1 where jobskl_job_id = '".$jobID."'");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_skills, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['skills']."','".date("Y-m-d H:i:s")."','1')");
				//echo "insert into sys_match - skill cnt = [ ".$matchRow['skills']." ] [".$matchRow['matchID']."]<br>";
				$did = Q("Update job_skills SET jobskl_status = 1 where jobskl_job_id = '".$jobID."'");
			}
			}
		}
	}
// *put in caller	deleteOldMatches();
//   $certReqs=NULL; // $funcReqs = NULL; //
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

// ************updateAgencyMatchesJPnonzeroempid 4/23/19 lloyd ***********************88
function 	updateAgencyMatchesJPnonzeroempid($jobID) {
		global $userID,$emp_ID;
	$empid =	$emp_ID;
	
	Q("UPDATE sys_match SET sysmat_agencies='0' WHERE sysmat_job_id = '".$jobID."' "); // x
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_agencies C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	$skillReqs = Q2R($q);                                                             // nonzero  x

	$buffer = '';
	if ($skillReqs) {
	//	$buffer .='<hr/><hr/>'.$q; 
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usragen_usr_id as 'usr',C.usragen_emp_id as 'emp', count(C.usragen_skl_id) as 'agencies', S.sysmat_id as 'matchID' FROM usr_agencies C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usragen_usr_id and S.sysmat_emp_id = C.usragen_emp_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id and A.usrapp_emp_id =  C.usragen_emp_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	 AND  C.usragen_usr_id > 0 AND C.usragen_emp_id > 0
	AND S.sysmat_job_id = '".$jobID."'  AND S.sysmat_emp_id > 0 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id,C.usragen_emp_id ";

	// 	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
	
		$iq = "SELECT C.usragen_usr_id as 'usr',C.usragen_emp_id as 'emp', count(C.usragen_skl_id) as 'agencies' FROM usr_agencies C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id and A.usrapp_emp_id =  C.usragen_emp_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND  C.usragen_usr_id > 0 AND C.usragen_emp_id > 0
	AND C.usragen_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usragen_usr_id AND X.sysmat_emp_id=C.usragen_emp_id	)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id, C.usragen_emp_id";
	
	/*
    echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit();
*/
////		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID && $matchRow['emp'] <>$empid){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '". $matchRow['emp']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']); 
			if ($union_logic == '1'){
		////		if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['agencies']."' WHERE sysmat_id ='".$matchRow['matchID']."'and sysmat_emp_id = '".$matchRow['emp']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID  && $matchRow['emp'] <>$empid){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '".$matchRow['emp']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
			////	if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_emp_id,sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status)
				VALUES ('".$matchRow['usr']."','".$matchRow['emp']."','".$jobID."','".$matchRow['agencies']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
// *put in caller	deleteOldMatches();
//   $certReqs=NULL; // $funcReqs = NULL; //
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}
 /***********************88 end updateAgencyMatchesnonzeroempid*/
function updateAgencyMatchesJP($jobID) {
	global $userID;
	
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

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usragen_usr_id as 'usr', count(C.usragen_skl_id) as 'agencies', S.sysmat_id as 'matchID' FROM usr_agencies C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usragen_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id";

	// 	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
	
		$iq = "SELECT C.usragen_usr_id as 'usr', count(C.usragen_skl_id) as 'agencies' FROM usr_agencies C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usragen_usr_id
	WHERE C.usragen_skl_id IN (".$skillReqs['x'].") 
	AND C.usragen_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usragen_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usragen_usr_id";
	
	/*
    echo '[q][ '.$q.' ]<br><br>';
	echo 'edu [ '.$skillReqs['edu'].' ]<br><br>';
	echo '[xq][ '.$xq.' ]<br><br>';
	echo '[iq][ '.$iq.' ]<br><br>';
	exit();
*/
		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']); 
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
				$did = Q("UPDATE sys_match SET sysmat_agencies = '".$matchRow['agencies']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
				if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
				$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_agencies, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['agencies']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
// *put in caller	deleteOldMatches();
//   $certReqs=NULL; // $funcReqs = NULL; //
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}

function updateProflicMatchesJP($jobID) {
	global $userID;

			
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
		
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'proflics', S.sysmat_id as 'matchID' FROM usr_proflics C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'proflics' FROM usr_proflics C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_proflics = '".$matchRow['proflics']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 		
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_proflics, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['proflics']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}

// *put in caller	deleteOldMatches();
//   $certReqs=NULL; // $funcReqs = NULL; //
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}
//************************************  updateGeoMatchesJPnonzeroempid(   ******/
function  updateGeoMatchesJPnonzeroempid($jobID) 
{
	global $userID,$emp_ID;
	$empid =	$emp_ID;
	$buffer = "";
		
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_geos C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
		//echo "[ ".$q." ]"; exit();
	
	$skillReqs = Q2R($q);
	
	if ($skillReqs) {
	////	$buffer .='<hr/><hr/>'.$q; 
	////	if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
		$stateID = Q2T("SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].")");
		
		//echo "[ SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].") ]<br>"; exit();
		
		if ($stateID) {
			foreach ($stateID as $row) {
							
				$all = Q2T("SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."'");
				
				//echo "[ SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."' ]<br>"; exit();
				
				if ($all){
					foreach ($all as $id) {
						$stateAbbr = substr($id['catskl_label'],0,2);
						if ($id['catskl_all_ind'] == 1) {
							//$stateAbbr = substr($id['catskl_label'],0,2);
							$stateReqs = Q2R("SELECT group_concat(catskl_id SEPARATOR ',') as 'x' FROM cat_geos WHERE catskl_label like '".$stateAbbr."-%'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];

						}
						else{
							$stateReqs = Q2R("SELECT catskl_id FROM cat_geos WHERE catskl_label = '".$stateAbbr."-ALL'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['catskl_id'];							
						}
					}
				}
			}			
		}
				
		//echo "[ ".$skillReqs['x']." ]<br>";
		//echo "[ ".$stateReqs['x']." ]<br>";
		//$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];
		//echo "[ ".$skillReqs['x']." ]<br>";
		//exit();


		//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', C.usrskl_emp_id as 'emp', count(C.usrskl_skl_id) as 'geos', S.sysmat_id as 'matchID' FROM usr_geos C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id and S.sysmat_emp_id = C.usrskl_emp_id
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id  and A.usrapp_emp_id = C.usrskl_emp_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id > 0 and C.usrskl_emp_id > 0
	AND S.sysmat_job_id = '".$jobID."' AND S.sysmat_emp_id > 0 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id,C.usrskl_emp_id";  // nonzeroe y
	
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', C.usrskl_emp_id as 'emp', count(C.usrskl_skl_id) as 'geos' FROM usr_geos C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id and A.usrapp_emp_id = C.usrskl_emp_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id AND X.sysmat_emp_id=C.usrskl_emp_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id, C.usrskl_emp_id";

////		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID  && $matchRow['emp'] <>$empid ){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '".$matchRow['emp']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
		////	if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['geos']."' WHERE sysmat_id = '".$matchRow['matchID']."'and sysmat_emp_id ='".$matchRow['emp']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID && $matchRow['emp'] <> $empid){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."' and usrapp_emp_id = '".$matchRow['emp']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
		////	if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_emp_id, sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status)
			VALUES ('".$matchRow['usr']."','".$matchRow['emp']."','".$jobID."','".$matchRow['geos']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}

// *put in caller	deleteOldMatches();
//   $certReqs=NULL; // $funcReqs = NULL; //
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
	return $buffer;
}
   
    
/*  ****************8end  updateGeoMatchesJPnonzeroempid(  */    
    
function updateGeoMatchesJP($jobID) {
	global $userID;
		
	Q("UPDATE sys_match SET sysmat_geos='0' WHERE sysmat_job_id = '".$jobID."' ");
	$q = "SELECT group_concat(C.jobskl_skl_id SEPARATOR ',') as 'x', 
	J.job_edu_level as 'edu', L.catclr_rank as 'clr', J.job_ava_id as 'ava' FROM job_geos C
	LEFT JOIN job J ON J.job_id = C.jobskl_job_id LEFT JOIN cat_clearance L ON J.job_clearance = L.catclr_rank
	WHERE C.jobskl_skl_id > 0 AND C.jobskl_job_id = '".$jobID."' GROUP BY C.jobskl_job_id";
	
	//echo "[ ".$q." ]"; exit();
	
	$skillReqs = Q2R($q);
	
	
	$buffer = '';
	if ($skillReqs) {
		$buffer .='<hr/><hr/>'.$q; 
		if (isset($_REQUEST['jobMatches'])) $buffer .= $q.($skillReqs?'<br/>'.print_r($skillReqs,true):'<br/>No Data.').'<hr/>';
		
		$stateID = Q2T("SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].")");
		
		//echo "[ SELECT catskl_id from cat_geos where catskl_id in (".$skillReqs['x'].") ]<br>"; exit();
		
		if ($stateID) {
			foreach ($stateID as $row) {
							
				$all = Q2T("SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."'");
				
				//echo "[ SELECT catskl_label, catskl_all_ind FROM cat_geos WHERE catskl_id = '".$row['catskl_id']."' ]<br>"; exit();
				
				if ($all){
					foreach ($all as $id) {
						$stateAbbr = substr($id['catskl_label'],0,2);
						if ($id['catskl_all_ind'] == 1) {
							//$stateAbbr = substr($id['catskl_label'],0,2);
							$stateReqs = Q2R("SELECT group_concat(catskl_id SEPARATOR ',') as 'x' FROM cat_geos WHERE catskl_label like '".$stateAbbr."-%'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];

						}
						else{
							$stateReqs = Q2R("SELECT catskl_id FROM cat_geos WHERE catskl_label = '".$stateAbbr."-ALL'");
				
							if ($stateReqs) 
								$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['catskl_id'];							
						}
					}
				}
			}			
		}
				
		//echo "[ ".$skillReqs['x']." ]<br>";
		//echo "[ ".$stateReqs['x']." ]<br>";
		//$skillReqs['x'] = $skillReqs['x'].",".$stateReqs['x'];
		//echo "[ ".$skillReqs['x']." ]<br>";
		//exit();


		//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'geos', S.sysmat_id as 'matchID' FROM usr_geos C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'geos' FROM usr_geos C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_geos = '".$matchRow['geos']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_geos, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['geos']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}

// *put in caller	deleteOldMatches();

//   $certReqs=NULL; // $funcReqs = NULL; //
  $stateID =NULL;
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
		
			return $buffer;
}
/* updateVehiclesMatchesJPnonzeroempid($id); */
function updateVehiclesMatchesJP($jobID) {
	global $userID;
		
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
		
//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$xq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'vehicles', S.sysmat_id as 'matchID' FROM usr_vehicles C 
	LEFT JOIN sys_match S ON S.sysmat_usr_id = C.usrskl_usr_id 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id
	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND S.sysmat_job_id = '".$jobID."' 
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";

	//	AND A.usrapp_ava_id = '".$skillReqs['ava']."'
		$iq = "SELECT C.usrskl_usr_id as 'usr', count(C.usrskl_skl_id) as 'vehicles' FROM usr_vehicles C 
	LEFT JOIN usr_app A ON A.usrapp_usr_id = C.usrskl_usr_id

	WHERE C.usrskl_skl_id IN (".$skillReqs['x'].") 
	AND C.usrskl_usr_id NOT IN (SELECT X.sysmat_usr_id FROM sys_match X WHERE X.sysmat_job_id = '".$jobID."' AND X.sysmat_usr_id = C.usrskl_usr_id)
	AND A.usrapp_clearance >= '".$skillReqs['clr']."'
	GROUP BY C.usrskl_usr_id";
	

		if (isset($_REQUEST['jobMatches'])) $buffer .= ($skillReqs?'XQ:'.$xq . '<hr/>InsQ:'.$iq.'<hr/>':'');
		$updateMatches = Q2T($xq);
		$newMatches = Q2T($iq);
	
		if ($updateMatches) foreach ($updateMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){			
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[update] '.print_r($matchRow,true); 
			$did = Q("UPDATE sys_match SET sysmat_vehicles = '".$matchRow['vehicles']."' WHERE sysmat_id = '".$matchRow['matchID']."' ");
			}
			}
		}
		if ($newMatches) foreach ($newMatches as $matchRow) {
			if ($matchRow['usr'] <> $userID){
			$usr_app_union = Q2R("SELECT usrapp_edu_level as 'edu' FROM usr_app WHERE usrapp_usr_id = '".$matchRow['usr']."'");
			$union_logic = union_match($skillReqs['edu'], $usr_app_union['edu']);
			if ($union_logic == '1'){
			if (isset($_REQUEST['jobMatches'])) $buffer .= '<br/>[insert]'.print_r($matchRow,true); 		
			$did = Q("INSERT INTO sys_match (sysmat_usr_id, sysmat_job_id, sysmat_vehicles, sysmat_matched_date, sysmat_status) VALUES ('".$matchRow['usr']."','".$jobID."','".$matchRow['vehicles']."','".date("Y-m-d H:i:s")."','1')");
			}
			}
		}
	}
// *put in caller	deleteOldMatches();

//   $certReqs=NULL; // $funcReqs = NULL; //
//  $stateID =NULL;
   $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
		

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
// *put in caller	deleteOldMatches();

//   $certReqs=NULL; // 
$funcReqs = NULL; //   $stateID =NULL;    $skillReqs  = NULL;
		$updateMatches = NULL;
		$newMatches =NULL;
		

	return $buffer;

}

function deleteOldMatches(){
	Q("DELETE FROM sys_match WHERE (sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
}

function union_match($job_union,$mem_union){
	$SEL_EITHER = 0;
	$SEL_NON_UNION = 1;
	$SEL_UNION = 2;
	
	$union_logic = '1';
		
	if (($mem_union == $SEL_UNION) and ($job_union == $SEL_NON_UNION))
		$union_logic = "0";	
			
	if (($mem_union == $SEL_NON_UNION) and ($job_union == $SEL_UNION))
		$union_logic = "0";
	
/*	if (($mem_union == $SEL_EITHER) or ($job_union == $SEL_EITHER))
		$union_logic = "1";	
*/	
	

	return $union_logic;
}
function set_inactivetimeout()
{
    $_SESSION['bc2logged_in'] = true; //set you've logged in
$_SESSION['bc2last_activity'] = time(); //your last activity was now, having logged in.'inactive_time0ut'
$_SESSION['bc2inactive_timeout'] = 20*60; // 30 minutes // 45 seconds // 30*60; 30 minutes     //3*60*60; 3 hours
////$_SESSION['bc2expire_time'] = 3*60*60; //expire time in seconds: three hours (you must change this) = test with 30 secs
$_SESSION['bc2expire_time'] = $_SESSION['bc2inactive_timeout']; //expire time in seconds: test with 30 secs

}

function check_inactivetimeout()
{
    if( $_SESSION['bc2last_activity'] < time()-$_SESSION['bc2expire_time'] ) { //have we expired?
    //redirect to logout.php     header('Location: http://yoursite.com/logout.php'); //change yoursite.com to the name of you site!!
    //for dev,demo prod   --  
     global   $content , $siteWebRoot ;
  //$_SESSION['env'] = 'bc2dev/db';
  //$siteWebRoot = 'http://www.bc2match.com/'.$_SESSION['env'].'/';
     //$content.= 'Location: '.$_SESSION['env']. '/logout.php';
    header('Location: '.$siteWebRoot . '/logout.php'); //change to the name of you site!!
 
} else{ //if we haven't expired:
    $_SESSION['bc2last_activity'] = time(); //this was the moment of last activity.
}
}

?>