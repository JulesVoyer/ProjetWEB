<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "trajets.php")
{
	header("Location:../index.php?view=trajets");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php"); 

?>

    <!-- **** B O D Y **** -->
    <div id="trajetBody">
        <br><br><br><br>


        <div id="searchFieldTrajet">
            <select type = "select" name = "direction" id = "champDirection">
                <option value = "-1" selected = "true" >Tous</option>
                <option value = "0">Centrale -> IG2I</option>
                <option value = "1">IG2I -> Centrale </option>

            </select>
            <input type="date" name="dateHeure" placeholder="Quand" id="champDate">
            <input type="text" name="nbPassagers" placeholder="Places restantes" id="champNbPassagers">
            <input type="image" name="imgRecherche" src="ressources/loupe.png" alt="rechercheTrajet" id="imgRecherche">
        </div>
        

        <a href="index.php?view=trajetsDetails" class="trajet">
        <img id="autoRouge" src="ressources/auto-rouge.png" alt="icone voiture rouge" style="display: none;"/>
            <p class="dateTrajet">Ven. 28 Juin</p>            

            <div class="contTrajet">
                <p class="heureDepart">12:30</p>
                <p class="pointDepart">Centrale - Villeneuve d'Ascq</p>
                <p class="pointArrivee">IG2I - Lens</p>
            </div>
                

            <div class="iconeTrajet">
                <div class="rond"></div>
                <div class="trait"></div>
            </div>
                
        </a>


        <a href="index.php?view=trajetsDetails" class="trajet">
                <img id="autoRouge" src="ressources/auto-rouge.png" alt="icone voiture rouge" style="display: none;"/>
                
                <p class="dateTrajet">Ven. 28 Juin</p>            

                <div class="contTrajet">
                    <p class="heureDepart">12:30</p>
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