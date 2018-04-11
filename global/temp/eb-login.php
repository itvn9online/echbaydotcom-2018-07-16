<?php
if ( $mtv_id > 0 ) {
	die('Login exist!');
}
?>

<div class="popup-border" style="display:none;">
	<div class="cf opoup-title-bg default-bg">
		<div class="lf f70 bold">Đăng nhập</div>
		<div align="right" class="lf f30"><a onclick="g_func.opopup();" href="javascript:;">Đóng [x]</a></div>
	</div>
	<div class="popup-padding l19">
		<form name="frm_dangnhap" method="post" action="process/?set_module=login" target="target_eb_iframe" onSubmit="return _global_js_eb.add_primari_iframe();">
			<div>
				<label for="t_email"><strong>Email</strong></label>
			</div>
			<div>
				<input type="email" name="t_email" id="t_email" value="" placeholder="Email" aria-required="true" required />
			</div>
			<br />
			<div>
				<label for="t_matkhau"><strong>Mật khẩu</strong></label>
			</div>
			<div>
				<input type="password" name="t_matkhau" id="t_matkhau" value="" placeholder="Password" aria-required="true" required />
			</div>
			<br />
			<div>
				<input type="checkbox" name="t_remember" id="t_remember" value="1" />
				<label for="t_remember" style="color:#666">Duy trì trạng thái đăng nhập</label>
			</div>
			<br />
			<div>
				<button type="submit" class="cur">Đăng nhập</button>
			</div>
			<br />
			<div><a href="#" onClick="g_func.opopup('fogotpassword');">Bạn quên mật khẩu? lấy lại mật khẩu tại đây</a></div>
		</form>
	</div>
</div>
