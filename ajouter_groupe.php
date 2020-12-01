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
<title>nouveau groupe</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1 id="h1_compte">Création d'un nouveau groupe</h1>
<div class="fms">
<form method="POST" action="">
<label for="nom_groupe">Nom groupe</label><span id="span1">*</span></br>
<input required type="text" id="nom_groupe" name="nom_groupe" maxlength="20"/></br>

<label for="nbre">Effectif</label><span id="span1">*</span></br>
<input required type="nunmber" id="nbre" name="nbre" min="1"/></br>
</br>
<input type="submit" class="submit" value="Créer"/>
</form>
<br/><br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['nom_groupe']) && isset($_POST['nbre']))
	{ 
	   $nom_groupe=$_POST['nom_groupe'];$nbre=$_POST['nbre'];
        $r=$bd->query("insert into groupe values ('$nom_groupe','',0,$nbre,0)");
		if($r)
            echo "<span class='succ'>Groupe créer avec succé!</span>";  
		else
			echo "<span>Ce groupe existe déja ou une erreur c'est produit durant la création du groupe.<br/>Veuillez reessayer</span>"; 
	}
	$bd=NULL;
}
else
	echo "<span>Erreur de connexion a la base</span><br/>";
?>
</div>
</body>
</html>