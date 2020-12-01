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
<title>Enregistrer un gerant</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href ="css_projet_tuto/produit.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="proprietaire.php">Retour à la page d'acceuil</a>
<h1>Enregistrer un nouvaux gerant</h1>
<div class="fms">
<form method="POST" action="">
<label for="num_i_n">Donnez votre numero de CNI</label><span>*</span></br>
<input required type="text" name="num_i_n"  maxlength="13"/></br>
<div class="div_caissier">
<label for="prenom">Prenom</label><span>*</span></br>
<input required type="text" name="prenom" /></br>
</div>
<label for="nom">Nom</label><span>*</span></br>
<input required type="text" name="nom"/></br></br>
<div class="div_caissier">
<label for="sex">Sexe</label><span>*</span></br>
<input required type="radio" name="sex" value="M"/>M<input required type="radio" name="sex" value="F"/>F</br>
</div>
<label for="adresse">Adresse</label><span>*</span></br>
<input required type="text" name="adresse"/></br>
<div class="div_caissier">
<label for="email">Email</label><span>*</span></br>
<input required type="email" name="email"/></br>
</div>
<label for="tel">Telephone</label><span>*</span></br>
<input required type="text" name="tel" minlength="9" maxlength="13"/></br>
<div class="div_caissier">
<label for="age">Age</label><span>*</span></br>
<input required type="number" name="age" MIN="18" MAX="100"/></br>
</div>
<label for="login">Login</label><span>*</span></br>
<input required type="text" name="login"/></br>
<label for="mdp">Mot de passe</label><span>*</span></br>
<input required type="password" name="mdp" maxlength="8"/></br>
<div class="div_caissier">
<label for="mdp1">Confirmer le mot de passe</label><span>*</span></br>
<input required type="password" name="mdp1" maxlength="8"/></br>
</div></br>
<input type="submit" class="submit" value="Envoyer"/>
</form>
<br/>
<?php
if( isset($_POST['num_i_n'])&& isset($_POST['prenom'])&&isset($_POST['nom'])&&isset($_POST['sex'])&&isset($_POST['adresse'])&&isset($_POST['email'])&&isset($_POST['tel']) && isset($_POST['age']))
{
	$num=$_POST['num_i_n'];
	$prenom=$_POST['prenom'];
	$nom=$_POST['nom']; $sex=$_POST['sex'];  $adresse=$_POST['adresse'];  $email=$_POST['email'];
	$telephone=$_POST['tel'];$age=$_POST['age'];$login=$_POST['login'];$mdp=$_POST['mdp'];$mdp1=$_POST['mdp1'];
	$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($bd)
	{
		$req="insert into gerant values($num,'$prenom','$nom','$sex','$adresse','$email','$telephone',$age)";
		$r=$bd->exec($req);
		if($r)
		{
			$r1=$bd->exec("insert into compte_personne values('$login','$mdp',1,'$num','gerant')");
			if($r1)
			    echo"<span class='succ'>gerant ajouter avec succes!";
			else 
				echo "<span>Ce login existe déja<span>";
		}
		else
			header("location:gestion_gerant.php");
	}
	else
		echo "<span>Echec da connexion a la base<span>";
}
?>
</div>
</body>
</html>