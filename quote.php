<?php
ob_start();
include_once "config.php";

phpparam('QuoteID','');
phpparam('CustomerID','');
phpparam('key','');
phpparam('QuoteType','');
phpparam('TheResults','');

$ReturnURL = $ReturnPath . $ReturnFrontPage;

if (($QuoteID == "") || ($CustomerID == "") || ($key == "")) {
	header("location: " . $ReturnURL);
	ob_end_flush();
	exit;
}

$XMLSent = "<TelarusQuote>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<QuoteStep>" . $QuoteType . "</QuoteStep>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<QuoteID>" . $QuoteID . "</QuoteID>";
$XMLSent .= "<CustomerID>" . $CustomerID . "</CustomerID>";
$XMLSent .= "<Key>" . $key . "</Key>";
$XMLSent .= "<ReturnPath>" . xmlspecialchars($ReturnPath) . "</ReturnPath>";
$XMLSent .= "<ReturnFrontPage>" . xmlspecialchars($ReturnFrontPage) . "</ReturnFrontPage>";
$XMLSent .= "</TelarusQuote>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/gq_plugin/output_html.cfm');
	
$geoxml->fetchXML($XmlUrlA, $XMLSent);
$vals = $geoxml->vals;
$myxml = $geoxml->myxml;

if ($geoxml->XMLError == 1) {
	include "calculate_error.php";
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