// On recupère les données de la requête
var liste = <?php echo json_encode($listeEcoles); ?>;

/**
* Retourne le JSON créé
* @param liste La liste récupérée de la BDD
* @param modele Le type de données à ajouter (université, hotel, ...)
*/

function getGeoJSON(liste, modele = ""){
	var geoJSON = {
		"type": "FeatureCollection",
		"features": [],
		"modele": modele
	};
	// On parcourt les données de liste
	for (var i = 0; i < liste.length; i++){
		var ecole = liste[i];
		// On fabrique le feature à partir de l'école. Pour cela on l'initialise.
		var feature = {
			"type": "Feature",
			"geometry": {},
			"properties": {}
		};
		for (var key in ecole){
			if(key == "Coordonnees"){
				// Pour les coordonnees, on les ajoute dans la clé "geometry".
				feature.geometry = JSON.parse(ecole[key]);
			}
			else if(key = "Id"){
				// Pour la colonne (id) on l'ajoute dans la clé "id"
				feature[key] = ecole[key];
			}
			else{
				// Pour les autres colonnes (nom et autre) on les ajoute dans properties pour les afficher dans le popup
				feature.properties[key] = ecole[key];
			}
		}
		// Une fois le feature créé, on l'ajoute dans la clé "features" de notre objet "geoJSON"
		geoJSON.features.push(feature);
	}
	return geoJSON;
};

/**
 * Affiche un geoJSON sur une carte
 * @param geoJSON Le fichier GeoJSON
 * @param modele Le type GeoJSON
 */

 function displayGeoJSON(geoJSON, modele){
 	var iconCircle = L.Icon.extend({
 		options: {
 			shadowUrl: 'img/circle-16.png',
 			iconSize:     [38, 95],
 			shadowSize:   [50, 64],
 			iconAnchor:   [22, 94],
 			shadowAnchor: [4, 62],
 			popupAnchor:  [-3, -76]
 		}
 	});
 	var iconMarker = "";
 	if(modele == "ecole"){
 		iconMarker = new iconCircle({iconUrl: 'img/circle-16.png'});
 	}
 	// L.geoJson permet d'afficher le geoJSON passé en paramètres.
 	return L.geoJSON([geoJSON], {
 		// S'applique sur chaque feature de la couche
 		onEachFeature: function(feature, layer){
 			var affichage = "<h2> "+ modele + "</h2>";
 			for(var key in feature.properties){
 				affichage += "<p><strong>" + key + "</strong> : " + feature.properties[key] + "</p>";
 			}
 			console.log(affichage);
 			layer.bind(affichage);
 		},
 		pointToLayer: function(feature, latlng){
 			return L.marker(latlng, {icon: iconMarker});
 		}
 	}).addTo(mymap);
 };

 // On construit la donnée GeoJSON. On l'initialise (features = tableau vide)

 // On récupère le geoJSON
 var geoJSON_Ecoles = getGeoJSON(listeSchools, "ecole");

 // Une fois le GeoJSON construit, on l'affiche sur la carte.
 var geojsonLayer = displayGeoJSON(geoJSON_Ecoles, "ecole");


// Le controlelr
// var controlLayers = L.control.layers().addTo(mymap);
// Add the geojson layer to the layercontrol
controlLayers.addOverlay(geojsonLayer, 'Écoles');
