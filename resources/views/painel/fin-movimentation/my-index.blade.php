@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          
        <div style="float:left;width:100%;border-bottom: 1px solid #ccc;padding-bottom: 16px;margin-bottom: 20px;">
          <h3 class="card-title" style="float:left;; margin-top:20px;">Histórico Financeiro</h3>                 
        </div>
          
          <br>
                    
					<div class="bg-light-gray border-radius-4" style="padding: 13px;margin-bottom: 40px;display:none">
						<div id="date-range" class="mbot15 fadeIn">
							<div class="row">
							<div class="col-md-3">
								<label for="report-from" class="control-label">Por Data</label>
								<div class="input-group date2">
									<input type="text" class="form-control date display-years" id="report-from" name="report-from" value="" data-date-format="dd-mm-yyyy">
									<div class="input-group-addon">
										<i class="fa fa-calendar calendar-icon"></i>
									</div>
								</div>
							</div>
							
              <div class="col-md-3">
								<label for="report-to" class="control-label">Até a Data</label>
								<div class="input-group date2">
									<input type="text" class="form-control date display-years" disabled="disabled" id="report-to" name="report-to" value="" data-date-format="dd-mm-yyyy">
									<div class="input-group-addon">
										<i class="fa fa-calendar calendar-icon"></i>
									</div>
								</div>
							</div>
              
              <div class="col-md-3">
								<label for="categoria" class="control-label">Status</label>
								<div class="input-group">
									<select class="form-control" name="status" id="">
                    <option value="0">Todas</option>
                    <option value="1">Em aberto</option>
                    <option value="2">Pago</option>
                  </select>
								</div>
							</div>
              
              <div class="col-md-3">
								<label for="categoria" class="control-label">Catêgoria</label>
								<div class="input-group">
									<select class="form-control" name="category">
                    <option value="0">Todas</option>
                    <?php 
                      foreach ($categories as $key => $categorie) {
                     ?>
                     <option value="<?php echo $key ?>"><?php echo $categorie ?></option>
                     <?php
                      }
                    ?>
                  </select>
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
                <th scope="col">Vencimento</th>
                <th scope="col">Valor</th>
                <th scope="col">Comprovante</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>{{$dado['id_fin_movimentation']}}</td>
                <td>{{Helper::formatData($dado['date_expiry'],2)}}</td>
                <td>
                  <?php 
                  $total = $dado['value']+$dado['tax'];
                  $total = $dado['value'];
                  ?>
                  {{$currencies[$dado['id_fin_currency']]}} {{Helper::moedaView($total)}}
                  
                </td>
                <td>
                    <?php 
                      if($dado['file']){
                        ?>
                          <a class="btn btn-info" href="/assets/painel/uploads/recibos/{{$dado['file']}}" download>Baixar</a>
                        <?php
                      }
                    ?>
                </td>
                <td>{{Helper::statusType($dado['status'],$dado['type'])}}</td>
                
              </tr>
              <tr>
              <tr>
				<td id="{{$dado['id_user']}}" colspan="5" style="background:#f7f6f7; padding:10px 0;">
					<table class="table table-sm" style="background:#f7f6f7">
						<thead >
							<tr>
								<th scope="col" style="border-top:0;padding-left:15px;"> | </th>
								<th scope="col" style="border-top:0;">Dominio</th>
								<th scope="col" style="border-top:0;">Total</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach($dado['report'] as $rp) { ?>
							<tr>
								<td style="padding-left:15px;"> | </td>
								<td><a href="/painel/users/clients/{{$dado['id_user']}}">{{$rp->site}}</a></td>
								<td>$ {{Helper::moedaView($rp->total)}}</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</td>
			  </tr>
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
@endsection