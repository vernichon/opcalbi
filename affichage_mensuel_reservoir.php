<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection � la base de donn�es
mysql_select_db('opc') or die('Impossible de s�lectionner la base de donn�es');



//recherche de la derniere valeur du d�bimetre de Rue du Bain (n�gative)
//ATTENTION les valeurs positives et negatives sont invers�es dans l'automate
            $query="SELECT * FROM `valeurs` WHERE item ='rdb.Total.LAVZRDB+(Monthly_analysis).VT_R8'ORDER BY id DESC LIMIT 1";
            $result_RdbN = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_RdbN=mysql_fetch_array($result_RdbN);


//recherche de la derniere valeur du d�bimetre de Rue du Bain (positive)
            $query="SELECT * FROM `valeurs` WHERE item ='rdb.Total.LAVZRDB-(Monthly_analysis).VT_R8'ORDER BY id DESC LIMIT 1";
            $result_RdbP = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_RdbP=mysql_fetch_array($result_RdbP);


//recherche de la derniere valeur du d�bimetre de Lavaziere Refoulement (n�gative)
            $query="SELECT * FROM `valeurs` WHERE item ='lav.Total.LAVZREF-(Monthly_analysis).VT_R8'ORDER BY id DESC LIMIT 1";
            $result_RefN = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_RefN=mysql_fetch_array($result_RefN);


//recherche de la derniere valeur du d�bimetre de Lavaziere Refoulement (positive)
            $query="SELECT * FROM `valeurs` WHERE item ='lav.Total.LAVZREF+(Monthly_analysis).VT_R8'ORDER BY id DESC LIMIT 1";
            $result_RefP = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_RefP=mysql_fetch_array($result_RefP);

//recherche de la derniere valeur du d�bimetre de Lavaziere Saint Juery (n�gative)
            $query="SELECT * FROM `valeurs` WHERE item ='lav.Total.LAVZSJY_-(Monthly_analysis).VT_R8'ORDER BY id DESC LIMIT 1";
            $result_SJN = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_SJN=mysql_fetch_array($result_SJN);


//recherche de la derniere valeur du d�bimetre de Lavaziere Saint Juery (positive)
            $query="SELECT * FROM `valeurs` WHERE item ='lav.Total.LAVZSJY_+(Monthly_analysis).VT_R8'ORDER BY id DESC LIMIT 1";
            $result_SJP = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_SJP=mysql_fetch_array($result_SJP);




// si la somme des valeurs n�gatives est superieure � la somme des valeurs positives la fleche sera vers le bas
   if ($refoulement_RdbN['valeur']+$refoulement_RefN['valeur']+$refoulement_SJN['valeur']>$refoulement_RdbP['valeur']+$refoulement_RefP['valeur']+$refoulement_SJP['valeur'])
      {
       $a="fleche_bas.php";

        }
   ELSE
       {
        $a="fleche_haut.php";

        }

 $debit_mensuel=-($refoulement_RdbN['valeur']+$refoulement_RefN['valeur']+$refoulement_SJN['valeur'])+($refoulement_RdbP['valeur']+$refoulement_RefP['valeur']+$refoulement_SJP['valeur']);





?>

<title>D�bit mensuel</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>






<body link="#993300" vlink="#993300">
<h1>D�bordement et fuites / mois</h1>




<table style="width: 100%; height: 80%;" border="0">
   <tbody><tr>


     

 
     <td align="center" width="40"><h1><?php echo "$debit_mensuel" ?> m3 </h1></td>
     <!-- <td align="center" width="40"><h1><?php echo '<img src="'.$a.'" alt="fleche" />' ?>  </h1></td> -->
     



                                                                                  

  </tr>


</tbody></table>



</body></html>





