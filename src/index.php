
<?php include("header.php"); ?>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

	<div class="content-wrap"> 
	
		<div class="ui-widget">
		<label for="artist">Enter Artist: </label>
		<input id="artist" />
		</div>

		<div class="ui-widget" style="margin-top:2em; font-family:Arial">
			Selected Artists:
			<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
		</div>
	
		<div class="left-content"> 
			<!-- below is the "search" feature form --> 
			<form method="get" action="/search" id="search" class="search">
				<input name="q" type="text" size="40" placeholder="Find an Artist..." />
			</form>
			<p> This is random text 
			<br /> and there is no point to having it here 
			<br /> except Tiffany wants to test things! </p> 
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