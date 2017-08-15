<?php




/*
* Quy tắc tạo file template:

1: Nếu muốn file chỉ chạy trên domain cụ thể, VD:
Domain: xwatch.vn

2. Nếu muốn chỉ chạy trên theme cụ thể -> cho vào thư mục /wp-content/themes/[theme name]theme/ui

3. Tạo tags để tìm kiếm themes dễ hơn, VD:
Tags: slogan, bigbanner, breadcrumb

*/




// reset lại mảng giá trị này từ file config cho nó chuẩn
//$arr_for_set_template = array();




// load danh sách file TOP, FOOTER
$str_list_all_include_file = array();
$str_html_for_list_theme_module = array();

function EBE_config_theme_load_file_tag ( $str, $search ) {
	if ( $str == '' || $search == '' ) {
		return '';
	}
	
	$str = explode( $search . ':', $str );
	
	if ( count( $str ) > 1 ) {
		$str = explode( "\n", $str[1] );
		
		return trim( $str[0] );
	}
	
	return '';
}




//
function WGR_load_list_design_module_for_page ( $module_name ) {
	global $__cf_row_default;
	global $__cf_row;
	
	$str = '';
	for ( $i = 1; $i < 10; $i++ ) {
		$j_name = 'cf_' . $module_name . $i . '_include_file';
//		echo $j_name . '<br>' . "\n";
		
		if ( isset( $__cf_row_default[ $j_name ] ) ) {
			$str .= '<div title="[Bấm đây để chọn thiết kế hoặc để trống]" data-name="' . $j_name . '" data-key="' . $module_name . $i . '" data-val="' . $__cf_row[ $j_name ] . '" class="click-to-change-file-design preview-file-design">&nbsp;</div>';
		} else {
			break;
		}
	}
	return $str;
}



function WGR_config_themes_replace_file_type ( $str, $new_type = '' ) {
	$str = str_replace( '.php', $new_type, $str );
	$str = str_replace( '.html', $new_type, $str );
	$str = str_replace( '.htm', $new_type, $str );
	
	return $str;
}

function WGR_create_html_for_list_theme_module ( $type, $file_type = '.php' ) {
	return '
<div data-key="' . $type . '" class="change-eb-design-hide-fixed change-eb-design-' . $type . '-fixed">
	<div class="change-eb-design-padding">' . EBE_config_load_top_footer_include( $type, $file_type ) . '</div>
</div>';
}


function EBE_config_load_top_footer_include ( $type, $file_type = '.php', $in_theme = 0 ) {
	global $__cf_row_default;
	global $__cf_row;
	global $str_list_all_include_file;
//	global $arr_for_set_template;
	
	// định dạng file được hỗ trợ
	$files_type_support = 'php,html,htm';
	
	// kiểm tra theo domain của template
	$current_domain = str_replace( 'www.', '', $_SERVER['HTTP_HOST'] );
	
	//
	$str_top_design_preview = '';
	
	// lấy trong plugin
	if ( $in_theme == 0 ) {
//		echo EB_THEME_PLUGIN_INDEX . "\n";
		$arr_file_name = glob ( EB_THEME_PLUGIN_INDEX . 'themes/' . $type . '/*.{' . $files_type_support . '}', GLOB_BRACE );
	}
	// lấy trong theme
	else {
//		echo EB_THEME_URL . "\n";
		$arr_file_name = glob ( EB_THEME_URL . 'theme/ui/*.{' . $files_type_support . '}', GLOB_BRACE );
	}
//	print_r( $arr_file_name );
	
	
	// tạo input cho config submit
	$arr_top_include_file = array();
	for ( $i = 1; $i < 10; $i++ ) {
		$j = $type . $i;
		$j_name = 'cf_' . $j . '_include_file';
//		echo $j_name . '<br>' . "\n";
		$j2_name = 'cf_' . $type . '_include_file';
//		echo $j2_name . '<br>' . "\n";
		
		//
		if ( isset( $__cf_row_default[ $j_name ] ) ) {
			/*
			$arr_top_include_file[ $j ] = array(
				'' => 'Chọn file thiết kế cho phần ' . $j,
				$type . '_widget.php' => 'Đặt làm ' . $type . ' widget'
			);
			*/
			
			$arr_top_include_file[ $j ] = array();
			
			$str_list_all_include_file[] = '<input type="text" name="' . $j_name . '" id="' . $j_name . '" value="' . $__cf_row[ $j_name ] . '" data-type="' . $j . '" class="each-to-get-current-value-file" />';
		}
		else {
			if ( isset( $__cf_row_default[ $j2_name ] ) ) {
				/*
				$arr_top_include_file[ $type ] = array(
					'' => 'Chọn file thiết kế cho phần ' . $type
				);
				*/
				
				$arr_top_include_file[ $type ] = array();
				
				$str_list_all_include_file[] = '<input type="text" name="' . $j2_name . '" id="' . $j2_name . '" value="' . $__cf_row[ $j2_name ] . '" data-type="' . $type . '" class="each-to-get-current-value-file" />';
			}
			
			break;
		}
	}
	$str_list_all_include_file[] = '<br>';
//	print_r( $str_list_all_include_file );
//	$arr_for_set_template['str_list_all_include_file'] = implode( "\n", $str_list_all_include_file );
//	print_r( $arr_top_include_file );
	
	foreach ( $arr_file_name as $v ) {
		$file_name = basename( $v );
		$node = explode( '-', $file_name );
//		print_r( $node );
//		$node = $node[0];
		if ( count( $node ) == 1 ) {
			$node = str_replace( '_', '', $type );
		} else {
//			$node = WGR_config_themes_replace_file_type( $node[1] );
			$node = explode( '.', $node[1] );
			$node = $node[0];
		}
//		echo $node . "\n";
		
		//
	//	if ( ! empty( $arr_top_include_file[ $node ] ) ) {
	//		$arr_top_include_file[ $node ] = array();
	//	} else {
	//		echo $v . "\n";
			$arr_top_include_file[ $node ][$v] = 1;
	//	}
	}
//	print_r( $arr_top_include_file );
	
	
	
	//
	$str_for_return = '';
	// Tạo nút riêng nếu là theme dùng chung
	if ( $in_theme == 0 ) {
		$str_for_return = '
<div class="change-eb-design-note d-none"><em>* Các file sẽ xuất hiện lần lượt theo vị trí đã chọn!</em></div>
<div class="button-for-ebdesign-hover">
	<button type="button" data-type="' . $type . '" class="click-remove-file-include-form-input cur">[ Xóa file ]</button>
	<button type="button" data-type="' . $type . '" class="click-add-widget-include-to-input cur">[ ' . $type . ' widget ]</button>
	<button type="button" class="cur click-to-exit-design d-none2 show-if-ebdesign-hover">Đóng [x]</button>
</div>';
	}
	
	
	
	$i = 0;
	foreach ( $arr_top_include_file as $k => $v ) {
//		print_r($v);
		
		$str_for_return .= '<br><h3>' . $k . '</h3>';
		
		$label_name = 'cf_' . $k . '_include_file';
		
		foreach ( $v as $k2 => $v2 ) {
			
			$label_id = $label_name . $i;
			$file_tag = '';
			$for_domain = '';
			$theme_description = '';
			$theme_tags = '';
			$search_tags = '';
			$warning_file_format = '';
			
			if ( $k2 == '' ) {
//				$str_for_return .= '<hr>';
				$val = '';
				$text = '[' . $v2 . ']';
			} else {
				// lấy thông tin file để tạo tag
				$file_tag = file_get_contents( $k2, 1 );
				
				// Tìm theo domain, nếu file được set cho domain cụ thể -> kiểm tra domain có trùng không
				$for_domain = EBE_config_theme_load_file_tag( $file_tag, 'Domain' );
				if ( $for_domain != '' ) {
					$for_domain = strtolower( str_replace( 'www.', '', $for_domain ) );
				}
//				echo $for_domain . '<br>' . "\n";
				
				//
				$theme_description = EBE_config_theme_load_file_tag( $file_tag, 'Description' );
				if ( $theme_description != '' ) {
					$theme_description = '<div><strong>Mô tả:</strong> ' . $theme_description . '</div>';
				}
				
				//
				$theme_tags = EBE_config_theme_load_file_tag( $file_tag, 'Tags' );
				if ( $theme_tags != '' ) {
					$search_tags = $theme_tags;
					$theme_tags = '<div class="themes-design-tags"><strong>Thẻ:</strong> ' . $theme_tags . '</div>';
				}
				
				$k2 = basename($k2);
				$val = $k2;
				$file_name_only = WGR_config_themes_replace_file_type( $k2 );
				$text = 'Mẫu #' . $file_name_only;
				
				
				// check file format
				if ( $type == 'top' || $type == 'footer' ) {
					// kiểm tra định dạng file đã theo chuẩn chưa
					if ( strstr( $file_tag, 'cf_' . $type . '_class_style' ) == false ) {
						$warning_file_format .= '<div class="redcolor"> * Định dạng file thiếu thuộc tính căn chỉnh chiều rộng: <strong>$__cf_row[\'cf_' . $type . '_class_style\']</strong></div>';
					}
					
					// tên file chưa có ID -> cảnh báo luôn
					if ( strstr( $file_tag, ' id="' . $file_name_only . '"' ) == false ) {
						$warning_file_format .= '<div class="redcolor"> * Định dạng file thiếu attribute để phân định lớp CSS: <strong>id="' . $file_name_only . '"</strong></div>';
					}
				}
			}
			
			
			//
			if ( $for_domain == ''
			// theo tên miền chính
			|| $current_domain == $for_domain
			// theo sub-domain -> tạo thêm dấu . ở đầu chuỗi
			|| strstr( $current_domain, '.' . $for_domain ) == true ) {
				
				//
				$ck = '';
				if ( $val == $__cf_row[ $label_name ] ) {
					$ck = ' checked="checked"';
				}
				
				
				// kiểm tra và lấy hình nền nếu có
				$bg = '';
				$css_class = '';
				$img = '';
				$chua_co_hinh_anh = '';
				if ( $val != '' ) {
					$bg_file = EB_THEME_PLUGIN_INDEX . 'themes/images/' . WGR_config_themes_replace_file_type( $val, '.jpg' );
					if ( file_exists( $bg_file ) ) {
						$file_info = getimagesize( $bg_file );
						
						$img = str_replace( EB_THEME_PLUGIN_INDEX, EB_URL_OF_PLUGIN, $bg_file );
						
						$css_class = 'preview-bg-ebdesign';
						if ( $ck != '' ) {
							$css_class .= ' selected';
							
	//						$str_top_design_preview .= '<div title="Click to change design" data-key="' . $k . '" data-size="' . $file_info[1] . '/' . $file_info[0] . '" class="click-to-change-file-design preview-file-design" style="background-image:url(\'' . $img . '\');">&nbsp;</div>';
	//						echo $bg_file;
						}
						
						$bg = ' data-size="' . $file_info[1] . '/' . $file_info[0] . '" style="height: ' . $file_info[1] . 'px;background-image:url(\'' . $img . '\');"';
					}
					else {
						// cảnh bảo bổ sung thêm ảnh
						$chua_co_hinh_anh = '<div class="redcolor">* Thiếu ảnh minh họa, để nghị bổ sung thêm</div>';
					}
				}
				
				/*
				// v1
				$str_for_return .= '
				<div data-img="' . $img . '" data-key="' . $k . '" data-val="' . $val . '" title="' . $text . '" class="click-add-class-selected preview-in-ebdesign ' . $css_class . '" ' . $bg . '>
					<input type="radio" name="' . $label_name . '" id="' .$label_id. '" value="' .$val. '" ' . $ck . '>
					<label for="' .$label_id. '">' .$text. '</label>
				</div>';
				*/
				
				// v2
				$str_for_return .= '
<div data-key="' . $val . '" data-tags="' . $search_tags . '" class="for-themes-quick-search">
	<div data-img="' . $img . '" data-key="' . $k . '" data-val="' . $val . '" data-type="' . $label_name . '" title="' . $text . '" class="click-add-class-selected preview-in-ebdesign ' . $css_class . '" ' . $bg . '>' .$text. '</div>
	<div class="small hide-if-threadnode">
		<div><strong>' . $text . '</strong></div>
		' . $theme_description . '
		' . $theme_tags . '
		' . $chua_co_hinh_anh . '
		' . $warning_file_format . '
	</div>
</div>';
				
			}
			
			//
			$i++;
		}
	}
//	echo $str_for_return;
	
	/*
	return array(
		'list' => $str_for_return,
		'preview' => $str_top_design_preview
	);
	*/
	
	return $str_for_return;
	
}

//
/*
$arr_design_preview = EBE_config_load_top_footer_include();
$arr_for_set_template['str_top_include_file'] = $arr_design_preview['list'];
$arr_for_set_template['str_top_design_preview'] = $arr_design_preview['preview'];
*/



/*
* các file theo theme
*/

$arr_for_set_template['str_private_include_file'] = EBE_config_load_top_footer_include( 'private', '.php', 1 );




/*
* các file dùng chung
*/


//$arr_for_set_template['str_top_include_file'] = EBE_config_load_top_footer_include('top');
$str_html_for_list_theme_module[] = WGR_create_html_for_list_theme_module('top');
$arr_for_set_template['str_top_design_preview'] = WGR_load_list_design_module_for_page('top');


//
/*
$arr_design_preview = EBE_config_load_top_footer_include('footer');
$arr_for_set_template['str_footer_include_file'] = $arr_design_preview['list'];
$arr_for_set_template['str_footer_design_preview'] = $arr_design_preview['preview'];
*/

//$arr_for_set_template['str_footer_include_file'] = EBE_config_load_top_footer_include('footer');
$str_html_for_list_theme_module[] = WGR_create_html_for_list_theme_module('footer');
$arr_for_set_template['str_footer_design_preview'] = WGR_load_list_design_module_for_page('footer');




//
//$arr_for_set_template['str_home_include_file'] = EBE_config_load_top_footer_include('home');
$str_html_for_list_theme_module[] = WGR_create_html_for_list_theme_module('home');
$arr_for_set_template['str_home_design_preview'] = WGR_load_list_design_module_for_page('home');




//
$arr_for_set_template['str_main_include_file'] = EBE_config_load_top_footer_include('main');

$str_main_design_preview = '<div title="[Bấm đây để chọn thiết kế hoặc để trống]" data-name="cf_main_include_file" data-key="main" data-val="' . $__cf_row[ 'cf_main_include_file' ] . '" class="click-to-change-file-design preview-file-design">&nbsp;</div>';

$arr_for_set_template['str_main_design_preview'] = $str_main_design_preview;




//
//$arr_for_set_template['str_cats_include_file'] = EBE_config_load_top_footer_include('cats');
$str_html_for_list_theme_module[] = WGR_create_html_for_list_theme_module('cats');
$arr_for_set_template['str_cats_design_preview'] = WGR_load_list_design_module_for_page('cats');




//
$arr_for_set_template['str_threadnode_include_file'] = EBE_config_load_top_footer_include('threadnode', '.html');

$str_threadnode_design_preview = '<div title="[Bấm đây để chọn thiết kế hoặc để trống]" data-name="cf_threadnode_include_file" data-key="threadnode" data-val="' . $__cf_row[ 'cf_threadnode_include_file' ] . '" class="click-to-change-file-design preview-file-design">&nbsp;</div>';

$arr_for_set_template['str_threadnode_design_preview'] = $str_threadnode_design_preview;

$arr_for_set_template['cf_threadnode_title_tag'] = __eb_create_select_checked_config(
	array(
		'div' => 'DIV',
		'p' => 'P',
		'li' => 'LI',
		'h2' => 'H2',
		'h3' => 'H3',
		'h4' => 'H4',
		'h5' => 'H5',
		'h6' => 'H6'
	),
	$__cf_row['cf_threadnode_title_tag'],
	'cf_threadnode_title_tag'
);





// khung tìm kiếm sản phẩm
/*
$str_threadsreachnode_design_preview = '<div title="[Bấm đây để chọn thiết kế hoặc để trống]" data-name="cf_threadsearchnode_include_file" data-key="threadsearchnode" data-val="' . $__cf_row[ 'cf_threadsearchnode_include_file' ] . '" class="click-to-change-file-design preview-file-design">&nbsp;</div>';

$arr_for_set_template['str_threadsreachnode_design_preview'] = $str_threadsreachnode_design_preview;
*/




//
$arr_for_set_template['str_threaddetails_include_file'] = EBE_config_load_top_footer_include('threaddetails', '.html');

$str_threaddetails_design_preview = '<div title="[Bấm đây để chọn thiết kế hoặc để trống]" data-name="cf_threaddetails_include_file" data-key="threaddetails" data-val="' . $__cf_row[ 'cf_threaddetails_include_file' ] . '" class="click-to-change-file-design preview-file-design">&nbsp;</div>';

$arr_for_set_template['str_threaddetails_design_preview'] = $str_threaddetails_design_preview;




//
global $str_list_all_include_file;

// thêm input cho khung tìm kiếm -> vì nãy không lấy qua function
$str_list_all_include_file[] = '<input type="text" name="cf_threadsearchnode_include_file" id="cf_threadsearchnode_include_file" value="' . $__cf_row[ 'cf_threadsearchnode_include_file' ] . '" data-type="threadsearchnode" class="each-to-get-current-value-file" />';


//print_r( $str_list_all_include_file );
$arr_for_set_template['str_list_all_include_file'] = implode( "\n", $str_list_all_include_file );





// Hiển thị đường dẫn tạo theme
$arr_for_set_template['dir_for_save_new_theme'] = EB_THEME_URL . 'theme/ui/';




// list toàn bộ các themes đã đươc liệt kê
$arr_list_all_themes = glob ( EB_THEME_PLUGIN_INDEX . 'themes/all/*.{php}', GLOB_BRACE );
//print_r($arr_list_all_themes);
foreach ( $arr_list_all_themes as $v ) {
	include $v;
}

//print_r($eb_all_themes_support);
$str_all_themes_support = '';
foreach ( $eb_all_themes_support as $k => $v ) {
	$theme_name = $k;
	$theme_avt = $v['screenshot'];
	
	$str_all_themes_support .= '
<li data-key="' . $theme_name . '">
	<div style="background-image:url(\'' . $theme_avt . '\');">
		<p>&nbsp;</p>
		<h3>' . $theme_name . '</h3>
		<button type="button" data-theme="' . $theme_name . '" class="blue-button cur click-active-eb-themes">Kích hoạt</button>
	</div>
</li>';
}
$arr_for_set_template['str_all_themes_support'] = $str_all_themes_support;






//
$arr_for_set_template['str_html_for_list_theme_module'] = implode( "\n", $str_html_for_list_theme_module );





//
//print_r( $arr_for_set_template );

//
//$main_content = EBE_arr_tmp( $arr_for_set_template, $main_content );




