<?php    
if (!defined('C3cms')) die('Direct access not allowed!');
if (!defined('C3cmsCore')) die('Not defined Core');

$hipposcript = '<!-- Chat Bot -->
<script src= "https://chat.hippochat.io/js/widget.js"></script>
<script>
     window.initHippo({
        appSecretKey: "c8acb6bc202db461ca2d8a6c5b040252"
    });
</script>';


$contypes = '';

  switch ($_SESSION['usr_auth']) {
	default: case "0": $contypes .= "'Public', 'PubApp', 'PubEmp', 'PubMgr'"; break;
	case "1": $contypes .= "'Applicants', 'PubApp', 'AppEmp', 'AppMgr'"; break;
	case "2": $contypes .= "'Employers', 'PubEmp', 'AppEmp', 'EmpMgr'"; break;
	case "3": $contypes .= "'Managers', 'PubMgr', 'EmpMgr', 'MgrAdm'"; break;
	case "4": case "5": case "6": $contypes .= "'MgrAdm', 'Admin'"; break;
	case "9": $contypes .= "'Employers', 'PubEmp', 'AppEmp', 'EmpMgr'"; break;
  }
  
      // echo("<br> sess comdash_exists: " .$_SESSION['$comdash_exists'] . "<br>"); //  print_r($_SESSION);
       //  echo ("in transmit line 20 seeing if we are at contactus or joinnow or noewemployer- pagename: " .  basename($_SERVER['PHP_SELF']) );
         $my_pagename = basename($_SERVER['PHP_SELF']);
         // echo (" $ my_pagename" . $my_pagename  . " =? " . basename($_SERVER['PHP_SELF']) );
    	$corefindme   = 'contactus';
          $corecontactpos = strpos($my_pagename , $corefindme);
         // echo ("$ corecontactpos: " . $corecontactpos);
        if  ( $corecontactpos  !== false) $contypes = "'ContactUs'";  
          	$corefindme   = 'joinnow';
           $corejoinnowpos = strpos($my_pagename , $corefindme);
         //   echo ("$ corejoinnowpos: " . $corejoinnowpos);
           if  (( $corejoinnowpos !== false) )   $contypes = "'NewEmp'";
      
        	$corefindme   = 'newemployer';
           $corenewemployerpos = strpos($my_pagename , $corefindme);
           // echo ("$ corenewemployerpos: " . $corenewemployerpos);
        if ( ( $corenewemployerpos !== false ) )$contypes = "'NewEmp'";
   
  //echo ("<  ! -- $ my_pagename" . $my_pagename .	",last $ corefindme: " . $corefindme .", $ corenewemployerpos: " .  $corenewemployerpos . ", $ corejoinnowpos: " .  $corejoinnowpos . ", $ corecontactpos: " .  $corecontactpos . ", $ contypes: "  .$contypes . " -->" );
  //echo( $my_pagename . $corefindme . 'corenewemployer: ' . $corenewemployerpos  . 'from transmit34 contype is ' .$contypes);
    $dbNav = ''; $dnQ = Q2T("SELECT * FROM res_content WHERE rescon_menuscope IN ('All',".$contypes.") ORDER BY rescon_order ASC");

//     $my_pagename ==  bc2companydashboard.php and $ _ SESSION[' $ comdash_exists'] == yes   $ my_pagename==index.php  url==
// lloyd 91318 need .php
 $thisURL = '';
 $extloc = '';
if ($dnQ)  //0
  { foreach($dnQ as $dn) //-1 
     $my_pagename=strtolower(trim($my_pagename));
    $thisurl = strtolower(trim($dn['rescon_url']));
     if   (
            ($my_pagename == 'bc2companydashboard.php') && ($thisurl =='bc2companydashboard.php' )
         || ( ($my_pagename =='index.php') && (strtolower($thisurl == 'index.php'))
         || ( ($my_pagename =='')  && $thisurl == 'index.php'))
         ||   ( (!($_SESSION['$comdash_exists'] == "yes")) && ( $thisurl== 'bc2companydashboard.php' ) || ($thisurl == 'index.php' ) )
         ||   ( ($_SESSION['$comdash_exists'] == "no") && ($thisurl == 'bc2companydashboard.php'  ||$thisurl == 'index.php'))
         ||  ( (empty($_SESSION['$comdash_exists'])) && ( $thisurl == 'bc2companydashboard.php' ||$thisurl == 'index.php'))
         || ( (!(isset($_SESSION['$comdash_exists'])) ) && ( $thisurl == 'bc2companydashboard.php' ||$thisurl == 'index.php'))
         || (($_SESSION['justloggingin'] == 1) && ( $thisurl == 'bc2companydashboard.php' ||$thisurl == 'index.php'))
         ) 
         {// no menu item out  //1
         }
 /**        
         else   //1
        { //1
          $dbNav = $dbNav . ' <li class="nav1 '   .$dn['rescon_menustyle']  ;
          $dbNav = $dbNav . '"><p><a href="' ; 
          $_SESSION['$usempempid'] ="";
          if(isset($_SESSION['$usempempid']))  // = "_empid";)
            {
                if ($thisurl == 'bc2companydashboard'  || $thisurl == 'bc2companydashboard.php')
                {
                    $dbNav = $dbNav  . 'bc2companydashboard'.$_SESSION['$usempempid'].'.php "  title= " Click to Switch Companies';
                }
           }
                else{$dbNav  = $dbNav  . $dn['rescon_url']  ;
                }
                
              if ( strpos($dn['rescon_url'], "php") > 0) // 2
              {   
              } else //2
              {
              //$dbNav =    $dbNav   .    '.php"   ' ;
              }   //-2
         
               
            
               $dbNav =      $dbNav .  '  ">  ';
               $dbNav =    $dbNav  . $dn['rescon_menu'];
               $dbNav =  $dbNav   .  ' </a></p><div class="subtext">';
               $dbNav =  $dbNav       .$dn['rescon_menusubtext'] ;
                $dbNav =  $dbNav   . ' </div>    </li>';
           } //1
**/           
         
    }//0
 //   $buffer .=     'in transmit line 36  dbNav: ' .  $dbNav;
  //  $buffer .=     'in transmit line 37  <br/> ***************************************';
 // } //--1

if ($_SESSION['justloggingin'] == 1) $_SESSION['justloggingin']  = 0;
 //$_SESSION['justloggingin'] 
switch ($response) {    //-1
	case "content":
		$buffer = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>' . @$title . ' - BC2MATCH</title>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
		'.@$cssLinks.'
		'.@$scriptLinks.'
		<script type="text/javascript">
//<![CDATA[
' . @$headerScript . '  
//]]>
		</script>
'.$hipposcript.'
		<style type="text/css">
' . $cssInline . '
		</style>
	</head>'.$buffer;
		$templateData = '';
	
		foreach (file($siteFileRoot."inc/templates/".$template.".tmplt") as $line) if (substr($line, 0, 2) != "//" ) $templateData .= $line . "\r\n";
		// fill blocks with fixed data
		if ($header!='') $templateData = str_replace("<<<header>>>", $header, $templateData); else $templateData = str_replace("<<<header>>>", "", $templateData); 
		if ($adminNav!='') $templateData = str_replace("<<<admin>>>", $adminNav, $templateData); else $templateData = str_replace("<<<admin>>>", "", $templateData); 
		$templateData = str_replace("<<<nav1>>>", "<div id='nav1'><ul class='nav1'>".$dbNav.$nav1."</ul></div>", $templateData);
		if ($nav2!='') $templateData = str_replace("<<<nav2>>>", "<div id='nav2'>".$nav2."</div>", $templateData); else $templateData = str_replace("<<<nav2>>>", "", $templateData); 
		if ($content!='') $templateData = str_replace("<<<content>>>", $content, $templateData); else $templateData = str_replace("<<<content>>>", "", $templateData); 
		if ($footer!='') $templateData = str_replace("<<<footer>>>", $footer, $templateData); else $templateData = str_replace("<<<footer>>>", "", $templateData); 
		if ($notifications!='') $templateData = str_replace("<<<notifications>>>", $notifications, $templateData); else $templateData = str_replace("<<<notifications>>>", "", $templateData); 
		if ($footerScript!='') $templateData = str_replace("<<<footerScript>>>", '<script type="text/javascript">
//<![CDATA[
'.$footerScript.'
//]]>
		</script>', $templateData); else $templateData = str_replace("<<<footerScript>>>", "", $templateData);

		// fill blocks with dynamic (sql) data
		if (isset($dbdata)) $templateData = str_replace("<<<data>>>", $dbdata, $templateData); else $templateData = str_replace("<<<data>>>", "", $templateData);
		// load buffer and flush template data   
		//	$buffer .= " SELECT * FROM res_content WHERE rescon_menuscope IN ('All',".$contypes.") ORDER BY rescon_order ASC ";
			$buffer .=  ' <!-- <br> from transmit line 124 - SESSION[justloggingin]: ' . $_SESSION['justloggingin']. ',SESSusr_auth: '.  $_SESSION['usr_auth'] .
			'<br> sess comdash_exists: ' .$_SESSION['$comdash_exists'] . ' my_pagename: ' . $my_pagename. '<br/> -->';
		$buffer .= $templateData . '</html>'; $templateData = '';
		//header("Content-"); $my_pagename
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		echo $buffer;
		break;
	case "ajax":
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		header("Content-Type: application/xhtml+xml");
		echo '
		<script type="text/javascript">
//<![CDATA[
' . @$headerScript . '
//]]>
		</script>' 
		. $hipposcript 
		. $content . '
		<script type="text/javascript">
//<![CDATA[
' . @$footerScript . '
//]]>
		</script>';
		break;
	case "data":
		//header('Content-Type: application/json');
		header('Content-Type: '.$contentType); // application/pdf
		header('Content-Disposition: attachment; filename="'.$contentName.'"');
		header("Content-Length: " . strlen($contentData));
		echo $contentData;
} //---1

die();
