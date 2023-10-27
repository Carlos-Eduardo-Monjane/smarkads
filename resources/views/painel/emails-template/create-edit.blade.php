@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Template de email</h4>
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
                    <label for="inputEmail4">name</label>
                    <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Html</label>
                    <textarea class="form-control" name="html" id="text" rows="20">
                      @if(old('html') != null) {{ old('html') }} @elseif(isset($data->html)) {!! $data->html !!}  @endif
                    </textarea>
                  </div>
                </div>
              </div>
            </div>
            <br>
            <button type="button" class="btn btn-success" onclick="showTemplate()"><i class="fa fa-eye"></i> Visualizar</button>
            <button type="submit" class="btn btn-primary">Salvar</button>
          </form>
        </div>
        <div class="row">
          <div class="col-md-12">
                <div id="showTemplate"></div>
          </div>
      </div>
    </div>
  </div>


  </div>
  @endsection

  @section('scripts')


  <script>
    function showTemplate(){
      var _token = '{{csrf_token()}}';
      var html = document.getElementById("text").value;
      $.post("/{{$principal}}/{{$rota}}/session-html", {_token: _token, html: html});
      var win = window.open('/{{$principal}}/{{$rota}}/show-html', '_blank');
      win.focus();
    }
  </script>

  @endsection
