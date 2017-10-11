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
	}

	function PokerHand(){
		var ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king', 'ace'];
		var suits = ['hearts', 'diamonds', 'clubs', 'spades'];
	}
</script>
</body>
</html>
