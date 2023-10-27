@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h3 class="card-title">Publishers</h3>
          <hr />
          <br>
          
					<div class="bg-light-gray border-radius-4" style="padding: 13px;margin-bottom: 40px;">
						<div id="date-range" class="mbot15 fadeIn">
							<div class="row">
							<div class="col-md-6">
								<label for="report-from" class="control-label">Por Data</label>
								<div class="input-group date2">
									<input type="text" class="form-control date display-years" id="report-from" name="report-from" value="" data-date-format="dd-mm-yyyy">
									<div class="input-group-addon">
										<i class="fa fa-calendar calendar-icon"></i>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<label for="report-to" class="control-label">Até a Data</label>
								<div class="input-group date2">
									<input type="text" class="form-control date display-years" disabled="disabled" id="report-to" name="report-to" value="" data-date-format="dd-mm-yyyy">
									<div class="input-group-addon">
										<i class="fa fa-calendar calendar-icon"></i>
									</div>
								</div>
							</div>
							</div>
						</div>
          </div>
				
        
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Empresa</th>
                <th scope="col">Sub-total</th>
                <th scope="col">Taxa</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($informations as $dado)
              <tr>
                <td>{{$dado->id_user}}</td>
                <td>{{$dado->name}}</td>
                <td>$ {{Helper::moedaView($dado->total)}}</td>
                <td>2%</td>
                <td>$ {{Helper::moedaView($dado->total)}}</td>
              </tr>
              @empty
              <tr>
                <td colspan="100">Nenhum resultado encontrado</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
        
      </div>
    </div>
  </div>
</div>
</div>

@endsection

@section('scripts')
<script>
    var report_from = $('input[name="report-from"]');
 		var report_to = $('input[name="report-to"]');

		 report_from.on('change', function() {
			var val = $(this).val();
			var report_to_val = report_to.val();
			if (val != '') {
			report_to.attr('disabled', false);
			if (report_to_val != '') {
				var from = report_from.val();
				var to = report_to.val();
				window.location.href = "?from="+from+"&to="+to;
			}
			} else {
			report_to.attr('disabled', true);
			}
		});

		report_to.on('change', function() {
			var val = $(this).val();
			if (val != '') {
				var from = report_from.val();
				var to = report_to.val();
				window.location.href = "?from="+from+"&to="+to;
			}
   		});
</script>
@endsection