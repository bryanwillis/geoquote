<?php
if (file_exists('config.php') == 0) {
	echo "<P>File is missing : config.php - Please download this file from your backoffice";
	exit;
}

include_once "config.php";

phpparam('ErrorMsg','');
phpparam('ErrorMsg2','');
phpparam('RefID','');
phpparam('SelectService','');
phpparam('CompanyLine','');
phpparam('PhoneLine','');
phpparam('EmailLine','');
phpparam('RefererPage','');
phpparam('IncompleteID','');
phpparam('npa','');
phpparam('nxx','');
phpparam('xxxx','');
phpparam('quoteCompany','');
phpparam('quoteFirstName','First Name');
phpparam('quoteLastName','Last Name');
phpparam('QuoteName','');
phpparam('quoteEmail','');
phpparam('BTN','');
phpparam('service_type','');
phpparam('service_id','');
phpparam('CustomerID','');
phpparam('LocationID','');
phpparam('ContactID','');
phpparam('ReadOnly','No');
phpparam('disableFormField','');

if ($ErrorMsg2 != ''){
	$ErrorMsg = $ErrorMsg2;
}

if ($CustomerID != '' && $LocationID != '' && $ContactID != ''){
	include "geoquote_get_customer_info.php";
	
	if($ReadOnly == "Yes"){
		$disableFormField = " disabled";
	}
} else {

	if ($QuoteName != ''){
		$QuoteNameA = explode(" ", $QuoteName);
		$quoteFirstName = $QuoteNameA[0];
		$quoteLastName = $QuoteNameA[1];
	}
	
	if (strlen($BTN) == 10) {
		$npa = substr($BTN,0,3);
		$nxx = substr($BTN,3,3);
		$xxxx = substr($BTN,6,4);
	}
	
	if ($service_type == "") {
		$service_type = $DefaultServiceType;
	}
	
	if ($ErrorMsg == "Not a valid Company Name") {
		$CompanyLine = "<tr><td colspan=\"2\" id=\"geoquoteStep1Error\">" . $ErrorMsg . "</td></tr>";
	 	$ErrorMsg = "";
	}
	
	if ($ErrorMsg == "Not a valid Email Address") {
		$EmailLine = "<tr><td colspan=\"2\" id=\"geoquoteStep1Error\">" . $ErrorMsg . "</td></tr>";
		$ErrorMsg = "";
	}
	
	if ($ErrorMsg == "Invalid Phone Number") {
		$PhoneLine = "<tr><td colspan=\"2\" id=\"geoquoteStep1Error\">" . $ErrorMsg . "</td></tr>";
	 	$ErrorMsg = "";
	}
	
	if ($ErrorMsg == "That phone number was not found in our database") {
		$PhoneLine = "<tr><td colspan=\"2\" id=\"geoquoteStep1Error\">" . $ErrorMsg . "</td></tr>";
	 	$ErrorMsg = "";
	}
	
	if ($ErrorMsg == "Toll Free Phone Number not accepted") {
		$PhoneLine = "<tr><td colspan=\"2\" id=\"geoquoteStep1Error\">" . $ErrorMsg . "</td></tr>";
	 	$ErrorMsg = "";
	}
}

echo <<< EOF
<script language="javascript" type="text/javascript">

function checkInput(f){	
	var hasError = false;
	var error = 'The following problems were encountered:\\n\\n';
	
	if(trim(f.quoteFirstName.value) == '' || trim(f.quoteFirstName.value) == 'First Name') {
		hasError = true;
		error += 'Please provide your First Name.\\n';
	}
		
	if(trim(f.quoteLastName.value) == '' || trim(f.quoteLastName.value) == 'Last Name') {
		hasError = true;
		error += 'Please provide your Last Name.\\n';
	}
	
	if(trim(f.quoteCompany.value) == '') {
		hasError = true;
		error += 'Please provide your Business Name.\\n';
	}	
	
	if(trim(f.quoteEmail.value) == '') {
		hasError = true;
		error += 'Please provide your Email.\\n';
	}		
		
	if((f.npa.value + f.nxx.value + f.xxxx.value).replace(/[^0-9]/g, '').length != 10) {
		hasError = true;
		error += 'The Installation Phone Number does not appear to be valid.\\n';
	}

	if(hasError) alert(error);
	return !hasError;
	
}
	
function trim(s) {
	return s.replace(/^\s*|\s*$/g, '');
}

</script>
EOF;

echo <<< EOF
<link rel="stylesheet" href="http://plugindata.geoquote.net/css_geoquote/styles.css" type="text/css">
<link rel="stylesheet" href="css_geoquote/styles.css" type="text/css">
<div align="center">
<form method="POST" action="geoquote_step2.php" name="Calculate" onSubmit="return checkInput(this)">
<input type="hidden" name="RefID" value="$RefID">
<input type="hidden" name="RefererPage" value="$RefererPage">
<input type="hidden" name="version" value="$version">

EOF;

if ($CustomerID != ''){
	echo '<input type="hidden" name="CustomerID" value="' . $CustomerID . '">' . "\n";
}
if ($LocationID != ''){
	echo '<input type="hidden" name="LocationID" value="' . $LocationID . '">' . "\n";
}
if ($ContactID != ''){
	echo '<input type="hidden" name="ContactID" value="' . $ContactID . '">' . "\n";
}

if ($service_id != ''){
	echo '<input type="hidden" name="service_type" value="' . $service_type . '">' . "\n";
	echo '<input type="hidden" name="service_id" value="' . $service_id . '">' . "\n";
}	
	
	
if ($IncompleteID != '') {
	echo '<input type="hidden" name="IncompleteID" value="' . $IncompleteID . '">' . "\n";
}

echo "<div class=\"geoquote_step1_block\">";
echo "<h3>ENTER YOUR INFORMATION:</h3>";
echo "<table class=\"geoquote_step1\">\n";

if ($ErrorMsg != "") {
    echo "<tr><td colspan=\"2\" id=\"geoquoteStep1Error\">" . $ErrorMsg . "</td></tr>";
}

if($service_id == ''){
	echo <<<EOF
	<tr>
		<td class="brcleft"><span class="large">Service Type</span> <span class="red">*</span></td>
		<td>
			<select name="service_type">
EOF;
			echo "<option value=\"D\"" . ($service_type == "D"?" selected":"").">High Speed Internet Access</option>";
			echo "<option value=\"V\"" . ($service_type == "V"?" selected":"").">Voice (SIP/LD/Local/VoIP/POTS)</option>";
			echo "<option value=\"I\"" . ($service_type == "I"?" selected":"").">Integrated Access (Voice/Data/Flex/PRI)</option>";
			echo "<option value=\"M\"" . ($service_type == "M"?" selected":"").">Multi-Site Networks (MPLS/VPN/WAN/P2P)</option>";
			echo "<option value=\"N\"" . ($service_type == "N"?" selected":"").">Network Services (Firewall/Collocation)</option>";
			echo <<<EOF
			</select>
		</td>
	</tr>
EOF;
}

	echo <<<EOF
	<tr>
		<td class="brcleft">Contact Name: <span class="red">*</span></td>
		<td>
			<input type="text" name="quoteFirstName" value="$quoteFirstName" size="17" maxlength="50" onfocus="if (this.value == 'First Name') { this.value=''; }" onblur="if (this.value == '') { this.value='First Name';}" $disableFormField>
			<input type="text" name="quoteLastName" value="$quoteLastName" size="17" maxlength="50" onfocus="if (this.value == 'Last Name') { this.value=''; }" onblur="if (this.value == '') { this.value='Last Name';}" $disableFormField>	
		</td>
	</tr>	

	<tr>
		<td class="brcleft">Business Name: <span class="red">*</span></td>
		<td><input type="text" name="quoteCompany" value="$quoteCompany" size="41" maxlength="60" $disableFormField></td>
	</tr>
	$CompanyLine
	
	<tr>
		<td class="brcleft">Contact&#146;s Email Address: <span class="red">*</span></td>
		<td><input type="text" name="quoteEmail" value="$quoteEmail" size="41" $disableFormField></td>
	</tr>
	$EmailLine
	
	<tr>
		<td class="brcleft">Installation Phone Number <span class="small">(area code first)</span>: <span class="red">*</span></td>
		<td>
			(<input type="text" name="npa" value="$npa" size="3" maxlength="3" onkeyup="javascript:if(Calculate.npa.value.length == 3) { Calculate.nxx.focus(); };" $disableFormField>)
			<input type="text" name="nxx" value="$nxx" size="3" maxlength="3" onkeyup="javascript:if(Calculate.nxx.value.length == 3) { Calculate.xxxx.focus(); };" $disableFormField> -
			<input type="text" name="xxxx" value="$xxxx" size="4" maxlength="4" value="" $disableFormField>
		</td>
	</tr>
	$PhoneLine
	
</table>
</div>


<table class="geoquote_step1_button">
	<tr><td style="width: 45%;"></td><td><input type=submit value="Continue >" class="btn_brc"></td></tr>
</table>

</form>
</div>
EOF;
?>