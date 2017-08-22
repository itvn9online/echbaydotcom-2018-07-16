<div id="echbaytwo-footer2">
	<div class="site-footer-inner">
		<div class="<?php echo $__cf_row['cf_footer_class_style']; ?>">
			<div class="cf">
				<div class="lf f25 fullsize-if-mobile">
					<div class="footer-title upper"><?php echo $__cf_row['cf_ten_cty']; ?></div>
					<div class="l19"><i class="fa fa-location-arrow orgcolor"></i> <?php echo nl2br( $__cf_row['cf_diachi'] ); ?><br>
						<i class="fa fa-phone orgcolor"></i> <?php echo $__cf_row['cf_call_hotline']; ?> - <span class="phone-numbers-inline"><?php echo $__cf_row['cf_call_dienthoai']; ?></span><br>
						<i class="fa fa-envelope-o orgcolor"></i> <a href="mailto:<?php echo $__cf_row['cf_email']; ?>" rel="nofollow" target="_blank"><?php echo $__cf_row['cf_email']; ?></a><br>
					</div>
					<br>
					<div>
						<?php
						echo EBE_echbay_footer_menu(
							array(
								'menu_class' => 'bold bottom-contact',
							),
							1,
							'<div class="footer-title upper">'
						);
						?>
					</div>
					<hr class="orgborder one-line" />
					<div><i class="fa fa-star greencolor l25"></i> <?php echo EBE_get_lang('joinus'); ?></div>
					<?php echo WGR_get_footer_social(); ?><br>
				</div>
				<div class="lf f25 fullsize-if-mobile">
					<div class="left-menu-space">
						<?php
						echo EBE_echbay_footer_menu(
							array(
								'menu_class' => 'bottom-node',
							),
							1,
							'<div class="footer-title upper">'
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
								'menu_class' => 'bottom-node',
							),
							1,
							'<div class="footer-title upper">'
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
								'menu_class' => 'bottom-node',
							),
							1,
							'<div class="footer-title upper">'
						);
						?>
					</div>
					<br>
				</div>
			</div>
		</div>
	</div>
</div>
