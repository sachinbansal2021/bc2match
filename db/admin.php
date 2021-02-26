<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "Admin";
$pageauth = 3;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$template = "jobcon"; 
$response = "content"; 
require "inc/core.php";
switch($_SESSION['usr_auth']) {
	case "1": header("Location: ".$siteWebRoot."applicants"); die(); break;
	case "2": header("Location: ".$siteWebRoot."employers"); die(); break;
	case "3": header("Location: ".$siteWebRoot."managers"); die(); break;
	case "4": header("Location: ".$siteWebRoot."admin_rep"); die(); break;
	case "5": case "6": header("Location: ".$siteWebRoot."admin_emp"); die(); break;
	case "7": case "8": header("Location: ".$siteWebRoot."admin_usr"); die(); break;
}
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; ?>
