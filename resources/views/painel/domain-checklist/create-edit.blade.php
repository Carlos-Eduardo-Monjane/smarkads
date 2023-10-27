@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Checklist</h4>
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
                    <input type="title" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Ordem</label>
                    <input type="title" class="form-control" name="ordem" @if(old('ordem') != null) value="{{ old('ordem') }}" @elseif(isset($data->ordem)) value="{{$data->ordem}}"  @endif>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                  <label for=""> Status</label>
                    <select class="form-control"  name="status">
                      <option value="">Selecione</option>
                      <option value="1"  @if(isset($data->status)) @if($data->status == 1) selected="true" @endif @endif>Ativo</option>
                      <option value="2"  @if(isset($data->status)) @if($data->status == 2) selected="true" @endif @endif>Inativo</option>
                     
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
