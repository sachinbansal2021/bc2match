<?php 
//-- page settings
define('C3cms', 1);
$title = "<<<newPageTitle>>>";
$pageauth = <<<newPageAuth>>>;  // 0=any, 1=members, 2=admin1, 3=admin2
$template = "standard"; // standard, members, admin, ... ?
$response = "content"; // content, ajax ... ?
require "inc/core.php";

//-- define content -----------------------------------------------------------------
$footerScript .= " "; $nav2='';
$content .= QV("SELECT rescon_content FROM res_content WHERE rescon_area='<<<newPageTitle>>>' ");

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php";
?>
