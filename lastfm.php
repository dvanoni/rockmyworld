<?php
include_once('jamBase.php');
include_once('eventClass.php');

function cmp( $a, $b ) {
	if( $a->date == $b->date ) {
		return 0;
	}
	
	return ( $a->date < $b->date ) ? -1 : 1;
}

class LastFM {
	private $lat, $long;
	
	public function __construct( $lat, $long ) {
		$this->lat  = $lat;
		$this->long = $long;
	}
	
	public function getEvents() {
		$url = 'http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20xml%20' . 
				'where%20url%3D%22http%3A%2F%2Fws.audioscrobbler.com%2F2.0%2F%3Fmethod%3Dgeo.getevents%26lat%3D' .
		 		$this->lat . '%26long%3D' . $this->long . '%26api_key%3Db25b959554ed76058ac220b7b2e0a026%22&format=json';
		
		$obj = json_decode( file_get_contents( $url ) );
		
		$events = $obj->query->results->lfm->events->event;

		$eventObjs = array();
		for( $i = 0; $i < count( $events ); $i++ ) {
			
			$e = new Event( $events[$i]->title, 
								strtotime( $events[$i]->startDate ), 
								$events[$i]->description, 
								$events[$i]->venue->name,
								$events[$i]->venue->location, 
								$events[$i]->image[0], 
								$events[$i]->tags );

			array_push( $eventObjs, $e );
		}
		
		return $eventObjs;
	}
}

$test = new LastFM( $_GET['lat'], $_GET['long'] );
$jam  = new JamBase( $_GET['lat'], $_GET['long'] );
$merged_array = array_merge( $test->getEvents(), $jam->getEvents() );
usort( $merged_array, "cmp" );
echo json_encode( $merged_array );
?>