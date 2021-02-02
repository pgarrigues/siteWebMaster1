<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title> Coordonnées </title>
</head>
<body>
	<?php
	require('connexion.php'); // Connexion à la base de donnée.

    //////// Code concernant la page etab_scolaires_1.php ////////

	// Choix de la commune envoyée par le formulaire :
    if (isset($_POST['communeChoix'])) {
        $commune_nom = $_POST['communeChoix'];
    }
    else {
        $commune_nom = NULL;
    }

    if(isset($commune_nom)){
        $requeteEcoles = "SELECT ecoles.type AS type, ecoles.nom_officiel AS nom, ecoles.adresse AS adresse, ecoles.longitude AS longitude, ecoles.latitude AS latitude, ecoles.code_postal AS code_postal, ecoles.commune AS commune FROM ecoles WHERE ecoles.commune = '$commune_nom'";
    	$resultatRequeteEcoles = mysqli_query($connexion, $requeteEcoles);
    }
    
    $listeEcoles = array();
    if(isset($commune_nom)){
    	if($resultatRequeteEcoles == true){
    		while ($row = mysqli_fetch_assoc($resultatRequeteEcoles)){
                // On construit un geoJSON de type POINT :
                $my_geoJSON = '{ "type": "Point", "coordinates": ['.$row['longitude'].' ,'.$row['latitude'].'] }';
                $listeEcoles[] = array('Nom' => $row['nom'], 'Adresse' => $row['adresse'], 'Code postal' => $row['code_postal'], 'Commune' => $row['commune'], 'Coordonnees' => utf8_encode($my_geoJSON));
                //print_r($listeEcoles);
    		}
    	}
    }

    //////// Code concernant la page etab_scolaires_2.php ////////

    if (isset($_POST['typeChoix'])) {
        if(isset($_POST['departementChoix'])){
            $type_nom = $_POST['typeChoix'];
            $departement_nom = $_POST['departementChoix'];
        }
    }
    else {
        $type_nom = NULL;
        $departement_nom = NULL;
    }

    if(isset($type_nom)){
        if(isset($departement_nom)){
            $requeteEcolesBis = "SELECT ecoles.type AS type, ecoles.nom_officiel AS nom, ecoles.adresse AS adresse, ecoles.longitude AS longitude, ecoles.latitude AS latitude, ecoles.code_postal AS code_postal, ecoles.commune AS commune FROM ecoles WHERE ecoles.type = '$type_nom' AND ecoles.departement = '$departement_nom'";
            $resultatRequeteEcolesBis = mysqli_query($connexion, $requeteEcolesBis);
        }
    }

    $listeEcolesBis = array();
    if(isset($type_nom)){
        if(isset($departement_nom)){
            if($resultatRequeteEcolesBis == true){
                while ($row = mysqli_fetch_assoc($resultatRequeteEcolesBis)){
                // On construit un geoJSON de type POINT :
                    $my_geoJSONbis = '{ "type": "Point", "coordinates": ['.$row['longitude'].' ,'.$row['latitude'].'] }';
                    $listeEcolesBis[] = array('Nom' => $row['nom'], 'Adresse' => $row['adresse'], 'Code postal' => $row['code_postal'], 'Commune' => $row['commune'], 'Coordonnees' => utf8_encode($my_geoJSONbis));
                //print_r($listeEcoles);
                }
            }
        }
    }


    //////// Code concernant la page etab_hospitaliers_1.php ////////

    // Choix de la commune envoyée par le formulaire :
    if (isset($_POST['communeChoixHosp'])) {
        $commune_nom_hosp = $_POST['communeChoixHosp'];
    }
    else {
        $commune_nom_hosp = NULL;
    }

    if(isset($commune_nom_hosp)){
        $requeteEtabHosp = "SELECT etab_hospitaliers.TYPE_ETABLISSEMENT AS type_hosp, etab_hospitaliers.RAISON_SOCIALE AS nom_hosp, etab_hospitaliers.ADRESSE_COMPLETE AS adresse_hosp, etab_hospitaliers.CP_VILLE AS code_postal_commune, etab_hospitaliers.lat AS latitude_hosp, etab_hospitaliers.lng AS longitude_hosp FROM etab_hospitaliers WHERE etab_hospitaliers.VILLE = '$commune_nom_hosp'";
        $resultatRequeteEtabHosp = mysqli_query($connexion, $requeteEtabHosp);
    }
    
    $listeEtabHosp = array();
    if(isset($commune_nom_hosp)){
        if($resultatRequeteEtabHosp == true){
            while ($row = mysqli_fetch_assoc($resultatRequeteEtabHosp)){
                // On construit un geoJSON de type POINT :
                $my_geoJSONhosp = '{ "type": "Point", "coordinates": ['.$row['longitude_hosp'].' ,'.$row['latitude_hosp'].'] }';
                $listeEtabHosp[] = array('Type' => $row['type_hosp'], 'Nom' => $row['nom_hosp'], 'Adresse' => $row['adresse_hosp'], 'Code postal & commune' => $row['code_postal_commune'], 'Coordonnees' => utf8_encode($my_geoJSONhosp));
                //print_r($listeEtabHosp);
            }
        }
    }


    //////// Code concernant la page etab_hospitalier_2.php ////////

    if (isset($_POST['typeChoixHosp'])) {
        if(isset($_POST['departementChoixHosp'])){
            $type_nom_hosp = $_POST['typeChoixHosp'];
            $departement_nom_hosp = $_POST['departementChoixHosp'];
        }
    }
    else {
        $type_nom_hosp = NULL;
        $departement_nom_hosp = NULL;
    }

    if(isset($type_nom_hosp)){
        if(isset($departement_nom_hosp)){
            $requeteHospBis = "SELECT etab_hospitaliers.TYPE_ETABLISSEMENT AS type_hosp, etab_hospitaliers.RAISON_SOCIALE AS nom_hosp, etab_hospitaliers.ADRESSE_COMPLETE AS adresse_hosp, etab_hospitaliers.CP_VILLE AS code_postal_commune, etab_hospitaliers.lat AS latitude_hosp, etab_hospitaliers.lng AS longitude_hosp FROM etab_hospitaliers WHERE etab_hospitaliers.TYPE_ETABLISSEMENT = '$type_nom_hosp' AND etab_hospitaliers.DEPT = '$departement_nom_hosp'";
            $resultatRequeteHospBis = mysqli_query($connexion, $requeteHospBis);
        }
    }

    $listeHospBis = array();
    if(isset($type_nom_hosp)){
        if(isset($departement_nom_hosp)){
            if($resultatRequeteHospBis == true){
                while ($row = mysqli_fetch_assoc($resultatRequeteHospBis)){
                // On construit un geoJSON de type POINT :
                    $my_geoJSON_HospBis = '{ "type": "Point", "coordinates": ['.$row['longitude_hosp'].' ,'.$row['latitude_hosp'].'] }';
                    $listeHospBis[] = array('Type' => $row['type_hosp'], 'Nom' => $row['nom_hosp'], 'Adresse' => $row['adresse_hosp'], 'Code postal & commune' => $row['code_postal_commune'], 'Coordonnees' => utf8_encode($my_geoJSON_HospBis));
                //print_r($listeEcoles);
                }
            }
        }
    }

    
	?>

</body>
</html>