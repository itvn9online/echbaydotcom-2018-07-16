<?php
/*
Description: Breadcrumb cho website, sử dụng thiết kế tràn khung, tràn màn hình (không giới hạn chiều rộng).
*/
?>

<div id="breadcrumb-top1">
	<div class="thread-details-tohome">
		<div class="<?php echo $__cf_row['cf_top_class_style']; ?>">
			<ul class="cf">
				<li><a href="./"><i class="fa fa-home"></i> <?php echo EBE_get_lang('home'); ?></a></li>
				<?php echo $group_go_to; ?>
			</ul>
		</div>
	</div>
</div>
