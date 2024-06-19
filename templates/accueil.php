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
    <body id="aclBody">
    <br><br><br><br>
    <div>Bienvenue pseudo</div>
    barre
    <div>Fatigué de marcher ? </div>
    <div>Monte à bord !</div>
    <div>Bienvenue sur Covoit’Campus, la plateforme de covoiturage qui transforme tes trajets inter-campus en véritables moments de convivialité.</div>
    <div>Fini les longues marches et les bus surchargés !</div>
    <div>Trouve des compagnons de route agréables et fais de chaque déplacement une expérience plaisante et divertissante.</div>
    <div>Trajets</div>
    <div>Tu peux rejoindre un trajet dans l’onglet “ trajets ”.</div>
    <div>Si aucun trajet ne te convient tu peux en créer un dans ce même onglet.</div>
    <div>Historique</div>
    <div></div>
    <div></div>
    </body>
</html>
