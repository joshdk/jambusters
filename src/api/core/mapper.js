var api_key = "AIzaSyBY98lcCjXRBf4lFiFG4X3H3N7lCLdxTd8";

	var geocoder;
	var map;
function initialize() {
   geocoder = new google.maps.Geocoder();

        var myOptions = {
          center: new google.maps.LatLng(40.714,-74.006),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("map_canvas"),
            myOptions);
}

function codeAddress() {
    var address = document.getElementById("location").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }


function addVenue() {
var marker = new google.maps.Marker({
    map: map,
    position: results[0].geometry.location
});

}
