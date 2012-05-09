<?php
include("header.php"); 
include($_SERVER['DOCUMENT_ROOT'] . './api/core/auth.php');  //'./api/core/auth.php'

$auth=new auth();
?>



	<div class="content-wrap"> 
	<div id="login"> 
<?php
	if($auth->is_login()){
		echo '<strong><em>Welcome '.htmlentities($auth->name()).'</em></strong>';
?>
		<br />
		<a href="/logout.php"><button>Logout</button></a>
<?php
	}else{
?>
		<a href="/login.php"><button>Login</button></a> If you have an account
		<br />
		<a href="/register.php"><button>Register</button></a> If you do not have an account
		<br />
<?php
	}
?>

	<link rel="stylesheet" href="./datepicker/css/datepicker.css" type="text/css" />
    <link rel="stylesheet" media="screen" type="text/css" href="./datepicker/css/layout.css" />


	<script type="text/javascript" src="./datepicker/js/jquery.js"></script>
	<script type="text/javascript" src="./datepicker/js/datepicker.js"></script>
    <script type="text/javascript" src="./datepicker/js/eye.js"></script>
    <script type="text/javascript" src="./datepicker/js/utils.js"></script>
    <script type="text/javascript" src="./datepicker/js/layout.js?ver=1.0.2"></script>

<script>
	$(function() {
		$("#calendar3").DatePicker({
		flat: true,
	date: ['2012-05-01','2012-05-07'],
	current: '2012-05-31',
	calendars: 1,
	mode: 'range',
	starts: 1

});
	});
</script>


<p id="calendar3"></p>      <!-- calendar widget tag -->

		<br /> </div> 
		
		
		<div class="left-content" > 
			Select an Artist to add to the list <br /> 
			<!--Enter artist input box-->
			<input class="artistSearch" id="artist" type="text" size="40" placeholder="Find an Artist..." /> 
			<br /> 
			<br /> 
			<!--Selected Artist Listbox-->
			Current Artists... 
			<div id="log" style="height: 200px; width: 200px; overflow: auto;" class="ui-widget-content"></div>
			
		</div> 

		<div class="right-content" onload="initialize();"> 
			<label for="location">Location</label><input type="text" id="location">
			<button id="submit" onclick = "codeAddress();">Map It!</button>
			<br/><br/> 
			<div id="map_canvas" style="width:400px; height:400px"></div>
		</div> 
	</div> 

	<script>
	$(function() {
		function log( message ) {
			addArtist(message);
			console.log(getArtists());
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
