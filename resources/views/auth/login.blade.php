@extends("auth.layout.authPageLayout");
@section("title", "Login")
@section("main")
 
	<body>
		<section class="fxt-template-animation fxt-template-layout11">
			<div class="container">
				<div class="row align-items-center justify-content-center">
					<div class="col-xl-6 col-lg-7 col-sm-12 col-12 fxt-bg-color">
						<div class="fxt-content">
							<div class="fxt-header">
								<!-- <a href="login-11.html" class="fxt-logo"><img src="img/logo-11.png" alt="Logo"></a>     -->
								<p>Đăng nhập</p>
							</div>
							<div class="fxt-form">
								<form action="{{ route("login.post") }}" method="POST">
									@csrf
									<div class="form-group">
										<div class="fxt-transformY-50 fxt-transition-delay-1">
											<input type="email" id="email" class="form-control" name="email"
												placeholder="Email" required="required">
										</div>
									</div>
									<div class="form-group">
										<div class="fxt-transformY-50 fxt-transition-delay-2">
											<input id="password" type="password" class="form-control" name="password"
												placeholder="********" required="required">
											<i toggle="#password" class="bi bi-eye-fill toggle-password field-icon"></i>
										</div>
									</div>

									@session("err_login")
										<div class="form-group">
											<div class="fxt-transformY-50 fxt-transition-delay-2">
												<label class="err_login">{{ session("err_login") }}</label>
											</div>
										</div>
									@endsession

									<div class="form-group">
										<div class="fxt-transformY-50 fxt-transition-delay-3">
											<div class="fxt-checkbox-area">
												<div class="checkbox">
													<input id="checkbox1" type="checkbox">
													<label for="checkbox1">lưu thông tin đăng nhập</label>
												</div>
												<a href="{{ route("password.request") }}" class="switcher-text">Quên mật
													khẩu</a>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="fxt-transformY-50 fxt-transition-delay-4">
											<button type="submit" class="fxt-btn-fill">Đăng nhập</button>
										</div>
									</div>
								</form>
							</div>
							<!-- <div class="fxt-style-line">
										<div class="fxt-transformY-50 fxt-transition-delay-5">
											<h3>Or Login With</h3>
										</div>
									</div> -->
							<!-- <ul class="fxt-socials">
										<li class="fxt-google">
											<div class="fxt-transformY-50 fxt-transition-delay-6">
												<a href="#" title="google"><i class="fab fa-google-plus-g"></i><span>Google +</span></a>
											</div>
										</li>
										<li class="fxt-twitter">
											<div class="fxt-transformY-50 fxt-transition-delay-7">
												<a href="#" title="twitter"><i class="fab fa-twitter"></i><span>Twitter</span></a>
											</div>
										</li>
										<li class="fxt-facebook">
											<div class="fxt-transformY-50 fxt-transition-delay-8">
												<a href="#" title="Facebook"><i class="fab fa-facebook-f"></i><span>Facebook</span></a>
											</div>
										</li>
									</ul> -->
							<div class="fxt-footer">
								<div class="fxt-transformY-50 fxt-transition-delay-9">
									<p>Bạn chưa có tài khoản ?<a href="{{ route("register") }}"
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
		@if(session("active_success"))
			iziToast.success({
				message: "{{ session("active_success") }}",
				position: "topRight"
			})
		@endif

		@if(session("register_success"))
			iziToast.success({
				message: "{!!  session("register_success") !!}",
				position: "topRight"
			})
		@endif

		@if(session("active_fail"))
			iziToast.warning({
				message: "{!!  session("active_fail") !!}",
				position: "topRight"
			})
		@endif

		@if(session("reset_password_success"))
			iziToast.success({
				message: "{{ session("reset_password_success") }}",
				position: "topRight"
			})
		@endif
	</script>

@endsection