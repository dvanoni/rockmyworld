<?

function reverseGeoLookup($lat, $lng) {
	$apikey= 'ABQIAAAAJthGY8atuRTbW0lLRBHl1hT0kzh_vIOjo5KaLA_k3-smoZ_YbBTT7B8DTKGgfLDw9RuScskT_iGjVQ';
	$gmapsquery ="http://maps.google.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=true&false&key=$apikey";
	
	// $gs = curl_init($gmapsquery);
	// curl_setopt($gs, CURLOPT_RETURNTRANSFER, true);
	// $js = curl_exec($gs);
	$js = file_get_contents($gmapsquery);
	$p = json_decode($js);
	
	$result = array('city'=>'', 'state'=>'');
	
	if(!is_null($p->results[0])){
		foreach ($p->results[0]->address_components as $loc) {
			if ($loc->types[0] == "locality") {
				$result['city'] = urlencode($loc->long_name);
			}
			if ($loc->types[0] == "administrative_area_level_1") {
				$result['state'] = urlencode($loc->short_name);
			}
			
		}
	}	
	
	return $result;
}

?>