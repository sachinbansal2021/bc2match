<?php
if (!defined('C3cms')) die('Direct access not allowed!');

$cssLinks .= '
			<link rel="stylesheet" type="text/css" href="css/main.css" />
			<link rel="stylesheet" type="text/css" href="css/mobile.css" />
			<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />';
$scriptLinks .= '
			<script type="text/javascript" src="js/jquery.js" ></script>
			<script type="text/javascript" src="js/jquery-ui.js" ></script>
			<!--   border: 1px solid black; -->';
$cssInline .= '	 ' ;
$header = '<a href="../../">
	<img title="BC2Match" alt="BC2Match" src="img/bc2match-logo-design-1.png" style="border:0px;float:left;display:inline-block;position:absolute;margin-top:10px;margin-left:10px;z-Index:5;" />
</a> <!--	&nbsp;
	<img title="BC2Match" alt="BC2Match" src="/img/bc2match-logo-design-1.png" style="border:0px;float:left;display:inline-block;position:absolute;margin-top:10px;margin-left:10px;z-Index:5;" />
 -->
  ';
$topSocial = '
	<div id="topSocial">
		<ul>
<!--			<li><a title="Follow Us on Twitter!" href="http://www.twitter.com/bc2matchllc" target="_blank"><img alt="Follow Us on Twitter!" src="/themes/boldy/images/ico_twitter.png" /></a></li>
			<li><a title="Join Us on Facebook!"  href="http://www.facebook.com/bc2matchllc" target="_blank"><img alt="Join Us on Facebook!" src="/themes/boldy/images/ico_facebook.png"/></a></li>
			<li><a title="YouTube" href="http://www.youtube.com/user/B2matchllc" target="_blank" ><img alt="Visit our YouTube page!" src="/themes/boldy/images/ico_youtube.png" /></a></li>
-->		</ul>
    </div>';
//$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."    
//$_SESSION['$usempempid'] = "_empid"; 
/*
	$footer .= '
			<div style="border:0px;margin-top:10px;">
				<img src="images/footer_wide.png" alt=" " style="position:relative;z-Index:1" />
			</div>
	<br/>
*/	
$footer .= '<br>&nbsp&nbspCopyright 2019, BC2 Match - All rights reserved.   .<br/>   <br/>';
/*
	Powered by <a href="http://www.cccsolutions.com/" style="color:#ddf;">Computer Consultants Corporation</a>
	<p><a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a></p>';
*/
/*
$footerScript .= <<<__EOS
$(document).ready(function(){  
		//When mouse rolls over  
		$("li.nav1").mouseover(function(){  
			$(this).stop().animate({height:'100px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
		//When mouse is removed  
		$("li.nav1").mouseout(function(){  
			$(this).stop().animate({height:'47px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
	}); 
__EOS;
*/
   
		  
  	 
$memberType = ' (Member)';

if (($_SESSION['usr_type'] == 0) || ($_SESSION['usr_auth_orig'] == 8)) $memberType = ' (Primary Member)';
if ($_SESSION['usr_type'] == 99) $memberType = ' (BC2 Admin)';
//echo('line 58 jobcon.php  $ _ SESSION [usr_type]: ' . $_SESSION['usr_type'] . ',  $ _SESSION[usr_auth]: ' . $_SESSION['usr_auth']);
switch ($_SESSION['usr_auth']) {
	default: case "0": // Public Users 
	
   	  $myloginvalue ='newemaillogin';
    //  $myloginvalue = 'login';
  	 
  	 $_SESSION['justloggingin'] = 1;
  	 	$_SESSION['$comdash_exists'] = 'no';
   
	
	$header .=	'
	<div class="login"  style="display:block; align:left;">
    			<form action="'.$_SERVER['PHP_SELF'].'" method="post" name="login" id="login">
			<table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" value="" id="username" name="username" title="Email or User Name" />
				</td><td>&nbsp; </td> <td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td>  		<input type="hidden" name="op" value="'.$myloginvalue.'"/>
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		</form><br/>
	</div>
	'.$topSocial;
		$nav1 .= ' ';
		$footerScript .= <<<__EOS
__EOS;
		break;
	case "1": // Authenticated Job Applicants
		$header .= $topSocial.'
		<div class="userAccount">
			Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).'<br/>
			<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
		</div>';
		$nav1 .= '
        <li class="nav1 "><p><a href="logout.php">Log Out</a></p><div class="subtext">Leave or <br/>Switch User</div></li>';

		break;	
//	case "2": // Authenticated Employer
//		$header .= $topSocial.'
//		<div class="userAccount">
//			Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).' (Premium)<br/>
//			<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
//		</div>';
//		$nav1 .= ' ';
//		$footerScript .= <<<__EOS
//__EOS;
//		break;		
	case "4": // Manager
	case "5": // Developer
	case "6": // Program Manager
	case "7": // Director
	case "8":  // Admin 
		$header .= $topSocial.'
		<div  class="userAccount">
		 
			Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).$memberType.'<br/>
			<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
		</div>	'
		//."<div style='position:absolute;top:10px;left:300px;'>".$liveUsers." live member, ".$guestUsers." guests online.</div>"
		.'
		<div id="editorWindow" style="display:none;position:absolute;top:0px;width:100%;height:900px;z-Index:100;background:#fff;"></div>';
		$headerScript .= 'editPage = function(pageID) { $("#editorWindow").load("?op=pageEdit&pageID=" + pageID, function() { $(this).show(); }); };';
		//$nav1 .= '<li class="nav1 redNav" ><p><a href="admin_usr">Admin</a></p><div class="subtext"><div class="sub2">Restricted Access</div></div></li>';
		$adminNav .= '
		<div id="adminNav">
			<div onclick="window.location=\'admin_con.php?show=content\';" >Manage Content</div>
			<div onclick="window.location=\'admin_med.php?show=files\';" >Files</div>
		</div>
		';
		$footerScript .= <<<__EOS
__EOS;
		break;	
	case "2": // Authenticated Member
		$header .= $topSocial.'
		<div class="userAccount">
			Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).$memberType.'<br/>
			<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
		</div>';
		$nav1 .= ' ';
		$footerScript .= <<<__EOS
__EOS;

		break;
	case "9": // Authenticated Member  // No  an Admin
		$header .= $topSocial.'
		<div class="userAccount">
			Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).' (Admin)<br/>
			<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
		</div>';
		$nav1 .= ' ';
		$footerScript .= <<<__EOS
__EOS;

		break;			
}
?>