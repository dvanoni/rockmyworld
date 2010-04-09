<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Rock My World!</title>
	<meta content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" name="viewport">	
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<link rel="apple-touch-startup-image" href="images/startup.png">
	<script type="text/javascript" charset="utf-8" src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
	<script type="text/javascript" charset="utf-8" src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js'></script>
 	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAJthGY8atuRTbW0lLRBHl1hT0kzh_vIOjo5KaLA_k3-smoZ_YbBTT7B8DTKGgfLDw9RuScskT_iGjVQ&sensor=false" type="text/javascript"></script>
	<script type="text/javascript" charset="utf-8" src='iscroll.js'></script>
	<script type="text/javascript" charset="utf-8" src='rockmyworld.js'></script>
	<link rel="stylesheet" type="text/css" href="rockmyworld.css">

</head>
<body>
	<div id='wrapper'>
		<div id='results'></div>
		<div id='tags-div'></div>
		<div id='tag-results-div'></div>
		<div id='photos-div'></div>
		<div id='lighter-div'>
			<div style='padding-top:94px;'>
				<img src='lighter.gif'>
			</div>
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
		<div class='icon' onclick='loadDiv("lighter-div");'>
			<img src='lighter.png' width='40px'>
		</div>
	</div>
	<div id='loading'>
		<div id='loading-text'>
			Loading...
		</div>
	</div>	
</body>	
</html>