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
<title>mise_a_j_stock</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Mise à jour du stock d'un produit</h1>
<div class="fms">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label for="nom_prod">Nom du produit</label><span>*</span></br>
<div id="List_prod"></div>
<input required type="text" name="nom_prod" id="nom_prod" maxlength="50"/></br></br>
<label for="nom_medic">Quantite a ajouter</label><span>*</span></br>
<input required type="number" name="quanti_ajout" maxlength="50"/></br></br>
<input type="submit" class="submit" value="Inserer"/></br>
</form>
<?php recherche_prod();?>
<br/><br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['nom_prod']) && isset($_POST['quanti_ajout']))
	{ 
	    $nom_prod=$_POST['nom_prod'];$quanti_ajout=$_POST['quanti_ajout'];
        $r=$bd->query("SELECT nom_prod,stock,stock_max  from produit where nom_prod LIKE '$nom_prod'");
		$res=$r->fetch();
		if($res)
	    {      
			$quantite_dispo=$quanti_ajout+$res['stock'];
			if($quantite_dispo<=$res['stock_max'])
			{
				$r=$bd->exec("UPDATE produit SET stock=$quantite_dispo where nom_prod LIKE '$nom_prod'");
				if($r)
					echo "<span class='succ'>Mise à jour du stock de $nom_prod éffectuée.<span><br/>";
				else
					echo "<span>Echec de la mise à jour du stock</span><br/>";
			}
			else
			{
				if($res['stock']==$res['stock_max'])
					echo "<span class='avert'>Le stock de $nom_prod à déja atteind le maximum ( ".$res['stock_max']." )</span>";
				else
				{
					$quantite_a_ajouter=$res['stock_max']-$res['stock'];
				    echo "<span class='avert'>Le nombre d'échantillons de ".$nom_prod." que vous souhaitez ajouter est trop grand. Vous devez en ajouter au maximum ".$quantite_a_ajouter."</span><br/>"; 
			    } 
			}					
	    } 
		else
		    echo "<span class='avert'>La boutique ne dispose pas de stock de ce produit</span><br/>";   
    }
	$bd=NULL;
}
else
	echo "<span>Connexion a la base KO</span>";
echo "<br/><br/><br/>";

?>
</div>
</body>
</html>
 