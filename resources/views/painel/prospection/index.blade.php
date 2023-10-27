@extends('painel.layouts.app')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Prospecção</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary">Novo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Dominio</th>
                <th scope="col">Mensagem</th>
                <th scope="col">Data/Hora</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td> {{$dado->name}} </td>
                <td> {{$dado->email}} </td>
                <td> {{$dado->domain}} </td>
                <td> {{$dado->message}} </td>
                <td> {{date('d-m-Y H-i', strtotime($dado->created_at))}} </td>
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
