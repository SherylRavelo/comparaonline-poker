<?php
/**
 * @copyright     Copyright (c) Sheryl Ravelo
 * @link          https://github.com/SherylRavelo/comparaonline-poker.git
 */

?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>	POKER </title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/custom.css">

	<script type="text/javascript" src="js/jquery-2.1.4.js"></script>	
	<script type="text/javascript" src="js/bootstrap/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Poker Compara Online</h1>
		</div>
		<div class="content">
			<p>
				<input type="button" class="btn btn-lg" id="barajar" value="Barajar">
			</p>
			<p>
				<input type="button" class="btn btn-lg" id="repartir" value="Repartir">
			</p>

			<input type="hidden" name="token" id="token">

			<!--<table id="player1" class="table">
				<thead>
					<tr>
						<th>Jugador 1</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>

			<table id="player2" class="table">
				<thead>
					<tr>
						<th>Jugador 2</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
					</tr>
				</tbody>
			</table>-->

			<table id="players" class="table">
				<thead>
					<tr>
						<th>Jugador 1</th>
						<th>Jugador 2</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<table id="player1">
								<tr>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
						<td>
							<table id="player2" >
								<tr>
									<td></td>
									<td></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>


			
		</div>
		
	</div>
	<div class="footer">
		<div class="container">
			Copyright 2017 Sheryl Ravelo
		</div>
	</div>
	
<script type="text/javascript">
	var textHand = "";
	var fullOnePair = "";
	var fullThreeOfAKind = "";
	$(function() {	

	    $('#barajar').click(function() {
	    	getDeck(function(token) {
		        // set token en hidden
		        $("#token").val(token);
		        console.log(token);		        
		    });
	        return false;
	    });

	    /*$('#repartir').click(function() {
	    	getHand(function(hand) {
		        
		        console.log(hand);

		        populateTable(hand);

		        var ranking = validateHand(hand);
		        console.log(ranking);
		        
		        
		    });
	        return false;
	    });*/

	    $('#repartir').click(function() {
	    	//Validar mano

		        var shand1='[{"number":"2","suit":"clubs"},{"number":"2","suit":"hearts"},{"number":"3","suit":"hearts"},{"number":"3","suit":"spades"},{"number":"3","suit":"clubs"}]';
		        var shand2='[{"number":"2","suit":"clubs"},{"number":"2","suit":"hearts"},{"number":"3","suit":"hearts"},{"number":"3","suit":"spades"},{"number":"3","suit":"clubs"}]';
		        
		        var hand1 = JSON.parse(shand1);
		        console.log(hand1);

		        var hand2 = JSON.parse(shand2);
		        console.log(hand2);

		        populateTable(hand1, "player1");
		        populateTable(hand1, "player2");

		        var ranking1 = validateHand(hand1);
		        console.log(ranking1);

		        var ranking2 = validateHand(hand2);
		        console.log(ranking2);

		        handWins(ranking1, ranking2);

	        return false;
	    });
	    
	});

	// Obtenemos la baraja
	function getDeck(callback) {
		$.ajax({
	    	type : 'POST',
	        url: 'https://services.comparaonline.com/dealer/deck',
	        success: function (token) {
	            callback(token);
	        },
	        error: function (resp) {
	        	alert("Intente de nuevo");
	        }
	    });
	}

	// Obtenemos las manos
	function getHand(callback) {
		var token = $("#token").val();
		$.ajax({
	    	type : 'GET',
	        url: 'https://services.comparaonline.com/dealer/deck/' + token + '/deal/5',
	        success: function (hand) {
	            callback(hand);
	        },
	        error: function (resp) {
	        	alert("Intente de nuevo");
	        }
	    });
	}

	function populateTable(data, nameTable) {
		$('#'+nameTable+' tr').not(':first').not(':last').remove();
		var html = '';
		for(var i = 0; i < data.length; i++)
		            html += '<tr><td>' + data[i].number + '-' + data[i].suit + '</td><td>';
		$('#'+nameTable+' tr').first().after(html);
	}

	function pokerHand(){
		var ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
		var suits = ['hearts', 'diamonds', 'clubs', 'spades'];
	}

	// Mano ganadora
	function handWins(valueHand1, valueHand2) {
		if (valueHand1 > valueHand2) {
			console.log("Hand 1 wins");
		} else if (valueHand1 < valueHand2) {
			console.log("Hand 1 wins");
		} else {
			// validar High card
			console.log("It's a tie");
		}
	}

	function validateHand(hand) {
		var valueHand = 0;
		if (highCard(hand)){
			valueHand = 0;
		}

		if (fourOfAKind(hand)){
			valueHand = 7;
		} else if (threeOfAKind(hand)){
			valueHand = 3;
		} else if (twoPair(hand)) {
			valueHand = 2;
		} else if (onePair(hand)) {
			valueHand = 1;
		}

		if (straight(hand)){
			valueHand = 4;
		}
		if (flush(hand)){
			valueHand = 5;
		}
		if (fullHouse(hand)){
			valueHand = 6;
		}
		
		if (straightFlush(hand)){
			valueHand = 8;
		}
		if (royalFlush(hand)){
			valueHand = 9;
		}
		return valueHand;
	}

	function highCard(hand) {

	}

	function onePair(hand) {
		var card;
		var result = "";

		for(var i = 0; i < hand.length; i++) {
		    var cardTemp = hand[i];

		    for (var j = i+1; j < hand.length; j++) {
		    	card = hand[j];
		    	
		    	if (cardTemp.number == card.number) {		    		
		    		result = "One pair: " + card.number + "-" + card.suit + " / " + cardTemp.number + "-" + cardTemp.suit;
		    		console.log("result: " + result);

		    		// set number for validate result full house
		    		fullOnePair = card.number;

		    		return true;
		    	}
		    }
		}

        return false;
	}

	function twoPair(hand) {
		var card;
		var cont = 0;
		var result = "Two pair: ";

		for(var i = 0; i < hand.length; i++) {
		    var cardTemp = hand[i];

		    for (var j = i+1; j < hand.length; j++) {
		    	card = hand[j];
		    	
		    	if (cardTemp.number == card.number) {
		    		cont = cont + 1;
		    		result = result + "(" + cont + ") " + card.number + "-" + card.suit + " / " + cardTemp.number + "-" + cardTemp.suit + "  ";
		    		
		    		if (cont == 2) {
		    			console.log("result: " + result);
						return true;
					}
		    	}
		    }
		}

        return false;	
	}

	function threeOfAKind(hand) {
		var card;
		var cont = 0;
		var result = "";		

		for(var i = 0; i < hand.length; i++) {
		    var cardTemp = hand[i];
		    result = "three Of A Kind: " + cardTemp.number + "-" + cardTemp.suit + "; ";
		    cont = 0;

		    for (var j = i+1; j < hand.length; j++) {
		    	card = hand[j];
		    	
		    	if (cardTemp.number == card.number) {
		    		cont = cont + 1;
		    		result = result + card.number + "-" + card.suit + "; ";

		    		if (cont == 2) {		
		    			// set number for validate result full house
		    			fullThreeOfAKind = card.number;   

						console.log(result);
						return true;
					}		    		
		    	}
		    }
		}
        return false;
	}

	function straight(hand) {
		var lowest = getLowest(hand);
	    var handStraight = getHandStraight(hand);

	     for(var i = 1; i < 5; i++){
	          if(occurrencesOf(lowest + i, handStraight) != 1){
	               return false
	          }     
	     }
	     return true;
	}

	function flush(hand) {
		for(var i = 0; i < hand.length - 1; i ++){
			if(hand[i].suit != hand[i+1].suit){
            	return false;
            }
        }
        return true;
	}

	function fullHouse(hand) {
		if (fullOnePair && fullThreeOfAKind) {
			if (fullOnePair != fullThreeOfAKind)
			return true;
		}
		return false;
	}

	function fourOfAKind(hand) {
		var card;
		var cont = 0;
		var result = "";		

		for(var i = 0; i < hand.length; i++) {
		    var cardTemp = hand[i];
		    result = "Four of a Kind: " + cardTemp.number + "-" + cardTemp.suit + "; ";
		    cont = 0;

		    for (var j = i+1; j < hand.length; j++) {
		    	card = hand[j];
		    	
		    	if (cardTemp.number == card.number) {
		    		cont = cont + 1;
		    		result = result + card.number + "-" + card.suit + "; ";

		    		if (cont == 3) {
						console.log(result);
						return true;
					}		    		
		    	}
		    }
		}
        return false;
	}

	function straightFlush(hand) {
		if (flush(hand) && straight(hand)) {
			return true;
		}
		return false;
	}

	function royalFlush(hand) {

	}

	// Obtener el menor número de la escalera
	function getLowest(hand){
	     var min = 12;
	     for(var i = 0; i < hand.length; i++){
	          min = Math.min(min, hand[i].number);     
	     }
	     return min;     
	} 

	// Verificar que existe ocurrencia
	function occurrencesOf(n, hand){
	     var count = 0;
	     var index = 0;   
	     do{          
	          index = hand.indexOf(n, index) + 1;
	          if(index == 0){
	               break;
	          }
	          else{
	               count ++;
	          }
	     } while(index < hand.length);
	     return count;
	}

	// Obtener array números de la mano
	function getHandStraight(hand){
		var arrayHand = [];
	     for(var i = 0; i < hand.length; i ++){
	          arrayHand[i] = hand[i].number % 13;
	          //suitsArray[i] = Math.floor(hand[i] / 13);     
	     }
	     return arrayHand;
	}

	// set array de resultados
	function setResult(text, number, suit="") {
		var result = [3];
		result[0] = text;
		result[1] = number;
		result[2] = suit;

		return result;
	}
</script>
</body>
</html>
