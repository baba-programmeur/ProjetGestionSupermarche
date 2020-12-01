<?php
 if(isset($_POST['query']))  
 {  
    $connect =new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($connect)
	{
        $query=$_POST['query'];
		//$output = '';  
		$result=$connect->query("SELECT nom_groupe FROM groupe WHERE nom_groupe LIKE '%".$query."%'");
		$result1=$connect->query("SELECT nom_groupe FROM groupe WHERE nom_groupe LIKE '%".$query."%'");
        if($result1)
		{		
		   $res=$result1->fetchAll();
			/*$output =*/echo '<ul style="width:10em;text-align:center;padding:0px;">'; 
			$nb_res = count($res);
			if($nb_res > 0)  
			{  
			   while($ligne = $result->fetch())  
			   {  
					/*$output .=*/ echo '<li style="text-decoration:none">'.$ligne['nom_groupe'].'</li>';  
			   }  
			}  
			else   
				/*$output .=*/echo "<li><span>Ce groupe n'existe pas dans la base de donnée</span></li>";    
			/*$output .= */echo '</ul>';  
			 //echo $output;  
		}
		else
			echo "<span>Ce groupe n'existe pas dans la base de donnée</span>"; 
	}
$connect=null;	
 }  
 
function recherche_prod()
 {
    echo "<script>  
    $(document).ready(function()
	{  
		$('#nom_prod').keyup(function()
		{  
		   var query1 = this.value;
		   if(query1 != '')  
			{  
				$.ajax(
				{  
					url:'fonction.php',  
					method:'POST',  
					data:{query1:query1},  
					success:function(data)  
					{  
						$('#List_prod').fadeIn();  
						$('#List_prod').html(data);  
					}  
				});  
			}  
		});  
		$(document).on('click', 'li', function(){  
			   $('#nom_prod').val($(this).text());  
			   $('#List_prod').fadeOut(); 	   
		});  
   });
</script>"; 
 }
 
 
function style_recherche()
{
echo "<style>   
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
</style>";
}
if(isset($_POST['query1']))  
{  
    $connect =new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($connect)
	{
        $query1=$_POST['query1'];  
		$result=$connect->query("SELECT nom_prod FROM produit WHERE nom_prod LIKE '%".$query1."%'");
		$result1=$connect->query("SELECT nom_prod FROM produit WHERE nom_prod LIKE '%".$query1."%'");
        if($result1)
		{		
		   $res=$result1->fetchAll();
			echo '<ul style="width:10em;text-align:center;padding:0px;">';
			$nb_res = count($res);
			if($nb_res > 0)  
			{  
			   while($ligne = $result->fetch())  
			   {  
					echo '<li style="text-decoration:none">'.$ligne['nom_prod'].'</li>';  
			   }  
			}  
			else   
				echo "<li><span>Ce produit n'existe pas dans la base de donnée</span></li>";    
			echo '</ul>';   
		}
		else
			echo "<span>Ce produit n'existe pas dans la base de donnée</span>"; 
	}
$connect=null;
}  

function entete_boutique()
{
	echo "<header id='tete'>
	<h1 id='h1_entete'>Sen supermarché le sénégal des grands<br/>Email: sensuper_marche@supmarche.sn téléphone: 339095874/773369685</h1>
    </header>
	<script>
    var i=0;
	setInterval(function(){
	var color = new Array('green', 'blue','silver','lime');
	var tete=document.getElementById('tete');
	tete.style.backgroundColor=color[i];
	tete.style.Color=color[i];
    i++;
	if(i==4)
	    i=0;
},1000
);
</script>
";
}


function afficher_date($el)
{
	echo " <script>
	setInterval(function(){
	var dat=document.getElementById('$el');
	var d=new Date();
	var j_du_mois =d.getDate();
	var j_de_sem =d.getDay();
	var annee=d.getFullYear();
	var m=d.getMonth();
	var h=d.getHours();
	var min=d.getMinutes();
	var sec=d.getSeconds();
	var jour=['Dimanche','Lundi','mardi','mercredi','jeudi','vendredi','samedi'];
	var mois=['janvier','février','mars','avril','mai','juin','juillet','aout','septembre','octobre','novembre','décembre'];
	dat.innerHTML=' / '+jour[j_de_sem]+' le '+j_du_mois+' '+mois[m]+' '+annee+' / heure: '+h+' : '+min+' : '+sec;
}, 1000
);
</script>";
}

function recherche_num()
 {
    echo "<script>  
    $(document).ready(function()
	{  
		$('#num_i_c').keyup(function()
		{  
		   var query2=this.value;
		   if(query2!='')  
			{  
				$.ajax(
				{  
					url:'fonction.php',  
					method:'POST',  
					data:{query2:query2},  
					success:function(data)  
					{  
						$('#List_num').fadeIn();  
						$('#List_num').html(data);  
					}  
				});  
			}  
		});  
		$(document).on('click', 'li', function(){  
			   $('#num_i_c').val($(this).text());  
			   $('#List_num').fadeOut(); 	   
		});  
   });
</script>"; 
 }


if(isset($_POST['query2']))  
{  
    $connect=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($connect)
	{
        $query2=$_POST['query2'];  
		$result=$connect->query("SELECT num_i_c FROM caissier WHERE num_i_c LIKE '%".$query2."%'");
		$result1=$connect->query("SELECT num_i_c FROM caissier WHERE num_i_c LIKE '%".$query2."%'");
        if($result1)
		{		
		   $res=$result1->fetchAll();
			echo '<ul style="width:10em;text-align:center;padding:0px;">';
			$nb_res = count($res);
			if($nb_res > 0)  
			{  
			    while($ligne = $result->fetch())   
					echo '<li style="text-decoration:none">'.$ligne['num_i_c'].'</li>';   
			}  
			else   
				echo "<li><span>Ce C.I.N n'existe pas dans la base de donnée</span></li>";    
			echo '</ul>';   
		}
		else
			echo "<span>Ce C.I.N n'existe pas dans la base de donnée</span>"; 
	}
$connect=null;
}  


function recherche_categorie()
 {
    echo "<script>  
    $(document).ready(function()
	{  
		$('#categ_prod').keyup(function()
		{  
		   var cat=this.value;
		   if(cat!='')  
			{  
				$.ajax(
				{  
					url:'fonction.php',  
					method:'POST',  
					data:{cat:cat},  
					success:function(data)  
					{  
						$('#List_cat').fadeIn();  
						$('#List_cat').html(data);  
					}  
				});  
			}  
		});  
		$(document).on('click', 'li', function(){  
			   $('#categ_prod').val($(this).text());  
			   $('#List_cat').fadeOut(); 	   
		});  
   });
</script>"; 
 }
 
 if(isset($_POST['cat']))  
{  
    $connect=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($connect)
	{
        $cat=$_POST['cat'];  
		$result=$connect->query("SELECT nom_categ FROM categorie WHERE nom_categ LIKE '%".$cat."%'");
		$result1=$connect->query("SELECT nom_categ FROM categorie WHERE nom_categ LIKE '%".$cat."%'");
        if($result1)
		{		
		   $res=$result1->fetchAll();
			echo '<ul style="width:10em;text-align:center;padding:0px;">';
			$nb_res = count($res);
			if($nb_res > 0)  
			{  
			    while($ligne = $result->fetch())   
					echo '<li style="text-decoration:none">'.$ligne['nom_categ'].'</li>';   
			}  
			else   
				echo "<li><span>Ce catégorie n'existe pas dans la base de donnée</span></li>";    
			echo '</ul>';   
		}
		else
			echo "<span>Ce catégorie n'existe pas dans la base de donnée</span>"; 
	}	
}  


/*function recherche_emplacement()
{
    echo "<script>  
    $(document).ready(function()
	{  
		$('#emp').keyup(function()
		{  
		   var emp=this.value;
		   if(emp!='')  
			{  
				$.ajax(
				{  
					url:'fonction.php',  
					method:'POST',  
					data:{emp:emp},  
					success:function(data)  
					{  
						$('#List_empl').fadeIn();  
						$('#List_empl').html(data);  
					}  
				});  
			}  
		});  
		$(document).on('click', 'li', function(){  
			$('#List_empl').fadeOut();
			$('#emp').val($(this).text()); 			   
		});  
   });
</script>"; 
}
 
if(isset($_POST['emp']))  
{  
    $connect=new PDO("mysql:host=localhost;dbname=boutique",'root',"");
	if($connect)
	{
        $emp=$_POST['emp'];  
		$result=$connect->query("SELECT nom_empl FROM emplacement WHERE nom_empl LIKE '%".$emp."%'");
		$result1=$connect->query("SELECT nom_empl FROM emplacement WHERE nom_empl LIKE '%".$emp."%'");
        if($result1)
		{		
		   $res=$result1->fetchAll();
			echo '<ul style="width:10em;text-align:center;padding:0px;">';
			$nb_res = count($res);
			if($nb_res > 0)  
			{  
			    while($ligne = $result->fetch())   
					echo '<li style="text-decoration:none">'.$ligne['nom_empl'].'</li>';   
			}  
			else   
				echo "<li><span>Cet emplacement n'existe pas dans la base de donnée</span></li>";    
			echo '</ul>';   
		}
		else
			echo "<span>Cet emplacement n'existe pas dans la base de donnée</span>"; 
	}	
} */
?>