<?php
if (!defined('C3cms')) die('');
if (!defined('C3cmsCore')) die('');

$usrPrefTable = Q2T("SELECT usrprf_pref, usrprf_value FROM usr_prefs WHERE usrprf_usr_id = '".$_SESSION['usr_id']."' ");
$usrPrefs = array(); if ($usrPrefTable) foreach($usrPrefTable as $pref) $usrPrefs[$pref['usrprf_pref']]=$pref['usrprf_value'];



if (isset($_REQUEST['op'])) {
	switch ($_REQUEST['op']) {
		case "updateProfilePanels":
			$cleanPref = Clean($_REQUEST["pref"]); $profileRow = "";
			if (substr($cleanPref,0,4) == "row1") { $profileRow = "row1"; $cleanPref = substr($cleanPref,4); }
			if (substr($cleanPref,0,4) == "row2") { $profileRow = "row2"; $cleanPref = substr($cleanPref,4); }
			$updQ = Q("UPDATE usr_prefs SET usrprf_value='".$cleanPref."' WHERE usrprf_usr_id = '".$_SESSION['usr_id']."' AND usrprf_pref = 'profile_".$profileRow."' ");
			$response = "ajax";
			require "inc/transmit.php";
			break;
		case "updateProfilePanelDisplay":
			$panel = Clean($_REQUEST["thisPanel"]); 
			$panelDisplay = Clean($_REQUEST["thisPanelDisplay"]); 
			$updQ = QV("SELECT usrprf_id FROM usr_prefs WHERE usrprf_usr_id = '".$_SESSION['usr_id']."' AND usrprf_pref = 'panel_".$panel."' ");
			if ($updQ>0) $updQ = Q("UPDATE usr_prefs SET usrprf_value='".$panelDisplay."' WHERE usrprf_usr_id = '".$_SESSION['usr_id']."' AND usrprf_pref = 'panel_".$panel."' ");
			else $updQ = Q("INSERT INTO usr_prefs (usrprf_value,usrprf_usr_id,usrprf_pref) VALUES ('".$panelDisplay."','".$_SESSION['usr_id']."','panel_".$panel."')");


			$subContent = '';
			switch ($panel) {
				case "usrBuyPanel":
					$buyTable = Q2T("Select C.catbns_desc as 'desc', U.usrbuy_comment as 'comment' from usr_buy U LEFT JOIN cat_buysell C ON U.usrbuy_buy_id = C.catbns_id WHERE usrbuy_usr_id = ".$_SESSION['usr_id']);
					if ($buyTable) $content .= panelRender($buyTable,Clean($_REQUEST["thisPanelDisplay"]));
					break;
				case "usrSellPanel":
					$sellTable = Q2T("Select U.usrsel_comment as 'comment',C.catbns_desc as 'desc' from usr_sell U LEFT JOIN cat_buysell C ON U.usrsel_sell_id = C.catbns_id WHERE usrsel_usr_id = ".$_SESSION['usr_id']);
					if ($sellTable) $content .= panelRender($sellTable,Clean($_REQUEST["thisPanelDisplay"])); 
					break;
				case "usrIntPanel":
					$intTable = Q2T("Select U.usrint_comment as 'comment',C.catint_desc as 'desc' from usr_int U LEFT JOIN cat_interest C ON U.usrint_int_id = C.catint_id WHERE usrint_usr_id = ".$_SESSION['usr_id']);
					if ($intTable) $content .= panelRender($intTable,Clean($_REQUEST["thisPanelDisplay"])); 
					break;
			}
			//return panel contents
			$response = "ajax";
			require "inc/transmit.php";
			break;
				
	}
}

function panelRender($dataTable,$mode) {
	include_once 'inc/tagcloud.php';
	$subBuffer = '';
	if ($dataTable) {
		switch ($mode){ 
			case 'list':
				foreach($dataTable as $dataRow) $subBuffer .="<div>" . $dataRow['desc'] . '</div>'.($dataRow['comment']!=''?'<div class="">' . $dataRow['comment'] . '</div>':'')."\n";
				break;
			case 'cloud':
				$cloud = new tagcloud(); foreach($dataTable as $dataRow) $cloud->addString($dataRow['desc']); 
			//	$cloud->addTags(array('tag-cloud','php','github')); 
				$cloud->setRemoveTags(array('and','or','but','not','of','from','the','on')); 
			//	$cloud->setMinLength(3); 
			//	$cloud->setOrder('colour','DESC');
				$cloud->setLimit(50); $subBuffer .= $cloud->render() ;
				break;
		}
	}
	return $subBuffer;
}
