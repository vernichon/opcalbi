<?php
/**
 * renvoie l'instance $_db
 */
$_db = ADONewConnection("mysql"); // type de base
if (!$_db) {
    die("Connexion � la base de donn�es impossible");
}
$_db->debug = true; // acvtivation du d�bug

// ne renvoie que les associations, pas les indices num�riques
$_db->SetFetchMode(ADODB_FETCH_ASSOC);

$ouvertureConnexion=$_db->Connect("localhost", "opc", "", "opc"); // connexion � la base
if (!$ouvertureConnexion) {
    die("Connexion � la database impossible : ".$_db->ErrorMsg());
}
?>