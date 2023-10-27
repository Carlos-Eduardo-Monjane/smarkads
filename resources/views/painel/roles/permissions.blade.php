@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Grupo de Permissão</h4>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="/{{$principal}}/{{$rota}}/permissions/{{$idRole}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @csrf
          <div class="col-md-12 col-12 selects-contant">
            <div class="card card-statistics Multi-sel">
              <div class="card-header">
                <div class="card-heading">
                  <h4 class="card-title">Permissões</h4>
                </div>
              </div>
              <div class="card-body">
                <div class="form-group mb-0">
                  <select class="js-basic-multiple form-control" name="permissao[]" multiple="multiple">
                    @foreach($Permissoes as $Permissao)
                    <option value="{{$Permissao->id}}" @if($PermissionsRule->where('permission_id', $Permissao->id)->count() > 0) selected @endif>{{$Permissao->readable_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
          </div>
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
