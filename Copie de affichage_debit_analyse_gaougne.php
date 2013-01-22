<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
<meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur du débit de la Gaougne

            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.DEBIT_GAO'ORDER BY id DESC LIMIT 1";
            $result= mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $d=mysql_fetch_array($result);

            $debit=$d['valeur'];

//recherche du dernier timestamp du débit de la Gaougne

            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.DEBIT_GAO'ORDER BY id DESC LIMIT 1";
            $result= mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $d=mysql_fetch_array($result);

            $timestamp=$d['timestamp'];



//recherche de la derniere valeur du ph de de la Gaougne
            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.PH_GAO'ORDER BY id DESC LIMIT 1";
            $result_p = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $p=mysql_fetch_array($result_p);
            $ph=$p['valeur']/100;




//recherche de la derniere valeur de turbidite de de la Gaougne
            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.TURBI_GAO'ORDER BY id DESC LIMIT 1";
            $result_t = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $t=mysql_fetch_array($result_t);
            $tb=$t['valeur'];






?>

<title>Débit et analyses gaougne</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>






<body link="#993300" vlink="#993300">
<h1>Débit et analyses gaougne</h1>




<table style="width: 100%; height: 103px;" border="1">
   <tbody><tr>


     

     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>debit <?php echo "$timestamp" ?>  </h1></td>
     <td class="fond_bleu" align="center" width="20"><h1>debit <?php echo "$debit" ?> </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Ph <?php echo "$ph" ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>turbidite <?php echo "$tb" ?>  </h1></td>
     </tr>


                                                                                  

  </tr>


</tbody></table>



</body></html>





