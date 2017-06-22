<?php



add_filter('rewrite_rules_array', 'kill_feed_rewrites');

function kill_feed_rewrites($rules){
	print_r( $rules );
	
	return $rules;
}





