<?php
include_once "config.php";

phpparam('AgentNumber','');
phpparam('website','');
phpparam('RemoteIPAddress','');
phpparam('ID','');  
phpparam('key','');  
phpparam('Reason',''); 
phpparam('comments','');
phpparam('PageExtension','php');
phpparam('htmlResult','');

$ReturnURL = $ReturnPath . $ReturnFrontPage;

if($ID == '' || $key == '') {
	header("location: " . $ReturnURL);
	exit;
}

$XMLSent = "<TelarusCustLogin>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . xmlspecialchars($RemoteIPAddress) . "</RemoteIPAddress>";
$XMLSent .= "<CustomerID>" . $ID . "</CustomerID>";
$XMLSent .= "<Key>" . $key . "</Key>";
$XMLSent .= "<UnsubscribeReason>" .  xmlspecialchars($Reason) . "</UnsubscribeReason>";
$XMLSent .= "<UnsubscribeComments>" .  xmlspecialchars($comments) . "</UnsubscribeComments>";
$XMLSent .= "</TelarusCustLogin>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/custlogin.cfm');

$geoxml->fetchXML($XmlUrlA, $XMLSent);
$vals = $geoxml->vals;
$myxml = $geoxml->myxml;

if ($geoxml->XMLError == 1) {
	header("location:" . $ReturnURL);
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