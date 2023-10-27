@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Contrato</h4>
        </div>
      </div>
      <div class="card-body">
        @if(isset($data->$primaryKey))
        <form method="POST" action="/{{$principal}}/{{$rota}}/update-user-new/{{$data->id_contract_user}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @else
          <form method="POST" action="/{{$principal}}/{{$rota}}/store-user-new" accept-charset="UTF-8" enctype="multipart/form-data">
            @endif
            @csrf

            <div class="row">


              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">RavShare %</label>
                    <input type="text" class="form-control" name="rev_share" @if(old('rev_share') != null) value="{{ old('rev_share') }}" @elseif(isset($data->rev_share)) value="{{$data->rev_share}}"  @endif>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Pagamento em: </label>
                    <select class="form-control" name="pay_time">
                      <option value="">Selecione</option>
                      <option value="30" @if(isset($data->pay_time)) @if($data->pay_time == 30) selected="true" @endif @endif>30 dias</option>
                      <option value="60" @if(isset($data->pay_time)) @if($data->pay_time == 60) selected="true" @endif @endif>60 dias</option>
                      <option value="90" @if(isset($data->pay_time)) @if($data->pay_time == 90) selected="true" @endif @endif>90 dias</option>
                      <option value="120" @if(isset($data->pay_time)) @if($data->pay_time == 120) selected="true" @endif @endif>120 dias</option>

                    </select>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Data de Inicio</label>
                    <div class="input-group date display-years" data-date-format="dd-mm-yyyy">
                        <input class="form-control" type="text" name="start_date" @if(old('start_date') != null) value="{{ old('start_date') }}" @elseif(isset($data->start_date)) value="{{date('d-m-Y', strtotime($data->start_date))}}"  @endif  >
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for="inputEmail4">Data de Termino</label>
                    <div class="input-group date display-years" data-date-format="dd-mm-yyyy">
                        <input class="form-control" type="text" name="end_date" @if(old('end_date') != null) value="{{ old('end_date') }}" @elseif(isset($data->end_date)) value="{{date('d-m-Y', strtotime($data->end_date))}}"  @endif  >
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-12">
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <label for=""> Cliente </label>
                    <select class="form-control" name="id_user">
                      <option value="">Selecione</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}" @if(isset($userSelected)) @if($userSelected->id == $user->id) selected="true" @endif @endif>{{$user->name}} </option>
                      @endforeach
                    </select>
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
    <script>
    $('.js-basic-multiple').select2();
    </script>
  @endsection
