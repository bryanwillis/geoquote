<?php
set_time_limit(300);
ob_start();
include "config.php";

phpparam('RefID','');
phpparam('service_type','');
phpparam('service_id',''); // agent defined
phpparam('npa','');
phpparam('nxx','');
phpparam('xxxx','');
phpparam('quoteCompany','');
phpparam('quoteFirstName','');
phpparam('quoteLastName','');
phpparam('quoteName','');
phpparam('quoteEmail','');
phpparam('customer_source','');
phpparam('CustomerID','');
phpparam('RefererPage','');
phpparam('QuotePage','');
phpparam('QuoteType','');
phpparam('gq_address_1','');
phpparam('gq_address2_1','');
phpparam('gq_city_1','');
phpparam('gq_state_1','');
phpparam('gq_zip_1','');
phpparam('ErrorMsg','');
phpparam('ErrorMsg2','');
phpparam('CustomerID','');
phpparam('LocationID','');
phpparam('ContactID','');
phpparam('ReadOnly','No');
phpparam('version','');

if ($CustomerID != '' && $LocationID != '' && $ContactID != ''){
	include "geoquote_get_customer_info.php";	
} else {
	
	$quoteName = $quoteFirstName . " " . $quoteLastName;
	
	if ((strlen($npa) != 3) || (strlen($nxx) != 3) || (strlen($xxxx) != 4)) {
		$ErrorMsg = "Your installation phone number is not correct!";
		include "geoquote_step1.php";
		exit;
	}
	
	if ($quoteName == "") {
		$ErrorMsg = "Your contact name is required.";
		include "geoquote_step1.php";
		exit;
	}
	
	if ($QuotePage == '') {
		$QuotePage = getenv('HTTP_REFERER');
	}
	
	ob_end_flush();
	
	$CookieCustomerID = "";
	if (isset($_COOKIE['CustomerID'])) {
		$CookieCustomerID = $_COOKIE['CustomerID'];
	}
	
	$TheCustomerID = 0;
	$BTN = $npa . $nxx . $xxxx;
	
	$XMLSent = "<TelarusQuote>";
	$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
	$XMLSent .= "<Website>" . $website . "</Website>";
	$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
	$XMLSent .= "<Version>" . $version . "</Version>";
	$XMLSent .= "<Source>" . $customer_source . "</Source>";
	$XMLSent .= "<ServiceType>" . $service_type . "</ServiceType>";
	$XMLSent .= "<CookieCustomerID>" . $CookieCustomerID . "</CookieCustomerID>";
	$XMLSent .= "<Customer>";
	$XMLSent .=    "<ContactName>" . xmlspecialchars($quoteName) . "</ContactName>";
	$XMLSent .=    "<BusinessName>" . xmlspecialchars($quoteCompany) . "</BusinessName>";
	$XMLSent .=    "<Email>" . xmlspecialchars($quoteEmail) . "</Email>";
	$XMLSent .=    "<BTN>" . xmlspecialchars($BTN) . "</BTN>";
	$XMLSent .= "</Customer>";
	$XMLSent .= "<RefID>" . xmlspecialchars($RefID) . "</RefID>";
	$XMLSent .= "<RefererPage>" . xmlspecialchars($RefererPage) . "</RefererPage>";
	$XMLSent .= "<EntryPage>" . xmlspecialchars($EntryPage) . "</EntryPage>";
	$XMLSent .= "<QuotePage>" . xmlspecialchars($QuotePage) . "</QuotePage>";
	$XMLSent .= "</TelarusQuote>";
	
	include_once('GeoXML.class.php');
	$geoxml = new GeoXML;
	
	$XmlUrlA = array('http://xml1.telarus.com/quote_step1.cfm');
		
	$geoxml->fetchXML($XmlUrlA, $XMLSent);
	$vals = $geoxml->vals;
	$myxml = $geoxml->myxml;
	
	if ($geoxml->XMLError == 1) {
		include("calculate_error.php");
		exit;
	}
	
	$TheResult = GetValidXML('RESULT',0,'');
	$ErrorMsg = GetValidXML('ERRORMESSAGE',0,'');
	$IncompleteID = GetValidXML('INCOMPLETEID',0,'');
	
	if (($TheResult == "Fail") && ($ErrorMsg == "Max Quotes Exceeded")) {
		$CloserInfo = array();
		$CloserInfo['ContactName'] = GetValidXML('CONTACTNAME',0,'');
		$CloserInfo['TollFree'] = GetValidXML('TOLLFREE',0,'');
		$CloserInfo['Email'] = GetValidXML('EMAIL',0,'');
		$RepeatReason = GetValidXML('REPEATREASON',0,'');
		include "repeat.php";
		exit;
	 } elseif ($TheResult == "Fail") {
			include "geoquote.php";
	    	exit;
	 } else {
		$CustomerInfo = array();
		$CustomerInfo["CustomerID"] = GetValidXML('CUSTOMERID',0,'');
		$CustomerInfo["Address1"] = GetValidXML('ADDRESS1',0,'');
		$CustomerInfo["Address2"] = GetValidXML('ADDRESS2',0,'');
		$CustomerInfo["Details"] = GetValidXML('DETAILS',0,'');
	
		if (($CustomerInfo["CustomerID"] != 0) && ($customer_source == "")) {
			$TheCustomerID = $CustomerInfo["CustomerID"];
			
			if ($gq_address_1 == "") {
				$gq_address_1 = $CustomerInfo["Address1"];
			}
			if ($gq_address2_1 == "") {
				$gq_address2_1 = $CustomerInfo["Address2"];
			}
	
			for($i=0; $i < count($myxml['CITY']); $i++){
	
				if ($gq_city_1 == "" && GetValidXML('CITY',$i,'') != '') {
					$gq_city_1 = GetValidXML('CITY',$i,'');
				}
	
				if ($gq_state_1 == "" && GetValidXML('STATE',$i,'') != '') {
					$gq_state_1 = GetValidXML('STATE',$i,'');
				}
				
				if ($gq_zip_1 == "" && GetValidXML('ZIP',$i,'') != '') {
					$gq_zip_1 = GetValidXML('ZIP',$i,'');
				}			
	
			}
			
			$customer_source = "return";
		}
	
		$ReversePhone = array();
		$ReversePhone["Result"] = GetValidXML('RESULT',1,'');
		$ReversePhone["Name"] = GetValidXML('NAME',0,'');
		$ReversePhone["Address"] = GetValidXML('ADDRESS',0,'');
		$ReversePhone["City"] = GetValidXML('CITY',0,'');
		$ReversePhone["State"] = GetValidXML('STATE',0,'');
		$ReversePhone["Zip"] = GetValidXML('ZIP',0,'');
	
		if ($customer_source == "") {
			if (($gq_address_1 == "") && ($ReversePhone["Address"] != "")) {
				$gq_address_1 = $ReversePhone["Address"];
				$customer_source = "reverse";
			}
	      if ($gq_city_1 == "") {
				$gq_city_1 = $ReversePhone["City"];
			}
			if (strpos($gq_city_1,"</div>") == true) {
				$gq_city_1 = "";
			}
	        if (($gq_state_1 == "") && ($ReversePhone["State"] != "")) {
				$gq_state_1 = $ReversePhone["State"];
				$customer_source = "reverse";
			}
			if (($gq_zip_1 == "") && ($ReversePhone["Zip"] != "")) {
				$gq_zip_1 = $ReversePhone["Zip"];
				$customer_source = "reverse";
			}
		}
	}
	
}	

include_once "header.php";
include "geoquote_step2_services.php";
include_once "footer.php";
?>
