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
    'date' => 'Ven 28 Juin',
    'heureDepart' => '08:00',
    'pointDepart' => 'Centrale - Villeneuve d’Ascq',
    'pointArrivee' => 'IG2I - Lens',
    'participants' => ['Philipe', 'Pierre', 'Jean-Michel']
);


?>


<!-- **** B O D Y **** -->

<div id="detailTrajetBody">
    <br><br><br><br>    
    <!-- Section pour afficher les détails du trajet -->


    <!-- Classe trajet récupéré de la page trajet  -->
    <div id="detailsTrajet" class="trajet">

        <a href="">
            <img id="flecheRetour" src="ressources/fleche-retour.png" alt="retour"> 
            <p id="retourTexte"> Retour </p>
        </a>

        <h1 id="detailsTrajetDate"><?php echo $trajet['date']; ?></h1>

        <div class="iconeTrajet">
                <div id="detailRond" class="rond"></div>
                <div id="detailTrait" class="trait"></div>
        </div>

        <p id="detailsTrajetHeure"> <?php echo $trajet['heureDepart']; ?></p>
        <p id="detailsTrajetDepart"><?php echo $trajet['pointDepart']; ?></p>
        <p id="detailsTrajetArrive"><?php echo $trajet['pointArrivee']; ?></p>

        <br><br><br>
        <h1> Nombre de place(s) restantes : 2 </h1>
        <br>

        <h1>Participants : </h1>
        <ul>
        <?php 
        for ($i = 0; $i < count($trajet['participants']); $i++) {
            echo "<a href=''><li class='detailTrajetListElm'>". $trajet['participants'][$i] . "</li></a>";
        }
        ?>
        </ul>

        <h1>Voiture : </h1>

        <div id="detailTrajetVoitureAssigne">
            <p><b>Modèle :</b> *modèle* </p>
            <p><b>Couleur :</b> *couleur* </p>
            <p><b>Immatriculation :</b> *imm* </p>
            <p><b>Propriétaire :</b> *prenom ou agence* </p>
        </div>

        <input id="trjRejoindre" class="btn btnTrajet" type="button" value="Rejoindre" />
    </div>
</div>
 