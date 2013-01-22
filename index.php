<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
	<meta name="generator" content="HTML Tidy for Linux/x86 (vers 11 August 2008), see www.w3.org"><?php
		
		$graphe=$_GET["graphe"];
		$limitmin=$_GET["limitmin"];
		$limitmax=$_GET["limitmax"];
		
		
		if (! $limitmax)
			{
				$limitmax=date("Y-m-d H:i:s");
				//$limitmax="2009-06-30 12:24:00";      
				
			}
		if (! $limitmin)
			{
					
				$limitmin=date("Y-m-d H:i:s",mktime(date("H")-1,date("i"),date("s"),date("m"),date("d")-1,date("Y")));
				//$limitmin='2009-06-30 11:25:00';
			}
		if (! $graphe) { 
			$graphe=2; 
			}
    function soustractdate($min,$max)
    {
        $mindatej = date("d", strtotime($min));
        $mindatem = date("m", strtotime($min));
        $mindatey = date("y", strtotime($min));
        $mindateh = date("H", strtotime($min));
        $mindatemi = date("i", strtotime($min));
        $mindatese = date("s", strtotime($min));
        $min = gmmktime ( $mindateh, $mindatemi,$mindatese, $mindatem, $mindatej, $mindatey );
        $maxdatej = date("d", strtotime($max));
        $maxdatem = date("m", strtotime($max));
        $maxdatey = date("y", strtotime($max));
        $maxdateh = date("H", strtotime($max));
        $maxdatemi = date("i", strtotime($max));
        $maxdatese = date("s", strtotime($max));
        $max = gmmktime ( $maxdateh, $maxdatemi,$maxdatese, $maxdatem, $maxdatej, $maxdatey );
        return $max - $min;
        
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
	function dateenreg($min,$max,$pas=1,$unite='HOUR')
		{
			$dates=array();
            $nbrvaleurs=1000;
			for ($x=1;$x<$nbrvaleurs;$x++)
                {
                    $query= "select date_ADD('".$min."', INTERVAL '".($x*$pas)."' ".$unite.") as date" ;
                    //print "date ". $query."<br>";
                    $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
                    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
                        {
                           if (date($line['date']) < date($max)){
                            array_push($dates,$line['date']);
                           }
                          
                        }
                    
                }
            /*$query="SELECT dateenreg from valeurs where dateenreg between '".$min."' and '".$max."' group by dateenreg order by dateenreg;";
			 
			$result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
			while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
				{
					array_push($dates,$line['dateenreg']);
				}*/
			return $dates;
		}
    function valeur2($variable,$listedate)
        {
            $query="SELECT serveur,item FROM `variables` v where variable ='".$variable."'";
            $retour=array();
            //~ print $query."\r\n";
            $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
            $item = mysql_fetch_array($result);
            for ($d=0;$d<count($listedate);$d++)
            {
                $query="select avg(valeur) as valeur from valeurs where  dateenreg between '".$listedate[$d]."' and date_sub('".$listedate[$d+1]."',INTERVAL 1 SECOND) and item ='".$item['item']."'";
                //print "<br>".$query."<br>";
                $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
                $countrows=mysql_num_rows($result);
                if ( $countrows== 0)
                {
                    $retour[$listedate[$d]]==Null;
                    //print "Null";
                }
                else
                {
                    while ($line = mysql_fetch_row($result)) //mysql_fetch_array($result, MYSQL_ASSOC)) 
                    {
                        $retour[$listedate[$d]]=$line[0];
                        //print $line[0];
                        //print_r($line);
        
                    }
                }
            }
            return $retour;
            
        }
	function valeur($variable,$champs="dateenreg, valeur as valeur",$where='',$groupby='',$order=" order by dateenreg",$listedate,$limit="")
	     {
		$query="SELECT serveur,item FROM `variables` v where variable ='".$variable."'";
		//~ print $query."\r\n";
		$result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
		$item = mysql_fetch_array($result);
		$query = "select ".$champs." from valeurs where ".$where." serveur = '".$item['serveur']."' and item ='".$item['item']."' ".$groupby." ".$order." ".$limit.";";
	//      print $where."\r\n";
		//print $query."\r\n";
		$result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
		$retour=array();

		while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
			{
				$retour[$line['dateenreg' ]]=$line;
				//print_r($line);

			}
		return $retour;
				
	}
	include 'php-ofc-library/open-flash-chart.php';
	
    //~ Connection au serveur
	$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
	
    //~ Connection à la base de données
	mysql_select_db('opc') or die('Impossible de sélectionner la base de données');
    $ecart=soustractdate($limitmin,$limitmax);
    
    
    $ecartjour= (floatval($ecart)/86400.0);
    
    if (($ecartjour <0.5))
    {
        $pas=10;
        $unite="MINUTE";
       
    }
    elseif (($ecartjour >=0.5)  and ($ecartjour <=1))
    {
        $pas=20;
        $unite="MINUTE";
        
    }
    elseif ($ecartjour >1 and $ecartjour<=8)
    {
        $pas=1;
        $unite="HOUR";
       
    }
    elseif ($ecartjour >8 and $ecartjour <=15)
    {
        $pas=2;
        $unite="HOUR";
        $dates=dateenreg($limitmin,$limitmax,2,'HOUR');
        print "Valeurs toute les 2 Heures"."<br>";
    } 
    elseif ($ecartjour >15 and $ecartjour<=75)
    {
        $pas=1;
        $unite="DAY";
        
    }
    elseif ($ecartjour >75 and $ecartjour<=150)
    {
        $pas=2;
        $unite="DAY";
    
    }
    elseif ($ecartjour >150 and $ecartjour<365)
    {
        $pas=3;
        $unite="DAY";

    }
    
    $dates=dateenreg($limitmin,$limitmax,$pas,$unite);
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
			if ( $limitmin)
			{
			  
	          $$var=valeur2($var,$dates);
    		   
			}
			else
			{
			    // toutes les heures
			     //~ print $line['variable']."<br>";
			  // $lignes=valeur($line['variable']," SUBSTRING(dateenreg,1,13) as dateenreg, AVG(valeur) as valeur ","","GROUP BY SUBSTRING(dateenreg,1,13)");
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
	$labels=array();
	foreach ($dates as $date)
		{
		array_push($labels,$date);
        //print_r( $date);
		}
	while ($line=mysql_fetch_array($res, MYSQL_ASSOC))
		{
			$valeurs[$nbrligne]=array();
			$couleurs[$nbrligne]=array();
			$linecouleurs[$nbrligne]=$line['couleur'];
			//~ print $line['item'];
			$nom[$nbrligne]=$line['designation'];
			
			//$couleurs=array();//[$nbrligne]=$line['couleur'];
			//print_r($couleurs);
			foreach ($dates as $date)
			{
				
				
				$valeur=$line['item'];
				//~ print "\r\n";
				foreach (split_variable($line['item']) as $var)
					{
					/*	print_r(${$var}[$date])."<br>";
						print "var ".$var." = ".${$var}[$date]['valeur']."<br>";
						print "valeur ".$valeur."<br>";*/
						if ( ${$var}[$date]['valeur'])
						{
							$valeur=str_replace($var,${$var}[$date],$valeur);
						}
						else
						{
							$valeur=${$var}[$date];
						}
					}
				
				if ($valeur)
				{
				$valeur=eval("return ".$valeur.";");
				}
				//print "DBG ".$valeur."<br>";
				if ($valeur and (! isset($min)or $valeur<$min) ) 
					{
						//print " ! min ou val<min Val : ".$valeur." min :  ".$min." max : ".$max."<br>";
						$min=$valeur;
						
						
					}
				if ($valeur and ( ! isset($max) or $valeur>$max )) 
					{
						
						//print " ! max ou val>max Val : ".$valeur." min :  ".$min." max : ".$max."<br>";       
						$max=$valeur;
						
						
					}
					
				if ($valeur == null and ($min > 0 or ! isset($min))) 
					{
						//print " ! valeur et min <> 0 : ".$valeur." min :  ".$min." max : ".$max."<br>";       
						$min=0;
						//print " ! valeur et min <> 0 : ".$valeur." min :  ".$min." max : ".$max."<br><br>";   
					}
				if ($valeur == null and ($max < 0 or ! isset($max)))
					{
						//print " ! valeur et max <> 0 : ".$valeur." min :  ".$min." max : ".$max."<br>";       
						$max=0;
						//print " ! valeur et max <> 0 : ".$valeur." min :  ".$min." max : ".$max."<br><br>";   
					}
				
				//print "Val : ".$valeur." min :  ".$min." max : ".$max."<br>";
				if ($valeur)
					{
						
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
					}
				
				if ($typegraphe=="ligne")
				{                       
					if (is_null($valeur))
					{
						
						$tmp=null;
					}
					else
					{
						$tmp=new dot_value($valeur,$couleur);
						
						$tmp->set_tooltip( " {#val#}<br>".$date."<br>");
						
						//$valeur=$tmp;
						
					}
				}
				
				if ($typegraphe=="barre")
				{                       
					if (is_null($valeur))
					{
                        //print "est null";
						$tmp=null;
					}
					else
					{
						$tmp=new bar_value($valeur);
						$tmp->set_colour($couleur);
						$tmp->set_tooltip( " {#val#}<br>".$date."<br>");
						//$valeur=$tmp;
					}
				}

				
				array_push($valeurs[$nbrligne],$tmp);
				array_push($couleurs[$nbrligne],$couleur);
					

			}
			
			$nbrligne=$nbrligne+1;
		}
		
		

	//$couleurs=array('#0000FF','#00CC00','#990000','#FFFF00','#FF00FF','#33FFFF');
	//print_r($valeurs[$x]);
    $titre['text']=$nomgraphe."\n Ecart en jour : ".sprintf("%01.2f",$ecartjour)."\n Pas : $pas $unite";
	if ($typegraphe=="ligne")
	{
		$lines=array();
		$chart = new open_flash_chart();
		$chart->set_bg_colour( '#FFFFFF' );
		for ($x=0;$x<$nbrligne;$x++)
		{
			   $lines[$x]= new line_dot();     
			   $lines[$x]->set_values($valeurs[$x]);
			   $lines[$x]->set_halo_size( 0 );
			   $lines[$x]->set_width( 1 );
			   $lines[$x]->set_dot_size( 6 );
			   $lines[$x]->set_colour($linecouleurs[$x]);
			   $lines[$x]->set_key($nom[$x],15);
			   $lines[$x]->set_on_click( "line" );
			   $chart->add_element( $lines[$x] );
		}
		$y = new y_axis();
		$x = new x_axis();
		
		$xlabels = new x_axis_labels();
		$xlabels->set_labels($labels);
		$xlabels->set_vertical();       

		$x->set_grid_colour="#ffffff";
		$x->set_labels($xlabels);

		$pas=intval((abs($max-$min))/20);
		$y->set_range($min, $max, $pas);
		
		$chart->set_y_axis( $y );
		$chart->set_x_axis( $x );

		$chart->set_title( $titre);
		$hauteur=600;
		$largeur=1200;
	}

	if ($typegraphe=="barre")
	{
		$lines=array();
		$bar = new bar();
		$bar->set_values(array($valeurs[0][count($valeurs)-1]));
		$chart = new open_flash_chart();
		$x = new x_axis();
		$y = new y_axis();
		$x->set_labels($labels[count($valeurs)-1]);
		$min=0;
		$max=$max+10;
		$y->set_range( $min, $max, 20 );
		$chart->set_y_axis( $y );
		$chart->set_x_axis( $x );
		$chart->add_element($bar);
		$hauteur=400;
		$largeur=340;

		$chart->set_title( $titre);
	}
	if ($typegraphe=="etat")
	{
		$valeur = $valeurs[0][count($valeurs)-1];
		$couleur = $couleurs[0][count($couleurs)-1];
		//print $couleur;
	}
	//print_r($valeurs);


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
	document.getElementById("graphe").innerHTML="<table align=\'left\'><tr><td bgcolor=\''.$couleur.'\'>'. $nomgraphe.'</td></tr><tr><td bgcolor=\''.$couleur.'\'>'. $labels[count($labels)-1].' = '.$valeur.'</td></tr></table></br>";
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
	window.location.href="index.php?graphe=<?php echo $graphe ?>&limit="+limite;
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

	document.getElementById('min').value=limite=data['x_axis']['labels']['labels'][index];
	}
	else
	{
	document.getElementById('max').value=limite=data['x_axis']['labels']['labels'][index];
	}

	}
	function redimensionne()
	{
	limitmin=document.getElementById('min').value;
	limitmax=document.getElementById('max').value;
	window.location.href="index.php?graphe=<?php echo $graphe ?>&limitmin="+limitmin+"&limitmax="+limitmax;
	}



	</script><?php
	    
	    //~ $link = mysql_connect('127.0.0.1', 'root', 'saikaku') or die('Impossible de se connecter : ' . mysql_error());
	    //~ mysql_select_db('opc') or die('Impossible de sélectionner la base de données');
	    $result = mysql_query("select * from graphes" ) or die('Échec de la requête : ' . mysql_error());
	    $graphes=array();
	    $compteur_graphe=0;
	    while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
		    if ($line['ID']==$graphe) {
			$nomgraphe=$line['nom'];
			}
		    $graphes[$compteur_graphe]=$line;
		    $compteur_graphe=$compteur_graphe+1;
		}
		//~ window.addEvent('domready', function(){$('graphe').makeDraggable();});
	?>
	<meta http-equiv="Content-Type" content="text/html; charset=us-ascii">

	<title>Serveur OPC <?php print $nomgraphe ?></title>
	<style type="text/css">
#graphe {

	margin-left: 10px;


	}
	</style>
</head>

<body onload="load();">
	<?php
	//~ include('xmlrpc.inc');
	$GLOBALS['xmlrpc_internalencoding']="UTF-8";
	/*
	<script type="text/javascript" src="/moo/mootools-1.2.1-core.js"></script>
	<script type="text/javascript" src="/moo/mootools-1.2-more.js"></script>
	onLoad="javascript:timedRefresh(10000)"
	Array
	(
	    [0] => Read                  access
	    [1] => 50                    server scan rate
	    [2] => 02/19/09 09:04:55     timestamp
	    [3] => VT_R8                 item 
	    [4] => Bad                   qualite 
	    [5] => 0                     valeur 
	    [6] => lav.LAVZSJY_-.VT_R8   item id
	)
	*/
	//~ $client = new xmlrpc_client("http://10.50.1.2:10018/RPC2");
	//~ function read($serveur,$item)
	//~ {
	    //~ global $client;
	    //~ $msg = new xmlrpcmsg('valeur');
	    //~ $msg->addParam(new xmlrpcval($serveur, "string"));
	    //~ $msg->addParam(new xmlrpcval($item, "string"));
	    //~ $resp = $client->send($msg)->value();
	   //~ return array_values(php_xmlrpc_decode($resp));
	//~ }
	print '<div><form>';
	print '<select name="grapheselect" onchange=window.location.href=this.form.grapheselect.options[this.form.grapheselect.selectedIndex].value>\r\n';
	foreach ($graphes as $graphelist)
	    {
		if ($graphelist['ID'] == $graphe)
		{
			print "<option value='index.php?graphe=".$graphelist['ID']."' selected=\"selected\" >".$graphelist['nom']."</option>\r\n";

		}
		else
		{
			print "<option value='index.php?graphe=".$graphelist    ['ID']."'>".$graphelist['nom']."</option>\r\n";
		}
		
	    }
        ?>
	</select>
   <!--</form>
	
		<form name="resize" id="resize">-->
			Minimun : <input id="min"> Maximun : <input id="max"> <input type="button" value="Redimensionne" onclick='redimensionne();'>
		</form>
	</div>
<br>
    <div position="absolute" align="center" style="border:2;width:50%;margin:auto" id="graphe"></div><br>

<br>
</body>
</html>
