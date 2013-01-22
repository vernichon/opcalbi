<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="refresh" content="600">
<?php
include("./conf/configuration.php");
include("./include/LogWriter.class.php");
include("./include/util.php");

// instanciation du fichier de log
$logWriter = new LogWriter($_fichierDeLog);

//~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur du debit eau brute CSII

  $dbe=rechercheValeur('MicroWin.CS01.USER1.DEBIT_CS2');
//recherche de la derniere valeur du débit de la Gaougne

  $debit=rechercheValeur('MicroWin.CS01.USER1.DEBIT_GAO');

//calcul du debit eau brute de Caussels 1 = debit gaougne - debit eau brute Caussels II

            $dCSI=$debit-$dbe;


//recherche de la derniere valeur de l'etat de la pompe1 de refoulement de CSII

  $etat_p1=rechercheValeur('MicroWin.CS01.USER1.BIT_MARCHE_P1REFOUL_CS2');

//recherche de la derniere valeur du compteur horaire de la pompe1 de refoulement de CSII

  $compt_p1=rechercheValeur('MicroWin.CS01.USER1.XXXXXXXXXXXXXXXXXXXXX');

if ($etat_p1=='True')
      {

        $a1="marche.php";
        } else {

        $a1="defaut.php";
        $logWriter -> writeMessage("defaut pompe 1 refoulement CSII  ");
        }



//recherche de la derniere valeur de l'etat de la pompe2 de refoulement de CSII

 $etat_p2=rechercheValeur('MicroWin.CS01.USER1.BIT_MARCHE_P2REFOUL_CS2');


//affichage de l'etat de la pompe 2
if ($etat_p2=='True')
      {

        $a2="marche.php";
        }
        else {

        $a2="defaut.php";
        $logWriter -> writeMessage("defaut pompe 2 refoulement CSII  ");
        }




//recherche de la derniere valeur du compteur horaire de la  pompe2 de refoulement de CSII

  $compt_p2=rechercheValeur('MicroWin.CS01.USER1.XXXXXXXXXXXXXXXXXXXXX');




//recherche de la derniere valeur de l'etat de la pompe 3 de refoulement de CSII

 $etat_p3=rechercheValeur('MicroWin.CS01.USER1.BIT_MARCHE_P3REFOUL_CS2');


//affichage de l'etat de la pompe 3
if ($etat_p3 =='True')
      {

        $a3="marche.php";
        }  else {

        $a3="defaut.php";
        $logWriter -> writeMessage("defaut pompe 3- refoulement CSII  ");
        }


//recherche de la derniere valeur du compteur horaire de la pompe3 refoulement de CSII

  $compt_p3=rechercheValeur('MicroWin.CS01.USER1.XXXXXXXXXXXXXXXXXXXXX');


?>


<title>Production</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<!-- <h1>Gaougne  </h1> -->

<h1> <a href=Synoptique_CSI.html target="_blank">CS I</a> </h1>
<table style="width: 100%; height: 20%;" border="1">
     <tbody>

     <tr><td class="fond_bleu" align="center" width="20"><h1>debit <?php echo "$dCSI" ?> m3/h</h1></td> </tr>


     </tbody>
</table>

<h1> <a href=Synoptique_CSII.html target="_blank">CS II</a> </h1>
<table style="width: 100%; height: 20%;" border="1">
     <tbody>

     <tr><td class="fond_bleu" align="center" width="20"><h1>debit <?php echo "$dbe" ?> m3/h</h1></td> </tr>
     <tr><td class="fond_bleu" align="center" width="20"><h1>Pompe 1 <?php echo '<img src="'.$a1.'" alt="rond" />' ?>  </h1></td></tr>
     <tr><td class="fond_bleu" align="center" width="20"><h1>Pompe 2  <?php echo '<img src="'.$a2.'" alt="rond" />' ?>  </h1></td></tr>
     <tr><td class="fond_bleu" align="center" width="20"><h1>Pompe 3  <?php echo '<img src="'.$a3.'" alt="rond" />' ?>  </h1></td></tr>

     </tbody>
</table>
</body>
</html>





