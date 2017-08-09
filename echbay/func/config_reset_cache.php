<?php


//
$__eb_cache_conf = EB_THEME_CACHE . '___all.php';
if ( file_exists( $__eb_cache_conf ) ) {
	unlink( $__eb_cache_conf );
}



//
$file_last_update = EB_THEME_CACHE . '___all.txt';
if ( file_exists( $file_last_update ) ) {
	unlink( $file_last_update );
}




//
echo '<strong>Remove</strong> config cache<br>' . "\n";




