@extends('painel.layouts.app')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="card card-statistics">
			<div class="card-header">
				<div class="card-heading">
					<h4 class="card-title">Checklist</h4>
					<div class="row" style="text-align: right;">
            <div class="col-md-12">
              <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
            </div>
          </div>
				</div>
			</div>
			<div class="card-body">
				<div class="datatable-wrapper table-responsive">
					<table id="datatable" class="display compact table table-striped table-bordered">
						<thead>
							<tr>
								<th scope="col">Site</th>
								@foreach($domainChecklist as $checklist)
								<th class="text-center" scope="col">{{$checklist->name}}</th>
								@endforeach
								<th class="text-center">Obs</th>
								<th scope="col">Remover</th>
							</tr>
						</thead>
						<tbody>
							@forelse($domains as $domain)
							<tr>
								<td>
									{{$domain->name}}
								</td>

								@foreach($domainChecklist as $checklist)
								@if(count($domainConfirmChecklist->where('id_domain', $domain->id_domain)->where('id_domain_checklist', $checklist->id_domain_checklist)) > 0)

								<th class="text-center" scope="col" id="check-domain-{{$domain->id_domain}}-checklist-{{$checklist->id_domain_checklist}}">
									<a onclick="uncheck({{$domain->id_domain}}, {{$checklist->id_domain_checklist}}, 'check-domain-{{$domain->id_domain}}-checklist-{{$checklist->id_domain_checklist}}')" href="javascript:void(0);" class="btn btn-icon btn-round btn-success"><i class="fa fa-check"></i></a>
								</th>
								@else
								<th class="text-center" scope="col" id="check-domain-{{$domain->id_domain}}-checklist-{{$checklist->id_domain_checklist}}">
									<a onclick="check({{$domain->id_domain}}, {{$checklist->id_domain_checklist}}, 'check-domain-{{$domain->id_domain}}-checklist-{{$checklist->id_domain_checklist}}')" href="javascript:void(0);" class="btn btn-icon btn-round btn-danger"><i class="fa fa-ban"></i></a>
								</th>
								@endif
								@endforeach
								<th class="text-center" scope="col">

								<a href="#" data-toggle="modal" data-target="#obs-modal-{{$domain->id_domain}}" class="btn btn-icon btn-round btn-info"><i class="fa fa-comments-o"></i></a>



								<div class="modal fade obs-modal-{{$domain->id_domain}}" id="obs-modal-{{$domain->id_domain}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">


										<div class="modal-dialog" role="document">

										<div class="modal-content">

											<div class="modal-header">
											<h4 class="modal-title" id="myModalLabel"><i class="fa fa-question-circle" data-toggle="tooltip"  data-placement="bottom"></i> Observações {{$domain->name}}</h4>

											<button type="button" class="close obs-modal-{{$domain->id_domain}}" data-rel-id="obs-modal-{{$domain->id_domain}}" data-rel-type="ticket" aria-label="Close" value="" data-dismiss="modal"><span aria-hidden="true">×</span></button>

											</div>

											<div class="modal-body">

																<div class="form-row">

																		<div class="form-group" style="width:100%;" >

																				<div class="input-group" style="width:100%;" >

																						<div style="width:100%;display:block;margin-botton:20px; text-align:left !important;">
																							<?php
																							$x = 1;
																							foreach ($domainObservations as $key => $domainObservation) {
																								if($domainObservation->id_domain == $domain->id_domain){
																									$x++ ;
																									if($x == 2){
																										echo '<p><b>Observações:</b><p>';
																									}

																									echo '<p>';
																									echo '<strong>Data:</strong> '.Helper::formatDateTime($domainObservation->created_at).'<br />';
																									echo '<strong>Por:</strong> '.$domainObservation->name.'<br /><strong>Informação:</strong> <br />';
																									echo nl2br($domainObservation->description);
																									echo '</p>';
																									echo '<hr />';

																								}

																							}
																							?>

																							<p><b>Observação: </b><br /><?php $x=0; ?>
																						</div>


																						<textarea class="form-control" name="description" id="description{{$domain->id_domain}}" cols="30" rows="3"></textarea>


																						<button class="btn btn-primary" id="saveObservation{{$domain->id_domain}}" onclick="saveObservation({{$domain->id_domain}}, description{{$domain->id_domain}}.value)">
																							<i class="fa fa-check"></i>
																						</button>

																				</div>

																		</div>

															</div>

												</div>

												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
												</div>
											</div>
											</div>
									</div>


								</th>

								<td class="text-center">
									<a href="/painel/domain-checklist/remove/{{$domain->id_domain}}" title="Atualizar/Visualizar">
										<img src="{{URL('assets/painel/img/close.png')}}" width="44" alt="">
									</a>
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
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script>

function saveObservation(id_domain, value){
	if(value != ''){

		$.ajax({
			type: "POST",
			url: "/{{$principal}}/{{$rota}}/save-observation",
			data: {
				'id_domain':id_domain,
				'value':value,
				'_token':'<?php echo csrf_token() ?>'
			},
			success: function (response) {
				Swal.fire("Obrigado!", "Informação salva com sucesso!", "success").then(function(){
					location.reload();
				});
			},
			error:function(response){
				console.debug(response);
			}
		});

	}
}

function check(id_domain, id_checklist, id_div) {
	Swal.fire({
		title: "Você concluiu essa melhoria?",
		type: "success",
		text: 'Deseja realmente marcar essa melhoria como concluida?',
		showCancelButton: true,
		confirmButtonClass: 'btn-success',
		confirmButtonText: 'Sim!',
		closeOnConfirm: false
		//closeOnCancel: false
	}).then((result) => {
		if (result.value) {
			$.get("/{{$principal}}/{{$rota}}/checked/"+id_domain+"/"+id_checklist, function(data, status){
				 Swal.fire("Obrigado!", "Informação salva com sucesso!", "success").then(function(){
					 location.reload();
				 });

			 });
		}
	});
};

function uncheck(id_domain, id_checklist, id_div) {
	Swal.fire({
		title: "Você quer remover essa melhoria?",
		type: "success",
		text: 'Deseja realmente marcar essa melhoria como cancelada?',
		showCancelButton: true,
		confirmButtonClass: 'btn-success',
		confirmButtonText: 'Sim!',
		closeOnConfirm: false
		//closeOnCancel: false
	}).then((result) => {
		if (result.value) {
			$.get("/{{$principal}}/{{$rota}}/unchecked/"+id_domain+"/"+id_checklist, function(data, status){
				 Swal.fire("Obrigado!", "Informação salva com sucesso!", "success").then(function(){
					 location.reload();
				 });
			 });
		}
	});
};


@if(!empty(session('filter')))
@if(session('filter') == 5)
$(".custon_date").show();
@endif
@endif

$(document).ready(function(){
	$("#filter").change(function(){
		if(this.value == 1){
			$(".custon_date").hide();
			$("#startDate").val("<?php echo date('d-m-Y') ?>");
			$("#endDate").val("<?php echo date('d-m-Y') ?>");
		}else if(this.value == 2){
			$(".custon_date").hide();
			$("#startDate").val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). " - 1 days")) ?>");
			$("#endDate").val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). " - 1 days")) ?>");
		}else if(this.value == 3){
			$(".custon_date").hide();
			$("#startDate").val("<?php echo date('01-m-Y') ?>");
			$("#endDate").val("<?php echo date('t-m-Y') ?>");
		}else if(this.value == 4){
			$(".custon_date").hide();
			$("#startDate").val("<?php echo date('01-m-Y', strtotime(date('d-m-Y'). " - 1 month")) ?>");
			$("#endDate").val("<?php echo date('t-m-Y', strtotime(date('d-m-Y'). " - 1 month")) ?>");
		}else if(this.value == 5){
			$(".custon_date").show();
			$("#startDate").val("<?php echo date('01-m-Y') ?>");
			$("#endDate").val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). " - 1 days")) ?>");
		}
	});
});
</script>
@endsection
