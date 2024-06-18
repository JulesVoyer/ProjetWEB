<?php

// Si la page est appelée directement par son adresse, on redirige en passant pas la page index
if (basename($_SERVER["PHP_SELF"]) != "index.php")
{
	header("Location:../index.php");
	die("");
}

?>

<div id="pied">
	<img src="ressources/ec-lille-rect.png" alt="Logo Centrale" />
</div>

</body>
</html>
