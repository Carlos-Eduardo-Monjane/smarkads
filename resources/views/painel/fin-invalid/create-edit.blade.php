@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title"><?php echo $title; ?></h4>
          <p>Nome: {{$user_dado->name}}</p>
          <p>Cód: {{$user_dado->id}}</p>
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
                    <label for=""> Mês Referência</label>
                    <select class="form-control"  name="month">
                      <option value="">Selecione</option>
                      <?php for ($i=1; $i < 13; $i++) { ?>
                      <option value="{{$i}}" @if(isset($month)) @if($month == $i) selected="true" @endif @endif>{{Helper::mes($i)}} </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>         
              
              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Ano Referência</label>
                    <select class="form-control"  name="year">
                      <option value="">Selecione</option>
                      <?php for ($i=2018; $i < 2026; $i++) { ?>
                      <option value="{{$i}}" @if(isset($year)) @if($year == $i) selected="true" @endif @endif>{{$i}} </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>    

              <div class="col-md-4">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Valor</label>
                    <input type="text" class="form-control valor" name="value" @if(old('value') != null) value="{{ old('value') }}" @elseif(isset($data->value)) value="{{$data->value}}"  @endif>
                  </div>
                </div>
              </div>     
            
              <input type="hidden" name="id_client" value="{{$id_client}}">
              <input type="hidden" name="urlPast" value="{{$urlPast}}">
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
<script type="text/javascript" src="/painel/assets/js/jquery.mask.min.js"></script>
<script>
  $(function(){
		    $('select').select2();
		    $('.valor').mask('#.##0,00', {reverse: true});
	})

    
</script>
<style>
.select2-container--open {
  z-index: 9999999
}
.select2-container .select2-selection--single{
  height: 39px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 38px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 37px;
    position: absolute;
    top: 1px;
    right: 1px;
    width: 20px;
}
.select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: 4px;
}
</style>
@endsection