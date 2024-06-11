<?php

/*
Partie modèle : on effectue ici tous les traitements sur la base de données (lecture, insertion, suppression, mise à jour).

Des fonctions sont déjà présentes : vous avez le droit de les modifier ou d'en ajouter à votre guise. Des indications sont données en commentaires.
*/

include_once("maLibSQL.pdo.php");

//*** Il est recommandé de ne pas modifier les fonctions suivantes, utilisées pour l'identification ***

function verifUserBdd($login,$passe)
{
	// Vérifie l'identité d'un utilisateur 
	// dont les identifiants sont passes en paramètre
	// renvoie faux si user inconnu
	// renvoie l'id de l'utilisateur si succès

	$SQL="SELECT id FROM users WHERE pseudo='$login' AND pass='$passe';";

	return SQLGetChamp($SQL);
	// si on avait besoin de plus d'un champ
	// on aurait du utiliser SQLSelect
}

function isAdmin($idUser)
{
	// Vérifie si l'utilisateur est un administrateur
	$SQL ="SELECT id FROM users WHERE id='$idUser' AND role='admin';";
	return SQLGetChamp($SQL); 
}

function isCoach($idUser)
{
	// Vérifie si l'utilisateur est un coach (ou un admin)
	$SQL ="SELECT id FROM users WHERE id='$idUser' AND role IN ('admin', 'coach');";
	return SQLGetChamp($SQL); 
}

//*** Fin des fonctions fournies avec le sujet ***

// TODO : D'autres fonctions peuvent être ajoutées à la suite

function getCycles(){
	$SQL = "SELECT * FROM cycles";
	return parcoursRs(SQLSelect($SQL));
}

function getCycleById($id){
	$SQL = "SELECT * FROM cycles WHERE id = '$id'";
	$cycles = parcoursRs(SQLSelect($SQL));

	if (count($cycles) == 0) return false;
	else return $cycles[0];
}

function getUserById($id){
	$SQL = "SELECT * FROM users WHERE id = '$id'";
	$users = parcoursRs(SQLSelect($SQL));

	if (count($users) == 0) return false;
	else return $users[0];
}

function getExercicesByCycle($idCycle){
	$SQL = "SELECT 
			cc.duree, 
			cc.repetitions, 
			e.nom, 
			e.description  
		FROM 
			composition_cycles cc 			
			JOIN exercices e 
			ON e.id = cc.idExercice 
		WHERE 
			cc.idCycle ='$idCycle' 
		ORDER BY 
			cc.ordre;
	";
	if (count(parcoursRs(SQLSelect($SQL))) == 0) return false;
	else return parcoursRs(SQLSelect($SQL));
}

function creerCycle($nom, $description, $repetitions, $repos_entre_cycles, $repos_entre_exercices, $idCoach){
	$SQL = "INSERT INTO 
		cycles (
			nom, 
			description,
			idCoach, 
			repetitions, 
			reposEntreCycles, 
			reposEntreExercices
			) 
	VALUES ('$nom', 
			'$description', 
			'$idCoach', 
			'$repetitions', 
			'$repos_entre_cycles', 
			'$repos_entre_exercices')";
	return SQLInsert($SQL);
}

?>
