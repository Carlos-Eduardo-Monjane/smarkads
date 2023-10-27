@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Contrato</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/user-new" class="btn btn-primary">Novo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Cliente</th>
                <th scope="col">Pag.</th>
                <th scope="col">Data Inicio</th>
                <th scope="col">Data Termino</th>
                <th scope="col">Alterar</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>{{$dado->id_contract_user}}</td>
                <td>
                  {{$dado->name}}
                </td>
                <td>@if($dado->pay_time) {{$dado->pay_time}} dias @endif</td>
                <td>
                  {{date('d/m/Y', strtotime($dado->start_date))}}
                </td>
                <td>
                  {{date('d/m/Y', strtotime($dado->end_date))}}
                </td>
                <td>
                  <a href="/{{$principal}}/{{$rota}}/show-user-new/{{$dado->$primaryKey}}" class="btn btn-icon btn-round btn-dark" title="Atualizar/Visualizar">
                    <i class="far fa-edit"></i>
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
