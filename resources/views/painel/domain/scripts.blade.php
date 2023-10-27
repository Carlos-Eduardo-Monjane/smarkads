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
        <form method="POST" action="/{{$principal}}/{{$rota}}/scripts/{{$idDomain}}" accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Header Mobile</label>
                  <textarea class="form-control" name="devices[mobile][header]" rows="3">@if(isset($dataMobile->header)) {{$dataMobile->header}} @endif</textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Footer Mobile</label>
                  <textarea class="form-control" name="devices[mobile][footer]" rows="3">@if(isset($dataMobile->footer)) {{$dataMobile->footer}} @endif</textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">After Body Mobile</label>
                  <textarea class="form-control" name="devices[mobile][after_body]" rows="3">@if(isset($dataMobile->after_body)) {{$dataMobile->after_body}} @endif</textarea>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Header Desktop</label>
                  <textarea class="form-control" name="devices[desktop][header]" rows="3">@if(isset($dataDesktop->header)) {{$dataDesktop->header}} @endif</textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">Footer Desktop</label>
                  <textarea class="form-control" name="devices[desktop][footer]" rows="3">@if(isset($dataDesktop->footer)) {{$dataDesktop->footer}} @endif</textarea>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="exampleFormControlTextarea1">After Body Desktop</label>
                  <textarea class="form-control" name="devices[desktop][after_body]" rows="3">@if(isset($dataDesktop->after_body)) {{$dataDesktop->after_body}} @endif</textarea>
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

  @section('scripts')
  <script>
  $('.js-basic-multiple').select2();
  </script>
  @endsection
