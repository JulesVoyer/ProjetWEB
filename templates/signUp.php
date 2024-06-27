<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

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
            
            $(document).ready( function () {

                $("#sguCB").click( function () {
                    if ($(this).is(":checked")) {
                        $("#sguFormStandard").css("filter", "blur(3px)");
                        $("#sguFormStandard").css("-webkit-filter", "blur(3px)");
                        $("#sguFormAdress").css("filter", "blur(3px)");
                        $("#sguFormAdress").css("-webkit-filter", "blur(3px)");

                        $("#sguPopupCont").show();
                    }
                } ); // fin click CB

                $("#sguPasser").click( function () {
                    $("#sgPopup input[type = text]").empty()
                    $("#sguFormStandard").css("filter", "blur(0)");
                    $("#sguFormStandard").css("-webkit-filter", "blur(0)");
                    $("#sguFormAdress").css("filter", "blur(0)");
                    $("#sguFormAdress").css("-webkit-filter", "blur(0)");
                    $("#sguPopupCont").hide();
                } ); // fin click Passer

                $("#sguValider").click(
                    function(){
                        $("#sguFormStandard").css("filter", "blur(0)");
                        $("#sguFormStandard").css("-webkit-filter", "blur(0)");
                        $("#sguFormAdress").css("filter", "blur(0)");
                        $("#sguFormAdress").css("-webkit-filter", "blur(0)");
                        $("#sguPopupCont").hide();
                    }
                )
                // fermer popup avec esc
                $(document).keydown( function (contexte) {
                    if (contexte.which == 27) {
                        $("#sguBG").css("filter", "blur(0)");
                        $("#sguBG").css("-webkit-filter", "blur(0)");
                        $("#sguPopupCont").hide();
                        }
                } ); // fin fermer popup

            } ); // fin ready
        </script>

    </head>
    <!-- **** F I N **** H E A D **** -->


    <!-- **** B O D Y **** -->
    <body>

        <div id="sguBG">

            <div id="sguCont">
                <h1 id=sguTitle>Créer un compte</h1>
                <hr />

                <form id="sguForm" action="controleur.php" methode="post">

                    <div id="sguFormStandard"> 
                        <input class="sguInput" type="text" name="display_name" placeholder="Nom d'affichage..." />
                        <input class="sguInput" type="text" name="username" placeholder="Identifiant..." />
                        <input class="sguInput" type="password" name="password" placeholder="Mot de passe..." />
                        <input class="sguInput" type="password" name="password_confirmation" placeholder="Confirmer le mot de passe..." />
                        <div id="sguLicence">
                            <label for="sguCB">Possédez-vous le permis ?</label>
                            <input id="sguCB" type="checkbox" name="driving_license" value = "1" />
                        </div>
                    </div>

                    <div id="sguFormAdress">
                        <p>Adresse :</p>
                        <input class="sguInput" type="text" name="street_number" placeholder="Numéro de rue..." />
                        <input class="sguInput" type="text" name="street" placeholder="Nom de rue..." />
                        <input class="sguInput" type="text" name="city_code" placeholder="Code postal..." />
                        <input class="sguInput" type="text" name="city" placeholder="Ville..." />
                        <div>
                            <input id="sguSubmit" class="btn" type="submit" name="action" value="Créer le compte" />   
                            <a href="index.php?view=login">Se connecter</a>
                        </div>
                    </div>                

                    
                    <div class="popup" id="sguPopupCont">
                        <div id="sguPopup">
                            <h2>Déclarer un véhicule :</h2>
                                <input class="popupInput" type="text" name="vehicle_name" placeholder="Nom du véhicule..." />
                                <input class="popupInput" type="text" name="vehicle_nb_seats" placeholder="Nombre de places... " />
                                <input class="popupInput" type="text" name="model" placeholder="Modèle... (optionnel)" />
                                <input class="popupInput" type="text" name="code" placeholder="Immatriculation... (optionnel)" />
                                <div class="popupButtons">
                                    <input id="sguPasser" class="btn" type="button" name="passer" value="Passer" />   
                                    <input id="sguValider" class="btn" type="button" name="valider" value="Valider" /> 
                                </div>  
                        </div>
                    </div>
                </form>

                <img id="sguLogo" src="ressources/ec-lille-rect.png" alt="Logo Centrale" />

            </div>
        </div>
    </body>
</html>
