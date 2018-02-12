<?php



/*
* Các đoạn HTML thường dùng
*/
function EBE_get_html_logo ( $set_h1 = 0 ) {
	global $__cf_row;
	
	// v2 -> custom height
	$logo_tag = 'div';
	if ( $set_h1 == 1 && $__cf_row['cf_h1_logo'] == 1 ) {
		global $act;
		
		if ( $act == '' ) {
			$logo_tag = 'h1';
		}
	}
	
	//
	return '<' . $logo_tag . '><a href="./" class="web-logo d-block" style="background-image:url(' . $__cf_row['cf_logo'] . ');">&nbsp;</a></' . $logo_tag . '>';
	
	// v1 -> auto set height
//	return '<div><a data-size="' . $__cf_row['cf_size_logo'] . '" href="./" class="web-logo ti-le-global d-block" style="background-image:url(' . $__cf_row['cf_logo'] . ');">&nbsp;</a></div>';
}

function EBE_get_html_search ( $class_for_search = 'div-search-margin' ) {
	global $current_search_key;
	
	/*
	* class_for_search: tạo class riêng với 1 số trường hợp
	*/
	
	return '
<div class="' . $class_for_search . '">
	<div class="div-search">
		<form role="search" method="get" action="' . web_link . '">
			<input type="search" placeholder="' . EBE_get_lang('searchp') . '" value="' . $current_search_key . '" name="s" aria-required="true" required>
			<input type="hidden" name="post_type" value="post" />
			<button type="submit" class="default-bg"><i class="fa fa-search"></i><span class="d-none">' . EBE_get_lang('search') . '</span></button>
			<span data-active="' . $class_for_search . '" class="span-search-icon cur"><i class="fa fa-search"></i></span>
		</form>
	</div>
	<div id="oiSearchAjax"></div>
</div>';
}

function EBE_get_html_cart ( $icon_only = 0 ) {
	$a = EBE_get_lang('cart');
	
	$text = '';
	if ( $icon_only == 0 ) {
		$text = $a;
	}
	
	return '<div class="btn-to-cart cf"><a title="' . $a . '" href="' . web_link . 'cart" rel="nofollow"><i class="fa fa-shopping-cart"></i> <span>' . $text . '</span> <em class="show_count_cart d-none">0</em></a></div>';
}

function EBE_get_html_profile () {
	return '<div class="oi_member_func">.</div>';
}

function EBE_get_html_address () {
	global $__cf_row;
	
	return '
	<div class="footer-address">
		<div class="footer-address-company bold">' . $__cf_row['cf_ten_cty'] . '</div>
		<div class="footer-address-info l19">
			<div class="footer-address-address"><strong>Địa chỉ:</strong> <i class="fa fa-map-marker"></i> ' . nl2br( $__cf_row['cf_diachi'] ) . '</div>
			<div class="footer-address-phone">
				<div class="footer-address-hotline"><strong>Hotline:</strong> <i class="fa fa-phone"></i> <span class="phone-numbers-inline">' . $__cf_row['cf_call_hotline'] . '</span></div>
				<div class="footer-address-cell"><strong>Điện thoại:</strong> <span class="phone-numbers-inline">' . $__cf_row['cf_call_dienthoai'] . '</span></div>
			</div>
			<div class="footer-address-email"><strong>Email:</strong> <i class="fa fa-envelope-o"></i> <a href="mailto:' . $__cf_row['cf_email'] . '" rel="nofollow" target="_blank">' . $__cf_row['cf_email'] . '</a></div>
		</div>
	</div>';
}

function WGR_get_bigbanner () {
	global $str_big_banner;
	
	//
	if ( $str_big_banner == '' ) {
		return '<!-- HTML for big banner-->';
	}
	
	//
//	return '<div class="oi_big_banner">' . $str_big_banner . '</div>';
	return $str_big_banner;
}

function WGR_get_footer_social () {
	global $__cf_row;
	
	$str = '';
	
	if ( $__cf_row['cf_facebook_page'] != '' ) {
		$str .= ' <li class="footer-social-fb"><a href="javascript:;" class="ahref-to-facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i> <span>Facebook</span></a></li>';
	}
	
	if ( $__cf_row['cf_instagram_page'] != '' ) {
		$str .= ' <li class="footer-social-it"><a href="javascript:;" class="ahref-to-instagram" target="_blank" rel="nofollow"><i class="fa fa-instagram"></i> <span>Instagram</span></a></li>';
	}
	
	if ( $__cf_row['cf_twitter_page'] != '' ) {
		$str .= ' <li class="footer-social-tw"><a href="javascript:;" class="each-to-twitter-page" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i> <span>Twitter</span></a></li>';
	}
	
	if ( $__cf_row['cf_youtube_chanel'] != '' ) {
		$str .= ' <li class="footer-social-yt"><a href="javascript:;" class="each-to-youtube-chanel" target="_blank" rel="nofollow"><i class="fa fa-youtube"></i> <span>Youtube</span></a></li>';
	}
	
	if ( $__cf_row['cf_google_plus'] != '' ) {
		$str .= ' <li class="footer-social-gg"><a href="javascript:;" class="ahref-to-gooplus" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i> <span>Google+</span></a></li>';
	}
	
	//
	return '<ul class="footer-social text-center cf">' . $str . '</ul>';
}

function WGR_get_fb_like_box () {
	return '
	<div class="each-to-facebook">
		<div class="fb-page" data-small-header="false" data-hide-cover="false" data-show-facepile="true"></div>
	</div>';
}

function WGR_get_quick_register () {
	return '
	<div class="hpsbnlbx">
		<form name="frm_dk_nhantin" method="post" action="process/?set_module=quick-register" target="target_eb_iframe">
			<div class="cf">
				<div class="quick-register-left quick-register-hoten"><span class="d-none">Họ tên</span>
					<input type="text" name="t_hoten" value="" placeholder="Họ tên" />
				</div>
				<div class="quick-register-left quick-register-phone d-none"><span class="d-none">Điện thoại</span>
					<input type="text" name="t_dienthoai" value="" placeholder="Điện thoại" />
				</div>
				<div class="quick-register-left quick-register-email"><span class="d-none">Email</span>
					<input type="email" name="t_email" value="" placeholder="Email" autocomplete="off" aria-required="true" required />
				</div>
				<div class="quick-register-left quick-register-submit">
					<button type="submit" class="cur">Gửi</button>
				</div>
			</div>
		</form>
	</div>';
}



