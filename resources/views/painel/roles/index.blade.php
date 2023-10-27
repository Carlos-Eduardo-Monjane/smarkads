@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Grupo de Permissão</h4>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Grupo</th>
                <th scope="col">Alterar</th>
                <th scope="col">Apagar</th>
                <th scope="col">Permissões</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <th scope="row" >{{$dado->id}}</th>
                <td>{{$dado->name}}</td>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-dark" title="Atualizar/Visualizar">
                    <i class="far fa-edit"></i>
                  </a>
                </td>
                <td>
                  <form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
                    {!! csrf_field() !!}
                  </form>
                  <button type="button" class="btn btn-icon btn-round btn-danger" onclick="deletar({{$dado->$primaryKey}})" title="Remover"><i class="fa fa-trash"></i></button>
                </td>
                <td style="width:40px">
                  <a href="/{{$principal}}/{{$rota}}/permissions/{{$dado->$primaryKey}}" class="btn btn-round btn-info" title="Atualizar/Visualizar"><i class="fa fa-lock"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="100">Nenhum resultado encontrado</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
      <div class="box-footer clearfix">
        {!! $data->render() !!}
      </div>
    </div>
  </div>
</div>



@endsection
