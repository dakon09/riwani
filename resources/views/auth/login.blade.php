<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
	<!--begin::Head-->
	<head>
        <base href="{{ url('/') }}" />
		<title>{{ config('app.name', 'BoilerPlate Harma') }}</title>
		<meta charset="utf-8" />
		<meta name="description" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
		<meta name="keywords" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
		<meta property="og:url" content="{{ url('/') }}" />
		<meta property="og:site_name" content="{{ config('app.name', 'BoilerPlate Harma') }}" />
		<link rel="canonical" href="{{ url('/') }}" />
		<link rel="shortcut icon" href="{{ asset('assets/media/logo-white.png') }}" />
		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<!--end::Global Stylesheets Bundle-->
		<script>// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking) if (window.top != window.self) { window.top.location.replace(window.self.location.href); }</script>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center">
		<!--begin::Root-->
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<!--begin::Page bg image-->
			<style>body { background-image: url( {{ asset('assets/media/auth/bg10.jpeg') }}); } [data-bs-theme="dark"] body { background-image: url( {{ asset('assets/media/auth/bg10-dark.jpeg') }}); }</style>
			<!--end::Page bg image-->
			<!--begin::Authentication - Sign-in -->
			<div class="d-flex flex-column flex-lg-row flex-column-fluid">
				<!--begin::Aside-->
				<div class="d-flex flex-lg-row-fluid">
					<!--begin::Content-->
					<div class="d-flex flex-column flex-center pb-0 pb-lg-10 p-10 w-100">
						<!--begin::Image-->
						<img class="theme-light-show mx-auto mw-100 w-150px w-lg-300px mb-10 mb-lg-20" src=" {{ asset('assets/media/logo.png') }} " alt="" />
						<!--end::Image-->
					</div>
					<!--end::Content-->
				</div>
				<!--begin::Aside-->
				<!--begin::Body-->
				<div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12">
					<!--begin::Wrapper-->
					<div class="bg-body d-flex flex-column flex-center rounded-4 w-md-600px p-10">
						<!--begin::Content-->
						<div class="d-flex flex-center flex-column align-items-stretch h-lg-100 w-md-400px">
							<!--begin::Wrapper-->
							<div class="d-flex flex-center flex-column flex-column-fluid pb-15 pb-lg-20">
								<!--begin::Form-->
								<form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <!-- reCAPTCHA v3 token -->
									<input type="hidden" name="g-recaptcha-response" id="recaptcha_token">
                                    <!--begin::Heading-->
									<div class="text-center mb-11">
										<!--begin::Title-->
										<h1 class="text-gray-900 fw-bolder mb-3">Sign In</h1>
										<!--end::Title-->
										<!--begin::Subtitle-->
										<div class="text-gray-500 fw-semibold fs-6">Username & Password</div>
										<!--end::Subtitle=-->
                                        @if($errors->any())
                                            <!--begin::Alert-->
                                            <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
                                                <!--begin::Icon-->
                                                <i class="ki-duotone ki-notification-bing fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <!--end::Icon-->
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-column pe-0 pe-sm-10">
                                                    <!--begin::Title-->
                                                    <h4 class="fw-semibold">Unauthorize!</h4>
                                                    <!--end::Title-->

                                                    <!--begin::Content-->
                                                    <span>{{$errors->first()}}</span>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Close-->
                                                <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                                                    <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                                </button>
                                                <!--end::Close-->
                                            </div>
                                            <!--end::Alert-->
                                        @endif
									</div>
									<!--begin::Heading-->
									<!--begin::Input group=-->
									<div class="fv-row mb-8">
										<!--begin::Email-->
										<input type="text" placeholder="Username" value="{{ old('username') }}" name="username" id="username" autocomplete="off" class="form-control bg-transparent" />
										<!--end::Email-->
									</div>
									<!--end::Input group=-->
									<div class="fv-row mb-3">
										<!--begin::Password-->
										<input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control bg-transparent" />
										<!--end::Password-->
									</div>
									<!--end::Input group=-->
									<!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                        <div></div>
                                        <!--begin::Link-->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                            <label class="form-check-label" for="remember">
                                                Remember Me
                                            </label>
                                        </div>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Wrapper-->
									<!--begin::Submit button-->
									<div class="d-grid mb-10">
										<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
											<!--begin::Indicator label-->
											<span class="indicator-label">Sign In</span>
											<!--end::Indicator label-->
											<!--begin::Indicator progress-->
											<span class="indicator-progress">Please wait... 
											<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
											<!--end::Indicator progress-->
										</button>
									</div>
									<!--end::Submit button-->
								</form>
								<!--end::Form-->
							</div>
							<!--end::Wrapper-->
							<!--begin::Footer-->
							<div class="d-flex flex-stack">
							</div>
							<!--end::Footer-->
						</div>
						<!--end::Content-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Root-->
		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('assets/js/auth/index.js') }}"></script>
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site') }}"></script>
		<script>
		grecaptcha.ready(function() {
			grecaptcha.execute('{{ config('services.recaptcha.site') }}', {action: 'login'}).then(function(token) {
				document.getElementById('recaptcha_token').value = token;
			});
		});
		</script>
		<!--end::Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>