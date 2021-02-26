<?php

define('C3cms', 1);
$title = "Logout";
$pageauth = 0;  // 0=any, 1=members,  2=premium, 3=admin1, 4=admin2
$_SESSION['$usempempid'] = ""; //  "_empid";
$template = "jobcon".$_SESSION['$usempempid']; // standard, mobile, other, ... ?
$response = "content"; // content, ajax ... ?
require "inc/core".$_SESSION['$usempempid'].".php";
$logout_redirect = "http://www.bc2match.com/index.php";
////$logout_redirect = "/../bc2dev/index.htm";
//$siteWebRoot = 'http://www.bc2match.com/'.$_SESSION['env'].'/';



//echo  $_SESSION['env']."<br>"; exit();
switch ($_SESSION['env'])
 { 
    case 'bc2dev/db':
        $logout_redirect  = 'http://www.bc2match.com/bc2dev/index.php';
    break;
     case 'bc2test/db':
        $logout_redirect  = 'http://www.bc2match.com/bc2test/index.php';
    break;
     case 'bc2demo/db':
        $logout_redirect  = 'http://www.bc2match.com/bc2demo/index.php';
    break;
     case 'db': default:
        $logout_redirect  = 'http://www.bc2match.com/index.php';
    break;
 }   
/* //bc2dev
$_SESSION['env'] = 'bc2dev/db';
//bc2test
//$ _ SESSION['env'] = 'bc2test/db';
//bc2demo
//$_SESSION['env'] = 'bc2demo/db';
//bc2prod
//$ _ SESSION['env'] = 'db';
*/

$unLive = Q("UPDATE usr SET usr_live=NULL WHERE usr_id='".$_SESSION['usr_id']."' ");
 ////	unset ($_SESSION['randashbdusrMatches']); // = "set"; // do not do updates for this test lloyd
 	
    $_SESSION = array();
    session_destroy();

//header("Location:  ".$siteWebRoot."index.htm");
header("Location:  ".$logout_redirect);
?>
