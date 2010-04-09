<?php
$query = urlencode($_REQUEST['query']);
$query_url = "http://gdata.youtube.com/feeds/api/videos".
	"?q=$query".
	"&category=music".
	"&orderby=relevance".
	"&max-results=1".
	"&safeSearch=none".
	"&key=AI39si6bsLGIrcdqhLo03XVdeiZc7cBGtAhbo20aXuSPv_r3oPduolYK1JNqge1vY3BGVqpGvjQOQHDobehfXwh4M8ShRcqxeg".
	"&v=2".
	"&alt=json";
$result_json = file_get_contents($query_url);
$result_object = json_decode($result_json);
$video = $result_object->feed->entry[0];
//print_r($video);
//print_r($video->title);
$href = $video->link[0]->href;
echo "<a href=\"$href\">$href</a>";
?>
