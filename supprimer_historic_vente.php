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
<title>supprimer old vente</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<style>   
 </style> 
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Supprimer les historiques de ventes</h1></br></br>
<div class="fms">
<form id="form_selon_med" method="POST" action=""><br/>
	<label for="date_deb">Date de début</label><br/>
	<input required type="date" name="date_deb" class="input-date"/><br/>
	<label for="date_def">Date de fin</label><br/>
	<input required type="date" name="date_def" class="input-date"/><br/><br/>
	<input type="submit" class="submit" value="Consulter"/><br/>
	</form ><br/><br/>
<?php
if(isset($_POST['date_deb']) && isset($_POST['date_def']))
{   
	$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($bd)
	{
		$date_deb=$_POST['date_deb'];$date_def=$_POST['date_def'];
		if($date_deb<=$date_def)
		{
		    $r=$bd->exec("DELETE  FROM ventes where date_vente between '$date_deb' and '$date_def' ");
			if($r)
			    echo "<span class='succ'>Suppression de toute l'historique de vente de $date_deb à $date_def effectuer avec succé!</span>";
			else
				echo "<span class='avert'>Aucun historique de vente n'a été enregistrer dans cette période</span>";
		}
		else
		{
			$r=$bd->exec("DELETE FROM ventes where date_vente between '$date_def' and '$date_deb' ");
		    if($r)
			    echo "<span class='succ'>Suppression de toute l'historique de vente de $date_def à $date_deb effectuer avec succé!</span>";
			else
				echo "<span class='avert'>Aucun historique de vente n'a été enregistrer dans cette période</span>";
		}
	}			
	else
		echo "<span>Connexion a la base de donnees non etablie</span><br/>";
}      
?>
</div>
</body>
</html>