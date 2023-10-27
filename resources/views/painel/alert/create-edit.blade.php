@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Modal</h4>
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
              <div class="col-md-10">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Titulo</label>
                    <input type="title" class="form-control" name="title" @if(old('title') != null) value="{{ old('title') }}" @elseif(isset($data->title)) value="{{$data->title}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="inputEmail4">Status</label>
                    <div class="checkbox checbox-switch switch-success">
                      <label>
                        <input type="hidden" name="status" value="0" />
                        <input type="checkbox" name="status"  @if(isset($data->status)) @if($data->status == 1) checked="checked" @endif @endif value="1"/>
                        <span></span>
                      </label>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Texto</label>
                <textarea type="title" class="form-control" name="text">
                  @if(old('text') != null) {{ old('text') }} @elseif(isset($data->text)) {{$data->text}}  @endif
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
