<?php



//
echo '<link rel="stylesheet" href="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/css/products_post.css?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'css/products_post.css' ) . '" type="text/css" media="all" />' . "\n";



//
$by_cat_id = isset( $_GET['by_cat_id'] ) ? (int) $_GET['by_cat_id'] : 0;


// tham khảo custom query: https://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query

//
$strFilter = " `" . wp_posts . "`.post_type = '" . $by_post_type . "'
	AND ( `" . wp_posts . "`.post_status = 'publish' OR `" . wp_posts . "`.post_status = 'pending' OR `" . wp_posts . "`.post_status = 'draft' ) ";
	
$joinFilter = "";
$strAjaxLink = '';

$strLinkPager .= '&by_post_type=' . $by_post_type;
$strAjaxLink .= '&by_post_type=' . $by_post_type;

$cats_type = ( $by_post_type == 'blog' ) ? 'blogs' : 'category';


//
if ( $by_cat_id > 0 ) {
	
	$strLinkPager .= '&by_cat_id=' . $by_cat_id;
	$strAjaxLink .= '&by_cat_id=' . $by_cat_id;
	
	//
	$arrs_cats = array(
		'taxonomy' => $cats_type,
		'hide_empty' => 0,
		'parent' => $by_cat_id,
	);
	
	$arrs_cats = get_categories( $arrs_cats );
//	print_r( $arrs_cats );
	
	$by_child_cat_id = '';
	foreach ( $arrs_cats as $v ) {
		$by_child_cat_id .= ',' . $v->term_id;
	}
	
	
	//
	$strFilter .= " AND `" . $wpdb->term_taxonomy . "`.taxonomy = '" . $cats_type . "'
		AND `" . $wpdb->term_taxonomy . "`.term_id IN (" . $by_cat_id . $by_child_cat_id . ") ";
	
	$joinFilter = " LEFT JOIN `" . $wpdb->term_relationships . "` ON ( `" . wp_posts . "`.ID = `" . $wpdb->term_relationships . "`.object_id)
		LEFT JOIN `" . $wpdb->term_taxonomy . "` ON ( `" . $wpdb->term_relationships . "`.term_taxonomy_id = `" . $wpdb->term_taxonomy . "`.term_taxonomy_id ) ";
//	$joinFilter = ", `" . $wpdb->term_taxonomy . "`, `" . $wpdb->term_relationships . "` ";
	
}
//echo $strFilter . '<br>' . "\n";
//echo $joinFilter . '<br>' . "\n";






//
$arrs_cats = array(
	'taxonomy' => $cats_type,
	'hide_empty' => 0,
	'parent' => 0,
);

//
$arrs_cats = get_categories( $arrs_cats );
//print_r( $arrs_cats );

echo '<ul class="cf admin-products_post-category">';
foreach ( $arrs_cats as $v ) {
	$sl = '';
	if ( $v->term_id == $by_cat_id ) {
		$sl = 'bold';
	}
	
	//
	echo '<li><a href="' . admin_link . 'admin.php?page=eb-products&by_post_type=' . $by_post_type . '&by_cat_id=' . $v->term_id . '" class="' . $sl . '">' . $v->name . '</a></li>';
}
echo '</ul>';





//
/*
if ( isset( $_GET['tab'] ) ) {
	$status_by = (int)$_GET['tab'];
	
	$strFilter .= " AND order_status = " . $status_by;
	
	$strLinkPager .= '&tab=' . $status_by;
}
*/

// tổng số đơn hàng
$totalThread = _eb_c ( "SELECT COUNT(ID) AS c
	FROM
		`" . wp_posts . "`
		" . $joinFilter . "
	WHERE
		" . $strFilter );
//echo $strFilter . '<br>' . "\n";
//echo $totalThread . '<br>' . "\n";



// phân trang bình thường
$totalPage = ceil ( $totalThread / $threadInPage );
if ( $totalPage < 1 ) {
	$totalPage = 1;
}
//echo $totalPage . '<br>' . "\n";
if ($trang > $totalPage) {
	$trang = $totalPage;
}
else if ( $trang < 1 ) {
	$trang = 1;
}
//echo $trang . '<br>' . "\n";
$offset = ($trang - 1) * $threadInPage;
//echo $offset . '<br>' . "\n";

//
$strAjaxLink .= '&trang=' . $trang;



?>

<div class="class-for-<?php echo $by_post_type; ?>">
	<div class="quick-show2-if-post">
		<div class="text-right cf div-inline-block">
			<div><a href="<?php echo web_link; ?>eb_export_products?export_type=google&token=<?php echo _eb_mdnam( $_SERVER['HTTP_HOST'] ); ?>" target="_blank" class="rf d-block blue-button whitecolor">for Google</a></div>
			<div><a href="<?php echo web_link; ?>eb_export_products?export_type=facebook&token=<?php echo _eb_mdnam( $_SERVER['HTTP_HOST'] ); ?>" target="_blank" class="rf d-block blue-button whitecolor">for Facebook</a></div>
			<div><a href="<?php echo web_link; ?>eb_export_products?export_type=echbaydotcom&token=<?php echo _eb_mdnam( $_SERVER['HTTP_HOST'] ); ?>" target="_blank" class="rf d-block blue-button whitecolor">from Echbaydotcom</a></div>
			<div><a href="<?php echo web_link; ?>eb_export_products?export_type=woo&token=<?php echo _eb_mdnam( $_SERVER['HTTP_HOST'] ); ?>" target="_blank" class="rf d-block blue-button whitecolor">from Woocommerce</a></div>
		</div>
		<br>
		<div class="thread-edit-tools">
			<div class="cf">
				<div class="lf f50">
					<input type="checkbox" id="thread-all-checkbox" value="0" class="thread-multi-checkbox" />
					<button type="button" class="small bold click-show-tools">Hành động <i class="fa fa-caret-down"></i></button>
				</div>
				<div align="right" class="lf f50"> Số sản phẩm trên mỗi trang
					<select id="change_set_thread_show_in_page" style="padding:3px;">
					</select>
				</div>
			</div>
			<div class="show-if-click-tools thread-multi-edit d-none">
				<form name="frm_admin_edit_content" method="post" action="ds34t53gt.php?act=process&module_id=thread_multi_edit" target="target_eb_iframe">
					<div class="d-none">
						<textarea name="t_list_id"></textarea>
						<input type="text" name="actions_for" value="" />
						<input type="text" name="actions_id_for" value="0" />
						<input type="submit" value="SB" />
					</div>
					<div class="titleCSS bold bborder">Chỉnh sửa nhiều sản phẩm</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Trạng thái</div>
							<div class="lf f60">{tmp.trv_str_trangthai}</div>
							<div class="lf f20">
								<button type="button" data-for="status" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Phân nhóm</div>
							<div class="lf f60 cf">
								<div class="lf f50">
									<div id="oiAnt"></div>
								</div>
							</div>
							<div class="lf f20">
								<button type="button" data-for="category" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Ngày hết hạn</div>
							<div class="lf f60 thread-multi-input">
								<input type="text" name="t_ngayhethan" value="" placeholder="Năm/Tháng/Ngày" maxlength="10" class="thread-list-ngayhethan" />
							</div>
							<div class="lf f20">
								<button type="button" data-for="enddate" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="bborder">
						<div class="cf">
							<div class="lf f20 bold">Số thứ tự</div>
							<div class="lf f60 thread-multi-input">
								<input type="text" name="t_stt" value="0" placeholder="Số thứ tự" maxlength="5" />
							</div>
							<div class="lf f20">
								<button type="button" data-for="stt" class="click-set-actions-for">Cập nhật</button>
							</div>
						</div>
						<br>
					</div>
					<br>
					<div class="thread_list_edit_options"></div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="frm_quick_edit_price" class="hide-if-press-esc">
	<div class="edit-price-padding">
		<div class="text-right"><i class="fa fa-close cur" onClick="$('#frm_quick_edit_price').fadeOut();"></i></div>
		<form name="frm_quick_edit_price" method="get" action="javascript:;" onSubmit="return WGR_check_quick_edit_price();">
			<input type="hidden" name="t_product_id" value="0">
			<div class="cf">
				<div class="lf f30">Giá cũ</div>
				<div class="lf f70">
					<input type="text" name="t_old_price" id="quick_edit_old_price" value="">
				</div>
			</div>
			<div class="cf">
				<div class="lf f30">Giá mới</div>
				<div class="lf f70">
					<input type="text" name="t_new_price" id="quick_edit_new_price" value="">
				</div>
			</div>
			<div class="small">* Mẹo:<br>
				Ví dụ giá cũ đang là 1,000,000đ, trong ô giá mới ta có các cách nhập như sau:<br>
				[<strong>70%</strong>] -&gt; hệ thống tự tính toán giá mới bằng 70% giá cũ -&gt; 700,000đ.<br>
				[<strong>-70%</strong>] -&gt; hệ thống tự tính toán giá mới bằng giá cũ trừ đi 70% -&gt; 300,000đ.<br>
				[<strong>600k</strong>] -&gt; hệ thống tự tính toán giá mới bằng 600 nhân với 1000 -&gt; 600,000đ.<br>
				* Giá cũ nhỏ hơn hoặc bằng Giá mới -&gt; Giá cũ sẽ được set bằng 0.</div>
			<br>
			<div class="cf">
				<div class="lf f30">&nbsp;</div>
				<div class="lf f70">
					<button type="submit" class="button button-primary">Cập nhật</button>
				</div>
			</div>
		</form>
	</div>
</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table-list class-for-post-type class-for-<?php echo $by_post_type; ?>">
	<tr class="table-list-title">
		<td width="5%">&nbsp;</td>
		<td width="10%">ID</td>
		<td width="8%">Ảnh</td>
		<td>Sản phẩm/ Giá cũ/ Giá mới</td>
		<td width="8%">STT</td>
		<td width="10%">Công cụ</td>
		<td width="14%">Ngày Đăng/ Cập nhật</td>
	</tr>
	<?php

if ( $totalThread > 0 ) {

	//
	$sql = "SELECT *
	FROM
		`" . wp_posts . "`
		" . $joinFilter . "
	WHERE
		" . $strFilter . "
	ORDER BY
		`" . wp_posts . "`.menu_order DESC
	LIMIT " . $offset . ", " . $threadInPage;
//	echo $sql; 
	$sql = _eb_q ( $sql );
//	print_r( $sql ); exit();
	
	//
	$arr_all_stick = get_option( 'sticky_posts' );
	
	//
	foreach ( $sql as $o ) {
		
//		print_r( $o ); exit();
		
		$trv_id = $o->ID;
		$trv_link = web_link . '?p=' . $trv_id;
		$trv_tieude = $o->post_title;
		
		$trv_img = _eb_get_post_img( $o->ID, 'thumbnail' );
		$view_by_group = '';
		$trv_stt = $o->menu_order;
		$trv_trangthai = $o->post_status == 'publish' ? 1 : 0;
//		$strLinkAjaxl = '&post_id=' . $trv_id . '&by_post_type=' . $by_post_type;
		$strLinkAjaxl = '&post_id=' . $trv_id . $strAjaxLink;
		
		//
		$current_sticky = 0;
		$comment_status = $o->comment_status;
		$ping_status = $o->ping_status;
		
		//
		$set_noindex = 0;
		$chinh_hang = 0;
		
		//
		$trv_giaban = 0;
		$trv_giamoi = 0;
		
		// các tính năng chỉ có ở post
		if ( $o->post_type == 'post' ) {
			if ( in_array( $o->ID, $arr_all_stick ) ) {
//			if ( is_sticky( $o->ID ) ) {
				$current_sticky = 1;
			}
			$chinh_hang = _eb_get_post_object( $o->ID, '_eb_product_chinhhang', 0 );
			
			// với phần giá cả -> sẽ lấy giá của woo nếu có
			$trv_giaban = _eb_float_only( _eb_get_post_object( $o->ID, '_eb_product_oldprice' ) );
			/*
			if ( $trv_giaban == 0 ) {
				$trv_giaban = _eb_float_only( _eb_get_post_object( $o->ID, '_regular_price', 0 ) );
			}
			*/
			$trv_giamoi = _eb_float_only( _eb_get_post_object( $o->ID, '_eb_product_price' ) );
			/*
			if ( $trv_giamoi == 0 ) {
				$trv_giamoi = _eb_float_only( _eb_get_post_object( $o->ID, '_price', 0 ) );
				
				// cập nhật giá mới từ giá của woo
				WGR_update_meta_post( $o->ID, '_eb_product_price', $trv_giamoi );
			}
			*/
			
			//
			if ( $trv_giaban > 0 && $trv_giaban == $trv_giamoi ) {
				delete_post_meta( $o->ID, '_eb_product_oldprice' );
			}
		}
		
		
		// tính điểm SEO nếu đang dùng công cụ SEO của EchBay
		$seo_color = '';
		
		// các tính năng chỉ có ở post hoặc blog
		if ( $o->post_type == 'post' || $o->post_type == 'blog' ) {
			$set_noindex = _eb_get_post_object( $o->ID, '_eb_product_noindex', 0 );
			
//			echo cf_on_off_echbay_seo;
			if ( cf_on_off_echbay_seo == 1 ) {
				$seo_score = 0;
				$seo_class_score = '';
				
				//
//				echo _eb_get_post_object( $o->ID, '_eb_product_title', $o->post_title ) . '<br>';
				
				// check title
				$a = strlen( _eb_get_post_object( $o->ID, '_eb_product_title', $o->post_title ) );
				if ( $a > 10 && $a < 70 ) {
					$seo_score++;
					$seo_class_score .= '1';
				}
				else {
					$seo_class_score .= '0';
				}
				
				// check description
				$a = strlen( strip_tags( _eb_get_post_object( $o->ID, '_eb_product_description', $o->post_excerpt ) ) );
				if ( $a > 160 && $a < 300 ) {
					$seo_score++;
					$seo_class_score .= '1';
				}
				else {
					$seo_class_score .= '0';
				}
				
				// check content
				$a = strlen( strip_tags( $o->post_content ) );
				if ( $a > 500 ) {
					$seo_score++;
					$seo_class_score .= '1';
				}
				else {
					$seo_class_score .= '0';
				}
				
				// mặc định thì báo đỏ
				$seo_color = 'redcolor';
				//
				if ( $seo_score > 2 ) {
					$seo_color = 'greencolor';
				}
				//
				else if ( $seo_score > 1 ) {
					$seo_color = 'bluecolor';
				}
				//
				else if ( $seo_score > 0 ) {
					$seo_color = 'orgcolor';
				}
				$seo_color = '<i data-id="' . $o->ID . '" class="fa fa-dot-circle fa-icons cur click-open-quick-edit-seo _' . $seo_class_score . ' ' . $seo_color . '"></i>';
				
//				echo $seo_color . '<br>';
			}
		}
		
		//
		echo '
<tr>
	<td class="text-center"><input type="checkbox" name="thread-checkbox" value="' . $trv_id . '" class="eb-uix-thread-checkbox thread-multi-checkbox" /></td>
	<td><a href="' . $trv_link . '" target="_blank">' . $trv_id . ' <i class="fa fa-eye"></i></a></td>
	<td><a href="' . $trv_link . '" target="_blank" class="d-block admin-thread-avt" style="background-image:url(\'' . $trv_img . '\');">&nbsp;</a></td>
	<td>
		<div><a title="' . $trv_tieude . '" href="' . admin_link . 'post.php?post=' . $trv_id . '&action=edit" target="_blank"><strong>' . $trv_tieude . '</strong> <i title="Sửa" class="fa fa-edit greencolor"></i></a></div>
		<div class="quick-show-if-post">Mã sản phẩm: <strong class="upper">' . _eb_get_post_object( $trv_id, '_eb_product_sku' ) . '</strong> | <span data-id="' . $trv_id . '" data-old-price="' . $trv_giaban . '"  data-new-price="' . $trv_giamoi . '" class="click-quick-edit-price cur">Giá: <span class="graycolor ebe-currency ebe-currency-format">' . $trv_giaban . '</span>/ <strong class="ebe-currency ebe-currency-format">' . $trv_giamoi . '</strong> <i title="Sửa" class="fa fa-edit greencolor"></i></span></div>
		<div>' . $view_by_group . '</div>
	</td>
	<td><input type="number" value="' . $trv_stt . '" data-ajax="' . $strLinkAjaxl . '&t=up&stt=" class="s change-update-new-stt" /></td>
	<td>
		<div class="text-center">
			<i title="Up to TOP" data-ajax="' . $strLinkAjaxl . '&t=auto&stt=' . $trv_stt . '" class="fa fa-refresh fa-icons cur click-order-thread"></i>
			
			<i title="Up" data-ajax="' . $strLinkAjaxl . '&t=up&stt=' . $trv_stt . '" class="fa fa-arrow-circle-up fa-icons cur click-order-thread"></i>
			
			<i title="Down" data-ajax="' . $strLinkAjaxl . '&t=down&stt=' . $trv_stt . '" class="fa fa-arrow-circle-down fa-icons cur click-order-thread"></i>
			
			<i title="Set sticky" data-val="' . $current_sticky . '" data-ajax="' . $strLinkAjaxl . '&t=sticky&current_sticky=' . $current_sticky . '" class="fa fa-star fa-icons cur click-order-thread"></i>
			
			<i title="Toggle comment status" data-val="' . $comment_status . '" data-ajax="' . $strLinkAjaxl . '&t=comment_status&comment_status=' . $comment_status . '" class="fa fa-comments fa-icons cur click-order-thread"></i>
			
			<i title="Toggle ping status" data-val="' . $ping_status . '" data-ajax="' . $strLinkAjaxl . '&t=ping_status&ping_status=' . $ping_status . '" class="fa fa-link fa-icons cur click-order-thread"></i>
			
			<i title="Toggle status" data-ajax="' . $strLinkAjaxl . '&t=status&toggle_status=' . $trv_trangthai . '" class="fa fa-icons cur click-order-thread ' . ( ($trv_trangthai > 0) ? 'fa-unlock' : 'fa-lock blackcolor' ) . '"></i>
			
			<i title="Set noindex" data-val="' . $set_noindex . '" data-ajax="' . $strLinkAjaxl . '&t=set_noindex&set_noindex=' . $set_noindex . '" class="fa fa-paw fa-icons cur click-order-thread"></i>
			
			<i title="Hàng chính hãng" data-val="' . $chinh_hang . '" data-ajax="' . $strLinkAjaxl . '&t=chinh_hang&chinh_hang=' . $chinh_hang . '" class="fa fa-diamond fa-icons cur click-order-thread"></i>
			
			' . $seo_color . '
		</div>
	</td>
	<td class="text-center">' . date( $__cf_row['cf_date_format'] . ' ' . $__cf_row['cf_time_format'], strtotime( $o->post_date ) ) . '<br>' . date( $__cf_row['cf_date_format'] . ' ' . $__cf_row['cf_time_format'], strtotime( $o->post_modified ) ) . '</td>
</tr>';
		
	}
	
}

	?>
</table>
<?php



echo '<script type="text/javascript" src="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/javascript/products_post.js?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'javascript/products_post.js' ) . '"></script>' . "\n";







