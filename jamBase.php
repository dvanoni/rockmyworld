<?
include('reversegeo.php');
include('eventClass.php');
class JamBase {
	
	public $location, $events;
	
	
	public function __construct($lat, $lng) {
		
		$this->location = reverseGeoLookup($lat, $lng);
		
	}
	
	public function getEvents() {
	  	$BASE_URL = "https://query.yahooapis.com/v1/public/yql";
		$events = "";
		
		$events = array();
		 
		// Form YQL query and build URI to YQL Web service
		$yql_query = "select * from html where url=\"http://www.jambase.com/shows/Shows.aspx?ArtistID=0&VenueID=0&City=" 
		. $this->location['city'] . "&State=" . $this->location['state'] .
		"&radius=25&Rec=False&pagenum=1&pasi=20\" and xpath=\"//table[@class='showList']\"";
		
		$yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";
		// Make call with cURL
		// $session = curl_init($yql_query_url);
		// curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
		// $json = curl_exec($session);
		$json = file_get_contents($yql_query_url);
		// Convert JSON to PHP object 
		$phpObj =  json_decode($json);
	
		// Confirm that results were returned before parsing
		if(!is_null($phpObj->query->results)) {
		  // Parse results and extract data to display
		  foreach ($phpObj->query->results as $result) {
			 $crap = $result->tr;
			 $date = "";
			 $artist = "";
			 $venue = "";
			 $loc = "";
			 foreach ($crap as $stuff) {
				if (isset($stuff->td) && (isset($stuff->class) && $stuff->class != "dateSep")) 
				{
					if ($stuff->class == "dateRow") 
					{
						$date = $stuff->td->a->content;
					}
					else 
					{
						$event = $stuff->td;
						//echo $date.": ";
						foreach($event as $detail) 
						{
							
							$colNames = array("artistCol","venueCol",'locationCol');
							foreach($colNames as $col) 
							{
								if (isset($detail->class) && $detail->class == $col) 
								{	
									if (!empty($detail->a->content)) 
									{
										if ($col == "artistCol") { $artist = $detail->a->content; }
										if ($col == "venueCol") { $venue = $detail->a->content; }
										if ($col == "locationCol") { $loc = $detail->a->content; }
										//echo $detail->a->content;
									}
									foreach($detail->a as $a) 
									{
										if (!empty($a->content)) 
										{
											$artist .=$a->content.', ';
											//echo $a->content.', ';
										}
									}
								}
							}
							

						}
						if (!empty($date) && !empty($artist) && !empty($venue)) 
							{
								$artist =  str_ireplace("\n",' ',trim($artist));
								$last = $artist[strlen($artist)-1];
								if ($last == ',') {
									$artist = substr_replace($artist ,"",-1);
								}
								array_push($events, new Event($artist,  strtotime($date), "",  str_ireplace("\n",' ',$venue),  str_ireplace("\n",' ',$loc), "", null));
							}
						$artist = "";
						
					}
				}
			 }
		  }
		}
		return $events;
	}

}

?>