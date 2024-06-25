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

			// traitement des icons du header
			currentIcon();

			$(window).resize(function() {
				currentIcon();
			})
			// fin traitement des icons du header


			// traitement du profil

			// traitement popups profil

			// popup déconnexion
			$("#pflDecoBtn").click( function () {
				$("#pflBody").css("filter", "blur(3px)");
				$("#pflBody").css("-webkit-filter", "blur(3px)");
				$("#pflPopupDecoCont").show();
			} ); // fin click Se déconnecter

			$(".pflAnnuler").click( function () {
				$("#pflBody").css("filter", "blur(0)");
				$("#pflBody").css("-webkit-filter", "blur(0)");
				$("#pflPopupDecoCont").hide();
				$("#pflPopupEditionPerso").hide();
				$("#pflPopupEditionVoit").hide();
			} ); // fin click Annuler
			// fin popup déconnexion


			var selected = 1; // vaut 1 si on modifie les infos perso, 2 si on modifie les véhicules
			
			// afficher popup édition des informations personnelles ou voitures
			$("#pflEditer").click( function () {
				$("#pflBody").css("filter", "blur(3px)");
				$("#pflBody").css("-webkit-filter", "blur(3px)");
				if (selected == 1) {
					/* Mettre les valeurs d'origine dans les champs d'entrée texte */
					console.log($("#pflPrenom").html());
					$("#newPre").val($("#pflPrenom").html());
					console.log($("#newPre").val());
					$("#newNom").val($("#pflNom").html());
					$("#newPseu").val($("#pflPseudo").html());
					$("#newNum").val($("#pflNum").html());
					$("#newNomRue").val($("#pflNomRue").html());
					$("#newCode").val($("#pflCode").html());
					$("#newCity").val($("#pflVille").html());

					/* afficher le popup */
					$("#pflPopupEditionPerso").show();
				}
				else $("#pflPopupEditionVoit").show();
			} );
			// fin afficher popup édition des informations personnelles

			// popup édition informations personnelles
			$("#cbMDP").click( function () {
				if ($(this).is(":checked")) $(".editMDP").show();
				else $(".editMDP").hide();
				
			} );


			// fin popup édition informations personnelles

			// fermer tous les popups avec esc
			$(document).keydown( function (contexte) {
				if (contexte.which == 27) {
					$("#pflBody").css("filter", "blur(0)");
					$("#pflBody").css("-webkit-filter", "blur(0)");
					$(".popup").hide();
					}
			} ); // fin fermer popups

			// fin traitement popups profil

			// changement de rubriques
			if ($("#pflLicence").html() == "Oui") {
				$("#pflVehicules").click( function () {
					selected = 2;
					$("#pflVoiture").show();
					$("#pflPerso").hide();
					$("#pflAPropos").css("background-color", "rgba(128, 128, 128, 0.5)");
					$("#pflVehicules").css("background-color", "transparent");
				} );
			}

			$("#pflAPropos").click( function () {
				selected = 1;
				$("#pflVoiture").hide();
				$("#pflPerso").show();
				$("#pflVehicules").css("background-color", "rgba(128, 128, 128, 0.5)");
				$("#pflAPropos").css("background-color", "transparent");
		} );
			// fin changement des rubriques

			// fin traitement du profil


		} ); // fin ready


		// Traite les icons du header
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
		} // fin icons header

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