<!DOCTYPE>
<html>
<head>
 <meta charset='utf-8'>
 <link rel="stylesheet" type="text/css" href="css/style_lister.css">
    <title>lister les produits</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">  
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
<table class="table table-bordered table-hover table stripped" align='center'  width='300' height='100' border='2'>
        <tr>
            <th>nom produit</th>
            <th>nom categorie</th>
            <th>nom emploi con</th>
            <th>zone conteneur</th>
            <th>range conteneur</th>
            <th>date d'expiration</th>
            <th>prix de revient</th>
              <th>prix de vente</th>
                <th>stock</th>
                  <th>stock max</th>
        </tr>
        <?php
        include("connexion.php");
        $query="select * from produit ";
        $result=$bd->query($query);
        $data=$result->fetchALL();
        for($i=0;$i<count($data);$i++)
        {
            $nom=$data[$i]['nom_prod'];
            $categorie=$data[$i]['nom_categ '];
            $emploi=$data[$i]['nom_empl_conteneur'];
            $conteneur=$data[$i]['zone_conteneur '];
            $range=$data[$i]['range_conteneur '];
            $date=$data[$i]['date_dexpiration '];
            $revient=$data[$i]['prix_revient '];
             $vente=$data[$i]['prix_vente'];
              $stock=$data[$i]['stock '];
               $max=$data[$i]['stock_max '];
            echo"<tr><td>$nom<td/><td>$categorie</td><td>$emploi</td><td>$conteneur</td><td>$range</td><td>$date</td><td>$revient</td><td>$vente</td><td>$stock</td><td>$max</td>";
            echo"<td>";
          
           
            echo"</tr>";
        }
        
        ?>
    </table>

    </div>
</body>
</html>