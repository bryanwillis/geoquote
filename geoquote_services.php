<?php
include "config.php";
phpparam('website','');
phpparam('categoryID',2);
phpparam('serviceID',13);
phpparam('serviceQuestionsHTML','');

$XMLSent = "<TelarusService>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<CategoryID>" . xmlspecialchars($categoryID) . "</CategoryID>";
$XMLSent .= "<ServiceID>" . xmlspecialchars($serviceID) . "</ServiceID>";
$XMLSent .= "<WebsiteType>GeoQuotePublic</WebsiteType>";
$XMLSent .= "</TelarusService>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.geoquote.net/geoquote_services.cfm');	
	
$geoxml->fetchXML($XmlUrlA, $XMLSent);

if ($geoxml->XMLError == 0) {
	$myxml = $geoxml->myxml;
	$vals = $geoxml->vals;
	$serviceQuestionsHTML = GetValidXML('QUESTIONSHTML',0,'');
}

echo $serviceQuestionsHTML;
?>