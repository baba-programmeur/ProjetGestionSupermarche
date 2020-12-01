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
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
<title>Recherche</title>
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="caissier_chef.php">Retour à la page d'accueil</a>
<div class="fms">
<form method='POST' action='<?php echo $_SERVER["PHP_SELF"]?>'>
<div id="List_prod"></div>
<input required type="search" placeholder="nom du produit" id="nom_prod" name="recherche"/></br>  
<input type="submit" value= "Rechercher" class="submit"/> </br>
</form>
<?php recherche_prod();?>
</br></br></br></br>
<?php
$db=new PDO("mysql:host=127.0.0.1;dbname=boutique","root","");
if($db)
{
	if(isset($_POST['recherche']))
	{   
		$faty=$_POST['recherche'];
		$reqt=$db->prepare("select * from produit where nom_prod like '$faty'");
		$reqt->execute(array('nom_prod'=>$_POST['recherche']));
		if($ligne=$reqt->fetch())
		{
			echo "<span class='succ'><h2>Resultat de la recherche</h2></span>";  
			echo "<table ><tr><th>nom du produit</th><th>categorie</th><th>emplacement</th><th>zone</th><th>Range</th> <th>date dexpiration</th> <th>prix_revient</th> <th>prix_vente</th> <th>Stock</th> <th>stock_max</th></tr>";
			echo "<td>" .$ligne['nom_prod']. "<td>" .$ligne['nom_categ'].  "<td>" .$ligne['nom_empl_conteneur']. "<td>" .$ligne['zone_conteneur']. "<td>" .$ligne['range_conteneur']. "<td>".$ligne['date_dexpiration'].  "<td>" .$ligne['prix_revient'].  "<td>" .$ligne['prix_vente'].   "<td>" .$ligne['stock']."<td>" .$ligne['stock_max']." </td></td></td></td></td></td></td></td></td></tr>";
			echo "</table>"; 
		}
		else
			echo "<span><h2>La boutique n'a pas de stock de $faty</h2></span>";
	} 
}
else
	echo "<span>Erreur de connexion a la base</span>";
   ?> 
 </div>
 </body>
 
 </html>