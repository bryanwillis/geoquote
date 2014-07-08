<?php
include_once "config.php";

phpparam('CustomerID','');
phpparam('LocationID','');
phpparam('ContactID','');

if ($CustomerID != '' && $LocationID != '' && $ContactID != ''){
	
	$XMLSent = "<TelarusQuote>";
	$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
	$XMLSent .= "<Website>" . $website . "</Website>";
	$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
	$XMLSent .= "<CustomerID>" . $CustomerID . "</CustomerID>";
	$XMLSent .= "<LocationID>" . $LocationID . "</LocationID>";
	$XMLSent .= "<ContactID>" . $ContactID . "</ContactID>";
	$XMLSent .= "</TelarusQuote>";
	
	include_once('GeoXML.class.php');
	$geoxml = new GeoXML;
	
	$XmlUrlA = array('http://xml.telarus.com/gq_plugin/get_customer_info.cfm');
		
	$geoxml->fetchXML($XmlUrlA, $XMLSent);
	$vals = $geoxml->vals;
	$myxml = $geoxml->myxml;	

	$TheResult = GetValidXML('RESULT',0,'');
	$ErrorMsg = GetValidXML('ERRORMESSAGE',0,'');
	
	if ($TheResult == "Success"){
		$CustomerInfo = array();
		$CustomerInfo["Name"] = GetValidXML('NAME',0,'');
		$CustomerInfo["Title"] = GetValidXML('TITLE',0,'');
		$CustomerInfo["BusinessName"] = GetValidXML('BUSINESSNAME',0,'');
		$CustomerInfo["Email"] = GetValidXML('EMAIL',0,'');
		$CustomerInfo["Email2"] = GetValidXML('EMAIL2',0,'');
		$CustomerInfo["Address1"] = GetValidXML('ADDRESS1',0,'');
		$CustomerInfo["Address2"] = GetValidXML('ADDRESS2',0,'');
		$CustomerInfo["City"] = GetValidXML('CITY',0,'');
		$CustomerInfo["State"] = GetValidXML('STATE',0,'');
		$CustomerInfo["Zip"] = GetValidXML('ZIP',0,'');
		$CustomerInfo["PhoneOffice"] = GetValidXML('PHONEOFFICE',0,'');
		
		$LocationInfo = array();
		$LocationInfo["Address1"] = GetValidXML('LOCATIONADDRESS1',0,'');
		$LocationInfo["Address2"] = GetValidXML('LOCATIONADDRESS2',0,'');
		$LocationInfo["City"] = GetValidXML('LOCATIONCITY',0,'');
		$LocationInfo["State"] = GetValidXML('LOCATIONSTATE',0,'');
		$LocationInfo["Zip"] = GetValidXML('LOCATIONZIP',0,'');
		$LocationInfo["BTN"] = GetValidXML('LOCATIONBTN',0,'');
		$LocationInfo["NPA"] = GetValidXML('LOCATIONNPA',0,'');
		$LocationInfo["NXX"] = GetValidXML('LOCATIONNXX',0,'');
		$LocationInfo["XXXX"] = GetValidXML('LOCATIONXXXX',0,'');
		
		$quoteName = $CustomerInfo["Name"];
		$quoteNameA = explode(" ", $quoteName);
		$quoteFirstName = $quoteNameA[0];
		$quoteLastName = $quoteNameA[1];
		
		$quoteEmail = $CustomerInfo["Email"];
		$quoteCompany = '';
		if ($CustomerInfo["Title"] != ''){
			$quoteCompany = $CustomerInfo["Title"];
		} else if ($CustomerInfo["BusinessName"] != ''){
			$quoteCompany = $CustomerInfo["BusinessName"];
		}
		
		$npa = $LocationInfo["NPA"];
		$nxx = $LocationInfo["NXX"];
		$xxxx = $LocationInfo["XXXX"];
		
		$gq_address_1 = $LocationInfo["Address1"];
		$gq_address2_1 = $LocationInfo["Address2"];
		$gq_city_1 = $LocationInfo["City"];
		$gq_state_1 = $LocationInfo["State"];
		$gq_zip_1 = $LocationInfo["Zip"];
		
		$ReadOnly = GetValidXML('READONLY',0,'');
		
	}
}
?> 