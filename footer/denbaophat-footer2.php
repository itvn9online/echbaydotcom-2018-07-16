<div id="denbaophat-footer2">
	<div class="bottom-support">
		<div class="titleCSS text-center upper bold"><?php echo $__cf_row['cf_ten_cty']; ?></div>
		<br>
		<div class="cf <?php echo $__cf_row['cf_footer_class_style']; ?>">
			<div class="lf f25 fullsize-if-mobile">
				<div>
					<?php
					echo EBE_echbay_footer_menu(
						array(
							'menu_class' => 'ls-bottom-support',
						),
						1,
						'<div class="titleCSS bold">'
					);
					?>
				</div>
				<div>
					<?php
					echo EBE_echbay_footer_menu(
						array(
							'menu_class' => 'ls-bottom-support',
						),
						1,
						'<div class="titleCSS bold">'
					);
					?>
				</div>
			</div>
			<div class="lf f25 fullsize-if-mobile">
				<div class="titleCSS bold">Kết nối với chúng tôi</div>
				<ul class="footer-social cf">
					<li><a href="javascript:;" class="ahref-to-facebook fa fa-facebook" target="_blank" rel="nofollow">&nbsp;</a></li>
					<li><a href="javascript:;" class="each-to-twitter-page fa fa-twitter" target="_blank" rel="nofollow">&nbsp;</a></li>
					<li><a href="javascript:;" class="each-to-youtube-chanel fa fa-youtube" target="_blank" rel="nofollow">&nbsp;</a></li>
					<li><a href="javascript:;" class="ahref-to-gooplus fa fa-google-plus" target="_blank" rel="nofollow">&nbsp;</a></li>
				</ul>
				<br>
				<div class="right-menu-space">
					<div class="each-to-facebook" style="background:#fff;">
						<div class="fb-like-box" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
					</div>
				</div>
			</div>
			<div class="lf f25 fullsize-if-mobile">
				<div class="right-menu-space">
					<div class="titleCSS bold">Sản phẩm yêu thích</div>
					<h4 class="clone-gorup-list l19"><?php echo EBE_echbay_footer_menu(); ?></h4>
				</div>
			</div>
			<div class="lf f25 fullsize-if-mobile">
				<div class="titleCSS bold">Liên hệ với chúng tôi</div>
				<div class="bottom-contact">
					<ul>
						<li><i class="fa fa-map-marker"></i> <?php echo nl2br( $__cf_row['cf_diachi'] ); ?></li>
						<li><i class="fa fa-phone"></i> <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span></li>
						<li><i class="fa fa-envelope-o"></i> <a href="mailto:<?php echo $__cf_row['cf_email']; ?>" rel="nofollow" target="_blank"><?php echo $__cf_row['cf_email']; ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
