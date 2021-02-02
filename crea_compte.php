<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Création compte </title>

	<!-- font -->
	<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

	<!-- CSS Bootstrap -->
	<link rel="stylesheet" type="text/css" href="css/bootstrap-grid.min.css">

	<!-- Ma feuille de style CSS -->
	<link rel="stylesheet" type="text/css" href="css/crea_compte-style.css">
</head>
<body>
	<?php require('connexion.php'); // Connexion à la base de donnée ?>

	<?php
	if (isset($_POST['formInscription'])) // Vérification que le formulaire est validé. 
	{
		$nom = htmlspecialchars($_POST['nom']);
		$prenom = htmlspecialchars($_POST['prenom']);
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$email1 = htmlspecialchars($_POST['email1']);
		$email2 = htmlspecialchars($_POST['email2']);
		$mdp1 = md5($_POST['mdp1']);						// Pas super sécurisé à priori --> plutot utiliser password_hash.
		$mdp2 = md5($_POST['mdp2']);

		if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['email1']) && !empty($_POST['email2']) && !empty($_POST['mdp1']) && !empty($_POST['mdp2']))		// Vérification que tous les champs sont remplis.
		{
			$nomLength = strlen($nom);
			$prenomLength = strlen($prenom);
			$pseudoLength = strlen($pseudo);
			$email1Length = strlen($email1);
			// Vérification que les champs remplis font moins de 255 caractères :
			if (($nomLength <= 255) && ($prenomLength <= 255) && ($pseudoLength <= 255) && ($email1Length <= 255)){
				// Vérification que les deux emails sont identiques :
				if ($email1 == $email2){
					if (filter_var($email1, FILTER_VALIDATE_EMAIL)){  // Pour valider qu'on rentre bien un email.
						// Vérification que le mail inscrit n'existe pas déjà dans la BDD :
						$reqMail = "SELECT email FROM users WHERE users.email = '$email1'";
						$reqMail_query = mysqli_query($connexion, $reqMail);
						$mailExiste = mysqli_num_rows($reqMail_query);
						if ($mailExiste == 0){
							// Si le mail n'existe pas dans la BDD, vérification que le pseudo n'est pas déjà utilisé :
							$reqPseudo = "SELECT pseudo FROM users WHERE users.pseudo = '$pseudo'";
							$reqPseudo_query = mysqli_query($connexion, $reqPseudo);
							$pseudoExiste = mysqli_num_rows($reqPseudo_query);
							if ($pseudoExiste == 0){
								// Si le pseudo n'existe pas dans la BDD, vérification que les emails sont identiques :
								if ($mdp1 == $mdp2){
									// Si tout ce qui précède est OK, alors on insère l'utilisateur dans la BDD :
									$insertUserInUsers = "INSERT INTO users (nom, prenom, pseudo, email, password) VALUES ('$nom', '$prenom', '$pseudo', '$email1', '$mdp1')";
									$insertUserInUsers_query = mysqli_query($connexion, $insertUserInUsers);
									$erreurInscription = "Bienvenue  ". $prenom. " " .$nom.  ". Votre inscription a bien été prise en compte.";
								}
								else{
									$erreurInscription = "Les deux mots de passe ne sont pas identiques.";
								}
							}
							else{
								$erreurInscription = "Le pseudo que vous avez inscrit est déjà utilisé.";
							}
						}
						else{
							$erreurInscription = "Le mail que vous avez inscrit existe déjà.";
						}
					}
					else{
						$erreurInscription = "Votre adresse mail n'est pas valide";
					}
				}
				else{
					$erreurInscription = "Les deux adresses mail ne sont pas identiques.";
				}
			}
			else{
				$erreurInscription = "Les champs remplis ne peuvent excéder 255 caractères !";
			}
		}
		else
		{
			$erreurInscription = "Tous les champs doivent être complétés !";
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

	<!-- Inscription -->
	<section class="container-fluid inscription">
		<div class="container">
			<div class="row">
				<div align="center" class="col-md-12">
					<h2> Inscription </h2>
					<p> Veuillez renseigner les champs ci dessous : </p>
				</div>
			</div>
			<div class="row">
				<div align="center" class="col-md-12">
					<!-- FORMULAIRE D'Inscription -->
					<form action="#" method="POST">
						<table>
							<tr>
								<td align="right">
									<label for="nom"> Nom : </label>    <!-- le for permet de renvoyer directement sur la case de l'id "nom" -->
								</td>
								<td>
									<input type="text" name="nom" id="nom" placeholder="Votre nom" value="<?php if (isset($nom)) { echo $nom; } ?>">	<!-- le php dans value permet de garder en mémoire ce qu'on a écrit -->
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="prenom"> Prénom : </label>
								</td>
								<td>
									<input type="text" name="prenom" id="prenom" placeholder="Votre prénom" value="<?php if (isset($prenom)) { echo $prenom; } ?>">
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="pseudo"> Pseudo : </label>
								</td>
								<td>
									<input type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" value="<?php if (isset($pseudo)) { echo $pseudo; } ?>">
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="email1"> Email : </label>
								</td>
								<td>
									<input type="email" name="email1" id="email1" placeholder="Votre email" value="<?php if (isset($email1)) { echo $email1; } ?>">
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="email2"> Confirmation de l'email : </label>
								</td>
								<td>
									<input type="email" name="email2" id="email2" placeholder="Votre email" value="<?php if (isset($email2)) { echo $email2; } ?>">
								</td>
							</tr>
							<tr>
								<td align="right">
									<label for="mdp1"> Mot de passe : </label>
								</td>
								<td>
									<input type="password" name="mdp1" id="mdp1" placeholder="Votre mot de passe" value="">
								</td>
							</tr>
							<tr>
								<td>
									<label for="mdp2"> Confirmation du mot de passe : </label>
								</td>
								<td align="right">
									<input type="password" name="mdp2" id="mdp2" placeholder="Votre mot de passe" value="">
								</td>
							</tr>
							<tr>
								<td></td>
								<td align="left">
									<br>
									<input type="submit" name="formInscription" value="Inscription"/>
								</td>	
							</tr>
						</table>
					</form>
					<?php
					if (isset($erreurInscription)){
						echo "<br>";
						echo '<font color="red">'.$erreurInscription. '</font>';
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<!-- Fin inscription -->

	<!-- Connexion -->
	<section class="container-fluid connexion">
		<div class="container">
			<div class="row">
				<a class="col-md-12" href="identification.php"> Cliquez sur ce lien pour vous connecter si vous avez déjà un compte. </a>
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