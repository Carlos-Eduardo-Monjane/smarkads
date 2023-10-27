@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Inválidos</h4>
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
                    <label for="inputEmail4">Valor</label>
                    <input type="text" class="form-control valor" name="value" @if(old('value') != null) value="{{ old('value') }}" @elseif(isset($data->value)) value="{{$data->value}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Mês</label>
                    <input type="text" class="form-control" name="month" @if(old('month') != null) value="{{ old('month') }}" @elseif(isset($data->month)) value="{{$data->month}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Ano</label>
                    <input type="text" class="form-control" name="year" @if(old('year') != null) value="{{ old('year') }}" @elseif(isset($data->year)) value="{{$data->year}}"  @endif>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Informação</label>
                    <input type="text" class="form-control" name="description" @if(old('description') != null) value="{{ old('description') }}" @elseif(isset($data->description)) value="{{$data->description}}"  @endif>
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

@section('scripts')
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>

<script>
  $(function(){
		    $('.valor').mask('#.##0,00', {reverse: true});
	});
</script>
@endsection
