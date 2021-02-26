<?php
if (!defined('C3cms')) die('');
if (!defined('C3cmsCore')) die('');

// check if editing requested

if (isset($_REQUEST['op'])) {
	switch ($_REQUEST['op']) {
		case "pageEdit":
//				$footerScript .= file_get_contents('js/tiny_mce/tiny_mce.js');
				$footerScript .= <<<XJS
	tinyMCE.init({
		// General options
        mode : "exact",
        elements : "elm1",
		theme : "advanced",
		skin : "default",
		width: "1000",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "/new/css/edit.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "/demo/inc/link_list.php",
		external_image_list_url : "/demo/inc/image_list.php",
		media_external_list_url : "/demo/inc/media_list.php",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});					
XJS;
			$dat = Q2R("SELECT * FROM res_content WHERE rescon_id='".CleanS($_REQUEST['pageID'])."' ");
				$datWid = (intval($dat['rescon_width'])!=0?$dat['rescon_width']:1000);
				$datHgt = (intval($dat['rescon_height'])!=0?$dat['rescon_height']:1000);
				$content = '<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
					<div style="margin:10px; padding:10px; background:#400; color:#fff; font-weight:bold; ">
						<span style="margin:5px;padding:5px;">Editing Page: "'.$dat['rescon_area'].' '.$dat['rescon_sub'].'"</span>
						&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onclick=\'$("#editorWindow").hide(500);\' />
						&nbsp;&nbsp;&nbsp;<input type="button" value="Upload" onclick=\'$("#uploadForm").show(1500);$(this).hide(1000);\' />
						<div id="uploadForm" style="display:none;">
							<form method="post" enctype="multipart/form-data">
								<input type="hidden" name="op" value="uploadFile" /><input type="hidden" name="show" value="content" /><input type="hidden" name="fileNum" value="-1" />
								<table style="border:0px solid black;margin:5px;display:inline-block;">
									<thead><tr><th style="width:100px">File Title / Name</th><th><input type="submit" value="Upload" /></th><th><input type="submit" value="Store Existing URL" /></th></tr></thead>
									<tbody><tr><td><input type="text" name="resfil_name" id="resfil_name" style="width:320px" title="The title caption of this file."/></td><td><input type="file" name="resfil_data" title="File to upload."/></td><td><input type="text" name="resfil_datapath" title="Use file at this URL instead of uploading." style="width:300px;"/></td></tr></tbody>
								</table>
							</form>
						</div>
					</div>
					<form action="'.$_SERVER['PHP_SELF'].'" method="post">
						<input type="hidden" name="op" value="pageEditSave" />
						<textarea id="elm1" name="elm1" style="width:'.$datWid.'px;height:'.$datHgt.'px;">'. $dat['rescon_content'] .'</textarea>
						<input type="hidden" name="pageID" value="'.CleanS($_REQUEST['pageID']).'" />
					</form>';
				if ((intval($dat['rescon_height'])!=0) || intval($dat['rescon_width'])!=0) $footerScript .= 'setTimeout(\'$("#elm1_ifr").animate({width:"'.$datWid.'px", height:"'.$datHgt.'px"},1000);$(".mceIframeContainer")[0].style.background="#000000";\',3000);';
				$response="ajax";
				require "inc/transmit.php";
			break;
		case "pageEditSave":
			Q("UPDATE res_content SET rescon_content = '".Clean($_REQUEST['elm1'])."' WHERE rescon_id='".CleanI($_REQUEST['pageID'])."' ");
			break;
		case "uploadFile":
			$fileNumber = CleanI($_REQUEST['fileNum']);
			if ($_FILES["resfil_data"]["error"] == 4) { // link instead of file.
				if ($fileNumber == -1) $newFile = QI("INSERT INTO res_files (resfil_name, resfil_date, resfil_size, resfil_mime, resfil_datapath) VALUES ('".Clean($_REQUEST['resfil_name'])."','".date('Y-m-d H:i:s')."','0','-remote-','".Clean($_REQUEST['resfil_datapath'])."')");
				else $newFile = Q("UPDATE res_files SET resfil_name='".Clean($_REQUEST['resfil_name'])."', resfil_date='".date('Y-m-d H:i:s')."', resfil_size='".$_FILES["resfil_data"]["size"]."', resfil_mime='".$_FILES["resfil_data"]["type"]."', resfil_datapath='".Clean($_REQUEST['resfil_datapath'])."' WHERE resfil_id ='".$fileNumber."'");
			} elseif ($_FILES["resfil_data"]["error"] > 0) { // bad upload
				$footerScript .="alert('Error: " . $_FILES["resfil_data"]["error"] . "');";
			} else { // uploading
				if (file_exists("media/" . $_FILES["resfil_data"]["name"])) $footerScript .="alert('File: ". $_FILES["resfil_data"]["name"] . " overwritten.'); ";
				move_uploaded_file($_FILES["resfil_data"]["tmp_name"], $siteFileRoot."media/" . $_FILES["resfil_data"]["name"]);
				//$footerScript .="alert('Stored in: " . $siteFileRoot."media/" . $_FILES["resfil_data"]["name"]."');";
				$literalPath = "media/" . $_FILES["resfil_data"]["name"];
				if ($fileNumber == -1) $newFile = QI("INSERT INTO res_files (resfil_name, resfil_date, resfil_size, resfil_mime, resfil_datapath) VALUES ('".Clean($_REQUEST['resfil_name'])."','".date('Y-m-d H:i:s')."','".$_FILES["resfil_data"]["size"]."','".$_FILES["resfil_data"]["type"]."','".$literalPath."')");
				else $newFile = Q("UPDATE res_files SET resfil_name='".Clean($_REQUEST['resfil_name'])."', resfil_date='".date('Y-m-d H:i:s')."', resfil_size='".$_FILES["resfil_data"]["size"]."', resfil_mime='".$_FILES["resfil_data"]["type"]."', resfil_datapath='".$literalPath."' WHERE resfil_id ='".$fileNumber."'");
			}
			break;
		case "deleteFile":
			Q("DELETE FROM res_files WHERE resfil_id = '".CleanI($_REQUEST['fil'])."'");
			break;
		case "emailUser":
			$ut = Q2R("SELECT * FROM usr WHERE usr_id='".CleanI($_REQUEST['usr'])."'");
			$content = '<form method="post">
				<table style="display:inline-block;vertical-align:top;">
					<tbody>
						<tr><td colspan="2">'.$ut['usr_firstname'].' '.$ut['usr_lastname'].' at <input type="text" style="width:250px" name="eml_to" value="'.$ut['usr_email'].'" /></td></tr>
						<tr><td>Subject</td><td><input type="text" style="width:350px;" name="eml_subject" value="" /></td></tr>
						<tr><td colspan="2"><textarea style="width:400px; height:350px;" name="eml_body" /></textarea></td></tr>
					</tbody>
				</table>
				<input type="hidden" name="op" value="emailUserSend" /><input type="submit" value="Send" />
				</form>
			';
			$response = "ajax";
			require "inc/transmit.php";
			break;
		case "emailUserSend":
			$footerScript .= "alert('not yet implemented');";
			break;
		case "editUser":
			$ut = Q2R("SELECT * FROM usr WHERE usr_id='".CleanI($_REQUEST['usr'])."'");
			$content = '
			<form method="post" action="#">
				<table style="vertical-align:top;">
					<tbody>
					<tr><td>First Name</td><td><input type="text" name="usr_firstname" value="'.$ut['usr_firstname'].'" /></td></tr>
					<tr><td>Last Name</td><td><input type="text" name="usr_lastname" value="'.$ut['usr_lastname'].'" /></td></tr>
					<tr><td>Title</td><td><input type="text" name="usr_title" value="'.$ut['usr_title'].'" /></td></tr>
					<tr><td>Prefix</td><td><input type="text" name="usr_prefix" value="'.$ut['usr_prefix'].'" /></td></tr>
					<tr><td>Email</td><td><input type="text" name="usr_email" value="'.$ut['usr_email'].'" /></td></tr>
					<tr><td>Address 1</td><td><input type="text" name="usr_addr1" value="'.$ut['usr_addr1'].'" /></td></tr>
					<tr><td>Address 2</td><td><input type="text" name="usr_addr2" value="'.$ut['usr_addr2'].'" /></td></tr>
					<tr><td>Address 3</td><td><input type="text" name="usr_addr3" value="'.$ut['usr_addr3'].'" /></td></tr>
					<tr><td>City</td><td><input type="text" name="usr_city" value="'.$ut['usr_city'].'" /></td></tr>
					<tr><td>State</td><td><input type="text" name="usr_state" value="'.$ut['usr_state'].'" /></td></tr>
					<tr><td>Zip</td><td><input type="text" name="usr_zip" value="'.$ut['usr_zip'].'" /></td></tr>
					<tr><td>Country</td><td><input type="text" name="usr_country" value="'.$ut['usr_country'].'" /></td></tr>
					<tr><td>Phone</td><td><input type="text" name="usr_phone" value="'.$ut['usr_phone'].'" /></td></tr>
					<tr><td>Phone 2</td><td><input type="text" name="usr_phone2" value="'.$ut['usr_phone2'].'" /></td></tr>
					<tr><td>Fax</td><td><input type="text" name="usr_fax" value="'.$ut['usr_fax'].'" /></td></tr>
					<tr><td></td><td><input type="hidden" name="usr_active" value="'.$ut['usr_active'].'" /></td></tr>
					</tbody>
				</table>
				<div style="position:relative;float:right;margin-right:60px;bottom:20px;">
					<input type="submit" value="Save Changes" /><input type="reset" value="Reset" />
					<input type="hidden" name="op" value="editUserSave" /><input type="hidden" name="usr_id" value="'.$ut['usr_id'].'" />
				</div>
			 </form>';
			$response = "ajax"; 
			require "inc/transmit.php"; 
			break;
		case "createUserSave":
		switch(CleanI($_REQUEST['usr_type'])) {
				case 0:
					$userAuth = 2;
					$userType = 0;
					break;
				case 1:
					$userAuth = 2;
					$userType = 1;
					break;
				case 99:
					$userAuth = 8;
					$userType = 99;
					break;					
			}				
			$newID = QI("INSERT INTO usr (`usr_email`, `usr_firstname`, `usr_lastname`, `usr_title`, `usr_prefix`, `usr_addr1`, `usr_addr2`, `usr_addr3`, `usr_city`, 
			`usr_state`, `usr_zip`, `usr_country`, `usr_phone`, `usr_phone2`, `usr_fax`, `usr_active`, `usr_join`, `usr_expire`, `usr_lastlogin`, `usr_password`,
			`usr_auth`, `usr_created`, `usr_updated`,`usr_company`,`usr_type`) 
			VALUES ('".Clean($_REQUEST['usr_email'])."', '".Clean($_REQUEST['usr_firstname'])."', '".Clean($_REQUEST['usr_lastname'])."', '".Clean($_REQUEST['usr_title'])."',
			'".Clean($_REQUEST['usr_prefix'])."', '".Clean($_REQUEST['usr_addr1'])."', '".Clean($_REQUEST['usr_addr2'])."', '".Clean($_REQUEST['usr_addr3'])."', '".Clean($_REQUEST['usr_city'])."',
			'".Clean($_REQUEST['usr_state'])."', '".Clean($_REQUEST['usr_zip'])."', '".Clean($_REQUEST['usr_country'])."', '".Clean($_REQUEST['usr_phone'])."', '".Clean($_REQUEST['usr_phone2'])."',
			'".Clean($_REQUEST['usr_fax'])."', 'A', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s",strtotime("+1 year"))."', '0000-00-00 00:00:00', '".Clean(sha1($_REQUEST['usr_password']))."', 
			'".$userAuth."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."','".Clean($_REQUEST['usr_emp'])."','".$userType."');");
			//switch(CleanI($_REQUEST['usr_auth'])) {
				//case 1:
					QI("INSERT INTO usr_app (usrapp_usr_id,usrapp_status,usrapp_edu_level,usrapp_ava_id,usrapp_clearance,usrapp_created) VALUES ('".$newID."','1','1','1','4','".date("Y-m-d H:i:s")."')");
					
					QI("INSERT INTO usr_edu (usredu_usr_id, usredu_edu_id) values ('".$newID."','1')");
					
					QI("INSERT INTO usr_clearance (usrclr_usr_id, usrclr_clr_id,usrclr_title) values ('".$newID."','4','None')");
				
					//break;
				//case 2:
					//$q= "INSERT INTO usr_emp (usremp_usr_id,usremp_emp_id,usremp_auth) VALUES ('".$newID."','".CleanI($_REQUEST['usr_emp'])."','".Clean($_REQUEST['emp_auth'])."')";
					//$content .=$q;
					//QI($q);
					//break;
			//}
			
			break;
		case "createCompanySave":
			QI("INSERT INTO `emp` (`emp_name`, `emp_address`, `emp_contact`, `emp_phone`, `emp_fax`, `emp_email`, `emp_reference_number`, `emp_notes`, `emp_updated`) 
			VALUES ( '".Clean($_REQUEST['emp_name'])."', '".Clean($_REQUEST['emp_address'])."', '".Clean($_REQUEST['emp_contact'])."', '".Clean($_REQUEST['emp_phone'])."', 
			'".Clean($_REQUEST['emp_fax'])."', '".Clean($_REQUEST['emp_email'])."', '".Clean($_REQUEST['emp_reference_number'])."', '".Clean($_REQUEST['emp_notes'])."', '".date("Y-m-d H:i:s")."')");
			break;
		case "passwordUser":
			$ut = Q2R("SELECT * FROM usr WHERE usr_id = '".CleanI($_REQUEST['usr'])."'");
			$content = '<form method="post">
				<table style="display:inline-block;vertical-align:top;">
					<tbody>
						<tr><td colspan="2">Change password of: '.$ut['usr_firstname'].' '.$ut['usr_lastname'].'</td></tr>
						<tr><td>To:</td><td><input type="text" style="width:150px;" name="pass" value="" /><input type="hidden" name="usr" value="'.$ut['usr_id'].'" /></td></tr>
					</tbody>
				</table><br/><br/>
				Send Email message to user with new password: <input type="checkbox" name="sendMessage" value="SEND" checked="checked" /><br/><br/>
				<input type="hidden" name="op" value="passwordUpdate" /><input type="submit" value="Save / Send" />
				</form>
			';
			$response = "ajax";
			require "inc/transmit.php";
			break;
		case "passwordUpdate":
			$ut = Q2R("SELECT * FROM usr WHERE usr_id = '".CleanI($_REQUEST['usr'])."'");
			if (isset($_REQUEST['sendMessage'])) {
					$tmp_content = "\nYour account password has been changed.  \n\nYour new password is:  " . Clean($_REQUEST['pass']) . "\n\n";
					mail($ut['usr_email'],"JobConnect Password Change",$tmp_content,'From: info@bizconnectonline.com' . "\r\n" . 'Reply-To: no-reply@bizconnectonline.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion() );
			}
			$did = Q("UPDATE usr SET usr_password = '".sha1($_REQUEST['pass'])."' WHERE usr_id ='".CleanI($_REQUEST['usr'])."' ");

		case "editMenu":
			Q("UPDATE res_content SET rescon_auth='".Clean($_REQUEST['pageScope'])."', rescon_menu='".Clean($_REQUEST['pageMenuText'])."', rescon_menuscope='".Clean($_REQUEST['pageMenuScope'])."', rescon_menusubtext='".Clean($_REQUEST['pageMenuSubtext'])."', rescon_menustyle='".Clean($_REQUEST['pageMenuStyle'])."', rescon_order='".CleanI($_REQUEST['pageMenuOrder'])."' WHERE rescon_id='".CleanI($_REQUEST['resconID'])."' ");
			break;
		case "newPage":
			$newFileContents = '';
			foreach (file($siteFileRoot. 'inc/templates/newPageTemplate.php') as $line) if (substr($line, 0, 2) != "//" ) $newFileContents .= $line;
			$newFileContents = str_replace("<<<newPageTitle>>>", $_REQUEST['pageName'], $newFileContents);
			$newFileContents = str_replace("<<<newPageAuth>>>", $_REQUEST['pageScope'], $newFileContents);
			$fp = fopen($siteTmpPath.($_REQUEST['pageURL']).'.php', 'w'); fwrite($fp, $newFileContents); fclose($fp);
			$newPage = QI("INSERT INTO res_content (rescon_area, rescon_sub, rescon_url, rescon_order, rescon_auth, rescon_menu, rescon_menuscope, rescon_menusubtext, rescon_menustyle, rescon_date, rescon_posted) VALUES (
				'".Clean($_REQUEST['pageName'])."', '','".Clean($_REQUEST['pageURL'])."', '".Clean($_REQUEST['pageMenuOrder'])."', '".Clean($_REQUEST['pageScope'])."', '".Clean($_REQUEST['pageMenuText'])."', 
				'".Clean($_REQUEST['pageMenuScope'])."', '".Clean($_REQUEST['pageMenuSubtext'])."', '".Clean($_REQUEST['pageMenuStyle'])."', '".date('Y-m-d H:i:s')."','0')");
			$footerScript .= '$.ajax({url: "inc/moveFile.php?pageID='.$newPage.'"});';

			break;
		case "newSubPage":
			$newPage = QI("INSERT INTO res_content (rescon_area, rescon_sub, rescon_url, rescon_order, rescon_height, rescon_width, rescon_auth, rescon_date, rescon_posted) VALUES (
				'".QV("SELECT rescon_area FROM res_content WHERE rescon_id = '".Clean($_REQUEST['parentPage'])."' ")."', '".Clean($_REQUEST['pageName'])."','', '0', '".Clean($_REQUEST['newHeight'])."', '".Clean($_REQUEST['newWidth'])."', '".Clean($_REQUEST['pageScope'])."', '".date('Y-m-d H:i:s')."','0')");
			$footerScript .= '$.ajax({url: "inc/moveFile.php?pageID='.$newPage.'"});';
			break;
		case "editUserSave":
			$q = "UPDATE usr SET 
					usr_firstname = '".Clean($_REQUEST['usr_firstname'])."',
					usr_lastname = '".Clean($_REQUEST['usr_lastname'])."',
					usr_title = '".Clean($_REQUEST['usr_title'])."',
					usr_prefix = '".Clean($_REQUEST['usr_prefix'])."', 
					usr_email = '".Clean($_REQUEST['usr_email'])."', 
					usr_addr1 = '".Clean($_REQUEST['usr_addr1'])."', 
					usr_addr2 = '".Clean($_REQUEST['usr_addr2'])."',
					usr_addr3 = '".Clean($_REQUEST['usr_addr3'])."', 
					usr_city = '".Clean($_REQUEST['usr_city'])."', 
					usr_state = '".Clean($_REQUEST['usr_state'])."', 
					usr_zip = '".Clean($_REQUEST['usr_zip'])."', 
					usr_country = '".Clean($_REQUEST['usr_country'])."', 
					usr_phone = '".Clean($_REQUEST['usr_phone'])."', 
					usr_phone2 = '".Clean($_REQUEST['usr_phone2'])."', 
					usr_fax = '".Clean($_REQUEST['usr_fax'])."', 
					usr_active = '".Clean($_REQUEST['usr_active'])."' 
				WHERE usr_id = '".CleanI($_REQUEST['usr_id'])."'";
			$did = Q($q);
			break;
		case "pdfResume":
			require_once('resume.php');
			break;
	}
}



?>
