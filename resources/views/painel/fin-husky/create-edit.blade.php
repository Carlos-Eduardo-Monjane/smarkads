@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title"><?php echo $title; ?></h4>
        </div>
      </div>
      <div class="card-body">
        @if(isset($data->$primaryKey))
        <form method="POST" action="/{{$principal}}/{{$rota}}/update/{{$data->$primaryKey}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @else
          <form method="POST" action="/{{$principal}}/{{$rota}}/store" accept-charset="UTF-8" enctype="multipart/form-data">
            @endif
            @csrf

            <div class="row">
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Data de Vencimento</label>
                    <input type="text" class="form-control data" name="date_expiry" @if(old('date_expiry') != null) value="{{ old('date_expiry') }}" @elseif(isset($data->date_expiry)) value="{{$data->date_expiry}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Data de Pagamento</label>
                    <input type="text" class="form-control data" name="date_payment" @if(old('date_payment') != null) value="{{ old('date_payment') }}" @elseif(isset($data->date_payment)) value="{{$data->date_payment}}"  @endif>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Numero do Documento</label>
                    <input type="text" class="form-control" name="number_doc" @if(old('number_doc') != null) value="{{ old('number_doc') }}" @elseif(isset($data->number_doc)) value="{{$data->number_doc}}"  @endif>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Valor</label>
                    <input type="text" class="form-control valor" name="value" @if(old('value') != null) value="{{ old('value') }}" @elseif(isset($data->value)) value="{{$data->value}}"  @endif>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Mês Referencia</label>
                    <input type="text" class="form-control data_mes" name="month_reference" @if(old('month_reference') != null) value="{{ old('month_reference') }}" @elseif(isset($data->month_reference)) value="{{$data->month_reference}}"  @endif>
                  </div>
                </div>
              </div>
              
              <!-- <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Recorrência <small>(nº lançado)</small></label>
                    <input type="number" class="form-control" name="recorrency" value="0">
                  </div>
                </div>
              </div> -->

              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Moeda</label>
                    <select class="form-control"  name="id_fin_currency">
                      <option value="">Selecione</option>
                      @foreach($currencies as $key => $currence)
                      <option value="{{$key}}" @if(isset($data->id_fin_currency)) @if($data->id_fin_currency == $key) selected="true" @endif @endif>{{$currence}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Banco</label>
                    <select class="form-control"  name="id_fin_bank">
                      <option value="">Selecione</option>
                      @foreach($banks as $key => $bank)
                      <option value="{{$key}}" @if(isset($data->id_fin_bank)) @if($data->id_fin_bank == $key) selected="true" @endif @endif>{{$bank}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Forma pagamento</label>
                    <select class="form-control"  name="id_fin_form">
                      <option value="">Selecione</option>
                      @foreach($forms as $key => $form)
                      <option value="{{$key}}" @if(isset($data->id_fin_form)) @if($data->id_fin_form == $key) selected="true" @endif @endif>{{$form}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Categoria</label>
                    <select class="form-control" id="category_id"  name="id_fin_category">
                      <option value="">Selecione</option>
                      @foreach($categories as $key => $category)
                      <option value="{{$key}}" @if(isset($data->id_fin_category)) @if($data->id_fin_category == $key) selected="true" @endif @endif>{{$category}} </option>
                      @endforeach
                    </select>
                    <div class="input-group-append">
                          <a href="#addccategoria" data-toggle="modal" data-target=".categoria-modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> adicionar</a>
                      </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> <?php echo $title_client; ?></label>
                    <div class="input-group">
                      <select class="custom-select"  name="client_id" id="client_id">
                        <option value="">Selecione</option>
                        @foreach($clients as $key => $client)
                        <option value="{{$key}}" @if(isset($data->id_client)) @if($data->id_client == $key) selected="true" @endif @endif>{{$client}} </option>
                        @endforeach
                      </select>
                      <div class="input-group-append">
                          <a href="#addclient"  data-toggle="modal" data-target=".clients-modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> adicionar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Status</label>
                    <select class="form-control"  name="status">
                      <option value="">Selecione</option>
                      @foreach($status as $key => $statu)
                      <option value="{{$key}}" @if(isset($data->status)) @if($data->status == $key) selected="true" @endif @endif>{{$statu}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Comprovante:</label>
                    <input type="file" name="arquivo_envio" class="form-control" data-name="arquivo" id="arquivo_envio">
                    <input type="hidden" name="file" id="arquivo" value="">
										<div id="recebeaviso"></div>
										<div id="arquivo_recebe">
                    @if(old('file') != null) {{ old('file') }} @elseif(isset($data->file)) 
                    <img id="arquivo_img" style="max-width:100%" src="/assets/painel/uploads/recibos/{{$data->file}}">
                    @endif
                    </div>
                  </div>
                </div>
              </div>
              


              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Observação</label>
                    <textarea class="form-control"  name="obs" id="" cols="30" rows="5" style="width:100%">
                      @if(old('obs') != null) {{ old('obs') }} @elseif(isset($data->obs)) {{$data->obs}} @endif
                    </textarea>
                    
                  </div>
                </div>
              </div>
              
              

              
             
            

              
            </div>
            
            <br>
            <input type="hidden" name="type" @if(old('type') != null) value="{{ old('type') }}" @else value="{{$usertype}}"  @endif>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade modal-clients clients-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form id="form-clients-ticket" method="post" accept-charset="utf-8" novalidate="novalidate" class="dirty">
		
		<div class="modal-header">
			<button type="button" class="close close-clients-modal" data-rel-id="87" data-rel-type="ticket" aria-label="Close" value=""><span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class="fa fa-question-circle" data-toggle="tooltip"  data-placement="bottom"></i> Adicionar um <?php echo $title_client; ?></h4>
		</div>
		
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">	
					<input type="hidden" id="tipo" name="tipo" value="<?php echo $usertype ?>">
					<div class="form-group">
						<label for="company" class="control-label"> 
						<small class="req text-danger">* </small><?php  echo $title_client;?>:</label>
						<input type="text" id="company" name="company" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="bank_cpf" class="control-label"> 
						<small class="req text-danger">* </small>CPF / CNPJ:</label>
						<input type="text" id="bank_cpf" name="bank_cpf" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="phonenumber" class="control-label"> 
						<small class="req text-danger">* </small>Telefone:</label>
						<input type="text" id="phonenumber" name="phonenumber" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="website" class="control-label"> 
						<small class="req text-danger">* </small>E-mail:</label>
						<input type="text" id="email" name="email" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="website" class="control-label"> 
						<small class="req text-danger">* </small>Site:</label>
						<input type="text" id="website" name="website" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="address" class="control-label"> 
						<small class="req text-danger">* </small>Endereço:</label>
						<input type="text" id="address" name="address" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="city" class="control-label"> 
						<small class="req text-danger">* </small>Cidade:</label>
						<input type="text" id="city" name="city" class="form-control" autocomplete="off">
					</div>	
					<div class="form-group">
						<label for="state" class="control-label"> 
						<small class="req text-danger">* </small>Estado:</label>
						<input type="text" id="state" name="state" class="form-control" autocomplete="off">
					</div>	
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default close-clients-modal" data-dismiss="clients-modal">Fechar</button>
			<button type="submit" class="btn btn-info" value="">Salvar</button>
		</div>
		</form>    
	</div>
  </div>
</div>

<div class="modal fade modal-categoria categoria-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form id="form-categoria-ticket" method="post" accept-charset="utf-8" novalidate="novalidate" class="dirty">
		
		<div class="modal-header">
			<button type="button" class="close close-categoria-modal" data-rel-id="87" data-rel-type="ticket" aria-label="Close" value=""><span aria-hidden="true">×</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class="fa fa-question-circle" data-toggle="tooltip"  data-placement="bottom"></i> Adicionar uma Categoria</h4>
		</div>
		
		<div class="modal-body">
			<div class="row">
				<div class="col-md-12">	
          <input type="hidden" id="tipo" name="tipo" value="<?php echo $usertype ?>">
          
					<div class="form-group" app-field-wrapper="date">
						<label for="date" class="control-label"> 
							<small class="req text-danger">* </small>Categoria:</label>
							<input type="text" id="cat" name="cat" class="form-control" autocomplete="off">
					</div>	

					<div class="form-group" app-field-wrapper="name">
						<label for="report-to" class="control-label">Categoria Mãe</label>
						
						<select class="" data-width="100%" name="mae" id="mae">
                            <option selected disabled>Selecione</option>
                            <?php foreach($maes as $key => $categoria){ ?>
                                <option value="<?php echo $key ?>" ><?php echo $categoria ?></option>
                            <?php } ?>
						</select>
					</div>
					
				</div>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default close-categoria-modal" data-dismiss="categoria-modal">Fechar</button>
			<button type="submit" class="btn btn-info" value="">Salvar</button>
		</div>
		</form>    
	</div>
  </div>
</div>


@endsection

@section('scripts')
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript" src="/painel/assets/js/jquery.mask.min.js"></script>
<script>
  $(function(){
		    $('select').select2();
		    $('.valor').mask('#.##0,00', {reverse: true});
        $('.data').mask("00/00/0000", {placeholder: "__/__/____"});
        $('.data_mes').mask("00/0000", {placeholder: "__/____"});
	})

    ajaxUpload('#arquivo_envio');

    function ajaxUpload(id){

        $(id).change(function(e){
            e.preventDefault();
            
            // Cria FormData
            var formData = new FormData();
            formData.append('file',this.files[0],this.files[0].name);
            formData.append('_token','<?php echo csrf_token() ?>');
            
            var campo = '#'+$(this).attr('data-name');
            var img   = $(this).attr('data-name')+'_img';
            var recebe= '#'+$(this).attr('data-name')+'_recebe';
            
            var aviso = '<div id="flashMessage" class="ls-alert-success" role="alert" >Efetuando upload aguarde</div>';

            $('#recebeaviso').html(aviso);

            // Envia
            $.ajax({
                type:'POST',
                url: "/painel/fin-movimentation/enviar",
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                success:function(data){
                    data = JSON.parse(data);
                    $('#'+img).remove();
                    $(campo).attr('value',data.msg)
                    
                    if(data.msg.indexOf('.pdf') > 0 || data.msg.indexOf('.PDF') > 0){
                        $(recebe).append('<p>Upload efetuado com sucesso</p>')
                    } else {
                        $(recebe).append('<p><img id="'+img+'" style="max-width:100%" src="/assets/painel/uploads/recibos/'+data.msg+'"></p>')
                    }

                    $('#recebeaviso').html(" ");
                    
                },
                error: function(data){
                    alert("Erro ao enviar o arquivo");
                    console.log(data);
                }
            })
        })

    }

    $('.close-clients-modal').click(function(){
		$('.clients-modal').modal('hide');
	})
	
	$('.close-categoria-modal').click(function(){
		$('.categoria-modal').modal('hide');
	})

	$('#form-clients-ticket').on('submit',function(e){
		e.preventDefault();

		var company = $('#company').val();
		var tipo = $('#tipo').val();
		var bank_cpf = $('#bank_cpf').val();
		var phonenumber = $('#phonenumber').val();
		var website = $('#website').val();
		var address = $('#address').val();
		var city = $('#city').val();
		var state = $('#state').val();
		var email = $('#email').val();
		
		$.ajax({
				type: "post",
				url: "/painel/fin-movimentation/user",
				data: {
					'name':company,
					'CPF_CNPJ':bank_cpf,
					'phone':phonenumber,
					'website':website,
					'email':email,
					'address':address,
					'city':city,
					'state':state,
          'user_type':<?php echo $usertype; ?>,
          '_token':'<?php echo csrf_token() ?>'
				},
				success: function (response) {
					var data = JSON.parse(response)
					console.debug(data);
					if(data){
						$('#company').val(' ');
						$('#bank_cpf').val(' ');
						$('#phonenumber').val(' ');
						$('#website').val(' ');
						$('#address').val(' ');
						$('#city').val(' ');
						$('#state').val(' ');
						$('#email').val(' ');

						$('.clients-modal').modal('hide');
						// $.each(data.clientes, function(){
							$("#client_id").append('<option value="'+ data.id +'">'+ data.name +'</option>')
						// });
					}
				}
			});

	})

	$('#form-categoria-ticket').on('submit',function(e){
		e.preventDefault();
		var mae = $('#mae').val();
		var cat = $('#cat').val();
			
		$.ajax({
			type: "post",
			url: "/painel/fin-movimentation/cat",
			data: {
				'fin_category_id':mae,
				'name':cat,
				'status':1,
        '_token':'<?php echo csrf_token() ?>'
			},
			success: function (response) {
				var data = JSON.parse(response)
				if(data){
					$('#mae').val(' ');
					$('#cat').val(' ');
					$('.categoria-modal').modal('hide');
						$("#category_id").append('<option value="'+ data.id_fin_category +'">'+ data.name +'</option>')
				}
			}
		});

		

	})
</script>
<style>
.select2-container--open {
  z-index: 9999999
}
.select2-container .select2-selection--single{
  height: 39px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 38px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 37px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}
</style>
@endsection