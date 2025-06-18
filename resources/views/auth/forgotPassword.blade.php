@extends("auth.layout.authPageLayout");
@section("title", "forgot_password")
@section("main")

	<style>
	
	</style>

	<body>
		<section class="fxt-template-animation fxt-template-layout11">
			<div class="container">
				<div class="row align-items-center justify-content-center">
					<div class="col-xl-6 col-lg-7 col-sm-12 col-12 fxt-bg-color">
						<div class="fxt-content">
							<div class="fxt-header">
								<!-- <a href="login-11.html" class="fxt-logo"><img src="img/logo-11.png" alt="Logo"></a> -->
								<p>Khôi phục mật khẩu của bạn</p>
							</div>
							<div class="fxt-form">
								<form action="{{ route("password.email") }}" method="POST">
									@csrf
									<div class="form-group">
										<div class="fxt-transformY-50 fxt-transition-delay-1">
											<input type="email" id="email" class="form-control" name="email"
												placeholder="Email" required="required">
										</div>
									</div>
									<div class="form-group">
										<div class="fxt-transformY-50 fxt-transition-delay-4">
											<button type="submit" class="fxt-btn-fill">Gửi</button>
										</div>
									</div>
								</form>
							</div>
							<div class="fxt-footer">
								<div class="fxt-transformY-50 fxt-transition-delay-9">
									<p>Bạn chưa có tài khoản?<a href="{{ route("register") }}"
											class="switcher-text2 inline-text">Đăng ký</a></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</body>
@endsection
@section("izitoast")
	<script>
		@if(session("send_email_success"))
			iziToast.info({
				message: "{{ session("send_email_success") }}",
				position: "topRight"
			})
		@endif
		@if(session("send_email_fail"))
			iziToast.warning({
				message: "{{ session("send_email_fail") }}",
				position: "topRight"
			})
		@endif
		@if(session("reset_password_fail"))
			iziToast.warning({
				message: "{{ session("reset_password_fail") }}",
				position: "topRight"
			})
		@endif


		
	</script>

@endsection