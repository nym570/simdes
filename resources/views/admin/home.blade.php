@extends('admin.layouts.app')
@section('container')
<div class="card mb-3">
	<div class="card-header text-center">
		<h4>Panduan Konfigurasi</h4>
	</div>
	<div class="card-body">
		<div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-5">
			
			<div class="col d-inline p-0">
				<button class="btn text-center " type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapseExample">
					<i class='bx bx-cog bx-lg '></i>
				<p>Konfigurasi Awal</p>
				</button>
					<i class="bx bx-chevron-right bx-lg"></i>
			 </div>
			 <div class="col d-inline p-0">
				<button class="btn text-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapseExample">
					<i class='bx bx-data bx-lg' ></i>
				<p>Master Data</p>
				</button>
				
					<i class="bx bx-chevron-right bx-lg"></i>
			 </div>
			 <div class="col d-inline p-0">
				<button class="btn text-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapseExample">
					<i class='bx bx-user bx-lg'></i>
				<p>Buat Pengguna</p>
				</button>
				
				<i class="bx bx-chevron-right bx-lg"></i>
			 </div>
			 <div class="col d-inline p-0">
				<button class="btn text-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapseExample">
					<i class="bx bx-body bx-lg"></i>
				<p>Pengaturan Role</p>
				</button>
				
				</button>
					<i class="bx bx-chevron-right bx-lg"></i>
			 </div>
			 <div class="col d-inline p-0">
				<button class="btn text-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapseExample">
					<i class='bx bx-home-circle bx-lg'></i>
				<p>Detail Desa & Panduan</p>
					
			 </div>
		</div>

		<div id="myGroup">
			<div class="collapse" id="collapse1">
				<div class="d-flex p-3 border">
				  
				  <span>
					Konfigurasi awal telah diselesaikan, data desa dan wilayah kemasyarakatan telah disimpan
				  </span>
				</div>
			  </div>
			  <div class="collapse" id="collapse2">
				<div class="d-flex p-3 border">
				  
				  <span>
					Silahkan buat pengguna awal <em> (pengguna yang akan menjadi petugas pengoperasian sistem seperti perangkat desa & perangkat lembaga kemasyarakatan) </em> dengan melakukan <strong>import</strong> pada <a href="{{route('users.index')}}">halaman user</a>
				  </span>
				</div>
			  </div>
			  <div class="collapse" id="collapse3">
				<div class="d-flex p-3 border">
				  
				  <span>
					Berikan pengguna yang telah dibuat peran/role. Peran yang dapat ditambahkan sebagai berikut
					<ul>
						<li><a href="{{route('m.desa.index')}}">Kepala Desa</a></li>
						<li><a href="{{route('m.lkd.index')}}">Ketua Lembaga Kemasyarakatan (dusun/rw/rt)</a></li>
						<li><a href="{{route('roles.index')}}">Peran Lainnya</a></li>
					</ul>
				  </span>
				</div>
			  </div>
			  <div class="collapse" id="collapse4">
				<div class="d-flex p-3 border">
				  
				  <span>
					Berikan informasi untuk desa yang dapat diakses secara umum. Informasi yang dapat ditambahkan :
					<ul>
						<li><a href="{{route('m.desa.index')}}">Deskripsi desa</a></li>
						<li><a href="{{route('m.pemerintahan.index')}}">Perangkat Desa</a></li>
					</ul>
					Untuk memberikan bantuan kepada pengguna dalam mempelajari sistem, silahkan <a href="{{route('admin.panduan.index')}}">atur panduan pengguna</a>  
				  </span>
				</div>
			  </div>
			  <div class="collapse" id="collapse5">
				<div class="d-flex p-3 border">
				  
				  <span>
					Berikan informasi untuk desa yang dapat diakses secara umum. Informasi yang dapat ditambahkan :
					<ul>
						<li><a href="{{route('m.desa.index')}}">Deskripsi desa</a></li>
						<li><a href="{{route('m.pemerintahan.index')}}">Perangkat Desa</a></li>
					</ul>
				  </span>
				</div>
			  </div>
		</div>
		
	</div>
	
</div>
<!-- Card Border Shadow -->
<div class="row">
	<div class="col-sm-6 col-lg-3 mb-4">
	  <div class="card card-border-shadow-primary h-100">
		<div class="card-body">
		  <div class="d-flex align-items-center mb-2 pb-1">
			<div class="avatar me-2">
			  <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-user"></i></span>
			</div>
			<h4 class="ms-1 mb-0">{{$data['user']['count']}}</h4>
		  </div>
		  <p class="mb-1">Jumlah pengguna aktif</p>
		  <p class="mb-0">
			<span class="fw-medium me-1 text-success">+ {{$data['user']['last_month']}} </span>
			<small class="text-muted">pengguna bulan ini</small>
		  </p>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-lg-3 mb-4">
	  <div class="card card-border-shadow-warning h-100">
		<div class="card-body">
		  <div class="d-flex align-items-center mb-2 pb-1">
			<div class="avatar me-2">
			  <span class="avatar-initial rounded bg-label-warning"><i class='bx bx-key'></i></span>
			</div>
			<h4 class="ms-1 mb-0">{{$data['user']['login']}}</h4>
		  </div>
		  <p class="mb-1">Pengguna Login Hari ini</p>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-lg-6 mb-4">
		<div class="card card-border-shadow-warning h-100">
			<div class="card-body row widget-separator">
				<div class="col-sm-5 border-shift border-end">
					<h1 class="text-primary text-center mb-0">{{array_sum($data['activity']['event_last_month'])}}</h1>
					<h4 class=" text-center mb-0">Aktivitas Anda</h4>
					<p class=" text-center mb-0">bulan ini</p>
				  </div>
		  
				  <div class="col-sm-7 gy-1 text-nowrap d-flex flex-column justify-content-between ps-4 gap-2 pe-3">
					<div id="activityStatisticsChart">
						<canvas id="activityChart" class="chartjs" data-height="150"></canvas>
					  </div>
		
				  </div>
			</div>
		  </div>
  </div>
  <!--/ Card Border Shadow -->

  <div class="row">
	<!-- Delivery Performance -->
	<div class="col-lg-6 col-xxl-6 mb-4 order-2 order-xxl-2">
	  <div class="card h-100">
		<div class="card-header d-flex align-items-center justify-content-between">
		  <div class="card-title mb-0">
			<h5 class="m-0 me-2">Aktivitas terakhir anda</h5>
		  </div>
		</div>
		<div class="card-body">
			@foreach($data['activity']['last'] as $item)
			<li class="d-flex mb-4 pb-1">
				<div class="avatar flex-shrink-0 me-3">
				  <span class="avatar-initial rounded bg-label-primary"><i class="bx bxs-bookmark"></i></span>
				</div>
				<div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
				  <div class="me-2">
					<h6 class="mb-1 fw-normal"> {{$item->log_name=='default'?'':$item->log_name.' : '}} {{$item->event==''?'lainnya':$item->event}}</h6>
					<small class="text-muted fw-normal d-block">
					  @if($item->log_name=='Warga')
					  		{{$item->subject->nik}}
						@else
							@if ($item->log_name== 'Admin' || $item->log_name == 'User'|| $item->log_name == 'Role')
								{{$item->subject ? $item->subject->username : ''}}
							@else
							@isset($item->subject->name)
							{{$item->subject->name}}
							@endisset
							
							
						@endif
					  @endif
					</small>
				  </div>
				  <div>
					{{$item->created_at->diffForHumans()}}
				  </div>
				</div>
			  </li>
			@endforeach
			
		  </ul>
		</div>
	  </div>
	</div>
	<!-- Shipment statistics-->
	<div class="col-lg-6 col-xxl-6 mb-4 order-1 order-xxl-1">
	  <div class="card h-100">
		<div class="card-header d-flex align-items-center justify-content-between">
		  <div class="card-title mb-0">
			<h5 class="m-0 me-2 mb-2 d-inline ">Statistik Pengguna Aktif</h5>
			<div class="d-inline  btn-group me-3">
				<button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Download
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
				  <li><a class="dropdown-item" download="user-statistik.jpg" href="" id="download-image" >image</a></li>
				</ul>
			  </div>
		  </div>
		 
		</div>
		<div class="card-body">
			<div class="row g-3">
				<div class="col mb-3">
					<select id="dusun" class="selectpicker w-100" data-style="btn-default" data-live-search="false" name="dusun_id" required>
						
					</select>
				</div>
				<div class="col mb-3">
					<select id="rw" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="RW" name="rw_id" required>
						
					</select>
				</div>

			</div>
		  <div id="shipmentStatisticsChart">
			<canvas id="barChart" class="chartjs" data-height="250"></canvas>
		  </div>
		</div>
	  </div>
	</div>
	<!--/ Shipment statistics -->
</div>
	<!--/ Delivery Performance -->

	<!--/ Reasons for delivery exceptions -->


</div>

@push('js')
	<script src="{{ asset('assets/vendor/libs/chartjs/chartjs.js') }}"></script>
<script>
	
	'use strict';
	$( document ).ready(function() {
			
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		

	
  // Color Variables
  const purpleColor = '#836AF9',
    yellowColor = '#ffe800',
    cyanColor = '#28dac6',
    orangeColor = '#FF8132',
    orangeLightColor = '#FDAC34',
    oceanBlueColor = '#299AFF',
    greyColor = '#4F5D70',
    greyLightColor = '#EDF1F4',
    blueColor = '#2B9AFF',
    blueLightColor = '#84D0FF';

  let cardColor, headingColor, labelColor, borderColor, legendColor;


    cardColor = config.colors.cardColor;
    headingColor = config.colors.headingColor;
    labelColor = config.colors.textMuted;
    legendColor = config.colors.bodyColor;
    borderColor = config.colors.borderColor;
  

  // Set height according to their data-height
  // --------------------------------------------------------------------
  const chartList = document.querySelectorAll('.chartjs');
  chartList.forEach(function (chartListItem) {
    chartListItem.height = chartListItem.dataset.height;
  });

  const activityChart = document.getElementById('activityChart');
  if (activityChart) {
    const activityChartVar = new Chart(activityChart, {
      type: 'bar',
      data: {
        labels: @json($data['activity']['graph']['label']),
        datasets: [
          {
            data: @json($data['activity']['graph']['data']),
            backgroundColor: [purpleColor,yellowColor,orangeColor, cyanColor, orangeLightColor,oceanBlueColor, greyColor,greyLightColor,blueColor, blueLightColor,config.colors.primary],
            borderColor: 'transparent',
            maxBarThickness: 5,
            borderRadius: {
              topRight: 5,
              topLeft: 5
            }
          }
        ]
      },
      options: {
		indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 500,
		  
		  
        },
        plugins: {
			title: {
                display: true,
                text: 'Aktivitas Berdasarkan Events'
            },
          tooltip: {
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          },
          legend: {
            display: false
          },
		  datalabels: {
            anchor: 'end',
            align: 'top',
            formatter: Math.round,
            font: {
                weight: 'bold'
            }
        }
		  
        },
        scales: {
          x: {
			min :0,
				max:Math.max(...@json($data['activity']['graph']['data']))+2,
            grid: {
				
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
				stepSize:	 Math.max(...@json($data['activity']['graph']['data']))%5,
              color: labelColor,
			  precision: 0
            }
          },
          y: {
            grid: {
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
              
              color: labelColor,
			  
            }
          }
        }
      }
	});
}

  // Bar Chart
  // --------------------------------------------------------------------
  const barChart = document.getElementById('barChart');
  if (barChart) {
    const barChartVar = new Chart(barChart, {
      type: 'bar',
      data: {
        labels: [],
        datasets: [
          {
            data: [],
            backgroundColor: [purpleColor,yellowColor,orangeColor, cyanColor, orangeLightColor,oceanBlueColor, greyColor,greyLightColor,blueColor, blueLightColor,config.colors.primary],
            borderColor: 'transparent',
            maxBarThickness: 15,
            borderRadius: {
              topRight: 15,
              topLeft: 15
            }
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 500,
		  
		  
        },
        plugins: {
			title: {
                display: true,
                text: 'Pengguna Aktif Berdasarkan Wilayah'
            },
          tooltip: {
            backgroundColor: cardColor,
            titleColor: headingColor,
            bodyColor: legendColor,
            borderWidth: 1,
            borderColor: borderColor
          },
          legend: {
			labels: {
          generateLabels: function(chart) {
            const data = chart.data;
            if (data.labels.length && data.datasets.length) {
              const {
                labels: {
                  pointStyle
                }
              } = chart.legend.options;

              const max = data.datasets[0].data.reduce((a, b) => (a + b), 0);

              return data.labels.map((label, i) => {
                const meta = chart.getDatasetMeta(0);
                const style = meta.controller.getStyle(i);

                return {
                  text: `${label} (${data.datasets[0].data[i] })`,
                  fillStyle: style.backgroundColor,
                  strokeStyle: style.borderColor,
                  lineWidth: style.borderWidth,
                  pointStyle: pointStyle,
                  hidden: !chart.getDataVisibility(i),

                  // Extra data used for toggling the correct item
                  index: i
                };
              });
            }
            return [];
          }
        },
		  
        },
		  datalabels: {
            anchor: 'end',
            align: 'top',
            formatter: Math.round,
            font: {
                weight: 'bold'
            }
        }
		  
        },
        scales: {
          x: {
            grid: {
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
              color: labelColor
            }
          },
          y: {
            min: 0,
            max: 0,
            grid: {
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
              stepSize:	0,
              color: labelColor,
			  precision: 0
            }
          }
        }
      }
    });



    

	$.ajax({
					type : 'GET',
					url: "{{route('users.dusun-count')}}",
					
					data : {id:'all'},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data'];
						barChartVar.options.scales.y.max = Math.max(...hasil['data'])+2;
						barChartVar.options.scales.y.ticks.stepSize = Math.max(...hasil['data'])%5;
						barChartVar.update();
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})

	$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-dusun')}}",
					success: function(msg){
						msg = "<option data-tokens='all' value='all'>All Dusun</option>" + msg;
						$('#dusun').selectpicker('destroy');
						$('#dusun').html(msg);
						$('#dusun').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				});
		    
		
		$('#dusun').on('change',function(){
				$('#dusun').selectpicker('render');
				let id_dusun = $('#dusun').val();
				

				if(id_dusun != 'all'){
					$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rw')}}",
					
					data : {id:id_dusun},

					success: function(msg){
						msg = "<option data-tokens='all' value='all'>All RW</option>" + msg
						$('#rw').selectpicker('destroy');
						$('#rw').html(msg);
						$('#rw').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
				
				}
				else{
					$('#rw').selectpicker('destroy');
					$('#rw').html('');
					$('#rw').selectpicker('refresh');
					$('#rt').selectpicker('destroy');
					$('#rt').html('');
					$('#rt').selectpicker('refresh');
				}
				$.ajax({
					type : 'GET',
					url: "{{route('users.dusun-count')}}",
					
					data : {id:id_dusun},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data']
						barChartVar.update();
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
				
			});
			$('#rw').on('change',function(){
				$('#rw').selectpicker('render');
				let id_rw = $('#rw').val();
				let id_dusun = $('#dusun').val();

				if(id_rw != 'all'){
					$.ajax({
					type : 'GET',
					url: "{{route('master-desa.get-rt')}}",
					
					data : {id:id_rw},

					success: function(msg){
						msg = "<option data-tokens='all' value='all'>All RT</option>" + msg
						$('#rt').selectpicker('destroy');
						$('#rt').html(msg);
						$('#rt').selectpicker('render');
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
				}
				else{
					$('#rt').selectpicker('destroy');
					$('#rt').html('');
					$('#rt').selectpicker('refresh');
					
				}
				$.ajax({
					type : 'GET',
					url: "{{route('users.rw-count')}}",
					
					data : {id:id_rw,dusun_id:id_dusun},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data']
						barChartVar.update();
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
  }
  document.getElementById("download-image").addEventListener('click', function(){
  var url_base64jp = document.getElementById("barChart").toDataURL("image/jpg");
  var a =  document.getElementById("download-image");
  a.href = url_base64jp;
});

var myGroup = $('#myGroup');

myGroup.on('show.bs.collapse','.collapse', function() {
   myGroup.find('.collapse.show').collapse('hide');
});

});

</script>
@endpush



@endsection