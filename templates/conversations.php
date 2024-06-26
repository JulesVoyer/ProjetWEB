<?php
// Ce fichier permet de tester les fonctions développées dans le fichier bdd.php (première partie)

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) == "conversations.php")
{
	header("Location:../index.php?view=conversations");
	die("");
}

include_once("libs/modele.php");
include_once("libs/maLibUtils.php");
include_once("libs/maLibForms.php");

?>

<div id="convBody">
        
        <div id="titlePage">Mes conversations</div>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Jules : Ça marche, rdv demain à IG2I :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Clément : Ça marche, rdv demain à IG2I :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>

        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>
        
        <a href="index.php?view=messages" class="conversations">
            <p class="titleConv">Nom de la conv</p>
            <div class="messageContainer">
                <p class="lastMessage">Oriane : Ça marche, rdv demain à Centrale :)</p>
                <p class="lastMessageTime">09:41</p>
            </div>
        </a>
    
</div>
