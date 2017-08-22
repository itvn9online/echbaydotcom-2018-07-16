<div id="webgiare-footer2" class="default-2bg">
	<div class="<?php echo $__cf_row['cf_footer_class_style']; ?> cf footer-bottom">
		<div class="lf f75 fullsize-if-mobile">
			<div>
				<?php
				echo EBE_echbay_footer_menu(
					array(
						'menu_class' => 'global-footer-company cf',
					)
				);
				?>
			</div>
			<div class="footer-coppyright">&copy;<?php echo $year_curent; ?> <span class="upper bold"> <?php echo web_name; ?> </span> - Toàn bộ phiên bản. <?php echo $str_fpr_license_echbay; ?></div>
			<br>
		</div>
		<div class="lf f25 cf fullsize-if-mobile"><?php echo WGR_get_footer_social(); ?></div>
	</div>
</div>
