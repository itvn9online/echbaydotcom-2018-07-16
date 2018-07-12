<?php




//
//if ( ! class_exists( 'EchBayCommerce' ) ) {
	
	
	
class EchBayCommerce {
	
	
	
	// lấy sản phẩm theo mẫu chung
	function select_thread_list_all ( $post, $html = __eb_thread_template, $pot_tai = 'category' ) {
		return EBE_select_thread_list_all ( $post, $html, $pot_tai );
	}
	
	function arr_tmp ($row = array(), $str = '') {
		return EBE_arr_tmp ($row, $str);
	}
	
	function str_template( $f, $arr = array(), $dir = EB_THEME_HTML ) {
		return EBE_str_template( $f, $arr, $dir );
	}
	
	// thay thế các văn bản trong html tìm được
	function html_template ( $html, $arr = array() ) {
		return EBE_html_template ( $html, $arr );
	}
	
	function get_page_template ( $page_name = '', $dir = EB_THEME_HTML ) {
		return EBE_get_page_template ( $page_name, $dir );
	}
	
	
	
	/*
	* Chức năng tạo head riêng của Echbay
	* Các file tĩnh như css, js sẽ được cho vào vòng lặp để chạy 1 phát cho tiện
	*/
	function add_css ( $arr = array(), $include_now = 0 ) {
		_eb_add_css_js_file( $arr, '.css', $include_now );
	}
	
	function add_full_css ( $arr = array(), $type_add = 'import' ) {
		_eb_add_full_css ( $arr, $type_add );
	}
	
	function add_js ( $arr = array(), $include_now = 0 ) {
		_eb_add_css_js_file( $arr, '.js', $include_now );
	}
	
	function add_full_js ( $arr = array(), $type_add = 'import' ) {
		_eb_add_full_js ( $arr, $type_add );
	}
	
	// một số host không dùng được hàm end
	function _end ( $arr ) {
		return _eb_end ( $arr );
	}
	function _last ( $arr ) {
		return _eb_last ( $arr );
	}
	function _begin ( $arr ) {
		return _eb_begin ( $arr );
	}
	function _first ( $arr ) {
		return _eb_first ( $arr );
	}
	
	function add_css_js_file ( $arr, $file_type = '.css', $include_now = 0, $include_url = EB_URL_OF_THEME ) {
		return _eb_add_css_js_file ( $arr, $file_type, $include_now, $include_url );
	}
	
	function import_js ( $js ) {
		return _eb_import_js ( $js );
	}
	
	//
	function replace_css_space ( $str, $new_array = array() ) {
		return _eb_replace_css_space ( $str, $new_array );
	}
	
	// add css thẳng vào HTML
	function add_compiler_css ( $arr ) {
		_eb_add_compiler_css ( $arr );
	}
	
	// add css dưới dạng <link>
	function add_compiler_link_css ( $arr ) {
		_eb_add_compiler_link_css ( $arr );
	}
	
	
	// Thiết lập hàm hiển thị logo
	function echbay_logo() {
		_eb_echbay_logo();
	}
	
	
	/*
	* Thiết lập hàm hiển thị menu
	* https://developer.wordpress.org/reference/functions/wp_nav_menu/
	* tag_menu_name: nếu muốn lấy cả tên menu thì gán thêm hàm này vào
	* tag_close_menu_name: thẻ đóng html của tên menu
	*/
	function echbay_menu( $slug, $menu = array(), $in_cache = 1, $tag_menu_name = '', $tag_close_menu_name = '</div>' ) {
		return _eb_echbay_menu( $slug, $menu, $in_cache, $tag_menu_name, $tag_close_menu_name );
	}
	
	
	/*
	* https://codex.wordpress.org/Function_Reference/dynamic_sidebar
	*/
	function echbay_sidebar( $slug, $css = '', $div = 'div', $in_cache = 1) {
		return _eb_echbay_sidebar( $slug, $css, $div, $in_cache );
	}
	
	
	function q ($str) {
		return _eb_q ($str);
	}
	
	function full_url () {
		return _eb_full_url ();
	}
	
	
	// Lưu log error vào file
	function log_file ($str) {
		_eb_log_file ($str);
	}
	
	
	//
	function sd($arr, $tbl) {
		_eb_sd($arr, $tbl);
	}
	function set_data($arr, $tbl) {
		_eb_sd($arr, $tbl);
	}
	
	
	
	
	/*
	* Chức năng lấy dữ liệu trong cache
	*/
	// https://www.smashingmagazine.com/2012/06/diy-caching-methods-wordpress/
	function get_static_html($f, $c = '', $file_type = '', $cache_time = 0) {
		return _eb_get_static_html( $f, $c, $file_type, $cache_time );
	}
	
	
	function check_email_type($e_mail = '') {
		return _eb_check_email_type($e_mail);
	}
	
	
	function mdnam($str) {
		return _eb_mdnam($str);
	}
	
	// function tạo chuỗi vô định bất kỳ cho riêng mềnh
	function code64 ($str, $code) {
		return _eb_code64 ($str, $code);
	}
	
	
	
	function eb_postmeta ( $id, $key, $val ) {
		_eb_postmeta ( $id, $key, $val );
	}
	
	function set_config($key, $val) {
		_eb_set_config($key, $val);
	}
	function get_config( $real_time = false ) {
		_eb_get_config( $real_time );
	}
	
	function log_click($m) {
		_eb_log_click($m);
	}
	function get_log_click( $limit = '' ) {
		return _eb_get_log_click( $limit );
	}
	
	function log_user($m) {
		_eb_log_user($m);
	}
	function get_log_user( $limit = '' ) {
		return _eb_get_log_user( $limit );
	}
	
	function log_admin($m) {
		_eb_log_admin($m);
	}
	function get_log_admin( $limit = '' ) {
		return _eb_get_log_admin( $limit );
	}
	
	function log_admin_order($m, $order_id) {
		return _eb_log_admin_order($m, $order_id);
	}
	function get_log_admin_order( $order_id, $limit = '' ) {
		return _eb_get_log_admin_order( $order_id, $limit );
	}
	
	function log_search($m) {
		_eb_log_search($m);
	}
	function get_log_search( $limit = '' ) {
		return _eb_get_log_search( $limit );
	}
	
	
	
	
	
	
	
	function non_mark_seo($str) {
		return _eb_non_mark_seo($str);
    }
	function non_mark($str) {
		return _eb_non_mark($str);
    }
	
	
	
	
	function build_mail_header($from_email) {
		return _eb_build_mail_header($from_email);
	}
	
	function lnk_block_email ($em) {
		return _eb_lnk_block_email ($em);
	}
	
	function send_email($to_email, $title, $message, $headers = '', $bcc_email = '', $add_domain = 1) {
		return _eb_send_email( $to_email, $title, $message, $headers, $bcc_email, $add_domain );
	}
	
	function send_mail_phpmailer($to, $to_name = '', $subject, $message, $from_reply = '', $bcc_email = '') {
		return _eb_send_mail_phpmailer($to, $to_name, $subject, $message, $from_reply, $bcc_email);
	}
	
	
	
	function ssl_template ($c) {
		return _eb_ssl_template ($c);
	}
	
	
	
	
	
	
	/*
	* https://codex.wordpress.org/Class_Reference/WP_Query
	* https://gist.github.com/thachpham92/d57b18cf02e3550acdb5
	*/
	function load_ads_v2 ( $type = 0, $posts_per_page = 20, $_eb_query = array(), $op = array() ) {
		return _eb_load_ads_v2 ( $type, $posts_per_page, $_eb_query, $op );
	}
	
	function load_ads ( $type = 0, $posts_per_page = 20, $data_size = 1, $_eb_query = array(), $offset = 0, $html = '' ) {
		return _eb_load_ads ( $type, $posts_per_page, $data_size, $_eb_query, $offset, $html );
	}
	
	function load_post_obj ( $posts_per_page, $_eb_query ) {
		
		//
		$arr['post_type'] = 'post';
		$arr['posts_per_page'] = $posts_per_page;
		$arr['orderby'] = 'menu_order';
		$arr['order'] = 'DESC';
		$arr['post_status'] = 'publish';
		
		//
		foreach ( $_eb_query as $k => $v ) {
			$arr[$k] = $v;
		}
//		print_r( $_eb_query );
//		print_r( $arr );
		
		// https://codex.wordpress.org/Class_Reference/WP_Query
		return new WP_Query( $arr );
		
	}
	
	/*
	* Load danh sách đơn hàng
	*/
	function load_order ( $posts_per_page = 68, $_eb_query = array() ) {
		global $wpdb;
		
		//
		$strFilter = "";
		if ( isset( $_eb_query['p'] ) && $_eb_query['p'] > 0 ) {
			$strFilter .= " AND ID = " . $_eb_query['p'];
		}
		
		//
		$sql = $this->q( "SELECT *
		FROM
			" . wp_posts . "
		WHERE
			post_type = 'shop_order'
			AND post_status = 'private'
			" . $strFilter . "
		ORDER BY
			ID DESC
		LIMIT 0, " . $posts_per_page );
		
		return $sql;
		
		
		//
		/*
		$_eb_query['post_type'] = 'shop_order';
		$_eb_query['post_status'] = 'private';
		$_eb_query['orderby'] = 'ID';
		$_eb_query['order'] = 'DESC';
		
		return $this->load_post_obj( $posts_per_page, $_eb_query );
		*/
	}
	
	/*
	* https://codex.wordpress.org/Class_Reference/WP_Query
	* posts_per_page: số lượng bài viết cần lấy
	* _eb_query: gán giá trị để thực thi wordpres query
	* html: mặc định là sử dụng HTML của theme, file thread_node.html, nếu muốn sử dụng HTML riêng thì truyền giá trị HTML mới vào
	* not_set_not_in: mặc định là lọc các sản phẩm trùng lặp trên mỗi trang, nếu để bằng 1, sẽ bỏ qua chế độ lọc -> chấp nhận lấy trùng
	*/
	function load_post ( $posts_per_page = 20, $_eb_query = array(), $html = __eb_thread_template, $not_set_not_in = 0 ) {
		global $___eb_post__not_in;
//		echo 'POST NOT IN: ' . $___eb_post__not_in . '<br>' . "\n";
		
		// lọc các sản phẩm trùng nhau
		if ( $___eb_post__not_in != '' && $not_set_not_in == 0 ) {
			$_eb_query['post__not_in'] = explode( ',', substr( $___eb_post__not_in, 1 ) );
		}
		
		//
		$sql = $this->load_post_obj( $posts_per_page, $_eb_query );
		
		//
//		if ( $_eb_query['post_type'] == 'blog' ) {
//			print_r( $sql );
//			print_r( $_eb_query );
//			exit();
//		}
		
		//
		$str = '';
		
		//
		while ( $sql->have_posts() ) {
			
			$sql->the_post();
//			the_content();
			
			//
			if ( $not_set_not_in == 0 ) {
				$___eb_post__not_in .= ',' . $sql->post->ID;
			}
			
			//
			$str .= $this->select_thread_list_all( $sql->post, $html );
			
		}
		
		//
		wp_reset_postdata();
		
		return $str;
	}
	
	
	
	
	
	
	function checkPostServerClient() {
		if ($_SERVER ['REQUEST_METHOD'] != 'POST') {
			die ( '<h1>POST DIE</h1>' );
			exit ();
		}
		
		
		$checkPostServer = $_SERVER ['HTTP_HOST'];
		$checkPostServer = str_replace ( 'www.', '', $checkPostServer );
//		$checkPostServer = explode ( '/', $checkPostServer );
//		$checkPostServer = $checkPostServer [0];
		
		$checkPostClient = isset ( $_SERVER ['HTTP_REFERER'] ) ? $_SERVER ['HTTP_REFERER'] : '';
		$checkPostClient = explode( '//', $checkPostClient );
		$checkPostClient = $checkPostClient[1];
		$checkPostClient = str_replace ( 'www.', '', $checkPostClient );
		$checkPostClient = explode ( '/', $checkPostClient );
		$checkPostClient = $checkPostClient [0];
		
		//
		if ( strtolower ( $checkPostServer ) != strtolower ( $checkPostClient ) ) {
			die ( '<h1>REFERER DIE</h1>' );
			exit ();
		}
		
		
		
		/*
		* xử lý an toàn cho chuỗi
		*/
		
		// kiểm tra get_magic_quotes_gpc đang bật hay tắt
		// Magic_quotes_gpc là 1 giá trị tùy chọn bật chế độ tự động thêm ký tự escape vào trước các ký tự đặc biệt như: nháy đơn ('), nháy kép ("), dấu backslash (\) khi nó đc POST hoặc GET từ client lên
		$magic_quotes = 0;
		if ( get_magic_quotes_gpc () ) {
			$magic_quotes = 1;
		}
		
		//
		foreach ( $_POST as $k => $v ) {
			if ( gettype( $v ) == 'string' ) {
				// nếu Magic_quotes_gpc đang tắt -> loại bỏ ký tự đặc biệt
//				if ( $magic_quotes == 1 ) {
//					$v = stripslashes ( $v );
//				}
				
				// nếu Magic_quotes_gpc đang tắt -> add dữ liệu an toàn thủ công vào
				if ( $magic_quotes == 0 ) {
					// xử lý an toàn cho chuỗi
					$v = addslashes ( $v );
					
					// mysqli_real_escape_string tương tự như addslashes, nhưng công việc sẽ do mysql xử lý
//					$str = mysqli_real_escape_string ( $str );
				}
				
				$_POST [$k] = $v;
			}
		}
		
		
		//
		return $_POST;
	}
	
	
	
	function checkDevice () {
		if ( isset($_SERVER['HTTP_USER_AGENT']) ) {
			// lấy thông tin hệ điều hành của người dùng
			$_ebArrUAAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
			// mảng các thiết bị mobile chuyên dụng
			$_ebArrMobi = array('midp', 'j2me', 'avantg', 'ipad', 'iphone', 'docomo', 'novarra', 'palmos', 'palmsource', '240x320', 'opwv', 'chtml', 'pda', 'windows ce', 'mmp/', 'mib/', 'symbian', 'wireless', 'nokia', 'hand', 'mobi', 'phone', 'cdm', 'up.b', 'audio', 'sie-', 'sec-', 'samsung', 'htc', 'mot-', 'mitsu', 'sagem', 'sony', 'alcatel', 'lg', 'erics', 'vx', 'nec', 'philips', 'mmm', 'xx', 'panasonic', 'sharp', 'wap', 'sch', 'rover', 'pocket', 'benq', 'java', 'pt', 'pg', 'vox', 'amoi', 'bird', 'compal', 'kg', 'voda', 'sany', 'kdd', 'dbt', 'sendo', 'sgh', 'gradi', 'jb', 'dddi', 'moto', 'opera mobi', 'opera mini', 'android');
			foreach ($_ebArrMobi as $k => $v) {
				// nếu không xác định được chuỗi
				if (strpos($_ebArrUAAgent, $v) === false) {
					// ~> bỏ qua ko làm gì cả
				}
				// nếu tìm được -> trả về thông tin rằng đây là thiết bị mobile
				else {
					return 'mobile';
					break;
				}
			}
		}
		// mặc định cho rằng đây là PC
		return 'pc';
	}
	
	
	
	function un_money_format($str) {
		return $this->number_only( $str );
	}
	
	
	
	// Chuyển ký tự UTF-8 -> ra bảng mã mới
	function str_block_fix_content ($str) {
	//	$str = iconv('UTF-16', 'UTF-8', $str);
	//	$str = mb_convert_encoding($str, 'UTF-8', 'UTF-16');
	//	$str = mysqli_escape_string($str);
	//	$str = htmlentities($str, ENT_COMPAT, 'UTF-16');
		// https://www.google.com/search?q=site:charbase.com+%E1%BB%9D#q=site:charbase.com+%E1%BA%A3
		$arr = array(
			'á' => '\u00e1',
			'à' => '\u00e0',
			'ả' => '\u1ea3',
			'ã' => '\u00e3',
			'ạ' => '\u1ea1',
			'ă' => '\u0103',
			'ắ' => '\u1eaf',
			'ặ' => '\u1eb7',
			'ằ' => '\u1eb1',
			'ẳ' => '\u1eb3',
			'ẵ' => '\u1eb5',
			'â' => '\u00e2',
			'ấ' => '\u1ea5',
			'ầ' => '\u1ea7',
			'ẩ' => '\u1ea9',
			'ẫ' => '\u1eab',
			'ậ' => '\u1ead',
			'Á' => '\u00c1',
			'À' => '\u00c0',
			'Ả' => '\u1ea2',
			'Ã' => '\u00c3',
			'Ạ' => '\u1ea0',
			'Ă' => '\u0102',
			'Ắ' => '\u1eae',
			'Ặ' => '\u1eb6',
			'Ằ' => '\u1eb0',
			'Ẳ' => '\u1eb2',
			'Ẵ' => '\u1eb4',
			'Â' => '\u00c2',
			'Ấ' => '\u1ea4',
			'Ầ' => '\u1ea6',
			'Ẩ' => '\u1ea8',
			'Ẫ' => '\u1eaa',
			'Ậ' => '\u1eac',
			'đ' => '\u0111',
			'Đ' => '\u0110',
			'é' => '\u00e9',
			'è' => '\u00e8',
			'ẻ' => '\u1ebb',
			'ẽ' => '\u1ebd',
			'ẹ' => '\u1eb9',
			'ê' => '\u00ea',
			'ế' => '\u1ebf',
			'ề' => '\u1ec1',
			'ể' => '\u1ec3',
			'ễ' => '\u1ec5',
			'ệ' => '\u1ec7',
			'É' => '\u00c9',
			'È' => '\u00c8',
			'Ẻ' => '\u1eba',
			'Ẽ' => '\u1ebc',
			'Ẹ' => '\u1eb8',
			'Ê' => '\u00ca',
			'Ế' => '\u1ebe',
			'Ề' => '\u1ec0',
			'Ể' => '\u1ec2',
			'Ễ' => '\u1ec4',
			'Ệ' => '\u1ec6',
			'í' => '\u00ed',
			'ì' => '\u00ec',
			'ỉ' => '\u1ec9',
			'ĩ' => '\u0129',
			'ị' => '\u1ecb',
			'Í' => '\u00cd',
			'Ì' => '\u00cc',
			'Ỉ' => '\u1ec8',
			'Ĩ' => '\u0128',
			'Ị' => '\u1eca',
			'ó' => '\u00f3',
			'ò' => '\u00f2',
			'ỏ' => '\u1ecf',
			'õ' => '\u00f5',
			'ọ' => '\u1ecd',
			'ô' => '\u00f4',
			'ố' => '\u1ed1',
			'ồ' => '\u1ed3',
			'ổ' => '\u1ed5',
			'ỗ' => '\u1ed7',
			'ộ' => '\u1ed9',
			'ơ' => '\u01a1',
			'ớ' => '\u1edb',
			'ờ' => '\u1edd',
			'ở' => '\u1edf',
			'ỡ' => '\u1ee1',
			'ợ' => '\u1ee3',
			'Ó' => '\u00d3',
			'Ò' => '\u00d2',
			'Ỏ' => '\u1ece',
			'Õ' => '\u00d5',
			'Ọ' => '\u1ecc',
			'Ô' => '\u00d4',
			'Ố' => '\u1ed0',
			'Ồ' => '\u1ed2',
			'Ổ' => '\u1ed4',
			'Ỗ' => '\u1ed6',
			'Ộ' => '\u1ed8',
			'Ơ' => '\u01a0',
			'Ớ' => '\u1eda',
			'Ờ' => '\u1edc',
			'Ở' => '\u1ede',
			'Ỡ' => '\u1ee0',
			'Ợ' => '\u1ee2',
			'ú' => '\u00fa',
			'ù' => '\u00f9',
			'ủ' => '\u1ee7',
			'ũ' => '\u0169',
			'ụ' => '\u1ee5',
			'ư' => '\u01b0',
			'ứ' => '\u1ee9',
			'ừ' => '\u1eeb',
			'ử' => '\u1eed',
			'ữ' => '\u1eef',
			'ự' => '\u1ef1',
			'Ú' => '\u00da',
			'Ù' => '\u00d9',
			'Ủ' => '\u1ee6',
			'Ũ' => '\u0168',
			'Ụ' => '\u1ee4',
			'Ư' => '\u01af',
			'Ứ' => '\u1ee8',
			'Ừ' => '\u1eea',
			'Ử' => '\u1eec',
			'Ữ' => '\u1eee',
			'Ự' => '\u1ef0',
			'ý' => '\u00fd',
			'ỳ' => '\u1ef3',
			'ỷ' => '\u1ef7',
			'ỹ' => '\u1ef9',
			'ỵ' => '\u1ef5',
			'Ý' => '\u00dd',
			'Ỳ' => '\u1ef2',
			'Ỷ' => '\u1ef6',
			'Ỹ' => '\u1ef8',
			'Ỵ' => '\u1ef4',
			// Loại bỏ dòng trắng
//			';if (' => ';if(',
//			'{if (' => '{if(',
//			'}if (' => '}if(',
//			'} else if (' => '}else if(',
//			'} else {' => '}else{',
//			'}else {' => '}else{',
//			';for (' => ';for(',
//			'}for (' => '}for(',
//			'function (' => 'function(',
//			//
//			' != ' => '!=',
//			' == ' => '==',
//			' || ' => '||',
//			' -= ' => '-=',
//			' += ' => '+=',
//			' && ' => '&&',
//			//
//			') {' => '){',
//			';}' => '}',
//			' = \'' => '=\'',
//			'\' +' => '\'+',
//			'+ \'' => '+\'',
//			' = ' => '=',
//			'}, {' => '},{',
//			'}, ' => '},',
			'\'' => '\\\'',
			'' => ''
		);
		foreach ($arr as $k => $v) {
			if ($v != '') {
				$str = str_replace($k, $v, $str);
			}
		}
	//	$str = str_replace('\\', '/', str_replace("'", "\'", $str) );
		return $str;
	}
	
	
	
	
	function postUrlContent($url, $data = '', $head = 0) {
		global $post_get_cc;
		
		return $post_get_cc->post ( $url, $data, $head );
	}
	function getUrlContent($url, $agent = '', $options = array(), $head = 0) {
		global $post_get_cc;
		
		return $post_get_cc->get ( $url, $agent, $options, $head );
	}
	
	
	
	
	// fix URL theo 1 chuẩn nhất định
	function fix_url( $url ) {
		return _eb_fix_url( $url );
	}
	// short link
	function _s_link ($id, $seo = 'p') {
		return _eb_s_link ( $id );
	}
	// link cho sản phẩm
	function _p_link ($id, $seo = '') {
		return _eb_p_link ($id);
	}
	// link cho phân nhóm
	function _c_link ( $id, $taxx = 'category' ) {
		return _eb_c_link ( $id, $taxx );
	}
	// blog
	function _b_link($id, $seo = '') {
		return _eb_p_link ($id);
	}
	// blog group
	function _bs_link($id, $seo = '') {
		return _eb_c_link( $id );
	}
	
	
	
	function create_file ($file_, $content_, $add_line = '') {
		
		//
		if ( ! file_exists( $file_ ) ) {
			$filew = fopen( $file_, 'x+' );
			// nhớ set 777 cho file
			chmod($file_, 0777);
			fclose($filew);
		}
		
		//
		if ( $add_line != '' ) {
			file_put_contents( $file_, $content_, FILE_APPEND ) or die('ERROR: add to file');
//			chmod($file_, 0777);
		}
		//
		else {
//			file_put_contents( $file_, $content_, LOCK_EX ) or die('ERROR: write to file');
			file_put_contents( $file_, $content_ ) or die('ERROR: write to file');
//			chmod($file_, 0777);
		}
		
		
		
		/*
		* add_line: thêm dòng mới
		*/
	//	$content_ = str_replace('\"', '"', $content_);
	//	$content_ = str_replace("\'", "'", $content_);
		
		/*
		// nếu tồn tại file rồi -> sửa
		if (file_exists($file_)) {
//			if( flock( $file_, LOCK_EX ) ) {
				// open
		//		$fh = fopen($file_, 'r+') or die('ERROR: open 1');
		//		$str_data = fread($fh, filesize($file_));
				if ($add_line != '') {
					$fh = fopen($file_, 'a+') or die('ERROR: add to file');
				} else {
					$fh = fopen($file_, 'w+') or die('ERROR: write to file');
				}
//			}
		}
		// chưa tồn tại file -> tạo
		else {
			// open
			$fh = fopen($file_, 'x+') or die('ERROR: create file');
			chmod($file_, 0777);
		}
		
		// write
		fwrite($fh, $content_) or die('ERROR: write');
		// close
		fclose($fh) or die('ERROR: close');
		*/
	}
	
	
	
	
	function setCucki ( $c_name, $c_value = 0, $c_time = 0, $c_path = '/' ) {
	}
	
	function getCucki ( $c_name, $default_value = '' ) {
		return _eb_getCucki( $c_name, $default_value );
	}
	
	
	
	function alert($m) {
		die ( '<script type="text/javascript">alert("' . $m . '");</script>' );
	}
	
	
	
	function number_only($str = '') {
		if ($str == '') {
			return 0;
		}
		return preg_replace ( '/[^0-9]+/', '', $str );
	}
	function text_only($str = '') {
		if ($str == '') {
			return '';
		}
		return preg_replace ( '/[^a-zA-Z0-9\-\.]+/', '', $str );
	}
	
	
	
	function remove_ebcache_content($dir = EB_THEME_CACHE, $remove_dir = 0) {
		_eb_remove_ebcache_content( $dir, $remove_dir );
	}
	
	
	function create_account_auto ( $arr = array() ) {
		return _eb_create_account_auto( $arr );
	}
	
	/*
	* Tự động tạo trang nếu chưa có
	*/
	function create_page( $page_url, $page_name, $page_template = '' ) {
		_eb_create_page( $page_url, $page_name, $page_template );
	}
	
	
	function create_breadcrumb ( $url, $tit ) {
		global $breadcrumb_position;
		
		//
//		echo $breadcrumb_position . "\n";
		
		$breadcrumb_position++;
		
		//
		return '
		, {
			"@type": "ListItem",
			"position": ' . $breadcrumb_position . ',
			"item": {
				"@id": "' . str_replace( '/', '\/', $url ) . '",
				"name": "' . str_replace( '"', '&quot;', $tit ) . '"
			}
		}';
	}
	function create_html_breadcrumb ($c) {
		return _eb_create_html_breadcrumb( $c );
	}
	
	function echbay_category_menu ( $id, $tax = 'category' ) {
		$str = '';
		
		$strCacheFilter = 'eb_cat_menu' . $id;
//		echo $strCacheFilter;
		
		$str = $this->get_static_html ( $strCacheFilter );
		
		if ($str == false) {
			
			// parent
			$parent_cat = get_term_by( 'id', $id, $tax );
	//		print_r( $parent_cat );
			
			// sub
			$sub_cat = get_categories( array(
	//			'hide_empty' => 0,
				'parent' => $parent_cat->term_id
	//			'child_of' => $parent_cat->term_id
			) );
	//		print_r( $sub_cat );
			
			foreach ( $sub_cat as $k => $v ) {
				$str .= '<li><a href="' . $this->_c_link( $v->term_id ) . '">' . $v->name . '</a></li>';
			}
			
			if ( $str != '' ) {
				$str = '<ul class="sub-menu">' . $str . '</ul>';
			}
			
			// tổng hợp
			$str = '<ul><li><a href="' . $this->_c_link( $parent_cat->term_id ) . '">' . $parent_cat->name . '</a>' . $str . '</li></ul>';
			
			//
			$this->get_static_html ( $strCacheFilter, $str );
			
		}
		
		//
		return $str;
	}
	
	function get_youtube_id ( $url ) {
		if ( $url == '' ) {
			return '';
		}
		
		parse_str( parse_url( $url, PHP_URL_QUERY ), $a );
		
		if ( isset( $a['v'] ) ) {
			return $a['v'];  
		} else {
			$a = explode( '/embed/', $url );
			if ( isset( $a[1] ) ) {
				$a = explode( '?', $a[1] );
				$a = explode( '&', $a[0] );
				
				return $a[0];
			}
		}
		
		return '';
	}
	
	// tiêu đề tiêu chuẩn của google < 70 ký tự
	function tieu_de_chuan_seo( $str ) {
		global $__cf_row;
		
		if ( strlen( $str ) < 35 && $__cf_row ['cf_abstract'] != '' ) {
			$str .= ' - ' . $__cf_row ['cf_abstract'];
			
			//
			if ( strlen( $str ) > 70 ) {
				$str = $this->short_string( $str, 70 );
			}
		}
		
		//
		return $str;
	}
	
	function short_string( $str, $len, $more = 1 ) {
		$str = trim ( $str );
		
		if ($len > 0 && strlen ( $str ) > $len) {
			$str = substr ( $str, 0, $len );
			if (! substr_count ( $str, " " )) {
				if ($more == 1) {
					$str .= "...";
				}
				return $str;
			}
			while ( strlen ( $str ) && ($str [strlen ( $str ) - 1] != " ") ) {
				$str = substr ( $str, 0, - 1 );
			}
			$str = substr ( $str, 0, - 1 );
			if ($more == 1) {
				$str .= "...";
			}
		}
		
		return $str;
	}
	
	function del_line ( $str, $re = "", $pe = "/\r\n|\n\r|\n|\t/i" ) {
		return preg_replace( $pe, $re, trim( $str ) );
	}
	
	function lay_email_tu_cache ( $id ) {
		if ( $id <= 0 ) {
			return 'NULL';
		}
		$strCacheFilter = 'tv_mail/' . $id;
		
		$tv_email = $this->get_static_html ( $strCacheFilter, '', '', 24 * 3600 );
		
		if ($tv_email == false) {
			$user = get_user_by( 'id', $id );
//			print_r($user);
			
			//
			if ( ! empty( $user ) ) {
				$tv_email = $user->user_email;
			} else {
				$tv_email = $id;
			}
			
			//
			$this->get_static_html ( $strCacheFilter, $tv_email, '', 60 );
		}
		
		return $tv_email;
	}
	
	function categories_list_list_v3 ( $taxx = 'category' ) {
		$arr = get_categories( array(
			'taxonomy' => $taxx,
			'hide_empty' => 0,
		) );
//		print_r($arr);
		
		//
//		echo count( $arr ) . "\n";
		
		//
		$str = '';
		
		foreach ( $arr as $v ) {
			$str .= '<option data-parent="' . $v->category_parent . '" value="' . $v->term_id . '">' . $v->name . '</option>';
		}
		
		return $str;
	}
	
	function categories_list_v3 ( $select_name = 't_ant', $taxx = 'category' ) {
		$str = '<option value="0">[ Lựa chọn phân nhóm ]</option>';
		
		$str .= $this->categories_list_list_v3( $taxx );
		
		$str .= '<option data-show="1" data-href="' . admin_link . 'edit-tags.php?taxonomy=category">[+] Thêm phân nhóm mới</option>';
		
		return '<select name="' . $select_name . '">' . $str . '</select>';
	}
	
	
	function get_post_img ( $id ) {
		return _eb_get_post_img( $id );
	}
	
	function get_post_meta ( $id, $key, $sing = true, $default_value = '' ) {
		return _eb_get_post_meta( $id, $key, $sing, $default_value );
	}
	
	
	// kiểm tra nếu có file html riêng -> sử dụng html riêng
	function get_html_for_module ( $check_file ) {
		// kiểm tra ở thư mục code riêng
		if ( file_exists( EB_THEME_HTML . $check_file ) ) {
			$f = EB_THEME_HTML . $check_file;
		}
		// nếu không -> kiểm tra ở thư mục dùng chung
		else if ( file_exists( EB_THEME_PLUGIN_INDEX . 'html/' . $check_file ) ) {
			$f = EB_THEME_PLUGIN_INDEX . 'html/' . $check_file;
		}
		
		return file_get_contents( $f, 1 );
	}
	
	function get_private_html ( $f, $f2 = '' ) {
		return _eb_get_private_html ( $f, $f2 );
	}
	
	
	
	//
	function get_full_category_v2($this_id = 0, $taxx = 'category') {
		return _eb_get_full_category_v2($this_id, $taxx);
	}
	
}



//}


$func = new EchBayCommerce ();




