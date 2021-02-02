<?php

// Connexion à la base de données "projet_gis":

$server = 'localhost';
$user = 'root';
$pwd = 'root';
$bdd = 'projet_gis';

try {
	$connexion = mysqli_connect($server, $user, $pwd, $bdd);
	//echo 'La connexion à la base de donnée projet_gis a été établie.';
}
catch(Exception $server){
	die('Erreur : '.$erreur->getMessage());
}

?>