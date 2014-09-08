<?php

if (!file_exists('config.php')) {
	exit;
}

include "config.php";

phpparam('QuoteName','');
phpparam('ContactName','');
phpparam('TollFree','');
phpparam('Email','');
phpparam('RepeatReason','');

echo <<< EOF
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td align=center>
			<br><br><br><br><br><br>
			<table border="0" cellpadding="0" cellspacing="0" width="458" bgcolor="#efefef" class="pn2">

				<tr bgcolor="#ffffff">
					<td colspan=3 align=center height=32><img src="http://plugindata.geoquote.net/images/repeat_top.gif" width=161 height=32 border=0 alt="geoquote"></td>
				</tr>
				<tr>
					<td rowspan=3 colspan=1 width=92 height=105><img src="http://plugindata.geoquote.net/images/box_left.gif" width=92 height=105 border=0></td>
					<td rowspan=1 colspan=1 width=312 height=8 valign=top><img src="http://plugindata.geoquote.net/images/box_top.gif" width=312 height=8 border=0></td>
					<td rowspan=3 colspan=1 width=54 height=105><img src="http://plugindata.geoquote.net/images/box_right.gif" width=54 height=105 border=0></td>
				</tr>
				<tr>
					<td rowspan=1 colspan=1 width=312 height=29 valign=middle>
						<div style="font-weight:bold;color:#c00000;">Maximum Quotes Exceeded</div>
						<hr size=1>
						Thank for returning to our site $QuoteName</cfoutput>!<br>
						<b>For more quotes, please call your personal product specialist ASAP!</b>
					</td>
				</tr>
				<tr>
					<td rowspan=1 colspan=1 width=312 height=8 valign=bottom><img src="http://plugindata.geoquote.net/images/box_bottom.gif" width=312 height=8 border=0></td>
				</tr>
			</table><br>

			<table width="458" bgcolor=ffffcc cellpadding=4 cellspacing=4 class="pn2">
				<tr>
					<td width="30%">&nbsp; Your Consultant:</td><td bgcolor=ffcc00><b>$ContactName</b></td>
				</tr>
				<tr>
					<td width="30%">&nbsp; Toll Free Number:</td><td bgcolor=ffcc00><b>$TollFree</b></td>
				</tr>
				<tr>
					<td width="30%">&nbsp; Contact Email:</td><td bgcolor=ffcc00><b><a href="mailto:$Email">$Email</a></b></td>
				</tr>
			</table>
			<br><br>
			<p align="center" class="pn2">$RepeatReason</p>
			<br><br><br><br><br>
		</td>
	</tr>
</table>
EOF;


if ((isset($_COOKIE["TheCustomerID"]) == false) && (isset($TheCustomerID) == true)) {
	$CookieCustomerID = $_COOKIE["TheCustomerID"];
} elseif ((isset($_COOKIE["TheCustomerID"]) == true) && (isset($TheCustomerID) == true)) {
	if ($CookieCustomerID != $_COOKIE["TheCustomerID"]) {
		$CookieCustomerID = $_COOKIE["TheCustomerID"];
	}
}

?>
