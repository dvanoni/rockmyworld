<?

class Weather {
	public $hi, $lo, $text, $date;
	
	public function __construct($hi, $lo, $text, $date) 
	{
		$this->hi = $hi;
		$this->lo = $lo;
		$this->text = $text;
		$this->date = $date;
	}
}

class Forecast {
	public $days = array();
	public function __construct($h1, $l1, $t1, $d1, $h2, $l2, $t2, $d2) {
		array_push($this->days, new Weather($h1, $l1, $t1, $d1)); 
		array_push($this->days, new Weather($h2, $l2, $t2, $d2)); 
	}
}

function getweather() {
	if ( isset($_GET['zip']) ) {
		$zip = $_GET['zip'];
	} else {
		$zip = 92122;
	}

	$url = "http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20weather.forecast%20where%20location%3D$zip&format=json";
	$obj = json_decode( file_get_contents( $url ) );
	$data = $obj->query->results->channel->item->forecast;
	return new Forecast(
		$data[0]->high, 
		$data[0]->low,
		$data[0]->text,
		$data[0]->date,
		$data[1]->high, 
		$data[1]->low,
		$data[1]->text,
		$data[1]->date
		);
}

echo json_encode( getweather() );
?>