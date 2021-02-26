<?php 



	$error = '';
	if ($_GET['action'] == 'logout')
		{
		$_SESSION['authenticated'] = 0;
		$_SESSION['user_id'] = 0;
		$_SESSION['user_fname'] = "";
		$_SESSION['user_lname'] = "";
		$_SESSION['linktarget'] = "";
		$_SESSION['linksource'] = "";
		$error = 'Logged Out';
		header("Location:  http://www.bizconnectonline.com");
		die();
	}

	include("includes/settings.php");
	mysql_connect($sb_dbServer, $sb_dbUsername, $sb_dbPassword) or die('Could not connect to the MySQL database server.  ');
	mysql_select_db($sb_dbDatabase) or die('Could not select the specified database.');
	include("includes/functions.php");
?>
<?php

	switch ($_POST['action'])
		{
		case 'login':
		if ($_POST['username'] == "" || $_POST['password'] == "")
			{$error = "Your e-mail address and password are required!";}
		else
			{
			$tmppass = checkUserPassword($_POST['username'], $_POST['password']);
			if ( $tmppass > 0)
				{
				$error = "Member ID: " . $tmppass;
				$result = "authenticated";
				//SESSION values are all set in checkUserPassword!
				// If we were redirected to login from some other link, continue to original destination
				if($_POST['regevent'] == 1) {
					header("Location: ../registration-form.php");
				}
				if ($_SESSION['linktarget'] != "" AND $_SESSION['linksource'] == 'redirect')
					{header ("Location:" . $_SESSION['linktarget']); }
				else header("Location:".$sb_root."dash.php");
				}
			else
				{$error = "The e-mail/password is not in our records!";}
			}
		break;
		case 'register':		echo "i equals 1"; break;
		case 'reset':
		$tmp_check = checkEmailExists($_POST['username']);
		switch ($tmp_check) {
			case 0:
				$error = "The e-mail address you entered was not found!";	
				break;
			case -1: 
				$result = "inactive";	
				break;
			default: 
				$tmppwd = generatePassword();
				$query2 = 	"UPDATE USERS SET password='" . sha1($tmppwd) . 
							"' WHERE username='" . $_POST['username'] . "'";
				$result2 = mysql_query($query2);
				
				$tmp_subject = "AMOS Password Reset";
				$tmp_content = "\nYour " . $sb_appTitle . " account password has been reset.  \n\nYour new password is:  " . 
								$tmppwd . "\n\n ";
				$result = "reset";
				break;
			}
		break;
		}

?>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/styles.css">    
</head>
<body>

<?php
	switch ($result) {
		case "":
?>
<table class="logintable" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <p><img src="images/logo.jpg" alt="BizConnect Subscribers" width="308" height="61" /></p>
<?php if ($error !="") { echo "<p class='error'>" . $error . "</p>"; }?>
<form id="login" name="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input type="hidden" name="regevent" value="<?php echo $_GET['regevent']; ?>" />
  <label class="loginlabel">
  Email:</label>
  <input name="username" type="text" id="username" value="<?php echo $_POST['email']; ?>" size="24" maxlength="40" />
  <br />
  <label class="loginlabel"> Password:</label>
  <input name="password" type="password" id="password" size="24" maxlength="40" />
    
    <br />
    <input type="submit" name="button" id="button" value="Login" />
    
    <input name="action" type="hidden" id="action" value="login" />

  <p><a href="forgot.php">Forgot your password? </a></p>
</form>
  <p><a href="/">BizConnect Home</a></p>

    </td>
  </tr>
</table>

<?php 
			break;
		case "reset": 
?>
<p>Your password has been reset.  </p>
<?php
			break;
		case "authenticated": 
?>
<p>You are  now logged in to the member-only area.</p>
<p><a href="<?php echo $_SESSION['lastpage']; ?>">Continue...</a></p>
<p>&nbsp;</p>
<p></p>
<?php
			break;
		case "inactive": 
?>
<p>Your account is not active.  Please contact your company representative.</p>
<?php
			break;
	 }
?>
</body>
</html>