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




//recherche de la derniere valeur de PH_sterilisation CSI

 $ph=rechercheValeur('MicroWin.CS01.USER1.PH_EAU_TRAITE_CS1')/100;


//recherche de la derniere valeur de ClO2 mesure CSI

  $clo2=rechercheValeur('MicroWin.CS01.USER1.CHLORE_STE_CS1')/100;


//recherche de la derniere valeur de la turbidite sterilisation CSI

   $turb=rechercheValeur('MicroWin.CS01.USER1.TURBI_EAU_TRAITE_CS1')/100;


//recherche de la derniere valeur de l'etat du traitement ClO2 sterilisation de CSI

            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.STE_EN_COUR_CS1'ORDER BY id DESC LIMIT 1";
            $result= mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $ma1=mysql_fetch_array($result);

 $etat_p1=rechercheValeur('MicroWin.CS01.USER1.STE_EN_COUR_CS1');

//affichage de l'etat de la pompe 1
            if ($etat_p1=='True')
                 {
                   $a1="marche.php";
                   } else {
                   $a1="defaut.php";
                   $logWriter -> writeMessage("defaut traitement sterilisation CSII ");
                   }





?>

<title>Sterilisation CSI</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<h1>Stérilisation</h1>

<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>pH  : <?php echo "$ph" ?>  </h1></td>
     </tr>

     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>ClO2 mesuré : <?php echo "$clo2" ?> mg/L </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Turbidité : <?php echo "$turb" ?> NTU </h1></td>
     </tr>

 </tr>
  


</tbody></table>
<p>

<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Traitement ClO2  <?php echo '<img src="'.$a1.'" alt="rond" />' ?>  </h1></td>
     </tr>
    </tr>









</body></html>





