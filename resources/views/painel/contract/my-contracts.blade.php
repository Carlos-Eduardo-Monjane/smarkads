@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Contratos</h4>
        </div>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Contrato</th>
                <th scope="col">Status</th>
                <th scope="col">Assinatura</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>
                  {{$dado->title}}
                </td>
                <td>
                  @if($dado->status == 1)
                  <span class="label label-success">Aguardando Assinatura Administrador</span>
                  @elseif($dado->status == 2)
                  <span class="label label-success">Assinado</span>
                  @else
                  <a href="/{{$principal}}/{{$rota}}/my-contract/{{$dado->$primaryKey}}">
                    <span class="label label-danger"> <i class="fa fa-edit"></i> Assinar</span>
                  </a>
                  @endif
                </td>
                <td>
                  <img width="100" src="{{URL('assets/painel/uploads/signature')}}/{{$dado->signature}}" alt="">
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
