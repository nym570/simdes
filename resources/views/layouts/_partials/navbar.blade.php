<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
	<div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
		<a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
			<i class="bx bx-menu bx-sm"></i>
		</a>
	</div>

	@guest
	<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
		<div class="navbar-nav align-items-center">
			<div class="nav-item d-flex align-items-center">
				<p class="mt-3" style="font-size: calc(0.3em + 1vw);">Selamat Datang! Silahkan Masuk untuk Mendapat Layanan</p>
			</div>
		</div>
		@endguest
	@auth
	<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
		<div class="navbar-nav align-items-center">
			<div class="nav-item d-flex align-items-center">
				<p class="mt-3 fs-5">{{$title}}</p>
			</div>
		</div>
	@endauth

		<ul class="navbar-nav flex-row align-items-center ms-auto">
			<!-- Place this tag where you want the button to render. -->

			@guest
			<!-- User -->
			<li class="nav-item">
				<a class=" btn btn-primary" role="button" href="/login">
						<i class="bx bx-log-in bx-sm d-none d-md-inline"></i>
						<span>Masuk</span>
				</a>
			</li>
			<!--/ User -->
			@endguest

			@auth
			<!-- User -->
			<li class="nav-item navbar-dropdown dropdown-user dropdown">
				<a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
					<div class="avatar avatar-online">
						<img src="{{ is_null(auth()->user()->warga->foto) ? asset('assets/img/avatars/profile.png') : asset('storage/'.auth()->user()->warga->foto) }}" alt class="w-px-40 h-px-40 rounded-circle" />
					</div>
				</a>
				<ul class="dropdown-menu dropdown-menu-end">
					<li>
						<a class="dropdown-item" href="{{route('profil.index')}}">
							<div class="d-flex">
								<div class="flex-shrink-0 me-3">
									<div class="avatar avatar-online">
										<img src="{{ is_null(auth()->user()->warga->foto) ? asset('assets/img/avatars/profile.png') : asset('storage/'.auth()->user()->warga->foto) }}" alt class="w-px-40 h-px-40 rounded-circle" />
									</div>
								</div>
								<div class="flex-grow-1">
									<span class="fw-semibold d-block">
										{{ user()->warga->nama }}
									</span>
									<small class="d-block">
										{{ user()->warga->nik }}
									</small>
									<small class="text-muted">
										@foreach (user()->getRoleNames() as $item)
											<span class="badge bg-primary">{{$item}}</span>
										@endforeach
									</small>
								</div>
							</div>
						</a>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<a class="dropdown-item" href="{{route('profil.index')}}">
							<i class="bx bx-user me-2"></i>
							<span class="align-middle">Saya</span>
						</a>
					</li>
					<li>
						<div class="dropdown-divider"></div>
					</li>
					<li>
						<a class="dropdown-item" href="javascript:;" onclick="logout()">
							<i class="bx bx-power-off me-2"></i>
							<span class="align-middle">Log Out</span>
						</a>

						<form action="{{ route('logout') }}" method="POST" class="d-none" id="logout-form">
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
		swalConfirm('Apakah anda yakin?', "Anda akan keluar dari akun", 'Ya! Keluar', () => {
			document.getElementById('logout-form').submit();
		});
	}
</script>
@endpush