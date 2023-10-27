@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          
          <div class="row">
				<div class="_buttons" style="width:100%;padding:10px;box-sizing:border-box;margin-bottom:30px;">
					
					<a href="/{{$principal}}/{{$rota}}/" class="btn btn-info">Voltar</a>
					
				</div>
            </div>     

            <h3 class="card-title" ><?php echo $title ?></h3>  


            

            <div class="row">
              <div class="col-md-12">
              <hr class="hr-panel-heading">
              </div>
             
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">USD {{$information['formatted_total_value']}}</h3>
                          <span class="text-info">Dolar</span>
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">BRL {{$information['formatted_total_final_value']}}</h3>
                          <span class="text-info">Real</span>
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">{{$information['number_of_transaction']}}</h3>
                          <span class="text-info">Transações</span>
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">{{$information['processed']}}%</h3>
                          <span class="text-info">Processamento</span>
              </div>
              
              
          </div>


          <br>        
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
				<th scope="col">Cliente</th>
				<th scope="col">Cambio</th>
				<th scope="col">Dolar</th>
				<th scope="col">Real</th>
				<th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $client)
              <tr>
							<td><?php echo $client['id'] ?></td>
							<td><?php echo $client['user_name'] ?></td>
							<td><?php echo number_format($client['market_rate'],2) ?></td>
							<td><?php echo ($client['formatted_value']) ?></td>
							<td><?php echo ($client['formatted_final_value']) ?></td>
							<td>
								<span data-toggle="tooltip" data-placement="top" title="<?php echo $client['message'] ?>"><?php echo ucfirst($client['status']) ?></span>
								
								<?php if($client['_links']['bank_transfer_receipt'] != '/broker_receipts/original/missing.png'){ ?>
									<br /><a href="<?php echo $client['_links']['bank_transfer_receipt'];?>">Recibo</a> 
								<?php } ?>
							</td>
							
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