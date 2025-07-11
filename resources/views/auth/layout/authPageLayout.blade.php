<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>@yield("title")</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	 <link rel="icon" href="{{ asset('assets/logo/icon.png') }}" type="image/png">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="/assets/bootstrap/bootstrap-5.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="/assets/bootstrap/bootstrap-icons/font/bootstrap-icons.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="/assets/auth/css/fontawesome-all.min.css">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="/assets/auth/lib/font/flaticon.css">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
	<!-- iziToast -->
	<link href="/assets/izitoast/css/iziToast.min.css" rel="stylesheet" type="text/css">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="/assets/auth/css/style.css">
</head>
<div id="spinner"
	class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
	<div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
</div>
@yield("main")

<!-- jquery-->
<script src="/assets/auth/js/jquery.min.js"></script>
<!-- Bootstrap js -->
<script src="/assets/bootstrap/bootstrap-5.3.0/js/bootstrap.min.js"></script>
<!-- Imagesloaded js -->
<script src="/assets/auth/js/imagesloaded.pkgd.min.js"></script>
<!-- Validator js -->
<script src="/assets/auth/js/validator.min.js"></script>
<!-- Custom Js -->
<script src="/assets/auth/js/main.js"></script>
<!-- iziToast js -->
<script src="/assets/izitoast/js/iziToast.min.js"></script>
@yield("izitoast")

</html>