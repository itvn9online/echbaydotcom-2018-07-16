<?php


//
if ( ! isset( $_GET['id'] ) ) {
	die('Product ID not found!');
}

//
$quick_view_id = (int) $_GET['id'];

// đặt lại act để còn load các script tương ứng của trang chi tiết
$act = 'single';



//
$sql = _eb_load_post_obj( 1, array(
	'p' => $quick_view_id
) );
//print_r( $sql );
//$GLOBALS['wp_query'] = $sql;
//print_r( $GLOBALS );

//
/*
$post = _eb_q("SELECT *
	FROM
		`" . wp_posts . "`
	WHERE
		ID = " . $quick_view_id);
//print_r( $post );
$post = $post[0];
$posts = $post;
*/

//
while ( $sql->have_posts() ) {
	$sql->the_post();
	
	//
//	print_r( $post );
	$post = $sql->post;
//	print_r( $post );
	
	//
//	print_r( $posts );
	$posts = $sql->posts;
//	print_r( $posts );
	
	// reset lại mảng css -> chỉ nạp cho trang chi tiết thôi
	$view_type = '';
	if ( isset($_GET['view_type']) ) {
		$view_type = $_GET['view_type'];
	}
	
	// nếu không phải xem qua quick view -> reset lại đống css cho đỡ phải load lại
	if ( $view_type != 'iframe' ) {
		$arr_for_add_css = array();
	}
	
	//
	include EB_THEME_PLUGIN_INDEX . 'global/details.php';
	include EB_THEME_PLUGIN_INDEX . 'common_content.php';
	
	// d.css
	$arr_for_add_css[ WGR_check_add_add_css_themes_or_plugin ( 'd' ) ] = 1;
	
	// nạp css trực tiếp nếu xem qua ajax
//	print_r( $arr_for_add_css );
	if ( $view_type != 'iframe' ) {
		_eb_add_compiler_css( $arr_for_add_css );
	}
	// nạp như bình thường nếu xem qua iframe
	else {
		// không index
		$__cf_row ["cf_blog_public"] = 0;
		
		//
		$global_dymanic_meta .= '<link rel="canonical" href="' . get_permalink( $quick_view_id ) . '" />
<link rel="shortlink" href="' . web_link . '?p=' . $quick_view_id . '" />';
		
		//
//		include EB_THEME_PLUGIN_INDEX . 'common.php';
		include EB_THEME_PLUGIN_INDEX . 'header.php';
	}
	
	
	//
	echo '<div class="css-for-quickview">';
	
	echo $main_content;
	
	echo '</div>';
?>
<script type="text/javascript">
// thêm tham số để khẳng định đây là trang quick view -> muốn xử lý code ở đây nó cũng tiện hơn
var quick_view_page = 1;
</script>
<?
	//
	if ( $view_type == 'iframe' ) {
?>
<style>
.height-for-mobile,
.menu-for-mobile,
.not-using-navcart { display: none !important; }
</style>
<script type="text/javascript">
// ép chuyển về trang chính nếu không phải xem trogn iframe
if ( top == self ) {
	setTimeout(function () {
//		window.location = web_link + '?p=' + pid;
		window.location = '<?php echo _eb_p_link( $quick_view_id ); ?>';
	}, 2000);
}
</script>
<?php
		// không cần include footer
		$arr_includes_footer_file = array();
		
		//
		include EB_THEME_PLUGIN_INDEX . 'quick_cart.php';
		
		//
//		include EB_THEME_PLUGIN_INDEX . 'footer.php';
		include EB_THEME_PLUGIN_INDEX . 'footer_css.php';
	} // end if
	
} // end while






