<?php
include_once("config.php");
include_once("header.php");

phpparam('ErrorMsg','');
phpparam('Email','');
phpparam('btn','');
phpparam('Password','');
phpparam('EmailErrorMsg','');

$ReturnURL = $ReturnPath . $ReturnFrontPage;

echo <<< EOF
<link rel="stylesheet" href="http://plugindata.geoquote.net/css_geoquote/styles.css" type="text/css">
<link rel="stylesheet" href="css_geoquote/styles.css" type="text/css">

<div align="center">
<table class="geoFrame">
	<tr>
		<td style="background-color:#eee;">
			<img align="right" src="http://plugindata.geoquote.net/images/calculate_box.gif" hspace="0" vspace="0" border="0"><br>
			<div class="bullet">Customer Login:</div>
		</td>
	</tr>
</table>

<table class="geoFrame">
	<tr>
		<td>
			<table class="quoteNote">
				<tr>
					<td>
						<div class="note">
							To look up a carrier service quote that you previously generated, please enter
							your 10 digit phone number and password (your password was emailed to you 
							when you generated your quote). If you need to contact us for any reason, 
							please do not hesitate to call or email us at your earliest convenience.  
							We will do all in our capacity to respond to your inquiry immediately.
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

<table class="geoFrame">
	<tr>
		<td width="50%" valign="top">
			<form method="post" action="order_lookup.php">
			<table class="custLogin">
				<tr>
					<td colspan="2"><div class="title">Login to review your quotes</div></td>
				</tr>
EOF;

				if ($ErrorMsg != "") {
					echo <<<EOF
					<tr><td colspan="2" bgcolor="#ff3333" align="center" style="font-weight:bold;color:#ffffff;background-color:#ff3333;">Error: $ErrorMsg</td></tr>
EOF;
				}
				
				echo <<<EOF
				<tr>
					<th>Phone Number:</th>
					<td><input type="text" name="btn" value="$btn" size="12" maxlength="12"></td>
				</tr>
				<tr>
					<th>Password:</th>
					<td><input type="password" value="$Password" name="Password" size="12" maxlength="7"></td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" value="Login" style="width:90px;"></td>
				</tr>
			</table>
			</form>
		</td>
		
		<td width="50%" valign="top">
			<form method="post" action="custlogin_reminder.php">
			<table class="custLogin">
				<tr>
					<td colspan="2"><div class="title">Forget your password?</div></td>
				</tr>
				<tr>
					<td colspan="2" style="padding:3px 2px 3px 10px;font-family:verdana;font-size:9px;font-weight:normal;">*Enter your email address and your password will be sent to you by email.</td>
				</tr>					
EOF;
				if ($EmailErrorMsg != "") {
					echo <<< EOF
					<tr><td colspan="2" bgcolor="#ff3333" align="center" style="font-weight:bold;color:#ffffff;background-color:#ff3333;">$EmailErrorMsg</td></tr>
EOF;
				}
				
				echo <<<EOF
				<tr>
					<th>Your Email:</th>
					<td><input type="text" name="Email" value="$Email" size="30" maxlength="100"></td>
				</tr>
				<tr>
					<th></th>
					<td><input type="submit" value="Send Password" style="width:120px;"></td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
</table>

<table class="geoFrame">
	<tr>
		<td>
			<table class="quoteNote">
				<tr>
					<td>
						<div class="note">
							All of the quotes you generate will be stored here for 6 months, so come
							back and compare your old results to our new low rates.
						</div>
						
						<div class="note" align="right">
							Not a customer? &nbsp; <a href="{$ReturnURL}"><b>Generate a T1 Quote</b></a>
						</div>

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

</div>
EOF;

include_once("footer.php");
?>