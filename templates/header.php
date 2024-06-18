<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// On envoie l'entête Content-type correcte avec le bon charset
header('Content-Type: text/html;charset=utf-8');

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!-- **** H E A D **** -->
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
	<title>Covoit'Campus</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">

	<script src="js/jquery-3.4.1.min.js"></script>

	<script>
		
		$(document).ready( function() {

			currentIcon();

			$(window).resize(function() {
				currentIcon();
			})

		} ) // fin ready

		function currentIcon () {
			// la variable view récupérée dans la page index.php
			// et donc accessible ici
			// est écrite comme l'id du lien qui lui est associé
			// on récupère donc cette variable pour mettre en surbrillance
			// l'icon associé à la vue sélectionnée
			var view = <?php echo json_encode($view); ?>;
			
			$("#banner a").each(function() { 

				if ($(this).attr("id") === view) { 

					if (window.matchMedia('(max-width:550px)').matches) {
						$(this).css({
								"background-color": "rgba(255, 255, 255, 0.7)",
								"text-shadow": "none"
							})
					} else {
						$(this).css({ 
								"color": "black",
								"background-color": "rgba(255, 255, 255, 0.7)",
								"text-shadow": "none"
							}
						);
					}
				}
			} );
		}

	</script>

</head>
<!-- **** F I N **** H E A D **** -->


<!-- **** B O D Y **** -->
<body>

	<div id="banner">

		<a href="index.php?view=accueil" id="accueil">Accueil</a>
		<a href="index.php?view=trajets" id="trajets">Trajets</a>
		<a href="index.php?view=conversations" id="conversations">Conversations</a>
		<a href="index.php?view=historique" id="historique">Historique</a>
		<a href="index.php?view=profil" id="profil">Profil</a>

	</div>