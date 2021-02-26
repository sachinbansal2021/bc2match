<?php

//  Employers
//-- page settings
define('C3cms', 1);
$title = "Member Dashboard";
$pageauth = 2; // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$_SESSION['$usempempid'] = ""; /////"_empid";
$usempempid = $_SESSION['$usempempid']; // "_empid"; //".$usempempid."
//$template = "jobcon"; //.$usempempid;
$template = "jobcon".$usempempid; 
$response = "content";
////$usempempid = $_SESSION['$usempempid'];// "_empid";   //".$usempempid."
require "inc/core.php";

//-- define content -----------------------------------------------------------------
$scriptLinks .= '<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
				<script type="text/javascript" language="javascript" src="js/jquery.colorbox.js"></script>
				<script type="text/javascript" language="javascript" src="js/jquery.jeditable.js"></script>';
//$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/colorbox.css" />';
//$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/tooltip.css" />';
$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/colorbox.css" />';
$cssLinks .= '<link rel="stylesheet" type="text/css" href="css/tooltip.css" />';
/* $cssLinks .= '<style>
            #footer{
                max-width: 1100px;
                position: relative;
                margin-left: auto;
                margin-right: auto;
                border-left: 1px solid black;
                border-right: 1px solid black;
                box-shadow: 0px 0px 15px #000;
            }
            <style>';
*/

$content .= "<!--br>trace 22 Start Dashboard at: " . date('Y-m-d H:i:s') . "  lloyd fixtest 082719 version -->";

$content .= "<!-- br> trace 28 set memory limit to 640M" . date('Y-m-d H:i:s') . "  <br  set memory limit to 1000M -->";
ini_set('memory_limit', '640M');

$content .= "<!--  31 br>Start dashboard Memory limit: " . (ini_get("memory_limit")) . " B\n\n" . "<br -->";

$content .= "<!-- br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
$content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n -->  ";
$content .= "<!-- br>******************" . date('Y-m-d H:i:s') . "*********************************************-->  ";

$userID = 0;
$userType = $_SESSION['usr_type'];
$userCompany = 0;

if (intval($_SESSION['usr_auth']) == 1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id'];

$_SESSION['view_id'] = $userID;

//echo $_SESSION['usr_company'].' - '.$_SESSION['usr_type'].'<br><br>';
$userCompany = $_SESSION['usr_company']; // this may now of a different company rather than one origianally tied to the usr_id
//echo $userCompany.' - '.$userType;//exit();
$content .= "<!--br> trace 33 b4 use reqa userID = " . $userID . ", userCompany = " . $userComapany . " (= sess usr_company)";
$content .= "<br> 34 rEQUEST [usr] = " . $_REQUEST['usr'] . ",  REQUEST [empid]= " . $_REQUEST['empid'] . " --> ";

/////if (isset($_REQUEST['usr']) ) $userID= $_REQUEST['usr'];
/////if (isset($_REQUEST['empid'])) $userCompany = $_REQUEST['empid'];
if (isset($_REQUEST['usr']))
{
    $userID = $_REQUEST['usr'];
    $_SESSION['passprofile_usr'] = $userID;
}
if (isset($_REQUEST['company_id']))
{
    $userCompany = $_REQUEST['company_id'];
    $_SESSION['passprofile_emp'] = $userCompany;
}
if (isset($_REQUEST['usr']))
{
    $userID = $_REQUEST['usr'];
}
else
{
    $userID = $_SESSION['usr_id'];
}
$_SESSION['passprofile_usr'] = $userID;
if (isset($_REQUEST['company_id']))
{
    $userCompany = $_REQUEST['company_id'];
}
else
{
    $userCompany = $_SESSION['usr_company'];
}
$_SESSION['passprofile_emp'] = $userCompany;

$userID = $_SESSION['passprofile_usr']; //= $userID;set im dashboard bc2memmbers lloys profileusremp
$emp_ID = $_SESSION['passprofile_emp']; //=$userCompany;
$thisuserType = QV("Select usr_type from usr where usr_id=" . $userID);
$content .= "<!-- br>b!-- br> trace 38 b4 use req vars now userID = " . $userID . ", userCompany = " . $userCompany . " ( -->";
$content .= "<!-- br> trace 42 thisuserType: " . $thisuserType . ", userType: " . $userType . ", userID: " . $userID . ", userCompany" . $userCompany . "-->";
//echo $_SESSION['usr_auth'];
// exit();;
////$_SESSION['passprofile_usr']= $userID;
//// $_SESSION['passprofile_emp']=$userCompany;
$content .= "<!--br> trace 47 _SESSION['passprofile_usr']: " . $_SESSION['passprofile_usr'] . ", _SESSION['passprofile_emp']: " . $_SESSION['passprofile_emp'] . " -->";
if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_emp.php\';\" >Return to Employers List</div>");';

$empSection = @$_REQUEST['empSection'] or $empSection = @$_SESSION['empSection'] or $empSection = "pst";
$_SESSION['empSection'] = $empSection;

////$content .= "!!!!" . $empSection . "!!!!" . print_r($_REQUEST,true). print_r($_SESSION,true);
$opRec = CleanI($_REQUEST['rec']);
//Make Title, Agency/Prime and Your Rating columns sortable  for tojo 10/19/18 lloyd
$orderby = ($_REQUEST['orderby']);
$content .= '<!-- trace 77>  orderby: ' . $orderby . " -->";
$emp_ID = $userCompany; // we now have the company in a SESSION variable lloyd   QV("SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'");


$content .= DBContent();

/*
echo "[".$content."]";
exit();
*/

$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '" . $userID . "'"); // ?usertype  lloyd 3/15/19'".$userID."'");   //== 0)
// show Company Name on line below Member Name above dashboard  tojo by lloyd
//Need to modify the below to get the particular company for this user that was selected in be bc2companydashboard - lloyd
/*$usrData = Q2R("Select usr.usr_id, usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type , emp.emp_name
                from usr usr left join emp emp on usr.usr_company =  emp.emp_id 
                             inner join usr_emp usemp on emp.emp_id = = usemp.usremp_emp_id 
                 WHERE usr_id = '".$userID."'   and usemp.usremp_emp_id = '".$empID."'" );

 $usrData = Q2R(" Select   usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type ,emp.emp_id, emp.emp_name
                  , usemp.usremp_usr_assignedusr_id as usr_id, usemp.usremp_emp_id
                  from usr usr inner join emp emp on usr.usr_company =  emp.emp_id 
                               inner join usr_emp usemp on emp.emp_id  = usemp.usremp_emp_id 
                  WHERE usemp.usremp_usr_assignedusr_id ='".$userID."'     
                                              and emp.emp_id = '".$empID."'"  );
*/

/*
$content .= "<!--    br>line 66 bc2members Q2R is: ***************************
              <br>Select   usr.usr_email, usr.usr_firstname as usr_firstname, usr.usr_lastname as usr_lastname , usr.usr_type ,emp.emp_id, emp.emp_name as emp_name
                  , usemp.usremp_usr_assignedusr_id as usr_id, usemp.usremp_emp_id 
                  from usr usr inner join emp emp on usr.usr_company =  emp.emp_id  
                               inner join usr_emp usemp on emp.emp_id  = usemp.usremp_emp_id  
          WHERE usemp.usremp_usr_assignedusr_id ='".$userID."' and emp.emp_id = '".$empID."'   and usr.usr_email like '".$_SESSION['usr_email']."' ;
         
                                               //      and usr.usr_id ='".$userID."'
$content .= "   Select   usr.usr_email, usr.usr_firstname as usr_firstname, usr.usr_lastname as usr_lastname , usr.usr_type ,emp.emp_id, emp.emp_name as emp_name
                  , usemp.usremp_usr_assignedusr_id as usr_id, usemp.usremp_emp_id 
                  from usr usr inner join emp emp on usr.usr_company =  emp.emp_id  
                               inner join usr_emp usemp on emp.emp_id  = usemp.usremp_emp_id  
                  WHERE usemp.usremp_usr_assignedusr_id ='".$userID."' and emp.emp_id = '".$empID."' and usr.usr_email like '".$_SESSION['usr_email']."' ";
$usrData = Q2R(" Select   usr.usr_email, usr.usr_firstname as usr_firstname, usr.usr_lastname as usr_lastname , usr.usr_type ,emp.emp_id, emp.emp_name as emp_name
                  , usemp.usremp_usr_assignedusr_id as usr_id, usemp.usremp_emp_id 
                  from usr usr inner join emp emp on usr.usr_company =  emp.emp_id  
                               inner join usr_emp usemp on emp.emp_id  = usemp.usremp_emp_id  
                  WHERE usemp.usremp_usr_assignedusr_id ='".$userID."' and emp.emp_id = '".$empID."' and usr.usr_email like '".$_SESSION['usr_email']."' ");
                  //usr.usr_id ='".$userID."' " );
               //   and usr.usr_id ='".$userID."'
            //         WHERE usemp.usremp_usr_assignedusr_id ='".$userID."' and emp.emp_id = '".$empID."' and usr.usr_email like '" .$_SESSION['usr_email']. "' " );
*/
$content .= "<!-- br> !-- line 82 members: usrData[usr_type]: " . $usrData['usr_type'] . "  !!!!userType: " . $userType . ", sess userid: " . $userID . ",   emp_id: " . $emp_ID . " SESSION[ usr_email ]: " . $_SESSION['usr_email'] . " -->";

/*
if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)){
	$adminUser = $_SESSION['admin_user'];
	$systemAdmin = '<td><center><a href="/'.$_SESSION['env'].'/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}
*/
if (($userType == 0) && ($usrData['usr_type'] == 1)) ////if ($thisuserType == 0)

{
    $adminUser = $_SESSION['admin_user'];
    $systemAdmin = '<td><center><a href="/' . $_SESSION['env'] . '/admin_usr.php?usr=' . $_SESSION['passprofile_usr'] . '&ptype=admin&userCompany=' . $_SESSION['passprofile_emp'] . '">
	ADMIN Panel</a></center></td>';
    ////	admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
    
}

if ($userType == 99)
{
    $adminUser = $_SESSION['admin_user'];
    $systemAdmin = '<td><center><a href="/' . $_SESSION['env'] . '/bc2_admins.php?usr=' . $adminUser . '&ptype=admin">ADMIN Panel</a></center></td>';
}

$empname = QV("SELECT emp_name from emp where emp_id = '" . $emp_ID . "';");
$emplevel = QV("SELECT emp_level from emp where emp_id = '" . $emp_ID . "';");
//$content .= ' <br> trace 106 _REQUEST[noop]: '.  $_REQUEST['noop'];
$usr_welcome_flagSQL = "select usr_welcome_flag from usr where usr_id =" . $userID . "";
$usr_welcome_flag = QV($usr_welcome_flagSQL);
$content .= "<!-- br> br>trace 113 bc2members; usr_welcome_flag: " . $usr_welcome_flag . " < !--, usr_welcome_flagSQL: " . $usr_welcome_flagSQL . "-->";

/* $content .= '<div style="text-align:center;display:block" id="showwelcomeDIV" >';
 
 $content .= '<button onmouseover="myshowhideFunction()">Show Welcome</button  > 
 </div> ';<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Government/Commercial Matches</strong>
*/
switch ($userType)
{
    case 0:
        $showusertype = 'Primary';
    break;
    case 1:
    default:
        $showusertype = 'Regular';
    break;
}
switch ($emplevel)
{
    case 1:
        $subleveldesc = "Silver";
        //$levelcolor = "#f2f2f2";
        $levelfgcolor = "#f2f2f2"; //"#f5f5f5";
        
    break;
    case 2:
        $subleveldesc = "Gold";
        // $levelcolor = "#FFD700";
        $levelfgcolor = "#FFD700";
    break;
    case 3:
        $subleveldesc = "Platinum";
        // $levelcolor
        $levelfgcolor == "#F4F4F4"; // White Smile
        
    break;
    default:
        $subleveldesc = "Gold";
        // $levelcolor = "#FFD700";
        $levelfgcolor = "#FFD700";
    break;
}
// $userType $empname $emplevel
$content .= '<br><div align="center">';
if ($usr_welcome_flag == 0)
{
    $content .= ' <div align="center" style="text-align:center;display:none;background-color:#9fcfff; border-radius: 10px 10px 10px 10px;width:500px;" id="mywelcomeDIV" >
         <br>  Welcome to BC2Match, first time ' . $showusertype . ' Member!';
    if ($userType == 0)
    {
        $content .= '<table align="center">
         <tr><td>
         As a ' . $showusertype . ' member you  
          <ul align="left">  
         <li>will see the dashboard below </li>
         <li>can edit your profile </li>
         <li> can create other members</li>
         <li> can manage your account</li>
         <li> can buy more seats</li>';
        if ($emplevel <= 1)
        {

            $content .= '  <li> Upgrade your company subscription level</li>';
        }
        $content .= '</ul>
         </td></tr></table>
         ';
        $content .= ' Your company, ' . $empname . ' is at subscription level ' . $subleveldesc . '.'; // <span style="background-color:'.$levelfgcolor.' "></span>';
        // $levelcolor = "#FFD700";   			            $levelfgcolor = "#FFD700";
        if ($emplevel == 1)
        {
            $content .= '<br> At this  <span style="background-color:' . $levelfgcolor . ';"> level you may see a dashboard of opportunities that match your profile.</span>';
        }
        elseif ($emplevel == 2)
        {
            $content .= ' <br>At this  <span style="background-color:$levelfgcolor "> level </span>you ';
            $content .= '<table align="center">
                   <tr><td>
                   <ul align="left">   
 			  	  <li>   may see a dashboard of opportunities that match your profile.</li>
 			  	  <li>  click on an opportunity in the dashboard to see details.</li>
 			  	  
 			  	  <li>  can build your team/opportunity.</li>';
            if ($userType == 0)
            {
                $content .= '<li>can see solicitation emails and contact information.</li>
 			  	      <li> can see any other member dashboards.</li>
 			  	      <li> can see matching company  scorecards.</li>
 			  	      <li> can build your team.</li>';
            }
            $content .= '</ul>
               </td></tr></table>
 			  	 
 			  	  ';
        }
        // } //??
        
    }
    elseif ($userType == 1)
    {
        $content .= ' <table align="center">
         <tr><td>
         As a ' . $showusertype . ' member you  
          <ul align="left">  
         <li>be will see the dashboard below </li>
         <li>can edit your profile </li>
          
         </ul>
         </td></tr></table>
         ';

    }
    $content .= '<!-- br><button onclick="myhidewelcomeFunction()">Dismiss Welcome</button> 
     <br --></div> ';

    //echo ' myshowhideFunction() ';
    
}
elseif ($usr_welcome_flag >= 1)
{
    // $content .= '<div align="center" style="text-align:center;display:none;background-color:#9fcfff; border-radius: 10px 10px 10px 10px;width:600px;" id="mywelcomeDIV" >
    //<br> Welcome to BC2Match, first time Primary user!';
    // $content .= '<br><button onclick="myhidewelcomeFunction()">Dismiss Welcome</button>
    //</div> ';
    
}
$content .= '</div>';
$uppdatewelcomeflag = $usr_welcome_flagupdate + 1;
$usr_welcome_flagupdate = "update usr set usr_welcome_flag = " . $uppdatewelcomeflag . " where usr_id =" . $userID . "";
$usr_welcome_update = Q($usr_welcome_flagupdate);
$content .= '<!-- br> trace 239 usr_welcome_update: ' . $usr_welcome_update . ' -->';

/*if($emp_level<=1){
	$thisptype=$_REQUEST['ptype'];
	$genericactioncompanyaddseats = 4;
	$thisusername =  QV("Select usr_email from usr where usr_id = ".$_REQUEST['usr'] . " ");
	$thiscompany_name = QV("Select emp_name from emp where emp_id =". $userCompany . " ");
	$thisusr_firstname = QV("Select usr_firstname from usr where usr_id = ".$_REQUEST['usr'] . " ");
	$thisusr_lastname = QV("Select usr_lastname from usr where usr_id = ".$_REQUEST['usr'] . " ");
	$thisusr_usrtype = QV("Select usr_type from usr where usr_id = ".$_REQUEST['usr'] . " ");
	if($thisusr_usrtype==0 || $thisusr_usrtype==99){
		$thisptype = 'admin';
	}
	$sqlGetEmpSeats = "SELECT emp_id, emp_name, emp_level,emp_seats_occupied,emp_number_seats  FROM emp where emp_id ='".$userCompany."'"; // lloyd 3/6/19$_SESSION['usr_company']."'";
	$thisrowseats =  Q2R($sqlGetEmpSeats);
	if ( $thisrowseats)
    {
		$emp_seats_occupied = $thisrowseats['emp_seats_occupied'];
		$emp_number_seats = $thisrowseats['emp_number_seats'];
		$emp_level =  $thisrowseats['emp_level'];
		$emp_name = $thisrowseats['emp_name'];
      
    }else { 
        $emp_seats_occupied =-99;
		$emp_number_seats  = -99;  // $emp_seats_occupied $emp_number_seats 
		$emp_level =  1;
		$emp_name = "Unknown";
    }
	$genericseatslevel='&generic_level='.$emp_level.'&generic_numseats='.$emp_number_seats.'&generic_numseatsoccupied='.$emp_seats_occupied;
	$genericnames= '&generic_usr_firstname='.$thisusr_firstname.'&generic_lastname='.$thisusr_lastname.'&generic_companyname='.$thiscompany_name;
	$genericactioncompany ='&generic_actioncompany='.$genericactioncompanyaddseats;
	$locationhref='location.href=';
	$upgradelevellocationhref=$locationhref.'"joinnow.php?join_op=upgradelevelexistcompany&frompage=manageaccount&ptype='.$thisptype.'&usr='.$userID;
	 $upgradelevellocationhref.='&empid='.$userCompany.'&generic_company_id='.$userCompany.'&generic_assignedusr_id='.$userID.'&generic_username='.$thisusername   ;
  
    $upgradelevellocationhref.=$genericnames;
    $upgradelevellocationhref.= $genericseatslevel;
    $upgradelevellocationhref .= $genericactioncompany .'"';
$content .= '<center><div class="alert" style="padding: 20px; background-color: #f47c36; color: white;border-radius: 10px; width: 80%"> 
  <strong>Notice!</strong> For full access, please upgrade your level. To upgrade <a style="color: #fff; font-weight: bold;" href="#" onclick='.$upgradelevellocationhref.'>click here</a>.
</div></center>';
}*/

////need req  $content .= ' <br/><div style="text-align:center;">' . $_SESSION['usr_firstname'] . ' ' . $_SESSION['usr_lastname']. '<br/> ' ;
$content .= ' <br/><div style="text-align:center;">' . $usrData['usr_firstname'] . ' ' . $usrData['usr_lastname'] . '<br/> ';
$content .= $empname . '</div>';
//$content .=  $usrData['emp_name'] .  '</div>';
/*
 $content .= ' <br/><div style="text-align:center;">' . $_SESSION['usr_firstname'] . ' ' . $_SESSION['usr_lastname']. '<br/> ' ; 
$content .=  $_SESSION['emp_name'] .  '</div>';  if ( $thisuserType == 0)
*/
$content .= '<br><br><div style="text-align:center;">
<table style="height: 21px;" width="600" align="center">
<tbody>
<tr>
<td><a href="/' . $_SESSION['env'] . '/applicants.php?usr=' . $_SESSION['passprofile_usr'] . '&company_id=' . $_SESSION['passprofile_emp'] . '">Member Profile</a></td>';
if (($emplevel > 1) || $userType == 99) // per Tom 6/4/19 silver members can not see these  was emplevel > 0

{
    $content .= '<td><a href="/' . $_SESSION['env'] . '/p_admins.php?usr=' . $_SESSION['passprofile_usr'] . '&company_id=' . $_SESSION['passprofile_emp'] . '">Search Members</a></td>';
    $content .= '<td><a href="/' . $_SESSION['env'] . '/employers.php?usr=' . $_SESSION['passprofile_usr'] . '&company_id=' . $_SESSION['passprofile_emp'] . '">Build Your Team</a></td>';
}
//if ( ($userType==0 && $emplevel > 1) || $userType==99 || $userType==9 )
//{ $content .= '
//<td><a href="/'.$_SESSION['env'].'/employers.php?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'">Post a Job</a></td>';
/**<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'">Search</a></td>
 //<td><a href="/'.$_SESSION['env'].'/bc2members.php?usr='.$userID.'">Show ECAs*</a></td>';**/
//}
//$content .= '
$userPrimary = '';

//echo $userCompany.' - '.$userType;exit();
//echo 'userType [ '. $userType . ' ] <br>';
//echo 'usrData [ '. $usrData['usr_type'] . ' ]';
//exit();
//////   if ($usrData['usr_type'] == 0)
if ($thisuserType >= 0 && $emplevel > 0)
{

    $usremail = QV("select usr_email from usr where usr_id =" . $_SESSION['passprofile_usr']);

    //$_SESSION['usr_auth'] = 8;  ?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].
    $userPrimary = '<td><a href="/' . $_SESSION['env'] . '/admin_usr.php?usr=' . $_SESSION['passprofile_usr'] . '&ptype=admin&userCompany=' . $_SESSION['passprofile_emp'] . '">Manage Account</a></td>';
}

$content .= $userPrimary;

if ($thisuserType == 0)
{
    $company_cnt = QV("select count(*) as cnt from usr_emp where usremp_usr_id =" . $_SESSION['passprofile_usr']);

    if ($company_cnt > 1)
    {
        $content .= '<td><a href="/' . $_SESSION['env'] . '/bc2companydashboard' . $_SESSION['$usempempid'] . '.php">Your Company List</a></td>';
    }
}

$content .= $systemAdmin . '</tr>
</tbody>
</table>
</div>';
$content .= '<br><br><center><h1 style="text-align: center;"><span style="background-color: #ffffff;"><strong>BC2 Match Dashboard</strong></span></h1>';

if (($usrData['usr_firstname'] == 'TESTING') && ($usrData['usr_lastname'] == 'TESTING'))
{

    $content .= '<a href="http://www.bizconnectonline.com/bc2dev/bc2dev_samnaics.php">Run SamNaics</a><br><br>';

    $content .= '<br><br><table width="1004">
<thead>
<tr>
    <th width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></th>
    <th>Head 2</th>
    <th>Head 3</th>
    <th>Head 4</th>
    <th>Head 5</th>
</tr>
</thead>
<tbody height: 100px; display: inline-block; width: 100%; overflow: auto;>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>
<tr>
    <td>Content 1</td>
    <td>Content 2</td>
    <td>Content 3</td>
    <td>Content 4</td>
    <td>Content 5</td>
</tr>

</tbody>

</table><br><br>';
} //if (($usrData['usr_firstname'] == 'TESTING') && ($usrData['usr_lastname'] == 'TESTING'))


/*******************************************************************************
$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Government/Commercial Matches</strong></td>
</tr>
<tr>
<td width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
<td width="300" bgcolor="#808080" align="left"><font color="#ffffff"><strong>&nbsp;AGENCY/PRIME</strong></font></td>
<td width="65" bgcolor="#808080" align="center"><font color="#ffffff"><strong>YOUR RATING</strong></font></td>
<td width="85" bgcolor="#808080" align="right"><font color="#ffffff"><strong>DUE DATE</strong></font></td>
</tr>';

$usrTable = getUSRMatches();
$rcnt = 1;

$x = 0;

$matches = array();	
$match_jobid = array("first");
$match_title = array("first");
$match_agency = array("first");
$match_rating = array("first");
$match_deadline = array("first");
$match_percentage = array("first");
		
	if ($usrTable) foreach($usrTable as $usr) {
			
		$job = getJobInfo($usr['sysmat_job_id']);
		
		if ($job) foreach($job as $match) {
			$matchjobid = $match['job_id'];
			$matchTitle = $match['job_title'];
			$matchAgency = $match['job_buying_office'];
			$matchDeadline = $match['job_due_date'];
		}
		
		$totalCriteria = 0;
		
		$rating = getRating($usr['sysmat_job_id']);
		
		if ($rating) foreach($rating as $match) {
			$totalCriteria = $totalCriteria + $match['sum'];
		}

		$matchRating = $usr['sum']."/".$totalCriteria;
		$matchPercentage = $usr['sum'] / $totalCriteria;
		
		/**** Rating Fix - LJF ****/
		//$matchPercentage = (($usr['sum'] / $totalCriteria) * 100) + $totalCriteria ;
		$matchPercentage = ($matchPercentage * 100) + $totalCriteria ;

		$matches[$x] = array($matchPercentage,$matchjobid,$matchTitle,$matchAgency,$matchRating,$matchDeadline);
/*
				$matches[$x] = array('matchpercentage' => $matchPercentage,'matchid' => $matchjobid,'matchtitle' => $matchTitle,'matchagency' => $matchAgency,'matchrating' => $matchRating,'matchdeadline' => $matchDeadline);
*/

if (is_int($rcnt / 2)) $cellbgcolor = "#FFFFFF";
else $cellbgcolor = "#E8E8E8";

/*
		$content .= '<tr>
		<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matchjobid.'" >'.$matchTitle.'</td>		
		<td width="300" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchAgency.'</td>
		<td width="65" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matchRating.'</td>
		<td width="45" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchDeadline.'</td>
		<td width="40" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchPercentage.'</td>
		</tr>';
/		
		$rcnt = $rcnt + 1;
		$x = $x + 1;
	}
	else
			$content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Matches Found<br><br></strong></td></tr>';

  $content .="<br>trace 509 main  at does sort matches get done here?: " .   date('Y-m-d H:i:s') . " -->";
	array_multisort($matches,SORT_DESC);
 $content .="<br>trace 511  main  apparently it does: " .   date('Y-m-d H:i:s') . " -->";	
	 $content .="<br>trace 757main  at switch to determine what to start sort: " .   date('Y-m-d H:i:s') . " -->";
	$rcnt = 1;
	
	for($i = 0; $i < $x; $i++) {

			if (is_int($rcnt/2))
				$cellbgcolor = "#FFFFFF";
			else
				$cellbgcolor = "#E8E8E8";


/***** matches array reference key ***
			$matches[$i][0] = $matchPercentage
			$matches[$i][1] = $matchjobid
			$matches[$i][2] = $matchTitle
			$matches[$i][3] = $matchAgency
			$matches[$i][4] = $matchRating
			$matches[$i][5] = $matchDeadline
			/
			
			
			$content .= '<tr>
			<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matches[$i][1].'" >'.$matches[$i][2].'</td>		
			<td width="300" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matches[$i][3].'</td>
			<td width="65" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matches[$i][4].'</td>
			<td width="85" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matches[$i][5].'</td>
			</tr>';
			
			$rcnt = $rcnt + 1;
			
		}


$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table><br><br><br>';
*************************************************** *********/

/*******SCROLL BEGIN******/

$scrollit = 380;
//$scrollit = 400;
// Make Title, Agency/Prime and Your Rating columns sortable
$link_color = "#cccccc";
$linkbgcolor = "#aaaaaa";
$headerheight = " height=60";
$dothissort = "RatingDESC";

$titlesortreq = "ASC";
$agencysortreq = "ASC";
$ratingsortreq = "DESC";
$duedatesortreq = "ASC";
switch ($orderby)
{
    case "":
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
        $ratingsortreq = "ASC";
        $duedatesortreq = "ASC";

    break;
    case "TitleDESC":
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
        $ratingsortreq = "DESC";
        $duedatesortreq = "ASC";
    break;
    case "TitleASC":
        $titlesortreq = "DESC";
        $agencysortreq = "ASC";
        $ratingsortreq = "DESC";
        $duedatesortreq = "ASC";
    break;
    case "AgencyASC":
        $agencysortreq = "DESC";
        $titlesortreq = "ASC";
        $ratingsortreq = "DESC";
        $duedatesortreq = "ASC";
    break;
    case "AgencyDESC":
        $agencysortreq = "ASC";
        $titlesortreq = "ASC";
        $ratingsortreq = "DESC";
        $duedatesortreq = "ASC";
    break;
    case "RatingASC":
        $ratingsortreq = "DESC";
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
        $duedatesortreq = "ASC";
    break;
    case "RatingDESC":
        $ratingsortreq = "ASC";
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
        $duedatesortreq = "ASC";
    break;
    case "DueDateASC":
        $duedatesortreq = "DESC";
        $ratingsortreq = "DESC";
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
    break;
    case "DueDateDESC":
        $ratingsortreq = "DESC";
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
        $duedatesortreq = "ASC";
    break;
    default:
        $titlesortreq = "ASC";
        $agencysortreq = "ASC";
        $ratingsortreq = "ASC";
        $duedatesortreq = "ASC";
    break;
}
$duedateageinterval = 30; // if fbo job due date older than this many days, do not include in matches
/// for degugging  $usrTable = getUSRMatches();
if (1 == 2) //if ($usrTable)

{

    $content .= " <br count usrtable is: " . COUNT($usrTable) . "   $usrtable is <br> ";
    echo ' < !-- br> count usrtable is: ' . COUNT($usrTable) . '   $ usrtable is <br> ';

    echo '  <pre>';
    print_r($usrTable);
    echo '</pre> -->';
    //$content .= ' < !-- br> count usrtable is: ' . COUNT($usrTable).  '   $ usrtable is <br> ';
    //$content .= print_r($usrTable) ;
    // $content .= " --> ";
    // when remove empty titles
    
}
$content .= '<table width="1014">
<tbody>
<tr>
<td valign="Top" width="1000">
<div class="container" style="border:0px solid #ccc; width:1000px; " >  <!-- height: 60px; -->
<table cellspacing="1"  class="winner-table"  >
<tbody>
<tr>';

$content .= "<!-- br>   trace 648 my_pagename: " . $my_pagename . " --> ";
$help_index_5 = QV("Select help_message from contextual_help where help_pagename = '" . $my_pagename . "' and help_index = 5");
$content .= '<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Government/Commercial Matches</strong>
<div class="tooltip"><img src="images/help-15-trans.png"/><span class="tooltiptext">' . $help_index_5 . '</span></div>';
//echo ($content);
//exit;
// $content .='  <br/> To Sort, click on either Title, Agency or Your Rating. Sort will toggle between ASC and DESC. ';
if ($orderby == "")
{
    $content .= '<br> Now sorted by Rating (DESC)  </td> </tr>';

}
else
{
    $content .= '<br>  Now sorted by ' . $orderby . '  </td> </tr> ';
    ////$content .= "<!-- br> trace should not be reading matches this pass -->" ;
    
}
//echo ($content);
//exit;
$passprofile_usr = $_SESSION['passprofile_usr'];
$passprofile_emp = $_SESSION['passprofile_emp']; //.'&company_id='.$passprofile_emp.'  2/12/20 need pass this for sort to preserve get usr atch final query
$content .= '<tr ><td  width="540" height="40"  bgcolor="' . $linkbgcolor . '" align="center"><font color="' . $link_color . '"><strong>';
$content .= '        <a href="bc2members.php?usr=' . $passprofile_usr . '&ptype=dashboard&empid=' . $passprofile_emp . '&company_id=' . $passprofile_emp . '&orderby=Title' . $titlesortreq . '">TITLE</a></strong></font></td> ';

$content .= ' <td    width="280" bgcolor="' . $linkbgcolor . '" align="center"><font color="' . $link_color . '"><strong>';
$content .= ' <a href="bc2members.php?usr=' . $passprofile_usr . '&ptype=dashboard&empid=' . $passprofile_emp . '&company_id=' . $passprofile_emp . '&orderby=Agency' . $agencysortreq . '">&nbsp;AGENCY/PRIME</a></strong></font></td> ';

$content .= '<td    width="95" bgcolor="' . $linkbgcolor . '" align="center"><font color="' . $link_color . '"><strong> ';
$content .= ' <a href="bc2members.php?usr=' . $passprofile_usr . '&ptype=dashboard&empid=' . $passprofile_emp . '&company_id=' . $passprofile_emp . '&orderby=Rating' . $ratingsortreq . '">YOUR RATING</a></strong></font></td> ';

$content .= '<td    width="85" bgcolor="' . $linkbgcolor . '" align="center"><font color="' . $link_color . '"><strong> ';
$content .= ' <a href="bc2members.php?usr=' . $passprofile_usr . '&ptype=dashboard&empid=' . $passprofile_emp . '&company_id=' . $passprofile_emp . '&orderby=DueDate' . $duedatesortreq . '">DUE DATE</a></strong></font></td>';
$content .= '  </tr>'; //'&company_id='.$passprofile_emp.
//echo ($content);
//exit;
////?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'
// <td width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
//<td width="280" bgcolor="#808080" align="left"><font color="#ffffff"><strong>&nbsp;AGENCY/PRIME</strong></font></td>
//<td width="85" bgcolor="#808080" align="center"><font color="#ffffff"><strong>YOUR RATING</strong></font><br></td>
//<td width="85" bgcolor="#808080" align="right"><font color="#ffffff"><strong>DUE DATE</strong></font></td>
//href="bc2members.php?usr='.$userID.'&ptype=dashboard&orderby=Rating>YOUR RATING</></strong></font></td></td>
$content .= '</tbody>
</table>
<div>
</td>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:1000px; height: ' . $scrollit . 'px; overflow-y: scroll;">
<table cellspacing="0" cellpadding="3" class="winner-table"> <!--wascellspacing="1" lloyd--> 
<tbody>';
$content .= " <!-- br>trace 679 calling getUSRMatches at: " . date('Y-m-d H:i:s') . " -->";
////$duedateageinterval = 30;  // if fbo job due date older than this many days, do not include in matches
//echo ($content);
//exit;
$usrTable = getUSRMatches();
if ($usrTable)
{
    $content .= "<!--  br>trace 705 returned from getUSRMatches at: " . date('Y-m-d H:i:s') . " count usrTable = " . count($usrTable) . "-->";
	$countjobs = COUNT($usrTable);
}
else
{
    $content .= "<!--  br>trace 709 returned from getUSRMatches at: " . date('Y-m-d H:i:s') . " - no usrTable -->";
	$countjobs = 0;
}
// echo ($content);
// exit;

if ($usrTable)
{
    $rcnt = 1;

    $x = 0;

    $matches = array();
    $match_jobid = array(
        "first"
    );
    $match_title = array(
        "first"
    );
    $uppercasematch_title = array(
        "first"
    );
    $match_agency = array(
        "first"
    );
    $match_rating = array(
        "first"
    );
    $match_deadline = array(
        "first"
    );
    $match_percentage = array(
        "first"
    );
    // 5/12/19 some more deduping
    $currentjobTitle = '';
    $currentAgency = '';
    $currentjobSolicitation = '';
    $currentjobDuedate = '0000-00-00';
    $currentjobfedid = - 99;
    $currentfedjobtitle = ''; //$usr['fjob_title'];
    $content .= "<!--br>trace 729  main building match tables at: " . date('Y-m-d H:i:s') . " -->";
    //      echo ($content); // exit;
    $forloopcounter = 0;
    $currentsysmatjobid = 0;
    $currentjobid = 0;
    $none_check = 0; //if still set to 0 after the foreach then at least one job that was pulled back had a cert other than NONE
    if ($usrTable)
    {
        foreach ($usrTable as $usr)
        {

            if (!($currentsysmatjobid == $usr['sysmat_job_id'])) //
            
            {
                //echo $currentsysmatjobid." ----".$usr['sysmat_job_id']."<br>";
                $newjobTitle = trim($usr['job_title']);
                $newAgency = trim($usr['job_buying_office']);
                $newjobSolicitation = trim($usr['job_solicitation']);
                $newjobDuedate = $usr['job_due_date'];
                $newjobfedid = $usr['fed_id'];
                $newfedjobtitle = $usr['fjob_title'];
                $content .= "<!--trace 753  currentjobTitle=" . $currentjobTitle . ", currentfedjobtitle: " . $currentfedjobtitle . ", currentAgency=" . $currentAgency . ",currentjobSolicitation=" . $currentjobSolicitation . ",currentjobDuedate =" . $currentjobDuedate . ", currentjobfedid=" . $currentjobfedid . "-->";

                $content .= "<!--br> trace 751 after not equal then set = matchjobid: " . $matchjobid . ", currentjobid: " . $currentjobid . " --> ";
                $content .= "<!--trace 753 newjobTitle=" . $newjobTitle . ", newfedjobtitle: " . $newfedjobtitle . ", newAgency=" . $newAgency . ", newjobSolicitation=" . $newjobSolicitation . ",newjobDuedate =" . $newjobDuedate . ", newjobfedid=" . $newjobfedid . "-->"; //=strtoupper
                if (((strtoupper(trim($currentjobTitle)) == strtoupper(trim($newjobTitle))) && ($currentjobfedid > 0) && ($newjobfedid == 0) && ($currentjobSolicitation <> '') && ($newjobSolicitation == '')) || ($newjobTitle == ''))
                {
                    //title equ fed and fake  dupe                    //get next usr rec
                    if ($newjobTitle == '')
                    {
                        $currentsysmatjobid = $usr['sysmat_job_id'];
                    }
                    else
                    {
                        $currentjobTitle = $newjobTitle;
                        $currentAgency = $newAgency;
                        $currentjobSolicitation = $newjobSolicitation;
                        $currentjobDuedate = $newjobDuedate;
                        $currentjobfedid = $newjobfedid; //$currentsysmatjobid =  $usr['sysmat_job_id'];
                        $currentfedjobtitle = $newfedjobtitle; /// $usr['fjob_title'];
                        $currentsysmatjobid = $usr['sysmat_job_id'];
                        $currentinsertFBOFeed = $usr['insert_FBO_Feed'];
                    }

                }
                else
                {
                    $currentjobTitle = $newjobTitle;
                    $currentAgency = $newAgency;
                    $currentjobSolicitation = $newjobSolicitation;
                    $currentjobDuedate = $newjobDuedate;
                    $currentjobfedid = $newjobfedid; //$currentsysmatjobid =  $usr['sysmat_job_id'];
                    $currentsysmatjobid = $usr['sysmat_job_id'];
                    $currentinsertFBOFeed = $usr['insert_FBO_Feed'];
                    $currentfedjobtitle = $newfedjobtitle; ////$usr['fjob_title'];
                    $job = getJobInfo($usr['sysmat_job_id']); ////	$job = getJobInfo($usr['sysmat_job_id'],$emp_ID,$userID);
                    $initcounter = 1; //code to be executed;
                    $countshow = 0;
                    $countnoshow = 0;
                    $countshowjobs = COUNT($job);

                    if ($job) foreach ($job as $match)
                    {
                        ////
                        $content .= "<!--br> trace 752 in foreach job for sysmat jobid: " . $usr['sysmat_job_id'] . "-->"; // echo ($content);
                        $matchjobid = $match['job_id'];

                        $content .= "<!--br> trace 766 matchjobid: " . $matchjobid . ", currentjobid: " . $currentjobid . " --> ";
                        if (!($matchjobid == $currentjobid))
                        {
                            $currentjobid = $matchjobid;
                            $checkmatchTitle = $match['job_title']; // job_buying_office job_solicitation ,buying_office,due_date,Solicitation_num
                            $checkTitle = trim($checkmatchTitle);
                            $checkLeftTitle = substr($checkTitle, 0, 128);
                            //$Seeiffakedrop =  "SELECT Job_Title from FBO_IMPORT   where Job_Title LIKE '".$checkLeftTitle."%'" ;
                            $Seeiffakedrop = "SELECT job_title from jobs   where job_title LIKE '" . $checkLeftTitle . "%'";
                            // $getSeeifffakedrop  = QV($Seeiffakedrop) ;  //strtoupper = substr($currentfedjobtitle,0,128);
                            $getSeeifffakedrop = $currentfedjobtitle;
                            $trimgetSeeifffakedrop = trim($getSeeifffakedrop);
                            $content .= "<!--  trace 789 getSeeifffakedrop: " . $getSeeifffakedrop . " from " . $Seeiffakedrop . ", checkmatchTitle: " . $checkmatchTitle . ", checkLeftTitle: " . $checkLeftTitle . ", job_solicitation: " . $match['job_solicitation'] . ", job_buying_office: " . $match['job_buying_office'] . "--> ";
                            if ((!($getSeeifffakedrop == '')) && ($match['job_buying_office'] == '') && ($match['job_solicitation'] == ''))
                            { // no output
                                
                            }
                            else
                            {
                                //    should show if not 'Annual Updates and Technical Support of AHRQ Quality Indicators analytics provider'*/
                                $qaisFBOjob = $currentjobfedid; // QV("SELECT  fed_id from job where  job_id = ". $currentjobid."");
                                $qagencyname = $currentAgency; //// QV("SELECT  job_buying_office from job where  job_id = ". $currentjobid.""); //".$matchjobid." ");
                                $qagencyinsfbo = $currentinsertFBOFeed; ////QV("SELECT COUNT(*) from job  where insert_FBO_Feed  is not null    and   job_id = ".$currentjobid." ");
                                //// $qagencyupdfbo = QV("SELECT   COUNT(*) from job where  update_FBO_Feed is not null and job_id = ".$currentjobid." ");
                                ///// $qaagencycntNONull= QV("SELECT  COUNT(*)    from job_agencies where insert_FBO_Feed  is not null and jobskl_job_id = ".$currentjobid." ");
                                $job_due_date = $match['job_due_date'];
                                $content .= "<!-- trace 763 qaisFBOjob: " . $qaisFBOjob . ", qagencyname: " . $qagencyname . ", qagencyinsfbo: " . $qagencyinsfbo . ", agencycntNONul: " . $qaagencycntNONull . ", job_due_date: " . $job_due_date . " -->";
                                $matchtitlesupp = "<!--  br>showjobs: " . $countshowjobs . ", currentsysmatjobid: " . $currentsysmatjobid . ", qaagencycntNONull: " . $qaagencycntNONull . "--" . $match['job_id'] . " ? currentjobid: " . $currentjobid . ", j_agency : " . $qagencyname . ", qaagencyinsfbo: " . $qagencyinsfbo . ", qaagencyupdfbo: " . $qagencyupdfbo . ",job_due_date: " . $job_due_date . " --> ";
                                /////	 $content.= || (($qagencyupdfbo==0))
                                if ((!($qagencyinsfbo == '')) && (!($job_due_date == '0000-00-00')))
                                {
                                    // $currentjobid = $matchjobid;
                                    $matchTitle = trim($match['job_title']); ////////      $matchTitle = QV("select job_title from job where job_id ='".$matchjobid."'");
                                    $matchAgency = trim($match['job_buying_office']); // $matchTitle = ltrim($match['job_title']);
                                    $testmatchTitle = trim($matchTitle);
                                    $upperCasetitle = strtoupper(trim($matchTitle));
                                    $upperCasematch_title = strtoupper(trim($matchTitle));
                                    $matchTitle .= $matchtitlesupp;
                                    $matchAgency = trim($matchAgency);
                                    $matchAgency .= "<!--  !  j_agency : " . $qagencyname . ", insfbo:" . $qagencyinsfbo . ", updatefbo: " . $qagencyupdfbo . " --> ";
                                    /////	 $content.= "<!-- trace 736 -currentsysmatjobid: >|". $currentsysmatjobid. "|< match['job_title']: ". $match['job_title'] .", upperCasetitle: >>|".  $upperCasetitle ."|<<-, matchAgency: >>|". $matchAgency . "|<< -->"   ;
                                    /*$matchDeadline = str_replace("-","",$match['job_due_date']);  //str_replace(find,replace,string,count)  for sort will format later
                                     ////while duedate format is still 20dd-mm-yy need to reformat as 			    yy-mm-dd  */
                                    $reformatDeadline = $match['job_due_date']; //was 20dd-mm-yy but/\
                                    $reformatDeadline = str_replace("-", "", $reformatDeadline); //  now 20yy-mm-dd 1/3/19  to yyyymmdd lloyd now 20ddmmyy			 /*  Here:  ROMOVE WHEN DATE FIXED to YYYY-MM-DD*/
                                    $displayDay = substr($reformatDeadline, 6, 2);
                                    $displayMonth = substr($reformatDeadline, 4, 2);
                                    $displayYear = substr($reformatDeadline, 0, 4);
                                    $reformatDeadline = $displayYear . $displayMonth . $displayDay; //now yymmdd
                                    $matchDeadline = $reformatDeadline; //$rline =  	//// $content .=  	'<!-- matchDeadline = ' .	$matchDeadline . ', reformatDeadline= ' . $reformatDeadline . ' --> ';			   /* to here */
                                    $matchDeadline .= '';
                                }
                                elseif ($qagencyinsfbo == 0 && $qaisFBOjob == 0)
                                { // not fbo so put it out
                                    $matchTitle = ltrim($match['job_title']); ////////      $matchTitle = QV("select job_title from job where job_id ='".$matchjobid."'");
                                    $matchAgency = ltrim($match['job_buying_office']); // $matchTitle = ltrim($match['job_title']);
                                    $testmatchTitle = rtrim($matchTitle);
                                    $upperCasetitle = strtoupper(ltrim($matchTitle));
                                    $upperCasematch_title = strtoupper(ltrim($matchTitle));
                                    $matchTitle .= $matchtitlesupp;
                                    $matchAgency = ltrim($matchAgency);
                                    $reformatDeadline = $match['job_due_date']; //was 20dd-mm-yy but/\
                                    $reformatDeadline = str_replace("-", "", $reformatDeadline); //  now 20yy-mm-dd 1/3/19  to yyyymmdd lloyd now 20ddmmyy			 /*  Here:  ROMOVE WHEN DATE FIXED to YYYY-MM-DD*/
                                    $displayDay = substr($reformatDeadline, 6, 2);
                                    $displayMonth = substr($reformatDeadline, 4, 2);
                                    $displayYear = substr($reformatDeadline, 0, 4);
                                    $reformatDeadline = $displayYear . $displayMonth . $displayDay; //now yymmdd
                                    $matchDeadline = $reformatDeadline; //$rline =  	//// $content .=  	'<!-- matchDeadline = ' .	$matchDeadline . ', reformatDeadline= ' . $reformatDeadline . ' --> ';			   /* to here */
                                    $matchDeadline .= '';
                                }
                                else
                                {
                                } // fbo if
                                
                            } ////$getSeeifffakedrop
                            
                        } // if	$currentjobid = $matchjobid;    else //$currentsysmatjobid ==$usr['sysmat_job_id'];
                        
                    } //end foreach job
                    
                } //if job
                //}
                
            } // if fake dupeif   ( ($currentjobTitle == $newjobTitle))
            //}
            $totalCriteria = 0;
            ///// $totalCriteria = 4;
            ///// 	$rating = 1; // see if this is performance culpri
            ////
            $rating = getRating($usr['sysmat_job_id']); //,$userID,$emp_ID);
            ////
            $content .= "<!-- br>trace members 809 rating=" . $rating . " for " . $usr['sysmat_job_id'] . " --> ";
            /////
            if ($rating) foreach ($rating as $match)
            { /////
                $totalCriteria = $totalCriteria + $match['sum'];

                /******* RATINGS CALCULATION
                if ($usr['sysmat_job_id'] == '410168')
                echo "[".$totalCriteria."]";
                *********************************/

            }
            /////
            if ($totalCriteria == 0)
            { /////
                $totalCriteria = 4; /////
                
            }
            ///// echo ("bc2members 795 titalCriteria: " .$totalCriteria);
            $matchRating = $usr['sum'] . "/" . $totalCriteria;
            //$matchPercentage = $usr['sum'] / $totalCriteria; //?should ?no end foreach usr here
            
            /**** Rating Fix - LJF ****/
		    $matchPercentage = (($usr['sum'] / $totalCriteria) * 100) + $totalCriteria ;

            
            
            $matches[$x] = array(
                $matchPercentage,
                $matchjobid,
                $matchTitle,
                $matchAgency,
                $matchRating,
                $matchDeadline
            ); //for Ratings sort
            $titlestoSort[$x] = array(
                $matchTitle,
                $matchPercentage,
                $matchjobid,
                $matchAgency,
                $matchRating,
                $matchDeadline
            ); //for Title sort
            $AgenciestoSort[$x] = array(
                $matchAgency,
                $matchTitle,
                $matchPercentage,
                $matchjobid,
                $matchRating,
                $matchDeadline
            ); //for for Agency sort
            $jobduedatestoSort[$x] = array(
                $matchDeadline,
                $matchAgency,
                $matchTitle,
                $matchPercentage,
                $matchjobid,
                $matchRating
            ); //for due date sort
            $uppercasetitlestoSort[$x] = array(
                $upperCasetitle,
                $matchTitle,
                $matchPercentage,
                $matchjobid,
                $matchAgency,
                $matchRating,
                $matchDeadline
            ); //for UppercaseTitle sort
            $content .= "<!--br>******************" . date('Y-m-d H:i:s') . "*********************************************";
            $content .= "<br> bc2members917 After setting up all arrays to sort" . date('Y-m-d H:i:s');
            $content .= "<br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
            $content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n";
            $content .= "<br>******************" . date('Y-m-d H:i:s') . "********************************************* -->";

            /* for (init counter; test counter; increment counter) {
              code to be executed;
               }   $titlestoSort[$i][5];  */

            //
            

            //10/19/18 here we do some hacking to sort by different fields ''yd 10
            //Make Title, Agency/Prime and Your Rating columns sortable		// if by title put $matchtitle first in array; if sort by agency put $matchAgency first
            //
            /*
            $matches[$x] = array('matchpercentage' => $matchPercentage,'matchid' => $matchjobid,'matchtitle' => $matchTitle,'matchagency' => $matchAgency,'matchrating' => $matchRating,'matchdeadline' => $matchDeadline);
            */
            if (is_int($rcnt / 2)) $cellbgcolor = "#FFFFFF";
            else $cellbgcolor = "#E8E8E8";
            /*
            $content .= '<tr>
            <td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$userID.'&profileID='.$matchjobid.'" >'.$matchTitle.'</td>
            <td width="300" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchAgency.'</td>
            <td width="65" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$matchRating.'</td>
            <td width="45" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchDeadline.'</td>
            <td width="40" valign="Top" align="right" bgcolor="'.$cellbgcolor.'">'.$matchPercentage.'</td>
            </tr>';
            */
            $rcnt = $rcnt + 1;
            $x = $x + 1;

        }
    }
    else

    $content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Matches Found<br><br></strong></td></tr>';

    $rcnt = 1;
    $content .= "<!--  br> trace 787 try putting sorts here orderby  worked  >>|" . $orderby . "|<<  --> ";
    //                       *****************************
    //$orderby = "TitleDESC";
    switch ($orderby)
    {
        case "": //  $content .="<br>trace 759main  start sorting matches  desc at: " .   date('Y-m-d H:i:s') . " -->";
            //var_dump ($matches);
            array_multisort($matches, SORT_DESC);
        break;
        case "TitleDESC":
            //var_dump ($uppercasetitlestoSort);
            array_multisort($uppercasetitlestoSort, SORT_DESC); //4/4/19
            //echo "<br><br>";
            //var_dump ($uppercasetitlestoSort);
            
        break;
        case "TitleASC":
            array_multisort($uppercasetitlestoSort, SORT_ASC); //4/4/19
            
        break;
        case "AgencyASC":
            //    $content .="<br>trace 789 6main  start sortin agency asc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($AgenciestoSort, SORT_ASC);
        break;
        case "AgencyDESC": //         $content .="<br>trace 794 6main  start sortin agency desc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($AgenciestoSort, SORT_DESC);
        break;
        case "RatingDESC": //       $content .="<br>trace 799 6main  start sortin rating desc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($matches, SORT_DESC);
        break;
        case "RatingASC": //     $content .="<br>trace 809 6main  start sortin rating asc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($matches, SORT_ASC);
        break;
        case "DueDateASC": //         $content .="<br>trace 809 6main  start sortin due date asc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($jobduedatestoSort, SORT_ASC);
        break;
        case "DueDateDESC": //        $content .="<br>trace 814 6main  start sorting due date date desc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($jobduedatestoSort, SORT_DESC);
        break;
        default: //     $content .="<br>trace 819 6main  start sorting fefaut $mathes rating desc at: " .   date('Y-m-d H:i:s') . " -->";
            array_multisort($matches, SORT_DESC);
        break;
    }
    $content .= "<!--br>trace 857 6main  finished sorting   at: " . date('Y-m-d H:i:s') . " -->";
    $content .= "<!--br>trace 857 6main  start rendering match table at: " . date('Y-m-d H:i:s') . " -->";

    //        ****************************"
    $this_showTitle = '';
    $current_showTitle = '';
    $this_showduedate = '';
    $current_showduedate = '';
    for ($i = 0;$i < $x;$i++)
    {

        if (is_int($rcnt / 2)) $cellbgcolor = "#FFFFFF";
        else $cellbgcolor = "#E8E8E8";

        /*  **** matches array reference key ***
        * ** for desc sort by rating fraction
        $matches[$i][0] = $matchPercentage
        $matches[$i][1] = $matchjobid
        $matches[$i][2] = $matchTitle
        $matches[$i][3] = $matchAgency
        $matches[$i][4] = $matchRating
        $matches[$i][5] = $matchDeadline
        *************************************
        * for asc sort by title
        $titlestoSort
        $titlestoSort = array($matchTitle,$matchPercentage,$matchjobid,$matchAgency,$matchRating,$matchDeadline); //for Title sort
        $titlestoSort[$i][0] = $matchTitle
        $titlestoSort[$i][1] = $matchPercentage
        $titlestoSort[$i][2] = $matchjobid
        $titlestoSort[$i][3] = $matchAgency
        $titlestoSort[$i][4] = $matchRating
        $titlestoSort[$i][5] = $matchDeadline
        
        --------------------------
        for upper case sort by title   4/4/19
        /   * * 	* for asc sort by title
        $titlestoSort
        $titlestoSort = array($matchTitle,$matchPercentage,$matchjobid,$matchAgency,$matchRating,$matchDeadline); //for Title sort
        $uppercasetitlestoSort[$x] = array($upperCasetitle,$matchTitle,$matchPercentage,$matchjobid,$matchAgency,$matchRating,$matchDeadline); //for UppercaseTitle sort
          $uppercasetitlestoSort[$i][0] = $upperCasetitle
          $uppercasetitlestoSort[$i][1] = $matchTitle
          $uppercasetitlestoSort[$i][2] = $matchPercentage
          $uppercasetitlestoSort[$i][3] = $matchjobid
          $uppercasetitlestoSort[$i][4] =$matchAgency
          $uppercasetitlestoSort[$i][5] =$matchRating
          $uppercasetitlestoSort[$i][6] == $matchDeadline
        
        
        ***********************
        * for asc sort by agency
        * $AgenciestoSort
        *  $AgenciestoSort = array($matchAgency,$matchTitle,$matchPercentage,$matchjobid,$matchRating,$matchDeadline); //for for Agency sort
        *  $AgenciestoSort[$i][0] = $matchAgency
        *  $AgenciestoSort[$i][1] = $matchTitle
        *  $AgenciestoSort[$i][0] = $matchPercentage
        *  $AgenciestoSort[$i][0] = $matchjobid
        *  $AgenciestoSort[$i][0] = $matchRating
        *  $AgenciestoSort[$i][0] = $matchDeadline
        ********************
        */

        // below is for sorted by rating desc
        // $orderby = "Rating";
        /***          substr(string,start,length)
        no now 4/4/19
        $upperCasetitlestoSort[$i][0] =  $upperCasetitle
        ////$titlestoSort[$i][] = $matchTitle
        $titlestoSort[$i][1] = $matchPercentage
        $titlestoSort[$i][2] = $matchjobid
        $titlestoSort[$i][3] = $matchAgency
        $titlestoSort[$i][4] = $matchRating
        $titlestoSort[$i][5] = $matchDeadline
        
        
        
        
        */

        if (substr($orderby, 0, 5) == "Title")
        {

            $this_showTitle = $uppercasetitlestoSort[$i][1];

            $this_showduedate = $uppercasetitlestoSort[$i][6];
            if (($current_showduedate == $this_showduedate) && ($current_showTitle == $this_showTitle))
            {
                $rcnt = $rcnt - 1;
            }
            else
            {
                $current_showTitle = $this_showTitle;
                $current_showduedate = $this_showduedate;
                //	$predisplaythisduedate = $titlestoSort[$i][5];
                $predisplaythisduedate = $uppercasetitlestoSort[$i][6];

                //	if ((	$predisplaythisdueda$uppercasetitlestoSort[$i][6] == $matchDeadline
                //	$predisplaythisduedate =  '0') ||(	$predisplaythisduedate== 0 ))   $displaythisduedate = '';
                $displaythisduedate = formatDateDisplay($predisplaythisduedate);
                ///// $displaythisduedate = $predisplaythisduedate;   //change back when get new due date format  yyyy-mm-dd
                ////?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'
                ////?usr='.$_SESSION['passprofile_usr'].'&emp_id='.$_SESSION['passprofile_emp
                /*	 $uppercasetitlestoSort[$x] = array($upperCasetitle,$matchTitle,$matchPercentage,$matchjobid,$matchAgency,$matchRating,$matchDeadline); //for UppercaseTitle sort
                $uppercasetitlestoSort[$i][0] = $upperCasetitle
                $uppercasetitlestoSort[$i][1] = $matchTitle
                $uppercasetitlestoSort[$i][2] = $matchPercentage
                $uppercasetitlestoSort[$i][3] = $matchjobid
                $uppercasetitlestoSort[$i][4] =$matchAgency
                $uppercasetitlestoSort[$i][5] =$matchRating */
                $content .= '<tr>';
				//if($emp_level > 1){
			$content .= '<td width="550" class="title-field" valign="bottom" bgcolor="' . $cellbgcolor . '">
<a href="bc2jobprofile.php?usr=' . $_SESSION['passprofile_usr'] . '&emp_id=' . $_SESSION['passprofile_emp'] . '&profileID=' . $uppercasetitlestoSort[$i][3] . '" >' . $uppercasetitlestoSort[$i][1] . '</a></td>';
				/*} else {
					$content .= '<td width="550" class="title-field" valign="bottom" bgcolor="' . $cellbgcolor . '">' . $uppercasetitlestoSort[$i][1] . '</td>';
				}*/
			$content .= '<td width="287" valign="bottom" bgcolor="' . $cellbgcolor . '">&nbsp;' . $uppercasetitlestoSort[$i][4] . '</td>
			<td width="85" valign="bottom" align="center" bgcolor="' . $cellbgcolor . '">' . $uppercasetitlestoSort[$i][5] . '</td>
			<td width="72" valign="bottom" align="right" bgcolor="' . $cellbgcolor . '">' . $displaythisduedate . '</td>
				</tr>';
                /* replaces
                <td width="550" class="title-field" valign="bottom" bgcolor="'.$cellbgcolor.'"><a href="bc2jobprofile.php?usr='.$_SESSION['passprofile_usr'].'&emp_id='.$_SESSION['passprofile_emp'].'&profileID='.$titlestoSort[$i][2].'" >'.$titlestoSort[$i][0] .'</td>
                <td width="287" valign="bottom" bgcolor="'.$cellbgcolor.'">&nbsp;'. $titlestoSort[$i][3] .'</td>
                <td width="85" valign="bottom" align="center" bgcolor="'.$cellbgcolor.'">'.$titlestoSort[$i][4] .'</td>
                <td width="72" valign="bottom" align="right" bgcolor="'.$cellbgcolor.'">'.$displaythisduedate.'<a></td>
                </tr>';
                */
            }
        }
        if (substr($orderby, 0, 6) == "Agency")
        {
            /*  ***********************
             
            * for asc sort by agency
            * $AgenciestoSort
            *  $AgenciestoSort = array($matchAgency,$matchTitle,$matchPercentage,$matchjobid,$matchRating,$matchDeadline); //for for Agency sort
            *  $AgenciestoSort[$i][0] = $matchAgency
            *  $AgenciestoSort[$i][1] = $matchTitle
            *  $AgenciestoSort[$i][2] = $matchPercentage
            *  $AgenciestoSort[$i][3] = $matchjobid
            *  $AgenciestoSort[$i][4] = $matchRating
            *  $AgenciestoSort[$i][5] = $matchDeadline
            ********************
            */
            $this_showTitle = $AgenciestoSort[$i][1]; // $uppercasetitlestoSort[$i][1];
            $this_showduedate = $AgenciestoSort[$i][5]; //$uppercasetitlestoSort[$i][6]  ;
            if (($current_showduedate == $this_showduedate) && ($current_showTitle == $this_showTitle))
            {
                $rcnt = $rcnt - 1;
            }
            else
            {
                $current_showTitle = $this_showTitle;
                $current_showduedate = $this_showduedate;
                $displaythisduedate = '';
                $predisplaythisduedate = $AgenciestoSort[$i][5];
                //	if ((	$predisplaythisduedate =  '0') ||(	$predisplaythisduedate== 0 ))   $displaythisduedate = '';
                ////?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'
                ////?usr='.$_SESSION['passprofile_usr'].'&emp_id='.$_SESSION['passprofile_emp'].'
                $displaythisduedate = formatDateDisplay($predisplaythisduedate);

                $content .= '<tr>
			<td width="550" class="title-field" valign="bottom" bgcolor="' . $cellbgcolor . '">
			<a href="bc2jobprofile.php?usr=' . $_SESSION['passprofile_usr'] . '&emp_id=' . $_SESSION['passprofile_emp'] . '&profileID=' . $AgenciestoSort[$i][3] . '" >' . $AgenciestoSort[$i][1] . '</a></td>		
			<td width="287" valign="bottom" bgcolor="' . $cellbgcolor . '">&nbsp;' . $AgenciestoSort[$i][0] . '</td>
			<td width="85" valign="Topbottom" align="center" bgcolor="' . $cellbgcolor . '">' . $AgenciestoSort[$i][4] . '</td>
			<td width="72" valign="bottom" align="right" bgcolor="' . $cellbgcolor . '">' . $displaythisduedate . '</td>
				</tr>';
            }
        }
        if (substr($orderby, 0, 7) == "DueDate")
        { //DeadlineASC DESC
            /*  ***********************
             * for asc sort by deadline due date
             * 		 $jobduedatestoSort[$x] = array($matchDeadline,$matchAgency,$matchTitle,$matchPercentage,$matchjobid,$matchRating);   //for due date sort *  $jobduedatestoSort:
             *  $jobduedatestoSort[$i][0] = $matchDeadline
             *  $jobduedatestoSort[$i][1] = $matchAgency
             *  $jobduedatestoSort[$i][2] = $matchTitle
             *  $jobduedatestoSort[$i][3] = $matchPercentage
             *  $jobduedatestoSort[$i][4] = $matchjobid
             *  $jobduedatestoSort[$i][5] = $matchRating
             *
             ********************
            */
            $this_showTitle = $jobduedatestoSort[$i][2]; // $AgenciestoSort[$i][1];  // $uppercasetitlestoSort[$i][1];
            $this_showduedate = $jobduedatestoSort[$i][0]; //$AgenciestoSort[$i][5] ; //$uppercasetitlestoSort[$i][6]  ;
            if (($current_showduedate == $this_showduedate) && ($current_showTitle == $this_showTitle))
            {
                $rcnt = $rcnt - 1;
            }
            else
            {
                $current_showTitle = $this_showTitle;
                $current_showduedate = $this_showduedate;
                $displaythisduedate = '';
                /* Now format the date field - if value is '0000-00-00' put out ' ' else last tow / middle 2/ send two drop off centur
                So o => ' '
                
                Then drop lead 0 from day and month
                substr(string,start,length)
                */
                $displaythisduedate = '';
                $predisplaythisduedate = $jobduedatestoSort[$i][0];
                //	if ((	$predisplaythisduedate =  '0') ||(	$predisplaythisduedate== 0 ))   $displaythisduedate = '';
                $displaythisduedate = formatDateDisplay($predisplaythisduedate);
                /*{
                if ($predisplaythisduedate== '00000000') {
                $displaythisduedate ='';
                } else
                {$displayYear = substr($predisplaythisduedate,2,2);
                $displayMonth =  substr($predisplaythisduedate,4,2);
                $displayDay = substr($predisplaythisduedate,6,2);
                $displaythisduedate =     $displayDay. '/'. $displayMonth. '/'. $displayYear;
                if ($displaythisduedate == '00/00/00')  $displaythisduedate = '';
                }
                } */
                ////?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'
                ////?usr='.$_SESSION['passprofile_usr'].'&emp_id='.$_SESSION['passprofile_emp'].'
                $content .= '<tr>
			<td width="550" class="title-field" valign="bottom" bgcolor="' . $cellbgcolor . '"><a href="bc2jobprofile.php?usr=' . $_SESSION['passprofile_usr'] . '&emp_id=' . $_SESSION['passprofile_emp'] . '&profileID=' . $jobduedatestoSort[$i][4] . '" >' . $jobduedatestoSort[$i][2] . '</a></td>		
			<td width="287" valign="bottom" bgcolor="' . $cellbgcolor . '">&nbsp;' . $jobduedatestoSort[$i][1] . '</td>
			<td width="85" valign="Topbottom" align="center" bgcolor="' . $cellbgcolor . '">' . $jobduedatestoSort[$i][5] . '</td>
			<td width="72" valign="bottom" align="right" bgcolor="' . $cellbgcolor . '">' . $displaythisduedate . '</td>
				</tr>';
            }
        } //default is sort by rating   initially descending
        if (substr($orderby, 0, 6) == "Rating" || $orderby == "")
        {
            $this_showTitle = $matches[$i][2]; //$uppercasetitlestoSort[$i][1];
            $this_showduedate = $matches[$i][5]; ////$uppercasetitlestoSort[$i][6]  ;
            if (($current_showduedate == $this_showduedate) && ($current_showTitle == $this_showTitle))
            {
                $rcnt = $rcnt - 1;
            }
            else
            {
                $current_showTitle = $this_showTitle;
                $current_showduedate = $this_showduedate;
                /*
                /***** matches array reference key ***
                * ** for desc sort by rating fraction
                $matches[$i][0] = $matchPercentage
                $matches[$i][1] = $matchjobid
                $matches[$i][2] = $matchTitle
                $matches[$i][3] = $matchAgency
                $matches[$i][4] = $matchRating
                $matches[$i][5] = $matchDeadline */
                $displaythisduedate = '';
                $predisplaythisduedate = $matches[$i][5];
                //	if ((	$predisplaythisduedate =  '0') ||(	$predisplaythisduedate== 0 ))   $displaythisduedate = '';
                $displaythisduedate = formatDateDisplay($predisplaythisduedate);

                //	if ((	$predisplaythisduedate =  '0') ||(	$predisplaythisduedate== 0 ))   $displaythisduedate = '';
                ////?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'
                ////?usr='.$_SESSION['passprofile_usr'].'&emp_id='.$_SESSION['passprofile_emp'].'
                $displaythisduedate = formatDateDisplay($predisplaythisduedate);
                $content .= '<tr>
			<td width="550" class="title-field" valign="bottom" bgcolor="' . $cellbgcolor . '">
			<a href="bc2jobprofile.php?usr=' . $_SESSION['passprofile_usr'] . '&emp_id=' . $_SESSION['passprofile_emp'] . '&profileID=' . $matches[$i][1] . '" >' . $matches[$i][2] . '</a></td>		
			<td width="287" valign="bottom" bgcolor="' . $cellbgcolor . '">&nbsp;' . $matches[$i][3] . '</td>
			<td width="85" valign="bottom" align="center" bgcolor="' . $cellbgcolor . '">' . $matches[$i][4] . '</td>
			<td width="72" valign="bottom" align="right" bgcolor="' . $cellbgcolor . '">' . $displaythisduedate . '<a></td> 
			</tr>';
                //	<!-- td width="72" valign="bottom" align="right" bgcolor="'.$ cellbgcolor.'">'.$  matches[$i][5].'<a></td  -->
                
            }
        }
        $rcnt = $rcnt + 1;

    }

    $content .= '</div>
</tbody>
</table>
</div>
</td>
</tr>';

    $content .= '<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:1000px; height: 42px;">
<table cellspacing="1">
<tbody>
<tr><td align="center" width="1000" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
<div>
</td>
</tr>';

}
else
{ //if ( usrTable) 640
    $content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Matches Found<br><br></strong></td></tr>';
}

$content .= '</tbody>
</table>';

if(!$usrTable){
    $content .= '</div>';
}

$content .= "<!--br>******************" . date('Y-m-d H:i:s') . "*********************************************";
$content .= "<br> bc2members 1274 After sorting and displaying matches  up all arrays to sort" . date('Y-m-d H:i:s');
$content .= "<br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
$content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n";
$content .= "<br>******************" . date('Y-m-d H:i:s') . "********************************************* -->";
$content .= "<!--br> trace 1131 countshow: " . $countshow . "-->";
// $content .= "<!--br> trace 757 countnoshow: " .   $countnoshow . "-->";
$content .= "<!--br> trace 1138 countjobs: " . $countjobs . "-->";
$content .= "<!--br>.trace 1134 from  getJobInfo returnresults of query: " . $_SESSION['getjobinfo'] . "-->";
$_Session['showed getjobinf'] = 1;
$content .= "<!-- br>trace 1095 6main  finish rendering match table at: " . date('Y-m-d H:i:s') . " -->";

/******* SCROLL END *******/

/******************************************************
$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>
<tr>
<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Your Partner Postings</strong></td>
</tr>
<tr>
<td width="540" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
<td width="100" bgcolor="#808080" align="center"><font color="#ffffff"><strong>#MATCHES</strong></font></td>
<td width="350" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TOP 3 MATCHES</strong></font></td>
</tr>';

$rcnt = 1;
$pstTable = getPosts();

		if ($pstTable) foreach($pstTable as $row) {
			$cnt = 0;
//			$matchTable = getMatches($row['job_id']);
			$totMatches = 0;
			$matchNames = "Testing";
/  *** remove matches
			$matchNames = "No Matches";
			
			if ($matchTable) foreach($matchTable as $roe) {
					if ($roe['match_cnt'] <> 0){
						$matchNames = "Click here to view matches";
					    $totMatches = $roe['match_cnt'];
					}

			}
remove matches*/

/*			if ($matchTable) foreach($matchTable as $roe) {
				//$totMatches = $totMatches + $roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos'];
				//$totMatches = $totMatches + $roe['sum'];
				$totMatches = $totMatches + 1;								
				if ($cnt <= 2) {
					if ($cnt == 0) 
						$matchNames = '<a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
					else
						//$matchNames = $matchNames . ', <a href="employers?op=pdfRes&res='.$roe['usr_id'].'" target="_blank" >'.$roe['usr_lastname'].'</a>';
						$matchNames = $matchNames . ', <a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
					}
					$cnt = $cnt + 1;
				}   
/			
			if (is_int($rcnt/2))
				$cellbgcolor = "#FFFFFF";
			else
				$cellbgcolor = "#E8E8E8";
			
			$content .= '
				<tr>
				<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2myjobprofile.php?usr='.$userID.'&profileID='.$row['job_id'].'" >'.$row['job_title'].'</td>
				<td width="100" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$totMatches.'</td>
				<td width="350" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchNames.'</td>
				</tr>';
				
					
			$rcnt = $rcnt + 1;
		}
		else
			$content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Job Post Found<br><br></strong></td></tr>';

$content .= '<tr><td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></div></center>';//</div></div>';

***************************************************************************/

/*******SCROLL BEGIN******/

$prows = 160;

$jobcnt = QV("select count(*) as cnt FROM job J WHERE J.job_emp_id = '" . $userID . "' and J.jobemp_id ='" . $emp_ID . "' ");
$scrollit = $jobcnt * 16;
$content .= "<!-- br> trace 1066 jobcnt: " . $jobcnt . " --> ";
/*
if ($scrollit > $prows)
	$scrollit = $prows;
elseif ($scrollit == 0)
	$scrollit = 16;
*/

if ($scrollit == 0) $scrollit = 16;
else $scrollit = $prows;

//if($emp_level>1){
$content .= '<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: 42px;">
<table cellspacing="1">
<tbody>
<tr>';
$content .= "<!-- br> trace 1284 my_pagename: " . $my_pagename . " --> ";
$help_index_10 = QV("Select help_message from contextual_help where help_pagename = '" . $my_pagename . "' and help_index = 10");
$content .= '<td align="center" colspan="4" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Your Partner Postings </strong>
<div class="tooltip"><img src="images/help-15-trans.png"/><span class="tooltiptext">' . $help_index_10 . '</span></div></td>';
$content .= '</tr>
<tr>
<td width="990" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TITLE</strong></font></td>
</tr>';

/*<td width="100" bgcolor="#808080" align="center"><font color="#ffffff"><strong>#MATCHES</strong></font></td>
<td width="350" bgcolor="#808080" align="left"><font color="#ffffff"><strong>TOP 3 MATCHES</strong></font></td>
</tr>';*/

$content .= '</tbody>
</table>
<div>
</td>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: ' . $scrollit . 'px; overflow-y: scroll;">
<table cellspacing="1">
<tbody>';
$rcnt = 1;
$pstTable = getPosts();

if ($pstTable) foreach ($pstTable as $row)
{
    $cnt = 0;
    //			$matchTable = getMatches($row['job_id']);
    $totMatches = 0;
    $matchNames = "Testing";
    /*** remove matches
    $matchNames = "No Matches";
    
    if ($matchTable) foreach($matchTable as $roe) {
    	if ($roe['match_cnt'] <> 0){
    		$matchNames = "Click here to view matches";
    	    $totMatches = $roe['match_cnt'];
    	}
    
    }
    remove matches*/

    /*			if ($matchTable) foreach($matchTable as $roe) {
    //$totMatches = $totMatches + $roe['sysmat_certifications']+$roe['sysmat_skills']+$roe['sysmat_agencies']+$roe['sysmat_proflics']+$roe['sysmat_geos'];
    //$totMatches = $totMatches + $roe['sum'];
    $totMatches = $totMatches + 1;								
    if ($cnt <= 2) {
    	if ($cnt == 0) 
    		$matchNames = '<a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
    	else
    		//$matchNames = $matchNames . ', <a href="employers?op=pdfRes&res='.$roe['usr_id'].'" target="_blank" >'.$roe['usr_lastname'].'</a>';
    		$matchNames = $matchNames . ', <a href="bc2membersprofile.php?usr='.$userID.'&profileID='.$roe['usr_id'].'&jobID='.$row['job_id'].'" >'.$roe['usr_lastname'].'</a>';
    	}
    	$cnt = $cnt + 1;
    }   
    */
    if (is_int($rcnt / 2)) $cellbgcolor = "#FFFFFF";
    else $cellbgcolor = "#E8E8E8";
    ////?usr='.$_SESSION['passprofile_usr'].'&company_id='.$_SESSION['passprofile_emp'].'
    ////?usr='.$_SESSION['passprofile_usr'].'&emp_id='.$_SESSION['passprofile_emp'].'
    $jobMatches = 1; ////&jobMatches='.$jobMatches.'
    //	<td width="540" valign="Top" bgcolor="'.$cellbgcolor.'"><a href="bc2myjobprofile.php?usr='.$userID.'&profileID='.$row['job_id'].'" >'.$row['job_title'].'</td>
    $content .= '
				<tr>
	<td width="990" valign="Top" bgcolor="' . $cellbgcolor . '">
	<a href="bc2myjobprofile.php?usr=' . $_SESSION['passprofile_usr'] . '&emp_id=' . $_SESSION['passprofile_emp'] . '&profileID=' . $row['job_id'] . '&jobMatches=' . $jobMatches . '&profilecompany_id=' . $row['jobemp_id'] . ' ">' . $row['job_title'] . '</td>
				</tr>';
    /*
    <td width="100" valign="Top" align="center" bgcolor="'.$cellbgcolor.'">'.$totMatches.'</td>
    <td width="350" valign="Top" bgcolor="'.$cellbgcolor.'">'.$matchNames.'</td>
    </tr>';*/

    $rcnt = $rcnt + 1;
}
else $content .= '<tr><td align="center" colspan="4" style="background-color: #ffffff;"><strong><br>No Job Post Found<br><br></strong></td></tr>';

$content .= '</div>
</tbody>
</table>
</div>
</td>
</tr>
<tr>
<td valign="Top" width="990">
<div class="container" style="border:0px solid #ccc; width:990px; height: 42px;">
<table cellspacing="1">
<tbody>
<tr><td align="center" width="990" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
</tbody>
</table>
<div>
</td>
</tr>
</tbody>
</table>';
//}

if(!$usrTable){
    $content .= '</div>';
}

//$content .= "<!--br>******************" . date('Y-m-d H:i:s') . "*********************************************";
//$content .= "<br> bc2members 1510 After   displaying job postings  up all arrays to sort" . date('Y-m-d H:i:s');
//$content .= "<br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
//$content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n";
//$content .= "<br>******************" . date('Y-m-d H:i:s') . "********************************************* -->";
/******* SCROLL END *******/

$footerScript .= <<<EOS
 
$(document).ready(function() {
  
    $(myshowhideFunction());
}  
)
function myshowhideFunction() {
  var x = document.getElementById("mywelcomeDIV");
    if (x.style.display === "none") {
    x.style.display = "block";
   } else {
     x.style.display = "none";
    }
}

function  myshowwelcomeFunction()
{
    var x = document.getElementById("mywelcomeDIV");
      x.style.display="block";
}
    
    function  myhidewelcomeFunction()
{
    var x = document.getElementById("mywelcomeDIV");
      x.style.display="none";
    
}

EOS;
$content .= "<!--br>trace 1340 end dashboard bc2members: " . date('Y-m-d H:i:s') . "   -->";
$content .= "</tr></tbody></table></center>";

//-- transmit ---------------------------------------------------------------
require "inc/transmit.php";

function formatDateDisplay($datetoformat)
{ /* now 01/03/2018 in yyyymmdd format now 12/11/16
     2 4 6  */

    $displaythisduedate = '';
    $predisplaythisduedate = $datetoformat;

    $displayDay = substr($predisplaythisduedate, 6, 2);
    $displayMonth = substr($predisplaythisduedate, 4, 2);
    $displayYear = substr($predisplaythisduedate, 2, 2);
    $displaythisduedate = $displayMonth . '-' . $displayDay . '-' . $displayYear;
    if ($displaythisduedate == '00-00-00') $displaythisduedate = '';
    return $displaythisduedate;

}
function getPosts()
{
    global $userID, $emp_ID, $content; //WHERE J.job_emp_id = '".$userID."' and J.jobemp_id ='". $emp_ID."'
    $content .= "<!--  br> trace 1240 getPosts  userID: " . $userID . ", emp_ID: " . $emp_ID . " <br>
	     return query q2t is SELECT J.* FROM job J WHERE J.job_emp_id = '" . $userID . "' AND J.jobemp_id =  '" . $emp_ID . "' ORDER BY J.job_submitted_date -->";
    return Q2T("SELECT J.* FROM job J WHERE J.job_emp_id = '" . $userID . "' AND J.jobemp_id = '" . $emp_ID . "' ORDER BY J.job_submitted_date ");

} //job_id 	job_job_id 	job_emp_id 	job_ind_id 	job_created_by 	job_title 	job_details
///job_location 	job_ava_id 	job_clearance 	job_edu_level 	job_submitted_date 	job_approved_date 	job_expire_date
//job_status 	job_solicitation 	job_due_date 	job_buying_office 	job_first_name 	job_last_name 	job_email_address 	job_phone 	job_solicitation_link 	fed_id
function getMatches($id)
{
    global $userID, $emp_ID, $content;

    $content .= " <br>120 getMatches is no longer called  <br>";
    //clear match table
    /*
    //	Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'");
    
    //rerun match routines
    updateCertMatchesJP($id);
    updateSkillMatchesJP($id);
    updateAgencyMatchesJP($id);
    updateProflicMatchesJP($id);
    updateGeoMatchesJP($id);
    updateVehiclesMatchesJP($id);
    */

    //return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC");
    //????do I need the $emp_ID here in sysmatch  \/\/????  probably
    //return Q2T("SELECT count(*) as match_cnt FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."'");
    
}

function getUSRMatches()
{
    global $userID, $emp_ID, $content, $duedateageinterval;
    $content .= "<!--br>trace 1368 entered getUSRMatches at: " . date('Y-m-d H:i:s') . "   -->";
    ////deleteOldMatches();
    //// $content .="<!--br>trace 1370  getUSRMatches, returned from deleteOldMatches at: " .   date('Y-m-d H:i:s') . " -->";
    $content .= "<!--br> trace getUSRmatches deletemymatches = <br>" . $deletemymatches . " contingently enabled--> ";
    ////(sysmat_certifications = 0 AND sysmat_skills = 0 AND sysmat_functions = 0 AND sysmat_agencies = 0 AND sysmat_proflics = 0 AND sysmat_geos = 0 AND sysmat_vehicles = 0)");
    //// $howmanydeleted = Q($deletemymatches);
    //// $content.="<br> trace getUSRmatches  = <br>" . $howmanydeleted . " --> " ;
    // exit;  //(sysmat_certifications = 0 AND sys
    /* Matching */
    /* */
    // change to do this only once per SESSION unless a profile has been addeded since last time entered run [  ]
    //need to unset this SESSION varaible at logon time  //if isset ()  unset();
    //$orderby=="" ) )  if non zero the match has already run   	////  //
    ////	unset ($_SESSION['randashbdusrMatches']); // = "set"; // do not do updates for this test lloyd
    // hpdat skill ok update cert ok /////	 $_SESSION['randashbdusrMatches']="randashbdthisSESSION";
    // 5/21/19 lloyd run dash if user changed usr's own member profile in applicant.php
    // \/ account for a bc2admin running another's dash
    if (!(isset($_SESSION['currentdash_usr_id']))) $_SESSION['currentdash_usr_id'] = 0;
    $thisdash_usr_id = $userID; //  ||  (!( $thisdash_usr_id == $_SESSION['currentdash_usr_id']) ||  (!($thisdash_emp_id==$_SESSION['currentdash_emp_id'])
    if (!(isset($_SESSION['currentdash_emp_id']))) $_SESSION['currentdash_emp_id'] = 0;
    $thisdash_emp_id = $emp_ID; //  ||  (!($thisdash_emp_id==$_SESSION['currentdash_emp_id'])
    if (!(isset($_SESSION['mymemberprofilechanged'])))
    {
        $_SESSION['mymemberprofilechanged'] = 1;
    } ///////not needed applicant's runs matches for the crteria added, deleted or editied 	  }
    $lastjobPost = QV("select MAX(jobposttimes_id) from jobposts_times");
    $lastjobPost = $lastjobPost + 0;

    if (!(isset($_SESSION['randashbdusrMatches'])))
    {
        $_SESSION['randashbdusrMatches'] = 0;
    }
    else
    {
        $_SESSION['randashbdusrMatches'] = $_SESSION['randashbdusrMatches'] + 0;
    }

    $content .= "<!--br>trace 1592 maybe running the dashboard matches;  SESSION['randashbdusrMatches']: " . $_SESSION['randashbdusrMatches'] . ", lastjobPost: " . $lastjobPost . ", _Session['mymemberprofilechanged']: " . $_SESSION['mymemberprofilechanged'] . " --> ";

    $thisSessionjobPost = $_SESSION['randashbdusrMatches'] + 0;
    $thisDBlastjobPost = $lastjobPost + 0;
    $content .= "<!-- trace 1608 thisSessionjobPost: " . $thisSessionjobPost . ", thisDBlastjobPost: " . $thisDBlastjobPost . " do updatesif 1st < 2nd: 
                         (" . $thisSessionjobPost . " <? " . $thisDBlastjobPost . " )
 	             or   _Session['mymemberprofilechanged']> 0; it's value is : " . $_SESSION['mymemberprofilechanged'] . " --> ";
    //// if ( 1==1)
    //////
    if (($thisSessionjobPost) < ($thisDBlastjobPost) || (0 < $_SESSION['mymemberprofilechanged']) || (!($thisdash_usr_id == $_SESSION['currentdash_usr_id'])) || (!($thisdash_emp_id == $_SESSION['currentdash_emp_id'])))
    {

        $_SESSION['currentdash_usr_id'] = $thisdash_usr_id;
        $_SESSION['currentdash_emp_id'] = $thisdash_emp_id;
        $_SESSION['mymemberprofilechanged'] = 0;
        $_SESSION['randashbdusrMatches'] = $thisDBlastjobPost + 0; // $thisSessionjobPost $lastjobPost * 1;
        // also need to tweak each for $emp_ID
        $content .= "<!--br>trace 1605  getUSRMatches calls to  update matches at: " . date('Y-m-d H:i:s') . ", SESSION['randashbdusrMatches']: " . $_SESSION['randashbdusrMatches'] . ", lastjobPost: " . $lastjobPost . " --> ";

        $content .= "<!--br> getUsrMatches 1636 Doing update Matches at " . date('Y-m-d H:i:s');
        $content .= "<br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
        $content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n";
        $content .= "<br>******************" . date('Y-m-d H:i:s') . "********************************************* -->";
        //echo "I am here now - ".$userID."  --  ".$emp_ID; exit();
        updateFunctionMatchesMP($userID, $emp_ID); //e  /////      ////
        updateSkillMatchesMP($userID, $emp_ID); //       exit;		//echo "skill " . date("h:i:sa")."<br>";  	  //// 	 //  %#$&! this causes exceed memory 	////
        updateCertMatchesMP($userID, $emp_ID); //cho "Functions " . date("h:i:sa")."<br>";/**/
        updateAgencyMatchesMP($userID, $emp_ID); // core function updateAgencyMatchesMP($userIdentity,$empIdentity)		//echo "Agency " . date("h:i:sa")."<br>";
        updateProflicMatchesMP($userID, $emp_ID); //echo "Proflic " . date("h:i:sa")."<br>";
        updateVehiclesMatchesMP($userID, $emp_ID); //echo "Vehicle " . date("h:i:sa")."<br>"; 	//  !#$%^& this also cuse memory  ///
        updateGeoMatchesMP($userID, $emp_ID); //echo "Geos " . date("h:i:sa")."<br>";
        deleteOldMatches(); ////
        $content .= "<!-- br>trace 1635  ran the dashboard matches;   _SESSION['randashbdusrMatches']: " . $_SESSION['randashbdusrMatches'] . "-->";

    }
    else
    {
        $content .= "<!--br>trace 1638  getUSRMatches did NOT do  calls to updatematches at: " . date('Y-m-d H:i:s') . " -->";
        $_SESSION['randashbdusrMatches'] = $thisDBlastjobPost + 0;
        $_SESSION['mymemberprofilechanged'] = 0;
        $content .= "<!--br>trace 1640 NOT running the dashboard matches.  SESSION['randashbdusrMatches']: " . $_SESSION['randashbdusrMatches'] . " -->";

        $content .= "<!-- br>******************" . date('Y-m-d H:i:s') . "*********************************************";
        $content .= "<br> getUsrMatches 1659 NOT Doing update Matches at " . date('Y-m-d H:i:s');
        $content .= "<br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
        $content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n";
        $content .= "<br>******************" . date('Y-m-d H:i:s') . "********************************************* --> ";

        ////  echo ("<br><br>trace 1326 NOT running the dashboard  matches.  SESSION['ranusrMatches']: ".$_SESSION['ranusrMatches'] ." -->");	/// _SESSION['randashbdusrMatches']: ".$_SESSION['randashbdusrMatches'] ."-->";	     ////flush();
        
    }
    /* End Matching */

    /*	$querymatret = "SELECT S.*,U.*
    ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
    FROM sys_match S 	INNER JOIN usr U ON U.usr_id = S.sysmat_usr_id and U.usr_id= ".$userID."  WHERE S.sysmat_usr_id ='".$userID."' and S.sysmat_emp_id = '".$emp_ID."'";
    */
    //// $content .="<!-- trace 1313 getusrmatches  : " .$querymatret ." -->";
    ////   $content .="<!-- br>trace 1460  getUSRMatches query tocount  matches at: " .   date('Y-m-d H:i:s') . " -->";
    $start_getmatch_count = QV("SELECT COUNT(*) FROM  sys_match  WHERE sysmat_usr_id =" . $userID . " and sysmat_emp_id = " . $emp_ID . "");
    /*  from bc2member 5/10/19 plus part of 5.12  5/10 */
    //$cert_req = QV("SELECT count(*) as cnt FROM job_certs WHERE jobcrt_job_id = '".$id."'");
    /*SELECT S.*
    ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S WHERE S.sysmat_usr_id ='400327' and S.sysmat_emp_id = '395258' and
    (     ( S.sysmat_skills > 0 AND S.sysmat_certifications > 0  and S.sysmat_job_id in ( select  jobcrt_job_id from job_certs where jobcrt_job_id = S.sysmat_job_id ) )
    OR ( S.sysmat_skills > 0   and S.sysmat_job_id not in ( select  jobcrt_job_id from job_certs where jobcrt_job_id =S.sysmat_job_id )  ) ) ORDER BY S.sysmat_job_id
    */
    ////$content.= "<!-- trace bc2members 1581 cert_req is: ". $cert_req . " from query: SELECT count(*) as cnt FROM job_certs WHERE jobcrt_job_id = '".$id."' -->";
    /* replace $querymatretnoU = "SELECT J.*,S.*,ltrim(F.Job_Title) as fjob_title
    ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
    FROM sys_match S  inner join job J on J.job_id = S.sysmat_job_id  inner join FBO_IMPORT F on F.fed_id = J.fed_id
    WHERE S.sysmat_usr_id ='".$userID."' and S.sysmat_emp_id = '".$emp_ID."' and S.sysmat_skills  > 0  ORDER BY  J.job_title, J.job_solicitation desc;" ;
    with: */

    /***
    $querymatretnoU = "SELECT J.*,S.*,ltrim(J.Job_Title) as fjob_title
    ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
    FROM sys_match S  inner join job J inner join job_certs JC on J.job_id = S.sysmat_job_id and J.job_id = JC.jobcrt_job_id WHERE S.sysmat_usr_id ='".$userID."' and S.sysmat_emp_id = '".$emp_ID."' and S.sysmat_skills  > 0
    and jobcrt_crt_id <> 53 and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' ) 
             OR (J.fed_id = 0 ) )/* 	    AND J.job_due_date <> '0000-00-00'  */
    //	  ORDER BY  J.job_title, J.job_solicitation desc;" ;
    

    $querymatretnoU = "SELECT J.*,S.*,ltrim(J.Job_Title) as fjob_title
	,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
	  FROM sys_match S  inner join job J on J.job_id = S.sysmat_job_id
	  WHERE S.sysmat_usr_id ='" . $userID . "' and S.sysmat_emp_id = '" . $emp_ID . "' and S.sysmat_skills  > 0  
	   and ((J.fed_id >0 and J.job_due_date <> '0000-00-00' ) 
             OR (J.fed_id = 0 ) )/* 	    AND J.job_due_date <> '0000-00-00'  */
	  ORDER BY  J.job_title, J.job_solicitation desc;";

    //echo $querymatretnoU;
    

    /*	 5/15/19 use this instead of requiring both skill and cert^^
    from May 11  $querymatretnoU = "SELECT S.*
    ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
    FROM sys_match S    WHERE S.sysmat_usr_id ='".$userID."' and S.sysmat_emp_id = '".$emp_ID."' and( S.sysmat_skills  > 0 " .  $qry_end;
    and ((S.sysmat_certifications > 0 and S.sysmat_skills  > 0)  OR   (S.sysmat_certifications = 0 and S.sysmat_skills  > 0) )	  order by S.sysmat_job_id ";
    //$content .="  <!-- trace 1318 getusrmatches  : " .$querymatretnoU ." -->"; ////exit;  and ((S.sysmat_certifications  + S.sysmat_skills  )> 0)
    */
    $doquerymatretnoU = Q2T($querymatretnoU); //trying no U at all but need J for de-dupe
    $content .= "<!--br>******************" . date('Y-m-d H:i:s') . "*********************************************";
    $content .= "<br> getUsrMatches 1698 After getiing SYSMATHCES at " . date('Y-m-d H:i:s');
    $content .= "<br> ::    used peak: " . (memory_get_peak_usage(false) / 1024 / 1024) . " MiB\n";
    $content .= " :::  allocated peak: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MiB\n\n";
    $content .= "<br>******************" . date('Y-m-d H:i:s') . "********************************************* --> ";

    if ($doquerymatretnoU)
    {
        $content .= "<!-- trace 1668 doquerymatifcertskill - got: " . COUNT($doquerymatretnoU) . " rows with query: " . $querymatretnoU . " -->";
        return $doquerymatretnoU;
    }
    else
    {
        $content .= "<!-- trace 1670 " . $doquerymatretnoU . " -  got: 0  rows  with query: " . $querymatretnoU . " -->";
        return $doquerymatretnoU;
    }

    //3//31/19 try no U.* and join // \/ 5/11/19  5/20/19  change sort to
    /*$querymatifcertskill = "SELECT J.*, S.*   ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
    FROM sys_match S left join job J on J.job_id = S.sysmat_job_id WHERE S.sysmat_usr_id ='".$userID."' and S.sysmat_emp_id = '".$emp_ID."' and
    (     ( S.sysmat_skills > 0 AND S.sysmat_certifications > 0  and S.sysmat_job_id in ( select  jobcrt_job_id from job_certs where jobcrt_job_id = S.sysmat_job_id ) )
    OR ( S.sysmat_skills > 0   and S.sysmat_job_id not in ( select  jobcrt_job_id from job_certs where jobcrt_job_id =S.sysmat_job_id )  ) )
    ORDER BY  J.job_title, J.job_solicitation desc      ";
    $content .= "<!-- trace 1619 querymatifcertskill: " . $querymatifcertskill . " --> ";
    $doquerymatifcertskill = Q2T($querymatifcertskill);
    if ($doquerymatifcertskill)
    {
     $content .= "<!-- trace 1666 doquerymatifcertskill - got: " . COUNT($doquerymatifcertskill) .  " rows with query: " .$querymatifcertskill." -->";
     return $doquerymatifcertskill;
    }else
    {
      $content .= "<!-- trace 1670 " .$querymatifcertskill." -  got: 0  rows  with query: " .$querymatifcertskill." -->";
      return $doquerymatifcertskill;
    }
    // 5/13/19 try to supporess false drops that sort like fbo but no agency no no due date
    */
    /*$querymatifcertskillageny = "SELECT C.*,JA.*,J.*, S.*
    ,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum
    FROM sys_match S left join job J on J.job_id = S.sysmat_job_id
    LEFT JOIN job_agencies JA on JA.jobskl_job_id = S.sysmat_job_id
    LEFT JOIN cat_agencies C   ON C.catagen_id = JA.jobskl_skl_id
    WHERE S.sysmat_usr_id ='".$userID."' and S.sysmat_emp_id = '".$emp_ID."' and
    (     ( S.sysmat_skills > 0 AND S.sysmat_certifications > 0  and S.sysmat_job_id in ( select  jobcrt_job_id from job_certs where jobcrt_job_id = S.sysmat_job_id ) )
    OR ( S.sysmat_skills > 0   and S.sysmat_job_id not in ( select  jobcrt_job_id from job_certs where jobcrt_job_id =S.sysmat_job_id )  ) )
    ORDER BY  J.job_title, J.job_solicitation desc
    */
}

function getJobInfo($id)
{
    global $userID, $emp_ID, $content, $duedateageinterval;
    /* change sort to job_title to elim dupes lloyd 5/11/19 4/22/19
    */

    //   $_Session['showed getjobinf'] = 1;
    $qgetjobinfo = "SELECT   J.job_id,J.job_job_id 	,J.job_emp_id 	,J.job_ind_id ,jobemp_id	,J.job_created_by 	,LTRIM(J.job_title) as job_title 	,J.job_details 
      ,J.job_location ,J.job_ava_id 	,J.job_clearance 	,J.job_edu_level 	,J.job_submitted_date 	,J.job_approved_date 	,J.job_expire_date 
      ,J.job_status ,J.job_solicitation ,J.job_due_date,J.job_buying_office,J.job_first_name ,J.job_last_name 	,J.job_email_address,J.job_phone,J.job_solicitation_link,J.fed_id 
      ,J.insert_FBO_Feed
    FROM job J 	WHERE J.job_id ='" . $id . "'   
    AND ( ((J.fed_id > 0 and J.job_solicitation is NOT NULL) and (J.job_solicitation  <> '') ) OR ( J.fed_id = 0) ) 
    ORDER  BY J.job_title,J.job_solicitation desc , J.job_due_date desc";

    $content .= "<!-- br> trace 1632 _ $qgetjobinfo :  " . $qgetjobinfo . " --> ";
    $_SESSION['getjobinfo'] = $qgetjobinfo;

    $didgetjobinfo = Q2T($qgetjobinfo);
    if ($didgetjobinfo)
    {
        $content .= "<!-- trace 1672 ingetjobinfo - got: " . COUNT($didgetjobinfo) . " rows -->";
        return $didgetjobinfo;
    }
    else
    {
        $content .= "<!-- trace 1675 ingetjobinfo - got: 0  rows -->";
        return $didgetjobinfo;
    }
    return $didgetjobinfo; ////Q2T( $didgetjobinfo); //
    /* */

}

function getRating($id)
{
    global $userID, $emp_ID, $content;
    ////   $content .= "<!-- br>1613 trace rating query: -->";
    /* select count(*) as sum from job_agencies where jobskl_job_id ='".$id."'  UNION ALL
    select count(*) as sum from job_certs where jobcrt_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_skills where jobskl_job_id ='".$id."' -->";
    */

    ////
    $crtData = Q2T("SELECT J.*, C.* FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '" . $id . "' ");

    $crtSel = QV("SELECT J.jobcrt_desc FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '" . $id . "' ");
    $crtcnt = QV("SELECT count(*) FROM cat_certs C LEFT JOIN job_certs J ON C.catcrt_id = J.jobcrt_crt_id WHERE J.jobcrt_job_id = '" . $id . "' ");

    /**************
        if ($crtData) {
    
             if (($pd['jobcrt_desc'] == 'NONE') && ($crtcnt == 1))
             {
                 $cnt = Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='".$id."'  UNION ALL
                select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_skills where jobskl_job_id ='".$id."'");
             }
             else
             {
                 $cnt = Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='".$id."'  UNION ALL
                select count(*) as sum from job_certs where jobcrt_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
                select count(*) as sum from job_skills where jobskl_job_id ='".$id."'");
             }
            
        }
        
    **********/

    /*******
    
        if (($crtSel == 'NONE') && ($crtcnt == 1))
        {
            
            //echo "[".$crtSel."]";
    
            $cnt = Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='".$id."'  UNION ALL
    select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
    select count(*) as sum from job_skills where jobskl_job_id ='".$id."'");
            
        }
        
        else
        {
    Validating NONE vs Blank ***/

    //echo "[".$crtSel."]";
    $cnt = Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='" . $id . "'  UNION ALL
				select count(*) as sum from job_certs where jobcrt_job_id ='" . $id . "' UNION ALL
				select count(*) as sum from job_geos where jobskl_job_id ='" . $id . "' UNION ALL
				select count(*) as sum from job_proflics where jobskl_job_id ='" . $id . "' UNION ALL
				select count(*) as sum from job_vehicles where jobskl_job_id ='" . $id . "' UNION ALL
				select count(*) as sum from job_skills where jobskl_job_id ='" . $id . "'");
    //        }
    

    return $cnt;

}