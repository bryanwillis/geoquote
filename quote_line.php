<?php
if (!file_exists('config.php')) {
	exit;
}
include "config.php";	

phpparam('QuoteID','');
phpparam('CustomerID','');
phpparam('Key','');
phpparam('Row','');

if (($QuoteID == "") || ($CustomerID == "") || ($Key == "")) {
	exit('invalid parameters');
}

$XMLSent = "<TelarusQuote>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<QuoteStep>" . 3 . "</QuoteStep>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<QuoteID>" . $QuoteID . "</QuoteID>";
$XMLSent .= "<Row>" . $Row . "</Row>";
$XMLSent .= "<CustomerID>" . $CustomerID . "</CustomerID>";
$XMLSent .= "<Key>" . $Key . "</Key>";
$XMLSent .= "</TelarusQuote>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/gq_plugin/output_quote_line.cfm');
	
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
