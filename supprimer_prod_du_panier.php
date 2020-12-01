
<?php
$bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
      if(isset($_GET['nom_prod'])) 
	  {
            $prod=$_GET['nom_prod'];
            if(!empty($prod)&&!is_numeric())
			{
		        $r=$bd->exec("DELETE  FROM panier WHERE nom_prod = '$prod' ");
					header("location:vente.php");
	        }
	}
 ?>
