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



//recherche de la derniere valeur du débit de la Gaougne

 $debit=rechercheValeur('MicroWin.CS01.USER1.DEBIT_GAO');

//recherche de la derniere valeur de l'etat de la pompe 1 de la Gaougne

  $etat_p1=rechercheValeur('MicroWin.CS01.USER1.DEF_P1_GAO');


 //affichage de l'etat de la pompe 1
  if ($etat_p1=='False')
      {

        $a1="marche.php";
        } else {

        $a1="defaut.php";
        $logWriter -> writeMessage("defaut pompe 1 Gaougne du ");
        }



//recherche de la derniere valeur de l'etat de la pompe 2 de la Gaougne

 $etat_p2=rechercheValeur('MicroWin.CS01.USER1.DEF_P2_GAO');


//affichage de l'etat de la pompe 2
     if ($etat_p2=='False')
      {

        $a2="marche.php";
        }

//recherche de la derniere valeur de l'etat de la pompe 3 de la Gaougne

  $etat_p3=rechercheValeur('MicroWin.CS01.USER1.DEF_P3_GAO');


//affichage de l'etat de la pompe 3
if ($etat_p3=='False')
      {

        $a3="marche.php";
        }



?>


<title>Production</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<!-- <h1>Gaougne  </h1> -->

<h1> <a href=Synoptique_Gaougne.html target="_blank">Gaougne</a> </h1>
<table style="width: 100%; height: 20%;" border="1">
     <tbody>

     <tr><td class="fond_bleu" align="center" width="20"><h1>debit <?php echo "$debit" ?> m3/h</h1></td> </tr>
     <tr><td class="fond_bleu" align="center" width="20"><h1>Pompe 1 <?php echo '<img src="'.$a1.'" alt="rond" />' ?>  </h1></td></tr>
     <tr><td class="fond_bleu" align="center" width="20"><h1>Pompe 2  <?php echo '<img src="'.$a2.'" alt="rond" />' ?>  </h1></td> </tr>
     <tr><td class="fond_bleu" align="center" width="20"><h1>Pompe 3  <?php echo '<img src="'.$a3.'" alt="rond" />' ?>  </h1></td> </tr>

     </tbody>
</table>
</body>
</html>





