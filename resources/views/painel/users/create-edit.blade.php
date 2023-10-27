@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Perfil - <a target="_blank" href="/painel/users/auth-user/{{$data->id}}/{{str_replace('/','',$data->password)}}" class="btn btn-info" title="Login">Efetuar Login</a></h4>
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
              <div class="col-md-12">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Link Login</label>
                  <input type="text" class="form-control" readonly @if(isset($data->password)) value="{{URL('/auth-user')}}/{{$data->id}}/{{str_replace('/','',$data->password)}}"  @endif>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Nome</label>
                  <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Empresa</label>
                  <input type="text" class="form-control" name="company" @if(old('company') != null) value="{{ old('company') }}" @elseif(isset($data->company)) value="{{$data->company}}"  @endif>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Email</label>
                  <input type="text" class="form-control"  @if(isset($data->email)) value="{{$data->email}}"  @endif>
                </div>
              </div>


            </div>




            <div class="row">
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for=""> Grupo</label>
                  <select class="form-control"  name="role">
                    @foreach($Grupos->all() as $Grupo)
                    <option value="{{$Grupo->id}}" @if(isset($GrupoSelecionado->role_id)) @if($GrupoSelecionado->role_id == $Grupo->id) selected="true" @endif @endif>{{$Grupo->name}} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Senha</label>
                  <input type="text" class="form-control" name="password">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for=""> Tipo Usuário</label>
                  <select class="form-control"  name="id_user_type">
                    @foreach($UserTypes as $UserType)
                    <option value="{{$UserType->id_user_type}}" @if(isset($UserTypeSelected->id_user_type)) @if($UserTypeSelected->id_user_type == $UserType->id_user_type) selected="true" @endif @endif>{{$UserType->name}} </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">CPF / CNPJ</label>
                  <input type="text" class="form-control" name="CPF_CNPJ" @if(old('CPF_CNPJ') != null) value="{{ old('CPF_CNPJ') }}" @elseif(isset($data->CPF_CNPJ)) value="{{$data->CPF_CNPJ}}"  @endif>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">WhatsApp</label>
                  <input type="text" class="form-control" name="whatsapp" @if(old('whatsapp') != null) value="{{ old('whatsapp') }}" @elseif(isset($data->whatsapp)) value="{{$data->whatsapp}}"  @endif>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Link AdManager</label>
                  <input type="text" class="form-control" name="invite_admanager" @if(old('invite_admanager') != null) value="{{ old('invite_admanager') }}" @elseif(isset($data->invite_admanager)) value="{{$data->invite_admanager}}"  @endif>
                </div>
              </div>
              
              
              <div class="col-md-4">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Sub Conta Adx</label>
                  <input type="text" class="form-control" name="sub_adx" @if(old('sub_adx') != null) value="{{ old('sub_adx') }}" @elseif(isset($data->sub_adx)) value="{{$data->sub_adx}}"  @endif>
                </div>
              </div>

              <div class="col-md-2">
                 <div class="form-group">
                    <div class="checkbox checbox-switch switch-success">
                      <label for="inputEmail4">Aprovado?</label><br>
                       <label>
                          <input type="hidden" name="status_admanager" value="0" />
                          <input type="checkbox" name="status_admanager" id="status_admanager" onchange="changeStatusApproved()" @if(isset($data->status_admanager)) @if($data->status_admanager == 1) checked="checked" @endif @endif value="1"/>
                          <span></span>
                       </label>
                    </div>
                 </div>
              </div>

              <div class="col-md-2">
                 <div class="form-group">
                    <div class="checkbox checbox-switch switch-info">
                      <label for="inputEmail4">Aguardando</label><br>
                       <label>
                          <input type="hidden" name="status_waiting" value="0" />
                          <input type="checkbox" name="status_waiting" id="status_waiting" onchange="changeStatusWaiting()" @if(isset($data->status_waiting)) @if($data->status_waiting == 1) checked="checked" @endif @endif value="1"/>
                          <span></span>
                       </label>
                    </div>
                 </div>
              </div>

              <div class="col-md-2">
                 <div class="form-group">
                    <div class="checkbox checbox-switch switch-danger">
                      <label for="inputEmail4">Reprovado?</label><br>
                       <label>
                          <input type="hidden" name="disapproved" value="0" />
                          <input type="checkbox" name="disapproved" id="disapproved" onchange="changeStatusDisapproved()" @if(isset($data->disapproved)) @if($data->disapproved == 1) checked="checked" @endif @endif value="1"/>
                          <span></span>
                       </label>
                    </div>
                 </div>
              </div>
            </div>

            <div class="row" id="obs">
              <div class="col-md-12">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Observação</label>
                  <textarea name="obs" rows="8" cols="80" class="form-control"> @if(isset($data->obs)) {{$data->obs}} @endif</textarea>
                </div>
              </div>
            </div>

            <div class="row" id="observation_disapproved" style="display:none">
              <div class="col-md-12">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Observação da reprovação</label>
                  <textarea name="observation_disapproved" rows="8" cols="80" class="form-control"> @if(isset($data->observation_disapproved)) {{$data->observation_disapproved}} @endif</textarea>
                </div>
              </div>
            </div>

            <div class="row" id="observation_waiting" style="display:none">
              <div class="col-md-12">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Observação</label>
                  <textarea name="observation_waiting" rows="8" cols="80" class="form-control"> @if(isset($data->observation_waiting)) {{$data->observation_waiting}} @endif</textarea>
                </div>
              </div>
            </div>

            <div class="row">

            <div class="col-md-12">
            <br /><br />
                <h4 id="bank" class="company-profile-billing-shipping-heading" >Dados Bancarios</h4>
                <hr class="no-mbot"/><br />
                <?php if(isset($data->husky_token)){ ?>
                  <button data-id="{{$data->id}}" class="btn btn-primary husky_update" style="float:right;margin-top: -55px;">Husky - Atualizar</button>
                <?php } else { ?>
                  <button data-id="{{$data->id}}" class="btn btn-info husky_create" style="float:right;margin-top: -55px;">Husky - Criar</button>
                <?php } ?>

            </div>

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
              
              
              <div class="col-md-6">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">IBAN</label>
                  <input type="text" class="form-control" name="iban" @if(old('iban') != null) value="{{ old('iban') }}" @elseif(isset($data->iban)) value="{{$data->iban}}"  @endif>
                </div>
              </div>
              
              
              <div class="col-md-6">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Swift</label>
                  <input type="text" class="form-control" name="swift" @if(old('swift') != null) value="{{ old('swift') }}" @elseif(isset($data->swift)) value="{{$data->swift}}"  @endif>
                </div>
              </div>


            </div>

            <div class="row">

            <div class="col-md-12">
            <br /><br />
                <h4 id="bank" class="company-profile-billing-shipping-heading">Documentos</h4>
                <hr class="no-mbot"/><br />
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
            </div>


            <button type="submit" class="btn btn-success" style="
   
   position: fixed;
    width: 500px;
    bottom: 0;
    z-index: 999;
    left: 50%;
    margin-left: -150px !important;
    
            ">Salvar</button>
          </form>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card card-statistics">
          <div class="card-header">
            <div class="card-heading">
              <h4 class="card-title">Dominios</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead class="thead-light">
                  <tr   class="text-center">
                    <th scope="col">Domínio</th>
                    <th scope="col">Alterar</th>
                    <th scope="col">Site</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($domains as $dado)
                  <tr class="text-center">
                    <td>{{$dado->name}}</td>
                    <td>
                      <a href="/{{$principal}}/domain/show/{{$dado->id_domain}}" class="btn btn-icon btn-round btn-secondary" title="Atualizar/Visualizar">
                        <i class="far fa-edit"></i>
                      </a>
                    </td>
                    <td>
                      <a target="_blank" href="https://{{$dado->name}}" class="btn btn-icon btn-round btn-success" title="Atualizar/Visualizar">
                        <i class="fa fa-link"></i>
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


    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card card-statistics">
          <div class="card-header">
            <div class="card-heading">
              <h4 class="card-title">Tickets</h4>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead class="thead-light">
                  <tr   class="text-center">
                    <th scope="col">Cód.</th>
                    <th scope="col">Assunto</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Data</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($tickets as $dado)
                  <tr class="text-left">
                    <td><a href="/painel/ticket/manager/2/{{$dado->id_ticket}}">{{$dado->id_ticket}}</a></td>
                    <td><a href="/painel/ticket/manager/2/{{$dado->id_ticket}}">{{$dado->subject}}</a></td>
                    <td><a href="/painel/ticket/manager/2/{{$dado->id_ticket}}">{!! $dado->description !!}</a></td>
                    <td>{{date('d/m/Y H:i', strtotime($dado->created_at))}}</td>
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


    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card card-statistics">
          <div class="card-header">
            <div class="card-heading">
              <h4 class="card-title">Histórico Financeiro</h4>
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
              @forelse($finans as $dado)
              <tr>
                <td><a href="/painel/fin-movimentation/show/{{$dado['id_fin_movimentation']}}">{{$dado['id_fin_movimentation']}}</a></td>
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
            <?php if(isset($dado['report'])){ ?>
						<?php foreach($dado['report'] as $rp) { ?>
							<tr>
								<td style="padding-left:15px;"> | </td>
								<td><a href="/painel/users/clients/{{$dado['id_user']}}">{{$rp->site}}</a></td>
								<td>$ {{Helper::moedaView($rp->total)}}</td>
							</tr>
						<?php } ?>
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
        </div>
      </div>
    </div>
    
    <?php if(isset($adx_report)) { ?>
    <div class="row">
      <div class="col-12 col-lg-12">
        <div class="card card-statistics">
          <div class="card-header">
            <div class="card-heading">
              <h4 class="card-title">Financeiro - Em aberto</h4>
            </div>
          </div>
          <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Mês</td>
                <th scope="col">Subtotal</th>
                <th scope="col">Invalidos</th>
                <th scope="col">Valor</th>
              </tr>
            </thead>
            <tbody>
            <?php $total = 0; $subtotal = 0; $invalido = 0; ?>
              
                <?php foreach($adx_report as $key => $d){  ?>
              <tr>
                <td>{{$key}}</td>
                <td>$ {{Helper::moedaView($d['value'])}} <?php $subtotal += $d['value']; ?></td>
                <td>$ {{Helper::moedaView($d['invalid'])}} <?php $invalido += $d['invalid']; ?></td>
                <td>$ {{Helper::moedaView(($d['value']-$d['invalid']))}} <?php $total += ($d['value']-$d['invalid']); ?></td>
              </tr>
                <?php } ?>
              
                          
                <tr>
                  <th scope="col"><strong>Total: </total></th>
                  <th scope="col" ><strong>$ {{Helper::moedaView($subtotal)}}</total></th>
                  <th scope="col" ><strong>$ {{Helper::moedaView($invalido)}}</total></th>
                  <th scope="col" ><strong>$ {{Helper::moedaView($total)}}</total></th>
                </tr>
						</tbody>
					</table>
				
        </div>
      </div>
        </div>
      </div>
    </div>
    <?php } ?>

  </div>

  <div id="recebeaviso"></div>



  @endsection


  @section('scripts')

<script>
  @if($data->status_waiting == 1)
    $('#observation_waiting').show();
  @else
    $('#observation_waiting').hide();
  @endif

  $(document).ready(function(){
     $("#status_waiting").change(function(){
       $('#status_waiting').val();
       var check = $("#status_waiting").is(':checked');
       if(check){
         $('#observation_waiting').show();
       }else{
         $('#observation_waiting').hide();
       }
     });
  });
</script>

<script>

function changeStatusApproved(){
  var check = $("#status_admanager").is(':checked');
  if(check){
    $("#status_waiting"). prop("checked", false);
    $("#disapproved"). prop("checked", false);
  }
}

function changeStatusWaiting(){
  var check = $("#status_waiting").is(':checked');
  if(check){
    $("#status_admanager"). prop("checked", false);
    $("#disapproved"). prop("checked", false);
  }
}

function changeStatusDisapproved(){
  var check = $("#disapproved").is(':checked');
  if(check){
    $("#status_waiting"). prop("checked", false);
    $("#status_admanager"). prop("checked", false);
  }
}

  @if($data->disapproved == 1)
    $('#observation_disapproved').show();
  @else
    $('#observation_disapproved').hide();
  @endif

  $(document).ready(function(){
     $("#disapproved").change(function(){
       $('#disapproved').val();
       var check = $("#disapproved").is(':checked');
       if(check){
         $('#observation_disapproved').show();
       }else{
         $('#observation_disapproved').hide();
       }
     });
  });
</script>

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

$('.husky_create').click(function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');

	$(this).text('Carregando...');
	$(this).attr('disabled','true');

	var formData = new FormData();
	formData.append('_token','<?php echo csrf_token() ?>');
	formData.append('id',id);
	$.ajax({
		type: "POST",
		url: "/painel/users/husky_create",
		data: formData,
		cache:false,
        contentType: false,
        processData: false,
		success: function (response) {
			response = JSON.parse(response);
			if(response.code == 200){
				if(confirm('Informações Sincronizadas com Husky')){
					window.location.reload();
				}
			}
			console.debug('RETORNO: ',response)
		}
	});
});

$('.husky_update').click(function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');

	$(this).text('Carregando...');
	$(this).attr('disabled','true');

	var formData = new FormData();
	formData.append('_token','<?php echo csrf_token() ?>');
	formData.append('id',id);
	$.ajax({
		type: "POST",
		url: "/painel/users/husky_destination",
		data: formData,
		cache:false,
        contentType: false,
        processData: false,
		success: function (response) {
			response = JSON.parse(response);
			if(response.code == 200){
				if(confirm('Informações Sincronizadas com Husky')){
					window.location.reload();
				}
			}
			console.debug('RETORNO: ',response)
		}
	});
});



</script>
@endsection
