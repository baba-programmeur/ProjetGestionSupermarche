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
<title>sta selon périodes</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1 id="h1_selon_periode_php">Statistiques de vente selon les periodes</h1>
<div class="fms">
	<form id="form_selon_med" method="POST" action=""><br/>
	<label for="date_deb">Date de début de la periode</label><br/>
	<input required type="date" name="date_deb" class="input-date"/><br/>
	<label for="date_def">Date de début de la periode</label><br/>
	<input required type="date" name="date_def" class="input-date"/><br/><br/>
	<input type="submit" class="submit" value="Consulter"/><br/>
	</form ><br/><br/>
<?php
if(isset($_POST['date_deb']) && isset($_POST['date_def']))
{   
	$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($bd)
	{
		$nb_prod_v_p=0;
		$date_deb=$_POST['date_deb'];$date_def=$_POST['date_def'];
		if($date_deb<=$date_def)
		    $r=$bd->query("SELECT nb_ech_vendu,prix_vente FROM ventes where date_vente between '$date_deb' and '$date_def' ");
		else
			$r=$bd->query("SELECT nb_ech_vendu,prix_vente FROM ventes where date_vente between '$date_def' and '$date_deb' ");
		if($r)
		{
			$chiffre_daffaire=0;
			while($res=$r-> fetch())
			{
				$nb_prod_v_p+=$res['nb_ech_vendu'];
				$chiffre_daffaire+=$res['prix_vente'];
			}
			if($date_deb<=$date_def)
		        $re=$bd->query("SELECT DISTINCT nom_prod_v FROM ventes where date_vente between '$date_deb' and '$date_def' ");
		    else
				$re=$bd->query("SELECT DISTINCT nom_prod_v FROM ventes where date_vente between '$date_def' and '$date_deb' ");
		    if($re)
			{ 
				$i=0;
				while($res=$re->fetch())
				{
					$tab[$i]=$res['nom_prod_v'];
					$i++;
				}
				if($i!=0)
				{
					if($date_deb<=$date_def)
						echo "La boutique a vendu ".$nb_prod_v_p." produits dans la période du ".$date_deb." au ".$date_def." dont:<br/><br/>";
					else
						echo "La boutique a vendu ".$nb_prod_v_p." produits dans la période du ".$date_def." au ".$date_deb." dont:<br/><br/>";
					
					for($i=0;$i < count($tab) ;$i++)
					{
						if($date_deb<=$date_def)
							$r=$bd->query("SELECT nb_ech_vendu from ventes where nom_prod_v = '$tab[$i]' and (date_vente between '$date_deb' and '$date_def' ) ");
						else
							$r=$bd->query("SELECT nb_ech_vendu from ventes where nom_prod_v = '$tab[$i]' and (date_vente between '$date_def' and '$date_deb' ) ");
						
						if($r)
						{
							$nb_prod_v=0;
							while($res=$r->fetch())
								$nb_prod_v+=$res['nb_ech_vendu'];
							echo $nb_prod_v." ".$tab[$i]."<br/>";
							
						} 
						else
						{
							echo "<span>Eche  de la decompte<br/>";
							break;
						}
					}
					echo "Toutes les ventes de la boutique confondues dans cette periode dont une somme totale de ".$chiffre_daffaire." Fcfa";
				}
				else
					echo "<span class='avert'>La boutique n'a vendu aucun produit dans cette prériode<span><br/>";
			}
			else
				echo "<span>Une erreur inattendu  est survenue. veuillez reourner a la pages d'acceuille et reessayer</span<br/> ";
		}
		$bd=NULL;	
	}
	else
		echo "<span>Connexion a la base de donnees non etablie</span><br/>";
}
		    
      
?>
</div>
</body>
</html> 