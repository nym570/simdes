<!-- Modal -->
<div class="modal fade" id="EditUser" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Ubah data Pengguna</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('profil.user.update',auth()->user()) }}" data-remote="true" method="POST">
            @method("PUT")
			@csrf
			<div class="modal-body">
				<div class="row">
					<div class="col mb-3">
						<x-label for="nik" :value="__('NIK')" />
						<x-input type="text" name="nik" id="nik" :placeholder="__('NIK 16 digit')" value="{{old('nik')? old('nik') : auth()->user()->nik}}" readonly/>
						<x-invalid error="nik" />
					  </div>
				  </div>
				<div class="row">
				  <div class="col mb-3">
					<x-label for="username" :value="__('Username')" />
					<x-input type="text" name="username" id="username" :placeholder="__('Username disarankan menggunakan nik')" value="{{old('username')? old('username') : auth()->user()->username}}" />
					<x-invalid error="username" />
				  </div>
				</div>
				
				
				<div class="row">
				  <div class="col mb-3">
					<x-label for="email" :value="__('Email')" />
					<x-input type="email" name="email" id="email" :placeholder="__('Email valid untuk pemberitahuan')" value="{{old('email')? old('email') : auth()->user()->email}}" />
					<x-invalid error="email" />
				  </div>
				</div>
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Edit Pengguna')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>

  <div class="modal fade" id="EditPassword" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h5 class="modal-title" id="exampleModalLabel1">Ubah Password</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="formAuthentication" class="mb-3" action="{{ route('profil.user.password',auth()->user()) }}" data-remote="true" method="POST">
            @method("PUT")
			@csrf
			<div class="modal-body">
				<div class="row g-2 mb-3">
                    <div class="col form-password-toggle">
                      <label for="password" class="form-label">Password*</label>
                      <div class="input-group input-group-merge">
                        <x-input type="password" name="password" id="password" :placeholder="__('Password')" aria-describedby="password" required/>
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        <x-invalid error="password" />
                       </div>
                    </div>
                    <div class="col form-password-toggle">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password*</label>
                        <div class="input-group input-group-merge">
                            <x-input type="password" name="password_confirmation" id="password_confirmation" :placeholder="__('Ketik ulang password')" aria-describedby="password" required />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            <x-invalid error="password_confirmation" />
                        </div>
                    </div>
                    <p><small>password terdiri dari minimal 8 karakter kombinasi huruf dan angka</small></p>
                  </div>
			  </div>
			  <div class="modal-footer">
				<x-button type="submit" class="btn btn-primary d-grid w-100" :value="__('Ubah Password')"/>
			  </div>
		</form>
	  </div>
	</div>
  </div>