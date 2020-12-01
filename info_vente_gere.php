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
<title>statistiques</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
   <style>  
li
{  
	padding:2px;
	list-style:none;
	border:1px solid #ffffff;
	border-radius:15px;
	width:12em;	
	background-color:#eee;	
	text-align:center;				
} 
   </style> 
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="caissier_chef.php">Retour à la page d'accueil</a>
<h1 id="h1_sta_vente">Détails de vente de mon groupe</h1><br/>
<div class="fms">
</form><br/><br/>
<?php
$grpe=$_SESSION['groupe'];
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{
	$r=$bd->query("SELECT nb_ech_vendu from ventes where groupe = '$grpe' ");
	$r1=$bd->query("SELECT nb_ech_vendu from ventes where groupe = '$grpe' ");
	$r1=$r1->fetch();
	if($r1)
	{
		$nb_prod_v=0;
		while($res=$r->fetch())
			$nb_prod_v+=$res['nb_ech_vendu'];
		$r=$bd->query("SELECT DISTINCT nom_prod_v from ventes where groupe = '$grpe' ");
		if($r)
		{   $j=0;
			while($res=$r->fetch())
			{
				$nom_prod_vendu[$j]=$res['nom_prod_v'];
				$j++;
			}
		}
		$montant_v_g=0;
		echo "<table>";
		echo "<tr><th>".$grpe."</th><th>$nb_prod_v produits vendus</th></tr>";
		echo "<tr><th>Nom</th><th>Quantité totale vendu</th><th>Vendeur</th><th>Quantité vendue par caissier</th><th>Montant</th></tr>";
		for($k=0;$k < count($nom_prod_vendu) ;$k++)
		{
			//$nom_prod_vend=$nom_prod_vendu[$k];$n_g=$tab[$i];
			$r=$bd->query("SELECT SUM(nb_ech_vendu) AS nb_ech,SUM(prix_vente) AS som_total FROM ventes where nom_prod_v like '$nom_prod_vendu[$k]' and groupe like '$grpe'");
			$resultat=$r->fetch();
			if($resultat)
			{
				$montant_v_g+=$resultat['som_total'];
				$detail_vendeur=$bd->query("SELECT DISTINCT num_i_n_caissier from ventes where nom_prod_v like '$nom_prod_vendu[$k]' and groupe like '$grpe' ");
				$pn_nom="";$nbv="";
				while($res1=$detail_vendeur->fetch())
				{
					$vendeur=$res1['num_i_n_caissier'];
					$r1=$bd->query("SELECT SUM(nb_ech_vendu) AS nb_ech_vendu_par_lekl1_du_groupe from ventes where num_i_n_caissier like '$vendeur' and nom_prod_v like '$nom_prod_vendu[$k]' and groupe like '$grpe' ");
					$r1=$r1->fetch();
					if($r1)
					{
						$r2=$bd->query("SELECT prenom,nom from caissier where num_i_c like '$vendeur'");
						$r2=$r2->fetch();
						if($r2)
						{
							$pn_nom.=$r2['prenom']." ".$r2['nom']."<br/>";
							$nbv.=$r1['nb_ech_vendu_par_lekl1_du_groupe']."<br/>";	
						}
					}
				}	
				echo "<tr><td>$nom_prod_vendu[$k]</td><td>".$resultat['nb_ech']."</td><td>$pn_nom</td><td>$nbv</td><td>".$resultat['som_total']." Fcfa</td></tr>";
			}
		}
		echo "<tr><td colspan='5'>Montant total des ventes $montant_v_g Fcfa</td></tr>";
		echo "</table>";
	}
	else
		echo "<span>Echec de l'affichage des detaille de ventes du $grpe</span><br/>";
}
else
	echo "<span>Echec de la connection a la base</span><br/>";				
?>			
</div>
</body>
</html>