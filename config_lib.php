<?php
if (!isset($DisplayedHeader)) {
	$DisplayedHeader = false;
}

$xmlsearch = array("&",'>','<',"'",'"');
$xmlreplace = array("&amp;","&gt;","&lt;","&apos;","&quot;");

if (!$DisplayedHeader && strtolower(getenv("SCRIPT_NAME")) != '/quote.php') {
// Setup the tracking cookies... QuotePage is setup in the calculate.php file
	if (!isset($_COOKIE['RefererPage'])) {
		$RefererPage = getenv("HTTP_REFERER");
		setcookie("RefererPage", $RefererPage);
	} else {
		$RefererPage = $_COOKIE['RefererPage'];
		if ($RefererPage == '') {
			$RefererPage = getenv("HTTP_REFERER");
			setcookie("RefererPage", $RefererPage);
		}
	}
	$EntryPage = getenv('HTTP_HOST') . getenv('SCRIPT_NAME');
	if (getenv('QUERY_STRING') != '') {
		$EntryPage .= getenv('QUERY_STRING');
	} 
	if (!isset($_COOKIE['EntryPage'])) {
		setcookie("EntryPage", $EntryPage);
	} else if ($_COOKIE['EntryPage'] == '') {
		setcookie("EntryPage", $EntryPage);
	} else {
		$EntryPage = $_COOKIE['EntryPage'];
	}
}

if (function_exists('str_Ireplace') == false) {
	function str_Ireplace($needle, $replacement, $haystack) {
	   $i = 0;
	   while (($pos = strpos(strtolower($haystack),
	     strtolower($needle), $i)) !== false) {
	       $haystack = substr($haystack, 0, $pos) . $replacement . substr($haystack, $pos + strlen($needle));
	       $i = $pos + strlen($replacement);
	   }
	   return $haystack;
	}
}

if (function_exists('get_keyi') == false) {
	function get_keyi($array, $key){
		// looks case insensitive for the key in array, and returns the matching key
		if (!is_array($array)) {
			return false;
		}
	   reset($array);
	   while (current($array)!==FALSE){
	       if (strtolower(key($array)) == strtolower($key)) {
			 	 return key($array);
	       }
	       next($array);
	   }
		return false;
	} 
}

if (function_exists('phpparam') == false) {
   function phpparam($var, $default) {
      global $$var;
		$keymatch = "";
      if (!isset(${$var})) {
			$keymatch = get_keyi($_POST,$var);
			if ($keymatch !== false) {
				$$var = $_POST[$keymatch];
			}
			if ($keymatch === false && isset($_HTTP_POST_VARS)) {
				$keymatch = get_keyi($_HTTP_POST_VARS,$var);
				if ($keymatch != false) {
					$$var = $_HTTP_POST_VARS[$keymatch];
				}
			}
			if ($keymatch === false) {
				$keymatch = get_keyi($_GET,$var);
				if ($keymatch != false) {
					$$var = $_GET[$keymatch];
				}
			}
			if ($keymatch === false && isset($_HTTP_GET_VARS)) {
				$keymatch = get_keyi($_HTTP_GET_VARS,$var);
				if ($keymatch != false) {
					$$var = $_HTTP_GET_VARS[$keymatch];
				}
			}
			if ($keymatch === false) {
				$keymatch = get_keyi($_COOKIE,$var);
				if ($keymatch != false) {
					$$var = $_COOKIE[$keymatch];
				}
			}

			if ($keymatch === false) { // couldn't find the parameter in the Get or Post methods
            $$var = $default;
         }
      }
   }
}

if (function_exists('GetValidXML') == false) {
	function GetValidXML($Param, $IndexVal, $default) {
		global $vals;
		global $myxml;		
		if (!array_key_exists($Param, $myxml)) {
			return $default;
		} else if (!array_key_exists($IndexVal, $myxml[$Param])) {
			return $default;
		} else if (!array_key_exists('value', $vals[$myxml[$Param][$IndexVal]])) {
			return $default;
		} else {
			return $vals[$myxml[$Param][$IndexVal]]['value'];
		}
	}
}

function xmlspecialchars($text) {
   return str_replace('&#039;', '&apos;', htmlspecialchars($text, ENT_QUOTES));
}

function xmldecode($txt) {
    $txt = str_replace('&amp;',		'&',	$txt);
    $txt = str_replace('&lt;',		'<',	$txt);
    $txt = str_replace('&gt;',		'>',	$txt);
    $txt = str_replace('&apos;',		"'",	$txt);
    $txt = str_replace('&quot;', 	'"',	$txt);
    return $txt;
}

Function DisplayPhoneNumber($ph) {
   $ph = ereg_replace ('[^0-9]+', '', $ph); // ##### Strip all Non-Numeric Characters
   $phlen = strlen($ph);
	if ($phlen == 7) {
		return substr($ph,0,3) . "-" . substr($ph,3,4);
	} elseif ($phlen == 10) {
		return "(" . substr($ph,0,3) . ") " . substr($ph,3,3) . "-" . substr($ph,6,4);
	} elseif (11 <= $phlen) {
		return "(" . substr($ph,0,3) . ") " . substr($ph,3,3) . "-" . substr($ph,6,4) . " x" . substr($ph,10);
	} else {
		return $ph;
	}
}
?>