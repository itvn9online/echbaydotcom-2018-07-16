<?php



//
set_time_limit(0);




// thêm nhóm trong leech data
if ( isset( $_GET['create_category'], $_GET['category_slug'] )
&& $_GET['create_category'] != ''
&& $_GET['category_slug'] != '' ) {
	if ( ! isset( $_GET['category_taxonomy'] ) ) {
		$_GET['category_taxonomy'] = 'category';
	}
	$_GET['create_category'] = trim( urldecode( $_GET['create_category'] ) );
	$_GET['category_slug'] = trim( urldecode( $_GET['category_slug'] ) );
	
	//
	$check_term_exist = term_exists( $_GET['category_slug'], $_GET['category_taxonomy'] );
	
	//
	if ( $check_term_exist !== 0 && $check_term_exist !== null ) {
		echo '<script>console.log("EXIST");</script>';
	}
	else {
		$done = wp_insert_term(
			// the term 
			$_GET['create_category'],
			// the taxonomy
			$_GET['category_taxonomy'],
			array(
//				'description'=> 'A yummy apple.',
				'slug' => $_GET['category_slug'],
				// tất cả các nhóm này mặc định cho vào nhóm ID là 1 hết
				'parent'=> 1
			)
		);
		
		//
		if ( is_wp_error( $done ) ) {
			print_r( $done );
			echo '<script>console.log("ERROR: ' . str_replace( '"', '&quot;', $done->get_error_message() ) . '");</script>';
		}
		else {
			echo '<script>console.log("OK");</script>';
		}
	}
	echo '<script>console.log("' . $_GET['create_category'] . '");</script>';
	echo '<script>console.log("' . $_GET['category_slug'] . '");</script>';
	echo '<script>console.log("' . str_replace( '-', '', $_GET['category_slug'] ) . '");</script>';
	
	exit();
}
// đọc và lấy thông tin bài viết
else if ( isset($_GET['categories_url']) ) {
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
		/*
		$a = explode( '//', $url );
		$a = $a[1];
//		_eb_alert($a);
		
		$a = explode( '/', $a );
		$a[0] = '';
		
		$a = implode( '/', $a );
		_eb_alert($a);
		
		$f = $a;
		*/
		
		if ( strlen( $url ) > 200 ) {
			$f = md5( $url );
		}
		else {
			$f = str_replace( '/', '-', str_replace( ':', '-', str_replace( ' ', '-', $url ) ) );
		}
//		_eb_alert($f);
		
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
			// Thay URL chuẩn của tên miền đang lấy tin, do thi thoảng bị lỗi domain (như của amazon)
			if ( isset( $_GET['source_url'] ) ) {
				$c = str_replace( web_link, urldecode( $_GET['source_url'] ), $c );
				
				//
//				$c = explode( web_link, $c );
//				$c = implode( urldecode( $_GET['source_url'] ), $c );
			}
			
			_eb_create_file ( $f, $c );
		}
	}
	
	//
	if ( isset( $_GET['load_in_iframe'] ) ) {
		$js = '<script>' . file_get_contents( EB_THEME_PLUGIN_INDEX . 'echbay/js/leech_data_after_iframe.js', 1 ) . '</script>';
		$c = str_replace( '</body>', $js, $c );
		$c = str_replace( '</BODY>', $js, $c );
		
		// xóa các thẻ không sử dụng
		$c = str_replace( '<iframe', '<eb-iframe', $c );
		$c = str_replace( '</iframe>', '</eb-iframe>', $c );
		
		$c = str_replace( '<link', '<eb-link', $c );
		$c = str_replace( '<style', '<eb-style', $c );
		$c = str_replace( '</style>', '</eb-style>', $c );
	}
	
	//
	echo $c;
	
	
	
	
	exit();
}






