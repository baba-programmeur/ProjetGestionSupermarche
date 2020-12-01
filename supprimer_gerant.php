<?php
if(isset($_GET['num']))
{
    $num=$_GET['num'];
    if(!empty($num)&& is_numeric($num))
    {
        $bd=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
        $query="delete from gerant where num_i_ng=$num";
        $sup=$bd->exec($query);
		if($sup)
		{
			$query=$bd->exec("delete from compte_personne where num_i_n=$num");
			if($query)
                header("location:gestion_gerant.php");
			else
				echo "<span>Le compte n'a pas été suprimé!</span>";
		}
    }
}
?>