<?php
include_once "config.php";

$ReturnURL = $ReturnPath . $ReturnFrontPage;

echo <<< EOF
<table class="calculateError" align="center">
	<tr>
		<td>
			<div class="pn4">
				There was a problem with the GeoQuote<sup>TM</sup> quoting engine.<br><br>
				This is most likely a short term connectivity issue and should be resolved in the next
				few minutes.<br><br>
				Our staff has been notified.<br><br>
				Thank you for your patience and cooperation.
				<br><br>
				<hr size=1 color=aaaaaa>
			
				<br>
			
				<div align="right"><a href="{$ReturnURL}"><b>Continue  &raquo;&raquo;</b></a></div>
				<br><br>
			</div>
		</td>
	</tr>
</table>
EOF;
?>
