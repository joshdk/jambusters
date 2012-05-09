var api_key = "AIzaSyBY98lcCjXRBf4lFiFG4X3H3N7lCLdxTd8";

var geocoder;
var map;
var infoWindow = null;
var markers = [];

//global current location values lol
var lat = null
var lon = null;

function getCurrent() {
    if (navigator.geolocation) {
          
         navigator.geolocation.getCurrentPosition( 
			    function (position) {
			
				    lat = position.coords.latitude;
				    lon = position.coords.longitude;
                    map.setCenter(new google.maps.LatLng(lat, lon));
                    console.log("current Lat:" + lat + "current long: " + lon);
                    getEventsByLatLong(lat,lon,$('#events'),artists);
                    //init();    
                },
                function (error)
			    {
				    switch(error.code) 
				    {
					    case error.TIMEOUT:
						    alert ('Timeout');
						    break;
					    case error.POSITION_UNAVAILABLE:
						    alert ('Position unavailable');
						    break;
					    case error.PERMISSION_DENIED:
						    alert ('Permission denied');
						    break;
					    case error.UNKNOWN_ERROR:
						    alert ('Unknown error');
						    break;
				    }
			    }
            );
        }
/*
    else {
        //if not supported or disabled, default to NYC
        lat = 40.714;
        lon = -74.006;
        init();
    }*/
}

function init() {
    //find user current location and center map on it:
    //getCurrent();
    //lat = 40.714;
    //lon = -74.006;
    console.log("initializing");
    console.log("lat: " + lat + "lon: " + lon);
	geocoder = new google.maps.Geocoder();
	infoWindow =  new google.maps.InfoWindow();

    


    var myOptions = {
        center: new google.maps.LatLng(lat,lon),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
    //this will close the info if user clicks on map
    google.maps.event.addListener(map, 'click', function() {if(infoWindow){infoWindow.close(); console.log("closed an infowindow");}});
    }


function initialize() {
    
    //find user current location and center map on it:
    //getCurrent();
    lat = 40.714;
    lon = -74.006;
    console.log("initializing");
    console.log("lat: " + lat + "lon: " + lon);
	geocoder = new google.maps.Geocoder();
	infoWindow =  new google.maps.InfoWindow();

    var myOptions = {
        center: new google.maps.LatLng(lat,lon),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
    google.maps.event.addListener(map, 'click', function() {if(infoWindow){infoWindow.close(); console.log("closed an infowindow");}});
    
}

function codeAddress() {
    var address = document.getElementById("location").value;
    console.log(address);
    var artists = getArtists();
    var useNav = document.getElementById("useNav");
    console.log(useNav);
    
    //if requesting a specific address geocode it and center map on it:
    if( useNav.checked == true ){
        console.log("using current");
        getCurrent();
   //     getEventsByLatLong(lat,lon,$('#test'),artists);
    }
    else {
        geocoder.geocode( { 'address': address}, function(results, status) {
            //asyncronous call: inside this function when it returns
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
            } else {
                alert("Geocode was not successful for the following reason: " + status);
            }
            console.log( results[0].geometry.location);
            //$a is latitude ab is longitude wat?
            getEventsByLatLong(results[0].geometry.location.$a,results[0].geometry.location.ab,$('#events'),artists);
        });
        
    }

}


function addVenue(event) {

    console.log(event);
    
    var marker;
    //create new marker and set it at the event location
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(event.venue.location["geo:point"]["geo:lat"],event.venue.location["geo:point"]["geo:long"]),
        map: map,
	    title: event.title
      });

//click event on the marker to open Info windows with more info
//notice the strange syntax
    google.maps.event.addListener(marker, 'click', (function(marker) {
            return function() {
	    //console.log(event);
             infoWindow.setContent(event.title + "<br>"+"Date: " + event.startDate +"<br>" + event.description + "<br>" +"Venue: " + event.venue.name + "<br>" + "Address: " + event.venue.location.street + " " + event.venue.location.city + "<br>" + "Phone: " + event.venue.phonenumber+ "<br>" + "<a href=" + event.website +"> Event page </a>" + "<a href=" + event.url +"> Last.fm page </a>");         
              infoWindow.open(map, marker);
    
            }
          })(marker));
}
