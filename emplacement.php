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
<title>créer un emplacement</title>
<link rel="stylesheet" href ="css_projet_tuto/emplacement.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1 id="h1_sec">Ajouter un nouveau emplacement</h1>
<div  class="fms">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label class="label_sec" for="emp">Nom de l'emplacement</label><span id="span1">*</span></br>
<input required type="text" id="input_emplacement" name="emp" maxlength="50"/></br>
<label class="label_sec" for="capacite">Capacité de stockage de l'emplacement</label><span>*</span></br>
<input required type="number" MIN="1" class="input_capacite" name="capacite" maxlength="50"/></br></br>
<input type="submit" class="submit" value="Ajouter"/>
</form>
<br/><br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if(isset($_POST['emp']) && isset($_POST['capacite']))
 {
	$emp=$_POST['emp'];$capacite=$_POST['capacite'];
   
   if($bd)
	{
        $req="INSERT INTO emplacement VALUES('$emp','$capacite',3,5)";
        $r=$bd->exec($req);
        if($r)
		    echo "<span class='succ'>$emp enregistré!</span><br/>";
        else 
		    echo "<span>Echec de l'enregistrement du $emp!<br/>";
    }
	else
	    echo "<span>Echec de la connexion a la base</span>";
}
?>
</div>
</body>
</html>