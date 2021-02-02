<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Identification </title>

	<!-- font -->
	<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

	<!-- CSS Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">

	<!-- Ma feuille de style CSS -->
	<link rel="stylesheet" type="text/css" href="css/identification-style.css">
</head>
<body>
	<?php
	session_start();
	require('connexion.php'); // Connexion à la base de donnée.

	// Vérification que le formulaire est validé.
	if (isset($_POST['formConnexion'])){
		$pseudoConnect = htmlspecialchars($_POST['pseudoConnect']);
		$mdpConnect = md5($_POST['mdpConnect']);

		// Vérification que les champs ne sont pas vides.
		if ((!empty($pseudoConnect)) && (!empty($mdpConnect))){
			// Vérification que les données rentrées sont valides :
			$reqUser = "SELECT * FROM users WHERE users.pseudo = '$pseudoConnect' AND users.password = '$mdpConnect'";
			$reqUser_query = mysqli_query($connexion, $reqUser);
			$userExiste = mysqli_num_rows($reqUser_query);
			if ($userExiste == 1){
				// Si l'utilisateur existe, alors on le redirige vers le site internet, sinon il doit réessayer de se connecter.
				$userInfo = mysqli_fetch_assoc($reqUser_query);
				$erreurConnexion = "Bonjour " .$userInfo['prenom']. " " .$userInfo['nom']. "! Vous êtes à présent connecté.";
				$_SESSION['id'] = $userInfo['id'];
				$_SESSION['nom'] = $userInfo['nom'];
				$_SESSION['prenom'] = $userInfo['prenom'];
				$_SESSION['pseudo'] = $userInfo['pseudo'];
				$_SESSION['email'] = $userInfo['email'];
				header("Location: indexSiteWeb.php?id=".$_SESSION['id']);
			}
			else{
				$erreurConnexion = "La connexion n'a pas pu être établie.";
			}
		}
		else{
			$erreurConnexion = "Veuillez renseigner tous les champs";
		}
	}
	?>

	<!-- Header --> 
	<header class="container-fluid header">
		<div class="container">
			<div class="logo">
				<img src="img/logo.jpg" alt="logo du site">
			</div>
			<a href="index.php" class="logo"> Retour à l'accueil </a>
		</div>
	</header>
	<!-- Fin header -->

	<!-- Connexion -->
	<section class="container-fluid connexion">
		<div class="container">
			<div class="row">
				<div align="center" class="col-md-12">
					<h2> Connexion </h2>
					<p> Veuillez renseigner les champs ci dessous : </p>
				</div>
			</div>
			<div class="row">
				<div align="center" class="col-md-12">
					<form action="#" method="POST">
						<table>
							<tr>
								<td align="right">
									<label for="pseudoConnect"> Pseudo : </label>
								</td>
								<td>
									<input type="text" name="pseudoConnect" id="pseudoConnect" placeholder="Votre pseudo" value="<?php if (isset($pseudo)) { echo $pseudo; } ?>">
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="mdpConnect"> Mot de passe : </label>
								</td>
								<td>
									<input type="password" name="mdpConnect" id="mdpConnect" placeholder="Votre mot de passe" value="">
								</td>
							</tr>
							<tr>
								<td></td>
								<td align="left">
									<br>
									<input type="submit" name="formConnexion" value="Connexion"/>
								</td>	
							</tr>
						</table>
					</form>
					<?php
					if (isset($erreurConnexion)){
						echo "<br>";
						echo '<font color="red">'.$erreurConnexion. '</font>';
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- Fin connexion -->


	<!-- Inscription -->
	<section class="container-fluid inscription">
		<div class="container">
			<div class="row">
				<a class="col-md-12" href="crea_compte.php"> Cliquez sur ce lien pour créer un compte si vous n'en avez pas. </a>
			</div>
		</div>
	</section>
	<!-- Fin inscription -->

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