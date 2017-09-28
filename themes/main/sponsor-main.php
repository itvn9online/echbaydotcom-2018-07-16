<?php
/*
Description: Sidebar tạo content cho trang chủ, đính kèm module Tạo danh sách logo đối tác theo dạng slider ở chân trang, dùng cho các website muốn lật slider này lên đầu tiên ở trang chủ.
Tags: echbaytwo, home sidebar, main sidebar
*/
?>

<div id="container">
	<section id="main-content">
		<div id="main" style="min-height:250px;">
			<div id="rME"><?php echo $main_content; ?></div>
		</div>
		<?php
		include EB_THEME_PLUGIN_INDEX . 'themes/home/echbaytwo-home6.php';
		?>
	</section>
	<section id="sidebar"></section>
</div>
