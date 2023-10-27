@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Banco</h4>
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
                    <label for="inputEmail4">Nome</label>
                    <input type="text" class="form-control" name="name" @if(old('name') != null) value="{{ old('name') }}" @elseif(isset($data->name)) value="{{$data->name}}"  @endif>
                  </div>
                </div>
              </div>
              
              <div class="col-md-10">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Valor</label>
                    <input type="text" class="form-control money" name="valor" @if(old('valor') != null) value="{{ old('valor') }}" @elseif(isset($data->valor)) value="{{$data->valor}}"  @endif>
                  </div>
                </div>
              </div>

              
              <div class="col-md-10">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Moeda</label>
                    <select class="form-control"  name="id_fin_currency">
                      <option value="">Selecione</option>
                      @foreach($currencies as $currence)
                      <option value="{{$currence->id_fin_currency}}" @if(isset($currenciesSelected->id_fin_currency)) @if($currenciesSelected->id_fin_currency == $currence->id_fin_currency) selected="true" @endif @endif>{{$currence->name}} </option>
                      @endforeach
                    </select>
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
  $('.money').mask('#.##0.00', {reverse: true});
</script>
@endsection