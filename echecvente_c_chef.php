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
<title>vendre</title>
<link rel="stylesheet" href ="css_projet_tuto/entete.css"/>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="jquery-3.4.1.js"></script>
<link rel="stylesheet" href="bootstrap/js/bootstrap.min.js">
</head>
<body>
<?php entete_boutique();?>
<a href="caissier_chef.php" id='retour'>Retour à la page d'acceuille</a></br></br>
<div class="fms">
<?php 
echo "<span class='btn btn-danger'>Votre compte est à l'état désactiver.<br/>Vous ne pouvez pas effectuer de vente.<br/>Cette action vous est autorisée si votre compte est activé.<br/>Autrement dit si le groupe auquel vous appartenez est pointés par le gerant </span>";
?>
</div>
</body>
</html>
