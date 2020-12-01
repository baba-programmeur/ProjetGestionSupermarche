<!doctype html>
<?php 
session_start();
include('fonction.php');
if(!($_SESSION['login'] && $_SESSION['mdp']))
	header("Location:index.php");
?>
<html>
 <head>
 <meta charset= "utf-8" />
 <title>gestion gerant</title> 
 <link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
 <body>
 <?php entete_boutique();?>
 <a id="retour" href="proprietaire.php">Retour à la page d'acceuil</a>
    <h1>lister les gerants</h1><br/><br/>
	<div class="fms">
    <table class="table table-bordered table-hover table stripped" style="margin-left:-9em;">
     
        <tr>
            <th>num_i_ng</th>
            <th>prenom</th>
            <th>nom</th>
               <th>sexe</th>
            <th>adresse</th>
            <th>email</th>
              <th>tel</th>
         <th>action</th>
        </tr>
        <?php
        $bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
        $query="select*from gerant";
        $result=$bd->query($query);
        $data=$result->fetchALL();
        for($i=0;$i<count($data);$i++)
        {
            $num=$data[$i]['num_i_ng'];
            $prenom=$data[$i]['prenom'];
            $nom=$data[$i]['nom'];
              $sexe=$data[$i]['sexe'];
            $adresse=$data[$i]['adresse'];
            $email=$data[$i]['email'];
             $tel=$data[$i]['tel'];
          
            echo"<tr><td>$num</td><td>$prenom</td><td>$nom</td><td>$sexe</td><td>$adresse</td><td>$email</td><td>$tel</td>";
            echo"<td>";
            echo"<a href='supprimer_gerant.php?num=$num ' onclick=' return confirm(\"etes-vous sur de vouloir ......?\");' class='btn btn-danger'>supprimer</a>";echo"<br/><br/>";
            echo"</tr>";
            
        }
        
        ?>
    </table>
    <a style="color:#000000;text-decoration:none;" class="submit" href="ajouter_gerant.php">ajouter un gerant</a>
  </div>
 </body>
</html>