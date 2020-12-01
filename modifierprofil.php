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
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="caissier.php">Retour à la page d'accueil </a><br/><br/>
<div class="fms">
 <?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
$login=$_SESSION['login'];$mdp=$_SESSION['mdp'];
$req="SELECT * from compte_personne WHERE login = '$login' and mdp = '$mdp' ";
$r=$bd->query($req);
$res=$r->fetch();
if($res) 
{$num_i_n=$res['num_i_n'];
 $rep="SELECT * from caissier WHERE num_i_c = '$num_i_n'";
 $rp=$bd->query($rep);
 $es=$rp->fetch();
 if($es)
{$num_i_c=$es['num_i_c'];$prenom=$es['prenom'];$nom=$es['nom'];$adresse=$es['adresse'];$email=$es['email'];$tel=$es['tel'];
 }
}
?>
<?php
  $con=new PDO("mysql:host=127.0.0.1;dbname=boutique","root","");
 if(isset($_GET['num_i_c']))
{
$num_i_c= $_GET['num_i_c'];
$result=("SELECT * FROM caissier WHERE num_i_c=$num_i_n");}
else
	$con=null;
 ?>
  <form action="?num_i_c=<?php echo $num_i_c;?>" method="POST">
  <input type="text" name="prenom" value="<?php echo $prenom;?>"/><br/>
  <input type="text" name="nom" value="<?php echo $nom;?>"/></br>
  <input type="text" name="adresse" value="<?php echo $adresse;?>" /><br/>
  <input type="email" name="email" value="<?php echo $email;?>" /><br/>
  <input type="text" name="tel" value="<?php echo $tel;?>" /><br/>
  <input type="text"  name="log" value="<?php echo $login;?>" /><br/>
  <input type="password" maxlength="8" name="md" value="<?php echo $mdp;?>" /><br/>
  <input type="password" maxlength="8" name="md1" value="<?php echo $mdp;?>" /><br/><br/>
  <input type="submit" class="submit" name="modifier" value="MODIFIER"/><br/><br/> 
<?php
if(isset($_POST["modifier"]))
{
	$prenom = $_POST["prenom"];$nom=$_POST["nom"];$adresse=$_POST["adresse"];
	$email=$_POST["email"];$tel= $_POST["tel"];
	$log= $_POST["log"];$md =$_POST["md"];$md1 =$_POST['md1'];
	if($md==$md1)
	{
		$rt="UPDATE caissier SET prenom='$prenom',nom='$nom',adresse='$adresse',email='$email',tel='$tel' WHERE num_i_c = $num_i_n";
		$rp=$bd->exec($rt);
		if($rp)
		{
			echo"<span class='succ'>Les modification sont faite avec succes</span></br>";
			$qr="SELECT * from caissier WHERE num_i_c= '$num_i_n' ";
			$r=$bd->query($qr);
			$sr=$r->fetch();
			if($sr)
			{
				$prenom =$sr['prenom'];$nom=$sr['nom'];$adresse=$sr['adresse'];
				$email=$sr['email'];$tel= $sr['tel'];
				
				echo"Prenom : ".$sr['prenom']."</br>"; echo "NOM : ".$sr['nom']."</br>";echo"Adresse : ".$sr['adresse']."</br>";
				echo"Email : ".$sr['email']."</br>";echo"Telephone : ".$sr['tel']."</br>";
			}
			
			$tt="UPDATE compte_personne SET login='$log',mdp='$md' where num_i_n=$num_i_n";
			$pp=$bd->exec($tt);
			if($pp)
			{
				$rr="SELECT * from compte_personne WHERE num_i_n= '$num_i_n' ";
				$aa=$bd->query($rr);
				$ss=$aa->fetch();
				if($ss)
				{  
					echo"Login : ".$log."</br>";//echo"MDP : ".$md;
					if(($log!=$login)||($md!=$mdp))
						$_SESSION['login']=$log;$_SESSION['mdp']=$md;
									
				}
			  
			}
						
		}
		else
			echo "<span class='avert'>Vous avez désider de ne pas modifier votre profil<br/></span>";  
	}
	else
		echo "<span class='avert'>Vous avez entrez des mots de passe differents<br/>Veuillez réessayer!</span>";  
} 
?>
</div>
</body>
 </html>