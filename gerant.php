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
<title>gérant</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>

<body id="bd_gerant">
<?php entete_boutique();?>
<a id="retour" href="index.php" onclick="session_destroy()">Déconnexion</a>
<?php 
if($_SESSION['sexe']=="M")
	echo "<h1 id='h1_b'> Bienvenue Monsieur ".$_SESSION['nom']." vous etes le ".$_SESSION['type']." de la boutique <span id='dd'>".afficher_date('dd')."</span></h1>";
else
	echo "<h1 id='h1_b'> Bienvenue Madame ".$_SESSION['nom']." vous etes la ".$_SESSION['type']."e de la boutique <span id='dd'>".afficher_date('dd')."</span></h1>";
?>
<nav>
<ul class="list-unstyled">
	<li><a class="f">Gestion des produits</a>
		<ul>
			<li><a href="enregistrer_prod.php">Enregistrer produits</a></li>
			<li><a href="enregistrer_categorie.php">Enregistrer catégorie</a></li>
			<li><a href="supprimer_prod.php">Supprimer un  produit</a></li>
			<li><a href="consulter_prod_gerant.php">Consulter un produit</a></li>
			<li><a href="suivre_stock_prod.php">Suivre stock des produits</a></li>
			<li><a href="mise_a_joue_prod.php">Mettre à jour stock</a></li>
			<li><a href="emplacement.php">Ajouter un nouveau emplacement</a></li>
		</ul>
	</li>
    <li><a>Gestion du personnel</a>
	    <ul>
			
			<li><a href="ajouter_groupe.php">Créer un nouveau groupe</a></li>
			<li><a href="acte_desact_groupe.php">Activer / Désactiver un groupe</a></li>
			<li><a href="enregistrer_caissier.php">Enregistrer un caissier</a></li>
			<li><a href="modifierprofil_par_gerant.php">Modifier le profil d'un caissier</a></li>
            <li><a href="supprimer_caissier.php">Supprimer un caissier</a></li>	
            <li><a href="supprimer_groupe.php">Supprimer un groupe</a></li>			
			<li><a href="afficher_personnel.php">Liste du personnel de la boutique</a></li>
      	</ul>
	</li>
	<li><a>Statistiques et details de groupe</a>
        <ul>			
			<li><a href="info_vente_groupe.php">Affichager ventes d'un groupe</a></li> 		
			<li><a href="statistiques.php">Statistiques de ventes</a></li>	
			<li><a href="supprimer_historic_vente.php">Supprimer l'historique de vente</a></li>	
        </ul>	
	</li>
 
</ul>
</nav>
</body>
</html>