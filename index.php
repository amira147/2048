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

	 .tile[data-value="4"]{background-color: red;}
	 .tile[data-value="8"]{background-color: orange;}
	 .tile[data-value="16"]{background-color: mistyrose;}
	 .tile[data-value="32"]{background-color: green;}
	 .tile[data-value="64"]{background-color: plum;}
	 .tile[data-value="128"]{background-color: violet;}
	 .tile[data-value="256"]{background-color: aquamarine;}
	 .tile[data-value="512"]{background-color: firebrick;}
	 .tile[data-value="1024"]{background-color: fuchsia;}
	 .tile[data-value="2048"]{background-color: thistle;}
	 .tile[data-value="4096"]{background-color: teal;}

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

	Game.prototype.square_values = [2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096];
	
	Game.prototype.get_random_square = function(){
		return Math.ceil(Math.random() * 16);
	}
	
	Game.prototype.move_tiles = function(direction){
		
		var loop_move = false; //flag to check if there was a merge, if true, do another move loop
		
		if(direction == 'up' || direction == 'left'){
			$tiles = $('.tile');
		}
		else if(direction == 'down' || direction == 'right'){
			$tiles = $('.tile').reverse();
			
		}

		$tiles.each(function(){
			console.log("%c <== New tile for MOVE check ==>", 'background-color: red;', $(this).attr('id'), "("+$(this).attr('data-x')+","+$(this).attr('data-y')+")");
			var movable = false;
			var x = parseInt($(this).attr('data-x'));
			var y = parseInt($(this).attr('data-y'));
			var tile_id = $(this).attr('id');
			// var target_sqr = 0;

			if(direction == 'up'){
				if(y>1){
					movable = true;
					// target_sqr = y-1;
				}
			}
			else if(direction == 'down'){
				if(y<4){
					movable = true;
					// target_sqr = y+1;
				}
				
			}
			else if(direction == 'left'){
				if(x>1){
					movable = true;
					// target_sqr = x-1;
				}
				
			}
			else if(direction == 'right'){
				if(x<4){
					movable = true;
					// target_sqr = x+1;
				}
			}

			if(movable){

				console.log("CHECK==> should_i_move ", myGame.should_i_move(tile_id, direction, true));

				// var count = 0;
				while(myGame.should_i_move(tile_id, direction)){
					loop_move = true;

					$tile = $('#'+tile_id);
					x = parseInt($tile.attr('data-x'));
					y = parseInt($tile.attr('data-y'));

					console.log("MOVE "+direction+": ",
					"current position=> ", "("+x+","+y+")");

					$current_sqr = $('.square[data-row='+ y +'][data-col='+x+']');

					if(direction == 'up'){
						y = y-1;
					}
					else if(direction == 'down'){
						y = y+1;
					}
					else if(direction == 'left'){
						x = x-1;
					}
					else if(direction == 'right'){
						x = x+1;
					}
					
					console.log("target position=> ", "("+x+","+y+")");

					// $current_sqr = $('.square[data-row='+ y +'][data-col='+x+']');
					$target_sqr = $('.square[data-row='+ y +'][data-col='+x+']');

					$target_sqr.html($('#'+tile_id));

					$tile.attr('data-x', x);
					$tile.attr('data-y', y);

					$current_sqr.html("");
					
					myGame.toggle_tiled_squares();

					// count++;

					// if(count==5){
						// break;
					// }

				}
			}
		});

		return loop_move;
	}

	Game.prototype.should_i_move = function(tile_id, direction, check_only){ 
		var should_i_move = true, x, y;
		x = parseInt($('#'+tile_id).attr('data-x'));
		y = parseInt($('#'+tile_id).attr('data-y'));
		
		if(!check_only){
			console.log("inside move check: ",
						"current position=> ", "("+x+","+y+")");
		}

		if(direction == 'up'){
			y = y-1;
		}
		else if(direction == 'down'){
			y = y+1;
			
		}
		else if(direction == 'left'){
			x = x-1;
			
		}
		else if(direction == 'right'){
			x = x+1;

		}

		if(!check_only){
			// console.log(
			// 	'target_sqr=> ', target_sqr, 
			// 	'x=> ', x, 
			// 	'y=> ', y, 
			// 	'target_sqr_val=> ',$('.square[data-row='+target_sqr+'][data-col='+ x +'] .tile').html(), 
			// 	'tile_val=> ', $('#'+tile_id).html()
			// );

			console.log("target position=> ", "("+x+","+y+")", 
				'target_sqr_val=> ',$('.square[data-row='+y+'][data-col='+ x +'] .tile').html(), 
				'tile_val=> ', $('#'+tile_id).html());
		}

		if(!$('.square[data-row='+y+'][data-col='+ x +']').hasClass('empty')){
			should_i_move = false;
		}

		return should_i_move;
	}

	Game.prototype.merge_tiles = function(direction){

		var tile_counter = 0, //counter to reset data-merged attribute for all tiles
		loop_merge = false, //flag to check if there was a merge, if true, do another move loop
		tile_count = $('.tile').length; //count total tiles before entering loop to equate with loop counter

		if(direction == 'up' || direction == 'left'){
			// $tiles = $('.tile').reverse();
			$tiles = $('.tile');
		}
		else if(direction == 'down' || direction == 'right'){
			$tiles = $('.tile').reverse();
			
		}

		$tiles.each(function(){
			console.log("%c <== New tile for MERGE check ==>", 'background-color:green;', $(this).attr('id'));
			var mergable = false;
			var x = parseInt($(this).attr('data-x'));
			var y = parseInt($(this).attr('data-y'));
			var tile_id = $(this).attr('id');

			if(direction == 'up'){
				if(y>1){
					mergable = true;
					// y = y-1;
				}
			}
			else if(direction == 'down'){
				if(y<4){
					mergable = true;
					// y = y+1;
				}
				
			}
			else if(direction == 'left'){
				if(x>1){
					mergable = true;
					// x = x-1;
				}
				
			}
			else if(direction == 'right'){
				if(x<4){
					mergable = true;
					// x = x+1;
				}

			}

			if(mergable){

				console.log("CHECK==> should_i_merge ", myGame.should_i_merge(tile_id, direction, true), "with x=> ", x, "with y=> ", y);

				// var count = 0;

				while(myGame.should_i_merge(tile_id, direction)){
					console.log("MERGE tile_id=> ", tile_id);
					// add_new_tile = true;
					loop_merge = true;

					$tile = $('#'+tile_id);
					x = parseInt($tile.attr('data-x'));
					y = parseInt($tile.attr('data-y'));
					
					$current_sqr = $('.square[data-row='+ y +'][data-col='+x+']');

					if(direction == 'up'){
						y = y-1;
					}
					else if(direction == 'down'){
						y = y+1;
						
					}
					else if(direction == 'left'){
						x = x-1;
						
					}
					else if(direction == 'right'){
						x = x+1;

					}

					$target_sqr = $('.square[data-row='+ y +'][data-col='+x+']');

					new_val = $tile.html()*2;

					console.log("MERGE. new_val=> ",new_val, "for sqr=> ", $target_sqr);
					$('#'+tile_id).html(new_val);
					$('#'+tile_id).attr('data-value', new_val);
					// $('#'+tile_id).css('background-color', 'violet');
					$target_sqr.html($('#'+tile_id));
					$tile.attr('data-x', x);
					$tile.attr('data-y', y);
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
			// console.log("tile_count=> ", $('.tile').length, "tile_counter=> ",tile_counter);
			if(tile_counter == tile_count){
				$('.tile').attr('data-merged', '0');
			}
		});

		return loop_merge;
	}

	Game.prototype.should_i_merge = function(tile_id, direction, check_only){ 
		var should_i_merge = false, x, y;
		x = parseInt($('#'+tile_id).attr('data-x'));
		y = parseInt($('#'+tile_id).attr('data-y'));
		is_merged = $('#'+tile_id).attr('data-merged');
		
		if(!check_only){
			console.log("inside merge check: ",
						"current position=> ", "("+x+","+y+")");
		}

		if(direction == 'up'){
			y = y-1;
		}
		else if(direction == 'down'){
			y = y+1;
			
		}
		else if(direction == 'left'){
			x = x-1;
			
		}
		else if(direction == 'right'){
			x = x+1;

		}

		if(!check_only){
			// console.log("INSIDE should_i_merge",
			// 	'tile_id=> ', tile_id, 
			// 	'tile_id=> ', tile_id, 
			// 	'is_merged=> ', is_merged, 
			// 	'target_sqr=> ', target_sqr, 
			// 	'x=> ', x, 
			// 	'y=> ', y, 
			// 	'target_sqr_val=> ',$('.square[data-row='+target_sqr+'][data-col='+ x +'] .tile').html(), 
			// 	'tile_val=> ', $('#'+tile_id).html()
			// );

			console.log("target position=> ", "("+x+","+y+")", 
				'target_sqr_val=> ',$('.square[data-row='+y+'][data-col='+ x +'] .tile').html(), 
				'tile_val=> ', $('#'+tile_id).html());
		}
		
		if($('#'+tile_id).length && is_merged == '0'){ //if tile exists
			if($('.square[data-row='+y+'][data-col='+ x +'] .tile').html() == $('#'+tile_id).html()){
				should_i_merge = true;
			}
		}

		return should_i_merge;
	}

	Game.prototype.swipe = function(direction){
		console.log(this, "direction=> ", direction);
		var add_new_tile = false, loop_move = true, loop_merge = false;

		if(direction){
			//move
			add_new_tile = myGame.move_tiles(direction);

			//merge
			loop_merge = myGame.merge_tiles(direction);
			
			//if there was a merge, move tiles again
			if(loop_merge){
				add_new_tile = true;
				console.log('%c MOVE TILES AGAIN', 'color: red;');
				myGame.move_tiles(direction);
			}
		}
		else{
			// check if there are mergable tiles
			if(!myGame.are_there_mergable_tiles()){
				alert("Game Over!");
			}

			return false;
		}

		if(!$('.square.empty').length){
			//check if anything is movable or mergable without moving or merging OH BOY
			myGame.swipe();
		}

		add_new_tile ? myGame.add_new_tile() : "" ;
	}

	Game.prototype.are_there_mergable_tiles = function(){
		console.log('%c inside are_there_mergable_tiles', 'background-color: violet;');
		var are_there_mergable_tiles = false;
		var $tiles = $('.tile');
		var current_direction = "up";

		function check_tiles(direction){
			console.log("CHECK TILES=> ", direction);
			$tiles.each(function(){
				console.log(456, current_direction);
				var mergable = false;
				var x = parseInt($(this).attr('data-x'));
				var y = parseInt($(this).attr('data-y'));
				var tile_id = $(this).attr('id');

				if(direction == 'up'){
					if(y>1){
						mergable = true;
						// y = y-1;
					}
				}
				else if(direction == 'left'){
					if(x>1){
						mergable = true;
						// x = x-1;
					}
					
				}

				if(mergable){

					console.log("CHECK==> should_i_merge ", myGame.should_i_merge(tile_id, direction, true));

					if(myGame.should_i_merge(tile_id, direction, true)){
						are_there_mergable_tiles = true;
						return false;
					}
				}
			});

			if(direction == "up" && !are_there_mergable_tiles){
				console.log(234, current_direction);
				current_direction = "left";
				check_tiles(current_direction);
			}

		}

		if(current_direction == "up" && !are_there_mergable_tiles){
				console.log(123, current_direction);
			check_tiles(current_direction);
		}
		
		// console.log("are_there_mergable_tiles?", are_there_mergable_tiles);
		return are_there_mergable_tiles;
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

		var tile_value = this.square_values[Math.floor(Math.random() * 2)];
		
		var $tile = $("<div id='tile_"+Math.ceil(Date.now() / 1000)*index+"' class='tile' data-x='0' data-y='0' data-merged='0' data-value='"+tile_value+"'>"+tile_value+"</div>");
		$($squares[index]).html($tile);

		$tile.attr('data-x', $tile.parent().attr('data-col'));
		$tile.attr('data-y', $tile.parent().attr('data-row'));
		// $squares[rand_square].innerHTML = this.square_values[Math.floor(Math.random() * 2)];

		this.toggle_tiled_squares();
	}
	
	$('#new_game').click(function(){
		myGame = new Game;
	});

	$('.swipe').click(function(){
		myGame.swipe($(this).attr('data-direction'));
	});

	$(document).keydown(function(e) {
		var direction;
	    if(e.keyCode == 37){direction = "left";}
	    if(e.keyCode == 38){direction = "up";}
	    if(e.keyCode == 39){direction = "right"};
	    if(e.keyCode == 40){direction = "down";}
		
		myGame.swipe(direction);
	});

});
</script>
</body>
</html>