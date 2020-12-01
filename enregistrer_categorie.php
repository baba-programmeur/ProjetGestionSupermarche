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
<title>catégorie</title>
<link rel="stylesheet" href ="css_projet_tuto/categorie.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1 id="h1_sec">Ajouter une nouvelle catégorie</h1>
<div  class="fms"> 
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label class="label_sec" for="emplacement">Nom catégorie</label><span id="span1">*</span></br>
<input required type="text" id="input_emplacement" name="nom_categ" maxlength="50"/></br>

<label class="label_sec" for="description">Description</label><span>*</span></br>
<textarea name="description" cols="45" rows="6">
</textarea><br/><br/><br/>


<input type="submit" class="submit" value="Ajouter"/>
</form>
<br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if(isset($_POST['nom_categ']) && isset($_POST['description']))
 {
	$nom_categ=$_POST['nom_categ'];$description=$_POST['description']; 
    if($bd)
	{
        $req="INSERT INTO categorie VALUES('$nom_categ','$description')";
        $r=$bd->exec($req);
        if($r)
		    echo "<span class='succ'>$nom_categ enregistré!<br/>";
        else 
		    echo "<span class='avert'>La catégorie $nom_categ existe déja dans la base!</span><br/>";
    }
	else
	    echo "<span>Echec de la connexion a la base</span>";
}
?>
</div>
</body>
</html>