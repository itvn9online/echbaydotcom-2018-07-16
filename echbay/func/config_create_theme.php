<?php



function WGR_create_themes_default_format (
	// nơi lưu file
	$f,
	// tên file
	$fname,
	// vị trí của file: top, footer....
	$position,
	// định dạng file
	$type = 'php',
	// nội dung file
	$default_content = '',
	// nội dung css cho file
	$default_css_content = ''
) {
	
	$html = $f . $fname . '.' . $type;
	$css = $f . $fname . '.css';
	
	// nếu file tồn tại rồi thì thôi
	if ( file_exists( $html ) ) {
		return false;
	}
	
	// kiểm tra trong plugin
	$ar_for_check_file = array(
		'top',
		'footer',
		'threaddetails',
		'threadnode',
	);
	foreach ( $ar_for_check_file as $v ) {
		$fcheck = EB_THEME_PLUGIN_INDEX . 'themes/' . $v . '/' . $fname . '.' . $type;
//		echo $fcheck . '<br>' . "\n";
		
		//
		if ( file_exists( $fcheck ) ) {
			return false;
		}
	}
	
	
	
	// tạo HTML mặc định nếu chưa có
	if ( $default_content == '' ) {
		$default_content = trim( '
<div id="' . $fname . '">
	<div class="<?php echo $__cf_row[\'cf_' . $position . '_class_style\']; ?>">
		<div class="' . $fname . '">
			<!-- Write HTML code to here -->
		</div>
	</div>
</div>
<?php
/*
*
* List function recommended for you, please remove after code finish.
*
* Get logo for website:
* EBE_get_html_logo();
*
* Big banner (primary banner):
* WGR_get_bigbanner();
*
* Get search form:
* EBE_get_html_search();
*
* GET cart URL:
* EBE_get_html_cart();
*
* GET profile URL:
* EBE_get_html_profile();
*
* GET top menu (auto):
* EBE_echbay_top_menu();
*
* GET footer menu (auto):
* EBE_echbay_footer_menu();
*
* GET contact info
* EBE_get_html_address();
*
*/
		' );
	}
	
	_eb_create_file( $html, $default_content );
	
	
	
	// tạo CSS mặc định nếu chưa có
	if ( $default_css_content == '' ) {
		for ( $i = 0; $i < 10; $i++ ) {
			$default_css_content .= '#' . $fname . ' { }' . "\n";
		}
	}
	
	_eb_create_file( $css, $default_css_content );
	
	
	
	//
	return true;
	
}



//
//print_r( $_POST ); exit();


//
$dir_for_save_theme = EB_THEME_URL . 'theme/ui/';

$create_theme_name = trim( $_POST['create_theme_name'] );
$create_theme_name = _eb_non_mark( $create_theme_name );
$create_theme_name = preg_replace ( '/[^a-zA-Z0-9]+/', '', $create_theme_name );
if ( $create_theme_name == '' ) {
	_eb_alert('create_theme_name not found');
}

$create_theme_top = (int) $_POST['create_theme_top'];
$create_theme_footer = (int) $_POST['create_theme_footer'];
$create_theme_threadnode = (int) $_POST['create_theme_threadnode'];
$create_theme_threaddetails = (int) $_POST['create_theme_threaddetails'];




// Tạo thư mục lưu trữ theme
EBE_create_dir( $dir_for_save_theme );



//exit();



// Tạo trang danh mục sản phẩm -> lấy mẫu mặc định theo theme mặc định
if ( $create_theme_top > 0 ) {
	for ( $i = 1; $i <= $create_theme_top; $i++ ) {
		$file_name = 'cf_top' . $i . '_include_file';
		
		if ( isset( $__cf_row_default[ $file_name ] ) ) {
			WGR_create_themes_default_format(
				$dir_for_save_theme,
				$create_theme_name . '-top' . $i,
				'top'
			);
		}
	}
}



// Tạo trang danh mục sản phẩm -> lấy mẫu mặc định theo theme mặc định
if ( $create_theme_footer > 0 ) {
	for ( $i = 1; $i <= $create_theme_footer; $i++ ) {
		$file_name = 'cf_footer' . $i . '_include_file';
		
		if ( isset( $__cf_row_default[ $file_name ] ) ) {
			WGR_create_themes_default_format(
				$dir_for_save_theme,
				$create_theme_name . '-footer' . $i,
				'footer'
			);
		}
	}
}



// Tạo trang danh mục sản phẩm -> lấy mẫu mặc định theo theme mặc định
if ( $create_theme_threadnode > 0 ) {
	WGR_create_themes_default_format(
		$dir_for_save_theme,
		$create_theme_name . '-threadnode',
		'',
		'html',
		file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/thread_node.html', 1 ),
		file_get_contents( EB_THEME_PLUGIN_INDEX . 'css/default/thread_node.css', 1 )
	);
}



// Tạo trang chi tiết -> lấy mẫu mặc định theo theme mặc định
if ( $create_theme_threaddetails > 0 ) {
	WGR_create_themes_default_format(
		$dir_for_save_theme,
		$create_theme_name . '-threaddetails',
		'',
		'html',
		file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/thread_details.html', 1 ),
		file_get_contents( EB_THEME_PLUGIN_INDEX . 'css/default/thread_details.css', 1 )
	);
}




// Tạo file Bộ giao diện nếu chưa có
function WGR_add_for_arr_all_themes ( $position, $ftype, $limit = 10 ) {
	
	global $__cf_row_default;
	global $create_theme_name;
	
	$str = '';
	$begin_i = 1;
	$end_i = $limit;
	
	
	// thêm widget tương ứng cho footer
	if ( $position == 'footer' ) {
		
		// thêm widget vào đầu
		$str .= '$eb_all_themes_support["' . $create_theme_name . '"]["cf_' . $position . $begin_i . '_include_file"] = "footer_widget.php";' . "\n";
		
		// bắt đầu lặp từ node 2 trở đi
		$begin_i = 2;
		
	}
	
	
	
	//
	for ( $i = $begin_i; $i <= $limit; $i++ ) {
		
		if ( $limit == 1 ) {
			$j = '';
		} else {
			$j = $i;
		}
//		echo $j . '<br>' . "\n";
		
		//
		$check_theme_node = 'cf_' . $position . $j . '_include_file';
//		echo $check_theme_node . '<br>' . "\n";
		
		if ( isset( $__cf_row_default[ $check_theme_node ] ) ) {
			
			$fname = $create_theme_name . '-' . $position . $j . $ftype;
//			echo $fname . '<br>' . "\n";
			
			$fcheck = EB_THEME_PLUGIN_INDEX . 'themes/' . $position . '/' . $fname;
//			echo $fcheck . '<br>' . "\n";
			
			if ( file_exists( $fcheck )
			|| file_exists( EB_THEME_URL . 'theme/ui/' . $fname ) ) {
				$str .= '$eb_all_themes_support["' . $create_theme_name . '"]["' . $check_theme_node . '"] = "' . $fname . '";' . "\n";
				
				$end_i = $j;
			}
			
		}
		else {
			break;
		}
	}
	
	
	// thêm widget tương ứng cho top
	if ( $position == 'top' ) {
		
		// thêm widget vào cuối
		$str .= '$eb_all_themes_support["' . $create_theme_name . '"]["cf_' . $position . $end_i . '_include_file"] = "top_widget.php";' . "\n";
		
	}
	
	
	
	
//	return $str;
	return '//' . "\n" . $str;
	
}

$dir_for_save_all_themes = EB_THEME_PLUGIN_INDEX . 'themes/all/';

$file_bo_giao_dien = $dir_for_save_all_themes . $create_theme_name . '.php';

//
if ( ! file_exists( $file_bo_giao_dien ) ) {
	
	EBE_create_dir( $dir_for_save_all_themes );
	
	$conten_for_bo_giao_dien = '<?php ' . "\n";
	
	$conten_for_bo_giao_dien .= '/*' . "\n";
	$conten_for_bo_giao_dien .= '* Save from ' . date( 'r', date_time ) . "\n";
	$conten_for_bo_giao_dien .= '* By ' . mtv_email . ' #' . mtv_id . "\n";
	$conten_for_bo_giao_dien .= '* From IP: ' . $client_ip . "\n";
	$conten_for_bo_giao_dien .= '* On domain: ' . $_SERVER['HTTP_HOST'] . "\n";
	$conten_for_bo_giao_dien .= '* User agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\n";
	$conten_for_bo_giao_dien .= '*/' . "\n";
	
	//
	$conten_for_bo_giao_dien .= '$eb_all_themes_support["' . $create_theme_name . '"] = array();' . "\n";
	
	// tên giao diện
	$conten_for_bo_giao_dien .= '$eb_all_themes_support["' . $create_theme_name . '"]["name"] = "' . $create_theme_name . '";' . "\n";
	
	// hình ảnh sẽ được đưa lên host của webgiare để quản lý cho dễ
	$conten_for_bo_giao_dien .= '$eb_all_themes_support["' . $create_theme_name . '"]["screenshot"] = "https://img1.webgiare.org/' . $create_theme_name . '.jpg";' . "\n";
	
	//
	$conten_for_bo_giao_dien .= WGR_add_for_arr_all_themes( 'top', '.php' );
	$conten_for_bo_giao_dien .= WGR_add_for_arr_all_themes( 'footer', '.php' );
	$conten_for_bo_giao_dien .= WGR_add_for_arr_all_themes( 'threaddetails', '.html', 1 );
	$conten_for_bo_giao_dien .= WGR_add_for_arr_all_themes( 'threadnode', '.html', 1 );
	
	_eb_create_file( $file_bo_giao_dien, $conten_for_bo_giao_dien );
	
}




//
_eb_log_admin( 'Tạo giao diện mẫu' );



//
//_eb_alert('Tạo giao diện mẫu thành công');



//
die('<script type="text/javascript">
alert("Tạo giao diện mẫu thành công");
parent.window.location = parent.window.location.href;
</script>');




