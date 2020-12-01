<!doctype html>
<?php 
session_start();
include('fonction.php');
?>
<html>
<head>
<meta charset="utf-8"/>
<title>connexion</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href ="css_projet_tuto/index.css"/>
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
</head>
<body>
<?php entete_boutique();?><br/><br/><br/><br/><br/><br/>
<div id="f_aut">
<h1 id="h1_index">Page d'authentification</h1><br/><br/>
<form id="from_login_mdp" method='POST' action="">
<input required type ="text" name="login" id="aut1" size="15" placeholder='Login'/><br/>
<input required type ="password" name="mdp" id="aut2" size="15" maxlength="8" placeholder="mot de passe"/><br/>
<input type ="submit" id="subm_autentif" name= "subm_autentification" value="Se connecter"/>
</form>
</div>

<p id="p_traiter_index">
<?php
$_SESSION['login']=@$_POST['login'];
$_SESSION['mdp']=@$_POST['mdp'];
if(isset(/*$_SESSION['login']*/$_POST['login']) && isset(/*$_SESSION['mdp']*/$_POST['mdp']))
{   
	$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");  
	if($bd)
	{       
		$login=$_POST['login']/*$_SESSION['login']*/;
		$mdp=$_POST['mdp']/*$_SESSION['mdp']*/;
		$req="SELECT login,mdp from compte_personne WHERE login = '$login' and mdp = '$mdp' ";
		$r=$bd->query($req);
		$res=$r->fetch();
		if($res) 
		{
			$req="SELECT type_compte from compte_personne WHERE login = '$login' ";
			$r=$bd->query($req);  
			$res=$r->fetch();
			if($res)
			{
				if($res['type_compte']=="proprietaire")
				{
					$r1=$bd->query("SELECT prenom,nom,sexe from proprietaire where num_i_n IN(select num_i_n from compte_personne where login like '$login')");
					$r1=$r1->fetch();
					if($r1)
					{
						$_SESSION['prenom']=$r1['prenom'];
						$_SESSION['nom']=$r1['nom'];
						$_SESSION['type']="proprietaire";
						$_SESSION['sexe']=$r1['sexe'];
					    header("Location:proprietaire.php");
					}
				}
				else if($res['type_compte']=="gerant")
				{
					$r1=$bd->query("SELECT prenom,nom,sexe from gerant where num_i_ng IN(select num_i_n from compte_personne where login like '$login')");
					$r1=$r1->fetch();
					if($r1)
					{
						$_SESSION['prenom']=$r1['prenom'];
						$_SESSION['nom']=$r1['nom'];
						$_SESSION['type']="gerant";
						$_SESSION['sexe']=$r1['sexe'];
					    header ("Location:gerant.php");
					}
				}
                else if($res['type_compte']=="caissier chef")
				{
					$r1=$bd->query("SELECT prenom,nom,sexe,age,status,groupe from caissier where num_i_c IN(select num_i_n from compte_personne where login like '$login')");
					$r1=$r1->fetch();
					if($r1)
					{
						$_SESSION['prenom']=$r1['prenom'];
						$_SESSION['nom']=$r1['nom'];
						$_SESSION['type']="caissier chef";
						$_SESSION['sexe']=$r1['sexe'];
						$_SESSION['age']=$r1['age'];
						$_SESSION['status']=$r1['status'];
						$_SESSION['groupe']=$r1['groupe'];
					   header("Location:caissier_chef.php");
					}
				}
                else
				{
					$r1=$bd->query("SELECT * from caissier where num_i_c IN(select num_i_n from compte_personne where login like '$login')");
					$r1=$r1->fetch();
					if($r1)
					{
						$_SESSION['num_i_c']=$r1['num_i_c'];
						$_SESSION['prenom']=$r1['prenom'];
						$_SESSION['nom']=$r1['nom'];
						$_SESSION['sexe']=$r1['sexe'];
						$_SESSION['age']=$r1['age'];
						$_SESSION['status']=$r1['status'];
						$_SESSION['groupe']=$r1['groupe'];
						$_SESSION['type']="caissier simple";	
					    header ("Location:caissier.php");
					}
                   	
				}					
			}
			else 
				echo "<br/><br/><span class='btn btn-danger' style='font-weigth:bold;margin-left:35em;'>Une erreur imprévue est survenue veuillez réessayer</span>";
	    }
	    else		
		    echo "<br/><br/><span class='btn btn-danger' style='font-weigth:bold;margin-left:32.5em;'>Login ou mot de passe incorrecte</span><br/>";
    }
    else
	    echo "<br/><br/><span class='btn btn-danger' style='font-weigth:bold;margin-left:35em;'>Connexion a la base KO</span>";
}
?>
</p>
</body>
</html>