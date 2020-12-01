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
<title>Supprimer produit</title>
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
<h1>Supprimer un produit</h1>
<div  class="fms">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label for="nom_prod_sup">Donnez le nom du produit à supprimer</label><span>*</span></br>
<div id="List_prod"></div>
<input required type="text" name="nom_prod_sup" id="nom_prod" maxlength="50"/></br>
<input type="submit" class="submit" value="Supprimer"/>
</form>
<?php recherche_prod();?>
<br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',""); 
if(isset($_POST['nom_prod_sup'])) 	
 {
	$nom_prod_sup=$_POST['nom_prod_sup'];
    if($bd)
	{
        $req="DELETE FROM produit WHERE nom_prod LIKE '$nom_prod_sup'";
        $r=$bd->exec($req);
        if($r)
		    echo "Supprimer un produit!<br/>";
        else
		    echo "Echec de la supprimer du produit<br/>";
	    $bd=null;
    }
	else
		echo "Echec da connexion a la base";
}
?>
</div>
</body>
</html>