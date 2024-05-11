<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
	<div class="app-brand demo ">
		<a href="/" class="app-brand-link">
			<span class="app-brand-logo demo">
				<img src="{{ asset('assets/img/icons/logo.png') }}" alt class="w-px-40 h-auto rounded-circle" />
			</span>
			<span class="app-brand-text demo menu-text fw-bolder ms-2 text-wrap w-px-40 d-block" >
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
				<li class="menu-item {{ menuIsActive('admin-list.*') }}">
					<a href="{{ route('admin-list.index') }}" class="menu-link">
						
						<div data-i18n="Admin">
							{{ __('Admin') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('users.*') }}">
					<a href="{{ route('users.index') }}" class="menu-link">
						
						<div data-i18n="Pengguna">
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
				<li class="menu-item {{ menuIsActive('m.pemerintahan.*') }}">
					<a href="{{ route('m.pemerintahan.index') }}" class="menu-link">
						<div data-i18n="Pemerintahan">
							{{ __('Perangkat Desa') }}
						</div>
					</a>
				  </li>
			  
			  
			</ul>
		</li>
		<li class="menu-item {{ menuIsActive('admin.panduan.index') }}">
			<a href="{{ route('admin.panduan.index') }}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-note"></i>
				<div data-i18n="Analytics">
					{{ __('Panduan') }}
				</div>
			</a>
		</li>

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">
				{{ __('Manajemen Master Data') }}
			</span>
		</li>
		
		
		<li class="menu-item">
			<a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon tf-icons bx bx-category"></i>
			<div>
			  Master Kategori
			</div></a>
			<ul class="menu-sub">
				<li class="menu-item {{ menuIsActive('master.aspirasi') }}">
					<a href="{{ route('master.aspirasi') }}" class="menu-link">
						
						<div data-i18n="Aspirasi">
							{{ __('Aspirasi') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('master.info') }}">
					<a href="{{ route('master.info') }}" class="menu-link">
						
						<div data-i18n="Informasi Publik">
							{{ __('Informasi Publik') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('master.panduan') }}">
					<a href="{{ route('master.panduan') }}" class="menu-link">
						<div data-i18n="Panduan">
							{{ __('Panduan') }}
						</div>
					</a>
				  </li>
			  
			  
			</ul>
		</li>

		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">
				{{ __('log') }}
			</span>
		</li>

		<li class="menu-item {{ menuIsActive('log') }}">
			<a href="{{ route('log.index') }}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-calendar-exclamation"></i>
				<div data-i18n="Analytics">
					{{ __('Log Aktivitas') }}
				</div>
			</a>
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