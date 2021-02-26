<?php
if (!defined('C3cms')) die('');
if (!defined('C3cmsCore')) die('');
require_once('tcpdf/tcpdf.php');

$RuserID = $_SESSION['resumePrint'];
$userData = Q2R("SELECT * FROM usr WHERE usr_id = '".$RuserID."'");
$eduData = Q2T("SELECT U.*, C.* FROM usr_edu U LEFT JOIN cat_edu C ON C.catedu_id = U.usredu_edu_id WHERE U.usredu_usr_id = '".$RuserID."' ORDER BY U.usredu_end");
$crtData = Q2T("SELECT U.*, C.* FROM usr_certs U LEFT JOIN cat_certs C ON C.catcrt_id = U.usrcrt_crt_id WHERE U.usrcrt_usr_id = '".$RuserID."' ");
$sklData = Q2T("SELECT U.*, C.* FROM usr_skills U LEFT JOIN cat_skills C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$RuserID."' ");
$expData = Q2T("SELECT U.*, E.* FROM usr_exp U LEFT JOIN cat_exp E ON E.catexp_id = U.usrexp_exp_id WHERE U.usrexp_usr_id = '".$RuserID."' ");
$fncData = Q2T("SELECT U.*, C.*, T.* FROM usr_exp_func U LEFT JOIN cat_func C ON C.catfnc_id = U.usrexpfnc_fnc_id LEFT JOIN cat_training T ON T.cattrn_id = U.usrexpfnc_trn_id LEFT JOIN usr_exp E ON E.usrexp_id = U.usrexpfnc_usrexp_id WHERE E.usrexp_usr_id = '".$RuserID."' ");

$html = '<div style="text-align:center;color:rgb(0,0,0);background:rgb(255,255,255);margin-bottom:-20px;">';
$html .= '<span style="font-size:60px;">'.$userData['usr_firstname'].' '.$userData['usr_lastname'].'</span><br/><br/><span style="font-size:38px;">';
if ($userData['usr_addr1']!='') $html .= $userData['usr_addr1'].'&nbsp;&nbsp;';
if ($userData['usr_addr2']!='') $html .= $userData['usr_addr2'].'&nbsp;&nbsp;';
if ($userData['usr_addr3']!='') $html .= $userData['usr_addr3'];
$html .= '<br/>'.$userData['usr_city'].', '.$userData['usr_state'].'  '.$userData['usr_zip'];
if ($userData['usr_email']!='') $html .= '<br/>'.$userData['usr_email'];
if ($userData['usr_phone']!='') $html .= '<br/>Phone: '.$userData['usr_phone'];
if ($userData['usr_phone2']!='') $html .= '<br/>Alternate: '.$userData['usr_phone2'];
if ($userData['usr_fax']!='') $html .= '<br/>Fax: '.$userData['usr_fax'];
$html .= '</span></div><div style="font-size:36px;">';
if ($eduData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold;font-size:45px;">Education</span><br/>';
	$html .= '<table style="width:680px;padding:3px;">';

	foreach ($eduData as $ed) {
		$html .= '<tr><td><span>&nbsp;&nbsp;&nbsp;</span><span style="font-weight:bold;">'.$ed['usredu_school'].'</span><span>&nbsp;&nbsp;&nbsp;</span>'.$ed['usredu_concentrations'].'<span>&nbsp;&nbsp;&nbsp;</span>'.($ed['usredu_start']!='1969-12-31'?$ed['usredu_start'].($ed['usredu_end']!='1969-12-31'?' - '.$ed['usredu_end']:''):'').'<span>&nbsp;&nbsp;&nbsp;</span>'.$ed['usredu_location'].' </td></tr>';
	}
	$html .= '</table><br/>';
}
if ($crtData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Certifications</span><br/>';
	$html .= '<table style="width:680px;padding:3px;">';
	foreach ($crtData as $cd) $html .= '<tr><td><span>&nbsp;&nbsp;&nbsp;</span><span style="font-weight:bold">'.(intval($cd['usrcrt_crt_id']==0)?$cd['catcrt_name']:$cd['usrcrt_title']).'</span><span>&nbsp;&nbsp;&nbsp;</span>'.date("Y-m-d",strtotime($cd['usrcrt_date'])).'<span>&nbsp;&nbsp;&nbsp;</span>'.$cd['usrcrt_comment'].'</td></tr>';
	$html .= '</table><br/>';
}
if ($expData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Previous Experience</span><br/>';
	foreach ($expData as $ed) {
		$html .= '<span style="font-weight:bold"><span style="font-size:38px">'.$ed['usrexp_employer'].'</span><br/>'.$ed['usrexp_title'].'</span><span>&nbsp;&nbsp;&nbsp;</span><span>'.($ed['usrexp_start']!='1969-12-31'?$ed['usrexp_start'].($ed['usrexp_end']!='1969-12-31'?' - '.$ed['usrexp_end']:''):'').' ('.$ed['usrexp_location'].')'.($ed['usrexp_comment']!=''?'<br/>'.$ed['usrexp_comment']:'').' ';
		$got = false; $expBuff = '<ul style="width:600px;">';
		if ($fncData) {
			foreach ($fncData as $fd) {
				if ($fd['usrexpfnc_usrexp_id'] == $ed['usrexp_id']) { 
					$expBuff .= '<li>'.$fd['usrexpfnc_title'].'<span>&nbsp;&nbsp;&nbsp;</span>'.$fd['catfnc_text'].'</li>'; 
					$got = true;
				}
			}
		}
		if ($got) $html .= $expBuff.'</ul>';
	}
	$html .= '<br/>';
}
$html .="</div>";
if ($sklData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Skills</span><br/>';
	$html .= '<table style="width:680px;padding:3px;">';
	foreach ($sklData as $sd) $html .= '<tr><td><span style="font-weight:bold;">'.$sd['usrskl_title'].'</span><span>&nbsp;&nbsp;&nbsp;</span>'.(($sd['usrskl_date']!='1969-12-31')&&($sd['usrskl_date']!='0000-00-00')?$sd['usrskl_date']:'').'<span>&nbsp;&nbsp;&nbsp;</span>'.$sd['usrskl_comment'].'</td></tr>';
	$html .= '</table><br/>';
}

//echo $html; die();

$pdf = new TCPDF('P', PDF_UNIT, 'LETTER', true, 'UTF-8', false); // create new PDF document
$pdf->SetCreator(PDF_CREATOR); // set document information
$pdf->SetAuthor($userData['usr_firstname'].' '.$userData['usr_lastname']);
$pdf->SetTitle('Resume');
$pdf->SetSubject('Resume');
$pdf->SetKeywords('');
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetAutoPageBreak(FALSE, 25.4); // set auto page breaks
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO); // set image scale factor
// set some language-dependent strings
// ?			$pdf->setLanguageArray($l);
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 004', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);// set default monospaced font

// set margins
$pdf->SetMargins(14, 15, 8);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);// set auto page breaks

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('times', '', 12); // set font
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Output('resume.pdf', 'I');
die();

