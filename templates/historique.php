<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

// On envoie l'entête Content-type correcte avec le bon charset
header('Content-Type: text/html;charset=utf-8');

// Pose qq soucis avec certains serveurs...
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <!-- **** H E A D **** -->
    <head>	
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-15" />
        <title>Covoit'Campus</title>
        <link rel="stylesheet" type="text/css" href="CSS/style.css">
    </head>
    <!-- **** F I N **** H E A D **** -->


    <!-- **** B O D Y **** -->
    <body id="trajetBody">
        <br><br><br><br>


        <div id="searchField">

        </div>

        <div class="subTitlePage">Mes trajets à venir</div>
        <div class="subTitlePage">Mes trajets passés</div>

        <a href="" class="trajet">
            <p class="dateTrajet">Ven. 28 Juin</p>            

            <div class="contTrajet">
                <p class="heureDepart">12:30</p>
                <p class="heureArrivee">13:00</p>
                <p class="pointDepart">Centrale - Villeneuve d'Ascq</p>
                <p class="pointArrivee">IG2I - Lens</p>
            </div>
                
            <div class="iconeTrajet">
                <div class="rond"></div>
                <div class="trait"></div>
            </div>
        </a>

        <a href="" class="trajet">
            <p class="dateTrajet">Ven. 28 Juin</p>            

            <div class="contTrajet">
                <p class="heureDepart">12:30</p>
                <p class="heureArrivee">13:00</p>
                <p class="pointDepart">Centrale - Villeneuve d'Ascq</p>
                <p class="pointArrivee">IG2I - Lens</p>
            </div>
                

            <div class="iconeTrajet">
                <div class="rond"></div>
                <div class="trait"></div>
            </div>
                
        </a>
    
    </body>
</html>
