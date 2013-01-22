<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
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



//recherche de la derniere valeur de ClO2 mesuré

  $clm=rechercheValeur('MicroWin.CS01.USER1.CHLORE_PRE_CS2')/100;


//recherche de la derniere valeur de turbidite filtration CSII

  $turb=rechercheValeur('MicroWin.CS01.USER1.TURBI_FILTRE_CS2')/100;


?>

<title>filtration CSII</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<h1>Filtration</h1>




<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
   
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>ClO2 mesuré : <?php echo "$clm" ?> mg/L </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Turbidité : <?php echo "$turb" ?> NTU </h1></td>
     </tr>

      </tr>
  

</body>
</html>





