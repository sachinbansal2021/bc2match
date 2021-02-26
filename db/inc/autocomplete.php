<?php 

// template (example) C3cms page

//-- page settings
define('C3cms', 1);
$title = "autocomplete";
$pageauth = 1;  // allow all users
$usempempid= "";  //  "_empid"  ;  //$_SESSION['$usempempid'] ;
$template = "jobcon".$usempempid; 
  
////$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
require "core".$usempempid.".php";

////$template = "jobcon"; // standard, members, admin, ... ?
$response = "data"; // content, ajax, data 
//// "core.php";

//-- define content -----------------------------------------------------------------

$category = Clean($_REQUEST['sec']);
$searchWord = Clean($_REQUEST['search']);
$results = '';
$resultmode="";

switch ($category) {
	case "skills-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catskl_label as 'A', catskl_id as 'B' FROM cat_skills WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_skills WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;
	case "proflics-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catskl_label as 'A', catskl_id as 'B' FROM cat_proflics WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_proflics WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;
	case "geos-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catskl_label as 'A', catskl_id as 'B' FROM cat_geos WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_geos WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;		
	case "certifications-app": 
		$results = Q2T("SELECT catcrt_name as 'A', catcrt_id as 'B' FROM cat_certs WHERE catcrt_name LIKE '%".$searchWord."%' AND catcrt_id > 0 ORDER BY catcrt_name");
		//$results = Q2T("SELECT catcrt_desc as 'A', catcrt_id as 'B' FROM cat_certs WHERE catcrt_desc LIKE '%".$searchWord."%' AND catcrt_id > 0 ORDER BY catcrt_desc");
		$resultmode="JSON";
		break;
	case "clearance-app": 
		echo "searchWord [ ".$searchWord." ]";exit();
		$results = Q2T("SELECT catclr_title as 'A', catclr_rank as 'B' FROM cat_clearance WHERE catclr_title LIKE '%".$searchWord."%' AND catclr_id > 0 ORDER BY catclr_rank");
		$resultmode="JSON";
		break;
	case "functions-app": 
		//$words = explode(" ",$searchWord); $searchBlock = "";
		//foreach ($words as $w) $searchBlock .= " catfnc_text LIKE '%" . $w . "%' AND ";
		//$results = Q2T("SELECT catfnc_text as 'A', catfnc_id as 'B' FROM cat_func WHERE ".$searchBlock." catfnc_id > 0 ORDER BY catfnc_order, catfnc_text");
		$results = Q2T("SELECT catfnc_title as 'A', catfnc_id as 'B' FROM cat_func WHERE catfnc_title LIKE '%".$searchWord."%' AND catfnc_id > 0 ORDER BY catfnc_order, catfnc_title");
		//$results = Q2T("SELECT catfnc_text as 'A', catfnc_id as 'B' FROM cat_func WHERE catfnc_title LIKE '%".$searchWord."%' AND catfnc_id > 0 ORDER BY catfnc_order, catfnc_text");
		$resultmode="JSON";
		break;
	case "agencies-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catagen_label as 'A', catagen_id as 'B' FROM cat_agencies WHERE catagen_label LIKE '%".$searchWord."%' AND catagen_id > 0 ORDER BY catagen_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_skills WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;		
	case "proflics-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catskl_label as 'A', catskl_id as 'B' FROM cat_proflics WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_skills WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;
	case "geos-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catskl_label as 'A', catskl_id as 'B' FROM cat_geos WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_skills WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;		
	case "vehicles-app": 
//		$words = explode(" ",$searchWord); $searchBlock = "";
		$results = Q2T("SELECT catskl_label as 'A', catskl_id as 'B' FROM cat_vehicles WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_label");
		//$results = Q2T("SELECT catskl_text as 'A', catskl_id as 'B' FROM cat_skills WHERE catskl_label LIKE '%".$searchWord."%' AND catskl_id > 0 ORDER BY catskl_text");
		$resultmode="JSON";
		break;


		
	case "skills-app-select": 
		$results = QV("SELECT catskl_text as 'A' FROM cat_skills WHERE catskl_id = '".$searchWord."' AND catskl_id > 0"); $resultmode="raw";
		break;
	case "proflics-app-select": 
		$results = QV("SELECT catskl_text as 'A' FROM cat_proflics WHERE catskl_id = '".$searchWord."' AND catskl_id > 0"); $resultmode="raw";
		break;
	case "geos-app-select": 
		$results = QV("SELECT catskl_text as 'A' FROM cat_geos WHERE catskl_id = '".$searchWord."' AND catskl_id > 0"); $resultmode="raw";
		break;		
	case "certifications-app-select":
		$results = QV("SELECT catcrt_desc as 'A' FROM cat_certs WHERE catcrt_id = '".$searchWord."' AND catcrt_id > 0 "); $resultmode="raw";
		break;
	case "clearance-app-select":
		$results = QV("SELECT catclr_desc as 'A' FROM cat_clearance WHERE catclr_id = '".$searchWord."' AND catclr_id > 0 "); $resultmode="raw";
		break;
	case "functions-app-select": 
		$results = QV("SELECT catfnc_text as 'A' FROM cat_func WHERE catfnc_id = '".$searchWord."' AND catfnc_id > 0"); $resultmode="raw";
		break;
	case "agencies-app-select": 
		$results = QV("SELECT catagen_text as 'A' FROM cat_agencies WHERE catagen_id = '".$searchWord."' AND catagen_id > 0"); $resultmode="raw";
		break;		
	case "vehicles-app-select": 
		$results = QV("SELECT catskl_text as 'A' FROM cat_vehicles WHERE catskl_id = '".$searchWord."' AND catskl_id > 0"); $resultmode="raw";
		break;		
	



		
//	case "fname": $results = Q2T("SELECT DISTINCT usr_firstname as 'A' FROM usr WHERE usr_firstname LIKE '%".$searchWord."%' ORDER BY usr_firstname"); break;
//	case "lname": $results = Q2T("SELECT DISTINCT usr_lastname as 'A' FROM usr WHERE usr_lastname LIKE '%".$searchWord."%' ORDER BY usr_lastname"); break;
//	case "keywords":
//		$results = Q2T("SELECT usr_firstname FROM usr WHERE usr_firstname LIKE '%".$searchWord."%'");
//		break;
//	case "company": $results = Q2T("SELECT usr_company as 'A' FROM usr WHERE usr_company LIKE '%".$searchWord."%' ORDER BY usr_company"); break;
//	case "bustype":
//		$results = Q2T("SELECT usr_firstname as 'A' FROM usr WHERE usr_firstname LIKE '%".$searchWord."%' ORDER BY usr_firstname");
//		break;
//	case "postal": $results = Q2T("SELECT DISTINCT usr_zip as 'A' FROM usr WHERE usr_zip LIKE '%".$searchWord."%' ORDER BY usr_zip"); break;
//	case "interests":
//		$results = Q2T("SELECT DISTINCT catint_desc as 'A' FROM `cat_interest` WHERE catint_desc LIKE '%".$searchWord."%' ORDER BY catint_desc");
//		break;
//	case "college":
//		break;
//	case "homestate":
//		break;
}

switch($resultmode) {
case "JSON":
	$contentArray = array();
	if ($results) foreach($results as $row) $contentArray[] ='{"id":"'.$row['B'].'","label":"'.$row['A'].'","value":"'.$row['A'].'"}';
	$contentData = '['.implode(",",$contentArray).']';
	break;
case "raw":
	$contentData = $results;
	break;
}

//-- transmit ---------------------------------------------------------------
require "transmit.php";
