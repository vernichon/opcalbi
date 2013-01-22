<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur du débimetre de Rue du Bain (négative)
//ATTENTION les valeurs positives et negatives sont inversées dans l'automate
            $query="SELECT * FROM `valeurs` WHERE item ='rdb.LAVZRDB+.VT_R8'ORDER BY id DESC LIMIT 1";
            $result_n = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $refoulement_n=mysql_fetch_array($result_n);


//recherche de la derniere valeur du débimetre de Rue du Bain (positive)
            $query="SELECT * FROM `valeurs` WHERE item ='rdb.LAVZRDB-.VT_R8'ORDER BY id DESC LIMIT 1";
            $result_p = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $refoulement_p=mysql_fetch_array($result_p);


$debit=0;




// le débit affiché sera le débit non nul
   if ($refoulement_n['valeur']>$refoulement_p['valeur'])
      {
        $debit=$refoulement_n['valeur'];
        $a="fleche_bas.php";

        }
   ELSE
       {
        $debit=$refoulement_p['valeur'];
        $a="fleche_haut.php";

        }







?>

<title>Débit Rue du Bain</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>






<body link="#993300" vlink="#993300">
<h1>Débimetre Rue du Bain</h1>




<table style="width: 100%; height: 100%;" border="0">
   <tbody><tr>


     

 
     <td class = "debimetre" ><h1><?php echo "$debit" ?>  </h1></td>
     <td class = "debimetre" ><h1><?php echo '<img src="'.$a.'" alt="fleche" />' ?>  </h1></td>



                                                                                  

  </tr>


</tbody></table>



</body>
</html>





