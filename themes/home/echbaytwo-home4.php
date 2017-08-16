<?php
/*
Description: Thêm dữ liệu theo chuẩn của SEO Quake.
Tags: home by seo quake
*/


// lấy tiêu đề chính làm thẻ H1
echo'<h1 class="home_default-title text-center">' . $__cf_row ['cf_title'] . '</h1>';

// lấy các danh mục cấp 2 làm thẻ H2
echo EBE_echbay_category_menu( 'category', 0, 'home_default-catgory text-center', 0, 'h2' );



