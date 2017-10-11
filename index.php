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

			<p>
				<label id="result" style="color:#f39"></label>
			</p>
			
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

	    $('#repartir').click(function() {
	    	getHand(function(data) {
		        
		        console.log(data);

		        var hand1 = data.slice(0, 5);
		        var hand2 = data.slice(5, 10);
		        console.log(hand1);
		        console.log(hand2);

		        // Mostrar manos de poker a cada jugador
		        populateTable(hand1, "player1");
		        populateTable(hand2, "player2");

		        var ranking1 = validateHand(hand1);
		        console.log(ranking1);

		        var ranking2 = validateHand(hand2);
		        console.log(ranking2);

		        handWins(ranking1, ranking2);
		        
		        
		    });
	        return false;
	    });

	    /*
	    $('#repartir').click(function() {
	    	//Validar mano

		        //var shand1='[{"number":"2","suit":"clubs"},{"number":"2","suit":"hearts"},{"number":"3","suit":"hearts"},{"number":"3","suit":"spades"},{"number":"3","suit":"clubs"}]';
		        //var shand2='[{"number":"2","suit":"clubs"},{"number":"2","suit":"hearts"},{"number":"3","suit":"hearts"},{"number":"3","suit":"spades"},{"number":"3","suit":"clubs"}]';
		        var sdata = '[{"number":"A","suit":"spades"},{"number":"9","suit":"spades"},{"number":"10","suit":"hearts"},{"number":"Q","suit":"hearts"},{"number":"3","suit":"diamonds"},{"number":"10","suit":"spades"},{"number":"A","suit":"diamonds"},{"number":"A","suit":"clubs"},{"number":"4","suit":"clubs"},{"number":"8","suit":"spades"}]';
		        
		        var data = JSON.parse(sdata);
		        console.log(data);

		        //var hand2 = JSON.parse(shand2);
		        //console.log(hand2);

		        var hand1 = data.slice(0, 5);
		        var hand2 = data.slice(5, 10);
		        console.log(hand1);
		        console.log(hand2);

		        populateTable(hand1, "player1");
		        populateTable(hand2, "player2");

		        var ranking1 = validateHand(hand1);
		        console.log(ranking1);

		        var ranking2 = validateHand(hand2);
		        console.log(ranking2);

		        handWins(ranking1, ranking2);

	        return false;
	    });*/
	    
	});

	// Obtenemos la baraja
	function getDeck(callback) {
		$.ajax({
	    	type : 'POST',
	        url: 'https://services.comparaonline.com/dealer/deck',
	        statusCode: {
	        	500: function() {
	        		alert("Ha ocurrido un error de comunicación, por favor vuelva a intentarlo.");
	        	},
	        	502: function() {
	        		alert("El servidor puede estar saturado, por favor vuelva a intentarlo.");
	        	}
	        },
	        success: function (token) {
	            callback(token);
	        },
	        error: function (resp) {
	        	//alert("Intente de nuevo");
	        }
	    });
	}

	// Obtenemos las manos
	function getHand(callback) {
		var token = $("#token").val();
		$.ajax({
	    	type : 'GET',
	        url: 'https://services.comparaonline.com/dealer/deck/' + token + '/deal/10',
	        statusCode: {
	        	500: function() {
	        		alert("Ha ocurrido un error de comunicación, por favor vuelva a intentarlo.");
	        	},
	        	502: function() {
	        		alert("El servidor puede estar saturado, por favor vuelva a intentarlo.");
	        	},
	        	404: function() {
	        		alert("Ups! Necesitas barajar el mazo.");
	        	}
	        },
	        success: function (hand) {
	            callback(hand);
	        },
	        error: function (resp) {
	        	//alert("Intente de nuevo");
	        	//console.log(resp);
	        	if (resp.status == 0) {
	        		alert('El servidor puede estar saturado, por favor vuelva a intentarlo.');
	        	}
	        }
	    });
	}

	function populateTable(data, nameTable) {
		$('#'+nameTable+' tr').empty();
		$('#'+nameTable+' tr').not(':first').not(':last').remove();
		var html = '';
		for(var i = 0; i < data.length; i++)
		            html += '<tr><td>' + data[i].number + '-' + data[i].suit + '</td><td>';
		$('#'+nameTable+' tr').first().after(html);
	}

	/*function pokerHand(){
		var ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
		var suits = ['hearts', 'diamonds', 'clubs', 'spades'];
	}*/

	// Mano ganadora
	function handWins(valueHand1, valueHand2) {
		var result = "";
		if (valueHand1 > valueHand2) {
			console.log("Hand 1 wins");
			console.log(valueHand1);
			switch(valueHand1){
				case 1:
				result = "Jugador 1 gana con 'One Pair'";
				break;
				case 2:
				result = "Jugador 1 gana con 'Two Pairs'";
				break;
				case 3:
				result = "Jugador 1 gana con 'Three of a Kind'";
				break;
				case 4:
				result = "Jugador 1 gana con 'Straight'";
				break;
				case 5:
				result = "Jugador 1 gana con 'Flush'";
				break;
				case 6:
				result = "Jugador 1 gana con 'Full House'";
				break;
				case 7:
				result = "Jugador 1 gana con 'Four of a Kind'";
				break;
				case 8:
				result = "Jugador 1 gana con 'Straight Flush'";
				break;
				case 9:
				result = "Jugador 1 gana con 'Royal Flush'";
				break;
				/*default:
        			console.log("Something went horribly wrong...");*/
			}
			console.log(result);
			$("#result").text(result);
		} else if (valueHand1 < valueHand2) {
			console.log("Hand 2 wins");
			switch(valueHand2){
				case 1:
				result = "Jugador 2 gana con 'One Pair'";
				break;
				case 2:
				result = "Jugador 2 gana con 'Two Pairs'";
				break;
				case 3:
				result = "Jugador 2 gana con 'Three of a Kind'";
				break;
				case 4:
				result = "Jugador 2 gana con 'Straight'";
				break;
				case 5:
				result = "Jugador 2 gana con 'Flush'";
				break;
				case 6:
				result = "Jugador 2 gana con 'Full House'";
				break;
				case 7:
				result = "Jugador 2 gana con 'Four of a Kind'";
				break;
				case 8:
				result = "Jugador 2 gana con 'Straight Flush'";
				break;
				case 9:
				result = "Jugador 2 gana con 'Royal Flush'";
				break;
			}
			console.log(result);
			$("#result").text(result);
		} else {
			// validar High card
			console.log("It's a tie");
			//alert("ES UN EMPATE");
			$("#result").text("Es un empate");
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
