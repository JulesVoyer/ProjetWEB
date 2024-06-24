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
            
            $(document).ready( function () {

                $("#sguCB").click( function () {
                    if ($(this).is(":checked")) {
                        $("#sguBG").css("filter", "blur(3px)");
                        $("#sguBG").css("-webkit-filter", "blur(3px)");
                        $("#sguPopupCont").show();
                    }
                } ); // fin click CB

                $("#sguPasser").click( function () {
                    $("#sguBG").css("filter", "blur(0)");
                    $("#sguBG").css("-webkit-filter", "blur(0)");
                    $("#sguPopupCont").hide();
                } ); // fin click Passer

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
                        <input class="sguInput" type="text" name="prenom" placeholder="Prénom..." />
                        <input class="sguInput" type="text" name="nom" placeholder="Nom..." />
                        <input class="sguInput" type="text" name="pseudo" placeholder="Pseudo..." />
                        <input class="sguInput" type="password" name="passe" placeholder="Mot de passe..." />
                        <input class="sguInput" type="password" name="passeConfirm" placeholder="Confirmer le mot de passe..." />
                        <div id="sguLicence">
                            <label for="sguCB">Possédez-vous le permis ?</label>
                            <input id="sguCB" type="checkbox" name="licence" />
                        </div>
                    </div>

                    <div id="sguFormAdress">
                        <p>Adresse :</p>
                        <input class="sguInput" type="text" name="streetNumber" placeholder="Numéro de rue..." />
                        <input class="sguInput" type="text" name="street" placeholder="Nom de rue..." />
                        <input class="sguInput" type="text" name="postCode" placeholder="Code postal..." />
                        <input class="sguInput" type="text" name="city" placeholder="Ville..." />
                        <div>
                            <input id="sguSubmit" class="btn" type="submit" name="login" value="S'inscrire" />   
                            <a href="index.php?view=login">Se connecter</a>
                        </div>
                    </div>                

                </form>

                <img id="sguLogo" src="ressources/ec-lille-rect.png" alt="Logo Centrale" />

            </div>
        </div>

        <div class="popup" id="sguPopupCont">
            <div id="sguPopup">
                <h3>Déclarer un véhicule :</h3>
                <form>
                    <input class="popupInput" type="text" name="model" placeholder="Modèle..." />
                    <input class="popupInput" type="text" name="color" placeholder="Couleur..." />
                    <input class="popupInput" type="text" name="nbPlaces" placeholder="Nombre de places..." />
                    <input class="popupInput" type="text" name="matriculation" placeholder="Immatriculation..." />
                    <div class="popupButtons">
                        <input id="sguPasser" class="btn" type="button" name="passer" value="Passer" />   
                        <input id="sguValider" class="btn" type="submit" name="valider" value="Valider" /> 
                    </div>  
                </form>
            </div>
        </div>
        
    </body>
</html>
