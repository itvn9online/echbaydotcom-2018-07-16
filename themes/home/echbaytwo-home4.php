<?php
/*
Description: Thêm dữ liệu bổ sung theo chuẩn của SEO Quake, bao gồm tiêu đề của website và danh mục sản phẩm được đặt trong thẻ H2.
Tags: home for seo quake
*/


// lấy tiêu đề chính làm thẻ H1
echo '<h1 class="home_default-title text-center">' . $__cf_row ['cf_title'] . '</h1>';

// lấy các danh mục cấp 2 làm thẻ H2
echo EBE_echbay_category_menu( 'category', 0, 'home_default-catgory text-center', 0, 'h2' );



