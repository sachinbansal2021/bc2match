<?php 

// Employers

//-- page settings
define('C3cms', 1);
$title = "BC2 Admin";
////$pageauth = 2;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
////$template = "jobcon"; 
////$response = "content"; 
////require "inc/core.php";
$_SESSION['$usempempid'] = ""; ////  "_empid";
$usempempid = $_SESSION['$usempempid'];// "_empid"; //".$usempempid."
$template = "jobcon".$usempempid; 
$response = "content"; 
////$usempempid = $_SESSION['$usempempid'];// "_empid";   //".$usempempid."
require "inc/core.php";

//-- define content -----------------------------------------------------------------


$userID = 0;
$userType = $_SESSION['usr_type'];
$userCompany = 0;

if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; 

$_SESSION['view_id'] = $userID;

$searchresults = $_SESSION['u-search_results'];
$newcompany = $_SESSION['newcompany'];

$userCompany = $_SESSION['usr_company'];


if (intval($_SESSION['usr_auth'] > 2)) $footerScript .= ' $("#adminNav").append("<div style=\"margin-right:5px;\" onclick=\"window.location.href=\'admin_emp.php\';\" >Return to Employers List</div>");';

$empSection=@$_REQUEST['empSection'] or $empSection=@$_SESSION['empSection'] or $empSection="pst"; $_SESSION['empSection']=$empSection;


$opRec = CleanI($_REQUEST['rec']);
$orderby = ($_REQUEST['orderby']);

$empID = QV("SELECT usremp_emp_id FROM usr_emp WHERE usremp_usr_id ='".$userID."'");
	$_SESSION['op'] = Clean($_REQUEST['op']);
switch(Clean($_REQUEST['op'])) {
	case "usearch": 
		$_SESSION['search_firstname'] = Clean($_REQUEST['first_name']);
		$_SESSION['search_lastname'] = Clean($_REQUEST['last_name']);
		
	
		$searchresults = 1;
		$search_type = "name";
		break;
	
	case "csearch":
		$_SESSION['search_company'] = Clean($_REQUEST['company']);
	
		$searchresults = 1;	
		$search_type = "company";

		break;
		
	case "msearch":
	    $searchresults = 1;
	    $search_type = "registered_company";
	    break;
		
	case "newcompany":
		$newcompany = 1;
		
		break;
		
	case "addNewCompany":
			
		if (!( $_REQUEST['company'] =='' || $_REQUEST['contactFirstname'] == '' || $_REQUEST['contactLastname'] =='' || $_REQUEST['contactPhone'] =='' || $_REQUEST['contactEmail'] =='' || $_REQUEST['contactPassword'] =='')) {
				$empID = QI("INSERT INTO emp (emp_name,emp_phone,emp_email,emp_notes) VALUES ('".$_REQUEST['company']."','".$_REQUEST['contactPhone']."','".$_REQUEST['contactEmail']."','".$_REQUEST['comments']."')");
				$tpass = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,9); $newPass = sha1($tpass);
				$tusrID = QI("INSERT INTO usr (usr_email, usr_firstname, usr_lastname, usr_phone, usr_active, usr_join, usr_password, usr_auth, usr_created,usr_company,usr_type) VALUES ('".Clean($_REQUEST['contactEmail'])."','".Clean($_REQUEST['contactFirstname'])."','".Clean($_REQUEST['contactLastname'])."','".Clean($_REQUEST['contactPhone'])."','A','".date("Y-m-d H:i:s")."','".sha1(Clean($_REQUEST['contactPassword']))."','2','".date("Y-m-d H:i:s")."','".$empID."','0')");
				QI("INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_auth) VALUES ('".$tusrID."','".$empID."','*')");
				$tmp_content = 'Username: '.$_REQUEST['contactEmail']."\n\r\nPassword: ".$tpass;
				
				//mail($_REQUEST['contactEmail'],"JobConnect Login",$tmp_content,'From: info@bizconnectonline.com' . "\r\n" . 'Reply-To: no-reply@bizconnectonline.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() );
				
				//Populate the clearance table
				$clearID = QI("insert into usr_clearance (usrclr_usr_id, usrclr_clr_id, usrclr_title) values (".$tusrID.", '4','None')");


				//Populate the union/non-union (edu) table
				$unonuID = QI("insert into usr_edu (usredu_usr_id, usredu_edu_id) values (".$tusrID.", '1')");
										
				$newcompany = 2;
				
				//$content .= '<div style="margin:5px;padding:5px;">Thank you, please login with the credentials sent to your email address.</div>';		
				break;
			} else {
				$newcompany = 3;
				//$content .= 'Please fill in all required fields.';
			}
		
		break;	
		case "deleteUser";
		  // not done here have new module bc2membersdelete.php to "delete a usr"
		break;
}



$content .= DBContent();

$usrData = Q2R("SELECT * FROM usr WHERE usr_id = '".$userID."'");

if ((($userType == 0) && ($usrData['usr_type'] == 1)) || ($userType == 99)) {
	$adminUser = $_SESSION['admin_user'];
 //	$systemAdmin = '<td><center><a href="/demo/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
	$systemAdmin = '<td><center><a href="/bc2dev/admin_usr.php?usr='.$adminUser.'&ptype=admin">ADMIN Panel</a></center></td>';
}



$content .= '<br><center><div><h1 style="text-align: center;"><span style="background-color: #ffffff;"><strong>BC2 Match Administrator Control Panel</strong></span></h1>';

if ($newcompany == 0) {
$content .= '<table><tr><td>';
$content .= '<form id="form1" name="form1" method="post"><table width="502">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';

	
		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><br><strong>User Search:</strong><br><!-- lloyd4tojo br --></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br><!-- lloyd 4 tojobr  --></td>
		</tr>';
	  
		
		if ($search_type == "name"){
		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">First Name:</td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="text" name="first_name" id="first_name" value="'.($_REQUEST['first_name']).'"><br></td>
		</tr>';
		
		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">Last Name:</td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="text" name="last_name" id="last_name" value="'.($_REQUEST['last_name']).'"><br></td>
		</tr>';

		$content .= '<tr>
		<td style="font-weight: bold;" width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input style="font-weight: bold;"  type="submit" name="submit" id="submit" value="Search" $("#usearch").load("bc2_admins.php");></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br></td>
		</tr>';	
		}
		else 
		{
	  	$content .= '<tr>	<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">First Name:</td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="text" name="first_name" id="first_name"><br></td>
		</tr>';
	 
		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">Last Name:</td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="text" name="last_name" id="last_name"><br></td>
		</tr>';

		$content .= '<tr>
		<td style="font-weight: bold;" width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input style="font-weight: bold;"  type="submit" name="submit" id="submit" value="Search" $("#usearch").load("bc2_admins.php");></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br></td>
		</tr>';	 
        }

//$content .= '<tr><td align="center" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
$content .= '</tbody>
</table>
<input type="hidden" name="op" value="usearch" />
</form>
</td>
</tr>';
$content .= '</td><td>';
$content .= '<form id="form1" name="form1" method="post"><table width="502>
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';
/*
<tr>
<td align="center" colspan="2" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Member Search</strong></td>
</tr>';
*/	
		$content .= '<tr>
		<td width="100" colspan="2" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><br><strong>Company Search:</strong><br></td>		
		<!-- lloyd td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br></td -->
		</tr>';
		
		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">Company:</td>	';
		if ($search_type == "company")
		{	$content .= '<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="text" name="company" id="company" value="'.($_REQUEST['company']).'"><br></td>';
	    }else
		{	$content .= '<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="text" name="company" id="company"><br></td>';
		}
		$content .= '</tr>';	

		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="submit" style="font-weight: bold;" name="submit" id="submit" value="Search" $("#usearch").load("bc2_admins.php");></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br><br></td>
		</tr>';		

//$content .= '<tr><td align="center" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
$content .= '</tbody>
</table>
<input type="hidden" name="op" value="csearch" />
</form>
</td>
</tr>';


$content .= '<form id="form1" name="form1" method="post"><table width="502>
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';
/*
<tr>
<td align="center" colspan="2" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Member Search</strong></td>
</tr>';
*/	
		$content .= '<tr>
		<td width="100" colspan="2" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><br><strong>View Registered Members:</strong><br></td>		
		<!-- lloyd td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br></td -->
		</tr>';

		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="submit" style="font-weight: bold;" name="submit" id="submit" value="Search" $("#usearch").load("bc2_admins.php");></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br><br></td>
		</tr>';		


//$content .= '<tr><td align="center" colspan="6" style="background-color: #9fcfff; border-radius: 1px 1px 10px 10px;"><br></td></tr>
$content .= '</tbody>
</table>
<input type="hidden" name="op" value="msearch" />
</form>
</td>
</tr>';

		$content .= '<tr>
		<td width="100" colspan="2" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><br><strong><a href="chk_criteria.php" target="_blank">Check Member Criteria</a></strong><br></td>		
		<!-- lloyd td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br></td -->
		</tr>



</tbody>
</table><br>';

$content .= '<table>
        <tr>
        <td><a href="alerts.php">Check Alerts</a></td>
        <td></td>
        </tr>
</table>';

$content .= '</td></tr></table>';
}

if ($newcompany == 2) {
	$content .= '<center>New Company created.<br><br>';
	$content .= '<form id="newcompany_confirm_id" name="newcompany_confirm" method="post" action="bc2_admins.php" >
<form method="post" action="bc2_admins.php">
<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1"   class="winner-table" >
<tbody>';

		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="submit" name="submit" id="submit" value="Click to Continue"></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br><br></td>
		</tr>';		

$content .= '</tbody>
</table>
<input type="hidden" name="op" value="refresh" />
</form>
</td>
</tr>
</tbody>
</table></center><br>';

}




//*****************
$content .='<div id=usearch>';
if (($searchresults == 1) || ($_REQUEST['ptype'] == 'admin')) {

	//$content .='fn=[ '.$_SESSION['search_firstname'].' ] ln=[ '.$_SESSION['search_lastname'].' ]<br><br>';

	$criteria = 0;
	$firstcolname = "User ID";
	$lastcolname = "Actions";
	
	$firstcolw = 70;
    $lastcolw = 200;
	
	if ($search_type == "name"){
		
		$first_name = $_SESSION['search_firstname'];
		$last_name = $_SESSION['search_lastname'];
		
	   //  4 tojo 101218 need company name	$usr_search = "Select usr_id, usr_email, usr_firstname, usr_lastname, usr_type from usr  where ";
	   // 3/5/19 lloyd : also need all companies for the user even if user in only once
			$usr_search = "Select usr.usr_id, usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type , emp.emp_name" ;
			$usr_search =  $usr_search . " from usr usr left join emp emp on usr.usr_company =  emp.emp_id ";
			/*	SELECT ue.usremp_id,ue.usremp_usr_id,ue.usremp_usr_assignedusr_id,e.emp_id  ,e.emp_name,u.*
                from usr_emp ue
                inner join usr u on u.usr_id = ue.usremp_usr_assignedusr_id
                 inner join emp e on e.emp_id = ue.usremp_emp_id
                where u.usr_firstname like 'lloyd' and u.usr_lastname like 'palmer' */
                	$usr_search = "Select usr.usr_id, usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type ,emp.emp_id ,emp.emp_name" ;
		       	$usr_search =  $usr_search . " from usr usr left join emp emp on usr.usr_company =  emp.emp_id ";
		
				$usr_search =  $usr_search ." where ";
			  /* $usr_search = "SELECT ue.usremp_id,ue.usremp_usr_id,ue.usremp_usr_assignedusr_id,e.emp_id  ,e.emp_name,usr.*
                from usr_emp ue,
                inner join usr usr on usr.usr_id = ue.usremp_usr_assignedusr_id
                 inner join emp e on e.emp_id = ue.usremp_emp_id
                where "   */; ////u.usr_firstname like 'lloyd' and u.usr_lastname like 'palmer' ";

		if (!empty($first_name)) {
			$usr_search = $usr_search."usr.usr_firstname like '%".$first_name."%'";
			$criteria = 1;
		}

		if (!empty($last_name)) {
			if ($criteria == 1)
				$usr_search = $usr_search." and usr.usr_lastname like '%".$last_name."%'";
			else
				$usr_search = $usr_search."usr.usr_lastname like '%".$last_name."%'";
		}
	$content .= "<!-- br> 352 usr_search: " .$usr_search . " --> ";	  
	}
	
	
	if ($search_type == "company"){
		
		$company = $_SESSION['search_company'];
	
	  // get company for tojo lloyd	$usr_search = "Select usr_id, usr_email, usr_firstname, usr_lastname, usr_type from usr where ";
		//$usr_search = "Select usr.usr_id, usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type ,emp.emp_id, emp.emp_name  ";
		//$usr_search  = $usr_search  .  " from usr usr left join emp emp on usr.usr_company =  emp.emp_id ";
		
		$usr_search = "Select usr.usr_id, usr.usr_email, usr.usr_firstname, usr.usr_lastname, usr.usr_type ,emp.emp_id, emp.emp_name ";
		$usr_search .= "from usr_emp UE inner join usr usr inner join emp emp on UE.usremp_usr_id = usr.usr_id and UE.usremp_emp_id = emp.emp_id ";

		if (!empty($company)) {
	
				$usr_search .= " where UE.usremp_emp_id in (select emp_id from emp where emp_name like '%".$company."%')";
		}
		
		echo $usr_search."<br>";
	}
	
	
	if ($search_type == "registered_company")
	{
	    //$usr_search = 'select DATE_FORMAT(UE.registration_date,"%m-%d-%Y") as registration_date, UE.usr_id, UE.emp_id, U.usr_firstname, U.usr_lastname, U.usr_email, U.usr_type, U.usr_phone, E.emp_name from usr_emp_registration UE inner join usr U inner join emp E ON UE.usr_id = U.usr_id and UE.emp_id = E.emp_id order by UE.registration_date';
	    $usr_search = 'select DATE_FORMAT(UE.registration_date,"%m-%d-%Y") as registration_date, UE.usr_id, UE.emp_id, U.usr_firstname, U.usr_lastname, U.usr_email, U.usr_type, U.usr_phone, E.emp_name from usr_emp_registration UE inner join usr U inner join emp E ON UE.usr_id = U.usr_id and UE.emp_id = E.emp_id';
	    $usr_search .= ' group by substr(registration_date,0,10), UE.usr_id, UE.emp_id, U.usr_firstname, U.usr_lastname, U.usr_email, U.usr_type, U.usr_phone, E.emp_name  order by UE.registration_date';

	    //echo $usr_search;
	    $firstcolname = "Date";
	    $firstcolw = 100;
	    $lastcolname = "Phone";
	    $lastcolw = 170;
	    
	}	
	
	
	

	 $default_sort = ' ' ; //' order by emp.emp_name ';
	 $dothissort = $default_sort; //  Company, First Name, Last Name, Email
	 $comsortreq = "ASC";
	 $firstnamesortreq = "ASC";
	 $lastnamesortreq = "ASC";
	 $firstnamesortreq="ASC";
	 $emailsortreq="ASC";
   switch 	($orderby) { 
    case "Company": case "CompanyASC":  case "":
         $dothissort = " order by emp.emp_name ASC,usr.usr_firstname ASC, usr.usr_lastname ASC,   usr.usr_email ASC ";
         $comsortreq ="DESC";
        break;
    case "CompanyDESC":  
         $dothissort = " order by emp.emp_name DESC,usr.usr_firstname ASC, usr.usr_lastname ASC,   usr.usr_email ASC";
          // do not need $comsortreq = "ASC"; 
        break;
    case "FirstName" :  case "FirstNameASC":
         $dothissort= " order by usr.usr_firstname ASC, usr.usr_lastname ASC, emp.emp_name ASC, usr.usr_email ASC";
         $firstnamesortreq ="DESC";
         break;
     case "FirstNameDESC":
         $dothissort= " order by usr.usr_firstname DESC, usr.usr_lastname DESC, emp.emp_name ASC, usr.usr_email ASC";
         break;
    case "LastName":  case "LastNameASC":
         $dothissort= " order by usr.usr_lastname ASC, usr.usr_firstname ASC, emp.emp_name ASC, usr.usr_email ASC ";
         $lastnamesortreq = "DESC";
         break;
          case "LastNameDESC":
         $dothissort= " order by usr.usr_lastname DESC, usr.usr_firstname  DESC, emp.emp_name ASC, usr.usr_email ASC";
         break;
    case "Email": case "EmailASC": 
         $dothissort= " order by usr.usr_email ASC,emp.emp_name ASC,usr.usr_firstname ASC, usr.usr_lastname ASC ";
         $emailsortreq="DESC";
         break;
    case "EmailDESC": 
         $dothissort= " order by usr.usr_email  DESC,emp.emp_name ASC,usr.usr_firstname ASC, usr.usr_lastname ASC";
         break;
    default:
       $dothissort = " order by emp.emp_name ASC";
             break;
    }  
    
    
    	if ($search_type <> "registered_company")
		{   
		    $usr_search .= $dothissort;
		}
    
 // $content .='search string =[ '.$usr_search.' ]<br><br>';
	$search_res  = Q2T($usr_search);
   	 
//	$content .='search string =[ '.$usr_search.' ]<br><br>';

$scrollit = 380;

     $reqopis=($_SESSION['op']); // set up for sort links for Company, First Name, Last Name, Email//
     $requsr=($_SESSION['usr_id'])  ;      //for &usr=$usr
     $reqcompany=$company;                  //&company= php  $company
     $reqptype = "admin" ;               // for &ptype="admin";
     $reqlast_name=$last_name;
     $reqfirst_name=$first_name;
       
 $link_color="#cccccc";
 $linkbgcolor="#aaaaaa";
 //<  ? ph    p  $last_name?  > 
 
$content .='<table width="1024">
<tbody>
<tr>
<td valign="Top" width="1004">  <!--  9/6/18  lloyd was 990 -->
<div class="container" style="border:0px solid #ccc; width:1004px height: 42px;">  <!--  9/6/18 lloyd was 990 -->
<table cellspacing="1" cellpadding="1"   class="winner-table" >
<tbody>
<tr>
<td align="center" width="1019" colspan="6" style="background-color: #9fcfff; border-radius: 20px 20px 1px 1px;"><strong>Search Results</strong>
<br/> To Sort, click on either Company, First Name, Last Name or Email. <br>Sort will toggle between ASC and DESC.</td>  
<!--  9/6/18 lloyd was 990 -->
</tr>
<tr>
<td width="'.$firstcolw.'" bgcolor="#808080" align="center"><font color="#ffffff"><strong>'.$firstcolname.'</strong></font></td>  
<td width="280" bgcolor="'.$linkbgcolor.'" align="center"><font color="'. $link_color.'">
 <strong><a href="bc2_admins.php?op='.$reqopis.'&usr='.$requsr.'&ptype='.$reqptype.'&company='.$reqcompany.'&last_name='.$reqlast_name.'&first_name='.$reqfirst_name.'&orderby=Company'.$comsortreq.'"> <u>Company</u><a></strong></font>
</td> <td width="122" bgcolor="'.$linkbgcolor.'" align="center"><font color="'. $link_color.'"><strong>
<a href="bc2_admins.php?op='.$reqopis.'&usr='.$requsr.'&ptype='.$reqptype.'&company='.$reqcompany.'&last_name='.$reqlast_name.'&first_name='.$reqfirst_name.'&orderby=FirstName'.$firstnamesortreq.'"> <u>First Name </u><a></font></strong></td> 

<td width="126" bgcolor="'.$linkbgcolor.'" align="center"><font color="'. $link_color.'"><strong>
<a href="bc2_admins.php?op='.$reqopis.'&usr='.$requsr.'&ptype='.$reqptype.'&company='.$reqcompany.'&last_name='.$reqlast_name.'&first_name='.$reqfirst_name.'&orderby=LastName'.$lastnamesortreq.'"> <u>Last Name </u><a></font></strong></td> 
<td width="220" bgcolor="'.$linkbgcolor.'" align="center"><font color="'. $link_color.'"><strong>
<a href="bc2_admins.php?op='.$reqopis.'&usr='.$requsr.'&ptype='.$reqptype.'&company='.$reqcompany.'&last_name='.$reqlast_name.'&first_name='.$reqfirst_name.'&orderby=Email'.$emailsortreq.'"> <u>Email Address </u><a></strong></font></td> <!-- lloyd was 277 -->
<td width="'.$lastcolw.'" bgcolor="#808080" align="center"><font color="#ffffff"><strong>'.$lastcolname.'</strong></font></td>
</tr> 
<!-- 9/6/18 lloyd was align="left" except for last one -->
</tbody>
</table>
<div>
</td>
<tr>
<td valign="Top" width="1024"> 
<!--  9/6/18 lloyd was 990 \/ also-->
<div class="container" style="border:0px solid #ccc; width:1024px; height: '.$scrollit.'px; overflow-y: scroll;">
<table cellspacing="0"  class="winner-table">  
<!--  9/6/18 lloyd was cellspacing = 1 -->
<tbody>';

		//<a class="editUser" href="admin_usr?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Edit</a>	
		//<a class="passwordUser" href="admin_usr?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Password</a>

if ($search_res){
	
	$rcnt = 1;
	
	foreach($search_res as $res) {

		if (is_int($rcnt/2))
			$cellbgcolor = "#FFFFFF";
		else
			$cellbgcolor = "#E8E8E8";
		
		
		$dashboard = '[<a href="bc2members.php?usr='.$res['usr_id'].'&ptype=dashboard&empid='.$res['emp_id'].'&company_id='.$res['emp_id'].'" style="color:#00f;">Dashboard</a>] ';
		$viewprofile = '[<a href="bc2membersprofile.php?usr='.$res['usr_id'].'&company_id='.$res['emp_id'].'&profileID='.$res['usr_id'].'" style="color:#00f;">View Profile</a>] ';
		// add delete user link for tojo 10/17/18
		$deleteusr =  '[<a href="bc2membersdelete.php?deleteusrid='.$res['usr_id'].'" style="color:#00f;">Delete User</a>] ';
		$password = '[<a href="bc2memberschangepassword.php?changepassword='.$res['usr_id'].'" style="color:#00f;">Password</a>]';
		
		if ($res['usr_type'] == 0) $usrtype = "Primary";
		if ($res['usr_type'] == 1) $usrtype = "User";
		
		if ($res['usr_type'] == 99) {
			$usrtype = "BC2 Admin";
			//$dashboard = '<font color="#505050">Dashboard</font> - ';
			//$deleteusr =  'Delete User -';
			//$password = 'Password';
			$viewprofile = '<a href="bc2membersprofile.php?usr='.$res['usr_id'].'&company_id='.$res['emp_id'].'&profileID='.$res['usr_id'].'" style="color:#00f;">View Profile</a>';
		    $dashboard = '';
			$deleteusr = '';
			$password = '';
		}
		
		
		if ($search_type == "registered_company")
		{   
		    $firstcol = $res['registration_date'];
		    $ph = $res['usr_phone'];
		    
		    $pos = strpos($ph, '-');

            if ($ph == "")
            {
                $lastcol = "(not listed)";
            }
            else if ($pos === false) 
            {
		            $lastcol = substr($ph,0,3)."-".substr($ph,3,3)."-".substr($ph,6,4);
		    }
		    else
		    {
		        $lastcol = $ph;
		    }		    

//'<a href="bc2membersprofile.php?usr='.$res['usr_id'].'&company_id='.$res['emp_id'].'&profileID='.$res['usr_id'].'" style="color:#00f;">'.$res['emp_name'].'</a>] '

		}
		else
		{
		    $firstcol = $res['usr_id'];
		    $lastcol = $dashboard.$viewprofile.$deleteusr.$password;
		}
		
		$content .= '<tr>
		<td width="'.$firstcolw.'" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">
		&nbsp;&nbsp;'  .$firstcol.'</td>
		<!--  9/6/18 lloyd was width=70 -->	
		<td width="280" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">
		<a href="bc2membersprofile.php?usr='.$res['usr_id'].'&company_id='.$res['emp_id'].'&profileID='.$res['usr_id'].'" style="color:#00f;">'.$res['emp_name'].'</a> </td> 
		<!--  9/6/18 lloyd was width=90 -->
		<td width="122" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">
		&nbsp;	&nbsp;&nbsp;'.$res['usr_firstname'].'</td>  
		<!--  9/6/18 lloyd was width=115 -->
		<td width="126" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">
		&nbsp;	&nbsp;&nbsp;'.$res['usr_lastname'].'</td>
		<!--  9/6/18 lloyd was width=115 -->
		<td width="250" class="title-field" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">
		&nbsp;'.$res['usr_email'].'</td>
		<!--  9/6/18 lloyd was width=215 -->
		<td width="'.$lastcolw.'" valign="Top" align="left" bgcolor="'.$cellbgcolor.'" >'.$lastcol.'</td> <!--removed <!-- nowrap -->
		<!--  9/6/18 lloyd was width=285 -->
		</tr>';                                      
		
		$rcnt = $rcnt + 1;
	}
}
else
	$content .= '<tr><td align="center" colspan="6" style="background-color: #ffffff;"><strong><br>No User Found<br><br></strong></td></tr>';

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
}
$content .='</div>';


$content .='<div id=newcompany>';   ////_empid
if ($newcompany == 3) $content .= 'Please fill in all required fields.<br><br>';
if (($newcompany == 1) || ($newcompany == 3)) {
$content .= '<form method="post" action="bc2_admins.php">
	<div style="background:#CFE8FF;border-radius:10px;margin:20px;padding:20px;">
		<div style="float:right">'.DBContent('','Application Form').'</div>
		<table style="border:0px;" cellpadding="0" cellspacing="0">
		<tr><td style="text-align:right;">* Company Name: </td><td><input type="text" name="company" value="'.$_REQUEST['company'].'" /></td></tr>
		<tr><td style="text-align:right;">* Primary Contact First Name: </td><td><input type="text" name="contactFirstname" value="'.$_REQUEST['contactFirstname'].'" title="First Name" /></td></tr>
		<tr><td style="text-align:right;">* Primary Contact Last Name: </td><td><input type="text" name="contactLastname" value="'.$_REQUEST['contactLastname'].'" title="Last Name" /></td></tr>
		<tr><td style="text-align:right;">* Phone Number: </td><td><input type="text" name="contactPhone" value="'.$_REQUEST['contactPhone'].'" /></td></tr>
		<tr><td style="text-align:right;">* E-Mail: </td><td><input type="text" name="contactEmail" value="'.$_REQUEST['contactEmail'].'" /></td></tr>
		<tr><td style="text-align:right;">* Password: </td><td><input type="text" name="contactPassword" value="'.$_REQUEST['contactPassword'].'" /></td></tr>
		</table>
		<div style="float:left;margin-top:5px;display:inline-block;text-align:top;margin-left:50px;">Comments / Remarks:</div>
		<textarea name="comments" rows="7" cols="60">'.$_REQUEST['comments'].'</textarea><br/><br/><input type="hidden" name="op" value="addNewCompany" />
		<input type="submit" value="Submit" />
</form>';

//<form id="newcompany_confirm_id" name="newcompany_confirm" method="post" action="bc2_admins.php" >

$content .= '<form id="newcompany_confirm_id" name="newcompany_confirm" method="post" action="bc2_admins.php" >
<form method="post" action="bc2_admins.php">
<table width="1004">
<tbody>
<tr>
<td valign="Top" width="990">
<table cellspacing="1">
<tbody>';

		$content .= '<tr>
		<td width="100" valign="Top" align="left" bgcolor="'.$cellbgcolor.'"><input type="submit" name="submit" id="submit" value="Cancel"></td>		
		<td width="490" valign="Top" align="left" bgcolor="'.$cellbgcolor.'">&nbsp;<br><br></td>
		</tr>';		

$content .= '</tbody>
</table>
<input type="hidden" name="op" value="refresh" />
</form>
</td>
</tr>
</tbody>
</table></center><br></div>';
}



$content .='</div>';



$content .= '<br><br><br></div></center>';




//-- transmit ---------------------------------------------------------------
require "inc/transmit.php"; 

function getPosts() {
	global $userID,$empID;
	return Q2T("SELECT J.* FROM job J WHERE J.job_emp_id = '".$userID."' ORDER BY J.job_submitted_date ");
}

function getMatches($id) {
	global $userID;

	//clear match table
	
	Q2T("DELETE from sys_match WHERE S.sysmat_job_id = '".$id."'"); 
	
	//rerun match routines
	updateCertMatchesJP($id);
	updateSkillMatchesJP($id);
	updateAgencyMatchesJP($id);
	updateProflicMatchesJP($id);
	updateGeoMatchesJP($id);
	updateVehiclesMatchesJP($id);	
		
	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE S.sysmat_job_id = '".$id."' ORDER BY sum DESC");
}

function getUSRMatches() {
    global $userID;

	/* Matching */
		updateSkillMatchesMP($userID); 
		updateCertMatchesMP($userID); 
		updateFunctionMatchesMP($userID); 
		updateAgencyMatchesMP($userID); 
		updateProflicMatchesMP($userID);
		updateVehiclesMatchesMP($userID);
		updateGeoMatchesMP($userID);
/* End Matching */
	
	return Q2T("SELECT S.*,U.*,(S.sysmat_certifications + S.sysmat_functions + S.sysmat_skills + S.sysmat_agencies + S.sysmat_proflics + S.sysmat_geos + S.sysmat_vehicles ) AS sum FROM sys_match S LEFT JOIN usr U ON U.usr_id = S.sysmat_usr_id WHERE U.usr_id ='".$userID."' ORDER BY sum DESC");
}

function getJobInfo($id) {
	return Q2T("SELECT J.* FROM job J WHERE J.job_id ='".$id."' ORDER BY J.job_submitted_date");
}

function getRating($id) {
	return Q2T("select count(*) as sum from job_agencies where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_certs where jobcrt_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_geos where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_proflics where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_vehicles where jobskl_job_id ='".$id."' UNION ALL
				select count(*) as sum from job_skills where jobskl_job_id ='".$id."'");
}
