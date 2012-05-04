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
		
		<div class="right-content"> 
			<p> This is a test of the right content
				<br /> this will have a lot of artists 
				<br /> in it when it is actually working 
				<br /> but for now I just am wondering about 
				<br /> this whole scrolling thing... 
				<br /> do we want it bigger?</p> 
		</div> 
	</div> 
	<script>
	$(function() {
		function log( message ) {
			$( "<div/>" ).text( message ).prependTo( "#log" );
			$( "#log" ).scrollTop( 0 );
		}

		$( "#artist" ).autocomplete({
			source: function( request, response ) {
			var url = "http://ws.audioscrobbler.com/2.0/?method=artist.search&artist=" + request.term + "&api_key=b25b959554ed76058ac220b7b2e0a026&format=json&callback=?";
				$.ajax({
					url: url,
					dataType: "json",
					success: function( data ) {
					console.log(data);
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