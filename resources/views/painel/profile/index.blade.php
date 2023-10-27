@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Perfil</h4>
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
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Nome</label>
                  <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Email</label>
                  <input type="text" class="form-control"  @if(isset($data->email)) value="{{$data->email}}"  @endif>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Senha</label>
                  <input type="text" class="form-control" name="password">
                </div>
              </div>
            </div>

            <div class="row" >
              <div class="col-md-6">
                <div class="form-group col-md-12">
                  <label for="inputState">Tipo de conta</label>
                  <select name="type_account" class="form-control">
                    <option value="">Selecione</option>
                    <option value="1" @if(isset($data->type_account)) @if($data->type_account == 1) selected="true" @endif @endif>Pessoal</option>
                    <option value="2" @if(isset($data->type_account)) @if($data->type_account == 2) selected="true" @endif @endif>Juridica</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">CPF/CNPJ</label>
                  <input type="text" class="form-control" name="CPF_CNPJ" @if(old('CPF_CNPJ') != null) value="{{ old('CPF_CNPJ') }}" @elseif(isset($data->CPF_CNPJ)) value="{{$data->CPF_CNPJ}}"  @endif>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
              <div class="form-group  col-md-12">
                  <label for="inputEmail4">Banco</label>
                  <select name="bank" class="form-control">
                    <option value="">Selecione</option>
                    @foreach($bancos as $key => $banco)
                    <option value="{{$key}}" @if(isset($data->bank)) @if($data->bank == $key) selected="true" @endif @endif>{{$banco}}</option>
                    @endforeach
                  </select>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group  col-md-12">
                  <label for="inputEmail4">Tipo de Conta</label>
                  <select name="bank_type" class="form-control">
                    <option value="">Selecione</option>
                    <option value="1" @if(isset($data->bank_type)) @if($data->bank_type == 1) selected="true" @endif @endif>Corrente</option>
                    <option value="2" @if(isset($data->bank_type)) @if($data->bank_type == 2) selected="true" @endif @endif>Poupança</option>
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Agência</label>
                  <input type="text" class="form-control" name="agency" @if(old('agency') != null) value="{{ old('agency') }}" @elseif(isset($data->agency)) value="{{$data->agency}}"  @endif>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Dígito</label>
                  <input type="text" class="form-control" name="agency_digit" @if(old('agency_digit') != null) value="{{ old('agency_digit') }}" @elseif(isset($data->agency_digit)) value="{{$data->agency_digit}}"  @endif>
                </div>
              </div>


              <div class="col-md-3">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Conta</label>
                  <input type="text" class="form-control" name="account" @if(old('account') != null) value="{{ old('account') }}" @elseif(isset($data->account)) value="{{$data->account}}"  @endif>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Dígito</label>
                  <input type="text" class="form-control" name="digit" @if(old('digit') != null) value="{{ old('digit') }}" @elseif(isset($data->digit)) value="{{$data->digit}}"  @endif>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">IBAN</label>
                  <input type="text" class="form-control" name="iban" @if(old('iban') != null) value="{{ old('iban') }}" @elseif(isset($data->iban)) value="{{$data->iban}}"  @endif>
                </div>
              </div>
              
              
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Swift</label>
                  <input type="text" class="form-control" name="swift" @if(old('swift') != null) value="{{ old('swift') }}" @elseif(isset($data->swift)) value="{{$data->swift}}"  @endif>
                </div>
              </div>

              

            </div>

            <div class="row" style="display:none">

            <div class="col-md-12">
            <br /><br />
                <h4 id="bank" class="company-profile-billing-shipping-heading">Documentos</h4>
                <hr class="no-mbot"/><br /><br />
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="titular">Documento de Identidade (FRENTE)</label>
                    <input type="file" class="form-control" data-name="doc_id_doc" name="doc_id_doc_envio" id="doc_id_doc_envio">
                    <input type="hidden" id="doc_id_doc" name="doc_id_doc" class="form-control" value="<?php echo $data->doc_id_doc ?>">
                    <div id="doc_id_doc_recebe">
                        <?php if(@$data->doc_id_doc){ ?>
                        <img id="doc_id_doc_img" style="width:100%;" src="/assets/painel/uploads/documentos/<?php echo $data->id ?>/<?php echo $data->doc_id_doc ?>">
                        <?php } ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="titular">Documento de Identidade (VERSO)</label>
                    <input type="file" class="form-control" data-name="doc_back_id_doc" name="doc_back_id_doc_envio" id="doc_back_id_doc_envio">
                    <input type="hidden" id="doc_back_id_doc" name="doc_back_id_doc" class="form-control" value="<?php echo $data->doc_back_id_doc ?>">
                    <div id="doc_back_id_doc_recebe">
                        <?php if(@$data->doc_back_id_doc){ ?>
                        <img id="doc_back_id_doc_img" style="width:100%;" src="/assets/painel/uploads/documentos/<?php echo $data->id ?>/<?php echo $data->doc_back_id_doc ?>">
                        <?php } ?>
                    </div>
                </div>



                <div class="form-group">
                    <label for="titular">Comprovante de Endereço (Validade 6 meses)</label>
                    <input type="file" class="form-control" data-name="doc_proof_of_address" name="doc_proof_of_address_envio" id="doc_proof_of_address_envio">
                    <input type="hidden" id="doc_proof_of_address" name="doc_proof_of_address" class="form-control" value="<?php echo $data->doc_proof_of_address ?>">
                    <div id="doc_proof_of_address_recebe">
                        <?php if(@$data->doc_proof_of_address){ ?>
                        <img id="doc_proof_of_address_img" style="width:100%;" src="/assets/painel/uploads/documentos/<?php echo $data->id ?>/<?php echo $data->doc_proof_of_address ?>">
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="titular">Assinatura em Papel</label>
                    <input type="file" class="form-control" data-name="doc_sign" name="doc_sign_envio" id="doc_sign_envio">
                    <input type="hidden" id="doc_sign" name="doc_sign" class="form-control" value="<?php echo $data->doc_sign ?>">
                    <div id="doc_sign_recebe">
                        <?php if(@$data->doc_sign){ ?>
                        <img id="doc_sign_img" style="width:100%;" src="/assets/painel/uploads/documentos/<?php echo $data->id ?>/<?php echo $data->doc_sign ?>">
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="titular">Foto de Perfil</label>
                    <input type="file" class="form-control" data-name="doc_pic" name="doc_pic_envio" id="doc_pic_envio">
                    <input type="hidden" id="doc_pic" name="doc_pic" class="form-control" value="<?php echo $data->doc_pic ?>">
                    <div id="doc_pic_recebe">
                        <?php if(@$data->doc_pic){ ?>
                        <img id="doc_pic_img" style="width:100%;" src="/assets/painel/uploads/documentos/<?php echo $data->id ?>/<?php echo $data->doc_pic ?>">
                        <?php } ?>
                    </div>
                </div>
            </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  <div id="recebeaviso"></div>

  @endsection






  @section('scripts')
<script>
ajaxUpload('#doc_id_doc_envio');
ajaxUpload('#doc_back_id_doc_envio');
ajaxUpload('#doc_proof_of_address_envio');
ajaxUpload('#doc_sign_envio');
ajaxUpload('#doc_pic_envio');

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
            url: '/painel/profile/upload/<?php echo $data->id ?>',
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
                    $(recebe).append('<p><img id="'+img+'" style="max-width:100%" src="/assets/painel/uploads/documentos/<?php echo $data->id ?>/'+data.msg+'"></p>')
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

</script>
@endsection
