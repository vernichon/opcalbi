

<?php
$link = mysql_connect('localhost', 'opc','opc') or die('Impossible de se connecter : ' . mysql_error());
//~ Connection � la base de donn�es
mysql_select_db('opc') or die('Impossible de s�lectionner la base de donn�es');
$result = mysql_query("select * from graphes" ) or die('�chec de la requ�te : ' . mysql_error());
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
print '<form>';
print '<select name="grapheselect" onchange=parent.graphe.location.href=this.form.grapheselect.options[this.form.grapheselect.selectedIndex].value>\r\n';
foreach ($graphes as $graphe)
    {
        print "<option value='graphe.php?graphe=".$graphe['ID']."'>".$graphe['nom']."</option>\r\n";
        
    }
print "</select>\r\n";
print "refresh <input id='refresh' value='600'></form>";
?>