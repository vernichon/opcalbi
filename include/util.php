<?php

/* recherche de la derniere valeur des item  */

function rechercheValeur($item) {
    $query="SELECT * FROM `valeurs` WHERE item = '".$item."' ORDER BY id DESC LIMIT 1";
           //echo 'query = '.$query;

           $result= mysql_query($query) or die('Échec de la requête : '.$query." ".mysql_error());
            $ma=mysql_fetch_array($result);
            return $ma['valeur'];
}

function insere_defauts($automate,$item,$debut)
	{
	$req="insert into defauts (`automate`,`item`,`debut`) values ('".$automate."','".$item."','".$debut."')";
	mysql_query($req) or die("Impossible de se connecter : $req ". mysql_error());;
	return mysql_insert_id();
	}
	
function id_defaut($automate,$item)
	{
		$req="select id from defauts where automate='".$automate."' and item ='".$item."' and (acquittement is  null and fin is null)";
		$res=mysql_query($req) or die("Impossible de se connecter : $req ". mysql_error());
		return mysql_fetch_array($res);
	}	
	
function fin_defaut($id)
	{
		$req="update defauts set fin = '".date('Y-m-d H:i:s')."' where id = ".$id;
		mysql_query($req) or die("Impossible d'executer le requete : $req ". mysql_error());;
	}	
function acquitte($automate,$item)
	{
		$req="select * from defauts where automate='".$automate."' and item ='".$item."' and (acquittement is not null and fin is null)";
		$res=mysql_query($req) or die("Impossible de se connecter : $req ". mysql_error());
		$compteur = mysql_num_rows($res) ;
		if ( mysql_num_rows($res) >0)
			{
				return True;
			}
		else
			{
				return False;
			}
	}

function cherche_defauts($automate,$item)
	{
	$req="select * from defauts where automate='".$automate."' and item ='".$item."' and (acquittement is null and fin is null) or (fin is null)  ";
	$res=mysql_query($req) or die("Impossible de se connecter : $req ". mysql_error());
	$compteur = mysql_num_rows($res) ;
	if ( mysql_num_rows($res) >0)
		{
			return True;
		}
	else
		{
			return False;
		}
	
	
	}
?>

