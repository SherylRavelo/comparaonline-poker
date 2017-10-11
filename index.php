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
	<script type="text/javascript" src="js/jquery-2.1.4.js"></script>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1>Poker Compara Online</h1>
		</div>
		<div id="content">
			<p>
				<input type="button" id="barajar" value="Barajar">
			</p>
			<p>
				<input type="button" id="repartir" value="Repartir">
			</p>

			<input type="hidden" name="token" id="token">


			<!--<h2>Mesa</h2>
			<table>
				<tbody>
					<tr>
						<td>Carta 1</td>
						<td>Carta 2</td>
						<td>Carta 3</td>
						<td>Carta 4</td>
						<td>Carta 5</td>
					</tr>
				</tbody>
			</table>-->

			<table>
				<thead>
					<tr>
						<th>Jugador 1</th>
						<th>Jugador 2</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Cel 1,1</td>
						<td>Cel 1,2</td>
					</tr>
					<tr>
						<td>Cel 2,1</td>
						<td>Cel 2,2</td>
					</tr>
					<tr>
						<td>Cel 3,1</td>
						<td>Cel 3,2</td>
					</tr>
					<tr>
						<td>Cel 4,1</td>
						<td>Cel 4,2</td>
					</tr>
					<tr>
						<td>Cel 5,1</td>
						<td>Cel 5,2</td>
					</tr>
				</tbody>
			</table>


			
		</div>
		<div id="footer">
			Copyright 2017 Sheryl Ravelo
		</div>
	</div>
	
<script type="text/javascript">
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
		        
		        

		        //Validar mano

		        var resp = onePair(hand);
		        if (resp) {
		        	console.log("Par");
		        } else {
		        	console.log("No hay par");
		        }

		        hand='[{"number":"2","suit":"hearts"},{"number":"J","suit":"clubs"},{"number":"5","suit":"spades"},{"number":"5","suit":"hearts"},{"number":"2","suit":"spades"}]';
		        console.log(hand);

		        var resp2 = twoPair(hand);
		        if (resp2) {
		        	console.log("Dos pares");
		        } else {
		        	console.log("No hay dos pares");
		        }

		        var resp3 = threeOfAKind(hand);
		        if (resp3) {
		        	console.log("Trío");
		        } else {
		        	console.log("No hay trío");
		        }
		        
		        
		    });
	        return false;
	    });*/

	    $('#repartir').click(function() {
	    	//Validar mano

		        /*var resp = onePair(hand);
		        if (resp) {
		        	console.log("Par");
		        } else {
		        	console.log("No hay par");
		        }*/

		        var shand='[{"number":"2","suit":"hearts"},{"number":"4","suit":"clubs"},{"number":"3","suit":"spades"},{"number":"5","suit":"hearts"},{"number":"6","suit":"spades"}]';
		        
		        var hand = JSON.parse(shand);
		        console.log(hand);

		        var resp2 = twoPair(hand);
		        if (resp2) {
		        	console.log("Dos pares");
		        } else {
		        	console.log("No hay dos pares");
		        }

		        var resp3 = threeOfAKind(hand);
		        if (resp3) {
		        	console.log("Trío");
		        } else {
		        	console.log("No hay trío");
		        }

		        var resp4 = straight(hand);
		        if (resp4) {
		        	console.log("Escalera");
		        } else {
		        	console.log("No hay escalera");
		        }
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

	/*$(function() {
	    $('#repartir').click(function() {
	    	getToken(function(hand) {
		        //processing the data
		        console.log(hand);
		        
		    });

	        return false;
	    });
	});

	function getToken(callback) {
	    var data;
	    $.ajax({
	    	type : 'POST',
	        url: 'https://services.comparaonline.com/dealer/deck',
	        success: function (token) {
	            console.log(token);
	            $.ajax({
			        type : 'GET',
			        url  : 'https://services.comparaonline.com/dealer/deck/' + token + '/deal/5',
			        success: function (resp) {
			        	data = resp;
			        	callback(data);
			        }
			    });
	        },
	        error: function () {}
	    }); 
	}*/

	function pokerHand(){
		var ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
		var suits = ['hearts', 'diamonds', 'clubs', 'spades'];
	}

	// Mano ganadora
	function handWins(hand1, hand2) {


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
	    console.log("lowest: "+lowest);
	    var handStraight = getHandStraight(hand);

	     for(var i = 1; i < 5; i++){
	          if(occurrencesOf(lowest + i, handStraight) != 1){
	               return false
	          }     
	     }
	     return true;
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
	          console.log('index: ' + index);
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
	     for(var i = 0; i < 5; i ++){
	          arrayHand[i] = hand[i].number % 13;
	          //suitsArray[i] = Math.floor(hand[i] / 13);     
	     }
	     console.log(arrayHand);
	     return arrayHand;
	}

	function flush(hand) {

	}

	function fullHouse(hand) {

	}

	function fourOfAKind(hand) {

	}

	function straightFlush(hand) {

	}

	function royalFlush(hand) {

	}
</script>
</body>
</html>
