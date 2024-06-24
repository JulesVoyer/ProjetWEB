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
    </head>
    <!-- **** F I N **** H E A D **** -->


    <!-- **** B O D Y **** -->
    <body id="messageBody">
        <br><br><br><br>

        <div id="titlePage">Nom du trajet</div>
        <a id="lienDetailTrajet" href="">
            <p>...<br></p>
        </a>
        <div id="conversation">
            <p class="heureRecu">11:40 - user1</p>
            <p class="messageRecu">Salut !</p>
            <p class="heureEnvoye">12:00 - moi</p>
            <p class="messageEnvoye">Salut à tous, rdv devant Centrale demain à 8:50.</p>
            <p class="rejointQuitte">user2 a rejoint le trajet</p>
            <p class="heureRecu">12:05 - user2</p>
            <p class="messageRecu">Salut ! On va bien à l'IG2I ?</p>
            
            <form action="controleur.php">
                <input type="text" name="contenuMessage" id="contenu">
                <input type="submit" value="Envoyer" name="envoyerMessage">
            </form>
        </div>
    </body>
</html>
