<?php


?>


<!-- **** B O D Y **** -->

// On ajoute le
<body id="trajetBody">
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
