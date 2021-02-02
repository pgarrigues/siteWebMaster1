<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Accueil </title>

	<!-- font -->
	<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

	<!-- CSS Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">

	<!-- Ma feuille de style CSS -->
	<link rel="stylesheet" type="text/css" href="css/index-style.css">
</head>
<body>
	<!-- Header --> 
	<header class="container-fluid header">
		<div class="container">
			<div class="logo">
				<img src="img/logo.jpg" alt="logo du site">
			</div>
			<a href="#connexion"> Se connecter </a>
			<a href="#connexion"> Créer un compte </a>
			<a href="aPropos.php"> À propos </a>
		</div>
	</header>
	<!-- Fin header -->

	<!-- Bannière -->
	<section class="container-fluid banner">
		<div class="ban">
			<img src="img/ban-min.jpg" alt="bannière du site">
		</div>
		<div class="inner-banner">
			<h1> Bienvenue sur le portail cartographique </h1>
			<h2> de l'Institut Paris Région</h2>
		</div>
	</section>
	<!-- Fin bannière -->

	<!-- Connexion -->
	<section class="container-fluid connexion">
		<div class="container">
			<div class="row">
				<h2 id="connexion" class="col-md-12"> Connectez vous ou créez un compte pour accéder au portail. </h2>
			</div>
			<div class="row">
				<hr class="separator col-md-2">
			</div>
			<div class="row box_connexion">
				<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
					<h2> Se connecter : </h2>
					<a href="identification.php"> Cliquez sur ce lien pour vous connecter. </a>
				</div>
				<div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
					<h2> Créer un compte : </h2>
					<a href="crea_compte.php"> Cliquez sur ce lien pour créer un compte. </a>
				</div>
			</div>
		</div>
	</section>
	<!-- Fin connexion -->


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