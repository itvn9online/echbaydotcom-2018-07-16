<?php





//
include EB_THEME_CORE . 'functions.php';





//
//if ( ! class_exists( 'EchBayCommerce' ) ) {
	
	
	
class EchBayCommerce {
	
	
	
	// lấy sản phẩm theo mẫu chung
	public function select_thread_list_all ( $post, $html = __eb_thread_template, $pot_tai = 'category' ) {
		return EBE_select_thread_list_all( $post, $html, $pot_tai );
	}
	
	public function arr_tmp ($row = array(), $str = '') {
		return EBE_arr_tmp( $row, $str );
	}
	
	public function str_template( $f, $arr = array(), $dir = EB_THEME_HTML ) {
		return EBE_str_template( $f, $arr, $dir );
	}
	
	// thay thế các văn bản trong html tìm được
	public function html_template ( $html, $arr = array() ) {
		return EBE_html_template ( $html, $arr );
	}
	
	public function get_page_template ( $page_name = '', $dir = EB_THEME_HTML ) {
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
		return _eb_end ( $arr );
	}
	function _begin ( $arr ) {
		return _eb_begin ( $arr );
	}
	function _first ( $arr ) {
		return _eb_begin ( $arr );
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
		return _eb_add_compiler_css ( $arr );
	}
	
	// add css dưới dạng <link>
	function add_compiler_link_css ( $arr ) {
		return _eb_add_compiler_link_css ( $arr );
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
		return _eb_echbay_sidebar( $slug, $css, $div, $in_cache);
	}
	
	
	public function q ($str) {
		return _eb_q ($str);
	}
	
	public function full_url () {
		return _eb_full_url();
	}
	
	
	// Lưu log error vào file
	public function log_file ($str) {
		_eb_log_file ($str);
	}
	
	
	//
	public function sd($arr, $tbl) {
		_eb_sd($arr, $tbl);
	}
	
	public function set_data($arr, $tbl) {
		return _eb_sd ( $arr, $tbl );
	}
	
	
	
	
	/*
	* Chức năng lấy dữ liệu trong cache
	*/
	// https://www.smashingmagazine.com/2012/06/diy-caching-methods-wordpress/
	public function get_static_html($f, $c = '', $file_type = '', $cache_time = 0) {
		return _eb_get_static_html($f, $c, $file_type, $cache_time);
	}
	
	
	public function check_email_type($e_mail = '') {
		return _eb_check_email_type($e_mail);
	}
	
	
	public function mdnam($str) {
		return _eb_mdnam($str);
	}
	
	// function tạo chuỗi vô định bất kỳ cho riêng mềnh
	public function code64 ($str, $code) {
		return _eb_code64 ($str, $code);
	}
	
	
	
	public function eb_postmeta ( $id, $key, $val ) {
		_eb_eb_postmeta ( $id, $key, $val );
	}
	
	public function set_config($key, $val) {
		_eb_set_config($key, $val);
	}
	public function get_config( $real_time = false ) {
		_eb_get_config( $real_time );
	}
	
	public function log_click($m) {
		return _eb_log_click($m);
	}
	
	public function get_log_click( $limit = '' ) {
		return _eb_get_log_click( $limit );
	}
	
	public function log_user($m) {
		return _eb_log_user($m);
	}
	
	public function get_log_user( $limit = '' ) {
		return _eb_get_log_user( $limit );
	}
	
	public function log_admin($m) {
		return _eb_log_admin($m);
	}
	
	public function get_log_admin( $limit = '' ) {
		return _eb_get_log_admin( $limit );
	}
	
	public function log_admin_order($m, $order_id) {
		return _eb_log_admin_order($m, $order_id);
	}
	
	public function get_log_admin_order( $order_id, $limit = '' ) {
		return _eb_get_log_admin_order( $order_id, $limit );
	}
	
	public function log_search($m) {
		return _eb_log_search($m);
	}
	
	public function get_log_search( $limit = '' ) {
		return get_log_search( $limit );
	}
	
	
	
	
	
	
	
	public function non_mark_seo($str) {
		return _eb_non_mark_seo($str);
    }
	
	public function non_mark($str) {
		return _eb_non_mark($str);
    }
	
	
	
	
	public function build_mail_header($from_email) {
		return _eb_build_mail_header($from_email);
	}
	
	public function lnk_block_email ($em) {
		return _eb_lnk_block_email ($em);
	}
	
	public function send_email($to_email, $title, $message, $headers = '', $bcc_email = '', $add_domain = 1) {
		return _eb_send_email($to_email, $title, $message, $headers, $bcc_email, $add_domain);
	}
	
	public function send_mail_phpmailer($to, $to_name = '', $subject, $message, $from_reply = '', $bcc_email = '') {
		return _eb_send_mail_phpmailer($to, $to_name, $subject, $message, $from_reply, $bcc_email);
	}
	
	
	
	public function ssl_template ($c) {
		return _eb_ssl_template ($c);
	}
	
	
	
	
	
	
	/*
	* https://codex.wordpress.org/Class_Reference/WP_Query
	* https://gist.github.com/thachpham92/d57b18cf02e3550acdb5
	*/
	public function load_ads_v2 ( $type = 0, $posts_per_page = 20, $_eb_query = array(), $op = array() ) {
		return _eb_load_ads_v2 ( $type, $posts_per_page, $_eb_query, $op);
	}
	
	public function load_ads ( $type = 0, $posts_per_page = 20, $data_size = 1, $_eb_query = array(), $offset = 0, $html = '' ) {
		return _eb_load_ads ( $type, $posts_per_page, $data_size, $_eb_query, $offset, $html );
	}
	
	public function load_post_obj ( $posts_per_page, $_eb_query ) {
		return _eb_load_post_obj ( $posts_per_page, $_eb_query );
	}
	
	/*
	* Load danh sách đơn hàng
	*/
	public function load_order ( $posts_per_page = 68, $_eb_query = array() ) {
		return _eb_load_order ( $posts_per_page, $_eb_query );
	}
	
	/*
	* https://codex.wordpress.org/Class_Reference/WP_Query
	* posts_per_page: số lượng bài viết cần lấy
	* _eb_query: gán giá trị để thực thi wordpres query
	* html: mặc định là sử dụng HTML của theme, file thread_node.html, nếu muốn sử dụng HTML riêng thì truyền giá trị HTML mới vào
	* not_set_not_in: mặc định là lọc các sản phẩm trùng lặp trên mỗi trang, nếu để bằng 1, sẽ bỏ qua chế độ lọc -> chấp nhận lấy trùng
	*/
	public function load_post ( $posts_per_page = 20, $_eb_query = array(), $html = __eb_thread_template, $not_set_not_in = 0 ) {
		return _eb_load_post ( $posts_per_page, $_eb_query, $html, $not_set_not_in );
	}
	
	
	
	
	
	
	public function checkPostServerClient() {
		return _eb_checkPostServerClient();
	}
	
	
	
	public function checkDevice () {
		return _eb_checkDevice ();
	}
	
	
	
	public function un_money_format($str) {
		return _eb_number_only( $str );
	}
	
	
	
	// Chuyển ký tự UTF-8 -> ra bảng mã mới
	public function str_block_fix_content ($str) {
		return _eb_str_block_fix_content( $str );
	}
	
	
	
	
	function postUrlContent($url, $data = '', $head = 0) {
		return _eb_postUrlContent($url, $data, $head);
	}
	
	function getUrlContent($url, $agent = '', $options = array(), $head = 0) {
		return _eb_getUrlContent($url, $agent, $options, $head);
	}
	
	
	
	
	// fix URL theo 1 chuẩn nhất định
	public function fix_url( $url ) {
		_eb_fix_url( $url );
	}
	// short link
	public function _s_link ($id, $seo = 'p') {
		return _eb_s_link ($id, $seo);
	}
	// link cho sản phẩm
	public function _p_link ($id, $seo = '') {
		return _eb_p_link ($id);
	}
	// link cho phân nhóm
	public function _c_link ( $id, $taxx = 'category' ) {
		return _eb_c_link ( $id, $taxx );
	}
	// blog
	public function _b_link($id, $seo = '') {
		return _eb_p_link($id);
	}
	// blog group
	public function _bs_link($id, $seo = '') {
		return _eb_c_link( $id );
	}
	
	
	
	public function create_file ($file_, $content_, $add_line = '') {
		return _eb_create_file ($file_, $content_, $add_line);
	}
	
	
	
	
	public function setCucki ( $c_name, $c_value = 0, $c_time = 0, $c_path = '/' ) {
		__eb_set_cookie( $c_name, $c_value, $c_time, $c_path );
	}
	public function getCucki ( $c_name, $default_value = '' ) {
		return _eb_getCucki ( $c_name, $default_value );
	}
	
	
	
	public function alert($m) {
		_eb_alert($m);
	}
	
	
	
	public function number_only($str = '') {
		return _eb_number_only($str);
	}
	
	public function text_only($str = '') {
		return _eb_text_only($str);
	}
	
	
	
	public function remove_ebcache_content($dir = EB_THEME_CACHE, $remove_dir = 0) {
		_eb_remove_ebcache_content($dir, $remove_dir);
	}
	
	
	public function create_account_auto ( $arr = array() ) {
		return _eb_create_account_auto ( $arr );
	}
	
	/*
	* Tự động tạo trang nếu chưa có
	*/
	function create_page( $page_url, $page_name, $page_template = '' ) {
		return _eb_create_page( $page_url, $page_name, $page_template );
	}
	
	
	function create_breadcrumb ( $url, $tit ) {
		return _eb_create_breadcrumb ( $url, $tit );
	}
	function create_html_breadcrumb ($c) {
		return _eb_create_html_breadcrumb ($c);
	}
	
	function echbay_category_menu ( $id, $tax = 'category' ) {
		return _eb_echbay_category_menu ( $id, $tax );
	}
	
	public function get_youtube_id ( $url ) {
		return _eb_get_youtube_id ( $url );
	}
	
	// tiêu đề tiêu chuẩn của google < 70 ký tự
	public function tieu_de_chuan_seo( $str ) {
		return _eb_tieu_de_chuan_seo( $str );
	}
	
	public function short_string( $str, $len, $more = 1 ) {
		return _eb_short_string( $str, $len, $more = 1 );
	}
	
	public function del_line ( $str, $re = "", $pe = "/\r\n|\n\r|\n|\t/i" ) {
		return _eb_del_line ( $str, $re, $pe );
	}
	
	public function lay_email_tu_cache ( $id ) {
		return _eb_lay_email_tu_cache ( $id );
	}
	
	public function categories_list_list_v3 ( $taxx = 'category' ) {
		return _eb_categories_list_list_v3 ( $taxx );
	}
	
	public function categories_list_v3 ( $select_name = 't_ant', $taxx = 'category' ) {
		return _eb_categories_list_v3 ( $select_name, $taxx );
	}
	
	
	public function get_post_img ( $id ) {
		return _eb_get_post_img ( $id );
	}
	
	public function get_post_meta ( $id, $key, $sing = true, $default_value = '' ) {
		return _eb_get_post_meta ( $id, $key, $sing, $default_value);
	}
	
	
	// kiểm tra nếu có file html riêng -> sử dụng html riêng
	function get_html_for_module ( $check_file ) {
		return _eb_get_html_for_module ( $check_file );
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




