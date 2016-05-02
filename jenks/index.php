<?php

/**
 *
 *	$ php example01.php
 *	From: 19 To: 26 (9)
 *	From: 40 To: 40 (7)
 *	From: 80 To: 83 (3)
 *	From: 100 To: 101 (2)
 *
 */

require "Jenks.php";

$_prices = array(
	355, 357.5, 368, 202.8, 196.5, 77.3, 119
);

$breaks = Jenks::getBreaks( $_prices, 4);

sort( $prices );
$cls = 1;
$from = $_prices[ 0 ];
$prices = array_unique( $_prices );
sort( $prices );

foreach( $prices as $i => $price ) {
	if( $price >= $breaks[ $cls ] ) {
		$count = 0;
		foreach( $_prices as $p ) {
			if( $p >= $from && $p <= $price ) {
				$count++;
			}
		}
		printf( "From: %s To: %s (%s)\n", $from, $price, $count );
		if( isset( $prices[ $i + 1 ] ) ) {
			$from = $prices[ $i + 1 ];
		}

		$cls++;
	}
}
?>
<br/>
<?php var_dump($breaks); ?>