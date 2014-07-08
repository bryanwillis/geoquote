<?php
echo <<<EOF
<html>
<head>
	<title>Calculating...</title>
	<style type="text/css">
		table.flash {margin:200px auto 0 auto;padding:0;border:0;width:100%;}
		table.flash td {margin:0;padding:0;border:0;}
	</style>	
</head>
<body topmargin="0" leftmargin="0" rightmargin="0" marginwidth="0" marginheight="0" bgcolor="#ffffff" onload="javascript:InterstitialTable.style.display='none';">
	<div align="center"><center>
	<table align="center" class="flash" id="InterstitialTable">
		<tr>
			<td valign="middle" align="center">
				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" 
					codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" 
					width="600" 
					height="420" 
					id="geoquote" 
					align="middle"
				>
					<param name="allowScriptAccess" value="always" />
					<param name="movie" value="http://plugindata.geoquote.net/flash/gq_calculating.swf$qs" />
					<param name="menu" value="false" />
					<param name="quality" value="best" />
					<param name="bgcolor" value="#ffffff" />
					
					<embed src="http://plugindata.geoquote.net/flash/gq_calculating.swf$qs" 
						menu="false" 
						quality="best" 
						bgcolor="#ffffff" 
						width="600" 
						height="420" 
						name="geoquote" 
						align="middle" 
						allowScriptAccess="always" 
						type="application/x-shockwave-flash" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" />
				</object>
			</td>
		</tr>
	</table>
	</center></div>
</body>
</html>
EOF;
flush();
?>