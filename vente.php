<!doctype html>
<?php 
session_start();
include('fonction.php');
if(!($_SESSION['login'] && $_SESSION['mdp']))
	header("Location:index.php");
$login=$_SESSION['login'];$mdp=$_SESSION['mdp'];
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
$req="SELECT * from compte_personne WHERE login = '$login' and mdp = '$mdp' ";
$r=$bd->query($req);
$res=$r->fetch();
if($res) 
{
	$etat=$res['etat'];
    if($etat==1)
	{
		$num_i_n=$res['num_i_n'];
		$rep="SELECT groupe from caissier WHERE num_i_c = '$num_i_n'";
		$rp=$bd->query($rep);
		$es=$rp->fetch();
		if($es)
		$groupe=$es['groupe'];
	}
    else
        header("Location:echecvente.php");	
}
?>
<html>
<meta charset="utf-8"/>
<head>
<title>vendre</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
<?php style_recherche();?>
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="caissier.php">Retour à la page d'accueil</a>
<h1 id="h1_vendre">Vente de produit</h1>
<div class="fms">
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label for="medic_v">Nom du produit à vendre</label><span>*</span></br>
<div id="List_prod"></div>
<input required type="text" id="nom_prod" name="prod_v" maxlength="50"/></br>
<label for="prix_vente">Quantite à vendre</label><span>*</span></br>
<input required type="floatval" id="input_prix_vente" MIN="1" name="q_v"/></br></br>     
<input type="submit" class="submit" value="Enregistrer"/>
</form>
<?php recherche_prod();?>
<table>
<tr><th colspan='6'  align="center">Remplisser votre panier</th></tr>
<tr><th>Nom du produit</th><th>Quantite a vendre</th><th>Prix total</th><th>CIN du caissier</th><th>Supprimer Produit</th></tr> 
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{ 
 $res=$bd->query("select * from panier");
  $data=$res->fetchALL();
  for($i=0;$i<count($data);$i++)
  {  $prod=$data[$i]['nom_prod'];
	 echo "<tr><td>".$data[$i]['nom_prod']."</td><td>".$data[$i]['nb_ech']."</td><td>".$data[$i]['prix']."</td><td>".$data[$i]['num_i_n']."</td>";
     echo "<td>";
     echo"<a href='supprimer_prod_du_panier.php?nom_prod=$prod' onclick=' return confirm(\"etes-vous sur de vouloir ......?\");' class='btn btn-danger'>supprimer</a>";echo"</td></tr>";} 
    if(isset($_POST['prod_v'])&&isset($_POST['q_v']))
	{	$prod=$_POST['prod_v'];$q_v=$_POST['q_v']; 
		$r=$bd->query("select nom_prod, prix_vente,stock,stock_max from produit where nom_prod = '$prod'");
		  $r=$r->fetch();
		  if($r)
		   { if($q_v<=$r['stock'])
			  { 
		        echo "Quantite disponible avant la vente: ".$r['stock']." <br/>";
			    $prix=$r['prix_vente'];
			    $prix=$prix*$q_v;
				$re="insert into panier values('$prod',$q_v,$prix,'$num_i_n')";
				$re=$bd->exec($re);
                if($re)
					header("location:vente.php");
				else
					echo "<span>echec de l'insertion a la table panier</span>"; 
			 }
			  else
				 echo "<span class='avert'>La quantite disponible du produit $prod est inferieur a ".$q_v." <br/>La quantite maximale que vous vendre actuellement est: ".$r['stock'];  
		   }
		   else
			 echo "<span>echec de la connexion a la table produit</span><br/>";}
    
  }
   
echo "<br/><br/>";
?>
</table>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
</br><label for="num_vente">Numéro CIN client</label><span>*</span>
<input required type="text" id="input_num_vente" name="cin" maxlength="13"/></br>
<label for="panier">Acheter votre panier</label><span>*</span>
<input type="submit" class="submit" name="oui" value="Acheter"/>
</form>
<?php 
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{
    if(isset($_POST['oui'])&&isset($_POST['cin']))
	{   $rep=$_POST['oui'];$num_i_a=$_POST['cin'];
	 
		$sql='SELECT * FROM panier';
		$reb=$bd->query($sql);
		while($r=$reb->fetch())
		{  
			$prod=$r['nom_prod'];$nb=$r['nb_ech'];$prix=$r['prix'];$num_i_n=$r['num_i_n'];
			$rq=$bd->query("select stock from produit where nom_prod ='$prod'");
		   $req=$rq->fetch();
		   if($req)				
			{
				$res="insert into ventes values('','$prod','$num_i_n','$num_i_a',$nb,now(),$prix,'$groupe')";
				$res=$bd->exec($res);
				if($res)
				{ 
					$new_stock= $req['stock'] - $nb;
					$req="UPDATE produit SET stock=$new_stock where nom_prod='$prod'";
					$r=$bd->exec($req);
					if($r)
					{ 
					  $req="DELETE from panier where nom_prod='$prod'";
					  $r=$bd->exec($req);
					  if($r){echo "Vente des $nb $prod enregistrée avec succé<br/>";
					  echo"<span class='succ'>le prix est de $prix Fcfa</span><br/>";}
					}
					if($new_stock>5)
						echo "Quantite de ".$prod." restant apres vente: <span class='avert'>".$new_stock."</span><br/><br/>";
					else
						echo "<span>La quantité de $prod restant est faible penser a renouveller son sock pour atteindre sa quantité de référence: ".$r['nb_ech_max']."</span></br>"; 
				}
				else 
				  echo "<span>Vente non enregistrée!</span><br/>";		
			}
		}	   
	} 
}  
else
	echo " Echec de la Connexion ";
echo "<br/>";
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
<label for="panier">Anuler votre panier</label><span>*</span>
<input type="submit" class="submit" name="non" value="Anuler"/>
</form>
<?php 
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if($bd)
{  if(isset($_POST['non']))
	{ $rep=$_POST['non'];
	  $req="DELETE from panier";
	  $r=$bd->exec($req);
	  if($r)
		echo "panier videe avec succé<br/>";				
	}		
}
?>	
</div>
</body>
</html>