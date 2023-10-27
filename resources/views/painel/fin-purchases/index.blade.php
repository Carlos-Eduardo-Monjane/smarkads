@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Pedido de Compras</h4>
          <br>
          <a href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary" style="float:right;margin-top:-45px;">Novo</a>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table mb-0">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Data</th>
                <th scope="col">Solicitante</th>
                <th scope="col">Comprar</th>
                <th scope="col">Valor</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>{{$dado->id_fin_purchases}}</td>
                <td data-sort="{{$dado->date}}">{{Helper::formatDateTime($dado->date)}}</td>
                <td>{{$dado->solicitante}}</td>
                <td><a href="#" class="popo" data-toggle="popover" title="{{$dado->name}}"  data-content="{{$dado->observation}}" data-placement="left" >{{$dado->name}}</a></td>
                <td>R$ {{Helper::moedaView($dado->valor)}}</td>
                <td>
                  @if($dado->status == 1)
                  <p class="list-group-item-text">
                    <span class="label label-success popo" data-toggle="popover" data-content="{{$dado->approval}}">Aprovado</span>
                  </p>
                  @elseif($dado->status == 2)
                  <p class="list-group-item-text">
                    <span class="label label-danger popo" data-toggle="popover" data-content="{{$dado->approval}}">Reprovado</span>
                  </p>
                  @else
                  <p class="list-group-item-text">
                    <span class="label label-info">Aguardando</span>
                  </p>
                  @endif
                </td>
                <td>
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                  </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                  <a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">Editar</a>
                  <form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
                    {!! csrf_field() !!}
                  </form>
                  <?php if(Auth::user()->id == '1255' || Auth::user()->id == '1260' || Auth::user()->id == '1288'){ ?>
                  <button type="button" class="dropdown-item" onclick="deletar({{$dado->$primaryKey}})" title="Remover">Excluir</button>
                  <?php } ?>
                </div>
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

    </div>
  </div>
</div>
</div>



@endsection


@section('scripts')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready( function () {
    $('#table').DataTable({
      "pageLength": 100,
      "order": [[ 4, "asc" ]],
      "language" : {
        "url":"https://cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json"
      }
    });

    $('.popo').popover({
    container: 'body'
  })
} );
</script>


@endsection
