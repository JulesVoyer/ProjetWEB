<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "trajetsDetails.php")
{
	header("Location:../index.php?view=trajetsDetails");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php"); // tprint
include_once("libs/maLibForms.php"); 
// définit mkTable

// Hypo : l'user doit etre connecté 
if (! valider("connecte","SESSION")) {
	header("Location:?view=accueil&msg_feedback=" . urlencode("Il faut etre connecte !"));
	die("");
}

?>


<!-- **** B O D Y **** -->

<div id="trajetBody">
    <br><br><br><br>

    <!-- Formulaire de recherche de trajet (déjà présent dans votre code) -->
    <form action="controleur.php" method="post" id="searchFieldTrajet">
        <input type="text" name="depart" placeholder="Départ" id="champDepart">
        <input type="text" name="destination" placeholder="Destination" id="champDestination">
        <input type="datetime-local" name="dateHeure" placeholder="Quand" id="champDateHeure">
        <input type="text" name="nbPassagers" placeholder="..." id="champNbPassagers">
        <input type="image" name="imgRecherche" src="ressources/loupe.png" alt="rechercheTrajet" id="imgRecherche">
    </form>
    
    <!-- Section pour afficher les détails du trajet -->


    <div id="detailsTrajet">
        <p>Date: <?php echo $trajet['date']; ?></p>
        <p>Heure de départ: <?php echo $trajet['heureDepart']; ?></p>
        <p>Heure d'arrivée: <?php echo $trajet['heureArrivee']; ?></p>
        <p>Point de départ: <?php echo $trajet['pointDepart']; ?></p>
        <p>Point d'arrivée: <?php echo $trajet['pointArrivee']; ?></p>
    </div>
</body>
