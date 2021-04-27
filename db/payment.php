<?php

// Homepage  index.php
//_empid
//-- page settings
define('C3cms', 1);
$title = "Homepage";
$pageauth = 0;  // 0=public, 1=applicants, 2=employers, 3=managers, 4=admin3, 5=admin2, 6=admin1
$_SESSION['$usempempid'] = ""; ////"_empid"; 
$template = "jobcon".$_SESSION['$usempempid']; 
$response = "content"; // content, ajax ... ?

require "inc/core".$_SESSION['$usempempid'].".php";

if(isset($_GET['removeUser']) && $_GET['removeUser']!=''){
    
    $comp = Q2T("select `emp_seats_occupied` from `emp` where `emp_id`='".$_GET['company']."'");
    $removeQuery = "delete from `usr` where `usr_id`='".$_GET['removeUser']."'";
    Q2T($removeQuery);
    if($comp[0]['emp_seats_occupied']>0){
        $updateComp = Q2T("update `emp` set `emp_seats_occupied`='".($comp[0]['emp_seats_occupied']-1)."' where `emp_id`='".$_GET['company']."'");
    }
}


require '../phpMailer/class.phpmailer.php';
require '../phpMailer/class.smtp.php';
	

function sendmail($subject = null, $body = null, $to = array()){
	$mail = new PHPMailer;
	//$mail->SMTPDebug  = 1;
	$mail->setFrom('renewals@bc2match.com');
	foreach($to as $to_key => $to_value){
	    $mail->addAddress($to_key, $to_value);
	}
    	$mail->isHTML(true); 
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->IsSMTP();
	$mail->SMTPSecure = 'starttls';
	$mail->Host = 'tls://smtp.office365.com';
	$mail->SMTPAuth = true;
	$mail->Port = 587;

	//Set your existing gmail address as user name
	$mail->Username = 'renewals@bc2match.com';
	//Set the password of your gmail address here
	$mail->Password = 'Bc2$2021';
	$mail->send();
	//For testing
	/*if(!$mail->send()) {
	  echo 'Email is not sent.';
	  echo 'Email error: ' . $mail->ErrorInfo;
	  echo '<br/>';
	} else {
	  echo 'Email has been sent.';
	  echo '<br/>';
	}*/	
}


$scriptLinks .= '<script type="text/javascript" language="javascript" src="js/jquery.dataTables.js"></script>
<script src="https://app.payproudlygateway.com/tokenizer/tokenizer.js"></script>
     <script>
     var payment, amountToPay;
     $(document).ready(function(){
       payment = new Tokenizer({
        url: "", // Optional - Only needed if domain is different than the one your on, example: localhost
        apikey: "pub_1lS1qb2tciXDsNDroaZ76xQfK8U",
        container: document.querySelector("#paymentDiv"),
        // Callback after submission request has been made
        // See Advanced -> Methods for breakdown of specific fields
        submission: (resp) => {
            console.log(resp);
            if(resp.status=="success"){
                //paymentApi(resp.token, amountToPay);
                $("#paytoken").val(resp.token);
                //$("#payamount").val(amountToPay);
                /*
                var planS = $("#mPlans").val();
                if(planS=="Silver"){
                	$("#new_emp_level").val(1);
                } else if(planS=="Gold"){
                	$("#new_emp_level").val(2);
                } else if(planS=="Platinum"){
                	$("#new_emp_level").val(3);
                }
                $("#new_emp_number_seats").val($("#plan-"+planS).val());*/
                
                $("#payform").submit();
            } else {
                
            }
        },
        settings: {
            payment: {
                types: ["card"], // Default ["card"]
                ach: {
                    sec_code: "web" // Default web - web, ccd, ppd, tel
                }
            }
        }
      });
     });
     
     function paymentApi(token, amount){
        $.ajax({  
            url: "https://app.payproudlygateway.com/api/transaction",
            type: "post",
            data: {
                "type": "sale",
                "amount": 1000,
                "payment_method": {
                    "token": token
                }
            },
            headers: {
                "Authorization": "pub_1lS1qb2tciXDsNDroaZ76xQfK8U",
                "Content-Type": "application/json"
            },
            success: function(){
                
            },
            error: function(){
                
            }
        });
     }
     
     function validateAgree(){
        if(!$("#agree").is(":checked")){
            $("#agree").css("outline", "2px solid #c00");
        } else {
            $("#agree").css("outline", "none");
            payment.submit();
        }
     }
     </script>';

//-- define content -----------------------------------------------------------------
$footerScript .= <<<EOS
//var usersTable = $('#usersTable').dataTable( { iDisplayLength: 50 } );
EOS;
////	unset ($_SESSION['randashbdusrMatches']); // = "set"; // do not do updates for this test lloyd
 	
$content .= DBContent();

$cont = '';

if(isset($_SESSION['usr_id']) && $_SESSION['usr_id']!=0){

	if(isset($_POST['token'])){
		//echo '<pre>'; print_r($_POST); echo '</pre>';
		/*$post_data = '{
	                "type": "sale",
	                "amount": 1000,
	                "payment_method": {
	                    "token": "'.$_POST['token'].'"
	                }';*/
	                
	    $usinfo = Q2T("select `usr_email` from `usr` where `usr_id`='".$_SESSION['usr_id']."'");
	    
	    $post_data = array(
	    	"type" => "sale",
	    	"amount" => (int)$_POST['amount'],
	    	"email_receipt" => false,
            "email_address" => $usinfo[0]['usr_email'],
	    	"payment_method" => array(
	    		"token" => $_POST['token']
	    	)
	    );
		$crl = curl_init('https://app.payproudlygateway.com/api/transaction');
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
	  	curl_setopt($crl, CURLINFO_HEADER_OUT, true);
	  	curl_setopt($crl, CURLOPT_POST, true);
		curl_setopt($crl, CURLOPT_POSTFIELDS, json_encode($post_data));
		    
		// Set HTTP Header for POST request 
		curl_setopt($crl, CURLOPT_HTTPHEADER, array(
		    'Content-Type: application/json',
		    'Authorization: api_1lS1nooe2n8EeUjfYiBU5DXe2mH'
		));
		    
		// Submit the POST request
		$result = curl_exec($crl);
		$result = json_decode($result);
		//echo '<pre>'; print_r($result); echo '</pre>';

		if($result->status=="success"){
			$tQuery = "insert into `transactions` set `user_id`='".$_POST['user_id']."', `amount`='".$result->data->amount."', `emp_id`='".$_POST['emp_id']."', `payment_id`='".$result->data->id."', `payment_user_id`='".$result->data->user_id."', `payment_user_name`='".$result->data->user_name."', `processor_id`='".$result->data->processor_id."', `processor_type`='".$result->data->processor_type."', `processor_name`='".$result->data->processor_name."', `payment_method`='".$result->data->payment_method."', `captured_at`='".date("Y-m-d H:i:s", strtotime($result->data->captured_at))."'";
			Q2T($tQuery);
			$empQuery = "update `emp` set `emp_level`='".$_POST['emp_level']."', `emp_number_seats`='".$_POST['emp_number_seats']."' where `emp_id`='".$_POST['emp_id']."'";
			//echo $empQuery;
			Q2T($empQuery);
			
			$empInfo = Q2T("select `emp_name` from `emp` where `emp_id`='".$_GET['company']."'");
			//echo "select `emp_name` from `emp` where `emp_id`='".$_GET['company']."'";
			
			$dateTime = "(".date('m-d-Y').")";
			$dateTimeEnd = "(".date('m-d-Y', strtotime('+1 year')).")";
			
			$uinfo = Q2T("select * from `usr` where `usr_id`='".$_POST['user_id']."'");
			$subsName = $uinfo[0]['usr_firstname'].' '.$uinfo[0]['usr_lastname'];
			$subCoName = $empInfo[0]['emp_name'];
			$subCoID = $_GET['company'];
			//$subsAddr = $uinfo[0]['usr_addr'].'<br/>'.$uinfo[0]['usr_addr1'].', '.$uinfo[0]['usr_addr2'].', '.$uinfo[0]['usr_addr3'].'<br/>'.$uinfo[0]['usr_city'].', '.$uinfo[0]['usr_state'].', '.$uinfo[0]['usr_zip'].'<br/>'.$uinfo[0]['usr_country'];
			
			$subsAddr = $uinfo[0]['usr_addr'].
			        (($uinfo[0]['usr_addr1']!='' && $uinfo[0]['usr_addr1']!=null)?'<br/>'.$uinfo[0]['usr_addr1']:'').
			        (($uinfo[0]['usr_addr2']!='' && $uinfo[0]['usr_addr2']!=null)?', '.$uinfo[0]['usr_addr2']:'').
			        (($uinfo[0]['usr_addr3']!='' && $uinfo[0]['usr_addr3']!=null)?', '.$uinfo[0]['usr_addr3']:'').
			        (($uinfo[0]['usr_city']!='' && $uinfo[0]['usr_city']!=null)?'<br/>'.$uinfo[0]['usr_city']:'').
			        (($uinfo[0]['usr_state']!='' && $uinfo[0]['usr_state']!=null)?', '.$uinfo[0]['usr_state']:'').
			        (($uinfo[0]['usr_zip']!='' && $uinfo[0]['usr_zip']!=null)?', '.$uinfo[0]['usr_zip']:'');
			
			$subsEmail = $uinfo[0]['usr_email'];
			$subsSeats = $_POST['emp_number_seats'];
			$subsID = $uinfo[0]['usr_id'];
			$totalcharged = $result->data->amount;
			$len = strlen($totalcharged);
		    
			$subsAmountCharged = substr($totalcharged,0,$len-2).".".substr($totalcharged,$len-2);
			//echo "[{$subsAmountCharged}]";
			
			
			
			$subject_team = "BC2Match Payment Processed {$dateTime}";
			
		    $body_team = "
			
<p>See details below.</p>
<br/>

Name: {$subsName}
<br/><br/>
Company Name: {$subCoName} [Company ID: {$subCoID}]
<br/><br/>
Email: {$subsEmail} [User ID: {$subsID}]

<br/><br/>

Gold-Level Membership
<br/>
{$subsSeats} seats
<br/><br/>

Purchase total: $ {$subsAmountCharged}
<br/><br/>
Subscription Expiration Date: {$dateTimeEnd}

 <br/><br/>";	
			
			
			$to_team = array("jonr@bc2match.com" => "Jon", "tjohnson@bc2match.com" => "Tom","larryf@bc2match.com" => "Larry");
			//$to_team = array("larryf@bc2match.com" => "Larry");
			
			sendmail($subject_team, $body_team, $to_team);
			
			
			
			$subject_comp = "BC2Match.com Payment Receipt";
				
			
			$body_comp = <<<EOS
			
<p>Thank you for subscribing to BC2Match.com for the coming year! BC2Match.com is a unique tool for connecting contractors to government opportunities, primes and teaming partners which leads to contract WINS! No one else in the marketplace offers the tools and the real-time responses we provide at a price that matches BC2Match.com.
</p>
<br/>

PAYMENT RECEIPT - {$dateTime}

<br/>*************************************************
<br/><br/>
BC2Online, LLC
<br/>
5335 Wisconsin Avenue NW Suite 640
<br/>
Washington DC 20015
<br/><br/>

{$subCoName}
<br/>
{$subsName}
<br/>
{$subsAddr}
<br/>
{$subsEmail}

<br/><br/>

Gold-Level Membership
<br/>
{$subsSeats} seats
<br/><br/>

Purchase total: $ {$subsAmountCharged}
 <br/><br/>
 
Subscription Expiration Date: {$dateTimeEnd}
<br/><br/>

Thank you for subscribing to BC2Match.com!
<br/><br/>
Questions? Email us at info@bc2match.com
EOS;
			
			$to_comp = array($subsEmail => $subsName);
			
			sendmail($subject_comp, $body_comp, $to_comp);

			//$resultCont = '<h2>Thank you for subscribing to BC2Match. Please sign into the site, confirm your profile and start using our matching service. We appreciate that you have joined and look forward to hearing about your successes. As always, please let us know how we can help you achieve your goals!</h2>';
			$resultCont = '<br><br><br><center><table width="800"><tr><td>';
			$resultCont .= 'Thank you for renewing your BC2Match.com membership. A payment receipt has been sent to <b>'.$subsEmail.'</b>.<br>We look forward to hearing about your successes. As always, please let us know how we can help you achieve your goals!<br><br>';
			$resultCont .= '</td></tr><tr><td align="center">';
			$resultCont .= '<a href="/db/bc2members.php?usr='.$subsID.'&company_id='.$subCoID.'">Click here to return to your Member Dashboard</a></center>';
			$resultCont .= '</td></tr></table></center>';
		} else {
			//$resultCont = '<h2>'.$result['msg'].'</h2><br><br>';
			$resultCont = '<h2>'.$result->msg.'</h2><br><br>';
			$resultCont .= '<a href="/db/bc2members.php?usr='.$subsID.'&company_id='.$subCoID.'">Click here to return to your Member Dashboard</a></center>';
		}
	}


	$sqlGetUsers = "SELECT u.*,ue.usremp_usr_assignedusr_id FROM usr u inner join usr_emp ue on u.usr_id= ue.usremp_usr_assignedusr_id 
        where ue.usremp_emp_id = ". $_REQUEST['company'] . " ";
	$userTable = Q2T($sqlGetUsers);
	
	$cont .= '<div style="margin: 10px;">';
	
	$thiscompany_name = QV("Select emp_name from emp where emp_id =". $_REQUEST['company'] . " ");
	
	$sqlGetEmpSeats = "SELECT emp_id, emp_name, emp_level,emp_seats_occupied,emp_number_seats  FROM emp where emp_id ='".$_REQUEST['company']."'";
	$thisrowseats =  Q2R($sqlGetEmpSeats);
	if ( $thisrowseats){
		$emp_seats_occupied = $thisrowseats['emp_seats_occupied'];
		$emp_number_seats = $thisrowseats['emp_number_seats'];
		$emp_level =  $thisrowseats['emp_level'];
		$emp_name = $thisrowseats['emp_name']; 
    } else { 
        $emp_seats_occupied =-99;
        $emp_number_seats  = -99;  // $emp_seats_occupied $emp_number_seats 
		$emp_level =  1;
		$emp_name = "Unknown";
    }
	
	$cont .= "<table class='grid' cellpadding='4' cellspacing='0' style='display:block;vertical-align:top;text-align:center;margin: 0 auto; max-width: 850px;'>
				<thead><tr background:#cfc'><th colspan='4' style='padding:10px; background: #020280; color: #fff;'>".$thiscompany_name."</th></tr></thead>
				<tbody><tr style='background:#72d5fb;cursor:pointer;'>";
				
	$cont .= '<td style="padding:10px;">Thank you for joining BC2Match. Currently, you have '.$emp_seats_occupied.' user(s). You may purchase more or fewer seats by clicking on the dropdown menu, “Select Seats.” If you are purchasing more seats, you can add users to fill those seats later on the Manage Account Page. If you are purchasing fewer seats, please remove those users for whom you are not purchasing seats.</td></tr>';
	//$cont .= "<tr style='background:#cfc;cursor:pointer;'>";
	//$cont .= '<td>Seats in Use</td><td>'.$emp_seats_occupied.'</td></tr>';
	
	$cont .= '</tbody></table>';
	
	
	
	/*$sqlGetPlans = "SELECT distinct `membership_level` from `bc2_pricing`";
	$Plans = Q2T($sqlGetPlans);
	$plansArray = array();
	

	foreach($Plans as $ind => $plan){
	    $sqlGetSeats = "SELECT * from `bc2_pricing` where `membership_level`='".$plan['membership_level']."'";
	    $Seats = Q2T($sqlGetSeats);
	    foreach($Seats as $index => $seat){
	        $plansArray[$plan['membership_level']][] = array('number' => $seat['total_seats'], 'product_id' => $seat['product_id'], 'cost' => $seat['cost']);
	    }
	}

	$selectedPlan = "";
	if($emp_level==1){
		$selectedPlan = 'Silver';
	} else if($emp_level==2){
		$selectedPlan = 'Gold';
	} else if($emp_level==3){
		$selectedPlan = 'Platinum';
	}*/
	
	/*$cont .= '<h2>Or change plan/seat</h2>
	<span>Select Plan:</span>
	<select id="mPlans">';	
	foreach($plansArray as $ind => $planSeats){
	    $cont .= '<option '.(($selectedPlan==$ind)?'selected="true"':'').'>'.$ind.'</option>';
	}
	$cont .= '</select>';*/
	
	$cont .= '<h3>Gold Membership</h3>';

	//$cont .= '<br/><br/>
	$cont .= '<span>Select Seats:</span>';
	
	$sqlGetPlans = "SELECT * from `bc2_pricing` where `membership_level`='Gold'";
	$Plans = Q2T($sqlGetPlans);
	
	$cont .= '<select class="seatsDropdown">';
	for($s=1; $s<=50; $s++){
	    $price = $Plans[0]['price'] + ( ($s-1) * $Plans[0]['add_seats'] );
	    $cont.='<option value="'.$price.'" '.(($s==$emp_number_seats)?'selected="true"':'').'>'.$s.'</option>';
	}
	$cont.='</select>';
	

	/*foreach($plansArray as $ind => $planSeats){
	    $cont .= '<select style="display: none;" id="plan-'.$ind.'" class="seatsDropdown">';
	    foreach($planSeats as $seat){
	        $cont .= '<option product-id="'.$seat['product_id'].'" product-price="'.$seat['cost'].'" '.(($ind==$selectedPlan && $emp_number_seats==$seat['number'])?'selected="true"':'').'>'.$seat['number'].'</option>';
	    }
	    $cont.='</select>';
	}*/
	
	
	/*$cont.='
	<span>Number of Seats: </span>
	
      <select id="seatSelect">
		<option seat-price="150" '.(($emp_number_seats==1)?'selected="true"':'').'>1</option>
		<option seat-price="300" '.(($emp_number_seats==2)?'selected="true"':'').'>2</option>
		<option seat-price="450" '.(($emp_number_seats==3)?'selected="true"':'').'>3</option>
		<option seat-price="600" '.(($emp_number_seats==4)?'selected="true"':'').'>4</option>
		<option seat-price="699" '.(($emp_number_seats==5)?'selected="true"':'').'>5</option>
		<option seat-price="1199" '.(($emp_number_seats==10)?'selected="true"':'').'>10</option>
		<option seat-price="1949" '.(($emp_number_seats==15)?'selected="true"':'').'>15</option>
		<option seat-price="2199" '.(($emp_number_seats==20)?'selected="true"':'').'>20</option>
		<option seat-price="2949" '.(($emp_number_seats==25)?'selected="true"':'').'>25</option>
		<option seat-price="2999" '.(($emp_number_seats==30)?'selected="true"':'').'>30</option>
	</select>';*/
	

	$cont .= '<h3>Annual Subscription: $<span id="priceToPay"></span></h3>';
	
	$cont .= '<h3>Seats:</h3>';
	
	$cont .= '<table id="usersTable" class="grid" cellpadding="4" cellspacing="0" style="width:984px;">
	<thead><tr><th style="background: #020280; color: #fff;">ID</th><th style="background: #020280; color: #fff;">Type</th><th style="background: #020280; color: #fff;">First Name</th><th  style="background: #020280; color: #fff;">Last Name</th><th  style="background: #020280; color: #fff;">Email</th><th style="width:250px; background: #020280; color: #fff;">Actions</th></tr></thead>
	<tbody>';
	if ($userTable) foreach($userTable as $ut) {
		$userColor = '';
		switch($ut['usr_type']) {
			case '0': $userColor = '72d5fb'; $userFontColor = '000'; break;
			case '1': $userColor = '72d5fb'; $userFontColor = '000'; break;
			case '99': $userColor = '72d5fb'; $userFontColor = '000'; break;
		}	

		$cont .= '<tr style="background:#'.$userColor.'; color:#'.$userFontColor.'"><td>'.$ut['usr_id'].'</td><td>';
		
		switch($ut['usr_type']) {
			case '0': $cont .= 'Primary'; break;
			case '1': $cont .= 'User'; break;
			case '99': $cont .= 'BC2 Admin'; break;
		}
		$cont .= '</td><td>'.$ut['usr_firstname'].'</td><td>'.$ut['usr_lastname'].'</td><td>'.$ut['usr_email'].'</td>';
		
		$cont .= '<td style = "width: 180px;" >';
		$holdusr_auth = $ut['usr_auth'];
		
		if (($thisusr_usrtype == "0") || ($_SESSION['usr_auth_orig'] == 8))	{
			switch ($ut['usr_auth']){
				//case '1':$users2 .= '<a href="applicants.php?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Dashboard</a>';break;
				//case '9':$users2 .= '<a href="employers.php?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Dashboard</a>';break;
				case '2': 
				//	if ((($ut['usr_type'] == 1) || ($ut['usr_type'] == 0) )  || ($_SESSION['usr_auth_orig'] == 8)){
				//	$users2 .= '<a href="bc2members.php?usr='.$ut['usr_id'].'&ptype=dashboard&empid='.$userCompany.'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Dashboard</a>';
				//	}
					break;
				case '3':$cont .= '<a href="managers.php?usr='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Manage</a>';break;
			}
		}
		
		$cont .= '<a class="removeUser" href="?company='.$_GET['company'].'&removeUser='.$ut['usr_id'].'" style="color:#00f;padding:4px;font-size:10px;background:#ddf;">Remove</a>';

		$cont .='
			</td>
		</tr>';
	}
	
	$cont .= '	</tbody>
	</table><br/><br/>';
	
	$cont .= '<div id="paymentDiv"></div>
	<form action="" method="post" id="payform">
	<input type="hidden" name="user_id" value="'.$_SESSION['usr_id'].'" />
	<input type="hidden" name="emp_id" value="'.$_GET['company'].'" />
	<input type="hidden" name="emp_level" id="new_emp_level" />
	<input type="hidden" name="emp_number_seats" id="new_emp_number_seats" />
	<input type="hidden" name="token" id="paytoken" />
	<input type="hidden" name="amount" id="payamount" />
	<input type="checkbox" name="agree" id="agree" value="1" /> I have read the <a onclick="window.open(\'../terms-and-conditions.htm\', \'newwin\', \'height=600px,width=1000px\');" style="cursor: pointer;color: #0505ff; text-decoration: underline;">terms and conditions</a> and I agree to abide by them.<br/><br/>
	<input type="button" onclick="validateAgree();" value="Pay Now" />
	</form>';
	
	
	$cont .= '</div>';

	$headerScript .= ' $(document).ready(function(){ 
		//var planSelected = $("#mPlans").val();
		//$("#plan-"+planSelected).show();
		var amountToPay = $(".seatsDropdown").val();
		$("#payamount").val(amountToPay+"00");
	    $("#priceToPay").html(amountToPay);
	    $("#new_emp_level").val(2);
	    $("#new_emp_number_seats").val($(".seatsDropdown option:selected").text());
		/*$("#mPlans").change(function(){
		    var planSelected = $(this).val();
		    $(".seatsDropdown").hide();
		    $("#plan-"+planSelected).show();
		    if(typeof $("#plan-"+planSelected).children("option:selected").attr("product-price") != "undefined"){
		    	amountToPay = $("#plan-"+planSelected).children("option:selected").attr("product-price");
		    	$("#priceToPay").html(amountToPay);
		    } else {
		    	amountToPay = 0;
		    	$("#priceToPay").html(amountToPay);
		    }
		});*/
		$(".seatsDropdown").change(function(){
		    amountToPay = $(this).val();
		    $("#priceToPay").html(amountToPay);
		    $("#payamount").val(amountToPay+"00");
		    $("#new_emp_number_seats").val($(this).children("option:selected").text());
		});
	});';
	
	
	$footerScript .= "";

	if(isset($_POST['token'])){
		$cont = $resultCont;
	}
}

$title = "BC2Match Subscribe";
   
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php";
?>