<div id="echbayfour-footer1">
	<div class="footer-top">
		<div class="<?php echo $__cf_row['cf_footer_class_style']; ?>">
			<div class="cf">
				<div class="lf f25 fullsize-if-mobile">
					<div class="medium18 upper">Liên hệ</div>
					<br>
					<div class="l19 footer-contact">
						<div class="upper bold"><?php echo $__cf_row['cf_ten_cty']; ?></div>
						<div><i class="fa fa-map-marker"></i> Địa chỉ: <?php echo nl2br( $__cf_row['cf_diachi'] ); ?></div>
						<div><i class="fa fa-phone"></i> Điện thoại: <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span></div>
						<div><i class="fa fa-mobile"></i> Hotline: <a href="tel:<?php echo $__cf_row['cf_hotline']; ?>" rel="nofollow"><?php echo $__cf_row['cf_hotline']; ?></a></div>
						<div><i class="fa fa-envelope"></i> Email: <a href="mailto:<?php echo $__cf_row['cf_email']; ?>"><?php echo $__cf_row['cf_email']; ?></a></div>
					</div>
					<br>
					<div class="medium18 upper">Kết nối với chúng tôi</div>
					<br>
					<?php echo WGR_get_footer_social(); ?>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space">
						<?php
						echo EBE_echbay_footer_menu(
							array(
								'menu_class' => 'footer-about-menu cf',
							),
							1,
							'<div class="medium18 upper">',
							'</div><br>'
						);
						?>
					</div>
					<br>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space">
						<?php
						echo EBE_echbay_footer_menu(
							array(
								'menu_class' => 'footer-about-menu cf',
							),
							1,
							'<div class="medium18 upper">',
							'</div><br>'
						);
						?>
					</div>
					<br>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space"><?php echo WGR_get_fb_like_box(); ?></div>
				</div>
			</div>
			<br>
		</div>
	</div>
</div>
