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

$content .= '<!-- Global site tag (gtag.js) - Google Analytics -->';
$content .= '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-167338735-1"></script>';
$content .= '<script>';
$content .= '  window.dataLayer = window.dataLayer || [];';
$content .= '  function gtag(){dataLayer.push(arguments);}';
$content .= "  gtag('js', new Date());";
$content .= "  gtag('config', 'UA-167338735-1');";
$content .= '</script>';
   
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; ?>
