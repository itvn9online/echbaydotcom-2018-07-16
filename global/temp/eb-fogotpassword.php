<?php
if ( $mtv_id > 0 ) {
	die('Login exist!');
}
?>

<div class="popup-border" style="display:none;">
	<div class="cf opoup-title-bg default-bg">
		<div class="lf f70 bold">Quên mật khẩu</div>
		<div align="right" class="lf f30"><a onclick="g_func.opopup();" href="javascript:;">Đóng [x]</a></div>
	</div>
	<div class="popup-padding l19">
		<div>Nhập email đăng nhập của bạn tại đây, sau đó kiểm tra email và làm theo hướng dẫn để lấy lại mật khẩu.</div>
		<br />
		<form name="frm_dangnhap" method="post" action="process/?set_module=fogotpassword" target="target_eb_iframe" onSubmit="return _global_js_eb.add_primari_iframe();">
			<div>
				<label for="t_email"><strong>Email</strong></label>
			</div>
			<div>
				<input type="email" name="t_email" id="t_email" value="" placeholder="Email" aria-required="true" required />
			</div>
			<br />
			<div>
				<button type="submit" class="cur">Gửi mật khẩu</button>
				<a href="javascript:;" onclick="g_func.opopup('login')">Trở về trang đăng nhập</a> </div>
			<br>
		</form>
	</div>
</div>
