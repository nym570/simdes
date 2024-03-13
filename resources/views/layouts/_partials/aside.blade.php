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
			<a href="{{ route('home') }}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-home-circle"></i>
				<div data-i18n="Analytics">
					{{ __('Dashboard') }}
				</div>
			</a>
		</li>
		<li class="menu-item {{ menuIsActive('desa.*') }}">
			<a href="{{ route('desa.show') }}" class="menu-link">
				<i class="menu-icon tf-icons bx bx-info-circle"></i>
				<div data-i18n="Desa">
					{{ __('Profil Desa') }}
				</div>
			</a>
		</li>
		<li class="menu-item">
			<a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
			<div>
			  Statistik Desa
			</div></a>
			<ul class="menu-sub">
				<li class="menu-item {{ menuIsActive('statistik.*') }}">
					<a class="menu-link menu-toggle" href="javascript:void(0)">
					<div>
						Kependudukan
					  </div></a>
					<ul class="menu-sub">
						<li class="menu-item {{ menuIsActive('statistik.warga.agama') }}">
							<a href="{{ route('statistik.warga.agama.index') }}" class="menu-link">
								
								<div data-i18n="Agama">
									{{ __('Berdasarkan Agama') }}
								</div>
							</a>
						</li>
						<li class="menu-item {{ menuIsActive('statistik.warga.pendidikan') }}">
							<a href="{{ route('statistik.warga.pendidikan.index') }}" class="menu-link">
								
								<div data-i18n="Pendidikan">
									{{ __('Berdasarkan Pendidikan') }}
								</div>
							</a>
						</li>
						<li class="menu-item {{ menuIsActive('statistik.warga.pekerjaan') }}">
							<a href="{{ route('statistik.warga.pekerjaan.index') }}" class="menu-link">
								
								<div data-i18n="Pekerjaan">
									{{ __('Berdasarkan Pekerjaan') }}
								</div>
							</a>
						</li>
						<li class="menu-item {{ menuIsActive('statistik.warga.gol_darah') }}">
							<a href="{{ route('statistik.warga.gol_darah.index') }}" class="menu-link">
								
								<div data-i18n="Gol Darah">
									{{ __('Berdasarkan Golongan Darah') }}
								</div>
							</a>
						</li>
						<li class="menu-item {{ menuIsActive('statistik.warga.ktp_desa') }}">
							<a href="{{ route('statistik.warga.ktp_desa.index') }}" class="menu-link">
								
								<div data-i18n="KTP">
									{{ __('Berdasarkan Kepemilikan KTP') }}
								</div>
							</a>
						</li>
						<li class="menu-item {{ menuIsActive('statistik.warga.jenis_kelamin') }}">
							<a href="{{ route('statistik.warga.jenis_kelamin.index') }}" class="menu-link">
								
								<div data-i18n="JK">
									{{ __('Berdasarkan Jenis Kelamin') }}
								</div>
							</a>
						</li>
						<li class="menu-item {{ menuIsActive('statistik.warga.umur') }}">
							<a href="{{ route('statistik.warga.umur.index') }}" class="menu-link">
								
								<div data-i18n="JK">
									{{ __('Berdasarkan Kelompok Umur') }}
								</div>
							</a>
						</li>
					</ul>
				</li>
				
			  
			  
			</ul>
		</li>
		
@auth
	@if(!empty(array_intersect(['ketua rt','ketua rw','kependudukan','kepala desa','kepala dusun'],auth()->user()->getRoleNames()->toArray())))
		<li class="menu-header small text-uppercase">
			<span class="menu-header-text">
				{{ __('Manajemen Warga') }}
			</span>
		</li>
		

		
		
		<li class="menu-item">
			<a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon tf-icons bx bx-user"></i>
			<div>
			  Warga
			</div></a>
			<ul class="menu-sub">
				<li class="menu-item {{ menuIsActive('warga.*') }}">
					<a href="{{ route('warga.index') }}" class="menu-link">
						
						<div data-i18n="Warga">
							{{ __('Warga') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('ruta.*') }}">
					<a href="{{ route('ruta.index') }}" class="menu-link">
						<div data-i18n="RumahTangga">
							{{ __('Rumah Tangga') }}
						</div>
					</a>
				  </li>
			  
			  
			</ul>
		</li>

		<li class="menu-item">
			<a class="menu-link menu-toggle" href="javascript:void(0)"><i class="menu-icon tf-icons bx bxs-landmark"></i>
			<div>
			  Dinamika Penduduk
			</div></a>
			<ul class="menu-sub">
				<li class="menu-item {{ menuIsActive('dinamika.kelahiran.*') }}">
					<a href="{{ route('dinamika.kelahiran.index') }}" class="menu-link">
						<div data-i18n="Analytics">
							{{ __('Kelahiran') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('dinamika.kematian.*') }}">
					<a href="{{ route('dinamika.kematian.index') }}" class="menu-link">
						<div data-i18n="Mati">
							{{ __('Kematian') }}
						</div>
					</a>
				  </li>
				<li class="menu-item {{ menuIsActive('dinamika.kedatangan.*') }}">
					<a href="{{ route('dinamika.kedatangan.index') }}" class="menu-link">
						<div data-i18n="Datang">
							{{ __('Kedatangan') }}
						</div>
					</a>
				</li>
				<li class="menu-item {{ menuIsActive('dinamika.kepindahan.*') }}">
					<a href="{{ route('dinamika.kepindahan.index') }}" class="menu-link">
						<div data-i18n="Pindah">
							{{ __('Kepindahan') }}
						</div>
					</a>
				  </li>
				  
			  
			</ul>
		</li>
	@endif
@if(auth()->user()->hasRole('warga')&&!is_null(\App\Models\AnggotaRuta::where('anggota_nik',auth()->user()->nik)->where('hubungan','Kepala Keluarga')->first()))
	<li class="menu-header small text-uppercase">
		<span class="menu-header-text">
			{{ __('Layanan Warga') }}
		</span>
	</li>
	<li class="menu-item {{ menuIsActive('pengajuan.warga.kependudukan.*') }}">
		<a href="{{ route('pengajuan.warga.kependudukan.index') }}" class="menu-link">
			<i class="menu-icon tf-icons bx bx-home-circle"></i>
			<div data-i18n="Analytics">
				{{ __('Kependudukan') }}
			</div>
		</a>
	</li>
@endif
@endauth
		


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