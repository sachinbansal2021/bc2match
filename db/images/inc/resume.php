<?php
if (!defined('C3cms')) die('');
if (!defined('C3cmsCore')) die('');

$userID = 0;
if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; $_SESSION['view_id'] = $userID;
$_SESSION['resumePrint'] = $userID;
include('renderResume.php');
