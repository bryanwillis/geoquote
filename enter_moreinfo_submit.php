<?php
include_once "config.php";

phpparam('AgentNumber','');
phpparam('website','');
phpparam('RemoteIPAddress','');
phpparam('QuoteID','');
phpparam('Row','');
phpparam('CustomerID','');
phpparam('key','');
phpparam('ContactName','');
phpparam('CustomerPhoneOffice','');
phpparam('CustomerPhoneCell','');
phpparam('CustomerPhoneHome','');
phpparam('CustomerEmail','');
phpparam('CustomerEmail2','');
phpparam('Q_Money','');
phpparam('Q_Time','');
phpparam('Q_DM','');
phpparam('CustomerNotes','');
phpparam('htmlResult','');

$ReturnURL = $ReturnPath . $ReturnFrontPage;

if (($QuoteID == "") || ($CustomerID == "") || ($key == "")) {
	header("location: " . $ReturnURL);
	exit;
}

$XMLSent = "<TelarusQuote>";
$XMLSent .= "<AgentNo>" . xmlspecialchars($AgentNumber) . "</AgentNo>";
$XMLSent .= "<Website>" . xmlspecialchars($website) . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . xmlspecialchars($RemoteIPAddress) . "</RemoteIPAddress>";
$XMLSent .= "<QuoteID>" . xmlspecialchars($QuoteID) . "</QuoteID>";
$XMLSent .= "<Row>" . xmlspecialchars($Row) . "</Row>";
$XMLSent .= "<CustomerID>" . xmlspecialchars($CustomerID) . "</CustomerID>";
$XMLSent .= "<Key>" . xmlspecialchars($key) . "</Key>";
$XMLSent .= "<ContactName>" . xmlspecialchars($ContactName) . "</ContactName>";
$XMLSent .= "<ContactPhoneOffice>" . xmlspecialchars($CustomerPhoneOffice) . "</ContactPhoneOffice>";
$XMLSent .= "<ContactPhoneCell>" . xmlspecialchars($CustomerPhoneCell) . "</ContactPhoneCell>";
$XMLSent .= "<ContactPhoneHome>" . xmlspecialchars($CustomerPhoneHome) . "</ContactPhoneHome>";
$XMLSent .= "<ContactEmail>" . xmlspecialchars($CustomerEmail) . "</ContactEmail>";
$XMLSent .= "<ContactEmail2>" . xmlspecialchars($CustomerEmail2) . "</ContactEmail2>";
$XMLSent .= "<Q_Money>" . xmlspecialchars($Q_Money) . "</Q_Money>";
$XMLSent .= "<Q_Time>" . xmlspecialchars($Q_Time) . "</Q_Time>";
$XMLSent .= "<Q_DM>" . xmlspecialchars($Q_Time) . "</Q_DM>";
$XMLSent .= "<Q_Qualify>2</Q_Qualify>";
$XMLSent .= "<CustomerNotes>" . xmlspecialchars($CustomerNotes) . "</CustomerNotes>";
$XMLSent .= "</TelarusQuote>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/customer_moreinfo.cfm');

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