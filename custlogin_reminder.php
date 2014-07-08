<?php

if (file_exists('config.php') == 0) {
	echo "<P>File is missing : config.php - Please download this file from your backoffice";
	exit;
}

include "config.php";

phpparam('Email','');

if (($Email == "") || (strpos($Email,"@") == 0)) {
	$EmailErrorMsg = "Invalid Email Address";
	include "custlogin.php";
	exit;
}

$XMLSent = "<TelarusCustLogin>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<Email>" . xmlspecialchars($Email) . "</Email>";
$XMLSent .= "</TelarusCustLogin>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array('http://xml.telarus.com/custlogin_reminder.cfm');	

$geoxml->fetchXML($XmlUrlA, $XMLSent);
$vals = $geoxml->vals;
$myxml = $geoxml->myxml;

if ($geoxml->XMLError == 1) {
	include("calculate_error.php");
	exit;
}

$LoginResult = GetValidXML('RESULT',0,'');
$EmailErrorMsg = GetValidXML('ERRORMESSAGE',0,'');

include "custlogin.php";
?>