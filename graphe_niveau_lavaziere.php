
<html>
<head>
<meta http-equiv="refresh" content="600">
<?php
    $graphe=17;
        $limitmin=$_GET["limitmin"];
        $limitmax=$_GET["limitmax"];
    if (! $limitmax)
        {
            $limitmax=date("Y-m-d H:i:s");
        }
    if (! $limitmin)
        {
            /* $limitmin=date("Y-m-d H:i:s",mktime(date("H"),date("i"),date("s"),date("m"),date("d")-1,date("Y"))); */
            $limitmin=date("Y-m-d H:i:s",mktime(date("H"),date("i")-1,date("s"),date("m"),date("d"),date("Y")));
        }


function nom_graphe($id)
{
    $query="select * from graphes where graphes = ".$id;
    $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
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
        if ($valeur and (count(array_keys($retour,$valeur))==0)) // si valeur et non présent dans le tableau
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
        //~ print $query;
        $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
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
        $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
    $item = mysql_fetch_array($result);
    $query = "select ".$champs." from valeurs where ".$where." serveur = '".$item['serveur']."' and item ='".$item['item']."' ".$groupby." ".$order." ".$limit.";";
//  print $where."\r\n";
//  print $query."\r\n";
    $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
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
//~ Connection à la base de données
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');

$dates=dateenreg($limitmin,$limitmax);
//  print "dates";
//  print_r($dates);
$query="select * from graphes where id=".$graphe;
$result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
{
    $nomgraphe=$line['nom'];
    $typegraphe=$line['type'];
}
    // Liste les variables
$query = "select item from graphesvaleurs g  where  graphes = ".$graphe;
$res = mysql_query($query)  or die('Échec de la requête : ' . $query." ".mysql_error());
$listevariable=array();

while ($line = mysql_fetch_array($res, MYSQL_ASSOC)) 
    {
        $split=split_variable($line['item']);
        $listevariable=array_merge($listevariable,$split);
        //~ foreach ($split  as $valeur)
        //~ {
            //~ array_push($listevariable,$valeur);
        //~ }
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
             //~ print $line['variable']."<br>";
         //$lignes=valeur($line['variable']," SUBSTRING(dateenreg,1,13) as dateenreg, AVG(valeur) as valeur ","","GROUP BY SUBSTRING(dateenreg,1,13)");
           // toutes les 10 minutes
           //$lignes=valeur($line['variable']," SUBSTRING(dateenreg,1,15) as dateenreg, AVG(valeur) as valeur ","","GROUP BY SUBSTRING(dateenreg,1,15)");
            // toutes les valeurs 
           $$var=valeur($var,"*","","");
           //~ print "nbr ligne ".$nbrligne."<br>";
        }
        
        
        }



$query = "select * from graphesvaleurs g where graphes = ".$graphe;
$res = mysql_query($query)  or die('Échec de la requête : ' . $query." ".mysql_error());
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


if ($typegraphe=="barre")
{
    $lines=array();
    $bar = new bar();
    $bar->set_values(array($valeurs[0][count($valeurs)-1]));
    //$bar->set_values(array($valeurs[0][count($valeurs)]));
    $chart = new open_flash_chart();
    $x = new x_axis();
    $y = new y_axis();
    $x->set_labels($labels[count($valeurs)-1]);
    //$min=0;
    //$pas=($max-$min)/20;
    //$max=$max+10;

    $y->set_range( 0, 3500, 200 );
    //$chart->set_y_max(4);
    $chart->set_y_axis( $y );
    $chart->set_x_axis( $x );
    $chart->add_element($bar);
    $hauteur=400;
    $largeur=340;
    $titre['text']=$nomgraphe;
    $chart->set_title( $titre);
}


print '<script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript" src="/js/json/json2.js"></script>';

if ($typegraphe!="etat")
    {
        print '<script type="text/javascript">
swfobject.embedSWF("open-flash-chart.swf", "graphe", '.$largeur.','.$hauteur.',"9.0.0");
function load()
{}
var data ='.$chart->toPrettyString().'</script>
';


}
else
{
print '
<script type="text/javascript">
function load()
{
document.getElementById("graphe").innerHTML="<table align=\'left\'><tr><td bgcolor=\''.$couleur.'\'>'. $nomgraphe.'</td></tr>'.$valeur.'</table></br><br><br>";
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

function hello( line, index )
{
limite=data['x_axis']['labels'][index];
window.location.href="graphe.php?graphe=<?php echo $graphe ?>&limit="+limite;
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
function redimensionne()
{
limitmin=document.getElementById('min').value;
limitmax=document.getElementById('max').value;
window.location.href="graphe.php?graphe=<?php echo $graphe ?>&limitmin="+limitmin+"&limitmax="+limitmax;
}



</script>


<meta http-equiv="Content-Type" content="text/html;charset="UTF-8" />
<title>Serveur OPC <?php print $nomgraphe ?></title>
<style>
#graphe {
margin-left: 100px;
}
</style> 
</head>
<body onload="load();" >



<div position="absolute"  align="center" style="border:2;width:50%;margin:auto" id="graphe" >
    
</div


</body>
</html>