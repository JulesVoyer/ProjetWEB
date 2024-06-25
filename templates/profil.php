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

<div id="pflBody">
    <br /><br /><br /><br /><br />

    <div id="pflCont">
        <h2 id="pflAPropos">A propos de vous</h2>
        <h2 id="pflVehicules">Vos véhicules</h2>

        <div id="pflPerso">
            <ul>
                <li><span>Prénom : </span>prénom</li>
                <li><span>Nom : </span>nom</li>
                <li><span>Pseudo : </span>pseudo</li>
                <li>
                    <span>Adresse : </span> 
                    <div>XX, rue -nom de la rue- 
                        <br />59650
                        <br />Villeneuve d'Ascq
                    </div>
                </li>
                <li><span>Permis : </span><span id="pflLicence">Oui</span></li>
            </ul>
        </div>

        <div id="pflVoiture">
            <ul>
                <li><span>Voiture 1 : </span>-modèle- -couleur-</li>
                <li><span>Voiture 2 : </span>-modèle- -couleur-</li>
                <li><span>Voiture 3 : </span>-modèle- -couleur-</li>
            </ul>
        </div>

        <img id="pflEditer" src="ressources/editer.png" alt="Editer" />
    </div>

    <input class="btn" id="pflDecoBtn" class="pflDeco" type="button" value="Se déconnecter" />
</div>


<div class="popup" id="pflPopupDecoCont">
    <div id="pflPopupDeco">
        <h3>Voulez-vous vous déconnecter ?</h3>
        <form action="controleur.php" methode="">
            <div class="popupButtons">
                <input id="pflAnnuler" class="btn" type="button" name="annuler" value="Annuler" />   
                <input id="pflDecoConf" class="btn" type="button" name="deconnexion" value="Déconnexion" /> 
            </div>  
        </form>
    </div>
</div>

<div class="popup" id="pflPopupEditionPerso">
    <div id="pflPopupDeco">
        <h3>Voulez-vous vous déconnecter ?</h3>
        <form action="controleur.php" methode="">
            <div class="popupButtons">
                <input id="pflAnnuler" class="btn" type="button" name="annuler" value="Annuler" />   
                <input id="pflDecoConf" class="btn" type="button" name="deconnexion" value="Déconnexion" /> 
            </div>  
        </form>
    </div>
</div>
