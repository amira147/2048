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

	 .square{
	 	background-color: black;
	 }

	 .tile{
	 	background-color: blue;
	 	text-align: center;
	 	color:white; 
	 	width:37px;
	 	height:37px;    
	 	display: table-cell;
	    vertical-align: middle;
	 }
	</style>
</head>
<body>
<table>
	<tr>
		<td class="square empty" data-row="1" data-col="1"></td>
		<td class="square empty" data-row="1" data-col="2"></td>
		<td class="square empty" data-row="1" data-col="3"></td>
		<td class="square empty" data-row="1" data-col="4"></td>
	</tr>
	<tr>
		<td class="square empty" data-row="2" data-col="1"></td>
		<td class="square empty" data-row="2" data-col="2"></td>
		<td class="square empty" data-row="2" data-col="3"></td>
		<td class="square empty" data-row="2" data-col="4"></td>
	</tr>
	<tr>
		<td class="square empty" data-row="3" data-col="1"></td>
		<td class="square empty" data-row="3" data-col="2"></td>
		<td class="square empty" data-row="3" data-col="3"></td>
		<td class="square empty" data-row="3" data-col="4"></td>
	</tr>
	<tr>
		<td class="square empty" data-row="4" data-col="1"></td>
		<td class="square empty" data-row="4" data-col="2"></td>
		<td class="square empty" data-row="4" data-col="3"></td>
		<td class="square empty" data-row="4" data-col="4"></td>
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
	jQuery.fn.reverse = [].reverse;

	console.log("document ready");
	var myGame, 
		$squares = $('.square');

	var Game = function(){
		var new_tile_count =  2;
		
		//clean squares
		$squares.each(function(){
			$(this).html("");
		});

		for(i=0; i<new_tile_count; i++){
			this.add_new_tile();
		}

	};

	Game.prototype.square_matrix = [[1,2,3,4],[1,2,3,4],[1,2,3,4],[1,2,3,4]];
	Game.prototype.square_values = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096];
	
	Game.prototype.get_random_square = function(){
		return Math.floor(Math.random() * 16);
	}
	
	Game.prototype.move_tiles = function(direction){

	}

	Game.prototype.merge_tiles = function(direction){
		
	}

	Game.prototype.swipe = function(direction){
		console.log(this, "direction=> ", direction);
		var add_new_tile = false, loop_move = true, loop_merge = true;

		if(direction=="up"){

			//move
			if(loop_move){

			}
			$('.tile').each(function(){
				console.log("%c <== New tile for MOVE check ==>", 'background-color: red;');
				var x = $(this).data('x');
				var y = $(this).data('y');
				var tile_id = $(this).attr('id');
				var sqr_above = y-1;

				if(y>1){

					console.log("CHECK==> should_i_move ", myGame.should_i_move(tile_id));

					// var count = 0;
					while(myGame.should_i_move(tile_id)){
						console.log("MOVE UP");
						add_new_tile = true;

						$tile = $('#'+tile_id);
						x = $tile.data('x');
						y = $tile.data('y');
						sqr_above = y-1;

						$current_sqr = $('.square[data-row='+ y +'][data-col='+x+']');
						$above_sqr = $('.square[data-row='+ sqr_above +'][data-col='+x+']');

						$above_sqr.html($('#'+tile_id));
						$tile.attr('data-y', sqr_above);
						$current_sqr.html("");
						
						myGame.toggle_tiled_squares();

						// count++;

						// if(count==5){
							// break;
						// }

					}
				}
			});

			//merge
			var tile_counter = 0;
			$('.tile').reverse().each(function(){
				console.log("%c <== New tile for MERGE check ==>", 'background-color:green;');
				var x = $(this).attr('data-x');
				var y = $(this).attr('data-y');
				var tile_id = $(this).attr('id');
				var sqr_above = y-1;

				if(y>1){

					console.log("CHECK==> should_i_merge ", myGame.should_i_merge(tile_id), "with x=> ", x, "with y=> ", y);

					// var count = 0;

					while(myGame.should_i_merge(tile_id)){
						console.log("MERGE tile_id=> ", tile_id);
						add_new_tile = true;

						$tile = $('#'+tile_id);
						x = $tile.attr('data-x');
						y = $tile.attr('data-y');
						sqr_above = y-1;

						console.log("this is the tile=> ", $('#'+tile_id), "with x=> ", x, "with y=> ", y);

						$current_sqr = $('.square[data-row='+ y +'][data-col='+x+']');
						$above_sqr = $('.square[data-row='+ sqr_above +'][data-col='+x+']');

						new_val = $tile.html()*2;

						console.log("MERGE. new_val=> ",new_val, "for sqr=> ", $above_sqr);
						$('#'+tile_id).html(new_val);
						$('#'+tile_id).css('background-color', 'violet');
						$above_sqr.html($('#'+tile_id));
						$tile.attr('data-y', sqr_above);
						$tile.attr('data-merged', '1');
						$current_sqr.html("");
						
						myGame.toggle_tiled_squares();

						// count++;
						// if (count==5){
						// 	break;
						// }

					}

				}

				tile_counter++;

				//reset all merge flags
				if(tile_counter == $('.tile').length){
					$('.tile').attr('data-merged', '0');
				}
			});

			//if there was a merge, move again, don't merge again.

		}if(direction=="down"){
			//query each row except 4
		}if(direction=="left"){
			//query each col except 1
		}if(direction=="right"){
			//query each col except 4
		}

		// add_new_tile ? myGame.add_new_tile() : "" ;
		myGame.add_new_tile();
	};

	Game.prototype.should_i_move = function(tile_id){ 
		var should_i_move = true, x, y, row_above;
		x = $('#'+tile_id).attr('data-x');
		y = $('#'+tile_id).attr('data-y');
		row_above = y-1;

		// console.log(
		// 	'row_above=> ', row_above, 
		// 	'x=> ', x, 
		// 	'y=> ', y, 
		// 	'row_above_val=> ',$('.square[data-row='+row_above+'][data-col='+ x +'] .tile').html(), 
		// 	'tile_val=> ', $('#'+tile_id).html()
		// );

		if(!$('.square[data-row='+row_above+'][data-col='+ x +']').hasClass('empty')){
			should_i_move = false;
		}

		return should_i_move;
	}

	Game.prototype.should_i_merge = function(tile_id){ 
		var should_i_merge = false, x, y, row_above;
		x = $('#'+tile_id).attr('data-x');
		y = $('#'+tile_id).attr('data-y');
		is_merged = $('#'+tile_id).attr('data-merged');
		row_above = y-1;

		console.log("INSIDE should_i_merge",
			'tile_id=> ', tile_id, 
			'tile_id=> ', tile_id, 
			'is_merged=> ', is_merged, 
			'row_above=> ', row_above, 
			'x=> ', x, 
			'y=> ', y, 
			'row_above_val=> ',$('.square[data-row='+row_above+'][data-col='+ x +'] .tile').html(), 
			'tile_val=> ', $('#'+tile_id).html()
		);
		
		if($('#'+tile_id).length && is_merged == '0'){ //if tile exists
			if($('.square[data-row='+row_above+'][data-col='+ x +'] .tile').html() == $('#'+tile_id).html()){
				should_i_merge = true;
			}
		}

		return should_i_merge;
	}


	
	Game.prototype.toggle_tiled_squares = function(){
		$squares.each(function(){
			if($(this).html()){
				$(this).removeClass('empty');
			}
			else{
				$(this).addClass('empty');
			}
		});
	}
	
	Game.prototype.add_new_tile = function(){
		var temp = this.get_random_square();
		
		while(!$($squares[temp]).hasClass('empty')){
			temp = this.get_random_square();
		}

		var index = temp;

		// this.lay_new_tile(rand_square);
		
		var $tile = $("<div id='tile_"+Math.floor(Date.now() / 1000)*index+"' class='tile' data-x='0' data-y='0' data-merged='0'>"+this.square_values[Math.floor(Math.random() * 2)]+"</div>");
		$($squares[index]).html($tile);

		$tile.attr('data-x', $tile.parent().data('col'));
		$tile.attr('data-y', $tile.parent().data('row'));
		// $squares[rand_square].innerHTML = this.square_values[Math.floor(Math.random() * 2)];

		this.toggle_tiled_squares();
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