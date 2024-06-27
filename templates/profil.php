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
                <li><span class="pflGras">Nom d'affichage : </span><span id="pflDisplayName">prénom</span></li>
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
                <li><span class="pflGras pflVoitureX">Nom voiture 1</span><span class="pflGras"> : </span>-modèle- -couleur-</li>
                <li><span class="pflGras pflVoitureX">Nom voiture 2</span><span class="pflGras"> : </span>-modèle- -couleur-</li>
                <li><span class="pflGras pflVoitureX">Nom voiture 3</span><span class="pflGras"> : </span>-modèle- -couleur-</li>
            </ul>
        </div>

        <img id="pflEditer" src="ressources/editer.png" alt="Editer" />
    </div>

    <input class="btn" id="pflDecoBtn" class="pflDeco" type="button" value="Se déconnecter" />
</div>


<div class="popup" id="pflPopupDecoCont">
    <div id="pflPopupDeco">
        <h2>Voulez-vous vous déconnecter ?</h2>
        <form action="controleur.php" methode="">
            <div class="popupButtons">
                <input class="btn pflAnnuler" type="button" name="annuler" value="Annuler" />   
                <input id="pflDecoConf" class="btn" type="submit" name="action" value="Déconnexion" /> 
            </div>  
        </form>
    </div>
</div>

<div class="popup" id="pflPopupEditionPerso">
    <div id="pflPopupPerso">
        <h2>Editer à propos :</h2>
        <form action="controleur.php" methode="">
            <input id="newDisp" class="popupInput" type="text" name="newDisp" placeholder="Nom d'affichage..." />
            <input id="newPseu" class="popupInput" type="text" name="newPseu" placeholder="Identifiant..." />
            <h3>Adresse :</h3>
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
                <input id="pflValiderProfil" class="btn" type="submit" name="action" value="Valider" /> 
            </div>  
        </form>
    </div>
</div>

<div class="popup" id="pflPopupEditionVoit">
    <div id="pflPopupVoit">
        <h2>Editer véhichules :</h2>
        <form action="controleur.php" methode="">
            <div id="cbSupprVoit">
                <label class="pflPopupLabel" for="cbSuppr">Supprimer un véhicule ?</label>
                <input id="cbSuppr" type="checkbox" name="supprV" />
            </div>
            <div id="pflPopupMesV">

            </div>
            <div id="cbAjVoit">
                <label class="pflPopupLabel" for="cbAj">Ajouter un véhicule ?</label>
                <input id="cbAj" type="checkbox" name="ajouterV" />
            </div>
            <input id="newNum" class="popupInput iptAjV" type="text" name="vehicle_name" placeholder="Nom du véhicule..." />
            <input id="newNomRue" class="popupInput iptAjV" type="text" name="vehicle_nb_seats" placeholder="Nombre de places..." />
            <input id="newCode" class="popupInput iptAjV" type="text" name="model" placeholder="Modèle... (optionnel)" />
            <input id="newCity" class="popupInput iptAjV" type="text" name="code" placeholder="Immatriculation... (optionnel)" />
            <div class="popupButtons">
                <input class="btn pflAnnuler" type="button" name="annuler" value="Annuler" />   
                <input id="pflValiderVoit" class="btn" type="submit" name="action" value="Valider" /> 
            </div>  
        </form>
    </div>
</div>


<script>

    // traitement du profil

    // traitement popups profil

    // popup déconnexion
    $("#pflDecoBtn").click( function () {
        $("#pflBody").css("filter", "blur(3px)");
        $("#pflBody").css("-webkit-filter", "blur(3px)");
        $("#pflPopupDecoCont").show();
    } ); // fin click Se déconnecter

    $(".pflAnnuler").click( function () {
        $("#pflBody").css("filter", "blur(0)");
        $("#pflBody").css("-webkit-filter", "blur(0)");
        $("#pflPopupDecoCont").hide();
        $("#pflPopupEditionPerso").hide();
        $("#pflPopupEditionVoit").hide();
    } ); // fin click Annuler
    // fin popup déconnexion


    var selected = 1; // vaut 1 si on modifie les infos perso, 2 si on modifie les véhicules
    
    // afficher popup édition des informations personnelles ou voitures
    $("#pflEditer").click( function () {
        $("#pflBody").css("filter", "blur(3px)");
        $("#pflBody").css("-webkit-filter", "blur(3px)");
        if (selected == 1) {
            /* Mettre les valeurs d'origine dans les champs d'entrée texte */
            $("#newDisp").val($("#pflDisplayName").html());
            $("#newPseu").val($("#pflPseudo").html());
            $("#newNum").val($("#pflNum").html());
            $("#newNomRue").val($("#pflNomRue").html());
            $("#newCode").val($("#pflCode").html());
            $("#newCity").val($("#pflVille").html());

            /* afficher le popup */
            $("#pflPopupEditionPerso").show();
        }
        else {
            $("#pflPopupEditionVoit").show();
        }
    } );
    // fin afficher popup édition des informations personnelles

    // popup édition informations personnelles
    $("#cbMDP").click( function () {
        if ($(this).is(":checked")) $(".editMDP").show();
        else $(".editMDP").hide();
        
    } );

    // fin popup édition informations personnelles

    // popup édition véhicules

    // récupération des véhicules pour les mettre dans le popup en cas de volonté de suppression
    var jDivVehicule = $("<div>");
    var jRadVehicule = $("<input type='radio'>").attr("name", "possessedV");
    var jLblVehicule = $("<label>");

    $("#cbSuppr").click( function () {
        /* Ajout des véhicules dans le popup */
        if ($(this).is(":checked")) { // si la valeur de la cb est vraie, on va chercher les noms 
            // on permet la visibilité des véhicules à supprimer
            $("#pflPopupMesV").show();

            var mesV = $(".pflVoitureX");

            // on créé les boutons radio
            $("#pflPopupMesV").empty(); // je vide avant de remplir

            $(mesV).each( function () {

                jDivVehicule.empty();
                jDivVehicule.append(jRadVehicule.clone()
                                        .val("")
                                        .attr("id", $(this).html()));
                jDivVehicule.append(jLblVehicule.clone()
                                        .html($(this).html())
                                        .attr("for", $(this).html()));
                
                console.log(jDivVehicule);

                $("#pflPopupMesV").append(jDivVehicule.clone());

                // fin création des boutons radio 

            } ); 
        } else {
            // sinon, on cache
            $("#pflPopupMesV").hide();
        }
    } );
    // fin suppression véhicules

    // ajout véhicules

    $("#cbAj").click( function () {
        if ($(this).is(":checked")) $(".iptAjV").show();
        else $(".iptAjV").hide();
    } );

    // fin ajout véhicules

    // fin popup édition véhicules

    // fermer tous les popups avec esc
    $(document).keydown( function (contexte) {
        if (contexte.which == 27) {
            $("#pflBody").css("filter", "blur(0)");
            $("#pflBody").css("-webkit-filter", "blur(0)");
            $(".popup").hide();
            }
    } ); // fin fermer popups

    // fin traitement popups profil

    // changement de rubriques
    if ($("#pflLicence").html() == "Oui") {
        $("#pflVehicules").click( function () {
            selected = 2;
            $("#pflVoiture").show();
            $("#pflPerso").hide();
            $("#pflAPropos").css("background-color", "rgba(128, 128, 128, 0.5)");
            $("#pflVehicules").css("background-color", "transparent");
        } );
    } else {
        $("#pflVehicules").mouseover( function () {
            $("#pflVehicules").css("cursor", "default");
        } );
    }

    $("#pflAPropos").click( function () {
        selected = 1;
        $("#pflVoiture").hide();
        $("#pflPerso").show();
        $("#pflVehicules").css("background-color", "rgba(128, 128, 128, 0.5)");
        $("#pflAPropos").css("background-color", "transparent");
    } );
    // fin changement des rubriques

    // fin traitement du profil


    function setUserInfo(){
        $.ajax(
            {
                type : 'GET',
                data : {action : 'getCurrentUser'},
                url : './libs/data.php',
                dataType : 'json',
                success : function(oRep){
                    console.log(oRep);

                },
                error : function(xhr, status, error) {
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }

            }
        )
    }

</script>