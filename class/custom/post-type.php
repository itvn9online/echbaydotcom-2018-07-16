<?php




/*
Chỉ số thứ tự của các menu hệ thống:
2 Dashboard
4 Separator
5 Posts
10 Media
15 Links
20 Pages
25 Comments
59 Separator
60 Appearance
65 Plugins
70 Users
75 Tools
80 Settings
99 Separator
*/






// Thêm kiểu bài viết mới cho sản phẩm
function echbay_create_custom_post_type ( $custom_post_name, $custom_post_module, $arr_supports = array(), $menu_position = 99, $arr_return = array() ) {
	
	// gán giá trị mặc định cho arr_supports
	if ( count( $arr_supports ) == 0 ) {
		$arr_supports = array(
			'title',
		);
	}
//	echo count( $arr_supports );
//	print_r( $arr_supports );
	
	// Biến $label để chứa các text liên quan đến tên hiển thị của Post Type trong Admin
	$label = array(
		'name' => $custom_post_name,
		'singular_name' => $custom_post_name,
		'add_new' => 'Thêm ' . $custom_post_name,
		'add_new_item' => 'Thêm ' . $custom_post_name . ' mới',
		'all_items' => 'Tất cả ' . $custom_post_name,
		'edit_item' => 'Sửa ' . $custom_post_name,
		'featured_image' => 'Ảnh đại diện ' . $custom_post_name,
		'filter_item_list' => 'Lọc danh sách ' . $custom_post_name,
		'item_list' => 'Danh sách ' . $custom_post_name,
		'set_featured_image' => 'Thiết lập ảnh đại diện'
	);
	
	
	// trả về mảng dữ liệu cần tạo
	$arr = array(
		//Gọi các label trong biến $label ở trên
		'labels' => $label,
		//Mô tả của post type
        'title' => 'Nhập tên ' . $custom_post_name,
		'description' => 'Post type đăng ' . $custom_post_name,
		//Các tính năng được hỗ trợ trong post type
		'supports' => $arr_supports,
		//Các taxonomy được phép sử dụng để phân loại nội dung
//		'taxonomies' => array(
//			'category',
//			'post_tag',
//		),
		//Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'hierarchical' => false,
		//Kích hoạt post type
        'public' => true,
		//Hiển thị khung quản trị như Post/ Page
        'show_ui' => true,
		//Hiển thị trên Admin Menu (tay trái)
        'show_in_menu' => true,
		//Hiển thị trong Appearance -> Menus
        'show_in_nav_menus' => true,
		//Hiển thị trên thanh Admin bar màu đen.
        'show_in_admin_bar' => true,
		//Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_position' => $menu_position,
		//Đường dẫn tới icon sẽ hiển thị
//		'menu_icon' => EB_URL_OF_THEME . '/images/product.png',
		//Có thể export nội dung bằng Tools -> Export
		'can_export' => true,
		//Cho phép lưu trữ (month, date, year)
//		'has_archive' => false,
		'has_archive' => true,
		//Loại bỏ khỏi kết quả tìm kiếm
		'exclude_from_search' => false,
		//Hiển thị các tham số trong query, phải đặt true
		'publicly_queryable' => true,
		//
		'capability_type' => 'post',
    );
	
	// thay đổi các tham số mặc định bằng tham số mới nếu có
	foreach ( $arr_return as $k => $v ) {
//		if ( isset( $arr[$k] ) ) {
			$arr[$k] = $v;
//		}
	}
	
	//
    return $arr;
}

//
function ech_bay_custom_post_type() {
	/*
	* Biến $args là những tham số quan trọng trong Post Type
	*/
	
	
	/*
	* Banner quảng cáo
	*/
	$custom_post_module = 'ads';
	
	//
	$args = echbay_create_custom_post_type( 'Quảng cáo', $custom_post_module, array(
		'title',
		'editor',
//		'author',
		'thumbnail',
		'excerpt',
//		'trackbacks',
//		'custom-fields',
//		'comments',
//		'revisions',
		'page-attributes',
//		'post-formats',
//	), 70 );
	), 7, array(
//		'public' => false,
		// không lưu trữ
		'has_archive' => false,
		// Loại bỏ khỏi kết quả tìm kiếm
		'exclude_from_search' => true,
//		'publicly_queryable' => false,
		'show_in_nav_menus' => false,
		// không cần rewwrite URL cho mục này
		'rewrite' => false,
	) );
	
	// điều chỉnh các tham số riêng trước khi gửi đi
	// với phần q.cáo, add cả các mục khác để q.cáo có thể xuất hiện ở nhiều nơi
	$args['taxonomies'] = array(
		'category',
		'post_options',
		EB_BLOG_POST_LINK,
	);
 
	// Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
	register_post_type($custom_post_module, $args);
	
	
	
	
	
	
	/*
	* Blog/ Tin tức
	*/
	$custom_post_module = EB_BLOG_POST_TYPE;
	
	//
	$args = echbay_create_custom_post_type( 'Blog/ Tin tức', $custom_post_module, array(
		'title',
		'editor',
//		'author',
		'thumbnail',
		'excerpt',
//		'trackbacks',
//		'custom-fields',
//		'comments',
		'revisions',
		'page-attributes',
		'post-formats',
//	), 71 );
	), 8 );
 
	// Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
	register_post_type($custom_post_module, $args);
	
	
	
	
	
	
	/*
	* Đơn hàng
	*/
	/*
	$custom_post_module = 'shop_order';
	
	//
	$args = echbay_create_custom_post_type( 'Đơn hàng', $custom_post_module, array(
		'title',
//		'editor',
//		'author',
//		'thumbnail',
//		'excerpt',
//		'trackbacks',
//		'custom-fields',
//		'comments',
//		'revisions',
//		'page-attributes',
//		'post-formats',
	), 999, array(
		// không cho sửa trực tiếp trên admin wp
        'show_ui' => false,
		// không hiển thị trên menu
        'show_in_menu' => false,
        'show_in_nav_menus' => false,
        'show_in_admin_bar' => false,
		// không lưu trữ
		'has_archive' => false,
		// Loại bỏ khỏi kết quả tìm kiếm
		'exclude_from_search' => true,
	) );
 
	// Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
	register_post_type($custom_post_module, $args);
	*/
	
	
	
	
	
	/*
	* kích hoạt chức năng sắp xếp bài viết cho post
	*/
	add_post_type_support( 'post', 'page-attributes' );
	
	// chức năng tóm tắt cho page -> dùng cho html riêng
	add_post_type_support( 'page', 'excerpt' );
	
	
	
}
// Kích hoạt hàm tạo custom post type
add_filter('init', 'ech_bay_custom_post_type');




