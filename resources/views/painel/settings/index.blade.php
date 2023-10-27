@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Grupo de Permissão</h4>
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
                <label for="inputEmail4">Nome Sistema</label>
                <input type="text" class="form-control" name="name_system" @if(old('name_system') != null) value="{{ old('name_system') }}" @elseif(isset($data->name_system)) value="{{$data->name_system}}"  @endif>
              </div>
              <div class="form-group col-md-4">
                <label for="inputEmail4">Email Ticket</label>
                <input type="text" class="form-control" name="email_ticket" @if(old('email_ticket') != null) value="{{ old('email_ticket') }}" @elseif(isset($data->email_ticket)) value="{{$data->email_ticket}}"  @endif>
              </div>

              <div class="form-group col-md-4">
                <label for="inputEmail4">Cotação Dolar</label>
                <input type="text" class="form-control" name="cotacao" @if(old('cotacao') != null) value="{{ old('cotacao') }}" @elseif(isset($data->cotacao)) value="{{$data->cotacao}}"  @endif>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="custom-file">
                  <input type="file" name="logo_white" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Logo Clara</label>
                </div>
                @if(isset($data->logo_white))
                <img src="{{URL('assets/painel/uploads/settings')}}/{{$data->logo_white}}" width="50">
                @endif
              </div>

              <div class="col-md-3">
                <div class="custom-file">
                  <input type="file" name="logo_black" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Logo Escura</label>
                </div>
                @if(isset($data->logo_black))
                <img src="{{URL('assets/painel/uploads/settings')}}/{{$data->logo_black}}" width="50">
                @endif
              </div>

              <div class="col-md-3">
                <div class="custom-file">
                  <input type="file" name="fiv_icon" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Fiv Icon</label>
                </div>
                @if(isset($data->fiv_icon))
                <img src="{{URL('assets/painel/uploads/settings')}}/{{$data->fiv_icon}}" width="50">
                @endif
              </div>

              <div class="col-md-3">
                <div class="custom-file">
                  <input type="file" name="backgroud_login" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Backgroud Login</label>
                </div>
                @if(isset($data->backgroud_login))
                <img src="{{URL('assets/painel/uploads/settings')}}/{{$data->backgroud_login}}" width="50">
                @endif
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
      </div>
    </div>
  </div>


  @endsection
