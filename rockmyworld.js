function handler( loc ) {
	var longitude = loc.coords.longitude;
	var latitude  = loc.coords.latitude;
	document.coords = loc.coords;
	
	var url = 'lastfm.php';
	$.getJSON( url, {lat: latitude, long: longitude }, function(data) {
		
		// Save the event data
		var events =  data;
		document.events = events;
		
		// Loop through events and output HTML for the event
		var html = "<div class='title'>Concerts Nearby</div>";
		for( var i = 0; i < events.length; i++ ) {
			html += getEventHtml(events[i], i, 'results');
		}
		
		// Append HTML to the page
		$('#results').append( html );
		myScroll = new iScroll( document.getElementById('results') );
		
		// Initialize Google Map with event markers
		if (GBrowserIsCompatible()) {
			var map = new GMap2(document.getElementById("maps-div"));
			map.setCenter(new GLatLng( loc.coords.latitude, loc.coords.longitude ), 10 );
			map.setUIToDefault();
			
			// Go through events and add markers
			for( var i = 0; i < events.length; i++ ) {
				if( events[i].venueLocation.point ) {
					// Create our "tiny" marker icon
					var blueIcon = new GIcon(G_DEFAULT_ICON);
					blueIcon.image    = "concert.png";
					blueIcon.shadow = null;
					blueIcon.iconSize = new GSize( 32, 32 );

					// Set up our GMarkerOptions object
					var markerOptions = { icon:blueIcon };

					// Add 10 markers to the map at random locations
					var point = new GLatLng( events[i].venueLocation.point.lat, events[i].venueLocation.point.long );
					
					var marker = new GMarker(point, markerOptions);
					marker.event = events[i];
					
				 	GEvent.addListener(marker, "click", function() {
						var html = "<div>" + 
										"<div style='margin:8px 0 8px 0;font-size:14px;color:#666;'>" + this.event.artist + "</div>"
										"<div style='padding:0 8px 8px 8px;'>";

						if( this.event.description )
							html += "<div style='font-size:12px;line-height:150%;'>" +this.event.description + "</div>"

						if( this.event.venueLocation.point ) {
							if( this.event.venueName )
								html += "<div>" + this.event.venueName + "</div>";

							if( this.event.venueLocation.street )
								html += "<div>" + this.event.venueLocation.street + "</div>";

							if( this.event.venueLocation.city )
								html += "<div>" + this.event.venueLocation.city + "</div>"

						} else {
							html += "<div class='venue-title'>VENUE</div>" + 
									"<div>" + this.event.venueName + "</div>";
						}
						
						html += "</div>" + 
							"</div>";
					
				    	this.openInfoWindowHtml( html );
				  	});
				
					map.addOverlay(marker);
				}
			}
		}
		
	});
}

function getEventHtml( event, index, thingy )  {
	var d = new Date( event.date * 1000 );		
	var artist = event.artist;
	var html = "";
	if( event.artist.length > 22 ) {
		artist = event.artist.substr(0, 22) + "&hellip;";
	}
	
	// Use the array ID of the event to access event data
	html += "<div onclick='openEvent(\"" + index + thingy + "\");' class='event'>" + 
			"<div class='event-padding'>" +
				"<div class='date'>" + d.getMonth() + "/" + d.getDate() + "</div>" +
				"<span class='event-title'>" + artist + "</span>" +
			"</div>" +
		"</div>" + 
		"<div id='event" + index + thingy + "' class='event-info'>" + 
			"<div style='float:right;'>" +
				"<a href='youtube/request.php?query=" + event.artist + "'><img src='images/youtube.png'></a>" +
			"</div>" +
			"<div style='margin:8px 0 8px 0;font-size:14px;color:#EEE;'>" + event.artist + "</div>"
			"<div style='padding:0 8px 8px 8px;'>";
			
	if( event.description )
		html += "<div style='font-size:12px;line-height:150%;'>" + event.description + "</div>"
		
	if( event.venueLocation.point ) {
		html += "<div class='venue-title'>VENUE</div>"+ 
				"<div onclick='centerMap(" + event.venueLocation.point.lat + ", " + event.venueLocation.point.long + ");'>" + 

		if( event.venueName )
			html += "<div>" + event.venueName + "</div>";
			
		if( event.venueLocation.street )
			html += "<div>" + event.venueLocation.street + "</div>";
			
		if( event.venueLocation.city )
			html += "<div>" + event.venueLocation.city + "</div>";
			
		html += "</div>";
			
	} else {
		html += "<div class='venue-title'>VENUE</div>" + 
				"<div>" + event.venueName + "</div>";
	}
	
	html += "</div>" + 
		"</div>";
	
	return html;
}

function openEvent( eventId ) {
	$( '#event' + eventId ).slideToggle('fast');
}

function loadURL( divId, URL ) {
	$('#wrapper').slideUp(function() {
		$.getJSON( URL, {lat: document.coords.latitude, long: document.coords.longitude }, function(data) {
			var html = "<div class='title'>Tagged Nearby</div>";
			for( key in data ) {
				html += "<div class='event' onclick='slideTags(\""+key+"\");'>" + 
						"<div class='event-padding'>" +
							"<span class='event-title' style='font-weight:" + (data[key] * 100) + "'>" + key + "</span>" +
						"</div>" +
					"</div>";
			}
			$('#tags-div').html( html );
			
			// Hide the selected tab
			$('#' + document.selected_div ).hide();
			$('#' + divId ).show();
			document.selected_div = divId;
			$('#wrapper').slideDown();
			myScroll = new iScroll( document.getElementById( divId ) );
		});
	});
}

function slideTags( tag ) {
	// Loop through events and output HTML for the event
	var html = "<div class='title' style='overflow:auto;'><img src='tags-back-button.png' height=25 style='float:left' onClick='backToTags();'>Concerts Tagged \"" +tag+ "\" Nearby</div>";
	//html += "<div style='background:#000;padding:2px;'></div>";
	var events = document.events;
	for( var i = 0; i < events.length; i++ ) {
		if (events[i].tags != null) {
			//alert(events[i].tags.tag);
			for (var j = 0; j < events[i].tags.tag.length; j++) {
				//alert(events[i].tags.tag[j]);
				if (events[i].tags.tag[j] == tag) {
					html += getEventHtml(events[i], i, 'tags');
				}
			}
		}
	}
	
	// Append HTML to the page
	$('#tag-results-div').html( html );
	$('#tags-div').hide("slide", { direction: "left" }, 200);
	$('#tag-results-div').show("slide", { direction: "right" }, 200);
	document.selected_div = "tag-results-div";
}

function backToTags() {
	$('#tag-results-div').hide("slide", { direction: "right" }, 200);
	$('#tags-div').show("slide", { direction: "left" }, 200);
	document.selected_div = "tags-div";
}

function loadDiv( divId ) {
	$('#wrapper').slideUp(function() {
		// Hide the selected tab
		$('#' + document.selected_div ).hide();
		$('#' + divId ).show();
		document.selected_div = divId;

		setTimeout( function() {
			$('#wrapper').slideDown();
		}, 500);
	});
}

$(function() {
	if( navigator.geolocation ) {
		navigator.geolocation.getCurrentPosition(handler);
	} else {
		$.getJSON( 'geolookup.php', null, function(data) {
			handler( data );
		});
	}
	
	document.ontouchmove = function(e) { e.preventDefault(); return false; }
	document.selected_div = "results";
});