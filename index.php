<!DOCTYPE html>
<html>
<head>
	<title>2048</title>
	<style type="text/css">
	body{

	}
	 td {
	 	border: 1px solid black;
	 	height: 40px;
	 	width: 40px;
	 	text-align: center;
	 }

	 .tile{
	 	background-color: black;
	 	color:white; 
	 }

	 .tile.numbered{
	 	background-color: blue;
	 }
	</style>
</head>
<body>
<table>
	<tr>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
	</tr>
	<tr>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
	</tr>
	<tr>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
	</tr>
	<tr>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
		<td class="tile"></td>
	</tr>
</table>
<button id="new_game">New Game</button>
<button class="swipe" data-direction="up">Up</button>
<button class="swipe" data-direction="down">Down</button>
<button class="swipe" data-direction="left">Left</button>
<button class="swipe" data-direction="right">Right</button>

<script src="https://code.jquery.com/jquery-1.11.3.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	console.log("document ready");
	
	var Game = function(){
		console.log("Game instaniated", this);
		
		//clean tiles
		var $tiles = $(".tile");
		$tiles.each(function(){
			$(this).html("");
		});

		var rand_tile_1 = this.get_random_tile();
		
		//prevent from getting two same tile positions
		var temp = this.get_random_tile();
		while(temp == rand_tile_1){
			temp = this.get_random_tile();
		}

		var rand_tile_2 = temp;

		$tiles[rand_tile_1].innerHTML = this.tile_numbers[Math.floor(Math.random() * 2)];
		$tiles[rand_tile_2].innerHTML = this.tile_numbers[Math.floor(Math.random() * 2)];


	};

	Game.prototype.tile_numbers = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096];
	Game.prototype.get_random_tile = function(){
		return Math.floor(Math.random() * 16);
	}
	Game.prototype.swipe = function(direction){

	};
	
	$('#new_game').click(function(){
		new Game;
	});

	$('.swipe').click(function(){
		var direction = $(this).data('direction');
	});

});
</script>
</body>
</html>