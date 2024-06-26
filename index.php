<?php
/*
Cette page génère les différentes vues de l'application en utilisant des templates situés dans le répertoire "templates". Un template ou 'gabarit' est un fichier php qui génère une partie de la structure XHTML d'une page. 

La vue à afficher dans la page index est définie par le paramètre "view" qui doit être placé dans la chaîne de requête. En fonction de la valeur de ce paramètre, on doit vérifier que l'on a suffisamment de données pour inclure le template nécessaire, puis on appelle le template à l'aide de la fonction include

Les formulaires de toutes les vues générées enverront leurs données vers la page data.php pour traitement. La page data.php redirigera alors vers la page index pour réafficher la vue pertinente, généralement la vue dans laquelle se trouvait le formulaire. 
*/
include_once "libs/maLibUtils.php";
include_once "libs/maLibForms.php";


// on récupère le paramètre view éventuel 
$view = valider("view"); 

if($erreur= valider('erreur')) {
	echo "<div class='erreur' style = { 'color' : 'red'}>$erreur</div>";
}
//Si on est pas connecté
 if (!valider("connecte","SESSION")) {

	// Si view est vide ou différent de signUp, on charge la vue login par défaut
	if ($view != "signUp") $view = "login"; 

    // Si l'utilisateur n'est pas connecté, on affiche la vue login
    include("templates/$view.php");

} else { 

    // Sinon

	// Si view est vide, on charge la vue accueil par défaut
	if ((!$view) || ($view == "login" || ($view == "signUp") )) $view = "accueil";

	// Dans tous les cas, on affiche l'entete, qui contient les balises de structure de la page
	include("templates/header.php");


	// En fonction de la vue à afficher, on appelle tel ou tel template
	switch($view)
	{		
		default : // si le template correspondant à l'argument existe, on l'affiche. Sinon, on redirige vers l'accueil
			if (file_exists("templates/$view.php"))
				include("templates/$view.php");
			else{
				header("Location:./index.php?view=accueil");
				}
	}


	// Dans tous les cas, on affiche le pied de page
	// Qui contient les coordonnées de la personne si elle est connectée

	include("templates/footer.php");
}
	
