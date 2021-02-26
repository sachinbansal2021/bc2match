<?php
define('C3cms', 1);
$pageauth = 1;

require('core.php');

$output = ''; $delimiter = ""; 
$output .= 'var tinyMCEImageList = new Array(';
$fTable= Q2T("SELECT resfil_datapath, resfil_name FROM res_files ");//WHERE resfil_mime LIKE 'image%' ");

foreach ($fTable as $fRow) {
                $output .= $delimiter
                    . '["'
                    . utf8_encode($fRow['resfil_name'])
                    . '", "'
                    . utf8_encode($fRow['resfil_datapath'])
                    . '"],';
}

$output = substr($output, 0, -1); 
$output .= $delimiter;
$output .= ');';
header('Content-type: text/javascript');
header('pragma: no-cache');
header('expires: 0'); 
echo $output;
