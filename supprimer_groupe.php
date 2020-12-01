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
<title>supprimer groupe</title>
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
<body id="bd_sup_g">
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1>Supprimer un groupe</h1></br></br>
<div class="fms">
<form method="POST" action="">
<label for="nom_g">Nom du groupe à supprimer</label><span id="span1">*</span></br>
<div id="List_groupe"></div>
<input required type="text" id="nom_g" name="nom_g" maxlength="13"/></br></br>
<input type="submit" class="submit" value="Supprimer"/>
</form>
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
</br>
<p>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{	
    if(isset($_POST['nom_g']))
    { 
        $nom_g=$_POST['nom_g'];
        $req=$bd->query("SELECT nb_c_ajouter FROM groupe WHERE nom_groupe like '$nom_g'");
		if($req=$req->fetch())
		{
			if($req['nb_c_ajouter']==0)
			{	
		        $re=$bd->exec("DELETE  FROM groupe WHERE nom_groupe like '$nom_g'");
				if($re)
					echo "<span class='succ'> Suppression du ".$nom_g." réussie</span>";
				else
					echo "<span>Suppression du ".$nom_g." non effectuer. Veuillez retenter</span>";
			}
			else
				echo "<span>Le $nom_g n'est pas vide.<br/>Pour le supprimer vous devez d'abord effacer touts ces membres.<br/>Puis relancer cette opération.</span>";
		} 
		else
			echo "<span>Ce groupe n'existe pas dans votre base de données</span>";
	}	 
}
else
	echo "<span>Erreur de connexion a la base</span><br/>";
?>
</p>
</div>
</body>
</html>