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
                <th scope="col">#</th>
                <th scope="col">Cliente</th>
                <th scope="col">Contrato</th>
                <th scope="col">Status</th>
                <th scope="col">Assinatura Cliente</th>
                <th scope="col">Assinatura Admin</th>
                <th scope="col">Contrato</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>
                  {{$dado->id_contract_user}}
                </td>
                <td>
                  {{$dado->name}}
                </td>
                <td>
                  {{$dado->title}}
                </td>
                <td>
                  @if($dado->status == 1)
                  <a href="/{{$principal}}/{{$rota}}/signature-admin-contract/{{$dado->$primaryKey}}">
                    <span class="label label-warning">Aguardando Assinatura Administrador</span>
                  </a>
                  @elseif($dado->status == 2)
                  <span class="label label-success">Assinado</span>
                  @else
                  <span class="label label-danger">Aguardando Assinatura cliente</span>
                  @endif
                </td>
                <td>
                  <img width="100" src="{{URL('assets/painel/uploads/signature')}}/{{$dado->signature}}" alt="">
                </td>
                <td>
                  <img width="100" src="{{URL('assets/painel/uploads/signature')}}/{{$dado->signature_admin}}" alt="">
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
