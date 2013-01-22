<?php
/**
 * renvoie l'instance $_db
 */
$_db = ADONewConnection("mysql"); // type de base
if (!$_db) {
    die("Connexion à la base de données impossible");
}
$_db->debug = true; // acvtivation du débug

// ne renvoie que les associations, pas les indices numériques
$_db->SetFetchMode(ADODB_FETCH_ASSOC);

$ouvertureConnexion=$_db->Connect("localhost", "opc", "", "opc"); // connexion à la base
if (!$ouvertureConnexion) {
    die("Connexion à la database impossible : ".$_db->ErrorMsg());
}
?>