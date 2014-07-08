<?php
include "config.php";

phpparam('orderpass','');
phpparam('Password','');
phpparam('btn','');

if (($Password == "") && ($orderpass != "")) {
	$Password = $orderpass;
}

$btn = ereg_replace('[^0-9]','',$btn);
if (strlen($btn) != 10) {
	$ErrorMsg = "Invalid Phone Number";
	include "custlogin.php";
	exit;
}

if ($Password == "") {
	$ErrorMsg = "Password was blank";
	include "custlogin.php";
	exit;
}

$XMLSent = "<TelarusCustLogin>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<BTN>" . $btn . "</BTN>";
$XMLSent .= "<Key>" . $Password . "</Key>";
$XMLSent .= "</TelarusCustLogin>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/gq_plugin/output_order_lookup.cfm');

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