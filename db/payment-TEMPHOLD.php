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
	$mail->setFrom('bc2match@gmail.com');
	foreach($to as $to_key => $to_value){
	    $mail->addAddress($to_key, $to_value);
	}
    	$mail->isHTML(true); 
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->IsSMTP();
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'ssl://smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Port = 465;

	//Set your existing gmail address as user name
	$mail->Username = 'bc2matchmail@gmail.com';
	//Set the password of your gmail address here
	$mail->Password = 'ssg.krs#22';
	//$mail->Password = 'password123';
	$mail->send();
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
                /*var planS = $("#mPlans").val();
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

$cont = '<br><br><center>We are updating our payment process. You will be able to make a payment soon. <br>Thank you for your patience.<br><br>';
        $cont .= '<a href="/db/bc2members.php?usr='.$_SESSION['usr_id'].'&company_id='.$_GET['company'].'">Return to Dashboard</a></center>';
        $cont .= '<br><br><br><br><br><br><br><br><br><br><br><br><br><br>';


$title = "BC2Match Subscribe";
   
//-- transmit ---------------------------------------------------------------
require "inc/transmit.php";
?>