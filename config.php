<?php
include_once("config_lib.php");

$version = 3; // Don't touch this!
$website = $_SERVER['SERVER_NAME']; // Don't touch this!

$ReturnPath = "http://xmlplugin.com/geoquotenew/"; // Root ReturnPath to the 'return home' references on the last step of the Plug-in
$ReturnFrontPage = "geoquote.php"; // File name (step 1) within the ReturnPath directory

$AgentNumber = "1054"; // Your Agent Number (you can find this on your View Profile page of agent.telarus.com

$DefaultServiceType = "D"; // Default service to be highlighted in Step 1 of the plug-in | D = Data, V = Voice, I = Intergrated, M = Multi-site, N = Network Services

// If the customer selected D (Data), which underlying service do you want to have pre-selected on step 2?
$DefaultServiceIDData = "4"; 
// 1  = Business DSL
// 80 = Business Cable
// 4  = Internet T1 (1.5 MB)
// 5  = Bonded Internet (3MB to 12MB)
// 2  = Fixed Wireless Broadband
// 10 = Satellite High-Speed Internet
// 6  = Fractional DS3 Internet (6MB to 45 MB)
// 7  = DS3 Internet(45MB)
// 9  = Ethernet over Copper Internet (2MB to 20MB)
// 53 = Ethernet over DS1/DS3
// 11 = Mobile Wireless
// 50 = High BW Fixed Wireless (> 2.0MB)
// 51 = 4G WiMax
// 8  = OC-3 Internet (155MB)
// 52 = OC-48 Internet (2.5GB)
// 47 = OC-12 Internet (622MB)
// 54 = Metro Fiber Ethernet
// 55 = Gigabit Ethernet

// If the customer selects V (Voice), which underlying service do you want pre-selected on step 2?
$DefaultServiceIDVoice = "43";
// 33 = Local Voice - T1
// 34 = Local Voice - PRI
// 36 = Dedicated LD (In/Out)
// 37 = Dedicated LD (PRI)
// 35 = POTS Lines
// 38 = Long Distance - Switched
// 69 = Dedicated LD (Call Center)
// 44 = Hosted PBX (SMB)
// 56 = Hosted PBX (Call Center/Enterprise)
// 43 = Business VoIP
// 42 = SIP (Local/LD Trunks)
// 41 = SIP/VoIP (LD Buckets)
// 71 = Voice over MPLS

// If the customer selects I (Integrated), which underlying service do you want pre-selected on step 2?
$DefaultServiceIDIntegrated = "14";
// 12 = Integrated Access (Digital Trunk Handoff)
// 13 = Integrated Access (PRI Handoff)
// 15 = Integrated Access (SIP Handoff)
// 14 = Integrated Access (Analog Handoff)

// If the customer selects M (Multi-Site), which underlying service do you want pre-selected on step 2?
$DefaultServiceIDNetwork = "20";
// 18 = Point to Point (1.5MB - 1GB)
// 46 = Multilocation Internet Access
// 20 = MPLS Network
// 21 = VPN (Virtual Private Network)
// 72 = Ethernet WAN
// 19 = MAN (Metro Area Network)
// 73 = VPLS
// 74 = International VPLS

// If the customer selects N (Newtowk Services), which underlying service do you want pre-selected on step 2?
$DefaultServiceIDNetworkService = "16";
// 16 = Server Colocation
// 23 = Network Monitoring
// 24 = Data Backup (Distaster Recovery)
// 25 = Managed Web Hosting
// 26 = Managed Services
// 27 = Remote Storage
// 28 = Security and Firewalls
// 29 = Audio and Web Conferencing
// 31 = Call Center Software
// 48 = SalesForce Automation
// 75 = Microsoft Exchange
// 76 = Google Apps for Business
// 77 = SSL VPN

?>