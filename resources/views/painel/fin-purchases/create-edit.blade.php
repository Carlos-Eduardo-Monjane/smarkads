@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Pedidos de compras</h4>
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
                    <label for="inputEmail4">Valor</label>
                    <input type="text" class="form-control valor" name="valor" @if(old('valor') != null) value="{{ old('valor') }}" @elseif(isset($data->valor)) value="{{Helper::moedaView($data->valor)}}"  @endif>
                  </div>
                </div>
              </div>
            
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Observação</label>
                    <textarea class="form-control" name="observation" cols="30" rows="4">@if(old('observation') != null){{ old('observation') }} @elseif(isset($data->observation)) {{$data->observation}} @endif</textarea>
                  </div>
                </div>
              </div>
              
              
              <?php if(Auth::user()->id == '1255' || Auth::user()->id == '1260' || Auth::user()->id == '1288'){ ?>
              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Status</label>
                    <select class="form-control"  name="status">
                      <option value="" selected>Selecione</option> 
                      <option value="1" @if(isset($data->status)) @if($data->status == 1) selected="true" @endif @endif>Aprovado</option> 
                      <option value="2" @if(isset($data->status)) @if($data->status == 2) selected="true" @endif @endif>Reprovado</option> 
                    </select>
                  </div>
                </div>
              </div>
              <?php }?>

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