<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "profil.php")
{
	header("Location:../index.php?view=profil");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

?>

    <!-- **** B O D Y **** -->
    <div id="profilBody">
        <br><br><br><br>


    </div>
