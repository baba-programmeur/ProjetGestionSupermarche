<!doctype html>
<?php 
session_start();
include('fonction.php');
if(!($_SESSION['login'] && $_SESSION['mdp']))
	header("Location:index.php");
?>
<html>
<head>
<meta charset="utf-8"/>
<title>proprietaire</title>
<link rel="stylesheet" href ="css_projet_tuto/proprietaire.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="index.php" onclick="session_destroy()">Déconnexion</a>
<?php 
if($_SESSION['sexe']=="M")
	echo "<h1 id='h1_b'> Bienvenue Monsieur ".$_SESSION['nom']." vous etes le ".$_SESSION['type']." de la boutique <span id='dd' style='color:#ffffff;'>".afficher_date('dd')."</span></h1>";
else
	echo "<h1 id='h1_b'> Bienvenue Madame ".$_SESSION['nom']." vous etes la propriétaire de la boutique <span id='dd' style='color:#ffffff;'>".afficher_date('dd')."</span></h1>";
?>
<nav>
<ul>
	<li><a>Gérant de ma boutique</a>
		<ul>
			<li><a href="ajouter_gerant.php">Enregistrer un gerant</a></li>
			<li><a href="afficher_personnel_proprietaire.php">Afficher le personnel</a></li>
			<li><a href="gestion_gerant.php">Supprimer un gérant</a></li>
			<!--<li><a href="desact_gerant.php">Désactiver le compte du gérant</a></li>-->
		</ul>
	</li>
    <li><a>Surveiller ma boutique</a>
	    <ul>
			<li><a href="suivre_stock_prod_p.php">Consulter les stock</a></li>
			<li><a href="statistiques_p.php">Statistiques de ventes</a></li>	
		</ul>
	</li>

</ul>
</nav>

<p>

</p>











</body>
</html>