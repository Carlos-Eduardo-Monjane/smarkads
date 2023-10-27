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
	  <?php if(isset($aviso)) {  ?>
		<div class="card-body">
			<center><h4>Selecione uma data <i class="fa fa-arrow-up" aria-hidden="true"></i></h4></center>
		</div>
	  <?php } else { ?>
      <div class="card-body">
        <div class="table-responsive">
          
		  <table class="table mb-0">
            
			<thead class="thead-light">
              <tr>
                <th scope="col"></th>
                <th scope="col">Cód.</th>
                <th scope="col">Empresa</th>
                <th scope="col">SubTotal</th>
                <th scope="col">Inválidos</th>
                <th scope="col">Total</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            
			<tbody>
				<?php $total = 0; $invalido=0; $subtotal=0;  ?>
              @forelse($informations as $dado)
			  
              <tr>
			  	<td> <span data-id="{{$dado['id_user']}}" class="togle" style="cursor:pointer">+</span> </td>
                <td><a href="/painel/users/show/{{$dado['id_user']}}">{{$dado['id_user']}}</a></td>
                <td>
					<a href="/painel/users/show/{{$dado['id_user']}}"><?php 
						if(empty($dado['company'])) {
							echo $dado['name'];
						} else {
							echo $dado['company'];
						}
					?></a>
				</td>
                <td>R$ {{Helper::moedaView($dado['total'])}} <?php $subtotal +=$dado['total']; ?></td>
                <td>R$ {{Helper::moedaView($dado['invalid'])}} <?php $invalido +=$dado['invalid']; ?></td>
                <td>R$ {{Helper::moedaView(($dado['total']-$dado['invalid']))}} <?php $total +=($dado['total']-$dado['invalid']); ?></td>
                <td>


					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                  	</a>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                   
					<?php 
					
					$tf = ($dado['total']-$dado['invalid']);
					if($tf > 100){ ?>
					<a href="#" 
					   data-id_user="{{$dado['id_user']}}" 
					   data-value="{{$tf}}" 
					   data-ids="{{$dado['geral_ids']}}" 
					   class="dropdown-item pagar"
					   ><i class="fa fa-money"></i> PAGAR</a>
					<?php } ?>

					<a href="/painel/fin-invalid/create/{{$dado['id_user']}}/{{$dado['month']}}/{{$dado['year']}}" 
					   class="dropdown-item"
					   ><i class="fa fa-minus-circle" aria-hidden="true"></i> INVÁLIDOS</a>	
					</td>
                  </div>
					
              </tr>
			  <tr>
				<td id="{{$dado['id_user']}}" colspan="7" style="background:#f7f6f7; padding:10px 0;display:none;">
					<table class="table table-sm" style="background:#f7f6f7">
						<thead >
							<tr>
								<th scope="col" style="border-top:0;padding-left:15px;"> | </th>
								<th scope="col" style="border-top:0;">Cód.</th>
								<th scope="col" style="border-top:0;">Dominio</th>
								<th scope="col" style="border-top:0;">Total</th>
								<th scope="col" style="border-top:0;">Ações</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($dado['report'] as $rp) { ?>
							<tr>
								<td style="padding-left:15px;"> | </td>
								<td>{{$rp['id_domain']}}</td>
								<td><a href="/painel/users/clients/{{$dado['id_user']}}">{{$rp['domain']}}</a></td>
								<td>R$ {{Helper::moedaView($rp['total'])}}</td>
								<td>
									<?php if($rp['status']==4) { ?>
									<a href="#" data-id="{{$rp['id_domain']}}" class="btn btn-icon btn-round btn-info acao" title="Congelar">
										<i class="fa fa-snowflake-o" aria-hidden="true"></i>
									</a>
									<?php } else { ?>
									<a href="#" data-id="{{$rp['id_domain']}}" class="btn btn-icon btn-round btn-danger acao" title="Descongelar">
										<i class="fa fa-free-code-camp" aria-hidden="true"></i>
									</a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</td>
			  </tr>
			  
              @empty
              <tr>
                <td colspan="100">Nenhum resultado encontrado</td>
              </tr>
              @endforelse
			  <tr>
				<td colspan="3">Total</td>
				<td colspan="1"><strong>$ <?php echo Helper::moedaView($subtotal); ?></strong></td>
				<td colspan="1"><strong>$ <?php echo Helper::moedaView($invalido); ?></strong></td>
				<td colspan="3"><strong>$ <?php echo Helper::moedaView($total); ?></strong></td>
			  </tr>
            </tbody>
          
		  </table>


        </div>
        <hr><br />
		<h3>Antigos</h3>
		<hr><br />
		<div class="table-responsive">
          
		  <table class="table mb-0">
            
			<thead class="thead-light">
              <tr>
                <th scope="col"></th>
                <th scope="col">Cód.</th>
                <th scope="col">Empresa</th>
                <th scope="col">Total</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            
			<tbody>
			  <?php $total_prev = 0; ?>
              @forelse($informations_back as $dado)
			  
              <tr>
			  	<td> <span data-id="d{{$dado['id_user']}}" class="togle" style="cursor:pointer">+</span> </td>
                <td>{{$dado['id_user']}}</td>
                <td>
					<?php 
						if(empty($dado['company'])) {
							echo $dado['name'];
						} else {
							echo $dado['company'];
						}
					?>
				</td>
                <td>R$ {{Helper::moedaView($dado['total'])}} <?php $total_prev+=$dado['total'] ?></td>
                <td>
				
					<?php if($dado['total'] > 100){ ?>
					<a href="#" 
					   data-id_user="{{$dado['id_user']}}" 
					   data-value="{{$dado['total']}}" 
					   data-ids="{{$dado['geral_ids']}}" 
					   class="btn btn-info pagar"
					   style="float:right">PAGAR</a>
					<?php } ?>
              </tr>
			  <tr>
				<td id="d{{$dado['id_user']}}" colspan="5" style="background:#f7f6f7; padding:10px 0;display:none">
					<table class="table table-sm" style="background:#f7f6f7">
						<thead >
							<tr>
								<th scope="col" style="border-top:0;padding-left:15px;"> | </th>
								<th scope="col" style="border-top:0;">Mês</th>
								<th scope="col" style="border-top:0;">Cód.</th>
								<th scope="col" style="border-top:0;">Dominio</th>
								<th scope="col" style="border-top:0;">Total</th>
								<th scope="col" style="border-top:0;">Ações</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($dado['report'] as $rp) { ?>
							<tr>
								<td style="padding-left:15px;"> | </td>
								<td><?php if($rp['month'] < 10){echo '0'; } ?>{{$rp['month']}}/{{$rp['year']}} </td>
								<td>{{$rp['id_domain']}}</td>
								<td><a href="/painel/users/clients/{{$dado['id_user']}}">{{$rp['domain']}}</a></td>
								<td>R$ {{Helper::moedaView($rp['total'])}}</td>
								<td>
									<?php if($rp['status']==4) { ?>
									<a href="#" data-id="{{$rp['id_domain']}}" class="btn btn-icon btn-round btn-info acao" title="Congelar">
										<i class="fa fa-snowflake-o" aria-hidden="true"></i>
									</a>
									<?php } else { ?>
									<a href="#" data-id="{{$rp['id_domain']}}" class="btn btn-icon btn-round btn-danger acao" title="Descongelar">
										<i class="fa fa-free-code-camp" aria-hidden="true"></i>
									</a>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</td>
			  </tr>
			  
              @empty
              <tr>
                <td colspan="100">Nenhum resultado encontrado</td>
              </tr>
              @endforelse
			  <tr>
				<td colspan="3">Total</td>
				<td colspan="2"><strong>$ <?php echo Helper::moedaView($total_prev); ?></strong></td>
			  </tr>
            </tbody>
          
		  </table>


        </div>
      </div>
		<?php } ?>
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

		$('.pagar').click(function(e){
			e.preventDefault();
			$(this).text('Carregando...');
			$(this).attr('disabled',true);

			var ids 	= $(this).attr('data-ids');
			var id_user = $(this).attr('data-id_user');
			var value 	= $(this).attr('data-value');

			var formData = new FormData();
        	formData.append('ids',ids);
        	formData.append('id_client',id_user);
        	formData.append('value',value);
        	formData.append('_token','<?php echo csrf_token() ?>');

			$.ajax({
				type: "POST",
				url: "/painel/fin-movimentation/publisher_x_movimentation",
				data: formData,
				cache:false,
            	contentType: false,
            	processData: false,
				success: function (response) {
					var $saida = JSON.parse(response)
					if(!alert($saida.msg)){window.location.reload();}
				}
			});
		});

		$('.togle').click(function(){
			var id = $(this).attr('data-id');
			$('#'+id).fadeToggle('slow');
		})

		$('.acao').click(function(e){
          e.preventDefault();
          $(this).text('Carregando...');
          $(this).attr('disabled',true);

          var id 	    = $(this).attr('data-id');

          $.ajax({
            type: "GET",
            url: "/painel/domain/change-status/"+id,
            cache:false,
                  contentType: false,
                  processData: false,
            success: function (response) {
              var $saida = JSON.parse(response)
              if(!alert('Ação Realizada com sucesso')){window.location.reload();}
            }
          });
        });
</script>
@endsection