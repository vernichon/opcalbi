<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
<?php //~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection � la base de donn�es
mysql_select_db('opc') or die('Impossible de s�lectionner la base de donn�es');



//recherche de la derniere valeur du d�bimetre de Lavaziere Saint Juery (n�gative)
            $query="SELECT * FROM `valeurs` WHERE item ='lav.LAVZSJY_-.VT_R8'ORDER BY id DESC LIMIT 1";
            $result_n = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_n=mysql_fetch_array($result_n);


//recherche de la derniere valeur du d�bimetre de Lavaziere Saint Juery (positive)
            $query="SELECT * FROM `valeurs` WHERE item ='lav.LAVZSJY_+.VT_R8'ORDER BY id DESC LIMIT 1";
            $result_p = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
            $refoulement_p=mysql_fetch_array($result_p);




/* echo "$refoulement_n['valeur']";
echo "$refoulement_p['valeur']"; */



// le d�bit affich� sera le d�bit non nul
   if ($refoulement_n['valeur']>$refoulement_p['valeur'])
      {
        $debit=$refoulement_n['valeur'];
        $a="fleche_bas.php";

        }
   ELSE
       {
        $debit=$refoulement_p['valeur'];
        $a="fleche_haut.php";

        }







?>

<title>D�bit refoulement Saint Juery</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css">
</head>




<body><div class="imghtml"><!-- c'est cette image qui sert de fond d'ecran --><img class="imghtml" src="images/fond_gris_bleu.jpg" alt="debimetre" title="" /></div>







<h1>Refoulement Saint-Ju�ry</h1>




<table style="width: 100%; height: 100%;" border="0">
     <tr>
     <td class = "debimetre" ><h1><?php echo "$debit" ?>  </h1></td>
     <td class = "debimetre" ><h1><?php echo '<img src="'.$a.'" alt="fleche" />' ?>  </h1></td>
      </tr>



</table>



</body>
</html>


