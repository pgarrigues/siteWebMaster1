<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Établissements hospitaliers P1</title>

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
	<link rel="stylesheet" type="text/css" href="css/etab_scolaires_1.css">
</head>
<body>
	<?php
	session_start();
	require('connexion.php'); // Connexion à la base de donnée.
	include('coordonnees.php');

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
			<a href="profil_user.php?id=<?php echo $_SESSION['id']; ?>"> <?php echo $message; ?></a>
			<a href="indexSiteWeb.php?id=<?php echo $_SESSION['id']; ?>"> Retour à l'accueil </a>
			<a href="#contact"> Contact </a>
			<a href="deconnexion_site.php"> Déconnexion </a>
		</div>
	</header>
	<!-- Fin header -->

	<!-- MAP -->
	<section class="container-fluid map_section">
		<div class="container">
			<div class="row">
				<div id="formulaire" class="col-md-4">
					<p> Trouvez toutes les établissements hospitaliers d'une commune :</p>
					<?php
					$selectionCommune = "SELECT DISTINCT VILLE FROM etab_hospitaliers ORDER BY VILLE";
					$resultatSelectionCommune = mysqli_query($connexion, $selectionCommune);
					?>
					<form action="#" method="post">
						<select name="communeChoixHosp">
							<?php while($row1 = mysqli_fetch_array($resultatSelectionCommune)):; ?>
								<option value="<?php echo $row1[0]?>"> <?php echo $row1[0]; ?> </option>
							<?php endwhile; ?>
						</select>
						<input type="submit" name="submit" value="Valider" />
					</form>
					<br>
					<?php
					if(isset($_POST['submit'])){
						$selected_val = $_POST['communeChoixHosp'];
						//echo "Vous avez sélectionné la commune " .$selected_val. ".";
						//echo "<br>";
					}
					else{
						echo "Vous n'avez pas encore fait de choix.";
						echo "<br>";
					}
					if(isset($selected_val)){
						$selectionEtabHosp = "SELECT etab_hospitaliers.RAISON_SOCIALE AS Nom, etab_hospitaliers.ADRESSE_COMPLETE AS Adresse FROM etab_hospitaliers WHERE etab_hospitaliers.VILLE = '$selected_val' ORDER BY RAISON_SOCIALE ASC";
						$resultatSelectionEtabHosp = mysqli_query($connexion, $selectionEtabHosp);
						$compteur = 1;
						?>
						<table>
							<?php
							echo "<br>";
							if ($resultatSelectionEtabHosp == true){
						// Récupération de la première ligne --> entetes:
								$entete = mysqli_fetch_assoc($resultatSelectionEtabHosp);
								echo "<tr>";
								foreach ($entete as $key => $value) {
									echo "<td><strong>".$key."</td>";
								}
								echo "</tr>";
								echo "<tr>";
								foreach ($entete as $key => $value) {
									echo "<td>".$value."</td>";
								}
								echo "</tr>";
								while ($ligne = mysqli_fetch_assoc($resultatSelectionEtabHosp)){
									echo "<tr>";
									echo "<td>".$ligne['Nom']."</td>";
									echo "<td>".$ligne['Adresse']."</td>";
									echo "</tr>";
									$compteur = $compteur + 1;
								}
							}
							?>
						</table>
						<?php
					}
					?>
				</div>
				<div class="col-md-8">
					<?php
					if(isset($selected_val)){
						echo "Commune séléctionnée : ".$selected_val. " | " .$compteur. " résultats.";
						echo "<br>";
						echo "<br>";
					}
					?>
					<div id="mapid"></div>
				</div>
			</div>
		</div>
	</section>
	<!-- Fin MAP -->

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

	<!-- Script JS -->
	<!-- <script src="js/map-script.js">
	</script> -->

	<!-- Script JS - Ajout des départements -->
	<script src="js/departement-IDF.js"></script>

	<!-- Script JS - Ajout des régions  -->
	<script src="js/regions.js"></script>


	<script type="text/javascript">

		// Copyrights Openstreetmap
		var mbAttr = 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		mbUrl = 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
		
		// Données des fonds de plan
		var grayscale   = L.tileLayer(mbUrl, {id: 'mapbox.light', attribution: mbAttr}),
		streets  = L.tileLayer(mbUrl, {id: 'mapbox.streets',   attribution: mbAttr}),
		original = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
			'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
			id: 'mapbox/streets-v11',
			tileSize: 512,
			zoomOffset: -1});

		// Carte
		var mymap = L.map('mapid', {
			center: [48.8534, 2.3488], // Centrer par défaut --> Paris
			zoom: 8, // Zoom par défaut
			layers: [original] // Fonds de carte
		});

		// Nom des fonds de carte qui vont apparaitre sur la carte
		var baseLayers = {
			"Original" : original,
			"Rues": streets,
			"Grayscale": grayscale
		};

		
		// Ajouter le controle layer : Permet d'ajouter des couches sur l'objet mymap
		var controlLayers = L.control.layers(baseLayers).addTo(mymap);


		// Etablissements hospitaliers ///

		// On recupère les données de la requête de sélection des établissement hospitaliers.
		var listeEtabHosp = <?php echo json_encode($listeEtabHosp); ?>;

		/**
		* Retourne le JSON créé
		* @param liste La liste récupérée de la BDD
		* @param modele Le type de données à ajouter (université, hotel, ...)
		*/

		function getGeoJSON(liste, modele=""){
			var geoJSON = {
				"type": "FeatureCollection",
				"features": [],
				"modele": modele
			};
			// On parcourt les données de liste
			for (var i = 0; i < liste.length; i++){
				var Hosp = liste[i];
				// On fabrique le feature à partir de l'établissement hospitalier. Pour cela on l'initialise.
				var coord = "";
				var feature = {
					"type": "Feature",
					"geometry": {},
					"properties": {}
				};
				for (var key in Hosp){
					if(key == "Coordonnees"){
					// Pour les coordonnees, on les ajoute dans la clé "geometry".
					feature.geometry = JSON.parse(Hosp[key]);
					}
					else{
					// Pour les autres colonnes (nom et autre) on les ajoute dans properties pour les afficher dans le popup
					feature.properties[key] = Hosp[key];
					}
				}
				// Une fois le feature créé, on l'ajoute dans la clé "features" de notre objet "geoJSON"
				geoJSON.features.push(feature);
			}
			return geoJSON;
		};		
		
		// On récupère le geoJSON
 		var geoJSON_EtabHosp = getGeoJSON(listeEtabHosp, "Hosp");
		
		console.log(Object.values(geoJSON_EtabHosp));

		function displayGeoJSON(geoJSON, modele){
			var iconCircle = L.Icon.extend({
				options: {
					shadowUrl: 'img/circle-16.png',
					iconSize:     [10, 10],
					shadowSize:   [0, 0],
					iconAnchor:   [0, 0],
					shadowAnchor: [0, 0],
					popupAnchor:  [0, 0]
				}
			});
			var iconMarker = "";
			if(modele == "Hosp"){
				iconMarker = new iconCircle({iconUrl: 'img/circle-16.png'});
			}
 			// L.geoJson permet d'afficher le geoJSON passé en paramètres.
 			return L.geoJSON([geoJSON], {
 			// S'applique sur chaque feature de la couche
 			onEachFeature: function(feature, layer){
 				var affichage = "";
 				for(var key in feature.properties){
 					affichage += "<p><strong>" + key + "</strong> : " + feature.properties[key] + "</p>";
 				}
 				console.log(affichage);
 				layer.bindPopup(affichage);
 			},
 			pointToLayer: function(feature, latlng){
 				return L.marker(latlng, {icon: iconMarker});
 			}
 		}).addTo(mymap);
 		};

 		// Une fois le GeoJSON construit, on l'affiche sur la carte.
 		var geojsonLayer = displayGeoJSON(geoJSON_EtabHosp, "Hosp");

 		// Add the geojson layer to the layercontrol
		controlLayers.addOverlay(geojsonLayer, 'Établissements hospitaliers');



		// DEPARTEMENTS ///

		console.log(Object.values(departements_IDF));

		// Une fois le GeoJSON construit, on l'affiche sur la carte.
 		var geojsonLayerDepsIDF = displayGeoJSON(departements_IDF, "Départements_IDF");

 		// Add the geojson layer to the layercontrol
		controlLayers.addOverlay(geojsonLayerDepsIDF, 'Départements_IDF');


		// REGIONS ///
		
		// Une fois le GeoJSON construit, on l'affiche sur la carte.
 		var geojsonLayerRegions = displayGeoJSON(regioooons, "Régions");

 		// Add the geojson layer to the layercontrol
		controlLayers.addOverlay(geojsonLayerRegions, 'Régions');

	</script>

</body>
</html>