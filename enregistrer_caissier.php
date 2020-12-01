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
<title>enregistrer caissier</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href ="css_projet_tuto/produit.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Enregistrer un nouveau caissier</h1>
<div class="fms">
<form method="POST" action="">
<label for="prenom">Prénom</label><span class="etoil">*</span></br>
<input required type="text" id="prenom" name="prenom" maxlength="50"/></br>
<div class="div_caissier">
<label for="nom">Nom</label><span class="etoil">*</span></br>
<input required type="text" id="nom" name="nom" maxlength="50"/></br>
</div>
<label for="num_i_c">Numéro d'identité national du caissier</label><span class="etoil">*</span></br>
<input required type="text" id="num_i_c" name="num_i_c" minlength="13" maxlength="13"/></br></br></br>
<div class="div_caissier">
<label for="sexe">Sexe</label><span class="etoil">*</span>
<input required type="radio" class="sexe" name="sexe" size="30px" value="M"/>M
<input type="radio" class="sexe" name="sexe" size="30px" value="F"/> F</br>
</div>
<label for="adresse">Adresse</label><span class="etoil">*</span></br>
<input required type="text" id="adresse" name="adresse" maxlength="100"/></br>
<div class="div_caissier">
<label for="email">Email</label><span class="etoil">*</span></br>
<input required type="email" id="email" name="email" maxlength="50"/></br>
</div>
<label for="tel">Téléphone</label><span class="etoil">*</span></br>
<input required type="tel"  name="tel" maxlength="20"/></br>
<div class="div_caissier">
<label for="age">Age</label><span class="etoil">*</span></br> 
<input required type="number"  name="age" MIN="18" MIN="88"/></br>
</div>
<label for="status" >Status</label><span class="etoil">*</span></br>
<select name="status">
<option value="0">Caissier simple</option>
<option value="1">Caissier chef</option>
</select> </br>
<div class="div_caissier">
<label for="groupe">Groupe</label><span id="etoil">*</span></br>
<input required type="text"  name="groupe" maxlength="20"/></br>
</div>
<label for="login">Login</label><span id="etoil">*</span><span id="sp_login_input"></span></br>
<input required type="text" name="login"  id="login" maxlength="20"/><span id="sp_login_sexe"></span></br>
<label for="mdp">Mot de passe</label><span class="etoil">*</span></br>
<input required type="password" class="mdp" name="mdp"  maxlength="8" placeholder="8 char"/><span id="sp_mdp_label"></span></br>
<div class="div_caissier">
<label for="mdp1"> Confirmer le mot de passe</label><span class="etoil">*</span></br>
<input required type="password" class="mdp" name="mdp1" maxlength="8" placeholder="8 char" /></br>
</div></br>
<input type="submit" class="submit" value="Enregistrer"/>
</form>
</br>
<p>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['prenom'])&& isset($_POST['nom'])&& isset($_POST['num_i_c'])&& isset($_POST['sexe'])&& isset($_POST['adresse']) && isset($_POST['email']) 
    && isset($_POST['tel'])  && isset($_POST['age']) && isset($_POST['status']) && isset($_POST['groupe']) && isset($_POST['login'])&& isset($_POST['mdp'])
    && isset($_POST['mdp1']))
    { 
		$prenom =$_POST['prenom'];$nom=$_POST['nom'];$num_i_c=$_POST['num_i_c'];$sexe=$_POST['sexe'];$adresse=$_POST['adresse'];$email=$_POST['email'];
		$tel=$_POST['tel'];$age=$_POST['age'];$status=$_POST['status'];$groupe=$_POST['groupe'];$login=$_POST['login'];$mdp=$_POST['mdp'];$mdp1=$_POST['mdp1'];
		if($mdp==$mdp1)
		{  
			$nb=$bd->query("SELECT 	nb_c_ajouter,nb_c_max FROM groupe WHERE nom_groupe='$groupe'");
			$nb=$nb->fetch();
			if($nb)
			{   
				$nb1=$nb['nb_c_ajouter'];
				$nb2=$nb['nb_c_max'];
				if(($nb1+1)<=$nb2)
				{   
			        if($status==0)
					{
					    $r=$bd->exec("INSERT INTO caissier VALUES ('$num_i_c','$prenom','$nom','$sexe','$adresse','$email','$tel',$age,$status,'$groupe')");
						if($r)
						{
							$re=$bd->exec("INSERT INTO compte_personne VALUES ('$login','$mdp',0,'$num_i_c','caissier simple')");
							if($re)
							{
								$nb1=$nb1+1;
								$req=$bd->exec("update groupe set nb_c_ajouter= $nb1 WHERE nom_groupe='$groupe'");
								if($req)
									echo "<span class='succ'>Enregistrement du caissier simple $prenom  $nom réussie!</span><br/><br/>"; 
							}
							else
							{
								$re=$bd->exec("DELETE from caissier where num_i_c like '$num_i_c'");
							    echo "<span>Echec de la création compte du caissier simple $prenom $nom.<br/>Veuillez réessayer</span><br/><br/>";
							}
						}
						else
							echo "<span>Echec de l'enregistrement du caissier simple $prenom $nom.<br/>Veuillez réessayer</span><br/><br/>";
					}
                    else
					{
					    $re=$bd->query("SELECT mun_i_c_chef from  groupe where nom_groupe like '$groupe'");
						$re=$re->fetch();
						if($re && $re['mun_i_c_chef'])	
							echo "<span class='avert'>Impossible d'enregistrer $prenom $nom comme caissier chef car le $groupe a déja un caissier chef!<span><br/><br/>";
						else 
						{
							$r=$bd->exec("INSERT INTO caissier VALUES ('$num_i_c','$prenom','$nom','$sexe','$adresse','$email','$tel',$age,$status,'$groupe')");
							$re=$bd->exec("INSERT INTO compte_personne VALUES ('$login','$mdp',0,'$num_i_c','caissier chef')");
							if($r && $re)
							{	
						        $nb1=$nb1+1;
								$req=$bd->exec("update groupe set mun_i_c_chef='$num_i_c', nb_c_ajouter= $nb1 WHERE nom_groupe='$groupe'");
								if($req)
									echo "<span class='succ'>Enregistrement du caissier chef $prenom  $nom réussie!</span><br/><br/>"; 
							}
							else
								echo "<span>Echec de l'enregistrement du caissier chef!</span><br/><br/>";
						}					
					} 						
				}
				else
					echo "<span class='avert'>Ajout impossible car le $groupe a atteint le maximum ($nb2 personnes)</span>";
			}
			else
				echo "<span>Veuillez bien vous rassurer que le $groupe exister déja avant d'y ajouter un nouveau caissier</span>";
		}
		else				
			echo "<span>Les deux mots de passes que vous avez donnez ne sont pas conformes</span><br/>";       
    }
	
}
else
	echo "<span>Erreur de connexion a la base</span><br/>";
?>
</div>
</p>
</body>
</html>