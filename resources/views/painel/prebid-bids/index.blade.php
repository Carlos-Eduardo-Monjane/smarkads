@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Prebid Bids</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Bidder</th>
                <th scope="col">Ativar</th>
                <th scope="col">Alterar</th>
                <th scope="col">Apagar</th>
                <th scope="col">Placement</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>
                  {{$dado->name}}
                </td>
                <td>
                  @if($dado->enable == 1)
                  <a href="/{{$principal}}/{{$rota}}/enable-disable/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-success" title="Atualizar/Visualizar">
                    <i class="fa fa-check"></i>
                  </a>
                  @else
                  <a href="/{{$principal}}/{{$rota}}/enable-disable/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-danger" title="Atualizar/Visualizar">
                    <i class="fa fa-ban"></i>
                  </a>
                  @endif
                </td>

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
                <td>
                  <a href="/{{$principal}}/prebid-placement/session-bids/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-primary" title="Atualizar/Visualizar">
                    <i class="fa fa-eye"></i>
                  </a>
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
