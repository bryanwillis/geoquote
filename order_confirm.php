<?php
include_once "config.php";

phpparam('AgentNumber','');
phpparam('website','');
phpparam('RemoteIPAddress','');
phpparam("QuoteLineID","");
phpparam("key","");
phpparam("CustomerNotes","undefined");
phpparam("LocationBTN","undefined");
phpparam("LocationAddress1","");
phpparam("LocationAddress2","");
phpparam("LocationCity","");
phpparam("LocationState","");
phpparam("LocationZip","");
phpparam("ContactName","");
phpparam("ContactTitle","");
phpparam("ContactEmail","");
phpparam("ContactEmail2","");
phpparam("ContactAddress1","");
phpparam("ContactAddress2","");
phpparam("ContactCity","");
phpparam("ContactState","");
phpparam("ContactZip","");
phpparam("ContactPhoneOffice","");
phpparam("ContactPhoneCell","");
phpparam("ContactPhoneHome","");
phpparam("ContactPhoneFax","");
phpparam("CustomerID","");
phpparam("QuoteID","");
phpparam("LineNumber","");
phpparam("Service","");
phpparam("Install","");
phpparam("Rebate","");
phpparam("Term","");
phpparam("Router","");
phpparam("Total","");
phpparam("htmlResult","");

$ReturnURL = $ReturnPath . $ReturnFrontPage;

if (($QuoteLineID == "") || ($key == "")) {
	header("location: " . $ReturnURL);
	exit;
}

if ($CustomerNotes == "undefined" && $LocationBTN == "undefined") {
	header("location: " . $ReturnURL);
	exit;
}

// Send all the information to the XML server to parse
$XMLSent = "<TelarusOrder>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . xmlspecialchars($RemoteIPAddress) . "</RemoteIPAddress>";
$XMLSent .= "<QuoteLineID>" . $QuoteLineID . "</QuoteLineID>";
$XMLSent .= "<Key>" . $key . "</Key>";
$XMLSent .= "<CustomerNotes>" . xmlspecialchars($CustomerNotes) . "</CustomerNotes>";
$XMLSent .= "<ReturnPath>" . xmlspecialchars($ReturnPath) . "</ReturnPath>";
$XMLSent .= "<ReturnFrontPage>" . xmlspecialchars($ReturnFrontPage) . "</ReturnFrontPage>";
$XMLSent .= "<LocationInfo>";
	$XMLSent .= "<LocationBTN>" . xmlspecialchars($LocationBTN) . "</LocationBTN>";
	$XMLSent .= "<LocationAddress1>" . xmlspecialchars($LocationAddress1) . "</LocationAddress1>";
	$XMLSent .= "<LocationAddress2>" . xmlspecialchars($LocationAddress2) . "</LocationAddress2>";
	$XMLSent .= "<LocationCity>" . xmlspecialchars($LocationCity) . "</LocationCity>";
	$XMLSent .= "<LocationState>" . xmlspecialchars($LocationState) . "</LocationState>";
	$XMLSent .= "<LocationZip>" . xmlspecialchars($LocationZip) . "</LocationZip>";
$XMLSent .= "</LocationInfo>";
$XMLSent .= "<ContactInfo>";
	$XMLSent .= "<ContactName>" . xmlspecialchars($ContactName) . "</ContactName>";
	$XMLSent .= "<ContactTitle>" . xmlspecialchars($ContactTitle) . "</ContactTitle>";
	$XMLSent .= "<ContactEmail>" . xmlspecialchars($ContactEmail) . "</ContactEmail>";
	$XMLSent .= "<ContactEmail2>" . xmlspecialchars($ContactEmail2) . "</ContactEmail2>";
	$XMLSent .= "<ContactAddress1>" . xmlspecialchars($ContactAddress1) . "</ContactAddress1>";
	$XMLSent .= "<ContactAddress2>" . xmlspecialchars($ContactAddress2) . "</ContactAddress2>";
	$XMLSent .= "<ContactCity>" . xmlspecialchars($ContactCity) . "</ContactCity>";
	$XMLSent .= "<ContactState>" . xmlspecialchars($ContactState) . "</ContactState>";
	$XMLSent .= "<ContactZip>" . xmlspecialchars($ContactZip) . "</ContactZip>";
	$XMLSent .= "<ContactPhoneOffice>" . xmlspecialchars($ContactPhoneOffice) . "</ContactPhoneOffice>";
	$XMLSent .= "<ContactPhoneCell>" . xmlspecialchars($ContactPhoneCell) . "</ContactPhoneCell>";
	$XMLSent .= "<ContactPhoneHome>" . xmlspecialchars($ContactPhoneHome) . "</ContactPhoneHome>";
	$XMLSent .= "<ContactPhoneFax>" . xmlspecialchars($ContactPhoneFax) . "</ContactPhoneFax>";
$XMLSent .= "</ContactInfo>";
$XMLSent .= "</TelarusOrder>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/customer_order_confirm.cfm');

$geoxml->fetchXML($XmlUrlA, $XMLSent);
$vals = $geoxml->vals;
$myxml = $geoxml->myxml;

if ($geoxml->XMLError == 1) {
	header("location:" . $returnErrorPage);
	exit;
}

$TheResult = GetValidXML('RESULT',0,'');
$ErrorMsg = GetValidXML('ERRORMESSAGE',0,'');
$htmlResult = xmldecode(GetValidXML('HTMLFORMATTEDRESULTS',0,''));

include "header.php";
echo <<<EOF
<link rel="stylesheet" href="http://plugindata.geoquote.net/css_geoquote/styles.css" type="text/css">
<link rel="stylesheet" href="css_geoquote/styles.css" type="text/css">
<div align="center">
EOF;

echo ($ErrorMsg == "" ? $htmlResult : $ErrorMsg);
echo "</div>";

include "footer.php";
?>