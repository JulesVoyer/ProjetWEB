<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "accueil.php")
{
	header("Location:../index.php?view=accueil");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

$interventions = array();
$interventions[] = array('date' => '2024-06-26', 'direction' => '1');
$interventions[] = array('date' => '2024-06-27', 'direction' => '2');
$interventions[] = array('date' => '2024-06-28', 'direction' => '1');

if (!$id=valider("user_id")){
    header("Location:../index.php?view=accueil");
    die("");
}

$utilisateur = getUserById($id);

$utilisateur = array(
    'Nom' => $utilisateur['display_name'],
    'Permis' => ($utilisateur['driving_license'] == 1) ? 'Oui' : 'Non',
    'nbTrajet' => getUserTripCount($id),
    'interventions' => getInterventionsByUserId($id),
)

?>


<div id="detailUtilisateurBody">

    <br><br><br>
    
    <div id="uDtlTitlePage">
            <a id="retourPagePrecedente" href="javascript:history.back()">
                <img id="flecheRetour" src="ressources/flecheRetour.png" alt="Fleche">
            </a>
            <p>Retour</p>
        </div>


    <div id="detailUtilisateur">
        <p id="nomUtilisateur"><?=$utilisateur['Nom'] . ' ' . $utilisateur['Prénom']?> </p>
        <hr style="width: 100%;">
        <ul>
            <li>
                <span class="rubrique" >Interventions : </span>
                <ul>
                    <?php
                        for ($i = 0; $i < count($utilisateur['interventions']); $i++) {
                            $direction = $utilisateur['interventions'][$i]['direction'];
                            $date = $utilisateur['interventions'][$i]['date'];
                            if ($direction == 0) {
                                echo "<li class='intervention'>Centrale - Villeneuve d'Ascq : $date</li>";
                            } elseif ($direction == 1) {
                                echo "<li class='intervention'>IG2I - Lens : $date</li>";
                            } else {
                                echo "<li class='intervention'>Direction inconnue : $date</li>";
                            }
                        }
                    ?>
                </ul>
            </li>
            
            <li>
                <span class="rubrique" >Permis : </span> 
                <span class="info"><?=$utilisateur['Permis'] ?></span>
            </li>
            
            <li>
                <span class="rubrique" >Nombre de trajets effectués : </span> 
                <span class="info"><?=$utilisateur['nbTrajet'] ?></span>
            </li> 
        </ul>
        
    </div>



</div>