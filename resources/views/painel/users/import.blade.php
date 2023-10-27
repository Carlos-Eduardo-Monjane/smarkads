@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Importar Usuários</h4>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="/{{$principal}}/{{$rota}}/import" accept-charset="UTF-8" enctype="multipart/form-data">
          @csrf
          <div class="input-group mb-12">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
              <input type="file" name="arquivo" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
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
