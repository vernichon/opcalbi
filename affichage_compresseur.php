<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur


include("./conf/configuration.php");
include("./include/LogWriter.class.php");
include("./include/util.php");

// instanciation du fichier de log
$logWriter = new LogWriter($_fichierDeLog);

$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur de l'etat du compresseur de la Gaougne

            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.DEF_COMP_GAO'ORDER BY id DESC LIMIT 1";
            $result= mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $ma=mysql_fetch_array($result);

           $etat_p1=rechercheValeur('MicroWin.CS01.USER1.DEF_COMP_GAO');







//recherche de la derniere valeur du compteur horaire du compresseur de de la Gaougne

            $compt_p1=rechercheValeur('MicroWin.CS01.USER1.TPS_DE_MARCHE_COMP_GAO');




if ($etat_p1=='False')
      {

        $a1="marche.php";
        }  else {

        $a1="defaut.php";
        $logWriter -> writeMessage("defaut pompe compresseur anti-bélier ");
        }





?>

<title>Compresseur anti-bélier</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<h1>Compresseur anti-bélier </h1>


<table style="width: 100%; height: 103px;" border="1">
   <tbody><tr>
     <tr>

     <td class="fond_bleu"  width="20"><h1>Compresseur  <?php echo '<img src="'.$a1.'" alt="fleche" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu"  width="20"><h1>Compteur <?php echo "$compt_p1" ?>  </h1></td>
     </tr>

  </tr>


</tbody></table>



</body>
</html>





