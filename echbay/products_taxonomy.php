<?php



//
echo '<link rel="stylesheet" href="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/css/products_taxonomy.css?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'css/products_taxonomy.css' ) . '" type="text/css" media="all" />' . "\n";




?>

<div class="text-right">
	<button class="blue-button cur click-show-quick-add-taxonomy">Thêm nhóm mới [+]</button>
</div>
<div class="show-quick-add-taxonomy d-none">
	<form name="frm_config" method="post" action="<?php echo web_link; ?>process/?set_module=create_taxonomy" target="target_eb_iframe" onsubmit="return WGR_check_create_taxonomy();">
		<div class="maxwidth-quick-add-taxonomy cf">
			<div class="lf f50">
				<div>
					<input type="hidden" name="t_taxonomy" value="<?php echo $by_taxonomy; ?>">
				</div>
				<p class="bold">Nhóm cha:</p>
				<div id="oiAnt"><?php echo _eb_categories_list_v3( 't_ant', $by_taxonomy ); ?></div>
				<br>
				<div>
					<label for="t_multi_taxonomy" class="l25 bold">Nhập danh sách các nhóm cần thêm:</label>
					<br>
					<textarea name="t_multi_taxonomy" id="t_multi_taxonomy" style="width:99%;height:300px;"></textarea>
					<p>* Có thể nhập nhiều nhóm, mõi nhóm cách nhau bởi dấu xuống dòng!</p>
				</div>
				<br>
			</div>
			<div class="lf f50">
				<div>
					<input type="submit" value="Thêm nhóm mới" class="button button-primary" />
				</div>
				<br>
				<div id="create_taxonomy_result" class="left-menu-space"></div>
			</div>
		</div>
	</form>
	<br>
	<hr>
	<br>
</div>
<?php






// Lấy toàn bộ danh sách category rồi hiển thị thành menu
function WGR_get_and_oders_taxonomy_category (
	// taxonomy mặc định
	$cat_type = 'category',
	// nhóm cha mặc định -> mặc định lấy nhóm cấp 1
	$cat_ids = 0,
	// có lấy nhóm con hay không -> mặc định là có
	$get_child = 1
) {
	
	//
	$arrs_cats = array(
		'taxonomy' => $cat_type,
		'hide_empty' => 0,
		'parent' => $cat_ids,
	);
	
	//
	$arrs_cats = get_categories( $arrs_cats );
//	print_r($arrs_cats);
//	exit();
	
	//
	if ( count($arrs_cats) == 0 ) {
		return '';
	}
	
	
	// Thử kiểm tra xem trong này có nhóm nào được set là nhóm chính không
	$post_primary_categories = array();
	
	// Nếu đang là lấy nhóm cấp 1
	if ( $cat_ids == 0 ) {
		foreach ( $arrs_cats as $v ) {
			$post_primary_categories[ $v->term_id ] = _eb_get_cat_object( $v->term_id, '_eb_category_primary', 0 );
		}
//		print_r( $post_primary_categories );
	}

	
	// sắp xếp mảng theo chủ đích của người dùng
	$oders = array();
	$options = array();
	
	//
	foreach ( $arrs_cats as $v ) {
		$oders[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
		$options[$v->term_id] = $v;
	}
	arsort( $oders );	
	
	
	//
	$str = '';
//	foreach ( $arrs_cats as $v ) {
	foreach ( $oders as $k => $cat_stt ) {
		$v = $options[$k];
		
		//
		$str_child = '';
		if ( $get_child == 1 ) {
			$str_child = WGR_get_and_oders_taxonomy_category (
				$v->taxonomy,
				$v->term_id
			);
		}
		
		//
		$strLinkAjaxl = '&term_id=' . $v->term_id . '&by_taxonomy=' . $v->taxonomy;
		$_eb_category_primary = _eb_get_cat_object( $v->term_id, '_eb_category_primary', 0 );
		
		//
		$c_link = _eb_c_link( $v->term_id );
		
		//
		$str .= '
		<div class="cf">
			<div class="lf">
				<div class="div-inline-block">
					<div><input type="number" value="' . $cat_stt . '" data-ajax="' . $strLinkAjaxl . '&t=up&stt=" class="s change-update-new-stt" /></div>
					
					<div><i title="Up to TOP" data-ajax="' . $strLinkAjaxl . '&t=auto&stt=' . $cat_stt . '" class="fa fa-refresh fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Up" data-ajax="' . $strLinkAjaxl . '&t=up&stt=' . $cat_stt . '" class="fa fa-arrow-circle-up fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Down" data-ajax="' . $strLinkAjaxl . '&t=down&stt=' . $cat_stt . '" class="fa fa-arrow-circle-down fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Set primary" data-val="' . $_eb_category_primary . '" data-ajax="' . $strLinkAjaxl . '&t=primary&current_primary=' . $_eb_category_primary . '" class="fa fa-star fa-icons cur click-order-thread"></i></div>
				</div>
			</div>
			<div class="lf"><a href="' . admin_link . 'term.php?taxonomy=' . $v->taxonomy . '&tag_ID=' . $v->term_id . '&post_type=' . ( $v->taxonomy == EB_BLOG_POST_LINK ? EB_BLOG_POST_TYPE : 'post' ) . '" target="_blank">' . $v->name . ' (' . $v->count . ') <i class="fa fa-edit"></i></a> - <a href="' . $c_link . '" target="_blank" class="small blackcolor">' . $c_link . ' <i class="fa fa-eye"></i></a></a></div>
		</div>' . $str_child;
	}
	
	return '<blockquote>' . $str . '</blockquote>';
}



//
echo '<div class="list-edit-taxonomy">' . WGR_get_and_oders_taxonomy_category( $by_taxonomy ) . '</div>';



echo '<script type="text/javascript" src="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/javascript/products_taxonomy.js?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'javascript/products_taxonomy.js' ) . '"></script>' . "\n";



