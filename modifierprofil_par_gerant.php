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
<?php style_recherche();?>
</head>
<body>
<?php entete_boutique();?>
<a id="retour" href="gerant.php">retourner a la page d'accueil</a><br/><br/>
<h1>Modifier le profil d'un caissier</h1>
<div class="fms">
  <form method="POST" action="modifierprofil_par_gerant1.php" >
  <label for="num_i_n">Donnez le C.I.N du caissier dont vous souhaitez modifier le profil</label></br>
  <div id="List_num"></div>
  <input type="text" name="num_i_n" id="num_i_c"/></br></br>
  <input type="submit" class="submit" value="Modifier"/>
 <?php recherche_num();?>
  </br></br>
</div>  
</body>
 </html>