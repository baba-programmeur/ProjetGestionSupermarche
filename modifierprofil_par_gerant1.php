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
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href ="css_projet_tuto/sta.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="gerant.php">retourner a la page d'accueil</a><br/><br/>
<h1>Modification du profil</h1>
<div class="fms">
 <?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{
	if(isset($_POST['num_i_n']))
	{
		$num_i_n=$_POST['num_i_n'];
		$rep="SELECT * from caissier WHERE num_i_c = '$num_i_n'";
		$rp=$bd->query($rep);
		$es=$rp->fetch();
		if($es)
		{
		    $_SESSION['num']=$es['num_i_c'];$_SESSION['prnom']=$es['prenom'];$_SESSION['nm']=$es['nom'];$_SESSION['s']=$es['sexe'];$_SESSION['ad']=$es['adresse'];$_SESSION['mail']=$es['email'];$_SESSION['phone']=$es['tel'];
			$_SESSION['ag']=$es['age'];$_SESSION['stat']=$es['status'];$_SESSION['group']=$es['groupe'];
		}
    }
}
 ?>
  <form method="POST" action="">
  <input type="text" name="num" value="<?php echo $_SESSION['num'];?>" placeholder="C.N.I"/></br>
  <input type="text" name="prenom" value="<?php echo $_SESSION['prnom'];?>" placeholder="Prenom"/></br>
   <input type="text" name="nom" value="<?php echo $_SESSION['nm'];?>" placeholder="Nom"/></br>
   <input type="text" name="sexe" value="<?php echo $_SESSION['s'];?>" placeholder="Sexe"/></br>
  <input type="text" name="status" value="<?php echo $_SESSION['stat'];?>" placeholder="Status"/></br>
  <input type="text" name="age" value="<?php echo $_SESSION['ag'];?>" placeholder="Age"/></br>
  <input type="text" name="groupe" value="<?php echo $_SESSION['group'];?>" placeholder="groupe"/></br></br>
  <input type="submit" class="submit" name="modifier" value="Modifier"/></br>
<?php
if(isset($_POST["modifier"]))
{
	$num=$_POST['num'];$ag=$_POST['age'];$stat=$_POST['status'];$groupe=$_POST['groupe'];
	$prenom =$_POST['prenom'];$nom=$_POST['nom'];$adresse=$_SESSION['ad'];$email=$_SESSION['mail'];$tel=$_SESSION['phone'];$sexe=$_POST['sexe'];$group=$_SESSION['group'];
	$rt=" UPDATE caissier SET num_i_c='$num',prenom='$prenom',nom='$nom',sexe='$sexe',adresse='$adresse',email='$email',tel='$tel', age=$ag, status=$stat, groupe='$groupe' WHERE num_i_c = $num";
	$rp=$bd->exec($rt);
	if($rp)
	{
		if($stat==0)
		    $r=$bd->exec("UPDATE compte_personne SET type_compte='caissier simple' WHERE num_i_n like '$num'");
		else
			$r=$bd->exec("UPDATE compte_personne SET type_compte='caissier chef' WHERE num_i_n like '$num'");
		
		echo"<span class='succ'>Modification faite avec succes.</span>";
		$qr="SELECT * from caissier WHERE num_i_c= '$num' ";
		$r=$bd->query($qr);
		$sr=$r->fetch();
		if($sr)
		{
			echo"</br>CIN : ".$sr['num_i_c']."</br>";
			echo"Prenom : ".$sr['prenom']."</br>"; 
			echo "NOM : ".$sr['nom']."</br>";echo"SEXE : ".$sr['sexe']."</br>";echo"Adresse : ".$sr['adresse']."</br>";echo"Email  : ".$sr['email']."</br>";
			echo"Telephone : ".$sr['tel']."</br>";echo"Age : ".$sr['age']."</br>";
			if($stat==0)
			    echo"Status : caissier</br>";
			else
				echo"Status : caissier chef</br>";
			echo"Groupe : ".$sr['groupe']."</br>";
			
		}
	}
	  else
		 echo "<span class='avert'>Vous n'avez fait aucune modification.</span>"; 
} 
?>
</body>
 </html>