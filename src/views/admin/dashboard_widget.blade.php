{{-- Theme::add('theme/bc/chart.js/Chart.js') --}}
{{ Theme::add('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js') }}
{{ Theme::add('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js') }}
{{ $row->createJsonFileChart() }}
{{ Theme::add('theme/js/dash.js') }}
{{-- Theme::add('theme/bc/AdminLTE/dist/js/pages/dashboard2.js') --}}
<div class="col-md-12">
	<div class="box panel panel-default">
		<div class="box-header with-border panel-heading">
			<h3 class="box-title"><a href="{{$area->url}}">{{ $area->area_define_name }}</a></h3>
			<div class="box-tools pull-right">
				<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
				</button>
				<div class="btn-group">
					<button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-wrench"></i></button>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Action</a></li>
						<li><a href="#">Another action</a></li>
						<li><a href="#">Something else here</a></li>
						<li class="divider"></li>
						<li><a href="#">Separated link</a></li>
					</ul>
				</div>
				<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-md-6">
						{{--
					<p class="text-center">
						@if($row->firstItem())
						{{ $row->firstItem()->updated_at->format('d/m/Y') }} - {{ $row->lastItem()->updated_at->format('d/m/Y') }}
						@endif
						<strong>Sales: 1 Jan, 2014 - 30 Jul, 2014</strong>
					</p>
					<div class="chart" style="">
						<!-- Sales Chart Canvas -->
						<canvas id="myChart1" style=" "></canvas>
					</div>
						--}}
					
					<canvas id="myChart" style="height:400px;"></canvas>
					<!-- /.chart-responsive -->
				</div>
				<!-- /.col -->
				<div class="col-md-6">
					<p class="text-center">
						<strong>Things</strong>
					</p>
					@foreach($row->types()->get() as $type)
					<div class="col-lg-3">
						<div class="panel panel-default"> 
							<div class="panel-heading">
							<a href="{{ url('admin/blog/'.App::getLocale().'/'.$type->guid) }}">{{ $type->guid }}</a>:<b>&nbsp;{{ number_format($type->archive()->count(),0,",","'") }}</b> 
							</div>

							
						</div>
					</div>
					@endforeach
					
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- ./box-body -->
		<div class="box-footer panel-footer">
			<!-- /.row -->
		</div>
		<!-- /.box-footer -->
	</div>
	<!-- /.box -->
</div>