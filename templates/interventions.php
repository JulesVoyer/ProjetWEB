<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "interventions.php")
{
	header("Location:../index.php?view=interventions");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

?>

<div id="interventionsBody">

	<div id="itvContent">
		<h2 id="itvTitreCreer">Créer une nouvelle intervention :</h2>
		<form id="itvNew" action="controleur.php" methode="" >
			<h3>Lieu :</h3>
			<select>
				<option name="lieu_intervention_IG2I" value="0">IG2I</option>
				<option name="lieu_intervention_centrale" value="1">Centralle</option>
			</select>
			<h3>Date :</h3>
			<input type="date" name="lieuIntervention" />
			<input id="itvCreerBtn" class="btn" type="submit" name="action" value="Créer" />
		</form>
		<h2>Liste des interventions :</h2>
		<div id="itvListe">
			<div><span class="itvIntervention">Intervention 1 : </span><span class="itvLieu">Centrale</span> <span class="date">26/06/24</span></div>
		</div>
		</div>
	</div>
	
</div>