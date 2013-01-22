<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr"><head><meta http-equiv="refresh" content="600">
<body>

<? 
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
mysql_select_db('opc') or die('Impossible de sélectionner la base de données');
$query="SELECT id,automate,item,debut,fin,acquittement FROM defauts order by debut desc" or die ('Erreur de requete : ' . mysql_error());
           
$result= mysql_query($query) or die('Échec de la requête : '.$query." ".mysql_error());
print "<br><br>";
print "<table align='center' border='1'>";
print "<tr><td>ID</td><td>Automate</td><td>Item</td><td>Debut defaut</td><td>Fin defaut</td><td>Acquittement defaut</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
while ($ligne = mysql_fetch_row($result)) 
                    {
			print '<tr><form action="acquitte.php" method="post"> <td><input type=text name=ID value='.$ligne[0].'></td><td>'.$ligne[1].'</td><td>'.$ligne[2].'</td><td>'.$ligne[3].'</td><td>'.$ligne[4].'</td><td>'.$ligne[5].'</td><td><input type="submit" name = "ACK"  value="Acquitter"></td><td><input type="submit" name = "END"  value="Fin"></td></form> </tr>';
                    }
		

print "</table>";
mysql_close()

?>
</body>
</html>