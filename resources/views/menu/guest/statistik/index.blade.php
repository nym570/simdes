@extends('layouts.app')
@section('container')
<div class="card mb-4">
	<div class="card-header">
		<h4 class="text-center">{{$title}} Filter</h4>
	</div>
	<div class="card-body">
		<div class="row g-4">
			<div class="col mb-3">
				<select id="dusun" class="selectpicker w-100" data-style="btn-default" data-live-search="false" name="dusun_id" required>
					
				</select>
			</div>
			<div class="col mb-3">
				<select id="rw" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="RW" name="rw_id" required>
					
				</select>
			</div>
			<div class="col mb-3">
				<select id="rt" class="selectpicker w-100" data-style="btn-default" data-live-search="true" title="RT" name="rt_id" required>
					
				</select>
			</div>
			<div class="col mb-3">
				<div class="btn-group ">
					<button class="btn  btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					  Download
					</button>
					<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					  <li><a class="dropdown-item" download="warga-agama-barchart.jpg" href="" id="download-bar">Barchart</a></li>
					  <li><a class="dropdown-item" download="warga-agama-doughnut.jpg" href="" id="download-dou">Doughnutchart</a></li>
					  <li><a class="dropdown-item" id="download-tab">Tabel</a></li>
					</ul>
				  </div>
			</div>

		</div>
		
	</div>
</div>
<div class="row">
	<!-- Delivery Performance -->
	<div class="col-lg-6 col-xxl-4 mb-4 order-2 order-xxl-2">
	  <div class="card h-100">
		<div class="card-header d-flex align-items-center justify-content-between">
		  <div class="card-title mb-0">
			<h5 class="m-0 me-2">Tabel {{$title}}</h5>
		  </div>
		</div>
		<div class="card-body">
			<div class="table-responsive" id="tab1">
				<table class="table table-striped table-bordered mb-4">
					<thead>
						<tr>
							<th>{{ __($category) }}</th>
							<th>{{ __('Jumlah') }}</th>
							<th>{{ __('Persentase') }}</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			
	

			</div>
			
			
		  </ul>
		</div>
	  </div>
	</div>
	<!-- Shipment statistics-->
	<div class="col-lg-6 col-xxl-6 mb-4 order-1 order-xxl-1">
	  <div class="card h-100">

		<div class="card-body">
			
			<div class="nav-align-top">
				<ul class="nav nav-pills mb-3" role="tablist">
				  <li class="nav-item">
					<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">Bar</button>
				  </li>
				  <li class="nav-item">
					<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile" aria-selected="false">Pie</button>
				  </li>

				</ul>
				<div class="tab-content">
				  <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">
					<div id="shipmentStatisticsChart">
						<canvas id="barChart" class="chartjs" data-height="300"></canvas>
					  </div>
				  </div>
				  <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
					<div id="shipmentStatisticsChart">
						<canvas id="doughnutChart" class="chartjs" data-height="250" ></canvas>
					  </div>
				  </div>
				</div>
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
	<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>

	
<script>
	
	'use strict';
	$( document ).ready(function() {
			
			$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		let cat = "<?=$category?>";
		
		let route = @json($route);
		$("#download-tab").click(function(){
        TableToExcel.convert(document.getElementById("tab1"), {
            name: "Warga Berdasarkan "+ cat +".xlsx",
            sheet: {
            name: "Sheet1"
            }
          });
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


// Color Variables
const doughnutChart = document.getElementById('doughnutChart');

 

  // Bar Chart
  // --------------------------------------------------------------------
  const barChart = document.getElementById('barChart');
  if (barChart&&doughnutChart) {
	var nama ="<?=$desa->desa?>";
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
                text: 'Warga Domisili Desa '+nama+ ' Berdasarkan '+cat
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
            },
			display: false,
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

	const doughnutChartVar = new Chart(doughnutChart, {
    type: 'doughnut',
    data: {
      labels: [],
      datasets: [
        {
          data: [],
		  
          backgroundColor: [purpleColor,yellowColor,orangeColor, cyanColor, orangeLightColor,oceanBlueColor, greyColor,greyLightColor,blueColor, blueLightColor,config.colors.primary],
          borderWidth: 0,
          pointStyle: 'rectRounded'
        }
      ]
    },
    options: {
      responsive: true,
      animation: {
        duration: 500
      },
      cutout: '65%',
      plugins: {
		
		title: {
                display: true,
                text: 'Warga Domisili Desa '+nama+ ' Berdasarkan '+cat
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
                  text: `${label} (${Math.round(data.datasets[0].data[i] * 100 / max)}%)`,
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
        tooltip: {
          callbacks: {
            label: function (context) {
              const label = context.labels || '',
                value = context.parsed;
              const output = ' ' + label + ' : ' +Math.round(value*100/context.chart._metasets[0].total)   + ' %';
              return output;
            }
          },
          // Updated default tooltip UI
          backgroundColor: cardColor,
          titleColor: headingColor,
          bodyColor: legendColor,
          borderWidth: 1,
          borderColor: borderColor
        }
      }
    }
  });




    

	$.ajax({
					type : 'GET',
					url: route.dusun,
					
					data : {id:'all'},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data'];
						barChartVar.options.scales.y.max = Math.max(...hasil['data'])+2;
						barChartVar.options.scales.y.ticks.stepSize = Math.max(...hasil['data'])%5;
						barChartVar.update();
						doughnutChartVar.data.labels = hasil['label'];
						doughnutChartVar.data.datasets[0].data = hasil['data'];
						doughnutChartVar.update();
						var tabel = '';
						var sum =  hasil['data'].reduce((accumulator, currentValue) => accumulator + currentValue, 0);
						for(var i=0; i<hasil.label.length; i++){
							tabel += '<tr><td>'+hasil['label'][i]+'</td><td>'+hasil['data'][i]+'</td><td>'+Math.round(hasil['data'][i]*100/sum)+'%</td></tr>';
						}
						if(hasil.label.length>0){
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong>100%</strong></td></tr>';
						}
						else{
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong></strong></td></tr>';
						}
						
						$('tbody').html(tabel);
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
					url: route.dusun,
					
					data : {id:id_dusun},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data']
						barChartVar.options.plugins.title.text = 'Warga Domisili Desa '+nama+' '+ $("#dusun option:selected").text() +' Berdasarkan '+cat;
						doughnutChartVar.options.plugins.title.text = 'Warga Domisili Desa '+nama+' '+ $("#dusun option:selected").text() +' Berdasarkan '+cat;
						barChartVar.update();
						doughnutChartVar.data.labels = hasil['label'];
						doughnutChartVar.data.datasets[0].data = hasil['data'];
						doughnutChartVar.update();
						var tabel = '';
						var sum =  hasil['data'].reduce((accumulator, currentValue) => accumulator + currentValue, 0);
						for(var i=0; i<hasil.label.length; i++){
							tabel += '<tr><td>'+hasil['label'][i]+'</td><td>'+hasil['data'][i]+'</td><td>'+Math.round(hasil['data'][i]*100/sum)+'%</td></tr>';
						}
						if(hasil.label.length>0){
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong>100%</strong></td></tr>';
						}
						else{
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong></strong></td></tr>';
						}
						
						$('tbody').html(tabel);
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
					url: route.rw,
					
					data : {id:id_rw,dusun_id:id_dusun},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data'];
						barChartVar.options.plugins.title.text = 'Warga Domisili Desa '+nama+' '+ $("#rw option:selected").text() +' Berdasarkan '+cat;
						doughnutChartVar.options.plugins.title.text = 'Warga Domisili Desa '+nama+' '+ $("#rw option:selected").text() +' Berdasarkan '+cat;
						barChartVar.update();
						doughnutChartVar.data.labels = hasil['label'];
						doughnutChartVar.data.datasets[0].data = hasil['data'];
						doughnutChartVar.update();
						var tabel = '';
						var sum =  hasil['data'].reduce((accumulator, currentValue) => accumulator + currentValue, 0);
						for(var i=0; i<hasil.label.length; i++){
							tabel += '<tr><td>'+hasil['label'][i]+'</td><td>'+hasil['data'][i]+'</td><td>'+Math.round(hasil['data'][i]*100/sum)+'%</td></tr>';
						}
						if(hasil.label.length>0){
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong>100%</strong></td></tr>';
						}
						else{
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong></strong></td></tr>';
						}
						
						$('tbody').html(tabel);
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
			$('#rt').on('change',function(){
				$('#rt').selectpicker('render');
				let id_rt = $('#rt').val();
				let id_rw = $('#rw').val();
				let id_dusun = $('#dusun').val();
				$.ajax({
					type : 'GET',
					url: route.rt,
					
					data : {id:id_rt,rw_id:id_rw,dusun_id:id_dusun},

					success: function(msg){
						let hasil = JSON.parse(msg);
						barChartVar.data.labels = hasil['label'];
						barChartVar.data.datasets[0].data = hasil['data'];
						barChartVar.options.plugins.title.text = 'Warga Domisili Desa '+nama+' '+ $("#rt option:selected").text() +' Berdasarkan '+cat;
						doughnutChartVar.options.plugins.title.text = 'Warga Domisili Desa '+nama+' '+ $("#rt option:selected").text() +' Berdasarkan '+cat;
						barChartVar.update();
						doughnutChartVar.data.labels = hasil['label'];
						doughnutChartVar.data.datasets[0].data = hasil['data'];
						doughnutChartVar.update();
						var tabel = '';
						var sum =  hasil['data'].reduce((accumulator, currentValue) => accumulator + currentValue, 0);
						for(var i=0; i<hasil.label.length; i++){
							tabel += '<tr><td>'+hasil['label'][i]+'</td><td>'+hasil['data'][i]+'</td><td>'+Math.round(hasil['data'][i]*100/sum)+'%</td></tr>';
						}
						if(hasil.label.length>0){
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong>100%</strong></td></tr>';
						}
						else{
							tabel += '<tr><td><strong>Total</strong></td><td><strong>'+sum+'</strong></td><td><strong></strong></td></tr>';
						}
						
						$('tbody').html(tabel);
					},
					error: function (xhr) {
						var err = JSON.parse(xhr.responseText);
						alert(err.message);
					}
					
				})
			});
  }
  document.getElementById("download-bar").addEventListener('click', function(){
  var url_base64jp = document.getElementById("barChart").toDataURL("image/jpg");
  var a =  document.getElementById("download-bar");
  a.href = url_base64jp;
});
document.getElementById("download-dou").addEventListener('click', function(){
  var url_base64jp = document.getElementById("doughnutChart").toDataURL("image/jpg");
  var a =  document.getElementById("download-dou");
  a.href = url_base64jp;
});

});

</script>
@endpush



@endsection