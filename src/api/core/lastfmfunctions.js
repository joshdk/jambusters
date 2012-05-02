function getEventsByArtist(artistName)
{
	url = "http://ws.audioscrobbler.com/2.0/?method=artist.getevents&artist=" + artistName + "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json";
   $.getJSON(url, function(data) {
        var html = '';
		console.log(data);
			if(data.events.total!=0)
			{
			$.each(data.events.event, function(i, item) {
            html += "<li> Title:" + item.title + "<br> Description:" + item.description + "</li>";
			});
			}
        $('#test').append(html);
          topArt = data.topartists;
    });
}