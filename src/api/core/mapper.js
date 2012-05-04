var api_key = "AIzaSyBY98lcCjXRBf4lFiFG4X3H3N7lCLdxTd8";

var geocoder;
var map;
var infoWindow = null;

function initialize() {
   geocoder = new google.maps.Geocoder();
infoWindow =  new google.maps.InfoWindow({ content: "some shit"});

        var myOptions = {
          center: new google.maps.LatLng(40.714,-74.006),
          zoom: 5,
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


var artist = document.getElementById("artistName").value;
	getEventsByLatLong(results[0].geometry.location.$a,results[0].geometry.location.ab,$('#test'),artist);
    });
}


function addVenue(item) {
console.log(item);
console.log(item.venue.location["geo:point"]["geo:lat"] + item.venue.location["geo:point"]["geo:long"]);
    var marker;
      marker = new google.maps.Marker({
        position: new google.maps.LatLng(item.venue.location["geo:point"]["geo:lat"],item.venue.location["geo:point"]["geo:long"]),
        map: map,
	title: "Title:" + item.title + "Description:" + item.description + "All Artists:" + item.artists.artist
      });

      google.maps.event.addListener(marker, 'click', (function(marker) {
	console.log(infoWindow);
         // infoWindow.setContent("some shit");
          infoWindow.open(map, marker);
        }));

}
