<?
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
function valeur($variable,$champs="dateenreg, valeur as valeur",$where='',$groupby='',$order=" order by dateenreg",$limit="")
     {
        $query="SELECT serveur,item FROM `variables` v where variable ='".$variable."'";
        $result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
	$item = mysql_fetch_array($result);
	$query = "select ".$champs." from valeurs where ".$where." valeur <> '0.0' and serveur = '".$item['serveur']."' and item ='".$item['item']."' ".$groupby." ".$order." ".$limit.";";
	$result = mysql_query($query) or die('Échec de la requête : ' . $query." ".mysql_error());
	$retour=array();
	$x=0;
	while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
			$retour[$x]=$line;
			$x=$x+1;
		}
	return $retour;
			
	}
?>

