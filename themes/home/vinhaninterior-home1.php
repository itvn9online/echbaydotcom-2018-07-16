<?php
$str_vinhaninterior_home1 = '
<div class="cf">
	<div class="lf f50 fullsize-if-mobile">
		<div class="right-menu-space l20 medium">
			<div>{tmp.trv_gioithieu}</div>
			<br>
		</div>
	</div>
	<div class="lf f50 fullsize-if-mobile global-a-posi">
		<div class="img-max-width">
			<iframe width="500" height="281" src="{tmp.youtube_url}" frameborder="0" allowfullscreen=""></iframe>
		</div>
	</div>
</div>';
?>

<div id="vinhaninterior-home1">
	<div class="<?php echo $__cf_row['cf_blog_class_style']; ?>">
		<div class="vinhaninterior-home1">
			<h1 class="home_default-title text-center"><?php echo $__cf_row ['cf_title']; ?></h1>
			<div style="text-align: justify;"><?php echo _eb_load_ads( 11, 1, '', array(), 0, $str_vinhaninterior_home1 ); ?></div>
		</div>
	</div>
</div>
