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
<title>pointer/dépointer groupe</title>
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
<h1>Activer ou desactiver un groupe</h1>
<br/>
<div class="fms">
<form method="POST" action="">
<label for="nom_groupe" style="color:green;font-weight:bold">Nom du groupe</label><span>*</span></br>
<div id="List_groupe"></div>
<input required type="text" id="nom_g" name="nom_groupe" maxlength="50"/></br></br>
<!--<label for="etat">Etat du compte</label><span>*</span></br>-->
<input required type="radio" class="etat_g" name="etat_g" value="Activer"/> <span style="color:green;font-weight:bold">Activer</span></br><input required type="radio" class="etat_g" name="etat_g" value="desactiver"/> <span style="color:red;font-weight:bold">Desactiver</span></br></br>
<input type="submit" style="margin-left:0em;" class="submit" value="valider le choix"/>
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
<br/>
<p>
<?php 
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{
   if(isset($_POST['nom_groupe'])&& isset($_POST['etat_g']))
    {			
    	$nom_groupe=$_POST['nom_groupe'];
        $etat_g=$_POST['etat_g'];
        $r=$bd->query("select nb_c_ajouter,etat_g from groupe where nom_groupe='$nom_groupe'");
	    $res=$r->fetch();
        if($res)
	    {
			if($res['nb_c_ajouter']!=0)
			{
				if($etat_g=="Activer")
				{
					if($res['etat_g']==1)
						echo "<span class='avert'>Ce groupe est déja pointé</span>";
					else
					{ 
						$r1=$bd->exec("update groupe set etat_g=1 where nom_groupe='$nom_groupe'");
						if($r && $r1)
						{
							echo "<span class='succ'>$nom_groupe pointer avec succé</span>";
							$r1=$bd->exec("update compte_personne set etat=1 where num_i_n IN (SELECT num_i_c from caissier where groupe like '$nom_groupe')");       
						}
						else
							echo "<span>Un probleme est survenue au moment du pointage du $nom_groupe.<br/>Veuillez réessayer</span>";
					} 
				}
				else
				{   
					if($res['etat_g']==0)
						echo "<span class='avert'>Ce groupe n'a pas été pointé</span>";
					else
					{
						$r=$bd->exec("update groupe set etat_g=0 where nom_groupe='$nom_groupe'");
						if($r)
						{
							echo "<span class='succ'>Dépointage du $nom_groupe fait avec succé</span>";
							$r1=$bd->exec("update compte_personne set etat=0 where num_i_n IN (SELECT num_i_c from caissier where groupe like '$nom_groupe')");
						}
						else
							echo "<span>Un probleme est survenue au moment du dépointage du $nom_groupe.<br/>Veuillez réessayer</span>";
					}
				}
			}
            else
                echo "<span>Impossible de pointer ou dépointer le $nom_groupe car ce groupe n'a aucun membre!</span>";				
        }
		else
		    echo "<span>Ce groupe n'existe</span>";
    }
}
else
	echo "<span>Erreur de connexion a la base</span>";
?>
</div>
</body>
</html>