<?php
if (!defined('C3cms')) die('');
if (!defined('C3cmsCore')) die('');
require_once('tcpdf/tcpdf.php');

$userID = 0;
if (intval($_SESSION['usr_auth'])==1) $userID = $_SESSION['usr_id'];
else $userID = @$_REQUEST['usr'] or $userID = @$_SESSION['view_id'] or $userID = $_SESSION['usr_id']; $_SESSION['view_id'] = $userID;

$userData = Q2R("SELECT * FROM usr WHERE usr_id = '".$userID."'");
$eduData = Q2T("SELECT U.*, C.* FROM usr_edu U LEFT JOIN cat_edu C ON C.catedu_id = U.usredu_edu_id WHERE U.usredu_usr_id = '".$userID."' ORDER BY U.usredu_end");
$crtData = Q2T("SELECT U.*, C.* FROM usr_certs U LEFT JOIN cat_certs C ON C.catcrt_id = U.usrcrt_crt_id WHERE U.usrcrt_usr_id = '".$userID."' ");
$sklData = Q2T("SELECT U.*, C.* FROM usr_skills U LEFT JOIN cat_skills C ON C.catskl_id = U.usrskl_skl_id WHERE U.usrskl_usr_id = '".$userID."' ");
$expData = Q2T("SELECT U.*, C.*, E.* FROM usr_exp U LEFT JOIN cat_exp E ON E.catexp_id = U.usrexpfnc_exp_id WHERE U.usrexpfnc_usr_id = '".$userID."' ");
$fncData = Q2T("SELECT U.*, C.*, T.* FROM usr_exp_func U LEFT JOIN cat_func C ON C.catfnc_id = U.usrexpfnc_fnc_id LEFT JOIN cat_training T ON T.cattrn_id = U.usrexpfnc_trn_id WHERE U.usrexpfnc_usr_id = '".$userID."' ");

$html = '<div style="text-align:center;color:rgb(0,0,0);background:rgb(255,255,255);">';
$html .= '<span style="font-size:60px;">'.$userData['usr_firstname'].' '.$userData['usr_lastname'].'</span><br/><br/><span style="font-size:38px;">';
if ($userData['usr_addr1']!='') $html .= $userData['usr_addr1'].'<br/>';
if ($userData['usr_addr2']!='') $html .= $userData['usr_addr2'].'<br/>';
if ($userData['usr_addr3']!='') $html .= $userData['usr_addr3'].'<br/>';
$html .= $userData['usr_city'].', '.$userData['usr_state'].'  '.$userData['usr_zip'].'<br/>';
$html .= "<br/>";
if ($userData['usr_phone']!='') $html .= 'Phone: '.$userData['usr_phone'].'<br/>';
if ($userData['usr_phone2']!='') $html .= 'Alternate: '.$userData['usr_phone2'].'<br/>';
if ($userData['usr_fax']!='') $html .= 'Fax: '.$userData['usr_fax'].'';
$html .= '</span></div><div style="font-size:36px;">';
if ($eduData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Education</span><br/>';
	$html .= '<table style="width:680px;padding:8px;">';
	foreach ($eduData as $ed) $html .= '<tr><td><div>'.$ed['usredu_school'].'<br/>&nbsp;&nbsp;&nbsp;('.$ed['catedu_text'].')</div></td><td>'.$ed['usredu_start'].' - '.$ed['usredu_end'].'</td><td>'.$ed['usredu_concentrations'].'</td></tr>';
	$html .= '</table><br/>';
}
if ($crtData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Certifications</span><br/>';
	$html .= '<table style="width:680px;padding:8px;">';
	foreach ($crtData as $cd) $html .= '<tr><td>'.(intval($cd['usrcrt_crt_id']==0)?$cd['catcrt_name']:$cd['usrcrt_title']).'</td><td>'.date("Y-m-d",strtotime($cd['usrcrt_date'])).'<br/>'.$cd['catcrt_desc'].'</td><td>'.$cd['usrcrt_comment'].'</td></tr>';
	$html .= '</table><br/>';
}
if ($sklData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Skills</span><br/>';
	$html .= '<table style="width:680px;padding:8px;">';
	foreach ($sklData as $sd) $html .= '<tr><td>'.$sd['usrskl_title'].'</td><td>'.$sd['usrskl_date'].'</td><td>'.$sd['usrskl_comment'].'</td></tr>';
	$html .= '</table><br/>';
}
if ($expData) {
	$html .= '<hr style="width:670px;"/><span style="font-weight:bold">Previous Experience</span><br/>';
	$html .= '<table style="width:680px;padding:8px;">';
	foreach ($expData as $ed) {
		$html .= '<tr><td>'.$ed['usrexp_employer'].'<br/>'.$ed['usrexp_title'].'</td><td>'.$ed['usrexp_start'].' - '.$ed['usrexp_end'].'<br/>'.$ed['usrexp_location'].'</td><td>'.$ed['usrexp_comment'].'</td></tr>';
		foreach ($fncData as $fd) {
			if ($fd['usrexpfnc_usrexp_id'] == $ed['usrexp_id']) $html .= '<tr><td>'.$fd['usrexpfnc_title'].'</td><td>'.$fd['catfnc_text'].'</td><td>Training: '.$fd['cattrn_desc'].'</td></tr>';
		}
	}
	$html .= '</table><br/>';
}
$html .="</div>";

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
$pdf->SetMargins(14, 15, 2);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);// set auto page breaks

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetFont('helvetica', '', 12); // set font
$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');


$pdf->Output('resume.pdf', 'I');
die();

