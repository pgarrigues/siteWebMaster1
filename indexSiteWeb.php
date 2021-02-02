<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Accueil portail cartographique</title>

	<!-- font -->
	<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

	<!-- CSS Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">

	<!-- CSS Leaflet -->
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
	integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
	crossorigin=""/>

	<!-- Make sure you put this AFTER Leaflet's CSS -->
	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
	integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
	crossorigin=""></script>

	<!-- Map CSS -->
	<link rel="stylesheet" type="text/css" href="css/map-style.css">

	<!-- Ma feuille de style CSS -->
	<link rel="stylesheet" type="text/css" href="css/indexSiteWeb-style.css">
</head>
<body>
	<?php
	session_start();
	require('connexion.php'); // Connexion à la base de donnée.

	if ((isset($_GET['id'])) && $_GET['id'] > 0){
		$getId = intval($_GET['id']); // ---> pour la sécurité : transformation en nombre pour être sur que l'utilisateur ne mette pas n'importe quoi.
		$reqUser = "SELECT * FROM users WHERE users.id = '$getId'";
		$reqUser_query = mysqli_query($connexion, $reqUser);
		$userInfo = mysqli_fetch_assoc($reqUser_query);
		$message = "Profil de " .$userInfo['prenom'];
	}
	?>

	<!-- Header -->
	<header class="container-fluid header">
		<div class="container">
			<div class="logo">
				<img src="img/logo.jpg" alt="logo du site">
			</div>
			<a href="profil_user.php?id=<?php echo $_SESSION['id']; ?>"><?php echo $message; ?></a>
			<a href="deconnexion_site.php">Déconnexion</a>
		</div>
	</header>
	<!-- Fin header -->

	<!-- Choix de fonctionnalités -->
	<section class="container-fluid fonctionnalites_section">
		<div class="container">
			<div class="row">
				<div class="col-md-3">
				</div>
				<div class="col-md-6">
					<p> Le portail cartographique de l'Institut Paris Région offre à l'utilisateur 4 fonctionnalités.</p>
					<br>
					<p>Établissements scolaires :</p>
					<ul>
						<li> <a href="etab_scolaires_1.php?id=<?php echo $_SESSION['id']; ?>">Recherche de tous les établissements scolaires d'une commune.</a> </li>
						<br>
						<li> <a href="etab_scolaires_2.php?id=<?php echo $_SESSION['id']; ?>">Recherche d'un type d'établissement scolaire spécifique dans un département.</a> </li>
					</ul>
					<br>
					<p>Établissements hospitaliers :</p>
					<ul>
						<li> <a href="etab_hospitaliers_1.php?id=<?php echo $_SESSION['id']; ?>">Recherche de tous les établissements hospitaliers d'une commune.</a> </li>
						<br>
						<li> <a href="etab_hospitaliers_2.php?id=<?php echo $_SESSION['id']; ?>">Recherche d'un type d'établissement hospitalier spécifique dans un département.</a> </li>
					</ul>
				</div>
				<div class="col-md-3">
				</div>
			</div>
		</div>
	</section>
	<!-- Fin choix de fonctionnalités -->


	<!-- Footer -->
	<footer class="container-fluid footer">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 id="contact"> Contact </h2>
					<p> Pierre-Loup GARRIGUES </p>
					<p> Master G2M - Master 1 </p>
					<a href="mailto:pierre-loupg@hotmail.fr"> Email : pierre-loupg@hotmail.fr </a>
				</div>
			</div>
		</div>
	</footer>
	<!-- Fin footer -->

</body>
</html>