<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
   <link rel="stylesheet" href="styles.css"  type="text/css">


<meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche du dernier timestamp du débit de la Gaougne

            $query="SELECT * FROM `valeurs` WHERE item ='MicroWin.CS01.USER1.STE_EN_COUR_CS1'ORDER BY id DESC LIMIT 1";
            $result= mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $d=mysql_fetch_array($result);

            $timestamp=$d['timestamp'];




?>

  <title>synoptique_CSI </title>
</head>
<body>

<i class="titre_synoptique">Synoptique du site de Caussels I  <?php echo $timestamp?><i>
</body>
</html>



