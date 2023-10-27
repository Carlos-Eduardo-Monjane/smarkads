@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          
        <div style="float:left;width:100%;border-bottom: 1px solid #ccc;padding-bottom: 16px;margin-bottom: 20px;">
          <h3 class="card-title" style="float:left;; margin-top:20px;">Movimentações</h3>
         
          <div style="float:right; margin-top:20px;">
            <b>Cadastrar: </b>
            <a href="/{{$principal}}/{{$rota}}/create/1" class="btn btn-danger">Despesas</a>
            <a href="/{{$principal}}/{{$rota}}/create/2" class="btn btn-success">Receitas</a>
            <a href="/{{$principal}}/{{$rota}}/create/3" class="btn btn-info">Pró-labore</a>
            <a href="/{{$principal}}/{{$rota}}/create/4" class="btn btn-primary ">Impostos</a>
          </div>
</div>
<h4>Carteira: </h4>
        <?php foreach($banks as $id_bankx => $bank){ ?>
        <a href="/painel/fin-movimentation/<?php echo $id_bankx ?>" class="btn btn-primary"><?php echo $bank ?></a>
        <?php } ?>
        <?php 
            $url = $_SERVER['REQUEST_URI'];
            if(strstr($url,'?')){
              $url = $url.'&pagos=true';
            } else {
              $url = $url.'?pagos=true';
            }
          
          ?>
          
          <a href="{{$url}}" class="btn btn-info">Filtrar Pagos</a>
          <br />
          <br />

<?php if(isset($id_bank)){ ?>
          
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

          <?php

            $prolabore[1] = 0;
            $prolabore[2] = 0;
            $receita[1]= 0;
            $receita[2] = 0;
            $despesa[1]= 0;
            $despesa[2] = 0;

            foreach ($data as $key => $value) {
         
              if($value->type == 1){
                $despesa[$value->id_fin_currency]  += ($value->value+$value->tax);
              }

              if($value->type == 2){
                $receita[$value->id_fin_currency] += ($value->value+$value->tax);
              }

              if($value->type == 3){
                $prolabore[$value->id_fin_currency]  += ($value->value+$value->tax);
              }

            }

            

            $balanco[1]= $receita[1]-($despesa[1]+$prolabore[1]);
            $balanco[2] = $receita[2]-($despesa[2]+$prolabore[2]);
            ?>

            <div class="col-md-12">
                          <h4 class="no-margin text-success">Resumo Financeiro - <?php echo $banks[$id_bank] ?> <?php if(isset($_GET['from'])) { echo '<br />Filtro Data: '.$_GET['from'].' a '.$_GET['to']; } ?></h4>
              </div>

            <?php
            for ($i=1; $i < 3; $i++) { 
            ?>

          <div class="row">
              <div class="col-md-12">
              <hr class="hr-panel-heading">
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">{{$currencies[$i]}} <?php echo number_format($receita[$i],2, ',', '.') ?></h3>
                          <span class="text-success">Receita</span>
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">{{$currencies[$i]}} <?php echo number_format($despesa[$i],2, ',', '.') ?></h3>
                          <span class="text-danger">Despesa</span>
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">{{$currencies[$i]}} <?php echo number_format($prolabore[$i],2, ',', '.'); ?></h3>
                          <span class="text-info">Prolabore</span>
              </div>
              <div class="col-md-3 border-right" style="text-align:center">
                          <h3 class="bold">{{$currencies[$i]}} <?php echo number_format($balanco[$i],2, ',', '.'); ?></h3>
                          <span class="text">Balanço</span>
              </div>
              
          </div>
            <?php } ?>
            <div class="col-md-12">
                <hr class="hr-panel-heading">
              </div>
			
				
        
        </div>
      </div>
      <div class="card-body">
        
        <div class="table-responsive">
          <table class="table mb-0" id="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Categoria</th>
                <th scope="col">Empresa</th>
                <th scope="col">Tipo</th>
                <th scope="col">Vencimento</th>
                <!-- <th scope="col">Pagamento</th> -->
                <th scope="col">Valor</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->id_fin_movimentation}}</a>
                </td>
                <td>
                  <span data-toggle="tooltip" data-placement="top" title="{{Helper::shout($categories[$dado->id_fin_category])}}">{{explode(' ',Helper::shout($categories[$dado->id_fin_category]))[0]}}</span>
                </td>
                <td>
                <a href="/painel/users/show/{{$dado->id_client}}" target="_blank"><?php 
                if(empty($dado->company)){
                  echo $dado->name;
                } else {
                  echo $dado->company;
                }
                ?></a>
                </td>
                <td>{{Helper::type($dado->type)}}</td>
                <td data-sort="{{$dado->date_expiry}}">{{Helper::formatData($dado->date_expiry,2)}}</td>
                <!-- <td>{{Helper::formatData($dado->date_payment,2)}}</td> -->
                <td>
                  <?php 
                  $total = $dado->value+$dado->tax;
                  ?>
                  {{$currencies[$dado->id_fin_currency]}} {{Helper::moedaView($total)}}
                  <?php if($dado->tax){ ?>
                  <br /><small>TAXA: {{Helper::moedaView($dado->tax)}}</small>
                  <br /><small>VALOR: {{Helper::moedaView($dado->value)}}</small>
                  <?php } ?>
                </td>
                
                <td>
                
                    <?php if(!empty($dado->file)){ ?>
                      <a style="color:#28a745!important" color="text-success" href="/assets/painel/uploads/recibos/{{$dado->file}}" target="_blank">{{Helper::statusType($dado->status,$dado->type)}}</a>
                    <?php } else { ?>
                      {{Helper::statusType($dado->status,$dado->type)}}
                    <?php } ?>
                    
                </td>
                
                <td>

                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                  </a>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <?php if($dado->husky_token && $mp && $dado->status == 1){ ?>
                    <a href="#"  data-currency="{{$dado->id_fin_currency}}" data-id="{{$dado->id_fin_movimentation}}" data-mp="{{$mp->id_husky}}" data-token="{{$dado->husky_token}}" data-value="{{$total}}" class="dropdown-item husky" title="Pagar com Husky">
                    <i class="fa fa-money"></i>  Pagar com husky
                    </a>
                    <?php } 
                    if($dado->status == 2) { ?>
                      <a href="/{{$principal}}/{{$rota}}/cpdf/{{$dado->$primaryKey}}" class="dropdown-item" title="Gerar Comprovante" target="_blank" download>
                        <i class="fa fa-file-excel-o" data-test="birl" aria-hidden="true"></i>  Gerar Comprovante
                      </a>
                    <?php } ?>
                    <a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                      <i class="far fa-edit"></i>  Editar
                    </a>
                    <form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
                      {!! csrf_field() !!}
                    </form>
                    <?php if(Auth::user()->id == '1255' || Auth::user()->id == '1260' || Auth::user()->id == '1288'){ ?>
                      <a href="#" class="dropdown-item" onclick="deletar({{$dado->$primaryKey}})" title="Remover"><i class="fa fa-trash"></i>  Excluir</button>
                    <?php } ?>
                  </div>
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
<?php } else { ?>
  <center><h4>Selecione uma carteira <i class="fa fa-arrow-up" aria-hidden="true"></i></h4></center>
<?php } ?>
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
        <?php if(strstr($_SERVER['REQUEST_URI'],'?')){ ?>
        window.location.href = "{{$_SERVER['REQUEST_URI']}}&from="+from+"&to="+to;
        <?php } else { ?>
          window.location.href = "{{$_SERVER['REQUEST_URI']}}?from="+from+"&to="+to;
        <?php } ?>
				
			}
   		});

       $('.husky').click(function(e){
          e.preventDefault();
          $(this).text('Carregando...');
          $(this).attr('disabled',true);

          var id 	    = $(this).attr('data-id');
          var mp      = $(this).attr('data-mp');
          var token 	= $(this).attr('data-token');
          var value 	= $(this).attr('data-value');
          var currency 	= $(this).attr('data-currency');

          var formData = new FormData();
              formData.append('id_fin_movimentation',id);
              formData.append('id_husky',mp);
              formData.append('token',token);
              formData.append('value',value);
              formData.append('currency',currency);
              formData.append('_token','<?php echo csrf_token() ?>');

          $.ajax({
            type: "POST",
            url: "/painel/fin-movimentation/add_mp",
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
</script>



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready( function () {
    $('#table').DataTable({
      "pageLength": 100,
      "order": [[ 4, "asc" ]],
      "language" : {
        "url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
      }
    });
} );
</script>


@endsection