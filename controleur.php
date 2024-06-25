<?php
session_start();

	include_once "libs/maLibUtils.php";
	include_once "libs/maLibSQL.pdo.php";
	include_once "libs/maLibSecurisation.php"; 
	include_once "libs/modele.php"; 

	$qs = "";

	if ($action = valider("action"))
	{

		switch($action)
		{
			//login de l'utilisateur
			case "Se connecter":
				//on récupère les valeurs du formulaire
				$login = valider("login");
				$password = valider("password");
				//on vérifie si le login et le mot de passe sont corrects
				$profil = verifUser($login, $password);
				//si le profil existe
				if ($profil)
				{
					//on redirige vers la page d'accueil
					$qs = "?view=accueil";
				}
				else
				{
					//sinon on redirige vers la page de login avec un message d'erreur
					$qs = "?view=login&erreur=".urlencode("Login ou mot de passe incorrect");
				}
			break;
			//fin login
			
			//logout de l'utilisateur
			case "Déconnexion":

				session_destroy();
				$qs = "?view=login";
			break;
			//fin logout

			//création d'un compte
			case "CreateAccount" :
				if (valider("username") && valider("password") && valider("password_confirmation") && valider("display_name") && valider("driving_license") && valider("street_number") && valider("street") && valider("city") && valider("city_code"))
				{
					// On récupère les valeurs du formulaire
					$username = valider("username");
					$password = valider("password");
					$password_confirmation = valider("password_confirmation");
					$display_name = valider("display_name");
					$driving_license = intval(valider("driving_license"));
					$street_number = valider("street_number");
					$street = valider("street");
					$city = valider("city");
					$city_code = valider("city_code");



					//on vérifie que le nom d'utilisateur n'est pas déjà pris
					if (checkUsername($username)){
						//si le nom d'utilisateur est déjà pris on redirige vers la page de création de compte avec un message d'erreur
						$qs = "?view=createAccount&erreur=".urlencode("Nom d'utilisateur déjà pris");
					}
					else{

						//on vérifie que l'utilisateur est bien sûr de son mot de passe 
						if($password == $password_confirmation){
							$id = createAccount($username, $password, $display_name, $driving_license, $street_number,$street, $city, $city_code);
							//si l'utilisateur a le permis, on regarde si il a déclaré un véhicule
							if ($driving_license == 1){
								if (valider("vehicle_name") && valider("vehicle_nb_seats")){
									$vehicle_name = valider("vehicle_name");
									$vehicle_nb_seats = valider("vehicle_nb_seats");
									if(valider("code")){ $code = valider("code") ;}else{ $code = null;}
									if(valider("model")){$model = valider("model");}else{$model = null;}
									createVehicle( $vehicle_name, $vehicle_nb_seats,$code,$model,$id);
								}
							}

							
							$qs = "?view=login";
						}
						else
						{
							//sinon on redirige vers la page de création de compte avec un message d'erreur
							$qs = "?view=createAccount&erreur=".urlencode("Les mots de passe ne correspondent pas");
						}
					}
				}
				else
				{
					//sinon on redirige vers la page de création de compte avec un message d'erreur
					$qs = "?view=createAccount&erreur=".urlencode("Veuillez remplir tous les champs");
				}
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










