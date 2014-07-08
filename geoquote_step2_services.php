<?php
$StateList = array("AL","AR","AZ","CA","CO","CT","DC","DE","FL","GA","HI","IA","ID","IL","IN","KS","KY","LA","MA","MD","ME","MI","MN","MS","MO","MT","NC","ND","NE","NH","NJ","NM","NV","NY","OH","OK","OR","PA","PR","RI","SC","SD","TN","TX","UT","VA","VT","WA","WI","WV","WY");

phpparam('RefID','');
phpparam('IncompleteID','');
phpparam('service_type','');
phpparam('npa','');
phpparam('nxx','');
phpparam('xxxx','');
phpparam('quoteCompany','');
phpparam('quoteFirstName','');
phpparam('quoteLastName','');
phpparam('quoteName','');
phpparam('quoteEmail','');
phpparam('quote_address1','');
phpparam('quote_address2','');
phpparam('quote_city','');
phpparam('comments','Enter your comments here');
phpparam('QuotePage','');
phpparam('gq_isPRI',0);
phpparam('TheDefaultServiceID',4);
phpparam('TheCategoryID',1);
phpparam('ReadOnly',"No");


$gq_maxInstallLocations = 2;
$gq_locationCount = 1;
$gq_installPhoneStyle = " style=\"display: none;\"";
$BTN = $npa . $nxx . $xxxx;
$defaultGeoQuoteTitleCase = "1"; //1: capical first, 2: Upper case, 3: lower case


if ($QuotePage == '') {
	$QuotePage = getenv('HTTP_REFERER');
}

$XMLSent = "<TelarusQuote>";
$XMLSent .= "<AgentNo>" . $AgentNumber . "</AgentNo>";
$XMLSent .= "<Website>" . $website . "</Website>";
$XMLSent .= "<RemoteIPAddress>" . getenv("REMOTE_ADDR") . "</RemoteIPAddress>";
$XMLSent .= "<Source>" . $customer_source . "</Source>";
$XMLSent .= "<ServiceType>" . xmlspecialchars($service_type) . "</ServiceType>";
$XMLSent .= "<Layout>public</Layout>";
$XMLSent .= "</TelarusQuote>";

include_once('GeoXML.class.php');
$geoxml = new GeoXML;

$XmlUrlA = array(
	'http://xml.geoquote.net/services.cfm');		
	
$geoxml->fetchXML($XmlUrlA, $XMLSent);

if ($geoxml->XMLError == 0) {

	$myxml = $geoxml->myxml;
	$vals = $geoxml->vals;

	$TheCategoryID = GetValidXML('THISCATEGORYID',0,'');
	$TheDefaultServiceID = GetValidXML('THEDEFAULTSERVICEID',0,'');
	
	$Services = array();
	$ServiceID = array();
	$ServiceCategory = array();
	$Description = array();
	$CategoryID = array();
	$InstallPhoneRequired = array();
	$PRI = array();
	$QuestionCounter = array();
	$ServiceMax = 0;
	
	for ($Counter = 0; $Counter < count($myxml['SERVICEID']); $Counter++) {
		$ServiceID[$ServiceMax] = GetValidXML('SERVICEID',$Counter,'');
		$Description[$ServiceMax] = GetValidXML('DESCRIPTION',$Counter,'');
		$CategoryID[$ServiceMax] = GetValidXML('CATEGORYID',$Counter,'');
		$InstallPhoneRequired[$ServiceMax] = GetValidXML('INSTALLPHONEREQUIRED',$Counter,'');
		$PRI[$ServiceMax] = GetValidXML('PRI',$Counter,'');
		$QuestionCounter[$ServiceMax] = GetValidXML('QUESTIONCOUNTER',$Counter,'');
		$ServiceMax = $ServiceMax + 1;
	}
}

if ($TheCategoryID == 1 && isset($DefaultServiceIDData)){
	$TheDefaultServiceID = $DefaultServiceIDData;
} else if ($TheCategoryID == 2 && isset($DefaultServiceIDIntegrated)){
	$TheDefaultServiceID = $DefaultServiceIDIntegrated;
} else if ($TheCategoryID == 3 && isset($DefaultServiceIDVoice)){
	$TheDefaultServiceID = $DefaultServiceIDVoice;
} else if ($TheCategoryID == 4 && isset($DefaultServiceIDNetwork)){
	$TheDefaultServiceID = $DefaultServiceIDNetwork;
} else if ($TheCategoryID == 5 && isset($DefaultServiceIDNetworkService)){
	$TheDefaultServiceID = $DefaultServiceIDNetworkService;
}

if ($service_id != ''){
	$TheDefaultServiceID = $service_id;
}

echo <<<EOF
<div align="center">
<script type="text/javascript" src="http://plugindata.geoquote.net/js/geoquote.js"></script>
<script type="text/javascript" src="http://plugindata.geoquote.net/js/geoquote_handleService.js"></script>
<link rel="stylesheet" href="http://plugindata.geoquote.net/css_geoquote/styles.css" type="text/css">
<link rel="stylesheet" href="css_geoquote/styles.css" type="text/css">
<form action="geoquote_step3.php" name="ContactForm" method="POST" enctype="multipart/form-data" onSubmit="return validate(this);">
<input type="hidden" name="gq_locationCount" value="$gq_locationCount">
<input type="hidden" name="gq_categoryID" value="$TheCategoryID">	
<input type="hidden" name="gq_readOnly" value="$ReadOnly">
<input type="hidden" name="quoteName" value="$quoteName">
<input type="hidden" name="quoteCompany" value="$quoteCompany">
<input type="hidden" name="quoteEmail" value="$quoteEmail">
<input type="hidden" name="serviceType" value="$serviceType">
<input type="hidden" name="quoteFirstName" value="$quoteFirstName">
<input type="hidden" name="service_type" value="$service_type">
<input type="hidden" name="npa" value="$npa">
<input type="hidden" name="nxx" value="$nxx">
<input type="hidden" name="xxxx" value="$xxxx">
<input type="hidden" name="RefID" value="$RefID">
<input type="hidden" name="QuotePage" value="$QuotePage">
<input type="hidden" name="IncompleteID" value="$IncompleteID">
<input type="hidden" name="CustomerID" value="$CustomerID">
<input type="hidden" name="LocationID" value="$LocationID">
<input type="hidden" name="ContactID" value="$ContactID">
EOF;

if (($TheCustomerID != "") && ($TheCustomerID != 0)) {
	echo '<input type="hidden" name="CustomerID" value="' . $TheCustomerID . '">';
}

echo <<< EOF
<table width="784" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td>
		
			<table class="geoquote_step2">
				<tr>
					<td width="44%" height="100%" valign="top">
					
						<table width="100%" height="100%" style="margin:0;padding:0 4px 0 0;border:1px solid #c6c6c6;">
							<tr>
								<td valign="top">
								
									<table width="100%" cellpadding="0" cellspacing="0">
										<tr>
											<td valign="top">
												<table class="geoquote_step2_title">
													<tr><td height="20">Step 2 - Select Service Type</td></tr>
												</table>
											</td>
										</tr>
									</table>
									<table width="85%" cellpadding="0" cellspacing="0" style="margin-left:10px">
EOF;
										
										for($i = 0; $i < count($ServiceID); $i++){
											if($ServiceID[$i] == $TheDefaultServiceID){
												$gq_isPRI = $PRI[$i]>
												$ThisBGColor = "FFCC00";
												$ThisChecked = " checked";													
											} else {
												$ThisBGColor = "F5F5F5";
												$ThisChecked = "";														
											}
											
											if($InstallPhoneRequired[$i] == 1){
												$gq_installPhoneStyle = '';
											}
											
											echo <<<EOF
											<script language="JavaScript">
												gq_products.push($ServiceID[$i]);
											</script>

											<tr>
												<td nowrap
													id="ServiceID$i" 
													onmouseover="this.style.backgroundColor = '#FFEE80'" 
													onclick="handleService(document.forms.ContactForm,$CategoryID[$i],$ServiceID[$i],$QuestionCounter[$i],$InstallPhoneRequired[$i],$PRI[$i]);document.ContactForm.ServiceID[$i].checked=true;this.style.backgroundColor='#FFCC00';" 
													style="cursor:pointer;background-color:$ThisBGColor;padding:0 0 0 10px;" 
													onmouseout="if (document.ContactForm.ServiceID[$i].checked == true) { this.style.backgroundColor = '#FFCC00' } else { this.style.backgroundColor = '#f5f5f5' };"
												>
													<input type="radio" name="ServiceID" value="$ServiceID[$i]" id="ServiceID_$ServiceID[$i]" $ThisChecked> $Description[$i]
												</td>
											</tr>
EOF;
										}
										
										echo <<<EOF
									</table><br>
								</td>
							</tr>
														
						</table>

					</td>
					
					<td width="20"><img src="http://plugindata.geoquote.net/images/spacer.gif" border="0" width="20" height="50"></td>

					<td width="" height="100%" valign="top">
					
						<table width="100%" style="margin:0;padding:0 0 0 0;border:1px solid #c6c6c6;">
							<tr>
								<td>

									<table width="100%">
										<tr>
											<td>
												<table class="geoquote_step2_title">
													<tr><td height="20">Step 3 - <span id="mpls_host">Enter Installation Information</span></td></tr>
												</table>
											</td>
										</tr>
									</table>
EOF;


								 if ($customer_source == "return") {
									echo <<< EOF
									<table class="geoInstallation" style="width:90%;">
									 	<tr>
											<td>
												The following customer information was found in the database.<br>
												If this is not you, click&nbsp;
EOF;
											echo "<a href=\"geoquote_step2.php?npa=" . $npa . "&nxx=" . $nxx . "&xxxx=" . $xxxx . "&service_type=" . $service_type . "&quoteEmail=" . urlencode($quoteEmail) . "&quoteName=" . urlencode($quoteName) . "&customer_source=none&quoteCompany=" . urlencode($quoteCompany). $Tracking_A . "\">HERE</a>.<br>&nbsp;</td></tr></table>";
								 } elseif ($customer_source == "reverse") {
									echo <<< EOF
									<table class="geoInstallation" style="width:90%;">
										<tr>
											<td>
												The following address information was found for the phone number entered.<br>
												If this is not you, click&nbsp;
EOF;
											echo "<a href=\"geoquote_step2.php?npa=" . $npa . "&nxx=" . $nxx . "&xxxx=" . $xxxx . "&service_type=" . $service_type . "&quoteEmail=" . urlencode($quoteEmail) . "&quoteName=" . urlencode($quoteName) . "&customer_source=none&quoteCompany=" . urlencode($quoteCompany) . $Tracking_A . "\">HERE</a>.<br>&nbsp;</td></tr></table>";
								 } 
								 
								 if ($ErrorMsg != "" || $ErrorMsg2 != "") {
								 		
									$ErrorMsg .= " " . $ErrorMsg2;
									echo <<< EOF
									<table class="geoInstallation" style="width:90%;">
										<tr>
											<td style="margin:0;padding:3px 0;border:0;color:#FF3333;font-weight:bold;">$ErrorMsg</td>
										</tr>
									</table><br>
EOF;
								} 

									for($i=1; $i <= $gq_maxInstallLocations; $i++){
			
										$displayLocationStyle = ($i > $gq_locationCount ? " style=\"display: none;\"" : "");
										
										echo <<<EOF
										<div id="gq_install_$i" $displayLocationStyle>
EOF;
											if($i > 1){
												echo <<<EOF
												<table class="geoInstallation" style="width:90%;margin:8px 8px 8px 20px;padding:3px 0;border:0;background-color:#fff5c6;">
													<tr>
														<td><b>Installation Address $i</b></td>
													</tr>
												</table>
EOF;
											}													
											echo <<<EOF
											<table class="geoInstallation">
											
												<div id="gq_installPhone_$i"$gq_installPhoneStyle>
													<tr>
														<td width="118" nowrap>Installation BTN:</td>
														<td>
EOF;
														echo "(<input class=\"textInput\" type=\"text\" name=\"gq_installNPA_$i\" value=\"" . ($i == 1 && $npa != '' ? $npa : "") . "\" size=\"3\" maxlength=\"3\" onKeyUp=\"if(this.value.length == 3) this.form.gq_installNXX_$i.focus();\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . ">) ";
														echo "<input class=\"textInput\" type=\"text\" name=\"gq_installNXX_$i\" value=\"" . ($i == 1 && $nxx != '' ? $nxx : "") . "\" size=\"3\" maxlength=\"3\" onKeyUp=\"if(this.value.length == 3) this.form.gq_installXXXX_$i.focus();\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . ">-";
														echo "<input class=\"textInput\" type=\"text\" name=\"gq_installXXXX_$i\" value=\"" . ($i == 1 && $xxxx != '' ? $xxxx : "") . "\" size=\"4\" maxlength=\"4\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . ">";
														echo <<<EOF
														</td>
													</tr>		
												</div>		
											
												<tr>
													<td nowrap>Address Line 1:</td>
EOF;
										
													echo "<td><input class=\"textInput\" type=\"text\" value=\"" . ($i == 1 && $gq_address_1 != '' ? $gq_address_1 : "") . "\" name=\"gq_address_$i\" size=\"25\" maxlength=\"50\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . "></td>";
													
													echo <<<EOF
												</tr>
											
												<tr>
													<td nowrap>Address Line 2:</td>
EOF;
													
													echo "<td><input class=\"textInput\" type=\"text\" value=\"" . ($i == 1 && $gq_address2_1 != '' ? $gq_address2_1 : "") . "\" name=\"gq_address2_$i\" size=\"25\" maxlength=\"50\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . "></td>";
													echo <<<EOF
												</tr>
											
												<tr>
													<td nowrap>City | State | Zip:</td>
													<td>
EOF;
													
														echo "<input class=\"textInput\" type=\"text\" value=\"" . ($i == 1 && $gq_city_1 != '' ? $gq_city_1 : "") . "\" name=\"gq_city_$i\" size=\"12\" maxlength=\"35\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . "> ";
														echo "<select name=\"gq_state_$i\" class=\"textInput\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . ">";
															foreach($StateList as $v) {
																echo "<option value=\"$v\"" . ($i == 1 && $gq_state_1 != '' && $gq_state_1 == $v ? " selected" : "") . ">$v</option>\n";
															}
															
															echo "</select>&nbsp;";
															echo "<input class=\"textInput\" type=\"text\" value=\"" . ($i == 1 && $gq_zip_1 != '' ? $gq_zip_1 : "") . "\" name=\"gq_zip_$i\" size=\"5\" maxlength=\"10\"" . ($i==1 && $ReadOnly == "Yes" ? " disabled" : "") . ">";
															if ($i==1 && $ReadOnly == "Yes"){
																echo <<<EOF
																<input type="hidden" name="gq_installNPA_1" value="$npa">			 
																<input type="hidden" name="gq_installNXX_1" value="$nxx">			 
																<input type="hidden" name="gq_installXXXX_1" value="$xxxx">
																<input type="hidden" name="gq_address_1" value="$gq_address_1">
																<input type="hidden" name="gq_address2_1" value="$gq_address_2">
																<input type="hidden" name="gq_city_1" value="$gq_city_1">
																<input type="hidden" name="gq_state_1" value="$gq_state_1">
																<input type="hidden" name="gq_zip_1" value="$gq_zip_1">
EOF;
																
															}
															echo <<<EOF
													<td>
												</tr>
											</table>
										</div>
EOF;
									}

									if ($ReadOnly == "No"){
										echo <<<EOF
										<table class="geoInstallation">
											<tr>
												<td width="118" valign="top" wrap>Tell us about your situation:</td>
												<td>
													<textarea id="txtArea" cols="32" rows="3" name="comments" onfocus="if (this.value == 'Enter your comments here') { this.value=''; }" onblur="if (this.value == '') { this.value='Enter your comments here';}">$comments</textarea>
												</td>
											</tr>
										</table>
EOF;
									} 

									echo <<<EOF
									<div id="gq_questions" style="display:none;">
										<div style="width:100%;background:#EEEEEE;text-align:left;"><img src="http://plugindata.geoquote.net/images/ajax_loading.gif" width="32" height="32" border="0" alt="loading addition information..."></div>
									</div>
									<noscript>
										<div class="noScriptDesc">
										JavaScript is turned OFF in your web browser. Please turn it ON to take full 
										advantage of this site, then refresh the page.
										</div>
									</noscript><br>
									
									
									
EOF;

									if ($ReadOnly == "Yes"){
										echo <<<EOF
										<div id="submitBlock" style="display:none;">
											<table class="submitButton">
											<tr>
												<td>
													<table width="100%">
														<tr>
															<td width="100%" valign="middle" align="right"><img src="http://plugindata.geoquote.net/images/seeprice.gif"></td>
										               		<td valign="middle"> <input type="submit" value="Continue >" name="lpqe"></td>
										              </tr>
													</table>		
												</td>
											</tr>
											</table>		
										</div>								
EOF;
									}									
									
								echo <<<EOF
								</td>
							</tr>
						</table>

EOF;
						
						if ($ReadOnly == "No"){
						echo <<<EOF
						<BR>
						<table width="100%" style="margin:0;padding:0 0 0 0;border:1px solid #c6c6c6;">
							<tr>
								<td>

									<table width="100%">
										<tr>
											<td>
												<table class="geoquote_step2_title">
													<tr><td height="20">Step 4 - Contact Preferences</td></tr>
												</table>
											</td>
										</tr>
									</table>
									<table width="98%" cellpadding="4" cellspacing="0" border="0">
										<tr>
											<td colspan="2" style="padding-left:15px;">
												After we calculate your quote, a member of our T1 Sales Department 
												<b>will contact you</b> to explore your options and answer any questions 
												you may have. What is the best way to reach you?<br>
												<img src="http://plugindata.geoquote.net/images/spacer.gif" height="10" width="1" border="0">
												<div style="white-space:nowrap;">
												<input type="radio" value="callme" name="preference"> Please call me ASAP at
												(<input type="text" value="$npa" name="contact_npa" size="3" maxlength="3">)
												<input type="text" value="$nxx" name="contact_nxx" size="3" maxlength="3">-
												<input type="text" value="$xxxx" name="contact_xxxx" size="4" maxlength="4">
												x <input type="text" name="contact_extension" size="4" maxlength="10">
												</div>
												<input type="radio" value="emailme" name="preference">
												Call me later but email me now at <a class="quoteEmail" href="mailto:$quoteEmail">$quoteEmail</a>
												<br>
												<input type="radio" value="nocontact" name="preference">
												I am just window shopping
												<br><br>
											</td>
										</tr>
										
										<tr id="submitBlock" style="display:none;">
											<td>
												<table width="100%">
													<tr>
														<td width="100%" valign="middle" align="right"><img src="http://plugindata.geoquote.net/images/seeprice.gif"></td>
									               <td valign="middle"> <input type="submit" value="Continue >" name="lpqe"></td>
									              </tr>
												</table>		
											</td>
										</tr>
										
									</table>
								</td>
							</tr>
						</table>
EOF;
						}
					
					echo <<<EOF
					</td>
				</tr>
			</table>

		</td>
	</tr>
</table>


<input type="hidden" name="gq_isPRI" value="$gq_isPRI">
<script language="JavaScript">
	gq_maxInstallLocations = $gq_maxInstallLocations;
	loadDefaultSettingAll($TheCategoryID,$TheDefaultServiceID);
	
	var gqTitleCase = $defaultGeoQuoteTitleCase;
	
	var mplsHost = document.getElementById('mpls_host');
	mplsHost.innerHTML = ($TheDefaultServiceID == 20 || $TheDefaultServiceID == 21 || $TheDefaultServiceID == 19) ? 'Enter Your Host Address' : 'Enter Installation Information';
</script>
</form>
</div>
EOF;
?>