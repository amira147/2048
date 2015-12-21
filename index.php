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
		<td class="tile" data-row="1" data-col="1"></td>
		<td class="tile" data-row="1" data-col="2"></td>
		<td class="tile" data-row="1" data-col="3"></td>
		<td class="tile" data-row="1" data-col="4"></td>
	</tr>
	<tr>
		<td class="tile" data-row="2" data-col="1"></td>
		<td class="tile" data-row="2" data-col="2"></td>
		<td class="tile" data-row="2" data-col="3"></td>
		<td class="tile" data-row="2" data-col="4"></td>
	</tr>
	<tr>
		<td class="tile" data-row="3" data-col="1"></td>
		<td class="tile" data-row="3" data-col="2"></td>
		<td class="tile" data-row="3" data-col="3"></td>
		<td class="tile" data-row="3" data-col="4"></td>
	</tr>
	<tr>
		<td class="tile" data-row="4" data-col="1"></td>
		<td class="tile" data-row="4" data-col="2"></td>
		<td class="tile" data-row="4" data-col="3"></td>
		<td class="tile" data-row="4" data-col="4"></td>
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
	var myGame, 
		$tiles = $('.tile');

	var Game = function(){
		
		//clean tiles
		$tiles.each(function(){
			$(this).html("");
		});

		var rand_tile_1 = this.get_random_tile();
		$tiles[rand_tile_1].innerHTML = this.tile_values[Math.floor(Math.random() * 2)];
		
		//prevent from getting two same tile positions
		var temp = this.get_random_tile();
		while(temp == rand_tile_1){
			temp = this.get_random_tile();
		}

		// var rand_tile_2 = temp;

		// $tiles[rand_tile_2].innerHTML = this.tile_values[Math.floor(Math.random() * 2)];

		this.toggle_numbered_class();

	};

	Game.prototype.tile_matrix = [[1,2,3,4],[1,2,3,4],[1,2,3,4],[1,2,3,4]];
	Game.prototype.tile_values = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096];
	
	Game.prototype.get_random_tile = function(){
		return Math.floor(Math.random() * 16);
	}
	
	Game.prototype.swipe = function(direction){
		console.log(this, "direction=> ", direction);

		if(direction=="up"){
			//while a tile in row 1 does not have class numbered
			var numbered_tile_count = 0;

			// console.log("is_top_tile_numbered=> ", myGame.is_top_tile_numbered('row', 1));
			// while(!myGame.is_whole_line_numbered('row', 1)){
				$('.tile.numbered').each(function(){
					console.log("numbered tile => ", $(this));
					var tile_row = $(this).data('row');
					var tile_col = $(this).data('col');

					while(!myGame.is_top_tile_numbered('row', 1, 'col', tile_col)){
						console.log("is_top_tile_numbered=> ", myGame.is_top_tile_numbered('row', 1));
						if(tile_row>1){
							var tile_above_row = tile_row - 1;
							var $tile_above = $('.tile[data-row='+tile_above_row+'][data-col='+tile_col+']');
							if(!$tile_above.hasClass('numbered')){
								console.log("move tile => ", $tile_above);
								$tile_above.html($(this).html());
								$(this).html("");
							}

							myGame.toggle_numbered_class();
						}
						break;
					}
				});
				// break;
			// }

		}if(direction=="down"){
			//query each row except 4
		}if(direction=="left"){
			//query each col except 1
		}if(direction=="right"){
			//query each col except 4
		}

		// myGame.add_new_tile();
	};

	Game.prototype.is_top_tile_numbered = function(line1, number, line2, tile_number){ 
		var top_tile_numbered = false;
		// $('.tile[data-'+line+'='+number+']').each(function(){
		// 	if(!$(this).hasClass('numbered')){
		// 		top_tile_numbered = false;
		// 		return false;
		// 	}
		// });
		if($('.tile[data-'+line1+'='+number+'][data-'+line2+'='+tile_number+']').hasClass('numbered')){
			top_tile_numbered = true;
		}

		return top_tile_numbered;
	}
	
	Game.prototype.toggle_numbered_class = function(){
		$tiles.each(function(){
			if($(this).html()){
				$(this).addClass('numbered');
			}
			else{
				$(this).removeClass('numbered');
			}
		});
	}
	
	Game.prototype.add_new_tile = function(){
		var temp = this.get_random_tile();
		
		while($($tiles[temp]).hasClass('numbered')){
			temp = this.get_random_tile();
		}

		var rand_tile = temp;

		$tiles[rand_tile].innerHTML = this.tile_values[Math.floor(Math.random() * 2)];

		this.toggle_numbered_class();
	}
	
	$('#new_game').click(function(){
		myGame = new Game;
	});

	$('.swipe').click(function(){
		myGame.swipe($(this).data('direction'));
	});

});
</script>
</body>
</html>