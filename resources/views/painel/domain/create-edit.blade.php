@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Domínio</h4>
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
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Domínio</label>
                    <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif <?php if(Auth::user()->id != 2){ if(isset($data->$primaryKey)){ echo 'disabled'; } } ?>>
                  </div>
                </div>
              </div>
              <?php if($role == 1){ ?>
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">RavShare AdManager</label>
                    <input type="text" class="form-control" name="rev_share_admanager" @if(old('rev_share_admanager') != null) value="{{ old('rev_share_admanager') }}" @elseif(isset($data->rev_share_admanager)) value="{{$data->rev_share_admanager}}"  @endif>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">RavShare AdServer</label>
                    <input type="text" class="form-control" name="rev_share_adserver" @if(old('rev_share_adserver') != null) value="{{ old('rev_share_adserver') }}" @elseif(isset($data->rev_share_adserver)) value="{{$data->rev_share_adserver}}"  @endif>
                  </div>
                </div>
              </div>
           
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">RavShare Account</label>
                    <input type="text" class="form-control" name="rev_share_account_manager" @if(old('rev_share_account_manager') != null) value="{{ old('rev_share_account_manager') }}" @elseif(isset($data->rev_share_account_manager)) value="{{$data->rev_share_account_manager}}"  @endif>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Account Manager </label>
                    <select class="form-control" name="id_account_manager">
                      <option value=""> Selecione </option>
                      @foreach($accountManager as $account)
                      <option value="{{$account->id}}" @if(isset($accountManagerSelected->id)) @if($accountManagerSelected->id == $account->id) selected="true" @endif @endif>{{$account->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <?php } ?>
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">PageViews</label>
                    <input type="text" class="form-control" name="page_views" @if(old('page_views') != null) value="{{ old('page_views') }}" @elseif(isset($data->page_views)) value="{{$data->page_views}}"  @endif>
                  </div>
                </div>
              </div>
           
            <?php if($role == 1){ ?>
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Status </label>
                    <select class="form-control"  name="id_domain_status">
                      <option value=""> Selecione </option>
                      @foreach($domainStatuss as $domainStatus)
                      <option value="{{$domainStatus->id_domain_status}}" @if(isset($domainStatusSelected->id_domain_status)) @if($domainStatusSelected->id_domain_status == $domainStatus->id_domain_status) selected="true" @endif @endif>{{$domainStatus->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            <?php } ?>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Categoria </label>
                    <select class="form-control"  name="id_domain_category">
                      @foreach($domainCategorys as $domainCategory)
                      <option value="{{$domainCategory->id_domain_category}}" @if(isset($domainCategorySelected->id_domain_category)) @if($domainCategorySelected->id_domain_category == $domainCategory->id_domain_category) selected="true" @endif @endif>{{$domainCategory->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <?php if($role == 1){ ?>
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Cliente </label>
                    <select class="form-control js-basic-multiple" name="id_user">
                      @foreach($users as $user)
                      <option value="{{$user->id}}" @if(isset($userSelected->id)) @if($userSelected->id == $user->id) selected="true" @endif @endif>{{$user->name}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <?php } ?>
            
            <?php if($role == 1){ ?>
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Google Analytics ID</label>
                    <input type="text" class="form-control" name="google_analytcs_id" @if(old('google_analytcs_id') != null) value="{{ old('google_analytcs_id') }}" @elseif(isset($data->google_analytcs_id)) value="{{$data->google_analytcs_id}}"  @endif>
                  </div>
                </div>
              </div>
              
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Head Bidder ID</label>
                    <input type="text" class="form-control" name="head_bidder_id" @if(old('head_bidder_id') != null) value="{{ old('head_bidder_id') }}" @elseif(isset($data->head_bidder_id)) value="{{$data->head_bidder_id}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for=""> CheckList </label>
                  <div class="checkbox checbox-switch switch-success">
                    <label>
                      <input type="hidden" name="status_checklist" value="0" />
                      <input type="checkbox" name="status_checklist"  @if(isset($data->status_checklist)) @if($data->status_checklist == 1) checked="checked" @endif @endif value="1"/>
                      <span></span>
                    </label>
                  </div>
                </div>
              </div>
              <?php } ?>
            
            
            
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Login</label>
                    <input type="text" class="form-control" name="login" @if(old('login') != null) value="{{ old('login') }}" @elseif(isset($data->login)) value="{{$data->login}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Senha</label>
                    <input type="text" class="form-control" name="password" @if(old('password') != null) value="{{ old('password') }}" @elseif(isset($data->password)) value="{{$data->password}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Admin (caso blogger informar blogger apenas).</label>
                    <input type="text" class="form-control" name="key_recaptcha" @if(old('key_recaptcha') != null) value="{{ old('key_recaptcha') }}" @elseif(isset($data->key_recaptcha)) value="{{$data->key_recaptcha}}"  @endif>
                  </div>
                </div>
              </div>
              <?php if($role == 1){ ?>
              <div class="col-md-3">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Versão Prebid </label>
                    <select class="form-control"  name="id_prebid_version">
                      <option value="">Selecione</option>
                      @foreach($prebidVersions as $prebidVersion)
                      <option value="{{$prebidVersion->id_prebid_version}}" @if(isset($prebidVersionSelected->id_prebid_version)) @if($prebidVersionSelected->id_prebid_version == $prebidVersion->id_prebid_version) selected="true" @endif @endif>{{$prebidVersion->version}} </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>

            </div>
            <?php } else { ?>
              <input name="rev_share_admanager" value="30" type="hidden">
              <input name="rev_share_adserver" value="30" type="hidden">
              <input name="rev_share_account_manager" value="30" type="hidden">
              <input name="id_domain_status" value="3" type="hidden">
              <input name="id_domain_category" value="3" type="hidden">
              <input name="id_user" value="{{Auth::user()->id}}" type="hidden">
            <?php } ?>

            <br>
            <button style="margin-left:15px" type="submit" class="btn btn-xl btn-primary">Salvar</button>

            <?php if($role != 1){ 
              
                if(strlen(@$data->login) > 0){
              ?>
              
              <a href="/painel/ticket/create?assunto=Instalar%20blocos&desc=informações%20no%20dominio." style="margin-left:20px;" class="btn btn-xl btn-primary">Solicitar Instalação</a>
              
            <?php } } ?>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection

  @section('scripts')
  <script>
  $('.js-basic-multiple').select2();
  </script>
  @endsection

  @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif