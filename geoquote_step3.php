<?php
set_time_limit(300);
include "config.php";
phpparam('source','');
phpparam('serviceType','');
phpparam('keyword','');
phpparam('quoteName','');
phpparam('quoteFirstName','');
phpparam('quoteCompany','');
phpparam('quoteEmail','');
phpparam('gq_installNPA_1','');
phpparam('gq_installNXX_1','');
phpparam('gq_installXXXX_1','');
phpparam('gq_address_1','');
phpparam('gq_address2_1','');
phpparam('gq_city_1','');
phpparam('gq_state_1','');
phpparam('gq_zip_1','');
phpparam('comments','');
phpparam('gq_categoryID','');
phpparam('ServiceID','');
phpparam('product','');
phpparam('gq_locationCount',1);
phpparam('contact_npa','');
phpparam('contact_nxx','');
phpparam('contact_xxxx','');
phpparam('contact_extension','');
phpparam('contact_time','');
phpparam('preference','emailme');
phpparam('RefID','');
phpparam('RefererPage','');
phpparam('EntryPage','');
phpparam('QuotePage','');
phpparam('IncompleteID','');
phpparam('gq_isPRI',0);
phpparam('UploadFile','');
phpparam('uploadVAR','');
phpparam('CustomerID','');
phpparam('LocationID','');
phpparam('ContactID','');
phpparam('ErrorMsg','');
phpparam('ErrorMsg2','');

$qs = '?FirstName=' . $quoteFirstName . '&ServiceID=' . $ServiceID . '&Source=public';
include "geoquote_calculating.php";

// comments
$gq_comments = trim($comments);
if ($gq_comments == "Enter your comments here"){
	$gq_comments = "";
}

// location infor
for($i=1; $i <= $gq_locationCount; $i++){
	if (array_key_exists('gq_installNPA_' . $i, $_POST)){
		$gq_installNPA_i = $_POST['gq_installNPA_' . $i];
	}
	
	if (array_key_exists('gq_installNXX_' . $i, $_POST)){
		$gq_installNXX_i = $_POST['gq_installNXX_' . $i];
	}	
	
	if (array_key_exists('gq_installXXXX_' . $i, $_POST)){
		$gq_installXXXX_i = $_POST['gq_installXXXX_' . $i];
	}	
	
	if (array_key_exists('gq_address_' . $i, $_POST)){
		$gq_address_i = $_POST['gq_address_' . $i];
	}	
	
	if (array_key_exists('gq_address2_' . $i, $_POST)){
		$gq_address2_i = $_POST['gq_address2_' . $i];
	}	
	
	if (array_key_exists('gq_city_' . $i, $_POST)){
		$gq_city_i = $_POST['gq_city_' . $i];
	}	
	
	if (array_key_exists('gq_state_' . $i, $_POST)){
		$gq_state_i = $_POST['gq_state_' . $i];
	}	
	
	if (array_key_exists('gq_zip_' . $i, $_POST)){
		$gq_zip_i = $_POST['gq_zip_' . $i];
	}							
}

if($gq_address_1 == ''){
	$ErrorMsg2 = "Your Address is required!";
	include "geoquote_step2.php";
	exit;
}

$gq_btn = $gq_installNPA_1 . $gq_installNXX_1 . $gq_installXXXX_1;
if ((strlen($gq_installNPA_1) != 3) || (strlen($gq_installNXX_1) != 3) || (strlen($gq_installXXXX_1) != 4)) {
	$ErrorMsg2 = "Your installation pone number is not correct!";
	include "geoquote_step1.php";
	exit;
}

// contact_phone
if($contact_npa == ''){$contact_npa = $gq_installNPA_1;}
if($contact_nxx == ''){$contact_nxx = $gq_installNXX_1;}
if($contact_xxxx == ''){$contact_xxxx = $gq_installXXXX_1;}
$contact_phone = $contact_npa . $contact_nxx . $contact_xxxx . $contact_extension;
$contact_phone = str_replace("[^0-9]","",$contact_phone);


// otherBrand
$gq_otherBrandVAR = 'gq_otherBrand_' . $gq_categoryID . '_' . $ServiceID;
if (isset($_POST['otherBrand'])){
	$$gq_otherBrandVAR = $_POST['otherBrand'];
}

// mpls_UploadSiteList
if (array_key_exists('gq_mpls_UploadSiteList_' . $gq_categoryID . '_' . $ServiceID, $_POST)){
	$uploadVAR = $_POST['gq_mpls_UploadSiteList_' . $gq_categoryID . '_' . $ServiceID];
}

// cookieCustomerID
$cookieCustomerID = "";
if (isset($_COOKIE["CustomerID"])) {
	$cookieCustomerID = $_COOKIE["CustomerID"];
}


// upload file begin
$tempDocCustomerID = date("YmdHis");
$docCustomerID = $tempDocCustomerID;
$uploadFileName = '';
$targetPath = "upload/";
if ($uploadVAR == 1){
	$uploadFileName = $_FILES['UploadFile']['tmp_name'];
	$uploadFileSize = round(($_FILES["UploadFile"]["size"] / 1024),2);
	$uploadFileType = $_FILES["UploadFile"]["type"];
	
	if ($uploadFileName != ''){
		$fileName = "mpls-" . $docCustomerID . "-" . basename($_FILES['UploadFile']['name']);
		$targetPath = $targetPath . $fileName;
		
		
		// check file type
		$fileTypeA = array(
		".doc" => "application/msword",
		".xls" => "application/msexcel",
		".mdb" => "application/msaccess",
		".ppt" => "application/mspowerpoint",
		".pdf" => "application/pdf",
		".ps" => "application/postscript",
		".rtf" => "application/rtf",
		".txt" => "text/plain",
		".html" => "text/html",
		".jpg" => "image/pjpeg",
		".gif" => "image/gif",
		".png" => "image/x-png",
		".html" => "text/html",
		".csv" => "application/vnd.ms-excel");
	
		foreach($fileTypeA as $k => $v){
			if($uploadFileType == $v){
				$uploadFileTypeExt = $k;
			} 
		}
		
		if(!array_key_exists($uploadFileTypeExt,$fileTypeA) && $uploadFileType != ''){
			$ErrorMsg2 = "The file type you tried to upload is not allowed. Please choose a allowed format file to upload.";
			include "geoquote_step2.php";
			exit;	
		}
		
		// check file size
		if($_FILES["UploadFile"]["size"] > 1000000){
			$ErrorMsg2 = "The maxmum file size is 1000K. Please decrease the size of your image.";
			include "geoquote_step2.php";
			exit;
		}	
	
		// upload file
		if(!move_uploaded_file($uploadFileName, $targetPath)) {
			// if upload file failed, do something here.
			$ErrorMsg2 =  "can not upload a file";
			include "geoquote_step2.php";
			exit;
		} 
	}
}
// upload file end

// send xml data
$XMLSent = "<TelarusQuote>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<Source>" . xmlspecialchars($source) . "</Source>";
$XMLSent .= "<ServiceType>" . xmlspecialchars($service_type) . "</ServiceType>";
$XMLSent .= "<keyword>" . xmlspecialchars($keyword) . "</keyword>";
$XMLSent .= "<CookieCustomerID>" . xmlspecialchars($cookieCustomerID) . "</CookieCustomerID>";
$XMLSent .= "<ReturnPath>" . xmlspecialchars($ReturnPath) . "</ReturnPath>";
$XMLSent .= "<ReturnFrontPage>" . xmlspecialchars($ReturnFrontPage) . "</ReturnFrontPage>";
$XMLSent .= "<Customer>";
$XMLSent .=    "<ContactName>" . xmlspecialchars($quoteName) . "</ContactName>";
$XMLSent .=    "<BusinessName>" . xmlspecialchars($quoteCompany) . "</BusinessName>";
$XMLSent .=    "<Email>" . xmlspecialchars($quoteEmail) . "</Email>";
$XMLSent .=    "<BTN>" . xmlspecialchars($gq_btn) . "</BTN>";
$XMLSent .=    "<address1>" . xmlspecialchars($gq_address_1) . "</address1>";
$XMLSent .=    "<address2>" . xmlspecialchars($gq_address2_1) . "</address2>";
$XMLSent .=    "<city>" . xmlspecialchars($gq_city_1) . "</city>";
$XMLSent .=    "<state>" . xmlspecialchars($gq_state_1) . "</state>";
$XMLSent .=    "<zip>" . xmlspecialchars($gq_zip_1) . "</zip>";
$XMLSent .=    "<comments>" . xmlspecialchars($gq_comments) . "</comments>";
$XMLSent .=    "<AdditionalLocations>";
if($gq_locationCount > 1){
	for($i=2; $i <= $gq_locationCount; $i++){
		$XMLSent .=	'<location id="0" name="loc_' . $i . '" btn="' . xmlspecialchars($_POST['gq_installNPA_' . $i]) . xmlspecialchars($_POST['gq_installNXX_' . $i]) . xmlspecialchars($_POST['gq_installXXXX_' . $i]) . '" address_1="' . xmlspecialchars($_POST['gq_address_' . $i]) . '" address_2="' . xmlspecialchars($_POST['gq_address2_' . $i]) . '" city="' . xmlspecialchars($_POST['gq_city_' . $i]) . '" state="' . xmlspecialchars($_POST['gq_state_' . $i]) . '" zip="' . xmlspecialchars($_POST['gq_zip_' . $i]) . '" />';
	}
}
$XMLSent .=    "</AdditionalLocations>";
$XMLSent .= "</Customer>";
$XMLSent .= "<ServicesV2ID>" . xmlspecialchars($ServiceID) . "</ServicesV2ID>";
$XMLSent .= "<Product>" . xmlspecialchars($product) . "</Product>";
$XMLSent .= "<Locations>" . xmlspecialchars($gq_locationCount) . "</Locations>";
$XMLSent .= "<Contact>";
$XMLSent .=    "<ContactPhone>" . xmlspecialchars($contact_phone) . "</ContactPhone>";
$XMLSent .=    "<ContactTime>" . xmlspecialchars($contact_time) . "</ContactTime>";
$XMLSent .=    "<ContactPreference>" . xmlspecialchars($preference) . "</ContactPreference>";
$XMLSent .= "</Contact>";
$XMLSent .= "<CustomerID>" . xmlspecialchars($CustomerID) . "</CustomerID>";
$XMLSent .= "<ContactID>" . xmlspecialchars($ContactID) . "</ContactID>";
$XMLSent .= "<LocationID>" . xmlspecialchars($LocationID) . "</LocationID>";
$XMLSent .= "<RefID>" . xmlspecialchars($RefID) . "</RefID>";
$XMLSent .= "<RefererPage>" . xmlspecialchars($RefererPage) . "</RefererPage>";
$XMLSent .= "<EntryPage>" . xmlspecialchars($EntryPage) . "</EntryPage>";
$XMLSent .= "<QuotePage>" . xmlspecialchars($QuotePage) . "</QuotePage>";
$XMLSent .= "<IncompleteID>" . xmlspecialchars($IncompleteID) . "</IncompleteID>";
$XMLSent .= "<PRI>" . xmlspecialchars($gq_isPRI) . "</PRI>";

// questions and answers
$XMLSent .=	"<Questions>";
$categoryServiceVAR = "_" . $gq_categoryID . "_" . $ServiceID;
foreach($_POST as $k => $v){
	$position = strstr($k, $categoryServiceVAR);
	if($position !== false && substr($k,0,3) == 'gq_'){
		$thisKey = str_replace("gq_","",$k);
		$thisKey = str_replace($categoryServiceVAR,"",$thisKey);
		
		if(is_array($v)){
			$thisValue = implode(",", $v);
		} else {
			$thisValue = $v;
		}
		$XMLSent .= '<question name="' . xmlspecialchars($thisKey) . '" value="' . xmlspecialchars($thisValue) . '" />';
	}
}
$XMLSent .=	"</Questions>";
$XMLSent .= "</TelarusQuote>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/quote_step2.cfm');
	
$geoxml->fetchXML($XmlUrlA, $XMLSent);
$vals = $geoxml->vals;
$myxml = $geoxml->myxml;

if ($geoxml->XMLError == 1) {
	include("calculate_error.php");
	exit;
}

$QuoteResult = GetValidXML('RESULT',0,'');
$ErrorMsg = GetValidXML('ERRORMESSAGE',0,'');
$NextURL =  GetValidXML('NEXTURL',0,'');
$ErrorMsg2 = $ErrorMsg;

if ($NextURL != "") {
	echo <<< EOF
	<script type="text/javascript" language="javascript">
		location.href = "$NextURL";
	</script>
EOF;
	exit;
}

if ($ErrorMsg == "Max Quotes Exceeded") {
	$CloserInfo = array();
	$CloserInfo['ContactName'] = GetValidXML('CONTACTNAME',0,'');
	$CloserInfo['TollFree'] = GetValidXML('TOLLFREE',0,'');
	$CloserInfo['Email'] = GetValidXML('EMAIL',0,'');
	$ContactName = $CloserInfo['ContactName'];
	$TollFree = $CloserInfo['TollFree'];
	$Email = $CloserInfo['Email'];	
	$RepeatReason = GetValidXML('REPEATREASON',0,'');
	include "repeat.php";
	exit;
}

if ($QuoteResult == "Success") {
	$CustomerID = GetValidXML('CUSTOMERID',0,'');
	$key = GetValidXML('KEY',0,'');
	$QuoteID = GetValidXML('QUOTEID',0,'');

	echo <<<EOF
	<script type="text/javascript">
EOF;
	echo "location.href='quote.php?CustomerID=" . $CustomerID . "&key=" . $key . "&QuoteID=" . $QuoteID .  $Tracking_A . "'";	
	echo <<<EOF
	</script>	
EOF;
	exit;
}

if ($QuoteResult != "Success") {

	$TheCustomerID = "";
	$customer_source = "none";
	include_once "header.php";
	include "geoquote_step2.php";
	include_once "footer.php";
} 
?>