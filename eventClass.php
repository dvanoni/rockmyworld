<?php

class Event {
	public $artist, $date, $desc, $venueName, $venueLocation, $image;
	public $tags = array();
	
	public function __construct( $artist, $date, $desc, $venueName, $venueLocation, $image, $tags) {
		$this->artist 		 = $artist;
		$this->date 		 = $date;
		$this->desc 		 = $desc;
		$this->venueName 	 = $venueName;
		$this->venueLocation = $venueLocation;
		$this->image 		 = $image;
		$this->tags			 = $tags;
	}
}

?>