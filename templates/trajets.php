<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "profil.php")
{
	header("Location:../index.php?view=users");
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


        <form action="controleur.php" method="post" id="searchFieldTrajet">
            <input type="text" name="depart" placeholder="Départ" id="champDepart">
            <input type="text" name="destination" placeholder="Destination" id="champDestination">
            <input type="datetime-local" name="dateHeure" placeholder="Quand" id="champDateHeure">
            <input type="text" name="nbPassagers" placeholder="..." id="champNbPassagers">
            <input type="image" name="imgRecherche" src="ressources/loupe.png" alt="rechercheTrajet" id="imgRecherche">
        </form>
        
        <a href="" class="trajet">
        <img id="autoRouge" src="ressources/auto-rouge.png" alt="icone voiture rouge" style="display: none;"/>
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


            <a href="" class="trajet sansVehicule inscrit">
                <img id="autoRouge" src="ressources/auto-rouge.png" alt="icone voiture rouge" style="display: none;"/>
                
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

            <!--<a href="http://localhost/WEB2.0/%5b04%5d%20Projet/ProjetWEB/index.php?view=conversations">
                <img id="convLink" src="ressources/conversations-bleu.png" alt="icone voiture rouge" style="display: none;"/>
            </a> -->  
        
        
        
    
    </div>