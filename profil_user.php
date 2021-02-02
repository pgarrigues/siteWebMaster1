<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Profil User </title>

	<!-- font -->
	<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

	<!-- CSS Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">

	<!-- Ma feuille de style CSS -->
	<link rel="stylesheet" type="text/css" href="css/profil_user-style.css">
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
		$message = "Profil de " .$userInfo['prenom']. " " .$userInfo['nom'];
	}
	?>

	<!-- Header -->
	<header class="container-fluid header">
		<div class="container">
			<div class="logo">
				<img src="img/logo.jpg" alt="logo du site">
			</div>
			<a href="#"> <?php echo $message ?> </a>
			<nav class="menu">
				<a href="indexSiteWeb.php?id=<?php echo $_SESSION['id']; ?>"> Retour à l'accueil </a>
			</nav>
		</div>
	</header>
	<!-- Fin header -->

	<!-- Infos profil -->
	<section class="container-fluid profil">
		<div class="container">
			<div class="row">
				<h2 class="col-md-12"> <?php echo $userInfo['prenom']. " " .$userInfo['nom']. ", " ?> voici les informations de votre compte : </h2>
			</div>
			<div class="row box_info">
				<div class="col-md-12">
					<?php
						echo "Prénom : " .$userInfo['prenom'];
						echo "<br>";
						echo "Nom : " .$userInfo['nom'];
						echo "<br>";
						echo "Pseudo : " .$userInfo['pseudo'];
						echo "<br>";
						echo "Email : ".$userInfo['email'];
						echo "<br>";
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- Fin infos profil -->

	<!-- Deconnexion -->
	<div class="container-fluid deconnexion">
		<div class="container">
			<div class="row">
				<a href="deconnexion_site.php" class="col-md-12"> Deconnexion. </a>
			</div>	
		</div>
	</div>
	<!-- Fin deconnexion -->


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