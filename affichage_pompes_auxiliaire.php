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



//recherche de la derniere valeur de l'etat de la pompe 1 de la Gaougne

 $etat_p1=rechercheValeur('MicroWin.CS01.USER1.DEF_PVDC1_GAO');


//recherche de la derniere valeur du compteur horaire de la PVDC 1 de de la Gaougne
            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.TPS_DE_MARCHE_PVDC1_GAO'ORDER BY id DESC LIMIT 1";
            $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $t=mysql_fetch_array($result);
            $compt_p1=$t['valeur'];

  $compt_p1=rechercheValeur('MicroWin.CS01.USER1.TPS_DE_MARCHE_PVDC1_GAO');


if ($etat_p1=='False')
      {

        $a1="marche.php";
        }



//recherche de la derniere valeur de l'etat de la pompe 2 de la Gaougne

  $etat_p2=rechercheValeur('MicroWin.CS01.USER1.DEF_PVDC2_GAO');


//affichage de l'etat de la pompe 2
if ($etat_p2=='False')
      {

        $a2="marche.php";
        }



//recherche de la derniere valeur du compteur horaire de la pompe2 de de la Gaougne
 $compt_p2=rechercheValeur('MicroWin.CS01.USER1.TPS_DE_MARCHE_PVDC2_GAO');




?>

<title>pompe auxiliaire</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>






<body link="#993300" vlink="#993300">
<h1>Pompage auxiliaire </h1>




<table style="width: 100%; height: 103px;" border="1">
   <tbody><tr>
     <tr>

     <td class="fond_bleu"  width="20"><h1>PVC 1 <?php echo '<img src="'.$a1.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu"  width="20"><h1>Compteur <?php echo "$compt_p1" ?>  </h1></td>
     </tr>

  </tr>


</tbody></table>
<p>

<table style="width: 100%; height: 103px;" border="1">
   <tbody><tr>
     <tr>

     <td class="fond_bleu"  width="20"><h1>PVC 2 <?php echo '<img src="'.$a2.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu"  width="20"><h1>Compteur <?php echo "$compt_p2" ?>  </h1></td>
     </tr>

  </tr>


</tbody></table>


</body></html>





