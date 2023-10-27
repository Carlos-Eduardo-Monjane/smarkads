@extends('painel.layouts.app')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Dominios</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr   class="text-center">
                <th scope="col">Cód.</th>
                <th scope="col">Endereço</th>
                <th scope="col">Informações</th>                
                <th scope="col">Automáticos (Fácil)</th>
                <th scope="col">Blocos (Média)</th>
                <!-- <th scope="col">Download (Difícil)</th> -->
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr class="text-center">
                <td>{{$dado->id_domain}}</td>
                <td><a href="/{{$principal}}/{{$rota}}/show/{{$dado->id_domain}}">{{$dado->name}}</a></td>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/show/{{$dado->id_domain}}" class="btn btn-icon btn-round btn-info" title="Atualizar/Visualizar">
                    <i class="fa fa-user"></i>
                  </a>
                </td>
                
                <td>
                  <a href="/{{$principal}}/{{$rota}}/blocos-fixos/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-primary" title="Blocos Automaticos">
                    <i class="fa fa-link"></i>
                  </a>
                </td>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/ad-unit-positions-publisher/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-warning" title="Atualizar/Visualizar">
                    <i class="fa fa-sort-alpha-asc"></i>
                  </a>
                </td>
                <!-- <td>
                  <a href="/{{$principal}}/{{$rota}}/download-ad-units/{{$dado->$primaryKey}}" style="display: none;" class="btn btn-icon btn-round btn-secondary hide" title="Baixar Blocos">
                    <i class="fa fa-download" title="Bloco"></i> 
                  <br />Bloco LazyLoad<br /><br /></a>
                  <a href="/{{$principal}}/{{$rota}}/download-ad-units-refresh/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-secondary" title="Baixar Blocos">
                    <i class="fa fa-download" alt="Bloco com Refresh"></i> 
                  </a>
                </td> -->
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
