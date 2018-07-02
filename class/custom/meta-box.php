<?php
/*
* custom-meta-box là các dữ liệu sẽ được bổ sung cho từng hạng mục bài viết, vd: giá cũ, giá mới...
*/





/*
* in ra HTML của các mảng đã nhập vào
* Khai báo callback
* @param $post là đối tượng WP_Post để nhận thông tin của post
*/
function WGR_echo_label_for_edit_form ( $str ) {
	if ( $str != '' ) {
		return '<div><em class="small">' . $str . '</em></div>';
	}
	return '';
}

function EchBayPrintHTMLOutput( $arr_box, $arr_type, $post ) {
	global $eb_arr_placeholder_custom_meta_box;
	
	// với các thông số ẩn thì cho vào 1 biến, rồi in ra sau
	$str_hidden = '';
	
	echo '<table class="eb-public-table eb-editer-table">';
	
	foreach ( $arr_box as $k => $v ) {
//		$val = get_post_meta( $post->ID, $k, true );
		$val = _eb_get_post_object( $post->ID, $k );
		$tai = isset( $arr_type[ $k ] ) ? $tai = $arr_type[ $k ] : 'text';
		
		//
		$other_attr = '';
		
		//
//		$other_attr .= 'placeholder="' . ( isset($eb_arr_placeholder_custom_meta_box[$k]) ? $eb_arr_placeholder_custom_meta_box[$k] : '' ) . '"';
		if ( ! isset( $eb_arr_placeholder_custom_meta_box[$k] ) ) {
			$eb_arr_placeholder_custom_meta_box[$k] = '';
		}
		/*
		else {
			$eb_arr_placeholder_custom_meta_box[$k] = '<em class="small">' . $eb_arr_placeholder_custom_meta_box[$k] . '</em>';
		}
		*/
		
		// chiều dài rộng cho td
//		$td1 = 28;
//		$td2 = 100 - $td1;
		
		//
//		echo gettype( $tai ) . '<br>';
		
		// nếu là array -> hiển thị dưới dạng select option
		if ( gettype( $tai ) == 'array' ) {
			echo '<tr data-row="' . $k . '">';
			echo '<td class="t"><label for="' . $k . '"><strong>' . $v . '</strong></label></td>';
			
			echo '<td class="i">';
			echo '<select id="' . $k . '" name="' . $k . '">';
			
			foreach ( $tai as $k2 => $v2 ) {
				$sl = '';
				if ( $k2 == $val ) {
					$sl = ' selected="selected"';
				}
				
				//
				echo '<option value="' . $k2 . '"' . $sl . '>' . $v2 . '</option>';
			}
			
			echo '</select>';
			echo WGR_echo_label_for_edit_form( $eb_arr_placeholder_custom_meta_box[$k] );
			echo '</td>';
			
			echo '</tr>';
		}
		else if ( $tai == 'textarea_one' ) {
			/*
			echo '
			<div><strong>' . $v . '</strong></div>
			<div><textarea id="' . $k . '" name="' . $k . '">' .esc_attr( $val ). '</textarea></div>
			<br>';
			*/
			
			//
//			echo '<div><strong>' . $v . '</strong></div>';
			
			//
			wp_editor( $val, $k );
			
//			echo '<br>';
		}
		else if ( $tai == 'hidden' ) {
			$str_hidden .= '<input type="' . $tai . '" id="' . $k . '" name="' . $k . '" value="' .esc_attr( $val ). '" />';
		}
		else if ( $tai == 'checkbox' ) {
			echo '
			<tr data-row="' . $k . '">
				<td class="t"><label for="' . $k . '"><strong>' . $v . '</strong></label></td>
				<td class="i"><label for="' . $k . '"><input type="' . $tai . '" id="' . $k . '" name="' . $k . '" value="' . $val . '" /> ' . $eb_arr_placeholder_custom_meta_box[$k] . '</label></td>
			</tr>';
		}
		// input text
		else {
			echo '
			<tr data-row="' . $k . '">
				<td class="t"><label for="' . $k . '"><strong>' . $v . '</strong></label></td>
				<td class="i"><input type="' . $tai . '" id="' . $k . '" name="' . $k . '" value="' .esc_attr( $val ). '" ' . $other_attr . ' class="m" />' . WGR_echo_label_for_edit_form( $eb_arr_placeholder_custom_meta_box[$k] ) . '</td>
			</tr>';
		}
	}
	
	echo '</table>';
	
	echo $str_hidden;
	
}




/*
* Định dạng dữ liệu
*/
$arr_product_giohethan = array(
	'' => '[ Không chọn ]'
);
for ( $i = 23; $i > 5; $i-- ) {
	$j = $i;
	if ( $j < 10 ) {
		$j = '0' . $j;
	}
	$j .= ':59';
	$arr_product_giohethan[$j] = $j;
}


//
$eb_arr_type_custom_meta_box = array(
	// post
	'_eb_product_status' => $arr_eb_product_status,
//	'_eb_product_color' => 'number',
//	'_eb_product_sku' => 'number',
//	'_eb_product_oldprice' => 'number',
//	'_eb_product_price' => 'number',
	'_eb_product_buyer' => 'number',
	'_eb_product_quantity' => 'number',
//	'_eb_product_avatar' => 'hidden',
	'_eb_product_giohethan' => $arr_product_giohethan,
	'_eb_product_noindex' => 'checkbox',
	'_eb_product_chinhhang' => 'checkbox',
	
	'_eb_product_size' => 'hidden',
	'_eb_product_searchkey' => 'hidden',
	'_eb_product_rating_value' => 'hidden',
	'_eb_product_rating_count' => 'hidden',
	
	// textarea_one -> một một mình một ô
	// textarea -> đừng chung với các thuộc tính khác -> style để tạo giãn cách
	'_eb_product_gallery' => 'textarea_one',
	'_eb_product_dieukien' => 'textarea_one',
	'_eb_product_noibat' => 'textarea_one',
	'_eb_product_list_color' => 'textarea_one',
	
	// Nội dung phụ cho phần blog, thi thoảng có site sử dụng
	'_eb_blog_2content' => 'textarea_one',
	
	'_eb_product_leech_source' => 'hidden',
	
	// ads
	'_eb_ads_status' => $arr_eb_ads_status,
	'_eb_ads_target' => 'checkbox',
//	'_eb_ads_for_post' => 'number',
//	'_eb_ads_for_category' => 'number',
	
	// category
	'_eb_category_status' => $arr_eb_category_status,
	'_eb_category_order' => 'number',
	'_eb_category_leech_url' => 'hidden',
	'_eb_category_primary' => 'checkbox',
	'_eb_category_content' => 'textarea',
	'_eb_category_noindex' => 'checkbox',
	'_eb_category_hidden' => 'checkbox',
);

// Một số thuộc tính chỉ hiển thị với admin cấp cao
if ( mtv_id == 1 ) {
	$eb_arr_type_custom_meta_box['_eb_product_leech_source'] = 'text';
//	$eb_arr_type_custom_meta_box['_eb_product_avatar'] = 'text';
	
	$eb_arr_type_custom_meta_box['_eb_category_leech_url'] = 'text';
}



// Hiển thị câu ghi chú đối với meta box
$eb_arr_placeholder_custom_meta_box = array(
	'_eb_product_css' => 'Bạn có thể thêm một class class CSS vào đây, class này sẽ xuất hiện trong thẻ BODY, dùng để tùy chỉnh CSS cho các post, page... cụ thể',
	'_eb_product_avatar' => 'Ảnh đại diện dự phòng (nhiều trường hợp chuyển dữ liệu hoặc làm demo sẽ tiện)',
	'_eb_product_old_url' => 'Khi người dùng truy cập vào URL này, hệ thống sẽ redirect 301 về URL mới',
	'_eb_product_video_url' => 'Một số giao diện hỗ trợ video youtube (nếu có)',
	
	'_eb_category_avt' => 'Ảnh đại diện của phân nhóm, kích thước khuyến nghị là 500x400 pixel. Ảnh này sẽ xuất hiện khi chia sẻ nhóm lên các mạng xã hội như: Facebook, Twiter...',
	'_eb_category_favicon' => 'Favicon là một ảnh nhỏ hơn, kích thước khuyến nghị là 64x64 pixel. Ảnh này thường dùng trong các menu nếu CSS của menu có hỗ trợ chức năng.',
	'_eb_category_custom_css' => 'Là nơi nhập class CSS riêng để tiện cho việc thay đổi CSS theo từng danh mục cha, con...',
	'_eb_category_title' => 'Với định dạng màu sắc thì nhập mã màu vào (bao gồm cả dấu #)',
	'_eb_category_google_product' => 'Tạo nhóm sản phẩm theo tiêu chuẩn của Google. <a href="https://support.google.com/merchants/answer/6324436?hl=vi" target="_blank" rel="nofollow">Tìm hiểu thêm...</a> Nên sử dụng nhóm sản phẩm dạng ID (số) theo <a href="https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt" target="_blank" rel="nofollow">danh sách này</a>, và chỉ sử dụng <strong>nhóm cấp 1</strong> thay vì các nhóm con chi tiết.',
	'_eb_category_order' => 'Số càng lớn thì độ ưu tiên càng cao, nhóm sẽ được ưu tiên xuất hiện trước',
	'_eb_category_old_url' => 'Khi người dùng truy cập vào URL này, hệ thống sẽ redirect 301 về URL mới',
//	'_eb_category_primary' => 'Sử dụng khi bạn muốn các post_option sử dụng chung với category. Nếu là nhóm chính, sẽ có nhiều quyền ưu tiên hơn, VD: tạo sản phẩm liên quan...',
	'_eb_category_primary' => 'Trong các module lấy sản phẩm, tạo menu... nếu có sự xuất hiện của nhóm chính thì sản phẩm trong nhóm đó sẽ được ưu tiên hơn.',
	'_eb_category_noindex' => 'Ngăn chặn các công cụ tìm kiếm đánh chỉ mục Danh mục này.',
	'_eb_category_hidden' => 'Trong một số trường hợp, bạn tạm thời không muốn nhóm này xuất hiện thì sử dụng chức năng này để ẩn nó đi.',
	
	'_eb_ads_target' => 'Mặc định, các URL trong quảng cáo sẽ được mở đè lên tab hiện tại, đánh dấu và lưu lại để mở URL trong tab mới.',
	'_eb_ads_for_post' => 'Nhập vào ID của Sản phẩm hoặc bài Blog mà bạn muốn quảng cáo này trỏ tới, khi đó, các dữ liệu như: Ảnh đại diện, tiêu đề, URL sẽ được lấy từ Sản phẩm/ Blog thay vì lấy từ quảng cáo.',
	'_eb_ads_for_category' => 'Nhập vào ID của Danh mục Sản phẩm hoặc Danh mục Blog mà bạn muốn quảng cáo này trỏ tới, khi đó, các dữ liệu như: Ảnh đại diện, tiêu đề, URL sẽ được lấy từ Danh mục Sản phẩm/ Blog thay vì lấy từ quảng cáo.',
	'_eb_ads_video_url' => 'Bạn có thể nhập vào URL video trên Youtube (Ví dụ: <strong>https://youtu.be/{ID}</strong>) hoặc URL video MP4, các định dạng khác hiện chưa được hỗ trợ.',
	
	'_eb_product_ngayhethan' => 'Nếu thời gian hết hạn được thiết lập, sản phẩm sẽ hiển thị chữ cháy hàng khi hết hạn.',
	'_eb_product_leech_sku' => 'Chức năng dùng để kiểm soát các tin đã tồn tại từ phiê bản cũ hơn (thường sử dụng khi chuyển đổi code khác sang wordpress).',
	
//	'_eb_product_size' => '',
	'_eb_product_giohethan' => 'Thiết lập giờ hết hạn cụ thể cho phần Ngày hết hạn ở trên. Nếu để trống trường này, giờ hết hạn sẽ là cuối ngày hôm đó (23:59)',
	'_eb_product_noindex' => 'Ngăn chặn các công cụ tìm kiếm đánh chỉ mục Bài viết này',
	'_eb_product_chinhhang' => 'Đánh dấu để hiển thị nhãn Đảm bảo chính hãng',
	
);
$eb_arr_placeholder_custom_meta_box['_eb_product_leech_source'] = $eb_arr_placeholder_custom_meta_box['_eb_product_old_url'];
$eb_arr_placeholder_custom_meta_box['_eb_category_leech_url'] = $eb_arr_placeholder_custom_meta_box['_eb_category_old_url'];




/*
* Nhiều form cần dùng đoạn này
*/
$eb_meta_custom_meta_box = array(
	'_eb_product_title' => 'Title',
	'_eb_product_keywords' => 'Keywords',
	'_eb_product_description' => 'Description',
	'_eb_product_noindex' => 'Noindex',
	
	//
	'_eb_product_avatar' => 'Ảnh đại diện',
	'_eb_product_css' => 'Tùy chỉnh CSS',
//	'_eb_product_leech_source' => 'URL đồng bộ',
);




/*
* Form sản phẩm
*/
$eb_arr_custom_meta_box = array(
	'_eb_product_status' => 'Trạng thái',
	'_eb_product_color' => 'Màu sắc',
	'_eb_product_size' => 'Kích thước',
	'_eb_product_searchkey' => 'EB Search',
	'_eb_product_sku' => 'Mã sản phẩm',
	'_eb_product_leech_sku' => 'SKU (leech data)',
	'_eb_product_oldprice' => EBE_get_lang('post_giacu'),
	'_eb_product_price' => EBE_get_lang('post_giamoi'),
	'_eb_product_buyer' => EBE_get_lang('post_luotmua'),
	'_eb_product_quantity' => EBE_get_lang('post_soluong'),
	'_eb_product_ngayhethan' => 'Ngày hết hạn',
	'_eb_product_giohethan' => 'Giờ hết hạn',
	'_eb_product_chinhhang' => 'Đảm bảo chính hãng',
	
	'_eb_product_rating_value' => 'Điểm đánh giá',
	'_eb_product_rating_count' => 'Tổng số đánh giá',
);

$eb_arr_gallery_meta_box = array(
	'_eb_product_gallery' => 'Thư viện ảnh',
);

$eb_arr_list_color_meta_box = array(
	'_eb_product_list_color' => 'Danh sách màu sắc',
);

$eb_arr_dieukien_meta_box = array(
	'_eb_product_dieukien' => 'Điều kiện',
);

$eb_arr_noibat_meta_box = array(
	'_eb_product_noibat' => 'Điểm nổi bật',
);

$eb_arr_blog_2content_meta_box = array(
	'_eb_blog_2content' => 'Nội dung phụ',
);

// thông tin phụ của trang sản phẩm
$eb_arr_phu_meta_box = array(
	'_eb_product_leech_source' => 'URL đồng bộ',
	'_eb_product_old_url' => 'URL cũ',
	'_eb_product_video_url' => 'URL Youtube video',
);


function EchBayThongTinOutput( $post ) {
	global $eb_arr_custom_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_custom_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayGalleryOutput( $post ) {
	global $eb_arr_gallery_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_gallery_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayListColorOutput( $post ) {
	global $eb_arr_list_color_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_list_color_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayDieukienOutput( $post ) {
	global $eb_arr_dieukien_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_dieukien_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayNoibatOutput( $post ) {
	global $eb_arr_noibat_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_noibat_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayPhuOutput( $post ) {
	global $eb_arr_phu_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_phu_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayMetaOutput( $post ) {
	global $eb_meta_custom_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_meta_custom_meta_box, $eb_arr_type_custom_meta_box, $post );
}

function EchBayBlog2Content ( $post ) {
	global $eb_arr_blog_2content_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_arr_blog_2content_meta_box, $eb_arr_type_custom_meta_box, $post );
}




/*
* Form quảng cáo
*/
$eb_ads_custom_meta_box = array(
	'_eb_ads_for_post' => 'ID Sản phẩm/ Blog/ Page',
	'_eb_ads_for_category' => 'Chuyên mục/ Danh mục',
	'_eb_ads_url' => 'Đường dẫn',
	'_eb_ads_target' => 'Mở trong tab mới',
	'_eb_ads_video_url' => 'URL Video',
	'_eb_ads_status' => 'Khu vực hiển thị',
	'_eb_product_avatar' => 'Ảnh đại diện',
);

function EchBayQuangCaoOutput( $post ) {
	global $eb_ads_custom_meta_box;
	global $eb_arr_type_custom_meta_box;
	
	//
	EchBayPrintHTMLOutput( $eb_ads_custom_meta_box, $eb_arr_type_custom_meta_box, $post );
}





/*
* Khai báo meta box cho các post
*/
function EchBayMetaBox () {
	// thông tin bổ sung cho sản phẩm
	add_meta_box( 'eb-product-info', 'Thông tin cơ bản', 'EchBayThongTinOutput', 'post' );
	
	// Các textarea khác
	add_meta_box( 'eb-product-gallery', 'Thư viện ảnh', 'EchBayGalleryOutput', 'post' );
	add_meta_box( 'eb-product-list-color', 'Danh sách màu sắc', 'EchBayListColorOutput', 'post' );
	add_meta_box( 'eb-product-dieukien', 'Điều kiện', 'EchBayDieukienOutput', 'post' );
	add_meta_box( 'eb-product-noibat', 'Điểm nổi bật', 'EchBayNoibatOutput', 'post' );
	
	// thẻ META cho sản phẩm
	if ( cf_on_off_echbay_seo == 1 ) {
		add_meta_box( 'eb-product-meta', 'Tùy chỉnh nội dung thẻ META', 'EchBayMetaOutput', 'post' );
		
		add_meta_box( 'eb-blog-meta', 'Tùy chỉnh nội dung thẻ META', 'EchBayMetaOutput', EB_BLOG_POST_TYPE );
		
		// thẻ META cho page
		add_meta_box( 'eb-page-meta', 'Tùy chỉnh nội dung thẻ META', 'EchBayMetaOutput', 'page' );
	}
	
	add_meta_box( 'eb-product-bosung', 'Thông tin bổ sung', 'EchBayPhuOutput', 'post' );
	
	
	// thẻ META cho blog
	add_meta_box( 'eb-blog-bosung', 'Thông tin bổ sung', 'EchBayPhuOutput', EB_BLOG_POST_TYPE );
	add_meta_box( 'eb-blog-2content', 'Nội dung phụ', 'EchBayBlog2Content', EB_BLOG_POST_TYPE );
	
	
	// thông tin bổ sung cho quảng cáo
	add_meta_box( 'eb-ads-info', 'Thông tin cơ bản', 'EchBayQuangCaoOutput', 'ads' );
}
add_filter( 'add_meta_boxes', 'EchBayMetaBox' );




/*
* Lưu dữ liệu meta box khi nhập vào
* @param post_id là ID của post hiện tại
*/
function EchBayThongTinRunSave ( $arr_box, $post_id ) {
	
	global $eb_arr_type_custom_meta_box;
	
	// cần phải lấy cả mảng dữ liệu cũ để save vào 1 thể, nếu không sẽ bị thiếu
//	$arr_save = _eb_get_object_post_meta( $post_id );
	
	foreach ( $arr_box as $k => $v ) {
		
		// lọc mã html với các input thường
		$loc_html = isset( $eb_arr_type_custom_meta_box[ $k ] ) ? $eb_arr_type_custom_meta_box[ $k ] : '';
		
		//
		if ( isset( $_POST[ $k ] ) ) {
//			echo $k . '<br>' . "\n";
			
			$val = $_POST[ $k ];
			
			// Bỏ qua với textarea
			if ( $loc_html == 'textarea_one' || $loc_html == 'textarea' ) {
			}
			else if ( $loc_html == 'checkbox' ) {
				$val = 1;
			}
			else {
				if ( $k == '_eb_product_oldprice'
				|| $k == '_eb_product_price' ) {
					$val = _eb_float_only( $val, 2 );
				}
				else {
					$val = sanitize_text_field( $val );
				}
			}
			
			//
			$val = trim( WGR_stripslashes( $val ) );
			
			//
			WGR_update_meta_post( $post_id, $k, $val );
			if ( $val == '' ) {
				delete_post_meta( $post_id, $k );
			}
			
			//
//			$arr_save[ $k ] = $val;
			
			//
//			$arr_save[ $k ] = addslashes( $val );
		}
		// thử kiểm tra với checkbox
		else if ( $loc_html == 'checkbox' ) {
			// không có -> set là 0 luôn
//			WGR_update_meta_post( $post_id, $k, 0 );
			delete_post_meta( $post_id, $k );
		}
		
	}
	
	//
//	WGR_update_meta_post( $post_id, eb_post_obj_data, $arr_save );
	
//	print_r( $arr_save ); exit();
	
}


function EchBayThongTinSave ( $post_id ) {
	global $eb_meta_custom_meta_box;
	global $eb_arr_custom_meta_box;
	global $eb_ads_custom_meta_box;
	global $eb_arr_blog_2content_meta_box;
	
	global $eb_arr_gallery_meta_box;
	global $eb_arr_list_color_meta_box;
	global $eb_arr_dieukien_meta_box;
	global $eb_arr_noibat_meta_box;
	global $eb_arr_phu_meta_box;
	
	EchBayThongTinRunSave( $eb_meta_custom_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_custom_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_ads_custom_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_gallery_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_list_color_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_dieukien_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_noibat_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_phu_meta_box, $post_id );
	
	EchBayThongTinRunSave( $eb_arr_blog_2content_meta_box, $post_id );
}
add_filter( 'save_post', 'EchBayThongTinSave' );












/*
* Custom fields for category extra
* https://en.bainternet.info/wordpress-category-extra-fields/
*/
//if ( cf_on_off_echbay_seo == 1 ) {



// cho phép HTML trong category
/*
foreach ( array( 'pre_term_description' ) as $filter ) {
	remove_filter( $filter, 'wp_filter_kses' );
}

foreach ( array( 'term_description' ) as $filter ) {
	remove_filter( $filter, 'wp_kses_data' );
}
*/



//
$arr_category_custom_fields = array();

//
$arr_category_custom_fields['_eb_category_avt'] = 'Ảnh đại diện lớn (banner)';
$arr_category_custom_fields['_eb_category_favicon'] = 'Ảnh đại diện nhỏ (favicon)';
$arr_category_custom_fields['_eb_category_custom_css'] = 'CSS riêng';


// Để tránh xung đột và thừa thãi -> chỉ kích hoạt cột liên quan đến SEO khi người dùng chọn bật nó, ngoài ra thì bỏ qua
if ( cf_on_off_echbay_seo == 1 ) {
	$arr_category_custom_fields['_eb_category_status'] = 'Trạng thái/ Định dạng';
	$arr_category_custom_fields['_eb_category_order'] = 'Số thứ tự';
	$arr_category_custom_fields['_eb_category_content'] = 'Giới thiệu';
	
	$arr_category_custom_fields['_eb_category_title'] = 'Title';
	$arr_category_custom_fields['_eb_category_keywords'] = 'Keywords';
	$arr_category_custom_fields['_eb_category_description'] = 'Description';
	$arr_category_custom_fields['_eb_category_google_product'] = 'Google product category';
	$arr_category_custom_fields['_eb_category_noindex'] = 'Noindex';
	$arr_category_custom_fields['_eb_category_hidden'] = 'Ẩn nhóm này';
	
	$arr_category_custom_fields['_eb_category_old_url'] = 'URL cũ (nếu có)';
	$arr_category_custom_fields['_eb_category_leech_url'] = 'URL đồng bộ';
}

// thuộc tính này luôn tồn tại cho category
$arr_category_custom_fields['_eb_category_primary'] = 'Đặt làm nhóm chính';


// Thêm trường dữ liệu cho phần category -> luôn kích hoạt
add_filter ( 'edit_category_form_fields', 'EBextra_category_fields');
add_filter ( 'edited_category', 'EBsave_extra_category_fileds');


// các trường còn lại, chỉ kích hoạt khi EchBay Seo plugin được bật
if ( cf_on_off_echbay_seo == 1 ) {
	add_filter ( 'edit_tag_form_fields', 'EBextra_category_fields');
	
	
	// Lưu dữ liệu edited_ + tên của taxonomy
	add_filter ( 'edited_post_tag', 'EBsave_extra_category_fileds');
	add_filter ( 'edited_post_options', 'EBsave_extra_category_fileds');
	//add_filter ( 'edited_blogs', 'EBsave_extra_category_fileds');
	add_filter ( 'edited_' . EB_BLOG_POST_LINK, 'EBsave_extra_category_fileds');
}



// add extra fields to category edit form callback function
function EBextra_category_fields( $tag ) {
	global $arr_category_custom_fields;
	global $eb_arr_type_custom_meta_box;
	global $eb_arr_placeholder_custom_meta_box;
	
	//
//	print_r( $tag );
//	echo 'aaaaaaaaaaaaaaa';
	
	// Lấy ID của trường
//	$cat_id = $tag->term_id;
	
	//
	foreach ( $arr_category_custom_fields as $k => $v ) {
		
		//
		$tai = isset( $eb_arr_type_custom_meta_box[ $k ] ) ? $tai = $eb_arr_type_custom_meta_box[ $k ] : 'text';
//		echo $tai;
		
		// Giá trị (nếu có)
//		$val = get_post_meta( $tag->term_id, $k, true );
		$val = _eb_get_cat_object( $tag->term_id, $k );
		$val = esc_attr( $val );
		
		//
		$hidden_class = '';
		if ( $tai == 'hidden' ) {
			$hidden_class = 'display:none';
		}
		
		//
		$other_attr = '';
		
		//
//		$other_attr .= 'placeholder="' . ( isset($eb_arr_placeholder_custom_meta_box[$k]) ? $eb_arr_placeholder_custom_meta_box[$k] : '' ) . '"';
		if ( ! isset( $eb_arr_placeholder_custom_meta_box[$k] ) ) {
			$eb_arr_placeholder_custom_meta_box[$k] = '';
		}
		/*
		else {
			$eb_arr_placeholder_custom_meta_box[$k] = '<div class="small">' . $eb_arr_placeholder_custom_meta_box[$k] . '</div>';
		}
		*/
		
		// tạo class riêng cho textarea
		$description_wrap = 'term-echbay-wrap';
		if ( $tai == 'textarea' ) {
			$description_wrap = 'term-description-wrap';
		}
		
		//
		echo '
<tr class="form-field ' . $description_wrap . '" style="' . $hidden_class . '">
	<th scope="row"><label for="' . $k . '">' . $v . '</label></th>
	<td>';
		
		//
		if ( gettype( $tai ) == 'array' ) {
			echo '<select id="' . $k . '" name="' . $k . '">';
			
			foreach ( $tai as $k2 => $v2 ) {
				$sl = '';
				if ( $k2 == $val ) {
					$sl = ' selected="selected"';
				}
				
				//
				echo '<option value="' . $k2 . '"' . $sl . '>' . $v2 . '</option>';
			}
			
			echo '</select>';
		}
		else if ( $tai == 'checkbox' ) {
			echo '<label for="' . $k . '"><input type="checkbox" name="' . $k . '" id="' . $k . '" value="' . $val . '" class="" />' . $eb_arr_placeholder_custom_meta_box[$k] . '</label>';
		}
		else if ( $tai == 'textarea' ) {
			wp_editor( html_entity_decode($val, ENT_QUOTES, 'UTF-8'), $k );
//			echo '<textarea id="' . $k . '" name="' . $k . '" ' . $other_attr . '>' .$val. '</textarea>';
		}
		else {
			echo '<input type="' . $tai . '" name="' . $k . '" id="' . $k . '" value="' . $val . '" ' . $other_attr . ' />';
		}
		
		//
		if ( $tai != 'checkbox' ) {
			echo WGR_echo_label_for_edit_form( $eb_arr_placeholder_custom_meta_box[$k] );
		}
		
		//
		echo '
	</td>
</tr>';
	}
}


// save extra category extra fields callback function
/*
https://developer.wordpress.org/reference/functions/delete_term_meta/
https://developer.wordpress.org/reference/functions/update_term_meta/
*/
function EBsave_extra_category_fileds( $term_id ) {
	global $arr_category_custom_fields;
	global $eb_arr_type_custom_meta_box;
//	global $__cf_row;
	
	// cần phải lấy cả mảng dữ liệu cũ để save vào 1 thể, nếu không sẽ bị thiếu
//	$arr_save = _eb_get_object_post_meta( $term_id, eb_cat_obj_data );
	
	// chạy vòng lặp rồi kiểm tra trong POST có tương ứng thì update
	foreach ( $arr_category_custom_fields as $k => $v ) {
		
		// lọc mã html với các input thường
		$loc_html = isset( $eb_arr_type_custom_meta_box[ $k ] ) ? $eb_arr_type_custom_meta_box[ $k ] : '';
		
		if ( isset( $_POST[ $k ] ) ){
//			echo $k . '<br>' . "\n";
			
			$val = $_POST[ $k ];
			
			// Bỏ qua với textarea
			if ( $loc_html == 'textarea_one' || $loc_html == 'textarea' ) {
			}
			// nếu là checkbox -> set giá trị là 1
			else if ( $loc_html == 'checkbox' ) {
				$val = 1;
			}
			// chỉ áp dụng nếu là input text
			else {
				$val = sanitize_text_field( $val );
			}
			
			//
			$val = trim( WGR_stripslashes( $val ) );
//			echo $val;
			
			//
			if ( $val == '' ) {
				delete_term_meta( $term_id, $k );
				
				// tạm thời sẽ xóa cả trong post meta phần này ======================================
				delete_post_meta( $term_id, $k );
			}
			else {
//				WGR_update_meta_post( $term_id, $k, $val );
				update_term_meta( $term_id, $k, $val );
				
				// tạm thời sẽ xóa cả trong post meta phần này ======================================
				delete_post_meta( $term_id, $k );
			}
			
			//
//			$arr_save[ $k ] = $val;
			
			//
//			$arr_save[ $k ] = addslashes( $val );
		}
		// thử kiểm tra với checkbox
		else if ( $loc_html == 'checkbox' ) {
			delete_term_meta( $term_id, $k );
			
			// không có -> set là 0 luôn
//			WGR_update_meta_post( $term_id, $k, 0 );
			// tạm thời sẽ xóa cả trong post meta phần này ======================================
			delete_post_meta( $term_id, $k );
		}
		
	}
//	exit();
	
	//
//	WGR_update_meta_post( $term_id, eb_cat_obj_data, $arr_save );
	
//	print_r( $arr_save ); exit();
	
}



//} // end check ON/ OFF seo module

