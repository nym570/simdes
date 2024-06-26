<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
	<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
		<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
			<i class="bx bx-menu bx-sm"></i>
		</a>
	</div>

	<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
		<!-- Search -->
		<h4 class="mt-3">{{$title}}</h4>
		<!-- /Search -->

		<ul class="navbar-nav flex-row align-items-center ms-auto">
			<!-- Place this tag where you want the button to render. -->

			@auth('admin')
			<!-- User -->
			<li class="nav-item navbar-dropdown dropdown-user dropdown">
				<div class="nav-link dropdown-toggle hide-arrow"  data-bs-toggle="dropdown">
					<div class="avatar avatar-online">
						<img src="{{ asset('assets/img/avatars/profile.png') }}" alt class="w-px-40 h-auto rounded-circle" />
					</div>
				</div>
				<ul class="dropdown-menu dropdown-menu-end">
					<li>
						<div class="dropdown-item" >
							<div class="d-flex">
								<div class="flex-shrink-0 me-3">
									<div class="avatar avatar-online">
										<img src="{{ asset('assets/img/avatars/profile.png') }}" alt class="w-px-40 h-auto rounded-circle" />
									</div>
								</div>
								<div class="flex-grow-1">
									<span class="fw-semibold d-block">
										{{  auth()->guard('admin')->user()->nama }}
									</span>
									<small class="text-muted">
										Admin
									</small>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					
					<li>
						<a class="dropdown-item" href="javascript:;" onclick="logout()">
							<i class="bx bx-power-off me-2"></i>
							<span class="align-middle">Log Out</span>
						</a>

						<form action="{{ route('admin.logout') }}" method="POST" class="d-none" id="logout-form">
							@csrf
						</form>
					</li>
				</ul>
			</li>
			<!--/ User -->
			@endauth
		</ul>
	</div>
</nav>

@push('js')
<script>
	function logout() {
		event.preventDefault()
		swalConfirm('Apakah anda yakin?', "Anda akan keluar dari akun admin", 'Ya! Keluar', () => {
			document.getElementById('logout-form').submit();
		});
	}
</script>
@endpush