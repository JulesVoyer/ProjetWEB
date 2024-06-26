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

?>

    <!-- **** B O D Y **** -->
<div id="locationBody">
    <br><br><br>

	<a href="index.php?view=trajetsDetails" class="trajet">
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


        <a href="index.php?view=trajetsDetails" class="trajet">
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

			<a href="index.php?view=trajetsDetails" class="trajet">
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


        <a href="index.php?view=trajetsDetails" class="trajet">
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
    
</div>
