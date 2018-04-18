<article class="amp-wp-article">
	<footer class="amp-wp-article-footer">
		<div class="amp-wp-meta amp-wp-tax-category"><a href="<?php echo web_link; ?>"><?php echo EBE_get_lang('home'); ?></a> <?php echo $amp_str_go_to; ?> </div>
	</footer>
</article>
<footer class="amp-wp-footer">
	<div>
		<p>&copy; <?php echo EBE_get_lang('amp_copyright'); ?> <?php echo $year_curent; ?> <?php echo web_name; ?>. <?php echo EBE_get_lang('amp_all_rights'); ?> - <a href="https://echbay.com/" target="_blank" rel="nofollow">AMP by EchBay</a></p>
		<p class="back-to-top"> <a href="#development=1"><?php echo EBE_get_lang('amp_development'); ?></a> | <a href="#top"><?php echo EBE_get_lang('amp_to_top'); ?></a></p>
	</div>
</footer>
<div class="amp-wp-comments-link"><a href="<?php echo $url_og_url; ?>"><?php echo EBE_get_lang('amp_full_version'); ?></a></div>
<br>
<?php
if ( $__cf_row['cf_ga_id'] != '' ) {
?>
<amp-analytics type="googleanalytics"> 
	<script type="application/json">
{
	"vars": {
		"account": "<?php echo $__cf_row['cf_ga_id']; ?>"
	},
	"triggers": {
		"trackPageview": {
			"on": "visible",
			"request": "pageview"
		}
	}
}
</script> 
</amp-analytics>
<?php
}

