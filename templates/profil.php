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
                <li><span class="pflGras">Prénom : </span><span id="pflPrenom">prénom</span></li>
                <li><span class="pflGras">Nom : </span><span id="pflNom">nom</span></li>
                <li><span class="pflGras">Pseudo : </span><span id="pflPseudo">pseudo</span></li>
                <li>
                    <span class="pflGras">Adresse : </span> 
                    <div><span id="pflNum">XX</span>, rue <span id="pflNomRue">-nom de la rue-</span>- 
                        <br /><span id="pflCode">59650</span>
                        <br /><span id="pflVille">Villeneuve d'Ascq</span>
                    </div>
                </li>
                <li><span class="pflGras">Permis : </span><span id="pflLicence">Oui</span></li>
            </ul>
        </div>

        <div id="pflVoiture">
            <ul>
                <li><span class="pflGras">Voiture 1 : </span>-modèle- -couleur-</li>
                <li><span class="pflGras">Voiture 2 : </span>-modèle- -couleur-</li>
                <li><span class="pflGras">Voiture 3 : </span>-modèle- -couleur-</li>
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
                <input class="btn pflAnnuler" type="button" name="annuler" value="Annuler" />   
                <input id="pflDecoConf" class="btn" type="submit" name="deconnexion" value="Déconnexion" /> 
            </div>  
        </form>
    </div>
</div>

<div class="popup" id="pflPopupEditionPerso">
    <div id="pflPopupPerso">
        <h3>Editer à propos :</h3>
        <form action="controleur.php" methode="">
            <input id="newPre" class="popupInput" type="text" name="newPre" placeholder="Prénom..." />
            <input id="newNom" class="popupInput" type="text" name="newNom" placeholder="Nom... " />
            <input id="newPseu" class="popupInput" type="text" name="newPseu" placeholder="Pseudo..." />
            <h4>Adresse :</h4>
            <input id="newNum" class="popupInput" type="text" name="newNum" placeholder="Numéro de rue..." />
            <input id="newNomRue" class="popupInput" type="text" name="newNomRue" placeholder="Nom de rue..." />
            <input id="newCode" class="popupInput" type="text" name="newCode" placeholder="Code postal..." />
            <input id="newCity" class="popupInput" type="text" name="newCity" placeholder="Ville..." />
            
            <div id="cbEditMDP">
                <label for="cbMDP">Modifier le mot de passe ?</label>
                <input id="cbMDP" type="checkbox" name="modifMDP" />
            </div>
            <input class="popupInput editMDP" type="password" name="ancienMDP" placeholder="Ancien mot de passe..." />
            <input class="popupInput editMDP" type="password" name="newMDP" placeholder="Nouveau mot de passe..." />
            <input class="popupInput editMDP" type="password" name="confirmMDP" placeholder="Confimer le mot de passe..." />
            <div class="popupButtons">
                <input  class="btn pflAnnuler" type="button" name="annuler" value="Annuler" />   
                <input id="pflValiderProfil" class="btn" type="button" name="valider" value="Valider" /> 
            </div>  
        </form>
    </div>
</div>

<div class="popup" id="pflPopupEditionVoit">
    <div id="pflPopupVoit">
        <h3>Editer véhichules :</h3>
        <p>Supprimer une voiture ?</p>
        <form action="controleur.php" methode="">
            <div class="popupButtons">
                <input class="btn pflAnnuler" type="button" name="annuler" value="Annuler" />   
                <input id="pflValiderVoit" class="btn" type="button" name="deconnexion" value="Déconnexion" /> 
            </div>  
        </form>
    </div>
</div>
