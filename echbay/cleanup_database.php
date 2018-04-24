<?php



global $wpdb;

//
$url_for_home_clean_up = admin_link . 'admin.php?page=eb-coder&tab=cleanup_database';




// tính tổng các post_type đang có
$sql = _eb_q("SELECT post_type
	FROM
		`" . wp_posts . "`
	GROUP BY
		post_type");
//print_r( $sql );
$str_post_type = '';
foreach ( $sql as $v ) {
	
	//
	$strsql = _eb_q("SELECT count(ID) as c
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = '" . $v->post_type . "'");
//	print_r( $strsql );
	
	//
	$str_post_type .= '<li>' . $v->post_type . ' (' . $strsql[0]->c . ')</li>';
}



function WGR_clean_post_meta_by_eb ( $key, $val = '', $tbl = wp_postmeta ) {
	/*
	$sql = _eb_q( "SELECT *
	FROM
		`" . $tbl . "`
	WHERE
		meta_key LIKE '%{$key}%'
		AND meta_value = '" . $val . "'
	LIMIT 0, 100" );
	print_r( $sql );
		*/
	
	_eb_q( "DELETE FROM
		`" . $tbl . "`
	WHERE
		meta_key LIKE '%{$key}%'
		AND meta_value = '" . $val . "'", 0 );
}




//
$str_count_meta_key = '';

// hiển thị các post_meta chi tiết theo key
if ( isset( $_GET['filter_post_meta'] ) ) {
	$s_meta_key = trim( $_GET['filter_post_meta'] );
	
	//
	$url_for_meta_clean_up = $url_for_home_clean_up . '&filter_post_meta=' . $s_meta_key;
	
	//
	$str_count_meta_key .= '<li><h3><a href="' . $url_for_meta_clean_up . '">Lọc theo post_meta = ' . $s_meta_key . '</a></h3></li>';
	
	// xóa các post_meta sinh ra bởi echbay
	if ( $s_meta_key == 'echbay_post_meta' ) {
		
		//
		WGR_clean_post_meta_by_eb( '_eb_product_' );
		WGR_clean_post_meta_by_eb( '_eb_blog_' );
		WGR_clean_post_meta_by_eb( '_eb_ads_' );
		WGR_clean_post_meta_by_eb( '_eb_category_' );
		
		WGR_clean_post_meta_by_eb( '_eb_product_', 0 );
		WGR_clean_post_meta_by_eb( '_eb_blog_', 0 );
		WGR_clean_post_meta_by_eb( '_eb_ads_', 0 );
		WGR_clean_post_meta_by_eb( '_eb_category_', 0 );
		
		//
		WGR_clean_post_meta_by_eb( '_eb_product_', '', wp_termmeta );
		WGR_clean_post_meta_by_eb( '_eb_blog_', '', wp_termmeta );
		WGR_clean_post_meta_by_eb( '_eb_ads_', '', wp_termmeta );
		WGR_clean_post_meta_by_eb( '_eb_category_', '', wp_termmeta );
		
		WGR_clean_post_meta_by_eb( '_eb_product_', 0, wp_termmeta );
		WGR_clean_post_meta_by_eb( '_eb_blog_', 0, wp_termmeta );
		WGR_clean_post_meta_by_eb( '_eb_ads_', 0, wp_termmeta );
		WGR_clean_post_meta_by_eb( '_eb_category_', 0, wp_termmeta );
	}
	// xóa các post_meta theo lựa chọn của người dùng
	else if ( $s_meta_key != '' ) {
		$str_count_meta_key .= '<li><h4><a href="' . $url_for_meta_clean_up . '&remove_meta=null">Xóa các meta_value trống</a> | <a href="' . $url_for_meta_clean_up . '&remove_meta=zero">Xóa các meta_value bằng không</a></li>';
		
		//
		$remove_meta = isset( $_GET['remove_meta'] ) ? $_GET['remove_meta'] : '';
		
		//
		$sql = _eb_q("SELECT *
		FROM
			`" . wp_postmeta . "`
		WHERE
			meta_key = '" . $s_meta_key . "'
		ORDER BY
			meta_id DESC
		LIMIT 0, 5000");
		foreach ( $sql as $v ) {
			$str_remove_meta = '';
			// xóa meta trống
			if ( $remove_meta == 'null' && $v->meta_value == '' ) {
				_eb_q( "DELETE FROM
					`" . wp_postmeta . "`
				WHERE
					meta_id = " . $v->meta_id . "
					AND meta_value = ''", 0 );
				
				$str_remove_meta = ' <span class="redcolor">Remove</span>';
			}
			// xóa meta bằng 0
			else if ( $remove_meta == 'zero' && $v->meta_value == '0' ) {
				_eb_q( "DELETE FROM
					`" . wp_postmeta . "`
				WHERE
					meta_id = " . $v->meta_id . "
					AND meta_value = '0'", 0 );
				
				$str_remove_meta = ' <span class="redcolor">Remove</span>';
			}
			
			//
			$str_count_meta_key .= '<li>#' . $v->meta_id . '; post_id = ' . $v->post_id . '; meta_value = ' . $v->meta_value . ';' . $str_remove_meta . '</li>';
		}
	}
}
// hiển thị tất cả các post_meta đang có
else {
	$sql = _eb_q("SELECT meta_key
	FROM
		`" . wp_postmeta . "`
	GROUP BY
		meta_key
	ORDER BY
		meta_key");
	//print_r( $sql );
	foreach ( $sql as $v ) {
		
		// tính tổng các post_meta đang có
		$strsql = _eb_q("SELECT meta_id
		FROM
			`" . wp_postmeta . "`
		WHERE
			meta_key = '" . $v->meta_key . "'");
		
		//
		$str_count_meta_key .= '<li>' . $v->meta_key . ' (' . count( $strsql ) . ') -&gt; <a href="' . $url_for_home_clean_up . '&filter_post_meta=' . $v->meta_key . '">Xem chi tiết &raquo;</a></li>';
	}
}






// xóa các post_type thuộc dạng nháp
$count_post_type_del = array();
$url_for_run_clean_up = $url_for_home_clean_up;
$text_for_run_clean_up = 'Tắt tiến trình dọn database';

// nếu đang là xóa database
if ( isset( $_GET['del_data'] ) ) {
	
	/*
	* Xóa các post thuộc dạng revision
	* Sử dụng lệnh mysql thuần xóa cho nhanh
	* Thường thì revision không có postmeta, term_relationships -> nhưng cứ đặt lệnh xóa cho nó xôm
	*/
	WGR_remove_post_by_type();
	
	
	// chạy lại bằng lệnh cung cấp bởi wp -> đề phòng lệnh trên có lỗi
	$sql = _eb_q("SELECT ID, post_title, post_name
	FROM
		`" . wp_posts . "`
	WHERE
		post_type = 'revision'
	ORDER BY
		ID
	LIMIT 0, 500");
	//print_r( $sql );
	$count_post_type_del['revision'] = count( $sql );
	
	//
	echo '<h2>- Xóa các bản nháp tự động sinh ra bởi wordpress:</h2>';
	foreach ( $sql as $v ) {
		echo 'Delete: #' . $v->ID . ' -&gt; ' . $v->post_title . ' (' . $v->post_name . ')<br>' . "\n";
		wp_delete_post( $v->ID, true );
	}
	
	
	
	
	// Xóa các log sinh ra bởi EchBay
	echo '<h2>- Xóa các log sinh ra bởi EchBay:</h2>';
	_eb_q( "DELETE FROM
		`" . wp_postmeta . "`
	WHERE
		meta_key = '__eb_log_user'
		OR meta_key = '__eb_log_admin'", 0 );
	
	//
	echo '<br><br>';
}
// nếu không -> thêm tham số xóa
else {
	$url_for_run_clean_up .= '&del_data=1';
	$text_for_run_clean_up = 'Bắt đầu dọn dẹp database';
}





// OPTIMIZE TABLE `wp_commentmeta`, `wp_comments`, `wp_links`, `wp_options`, `wp_pmxe_exports`, `wp_pmxe_google_cats`, `wp_pmxe_posts`, `wp_pmxe_templates`, `wp_postmeta`, `wp_posts`, `wp_termmeta`, `wp_terms`, `wp_term_relationships`, `wp_term_taxonomy`, `wp_usermeta`, `wp_users`, `wp_WP_SEO_404_links`, `wp_WP_SEO_Cache`, `wp_WP_SEO_Redirection`, `wp_WP_SEO_Redirection_LOG`

//
$str_all_table_in_site = '';
$str_for_optimize_table = '';
$sql = _eb_q("SHOW TABLES");
//print_r($sql);

foreach ( $sql as $v ) {
//	print_r($v);
	
	//
	foreach ( $v as $v2 ) {
//		echo $v2 . '<br>' . "\n";
		
		$str_all_table_in_site .= '<li>' . $v2 . '</li>';
		
		$str_for_optimize_table .= ', `' . $v2 . '`';
	}
}
//echo $str_for_optimize_table;

if ( isset( $_GET['optimize_table'] ) ) {
	// bỏ dấu , đầu tiên
	$str_for_optimize_table = substr( $str_for_optimize_table, 1 );
	$str_for_optimize_table = trim( $str_for_optimize_table );
	
	if ( $str_for_optimize_table != '' ) {
		$str_for_optimize_table = 'OPTIMIZE TABLE ' . $str_for_optimize_table;
		
		//
		$wpdb->query( $str_for_optimize_table );
		
		//
		echo $str_for_optimize_table . '<br><br>' . "\n";
	}
}






?>
<div class="l20">
	<h2><a href="<?php echo $url_for_run_clean_up; ?>"><i class="fa fa-magic"></i> <?php echo $text_for_run_clean_up; ?></a></h2>
	<div>+ Xóa các post_type = <strong>revision</strong>.</div>
	<div>+ Log sinh ra bởi EchBay.</div>
	<br>
	<h2><a href="<?php echo $url_for_home_clean_up; ?>&optimize_table=true" onClick="return confirm('Thao tác này không nên sử dụng quá nhiều');"><i class="fa fa-magic"></i> Tối ưu hóa các bảng trong database này (OPTIMIZE TABLE)</a></h2>
	<div>* Tính năng cần hạn chế sử dụng, nên sử dụng khoảng mỗi tháng một lần.</div>
	<br>
	<h2><a href="<?php echo $url_for_home_clean_up; ?>&filter_post_meta=echbay_post_meta"><i class="fa fa-magic"></i> Dọn dẹp các post_meta sinh ra bởi EchBay</a></h2>
	<div>+ Các meta_key bắt đầu bằng <strong>_eb_</strong> hoặc <strong>__eb_</strong>.</div>
</div>
<br>
<hr>
<br>
<h3>Các post_type đang có trên website:</h3>
<ol>
	<?php echo $str_post_type; ?>
</ol>
<br>
<h3>Các post_type đã được đặt lệnh xóa:</h3>
<ol id="refresh_if_del_data">
	<?php
	foreach ( $count_post_type_del as $k => $v ) {
		if ( $v > 0 ) {
			echo '<li>Xóa <strong>' . $v . '</strong> post_type = <strong>' . $k . '</strong></li>';
		}
	}
	?>
</ol>
<br>
<br>
<h3>Các post_meta đang có trên website:</h3>
<ol>
	<?php echo $str_count_meta_key; ?>
</ol>
<br>
<br>
<h3>Danh sách các bảng dữ liệu trong website:</h3>
<ol>
	<?php echo $str_all_table_in_site ; ?>
</ol>
<br>
<br>
<script type="text/javascript">
setTimeout(function () {
	if ( window.location.href.split('&del_data=1') ) {
		// nếu còn dữ liệu để xóa -> xóa luôn
		if ( $('#refresh_if_del_data li').length > 0 ) {
			window.location = window.location.href;
		} else {
			$('#refresh_if_del_data').html('<li><em>Không có posst_type nào bị xóa</em></li>');
		}
	}
}, 2000);
</script> 
