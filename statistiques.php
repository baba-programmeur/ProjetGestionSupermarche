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
<title>statistiques</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href ="css_projet_tuto/sta.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a  id="retour" href="gerant.php">Retour à la page d'accueil</a>
<h1 id="h1_sta_vente">Statistiques de vente selon?</h1>
<div class="fms">
<form method="POST" action="">
<input type="radio" name="sta" id="a8"   value="selon_produit"/><span class="options">les produits</span>
<input type="radio" name="sta"  id="a10" value="selon_groupe"/><span class="options">les groupes</span>
<input type="radio" name="sta"  id="a9" value="selon_periode"/><span class="options">les périodes</span><br/>
<input type="submit" class="submit" value="Consulter"><br/>
</form>
<br/>
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
if(isset($_POST['sta']))
{  
    $sta=$_POST['sta'];
    if($bd)
	{
		$tab[]=array();$nom_prod_vendu[]=array(); $id_vendeur[]=array();
		//Partie statistiques selon les produits//
	    if($sta=="selon_produit")
		{
		    $req="SELECT COUNT(*) AS nb_prod_vendu FROM ventes"; 
		    $r=$bd->query($req);
		    $res=$r-> fetch();
		    if($res)
		    {
		        echo "<span id='p12' style='color:black;'>La boutique a enregistré en tout ".$res['nb_prod_vendu']." ventes.</span><br/><span style='color:black' class='p12'>Voire ci-dessous leurs résumés selon les noms des produits</span><br/><br/>";
		        $req="SELECT DISTINCT nom_prod_v FROM ventes";
		        $r=$bd->query($req);
		        if($r)
		        { 
			        $i=0;
		            while($res=$r->fetch())
		            {
			            $tab[$i]=$res['nom_prod_v'];
			            $i++;
		            }
					
					$montant_total=0;
					echo '<table>';
					echo "<tr><th>Nom</th><th>Quantité vendu</th><th>Montant</th></tr>";
                    for($i=0;$i < count($tab) ;$i++)
		            {
						$r=$bd->query("SELECT prix_vente, nb_ech_vendu from ventes where nom_prod_v = '$tab[$i]' ");
						if($r)
						{
						    $nb_prod_v=0;$montant=0;
				            while($res=$r->fetch())
							{
			                    $nb_prod_v+=$res['nb_ech_vendu'];
								$montant+=$res['prix_vente'];
				            }
							echo "<tr><td>$tab[$i]</td><td>$nb_prod_v</td><td>$montant Fcfa</td></tr>";
							$montant_total+=$montant;
						} 
			            else
					    {
				            echo "<span>Eche de la décompte<span><br/>";
						    break;
					    }
		            }		
					echo "</table>";
					echo "<br/><span style='color:black;'>Toutes les ventes confondues ont donné un montant de: ".$montant_total." Fcfa </span>";
		        }
		        else
			        echo "<span>Une erreur innatendue s'est produite</span><br/>";
		    }
		    else
			    echo "<span>Présentation des statistiques impossible</span>";
	    }
		 //Partie statistiques selon les groupes//
		else if($sta=="selon_groupe")
		{
		    $req="SELECT DISTINCT groupe FROM ventes";
		    $r=$bd->query($req);
		    if($r)
		    { 
			    $i=0;
		        while($res=$r->fetch())
		        {
			        $tab[$i]=$res['groupe'];
			        $i++;
		        }
			    $nb_grpe_v=count($tab);
				
				echo "<table>";
			    echo "<tr><td colspan='5'>".$nb_grpe_v." groupes de la boutique ont vendu des produits</td></tr>";
                for($i=0;$i < $nb_grpe_v ;$i++)
		        {
					$etat_boucle=$i;
			        $r=$bd->query("SELECT nb_ech_vendu from ventes where groupe = '$tab[$i]' ");
				    if($r)
				    {
					    $nb_prod_v=0;
						while($res=$r->fetch())
							$nb_prod_v+=$res['nb_ech_vendu'];
						$grpe=$bd->query("SELECT groupe from ventes where groupe like '$tab[$i]' ");
						if($groupe=$grpe->fetch())
						{
							echo "<tr><th>".$groupe['groupe']."</th><th>$nb_prod_v produits</th></tr>";
						    echo "<tr><th colspan='5'>Détailles</th></tr>";
							$r=$bd->query("SELECT DISTINCT nom_prod_v from ventes where groupe = '$tab[$i]' ");
						    if($r)
							{   $j=0;
								while($res=$r->fetch())
								{
									$nom_prod_vendu[$j]=$res['nom_prod_v'];
									$j++;
								}
							}
							$montant_v_g=0;
							echo "<tr><th>Nom</th><th>Quantité totale vendu</th><th>Vendeur</th><th>Quantité vendue par caissier</th><th>Montant</th></tr>";
							for($k=0;$k < count($nom_prod_vendu) ;$k++)
							{
							    $r=$bd->query("SELECT SUM(nb_ech_vendu) AS nb_ech,SUM(prix_vente) AS som_total FROM ventes where nom_prod_v like '$nom_prod_vendu[$k]' and groupe like '$tab[$i]'");
							    $resultat=$r->fetch();
								if($resultat)
								{
									$montant_v_g+=$resultat['som_total'];
									$detail_vendeur=$bd->query("SELECT DISTINCT num_i_n_caissier from ventes where nom_prod_v like '$nom_prod_vendu[$k]' and groupe like '$tab[$i]' ");
									$pn_nom="";$nbv="";
									while($res1=$detail_vendeur->fetch())
									{
										$vendeur=$res1['num_i_n_caissier'];
									    $r1=$bd->query("SELECT SUM(nb_ech_vendu) AS nb_ech_vendu_par_lekl1_du_groupe from ventes where num_i_n_caissier like '$vendeur' and nom_prod_v like '$nom_prod_vendu[$k]' and groupe like '$tab[$i]' ");
										$r1=$r1->fetch();
										if($r1)
										{
											$r2=$bd->query("SELECT prenom,nom from caissier where num_i_c like '$vendeur'");
											$r2=$r2->fetch();
											if($r2)
											{
												$pn_nom.=$r2['prenom']." ".$r2['nom']."<br/>";
												$nbv.=$r1['nb_ech_vendu_par_lekl1_du_groupe']."<br/>";	
											}
											
										}
									}
									echo "<tr><td>$nom_prod_vendu[$k]</td><td>".$resultat['nb_ech']."</td><td>$pn_nom</td><td>$nbv</td><td>".$resultat['som_total']." Fcfa</td></tr>";
								}
							}
							echo "<tr><td colspan='5'>Montant total des ventes $montant_v_g Fcfa</td></tr>";
						}
		            }
					else
			            echo "<span>Une erreur innatendue s'est produite</span><br/>";
		        }
				echo "</table>";  
		    }
			else
				echo "<span>Impossible d'afficher les statistiques selon les groupes</span><br/>";	
		}
		//Partie statistiques selon periode//
		else
		    header("Location:selon_periode.php");
	}	
    else
        echo "<span>Echec de la connexion a la base</span>";
}	
?>			
</div>
</body>
</html>