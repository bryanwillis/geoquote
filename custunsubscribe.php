<?php
include_once("config.php");

phpparam('ID','');
phpparam('key','');

if ($ID == '' || $key == '') {
	$ErrorMsg = "Unsubscribe Information Incomplete.  Please recheck your email.";
	include "custlogin.php";
	exit;
}

$XMLSent = "<TelarusCustLogin>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<CustomerID>" . $ID . "</CustomerID>";
$XMLSent .= "<Key>" . $key . "</Key>";
$XMLSent .= "<Version>" . $version . "</Version>";
$XMLSent .= "</TelarusCustLogin>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/gq_plugin/output_cust_unsubscribe.cfm');

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

if ($ErrorMsg != "") {
	include "custlogin.php";
	exit;
}

echo <<<EOF
<link rel="stylesheet" href="http://plugindata.geoquote.net/css_geoquote/styles.css" type="text/css">
<link rel="stylesheet" href="css_geoquote/styles.css" type="text/css">
<div align="center">
$htmlResult
</div>
EOF;

?>