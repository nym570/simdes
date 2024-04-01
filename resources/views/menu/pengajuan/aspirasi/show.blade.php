@extends('layouts.app')
@section('container')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                {{ __('Lihat Aspirasi') }}
            </h5>

            <div class="mb-4">
                <a href="{{ route('pengajuan.warga.aspirasi.index') }}" class="btn btn-dark">
                    {{ __('Kembali') }}
                </a>
            </div>
            <span><h3 class="text-truncate mb-0 me-2 d-inline">{{$aspirasi->judul}}</h3></span>
            <span class="badge bg-label-warning">{{$aspirasi->kategori}}</span>
            
            <div class="card email-card-prev border mt-3">
                          <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <div class="d-flex align-items-center"> 
                              <small class="mb-0 me-3 text-muted">{{$aspirasi->created_at}}</small>
                            </div>
                          </div>
                          <div class="card-body">
                            {!!$aspirasi->isi!!}
                            @if($aspirasi->lampiran)
                            <hr>
                            
                            <p class="mb-2">Lampiran</p>
                            <div class="cursor-pointer">
                              
                              <button class="align-middle btn btn-primary" data-bs-toggle="modal" data-bs-target="#largeModal"><i class="bx bx-file"></i> .{{pathinfo($aspirasi->lampiran)['extension']}}</button>
                            </div>
                            @endif
                          </div>
                        </div>
                        <div class="modal fade" id="largeModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel3">Lampiran</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if(pathinfo($aspirasi->lampiran)['extension']==="pdf")
                                        <iframe src ="{{ asset('/laraview/#../storage/'.$aspirasi->lampiran) }}" width="100%" height="600px"></iframe>
                                    @else
                                        <img src="{{asset('/storage/'.$aspirasi->lampiran)}}" class="img-thumbnail" alt="lampiran" width="100%">
                                    @endif
                                </div>
                                
                              </div>
                            </div>
                          </div>
            @include('menu.pengajuan.aspirasi._partials.chat')

        </div>
    </div>
@endsection