<?php
include("header.php"); 
include($_SERVER['DOCUMENT_ROOT'] . '/api/core/auth.php');

$auth=new auth();
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="../assets/css/bootstrap.css" rel="stylesheet">

		<link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="../assets/ico/favicon.ico">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
	</head>

	<body>

		
					<a class="brand" href="/">Jambusters</a>

					<div class="btn-group pull-right">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-user"></i> 
<?php
	if($auth->is_login()){
		echo htmlentities($auth->name());
	}else{
		echo 'anonymous';
	}
?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
<?php
	if($auth->is_login()){
?>
							<li>
							<a href="/logout.php">Logout</a>
							</li>
<?php
	}else{
?>
							<li>
							<a href="/login.php">Login</a>
							</li>
							<li>
							<a href="/register.php">Register</a>
							</li>
<?php
	}
?>
						</ul>
					</div>
	<div class="content-wrap"> 
	
<?php
	if($auth->is_login()){
		echo '<strong><em>Welcome '.htmlentities($auth->name()).'</em></strong><br/><br/> ';
	
?>
		
<?php
	}else{echo '<h3>Log in or create an account with JamBusters for more features! </h3><br/><br/> '; 
?>
		
<?php
	}
?>
 
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
		<div class="right-content">
			<label for="location">Location</label><input type="text" id="location">
			<button id="submit" onclick = "codeAddress();">Map It!</button>
            <input type="checkbox" id="useNav" value="usenav"> Use Current Location
			<br/>
            <br/>
			<div id="map_canvas" style="width:600px; height:400px" ></div>
		</div> 
	</div> 
    <div class="content-wrap" id="events">
         
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
	
	
	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="../assets/js/bootstrap-transition.js"></script>
	<script src="../assets/js/bootstrap-alert.js"></script>
	<script src="../assets/js/bootstrap-modal.js"></script>
	<script src="../assets/js/bootstrap-dropdown.js"></script>
	<script src="../assets/js/bootstrap-scrollspy.js"></script>
	<script src="../assets/js/bootstrap-tab.js"></script>
	<script src="../assets/js/bootstrap-tooltip.js"></script>
	<script src="../assets/js/bootstrap-popover.js"></script>
	<script src="../assets/js/bootstrap-button.js"></script>
	<script src="../assets/js/bootstrap-collapse.js"></script>
	<script src="../assets/js/bootstrap-carousel.js"></script>
	<script src="../assets/js/bootstrap-typeahead.js"></script>

<?php include("footer.php"); ?> 
