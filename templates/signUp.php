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
    </head>
    <!-- **** F I N **** H E A D **** -->


    <!-- **** B O D Y **** -->
    <body id="sguBody">

        <div id="sguCont">
            <h1 id=sguTitle>Covoit'Campus</h1>
            <hr />
            Renseignez vos informations : 
            <?php
                mkForm("controleur.php","POST");
                    mkInput("text", "nom");
                    mkInput("text", "prenom");
                    mkInput("text", "pseudo");
                    mkInput("password", "passe1");
                    mkInput("password", "passe2");

                endForm();
            ?>
            <form id="sguForm" action="controleur.php" methode="post">
                <input class="sguInput" type="text" name="pseudo" placeholder="Pseudo..." />
                <input class="sguInput" type="password" name="passe" placeholder="Mot de passe..." />
                <input id="sguSubmit" type="submit" name="login" value="Se connecter" />
            </form>

            <div>Vous avez déjà un compte ?</div>
            <div id="sguSignUp">
                <img src="ressources/examen.png" alt="Icon inscription" />
                <a href="templates/signUp.php">Se connecter !</a>
            </div>

            <img id="sguLogo" src="ressources/ec-lille.png" alt="Logo Centrale" />
        </div>
        
    </body>
</html>