<?php
/*
Description: Sidebar tạo content cho trang chủ (main mặc định), có giới hạn chiều rộng theo chiều rộng chung trong cấu hình website.
*/
?>

<div id="container" class="<?php echo $__cf_row['cf_blog_class_style']; ?>">
	<section id="main-content">
		<div id="main" style="min-height:250px;">
			<div id="rME"><?php echo $main_content; ?></div>
		</div>
	</section>
	<section id="sidebar"></section>
</div>
