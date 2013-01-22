

<?php

include 'php-ofc-library/open-flash-chart.php';

function make_def_dot()
{
  $d = new dot();
  return $d->size(4)->halo_size(0);
}

$data = array();

for( $i=0; $i<6.2; $i+=0.2 )
{
  $val = (sin($i) * 7) + 7;
  if( $val > 11.5 )
    $data[] = null;   // <-- LOOK!
  else
    $data[] = $val;

}

$title = new title( date("D M d Y") );

$line = new line();
$line->set_default_dot_style(make_def_dot());
$line->set_values( $data );
$line->set_width( 2 );

$y = new y_axis();
$y->set_range( 0, 15, 5 );


$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $line );
$chart->set_y_axis( $y );

echo $chart->toPrettyString();