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
    <body id="lgiBody">

        <div id="lgiCont">
            <h1 id=lgiTitle>Covoit'Campus</h1>
            <hr />

            <form id="lgiForm" action="controleur.php" methode="post">
                <input class="lgiInput" type="text" name="pseudo" placeholder="Pseudo..." />
                <input class="lgiInput" type="password" name="passe" placeholder="Mot de passe..." />
                <input id="lgiSubmit" type="submit" name="action" value="connexion" />
            </form>

            <div>Vous n'avez pas encore de compte ?</div>
            <div id="lgiSignUp">
                <img src="ressources/examen.png" alt="Icon inscription" />
                <a href="index.php?view=signUp">INSCRIVEZ VOUS !</a>
            </div>

            <img id="lgiLogo" src="ressources/ec-lille.png" alt="Logo Centrale" />
        </div>
        
    </body>
</html>
