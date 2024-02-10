<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo ">
		<a href="/" class="app-brand-link">
			<span class="app-brand-logo demo">
				<img src="{{ asset('assets/img/icons/logo.png') }}" alt class="w-px-40 h-auto rounded-circle" />
			</span>
			<span class="app-brand-text demo menu-text fw-bolder ms-2 text-wrap w-px-40 d-block">
				{{ (config('app.name').' '.$desa->desa)}}
			</span>
		</a>

		<a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
			<i class="bx bx-chevron-left bx-sm align-middle"></i>
		</a>
	</div>
	

	<div class="menu-inner-shadow"></div>

	<ul class="menu-inner py-1">
		<!-- Dashboard -->
		<li class="menu-item {{ menuIsActive('home') }}">
			<a href="{{ route('admin.home') }}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-home-circle"></i>
				<div data-i18n="Analytics">
					{{ __('Dashboard') }}
				</div>
			</a>
		</li>

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">
				{{ __('Manajemen Sistem') }}
			</span>
		</li>
		

		
		
		<li class="menu-item">
			<a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon tf-icons bx bx-user"></i>
			<div>
			  Manajemen Pengguna
			</div></a>
			<ul class="menu-sub">
				<li class="menu-item {{ menuIsActive('users.*') }}">
					<a href="{{ route('users.index') }}" class="menu-link">
						
						<div data-i18n="Manajemen Pengguna">
							{{ __('Pengguna') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('roles.*') }}">
					<a href="{{ route('roles.index') }}" class="menu-link">
						<div data-i18n="Roles">
							{{ __('Roles') }}
						</div>
					</a>
				  </li>
			  
			  
			</ul>
		</li>

		<li class="menu-item">
			<a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon tf-icons bx bxs-landmark"></i>
			<div>
			  Manajemen Desa
			</div></a>
			<ul class="menu-sub">
				<li class="menu-item {{ menuIsActive('m.desa.index') }}">
					<a href="{{ route('m.desa.index') }}" class="menu-link">
						<div data-i18n="Analytics">
							{{ __('Profil Desa') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('m.lkd.*') }}">
					<a href="{{ route('m.lkd.index') }}" class="menu-link">
						<div data-i18n="Analytics">
							{{ __('Dusun, Rw, RT') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('roles.*') }}">
					<a href="{{ route('roles.index') }}" class="menu-link">
						<div data-i18n="Roles">
							{{ __('Perangkat Desa') }}
						</div>
					</a>
				  </li>
			  
			  
			</ul>
		</li>

		

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">
				{{ __('Data Master') }}
			</span>
		</li>


		<!-- <li class="menu-item">
			<a href="javascript:void(0);" class="menu-link menu-toggle">
				<i class="menu-icon tf-icons bx bx-cube-alt"></i>
				<div data-i18n="Misc">Misc</div>
			</a>
			<ul class="menu-sub">
				<li class="menu-item">
					<a href="javascript:void(0);" class="menu-link">
						<div data-i18n="Error">Error</div>
					</a>
				</li>
			</ul>
		</li> -->

	</ul>
</aside>