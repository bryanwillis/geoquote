<?php
include "config.php";

phpparam('QuoteID','');
phpparam('CustomerID','');
phpparam('key','');

$XMLSent = "<TelarusQuote>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<QuoteStep>" . $QuoteType . "</QuoteStep>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<QuoteID>" . $QuoteID . "</QuoteID>";
$XMLSent .= "<CustomerID>" . $CustomerID . "</CustomerID>";
$XMLSent .= "<Key>" . $key . "</Key>";
$XMLSent .= "</TelarusQuote>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/gq_plugin/output_callme.cfm');	
	
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

echo <<<EOF
<link rel="stylesheet" href="http://plugindata.geoquote.net/css_geoquote/styles.css" type="text/css">
<link rel="stylesheet" href="css_geoquote/styles.css" type="text/css">
<div align="center">
EOF;

echo ($ErrorMsg == "" ? $htmlResult : $ErrorMsg);
echo "</div>";
?>