<?php 
// Join Now -Another Company or New User and New Company
//-- page settings
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

define('C3cms', 1);
$title = "Join Now";
$pageauth = 0;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$template = "jobcon"; 
$response = "content"; 
require "inc/core.php";

//-- define content -----------------------------------------------------------------
/* 12/6/18 code for situatjoin_op_actionion when entered e-mail finds no associated customers in the db
  that is, the original join now before user emails and ids could be associated with multiple customes 
  */
$footerScript .= " ";

$scriptLinks .= '<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
				<script type=$userID"text/javascript" language="javascript" src="js/jquery.colorbox.js"></script>
				<script type="text/javascript" language="javascript" src="js/jquery.jeditable.js"></script>';
$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/colorbox.css" />';


/*	*/	
  $halfheaderheight = "40";

$content .= DBContent();
 if (!(isset( $_SESSION['adminnnuserID'] )))
  {
  if (isset($_REQUEST['usr']) ) 
  {
      $userID = $_REQUEST['usr'];
      $_SESSION['adminnnuserID']  = $userID;
  }
  }
  if (isset($_REQUEST['empid'])) 
  {
      $userCompany = $_REQUEST['empid']; //  $empid $userCompany $userID
       $_SESSION['adminnuserCompany']= $userCompany;
  }
  
  $membernewcompany = 0;
  
  if (isset($_REQUEST['membernewcompany'])) 
  {
      $membernewcompany = $_REQUEST['membernewcompany'];
  }
  
  
  
/*&ptype=admin&empid=790819&usr=810668&generic_company_id=790819
&generic_assignedusr_id=810668&generic_username=tom@setasidealert.com
&generic_usr_firstname=Tojo
&generic_lastname=Johnson  */
  $content.= "<!-- br>26 userID = " .$userID . ", userCompany = " . $userCompany . "-->";
  
 
if (isset($_REQUEST['join_op_action']))
{
    $reqjoin_op_action = $_REQUEST['join_op_action'];
} else
 {
     $reqjoin_op_action = "notset";
 }

if (isset($_REQUEST['join_op'])) 
{
    $reqop = $_REQUEST['join_op'];
}
else 
{
    $reqop = "notset";
     
} 
$customCSS = <<<EOD
<style>
.btn-prm{
    padding: 5px 15px;
    margin: 8px 1px;
    background: #ccc;
    border: 1px solid #a9a9a9;
    border-radius: 4px;
}
.compDetails{

}

ul.options-list{
  padding-left: 25px;
}
  ul.options-list li {
    list-style: none;
    font-size: 18px;
    line-height: 1.7;
    color: #010b7c;
    position: relative;
    font-style: italic;
}
ul.options-list li:before {
    content: "";
    position: absolute;
    left: -24px;
    top: 50%;
    width: 10px;
    height: 10px;
    background: #fff;
    transform: translateY(-50%);
    border: 1px solid #010b7c;
    box-shadow: 2px 2px 0px 0px #010b7c;
}
.loginbox {
    width: calc(100% - 20px) !important;
    margin: 8px 0px;
    padding: 6px 10px;
    border: 0;
}
table.login-bg{
  position: relative;
}
.addCompanyFormimg:before {
    content: "";
    background-image: url({$siteWebRoot}img/girl.png);
    height: 100%;
    width: 100;
    position: absolute;
    left: -151px;
    top: 0;
    background-repeat: no-repeat;
    background-size: 100%;
    background-position: left center;
}
table.login-bg:before {
    content: "";
    background-image: url({$siteWebRoot}img/girl.png);
    width: 19%;
    height: 100%;
    position: absolute;
    left: -151px;
    top: 0;
    background-repeat: no-repeat;
    background-size: 100%;
    background-position: left center;
}
.main-body-content{
  position: relative;
  padding-bottom: 50px;
}
.main-body-content.new-join:before {
  right: 0;
  }

.main-body-content:before {
    content: "";
    background-image: url({$siteWebRoot}img/girl2.png);
    width: 19%;
    height: 100%;
    position: absolute;
    right: 50px;
    top: 0;
    background-repeat: no-repeat;
    background-size: 90%;
    background-position: left center;
}
.girl-bg{
  position: relative;
  padding-bottom: 100px;
}
.girl-bg:before {
    content: "";
    background-image: url({$siteWebRoot}img/girl3.png);
        width: 19%;
    height: 100%;
    position: absolute;
    right: 0px;
    top: 0;
    background-repeat: no-repeat;
    background-size: 70%;
    background-position: left center;
}
.dark-heading {
    padding: 30px 60px;
    font-size: 24px;
    line-height: 1.5;
    color: #00007f;
}
.table-form-label{
	text-align: left;width: 30%;font-size:18px;font-weight:bold;
}
.w-100{
	width:100%;
}
</style>
EOD;
$content .= $customCSS;

//switch (@$_REQUEST['join_op'])  
////1  
    $content .= "<!--br>Entered actionhub, reqjoin_op_action: ". $reqjoin_op_action. ", - actioncompany= ". $_REQUEST['actioncompany'] .",join_ptype: ".  $_REQUEST['join_ptype']."-->" ;
  switch ($reqjoin_op_action)
  {
      case "actionhub":
            /* 
                <br>&nbsp;<input type="radio"   name="actioncompany" 	value="1" checked="checked"/>Log in 
                 <br>&nbsp;<input type="radio"   name="actioncompany" 	value="2" />Add User
	    		                             <br>&nbsp;<input type="radio"   name="actioncompany"	value="3"/> Add Seats 
	    		                              <br>&nbsp;<input type="radio"   name="actioncompany" value="4"/> Upgrade Level
	    	*/
	      $content .= "<!--br>Entered actionhub - actioncompany= ". $_REQUEST['actioncompany'] .",join_ptype: ".  $_REQUEST['join_ptype'] 
	      . ", REQUEST['generic_join_op_todo']: ". $_REQUEST['generic_join_op_todo']." --> ";	
           switch ($_REQUEST['actioncompany'])
             {
               case 1:
                   $reqop = "logintoexistco"; //need to pass
                      /*   $login_company_id = $_REQUEST['company_id'];
 	                             $login_numcos = $_REQUEST['numcos'];
 	                    $login_assignedusr_id  = $_REQUEST['assignedusr_id'];
				          $login_usr_firstname = $_REQUEST['usr_firstname'];
				          $login_lastname      = $_REQUEST['lastname'] ;
				          $login_username      = $_REQUEST['username'];
				          $login_usr_auth      = $_REQUEST['usr_auth'] ;
				           $login_usr_type     = $_REQUEST['usr_type'];
				           $login_company_id   = $_REQUEST['company_id']; 
				            $login_company_name = $_REQUEST['emp_name'];
				            $login_level = $_REQUEST['level'];
				           set to  company_id" value="'.$co_dashrow['companyid'].'"/> x
	    		                                  assignedusr_id" value="'.$co_dashrow['assignedusr_id'].'"/> x
	    		                                   usr_firstname" value="'.$co_dashrow['firstname'].'"/> x
	    		                                    lastname" value="'.$co_dashrow['lastname'].'"/> x
	    		                                      usr_type" value="'.$co_dashrow['usertype']. '"/> x
	    		                                      usr_auth" value="' .$co_dashrow['userauth'].' "/> x
	    		                                        username" value="'.$reqemail.'"/> 
	    		                                        emp_name" value="'.$strcompanyname.'"/>
	    		                                         subscriptionlevel" value="'.$co_dashrow['subscriptionlevel'].'"/> 
	    		                                    numseats       numcos" value="'.$numrows.'"/> 
	    		                                       " value="'.$co_dashrow['numseats'].'"/> 
	    		                                        numseatsoccupied" value="'.$co_dashrow['numseatsoccupied']. '"/> 
	    		                                        emp_name" value="'.$strcompanyname.'"/> 
	    		                                        level" value="'.$co_dashrow['subscriptionlevel'].'"/> */
	                  $login_company_id = $_REQUEST['company_id'];
	                  $login_assignedusr_id  = $_REQUEST['assignedusr_id'];
	                  $login_usr_firstname = $_REQUEST['usr_firstname'];
	                   $login_lastname      = $_REQUEST['lastname'] ;
	                   $login_username      = $_REQUEST['username'];
	                   $login_usr_auth      = $_REQUEST['usr_auth'] ;
				           $login_usr_type     = $_REQUEST['usr_type'];
				            $login_company_id   = $_REQUEST['company_id']; 
				            $login_company_name = $_REQUEST['emp_name'];
				            $login_level = $_REQUEST['level'];
                   break;
               case 2:
                   /*value="2" />Add User*/
                    $_SESSION['adminnnuserID']  =  $_REQUEST['assignedusr_id'];
                    $reqop = "addnewuserexistcompany";
                    $frompage=$_REQUEST['frompage']; ////j ";  joinow_logging_in
                     $addnewuser_company_id = $_REQUEST['company_id'];  //company_id fromlogin//company_id <input type="hidden" name="company_id" value="'.$addnewuser_company_id .'"/> 
	                  $addnewuser_assignedusr_id  = $_REQUEST['assignedusr_id'];
	                  $addnewuser_usr_firstname = $_REQUEST['usr_firstname'];
	                   $addnewuser_lastname      = $_REQUEST['lastname'] ;
	                   $addnewuser_username      = $_REQUEST['username'];
	                   /////username      = $_REQUEST['username'];
	                   $addnewuser_usr_auth      = $_REQUEST['usr_auth'] ;
				           $addnewuser_usr_type     = $_REQUEST['usr_type'];
				            ////$addnewuser_company_id   = $_REQUEST['company_id']; 
				            $addnewuser_company_name =  $_REQUEST['company_name'];  ///   n   ot$_REQUEST['emp_name'];
				            $addnewuser_level = $_REQUEST['level'];
				                 $addnewuser_level       = $_REQUEST['level'];
				              $addnewuser_numseats  = $_REQUEST['numseats'];
				       $addnewuser_numseatsoccupied = $_REQUEST['numseatsoccupied'];
				       $addnewuser_NEW_username = $_REQUEST['new_contactEmail'];
                   break;
               case 3:
                   //add seats
                       $content .= "<!-- br>trace 118 in action hub case 3 add seats -->";
                       if ( $_REQUEST['generic_join_op_todo'])
                       {
                           $reqop = $_REQUEST['generic_join_op_todo'];  // came from generic login for
                       }else
                       {   // if empty came from the action form, so first login
                           $reqop = "generic_login_form";   //  generic_join_op_todo  generic_login_form addseatexistcompany
                       }
                        
                        /* from orig form  to login to exist compp<input type="hidden"  name="login_retry" value='.$_Session['joinnow_logins'].'/> 
				                <input type="hidden" name="username" value="'.$reqemail.'"/> 
				             $generic_join_op_todo = "addseatexistcompany";
				       $reqop = "generic_login_form";    				                */
				                $generic_casevalue = "addseatexistcompany";
				                  $frompage=$_REQUEST['frompage']; 
				         $generic_frompage=$_REQUEST['frompage']; 
				            $generic_company_id  = $_REQUEST['company_id'];
				            $generic_company_id = $_REQUEST['generic_company_id'];  //  = $_REQUEST['company_id'];']
	                 $generic_assignedusr_id     = $_REQUEST['assignedusr_id'];
	                  $generic_usr_firstname     = $_REQUEST['usr_firstname'];
	                   $generic_lastname         = $_REQUEST['lastname'] ;
	                   $generic_username         = $_REQUEST['username'];
	                   $generic_usr_auth         = $_REQUEST['usr_auth'] ;
				          $generic_usr_type      = $_REQUEST['usr_type'];
				           $generic_company_id   = $_REQUEST['company_id']; 
				           $generic_company_name = $_REQUEST['company_name'];
				            $generic_level       = $_REQUEST['level'];
				              $generic_numseats  = $_REQUEST['numseats'];
				       $generic_numseatsoccupied = $_REQUEST['numseatsoccupied'];
				       $generic_actioncompany = 3; //addseats
				     
                   break; 
                   Case 4: 
                      //// $reqop = $_REQUEST['generic_join_op_next'];  // 
                      $content .= "<!--br>trace 148 in action hub case 4 upgrade level -->";
                      //$generic_join_op_next = $_REQUEST['generic_join_op_next']; 
                        if ( $_REQUEST['generic_join_op_todo'])
                       {
                           $reqop = $_REQUEST['generic_join_op_todo'];  // came from generic login for
                       }else
                       {   // if empty came from the action form, so first login
                           $reqop = "generic_login_form";   //  generic_join_op_todo  generic_login_form 
                       }
                      //"upgradelevelexistcompany";
                      $generic_casevalue =  "upgradelevelexistcompany"; 
                    $generic_join_op_todo = "upgradelevelexistcompany";      
                        $frompage=$_REQUEST['frompage']; 
				         $generic_frompage=$_REQUEST['frompage']; 
				            $generic_company_id  = $_REQUEST['company_id'];
	                 $generic_assignedusr_id     = $_REQUEST['assignedusr_id'];
	                  $generic_usr_firstname     = $_REQUEST['usr_firstname'];
	                   $generic_lastname         = $_REQUEST['lastname'] ;
	                   $generic_username         = $_REQUEST['username'];
	                   $generic_usr_auth         = $_REQUEST['usr_auth'] ;
				          $generic_usr_type      = $_REQUEST['usr_type'];
				           $generic_company_id   = $_REQUEST['company_id']; 
				           $generic_company_name = $_REQUEST['company_name'];
				            $generic_level       = $_REQUEST['level'];
				              $generic_numseats  = $_REQUEST['numseats'];
				       $generic_numseatsoccupied = $_REQUEST['numseatsoccupied'];
				       $generic_actioncompany = 4; //  upgrade level
				         
                    break; 
                case 5: case "subscribeCompany":
                    // have a SAM user and associated company with level 0  - make company live with  specified level and number of seats specified, set occupied seats to 1
                    $reqop = "addanothercompany";
                     $login_company_id = $_REQUEST['company_id'];
	                  $login_assignedusr_id  = $_REQUEST['assignedusr_id'];
	                  $login_usr_firstname = $_REQUEST['usr_firstname'];
	                   $login_lastname      = $_REQUEST['lastname'] ;
	                   $login_username      = $_REQUEST['username'];
	                   $login_usr_auth      = $_REQUEST['usr_auth'] ;
				           $login_usr_type     = $_REQUEST['usr_type'];
				            $login_company_id   = $_REQUEST['company_id']; 
				            $login_company_name = $_REQUEST['emp_name'];
				            $login_level = $_REQUEST['level'];
				             $generic_company_id   = $_REQUEST['company_id']; 
				           $generic_company_name = $_REQUEST['emp_name'];
				            $generic_level       = $_REQUEST['level'];
				            $generic_actioncompany = 5;
				          if  ($_REQUEST['actioncompany'] == "subscribeCompany") 
				          {
				               $generic_actioncompany = 5;
				             $generic_company_name = $_REQUEST['company']  ;
				          $generic_company_id = $_REQUEST['company_id'];
				          $reqop = "subscribeCompany";
				          }
                    break;
                default:
                    
                    break;
             }
         break;
      default :
      break;    
  }
 
  //$reqop = 'addanothercompany';
   switch ($reqop) 
   {
   case "startNewEmployer":
              $_SESSION['joinusr_type'] = 0 ;
         	  $content .= '<!-- at case "startNewEmployer" -->';
      if (!( $_REQUEST['contactEmail'] =='')) { //0
			     $reqemail =  $_REQUEST['contactEmail'];
			     $usethisemail=$reqemail;   // always us original email entered on first page even if user changes it on login
			       //get usr_type
			       	$check4usrtype = "  SELECT usr_type  FROM usr   WHERE   usr_email like '". $reqemail. "'  ";
			    $joinrequsr_type = QV($check4usrtype);
			   // $content .= "  joinrequsr_type" . $joinrequsr_type . "";
			    if (!($joinrequsr_type ==NULL))  $_SESSION['joinusr_type']= $joinrequsr_type ;
			     $content .= " <!-- br>at startNewEmployer - Session['joinusr_type']: " . $_SESSION['joinusr_type'] . " You entered for E-Mail: " .  $reqemail ." -->" ; 
			   //////use usremp_usr_assignedusr_id` usremp_usr_assignedusr_id and join
			    $check4dupeemail = "  SELECT usr.usr_id as usruserid,usr.usr_password as reqpassword,usemp.usremp_usr_assignedusr_id as assignedusr_id,emp.emp_contact,usr.usr_email as email,usr.usr_lastname as lastname,usr.usr_firstname as firstname,usr.usr_type as usertype ";
		        $check4dupeemail .= "  ,usr.usr_auth as userauth,usr.usr_company,usr.usr_phone ";
                $check4dupeemail .= "     ,emp.emp_id as companyid, emp.emp_name as companyname ,emp.emp_contact,emp.emp_number_seats as numseats, emp.emp_seats_occupied as numseatsoccupied ";
                $check4dupeemail .= "   ,emp.emp_level as subscriptionlevel,usemp.usremp_id,usemp.usremp_usr_id as companyuserid,usemp.usremp_emp_id,usemp.usremp_auth,usemp.usremp_type ";
//    $check4dupeemail .= " FROM usr usr inner join emp emp on emp.emp_id = usr.usr_company inner join usr_emp usemp on usemp.usremp_usr_assignedusr_id = usr.usr_id ";
$check4dupeemail .= " FROM usr usr  left join usr_emp usemp on usemp.usremp_usr_assignedusr_id = usr.usr_id  left join emp emp on emp.emp_id = usemp.usremp_emp_id ";
       	              	       
       	        $check4dupeemail .= "  WHERE   usr.usr_email like '". $reqemail. "'  AND usemp.usremp_usr_assignedusr_id is not NULL order by emp.emp_name,usr.usr_email,usr.usr_lastname,usr.usr_firstname ";
       	       // changed last inner join from  inner join usr_emp usemp on usemp.usremp_emp_id = emp.emp_id 
       	       
       	           //  $check4dupeemail .= " FROM usr usr inner join emp emp on emp.emp_id = usr.usr_company inner join usr_emp usemp on usemp.usremp_usr_id = usr.usr_id ";
       	 //// 8/22/19 changed above iiner joins to left joins lloyd  - not getting sam people not members of bc2match
       	         $tracecompany = '';    	           ////	
       	     $content.= '<!--  br>  check4dupeemail: ' . $check4dupeemail. '<br> ....-->';
       	     /*********************ala bc2companydshboard***************************************/
		/*******SCROLL BEGIN******/
	 
         $usr_welcome_flagSQL = "select usr_welcome_flag from usr where usr_email ='".$reqemail."'";
         $usr_welcome_flag = QV($usr_welcome_flagSQL);
         

	     $_SESSION['$comdash_exists']= 'no';
		if ($result=mysqli_query($conn, $check4dupeemail))
		  { // 1
		  
		   	if ((mysqli_num_rows($result)>0) && ($usr_welcome_flag <> 1))		        	 
		      { //2
		      
		          if (mysqli_num_rows($result)>1) {$_SESSION['$comdash_exists']= 'yes'; }// 3 -3
		          
		          //2
		        	    $dupectr = 0; 
		        	    
		       	$scrollit = 360;
	      	$link_color="#eeeeee";
	      	$cofont_color="#dddddd";
	    	 $linkbgcolor="#aaaaaa";
		    $headerheight ="80";
		     $halfheaderheight ="40";
 		    $height="60";
 		     $content.= '<table class="table-striped login-bg" align="center" width="780" border="0" bordercolor="red" cellspacing="1"><tr><td align="center" width="780">
		 <p style="text-align:center; font-size:28px;color:#00005F;margin:20px 0;">
		 Welcome to BC2Match</p>
		 </td></tr><tr><td>';
 	    	$content .= ' <table align ="center"  width="780">';
 	    		$content .= '    <tbody> 		  <tr><td> ';
 		    $content .= ' <!--  SESSION[usr_auth]: '.  $_SESSION['usr_auth'].', sess comdash_exists: ' .$_SESSION['$comdash_exists'] . ', my_pagename: ' .  basename($_SERVER['PHP_SELF']) . ' -->
                </td></tr>';
      	 $content .= ' <tr> <td width="780" colspan="1" height="'.$headerheight.'" >'; 
      	 $content .= '<h3 style="font-size: 20px;line-height: 1.5;margin-top: 0;color: #010b7c; text-align:center;">We have the following compan(y)(ies) affliliated with your e-mail address: '.$reqemail;
           If (($_SESSION['joinusr_type'] == 0) || ($_SESSION['joinusr_type']== 99))
                {  $content .= '</h3> </td></tr> ' ;
                $_SESSION['emailtogodash'] = $reqemail;
                   
		$content .= '<!--      <tr><td  align="center" style="background-color:#aaaaaa; width:780px;text-align:center; height:84px;"> 
	         To add a new <b>User</b> to an existing Company, Login here with displayed e-mail: 
	                     
	           <br> 		<form  action="'.$_SERVER['PHP_SELF'].'"  method="post"> 
		          <table cellspacing="5" cellpadding="0" border="0" align="center">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" style="width:180px;" value="'.$reqemail.'" id="joinusername" name="joinusername" title="Email or User Name" />
				</td><td>&nbsp; </td> <td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td valign="bottom">  		<input type="hidden" name="join_op" value="addnewuserexistcompany"/> 
				                	<input type="hidden" name="join_opusr_type" value="addnewuserexistcompany"/> 
				                    
				                <input type="hidden"  name="login_retry" value='.$_Session['joinnow_logins'].'/> 
				                <input type="hidden" name="username" value="'.$reqemail.'"/> 
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
					</tbody></table>
		  </form><br/>
		   </td></tr>
				 <tr><td align="center" style="background-color:#dddddd; width:780px;align:center; height:84px;"> 
	          To add a <b>Subscribed Seat</b> or <b> Seats</b>  to an existing Company, Login here with displayed e-mail: 
	                      
	           <br> 		<form  action="'.$_SERVER['PHP_SELF'].'" method="post"> 
		          <table cellspacing="5" cellpadding="0" border="0" align="center">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" style="width:180px;" value="'.$reqemail.'" id="join_username" name="join_username" title="Email or User Name" />
				</td><td>&nbsp; </td> <td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td valign="bottom">  		<input type="hidden" name="join_op" value="addseatexistcompany"/> 
				                    
				                <input type="hidden"  name="login_retry" value='.$_Session['joinnow_logins'].'/> 
				                <input type="hidden" name="username" value="'.$reqemail.'"/> 
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		  </form><br/>     
		    </td></tr>   
		    
		    
		     <tr><td align="center" style="background-color:#dddddd; width:780px;align:center; height:84px;"> 
	          To <b>Change</b> your <b>Subscription Level</b> of an existing Company subscription, Login here with displayed e-mail: 
	                      
	           <br> 		<form  action="'.$_SERVER['PHP_SELF'].'" method="post"> 
		          <table cellspacing="5" cellpadding="0" border="0" align="center">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" style="width:180px;" value="'.$reqemail.'" id="join_username" name="join_username" title="Email or User Name" />
				</td><td>&nbsp; </td> <td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td valign="bottom">  		<input type="hidden" name="join_op" value="upgradelevelexistcompany"/> 
				                    
				                <input type="hidden"  name="login_retry" value='.$_Session['joinnow_logins'].'/> 
				                <input type="hidden" name="username" value="'.$reqemail.'"/> 
					<input type="submit"  style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		  </form><br/>     
		    </td></tr>  
		 --> </td></tr>'; 
 		    }     // usr_type must be 0 or 99 to do add user or add company
 	     
 		  $content .='<tr><td align="center"  style="background-color:#aaaaaa width:780px;align:center;">' ;
 	      $content .='<table align="center" width="780">';
/* 		 
 		 $content .= '<tr ><td colspan="5" width="780" height="40" style="font-size: 16px;padding: 15px;width: 100%;" bgcolor="#4472c4" align="center"><font color="#FFFFFF"><strong> 
 	                 <b> To login, Add a User, Add Seats, or changes levels to an exciting Company below, click on the<br>
Action Button beside the Company and the click GO. </b></strong></td></tr>';
*/
            
        $content .= '<tr ><td colspan="5" width="780" height="40" style="font-size: 16px;padding: 15px;width: 100%;" bgcolor="#4472c4" align="center"><font color="#FFFFFF"><strong> 
 	                 <b> Click Go to log in to an existing Company below. After logging in, <br>you will have the ability to add additional seats and users for the selected Company.<br></b></strong></td></tr>';
 		////$content .= '<tr ><td width="780" height="1" colspan="3" style="background-color: #9fcfff; ><td></tr>';
 	      // $content .= '<table width="780" border="0" align="center" >';
 	       	////$content .= '<tr ><td width="780"  colspan="3" align="center"style="background-color: #9fcfff; ></td</tr>';
 	       $content .= '<tr ><td width="334"  align="center" style="background-color: #9fcfff;"> Company</td>
 	                         <td width = "106" align = "center" style="background-color: #9fcfff;"> Action </td>
 	                         <td width="98"  align="center" style="background-color: #9fcfff;"> Subscription Level</td>
 	                        <td   width="98" align="center" style="background-color: #9fcfff;">Number of <br>Occupied Seats</td>
 	                         <td  width="98" align="center" style="background-color: #9fcfff;"> Number of <br>Seats in Subscription</td></tr> ';                  
 		   ////$content .= '</table></td></tr>';  //3col
 	////	$content .='<tr ><td width="780" colspan="3" >';
 	 	$content .='<tr ><td colspan="5" width="780"  align="center">';
 			$content .='<div class="container" align="center" style="border:0px solid #ccc; width:780px; height: '.$scrollit.'px; overflow-y: scroll;">
 	       	<table cellspacing="1" class="winner-table" width="780" align="center" >
 	        	<tbody>';
 		////	$content .='<tr ><td colspan="3" width="780" height="1" align="center"></td></tr>';
 	     	$rcnt = 1;
 	          
                      $numrows = mysqli_num_rows($result);
		        $rcnt = 1;
		       $bool1 = 1;
           $levelquery = " SELECT MAX(subscription_level) as maxlevel,MIN(subscription_level) as minlevel FROM price_table ";
 $maxlevel =  QV($levelquery) ;
		      while ($co_dashrow = mysqli_fetch_array($result, MYSQLI_ASSOC))      
		      {    // 3                          if ($  a & 1) {    echo 'odd';} else {    echo 'even';}  
		         if ($rcnt & $bool1 )	 //  if (is_int($rcnt/2))
			       {$linkbgcolor = "#dddddd";   // 4
		           } else 
		           {$linkbgcolor = "#999999";
		           }                           //-4
 			     //frombc2joinnowco
 			$subscriptionlevel = $co_dashrow['subscriptionlevel'];       //$maxlevel $subscriptionlevel
 		    switch ($subscriptionlevel)
 			     {
 			         case 0:
 			           $subleveldesc = "Un-subscribed";
 			            //$levelcolor = "#cccccc";
 			             $levelfgcolor = "#bbbbbb"; //"#f5f5f5"; // actually background color
 			           break;
 			         
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
 			         case 4 :
 			            $subleveldesc = "Titanium";
 			            // $levelcolor 
 			             $levelfgcolor == "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $subleveldesc = "Silver";
 			          //  $levelcolor 
 			            $levelfgcolor =  $levelfgcolor = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			     } 
 			     $_SESSION['addco_assignedusr_id'] = $co_dashrow['assignedusr_id'];
 			      $_SESSION['addco_firstname']=$co_dashrow['firstname'];
                 $_SESSION['addco_lastname']=$co_dashrow['lastname'];
                 $_SESSION['addco_contactPhone']=$co_dashrow['usr_phone'];
 			     $thiscompanyname = $co_dashrow['companyname'];
 			     $thisusr_type = $joinrequsr_type;
 			     $strcompanyname = str_replace("&", "AND",$thiscompanyname,  $cocount);//		       $strcompanyname = str_replace("AND", "&amp;",$thiscompanyname,  $cocount);
   			   /* can we put a radio button on each company
   			    <td > 
	    	                                    	<input type="radio"   name="user_type" 	value="1" "checked" >Regular User
	    		                                  &nbsp;  <input type="radio"   name="user_type"	value="0"> Primary </td></tr>
	    		             	<input type="radio"   name="action" 	value="1" "checked" >Log in
	    		                                  &nbsp;  <input type="radio"   name="user_type"	value="0"> Primary </td></tr>
   			   */
   			      $thisrowheight=40;   //  '.$thisrowheight'
   			     
   			     // $content.='  <form>';
   			      
   			     $content .= '<tr  ><td  width="324"   height="'.$thisrowheight.'"   align="center"  style="font-color:'.$cofont_color.';background-color:'.$linkbgcolor.';">
   			     <strong>
 			           <b>' .$thiscompanyname .' </b></strong>
 			        </td>
 			        <td   width="102" height="'.$thisrowheight.'" style="font-size:10px;text-align:left;font-color:'.$cofont_color.';background-color:'.$linkbgcolor.'; ">
 			           
 			                   <form  action="'.$_SERVER['PHP_SELF'].'" method="post" > ';
/*** 			                   
 			                if  ($subscriptionlevel == 0)  
 			                {
	    		                 $content .= ' <br> <br><span style="font-size:14px;color:#000099;">&nbsp;
	    		                 <input type="radio"   name="actioncompany"  checked="checked"	value="5"/><b> Subscribe</b> </span>';
	    		                            
 			                }
 			                  elseif ( $co_dashrow['numseatsoccupied']   > $co_dashrow['numseats'])
 			                 {
 			                  $content .= '        
 		                             <br>&nbsp;<input type="radio"   name="actioncompany" 	value="1" checked="checked"/>Log in ';
 			                         If (($_SESSION['joinusr_type'] == 0) || ($_SESSION['joinusr_type']== 99))         
 			                              {
 			                             // $content .= '     <br>&nbsp;<input type="radio"   name="actioncompany" 	value="2" />Add User
 			                             //<input type="button" /> Add User
 		                                     //   </span>       
 		            $content .= '<br>&nbsp;&nbsp';
 		              $content .= '     <br>&nbsp;<input type="radio"   name="actioncompany" disabled="disabled"	value="2" />
 		               
 		              <span style="text-decoration:line-through;">Add User  </span>
 		                             <br> &nbsp;&nbsp;&nbsp;<span style="font-size:9px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Need more seats</span>
 		                    
	    		                             <br>&nbsp;<input type="radio"   name="actioncompany" 	value="3"/> Add Seats';

	    		                             /*<br>&nbsp;<input type="radio"   name="actioncompany" value="4"/> Upgrade Level';*/
/***	    		                             
 			                             }
 			                 } else
 			                     {    $content .= '     <br>&nbsp;<input type="radio"   name="actioncompany" 	value="1" checked="checked"/>Log in ';
 			                        If (($_SESSION['joinusr_type'] == 0) || ($_SESSION['joinusr_type']== 99))         
 			                             {  
 			                              $content .= '     <br>&nbsp;<input type="radio"   name="actioncompany" 	value="2" />Add User
	    		                             <br>&nbsp;<input type="radio"   name="actioncompany"	value="3"/> Add Seats ';
	    		                             if ( $subscriptionlevel < $maxlevel)
	    		                             {//$content .= '   <br>&nbsp;<input type="radio"   name="actioncompany" value="4"/> Upgrade Level';
                                       }
 			                             }
 			                 } 
***/ 			                 
//<input type="hidden" name="join_op_action" value="actionhub"/> 
 			                        $content .= ' <input type="hidden"   name="actioncompany" 	value="1" />
 			                                     <input type="hidden"   name="join_ptype" value="joinaction"/> 
	    		                                <input type="hidden"   name="company_id" value="'.$co_dashrow['companyid'].'"/> 
	    		                                 <input type="hidden"   name="assignedusr_id" value="'.$co_dashrow['assignedusr_id'].'"/> 
	    		                                  <input type="hidden"   name="usr_firstname" value="'.$co_dashrow['firstname'].'"/> 
	    		                                   <input type="hidden"   name="lastname" value="'.$co_dashrow['lastname'].'"/> 
	    		                                     <input type="hidden"   name="usr_type" value="'.$co_dashrow['usertype']. '"/> 
	    		                                     <input type="hidden"   name="usr_auth" value="' .$co_dashrow['userauth'].' "/> 
	    		                                       <input type="hidden"   name="username" value="'.$reqemail.'"/> 
	    		                                       <input type="hidden"   name="emp_name" value="'.$strcompanyname.'"/>
	    		                                        <input type="hidden"   name="company_name" value="'.$strcompanyname.'"/>

	    		                                      
	    		                                        <input type="hidden"   name="numcos" value="'.$numrows.'"/> 
	    		                                        <input type="hidden"   name="numseats" value="'.$co_dashrow['numseats'].'"/> 
	    		                                       <input type="hidden"   name="numseatsoccupied" value="'.$co_dashrow['numseatsoccupied']. '"/> 
	    		                                     
	    		                                       <input type="hidden"   name="level" value="'.$co_dashrow['subscriptionlevel'].'"/> 
	    		                                       <input type="hidden"   name="frompage" value="joinpage_actionhub" />
	    		                                	<input type="hidden" name="join_op" value="samuserlogin"/> 
	    		                                
	    	                             <br>&nbsp; 
			         <button type="submit" style="border:0;padding: 0px 12px 0px 0px;background-color:'.$linkbgcolor.' " >                                  
	          <img src="images/Go_butt_25B_Off.gif" valign="top" align="left" border="0" width="20" height="20" border-color="'.$linkbgcolor.'" title="Click to take action selected">
 			         </button>
 			     
                   </form> 
                   </td>
 			        <td width="97" height="'.$thisrowheight.'" align="center" style="font-color:'.$cofont_color.'; background-color:'.$levelfgcolor.';"><span style="font-color:'.$cofont_color.'; background-color:'.$levelfgcolor.';">'.$subleveldesc. '</span></td>
 			    
 			       <td width="97" height="'.$thisrowheight.'" align="center" style="font-color:'.$cofont_color.';   background-color:'.$linkbgcolor.';" > ';
 			       if    ($subscriptionlevel == 0) 
 			              {$content  .= '-';} else  
 			              {$content  .= $co_dashrow['numseatsoccupied'];
 			              } 
 			       $content  .=  '</td>
 	              <td align="center" width="97" height="'.$thisrowheight.'" style="font-color:'.$cofont_color.';   background-color:'.$linkbgcolor.';">  ';
 	              if    ($subscriptionlevel == 0) 
 			              {$content  .= '-';} else 
 			              {$content  .= $co_dashrow['numseats'];
 			              }
 			               $content  .=  '</td></font></td></tr>
                   ';
 				    $rcnt +=   1 ;  ////$linkbgcolor  $levelfgcolor
		       } //3   
		          $content  .= '</td></tbody></table> </td></tr>   ';

		     //// $content .= '  <tr> <td align="center" width="780" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;"></td></tr> </table>';
		       $content .= '  </div>';
		       $content .= ' <table width="780" align="center">
		       <tr> <td align="center" width="780" colspan="3"></td></tr> </table>';
		        $content .= ' </div></div>'		        ;
		        
		        $content .= '</tr>';

/* Removed per conversation with Jon and Tom 4/25/2020		        
		        
            if (mysqli_num_rows($result)>0)               
            { //2
              $content .= '     <tr><td width="780"  style="background-color: #eaeff7;height: auto;text-align: center;padding: 15px;">
               <p><b>To login, Add Users or Add Seats, choose an Action radio button beside the Company and click GO</b></p>
             <form  action="'.$_SERVER['PHP_SELF'].'" method="post"> 
              <table cellspacing="5" cellpadding="0" border="0" style="width: 100%;">
        <tbody><tr><td>
          <label class="loginlabel"> E-mail</label>
          <input class="loginbox" type="text" maxlength="40" size="24" style="width:180px;" value="'.$reqemail.'" id="join_username" name="join_username" title="Email or User Name" />
        </td><td>&nbsp; </td> <td>
          <label class="loginlabel"> Password</label>
          <input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
        </td><td  valign="bottom">      <input type="hidden" name="join_op" value="addanothercompany"/> 
                          <input type="hidden" name="username" value="' .$reqemail .'"/> 
          <input type="submit" style="padding: 5px 15px;margin: 8px 1px;background: #ccc;border: 1px solid #a9a9a9;border-radius: 4px;" value="Submit" title="Submit" /><br/>
        </td></tr><tr>
<td colspan="3" style="text-align: right;">
          <a href="forgot.php" class="">Forgot your password? </a>
        </td>
        </tr>
      </tbody></table>
      </form><br/>
       </td></tr>';
            }
*/            
            $content .= '</table>';
		        
		       
		            $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
               <table width="780" align="center">
               <tr> <td align="center" width="780" colspan="1" >
                             
                </td> </tr>            
                   <tr> <td align="center" width="780" colspan="1" height="'.$headerheight.'">
                      <br>
                    <a href ="../join-now/">Return to BC2Match Join Now Page </a>                  
                  </td><tr>
                  <tr> <td align="center" width="780" colspan="3" ></td></tr>
                  </table> </div>';
		        
       /******* SCROLL END *******/
             }  // - 2
        	   else 
             {
                 if (($usr_welcome_flag == 1) && ($membernewcompany <> 1))
                 {
                     //***  SIGN IN PAGE ***//
                     /***
                     <form id="login" name="login" method="post" action="db/index.php">
        <div class="form-group">
 			 <input type="text" name="username" id="username" class="" placeholder="E-Mail Address" title="E-Mail Address" required>
 			 &nbsp;&nbsp;
			 <input type="password" name="password" id="password" title="Password" class="" placeholder="Password" required>
			 <input type="hidden" name="op" value="newemaillogin"/>
			 
			 <input type="submit" name="submit" id="submit" value="Sign In" title="Submit">
			 
			<a href="db/forgot.php">Forgot your password?</a>
        </div>
      </form>
      ***/
                  //2
		           	   //     $content .= " " . $_REQUEST['contactEmail'] . " - Not found will prompt to add person and company <br>";   
		     /////	$content .= D B Content(); '.D B Content('','Application Form').'
		     $content.= '<div class="main-body-content new-join"><table class="table-striped" align="center" width="780" border="0" bordercolor="red" cellspacing="1"><tr><td align="center" width="780">
		 <span style="text-align:center; font-size:18px;color:#99bbff;">
		 <br> <strong class="dark-heading">You already have at least one registered company. Please log in to your account here. Once you are logged in you will be able to add additional companies.</strong> <br><br></span>
		 </td></tr><tr><td>';
		   $custommessage= "message here";
		   
		   
		   
            $content .= '<form id="login" name="login" method="post" action="index.php">
	        <div style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width: auto;padding-bottom:0;">
	    	<div style="float:right"></div>
	    	<br>
		    <table class="w-100" style="border:0px;" cellpadding="0" cellspacing="0">
		    	<tr><td class="table-form-label">E-Mail Address: </td>
				<td><input type="text" name="username" id="username" class="" placeholder="E-Mail Address" title="E-Mail Address" value="'.$reqemail.'" required></td></tr> 
				
	 	  	<tr><td class="table-form-label">Password: </td>
			<td><input type="password" name="password" id="password" title="Password" class="" placeholder="Password" required></td></tr>
			
	    	<tr><td colspan="2">
	    	 <center><input type="submit" value="Submit" class="btn-prm"    /></center>
	    	</td></tr>
	    	 <!-- tr><td>
	    
	    	<input type="button" value="click"   onclick="return dothis();"  />
	    		</td></tr -->
	        </div>
	        	</table><input type="hidden" name="op" value="newemaillogin"/>
            </form>';
             $content .= '<div> <table style="width:100%" align="center">';
               //<tr> <td align="center" width="700" colspan="1" height="'.$halfheaderheight.'" style="padding-bottom:15px">
                             
               // </td> </tr>            
                // $content .= '  <tr> <td align="center" width="780" colspan="1" height="'.$headerheight.'" style="background-color: #CFE8FF; " >';
                  ///  $UseHREFreqs = '?join_op=startNewEmployer&join_ptype=fromlogintoexist';
                   //// $UseHREFreqs .='&contactEmail='.$requsername;
                    
                           
                   $content .= '<tr> <td align="center" width="740" colspan="3" height="'.$halfheaderheight.'" style="padding-bottom:15px">
                     <br>
                              
       <center><a href ="../index.htm">Return to BC2Match Join Now Page</a> 
       </center>
                             </td></tr>
                  </table> </div>';
            $content .= '  </div></div></div>';     

                 }                 
                 else
                 {
                 //2
		           	   //     $content .= " " . $_REQUEST['contactEmail'] . " - Not found will prompt to add person and company <br>";   
		     /////	$content .= D B Content(); '.D B Content('','Application Form').'
		     $content.= '<div class="main-body-content new-join"><table class="table-striped" align="center" width="780" border="0" bordercolor="red" cellspacing="1"><tr><td align="center" width="780">
		 <span style="text-align:center; font-size:18px;color:#99bbff;">
		 <br> <strong class="dark-heading">Welcome to BC2Match</strong> <br>
     <strong class="dark-heading"> JOIN NOW Add your Company and select your Seats</strong> <br></span>
		 </td></tr><tr><td>';
		   $custommessage= "message here";
		   
		   
		   //Find Gold radio button.
		   //<-- <input type="radio"   name="level" 	value="1"  ><span style="background-color:#f2f2f2;"> Silver</span>&nbsp; &nbsp;
		   
		   
			$content .= '<form method="post" id="addnewusernewcompForm" name="addnewusernewcompForm" action="'.$_SERVER['PHP_SELF'].'" onsubmit="validatenewusernewcompForm()">          
	        <div style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width: auto;padding-bottom:0;">
	    	<div style="float:right"></div>';
	    	
	    	if ($membernewcompany == 0)
	    	{
    		$content .='<div style="font-size: 18px; text-align: center;"><b>Enter the information requested below to add new e-mail (User Name) and new Company <b> </div>
	    	<br>
		    <table class="w-100" style="border:0px;" cellpadding="0" cellspacing="0">
		    	<tr><td class="table-form-label">* Company : </td>
				<td><input class="loginbox" type="text" name="company" value="" required /></td></tr> 
				
	 	  	<tr><td class="table-form-label">* First Name: </td>
			<td><input type="text" class="loginbox" name="contactFirstname" value="" title="First Name" required/></td></tr>
			
	    	<tr><td class="table-form-label">* Last Name: </td>
			<td><input type="text" class="loginbox" name="contactLastname" value="" title="Last Name" required/></td></tr>
			
	    	<tr><td class="table-form-label">* Phone Number: <br> <span style="font-size:14px;font-weight:500;">Phone number format is<br>(xxx-xxx-xxxx)</span></td>
			<td><input type="tel" class="loginbox" name="contactPhone" value="" min="0" pattern="^\d{3}-\d{3}-\d{4}$" onKeyPress="if(this.value.length == 12) return false;" required/></td></tr>  
			
	    	<tr><td class="table-form-label">* E-Mail: </td>
			<td><input type="email" class="loginbox" name="contactEmail" value="'.$_REQUEST['contactEmail'].'" required/></td></tr>';
			
		 	$content .= '<tr><td class="table-form-label">* Password: </td>
			<td><input type="text" class="loginbox" name="password" value="" title="Password" required/></td></tr>';

	        $content .= '<tr><td class="table-form-label">* Number of Seats: </td>
				<td >
		    	<input type="number" class="loginbox" style="text-align:center;" name="numberofseats" value="1" min="1" max="10"  title="Number of Seats" required/></td></tr>
	         	</table>
	         	<table class="w-100">
	         	<tr><td class="table-form-label"> Subscription Level: </td>
				<td>'; 
	    		 $content .= '<input type="radio" name="level" value="1"  checked  ><span style="background-color:#f8f8f8;"> Silver </span>';
	    		 $content .= '<input type="radio" name="level" value="2" checked="true"   ><span style="background-color:#FFD700;"> Gold </span>
	    		 </td></tr>
	    	 <tr><td colspan="2">
	    	 <center><input type="submit" value="Submit" class="btn-prm"    /></center>
	    	</td></tr>
	    	 <!-- tr><td>
	    
	    	<input type="button" value="click"   onclick="return dothis();"  />
	    		</td></tr -->
	        </div>
	        	</table>
	        		<input type="hidden" namename="user_type" value="0" />
	     	<input type="hidden" name="join_op" value="addnewusernewcompanypay" />
	    	<input type="hidden" name="actioncompany" value="5" /> 
	    	<input type="hidden" name="frompage" value="addnewusernewcompanypay" />
            </form>';
	    	}
	    	else //Find
	    	{
	    	  $content .='<div style="font-size: 18px; text-align: center;"><b>Enter the information requested below to add new e-mail (User Name) and new Company <b> </div>
	    	<br>
		    <table class="w-100" style="border:0px;" cellpadding="0" cellspacing="0">
		    	<tr><td class="table-form-label">* Company : </td>
				<td><input class="loginbox" type="text" name="company" value="" required /></td></tr> 
			
	    	<tr><td class="table-form-label">* E-Mail: </td>
			<td><input type="email" class="loginbox" name="contactEmail" value="'.$_REQUEST['contactEmail'].'" required readonly/></td></tr>';
			
	        $content .= '<tr><td class="table-form-label">* Number of Seats: </td>
				<td >
		    	<input type="number" class="loginbox" style="text-align:center;" name="numberofseats" value="1" min="1" max="10"  title="Number of Seats" required/></td></tr>
	         	</table>
	         	<table class="w-100">
	         	<tr><td class="table-form-label"> Subscription Level: </td>
				<td>'; 
	    		 $content .= '<input type="radio" name="level" value="1"  checked  ><span style="background-color:#f8f8f8;"> Silver </span>';
	    		 $content .= '<input type="radio" name="level" value="2" checked="true"   ><span style="background-color:#FFD700;"> Gold </span>
	    		 </td></tr>
	    	 <tr><td colspan="2">
	    	 <center><input type="submit" value="Submit" class="btn-prm"    /></center>
	    	</td></tr>
	    	 <!-- tr><td>
	    
	    	<input type="button" value="click"   onclick="return dothis();"  />
	    		</td></tr -->
	        </div>
	        	</table>
	        	<input type="hidden" namename="user_type" value="0" />
	     	<input type="hidden" name="join_op" value="memaddnewcompany" />
	    	<input type="hidden" name="actioncompany" value="5" /> 
	    	<input type="hidden" name="frompage" value="addnewusernewcompanypay" />
	    	<input type="hidden" name="usrCompanyID" value="'.$_REQUEST['userCompany'].'" />
            </form>';  
	    	}
 
            
             $content .= '<div> <table style="width:100%" align="center">';
               //<tr> <td align="center" width="700" colspan="1" height="'.$halfheaderheight.'" style="padding-bottom:15px">
                             
               // </td> </tr>            
                // $content .= '  <tr> <td align="center" width="780" colspan="1" height="'.$headerheight.'" style="background-color: #CFE8FF; " >';
                  ///  $UseHREFreqs = '?join_op=startNewEmployer&join_ptype=fromlogintoexist';
                   //// $UseHREFreqs .='&contactEmail='.$requsername;
                    
                           
                   $content .= '<tr> <td align="center" width="740" colspan="3" height="'.$halfheaderheight.'" style="padding-bottom:15px">
                     <br>
                              
       <center><a href ="../join-now/">Return to BC2Match Join Now Page </a>
       </center>
                             </td></tr>
                  </table> </div>';
            $content .= '  </div></div></div>';
            
                 }

             }//- 2
			  $content .= '  </div></div></div>'; 	        
               //// 
             //} //
             
		  } // -1
			 else
 	  	   { //1
                    $content .= " Query for dupe email failed";
    	   }  //-1
                  
	}   else
	{ // - 0
	        $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
               <table width="780" align="center">
               <tr> <td align="center" width="780" colspan="1" height="'.$halfheaderheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
                             
                </td> </tr>            
                   <tr> <td align="center" width="780" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                    Please enter an E-mail 
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>
                             
                  
                            </td><tr>
                  <tr> <td align="center" width="780" colspan="3" height="'.$halfheaderheight.'" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;"></td></tr>
                  </table> </div> ';
    }           
    $content .= '  </div></div></div></div>';
    break;
    
    
    
    case "samuserlogin":
              //2
		           	   //     $content .= " " . $_REQUEST['contactEmail'] . " - Not found will prompt to add person and company <br>";   
		     /////	$content .= D B Content(); '.D B Content('','Application Form').'
		     $content.= '<div class="main-body-content new-join"><table class="table-striped" align="center" width="780" border="0" bordercolor="red" cellspacing="1"><tr><td align="center" width="780">
		 <span style="text-align:center; font-size:18px;color:#99bbff;">
		 <br> <strong class="dark-heading">Welcome to BC2Match</strong> <br>
     <strong class="dark-heading"> JOIN NOW Add your Company and select your Seats</strong> <br></span>
		 </td></tr><tr><td>';
		   $custommessage= "message here";
		   
		   
		   //Find Gold radio button.
		   //<-- <input type="radio"   name="level" 	value="1"  ><span style="background-color:#f2f2f2;"> Silver</span>&nbsp; &nbsp;
		   
		   
			$content .= '<form method="post" id="addnewusernewcompForm" name="addnewusernewcompForm" action="'.$_SERVER['PHP_SELF'].'" onsubmit="validatenewusernewcompForm()">          
	        <div style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width: auto;padding-bottom:0;">
	    	<div style="float:right"></div>
    		<div style="font-size: 18px; text-align: center;"><b>Enter the information requested below to add new e-mail (User Name) and new Company <b> </div>
	    	<br>
		    <table class="w-100" style="border:0px;" cellpadding="0" cellspacing="0">
		    	<tr><td class="table-form-label">* Company : </td>
				<td><input class="loginbox" type="text" name="company" value="'.$_REQUEST['company_name'].'" required /></td></tr> 
				
	 	  	<tr><td class="table-form-label">* First Name: </td>
			<td><input type="text" class="loginbox" name="contactFirstname" value="'.$_REQUEST['usr_firstname'].'" title="First Name" required/></td></tr>
			
	    	<tr><td class="table-form-label">* Last Name: </td>
			<td><input type="text" class="loginbox" name="contactLastname" value="'.$_REQUEST['lastname'].'" title="Last Name" required/></td></tr>
			
	    	<tr><td class="table-form-label">* Phone Number: <br> <span style="font-size:14px;font-weight:500;">Phone number format is<br>(xxx-xxx-xxxx)</span></td>
			<td><input type="tel" class="loginbox" name="contactPhone" value="" min="0" pattern="^\d{3}-\d{3}-\d{4}$" onKeyPress="if(this.value.length == 12) return false;" required/></td></tr>  
			
	    	<tr><td class="table-form-label">* E-Mail: </td>
			<td><input type="email" class="loginbox" name="contactEmail" value="'.$_REQUEST['username'].'" required/></td></tr>
			
			<tr><td class="table-form-label">* Password: </td>
			<td><input type="text" class="loginbox" name="password" value="" title="Password" required/></td></tr>
			
	         	<tr><td class="table-form-label">* Number of Seats: </td>
				<td >
		    	<input type="number" class="loginbox" style="text-align:center;" name="numberofseats" value="1" min="1" max="10"  title="Number of Seats" required/></td></tr>
	         	</table>
	         	<table class="w-100">
	         	<tr><td class="table-form-label"> Subscription Level: </td>
				<td>'; 
	    		 $content .= '<input type="radio" name="level" value="1"  checked  ><span style="background-color:#f8f8f8;"> Silver </span>';
	    		 $content .= '<input type="radio" name="level" value="2" checked="true"   ><span style="background-color:#FFD700;"> Gold </span>
	    		 </td></tr>
	    	 <tr><td colspan="2">
	    	 <center><input type="submit" value="Submit" class="btn-prm"    /></center>
	    	</td></tr>
	    	 <!-- tr><td>
	    
	    	<input type="button" value="click"   onclick="return dothis();"  />
	    		</td></tr -->
	        </div>
	        	</table>
	        		<input type="hidden" namename="user_type" value="0" />
	     	<input type="hidden" name="join_op" value="confirmsamuser" />
	    	<input type="hidden" name="actioncompany" value="5" /> 
	    	<input type="hidden" name="frompage" value="confirmsamuser" />
	    	<input type="hidden"   name="company_id" value="'.$_REQUEST['company_id'].'"/> 
	        <input type="hidden"   name="assignedusr_id" value="'.$_REQUEST['assignedusr_id'].'"/>
	    	
	    	
            </form>';
             $content .= '<div> <table style="width:100%" align="center">';
               //<tr> <td align="center" width="700" colspan="1" height="'.$halfheaderheight.'" style="padding-bottom:15px">
                             
               // </td> </tr>            
                // $content .= '  <tr> <td align="center" width="780" colspan="1" height="'.$headerheight.'" style="background-color: #CFE8FF; " >';
                  ///  $UseHREFreqs = '?join_op=startNewEmployer&join_ptype=fromlogintoexist';
                   //// $UseHREFreqs .='&contactEmail='.$requsername;
                    
                           
                   $content .= '<tr> <td align="center" width="740" colspan="3" height="'.$halfheaderheight.'" style="padding-bottom:15px">
                     <br>
                              
       <center><a href ="../join-now/">Return to BC2Match Join Now Page</a> 
       </center>
                             </td></tr>
                  </table> </div>';
            $content .= '  </div></div></div>';
             //- 2
			  $content .= '  </div></div></div>'; 
    break;
    
    case "logintoexistco" :   	
         		$content .= '<!--<b>arrived at "logintoexistco" <br -->';
         		  $requsername = $_REQUEST['username'] ; //$_REQUEST['username'];
         $content .= '  <!--:at logintoexistco -requvars =' ; 
      if ($reqjoin_op_action == "actionhub")
       {
             $content .= ' <!-- if from actionhub , the following are already assigned -->';
                        /*$login_company_id = $_REQUEST['company_id'];
 	                     $login_numcos ,   $login_assignedusr_id   ,      $login_usr_firstname,
				          $login_lastname  ,      $login_usr_auth   ,	     $login_usr_type    ,        $login_company_id  .';*/
				          /* $login_company_id = $_REQUEST['company_id'];
	                  $login_assignedusr_id  = $_REQUEST['assignedusr_id'];
	                  $login_usr_firstname = $_REQUEST['usr_firstname'];
	                   $login_lastname      = $_REQUEST['lastname'] ;
	                   $login_username      = $_REQUEST['username'];
	                   $login_usr_auth      = $_REQUEST['usr_auth'] ;
				           $login_usr_type     = $_REQUEST['usr_type'];
				            $login_company_id   = $_REQUEST['company_id']; 
				            $login_company_name = $_REQUEST['emp_name'];
				            $login_level = $_REQUEST['level']; */
       } else
       {
     $content .= ' if from original joinnow login boxgot here with <br>
                 ptype=joincoexists   <br> 
                 ?join_op=logintoexistco <br>
                 &company_id= co_dashrow[companyid]: '. $_REQUEST['company_id']. ' ? '.$_REQUEST['companyid']. ' <br>
 			        &assignedusr_id=  co_dashrow[assignedusr_id : '. $_REQUEST['assignedusr_id']. '  <br>
 			       &usr_firstname=   co_dashrow[firstname]: '. $_REQUEST['usr_firstname']. ' <br>
 			       &lastname= co_dashrow: '. $_REQUEST['lastname']. ' <br>
 			       &usr_type=co_dashrow[usertype]: '. $_REQUEST['usr_type']. ' <br> 
 			       &usr_auth=co_dashrow[userauth]: '. $_REQUEST['usr_auth']. ' <br>
 			       &username= reqemail: '. $_REQUEST['username']. ' <br>
 			       &emp_name=co_dashrow[ companyname ]: '. $_REQUEST['emp_name']. '  <br>
 			       &numcos = numrows =  '. $_REQUEST['numcos']. '  <br>
 	         Now a login form with company is to be shown';
 	                         $login_username =  $_REQUEST['username'];
 	                         $login_company_id = $_REQUEST['company_id'];
 	                             $login_numcos = $_REQUEST['numcos'];
 	                    $login_assignedusr_id  = $_REQUEST['assignedusr_id'];
				          $login_usr_firstname = $_REQUEST['usr_firstname'];
				          $login_lastname      = $_REQUEST['lastname'] ;
				          $login_usr_auth      = $_REQUEST['usr_auth'] ;
				           $login_usr_type     = $_REQUEST['usr_type'];
				           $login_company_id   = $_REQUEST['company_id'];
       }
 		$content .=	 '<!--  ^^^^^^^^^^^^^^^^^^^^^^^^^^^ --> ';    
 	$headerheight ="80";		
 	 $strcompanyname = str_replace("AND", "&",$_REQUEST['emp_name'],  $cocount);
  	$content .= '<table align="center" width="700"> <tbody>
      	<tr> <td align="center" width="100%" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;"><strong>Login to Your Company</strong>'; 
       $content .= '<br/> Login to the company you selected: '. $_REQUEST['username'].' <br/> 
                    </td></tr> 
                    <tr><td style="background-color:#dddddd; height:80px;">
              <strong> Login in here: </strong>  <br> 	
              <form action="index.php" method="post" > 
		          <table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink" style="margin-top:40px;">Forgot your password? </a>
				</td><td>
				<label class="loginlabel"> Email:</label>
			<input class="loginbox" style="display:inline;width:180px;" type="text" maxlength="40" size="24"  value="'.$_REQUEST['username'].'" id="username" name="username" title="Email or User Name" />
				</td><td>&nbsp; </td> <td><label class="loginlabel" style="display:inline;"> Password:</label>
				 					<input class="loginbox" style="display:inline;" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				  </td><td>&nbsp; </td> <td> <label class="loginlabel" style="display:inline;">Company:</label>
				  <input class="loginbox" style="display:inline;width:180px;" type="text" maxlength="40" size="24"  value="'.$strcompanyname.'" id="companyname" name="companyname" title="Company" />
					
				</td><td>  		<input type="hidden" name="ptype" value="corelogintoexistco"/> 
				   <input type="hidden" name="op" value="newemaillogin"/>
				           <input type="hidden" name="companyid" value="'.$login_company_id .'"/>
				           <input type="hidden" name="company_id" value="'.$login_company_id .'"/>
				            <input type="hidden" name="numcos" value="'. $login_numcos. '"/> 
				             <input type="hidden" name="assignedusr_id" value="'.  $login_assignedusr_id. '"/> 
				             
				               <input type="hidden" name="usr_firstname" value="'.  $login_usr_firstname. '"/> 
				              <input type="hidden" name="usr_lastname" value="'.  $login_lastname . '"/> 
				              <input type="hidden" name="usr_auth" value="'.  $login_usr_auth . '"/> 
				              <input type="hidden" name="usr_type" value="'. $login_usr_type . '"/> 
				              <input type="hidden" name="usr_company" value="'.  $login_company_id. '"/> 
				            
				             
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		</form><br/>
		         
		   </td></tr> </tbody></table></td></tr></tbody></table> '; //</div>';
		        //$content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
               $content .= ' <br><table width="700" align="center">';
               //<tr> <td align="center" width="700" colspan="1" height="'.$halfheaderheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
                             
               // </td> </tr>            
                 $content .= '  <tr> <td align="center" width="700" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >';
                    $UseHREFreqs = '?join_op=startNewEmployer&join_ptype=fromlogintoexist';
                    $UseHREFreqs .='&contactEmail='.$requsername;
                    $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to JoinNow Action Page</a>
   
                            <br>   
                              OR
                             <br>
                              
                             <a href ="../join-now/">Return to BC2Match Join Now Home Page </a>
                             
                  
                            </td><tr>
                  <tr> <td align="center" width="700" colspan="3" height="'.$halfheaderheight.'" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;"></td></tr>
                  </table> '; //</div>';
		   /*  $_SESSION['usr_firstname'] = $_REQUEST['usr_firstname'];        //   $row['usr_firstname'];
		         $_SESSION['usr_lastname']  = $_REQUEST['usr_lastname'];         //$row['usr_lastname'];
		         $_SESSION['usr_prefix']    = $_REQUEST['usr_prefix'];           //$row['usr_prefix'];  
		         $_SESSION['usr_auth']      = $_REQUEST['usr_auth'];             //$row['usr_auth']; 
		         $_SESSION['usr_auth_orig'] = $_REQUEST['usr_auth'];             //$row['usr_auth'];      //echo $row['usr_company'].' - '.$row['usr_type'].'<br><br>';
		         $_SESSION['usr_company']   = $_REQUEST['company_id'];           //$row['usr_company'];
		         $_SESSION['usr_type']      = $_REQUEST['usr_type'];             // $row['usr_type'];
		       */
         		
          break;
    case "addanothercompany":
      	$content .= '<!-- br>Arrived at "addanothercompany" <br -->';
     $_SESSION['$comdash_exists']= 'yes';
       $content .= "<!--br>Here to add another company to the companies associated with " . $_REQUEST['username']. " implementation uderway"  ;//$_REQUEST['username']
       $content .= 'generic_actioncompany: ' .  $generic_actioncompany .', if 5 making subscription for company   
                   , username: '.$_REQUEST['username'] . '  company_id: '.$generic_company_id . ', generic_company_name: ' .          $generic_company_name . '-->';
                   
                   $generic_company_name5 = "";
                   if ($generic_actioncompany == 5)   $generic_company_name5 =  $generic_company_name;
         
       /* Need to login first $generic_company_id   = $_REQUEST['company_id']; 
				           $generic_company_name = $_REQUEST['company_name'];
				            $generic_level    */
   //    	$query = "SELECT * FROM usr usr  WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
  	$query = "SELECT usr.*,usemp.usremp_usr_assignedusr_id FROM usr usr left join usr_emp usemp on usr.usr_id = usemp.usremp_usr_assignedusr_id
  	WHERE usr.usr_email ='" . Clean($_REQUEST['username']) . "' ";
  	if ($generic_actioncompany <> 5)    $query .= "AND usr_password = '" . sha1($_REQUEST['password']) . "'";
	$content .= '<!-- br> addanother company query'.	$query . '<br  -->';
	
	// 8/22/19  lloyd  need left joins - user may not have any companies
		if ($result=mysqli_query($conn, $query))  //1
		{
			if  (mysqli_num_rows($result)>0)  //2
	      {		
             /* need $addco_username to put in place   of  $_REQUEST['contactEmail']
             $addco_firstname
                 $addco_lastname
                 .$addco_contactPhone.
              need to pass usr_id (assigneduser_id)   $_SESSION['addco_assignedusr_id']  -CHECK*/
            /* check for duplicate company name */
        
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
             $addco_username = $_REQUEST['username'];
             $addco_firstname =$row['usr_firstname'];
               $addco_lastname =$row['usr_lastname'];
             $addco_contactPhone =$row['usr_phone'];
             
             $thisuser_reqpassword = $_REQUEST['password'];
             if ($generic_actioncompany == 5) $thisuser_reqpassword = $row['usr_password'] ;
              $addco_assignedusr_id = $row['usremp_usr_assignedusr_id'];
            $content .= '	<div >
			<div class="main-body-content">
	    	<div> 
		    <p style="padding: 30px 60px;font-size: 24px;line-height: 1.5;color: #00007f;">  Enter or change the information below to ';
		    if ($generic_actioncompany == 5) { $content .= ' subscribe to Company '.$generic_company_name5. ' below.';
		     } else
		     {$content .= 'to add another Company for the <br> user e-mail: <b> '. $addco_username .'</b>';}
		      $content .= ' </p> </div>
			  <div style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width:70%;padding-bottom:0;">
	       	<div style="float:right"></div>
	    	<div style=" 	font-size: 18px;  text-align: center;"> 
		   <b> To add another Company, login using your e-mail & password</b>
 </div>
	    	<br>';   	
       		$content .= '<form method="post" enctype="multipart/form-data" id="addCompanyForm" name="addCompanyForm" action="'.$_SERVER['PHP_SELF'].'" onsubmit="return validateaddCompanyForm()" >          
	         <div style="background:#eaeff7;border-radius:4px;padding:20px;">
	    	<div style="float:right"></div>
	    	<table style="border:0px; width:100%;" cellpadding="0" cellspacing="0">
	    	<tr>
	    	<td style="text-align: left;width: 30%;font-size:18px;font-weight:bold;">* Company Name: </td>
	    	<td><input type="text" class="loginbox" name="company" value="'.$generic_company_name5.'"  /></td>
	    	</tr>
	    	<tr>
	    	<td style="text-align: left;width: 35%;font-size:18px;font-weight:bold;"> Primary Contact First Name: </td>
	    	<td><input type="text" class="loginbox" name="contactFirstname" value="'.$addco_firstname.'" title="First Name" /></td>
	    	</tr>
	    	<tr>
	    	<td style="text-align: left;width: 35%;font-size:18px;font-weight:bold;"> Primary Contact Last Name: </td>
	    	<td><input type="text" class="loginbox" name="contactLastname" value="'. $addco_lastname.'" title="Last Name" /></td>
	    	</tr>
	    	<tr>
	    	<td style="text-align: left;width: 35%;font-size:18px;font-weight:bold;"> Phone Number: </td>
	    	<td><input type="text" class="loginbox" name="contactPhone" value="'.$addco_contactPhone.'" /></td></tr> 
		    <!-- tr>
		    <td style="text-align: left;width: 35%;"> E-Mail: </td>
		    <td><input type="text" class="loginbox" name="contactEmail" value="'.$addco_username.'" / --></td>
		    <td></td>
		    <td> <input type="hidden" name="username" value="'.$addco_username.'" />
		    <input type="hidden" name="password" value="'.$thisuser_reqpassword.'" />
		    <input type="hidden" name="assignedusr_id" value="'.$addco_assignedusr_id.'" /> ';
		    if ($generic_actioncompany == 5) {$content .= '<input type="hidden" name="actioncompany"  value="subscribeCompany"/> 
		                                    <input type="hidden" name="join_op_action" value="actionhub" />
        <input type="hidden" name="company_id" value="'.$generic_company_id. '"/>
        <input type="hidden" name="join_op" value="subscribeCompany" />';}
	    	else {$content .= ' <input type="hidden" name="join_op" value="addnewCompany" />';}
        $content .= '';
		     $content .= '<input class="btn-prm" type="submit" value="Submit" />
	        </table>     </div>                                                                  <!--  \/ was 50 -->
	     	<!-- <div style="float:left;margin-top:5px;display:inline-block;text-align:top;margin-left:38px;">Comments / Remarks:</div>
		   <textarea name="comments" rows="7" cols="60"> </textarea><br/><br/> -->
		    
	        </div> 
             </form>';
             $header .= $topSocial.'
		<div class="userAccount">
			Hello '.$addco_firstname." ".$addco_lastname.'<br/>
			<a href="logout'.$usempempid.'.php" class="userLogout" title="Logout" >Logout</a>
		</div>';
		$nav1 .= ' ';
		$footerScript .= <<<__EOS
__EOS;
             break;
	        } else{  //2
	        // password incorrect?  or 
	        $reqemail=$_REQUEST['username'];
	       $content .= '	<div style="background:#CFE8FF;border-radius:10px;margin:20px;padding:20px;">
	    	<div style="float:right"></div>
	    	<div style=" 	font-size: 16px; font-family: arial; "> 
		    <br>  Password incorrect please try again for the e-mail  '. $_REQUEST['contactEmail'] . ' <br> </div>
	     	<br>
	    		<form  action="'.$_SERVER['PHP_SELF'].'" method="post"> 
		          <table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" style="width:180px;" value="'.$reqemail.'" id="username" name="username" title="Email(User Name)" />
				</td><td>&nbsp; </td> <td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td>  		<input type="hidden" name="join_op" value="addnothercompany"/> 	
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
	    	</form><br/> 
	    	</div>';
		 break;
	      }  //2
		}  //1
	  else{   //1
	      // password incorrect
	         $reqemail=$_REQUEST['username'];   /////$reqemail=$_REQUEST['contactEmail'];
	       $content .= '	<div style="background:#CFE8FF;border-radius:10px;margin:20px;padding:20px;">
	    	<div style="float:right"></div>
	    	<div style=" 	font-size: 16px; font-family: arial; "> 
		    <br>  Password incorrect please try again for the e-mail  '.  $_REQUEST['username'] . ' <br> </div>
	    	<br>
	    		<form action="'.$_SERVER['PHP_SELF'].'" method="post"> 
		          <table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" style="width:180px;" value="'.$reqemail.'" id="username" name="username" title="Email(User Name)" />
				</td><td>&nbsp; </td> <td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td>  		<input type="hidden" name="join_op" value="addnothercompany"/> 	
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		</form><br/> 
		</div>';
	    }  // 1
	 
 
   break;  	
      	
  case "addnewCompany":   case "subscribeCompany" :  
      
      
     // |-
      if  ($reqop == "subscribeCompany")
     	    { 
     	       
     	      $content .= '<!--arrived at subscribeCompany '.      'generic_actioncompany: ' .  $generic_actioncompany .', if 5 making subscription for company   
                   , username: '.$_REQUEST['username'] . '  company_id: '.$generic_company_id . ', generic_company_name: ' .       $generic_company_name . '-->';
                   $requsername =$_REQUEST['username'];
       $subscribe_company_id  = $generic_company_id;   
           $reqassignedusr_id = $_REQUEST['assignedusr_id'];
              $reqcompany = $_REQUEST['company'];
              $requsername = $_REQUEST['username'];
              $reqpassword  = $_REQUEST['password'];
              $_SESSION['$comdash_exists']= 'yes';
               $content .= '<!-- br>reqassignedusr_id: '.$reqassignedusr_id.', reqcompany: '. $reqcompany.',requsername: '.$requsername.', reqpassword: '.$reqpassword . ' --> ';
        
           
     	        $content .= '	<div style="background:#CFE8FF;border-radius:10px;margin:20px;padding:20px;">';
;				$content .= '<div style="margin:5px;padding:5px;">';
			      // $content .= '<br/>The company you entered: ' . in our database';.$reqcompany .
			    //***  ['new_contactEmail']return
			   // update the company to level 1 num seats = 1 oc =1
			      $updatesubscribeSQL= "UPDATE emp   SET emp_level = 1,emp_seats_occupied=1,emp_number_seats  = 1  where emp_id = '".$subscribe_company_id. "'";
			      $content .= ' <!-- \\   updatesubscribeSQL: '.  $updatesubscribeSQL . ' --> ';
	    $empupdate = QU( $updatesubscribeSQL) ;
	    
	    //echo "I am here 3<br>";      NOT SURE HOW TO HIT THIS CODE
	    $setregdate = "UPDATE usr_emp SET usremp_registration_date= NOW() WHERE usremp_usr_id = ".$reqassignedusr_id." and usremp_emp_id = ".$subscribe_company_id;
	    //echo $setregdate;
	    //$usrempupdate = QU($setregdate); 
	      
	       
			    $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
               <table width="600" align="center">
               <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
                            <!--'. $_REQUEST['username'].'--> The   company  , '. $generic_company_name.  ',
                            <br>  has been subscribed to in our database associated with your user name, '.$requsername.'
                            <br> Subscription Level is <span style="background-color:#f2f2f2;">Silver</span> 
                            <!-- // $upgradefgcolor = "#f2f2f2"; //"#f5f5f5"; $upgrade_show_level = "Silver"$upgrade_show_level = "Silver"; -->
                            <br> Number of Seats is 1
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                            <br>';
                    $UseHREFreqs = '?join_op=startNewEmployer&join_ptype=havesubscribedtoco';
                  ////  $UseHREFreqs .= '&password='.$reqpassword  ;
                  ////  $UseHREFreqs .= '&assignedusr_id='.$reqassignedusr_id;
                  ////  $UseHREFreqs .='&username='. $_REQUEST['.$requsername.'];contactEmail='.$requsername;
                    $UseHREFreqs .='&contactEmail='.$requsername;
                   //// $UseHREFreqs .= '&$_REQUEST['='. $dbmycompany.'';
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to JoinNow Action Page <br>
                  to change Subscription level and/or Number of seats or Subscribe</a>
   
                            <br>   
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>
                            </div>
                            </td><tr>
               
				         </div>'; 
      
     // _|
     	    }else
      
           {$content .= '<!-- br> Arrived at "addnewCompany" <br> should  check for duplicate company -->';
              
           $reqassignedusr_id = $_REQUEST['assignedusr_id'];
              $reqcompany = $_REQUEST['company'];
              $requsername = $_REQUEST['username'];
              $reqpassword  = $_REQUEST['password'];
              $_SESSION['$comdash_exists']= 'yes';
               $content .= '<!-- br>reqassignedusr_id: '.$reqassignedusr_id.', reqcompany: '. $reqcompany.',requsername: '.$requsername.', reqpassword: '.$reqpassword . ' --> ';
        
              /*****************B    --- check for duplicate company**************************************/
               $addanothcocheck4dupecompany =  " Select emp_name from emp WHERE emp_name like '"  .  $reqcompany . "' "  ;
			   $content .= '<!-- addanothcocheck4dupecompany: ' . $addanothcocheck4dupecompany  . ' --> ';
			    //	$query = "SELECT * FROM usr WHERE usr_email ='" . Clean($_REQUEST['us$reqCompanyername']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
	       	if ($addanothcoempresult=mysqli_query($conn, $addanothcocheck4dupecompany)) {
		    	if (mysqli_num_rows($addanothcoempresult)>0) {
				    $emprow = mysqli_fetch_array($addanothcoempresult, MYSQLI_ASSOC);
			        $dbmycompany =	$emprow['emp_name'];
			        	$content .= '	<div style="background:#CFE8FF;border-radius:10px;margin:20px;padding:20px;">';
;				$content .= '<div style="margin:5px;padding:5px;">';
			      // $content .= '<br/>The company you entered: ' . $dbmycompany . ' is a duplicate in our database';
			    //***  ['new_contactEmail']
			    
			    $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
               <table width="600" align="center">
               <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
                            <!--'. $_REQUEST['username'].'--> The new company name, '. $reqcompany.  ',
                            <br>  you submitted is already in our database 
                            <br>
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                    ';
                    $UseHREFreqs = '?join_op=addanothercompany&join_ptype=haveoldusrnewco';
                    $UseHREFreqs .= '&password='.$reqpassword  ;
                    $UseHREFreqs .= '&assignedusr_id='.$reqassignedusr_id;
                    $UseHREFreqs .='&username='.$_REQUEST['username'];
                   //// $UseHREFreqs .= '&$_REQUEST['='. $dbmycompany.'';
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to  enter a different company name </a>
   
                            <br>   
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>
                            </div>
                            </td><tr>
               
				         </div>';
				    break;
             /* need to fix if then logic */
		    	}}
             /***************************************************************/
			   //// add user etc
			// $content .= '<br> add company with: $empID = QI("INSERT INTO emp (emp_name,emp_phone,emp_email,emp_notes) 
			    ///	VALUES ('".$_REQUEST['company']."','".$_REQUEST['contactPhone']."','".$_REQUEST['contactEmail']."','".$_REQUEST['comments']."')")'; .
			/* $reqassignedusr_id = $_REQUEST['assignedusr_id'];
              $reqcompany = $_REQUEST['company'];
              $requsername = $_REQUEST['username'];$reqassignedusr_id
              $reqpassword  = $_REQUEST['password'];
              $_SESSION['$comdash_exists']= 'yes'; */
              $content.= "<!-- INSERT INTO emp (emp_name,emp_phone,emp_email,emp_notes,emp_level,emp_number_seats,emp_seats_occupied) 
				VALUES ('".$reqcompany ."','".$_REQUEST['contactPhone']."','".$requsername."','".$_REQUEST['comments']."',2,1,1)  --> ";
        
		   	$empID = QI("INSERT INTO emp (emp_name,emp_phone,emp_email,emp_notes,emp_level,emp_number_seats,emp_seats_occupied) 
				VALUES ('".$reqcompany ."','".$_REQUEST['contactPhone']."','','".$_REQUEST['comments']."',2,1,1)");
				
				
			
				$tracecompany = $_REQUEST['company'];
			    $content.= 	"<!--br> line 727 addnewcompany empID: " . 	$empID . "-->";
					$tusrID = $_REQUEST['assignedusr_id'];  //$reqassignedusr_id
				
				////QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_auth) VALUES ('".$tusrID."','".$empID."','*')");
				$content .= "<!--  BR> line 731 addnewcompany query for usr_emp: "
				. "INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_usr_assignedusr_id,usremp_auth )
					                 VALUES ('".$tusrID."','".$empID."','".$tusrID."','*') -->  ";
					                 
					//echo "I am here 4";  - NOT SURE HOW TO HIT THIS CODE
            
					$usremp_id = QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_usr_assignedusr_id,usremp_auth, usremp_registration_date )
					                 VALUES ('".$tusrID."','".$empID."','".$tusrID."','*', NOW())");      //usremp_usr_assignedusr_id
			   
			      $content.= 	"<!-- br> line 734 addnewcompany usremp_ID: " . 	$usremp_id . " --> ";
			      
			      $tmp_content = 'Thank you for registering a new company. We are excited to have you as a member of BC2Match!';;
			 	  $joinsubject = 'BC2Match Company Registration:, '.$_SESSION['addcompany_username']. ' & Company, '. $_REQUEST['company']. ', Added';
			      $joinheaders = 'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  mail($_SESSION['addcompany_username'],'BC2Match New Company Registration',$tmp_content,$joinheaders );
			      
			      
			      
			      
				   	//$tmp_content = 'For Username: '.$_REQUEST['contactEmail']. ' --Added Company: '.$_REQUEST['company'] ;
				    //$joinsubject = 'BC2Match Join Now - Company '.$_REQUEST['contactEmail']. ' Added';
				    //$joinheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  //  $requsername mail($_REQUEST['contactEmail'],'BC2Match Join ',$tmp_content,$joinheaders );
				    //mail($requsername,'BC2Match Join ',$tmp_content,$joinheaders );
				    
				    
				  $tmp_content = 'Thank you for registering a new company. We are excited to have you as a member of BC2Match!';;
			 	  $joinsubject = 'BC2Match Company Registration:, '.$_SESSION['addcompany_username']. ' & Company, '. $_REQUEST['company']. ', Added';
			      $joinheaders = 'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  mail($requsername,'BC2Match New Company Registration',$tmp_content,$joinheaders );
				    
				    
				    
				    
			  	    $tmptrace_content = 'Username: '.$_REQUEST['contactEmail']. 'Added Company: '.$_REQUEST['company'] ;
			  		$tmptrace_content .= " traces" .  $tracecompany . "for user: ". $requsername;
				    $jointracesubject = 'BC2Match Join';
				    $jointraceheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				    //mail('lloydpalmer@yahoo.com','BC2Match Join Trace',$tmptrace_content,$jointraceheaders );
//Larry

                //Insert into usr_app table
                $usr_app=QI("insert into usr_app (usrapp_usr_id,usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) values (".$tusrID.",".$empID.",'1','0','1','0')")  ; 
				
				//Populate the clearance table
			  //1/4/19lloyd - not for emp	
			  
			 $clearID = QI("insert into usr_clearance (usrclr_usr_id, usrclr_emp_id, usrclr_clr_id, usrclr_title) values (".$tusrID.",".$empID.", '4','None')");
			 
			  
				//Populate the union/non-union (edu) table
			//1/4/19lloyd	$unonuID = QI("insert into usr_edu (usredu_usr_id, usredu_edu_id) values (".$tusrID.", '1')");
			
				     $content .= '<div class="girl-bg">
					<div style="margin: 20px;font-size: 24px;color: #00007f;font-weight: bold;text-align: center;">Congratulations, you have just successfully added another Company.<br>
Click below to select a company for a session.</div>';	
				$content .= '<div style="margin: 30px 5%;font-size: 18px;line-height: 1.5;"><b>You entered: </b> <br/> <b>Company: </b>' . $_REQUEST['company'] . "<br> <b>First Name: </b> " . $_REQUEST['contactFirstname'];
				 $content .= "<br> <b>Last Name: </b> " . $_REQUEST['contactLastname'] . "<br> <b>Phone: </b> " . $_REQUEST['contactPhone'] . ", </br><b>E Mail: </b> " .$requsername ; //  $_REQUEST['contactEmail'] . " | " .$reqemail;
				   // $content .= "<br/>Comments: " . $_REQUEST['comments'];
				    $content .= '    </div>';
				    /*change to send proper ack */
				     		        	$content .= '	<div style="background:#fff;border-radius:10px;">';
;				$content .= '<div style="margin:5px;padding:5px;">';
			      // $content .= '<br/>The company you entered: ' . in our database';.$reqcompany .
			    //***  ['new_contactEmail']return
			    
			    $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
               <table width="600" align="center">
               <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #eaeff7;border-radius: 0;font-size: 18px;font-weight: bold;line-height: 1.4;padding: 10px;">
                            <!--'. $_REQUEST['username'].'--> The new company name, '. $reqcompany.  ',
                            <br>  has been added our database associated with your user name, <u>'.$requsername.'</u>
                            <br> Subscription Level is <span style="background-color:#f5f5f5;">Silver</span> 
                            <!-- // $upgradefgcolor = "#f2f2f2"; //"#f5f5f5"; $upgrade_show_level = "Silver"$upgrade_show_level = "Silver"; -->
                            <br> Number of Seats is 1
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;" >
            
                            ';
                    $UseHREFreqs = '?join_op=startNewEmployer&join_ptype=haveaddedusrnewco';
                  ////  $UseHREFreqs .= '&password='.$reqpassword  ;
                  ////  $UseHREFreqs .= '&assignedusr_id='.$reqassignedusr_id;
                  ////  $UseHREFreqs .='&username='. $_REQUEST['.$requsername.'];contactEmail='.$requsername;
                    $UseHREFreqs .='&contactEmail='.$requsername;
                   //// $UseHREFreqs .= '&$_REQUEST['='. $dbmycompany.'';
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to JoinNow Action Page <br>
                  to change Subscription level and/or Number of seats</a>
   
                            <br>   
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>
                            </div>
                            </td><tr>
               
				         </div></div>';
				    
				
           }		       
		break;   
		
	case "registersamuser" :
	    
	    /**
	    echo $_REQUEST['numberofseats']."<br>".
	    $_REQUEST['company']."<br>".
	    $_REQUEST['contactFirstname']."<br>".
	    $_REQUEST['contactLastname']."<br>".
	    $_REQUEST['contactPhone']."<br>".
	    $_REQUEST['contactEmail']."<br>".
	    $_REQUEST['password']."<br>".
	    $_REQUEST['numberofseats']."<br>".
	    $_REQUEST['company_id']."<br>".
	    $_REQUEST['assignedusr_id']."<br>";
	    **/
	    
	    
	    $tpass = $_REQUEST['password'];
	    
	    $emp_update = QI('UPDATE emp SET emp_name="'.$_REQUEST['company'].'", emp_phone="'.$_REQUEST['contactPhone'].'", emp_number_seats="'.$_REQUEST['numberofseats'].'", emp_seats_occupied="'.$_REQUEST['numseatsoccupied'].'" where emp_id="'.$_REQUEST['company_id'].'"');

        //echo "I am here 6<br>";
	    $setregdate = "UPDATE usr_emp SET usremp_registration_date = NOW() WHERE usremp_usr_id = ".$_REQUEST['assignedusr_id']." and usremp_emp_id = ".$_REQUEST['company_id'];
	    echo $setregdate;
	    $usrempupdate = QU($setregdate); 
	    
	    $usr_update = QI('UPDATE usr SET usr_firstname="'.$_REQUEST['contactFirstname'].'", usr_lastname="'.$_REQUEST['contactLastname'].'", usr_contact="'.$_REQUEST['contactPhone'].'", usr_password="'.sha1($_REQUEST['password']).'" where usr_id='.$_REQUEST['assignedusr_id']);

	    
	    
	    	$content .= '<!--br> 970 arrived at "addnewuserandcompany" <br> company is: <br>'.$_REQUEST['company']. '<br>  ';
	    	     	$content .='<!--br>|_|frompage: ' . $_REQUEST['frompage']  . ' req ptype:'.$_REQUEST['ptype'] .' -->'; // return to admin_usr with joinnowRC = "ok" if ok , "fail" if fail
  
                   
	    	 $_SESSION['$comdash_exists']= 'no';
	    

          $content .= '<div class="girl-bg">
				 <div style="margin: 20px;font-size: 24px;color: #00007f;font-weight: bold;text-align: center;"></div>
<div style="margin: 30px 5%;font-size: 20px;line-height: 1.5;">
				
				 </div>
				  <div align="center" > <br>';
				 $content .= ' <div align="center" style="text-align:center;display:block; border-radius: 10px 10px 10px 10px;width:500px;" id="addnewack">
				 <div style="background-color: #eaeff7;border-radius: 0;font-size: 15px;font-weight: bold;line-height: 1.4;padding: 10px;">Thank you for registering your company. <br>You will receive a welcome email shortly.<br>Click here to update your profile.</div>';	
				//$content .= '<div style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;">You entered: <br/> Company:' . $_REQUEST['company'] . "<br> First Name:" . $_REQUEST['contactFirstname'];
				$content .= '<div style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;">';
				
           //$content .= "<br><br> or Click";		
		  $content .= "<br><a href=./bc2companydashboard.php?op=newemaillogin&username=".$_SESSION['addcompany_username']."&usr_password=".$tpass."&password=".$tpass.">Go to Member Profile </a>";
		
				    $content .= '   </div> </div></div></div>';
	    
	    
	    
	    
	    
	
	break;
	
	case "addnewuserandcompany"	: case "memnewcompany" :
	    
	    
	    	$content .= '<!--br> 970 arrived at "addnewuserandcompany" <br> company is: <br>'.$_REQUEST['company']. '<br>  ';
	    	     	$content .='<!--br>|_|frompage: ' . $_REQUEST['frompage']  . ' req ptype:'.$_REQUEST['ptype'] .' -->'; // return to admin_usr with joinnowRC = "ok" if ok , "fail" if fail
  //emp.emp_number_seats,emp.emp_seats_occupied$_REQUEST['level'] $_REQUEST['user_type']$_REQUEST['numberofseats']
                   
	    	 $_SESSION['$comdash_exists']= 'no';
	    	 $tpass = $_REQUEST['password'];
	    	 
	    if ($_REQUEST['join_op'] == "addnewuserandcompany")
	    {
	 	$empID = QI("INSERT INTO emp (emp_name,emp_phone,emp_email,emp_number_seats,emp_level,emp_seats_occupied) 
	VALUES ('".$_REQUEST['company']."','".$_REQUEST['contactPhone']."','".$_REQUEST['contactEmail']."','".$_REQUEST['numberofseats']."','".$_REQUEST['level']."','1')");
				$tracecompany = $_REQUEST['company'];
				
			$content .= "<!--br>980 trace insert is: " ."INSERT INTO emp (emp_name,emp_phone,emp_email,emp_number_seats,emp_level,emp_number_seats,emp_seats_occupied) 
	VALUES ('".$_REQUEST['company']."','".$_REQUEST['contactPhone']."','".$_REQUEST['contactEmail']."','".$_REQUEST['numberofseats']."','".$_REQUEST['level']."','1') -->";
					//$tpass = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,9); 
					$newPass = sha1($tpass);
	     $content .= "<!-- br>trace 1023 try insert new usr query: <br> 
	  INSERT INTO usr (usr_email, usr_firstname, usr_lastname, usr_phone, usr_active, usr_join
	  , usr_password, usr_auth, usr_created,usr_company,usr_type,usr_welcome_flag) 
   VALUES('".Clean($_SESSION['addcompany_username'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','".Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."'
				   ,'".$newPass."','2','".date("Y-m-d H:i:s")."','".$empID."','0','0')  --> ";	
	
   $tusrID = QI("INSERT INTO usr (usr_email, usr_firstname, usr_lastname, usr_phone, usr_active, usr_join, usr_password, usr_auth, usr_created,usr_company,usr_type,usr_welcome_flag) 
				   VALUES('".Clean($_SESSION['addcompany_username'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','".Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."','".$newPass."','2','".date("Y-m-d H:i:s")."','".$empID."','0','0')");
				 //$_REQUEST['contactFirstname']
				 if (!($tusrID))
				 {
				     $content .= "<!-- br>trace 989 insert failed insert query: <br "
				     ."INSERT INTO usr (usr_email, usr_firstname, usr_lastname, usr_phone, usr_active, usr_join, usr_password, usr_auth, usr_created,usr_company,usr_type,usr_welcome_flag) 
				   VALUES('".Clean($_SESSION['addcompany_username'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','".Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."'

				   ,'".$newPass."','2','".date("Y-m-d H:i:s")."','".$empID."','0','0')  --> ";
				   
					  ////VALUES('".Clean($_REQUEST['contactEmail'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','".Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."'
	
				 }
				 
				////  $_SESSION['addcompany_username']
				////QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_auth) VALUES ('".$tusrID."','".$empID."','*')");
				
				    //echo "I am here 1";
		
					QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_usr_assignedusr_id,usremp_auth, usremp_registration_date )
					                 VALUES ('".$tusrID."','".$empID."','".$tusrID."','*', NOW())");  //usremp_usr_assignedusr_id
			   
			  
			 	 $tmp_content = 'Username: '.$_SESSION['addcompany_username'].'\n\r\nPassword: '.$tpass . ' --- env: ' .$_SESSION['env'];
			 	 //	 $tmp_content = 'Username: '.$_REQUEST['contactEmail'].'\n\r\nPassword: '.$tpass;
			 
			 	  $joinsubject = 'BC2Match Join Now - User, '.$_SESSION['addcompany_username']. ' & Company, '. $_REQUEST['company']. ', Added';
			      $joinheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  //mail($_SESSION['addcompany_username'],'BC2Match Join ',$tmp_content,$joinheaders );
				  
				  //$tmp_content = 'Thank you for registering a new company. We are excited to have you as a member of BC2Match!';;
				  
				   $tmp_content = 'Thank you for registering! We are excited to have you as a new member of BC2Match! As an Early Adopter, you have earned a number of benefits, including 90 days no-charge of prioritized relevant federal opportunities, up to 4 additional free seats, searching for team members and other federal contractors, and immediate responses to changes in your profile.
				  
Here are some tips for effective use of BC2Match:

1. The first thing you should do is click on Manage Profile – You’ll see whether you have industry NAICS codes already listed, as well as Certs for your small business status. You MUST have one or more NAICS codes in your profile to match on opportunities, along with entries in your Union/Nonunion status and Clearances criteria. The others are optional, but the more complete your profile, the more relevant will be the opportunities you’ll see, and the better you will match with other contractors seeking teaming partners. Let us know if you would like help on specifying your profile.

2. Once your profile is up-to-date, click Return to Dashboard to see all the federal opportunities in your sweet spot (State and Local to be added shortly).

3. Want to add others to the platform to use your four additional free seats? Go to Manage Account and look for the Add User button. Click on it and you can enter others in your company, who can establish and manage their own Profiles to support your company’s business development efforts.

4. Trying to find a contact at another company, or the contact info for someone you met at a networking event? Use Search Members.

5. Building a team for your next bid? Use our Post a Job function – enter your criteria, click Submit and see who pops up, based on your Search specifications. How easy is that?

We do a weekly demo and Q&A on Zoom on Thursdays at noon. No need to register, just show up. We’ll send the link, or contact us for the specifics or a personalized demo with tips and tricks. We want to help you get the most out of BC2Match from the git-go!';
	
			 	  $joinsubject = 'BC2Match Company Registration:, '.$_SESSION['addcompany_username']. ' & Company, '. $_REQUEST['company']. ', Added';
			      $joinheaders = 'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  mail($_SESSION['addcompany_username'],'BC2Match New Company Registration',$tmp_content,$joinheaders );
				  
				  
				  
				  
			      	$tmptrace_content = 'Username: '.$_SESSION['addcompany_username'].'|'.$_REQUEST['contactEmail'].' \n\r\nPassword: '.$tpass;
			  		$tmptrace_content .= ' -- company: ' .  $tracecompany . ' --- env: ' .$_SESSION['env'];
			    	$jointracesubject = 'BC2Match Join';
			    	$jointraceheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
			    	mail('lloydpalmer@yahoo.com','BC2Match Join Trace',$tmptrace_content,$jointraceheaders );
			     				
				//Populate the clearance table
				$clearID = QI("insert into usr_clearance (usrclr_usr_id,usrclr_emp_id, usrclr_clr_id, usrclr_title) values (".$tusrID.",".$empID.", '4','None')");
			  
				//Populate the union/non-union (edu) table
				$unonuID = QI("insert into usr_edu (usredu_usr_id,usredu_emp_id, usredu_edu_id) values (".$tusrID.",".$empID.", '1')");
		
				// 1/4/19 populate the usr_app table so profile matching will work
				// cron job$query = "insert into usr_app (usrapp_usr_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) select usr_id,'1','0','1','0' from usr where fed_id > 0 and fbo_file_processed = 0";
        $usr_app=QI("insert into usr_app (usrapp_usr_id,usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) values (".$tusrID.",".$empID.",'1','0','1','0')")  ;      
          $content .= "<!-- br>trace 1051 new usr_app id ". $usr_app ." 
          with query: insert into usr_app (usrapp_usr_id,usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) values (".$tusrID.",".$empID.",'1','0','1','0') -->";
          
                  $content .= '<div class="girl-bg">
				 <div style="margin: 20px;font-size: 24px;color: #00007f;font-weight: bold;text-align: center;"></div>
<div style="margin: 30px 5%;font-size: 20px;line-height: 1.5;">
				
				 </div>
				  <div align="center" > <br>';
				 $content .= ' <div align="center" style="text-align:center;display:block; border-radius: 10px 10px 10px 10px;width:500px;" id="addnewack">
				 <div style="background-color: #eaeff7;border-radius: 0;font-size: 15px;font-weight: bold;line-height: 1.4;padding: 10px;">Thank you for registering your company. <br>You will receive a welcome email shortly.<br>Click here to update your profile.</div>';	
				//$content .= '<div style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;">You entered: <br/> Company:' . $_REQUEST['company'] . "<br> First Name:" . $_REQUEST['contactFirstname'];
				$content .= '<div style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;">';
				
           //$content .= "<br><br> or Click";		
		  $content .= "<br><a href=./bc2companydashboard.php?op=newemaillogin&username=".$_SESSION['addcompany_username']."&usr_password=".$tpass."&password=".$tpass.">Go to Member Profile </a>";
		
				    $content .= '   </div> </div></div></div>';
	    }
	    else
	    {
	        
	            $contactPhone = QV("select usr_phone from usr where usr_email ='".$_REQUEST['contactEmail']."'");
	            
	      	 	$empID = QI("INSERT INTO emp (emp_name,emp_phone,emp_email,emp_number_seats,emp_level,emp_seats_occupied) 
	VALUES ('".$_REQUEST['company']."','".$contactPhone."','".$_REQUEST['contactEmail']."','".$_REQUEST['numberofseats']."','".$_REQUEST['level']."','1')");
				$tracecompany = $_REQUEST['company'];
				

            $tusrID = QV("select usr_id from usr where usr_email ='".$_REQUEST['contactEmail']."'");
            
                     //echo "I am here 5";

					QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_usr_assignedusr_id,usremp_auth, usremp_registration_date  )
					                 VALUES ('".$tusrID."','".$empID."','".$tusrID."','*', NOW())");  //usremp_usr_assignedusr_id
			   
			  
			 	  $tmp_content = 'Thank you for registering a new company. We are excited to have you as a member of BC2Match!';;
			 	  $joinsubject = 'BC2Match Company Registration:, '.$_SESSION['addcompany_username']. ' & Company, '. $_REQUEST['company']. ', Added';
			      $joinheaders = 'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  mail($_SESSION['addcompany_username'],'BC2Match New Company Registration',$tmp_content,$joinheaders );
				  
			      	//$tmptrace_content = 'Thank you for registering a new company. We are excited to have you as a member of BC2Match!';
			    	//$jointracesubject = $joinsubject;
			    	//$jointraceheaders = 'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
			    	//mail('lloydpalmer@yahoo.com','BC2Match Join Trace',$tmptrace_content,$jointraceheaders );
			     				
				//Populate the clearance table
				$clearID = QI("insert into usr_clearance (usrclr_usr_id,usrclr_emp_id, usrclr_clr_id, usrclr_title) values (".$tusrID.",".$empID.", '4','None')");
			  
				//Populate the union/non-union (edu) table
				$unonuID = QI("insert into usr_edu (usredu_usr_id,usredu_emp_id, usredu_edu_id) values (".$tusrID.",".$empID.", '1')");
		
				// 1/4/19 populate the usr_app table so profile matching will work
				// cron job$query = "insert into usr_app (usrapp_usr_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) select usr_id,'1','0','1','0' from usr where fed_id > 0 and fbo_file_processed = 0";
        $usr_app=QI("insert into usr_app (usrapp_usr_id,usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) values (".$tusrID.",".$empID.",'1','0','1','0')")  ;      
          $content .= "<!-- br>trace 1051 new usr_app id ". $usr_app ." 
          with query: insert into usr_app (usrapp_usr_id,usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) values (".$tusrID.",".$empID.",'1','0','1','0') -->";
          
                  $content .= '<div class="girl-bg">
				 <div style="margin: 20px;font-size: 24px;color: #00007f;font-weight: bold;text-align: center;"></div>
<div style="margin: 30px 5%;font-size: 20px;line-height: 1.5;">
				
				 </div>
				  <div align="center" > <br>';
				 $content .= ' <div align="center" style="text-align:center;display:block; border-radius: 10px 10px 10px 10px;width:500px;" id="addnewack">
				 <div style="background-color: #eaeff7;border-radius: 0;font-size: 14px;font-weight: bold;line-height: 1.4;padding: 10px;">Thank you for registering a new company.<br>You will receive a welcome email shortly.<br>Click below to return to you current company Manage Account page.</div>';	
				//$content .= '<div style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;">You entered: <br/> Company:' . $_REQUEST['company'] . "<br> First Name:" . $_REQUEST['contactFirstname'];
				$content .= '<div style="background-color: #d2deef;padding: 10px;line-height: 1.5;font-size: 18px;">';
				
           //$content .= "<br><br> or Click";		
		  //$content .= "<br><a href=./bc2members.php?usr=".$tusrID."&company_id=".$_REQUEST['usrCompanyID'].">Manage Account</a>";
		  $content .= "<br><a href=./admin_usr.php?usr=".$tusrID."&ptype=admin&userCompany=".$_REQUEST['usrCompanyID'].">Manage Account</a>";
		  //https://bc2match.com/bc2demo/db/admin_usr.php?usr=951158&ptype=admin&userCompany=927165
		
				    $content .= '   </div> </div></div></div>';  
	    }
	    	 
	    	 
	    break;
 
    case  "addnewuserexistcompany" :
        	$content .= '<!--br>Arrived at "addnewuserexistcompany  - implementation under way "    at '. date('Y-m-d H:i:s') . '-->';// date("Y/m/d") ;
        	   $generic_company_id = $_REQUEST['addseat_company_id'] OR  $generic_company_id= $_REQUEST['upgradelevel_company_id'] OR  $generic_company_id= $_REQUEST['addnewuser_company_id'] ;
        	    $generic_company_idseat = $_REQUEST['addseat_company_id'];
        	    $generic_company_iduser = $_REQUEST['addnewuser_company_id'];
        	    $generic_company_idlevel= $_REQUEST['upgradelevel_company_id'] ;
        	    $content .= "<!--br> generic_company_idseat = ".  $generic_company_idseat;
        	     $content .= "<br>generic_company_iduser = ".  $generic_company_iduser;
        	     $content .= "<br>generic_company_idlevel= ". $generic_company_idlevel ;
        	 	$content .= '<br> LINE 1117 trace at addneweuserexistcom generic_company_id :' . $generic_company_id .' -->' ;
        	$content .= '<!--br>The following have been set:  
	                    '. $addnewuser_company_id .  ' =  company_id ; '.$addnewuser_assignedusr_id . ' = assignedusr_id ;'. $addnewuser_usr_firstname.' = usr_firstname ;
	                      '.$addnewuser_lastname.    ' =  lastname;	                    '.$addnewuser_username.      ' = username;
	                   '.$addnewuser_usr_auth .      ' = usr_auth;				         '. $addnewuser_usr_type .   ' = usr_type;
				          '. $addnewuser_company_id. ' = company_id; 				        '. $addnewuser_company_name. ' = company_name (not emp_name);
				           '. $addnewuser_level .    ' = level;				           '.  $addnewuser_numseats .' = numseats;
				           '.$addnewuser_NEW_username. ' = new user to add;
				     '. $addnewuser_numseatsoccupied.' = numseatsoccupied.-->';
	      /* Need to login first before get list of companies to select one for adding a seat*/
	         $_SESSION['adminnnuserID']  = $addnewuser_assignedusr_id ; // yes';
	          $_SESSION['adminnuserCompany']= $addnewuser_company_id;
      	$content .='<!-- br>|_|frompage: ' . $_REQUEST['frompage'] ." | " .$frompage . ', req ptype:'.$_REQUEST['ptype'] ; // return to admin_usr with joinnowRC = "ok" if ok , "fail" if fail
        $content .= ',  SERVER[HTTP_REFERER]: >|' . $_SERVER["HTTP_REFERER"] . '|<< -->';
       $content .= '<!--br>SESSION[holdfrompage] ' . $_SESSION['holdfrompage'];
      $content .= "<br>Here to add another user to one of the companies associated with " . $_REQUEST['username']. " - req usr_type: " .$_REQUEST['usr_type'] 
      . ", sess usr_type: ".  $_SESSION['usr_type'] . "  implementation underway -->"  ;
          $frompage = $_REQUEST['frompage'];
          $usethisfrompage = $frompage;
        if ($_REQUEST['frompage'] == "manageaccount")
            {
                $_SESSION['holdfrompage'] = "manageaccount";
                 $usethisfrompage = $_REQUEST['frompage'];
       				
			//  $upgradelevel_company_id   $upgradelevel_assignedusr_id  $upgradelevel_username
//	 $upgradelevellocationhref=$locationhref.'"joinnow.php?join_op=upgradelevelexistcompany&frompage=manageaccount&upgradelevel_company_id='.$userCompany.'&upgradelevel_assignedusr_id='.$ut['usr_id'].'&upgradelevel_username='.$ut['usr_email'] .'"'  ;
//adduserlocationhref=$locationhref.'"joinnow.php?join_op=addnewuserexistcompany&frompage=manageaccount&ptype='.$thisptype.'&addnewuser_company_id='.$userCompany.'&addnewuser_assignedusr_id='.$ut['usr_id'].'&addnewuser_username='.$ut['usr_email'] .'"'  ;
	 //
//	 $addseatlocationhref=$locationhref.'"joinnow.php?join_op=addseatexistcompany&frompage=manageaccount&addseat_company_id='.$userCompany.'&addseat_assignedusr_id='.$ut['usr_id'].'&addseat_username='.$ut['usr_email'] .'"'  ;
 $generic_company_id = @$_REQUEST['addseat_company_id'] or $generic_company_id = @$_REQUEST['upgradelevel_company_id'] or $generic_company_id = @$_REQUEST['addnewuser_company_id'];
  $generic_join_op = @$_REQUEST['join_opfrompage ='] ;
  $generic_frompage =   @$_REQUEST['frompage'] ;
   $generic_ptype  =    @$_REQUEST['ptype'];
 
 $generic__assignedusr_id = @$_REQUEST['addseat_assignedusr_id'] or $generic__assignedusr_id =  @$_REQUEST['upgradelevel_assignedusr_id'] or $generic__assignedusr_id = @$_REQUEST['addnewuser_assignedusr_id'];
 
 $generic_username = @$_REQUEST['addseat_addnewuser_username'] or $generic_username =  @$_REQUEST['upgradelevel_addnewuser_username'] or $generic_username = @$_REQUEST['addnewuser_username'];
 
  
      $content .= "<!-- br> at addseatexistco frompage: " . $_REQUEST['frompage'] . " maybe from addmin_usr if from manageaount -->";
      
      
  }         
            
       
            // this should stay ==manageaccount if from admin_usr
         
           $content .= "<!---br>  request[frompage]: ". $_REQUEST['frompage'] . ", usethisfrompage: " .  $usethisfrompage .", SESSION['holdfrompage']: " . $_SESSION['holdfrompage']."-->";
         // return to admin_usr with joinnowRC = "ok" if ok , "fail" if fail
         /*Flow      */
         /*If from manageaccount(admin_usr frompage: manageaccount */
        switch ($usethisfrompage) 
           {   case "addnewusrtocompany":
               $content .= '<!-- br> at addnewuserexistcompany -  REQUEST[join_ptype]: '.$_REQUEST['join_ptype']. ' = ?= havenewuserinfo , user_type: '.$_REQUEST['user_type'] ;
	       	$content .= '<!-- br> Here to add new user: '.$addnewuser_username.' to selected/current company --> '; 
	         	$content .= '<!-- Your candidate new username: '.$addnewuser_NEW_username. '=' . $_REQUEST['new_contactEmail']
	       	         .' to the database for  company: '. $_REQUEST['join_emp_name'].' with id:'.$_REQUEST['join_emp_id'].'-->'; 
	        $content .= '<!--br> checking if the user is   already in the selected company: '. $addnewuser_company_name.'='.$_REQUEST['join_emp_name'] .'   in the db  
	                        <br>if so, err message with link back to - if from join now startnewcompany or join now action page; if from manageaccount link back to manage account
	                        <br> if not, see if the new user e-mail is in any company - to get his or her password, otherwise would not care
	                        <br>        , then using the password and user_id obtained  or having a new usr_id and password assigned    add the user to the company   -->  ';
	      	$query = "SELECT usr.*,usemp.usremp_usr_assignedusr_id,usemp.usremp_emp_id
	      	         FROM usr usr     inner join usr_emp usemp on usr.usr_id = usemp.usremp_usr_assignedusr_id 
	   	           WHERE usr_email ='" .$addnewuser_NEW_username. "' and usemp.usremp_emp_id = ". $addnewuser_company_id . " " ;
	       $content .= '<!-- <br> addnewuserexistco check if new user already there in this company query: '.	$query . ' for user at: '.$usethisfrompage.' -->';
	  	if ($result=mysqli_query($conn, $query))  //1
		 {
		  if  (mysqli_num_rows($result)>0)  //2
	      {		
             $content .= '<!-- <br>   newuserinfo line 1021 newuser already in the company; put error mesage and way back to the previous screen -->';
               
          if ($_SESSION['holdfrompage'] ==    "manageaccount")     
           {        
               $userID = $_SESSION['adminnnuserID']; //                   $addnewuser_assignedusr_id
               $userCompany= $_SESSION['adminnuserCompany'];
                unset($_SESSION['adminnnuserID'] );// = '';
                         unset($_SESSION['adminnuserCompany']) ; // = '';
                           // header("Refresh:1; url=/".$_SESSION['env']."/admin_usr.php?usr=".$userID."&empid=".$userCompany."&ptype=admin&numseats=".$addoneto_emp_seats_occupied."&fromjoinnowRC=fail-userthere");
	                     //$addnewuser_numseatsoccupied
	                   $content     .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                  <table width="600" align="center">
                  <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">';
                  $content     .='The new user name, <br>
                            '. $_REQUEST['new_contactEmail'].',
                            <br>  is already in selected company -' .$addnewuser_company_name.' 
                            <!-- br>  The number of seats occupied is now '.$addnewuser_numseatsoccupied  . ' -->';
                 $content .= '<br><a href="admin_usr.php?usr='.$userID.'&empid='.$userCompany.'&ptype=admin&fromjoinnowRC=fail-userthere">Manage Account </a> 
	               </td></tr>
         <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">
         </td></tr></table></div>';
              
   /*<tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
        
                            The new user name, <br>
                            '. $_REQUEST['new_contactEmail'].',
                            <br>  is already in selected company -' .$addnewuser_company_name.' 
                            <br>  The number of seats occupied is now '.$addoneto_emp_seats_occupied . '
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                            <br>';*/
             $theselectedcompany = $addnewuser_company_name;
             }else
	         {
              $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                 <table width="600" align="center">
                 <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
        
  
                            The new user name, <br>
                            '. $_REQUEST['new_contactEmail'].',
                            <br>  you submitted is already in the selected company -<br>'. $_REQUEST['join_emp_name'].'
                            <br>
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                            <br>';
                    $UseHREFreqs = '?join_op=addnewuserexistcompany&join_ptype=havecofornewusr&actioncompany=2&join_op_action=actionhub&frompage=joinpage_loggedin';
                    $UseHREFreqs .= '&company_id='.$addnewuser_company_id  .'' ;
                    $UseHREFreqs .= '&company_name='.$addnewuser_company_name.'&username='. $addnewuser_username;
                    $UseHREFreqs .= '&attemptnewthere='. $_REQUEST['new_contactEmail'].'';
                     
                     
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to  enter a different name </a>
   
                            <br>
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>';
                    
                     $content .= '  </div>
                            </td><tr>
               <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">
               </td></tr></table></div>';
	             
                   break;
	           }
	  	     }else
	  	    {
		        $content .= ' <!--trace <br>  new user  not in the selected company  so now see if the new user e-mail in any other company
		                    if so, use that use password, if not assign a whole new shebang to the company selected --> ';
		          /* See if entered new user name is in any other company,  
		            If not, add new user to the selected (by current user)company.
		            Then display the result added new user .  REQUEST['new_contactEmail']. to  existing REQUEST['join_emp_name']
		           
		            if so, assign that new user  to the selected company REQUEST['join_emp_name'] and queryresult['password'], current password 
		                of the "new user"- from the other   company
		             
		            Then, display the result added new use .  REQUEST['new_contactEmail']. to  existing REQUEST['join_emp_name']
		         
		         */
		        // select
		        $reqemail = $_REQUEST['username'] ;   //  $_REQUEST['username']$_REQUEST['contactEmail'];
			    $content .= '<!-- br> Obtaining the company list associated Your E-Mail: ' .  $reqemail . '-->' ; // use usremp_usr_assignedusr_id` usremp_usr_assignedusr_id and join
			    $look4anothercompany =  "  SELECT usr.usr_id,usr.usr_password as password ";
                $look4anothercompany .= "  ,emp.emp_id as companyid, emp.emp_name as companyname ";
               $look4anothercompany  .= "  ,usemp.usremp_id,usemp.usremp_usr_id as companyuserid,usemp.usremp_emp_id,usemp.usremp_auth,usemp.usremp_type ";
              ///bad $look4anothercompany  .= "  FROM usr usr inner join emp emp on emp.emp_id = usr.usr_company inner join usr_emp usemp on usemp.usremp_usr_id = usr.usr_id ";
              $look4anothercompany .= " FROM usr usr  inner join usr_emp usemp on usemp.usremp_usr_assignedusr_id = usr.usr_id  inner join emp emp on emp.emp_id = usemp.usremp_emp_id ";
 
               $look4anothercompany  .= "  WHERE   usr.usr_email like '".$_REQUEST['new_contactEmail'] . "'  order by emp.emp_name,usr.usr_email,usr.usr_lastname,usr.usr_firstname ";
       	       // changed last inner join from  inner join usr_emp usemp on usemp.usremp_emp_id = emp.emp_id 
       	         $tracecompany = '';       	           ////	numseats numseatsoccupied
         	  $content .= '<!-- br>line 1091 at addnewuserexistcompany -  REQUEST[join_ptype]: '.$_REQUEST['join_ptype']. ' = ?= havenewuserinfo checking for different company';  
       	      $content.= '<br> anothercompany check< ! --br>  look4anothercompany : ' . $look4anothercompany. '<br> ....  -->';
       	      $newuserpassword = 'not found';
	    	/************************************************************/
	    	/*****NO**see if already in another company******/
	     
	       if ($anothercompanyresult=mysqli_query($conn, $look4anothercompany))
		    { // 3
		   	if (mysqli_num_rows($anothercompanyresult)>0) 	
		       {  
		         $anotherco_dashrow = mysqli_fetch_array($anothercompanyresult, MYSQLI_ASSOC);
		         $newuserid = $anotherco_dashrow['usr_id'];
		         $newuserpassword = $anotherco_dashrow['password']; 
		         $anothercompany  = $anotherco_dashrow['companyname']; 
		         
		            $content.= '<!-- br> '. $_REQUEST['new_contactEmail'] . '   found in another company with password: ' . $newuserpassword .' one company is '.$anothercompany .' --> ' ;
		          /* the new user is in another company, 
		             so, assign that new user  to the selected company REQUEST['join_emp_name'] and queryresult['password'], current password 
		                of the "new user"- from the other   company 
		            Then, display the result" [ added new use .  REQUEST['new_contactEmail']. to  existing REQUEST['join_emp_name'] with current new user password
		         */
		       } else
		        {  
		            $content.= '<!-- r> '. $_REQUEST['new_contactEmail'] . ' not found in another company -->';
		            $newuserpassword = 'not found';
		        /* new user is not in another company*/
		        }
		    }
		       $content.= '<!--br> Now add the new user '.$_REQUEST['new_contactEmail'] . ' -->';
		       $newnew_user='no'; // assume already in some company for the below purposes
		        if  ($newuserpassword == 'not found')
		          {   //  if completely new user add to usr table
		            $newnew_user='yes';
		           $tpass = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,9);
		           $newuserpassword = sha1($tpass);
	      	 
	      	   $newPass =$newuserpassword ;
		             /*If not, add new user to the selected (by current user)company.
		            Then display the result added new user .  REQUEST['new_contactEmail']. to  existing REQUEST['join_emp_name']
		           add new user to esixting company   - NEED to prompt for usr_type some where - probably on the form for entering new user info
		           until then will as as user_type = 1, not a primary*/ 
		$content .="<!--br>insert querylinr 1205<br>"
		."INSERT INTO usr (usr_email, usr_firstname, usr_lastname, usr_phone, usr_active, usr_join, usr_password, usr_auth, usr_created,usr_company,usr_type,usr_welcome_flag) 
	 VALUES('".Clean($_REQUEST['new_contactEmail'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','"
	        .Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."','".$newPass."','2','".date("Y-m-d H:i:s")."','".$addnewuser_company_id."','".$_REQUEST['newuser_type']."','0') -->";
		           
 $newuserid = QI("INSERT INTO usr (usr_email, usr_firstname, usr_lastname, usr_phone, usr_active, usr_join, usr_password, usr_auth, usr_created,usr_company,usr_type,usr_welcome_flag) 
 		   VALUES('".Clean($_REQUEST['new_contactEmail'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','"
 		   .Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."','".$newPass."','2','".date("Y-m-d H:i:s")."','".$addnewuser_company_id."','".$_REQUEST['newuser_type']."','0')");
		          $tusrID =$newuserid;
		$content .= "<!--<br>just did above insert; newuserid:" . $newuserid . " -->";	
		   if (!($newuserid))
		     {
		        $content .= "<br> error 1224 insert failed"; 
		     }
		          } 	
		      // whether  new user or user in a another company ned to add usr_emp table   record  
				////QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_auth) VALUES ('".$tusrID."','".$empID."','*')");
	$content .= "<!-- br> now doing the usr_emp insert:
	             <br>INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_usr_assignedusr_id,usremp_usr_auth,usremp_usr_password,usremp_usr_type )
		                 VALUES ('".$newuserid."','".$addnewuser_company_id."','".$newuserid."','*','".$newPass."','".$_REQUEST['newuser_type']."','0') -->";  //usremp_usr_assignedusr_id
//echo "I am here 2<br>";
		
 $newusremp_id=QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_usr_assignedusr_id,usremp_usr_auth,usremp_usr_password,usremp_usr_type, usremp_registration_date )
					VALUES ('".$newuserid."','".$addnewuser_company_id."','".$newuserid."','*','".$newPass."','".$_REQUEST['newuser_type']."', NOW())");  //usremp_usr_assignedusr_id
					
					
	$revtrigger = "DELETE from usr_emp_registration where usr_id = '".$newuserid."' and emp_id = '".$addnewuser_company_id."'";
	//echo $revtrigger."<br>";
	$delres = Q($revtrigger);

	
	if ($newusremp_id)
	   {
	      $content .= "<!--br>  usr_emp insert succeeded - newusremp_id: ". $newusremp_id . " -->";
	   }else
	   {  $content .= "<!-- br>  usr_emp insert failed  -->";
	   }
	//   Now update the number of seats in the company
	$getemprowSQL =  "SELECT emp_seats_occupied FROM emp   where emp_id =".$addnewuser_company_id. ""; 
	 $thisemp_seats  = QV($getemprowSQL);
	 if ($thisemp_seats)
	  { 
	     $addoneto_emp_seats_occupied = $thisemp_seats + 1;
	    $updateSQL= "UPDATE emp   SET emp_seats_occupied=" .$addoneto_emp_seats_occupied." where emp_id = ".$addnewuser_company_id. "";
	    $empupdate = QU($updateSQL) ;
	    
	 }
 //    
	//   
			  if ($newnew_user=='yes')
			  { 
			  $tmp_content = 'New User: '.$_REQUEST['new_contactEmail'] . "\r\n" . ' with assigned Password: '.$tpass; 
			    $tmp_content .=' has been added as a new user and associated with selected company: '.$addnewuser_company_name. '. ';
			    	$tmptrace_content = 'Username: '.$_REQUEST['new_contactEmail'] ."\r\n" .' with  Password: '.$tpass;
			  		$tmptrace_content .= ' has been added to company: ' .  $addnewuser_company_name. ', company_id: '.$addnewuser_company_id.'.';
			    	$jointracesubject = 'BC2Match Join - Add User';
			  } else 
			  {
			      $tmp_content = 'Username: '.$_REQUEST['new_contactEmail'] ."\r\n" . 'has been added to company named, '
			      .$addnewuser_company_name .  ' The  user is already in the database associated with another company or companies.
			        The new user password is unchanged.' ;
			      	$tmptrace_content = 'Username: '.$_REQUEST['new_contactEmail']."\r\n" . 'has been added to company, '
			      	.$addnewuser_company_name .', company_id: '.$addnewuser_company_id. 'The  user is already in the database associated with another company or companies.
			        The new user password is unchanged.' ;  
			  }
			     // 2/13/19 for test purspose 
			      $new_contactEmail =  $_REQUEST['new_contactEmail'];
			       $new_contactEmail ='lloydpalmer@yahoo.com';   // kill this statement  for production !!!!!!!
			 	  $joinsubject = 'BC2Match Join - Add User '.$_REQUEST['new_contactEmail']. ' for Company, ' .$addnewuser_company_name ;
			 	  $joinheaders = 'CC: '.$addnewuser_username . "\r\n" . ' From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
			      $joinheaders .= 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
				  mail($new_contactEmail,'BC2Match Join - Add User',$tmp_content,$joinheaders );
			      
			  		
			    	$jointracesubject = 'BC2Match Join Trace - Add User';
			    	$jointraceheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
			    	mail('lloydpalmer@yahoo.com','BC2Match Join Trace - Add User',$tmptrace_content,$jointraceheaders );
			    	
			    	
			    if ($newnew_user== 'yes')  				
			{	//Populate the clearance table
				$clearID = QI("insert into usr_clearance (usrclr_usr_id,usrclr_emp_id, usrclr_clr_id, usrclr_title) values (".$tusrID.",".$addnewuser_company_id.", '4','None')");
			  
				//Populate the union/non-union (edu) table
				$unonuID = QI("insert into usr_edu (usredu_usr_id, usredu_emp_id,usredu_edu_id) values (".$tusrID.",".$addnewuser_company_id.", '1')");
				
				// 1/30/19 populate the usr_app table so profile matching will work
				// cron job$query = "insert into usr_app (usrapp_usr_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance) select usr_id,'1','0','1','0' from usr where fed_id > 0 and fbo_file_processed = 0";
        $iquery = "insert into usr_app (usrapp_usr_id,usrapp_emp_id, usrapp_status, usrapp_edu_level, usrapp_ava_id, usrapp_clearance)
        values (".$tusrID.",".$addnewuser_company_id.",'1','0','1','0')"  ;      
		      $usr_app=QI($iquery);
		       $content .= "<!-- br>trace 1356 new usr_app id ". $usr_app ."           with iquery: ".$iquery  . "--> ";
       	}
		//********
		 $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                 <table width="600" align="center">
                 <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
        
  
                            The new user name, <br>
                            '. $_REQUEST['new_contactEmail'].',
                            <br>  has been added to the selected company -' .$addnewuser_company_name.' 
                            <br>  The number of seats occupied is now '.$addoneto_emp_seats_occupied . '
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                            <br>';
                    $UseHREFreqs = '?join_op=startNewEmployer';
                    $UseHREFreqs .= '&company_id='.$addnewuser_company_id ;
                    $UseHREFreqs .= '&contactEmail='.$addnewuser_username;  //$addnewuser_username
                     
                    if ($_SESSION['holdfrompage'] ==    "manageaccount")
                    {  //$userCompany $userID
                    $userCompany =$_SESSION['adminnuserCompany'];
                    $userID = $_SESSION['adminnnuserID'];
                       
                    unset($_SESSION['adminnnuserID'] );// = '';
                         unset($_SESSION['adminnuserCompany']) ; // = '';
                     $content .='<a href="admin_usr.php?usr='.$userID.'&empid='.$userCompany.'&ptype=admin&numseats='.$addoneto_emp_seats_occupied.'&fromjoinnowRC=ok">Return to Manage Account </a>';
                     //// $content .='<a href="admin_usr.php?usr='.$addnewuser_assignedusr_id.'&empid='.$userCompany.'&ptype=admin&numseats='.$addoneto_emp_seats_occupied.'&fromjoinnowRC=ok">Return to Manage Account </a>';
                    /////$_SESSION['adminnnuserID']    $_SESSION['adminnuserCompany'] 
                        
                        
                    }else
                    {
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to  Join Now Action Page </a>
   
                            <br>
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>';
                    }
                     $content .= '  </div>
                            </td><tr>
               <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';  
		
		//***********
			
		 
		
	  	  }
		     
		}
		          
               
               break;
               case "manageaccount" : 
               case "joinpage_loggedin":       
                /*$frompage ; $frompage="joinpage_actionhub";
                 asssume user has logged in successfully  if from manageaccount   query &addnewuser_company_id='.$userCompany.'&addnewuser_username='.$ut['usr_email'] .'"'
                 set $addnewuser_company_id= request['addnewuser_username']
                 set $addnewuser_username.      ;;;; username = request['addnewuser_company_id']  
                  query company for number of seats, emp_number_of_seats - subscription and emp-seats_occupied occupied 
                 set $addnewuser_numseats                   set $addnewuser_numseatsoccupied   emp_number_of_seats - emp-seats_occupied >= 1 then add 
               if ! ($addnewuser_numseats - $addnewuser_numseatsoccupied > 0 )
                   __    error panel                     __
                  |    error num seats return to action  [manage account] page to add seats       |                                                                               |
                                                                                                  |
                  |      return admin_usr manageaccount or to joinnow [action page or joinnow top |
                  |__                                                                           __|
                                                                                          
                 else
                   form to enter new user name         success panel
                    __
                   |    success user add num seats = occupied =                                   |
                                                                                                  |
                         return admin_usr manageaccount or to joinnow [action page or joinnow top |
                  |__                                                                           __|
               */      
      	$content .= '<!-- br>Arrived at "addnewuserexistcompany.manageaccount | joinpage_loggedin after successful login or from manage account<br -->';
      	$content .= '<!--br>usethisfrompage: '. $usethisfrompage . '-->';
       $_SESSION['$comdash_exists']= 'yes';
       $content .= '<!--br>Here to add another user to  the company: '.$addnewuser_company_name .',| '. $theselectedcompany . ' selected by ' . $_REQUEST['username']. ' implementation underway; sessjoinnowlogins: '  .$_Session['joinnow_logins'] ;
       $content .= '<br>addnewuser_company_name: ' .$addnewuser_company_name .', theselectedcompany: ' . $theselectedcompany . ' with company id: '.$addnewuser_company_id;
       $content .= '<br>addnewuser_assignedusr_id: '. $addnewuser_assignedusr_id . ' ';
       $content .= '<br>&addnewuser_username: '. $addnewuser_username . ', REQUEST[username]: ' .$_REQUEST['username'] . ',  REQUEST[contactEmail]: '  . $_REQUEST['contactEmail'] .'-->' ;
       /* Have already successfully logged in  show the add user form */
       
        if ( $usethisfrompage=="manageaccount")
        {
            //need to get the company name and user name if from admin_usr.php
             $content .= "<!-- br>need to get the company name and user name if from admin_usr.php <br -->";
             $content .=  "<!--  br> SESSION ".$_SESSION  . " -->";
            $addnewuser_username = $_REQUEST['addnewuser_username'];
            $foraddusergetcompanyname = "select emp_name from emp where emp_id =".$_REQUEST['addnewuser_company_id'];
            $addnewuser_company_name = QV($foraddusergetcompanyname);
            $addnewuser_company_id = $_REQUEST['addnewuser_company_id'];
            $addnewuser_assignedusr_id = $_REQUEST['addnewuser_assignedusr_id'];
            $_SESSION['adminnnuserID']  =  $addnewuser_assignedusr_id;
           $content .= "<!-- br> got addnewuser_username from REquest: ". $addnewuser_username ." got addnewuser_company_name, ".  $addnewuser_company_name. 
           " from query emp using Session usr_company: request [ addnewuser_company_id]  which is ". $addnewuser_company_id 
             . " and usr_id  addnewuser_assignedusr_id: ".  $addnewuser_assignedusr_id . " from request [ addnewuser_assignedusr_id] -->";
          }
          $content .= '  <div  style="background-color: #CFE8FF; margin:auto; border-radius: 20px 20px 1px 1px;width:600px;"> &nbsp;
           <br>';
			$content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'" id="newuseroldcompForm" name="newuseroldcompForm" onsubmit="return validatenewuseroldcompForm()">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	<div style="float:right">&nbsp;</div>
    		<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:left; ">  
    		    <br>&nbsp;You are logged in as '.$addnewuser_username . '; your selected company is ' .$addnewuser_company_name. '.</span>
		     <br> <br> &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:left;"> 
		     Enter information requested below to add a new user(E-Mail) to the company.   </span> 
	    	     <br>	<span style="font-size: 12px; font-family: arial; "> 
	    	    &nbsp;* - Starred (*) items are required. </span>
	    	     	</div> <br>
		    <table style="border:0px;" cellpadding="0" cellspacing="0">
		    	<tr><td style="text-align:right;">  Company Name: </td><td style="background-color:#eeeeee;width:200px;"> '.$addnewuser_company_name . '</td></tr> 
	 	  	<tr><td style="text-align:right;">* First Name: </td><td ><input type="text" style="width:200px;" name="contactFirstname" value="" title="First Name" /></td></tr>
	    	<tr><td style="text-align:right;">* Last Name: </td><td ><input type="text" style="width:200px;" name="contactLastname" value="" title="Last Name" /></td></tr>
	    	<tr><td style="text-align:right;">* Phone Number: </td><td ><input type="text" style=width:200px;" name="contactPhone" value="" /></td></tr>  
	    	<tr><td style="text-align:right;">* E-Mail: </td><td ><input type="text" style="width:200px;" name="new_contactEmail" value="" /></td></tr>
	    		<tr><td style="text-align:right;">* User Type: </td>
	    	         <td style="background-color:#ffffff;width:200px;">                                                 
	    	           	  <input type="radio"   name="newuser_type" 	value="1" checked>Regular User
	    		&nbsp;  <input type="radio"   name="newuser_type" value="0"> Primary  </td></tr   
	    		  	
	    	          <tr><td> 
	    	           <!--input type="hidden" name="newuser_type" 	value="0" / -->
	    	          <input type="hidden" name="join_op" value="addnewuserexistcompany" />
	    	            <input type="hidden" name="join_op_action" value="actionhub" />
	    	                <input type="hidden" name="actioncompany" value="2" />	
	                     <input type="hidden" name="frompage" value="addnewusrtocompany" />
	    	            <input type="hidden" name="company_name" value="'.$addnewuser_company_name .'"/>
				            <input type="hidden" name="username" value="'.$addnewuser_username . '"/>
				             <input type="hidden" name="assignedusr_id" value="'.  $addnewuser_assignedusr_id. '"/> 
				             
				            
				              <input type="hidden" name="usr_company" value="'.  $addnewuser_company_id. '"/> 
				              <input type="hidden" name="company_id" value="'.  $addnewuser_company_id. '"/> 
	                 </td></tr>
	                 <tr><td style="text-align:right;">&nbsp;</td> 
	                  <td   style="text-align:center;"><br>	<input type="submit" value="Submit" />
	    	</td></tr>
	    	</table> 
	        
            </form>  
            </div>';
             $content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:600px;height:'.$halfheaderheight.'px;">&nbsp;</div>';
            //<tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';
            
                  break;
           case "joinnow_logging_in":
                 /*
                   authenticate login for curent user - query db for usr_id with pword and usremp_emp_id = company_id (selected company)
                   if ok set loginauth = "ok"
                   if not show error and choice to return to action page or top of jonnow
                  extract username and password                   query usr with usrname and password
                  if no hit ::: error login unsuccessful                   _
                  |    error bad login 
                  |                                                                              |
                                                                                                 |
                        return admin_usr manageaccount or to joinnow [action page or joinnow top |
                  |__ 
                  else if login successful
                      go to joinnow with $frompage="joinpage_loggedin"
                  break;
                        //  joinnow_loginfromaddnewuserexistco  $frompage="joinpage_actionhub";    //join_ op= "addnewuserexistcompany" and join_ptype" value="loginfromaddnewuserexistco"
                  
                  */
                  $sleeptime = 20;
                  $content .= '<!--br>Arrived at joinnow_loggin_in - addnewuser_company_id: '.$addnewuser_company_id.', REQUEST[username]: '. $_REQUEST['username'] . 
                  'addnewuser_company_name: ' . $addnewuser_company_name. ', addnewuser_assignedusr_id: '.  $addnewuser_assignedusr_id .' sleep 30-addnewuser_company_id: ' .$addnewuser_company_id .'-->';
                 // break;
                  //sleep(5);

                  
     ////   $query = "SELECT * FROM usr usr  WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
       	$query = "SELECT usr.*,usemp.usremp_usr_assignedusr_id FROM usr usr inner join usr_emp usemp on usr.usr_id = usemp.usremp_usr_assignedusr_id
       	WHERE usr.usr_email ='" . Clean($_REQUEST['username']) . "' AND usr.usr_password = '" . sha1($_REQUEST['password']) . "'";
         	  $content .= '<!-- <br> addnewuserexistcompany login first query'.	$query . '<br>  -->';
              $result=mysqli_query($conn, $query) ;
   	         if   ($result )   //1
	          {
		    	if  (mysqli_num_rows($result)== 0)  //2
	      		
	           {   // login failed --show another login in form
		         $_Session['joinnow_logins'] = $_Session['joinnow_logins'] + 1;
		         
		         $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                 <table width="600" align="center">
                 <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
        
  
                            Login for ' . $_REQUEST['username']. ' failed. 
                            
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
            
                            <br>';
                    $UseHREFreqs = '?join_op=addnewuserexistcompany&join_ptype=havecofornewusr';
                    $UseHREFreqs .= '&company_id='.$addnewuser_company_id .'' ;
                    $UseHREFreqs .= '&company_name='.$addnewuser_company_name.'&username='. $_REQUEST['username'].'&contactEmail='. $_REQUEST['username'];
                    $UseHREFreqs .= '&attemptnewthere='. $_REQUEST['new_contactEmail'].'';
                    if ($_SESSION['holdfrompage'] ==    "manageaccount")
                    {
                        //&empid='.$userCompany.'' $userID
                      ////  $content .= '<a href="admin_usr.php?usr='.$addnewuser_assignedusr_id.'&ptype=admin">Manage Account </a>';
                     
                       $userCompany =$_SESSION['adminnuserCompany'];
                    $userID = $_SESSION['adminnnuserID'];
                       
                    unset($_SESSION['adminnnuserID'] );// = '';
                         unset($_SESSION['adminnuserCompany']) ; // = '';
                      
                          $content .= '<a href="admin_usr.php?usr='.$userID.'&empid='.$userCompany.'&ptype=admin">Manage Account </a>';
                    }else
                    {
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to Join Now page </a>
   
                            <br>
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>';
                    }
                     $content .= '  <!-- ?/div  -->
                            </td><tr>
               <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';
              
		  	     $content .= '<table align="center" width="780">
 		         < 
 		         </tr></td></table>';
 		       ////   <!-- SESSION[usr_auth]: '.  $_SESSION['usr_auth'].', sess comdash_exists: ' .$_SESSION['$comdash_exists'] . 
 		       ////, my_pagename: ' .  basename($_SERVER['PHP_SELF']) . ' --> Session[ joinnow_logins ]: ' .$_Session['joinnow_logins']. 
 		        
	        } else {
	            // login successful'  now show add new user form
	            $content .= "<!-- br> login successful'  now show add user form at ". date('Y-m-d H:i:s') ;
  $content .= "<br>redirecting to url=/  "
  .$_SESSION['env']."/joinnow.php.?join_op=addnewuserexistcompany&join_op_action=actionhub&actioncompany=2&frompage=joinpage_loggedin&assignedusr_id=".$addnewuser_assignedusr_id."&company_name=".$addnewuser_company_name ."&company_id=".$addnewuser_company_id ."&username=".$_REQUEST['username']. " -->";

	           // break;   &assignedusr_id=".$addnewuser_assignedusr_id ." &company_name="'.$addnewuser_company_name ."
	             $sleeptime = 40;
                  //sleep(30);
header("Refresh:1; url=/".$_SESSION['env']."/joinnow.php.?join_op=addnewuserexistcompany&join_op_action=actionhub&actioncompany=2&frompage=joinpage_loggedin&assignedusr_id=".$addnewuser_assignedusr_id."&company_name=".$addnewuser_company_name ."&company_id=".$addnewuser_company_id ."&username=".$_REQUEST['username']);
///http://bc2match.com/bc2dev/joinnow.php?join_op=addnewuserexistcompany&join_op_action=actionhub&actioncompany=2&frompage=joinpage_loggedin&assignedusr_id=26804&company_name=Saints%20Foundation&company_id=395259&username=tojo@att.net

////
	    ////header("Refresh: 1; url=/".$_SESSION['env']."/bc2_admins.php"); die(); break;                 >$addnewuser_company_id 
	   //// die(); break;
	            // header("Refresh: 1; url=". $ _ SERVER['PHP_SELF']."); die(); break;
	      /*   <input type="hidden" name="join_op" value="addnewuserandcompany" /><input type="hidden" name="join_op_action" value="actionhub" />
	 * 	                <input type="hidden" name="actioncompany" value="2" />	
	    	            <input type="hidden" name="company_name" value="'.$addnewuser_company_name .'"/>
				           
				             <input type="hidden" name="assignedusr_id" value="'.  $addnewuser_assignedusr_id. '"/> 
				             
				               <input type="hidden" name="usr_firstname" value="'.  $addnewuser_usr_firstname. '"/> 
				              <input type="hidden" name="usr_lastname" value="'.  $addnewuser_lastname . '"/> 
				              <input type="hidden" name="usr_auth" value="'.  $addnewuser_usr_auth . '"/> 
				              <input type="hidden" name="usr_type" value="'. $addnewuser_usr_type . '"/> 
				              <input type="hidden" name="usr_company" value="'.  $addnewuser_company_id. '"/> 
	            */
	        }  
	      }
          
         break;
                  
                  
            case "joinpage_actionhub":     
                  //  ??"  here to login and go tojoinnow_logging_in":     
            default:    
                   /* display login form                        set $frompage=_logging_in                *******                */       
              		$content .=	 ' <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ --> ';  
              		$content .=	' <!--br> arrived at frompage = "joinpage_actionhub"  or to default: -  here to log in;  addnewuser_company_id: '   . $addnewuser_company_id .'-->';
    	$headerheight ="80";		
 	 $strcompanyname = str_replace("AND", "&",$_REQUEST['emp_name'],  $cocount);
  	$content .= '<table align="center" width="700"> <tbody>
      	<tr> <td align="center" width="100%" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;"><strong>Here to Login to Your Company - 2</strong>'; 
       $content .=  '<br/>'. $_REQUEST['username']. ', Login to to the company you selected:  <br/> 
                    </td></tr> 
                    <tr><td style="background-color:#dddddd; height:80px;">
              <strong> Login here: </strong>  <br> 	
              <form action="index.php" method="post"  > 
		          <table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink" style="margin-top:40px;">Forgot your password? </a>
				</td><td>
				<label class="loginlabel"> Email:</label>
			<input class="loginbox" style="display:inline;width:180px;" type="text" maxlength="40" size="24"  value="'.$addnewuser_username .'" id="username" name="username" title="Email(User Name)" />
				</td><td>&nbsp; </td> <td><label class="loginlabel" style="display:inline;"> Password:</label>
				 					<input class="loginbox" style="display:inline;" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				  </td><td>&nbsp; </td> <td> <label class="loginlabel" style="display:inline;">Company:</label>
				  <input class="loginbox" style="display:inline;width:180px;" type="text" maxlength="40" size="24"  value="'.$addnewuser_company_name .'" id="companyname" name="companyname" title="Company" />
					                              
				</td><td>  		
				           <input type="hidden" name="join_op" value="addnewuserexistcompany"/>
				           <input type="hidden" name="join_op_action" value= "actionhub"/>     <!--$reqjoin_op_action) * -->
				   <input type="hidden" name=join_ptype" value="loginfromaddnewuserexistco"/>
				   <input type="hidden" name="frompage" value="joinnow_logging_in"/>
				            <input type="hidden" name="actioncompany" value="2" />
				           <input type="hidden" name="company_id" value="'.$addnewuser_company_id .'"/>
				           <input type="hidden" name="company_name" value="'.$addnewuser_company_name .'"/>
				           
				             <input type="hidden" name="assignedusr_id" value="'.  $addnewuser_assignedusr_id. '"/> 
				             
				               <input type="hidden" name="usr_firstname" value="'.  $addnewuser_usr_firstname. '"/> 
				              <input type="hidden" name="usr_lastname" value="'.  $addnewuser_lastname . '"/> 
				              <input type="hidden" name="usr_auth" value="'.  $addnewuser_usr_auth . '"/> 
				              <input type="hidden" name="usr_type" value="'. $addnewuser_usr_type . '"/> 
				              <input type="hidden" name="usr_company" value="'.  $addnewuser_company_id. '"/> 
				               <input type="hidden" name="username" value="'. $_REQUEST['username']. '"/>   <!--?? $ addnewuser_username -->
				             
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		</form><br/>
		         
		   </td></tr> </tbody></table></td></tr></tbody></table> ';    
               
                   break;
                 
           }        
           
       

         break;
     case "addseattocompany":
         //here to update company table field, emp_level and inform user.';
         /* UPDATE table_name SET column1=value, column2=value2,...WHERE some_column=some_value 
            global  $addfiveprice,$addtenprice,$addfifteenprice,$addtwentyprice,  $addtwentyfiveprice,$addthirtyprice,$generic_numseats,$generic_level,$intmultfive,$eachaddprice;
     global $addfromoneprice,$addfromfiveprice,$addfromtenprice,$addfromfifteenprice,$addfromtwentyprice,$addfromtwentyfiveprice;
  addthismanyseats $addthismanyseats   forthisamount $forthisamount
   */ 
     $content .= '<!--br>trace line 1582 at addseattocompany after payment here to actually add the seat and ack to user';
       $content .= '<br>addthismanyseats: ' .$_REQUEST['addthismanyseats'] .'  forthisamount: '. $_REQUEST['forthisamount'] . '-->';
          $addthismanyseats =$_REQUEST['addthismanyseats'];
          $forthisamount =$_REQUEST['forthisamount'];
          $sumcurrentplusaddseats =  $generic_numseats + $addthismanyseats;
          $lookB4addseatsQL= "SELECT emp_number_seats from emp where emp_id = ".$generic_company_id .";";
          $numseatsB4 = QV( $lookB4addseatsQL);
           $content .= "<!-- ------br>trace 1594 numseatsB4 = ". $numseatsB4 . ", lookB4addseatsQL: ". $lookB4addseatsQL ."----   -->";
           $sumcurrentplusaddseats = $numseatsB4 + + $addthismanyseats;
          $addseatSQL =" UPDATE emp Set emp_number_seats = ". $sumcurrentplusaddseats . " where emp_id = ".$generic_company_id .";";
          $thisseatadded = QV($addseatSQL);
       $content .= '<!-- br> trace 1595 updateseatsSQL: '. $addseatSQL .'-->';
       $lookafteraddseatsQL= "SELECT emp_number_seats from emp where emp_id = ".$generic_company_id .";";
       $numseatsafter = QV($lookafteraddseatsQL);
       
       $content .= "<!-- br>1599  thisseatadded = " . $thisseatadded . ";  numseatsafter = " . $numseatsafter .", lookafteraddseatsQL: ". $lookafteraddseatsQL . "-->";
         $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                 <table width="600" align="center">
                 <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">';
   
         $content .=' We have added '. $addthismanyseats .' seats to the selected company -' .$generic_company_name.' 
                            <br>You now have [' .  $sumcurrentplusaddseats.'] of which ['.$generic_numseatsoccupied . '] ';
                            if ($generic_numseatsoccupied ==1)
                            {$content.= 'is'; } else {$content .= 'are';} 
                            $content .=' in use. ';
                           // $content .="_SESSION['env']: " .$_SESSION['env'];
                  $content .='</td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >';
  //$content .= "<a href=./bc2companydashboard.php?op=newemaillogin&username=".$_SESSION['emailtogodash']."&usr_password=".$_SESSION['password_addseats']."&password=".$_SESSION['password_addseats'].">Go to Dash Board </a>";
  $content .= "<br><a href=./bc2members.php?usr=".$generic_assignedusr_id."&company_id=".$generic_company_id.">Go to Dashboard </a> <br><br>or<br><br> ";  
  $content .= "<a href=./admin_usr.php?usr=".$generic_assignedusr_id."&ptype=admin&company_id=".$generic_company_id.">Go to Manage Account </a><br><br>";

                  //?usr=".$_SESSION['usr_id']."&company_id=".$_SESSION['usr_company']."" $_SESSION['emailtogodash']= $reqemail;	$_SESSION['password_addseats']
                   
                 
                  
                     $content .= '  </div>
                            </td><tr>
               <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';  
  
    break;
    
 case "upgradelevelcompany":       
            //here to update company table field, emp_level and inform user.';
            /* UPDATE table_name SET column1=value, column2=value2,...WHERE some_column=some_value   */
       $content .= '<!-- br>trace line 1590 arrived at upgradelevelcompany after payment here to actually upgrade the level and ack the user -->';
       $thisupgradetolevel = $_REQUEST['thisupgradetolevel'];
       $thisupgradetolevel = $_REQUEST['thisupgradetolevel'];
        $B4lookatlevel = "SELECT emp_level from emp where  emp_id = ".$generic_company_id .";";
       $B4whatislevel = QV($lookatlevel);
      $content .= '<!-- br> trace 1595 thisupgradetolevel: '.$thisupgradetolevel.', B4lookatlevel: '. $B4lookatlevel  . '  B4whatislevel is ' .$B4whatislevel .'-->';
      
       $thisupgradetolevel = $_REQUEST['thisupgradetolevel'];
        $updatelevelSQL= "UPDATE emp Set emp_level = ". $thisupgradetolevel . " where emp_id = ".$generic_company_id .";";
       $content .= '<!-- br> trace 1595 updatelevelSQL: '. $updatelevelSQL .'-->';
       $doupdatelevel = QV( $updatelevelSQL);
       $lookatlevel = "SELECT emp_level from emp where  emp_id = ".$generic_company_id .";";
       $whatislevel = QV($lookatlevel);
        $content .= '<!--br> trace 1595 lookatlevel: '. $lookatlevel  . ' now whatislevel is ' .$whatislevel .'-->';
      $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                 <table width="600" align="center">
                 <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">';
        
  switch ($_REQUEST['thisupgradetolevel'])
 			     {
 			         case 1:
 			           $upgradedesc = "Silver";
 			            //$levelcolor = "#f2f2f2";
 			             $upgradefgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $upgrade_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $upgradedesc = "Gold";
 			           $upgradecolor = "#FFD700";
 			            $upgradefgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $upgrade_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $upgradedesc = "Platinum";
 			             $upgrade_show_level ="Platinum";
 			             // $levelcolor 
 			              $upgradefgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $upgradedesc = "Titanium";
 			            $upgrade_show_level = "Titanium";
 			            // $levelcolor 
 			             $upgradefgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $upgradedesc = "Silver";
 			           $upgrade_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $upgradefgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }   
                    $content .=' <br> The subscription level for the selected company<br> - ' .$generic_company_name.' 
                            <br>- has been upgraded to <span style="background-color:'. $upgradefgcolor.';">' . $upgrade_show_level.'</span> 
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >';
            
    $content .= "<a href=./bc2companydashboard.php?op=newemaillogin&username=".$_SESSION['emailtogodash']."&usr_password=".$_SESSION['password_upgradelevel']."&password=".$_SESSION['password_upgradelevel'].">Go to Dash Board </a>";
                    
        $content .= '<br>';
                 /*   $UseHREFreqs = '?join_op=startNewEmployer';password_upgradelevel
                    $UseHREFreqs .= '&company_id='.$generic_company_id ;
                    $UseHREFreqs .= '&contactEmail='.$generic_username;  //$addnewuser_usernameusr='.$generic_assignedusr_id.'
                     $content.= "<!-- br> trace 1654 generic_assignedusr_i: " .$generic_assignedusr_id. ",SESSION['holdfrompage']: ". $_SESSION['holdfrompage'] ." -->" ;
                    if ($_SESSION['holdfrompage'] ==    "manageaccount")
                    {
                 //  &empid='.$userCompany.'   $userID   
        ////  $content .='<a href="admin_usr.php?usr='.$generic_assignedusr_id.'&ptype=admin&newlevel='.$thisupgradetolevel.'&fromjoinnowRC=ok">Return to Manage Account </a>';
      
         $userCompany =$_SESSION['adminnuserCompany'];
                    $userID = $_SESSION['adminnnuserID'];
                       
                    unset($_SESSION['adminnnuserID'] );// = '';
                         unset($_SESSION['adminnuserCompany']) ;
      
        $content .='<a href="admin_usr.php?usr='.$userID.'&empid='.$userCompany.'&ptype=admin&newlevel='.$thisupgradetolevel.'&fromjoinnowRC=ok">Return to Manage Account </a>';
                  }else
                    {
                  $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to  Join Now Action Page </a>
   
                            <br>
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>';
                    }*/
                     $content .= '  </div>
                            </td><tr>
               <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';  
        break;  
  case "confirmsamuser" :
                $content.="<!-- br>trace 1756 arrived at addnewusernewcompanypay to show pay form for adding new user and new company 
          here to do mock payment processing for updgrade level  table field, emp_level and inform user -->";
           $goldlevelcolor = "#FFD700";
           $silverlevelcolor ="#f2f2f2";
          $content .=  "<!-- br>trace 1754 REQUEST['frompage']: ". $_REQUEST['frompage'] . ", REQUEST['company']: ".   $_REQUEST['company']     
                   .", REQUEST['level']" . $_REQUEST['level'] . ", REQUEST['user_type']: " . $_REQUEST['user_type']
                   .", REQUEST['numberofseats']: ".  $_REQUEST['numberofseats'] .  ",REQUEST['ptype']: " .  $_REQUEST['ptype'] 
                    .", REQUEST['comments']: " .  $_REQUEST['comments']. ", REQUEST[contactLastname]: " . $_REQUEST['contactLastname']
                    . ",REQUEST['contactFirstname']: " .  $_REQUEST['contactFirstname'] . ", REQUEST['contactPhone']: " .  $_REQUEST['contactPhone']
                    . ",REQUEST['contactEmail']: " .  $_REQUEST['contactEmail'] .",REQUEST['company']: ".   $_REQUEST['company']."-->";
   /**/
   $generic_company_name =$_REQUEST['company'];
   $generic_username= $_REQUEST['contactEmail'];
   
 $_SESSION['addcompany_username']= $_REQUEST['contactEmail'];
      
   	switch ( $_REQUEST['level'])
 			     {
 			         case 1:
 			           $subleveldesc = "Silver";
 			            $silverlevelcolor = "#f2f2f2";
 			             $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $generic_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $subleveldesc = "Gold";
 			           $goldlevelcolor = "#FFD700";
 			            $levelfgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $generic_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $subleveldesc = "Platinum";
 			             $generic_show_level ="Platinum";
 			             // $levelcolor 
 			              $levelfgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $subleveldesc = "Titanium";
 			            $generic_show_level = "Titanium";
 			            // $levelcolor 
 			             $levelfgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $subleveldesc = "Silver";
 			           $generic_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $levelfgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }      
 			       $silverlevelcolor = "#f2f2f2";
 			           $goldlevelcolor = "#FFD700";
 			             $platinumlevelcolor ="#F4F4F4";
   
    $content .= '  <div class="main-body-content" "> ';
        $content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	
    		<div style="font-size: 14px; font-family: arial; font-family: arial; text-align:left;"> ';

		        $content .= ' 
		      <span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
		      </span> 
		      
		      <p class="dark-heading" style="text-align:center;"><strong >Please review your information.</strong></p>
		      

	    	     	 
         <table cellpadding="2" cellspacing="2" style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width: 685px; margin-left:auto; margin-right:auto;" width="780">
<tr><td colspan="2" style="text-align:center;"><p style=" 	font-size: 18px;  text-align: center;"><b>Please confirm your information and when correct click the submit button</b></p></td></tr>
		 <tr><td class="table-form-label">* Company: </td>
		 <td>
<input  class="loginbox" type="text" name="company" value="'. $_REQUEST['company'].'" required="true" /></td></tr>					 
					 
<tr><td class="table-form-label">* First Name: </td>
<td >
<input class="loginbox" type="text" name="contactFirstname" value= "'. $_REQUEST['contactFirstname'].'" required="true" /> </td></tr> 
	   		 	
<tr><td class="table-form-label">* Last Name: </td><td>
<input class="loginbox" type="text" name="contactLastname"  value= "' . $_REQUEST['contactLastname'].'" required="true" />	</td></tr> 

<tr><td class="table-form-label">* Phone: <br> <span style="font-size:14px;font-weight:500;">Phone number format is<br>(xxx-xxx-xxxx)</span></td><td>
<input class="loginbox" type="tel" name="contactPhone" value= "'  .  $_REQUEST['contactPhone'].'" required="true" pattern="^\d{3}-\d{3}-\d{4}$" onKeyPress="if(this.value.length == 12) return false;" /></td></tr> 
			  
<tr><td class="table-form-label">* E-Mail: </td><td>
<input class="loginbox" type="email" name="contactEmail" value="'. $_REQUEST['contactEmail'].'" required="true" readonly /></td></tr>

<tr><td class="table-form-label">* Password: </td><td>
<input class="loginbox" type="text" name="password" value="'. $_REQUEST['password'].'" required="true" /></td></tr>

<tr><td class="table-form-label">* Number of Seats: </td><td>
<input class="loginbox" type="text" name="numberofseats" value="'. $_REQUEST['numberofseats'].'" required="true"/></td></tr>	

<input type="hidden" name="join_op" value="registersamuser" />
	    	            <input type="hidden" name="generic_casevalue" value = "registersamuser" /> 
	    	                <input type="hidden" name="actioncompany" value="5" /-->
	    	             <input type="hidden" name="generic_casevalue" value = "registersamuser" /> 
	    	             <input type="hidden" name="frompage" value="registersamuser" />
	    	             <input type="hidden" name="forthisamount" value="'.$forthisamount.'" />
	    	            

			 	    	<tr><td colspan="3">  
						<input type="hidden" name=" level" value="'.$_REQUEST['level'].'" />
	    	            <input type="hidden" name="level" value="'.$_REQUEST['level'].'" />
	    	            <input type="hidden" name="user_type"  value= "' . $_REQUEST['user_type'].'" />
	    	            <input type="hidden" name="ptype" value= "' .  $_REQUEST['ptype'] .'"/>
	    	            <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				        <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                    
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				        <input type="hidden" name="username" value="'.$generic_username . '"/>
				        
				         <input type="hidden"   name="company_id" value="'.$_REQUEST['company_id'].'"/> 
	                     <input type="hidden"   name="assignedusr_id" value="'.$_REQUEST['assignedusr_id'].'"/>
				        
				        <input type="hidden" name="numseatsoccupied" value="1"/> ';
				        

				        

	                $content .=' </td></tr>
	                  
	               <tr> <td colspan="2"><center><input class="btn-prm" type="submit" value="Submit" /></center>
	    	</td></tr>
	    	</table> 
	        
            </form>  
            </div>';
             //$content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:660px;height:'.$halfheaderheight.'px;">&nbsp;</div>';
      
    break;
  case "upgradelevelpay": case "addseatpay": case "addnewusernewcompanypay": case "memaddnewcompany" :
      // will show payform here for addnewuserandcompany
      if ($_REQUEST['join_op']== "addnewusernewcompanypay")  // //actioncompany = 5
      {
          $content.="<!-- br>trace 1756 arrived at addnewusernewcompanypay to show pay form for adding new user and new company 
          here to do mock payment processing for updgrade level  table field, emp_level and inform user -->";
           $goldlevelcolor = "#FFD700";
           $silverlevelcolor ="#f2f2f2";
          $content .=  "<!-- br>trace 1754 REQUEST['frompage']: ". $_REQUEST['frompage'] . ", REQUEST['company']: ".   $_REQUEST['company']     
                   .", REQUEST['level']" . $_REQUEST['level'] . ", REQUEST['user_type']: " . $_REQUEST['user_type']
                   .", REQUEST['numberofseats']: ".  $_REQUEST['numberofseats'] .  ",REQUEST['ptype']: " .  $_REQUEST['ptype'] 
                    .", REQUEST['comments']: " .  $_REQUEST['comments']. ", REQUEST[contactLastname]: " . $_REQUEST['contactLastname']
                    . ",REQUEST['contactFirstname']: " .  $_REQUEST['contactFirstname'] . ", REQUEST['contactPhone']: " .  $_REQUEST['contactPhone']
                    . ",REQUEST['contactEmail']: " .  $_REQUEST['contactEmail'] .",REQUEST['company']: ".   $_REQUEST['company']."-->";
   /**/
   $generic_company_name =$_REQUEST['company'];
   $generic_username= $_REQUEST['contactEmail'];
   
 $_SESSION['addcompany_username']= $_REQUEST['contactEmail'];
      
   	switch ( $_REQUEST['level'])
 			     {
 			         case 1:
 			           $subleveldesc = "Silver";
 			            $silverlevelcolor = "#f2f2f2";
 			             $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $generic_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $subleveldesc = "Gold";
 			           $goldlevelcolor = "#FFD700";
 			            $levelfgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $generic_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $subleveldesc = "Platinum";
 			             $generic_show_level ="Platinum";
 			             // $levelcolor 
 			              $levelfgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $subleveldesc = "Titanium";
 			            $generic_show_level = "Titanium";
 			            // $levelcolor 
 			             $levelfgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $subleveldesc = "Silver";
 			           $generic_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $levelfgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }      
 			       $silverlevelcolor = "#f2f2f2";
 			           $goldlevelcolor = "#FFD700";
 			             $platinumlevelcolor ="#F4F4F4";
   
    $content .= '  <div class="main-body-content" "> ';
        $content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	
    		<div style="font-size: 14px; font-family: arial; font-family: arial; text-align:left;"> ';

		        $content .= ' 
		      <span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
		      </span> 
		      
		      <p class="dark-heading" style="text-align:center;"><strong >Please review your information.</strong></p>
		      

	    	     	 
         <table cellpadding="2" cellspacing="2" style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width: 685px; margin-left:auto; margin-right:auto;" width="780">
<tr><td colspan="2" style="text-align:center;"><p style=" 	font-size: 18px;  text-align: center;"><b>Please confirm your information and when correct click the submit button</b></p></td></tr>
		 <tr><td class="table-form-label">* Company: </td>
		 <td>
<input  class="loginbox" type="text" name="company" value="'. $_REQUEST['company'].'" required="true" /></td></tr>					 
					 
<tr><td class="table-form-label">* First Name: </td>
<td >
<input class="loginbox" type="text" name="contactFirstname" value= "'. $_REQUEST['contactFirstname'].'" required="true" /> </td></tr> 
	   		 	
<tr><td class="table-form-label">* Last Name: </td><td>
<input class="loginbox" type="text" name="contactLastname"  value= "' . $_REQUEST['contactLastname'].'" required="true" />	</td></tr> 

<tr><td class="table-form-label">* Phone: <br> <span style="font-size:14px;font-weight:500;">Phone number format is<br>(xxx-xxx-xxxx)</span></td><td>
<input class="loginbox" type="tel" name="contactPhone" value= "'  .  $_REQUEST['contactPhone'].'" required="true" pattern="^\d{3}-\d{3}-\d{4}$" onKeyPress="if(this.value.length == 12) return false;" /></td></tr> 
			  
<tr><td class="table-form-label">* E-Mail: </td><td>
<input class="loginbox" type="email" name="contactEmail" value="'. $_REQUEST['contactEmail'].'" required="true" readonly /></td></tr>

<tr><td class="table-form-label">* Password: </td><td>
<input class="loginbox" type="text" name="password" value="'. $_REQUEST['password'].'" required="true" /></td></tr>

<tr><td class="table-form-label">* Number of Seats: </td><td>
<input class="loginbox" type="text" name="numberofseats" value="'. $_REQUEST['numberofseats'].'" required="true"/></td></tr>	

<input type="hidden" name="join_op" value="addnewuserandcompany" />
	    	            <input type="hidden" name="generic_casevalue" value = "addseattocompany" /> 
	    	                <input type="hidden" name="actioncompany" value="5" /-->
	    	             <input type="hidden" name="generic_casevalue" value = "addnewuserandcompany" /> 
	    	             <input type="hidden" name="frompage" value="addnewuserandcompany" />
	    	             <input type="hidden" name="forthisamount" value="'.$forthisamount.'" />
	    	            

			 	    	<tr><td colspan="3">  
						<input type="hidden" name=" level" value="'.$_REQUEST['level'].'" />
	    	            <input type="hidden" name="level" value="'.$_REQUEST['level'].'" />
	    	            <input type="hidden" name="user_type"  value= "' . $_REQUEST['user_type'].'" />
	    	            <input type="hidden" name="ptype" value= "' .  $_REQUEST['ptype'] .'"/>
	    	            <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				        <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                    
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				        <input type="hidden" name="username" value="'.$generic_username . '"/>
				        <input type="hidden" name="numseatsoccupied" value="1"/> ';

	                $content .=' </td></tr>
	                  
	               <tr> <td colspan="2"><center><input class="btn-prm" type="submit" value="Submit" /></center>
	    	</td></tr>
	    	</table> 
	        
            </form>  
            </div>';
             //$content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:660px;height:'.$halfheaderheight.'px;">&nbsp;</div>'; 
          
		     
          break;
      }
      elseif ($_REQUEST['join_op']== "memaddnewcompany")
      {
          $content.="<!-- br>trace 1756 arrived at addnewusernewcompanypay to show pay form for adding new user and new company 
          here to do mock payment processing for updgrade level  table field, emp_level and inform user -->";
           $goldlevelcolor = "#FFD700";
           $silverlevelcolor ="#f2f2f2";
          $content .=  "<!-- br>trace 1754 REQUEST['frompage']: ". $_REQUEST['frompage'] . ", REQUEST['company']: ".   $_REQUEST['company']     
                   .", REQUEST['level']" . $_REQUEST['level'] . ", REQUEST['user_type']: " . $_REQUEST['user_type']
                   .", REQUEST['numberofseats']: ".  $_REQUEST['numberofseats'] .  ",REQUEST['ptype']: " .  $_REQUEST['ptype'] 
                    .", REQUEST['comments']: " .  $_REQUEST['comments']. ", REQUEST[contactLastname]: " . $_REQUEST['contactLastname']
                    . ",REQUEST['contactFirstname']: " .  $_REQUEST['contactFirstname'] . ", REQUEST['contactPhone']: " .  $_REQUEST['contactPhone']
                    . ",REQUEST['contactEmail']: " .  $_REQUEST['contactEmail'] .",REQUEST['company']: ".   $_REQUEST['company']."-->";
   /**/
   $generic_company_name =$_REQUEST['company'];
   $generic_username= $_REQUEST['contactEmail'];
   
 $_SESSION['addcompany_username']= $_REQUEST['contactEmail'];
      
   	switch ( $_REQUEST['level'])
 			     {
 			         case 1:
 			           $subleveldesc = "Silver";
 			            $silverlevelcolor = "#f2f2f2";
 			             $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $generic_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $subleveldesc = "Gold";
 			           $goldlevelcolor = "#FFD700";
 			            $levelfgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $generic_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $subleveldesc = "Platinum";
 			             $generic_show_level ="Platinum";
 			             // $levelcolor 
 			              $levelfgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $subleveldesc = "Titanium";
 			            $generic_show_level = "Titanium";
 			            // $levelcolor 
 			             $levelfgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $subleveldesc = "Silver";
 			           $generic_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $levelfgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }      
 			       $silverlevelcolor = "#f2f2f2";
 			           $goldlevelcolor = "#FFD700";
 			             $platinumlevelcolor ="#F4F4F4";
   
    $content .= '  <div class="main-body-content" "> ';
        $content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	
    		<div style="font-size: 14px; font-family: arial; font-family: arial; text-align:left;"> ';

		        $content .= ' 
		      <span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
		      </span> 
		      
		      <p class="dark-heading" style="text-align:center;"><strong >Please review your information.</strong></p>
		      

	    	     	 
         <table cellpadding="2" cellspacing="2" style="background:#eaeff7;border-radius:4px;margin:20px;padding:20px;width: 685px; margin-left:auto; margin-right:auto;" width="780">
<tr><td colspan="2" style="text-align:center;"><p style=" 	font-size: 18px;  text-align: center;"><b>Please confirm your information and when correct click the submit button</b></p></td></tr>
		 <tr><td class="table-form-label">* Company: </td>
		 <td>
<input  class="loginbox" type="text" name="company" value="'. $_REQUEST['company'].'" required="true" /></td></tr>					 
					 
<tr><td class="table-form-label">* E-Mail: </td><td>
<input class="loginbox" type="email" name="contactEmail" value="'. $_REQUEST['contactEmail'].'" required="true" readonly /></td></tr>

<tr><td class="table-form-label">* Number of Seats: </td><td>
<input class="loginbox" type="text" name="numberofseats" value="'. $_REQUEST['numberofseats'].'" required="true" /></td></tr>	

<input type="hidden" name="join_op" value="memnewcompany" />
	    	            <input type="hidden" name="generic_casevalue" value = "addseattocompany" /> 
	    	                <input type="hidden" name="actioncompany" value="5" /-->
	    	             <input type="hidden" name="generic_casevalue" value = "addnewuserandcompany" /> 
	    	             <input type="hidden" name="frompage" value="addnewuserandcompany" />
	    	             <input type="hidden" name="forthisamount" value="'.$forthisamount.'" />
	    	            

			 	    	<tr><td colspan="3">  
						<input type="hidden" name=" level" value="'.$_REQUEST['level'].'" />
	    	            <input type="hidden" name="level" value="'.$_REQUEST['level'].'" />
	    	            <input type="hidden" name="user_type"  value= "' . $_REQUEST['user_type'].'" />
	    	            <input type="hidden" name="ptype" value= "' .  $_REQUEST['ptype'] .'"/>
	    	            <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				        <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                    
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				        <input type="hidden" name="username" value="'.$generic_username . '"/>
				        <input type="hidden" name="usrCompanyID" value= "' .  $_REQUEST['usrCompanyID'] .'"/>
				        <input type="hidden" name="numseatsoccupied" value="1"/> ';

	                $content .=' </td></tr>
	                  
	               <tr> <td colspan="2"><center><input class="btn-prm" type="submit" value="Submit" /></center>
	    	</td></tr>
	    	</table> 
	        
            </form>  
            </div>';
             //$content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:660px;height:'.$halfheaderheight.'px;">&nbsp;</div>'; 
          
		     
          break;          
      }
      elseif ($_REQUEST['join_op']== "upgradelevelpay") //actioncompany = 4
       {
            
           $content .= '<!--br>trace   2024 Arrived at upgradelevelpay v2- here to do mock payment processing for updgrade level  table field, emp_level and inform user -.
         currentlevel: ' .$generic_level. ',  upgradetolevel: '.$_REQUEST['upgradetolevel']. '-->';
      $upgradetolevelmore = $_REQUEST['upgradetolevel'];
        		     
        		    $splitupgradetolevel= substr($upgradetolevelmore,0, 1);    //  ;
        		    $forthisamount  =   substr($upgradetolevelmore, -strlen($upgradetolevelmore)+2);  //     right($addnumseatsprice, strlen($addnumseatsprice)-3);
        		  
      
      
        $this_siverprice=0;
        /* $content .= '<br>trace this_siverprice =QV("SELECT total_price from price_table where subscription_level = 1 and num_seats = "'.$generic_numseats .'")';
        $this_siverprice = QV("SELECT total_price from price_table where subscription_level = 1 and num_seats = ".$generic_numseats . " ");  //plusone = $generic_level +1;
        $content .= '<!--br>trace 1601, generic_level: '. $generic_level.', this_siverprice: ' .$this_siverprice  ;
        $this_goldprice=0;
        $this_goldprice= QV("SELECT total_price from price_table where subscription_level = 2 and num_seats = ".$generic_numseats . " ");  //plusone = $generic_level +1;
          $content .= '<br>trace 1604 this_goldprice: ' . $this_goldprice;
          $deltaprice = $generic_numseats * 150;
         $this_platinum_price =  $this_goldprice + $deltaprice;
         $content .= '<br>trace 1606 this_platinum_price: '. $this_platinum_price;
         */
           $deltalevel = $splitupgradetolevel - $generic_level;
           $thisupgradetolevel = $splitupgradetolevel;
        /*if ( $_REQUEST['upgradetolevel'] ==2) 
         {
             $thischargeprice =$this_goldprice;
             
         } elseif  ($_REQUEST['upgradetolevel'] ==3)
         {
             $thischargeprice =$this_platinum_price;
         } else
         {
              $thischargeprice =$this_goldprice;
         } */
          $thischargeprice= $forthisamount; 
         $content .= '<!-- br>trace 1623 thischargeprice: '.  $thischargeprice .'.00 -->' ;
        //if ($generic_level == 1 ) && $_REQUEST['upgradetolevel']  upgradetolevel
        
 	switch ($_REQUEST['upgradetolevel'])
 			     {
 			         case 1:
 			           $upgradedesc = "Silver";
 			            //$levelcolor = "#f2f2f2";
 			             $upgradefgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $upgrade_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $upgradedesc = "Gold";
 			           $upgradecolor = "#FFD700";
 			            $upgradefgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $upgrade_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $upgradedesc = "Platinum";
 			             $upgrade_show_level ="Platinum";
 			             // $levelcolor 
 			              $upgradefgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $upgradedesc = "Titanium";
 			            $upgrade_show_level = "Titanium";
 			            // $levelcolor 
 			             $upgradefgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $upgradedesc = "Silver";
 			           $upgrade_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $upgradefgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }   
       	switch ($_REQUEST['level'])
 			     {
 			         case 1:
 			           //$upgradedesc = "Silver";
 			            $levelcolor = "#f2f2f2";
 			             $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $generic_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $leveldesc = "Gold";
 			           $upgradecolor = "#FFD700";
 			            $levelfgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $generic_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $leveldesc = "Platinum";
 			             $generic_show_level ="Platinum";
 			             // $levelcolor 
 			              $levelfgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $leveldesc = "Titanium";
 			            $generic_show_level = "Titanium";
 			            // $levelcolor 
 			             $levelfgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $leveldesc = "Silver";
 			           $generic_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $levelfgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }         	
 			             
      
       }elseif ($_REQUEST['join_op']== "addseatpay") //actioncompany = 3
        {
            $content .= '<!--br>trace   joinnow 2101 Arrived at addseatpay - here to do mock up of credit card payment  
            addnumseats= '.$_REQUEST['addnumseats'] .' the price: $'.$_REQUEST['theaddseatprice']. '-->';
       } else
       {   $content .= '<br>join now Error 1789- bad join_op value:'.$_REQUEST['join_op'];
           break;
       }
       
          
     //<span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.'</span>  
        /*  $content .= '  <div  style="background-color: #CFE8FF; margin:auto; border-radius: 20px 20px 1px 1px;width:660px;" align="center"> &nbsp;
           <br>';
      $content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	<div style="float:right">&nbsp;</div>
    		<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:center; "> ';
    		*/
     	 $pulled_company_name = QV("Select emp_name from emp where emp_id =".$generic_company_id."");
       	  $pulled_company_level = QV("Select emp_level from emp where emp_id =".$generic_company_id."");
        		  	 $content .= "<!--   br> trace 2131 query for pulled company name is: Select emp_name from emp where emp_id =".$generic_company_id." -->";
        		  	$content .= ' <br>   &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> ';
        		  	 if ($pulled_company_name)
        		  	 {
        		  	       	 $content .= '<!-- br>&nbsp;Hello '.$generic_username . '; your selected company is ' .$pulled_company_name. '.</span> -->';
        		  	 } else        
        		  	 {
        		  	 $content .= '<!--br>&nbsp;Hello '.$generic_username . '; your selected company is ' .$generic_company_name. '.</span -->';
        		  	 }
        		  	  if ($pulled_company_level)
        		  	 {
        		  	      	$addseatscompany_level = $pulled_company_level;
        		  	 } else        
        		  	 {
        		  	$addseatscompany_level =$generic_level;
        		  	 }	
  if ( ($addseatscompany_level < 2) && ($_REQUEST['join_op']== "addseatpay")) 
          	{   
          	     $addnumseatsprice = $_REQUEST['addnumseats'];
        		    $splitnumamount=  strtok( $addnumseatsprice,"$");
        		    $addthismanyseats= $splitnumamount[0];
        		    $forthisamount = $splitnumamount[1];
        		    $addthismanyseats= substr($addnumseatsprice,0, 2);    //left($addnumseatsprice,2);
        		    $forthisamount  =   substr($addnumseatsprice, -strlen($addnumseatsprice)+3);  //     right($addnumseatsprice, strlen($addnumseatsprice)-3);
        		    if( $addthismanyseats< 10)
        		      {
        		          $addthismanyseats = floor($addthismanyseats);
        		      }
          	    // $content .=  '<!--tr>   <td   colspan="3" style="text-align:center;"><b>Need to jump to bypass credit card processing</b> -->';
                       
header("Refresh:1; url=/".$_SESSION['env']."/joinnow.php?join_op=addseattocompany&generic_casevalue=addseattocompany&join_op_action=actionhub&generic_join_op_todo=addseattocompany&actioncompany=3&frompage=addseattocompany&forthisamount=".$forthisamount."&addthismanyseats=".$addthismanyseats."&numseatsoccupied=". $generic_numseatsoccupied."&company_id=".$generic_company_id."&company_name=".$generic_company_name."  ");

//$generic_company_name = $_REQUEST['company_name'];

//name="addthismanyseats" value="'.$addthismanyseats.
             break;
             }
     if ($_REQUEST['join_op']== "upgradelevelpay") //actioncompany = 4
        { 
          $content .= '  <div  style="background-color: #CFE8FF; margin:auto; border-radius: 20px 20px 1px 1px;width:660px;" align="center"> &nbsp;
           <br>';
         $content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	<div style="float:right">&nbsp;</div>
    		<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:center; "> ';
  
               
               $content .= '<br>&nbsp;Hello '.$generic_username . '; your selected company is ' .$generic_company_name. '.</span>
        	      <br>   &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> ';
        		 $content .= '<h3> Welcome to the Upgrade Company Subscription Level Payment Page </h3>
        	    
		          <br>Your company   subscription  at <span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.'</span> level
		          has '. $generic_numseats. ' seats .
		          <br><br>You have selected the option to upgrade from level <span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.'</span>  
		          to   <span style="background-color:'. $upgradefgcolor.';">' . $upgrade_show_level.'</span>   </span> ';
		          
	   	}
 
        if ($_REQUEST['join_op']== "addseatpay")  //f ($_REQUEST['join_op']== "upgradelevelpay") 
	        {
        	    $content .= '  <div  style="background-color: #CFE8FF; margin:auto; border-radius: 20px 20px 1px 1px;width:660px;" align="center"> &nbsp;
           <br>';
           $content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	<div style="float:right">&nbsp;</div>
    		<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:center; "> ';
  
        		    $addnumseatsprice = $_REQUEST['addnumseats'];
        		    $splitnumamount=  strtok( $addnumseatsprice,"$");
        		    $addthismanyseats= $splitnumamount[0];
        		    $forthisamount = $splitnumamount[1];
        		    $addthismanyseats= substr($addnumseatsprice,0, 2);    //left($addnumseatsprice,2);
        		    $forthisamount  =   substr($addnumseatsprice, -strlen($addnumseatsprice)+3);  //     right($addnumseatsprice, strlen($addnumseatsprice)-3);
        		    if( $addthismanyseats< 10)
        		      {
        		          $addthismanyseats = floor($addthismanyseats);
        		      }
        	         $content .=  '<!-- br> 2179 addthismanyseats: '.    $addthismanyseats. ', forthisamount: '. $forthisamount.' -->'; 
        		  	 $content .= '<h3> Welcome to the Add Seats to Subscription Payment Page </h3>';
        		  
        		  switch ($addseatscompany_level)
 			     {
 			         case 1:
 			           $upgradedesc = "Silver";
 			            //$levelcolor = "#f2f2f2";
 			             $upgradefgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $upgrade_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $upgradedesc = "Gold";
 			           $upgradecolor = "#FFD700";
 			            $upgradefgcolor = "#FFD700"; //  $subleveldesc = "Gold";
 			            $upgrade_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $upgradedesc = "Platinum";
 			             $upgrade_show_level ="Platinum";
 			             // $levelcolor 
 			              $upgradefgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $upgradedesc = "Titanium";
 			            $upgrade_show_level = "Titanium";
 			            // $levelcolor 
 			             $upgradefgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $upgradedesc = "Silver";
 			           $upgrade_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $upgradefgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }   
                    $content .=' <br> The company subscription level is <span style="background-color:'. $upgradefgcolor.';">' . $upgrade_show_level.'</span> ';
                 
        	      
        		  	  $content .= '<br><br> <span style="font-size:12px;font-family: arial;"> 
        		  	   <br> <br> &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
        		  	  Your company now has '. $generic_numseats . ' seats in your subscription with '. $generic_numseatsoccupied . ' occupied.</span>
        		  	  <br> &nbsp;<span style="font-size:14px;font-family: arial; font-family: arial;text-align:center;">
	              You have selected the option to add '. $addthismanyseats. ' seats to  the subscription.   </span> 
	             	 ';
	             	 	      /*   global  $addfiveprice,$addtenprice,$addfifteenprice,$addtwentyprice,  $addtwentyfiveprice,$addthirtyprice,$generic_numseats,$generic_level,$intmultfive,$eachaddprice;
     global $addfromoneprice,$addfromfiveprice,$addfromtenprice,$addfromfifteenprice,$addfromtwentyprice,$addfromtwentyfiveprice;
  */
      
       // addseatsprice();substr(string,start,length)  echo strpos("Hello world!", "world"); strlen()  strtok(string,split)
        	
        		 
		        $content .= ' <br> 
		      <br> <br> &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
		      </span> 
		      
		      <br> The price is $'.$forthisamount.'.00  <br> ';
            }  ////end if $_REQUEST['join_op']== "addseatpay")
    
      /////	 if ( (($addseatscompany_level >1) && ($_REQUEST['join_op']== "addseatpay"))   || ($_REQUEST['join_op']== "upgradelevelpay") )
	           
		       $content .= ' <br>Enter your credit card information, 
		         <!--  br>- your first name, last name address, card company, your number and security code,  -->
		       then click on the [SUBMIT] button 
		     <!-- br>	<span style="font-size: 12px; font- family: arial; "> 
	    
	    	    &nbsp;* - Starred (*) items are required. </span  -->
	    	     	 
         <table style="border:0px;" cellpadding="2" cellspacing="2">
	   		<tr><td style="text-align:right;">* First Name: </td><td style="width:220px;">
	   		 <input  style="width:220px;" type="text" name="fname" value="Mockup - Click Submit" /></td></tr> 
	   		 	<tr><td style="text-align:right;">* Last Name: </td><td style="width:220px;">
	   		 <input  style="width:220px;" type="text" name="lname" value="Mockup - Click Submit" /></td></tr> 
		  		<tr><td style="text-align:right;">* Street: </td><td style="width:220px;">
		  	 <input  style="width:220px;" type="text" name="street" value="Mockup - Click Submit" /></td></tr> 
	   		 	<tr><td style="text-align:right;">* City: </td><td style="width:220px;">
		  		 <input  style="width:220px;" type="text" name="city" value="Mockup - Click Submit" /></td></tr> 
		  	<tr><td style="text-align:right;">* State: </td><td style="width:220px;">
	   		 <input  style="width:220px;" type="text" name="state" value="Mockup - Click Submit" /></td></tr> 
		      	<tr><td style="text-align:right;">* ZIP: </td><td style="width:220px;">
	   		 <input  style="width:220px;" type="text" name="zip" value="Mockup - Click Submit" /></td></tr> 
		
		    
		    	<tr><td style="text-align:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;* Card Type: 	</td>
		    <td style="background-color:#ffffff;width:219px;text-align:left;"> 
		    	        	         &nbsp;<input type="radio"   name="creditcardtype" 	value="MC"    >Master Card
	    				    	<br> &nbsp;<input type="radio" name="creditcardtype" value="AM">American Express
	    				    	<br> &nbsp;<input type="radio" name="creditcardtype" value="VI">VISA 
	    		        		<br> &nbsp;<input type="radio"   name="creditcardtype" value="DS">Discovery
	    		 		    	<br> &nbsp;<input type="radio" name="creditcardtype" value="DC">Diners Club
	              </td></tr>
	              <tr><td style="text-align:right;"background-color:#ffffff;width:220px;">* Expiration Date: </td><td>&nbsp;</td></tr>
	             <tr><td>Month:</td> <td><input  style="width:220px;" type="text" name="expdatemon" value="MOCK-UP" /></td></tr>
	              <tr><td>&&Day:</td> <td><input  style="width:220px;" type="text" name="expdateday" value="JUST" /></td></tr>
	               <tr><td>&Year:</td> <td><input  style="width:220px;" type="text" name="expdateyear" value="HIT SUBMIT" /></td></tr>
	               <tr><td style="text-align:right;">* Card Number: </td> 
	                 <td style="width:220px;"> <input  style="width:220px;" type="text" name="company" value="Mockup - Click Submit" /> </td></tr>  
	    	       <tr><td style="text-align:right;">* Security Code: </td> 
	                 <td style="width:220px;"> <input  style="width:220px;" type="text" name="company" value="Mockup - Click Submit" /> </td></tr> ';
   
	    	         if ($_REQUEST['join_op']== "upgradelevelpay") //actioncompany = 4
	    	         { 
	    	           $content .='<input type="hidden" name="join_op" value="upgradelevelcompany" />
	    	            <input type="hidden" name="generic_join_op_todo" value="upgradelevelcompany" />
	    	            <input type="hidden" name = "thisupgradetolevel" value= "'.$thisupgradetolevel.'" />
	    	             <input type="hidden" name="actioncompany" value="4" /> 
	    	             <input type="hidden" name="generic_casevalue" value = "upgradelevelexistcompany" /> 
	    	              <input type="hidden" name="frompage" value="upgradelevelcompany" />
	    	            <input type="hidden" name="join_op_action" value="actionhub" />
	    	                    <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				              <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                     <input type="hidden" name="frompage" value="upgradelevelcompany" />
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				            <input type="hidden" name="username" value="'.$generic_username . '"/>
				             <input type="hidden" name="assignedusr_id" value="'.  $generic_assignedusr_id. '"/> 
				              <input type="hidden" name="numseats" value="'. $generic_numseats. '"/>  
				              <input type="hidden" name="numseatsoccupied" value="'. $generic_numseatsoccupied. '"/> 
				              <input type="hidden" name="usr_company" value="'.  $generic_company_id. '"/> 
				              <input type="hidden" name="company_id" value="'.  $generic_company_id. '"/> 
				              <input type="hidden" name="generic_casevalue" value = "upgradelevelexistcompany" /> 	';
	    	           } 
	    	            elseif ($_REQUEST['join_op']== "addseatpay")
	    	           {
	    	      /*   global  $addfiveprice,$addtenprice,$addfifteenprice,$addtwentyprice,  $addtwentyfiveprice,$addthirtyprice,$generic_numseats,$generic_level,$intmultfive,$eachaddprice;
     global $addfromoneprice,$addfromfiveprice,$addfromtenprice,$addfromfifteenprice,$addfromtwentyprice,$addfromtwentyfiveprice; addthismanyseats $addthismanyseats   forthisamount $forthisamount
  */
                  $content .='   <input type="hidden" name="join_op" value="addseattocompany" />
	    	            <input type="hidden" name="generic_casevalue" value = "addseattocompany" /> 
	    	            <input type="hidden" name="join_op_action" value="actionhub" />
	    	                <input type="hidden" name="actioncompany" value="3" />
	    	              	            <input type="hidden" name="generic_join_op_todo" value="addseattocompany" />
	    	             <input type="hidden" name="frompage" value="addseattocompany" />
	    	             <input type="hidden" name="forthisamount" value="'.$forthisamount.'" />
	    	             <input type="hidden" name="addthismanyseats" value="'.$addthismanyseats.'" /> 
	    	             <input type="hidden" name="current_level" value="'.$generic_level.'" />
	    	                
	    	                  <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				              <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                    
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				            <input type="hidden" name="username" value="'.$generic_username . '"/>
				             <input type="hidden" name="assignedusr_id" value="'.  $generic_assignedusr_id. '"/> 
				              <input type="hidden" name="numseats" value="'. $generic_numseats. '"/>  
				              <input type="hidden" name="numseatsoccupied" value="'. $generic_numseatsoccupied. '"/> 
	
				            
				              <input type="hidden" name="usr_company" value="'.  $generic_company_id. '"/> 
				              <input type="hidden" name="company_id" value="'.  $generic_company_id. '"/> ';
				      } 
				              
				             
	                $content .=' </td></tr> 
	               <tr>   <td   colspan="3" style="text-align:center;"><br><input type="submit" value="Submit" />';
	        
	    $content .='	</td></tr>
	    	</table> 
	        
            </form>  
            </div>';
    $content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:660px;height:'.$halfheaderheight.'px;">&nbsp;</div>'; 
 
  break;
   
   case "generic_login_try": 
       $content .= "<!--  br><br>trace: arrived at line 2383 generic_login_try at ". date('Y-m-d H:i:s');
        /// $_REQUEST['actioncompany'] ==3) || ($generic_actioncompany ==3))
        $content .= "<br>generic_company_id: ". $generic_company_id ." , generic_assignedusr_id: ". $generic_assignedusr_id.", generic_usr_firstname: ". $generic_usr_firstname    
	                .", generic_lastname: ". $generic_lastname.", generic_username: ". $generic_username .", generic_usr_auth: ". $generic_usr_auth  
				    .", generic_usr_type: ". $generic_usr_type.", generic_company_id: ". $generic_company_id.", generic_company_name: ". $generic_company_name
				    .", generic_level: ".     $generic_level.", generic_numseats: ".  $generic_numseats.", generic_numseatsoccupied: ". $generic_numseatsoccupied 
				    .", generic_actioncompany: ".  $generic_actioncompany 
				    .", generic_casevalue: " . $generic_casevalue
				    .",_REQUEST['actioncompany'] : ".$_REQUEST['actioncompany'] .", _REQUEST['password']: " .$_REQUEST['password'] 
				    .", _REQUEST['password_addseats']: ". $_REQUEST['password_addseats']; //addseats
	                     /* display login form                        set $genericfrompage to generic_login_try               *******                */       
              		$content .=	 ' ^^^^^^^^^^^^^^^^^^^^^^^^^^^ --> ';  
      	$headerheight ="80";	
       /* modify the below to reflect generic
                       
                   authenticate login for curent user - query db for usr_id with pword and usremp_emp_id = company_id (selected company)
                   if ok set loginauth = "ok"
                   if not show error and choice to return to action page or top of jonnow
                  extract username and password                   query usr with usrname and password
                  if no hit ::: error login unsuccessful                   _
                  |    error bad login 
                  |                                                                              |
                                                                                                 |
                        return admin_usr manageaccount or to generic joinnow [action page or joinnow top |
                  |__ 
                  else if login successful
                      go to joinnow with $frompage="j _loggedin"
                  break;
                        //  joinnow_loginfromaddnewuserexistco  $frompage="joinpage_actionhub";    //join_ op= "addnewuserexistcompany" and join_ptype" value="loginfromaddnewuserexistco"
                  
          */
                 // $sleeptime = 20;             // sleep(5);

     ////   $query = "SELECT * FROM usr usr  WHERE usr_email ='" . Clean($_REQUEST['username']) . "' AND usr_password = '" . sha1($_REQUEST['password']) . "'";
       	$genericquery = "SELECT usr.*,usemp.usremp_usr_assignedusr_id , e.emp_id,e.emp_name FROM usr usr 
       	inner join usr_emp usemp on usr.usr_id = usemp.usremp_usr_assignedusr_id inner join emp e on usemp.usremp_emp_id = emp_id ";
       	
       	//' ^^^^^^^^^^^^^^^^^^^^^^^^^^^ name="actioncompany" value="3"  sha1('1234') should be:da39a3ee5e6b4b0d3255bfef95601890afd80709--> '
       if (($_REQUEST['actioncompany'] ==3) || ($generic_actioncompany ==3))
       {
           $_SESSION['password_addseats'] = $_REQUEST['password_addseats'];
       	$genericquery .= "        	WHERE usr.usr_email ='" . Clean($generic_username) . "' AND usr.usr_password = '" . sha1($_REQUEST['password_addseats']) . "'
       	and e.emp_id= ".$generic_company_id. "";
       }elseif (($_REQUEST['actioncompany'] ==4) || ($generic_actioncompany ==4))
       {
           $_SESSION['password_upgradelevel'] = $_REQUEST['password_addseats'] ;  //$_REQUEST['password'];
       	$genericquery .= " 	WHERE usr.usr_email ='" . Clean($generic_username) . "' 
       	AND ((usr.usr_password = '" . sha1($_SESSION['password_upgradelevel']) . "' OR usr.usr_password = '" . sha1($_REQUEST['password_addseats']) . ") 
       	and e.emp_id= ".$generic_company_id. "";
       }
       else
      { 	$genericquery .=  "	WHERE usr.usr_email ='" . Clean($generic_username) . "' AND usr.usr_password = '" . sha1($_REQUEST['password']) . "' 
        	and e.emp_id= ".$generic_company_id. "";
      }
         	  $content .= '<!-- sha1(1234) should be:da39a3ee5e6b4b0d3255bfef95601890afd80709 
         	  line 2333 $_REQUEST[actioncompany] ' .$_REQUEST['actioncompany']. 'generic_actioncompany: '.$generic_actioncompany  
         	  . ' &nbsp; -----  generic login first query'.	$genericquery . ' _REQUEST[password_addseats ' .$_REQUEST['password_addseats']. ' -->';
         	 
              $genericresult=mysqli_query($conn, $genericquery) ;
              $content .= '<!-- genericresult: ' . $genericresult . ', genericquery: '. $genericquery;
   	         if   ($genericresult )   //1
	          {
		    	if  (mysqli_num_rows($genericresult)== 0)  //2
	           {   // login failed --show another login in form
		         $_Session['joinnow_logins'] = $_Session['joinnow_logins'] + 1;
		         $content .= '	<div style="font-size: 16px; font-family: arial; text-align:center; "> 
                 <table width="600" align="center">
                 <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;">
                            Login for ' . $_REQUEST['username']. ' failed. 
                </td> </tr>            
                   <tr> <td align="center" width="600" colspan="1" height="'.$headerheight.'" style="background-color: #dddddd; " >
                            <br>';
                    $UseHREFreqs = '?join_op='.$generic_casevalue.'&join_ptype=havecofor'.$generic_casevalue.'';
                    $UseHREFreqs .= '&company_id='.$generic_company_id .'' ;
                    $UseHREFreqs .= '&company_name='.$generic_company_name.'&username='. $generic_username.'&contactEmail='. $generic_username;                    // $UseHREFreqs .= '&attemptnewthere='. $_REQUEST['new_contactEmail'].'';
                    if ($_SESSION['holdfrompage'] ==    "manageaccount")
                    {                         //  '&empid='.$userCompany.'   $userID  
                         $userCompany =$_SESSION['adminnuserCompany'];
                      $userID = $_SESSION['adminnnuserID'];
                      unset($_SESSION['adminnnuserID'] );// = '';
                         unset($_SESSION['adminnuserCompany']) ;
                     //// $content .= '<a href="admin_usr.php?usr='.$generic_assignedusr_id.'&ptype=admin">Return to Manage Account </a>';   
                        $content .= '<a href="admin_usr.php?usr='.$userID.'&empid='.$userCompany.'&ptype=admin">Return to Manage Account </a>';
                    }else
                    {
                      $content .= '  <a href="'.$_SERVER['PHP_SELF'].$UseHREFreqs.'">Return to Join Now Action Page </a>
                            <br>
                              OR
                             <br>
                             <a href ="'.$_SERVER['PHP_SELF'].'">Return to BC2Match Join Now Home Page </a>';
                    }
                     $content .= '  <!-- ?/div  -->
                            </td><tr>
               <tr> <td align="center" width="600" colspan="3" height="40" style="background-color: #9fcfff;  border-radius: 1px 1px 20px 20px;">';
              
		  	     $content .= '<table align="center" width="780">
 		           
 		         </tr></td></table>';
 		       ////   <!-- SESSION[usr_auth]: '.  $_SESSION['usr_auth'].', sess comdash_exists: ' .$_SESSION['$comdash_exists'] . 
 		       ////, my_pagename: ' .  basename($_SERVER['PHP_SELF']) . ' --> Session[ joinnow_logins ]: ' .$_Session['joinnow_logins']. 
 		        
	        } 
	        else {
	            // login successful'  now show add new user form
	            if ( $generic_actioncompany ==3 ) 
	               {
	                   $thisgeneric_action = "add seats";
	               } 
	               elseif   ( $generic_actioncompany ==   4)
	               {
	                    $thisgeneric_action = "upgrade level";
	               } 
	               else
	               {
	                    $thisgeneric_action = "Error not add seats or upgrade level";
	               }
	        }
	          }
        // break;

     
     case "upgradelevelexistcompany": case "addseatexistcompany":
      if ( $generic_actioncompany ==3 ) 
	      {
       $content .= '<!-- br>line 1691trace Arrived at  addseatexistcompany - here to actually show add seats form company table field emp_number_seats and inform user-->';
         } //
     if   ( $generic_actioncompany ==   4)
	         {
	          $content .= '<!-- br>trace line 1694 Arrived at upgradelevelexistcompany - here to show form update company table field, emp_level and inform user.-->';
        
               }

        
		$content .='<!-- !  br>|_|frompage: ' . $_REQUEST['frompage']  . ' req ptype:'.$_REQUEST['ptype'] .' --> '; // return to admin_usr with joinnowRC = "ok" if ok , "fail" if fail
        if ($_REQUEST['frompage']=="manageaccount")
       {
            $_SESSION['holdfrompage'] = "manageaccount";
                 $usethisfrompage = $_REQUEST['frompage'];
           $generic_company_id = @$_REQUEST['generic_company_id'];
        $generic_join_op = @$_REQUEST['join_op'] ;
        $generic_frompage =   @$_REQUEST['frompage'] ;
        $generic_ptype  =    @$_REQUEST['ptype'];
 
        $generic_assignedusr_id = @$_REQUEST['generic_assignedusr_id'];
         $generic_username = @$_REQUEST['generic_username']; 
         $generic_usr_firstname=  @$_REQUEST['generic_usr_firstname'];
         $generic_lastname =  @$_REQUEST['generic_lastname'];
         $generic_company_name =  @$_REQUEST['generic_companyname'];
         $generic_level  =  @$_REQUEST['generic_level'];
         $generic_usr_type = $_SESSION['usr_type'];
         $generic_numseats =  @$_REQUEST['generic_numseats'];
          $generic_numseatsoccupied  =  @$_REQUEST['generic_numseatsoccupied']; 
         $generic_actioncompany =  @$_REQUEST['generic_actioncompany'];
       }
     case "generic_manageaccount_seatsorlevel" :            case "generic_loggedin": 
              $content .= '<!-- by the time arrive here either from self: join now or from manage account:admin_usr - the user has been logged in
	       so after some house keeping, just have 2 cases  case show add-seat or upgrade form and  case add the  seat. ';  
	            $content .= "<br> either came from manageaccount in admin_usr or was o know came from manage accountTO THE ADD SEATS OR UPGRADE LEVEL FORM --> ";
     
      $content .="<!-- br>trace at 1737 in case: generic_manageaccount_seatsorlevel or generic_loggedin or upgradelevelexistcompany or addseatexistcompany
      $frompage: " . $_REQUEST['frompage'] . " maybe from addmin_usr if from manageaount";
       $content .= "<br>generic_company_id: ". $generic_company_id ." , generic_assignedusr_id: ". $generic_assignedusr_id.", generic_usr_firstname: ". $generic_usr_firstname    
	                ."<br>, generic_lastname: ". $generic_lastname.", generic_username: ". $generic_username .", generic_usr_auth: ". $generic_usr_auth  
				    .",<br> generic_usr_type: ". $generic_usr_type.", generic_company_id: ". $generic_company_id.", generic_company_name: ". $generic_company_name
				    .",<br> generic_level: ".     $generic_level.", generic_numseats: ".  $generic_numseats.", generic_numseatsoccupied: ". $generic_numseatsoccupied 
				    ."<br>, generic_actioncompany: ".  $generic_actioncompany ." --> " ; //addseats or upgrade level
      
                     
				switch ($generic_level)
 			     {
 			         case 1:
 			           $subleveldesc = "Silver";
 			            //$levelcolor = "#f2f2f2";
 			             $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
 			              $generic_show_level = "Silver"; 
 			           break;
 			         case 2:   
 			          $subleveldesc = "Gold";
 			           $goldlevelcolor = "#FFD700";
 			            $levelfgcolor = "#FFD700";
 			            $generic_show_level = "Gold"; 
 			          break;
 			         case 3:
 			             $subleveldesc = "Platinum";
 			             $generic_show_level ="Platinum";
 			             // $levelcolor 
 			              $levelfgcolor = "#F4F4F4";   // White Smile
 			             break;
 			         case 4 :
 			            $subleveldesc = "Titanium";
 			            $generic_show_level = "Titanium";
 			            // $levelcolor 
 			             $levelfgcolor = "#F6F6F6";  // Snow  not Ghost White
 			            break;
 			        default:
 			            ////$linkbgcolor  $levelfgcolor
 			           $subleveldesc = "Silver";
 			           $generic_show_level = "Unknown";
 			          //  $levelcolor $generic_show_level = Gold  
 			            $levelfgcolor  = "#f2f2f2"; // "#f5f5f5";
 			           break;  
 			         
 			     }      
 			       $silverlevelcolor = "#f2f2f2";
 			           $goldlevelcolor = "#FFD700";
 			             $platinumlevelcolor ="#F4F4F4"; 
			 
                     // show add seats form 	addseattocompany
                // get pricing info
       $pricequery="SELECT * FROM `price_table` where subscription_level = 1 order by subscription_level, num_seats ";   
               
                 
                  
            /*
            SELECT MAX(subscription_level) as maxlevel,MIN(subscription_level) as minlevel 
FROM `price_table`;
SELECT subscription_level,sub_level_desc,num_seats,added_price_per_seat,total_price,average_tix,diff,AVE_DIFF

FROM `price_table` order by subscription_level, num_seats */
 $levelquery = " SELECT MAX(subscription_level) as maxlevel,MIN(subscription_level) as minlevel FROM price_table ";
 $maxlevel =  QV($levelquery) ; // if ( $subscriptionlevel < $maxlevel)
    $content .= '<!-- br> TRACE line 1825 maxlevel: '.$maxlevel.' -->';
    
$currenttotalprice = QV("SELECT total_price from price_table where subscription_level = ".$generic_level." and num_seats = ".$generic_numseats . " "); //plusone = $generic_level +1;
// for now hardcode the prices
$currentpricesilver = 0;  //per seat
$generic_levelplusone = $generic_level +1;
$generic_levelplustwo = $genericlevel + 2;
 
   $currentpriceplusgold = QV("SELECT total_price from price_table where subscription_level = 2 and num_seats = ".$generic_numseats . " "); //plusone = $generic_level +1;
 
       $currentpriceplusplatinum = $currentpriceplusgold  +  $generic_numseats   * 150 ;
    // for now lloyd - assume platinum is 150 $ more per seat
  

$currentprice = QV("SELECT total_price from price_table 	where subscription_level =$generic_level and num_seats = ".$generic_numseats . " "); 
	    $content .=   '<!--br> line 1856 add seat or upgrade form; currentprice: $'. $currentprice . '.00 for '. $generic_numseats . ' seats at current level '. $generic_show_level.'-->';


	   // $content
	    if ( $generic_actioncompany==4)
                  {  
	        $content .= '  <div  style="background-color: #CFE8FF; margin:auto; border-radius: 20px 20px 1px 1px;width:660px;" align="center"> &nbsp;
           <br>';
	    
	    /*	<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:left; ">  
    		    <br>&nbsp;You are logged in as '.$generic_username . '; your selected company is ' .$generic_company_name. '.</span>
		     <br> <br> &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:left;"> 
		     Enter information requested below to add one or more new seats to the company.   </span> 
		     <br> You now have '. $generic_numseats . ' seats in your subscrption with '. $generic_numseatsoccupied . ' occupied
		     <br> Your company is at subscription level <span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.'</span>   
	    	     <br>	<span style="font-size: 12px; font- family: arial; "> 
	    	    &nbsp;* - Starred (*) items are required. </span>
	    	     	</div>tr><td>  <input type="hidden" name="join_op" value="addseattocompany" />
	    	            <input type="hidden" name="join_op_action" value="actionhub" />
	    	                <input type="hidden" name="actioncompany" value="3" />
	    	                $generic_casevalue = "addseattocompany";
	                     <input type="hidden" name="frompage" value="addseattoexistcompany" />
	    	     	
	    	     	*/ 
			$content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	<div style="float:right">&nbsp;</div>
    		<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:center; "> ';
  	
    		$content .= '<h3> Welcome to the Upgrade Company Subscription Level Selection Page</h3>
    		    <br>&nbsp;Hello '.$generic_username . '; your selected company is ' .$generic_company_name. '.</span>
		    
		     <br> 
		       <br>Your company   subscription  at <span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.'</span> level
		          has '. $generic_numseats. ' seats 
		     with
		  '. $generic_numseatsoccupied . ' occupied</span> .';
		     $this_siverprice=0;
         $content .= '<!-- br>trace this_siverprice =QV("SELECT total_price from price_table where subscription_level = 1 and num_seats = "'.$generic_numseats .'") -->';
        $this_siverprice = QV("SELECT total_price from price_table where subscription_level = 1 and num_seats = ".$generic_numseats . " ");  //plusone = $generic_level +1;
        $content .= '<!--br>trace 1601, generic_level: '. $generic_level.', this_siverprice: ' .$this_siverprice .'-->';
        $this_goldprice=0;
             $content .= '<!-- br>trace this_goldprice =QV("SELECT total_price from price_table where subscription_level = 2 and num_seats = ".$generic_numseats .") -->';
      if (($generic_numseats == 5 || ($generic_numseats % 10 ==0)))  //x % $y;
      {
              $this_goldprice= QV("SELECT added_price_per_seat from price_table where subscription_level = 2 and num_seats = ".$generic_numseats . " ");  //plusone = $generic_level +1;
    
      }else{
       
       $this_goldprice= QV("SELECT total_price from price_table where subscription_level = 2 and num_seats = ".$generic_numseats . " ");  //plusone = $generic_level +1;
       }
       $content .= '<!--br>trace 1604 this_goldprice: ' . $this_goldprice .'-->';
          $deltaprice = $generic_numseats * 150;
         $this_platinum_price =  $this_goldprice + $deltaprice;
         $content .= '<!--br>trace 1606 this_platinum_price: '. $this_platinum_price .'-->';
           $deltalevel = $_REQUEST['upgradetolevel'] - $generic_level;
           $thisupgradetolevel = $_REQUEST['upgradetolevel'];
        if ( $_REQUEST['upgradetolevel'] ==2) 
         {
             $thischargeprice =$this_goldprice;
             
         } elseif  ($_REQUEST['upgradetolevel'] ==3)
         {
             $thischargeprice =$this_platinum_price;
         } else
         {
              $thischargeprice =$this_goldprice;
         }
         $content .= '<!-- br>trace 1623 thischargeprice: '.  $thischargeprice .'.00 -->' ;
		    
		   $content .= ' <br><br>
		      <br> <br> &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
		     Click the circular button below to upgrade the <strong>subscription </strong>to the desired level.   </span> 
		    <br> Then click on the submit button 
		     <!-- br>	<span style="font-size: 12px; font- family: arial; "> 
	    
	    	    &nbsp;* - Starred (*) items are required. </span  -->
	    	     	</div> 
	    <table style="border:0px;" cellpadding="2" cellspacing="2">
	   	<!-- tr><td style="text-align:right;">  Company Name: </td><td  > '.$generic_company_name . '</td></tr> 
	   	<tr><td style="text-align:right;"> Your E-Mail: </td><td> '. $generic_username.'</td></tr -->
	   		<tr><td style="text-align:right;"> Subscription </td><td> 	  	            Level </td><td>Price</td></tr>
	     
	  	<tr><td style="text-align:right;"> Current:</td><td>
	  	            <span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.'</span> </td><td>$'.$this_siverprice.'.00</td></tr>
	     <tr><td style="text-align:right;"> Available: </td><td> &nbsp; </td><td>&nbsp;   </td></tr> 
	      
	  	<tr><td style="text-align:right;">&nbsp; </td>
	       	<td><input type="radio" name="upgradetolevel" value="2$'.$this_goldprice.'"/> <span style="background-color:'. $goldlevelcolor.';">  Gold</span> </td><td> $'.$this_goldprice.'.00 </td></tr>
	  	<tr><td style="text-align:right;">&nbsp; </td>
	  	  <!--  <td><input type="radio" name="upgradetolevel" value="3$'.$this_platinum_price.'" /> <span style="background-color:'. $platinumlevelcolor.';">  Platinum</span></td><td> $'.$this_platinum_price.'.00 </td></tr>
	     -->	           	 
	    	           	 <tr><td colspan="3">  <input type="hidden" name="level" value="'.$generic_level.'" />
	    	             <input type="hidden" name="join_op" value="upgradelevelpay" />
	    	            <input type="hidden" name="join_op_action" value="actionhub" />
	    	            <input type="hidden" name="generic_join_op_todo" value="upgradelevelpay" />
	    	                <input type="hidden" name="actioncompany" value="4" />	
	    	                  <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				              <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                     <input type="hidden" name="frompage" value="upgradelevelpay" />
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				            <input type="hidden" name="username" value="'.$generic_username . '"/>
				             <input type="hidden" name="assignedusr_id" value="'.  $generic_assignedusr_id. '"/> 
				                			              <input type="hidden" name="numseats" value="'. $generic_numseats. '"/>  
				              <input type="hidden" name="numseatsoccupied" value="'. $generic_numseatsoccupied. '"/> 
	
				              <input type="hidden" name="usr_company" value="'.  $generic_company_id. '"/> 
				              <input type="hidden" name="company_id" value="'.  $generic_company_id. '"/> 
				              
				              <input type="hidden" name="generic_casevalue" value = "upgradelevelexistcompany" /> 
	                 </td></tr>
	                  
	               <tr>   <td   colspan="3" style="text-align:center;"><br><input type="submit" value="Submit" />
	    	</td></tr>
	    	</table> 
	        
            </form> ';
             $content .= ' </div>';
             $content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:660px;height:'.$halfheaderheight.'px;">&nbsp;</div>'; 
  
         	 }else  // 3 add seats
		    {
		        
	$content.= '<!--br> <span style="font-size:12px;font-family: arial;">trace 2224 on the else clause of action type: '.$generic_actioncompany. 
	' in case "upgradelevelexistcompany": case "addseatexistcompany":</span> -->';	        
/*	        $addfiveprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = ".$generic_numseats . " ");
$addtenprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = ".$generic_numseats . " ");
$addtwentyprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = ".$generic_numseats . " ");

$x = 7;
$y = 2;
$result = fmod($x,$y);
// $result equals 1, because 2 * 3 + 1 = 7 
intdiv ( int $dividend , int $divisor ) : int
Returns the integer quotient of the division of dividend by divisor.
*/
   addseatsprice();
/*$intmultfive=floor ( $generic_numseats/ 5);   // intdiv( $generic_numseats,  5) isnot valid;
 switch ($generic_numseats)
 { 
    case 0:
     $eachaddprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 2");
    
     case 1:
     $eachaddprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 6");
     break;
      case 2:
     $eachaddprice =QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 11 ");
     break;
      case 5:
     $eachaddprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 21 ");
     break;
     default:
         $eachaddprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 2");
         break;
 }
 */
  $content .= '  <div  style="background-color: #CFE8FF; margin:auto; border-radius: 20px 20px 1px 1px;width:660px;" align="center"> &nbsp;
           <br>';
	    
	    /*		*/ 
			$content .= '<form method="post"  action="'.$_SERVER['PHP_SELF'].'">          
	        <!-- div style="background:#CFE8FF;border-radius:10px;margin:auto;padding:20px;width:600px;"  -->
	    	<div style="float:right">&nbsp;</div>
    		<div style="font-size: 14px; font-family: arial; font-family: arial;text-align:center; "> ';
		       $content .= ' <h3> Welcome to the Add Seats to the Company Subscription Selection Page</h3>';
		       
		       /*  change below ####[]*/
		       	  	 $pulled_company_name = QV("Select emp_name from emp where emp_id =".$generic_company_id."");
        		  	 $content .= "<!-- br> trace 2671 query for pulled company name is: Select emp_name from emp where emp_id =".$generic_company_id." -->";
        		  	$content .= ' <br>   &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> ';
        		  	 if ($pulled_company_name)
        		  	 {
        		  	       	 $content .= '<br>&nbsp;Hello '.$generic_username . '; your selected company is ' .$pulled_company_name. '.</span>';
        		
        		  	 } else        
        		  	 {		       	$content .= '
    		    <br>&nbsp;Hello '.$generic_username . '; your selected company is ' .$generic_company_name. '.</span>
		    <br> <span style="font-size:16px;font-family: arial;"> 
		    You now have '. $generic_numseats . ' seats in your subscrption with '  . $generic_numseatsoccupied . ' occupied.</span>  ';
		    }
		    $content .= '<br> <span style="font-size:12px;font-family: arial;">
		     (Your company is at subscription level <span style="background-color:'. $levelfgcolor.';">' . $generic_show_level.')</span> 
		    <br>';
		     $content .= ' <br> <span style="font-size:16px;font-family: arial;"> The current list price for your subscription level and number of seats is $'.$currentprice.'.00</span>';
		/*
		  global  $addfiveprice,$addtenprice,$addtwentyprice, $generic_numseats,$generic_level,$intmultfive,$eachaddprice;
     global $addfromoneprice,$addfromfiveprice,$addfromtenprice,$addfromtwentyprice;
       global  $addfiveprice,$addtenprice,$addtwentyprice, $generic_numseats,$generic_level,$intmultfive,$eachaddprice;
     global $addfromoneprice,$addfromfiveprice,,$addfromfifteenprice,$addfromtwentyprice,$addfromtwentyfiveprice;$addfifteenprice,$addtwentyprice,  $addtwentyfiveprice
   $addfromtenprice
  */   
  $twotimeseachdadd = 2*$eachaddprice;
  $threetimeseachdadd = 3*$eachaddprice;
  $fourtimeseachdadd = 4*$eachaddprice;
  
 	   $content .= '
		      <br> <br> &nbsp;<span style="font-size:16px;font-family: arial; font-family: arial;text-align:center;"> 
		     Click a radio button below to select the <strong>desired number of seats </strong>to add.    
		    <br> Then click on the submit button </span>
		    
	    	     	</div> 
	    <table style="border:0px;" cellpadding="4" cellspacing="3">
	   	 
	    <tr><td style="text-align:right;"> &nbsp; </td><td> &nbsp; </td><td>&nbsp;   </td></tr> 
	 	<tr><td style="text-align:right;"> Add Seats </td><td> 	  	            Number </td><td>Incremental Price</td></tr>
        <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="01$'.$eachaddprice.'"/> &nbsp;1 </td> <td align="right">$'.$eachaddprice.'.00    </td></tr>
 	    <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="02$'.$twotimeseachdadd.'"/> &nbsp;2 </td> <td align="right">$'. $twotimeseachdadd.'.00</td></tr>
       <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="03$'. $threetimeseachdadd.'"/> &nbsp;3 </td> <td align="right">$'.$threetimeseachdadd.'.00</td></tr>
    <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="04$'. $fourtimeseachdadd.'"/> &nbsp;4 </td> <td align="right">$'. $fourtimeseachdadd.'.00</td></tr>
  <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="05$'. $addfiveprice.'"/> &nbsp;5 </td> <td align="right">$'. $addfiveprice.'.00</td></tr>
 		         	    <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="10$'. $addtenprice.'"/> 10 </td> <td align="right">$'. $addtenprice.'.00</td></tr>	    
  
  <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="15$'. $addfifteenprice.'"/> 15 </td> <td align="right">$'. $addfifteenprice.'.00</td></tr>	    

        <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="20$'. $addtwentyprice.'"/> 20 </td> <td align="right">$'. $addtwentyprice.'.00</td></tr>	    
 	    <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="25$'.  $addtwentyfiveprice.'"/> 25 </td> <td align="right">$'.  $addtwentyfiveprice.'.00</td></tr>	    
   	    <tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="30$'.  $addthirtyprice.'"/> 30 </td> <td align="right">$'.  $addthirtyprice.'.00</td></tr>	    


	    <!--tr><td style="text-align:right;"> &nbsp; </td> <td align="right"><input type="radio" name="addnumseats" value="-99"/>&nbsp; &nbsp;&nbsp;  </td> <td align="right">Enter number<br> Price calculates<br> after click submit
	    </td></tr -->	    
	            
	                                                              <!-- will need a java script to show the other amount above on this page-->                                
	      <!-- <td><input type="radio" name="addnumseats" value="1"/>
	  	<tr><td style="text-align:right;">&nbsp; </td>
	       	<td><input type="radio" name="upgradetolevel" value="2"> <span style="background-color:'. $goldlevelcolor.';">  Gold</span> </td><td> $ </td></tr>
	  	<tr><td style="text-align:right;">&nbsp; </td>
	  	    <td><input type="radio" name="upgradetolevel" value="3"> <span style="background-color:'. $platinumlevelcolor.';">  Platinum</span></td><td> $ </td></tr>
	  	    -->';
		     
		        $content .= '   
		         <tr><td colspan="3">  <input type="hidden" name="level" value="'.$generic_level.'" />
	    	             <input type="hidden" name="join_op" value="addseatpay" />
	    	            <input type="hidden" name="join_op_action" value="actionhub" />
	    	            <input type="hidden" name="generic_join_op_todo" value="addseatpay" />
	    	                <input type="hidden" name="actioncompany" value="3" />	
	    	                  <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />
				              <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
	                     <input type="hidden" name="frompage" value="addseatpay" />
	    	            <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				            <input type="hidden" name="username" value="'.$generic_username . '"/>
				             <input type="hidden" name="assignedusr_id" value="'.  $generic_assignedusr_id. '"/> 
				             			              <input type="hidden" name="numseats" value="'. $generic_numseats. '"/>  
				              <input type="hidden" name="numseatsoccupied" value="'. $generic_numseatsoccupied. '"/> 
				            
				              <input type="hidden" name="usr_company" value="'.   $generic_company_id. '"/> 
				              <input type="hidden" name="company_id" value="'.   $generic_company_id. '"/> 
				              
				              <input type="hidden" name="generic_casevalue" value = "addseattoexistcompany" /> 
	                 </td></tr>
	                  
	               <tr>   <td   colspan="3" style="text-align:center;"><br><input type="submit" value="Submit" />
	    	</td></tr>
	    	</table> 
	        
            </form> ';
            $content .= ' </div>';
             $content .= '  <div  style="background-color: #CFE8FF;margin:auto;border-radius: 1px 1px 20px 20px;width:660px;height:'.$halfheaderheight.'px;">&nbsp;</div>'; 
  
		    }  

                                  
                      // error return with error 
                  
	            break;
	    
   case "generic_login_form":
            $_SESSION[holdfrompage] = '';
         $content .= "<!--br><br>trace: arrived at generic_login_form at ". date('Y-m-d H:i:s');
         $content .= "<br> trace if SESSION[holdfrompage] ==manageaccount: ". $_SESSION['holdfrompage'] . " came from admin_usr.php -->";
    //     	 $upgradelevellocationhref=$locationhref.'"joinnow.php?join_op=upgradelevelexistcompany&frompage=manageaccount&upgradelevel_company_id='.$userCompany.'&upgradelevel_assignedusr_id='.$ut['usr_id'].'&upgradelevel_username='.$ut['usr_email'] .'"'  ;

          $content .= "<!-- br>generic_company_id: ". $generic_company_id ." , generic_assignedusr_id: ". $generic_assignedusr_id.", generic_usr_firstname: ". $generic_usr_firstname    
	                .", generic_lastname: ". $generic_lastname.", generic_username: ". $generic_username .", generic_usr_auth: ". $generic_usr_auth  
				    .", generic_usr_type: ". $generic_usr_type.", generic_company_id: ". $generic_company_id.", generic_company_name: ". $generic_company_name
				    .", generic_level: ".     $generic_level.", generic_numseats: ".  $generic_numseats.", generic_numseatsoccupied: ". $generic_numseatsoccupied 
				    .", generic_actioncompany: ".  $generic_actioncompany  ; //addseats
	                     /* display login form                        set $genericfrompage to generic_logging_in                *******                */       
              		$content .=	 ' <!-- ^^^^^^^^^^^^^^^^^^^^^^^^^^^ name="actioncompany" value="3"--> ';  
      	$headerheight ="80";		
 	 $strcompanyname = str_replace("AND", "&", $generic_company_name ,  $cocount);
 	 $generic_join_op_todo = "generic_login_try";
  	$content .= '<table align="center" width="700"> <tbody>
      	<tr> <td align="center" width="100%" colspan="1" height="'.$headerheight.'" style="background-color: #9fcfff;  border-radius: 20px 20px 1px 1px;"><strong>Here to Login to Your Company - 3</strong>'; 
       $content .=  '<br/>'. $generic_username. ', Login to to the company you selected: '.$strcompanyname . '
                     <br/> </td></tr> 
                    <tr><td style="background-color:#dddddd; height:80px;">
              <strong> Login here: </strong>  <br> 	
              <form action="'.$_SERVER['PHP_SELF'].'/index.php" method="post"  > 
		          <table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink" style="margin-top:40px;">Forgot your password?  </a>
				</td><td>
				<label class="loginlabel"> Email:</label>
			<input class="loginbox" style="display:inline;width:180px;" type="text" maxlength="40" size="24"  value="'.$generic_username .'" id="username" name="username" title="Email(User Name)" />
				</td><td>&nbsp; </td> <td><label class="loginlabel" style="display:inline;"> Password:</label>';
			$content .= '
				 					<input class="loginbox" style="display:inline;" type="password" maxlength="40" size="24" id="password" name="password_addseats" title="Password" />
				  </td><td>&nbsp; </td> <td> <label class="loginlabel" style="display:inline;">Company:</label>
				  <input class="loginbox" style="display:inline;width:180px;" type="text" maxlength="40" size="24"  value="'.$generic_company_name .'" id="companyname" name="companyname" title="Company" />
					                              
				</td><td>  		
				
				           <input type="hidden" name="generic_join_op_todo" value="'.$generic_join_op_todo .'"/>
				           <input type="hidden" name="join_op_action" value= "actionhub"/>     <!--$reqjoin_op_action) * -->
				   <input type="hidden" name=join_ptype" value="loginfrom'.$generic_join_op_todo .'"/>
				   <input type="hidden" name="frompage" value="generic_login_try"/>
				            <input type="hidden" name="actioncompany" value="'.$generic_actioncompany.'" />
				           <input type="hidden" name="company_id" value="'.$generic_company_id .'"/>
				           <input type="hidden" name="company_name" value="'.$generic_company_name .'"/>
				           <input type="hidden" name="generic_frompage" value="'.$generic_frompage.'" />  <!--joinpage_actionhub -->
				              <input type="hidden" name="generic_actioncompany" value="'.$generic_actioncompany.'" />
				             <input type="hidden" name="assignedusr_id" value="'.  $generic_assignedusr_id. '"/> 
				             
				               <input type="hidden" name="usr_firstname" value="'. $generic_usr_firstname. '"/> 
				              <input type="hidden" name="lastname" value="'.  $generic_lastname . '"/> 
				              <input type="hidden" name="usr_auth" value="'.  $generic_usr_auth . '"/> 
				              <input type="hidden" name="usr_type" value="'. $generic_usr_type . '"/> 
				              <input type="hidden" name="usr_company" value="'.  $generic_company_id. '"/> 
				               <input type="hidden" name="username" value="'. $generic_username. '"/>   <!--?? $ addnewuser_username -->
				                  <input type="hidden"   name="numseats" value="'.$generic_numseats.'"/> 
	    		                   <input type="hidden"   name="numseatsoccupied" value="'.$generic_numseatsoccupied. '"/> 
	    		                    <input type="hidden"   name="level" value="'.$generic_level.'"/>         <!-- = REQUEST[level];  -->    
			          
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		</form><br/>
		         
		   </td></tr> </tbody></table></td></tr></tbody></table> ';                   
	                          
	                       
	                        
				            
				            
				          
				                   
				               
				       
				      
         break;
   default:
		   $_Session['joinnow_logins']= 0;
		//////	$content .= D B Content();'.D B Content('','Application Form').'
			$content .= '<form method="post" action="'.$_SERVER['PHP_SELF'].'"   >          
	<div style="background:#CFE8FF;border-radius:10px;margin:20px;padding:20px;">
		<div style="float:right"> </div>
		<div style=" 	font-size: 16px; font-family: arial; "> 
		 <br>  Welcome to BC2Match Join Now! <br> To add User or Company <br><br>Enter   User E-mail to use <br> </div>
		<br>
		<table style="border:0px;" cellpadding="0" cellspacing="0">
	         
		<tr><td style="text-align:right;">* E-Mail: </td><td><input type="text"style="width:200px;" name="contactEmail" value="" /></td></tr>
	      	<tr><td style="text-align:right;" colspan="2"> <br>  &nbsp;</td></tr>                                                            
	  	<tr><td style="text-align:right;">
		<input type="hidden" name="join_op"  value="startNewEmployer" /> </td>
		<input type="hidden" name="op"  value="ignore" /> </td>
		<td> 
		<input type="submit" value="Submit E-Mail" />
		</td></tr>
			</table>  
  	</div>
    </form>
   </div>';   ///end 4
	break;
	///////  
	
$content .= '  </div></div> </div></div>' ;
 //$footerscript = '';
///////3	
}
function addseatsprice()
{
     global  $addfiveprice,$addtenprice,$addfifteenprice,$addtwentyprice,  $addtwentyfiveprice,$addthirtyprice,$generic_numseats,$generic_level,$intmultfive,$eachaddprice;
     global $addfromoneprice,$addfromfiveprice,$addfromtenprice,$addfromfifteenprice,$addfromtwentyprice,$addfromtwentyfiveprice;
     global $content;
     $addfiveprice =  QV ("SELECT  added_price_per_seat from price_table where subscription_level =".$generic_level." and num_seats = 5 ");

  $addtenprice   = QV ("SELECT  added_price_per_seat from price_table where subscription_level =".$generic_level." and num_seats = 10 ");
  $addfifteenprice  = QV ("SELECT total_price from price_table where subscription_level =".$generic_level." and num_seats = 15 ");
 $addtwentyprice= QV ("SELECT  added_price_per_seat from price_table where subscription_level =".$generic_level." and num_seats = 20  ");
   $addtwentyfiveprice  = QV ("SELECT total_price from price_table where subscription_level =".$generic_level." and num_seats = 25 ");

$addthirtyprice= QV ("SELECT  added_price_per_seat from price_table where subscription_level =".$generic_level." and num_seats = 30  ");

$content .= "<!-- br> trace 2447 from addseatsprice(); addfiveprice: ".$addfiveprice.", addtenprice: ".$addtenprice.", addtwentyprice: ". $addtwentyprice ."-->"; 

$intmultfive=floor ( $generic_numseats/ 5);   // intdiv( $generic_numseats,  5) isnot valid

$content .= "<!--br> trace 2451; intmultfive: ". $intmultfive ."-->";
 switch ($intmultfive)
 { 
    case 0:
     $eachaddfromoneprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 2");
     $eachaddprice =$eachaddfromoneprice;
     break;
     case 1:
     $eachaddfromfiveprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 6");
     $eachaddprice=$eachaddfromfiveprice;
     break;
      case 2:
     $addfromtenprice =QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 11 ");
    $eachaddprice =$addfromtenprice;
     case 3:
     $addfromfifteenprice =QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 16 ");
    $eachaddprice =$addfromfifteenprice;
     break;
      case 4:
     $addfromtwentyprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 21 ");
    $eachaddprice = $addfromtwentyprice ;
     break;
      case 5:
     $addfromtwentyfiveprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 26 ");
    $eachaddprice = $addfromtwentyfiveprice ;
     break; 
     default:
         $eachaddprice = QV ("SELECT  added_price_per_seat from price_table where subscription_level =$generic_level and num_seats = 2");
         break;
 }
 $content .= "<!-- br> trace 2470 eachaddprice" . $eachaddprice . "<br> returning ...-->";
 $custom_message = "arrived at dothis";//$custommessage
 //$eachaddprice  $addtwentyprice
}

$footerScript .= <<<EOS
$(document).ready(function() {
	 
	 $( document ).tooltip();
} );

function  dothis()
  {
    var alertMsg = '<?php echo "arrived"; ?>';
  alert(alertMsg);
  return false;
 
    }

function validateForm() {

 // return true;
    var x = document.forms["addUserForm"]["usr_emp"].value;
	var y = document.forms["addUserForm"]["usr_type"].value;
	
    if ((x == "") && (y != "99"))  {
        alert("You must select a company.");
        return false;
    }
}
function validatenewusernewcompForm() {
  alert("entered validatenewusernewcompForm ");
 // return false;
  // company  contactFirstname contactLastname contactPhone contactEmail
 var xcomp = document.forms["addnewusernewcompForm"]["company"].value;
 var xfname= document.forms["addnewusernewcompForm"]["contactFirstname"].value;
    var xlname =  document.forms["addnewusernewcompForm"]["contactLastname"].value;
    var xphone =  document.forms["addnewusernewcompForm"]["contactPhone"].value;
    var xemail =  document.forms["addnewusernewcompForm"]["contactEmail"].value;
alert("at validatenewusernewcompForm xcomp: " + xcomp + ", xfname: " + xfname + ", xlname: " + xlname + ", xphone: " + xphone + ", xemail: " + xemail);
  var stralert = "";
  var intalertflag = 0;
    if (xcomp == "")   {
        stralert = " You must specify a company.";
        intalertflag = intalertflag  +1;
    }
   if (xfname == "")   {
        stralert = stralert + " You must specify a first name.";
        intalertflag = intalertflag  +1;
    }    
   if (xlname == "")   {
        stralert = stralert +  " You must specify a last name.";
        intalertflag = intalertflag  +1;
    }    
   if (xphone == "")   {
        stralert = stralert + " You must specify a phone number.";
        intalertflag = intalertflag  +1;
    }    
   if (xemail == "")   {
        stralert = stralert + " You must specify an Email.";
        intalertflag = intalertflag  +1;
    }    
     ////intalertflag = 1;
     if ((intalertflag != '0') ||(stralert) '= ""))
     {
     alert(stralert);
        return false;
    }
}

function validatenewuseroldcompForm(){
   var xemail =  document.forms["newuseroldcompForm"]["new_contactEmail"].value;
   alert("arivd at validatenewuseroldcompForm; xemail: " + xemail);
}
function validateaddCompanyForm() {
  //return true;
    //var x = document.forms["addCompanyForm"]["usr_emp"].value;
    var z = document.forms["addCompanyForm"]["company"].value;
    alert ("z: " + z);
	//  var y = document.forms["addCompanyForm"]["usr_type"].value;
	
    if ( z == "" )      {
        alert("You must select a company.");
        return false;
    }
}
function validatenumberseatsForm() {
    var x = document.forms["addSeatsForm"]["addnum_seats"].value;
	
	
    if (!(isNaN(x))    {
        alert("Number of seats must be numeric.");
        return false;
    }
}

EOS;
//////3
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php";

?>