<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "accueil.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 

// Hypo : l'user doit etre connecté 
if (! valider("connecte","SESSION")) {
	header("Location:?view=accueil&msg_feedback=" . urlencode("Il faut etre connecte !"));
	die("");
}

?>

    <!-- **** B O D Y **** -->
<div id="aclBody">
 
    <br><br><br>
    <h1>Bienvenue Pseudo</h1>
    <hr>
    <div id="presApp">
        <h2 class="alignLeft">Fatigué de marcher ? </h2>
        <h2 class="alignRight">Monte à bord !</h2>
        <p class="alignLeft">Bienvenue sur Covoit’Campus, la plateforme de covoiturage qui transforme tes trajets inter-campus en véritables moments de convivialité.</p>
        <p class="alignRight">Fini les longues marches et les bus surchargés !</p>
        <p class="alignLeft">Trouve des compagnons de route agréables et fais de chaque déplacement une expérience plaisante et divertissante.</p>
        <h3>Trajets</h3>
        <p class="alignLeft">Tu peux rejoindre un trajet dans l’onglet “ trajets ”.</p>
        <p class="alignRight">Si aucun trajet ne te convient tu peux en créer un dans ce même onglet.</p>
        <h3>Historique</h3>
        <p class="alignLeft">Tu peux consulter tes trajets passés et à venir dans l’onglet “historique”.</p>
        <h3>Profil</h3>
        <p class="alignRight">Tu peux modifier tes informations personnelles ou consulter tes véhicules dans l’onglet “profil”.</p>
        <br><br><br>
    </div>

</div>