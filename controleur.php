<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";

	if ($action = valider("action"))
	{
		ob_start ();
		echo "Action = '$action' <br />";
		// ATTENTION : le codage des caractères peut poser PB si on utilise des actions comportant des accents... 
		// A EVITER si on ne maitrise pas ce type de problématiques

		/* TODO: A REVOIR !!
		// Dans tous les cas, il faut etre logue... 
		// Sauf si on veut se connecter (action == Connexion)

		if ($action != "Connexion") 
			securiser("login");
		*/

		// Un paramètre action a été soumis, on fait le boulot...
		switch($action)
		{
			
			
			// Connexion //////////////////////////////////////////////////
			case 'Connexion' :
				// On verifie la presence des champs login et passe
				$feedback = false; 
				if ($login = valider("pseudo")) {
					if ($passe = valider("passe"))
					{
						// On verifie l'utilisateur, 
						// et on crée des variables de session si tout est OK
						// Cf. maLibSecurisation
						if (verifUser($login,$passe)) {
							// tout s'est bien passé, doit-on se souvenir de la personne ? 
							if (valider("remember")) {
								setcookie("pseudo",$login , time()+60*60*24*30);
								setcookie("passe",$password, time()+60*60*24*30);
								setcookie("remember",true, time()+60*60*24*30);
							} else {
								setcookie("pseudo","", time()-3600);
								setcookie("passe","", time()-3600);
								setcookie("remember",false, time()-3600);
							}
						} else {
							// Identifiants incorrects 
							// TODO: expliciter cryptage des mots de passe dans la bdd 
							// au moment de la création d'un compte : 
							// $SQL = "INSERT INTO users(login,passe) VALUES('tom',md5('passe'))"
							// => la base de données ne contient pas les mots de passe en clair 
							// Fonctions possibles : crypt, md5... 
							// Au moment de la vérification des identifiants : 
							// $SQL = "SELECT id FROM users WHERE login='tom' AND passe=md5('passe')"
							$feedback = "Identifiants incorrects"; 
						}
					} else {
						// pas de mot de passe 
						$feedback = "Mot de passe absent"; 
					}
				} else {
					// pas de login 
					$feedback = "Login absent"; 
				}

				// On redirigera vers la page index automatiquement
				if ($feedback) {
					$qs = "?view=login&msg_feedback=" . urlencode($feedback);
				} else {
					$qs = "?view=accueil&msg_feedback=" . urlencode("Bienvenue, " . $_SESSION["pseudo"]);
				}
			break;

			case 'Logout' : case 'logout' :
				// traitement métier
				// NEVER TRUST USER INPUT !!
				if (valider("connecte","SESSION")) {
					// id : $_SESSION["idUser"]
					deconnecterUtilisateur($_SESSION["idUser"]); 
					session_destroy();
				}
				
				// On redirigera vers la vue connexion (view=login)
				$qs = "?view=login";
			break; 

			case 'Supprimer Conversation' :  
				if ($idConv = valider("idConv"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"]) {
					supprimerConversation($idConv); 
				}
				$qs = "?view=conversations&lastIdConv=$idConv";
			break; 

			case 'Créer Conversation' :  
				if ($theme = valider("theme"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"]) {
					$idNouvelleConv = creerConversation($theme); 
				}
				$qs = "?view=conversations&lastIdConv=$idNouvelleConv";
			break; 



			case 'Poster' : case 'POSTER' :
				if ($idConv = valider("idConv"))
				if ($contenu = valider("contenu"))
				if (valider("connecte","SESSION")){
					$idUser = $_SESSION["idUser"];
					$dataConv = getConversation($idConv); 
					//NEVER TRUST USER INPUT 
					if ($dataConv["active"])
						enregistrerMessage($idConv, $idUser, $contenu); 
				}
		 		$qs = "?view=chat&idConv=$idConv";	 
			break;


			// ACTIONS POUR ADMIN : 

			case 'Supprimer' : 
				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"])
					supprimerUser($idUser); 

				$qs = "?view=users&idLastUser=$idUser";
			break; 

			case 'Interdire' :
				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"]) 
					interdireUtilisateur($idUser); 

				$qs = "?view=users&idLastUser=$idUser";
			break;
 
			case 'Autoriser' : 
				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"])
					autoriserUtilisateur($idUser); 

				$qs = "?view=users&idLastUser=$idUser";
			break; 

			case 'Promouvoir Admin' : case 'Promouvoir admin' : 
				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"])
					promouvoirAdmin($idUser); 

				$qs = "?view=users&idLastUser=$idUser";
			break; 

			case 'Rétrograder' : 
				if ($idUser = valider("idUser"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"])
					retrograderUser($idUser); 

				$qs = "?view=users&idLastUser=$idUser";
			break; 


			case 'Changer Couleur' : case 'Changer couleur' : 
				if ($idUser = valider("idUser"))
				if ($couleur = valider("couleur"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"])
					changerCouleur($idUser,$couleur);

				$qs = "?view=users&idLastUser=$idUser";
			break; 

			case 'Créer Utilisateur' : 
				$idUser = false; 
				if ($pseudo = valider("pseudo"))
				if ($passe = valider("passe"))
				if ($couleur = valider("couleur"))
				if (valider("connecte","SESSION"))
				if ($_SESSION["isAdmin"])
					$idUser = mkUser($pseudo, $passe,false,$couleur);

				$qs = "?view=users&idLastUser=$idUser";
			break; 

			case 'Modifier Couleur' : case 'Modifier couleur' : 
				if ($couleur = valider("couleur"))
				if (valider("connecte","SESSION")) {
					$idUser = $_SESSION["idUser"];
					changerCouleur($idUser,$couleur);
				}

				$qs = "?view=profil";
			break; 

			case 'Modifier Passe' : case 'Modifier passe' : 
				if ($passe = valider("passe"))
				if (valider("connecte","SESSION")) {
					$idUser = $_SESSION["idUser"];
					changerPasse($idUser,$passe);
				}

				$qs = "?view=profil";
			break; 

		} // fin switch(action)

	} // fin if (action = ...)

	// On redirige toujours vers la page index, mais on ne connait pas le répertoire de base
	// On l'extrait donc du chemin du script courant : $_SERVER["PHP_SELF"]
	// Par exemple, si $_SERVER["PHP_SELF"] vaut /chat/data.php, dirname($_SERVER["PHP_SELF"]) contient /chat

	$urlBase = dirname($_SERVER["PHP_SELF"]) . "/index.php";
	// On redirige vers la page index avec les bons arguments

	header("Location:" . $urlBase . $qs);

	// On écrit seulement après cette entête
	ob_end_flush();
	
?>










