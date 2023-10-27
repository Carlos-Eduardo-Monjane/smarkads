@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Checklist</h4>
          <br>
          <div class="row" style="text-align: right;">
            <div class="col-md-12">
              <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Nome</th>
                <th scope="col">Ordem</th>
                <th scope="col">Status</th>
                <th scope="col">Alterar</th>
                <th scope="col">Apagar</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>{{$dado->id_domain_checklist}}</td>
                <td>
                  {{$dado->name}}
                </td>
                <td>{{$dado->ordem}}</td>
                <td>{{Helper::status($dado->status)}}</td>
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
