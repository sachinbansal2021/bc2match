<?php

// Homepage  index.php
//_empid
//-- page settings
session_start();
define('C3cms', 1);
$title = "Homepage";
$pageauth = 0;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$_SESSION['$usempempid'] = ""; ////"_empid"; 
$template = "jobcon".$_SESSION['$usempempid']; 
$response = "content"; // content, ajax ... ?

require "inc/core".$_SESSION['$usempempid'].".php";

//-- define content -----------------------------------------------------------------
$footerScript .= <<<EOS
EOS;
////	unset ($_SESSION['randashbdusrMatches']); // = "set"; // do not do updates for this test lloyd
 	
$content .= DBContent();


   
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; ?>
