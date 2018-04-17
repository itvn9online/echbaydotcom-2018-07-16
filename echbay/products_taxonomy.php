<?php



//
echo '<link rel="stylesheet" href="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/css/products_taxonomy.css?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'css/products_taxonomy.css' ) . '" type="text/css" media="all" />' . "\n";



//
$get_site_select_taxonomy = _eb_categories_list_v3( 't_ant', $by_taxonomy );




?>
<style>
#edit_parent_for_category { display: none; }
.edit-parent-padding {
	background: #fff;
	border: 1px #ccc solid;
	padding: 15px;
	position: fixed;
	right: 10px;
	top: 10%;
	max-width: 350px;
	width: 95%;
}
</style>
<div id="edit_parent_for_category" class="hide-if-press-esc">
	<div class="edit-parent-padding">
		<form name="frm_quick_edit_parent" method="get" action="javascript:;" onSubmit="return WGR_check_quick_edit_parent();">
			<input type="hidden" name="t_uri" value="">
			<div class="cf">
				<div class="lf f30">Danh mục</div>
				<div class="lf f70 bold edit_parent_for"></div>
			</div>
			<div class="cf">
				<div class="lf f30">Nhóm cha</div>
				<div class="lf f70 edit_parent_by"><?php echo $get_site_select_taxonomy; ?></div>
			</div>
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
				<div id="oiAnt"><?php echo $get_site_select_taxonomy; ?></div>
				<br>
				<div>
					<label for="t_multi_taxonomy" class="l25 bold">Nhập danh sách các nhóm cần thêm:</label>
					<p>* Nếu không có Category slug -&gt; slug sẽ tự động tạo theo Category name</p>
					<textarea name="t_multi_taxonomy" id="t_multi_taxonomy" placeholder="Category name [ | category slug ]" style="width:99%;height:300px;"></textarea>
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
//	if ( count($arrs_cats) == 0 ) {
	if ( empty($arrs_cats) ) {
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
	$oders = WGR_order_and_hidden_taxonomy( $arrs_cats, 1 );
	/*
	$oders = array();
	$options = array();
	
	//
	foreach ( $arrs_cats as $v ) {
		$oders[ $v->term_id ] = (int) _eb_get_cat_object( $v->term_id, '_eb_category_order', 0 );
		$options[$v->term_id] = $v;
	}
	arsort( $oders );	
	*/
	
	
	//
	$str = '';
//	foreach ( $arrs_cats as $v ) {
	foreach ( $oders as $k => $v ) {
//		$v = $options[$k];
		$cat_stt = $v->stt;
		
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
		$_eb_category_noindex = _eb_get_cat_object( $v->term_id, '_eb_category_noindex', 0 );
		$_eb_category_hidden = _eb_get_cat_object( $v->term_id, '_eb_category_hidden', 0 );
		
		// tính điểm SEO nếu đang dùng công cụ SEO của EchBay
		$seo_color = '';
//		echo cf_on_off_echbay_seo;
		if ( cf_on_off_echbay_seo == 1 ) {
			$seo_score = 0;
			$seo_class_score = '';
			
			// check title
			$a = strlen( _eb_get_cat_object( $v->term_id, '_eb_category_title', $v->name ) );
			if ( $a > 10 && $a < 70 ) {
				$seo_score++;
				$seo_class_score .= '1';
			}
			else {
				$seo_class_score .= '0';
			}
			
			// check description
			$a = strlen( strip_tags( _eb_get_cat_object( $v->term_id, '_eb_category_description', $v->description ) ) );
			if ( $a > 160 && $a < 300 ) {
				$seo_score++;
				$seo_class_score .= '1';
			}
			else {
				$seo_class_score .= '0';
			}
			
			// check content
			$a = strlen( strip_tags( _eb_get_cat_object( $v->term_id, '_eb_category_content', '' ) ) );
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
			$seo_color = '<i data-id="' . $v->term_id . '" class="fa fa-dot-circle fa-icons cur click-open-quick-edit-seo _' . $seo_class_score . ' ' . $seo_color . '"></i>';
		}
		
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
					
					<div><i title="Alow for bot" data-val="' . $_eb_category_noindex . '" data-ajax="' . $strLinkAjaxl . '&t=primary&current_index=' . $_eb_category_noindex . '" class="fa fa-paw fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Hidden or show" data-val="' . $_eb_category_hidden . '" data-ajax="' . $strLinkAjaxl . '&t=primary&current_hidden=' . $_eb_category_hidden . '" class="fa fa-unlock fa-icons cur click-order-thread"></i></div>
					
					<div><i title="Change parent category" data-name="' . str_replace( '"', '&quot;', $v->name ) . '" data-val="' . $v->parent . '" data-ajax="' . $strLinkAjaxl . '&t=change_parent&current_parent=' . $v->parent . '" class="fa fa-group fa-icons cur click-change-parent-category"></i></div>
					
					<div>' . $seo_color . '</div>
				</div>
			</div>
			<div class="lf"> &nbsp; &nbsp; <a href="' . admin_link . 'term.php?taxonomy=' . $v->taxonomy . '&tag_ID=' . $v->term_id . '&post_type=' . ( $v->taxonomy == EB_BLOG_POST_LINK ? EB_BLOG_POST_TYPE : 'post' ) . '" target="_blank">' . $v->name . ' (' . $v->count . ') <i class="fa fa-edit"></i></a> - <a href="' . $c_link . '" target="_blank" class="small blackcolor">' . str_replace( web_link, '', $c_link ) . ' <i class="fa fa-eye"></i></a></div>
		</div>' . $str_child;
	}
	
	return '<blockquote>' . $str . '</blockquote>';
}



//
echo '<div class="list-edit-taxonomy">' . WGR_get_and_oders_taxonomy_category( $by_taxonomy ) . '</div>';





?>
<br>
<br>
<div><i class="fa fa-dot-circle fa-icons cur orgcolor"></i> Là thang điểm SEO của Danh mục! <strong class="redcolor">Màu đỏ</strong>: 0 điểm, <strong class="orgcolor">màu cam</strong>: 1 điểm, <strong class="bluecolor">màu xanh lục</strong>: 2 điểm, <strong class="greencolor">màu xanh lá</strong>: 3 điểm.<br>
	<blockquote> Điều kiện chấm điểm (dựa theo SEO Quake):
		<ol>
			<li>TITLE dài từ 10-70 ký tự.</li>
			<li>DESCRIPTION dài từ 160-300 ký tự.</li>
			<li>Nội dung từ 500 ký tự trở lên.</li>
		</ol>
	</blockquote>
</div>
<?php


echo '<script type="text/javascript" src="' . web_link . EB_DIR_CONTENT . '/echbaydotcom/javascript/products_taxonomy.js?v=' . filemtime( EB_THEME_PLUGIN_INDEX . 'javascript/products_taxonomy.js' ) . '"></script>' . "\n";

















