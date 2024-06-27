<?php
	if(!isset($_SESSION)) session_start();
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
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
				setcookie(session_name(), '', time() - 42000);
				$qs = "?view=login";
			break;
			//fin logout

			//création d'un compte
			case "Créer le compte" :
				if (valider("username") && valider("password") && valider("password_confirmation") && valider("display_name") && valider("driving_license") && valider("street_number") && valider("street") && valider("city") && valider("city_code"))
				{
					// On récupère les valeurs du formulaire
					$username = valider("username");
					$password = valider("password");
					$password_confirmation = valider("password_confirmation");
					$display_name = valider("display_name");
					$driving_license = valider("driving_license");
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

			//fin création de compte

			case "Créer un trajet" :
				if(valider("connecte", "SESSION")){
					$id = valider("idUser","SESSION");

					if(valider("dateHeure") && valider("direction")){
						$datetime = valider("dateHeure");
						$direction =( valider("direction")=="c2i")?0:1;
						//si l'utilisateur souhaite se déclarer conducteur
						if($conduit = valider("conducteur")){
							//on vérifie qu'il possède bien un permis de conduire, on le rejette sinon
							if(!verifDriverLicenseById($id)){

								$qs = "?view=trajets&erreur=".urlencode("Vous ne pouvez pas vous déclarer comme conducteur si vous ne possédez pas le permis de conduire");
							}
							else
							{

								$driver_id = $id;	

								//on regarde si l'utilisateur a déclaré un véhicule
								$vehicle_id = valider("vehicle") ? valider("vehicle") : null;	
								if(!is_null($vehicle_id)){
									//si oui, on inspecte ce véhicule
									$vehicle = getVehicleById($vehicle_id);
									//si le véhicule appartient à Centrale
									if($vehicle['owner_id'] == 1){
										//on récupère la date du trajet
										$date = (new DateTime($datetime))->format('Y-m-d');
										//on vérifie que le vehicule est disponible à cette date
										if(!getCentraleVehicleAvailabilityByIdAndDate($vehicle_id, $date)){
											//sinon, on rejette
											$qs = "?view=trajets&erreur=".urlencode("Ce vehicule est indisponible à cette date");
										}else{
											//si oui, on réserve le véhicule pour la journée, on garde le nb de sièges; et ça part
											bookVehicleByIds($vehicle_id, $date, $id);		
											$nb_passagers = $vehicle['nb_seats'];
											$trip_id = createTrip($datetime,$driver_id,$vehicle_id, $nb_passagers, $direction);
											subscribeToTrip($id, $trip_id);
											$qs = "?view=trajetsDetails&trip_id=$trip_id";
										}										
									}
									//si le véhicule n'appartient pas à centrale, et qu'il n'appartient pas à l'utilisateur 
									elseif($vehicle['owner_id'] != $id){
										//on rejette
										$qs = "?view=trajets&erreur=".urlencode("Ce vehicule ne vous appartient pas !");
									}
									//si c'est le véhicule de l'utilisateur
									else{
										// on garde le nombre de sièges, et ça part
										$nb_passagers = $vehicle['nb_seats'];		
										$trip_id = createTrip($datetime,$driver_id,$vehicle_id, $nb_passagers, $direction);
										subscribeToTrip($id, $trip_id);				
										$qs = "?view=trajetsDetails&trip_id=$trip_id";			
									}
								}
								//SI ON N'A PAS DE VEHICULE
								else{
									//on crée un trajet en attente avec un chauffeur volontaire, et ça part
									$trip_id = createTrip($datetime,$driver_id,null, 4, $direction);
									subscribeToTrip($id, $trip_id);
									$qs = "?view=trajetsDetails&trip_id=$trip_id";
								}
							}		
						}
						//SI L'UTILISATEUR NE S'EST PAS DECLARE COMME CONDUCTEUR
						else {
							//On crée un trajet coquille avec direction et date, et ça part
							$trip_id = createTrip($datetime,null,null, 4, $direction);
							subscribeToTrip($id, $trip_id);
							$qs = "?view=trajetsDetails&trip_id=$trip_id";
							echo("     success !");
							echo("		trip_id : $trip_id");
						}

					}else{
						$qs = "?view=trajets&erreur=".urlencode("Veuillez renseigner une date et une direction");
						echo("		erreur : Veuillez renseigner une date et une direction");
					}
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