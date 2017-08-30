<?php
if ( $str_big_banner != '' ) :
?>
<!-- Riêng ở trang chủ -> cho hiển thị menu ra -->
<style>
#dumbo-top3 .all-category-cats { display: block; }
</style>
<div id="dumbo-top4">
	<div class="<?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="dumbo-top4 cf">
			<div class="lf f25">&nbsp;</div>
			<div class="lf f75">
				<div class="left-menu-space"><?php echo WGR_get_bigbanner(); ?></div>
			</div>
		</div>
	</div>
</div>
<?php
endif;
?>
