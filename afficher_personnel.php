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
<title>Liste du personnel</title>
<link rel="stylesheet" href ="css_projet_tuto/afficher_personnel.css"/>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<style>  
li
{  
	padding:2px;
	list-style:none;
	border:1px solid #ffffff;
	border-radius:15px;
	width:12em;	
	background-color:#eee;	
	text-align:center;				
} 
 </style> 
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Liste du personnel de la boutique</h1>
<div class="fms">
<p>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
	$req=$bd->query("SELECT * FROM caissier");
	$reqt=$bd->query("SELECT * FROM caissier");
	if($reqt=$reqt->fetch())
	{
		echo "<table>";
		echo"<tr><th>Num id</th><th>Prenom</th><th>Nom</th><th>Sexe</th><th>adresse</th><th>Email</th><th>Tel</th><th>Age</th><th>Status</th><th>Groupe</th></tr>";
		while($re=$req->fetch())
		{
			if($re['status']==1)
				echo"<tr><td>".$re['num_i_c']."</td><td>".$re['prenom']."</td><td>".$re['nom']."</td><td>".$re['sexe']."</td><td>".$re['adresse']."</td><td>".$re['email']."</td><td>".$re['tel']."</td><td>".$re['age']."</td><td>caissier chef</td><td>".$re['groupe']."</td></tr>";
			else
				echo"<tr><td>".$re['num_i_c']."</td><td>".$re['prenom']."</td><td>".$re['nom']."</td><td>".$re['sexe']."</td><td>".$re['adresse']."</td><td>".$re['email']."</td><td>".$re['tel']."</td><td>".$re['age']."</td><td>caissier simple</td><td>".$re['groupe']."</td></tr>";
		}
		echo "</table>";
	} 
	else
		echo "<span>Aucun membre du personnel de votre boutique n'est enregistrer pour le moment.</span>";
$bd=NULL;	
}
else
	echo "<span>Erreur de connexion a la base</span><br/>";
?>
</p>
<form id="from_g" method="POST" action="">
<label for="nom_g">Afficher les membres du groupe</label><span id="span1">*</span></br>
<div id="List_groupe"></div>
<input required type="text" id="nom_g" name="nom_g" placeholder="Tapez le nom du groupe" maxlength="20" /></br></br>
<input type="submit" class="submit" value="Afficher"/>
</form>
<p>
<script>  
 $(document).ready(function(){  
	$('#nom_g').keyup(function()
	{  
	   var query = this.value;
	   if(query != '')  
		{  
			$.ajax(
			{  
				url:"fonction.php",  
				method:"POST",  
				data:{query:query},  
				success:function(data)  
				{  
					$('#List_groupe').fadeIn();  
					$('#List_groupe').html(data);  
				}  
			});  
		}  
	});  
	$(document).on('click', 'li', function(){  
		   $('#nom_g').val($(this).text());  
		   $('#List_groupe').fadeOut(); 	   
	});  
});
</script> 
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['nom_g']))
	{
		$nom_g=$_POST['nom_g'];
		if(strlen($nom_g)<=20)
		{	
	        $t=$bd->query("SELECT nom_groupe from groupe where nom_groupe like '$nom_g'");
			if($t=$t->fetch())
			{	$r=$bd->query("SELECT* FROM caissier WHERE groupe like '$nom_g'");
				if($r)
				{
					$rq=$bd->query("SELECT COUNT(*) AS nb_pers FROM caissier WHERE groupe like '$nom_g'");
					$rqt=$rq-> fetch();
					if($rqt['nb_pers']!=0)
					{	
						echo "<table>";
						echo"<tr><th colspan='9'>".$nom_g."</th></tr>";
						echo"<tr><th>Num id</th><th>Prenom</th><th>Nom</th><th>Sexe</th><th>adresse</th><th>Email</th><th>Tel</th><th>Age</th><th>Status</th></tr>";
						while($res=$r->fetch())
						{
							if($res['status']==1)
								echo"<tr><td>".$res['num_i_c']."</td><td>".$res['prenom']."</td><td>".$res['nom']."</td><td>".$res['sexe']."</td><td>".$res['adresse']."</td><td>".$res['email']."</td><td>".$res['tel']."</td><td>".$res['age']."</td><td>caissier chef</td></tr>";
							else
								echo"<tr><td>".$res['num_i_c']."</td><td>".$res['prenom']."</td><td>".$res['nom']."</td><td>".$res['sexe']."</td><td>".$res['adresse']."</td><td>".$res['email']."</td><td>".$res['tel']."</td><td>".$res['age']."</td><td>caissier simple</td></tr>";
						}
						echo "</table>";
					}
					else
						echo "<span class='avert'>Le $nom_g n'a pas de membres pour le moment</span>";
				} 
				else
					echo "<span>Echec de l'affichage du personnel.Veuillez réessayez</span>";
			}
			else
				echo "<span>Ce groupe n'existe pas dans votre base de donnnées</span>";
		}
        else
            echo "<span>Ce groupe n'existe pas dans votre base de donnnées</span>";			
	}
    $bd=NULL;	
}
else
	echo "<span>Erreur de connexion a la base<span><br/>";
?>
</p>
<form method="POST" action="">
<input type="submit" name="bouton" class="submit" value="Afficher les détailles des groupe"/>
</form>
<p>
<?php
if(isset($_POST['bouton']))
{
	$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($bd)
	{	
		$t=$bd->query("SELECT * from groupe");
		//$req=$bd->query("SELECT * from groupe");
		if(/*$t*/$res=$t->fetch())
		{	
			echo "<table>";
			echo"<tr><th>Nom du groupe</th><th>id caissier chef</th><th>effectif actuel</th><th>effectif maximal</th><th>Etat</th></tr>";
			echo"<tr><td>".$res['nom_groupe']."</td><td>".$res['mun_i_c_chef']."</td><td>".$res['nb_c_ajouter']."</td><td>".$res['nb_c_max']."</td><td>".$res['etat_g']."</td></tr>";
			while($res=$t->fetch())
				echo"<tr><td>".$res['nom_groupe']."</td><td>".$res['mun_i_c_chef']."</td><td>".$res['nb_c_ajouter']."</td><td>".$res['nb_c_max']."</td><td>".$res['etat_g']."</td></tr>";
			echo "</table>";
			
		}
		else
			echo "<span>Aucun groupe n'existe dans votre base de donnnées</span>";
	$bd=NULL;	
	}
	else
		echo "<span>Erreur de connexion a la base<br/>";	
}
?>
</p>
</div>
</body>
</html>