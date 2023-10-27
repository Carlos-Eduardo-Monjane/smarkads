@extends('painel.layouts.app')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Inválidos</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Valor</th>
                <th scope="col">Ano</th>
                <th scope="col">Mês</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>$ {{number_format($dado->value, 2, ',', '.')}}</td>
                <td>{{$dado->year}}</td>
                <td>{{$dado->month}}</td>
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
</div>



@endsection
