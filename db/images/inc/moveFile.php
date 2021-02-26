<?php 
define('C3cms', 1);
$pageauth = 3;  // // 0=any, 1=members, 2=premium, 3=admin1, 4=admin2
include('core.php');

if (isset($_REQUEST['pageID'])) {
	$fQ = Q2R("SELECT rescon_id, rescon_url FROM res_content WHERE rescon_posted='0' AND rescon_id='".CleanI($_REQUEST['pageID'])."' ");
	print_r($fQ);
	if (intval($fQ['rescon_id'])>0) {
		copy( $siteTmpPath.($fQ['rescon_url']).".php", $siteFileRoot.($fQ['rescon_url']).".php");
		Q("UPDATE res_content SET rescon_posted='1' WHERE rescon_id='".CleanI($_REQUEST['pageID'])."' ");
	}
}

