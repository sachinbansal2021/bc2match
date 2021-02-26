<?php 
//-- page settings
define('C3cms', 1);
$title = "Password Recovery";
$pageauth = 0;  // 0=any, 1=members, 2=admin1, 3=admin2
$template = "jobcon"; // standard, mobile, other, ... ?
$response = "content"; // content, ajax ... ?
require "inc/core.php";

//-- define content -----------------------------------------------------------------
	
$error = '';$result="";
$content .= '
	<table class="logintable" align="center" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<!-- p>< - img src="img/logo.png" alt="JobConnect Online" /></p  
					<p><img src="img/bc2match-smalllogo.png" alt="BC2Match"/></p -->
		<br>		';
		

if (isset($_REQUEST['action'])) {
      $page_action = $_REQUEST['action'];
}
else
    $page_action = $_POST['action'];
  

switch ($page_action) {
	case 'reset':
		$rsusr = QV("SELECT usr_id FROM usr WHERE usr_email = '".Clean($_POST['username'])."' ");
		
		if ($rsusr == 0 || $rsusr == false || $rsusr == null) {
			$content .= '<span style="color:#900;">Password Not Reset: User Not Recognized.</span><br/><br/>';
		} else {
			$tmppwd = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,9);
			$tmppwd = $_POST['pass'];
			$query2 = "UPDATE usr SET usr_password='" . sha1($tmppwd) . "' WHERE usr_id='" . $rsusr . "'";
			if ($result2 = mysqli_query($conn, $query2)) {
				$tmp_subject = "BC2Match Password Reset for " .$_POST['username'];
				$tmp_content = "\r\nYour " . $sb_appTitle . " account password has been reset.  \r\nYour new password is:  " . $tmppwd . "\r\n";
			//	mail($_POST['username'],$tmp_subject,$tmp_content,'From: info@bizconnectonline.com' . "\r\n" . 'Reply-To: no-reply@bizconnectonline.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() );
       //    $joinheaders = 'BCC: lloydpalmer@yahoo.com' ."\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
	//    $joinheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
		 //   $joinheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
	    $joinheaders = 'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
							   
           // $joinheaders2 =  'BCC: lloydpalmer@yahoo.com' . "\r\n" .'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
		  //$tryheaders = 'From: info@bc2match.com' . "\r\n" .' Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
		 //// $tryheaders = $joinheaders ;//. ' BCC: lloydpalmer@yahoo.com' . "\r\n" ;//.'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@bc2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() ;
		  

            if ($_POST['wherefrom'] == 'site')
            {
		   	   // mail($_POST['username'],$tmp_subject,$tmp_content, $joinheaders );  
		   	                   //,'From: info@bc2match.com' . "\r\n" . 'Reply-To: no-reply@b2match.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() );
 		 
			
				$result = "reset";
				$content .= 'Password has been reset for: '.$_POST['username'].'<br/><br/><br/><a href="../index.php">Return to homepage.</a>';
            }
            else
            {
                $result = "reset";
                $content .= 'Password has been reset for: '.$_POST['username'].'<br/><br/><br/><a href="admin_usr.php?usr='.$_POST['usr'].'&ptype=admin&userCompany='.$_POST['userCompany'].'">Return to Manage Account</a>';
                
            }
		
			}
			break;
		}
		
		break;
		
	default:
	    if ($page_action == 'change')
	    	    {
	        $prompt = "Change the password for: ".$_REQUEST['email'];
	        $email = $_REQUEST['email'];
	        $postaction = 'change';
	    }
	    else
	    {
	        $prompt = "Forgot your password?";
	        $email = $_POST['username'];
	        $postaction = 'site';
	    }

		$content .= '
				<form id="login" name="login" method="post" action="'.$_SERVER['PHP_SELF'].'">
					<label class="loginlabel">'.$prompt.'<br></label><br>
					<table>
					<tr>';
					
					if ($page_action == 'change')
					    $content .= '<td>Email Address:&nbsp;</td><td><input name="username" type="text" id="username" value="'.$email.'" size="24" maxlength="40" readonly /></td>';
					else
					    $content .= '<td>Email Address:&nbsp;</td><td><input name="username" type="text" id="username" value="'.$email.'" size="24" maxlength="40" /></td>';
					
					
					
					$content .='</tr>
					<tr>
					<td>New Password:&nbsp;</td><td><input name="pass" type="password" id="pass" value="" size="24" maxlength="40" /></td>
					</tr>
					</table>
					<br />
					<label class="loginlabel"></label>
					<p>
						<input type="submit" name="Submit" id="button" value="Reset Password" />
						<input name="action" type="hidden" id="action" value="reset" />
						<input name="wherefrom" type="hidden" id="wherefrom" value="'.$postaction.'" />';
						
				    if ($page_action == 'change')
				    {
				        $content .= '<input name="usr" type="hidden" id="usr" value="'.$_REQUEST['usr'].'" />
						<input name="userCompany" type="hidden" id="userCompany" value="'.$_REQUEST['userCompany'].'" />';
				    }
					
					
					if ($page_action == 'change')
				    {
					    $content .= '</p><p><a href="admin_usr.php?usr='.$_REQUEST['usr'].'&ptype=admin&userCompany='.$_REQUEST['userCompany'].'">Return to Manage Account</a></p>';
					}
					else
					{
					    $content .= '</p>
					    <p><a href="../index.php">Back to Home Page</a> </p>';
				    }
					
					
				$content .= '</form>';
		break;
}
$content .= '
			</td>
		</tr>
	</table>';

include("inc/transmit.php");

?>