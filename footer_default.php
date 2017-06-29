<?php

//
$arr_tmp_footer_menu[] = _eb_echbay_menu(
	'footer-menu-01',
	array(
		'menu_class' => 'bottom-node',
	),
	1,
	'<div class="footer-title upper">'
);

$arr_tmp_footer_menu[] = _eb_echbay_menu(
	'footer-menu-02',
	array(
		'menu_class' => 'bottom-node',
	),
	1,
	'<div class="footer-title upper">'
);

$arr_tmp_footer_menu[] = _eb_echbay_menu(
	'footer-menu-03',
	array(
		'menu_class' => 'bottom-node',
	),
	1,
	'<div class="footer-title upper">'
);

$arr_tmp_footer_menu[] = _eb_echbay_menu(
	'footer-menu-04',
	array(
		'menu_class' => 'bold bottom-contact',
	),
	1,
	'<div class="footer-title upper">'
);

$arr_tmp_footer_menu[] = _eb_echbay_menu(
	'footer-menu-05',
	array(
		'menu_class' => 'bottom-nav'
	),
	1,
	'<div class="medium18 bold upper">'
);

?>
<footer id="footer">
	<div class="bottom-slogan">
		<div class="<?php echo $__cf_row['cf_blog_class_style']; ?>">
			<ul data-width="240" class="fix-li-wit cf l19 bold upper">
				<li>
					<div><i class="fa fa-refresh"></i> Đổi hàng<br />
						trong 7 ngày</div>
				</li>
				<li>
					<div><i class="fa fa-truck"></i> Giao hàng miễn phí<br />
						Toàn Quốc</div>
				</li>
				<li>
					<div><i class="fa fa-dollar"></i> Thanh toán<br />
						khi giao hàng</div>
				</li>
				<li>
					<div><i class="fa fa-check-square"></i> Bảo hành VIP<br />
						12 tháng</div>
				</li>
			</ul>
		</div>
	</div>
	<div class="site-footer-inner default-2bg">
		<div class="<?php echo $__cf_row['cf_blog_class_style']; ?>">
			<div class="cf">
				<div class="lf f25 fullsize-if-mobile">
					<div class="footer-title upper"><?php echo $__cf_row['cf_ten_cty']; ?></div>
					<div class="l19"><i class="fa fa-location-arrow orgcolor"></i> <?php echo nl2br( $__cf_row['cf_diachi'] ); ?><br>
						<i class="fa fa-phone orgcolor"></i> <?php echo $__cf_row['cf_call_hotline']; ?> - <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span><br>
						<i class="fa fa-envelope-o orgcolor"></i> <a href="mailto:<?php echo $__cf_row['cf_email']; ?>" rel="nofollow" target="_blank"><?php echo $__cf_row['cf_email']; ?></a><br>
					</div>
					<br>
					<div><?php echo $arr_tmp_footer_menu[3]; ?></div>
					<hr class="orgborder one-line" />
					<div><i class="fa fa-star greencolor l25"></i> Kết nối với chúng tôi</div>
					<ul class="footer-social text-center cf">
						<li class="footer-social-fb"><a href="javascript:;" class="ahref-to-facebook" target="_blank" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
						<li class="footer-social-tw"><a href="javascript:;" class="each-to-twitter-page" target="_blank" rel="nofollow"><i class="fa fa-twitter"></i></a></li>
						<li class="footer-social-yt"><a href="javascript:;" class="each-to-youtube-chanel" target="_blank" rel="nofollow"><i class="fa fa-youtube"></i></a></li>
						<li class="footer-social-gg"><a href="javascript:;" class="ahref-to-gooplus" target="_blank" rel="nofollow"><i class="fa fa-google-plus"></i></a></li>
					</ul>
					<br>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space"><?php echo $arr_tmp_footer_menu[0]; ?></div>
					<br>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space"><?php echo $arr_tmp_footer_menu[1]; ?></div>
					<br>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space"><?php echo $arr_tmp_footer_menu[2]; ?></div>
					<br>
				</div>
			</div>
		</div>
	</div>
	<div class="footer-site-info text-center">Bản quyền &copy; <?php echo $year_curent; ?> <span><?php echo $web_name; ?></span> - Toàn bộ phiên bản. <?php echo $str_fpr_license_echbay; ?></div>
</footer>
