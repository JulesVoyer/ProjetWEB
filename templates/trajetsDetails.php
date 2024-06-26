<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)
echo '<script type="text/javascript">';
echo 'console.log("marche");';
echo '</script>';
// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "trajetsDetails.php")
{
	header("Location:../index.php?view=trajetsDetails");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 

$trajet = array(
    'date' => 'Ven. 28 Juin',
    'heureDepart' => '08:00',
    'pointDepart' => 'Centrale',
    'pointArrivee' => 'IG2I',
    'participants' => ['Philipe', 'Pierre']
);


?>


<!-- **** B O D Y **** -->

<div id="detailTrajetBody">
    <br/><br/><br/>    
    <!-- Section pour afficher les détails du trajet -->

        <div id="titlePage">
            <a id="retourPagePrecedente" href="javascript:history.back()">
                <img id="flecheRetour" src="ressources/flecheRetour.png" alt="Fleche">
            </a>
            <p>Retour</p>
        </div>

    <!-- Classe trajet récupéré de la page trajet  -->
    <div id="detailsTrajet" class="trajet">

        <p id="detailTrajetDate"><?php echo $trajet['date']; ?></p>
        <p>Heure de départ: <?php echo $trajet['heureDepart']; ?></p>
        <p>Point de départ: <?php echo $trajet['pointDepart']; ?></p>
        <p>Point d'arrivée: <?php echo $trajet['pointArrivee']; ?></p>

        <p>Participants : </p>
        <ul>
            <?php 
                for ($i = 0; $i < count($trajet['participants']); $i++) {
                    echo "<li> <a href='index.php?view=detailUtilisateur'>" . $trajet['participants'][$i] . "</a></li>";
                }
            ?>
        </ul>
        
    </div>
</div>
