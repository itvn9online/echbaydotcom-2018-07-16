<?php
/*
Description: Breadcrumb cho website, sử dụng thiết kế bo khung hình theo cài đặt của phần TOP.
Tags: breadcrumb
*/
?>

<div id="breadcrumb-top1">
	<div class="<?php echo $__cf_row['cf_top_class_style']; ?>">
		<div class="thread-details-tohome">
			<ul class="cf">
				<li><a href="./" rel="nofollow"><i class="fa fa-home"></i> <?php echo EBE_get_lang('home'); ?></a></li>
				<?php echo $group_go_to; ?>
			</ul>
		</div>
	</div>
</div>
