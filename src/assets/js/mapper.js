var api_key = "AIzaSyBY98lcCjXRBf4lFiFG4X3H3N7lCLdxTd8";

var geocoder;
var map;
var infoWindow = null;
var markers;
var ITEM;
function initialize() {
console.log("initializing");
	geocoder = new google.maps.Geocoder();
	infoWindow =  new google.maps.InfoWindow();

        var myOptions = {
          center: new google.maps.LatLng(40.714,-74.006),
          zoom: 11,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
}

function codeAddress() {
    var address = document.getElementById("location").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
//asyncronous call: inside this function when it returns
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
console.log(results[0].geometry.location);

var artists = getArtists();

//var artist = document.getElementById("artistName").value;
//var artist = ["We Were Promised Jetpacks","Liturgy"];
	getEventsByLatLong(results[0].geometry.location.$a,results[0].geometry.location.ab,$('#test'),artists);
    });
}


function addVenue(event) {
ITEM = event;
console.log(event);
console.log(event.venue.location["geo:point"]["geo:lat"] + event.venue.location["geo:point"]["geo:long"]);
    var marker;
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(event.venue.location["geo:point"]["geo:lat"],event.venue.location["geo:point"]["geo:long"]),
        map: map,
	title: "Title:" + event.title + "Description:" + event.description + "All Artists:" + event.artists.artist
      });
//markers.push({"marker": marker, "event": event});
google.maps.event.addListener(marker, 'click', (function(marker) {
        return function() {
	console.log("here");
	console.log(event);
         infoWindow.setContent("Title" + ITEM.title + "<br>" + ITEM.description);
          infoWindow.open(map, marker);
        }
      })(marker));
/*
      google.maps.event.addListener(marker, 'click', (function(marker) {
	console.log(infoWindow);
         // infoWindow.setContent("some shit");
          infoWindow.open(map, marker);
        })); */

}
