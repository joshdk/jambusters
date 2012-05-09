<?php include("header.php"); ?>

	<div class="content-wrap"> 
		<div class="left-content"> 
			Select an Artist to add to the list <br /> 
			<!--Enter artist input box-->
			<input class="artistSearch" id="artist" type="text" size="40" placeholder="Find an Artist..." /> 
			<br /> 
			<br /> 
			<!--Selected Artist Listbox-->
			Current Artists... 
			<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
		</div> 
		<div class="right-content" onload="initialize();"> 
			<label for="location">Location</label><input type="text" id="location">
			<button id="submit" onclick = "codeAddress();">Map It!</button>
			<br/>
			<div id="map_canvas" style="width:600px; height:400px"></div>
		</div> 

	</div> 

	<script>
		function removeArtistFromLog(event){ 
		var artistToRemove = event.target.id;
		
		var d = document.getElementById("log");//$("#log");//
		var olddiv =  document.getElementById(artistToRemove);
		d.removeChild(olddiv);
		removeArtist(artistToRemove);
	}
	
	$(function() {
		function log( message ) {
			addArtist(message);
			html = "";
			html = "<input type=\"submit\" class=\"artistButton\"  value=\"x\" id=\"";
			html+= message + "\"";
			html+= "onclick=removeArtistFromLog(event) >";
			console.log("button html: " + html);
			$( "<div id=\"" + message + "\"/>" ).html(html + " " + message).prependTo( "#log" );
			console.log($("#log"));
			$( "#log" ).scrollTop( 0 );
		}

		$( "#artist" ).autocomplete({
			source: function( request, response ) {
			var url = "http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=" + request.term + "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json&callback=?";
				$.ajax({
					url: url,
					dataType: "json",
					success: function( data ) {
						if(data.results["opensearch:totalResults"]!=0) //no artists found
						{		
						response( $.map( data.results.artistmatches.artist, function( item ) {
							return {
								label: item.name,
								value: item.name
							}
						}));
						}
					}
				});
			},
			minLength: 2,
			select: function( event, ui ) {
				//set vlaue of thing to ""
				//ui.item.label = "";
				//$("#artist").replaceWith(blankSearchdiv);
				
				log( ui.item ?
					ui.item.label :
					"Nothing selected, input was " + this.value);
			},
			open: function() {
				$( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
			},
			close: function() {
				$( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
			}
		});
	});
	
	</script>

<?php include("footer.php"); ?> 
