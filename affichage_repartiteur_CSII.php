<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">

<?php //~ Connection au serveur

include("./conf/configuration.php");
include("./include/LogWriter.class.php");
include("./include/util.php");

// instanciation du fichier de log
$logWriter = new LogWriter($_fichierDeLog);

$message="";

$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');



//recherche de la derniere valeur de PH_DESIRE_REPARTITEUR CSII

 //
 $phd=rechercheValeur('MicroWin.CS01.USER1.PH_DESIRE_REPARTITEUR')/100;
 $phd=valeuropc('S7200.OPCServer','MicroWin.CS01.USER1.PH_DESIRE_REPARTITEUR')/100;
//recherche de la derniere valeur de PH_REPARTITEUR CSII

 //$ph=rechercheValeur('MicroWin.CS01.USER1.PH_REPARTITEUR')/100;
 $ph=valeuropc('S7200.OPCServer','MicroWin.CS01.USER1.PH_REPARTITEUR')/100;
//recherche de la derniere valeur de POURCEN_UTIL_POMPE_REPA CSII

 $pourcent=rechercheValeur('MicroWin.CS01.USER1.POURCEN_UTIL_POMPE_REPA');


//recherche de la derniere valeur du debit eau brute CSII

  $dbe=rechercheValeur('MicroWin.CS01.USER1.DEBIT_CS2');


//recherche de la derniere valeur de l'etat de la pompe 1 du repartiteur de CSII

 // $etat_p1=valeuropc('S7200.OPCServer','MicroWin.CS01.USER1.MARCHE_P1_REPARTITEUR'); 
 $etat_p1=rechercheValeur('MicroWin.CS01.USER1.MARCHE_P1_REPARTITEUR');


//affichage de l'etat de la pompe 1
        if ($etat_p1=='True')
                {
			$id= id_defaut('MicroWin.CS01.USER1','MARCHE_P1_REPARTITEUR');
			if ($id)
				{
					fin_defaut($id);
				}
					
			$a1="marche.php";
		} 
	else
		{
			$a1='<img src=defaut.php alt="fleche" />';
                  
			if (! cherche_defauts('MicroWin.CS01.USER1','MARCHE_P1_REPARTITEUR'))
				{
					$id=insere_defauts('MicroWin.CS01.USER1','MARCHE_P1_REPARTITEUR',date('Y-m-d H:i:s'));
					$a1='<img src=defaut.php palt="fleche" /><form action="acquitte.php" method="post"><input type=text name=origine value="./Synoptique_CSII.html"><input type=text name=ID value='.$id.'></form>';
				}
			if  ( acquitte('MicroWin.CS01.USER1','MARCHE_P1_REPARTITEUR'))
				{
					$a1='<img src=affichage_acquitte.php palt="fleche" />';
					
				}
			else 
				{
					$id= id_defaut('MicroWin.CS01.USER1','MARCHE_P1_REPARTITEUR');
					$id=$id[0];
					$a1='<img src=defaut.php palt="fleche" /><form action="acquitte.php" method="post"><input type="submit" name = "ACK"  value="Acquitter"><input type=hidden name=origine value="./Synoptique_CSII.html"><input type=hidden name=ID value='.$id.'></form>';
				
				}

		}

//recherche de la derniere valeur de l'etat de la pompe 2 du repartiteur de CSII

  $etat_p2=rechercheValeur('MicroWin.CS01.USER1.MARCHE_P2_REPARTITEUR');



//affichage de l'etat de la pompe 2
            if ($etat_p2=='True')
                  {
                    $a2="marche.php";
                    } else {
                    $a2="defaut.php";
                    $logWriter -> writeMessage("defaut pompe 2 repartiteur CSII du ");
                    }





//recherche de la derniere valeur du compteur horaire de la pompe 1 du repartiteur de CSII

   //$compt_p1=rechercheValeur('MicroWin.CS01.USER1.XXXXXXXXXXXXXXXR');

//recherche de la derniere valeur du compteur horaire de la pompe2 du repartiteur de CSII

   //$compt_p2=rechercheValeur('MicroWin.CS01.USER1.XXXXXXXXXXXXXXXR');


//recherche de la derniere valeur de l'etat de la cuve1 du repartiteur de CSII

  $etat_c1=rechercheValeur('MicroWin.CS01.USER1.CUVE1_ACIDE_REPARTITEUR');



//affichage de l'etat de la cuve1
            if ($etat_c1=='True')
                  {

                    $c1="marche.php";
                    } else {

                    $c1="defaut.php";
                    $logWriter -> writeMessage("Cuve 1 du repartiteur vide du ");
                    }




//recherche de la derniere valeur de l'etat de la cuve1 du repartiteur de CSII

 $etat_c2=rechercheValeur('MicroWin.CS01.USER1.CUVE2_ACIDE_REPARTITEUR');


//affichage de l'etat de la cuve 2
            if ($etat_c2=='True')
                  {

                    $c2="marche.php";
                    } else {

                    $c2="defaut.php";
                    $logWriter -> writeMessage("Cuve 2 du repartiteur vide  ");
                    }

?>

<title>Repartiteur CSII</title><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles.css" rel="stylesheet" type="text/css"></head>

<body link="#993300" vlink="#993300">
<h1>Repartiteur</h1>

<table style="width: 100%; height: 20%;" border="1">
   <tbody> 
    <tr>
   
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>pH consigne : <?php echo "$phd" ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>pH mesuré : <?php echo "$ph" ?>  </h1></td>
     </tr>

     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>% pompe  : <?php echo "$pourcent" ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Débit EB CSII : <?php echo "$dbe" ?>  </h1></td>
     </tr>

 </tr>
  

</tbody></table>
<p>

<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 1  <?php echo $a1 ?>  </h1></td>
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
     <td class="fond_bleu" align="center" width="20"><h1>Pompe 2  <?php echo '<img src="'.$a2.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Compteur <?php echo "$compt_p2" ?>  </h1></td>
     </tr>
    </tr>


</tbody></table>

<table style="width: 100%; height: 20%;" border="1">
   <tbody><tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Cuve 1  <?php echo '<img src="'.$c1.'" alt="rond" />' ?>  </h1></td>
     </tr>
     <tr>
     <td class="fond_bleu" align="center" width="20"><h1>Cuve 2 <?php echo '<img src="'.$c2.'" alt="rond" />' ?>  </h1></td>
     </tr>
    </tr>
</tbody></table>
<?php
print $message;
?>
<a href="./log_defauts.php" target="_blank">Historique Défauts</a>
<br>


</body>
</html>





