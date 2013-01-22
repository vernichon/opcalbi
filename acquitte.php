<?php
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');

if (isset($_POST['ACK']))
{
	$req="update defauts set acquittement = '".date('Y-m-d H:i:s')."' where id = ".$_POST['ID'];
	mysql_query($req) or die("Impossible d'executer le requete : $req ". mysql_error());
}
if (isset($_POST['END']))
{
	$req="update defauts set fin = '".date('Y-m-d H:i:s')."' where id = ".$_POST['ID'];
	mysql_query($req) or die("Impossible d'executer le requete : $req ". mysql_error());;
}
if (isset($_POST['origine']))
{
	header("location: ".$_POST['origine']);
}
else
{
	header("location: ./log_defauts.php");
}
?>

