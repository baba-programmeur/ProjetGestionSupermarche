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
<title>consulter_prod</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Consulter les détailles d'un produit</h1>
<div class="fms">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label for="nom_prod">Nom du produit à consulter</label><span>*</span><br/>
<div id="List_prod"></div>
<input required type="text" name="nom_prod" id="nom_prod" maxlength="50"/><b/><br/><br/>
<input type="submit" class="submit" value="Consulter"/><br/>
</form>
<?php recherche_prod();?>
<br/><br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['nom_prod']))
	{ 
	   $nom_prod=$_POST['nom_prod'];
		$r=$bd->query("SELECT * FROM produit WHERE nom_prod = '$nom_prod' ");
		$res=$r->fetch();
		if($res)
		{  
			echo "<table>"; 
			echo "<tr><th>Nom</th><th>Catégorie</th><th>Nom emplacement</th><th>Zone</th><th>Rangé</th><th>Date d'expiration</th><th>Prix de revient</th><th>Prix de vente</th><th>Stock</th><th>Stock maximal</th></tr>";
			echo "<tr><td>".$res['nom_prod']."</td><td>".$res['nom_categ']."</td><td>".$res['nom_empl_conteneur']."</td><td>".$res['zone_conteneur']."</td><td> ".$res['range_conteneur']."</td><td>".$res['date_dexpiration']."</td><td>".$res['prix_revient']." Fcfa</td><td>".$res['prix_vente']." Fcfa</td><td>".$res['stock']."</td><td>".$res['stock_max']."</td></tr>";
			echo "</table>"; 
		} 
		else
			 echo "<span>La boutique n'a pas de stock de $nom_prod</span><br/>";      
	}
	
	$bd=NULL;
}
else
	echo "Connexion a la base KO<br/>";

?>
</div>
</body>
</html>