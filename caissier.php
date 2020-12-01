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
<title>caissier</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body id="bd_caissier">
<?php entete_boutique();?>
<a  id="retour" href="index.php" onclick="session_destroy()">Déconnexion</a>
<?php 
if($_SESSION['sexe']=="M")
	echo "<h1 id='h1_b'> Bienvenue Monsieur ".$_SESSION['nom']." vous etes le ".$_SESSION['type']." de la boutique <span id='dd' style='color:#ffffff;'>".afficher_date('dd')."</span></h1>";
else
	echo "<h1 id='h1_b'> Bienvenue Madame ".$_SESSION['nom']." vous etes une caissière de la boutique <span id='dd' style='color:#ffffff;'>".afficher_date('dd')."</span></h1>";
?>
<nav>
<ul class="list-unstyled">
	<li><a href="vente.php">Enregistrer une vente</a></li>
	<li><a href="modifierprofil.php">Modifier votre profil</a></li>
	<li><a href="consulter_prod.php">Consulter un produit</a></li>
	<li><a href="recherche.php">rechercher un produit</a></li>	
</ul>
</nav>
</body>
</html>