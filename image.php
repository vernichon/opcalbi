<?
header("Content-type: image/gif");

$debit=2;

/* echo "$debit"; */

 /* if ($debit==1)
    { */

    $image=("images/fleche_bas.gif");
  /*   }
else {
      $image=("images/fleche_haut.gif");
      } */



/* echo "$image"; */


readfile($image);
?>