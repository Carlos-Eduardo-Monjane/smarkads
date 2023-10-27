@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Status Tarefas</h4>
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
              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Nome</label>
                    <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Cor </label>
                    <select class="form-control" name="color">
                      <option value="">Selecione</option>
                      <option value="warning" @if(isset($data->color)) @if($data->color == 'warning') selected="true" @endif @endif> Laranja</option>
                      <option value="primary" @if(isset($data->color)) @if($data->color == 'primary') selected="true" @endif @endif> Verde</option>
                      <option value="dark" @if(isset($data->color)) @if($data->color == 'dark') selected="true" @endif @endif> Preto </option>
                      <option value="danger" @if(isset($data->color)) @if($data->color == 'danger') selected="true" @endif @endif> Vermelho </option>
                      <option value="info" @if(isset($data->color)) @if($data->color == 'info') selected="true" @endif @endif> Azul </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  @endsection
