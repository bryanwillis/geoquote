geoquote
========

Teleraus Geoquote Module

Upload to a folder in you site directory.


Edit lines 7,8,9 in geoquote/config.php to point to the plugin in your site path:

$ReturnPath = "http://example.com/geoquote/"; // location of plugin
$ReturnFrontPage = "geoquote.php"; // points to geoquote.php
$AgentNumber = "1054"; // Your Agent Number (you can find this on your View Profile page of agent.telarus.com)


The plugin should now be accessable via http://example.com/geoquote/geoquote.php


You can load step one several different ways to include it in one of your own templates. 


The easiest way is probably using jquery:

    <div class="somediv"></div>
    <script type='text/javascript'>
        jQuery(document).ready(function($) {
	      	$('.somediv').load('http://example.com/geoquote/geoquote.php');
        });
    </script>
    
Or consider an iframe: 

    <iframe src="http://example.com/geoquote/geoquote.php"></iframe>


You can also just edit the current templates themselves and edit header.php and footer.php to change the page header and footer.
