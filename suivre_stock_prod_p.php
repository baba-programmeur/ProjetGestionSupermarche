<!doctype html>
<?php 
session_start();
include('fonction.php');
if(!($_SESSION['login'] && $_SESSION['mdp']))
	header("Location:index.php");
?>
<html>
<meta charset="utf-8"/>
<head>
<title>suivre_stock</title>
<link rel="stylesheet" href ="css_projet_tuto/suivre_stock_prod.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="proprietaire.php">Retour à la page d'accueil</a>
<h1>Suivre les stock des produits</h1><br/><br/>
<div class="fms">
<?php
   $bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
   if($bd)
	{
        $r=$bd->query("SELECT * FROM  produit");
		if($r)
		{	echo "<table>"; 
			echo "<tr><th>Nom</th><th>Catégorie</th><th>Nom emplacement</th><th>Zone</th><th>Rangé</th><th>Date d'expiration</th><th>Prix de revient</th><th>Prix de vente</th><th>Stock</th><th>Stock maximal</th></tr>";
            while($res=$r->fetch())
		        echo "<tr><td>".$res['nom_prod']."</td><td>".$res['nom_categ']."</td><td>".$res['nom_empl_conteneur']."</td><td>".$res['zone_conteneur']."</td><td> ".$res['range_conteneur']."</td><td>".$res['date_dexpiration']."</td><td>".$res['prix_revient']." Fcfa</td><td>".$res['prix_vente']." Fcfa</td><td>".$res['stock']."</td><td>".$res['stock_max']."</td></tr>";
		    echo "</table>";
        }
		else
			echo "Echec du chargement des médicaments";
		$bd=NULL;
    }
	else
	    echo "Echec de la connexion a la base";
?>
</body>
</html>