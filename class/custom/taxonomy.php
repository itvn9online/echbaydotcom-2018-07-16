<?php
/*
* custom-taxonomy là cách để xây dựng danh mục, tag riêng cho từng loại bài viết, mặc định sẽ dùng chung với post
*/





// xóa link cache của category sau khi update
function WGR_custom_term_slug_edit_success ( $taxonomy = 'category' ) {
	add_filter( 'edited_' . $taxonomy, 'WGR_custom_term_slug_edit_success2', 10, 2 );
}

function WGR_custom_term_slug_edit_success2 ( $term_id, $taxonomy ) {
	// xóa cache
	_eb_remove_static_html( 'cat_link' . $term_id );
	// sau đó nạp lại url
	_eb_c_link( $term_id, $taxonomy );
}


/*
* Tạo taxonomy cho product
*/
function dang_ky_taxonomy() {
	/*
	* Biến $label chứa các tham số thiết lập tên hiển thị của Taxonomy
	* Biến $args khai báo các tham số trong custom taxonomy cần tạo
	*/
	
	
	
	//
	WGR_custom_term_slug_edit_success();
	
	
	
	/*
	* Blog/ Tin tức
	*/
	$taxonomy_post_type = EB_BLOG_POST_TYPE;
	
	// cat
	$labels = array(
		'name' => 'Danh mục tin',
		'singular_name' => 'Danh mục tin',
		'search_items' => 'Tìm danh mục tin',
		'all_items' => 'Tất cả',
		'parent_item' => 'Danh mục cha',
		'parent_item_colon' => 'Danh mục cha:',
		'edit_item' => 'Sửa danh mục',
		'update_item' => 'Cập nhật danh mục',
		'add_new_item' => 'Thêm danh mục mới',
		'new_item_name' => 'New Danh mục Name',
		'menu_name' => 'Danh mục tin',
	);
	
	$args = array(
		'labels' => $labels,
		// cho phép phân cấp
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
	);
	
	// Hàm register_taxonomy để khởi tạo taxonomy
	register_taxonomy(EB_BLOG_POST_LINK, $taxonomy_post_type, $args);
	WGR_custom_term_slug_edit_success( EB_BLOG_POST_LINK );
	
	
	
	// tag
	$labels = array(
		'name' => 'Danh sách từ khóa',
//		'singular' => 'Từ khóa',
		'singular_name' => 'Từ khóa',
		'search_items' => 'Tìm từ khóa',
		'all_items' => 'Tất cả',
		'parent_item' => 'Từ khóa cha',
		'parent_item_colon' => 'Từ khóa cha:',
		'edit_item' => 'Sửa từ khóa',
		'update_item' => 'Cập nhật từ khóa',
		'add_new_item' => 'Thêm từ khóa sản phẩm',
		'new_item_name' => 'New từ khóa Name',
		'menu_name' => 'Các từ khóa',
	);
	
	//
	$args = array(
		'labels' => $labels,
		// với tag thì không phân cấp
		'hierarchical' => false,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => true,
	);
	
	register_taxonomy($taxonomy_post_type . '_tag', $taxonomy_post_type, $args);
	WGR_custom_term_slug_edit_success( $taxonomy_post_type . '_tag' );
	
	
	
	
	
	
	/*
	* Sản phẩm/ Bài viết
	*/
	$taxonomy_post_type = 'post';
	
	// cat
	$labels = array(
		'name' => 'Thông số khác',
		'singular_name' => 'Thông số khác',
		'search_items' => 'Tìm Thông số',
		'all_items' => 'Tất cả',
		'parent_item' => 'Thông số cha',
		'parent_item_colon' => 'Thông số cha:',
		'edit_item' => 'Sửa Thông số',
		'update_item' => 'Cập nhật Thông số',
		'add_new_item' => 'Thêm Thông số mới',
		'new_item_name' => 'New Thông số Name',
		'menu_name' => 'Thông số khác',
	);
	
	//
	$args = array(
		'labels' => $labels,
		// cho phép phân cấp
		'hierarchical' => true,
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => false,
		'show_tagcloud' => true,
	);
	
	register_taxonomy($taxonomy_post_type . '_options', $taxonomy_post_type, $args);
	WGR_custom_term_slug_edit_success( $taxonomy_post_type . '_options' );
}
// Hook into the 'init' action
add_filter( 'init', 'dang_ky_taxonomy');





