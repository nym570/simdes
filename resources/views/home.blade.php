@extends('layouts.app')
@section('container')
<div class="row mb-4 g-4">
	<div class="col-md-6">
	  <div class="card h-100">
		<div class="card-body row widget-separator">
		  <div class="col-sm-5 border-shift border-end">
			<h1 class="text-primary text-center mb-0">{{$data['warga']['status']['warga']}}</h1>
			<h5 class=" text-center">Warga Desa berdomisili di Desa {{$desa['desa']}}</h5>

		  </div>
  
		  <div class="col-sm-7 gy-1 text-nowrap d-flex flex-column justify-content-between ps-4 gap-2 pe-3">
			<div id="KTPStatisticsChart">
				<canvas id="KTPChart" class="chartjs" data-height="110"></canvas>
			  </div>

		  </div>
		  @if(isset($data['warga']['status']['sementara tidak berdomisili']))
		
			<small class="text-muted text-center mt-2">Terdapat {{$data['warga']['status']['sementara tidak berdomisili']}} warga yang tinggal ditempat lain karena bekerja/bersekolah </small>
		@endif
	    </div>
		
	</div>
	
</div><div class="col-md-6">
	<div class="card h-100">
	  <div class="card-body row widget-separator">
		<div class="col-sm-5 border-shift border-end">
		  <h1 class="text-primary text-center mb-0">{{$data['ruta']}}</h1>
		  <h3 class=" text-center">Rumah Tangga</h3>
		</div>

		<div class="col-sm-7 gy-1 text-nowrap d-flex flex-column justify-content-between ps-4 gap-2 pe-3">
		 	<p class="text-muted text-wrap">Rumah Tangga adalah seseorang atau sekelompok orang yang mendiami suatu bangunan</p>
			<small class="text-muted text-wrap">- Badan Pusat Statistik -</small>
		</div>
	  </div>
  </div>
</div>
	
  
<div class="row g-4 mb-4">
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Lahir</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kelahiran']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-primary">
				<i class="bx bx-user bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Mati</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kematian']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-danger">
				<i class="bx bx-user-check bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Datang</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kedatangan']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-success">
				<i class="bx bx-group bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	<div class="col-sm-6 col-xl-3">
	  <div class="card">
		<div class="card-body">
		  <div class="d-flex align-items-start justify-content-between">
			<div class="content-left">
			  <span>Pindah</span>
			  <div class="d-flex align-items-end mt-2">
				<h4 class="mb-0 me-2">{{$data['kepindahan']}}</h4>
			  </div>
			</div>
			<div class="avatar">
			  <span class="avatar-initial rounded bg-label-warning">
				<i class="bx bx-user-voice bx-sm"></i>
			  </span>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
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

  const KTPChart = document.getElementById('KTPChart');
  if (KTPChart) {
    const KTPChartVar = new Chart(KTPChart, {
      type: 'bar',
      data: {
        labels: @json($data['warga']['graph']['label']),
        datasets: [
          {
            data: @json($data['warga']['graph']['data']),
            backgroundColor: orangeColor,
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
                text: 'Warga Berdasarkan Kepemilikan KTP'
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
				max:Math.max(...@json($data['warga']['graph']['data']))+2,
            grid: {
				
              color: borderColor,
              drawBorder: false,
              borderColor: borderColor
            },
            ticks: {
				stepSize:	 Math.max(...@json($data['warga']['graph']['data']))%5,
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


    });




</script>
@endpush
@endsection
