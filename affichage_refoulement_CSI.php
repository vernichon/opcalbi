<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur

include("./conf/configuration.php");
include("./include/LogWriter.class.php");

// instanciation du fichier de log
$logWriter = new LogWriter($_fichierDeLog);



$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur de l'etat de la pompe1 de refoulement de CSI





//recherche de la derniere valeur du compteur horaire de la pompe1 de refoulement de CSII


if ($etat_p1=='True')
      {

        $a1="marche.php";
        } else {

        $a1="defaut.php";
        $logWriter -> writeMessage("defaut pompe 1 refoulement CSI  ");
        }



//recherche de la derniere valeur de l'etat de la pompe2 de refoulement de CSI




//affichage de l'etat de la pompe 2
if ($etat_p2=='True')
      {

        $a2="marche.php";
        }
        else {

        $a2="defaut.php";
        $logWriter -> writeMessage("defaut pompe 2 refoulement CSI  ");
        }




//recherche de la derniere valeur du compteur horaire de la  pompe2 de refoulement de CSI





//recherche de la derniere valeur de l'etat de la pompe 3 de refoulement de CSI



//affichage de l'etat de la pompe 3
if ($etat_p3=='True')
      {

        $a3="marche.php";
        }  else {

        $a3="defaut.php";
        $logWriter -> writeMessage("defaut pompe 3- refoulement CSI  ");
        }


//recherche de la derniere valeur du compteur horaire de la pompe3 refoulement de CSI


?>

<title>Refoulement</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>






<body link="#993300" vlink="#993300">
<h1>Refoulement</h1>




<!-- <table style="width: 100%; height: 25%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 1 <?php echo '<img src="'.$a1.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p1" ?>  </h1></td>
     </tr>

  </tr>


</tbody></table>
<p>

<table style="width: 100%; height: 25%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 2  <?php echo '<img src="'.$a2.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p2" ?>  </h1></td>
     </tr>

</tr>


</tbody></table>

<p>
<table style="width: 100%; height: 25%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 3  <?php echo '<img src="'.$a3.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p3" ?>  </h1></td>
     </tr>

  </tr>


  </tbody></table> -->
  

</body></html>





