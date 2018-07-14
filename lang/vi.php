<?php


//
$___eb_lang = array();

// định dạng kiểu dữ liệu
$eb_type_lang = array();

// ghi chú
$eb_note_lang = array();

// URL file gốc từ github (nếu có)
$eb_ex_from_github = array();

// class CSS riêng (nếu có)
$eb_class_css_lang = array();

//
define( 'eb_key_for_site_lang', 'lang_eb_' );


//
$___eb_lang[eb_key_for_site_lang . 'home'] = 'Trang chủ';
$___eb_lang[eb_key_for_site_lang . 'widget_products_more'] = 'Xem thêm <span>&raquo;</span>';

//
$___eb_lang[eb_key_for_site_lang . 'search'] = 'Tìm kiếm';
// placeholder for search
$___eb_lang[eb_key_for_site_lang . 'searchp'] = $___eb_lang[eb_key_for_site_lang . 'search'] . ' sản phẩm';
$___eb_lang[eb_key_for_site_lang . 'search_not_found'] = 'Dữ liệu bạn đang tìm kiếm không tồn tại hoặc đã bị xóa!';
// nếu phần mã này xuất hiện -> hiển thị mã này thay vì search_not_found ở trên -> ví dụ mã của trang tìm kiếm tùy chỉnh của google, mã tìm kiếm tự viết cho các site khác
$___eb_lang[eb_key_for_site_lang . 'search_addon'] = '';
$eb_type_lang[eb_key_for_site_lang . 'search_addon'] = 'textarea';
//$___eb_lang[eb_key_for_site_lang . 'search_title_addon'] = '';

$___eb_lang[eb_key_for_site_lang . 'cart'] = 'Giỏ hàng';
$___eb_lang[eb_key_for_site_lang . 'shopping_cart'] = $___eb_lang[eb_key_for_site_lang . 'cart'];
$___eb_lang[eb_key_for_site_lang . 'lienhe'] = 'Liên hệ';
$___eb_lang[eb_key_for_site_lang . 'muangay'] = 'Mua ngay';

$___eb_lang[eb_key_for_site_lang . 'taikhoan'] = 'Tài khoản';
$___eb_lang[eb_key_for_site_lang . 'thoat'] = 'Thoát';
$___eb_lang[eb_key_for_site_lang . 'xacnhan_thoat'] = 'Xác nhận đăng xuất khỏi hệ thống';
$___eb_lang[eb_key_for_site_lang . 'dangnhap'] = 'Đăng nhập';
$___eb_lang[eb_key_for_site_lang . 'dangky'] = 'Đăng ký';

//
$___eb_lang[eb_key_for_site_lang . 'home_hot'] = '<i class="fa fa-dollar"></i> Sản phẩm HOT';
$___eb_lang[eb_key_for_site_lang . 'home_new'] = '<i class="fa fa-star"></i> Sản phẩm MỚI';

$___eb_lang[eb_key_for_site_lang . 'order_by'] = 'Sắp xếp theo';
$___eb_lang[eb_key_for_site_lang . 'order_view'] = 'Xem nhiều';
$___eb_lang[eb_key_for_site_lang . 'order_price_down'] = 'Giá giảm dần';
$___eb_lang[eb_key_for_site_lang . 'order_price_up'] = 'Giá tăng dần';
$___eb_lang[eb_key_for_site_lang . 'order_az'] = 'Tên sản phẩm ( từ A đến Z )';
$___eb_lang[eb_key_for_site_lang . 'order_za'] = 'Tên sản phẩm ( từ Z đến A )';

//
$___eb_lang[eb_key_for_site_lang . 'post_giacu'] = 'Giá cũ';
$___eb_lang[eb_key_for_site_lang . 'post_giamgia'] = 'Giảm<br>giá';
$___eb_lang[eb_key_for_site_lang . 'post_giamoi'] = 'Giá mới';
$___eb_lang[eb_key_for_site_lang . 'post_zero'] = '<em>Liên hệ</em>';
$___eb_lang[eb_key_for_site_lang . 'post_luotmua'] = 'Lượt mua';
$___eb_lang[eb_key_for_site_lang . 'post_soluong'] = 'Số lượng';
$___eb_lang[eb_key_for_site_lang . 'post_time_discount'] = 'Thời gian khuyến mại còn lại:';
$___eb_lang[eb_key_for_site_lang . 'post_time_soldout'] = 'Sản phẩm tạm thời ngừng bán';
$___eb_lang[eb_key_for_site_lang . 'post_comment'] = 'Bình luận';
$___eb_lang[eb_key_for_site_lang . 'post_content'] = 'Thông tin sản phẩm';
$___eb_lang[eb_key_for_site_lang . 'post_other'] = 'Sản phẩm khác';
$___eb_lang[eb_key_for_site_lang . 'post_sku'] = 'Mã sản phẩm';
$___eb_lang[eb_key_for_site_lang . 'post_stock'] = 'Tình trạng';
$___eb_lang[eb_key_for_site_lang . 'post_instock'] = 'Sẵn hàng';
$___eb_lang[eb_key_for_site_lang . 'post_outstock'] = 'Hết hàng';

//
$___eb_lang[eb_key_for_site_lang . 'thread_list_mua'] = '<i class="fa fa-shopping-cart"></i> Mua ngay';
$___eb_lang[eb_key_for_site_lang . 'thread_list_more'] = '<i class="fa fa-eye"></i> Xem';

//
$___eb_lang[eb_key_for_site_lang . 'cart_diachi'] = 'Địa chỉ';
$___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'] = 'Điện thoại';
$___eb_lang[eb_key_for_site_lang . 'cart_pla_dienthoai'] = $___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'];
$___eb_lang[eb_key_for_site_lang . 'cart_hotline'] = 'Hotline';

// giờ vàng
$___eb_lang[eb_key_for_site_lang . 'golden_time'] = 'Giờ vàng';
$___eb_lang[eb_key_for_site_lang . 'golden_desc_time'] = 'Giờ vàng GIÁ SỐC, khuyến mại tận GỐC';
$___eb_lang[eb_key_for_site_lang . 'limit_golden_time'] = 50;
$eb_type_lang[eb_key_for_site_lang . 'limit_golden_time'] = 'number';

//
$___eb_lang[eb_key_for_site_lang . 'favorite'] = 'Sản phẩm yêu thích';
$___eb_lang[eb_key_for_site_lang . 'limit_favorite'] = 50;
$eb_type_lang[eb_key_for_site_lang . 'limit_favorite'] = 'number';

// default status
$___eb_lang[eb_key_for_site_lang . 'ads_status1'] = 'Banner chính ( 1366 x Auto )';
$___eb_lang[eb_key_for_site_lang . 'ads_status2'] = 'Chờ sử dụng';
$___eb_lang[eb_key_for_site_lang . 'ads_status3'] = $___eb_lang[eb_key_for_site_lang . 'ads_status2'];
$___eb_lang[eb_key_for_site_lang . 'ads_status4'] = 'Review của khách hàng';
$___eb_lang[eb_key_for_site_lang . 'ads_status5'] = 'Banner/ Logo đối tác ( chân trang )';
$___eb_lang[eb_key_for_site_lang . 'ads_status6'] = 'Video HOT (trang chủ)';
$___eb_lang[eb_key_for_site_lang . 'ads_status7'] = 'Bộ sưu tập/ Banner nổi bật (trang chủ)';
$___eb_lang[eb_key_for_site_lang . 'ads_status8'] = 'Địa chỉ/ Bản đồ (chân trang/ liên hệ)';
$___eb_lang[eb_key_for_site_lang . 'ads_status9'] = 'Banner chuyên mục ở trang chủ';
$___eb_lang[eb_key_for_site_lang . 'ads_status10'] = 'Slide ảnh theo phân nhóm (trang chi tiết)';
$___eb_lang[eb_key_for_site_lang . 'ads_status11'] = 'Noname';
$___eb_lang[eb_key_for_site_lang . 'ads_status12'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'ads_status13'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'ads_status14'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'ads_status15'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];

$___eb_lang[eb_key_for_site_lang . 'product_status0'] = 'Mặc định';
$___eb_lang[eb_key_for_site_lang . 'product_status1'] = 'Sản phẩm HOT';
$___eb_lang[eb_key_for_site_lang . 'product_status2'] = 'Sản phẩm MỚI';
$___eb_lang[eb_key_for_site_lang . 'product_status3'] = 'Sản phẩm BÁN CHẠY';
$___eb_lang[eb_key_for_site_lang . 'product_status4'] = 'Sản phẩm GIẢM GIÁ';
$___eb_lang[eb_key_for_site_lang . 'product_status5'] = 'Sản phẩm KHÁC';
$___eb_lang[eb_key_for_site_lang . 'product_status6'] = $___eb_lang[eb_key_for_site_lang . 'golden_time'];
$___eb_lang[eb_key_for_site_lang . 'product_status7'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'product_status8'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'product_status9'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];
$___eb_lang[eb_key_for_site_lang . 'product_status10'] = $___eb_lang[eb_key_for_site_lang . 'ads_status11'];


// details
$___eb_lang[eb_key_for_site_lang . 'chitietsp'] = 'Chi tiết Sản phẩm';
$___eb_lang[eb_key_for_site_lang . 'tuongtu'] = 'Sản phẩm tương tự';

// footer
$___eb_lang[eb_key_for_site_lang . 'copyright'] = 'Bản quyền';
$___eb_lang[eb_key_for_site_lang . 'allrights'] = ' - Toàn bộ phiên bản.';
$___eb_lang[eb_key_for_site_lang . 'joinus'] = 'Kết nối với chúng tôi';
$___eb_lang[eb_key_for_site_lang . 'diachi'] = $___eb_lang[eb_key_for_site_lang . 'cart_diachi'] . ':';
$___eb_lang[eb_key_for_site_lang . 'dienthoai'] = $___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'] . ':';
$___eb_lang[eb_key_for_site_lang . 'poweredby'] = 'Cung cấp bởi';

// echbay two footer sologan
$___eb_lang[eb_key_for_site_lang . 'ebslogan1'] = '<i class="fa fa-refresh"></i> Đổi hàng<br />trong 7 ngày';
$___eb_lang[eb_key_for_site_lang . 'ebslogan2'] = '<i class="fa fa-truck"></i> Giao hàng miễn phí<br />Toàn Quốc';
$___eb_lang[eb_key_for_site_lang . 'ebslogan3'] = '<i class="fa fa-dollar"></i> Thanh toán<br />khi giao hàng';
$___eb_lang[eb_key_for_site_lang . 'ebslogan4'] = '<i class="fa fa-check-square"></i> Bảo hành VIP<br />12 tháng';

// quick cart
$___eb_lang[eb_key_for_site_lang . 'cart_muangay'] = $___eb_lang[eb_key_for_site_lang . 'muangay'];
$___eb_lang[eb_key_for_site_lang . 'cart_mausac'] = 'Màu sắc';
$___eb_lang[eb_key_for_site_lang . 'cart_kichco'] = 'Kích cỡ';
$___eb_lang[eb_key_for_site_lang . 'cart_soluong'] = $___eb_lang[eb_key_for_site_lang . 'post_soluong'];
$___eb_lang[eb_key_for_site_lang . 'cart_thanhtien'] = 'Thành tiền';
$___eb_lang[eb_key_for_site_lang . 'cart_hoten'] = 'Họ và tên';
$___eb_lang[eb_key_for_site_lang . 'cart_diachi2'] = 'Địa chỉ nhận hàng. Vui lòng nhập chính xác! trong trường hợp vận chuyển.';
$___eb_lang[eb_key_for_site_lang . 'cart_ghichu'] = 'Ghi chú';
$___eb_lang[eb_key_for_site_lang . 'cart_vidu'] = 'Ví dụ: Giao hàng trong giờ hành chính, gọi điện trước khi giao...';
$___eb_lang[eb_key_for_site_lang . 'cart_gui'] = '<i class="fa fa-shopping-cart"></i> Gửi đơn hàng';
$___eb_lang[eb_key_for_site_lang . 'cart_them'] = 'Cho vào giỏ hàng';
$___eb_lang[eb_key_for_site_lang . 'cart_emailformat'] = 'Email không đúng định dạng';
$___eb_lang[eb_key_for_site_lang . 'billing_custom_style'] = '/* Thêm custom CSS cho trang in đơn hàng */';

// contact
$___eb_lang[eb_key_for_site_lang . 'lh_lienhe'] = 'Liên hệ với chúng tôi';
$___eb_lang[eb_key_for_site_lang . 'lh_luuy'] = 'Để liên hệ với chúng tôi, bạn có thể gửi email tới <a href="mailto:{tmp.cf_email}" rel="nofollow">{tmp.cf_email}</a>, sử dụng phom liên hệ phía dưới hoặc liên hệ trực tiếp theo địa chỉ và số điện thoại chúng tôi cung cấp.';
$___eb_lang[eb_key_for_site_lang . 'lh_hoten'] = $___eb_lang[eb_key_for_site_lang . 'cart_hoten'];
$___eb_lang[eb_key_for_site_lang . 'lh_diachi'] = $___eb_lang[eb_key_for_site_lang . 'cart_diachi'];
$___eb_lang[eb_key_for_site_lang . 'lh_dienthoai'] = $___eb_lang[eb_key_for_site_lang . 'cart_dienthoai'];
$___eb_lang[eb_key_for_site_lang . 'lh_noidung'] = 'Nội dung';
$___eb_lang[eb_key_for_site_lang . 'lh_submit'] = 'Gửi liên hệ';
$___eb_lang[eb_key_for_site_lang . 'lh_note'] = 'là các trường bắt buộc phải điền.<br>Vui lòng cung đầy đủ thông tin để quá trình trao đổi được diễn ra thuận lợi hơn.';
$___eb_lang[eb_key_for_site_lang . 'lh_done'] = 'Cảm ơn bạn! thông tin của bạn đã được gửi đi, chúng tôi sẽ phản hồi sớm nhất có thể.';


// register
$___eb_lang[eb_key_for_site_lang . 'reg_no_email'] = 'Dữ liệu đầu vào không chính xác';
$___eb_lang[eb_key_for_site_lang . 'reg_pass_short'] = 'Mật khẩu tối thiểu phải có 6 ký tự';
$___eb_lang[eb_key_for_site_lang . 'reg_pass_too'] = 'Mật khẩu xác nhận không chính xác';
$___eb_lang[eb_key_for_site_lang . 'reg_email_format'] = 'Email không đúng định dạng';
$___eb_lang[eb_key_for_site_lang . 'reg_thanks'] = 'Cảm ơn bạn đã đăng ký nhận tin!';
$___eb_lang[eb_key_for_site_lang . 'reg_email_exist'] = 'Email đã được sử dụng';
$___eb_lang[eb_key_for_site_lang . 'reg_done'] = 'Đăng ký nhận bản tin thành công';
$___eb_lang[eb_key_for_site_lang . 'reg_error'] = 'Lỗi chưa xác định!';

// quick register
$___eb_lang[eb_key_for_site_lang . 'qreg_name'] = 'Họ tên';
$___eb_lang[eb_key_for_site_lang . 'qreg_phone'] = 'Điện thoại';
$___eb_lang[eb_key_for_site_lang . 'qreg_email'] = 'Email';
$___eb_lang[eb_key_for_site_lang . 'qreg_submit'] = 'Gửi';

// profile
$___eb_lang[eb_key_for_site_lang . 'pr_tonquan'] = 'Tổng quan về tài khoản';
$___eb_lang[eb_key_for_site_lang . 'pr_email'] = 'E-mail';
$___eb_lang[eb_key_for_site_lang . 'pr_id'] = 'Mã tài khoản';
$___eb_lang[eb_key_for_site_lang . 'pr_matkhau'] = 'Mật khẩu';
$___eb_lang[eb_key_for_site_lang . 'pr_doimatkhau'] = 'Thay đổi mật khẩu';
$___eb_lang[eb_key_for_site_lang . 'pr_hoten'] = 'Họ và tên';
$___eb_lang[eb_key_for_site_lang . 'pr_dienthoai'] = 'Điện thoại';
$___eb_lang[eb_key_for_site_lang . 'pr_diachi'] = 'Địa chỉ';
$___eb_lang[eb_key_for_site_lang . 'pr_ngaydangky'] = 'Ngày đăng ký';
$___eb_lang[eb_key_for_site_lang . 'pr_capnhat'] = 'Cập nhật';
$___eb_lang[eb_key_for_site_lang . 'pr_no_id'] = 'Không xác định được ID tài khoản';
$___eb_lang[eb_key_for_site_lang . 'pr_done'] = 'Cập nhật thông tin tài khoản thành công!';

$___eb_lang[eb_key_for_site_lang . 'pr_short_matkhau'] = 'Mật khẩu tối thiểu phải có 6 ký tự!';


// AMP
$___eb_lang[eb_key_for_site_lang . 'amp_full_version'] = 'Xem phiên bản đầy đủ';
$___eb_lang[eb_key_for_site_lang . 'amp_to_top'] = 'Về đầu trang';
$___eb_lang[eb_key_for_site_lang . 'amp_development'] = 'Nhà phát triển';
$___eb_lang[eb_key_for_site_lang . 'amp_copyright'] = 'Bản quyền';
$___eb_lang[eb_key_for_site_lang . 'amp_all_rights'] = 'Toàn bộ phiên bản';
$___eb_lang[eb_key_for_site_lang . 'amp_buy_now'] = '{tmp.web_link}cart?id={tmp.id}';
$eb_note_lang[eb_key_for_site_lang . 'amp_buy_now'] = 'Nhập đầy đủ cấu trúc URL dẫn tới giỏ hàng, nhập <strong>null</strong> để tắt tính năng này.';

// footer address
$___eb_lang[eb_key_for_site_lang . 'fd_diachi'] = '<strong>Địa chỉ:</strong> <i class="fa fa-map-marker"></i>';
$___eb_lang[eb_key_for_site_lang . 'fd_hotline'] = '<strong>Hotline:</strong> <i class="fa fa-phone"></i>';
$___eb_lang[eb_key_for_site_lang . 'fd_dienthoai'] = '<strong>Điện thoại:</strong>';
$___eb_lang[eb_key_for_site_lang . 'fd_email'] = '<strong>Email:</strong> <i class="fa fa-envelope-o"></i>';




/*
* Đối với các phần textarea -> mặc định sẽ là 1 tham số, nếu đúng tham số này -> sẽ dùng file html
*/
// HTML cho giỏ hàng
//$___eb_lang[eb_key_for_site_lang . 'cart_html'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/cart.html' );
$___eb_lang[eb_key_for_site_lang . 'cart_html'] = 'cart';
$eb_type_lang[eb_key_for_site_lang . 'cart_html'] = 'textarea';
$eb_ex_from_github[eb_key_for_site_lang . 'cart_html'] = 'https://github.com/itvn9online/echbaydotcom/blob/master/html/cart.html';

// booking done
//$___eb_lang[eb_key_for_site_lang . 'booking_done'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/hoan-tat.html' );
$___eb_lang[eb_key_for_site_lang . 'booking_done'] = 'booking_done';
$eb_type_lang[eb_key_for_site_lang . 'booking_done'] = 'textarea';
$eb_ex_from_github[eb_key_for_site_lang . 'booking_done'] = 'https://github.com/itvn9online/echbaydotcom/blob/master/html/hoan-tat.html';

// nội dung email đơn hàng
//$___eb_lang[eb_key_for_site_lang . 'booking_mail'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/booking.html' );
$___eb_lang[eb_key_for_site_lang . 'booking_mail'] = 'booking_mail';
$eb_type_lang[eb_key_for_site_lang . 'booking_mail'] = 'textarea';
$eb_ex_from_github[eb_key_for_site_lang . 'booking_mail'] = 'https://github.com/itvn9online/echbaydotcom/blob/master/html/mail/booking.html';

// file mail mặc định
//$___eb_lang[eb_key_for_site_lang . 'mail_main'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/mail.html' );
$___eb_lang[eb_key_for_site_lang . 'mail_main'] = 'mail_main';
$eb_type_lang[eb_key_for_site_lang . 'mail_main'] = 'textarea';
$eb_ex_from_github[eb_key_for_site_lang . 'mail_main'] = 'https://github.com/itvn9online/echbaydotcom/blob/master/html/mail/mail.html';

// mail khi đăng ký nhận tin
//$___eb_lang[eb_key_for_site_lang . 'quick_register_mail'] = file_get_contents( EB_THEME_PLUGIN_INDEX . 'html/mail/qregister.html' );
$___eb_lang[eb_key_for_site_lang . 'quick_register_mail'] = 'quick_register_mail';
$eb_type_lang[eb_key_for_site_lang . 'quick_register_mail'] = 'textarea';
$eb_ex_from_github[eb_key_for_site_lang . 'quick_register_mail'] = 'https://github.com/itvn9online/echbaydotcom/blob/master/html/mail/qregister.html';




/*
* Mã nhúng ngoài của một số trang cụ thể -> custom code -> cc
*/
// Trang chi tiết sản phẩm
$___eb_lang[eb_key_for_site_lang . 'cc_head_product'] = '';
$eb_type_lang[eb_key_for_site_lang . 'cc_head_product'] = 'textarea';

$___eb_lang[eb_key_for_site_lang . 'cc_body_product'] = '';
$eb_type_lang[eb_key_for_site_lang . 'cc_body_product'] = 'textarea';





/*
* Phần này không hẳn là phần ngôn ngữ, mà nó là phần config nhanh, đỡ phải chỉnh nhiều
*/
// kích thước ảnh quảng cáo ở phần danh sách sản phẩm trang chủ: auto || 90/728
$___eb_lang[eb_key_for_site_lang . 'homelist_size'] = 'auto';
$eb_class_css_lang[eb_key_for_site_lang . 'homelist_size'] = 'fixed-size-for-config';

$___eb_lang[eb_key_for_site_lang . 'homelist_num'] = 1;
$eb_type_lang[eb_key_for_site_lang . 'homelist_num'] = 'number';


// tiêu đề của phần logo đối tác
$___eb_lang[eb_key_for_site_lang . 'doitac_title'] = '';

// số comment facebook mặc định
$___eb_lang[eb_key_for_site_lang . 'fb_comments'] = 10;
$eb_type_lang[eb_key_for_site_lang . 'fb_comments'] = 'number';

// số tin trên mỗi dòng
$___eb_lang[eb_key_for_site_lang . 'doitac_num'] = 5;
$eb_type_lang[eb_key_for_site_lang . 'doitac_num'] = 'number';

// kích thước của banner đối tác: auto || 1/2
$___eb_lang[eb_key_for_site_lang . 'doitac_size'] = 'auto';
$eb_class_css_lang[eb_key_for_site_lang . 'doitac_size'] = 'fixed-size-for-config';


// Số lượng banner lớn sẽ lấy cho mỗi trang
$___eb_lang[eb_key_for_site_lang . 'bigbanner_num'] = 5;
$eb_type_lang[eb_key_for_site_lang . 'bigbanner_num'] = 'number';

// thẻ H2 cho phần chi tiết tin tức
$___eb_lang[eb_key_for_site_lang . 'tag_blog_excerpt'] = 'h2';

//
$___eb_lang[eb_key_for_site_lang . 'search_autocomplete'] = 'off';
$eb_note_lang[eb_key_for_site_lang . 'search_autocomplete'] = 'on/ off';

// icon cho khối mạng xã hội
$___eb_lang[eb_key_for_site_lang . 'social_facebook'] = 'fa fa-facebook';
$___eb_lang[eb_key_for_site_lang . 'social_instagram'] = 'fab fa-instagram';
$___eb_lang[eb_key_for_site_lang . 'social_twitter'] = 'fa fa-twitter';
$___eb_lang[eb_key_for_site_lang . 'social_youtube'] = 'fab fa-youtube';
$___eb_lang[eb_key_for_site_lang . 'social_google_plus'] = 'fab fa-google-plus';
$___eb_lang[eb_key_for_site_lang . 'social_pinterest'] = 'fab fa-pinterest';


// phần ngôn ngữ riêng, để sử dụng cho các câu từ mà một số website sẽ dùng
$___eb_lang[eb_key_for_site_lang . 'custom_text'] = 'Custom text';
$___eb_lang[eb_key_for_site_lang . 'custom_text1'] = 'Custom text 1';
$___eb_lang[eb_key_for_site_lang . 'custom_text2'] = 'Custom text 2';
$___eb_lang[eb_key_for_site_lang . 'custom_text3'] = 'Custom text 3';
$___eb_lang[eb_key_for_site_lang . 'custom_text4'] = 'Custom text 4';
$___eb_lang[eb_key_for_site_lang . 'custom_text5'] = 'Custom text 5';
$___eb_lang[eb_key_for_site_lang . 'custom_text6'] = 'Custom text 6';
$___eb_lang[eb_key_for_site_lang . 'custom_text7'] = 'Custom text 7';
$___eb_lang[eb_key_for_site_lang . 'custom_text8'] = 'Custom text 8';
$___eb_lang[eb_key_for_site_lang . 'custom_text9'] = 'Custom text 9';


// ngôn ngữ riêng trong trang chi tiết sản phẩm, tin tức
$___eb_lang[eb_key_for_site_lang . 'post_custom_text'] = 'Post custom text';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text1'] = 'Post custom text 1';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text2'] = 'Post custom text 2';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text3'] = 'Post custom text 3';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text4'] = 'Post custom text 4';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text5'] = 'Post custom text 5';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text6'] = 'Post custom text 6';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text7'] = 'Post custom text 7';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text8'] = 'Post custom text 8';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text9'] = 'Post custom text 9';
$___eb_lang[eb_key_for_site_lang . 'post_custom_text10'] = 'Post custom text 10';


// URL của phần chính sách, quy định trong phần đặt hàng
$___eb_lang[eb_key_for_site_lang . 'url_chinhsach'] = '#';
$___eb_lang[eb_key_for_site_lang . 'chinhsach'] = 'Quý khách vui lòng tham khảo <a href="{tmp.url_chinhsach}" target="_blank">chính sách, quy định chung</a> của chúng tôi.';




//
$___eb_default_lang = $___eb_lang;
//$___eb_lang_default = $___eb_lang;
//$___eb_lang = array();
// EBE_get_lang('home')




