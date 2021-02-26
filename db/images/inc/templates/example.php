<?php
if (!defined('C3cms')) die('Direct access not allowed!');

$cssLinks .= '		<link rel="stylesheet" type="text/css" href="css/main.css" />
			<link rel="stylesheet" type="text/css" href="css/mobile.css" />
			<link rel="stylesheet" type="text/css" href="css/jquery-ui.css" />';

$scriptLinks .= '	<script type="text/javascript" src="js/jquery.js" ></script>
			<script type="text/javascript" src="js/jquery-ui.js" ></script>';

$cssInline .= '';

$liveUsers = QV("SELECT COUNT(*) FROM usr WHERE usr_live > '".date('Y-m-d H:i:s',strtotime('-2 hours',time()))."'");
$guestUsers = (count(scandir(session_save_path()))-2) - $liveUsers;

$header = '<img src="img/logo.jpg" alt="BizConnect Online" title="BizConnect Online" style="float:left;margin:20px;"/>'
	."<div style='position:absolute;top:10px;left:300px;'>".$liveUsers." live member, ".$guestUsers." guests online.</div>";

$topSocial = '
	<div id="topSocial">
		<ul>
			<li><a title="Join us on LinkedIn!" href="http://www.linkedin.com/profile/view?id=20017817&amp;trk=tab_pro" target="_blank"><img alt="LinkedIn" src="/themes/boldy/images/ico_linkedin.png" /></a></li>
			<li><a title="Follow Us on Twitter!" href="http://www.twitter.com/bizconnectllc" target="_blank"><img alt="Follow Us on Twitter!" src="/themes/boldy/images/ico_twitter.png" /></a></li>
			<li><a title="Join Us on Facebook!"  href="http://www.facebook.com/bizconnectonline" target="_blank"><img alt="Join Us on Facebook!" src="/themes/boldy/images/ico_facebook.png"/></a></li>
			<li><a title="YouTube" href="http://www.youtube.com/user/BizConnectOnline" target="_blank" ><img alt="Visit our YouTube page!" src="/themes/boldy/images/ico_youtube.png" /></a></li>
		</ul>
    </div>
';
$footer .= '<br/>
		<div style="font-size:16px;background:#fff;padding:10px;border-radius:5px;display:inline-block;box-shadow:0 0 10px #000 inset">
			<span style="color:#6FBA39;font-weight:bold;font-family:serif;">Biz</span><span style="color:#360;font-weight:bold;font-family:serif;">Connect</span>
		</div><br/><br/>
		818 18th ST NW, Suite 950, Washington DC 20006<br/>
		Phone (202) 785-8005 | Fax (202) 785-8006<br/>
		<br/>
		Copyright 2013, BizConnect All rights reserved.<br/><br/>
		Powered by <a href="http://www.cccsolutions.com/" style="color:#ddf;">Computer Consultants Corporation</a>
		<p><a href="http://validator.w3.org/check?uri=referer"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a></p>';
		

switch ($_SESSION['usr_auth']) {
	case "0": // Public Users 
		$header .= '
	<div class="login">
    	<form action="'.$_SERVER['PHP_SELF'].'" method="post" name="login" id="login">
			<table cellspacing="5" cellpadding="0" border="0">
				<tbody><tr><td>
					<a href="forgot.php" class="forgotlink">Forgot your password? </a>
				</td><td>
					<label class="loginlabel"> Email:</label>
					<input class="loginbox" type="text" maxlength="40" size="24" value="" id="username" name="username" title="Email or User Name" />
				</td><td>
					<label class="loginlabel"> Password:</label>
					<input class="loginbox" type="password" maxlength="40" size="24" id="password" name="password" title="Password" />
				</td><td>
					<input type="hidden" name="op" value="login"/>
					<input type="submit" style="height:32px;width:64px;" value="Login" title="Submit" /><br/>
				</td></tr>
			</tbody></table>
		</form><br/>
	</div>
	'.$topSocial;

		$nav1 .= '
        <li class="nav1 "><p><a href="index.php">Home</a></p><div class="subtext">Welcome</div></li>  
        <li class="nav1 "><p><a href="benefits.php">Benefits</a></p><div class="subtext">Membership Benefits</div></li>  
        <li class="nav1 "><p><a href="events.php">Events</a></p><div class="subtext">Upcoming Meetings</div></li>  
        <li class="nav1 "><p><a href="join.php">Join Now</a></p><div class="subtext">Become a BizConnect Member!</div></li>  
        <li class="nav1 "><p><a href="about.php">About</a></p><div class="subtext">About Us</div></li>  
        <li class="nav1 "><p><a href="contact.php">Contact</a></p><div class="subtext">Get in touch</div></li>  
';


		$footerScript .= <<<__EOS
$(document).ready(function(){  
		//When mouse rolls over  
		$("li.nav1").mouseover(function(){  
			$(this).stop().animate({height:'150px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
		//When mouse is removed  
		$("li.nav1").mouseout(function(){  
			$(this).stop().animate({height:'50px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
	}); 
__EOS;
		break;
	case "1": // Authenticated Members 
		$header .= $topSocial.'
	<div class="userAccount">
		Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).'<br/>
		<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
	</div>
	';

		$nav1 .= '
        <li class="nav1 "><p><a href="dashboard.php">Home</a></p><div class="subtext">Welcome</div></li>  
        <li class="nav1 "><p><a href="myprofile.php">My Profile</a></p><div class="subtext">View Your Profile</div></li>  
        <li class="nav1 "><p><a href="matches.php">Matches</a></p><div class="subtext">See Your Matches</div></li>  
        <li class="nav1 "><p><a href="events.php">Events</a></p><div class="subtext">Upcoming Meetings</div></li>  
        <li class="nav1 "><p><a href="renew.php">Renew</a></p><div class="subtext">Renew your membership!</div></li>  
        <li class="nav1 "><p><a href="search.php">Search</a></p><div class="subtext">Find Other Members</div></li>  
        <li class="nav1 "><p><a href="contact.php">Contact</a></p><div class="subtext">Get in touch</div></li>  
        <li class="nav1 "><p><a href="logout.php">Log Out</a></p><div class="subtext">Leave or <br/>Switch User</div></li>  
';


		$footerScript .= <<<__EOS
$(document).ready(function(){  
		//When mouse rolls over  
		$("li.nav1").mouseover(function(){  
			$(this).stop().animate({height:'150px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
		//When mouse is removed  
		$("li.nav1").mouseout(function(){  
			$(this).stop().animate({height:'50px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
	}); 
__EOS;
		break;
	case "2": // Permanent Members 
			$header .= $topSocial.'
	<div class="userAccount">
		Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).' (Premium)<br/>
		<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
	</div>';

		$nav1 .= '
        <li class="nav1 "><p><a href="dashboard.php">Home</a></p><div class="subtext">Welcome</div></li>  
        <li class="nav1 "><p><a href="myprofile.php">My Profile</a></p><div class="subtext">View Your Profile</div></li>  
        <li class="nav1 "><p><a href="matches.php">Matches</a></p><div class="subtext">See Your Matches</div></li>  
        <li class="nav1 "><p><a href="events.php">Events</a></p><div class="subtext">Upcoming Meetings</div></li>  
        <li class="nav1 "><p><a href="renew.php">Renew</a></p><div class="subtext">Renew your membership!</div></li>  
        <li class="nav1 "><p><a href="search.php">Search</a></p><div class="subtext">Find Other Members</div></li>  
        <li class="nav1 "><p><a href="contact.php">Contact</a></p><div class="subtext">Get in touch</div></li>  
        <li class="nav1 "><p><a href="logout.php">Log Out</a></p><div class="subtext">Leave or <br/>Switch User</div></li>  
';


		$footerScript .= <<<__EOS
$(document).ready(function(){  
		//When mouse rolls over  
		$("li.nav1").mouseover(function(){  
			$(this).stop().animate({height:'120px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
		//When mouse is removed  
		$("li.nav1").mouseout(function(){  
			$(this).stop().animate({height:'50px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
	}); 
__EOS;
		break;		
	case "3": case "4": // Admin Levels 1, 2 
		$header .= $topSocial.'
	<div class="userAccount">
		Hello '.QV('SELECT CONCAT(usr_prefix," ",usr_firstname," ",usr_lastname) FROM usr WHERE usr_id = '.$_SESSION['usr_id']).' (Administrator)<br/>
		<a href="logout.php" class="userLogout" title="Logout" >Logout</a>
	</div>
	<div id="editorWindow" style="display:none;position:absolute;top:0px;width:100%;height:900px;z-Index:100;background:#fff;"></div>
	';
		$headerScript .= '
	function editPage(pageID) {
		$("#editorWindow").load("?op=pageEdit&pageID=" + pageID, function() {
			$(this).show();
			//alert("Load was performed." + page);
		});
	}';
	
		$nav1 .= '
        <li class="nav1 "><p><a href="dashboard.php">Home</a></p><div class="subtext">Welcome</div></li>  
        <li class="nav1 "><p><a href="myprofile.php">My Profile</a></p><div class="subtext">View Your Profile</div></li>  
        <li class="nav1 "><p><a href="matches.php">Matches</a></p><div class="subtext">See Your Matches</div></li>  
        <li class="nav1 "><p><a href="events.php">Events</a></p><div class="subtext">Upcoming Meetings</div></li>  
        <li class="nav1 "><p><a href="renew.php">Renew</a></p><div class="subtext">Renew your membership!</div></li>  
        <li class="nav1 "><p><a href="search.php">Search</a></p><div class="subtext">Find Other Members</div></li>  
        <li class="nav1 "><p><a href="contact.php">Contact</a></p><div class="subtext">Get in touch</div></li>  
        <li class="nav1 "><p><a href="logout.php">Log Out</a></p><div class="subtext">Leave or <br/>Switch User</div></li>  
        <li class="nav1 " style="background:#500;"><p><a href="admin.php">Admin</a></p><div class="subtext">Restricted Access</div></li>  
';

		$adminNav .= '
		<div id="adminNav">
			<div onclick="editPage(\''.QV("SELECT rescon_id FROM res_content WHERE rescon_area = '".str_replace("/new/","",str_replace(".php","",$_SERVER['PHP_SELF']))."' ").'\');" >Edit This Page</div>
			<div onclick="window.location=\'admin.php?show=content\';" >Manage Content</div>
		</div>
		';

		$footerScript .= <<<__EOS
$(document).ready(function(){  
		//When mouse rolls over  
		$("li.nav1").mouseover(function(){  
			$(this).stop().animate({height:'120px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
		//When mouse is removed  
		$("li.nav1").mouseout(function(){  
			$(this).stop().animate({height:'50px'},{queue:false, duration:500, easing: 'easeOutSine'})  
		});  
	}); 
	
__EOS;
		break;		
}
?>
