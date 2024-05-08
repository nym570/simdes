<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('/') }}" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

	<title>{{ $title }}</title>

	<meta name="description" content="" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

	<!-- Icons. Uncomment required icon fonts -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

	<!-- Core CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
	<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

	<!-- Vendors CSS -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
	<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />

	<!-- Page CSS -->
	<!-- Page -->
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
	<!-- Helpers -->
	<script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="{{ asset('assets/js/config.js') }}"></script>
	<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css">
	<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"/>
		<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.css') }}" />
		<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
		<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
		<style>
			.trix-button-group.trix-button-group--file-tools {
				display:none;
			}
			.modal-backdrop {
				z-index: 0;
			}
			.bs-stepper-header {
				flex-wrap: wrap;
			}
			.overlay_loading {
				z-index: 10000000000000000;
				position: fixed;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;
				background: rgba(0,0,0,.7);
			}
			.overlay__wrapper_loading {
				width: 100%;
				height: 100%;
				position: relative;
			}
			.overlay__spinner_loading {
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
			}
			
		</style>




</head>

<body>
	<!-- Content -->

	<div class="container-xxl">
		<div class="authentication-wrapper authentication-basic container-p-y">
			<div class="authentication-inner" style="{{Request::is('login') ? '' : 'max-width:700px'}}">
				<div class="card">
					<div class="card-body">

						<!-- Logo -->
						<div class="app-brand justify-content-center">
							<a href="/" class="app-brand-link gap-2">
								<span class="app-brand-logo demo">
									<img src="{{ asset('assets/img/icons/logo.png') }}" alt class="w-px-40 h-auto rounded-circle" />
								</span>
								<span class="app-brand-text demo text-body fw-bolder">{{config('app.name')}} {{ is_null($desa) ?  __('') : __($desa->desa)}}</span>
								
							</a>
						</div>
						<!-- /Logo -->
						
						<x-alert />
						@yield('container')
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- / Content -->

	<!-- Core JS -->
	<!-- build:js assets/vendor/js/core.js -->
	<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
	<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/bs-stepper/bs-stepper.js') }}"></script> 
	<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
	<!-- endbuild -->

	<!-- Vendors JS -->
	<script src="{{ asset('assets/vendor/libs/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
	<script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script> 

	<!-- Main JS -->
	<script src="{{ asset('assets/js/main.js') }}"></script>
	<script src="{{ asset('assets/js/custom.js') }}"></script>

	@stack('js')
</body>

</html>