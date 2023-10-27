@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Notificação</h4>
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
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Assunto</label>
                    <input type="title" class="form-control" name="subject" @if(old('subject') != null) value="{{ old('subject') }}" @elseif(isset($data->subject)) value="{{$data->subject}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Mensagem</label>
                <textarea type="title" class="form-control" name="message">
                  @if(old('message') != null) {{ old('message') }} @elseif(isset($data->message)) {{$data->message}}  @endif
                </textarea>
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
