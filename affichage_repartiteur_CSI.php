=<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
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



//recherche de la derniere valeur de PH_DESIRE_REPARTITEUR CSI


//recherche de la derniere valeur de PH_REPARTITEUR CSI

 $ph=rechercheValeur('MicroWin.CS01.USER1.PH_REPARTITEUR')/100;


//recherche de la derniere valeur de POURCEN_UTIL_POMPE_REPA CSI


//recherche de la derniere valeur du debit eau brute CSII

 $dbe=rechercheValeur('MicroWin.CS01.USER1.DEBIT_CS2');

//recherche de la derniere valeur du débit de la Gaougne

 $debit=rechercheValeur('MicroWin.CS01.USER1.DEBIT_GAO');

//calcul du debit eau brute de Caussels 1 = debit gaougne - debit eau brute Caussels II

            $dCSI=$debit-$dbe;


//recherche de la derniere valeur de l'etat de la pompe 1 du repartiteur de CSI


//affichage de l'etat de la pompe 1




//recherche de la derniere valeur de l'etat de la pompe 2 du repartiteur de CSI



//affichage de l'etat de la pompe 2





//recherche de la derniere valeur du compteur horaire de la pompe 1 du repartiteur de CSI



//recherche de la derniere valeur du compteur horaire de la pompe2 du repartiteur de CSI



//recherche de la derniere valeur de l'etat de la cuve1 du repartiteur de CSI



//affichage de l'etat de la cuve1


//recherche de la derniere valeur de l'etat de la cuve1 du repartiteur de CSI


//affichage de l'etat de la cuve 2


?>

<title>Repartiteur CSI</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<h1>Repartiteur</h1>




<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
   
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>pH consigne : <?php echo "$phd"  ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>pH mesuré : <?php echo "$ph" ?>  </h1></td>
     </tr>

     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>% pompe  : <?php  echo "$pourcent"  ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Débit EB CSI : <?php echo "$dCSI" ?>  </h1></td>
     </tr>

 </tr>
  


</tbody></table>
<p>

<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 1  <?php echo '<img src="'.$a1.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p1" ?>  </h1></td>
     </tr>
</tr>


</tbody></table>

<p>
<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 2  <?php echo  '<img src="'.$a2.'" alt="rond" />'  ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo  "$compt_p2" ?>  </h1></td>
     </tr>
    </tr>


</tbody></table>

<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Cuve 1  <?php echo '<img src="'.$c1.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Cuve 2 <?php echo  '<img src="'.$c2.'" alt="rond" />' ?>  </h1></td>
     </tr>
    </tr>





</body></html>





