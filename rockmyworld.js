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
			
			var d = new Date( events[i].date * 1000 );
			
			var artist = events[i].artist;
			if( events[i].artist.length > 22 ) {
				artist = events[i].artist.substr(0, 22) + "&hellip;";
			}
			
			// Use the array ID of the event to access event data
			html += "<div onclick='openEvent(" + i + ");' class='event'>" + 
					"<div class='event-padding'>" +
						"<div class='date'>" + d.getMonth() + "/" + d.getDate() + "</div>" +
						"<span class='event-title'>" + artist + "</span>" +
					"</div>" +
				"</div>" + 
				"<div id='event" + i + "' class='event-info'>" + 
					"<div style='padding:0 8px 8px 8px;'>";
					
			if( events[i].image.content )
				html += "<div style='float:right;'><img src='" + events[i].image.content + "'></div>";
					
			if( events[i].venueLocation.point ) {
				html += "<div class='venue-title'>VENUE</div>";
				
				if( events[i].venueName )
					html += "<div>" + events[i].venueName + "</div>";
					
				if( events[i].venueLocation.street )
					html += "<div>" + events[i].venueLocation.street + "</div>";
					
				if( events[i].venueLocation.city )
					html += "<div>" + events[i].venueLocation.city + "</div>"
					
			} else {
				html += "<div class='venue-title'>VENUE</div>" + 
						"<div>" + events[i].venueName + "</div>";
			}
			
			html += "</div>" + 
				"</div>";
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
					map.addOverlay(new GMarker(point, markerOptions));
				}
			}
		}
		
	});
}

function openEvent( eventId ) {
	$( '#event' + eventId ).slideToggle('fast');
}

function loadURL( divId, URL ) {
	$('#wrapper').slideUp(function() {
		$.getJSON( URL, {lat: document.coords.latitude, long: document.coords.longitude }, function(data) {
			var html = "<div class='title'>Tagged Nearby</div>";
			for( key in data ) {
				html += "<div class='event'>" + 
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