<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Rock My World!</title>
	<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport">	
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<script type="text/javascript" charset="utf-8" src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
	<script type="text/javascript" charset="utf-8" src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js'></script>
 	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAJthGY8atuRTbW0lLRBHl1hT0kzh_vIOjo5KaLA_k3-smoZ_YbBTT7B8DTKGgfLDw9RuScskT_iGjVQ&sensor=false" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8" src='iscroll.js'></script>
	<script type="text/javascript" charset="utf-8" src='rockmyworld.js'></script>
	<style type='text/css'>
		body {
			margin:0;	
			font-family:'Trebuchet MS',Verdana,Arial,sans-serif;
			font-size:12px;
			background:#493736;
			line-height:150%;
		}
		
		IMG {
			vertical-align:middle;
		}
		
		#wrapper {
			position:relative;
			z-index:1;
			height:416px;
			overflow:hidden;
		}
		
		#maps-div {
			height:416px;
		}
		
		#footer {
			background: url('footer-bg.png') repeat-x;
			background-position: 50% 100%;
			display:block;
			height:44px;
			width:100%;
		}
		
		#results {
		}
		
		.venue-title {
			color:#EEE;
			font-weight:bold;
		}
		
		.icon {
			float:left;
			width:40px;
			height:40px;
			margin: 2px 8px;
		}
				
		.event {
			background:url(bg.png) repeat-x;
			width:100%;
			color:#EEE;
			margin-bottom:4px;
			height:60px;
		}
		
		.title {
			background:#000;
			color:#fff;
			font-size:12px;
			text-align:center;
			padding:1px;
		}
		
		.event-info {
 			clear:both;
			display:none;
			font-size:14px;
			color:#AAA;
			margin: 0 8px 8px 8px;
		}
		
		.event-padding {
			padding:16px 8px;
		}
		
		.event-title {
			font-size:18px;
			text-transform: uppercase;
			font-variant: small-caps;
		}
		
		.date {
			float:left;
			color:#2A2829;
			font-size:20px;
			font-weight:bold;
			width:52px;
		}
	</style>

</head>
<body>
	<div id='wrapper'>
		<div id='results'>
		</div>
		<div id='tags-div' style='display:none;'>
		</div>
		<div id='maps-div'></div>
	</div>
	<div id='footer'>
		<div class='icon' onclick='loadDiv("results");'>
			<img src='images/list.png' width='40px'>
		</div>
		<div class='icon' onclick='loadURL("tags-div", "tags.php");'>
			<img src='images/tags.png' width='40px'>
		</div>
		<div class='icon' onclick='loadDiv("maps-div");'>
			<img src='images/map.png' width='40px'>
		</div>
	</div>
</body>	
</html>