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
<title>produit</title>
<link rel="stylesheet" href ="css_projet_tuto/produit.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1 id="h1_med">Ajouter un nouveau produit</h1>
<div class="fms">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label for="nom_prod">Nom du produit</label><span>*</span></br>
<input required type="text" name="nom_prod" maxlength="50"/></br>
<div id="div_prod">
<label for="categ_prod">Catégorie</label><span>*</span></br>
<div id="List_cat"></div>
<input required type="text" id="categ_prod" name="categ_prod" maxlength="50"/></br>
<?php recherche_categorie();?>
</div>
<label for="prix_prod">Prix de revient du produit</label><span>*</span></br>
<input required type="floatval" name="prix_prod" MIN="0">
<div id="div_prod">
<label for="prix_vente">Prix de vente du produit</label><span>*</span></br>
<input required type="floatval" name="prix_vente" MIN="0"></br>
</div>
<label for="date_exp">Date d'expiration</label><span>*</span></br>
<input required type="date" name="date_exp">
<div id="div_prod">
<label for="nb_ech">Nombre d'échantillon à ajouter</label><span>*</span></br>
<input required type="number" MIN="1" name="nb_ech"/></br>
</div>
<label for="nb_ech_max">La quantité maximal autorisée</label><span>*</span></br>
<input required type="number"  MIN="1" name="nb_ech_max"/></br>
<div id="div_prod">
<label for="emp">Je le place à</label><span>*</span></br>
<div id="List_empl"></div>
<input required type="text" placeholder="nom emplacement" id="emp" name="emp"/><span id="sp"></span>
<?php /*recherche_emplacement();*/?>
<select name="zone"><span id="sp"></span>
<option>--Zone--</option>
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
</select>
<select name="range"><span id="sp"></span>
<option>-Rangé-</option>
<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select></div></br></br>
<input type="submit" class="submit" value="Enregistrer"/>
</form><br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',""); 
if(isset($_POST['nom_prod'])  && isset($_POST['categ_prod'])&& isset($_POST['prix_prod']) && isset($_POST['prix_vente']) && isset($_POST['date_exp'])&& isset($_POST['nb_ech']) && isset($_POST['nb_ech_max'])
&& isset($_POST['emp']) && isset($_POST['zone']) && isset($_POST['range'])) 	
 {
	$nom_prod=$_POST['nom_prod'];$categ_prod=$_POST['categ_prod'];$prix_prod=$_POST['prix_prod'];$prix_vente=$_POST['prix_vente'];$date_exp=$_POST['date_exp'];
	$nb_ech=$_POST['nb_ech'];$nb_ech_max=$_POST['nb_ech_max'];$emp=$_POST['emp'];$zone=$_POST['zone'];$range=$_POST['range'];
   
   if($bd)
	{
        $req="INSERT INTO produit VALUES ('$nom_prod','$categ_prod','$emp','$zone',$range,'$date_exp',$prix_prod,$prix_vente,$nb_ech,$nb_ech_max)";
        $r=$bd->exec($req);
        if($r)
		    echo "<span class='succ'>Produit enregistré!<span><br/>";
        else
		    echo "<span>Echec de l'enregistrement du produit<br/>Veuillez bien vous rassurer que vous avez déja créer l'emplacement que vous avez choisi pour stocker ce produit</span>";
        $bd=null;
    }
	else
		echo "<span>Echec da connexion a la base</span>";
}
?>
</div>
</body>
</html>