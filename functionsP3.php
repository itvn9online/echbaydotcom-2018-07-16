<?php




function WGR_remove_html_comments ( $a ) {
	
	$str = '';
	
	$a = explode( '-->', $a );
	foreach ( $a as $v ) {
		$v = explode('<!--', $v);
		$str .= $v[0];
	}
	
	return $str;
	
}



