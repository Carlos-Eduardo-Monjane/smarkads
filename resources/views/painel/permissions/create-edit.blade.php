@extends('painel.layouts.app')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Permissão</h4>
        </div>
      </div>
      <div class="card-body">
        @if(isset($data->$primaryKey))
        <form method="POST" action="/{{$principal}}/{{$rota}}/update/{{$data->$primaryKey}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @else
          <form method="POST" action="/{{$principal}}/{{$rota}}/store" accept-charset="UTF-8" enctype="multipart/form-data">
            @endif
            @csrf
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputEmail4">Nome</label>
                <input type="text" class="form-control" name="readable_name" @if(old('readable_name') != null) value="{{ old('readable_name') }}" @elseif(isset($data->readable_name)) value="{{$data->readable_name}}"  @endif>
              </div>

              <div class="form-group col-md-2">
                <label for="inputEmail4">Prefixo</label>
                <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
              </div>

              <div class="form-group col-md-2">
                <label for="inputEmail4">Icone</label>
                <input type="text" class="form-control" name="icon" @if(old('icon') != null) value="{{ old('icon') }}" @elseif(isset($data->icon)) value="{{$data->icon}}"  @endif>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="inputEmail4">Novo?</label>
                  <div class="checkbox checbox-switch switch-success">
                    <label>
                      <input type="hidden" name="new" value="0" />
                      <input type="checkbox" name="new"  @if(isset($data->new)) @if($data->new == 1) checked="checked" @endif @endif value="1"/>
                      <span></span>
                    </label>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <div class="form-group">
                  <label for="inputEmail4">Fixo?</label>
                  <div class="checkbox checbox-switch switch-success">
                    <label>
                      <input type="hidden" name="menu_fix" value="0" />
                      <input type="checkbox" name="menu_fix"  @if(isset($data->menu_fix)) @if($data->menu_fix == 1) checked="checked" @endif @endif value="1"/>
                      <span></span>
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Ordem</label>
                <input type="text" class="form-control" name="order" @if(old('order') != null) value="{{ old('order') }}" @elseif(isset($data->order)) value="{{$data->order}}"  @endif>
              </div>

              <div class="form-group col-md-6">
                <label for="inputState">Menu</label>
                <select name="id_permission" class="form-control">
                  <option value="">Selecione</option>
                  <?php if(isset($data->id)) $IDPermissao = $data->id; else $IDPermissao = NULL;?>
                  @foreach($Permissoes->where('id', '!=', $IDPermissao) as $Permissao)
                  <option value="{{$Permissao->id}}" @if(isset($PermissaoSelecionada->id)) @if($PermissaoSelecionada->id == $Permissao->id) selected="true" @endif @endif>{{$Permissao->readable_name}}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection
