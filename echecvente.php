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
<a href="caissier.php" id='retour'>Retour à la page d'acceuille</a></br></br>
<div class="fms">
<?php 
echo "<span class='btn btn-danger'>votre compte est a l'etat desactiver.<br/>Vous ne pouver pas effectuer une vente.<br/>Cette action vous est autoriser si votre compte est activé.<br/>Autrement dit le groupe auquel vous appartenez doit etre pointer par le gerant </span>";
?>
</div>
</body>
</html>