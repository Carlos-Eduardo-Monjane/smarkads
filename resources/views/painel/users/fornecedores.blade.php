@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
          <div class="row">
            <div class="card-heading">
              <div class="col-md-12">
                <h4 class="card-title">Fornecedores</h4>
                
              </div>
              <a href="/painel/users/create" class="btn btn-success" style="float:right;display:block;right: 0;position: absolute;margin-top: -32px;margin-right: 10px;">Adicionar</a>
            </div>
          
        </div>
      </div>
      @if(isset($report))
      <div class="row widget-social">
        <div class="col-xl-12 col-md-12">
            <div class="card card-statistics widget-social-box1 px-2">
                <div class="card-body pb-3 pt-4">
                    <div class="text-center">
                        <div class="mt-3">
                            <ul class="nav justify-content-between mt-4 px-3 py-2">
                                <li class="flex-fill">
                                    <h3 class="mb-0">{{$countContractUser}}</h3>
                                    <p>Contratos Assinados</p>
                                </li>
                                <li class="flex-fill">
                                    <h3 class="mb-0">{{$countClientActive}}</h3>
                                    <p>Usuários ativos</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      @endif
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table mb-0 table table-striped table-bordered">
            <thead class="thead-light">
              <tr class="text-center">
                <th scope="col">Cód</th>
                <th scope="col">Empresa</th>
                <th scope="col">CNPJ/CPF</th>
                <th scope="col">Data de Criação</th>
                
              </tr>
            </thead>
            <tbody>

              @forelse($data as $dado)
              <tr class="text-left">
                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->id}}</a></th>
                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->name}}</a>
                
                <span style="display:none">{{$dado->email}}</span>
                </th>


                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{Helper::cpfcnpj($dado->CPF_CNPJ)}}</a></th>
               


                <!-- <td>
                  <form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
                    {!! csrf_field() !!}
                  </form>
                  <button type="button" class="btn btn-icon btn-round btn-danger" onclick="deletar({{$dado->$primaryKey}})" title="Remover"><i class="fa fa-trash"></i></button>
                </td> -->


        
                <th scope="row" style="font-size:12px">{{Helper::formatDate($dado->created_at)}}</th>

               
              </tr>
              @empty
              <tr>
                <td colspan="100">Nenhum resultado encontrado</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="box-footer clearfix">
          {!! $data->render() !!}
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@section('scripts')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script> -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready( function () {
    $('#table').DataTable({
      "pageLength": 100,
      "order": [[ 0, "desc" ]],
      "language" : {
        "url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
      }
    });
} );
</script>

@endsection
