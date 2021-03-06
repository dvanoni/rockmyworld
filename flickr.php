<?php
$query 	 = urlencode($_REQUEST['query']);
$queries = preg_split( '/,/', $query );
$artist = $queries[0];

$url = "http://query.yahooapis.com/v1/public/yql?q=".
		"select%20source%20from%20flickr.photos.sizes%20where%20photo_id%20in%20".
		"(select%20id%20from%20flickr.photos.search%20where%20text%3D%22$artist%22)&format=json";

$obj = json_decode( file_get_contents( $url ) );

$sizes = $obj->query->results->size;
//echo print_r($sizes);

if( count( $sizes ) == 0 ) {
	echo "<div style='padding:16px;font-size:16px;text-align:center;'>No images available!</div>";
} else {
	foreach ($sizes as $key => $value) {
		$img_src = $value->source;
		if (preg_match('/.+_m.jpg$/', $img_src)) {
			echo "<div><img src=\"$img_src\" width=\"320\"/></div>";
		}
	}
}

?>