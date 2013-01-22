<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="refresh" content="600">
<?php
include("./conf/configuration.php");
include("./include/LogWriter.class.php");
include("./include/util.php");

 //~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur du niveau Ultrason

  $nu=rechercheValeur('MicroWin.CS01.USER1.NIVEAU_ULTRASON_LAVAZ');


//recherche de la derniere valeur du du niveau Pression

 $np=rechercheValeur('MicroWin.CS01.USER1.NIVEAU_PRESSION_LAVAZ');


//recherche de la derniere valeur du niveau moyen

  $nmoy=rechercheValeur('MicroWin.CS01.USER1.MOYENNE_NIVEAUX_LAVAZ');




?>

<title>Niveau des reservoirs</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>


<body link="#993300" vlink="#993300">
<h1>Niveau du reservoire de Lavaziere</h1>




<table style="width: 100%; height: 103px;" border="1">
   <tbody><tr>


     

     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Niveau ultrason <?php echo "$nu" ?>  mm</h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Niveau pression <?php echo "$np" ?> mm</h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Niveau moyen <?php echo "$nmoy" ?> mm </h1></td>
     </tr>


                                                                                  

  </tr>


</tbody></table>



</body>
</html>





