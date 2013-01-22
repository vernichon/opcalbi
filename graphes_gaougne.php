<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur

include("./conf/configuration.php");
include("./include/LogWriter.class.php");
include("./include/util.php");

// instanciation du fichier de log
$logWriter = new LogWriter($_fichierDeLog);



$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur de l'etat de la pompe 1 de la Gaougne

  $etat_p1=rechercheValeur('MicroWin.CS01.USER1.DEF_P1_GAO');



//recherche de la derniere valeur du compteur horaire de la pompe1 de de la Gaougne

   $compt_p1=rechercheValeur('MicroWin.CS01.USER1.TPS_DE_MARCHE_P1_GAO');

if ($etat_p1=='False')
      {

        $a1="marche.php";
        } else {

        $a1="defaut.php";
        $logWriter -> writeMessage("defaut pompe 1 Gaougne  ");
        }



//recherche de la derniere valeur de l'etat de la pompe 2 de la Gaougne

  $etat_p2=rechercheValeur('MicroWin.CS01.USER1.DEF_P2_GAO');


//affichage de l'etat de la pompe 2
if ($etat_p2=='False')
      {

        $a2="marche.php";
        }

//recherche de la derniere valeur de la vitesse de la pompe 2 de la Gaougne

 $v_p2=rechercheValeur('MicroWin.CS01.USER1.VITESSE_P2_GAO');


//recherche de la derniere valeur du compteur horaire de la pompe2 de de la Gaougne
  $compt_p2=rechercheValeur('MicroWin.CS01.USER1.TPS_DE_MARCHE_P2_GAO');


//recherche de la derniere valeur de l'etat de la pompe 3 de la Gaougne

 $etat_p3=rechercheValeur('MicroWin.CS01.USER1.DEF_P3_GAO');


//affichage de l'etat de la pompe 3
if ($etat_p3=='False')
      {

        $a3="marche.php";
        }

//recherche de la derniere valeur de la vitesse de la pompe 3 de la Gaougne
 
 $v_p3=rechercheValeur('MicroWin.CS01.USER1.VITESSE_P3_GAO');

//recherche de la derniere valeur du compteur horaire de la pompe3 de de la Gaougne
   $compt_p3=rechercheValeur('MicroWin.CS01.USER1.TPS_DE_MARCHE_P3_GAO');


?>

<title>pompe Gaougne</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>






<body link="#993300" vlink="#993300">
<h1>Pompes</h1>




<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 1 <?php echo '<img src="'.$a1.'" alt="fleche" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p1" ?>  </h1></td>
     </tr>

  </tr>


</tbody></table>
<p>

<table style="width: 100%; height: 33%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 2  <?php echo '<img src="'.$a2.'" alt="fleche" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p2" ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Vitesse <?php echo "$v_p2" ?>  tr/mn </h1></td>
     </tr>

</tr>


</tbody></table>

<p>
<table style="width: 100%; height: 33%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 3  <?php echo '<img src="'.$a3.'" alt="fleche" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p3" ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Vitesse <?php echo "$v_p3" ?>  tr/mn </h1></td>
     </tr>
                                                                                  

  </tr>


</tbody></table>
</body>
</html>





