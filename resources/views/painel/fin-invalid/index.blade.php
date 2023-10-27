@extends('painel.layouts.app')
@section('content')


<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          
        
          <h3 class="card-title" style="float:left;; margin-top:20px;">Inválidos</h3>         
        
        			
        
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table mb-0" id="table">
            <thead class="thead-light">
              <tr>
                <th scope="col">Cód.</th>
                <th scope="col">Mês/Ano</th>
                <th scope="col">Ciente</th>
                <th scope="col">Valor</th>
                <th scope="col">Data</th>
                <th scope="col">Por</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>{{$dado->id_fin_invalid}}</td>
                <td>{{$dado->month}}/{{$dado->year}}</td>
                <td><a href="/painel/users/show/{{$dado->id_client}}">{{$dado->id_client}} - {{$dado->cliente_nome}}</a></td>
                <td>$ {{Helper::moedaView($dado->value)}}</td>
                <td>{{Helper::formatDateTime($dado->created_at)}}</td>
                <td><?php echo explode(' ',$dado->usuario_nome)[0] ?></td>             
                
                <td>

                  <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                  </a>

                  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
                      {!! csrf_field() !!}
                    </form>
                    <?php if(Auth::user()->id == '1255' || Auth::user()->id == '1260' || Auth::user()->id == '1288'){ ?>
                      <a href="#" class="dropdown-item" onclick="deletar({{$dado->$primaryKey}})" title="Remover"><i class="fa fa-trash"></i>  Excluir</button>
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
      "pageLength": 1000,
      "order": [[ 0, "asc" ]]
    });
} );
</script>


@endsection