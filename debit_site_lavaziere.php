
<html>
<head>
<meta http-equiv="refresh" content="600">
<?php
//$graphe=$_GET["graphe"];
$graphe=8;
        $limitmin=$_GET["limitmin"];
        $limitmax=$_GET["limitmax"];
    if (! $limitmax)
        {
            $limitmax=date("Y-m-d H:i:s");

        }
    if (! $limitmin)
        {

            $limitmin=date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y")));
        }
        /* if (! $graphe) { 
        $graphe=14;
        } */





function nom_graphe($id)
{
    /* $query="select * from graphes where graphes = ".$id; */
    $query="select * from graphes where graphes ='14' ";
    $result = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
    $res=mysql_fetch_array($result, MYSQL_ASSOC);
    return $res['nom'];
}
function split_variable($variable)
{
    $pattern="`([A-Z]*)`";
    $retour=array();
    preg_match_all($pattern,$variable,$resultat);
    foreach ($resultat[0] as $valeur)
    {
        if ($valeur and (count(array_keys($retour,$valeur))==0)) // si valeur et non pr�sent dans le tableau
            {
                array_push($retour,$valeur);
            }
    }
    return $retour;
}
function dateenreg($min,$max)
    {
        $dates=array();
        $query="SELECT dateenreg from valeurs where dateenreg between '".$min."' and '".$max."' group by dateenreg order by dateenreg;";
        /* print $query; */
        $result = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
        while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
            {
                array_push($dates,$line['dateenreg']);
            }
        return $dates;
    }
function valeur($variable,$champs="dateenreg, valeur as valeur",$where='',$groupby='',$order=" order by dateenreg",$limit="")
     {
        $query="SELECT serveur,item FROM `variables` where variable ='".$variable."'";
    //~ print $query."\r\n";
        $result = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
    $item = mysql_fetch_array($result);
    $query = "select ".$champs." from valeurs where ".$where." serveur = '".$item['serveur']."' and item ='".$item['item']."' ".$groupby." ".$order." ".$limit.";";
//  print $where."\r\n";
//  print $query."\r\n";
    $result = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());
    $retour=array();
    $x=0;
    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
        {
            $retour[$line['dateenreg' ]]=$line;

        }
    return $retour;
            
}
include 'php-ofc-library/open-flash-chart.php';
//~ Connection au serveur
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection � la base de donn�es
mysql_select_db('opc') or die('Impossible de s�lectionner la base de donn�es');

$dates=dateenreg($limitmin,$limitmax);
//  print "dates";
//  print_r($dates);
$query="select * from graphes where id=".$graphe;
$result = mysql_query($query) or die('�chec de la requ�te : ' . $query." ".mysql_error());

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
{
    /* $nomgraphe=$line['nom']; */

    $typegraphe=$line['type'];
}
    // Liste les variables
$query = "select item from graphesvaleurs g  where  graphes = ".$graphe;
$res = mysql_query($query)  or die('�chec de la requ�te : ' . $query." ".mysql_error());
$listevariable=array();

while ($line = mysql_fetch_array($res, MYSQL_ASSOC)) 
    {
        $split=split_variable($line['item']);
        $listevariable=array_merge($listevariable,$split);

    }
        // Initialisation Compteur du nombre de ligne
        $nbrligne=0;
        // Initialisation Compteur de la table des items
        $nbrligne=0;
        $compteurlimite=0;
        // Initialisation de la table des valeurs
        $result=array();
    $lignes=array();
        // remplissage de la table des valeurs 
        foreach ($listevariable as $var)
        { 
        //~ print_r( $var)."\r\n";
        if ( $limitmin)
        {
          
           $$var=valeur($var,"*"," (dateenreg between '".$limitmin."' and '".$limitmax."') and ","");
           
        }
        else
        {
            // toutes les heures
            // $lignes=valeur($line['variable']," SUBSTRING(dateenreg,1,13) as dateenreg, AVG(valeur) as valeur ","","GROUP BY SUBSTRING(dateenreg,1,13)");
           // toutes les 10 minutes
           //$lignes=valeur($line['variable']," SUBSTRING(dateenreg,1,15) as dateenreg, AVG(valeur) as valeur ","","GROUP BY SUBSTRING(dateenreg,1,15)");
            // toutes les valeurs 
           $$var=valeur($var,"*","","");
           //~ print "nbr ligne ".$nbrligne."<br>";
        }
        
        
        }



$query = "select * from graphesvaleurs g where graphes = ".$graphe;
$res = mysql_query($query)  or die('�chec de la requ�te : ' . $query." ".mysql_error());
$nbrligne=0;
$valeurs=array();
$couleurs=array();
while ($line=mysql_fetch_array($res, MYSQL_ASSOC))
    {
        $valeurs[$nbrligne]=array();
        $couleurs[$nbrligne]=array();
        $linecouleurs[$nbrligne]=$line['couleur'];
        //~ print $line['item'];
        $nom[$nbrligne]=$line['designation'];
        $labels=array();
        //$couleurs=array();//[$nbrligne]=$line['couleur'];
        //print_r($couleurs);
        foreach ($dates as $date)
        {
            array_push($labels,$date);
            
            $valeur=$line['item'];
            //~ print "\r\n";
            foreach (split_variable($line['item']) as $var)
                {
                    //print_r(${$var}[$date]);
                    //print $var." = ".${$var}[$date]['valeur']."\r\n";
                    //print $valeur."\r\n";
                    if (array_key_exists($date,${$var}))
                    {
                        $valeur=str_replace($var,${$var}[$date]['valeur'],$valeur);
                    }
                    else
                    {
                        $valeur=0;
                    }
                    
                }
            
            $valeur=eval("return ".$valeur.";");
            
            if (! isset($min) or ($valeur<$min) ) 
                {
                    
                    $min=$valeur;
                    
                }
            if (!  isset($max) or ($valeur>$max) ) 
                {
                    $max=$valeur;
                    
                }
            if ($valeur<$line['min'])
                {
                    $couleur=$line['couleurmin'];
                }
            elseif ($valeur>$line['max'])
                {
                    $couleur=$line['couleurmax'];
                }
            else
                {
                    $couleur=$line['couleur'];
                }
            if ($typegraphe=="ligne")
            {           
                $tmp=new dot_value($valeur,$couleur);
                $tmp->set_tooltip( " {#val#}<br>".$date."<br>");
                $valeur=$tmp;
            }
            
            if ($typegraphe=="barre")
            {           
                $tmp=new bar_value($valeur);
                $tmp->set_colour($couleur);
                $tmp->set_tooltip( " {#val#}<br>".$date."<br>");
                $valeur=$tmp;
            }

                array_push($valeurs[$nbrligne],$valeur);
            array_push($couleurs[$nbrligne],$couleur);

        }
        
        $nbrligne=$nbrligne+1;
    }
    
    

//$couleurs=array('#0000FF','#00CC00','#990000','#FFFF00','#FF00FF','#33FFFF');


if ($typegraphe=="etat")
{
$valeur='';
    for ($x=0;$x<$nbrligne;$x++)
    {
        
       /*  $valeur = $valeur.'<tr><td bgcolor=\''.$couleurs[$x][count($couleur[$x])-1].'\'>'.$listevariable[$x].' : '. $labels[count($labels)-1].' = '.$valeurs[$x][count($valeurs[$x])-1].'</td></tr>'; */
           $valeur = $valeur.'<tr><td bgcolor=\''.$couleurs[$x][count($couleur[$x])-1].'\'>Debit : '. $labels[count($labels)-1].' = '.$valeurs[$x][count($valeurs[$x])-1].'</td></tr>';
    }
    
    //$couleur = $couleurs[0][count($couleurs)-1];
    //print $couleur;
}
/* print_r($valeurs) */;





print '<script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript" src="/js/json/json2.js"></script>';

/* if ($typegraphe!="etat")
    {
        print '<script type="text/javascript">
swfobject.embedSWF("open-flash-chart.swf", "graphe", '.$largeur.','.$hauteur.',"9.0.0");
function load()
{}
var data ='.$chart->toPrettyString().'</script>
';


}
else */
{
print '
<script type="text/javascript">
function load()
{
document.getElementById("graphe").innerHTML="<table><tr><td bgcolor=\''.$couleur.'\'>'. $nomgraphe.'</td></tr>'.$valeur.'</table></br><br><br>";
}
</script>';
}

?>


<script type="text/javascript">


function open_flash_chart_data()
{
    
    return JSON.stringify(data);
}

function load_1()
{
  tmp = findSWF("graphe");
  x = tmp.load( JSON.stringify(data_1) );
  
}



function findSWF(movieName) {
  if (navigator.appName.indexOf("Microsoft")!= -1) {
    return window[movieName];
  } else {
    return document[movieName];
  }
}

function line( index )
{
if (document.getElementById('min').value=='')
{
    document.getElementById('min').value=limite=data['x_axis']['labels'][index];
}
else
{
   document.getElementById('max').value=limite=data['x_axis']['labels'][index];
   }

}




</script>


<meta http-equiv="Content-Type" content="text/html;charset="UTF-8" />
<title>Serveur OPC <?php print $nomgraphe ?></title>
<style>


</style> 
</head>
<body onload="load();" >


<br>
<!-- <div   position="absolute" align="left" style="border:2;width:50%;margin:auto"  id="graphe" > </div> -->

<div   position="absolute" align="center" style="border:2;width:100%;margin:auto"  id="graphe" > </div>




<br>
<br>



<br>
</body>
</html>