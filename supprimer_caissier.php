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
<title>supprimer caissier</title>
<link rel="stylesheet" href ="css_projet_tuto/gerant.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
</head>
<body id="bd_sup_c">
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Supprimer un caissier</h1></br></br>
<div class="fms">
<form method="POST" action="">
<label for="num_i_c">Numéro d'identité du caissier à supprimer</label><span id="span1">*</span></br>
 <div id="List_num"></div>
<input required type="text" id="num_i_c" name="num_i_c" maxlength="13"/></br></br>
<input type="submit" class="submit" value="Supprimer"/>
</form>
<?php recherche_num();?>
<br/><br/>
<p>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['num_i_c']))
    { 
        $num_i_c=$_POST['num_i_c'];
        $req=$bd->query("SELECT num_i_c,prenom,nom,status,groupe FROM caissier WHERE num_i_c='$num_i_c'");
		$req=$req->fetch();
		if($req)
		{   
	        $groupe=$req['groupe'];
	        $nb=$bd->query("SELECT 	nb_c_ajouter FROM groupe WHERE nom_groupe='$groupe'");
		    $nb=$nb->fetch();
			if($nb)
			{
				$re=$bd->exec("DELETE  FROM caissier WHERE num_i_c = '$num_i_c'");
				if($re)
				{   
					$r=$bd->exec("DELETE  FROM compte_personne WHERE num_i_n = '$num_i_c'");
					if($r)
					{
						$nb1=$nb['nb_c_ajouter'];
						$nb1=$nb1-1;
						if($req['status']==0)
						    $reqt=$bd->exec("update groupe set nb_c_ajouter= $nb1 WHERE nom_groupe='$groupe'");
						else
							$reqt=$bd->exec("update groupe set nb_c_ajouter= $nb1,mun_i_c_chef = '' WHERE nom_groupe='$groupe'");
						if($reqt)
					        echo "<span class='succ'>Suppression du caissier ".$req['prenom']." ".$req['nom']." de la base fait avec succée</span>";
					}
					else
						echo "<span>Echec de la suppression du caissier ".$req['prenom']." ".$req['nom']."</span>";;
				}
				else
					echo "<span>Echec de la suppression du caissier ".$req['prenom']." ".$req['nom']." de la base</span>";
			}
		} 
		else
			echo "<span>Le proprietaire de la carte d'identité numéro $num_i_c ne figure pas sur la liste des caissier de votre boutique.</span>";
	}	
}
else
	echo "<span>Erreur de connexion a la base</span><br/>";
?>
</p>
</div>
</body>
</html>