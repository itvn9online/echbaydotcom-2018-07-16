<?php
/*
Description: Breadcrumb cho website, thiết kế bo gọn theo kích thước của TOP trong mục Cài đặt giao diện.
*/
?>

<div id="breadcrumb2-top1">
	<div class="<?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="thread-details-tohome">
			<ul class="cf">
				<li><a href="./"><i class="fa fa-home"></i> <?php echo EBE_get_lang('home'); ?></a></li>
				<?php echo $group_go_to; ?>
			</ul>
		</div>
	</div>
</div>
