<?php



//
set_time_limit(0);




//
if ( isset($_GET['categories_url']) ) {
	$url = str_replace( '&amp;', '&', urldecode( trim( $_GET['categories_url'] ) ) );
	echo $url . '<br>';
//	exit();
	
	//
	$dir_leech_cache = EB_THEME_CACHE . 'leech_data/';
	if( !is_dir($dir_leech_cache) ) {
		mkdir($dir_leech_cache, 0777) or die('mkdir error');
		// server window ko cần chmod
		chmod($dir_leech_cache, 0777) or die('chmod ERROR');
	}
	
	//
	$leech_id = isset($_GET['leech_id']) ? trim($_GET['leech_id']) : '';
	if ( $leech_id == '' ) {
		$a = explode( '//', $url );
		$a = $a[1];
//		_eb_alert($a);
		
		$a = explode( '/', $a );
		$a[0] = '';
		
		$a = implode( $a );
//		_eb_alert($a);
		
		$f = $a;
		
		/*
		$f = $a[ count($a) - 1 ];
		if ( $f == '' ) {
			$f = $a[ count($a) - 2 ];
		}
		*/
		
		$f = _eb_text_only( $f );
	} else {
		$f = $leech_id;
	}
	
	$f = $dir_leech_cache . $f . '.txt';
//	$f = $dir_for_ebcache . 'lech_data_' . md5( $url ) . '.txt';
	echo $f . '<br>';
	
	// lấy trong cache
	if ( file_exists($f) ) {
		$c = file_get_contents( $f, 1 );
	}
	// chưa có -> download mới
	else {
		
		//
		$c = _eb_getUrlContent( $url, 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html', array(), 1 );
		if ( $c == '' ) {
			$c = file_get_contents( $url, 1 );
		}
		
		// nếu có dữ liệu mới lưu lại
		if ( $c != '' ) {
			_eb_create_file ( $f, $c );
		}
	}
	
	echo $c;
	
	
	
	
	exit();
}






