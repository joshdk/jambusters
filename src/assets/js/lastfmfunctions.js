
/*
artistName = name of the artist.
selector = 	html object to put html into. ex. $('#test')
			appends html to #test
			
//TODO Need to implement error checking
//for bad band name, and maybe return something if no events fond
*/
function getEventsByArtist(artistName,selector)
{
	var url = "http://ws.audioscrobbler.com/2.0/?method=artist.getevents&artist=" + artistName + "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json&callback=?";
   $.getJSON(url, function(data) {
		console.log(data);
		var html = '';
		if(data.events.total!=0)
		{
			$.each(data.events.event, function(i, item) {
			html += "<li> Title:" + item.title + "<br> Description:" + item.description + "</li>";
			});
		}
		else 
		{
			html += "<p> No Events Found </p>";
		}
		selector.append(html);
    });
}

//Artist is now an array of artists
function getEventsByLatLong(Lat, Long,selector,artistName)
{
	var url = "http://ws.audioscrobbler.com/2.0/?method=geo.getevents&lat=" + Lat + "&long=" + Long + "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json&limit=30&callback=?";
   $.getJSON(url, function(data) {
		var html = '';
		var items = new Array();
		if(data.events.total!=0) //no events found
		{
			$.each(data.events.event, function(i, item) {
				if(item.artists.artist instanceof Array)//is an array
				{
					for(var x =0; x < artistName.length;x++)
					{
						if(jQuery.inArray(artistName[x],item.artists.artist)!=-1) //artist you were loooking for has been found
						{
							console.log("success");
							//items.push(item);
							addVenue(item);
							html += "<li> Title:" + item.title + "<br> Description:" + item.description + "<br> All Artists:" + item.artists.artist + "</li>";
						}
					}
				}
				else //is not an array
				{
					for(var x =0; x < artistName.length;x++)
					{
						if(item.artists.artist == artistName[x])
							html += "<li> Title:" + item.title + "<br> Description:" + item.description + "<br> All Artists:" + item.artists.artist + "</li>";
					}
				}
			});
		}
		else 
		{
			html += "<p> No Events Found </p>";
		}
		
		selector.append(html);
    });
}

function getArtistsByPartialArtist(artist,selector)
{

	selector.empty();
		if(artist == "")
		return;
	var url = "http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=" + artist + "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json&callback=?";
	$.getJSON(url, function(data) {
		console.log(data);
		var html = '';
		if(data.results.totalResults!=0) //no artists found
		{
			$.each(data.results.artistmatches.artist, function(i, item) {
			html += "<li>" + item.name + "</li>";
			});
		}
		else 
		{
			html += "<p> No Events Found </p>";
		}
		selector.append(html);
    });
}
currentArtists = [];
function addArtist(artist)
{
	currentArtists.push(artist);
}

function getArtists()
{
return currentArtists;
}
