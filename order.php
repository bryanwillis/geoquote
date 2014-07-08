<?php
include "config.php";

phpparam('QuoteLineID','');
phpparam('key','');

if (($QuoteLineID == "") || ($key == "")) {
	exit('invalid parameters');
}

$XMLSent = "<TelarusOrder>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<QuoteLineID>" . $QuoteLineID . "</QuoteLineID>";
$XMLSent .= "<Key>" . $key . "</Key>";
$XMLSent .= "<ReturnPath>" . xmlspecialchars($ReturnPath) . "</ReturnPath>";
$XMLSent .= "<ReturnFrontPage>" . xmlspecialchars($ReturnFrontPage) . "</ReturnFrontPage>";
$XMLSent .= "<Version>" . $version . "</Version>";
$XMLSent .= "</TelarusOrder>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;
$XmlUrlA = array('http://xml.telarus.com/gq_plugin/output_order.cfm');

$geoxml->fetchXML($XmlUrlA, $XMLSent);
$vals = $geoxml->vals;
$myxml = $geoxml->myxml;

if ($geoxml->XMLError == 1) {
	include("calculate_error.php");
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
 