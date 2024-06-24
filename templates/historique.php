<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "historique.php")
{
	header("Location:../index.php?view=historique");
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
    <div id="trajetBody">
        <br><br><br><br>


        <form action="controleur.php" method="post" id="searchFieldHistorique">
            <input type="date" name="date" placeholder="Quand" id="champDate">
            <input type="image" name="imgRecherche" src="ressources/loupe.png" alt="rechercheHistorique" id="imgRecherche">
        </form>

        <div class="subTitlePage">Mes trajets à venir</div>
        <div class="subTitlePage">Mes trajets passés</div>

        <a href="" class="trajet">
            <p class="dateTrajet">Ven. 28 Juin</p>            

            <div class="contTrajet">
                <p class="heureDepart">12:30</p>
                <p class="heureArrivee">13:00</p>
                <p class="pointDepart">Centrale - Villeneuve d'Ascq</p>
                <p class="pointArrivee">IG2I - Lens</p>
            </div>
                
            <div class="iconeTrajet">
                <div class="rond"></div>
                <div class="trait"></div>
            </div>
        </a>

        <a href="" class="trajet">
            <p class="dateTrajet">Ven. 28 Juin</p>            

            <div class="contTrajet">
                <p class="heureDepart">12:30</p>
                <p class="heureArrivee">13:00</p>
                <p class="pointDepart">Centrale - Villeneuve d'Ascq</p>
                <p class="pointArrivee">IG2I - Lens</p>
            </div>
                

            <div class="iconeTrajet">
                <div class="rond"></div>
                <div class="trait"></div>
            </div>
                
        </a>
    
    </div>
