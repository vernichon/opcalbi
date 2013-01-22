<?php
/**
 * Classe de gestion des logs applicatifs
 *
 */
class LogWriter {
    /* chemin vers le fichier de logs */
    var $pathFile;
    /**
     * Constructeur
     *
     * @param $pathFile : chemin vers le fichier de logs
     */
    public function LogWriter($pathFile) {
           $this->pathFile = $pathFile;
    }
    /**
     * ecrit une ligne de log
     *
     * @param $message : le message à ecrire
     * @param $level   : le niveau à ecrire (facultatif)
     */
    public function writeMessage($message, $level=false) {
           $separator = " - ";
           if (!$this->pathFile) {
              return false;
           }
           // constitution de la ligne
           $ligne=date("d/m/Y H:m:s");
           $ligne.=$separator;
           $ligne.=$_SERVER['PHP_AUTH_USER'];
           $ligne.=$separator;
           $ligne.=$_SERVER["REMOTE_ADDR"];
           $ligne.=$separator;
           if ($level) {
              $ligne.=$level;
              $ligne.=$separator;
           }
           $ligne.=$message;
           // retour à la ligne
           $ligne.="\r\n";

           // ecriture
           file_put_contents ($this->pathFile, $ligne,FILE_APPEND);
    }
}
?>