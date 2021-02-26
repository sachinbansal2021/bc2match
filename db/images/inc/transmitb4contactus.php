<?php    
if (!defined('C3cms')) die('Direct access not allowed!');
if (!defined('C3cmsCore')) die('Not defined Core');
$contypes = '';
switch ($_SESSION['usr_auth']) {
	default: case "0": $contypes .= "'Public', 'PubApp', 'PubEmp', 'PubMgr'"; break;
	case "1": $contypes .= "'Applicants', 'PubApp', 'AppEmp', 'AppMgr'"; break;
	case "2": $contypes .= "'Employers', 'PubEmp', 'AppEmp', 'EmpMgr'"; break;
	case "3": $contypes .= "'Managers', 'PubMgr', 'EmpMgr', 'MgrAdm'"; break;
	case "4": case "5": case "6": $contypes .= "'MgrAdm', 'Admin'"; break;
	case "9": $contypes .= "'Employers', 'PubEmp', 'AppEmp', 'EmpMgr'"; break;
}
$dbNav = ''; $dnQ = Q2T("SELECT * FROM res_content WHERE rescon_menuscope IN ('All',".$contypes.") ORDER BY rescon_order ASC");
// lloyd 91318 need .php
 $thisURL = '';
 $extloc = '';
if ($dnQ)
  { foreach($dnQ as $dn)
    { 
       $dbNav = $dbNav . ' <li class="nav1 '   .$dn['rescon_menustyle']  ;
       $dbNav = $dbNav . '"><p><a href="' ; 
         $dbNav  = $dbNav  . $dn['rescon_url']  ;
      
           if ( strpos($dn['rescon_url'], "php") > 0)
           {   
            } else
            {
              $dbNav =    $dbNav   .    '.php"   ' ;
            }
             $dbNav =      $dbNav .  '  ">  ';
           $dbNav =    $dbNav  . $dn['rescon_menu'];
           $dbNav =  $dbNav   .  ' </a></p><div class="subtext">';
               $dbNav =  $dbNav       .$dn['rescon_menusubtext'] ;
              $dbNav =  $dbNav   . ' </div>    </li>';
    }
 //   $buffer .=     'in transmit line 36  dbNav: ' .  $dbNav;
  //  $buffer .=     'in transmit line 37  <br/> ***************************************';
  }

switch ($response) {
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
		$buffer .= $templateData . '</html>'; $templateData = '';
		//header("Content-");
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
		</script>' . $content . '
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
}

die();
