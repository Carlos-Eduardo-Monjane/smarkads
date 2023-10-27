@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
          <div class="row">
            <div class="card-heading">
              <div class="col-md-12">
                <h4 class="card-title">Usuários</h4>
                
              </div>
              <a href="/painel/prospection/create" class="btn btn-success" style="float:right;display:block;right: 0;position: absolute;margin-top: -32px;margin-right: 10px;">Prospectar</a>
            </div>
          <br>
          <form method="post" class="col-md-12" action="/painel/users/pesquisa" style="display:none">
            {!! csrf_field() !!}
            <input type="hidden" name="idPermission" value="{{$idPermission}}">
            <div class="row">
              <div class="col-md-3">
                <select class="form-control" name="campo">
                  <option value="id">Cód</option>
                  <option value="name" selected>Nome</option>
                  <option value="company">Empresa</option>
                  <option value="email">E-mail</option>
                </select>
              </div>
              <div class="col-md-3">
                <input type="text" class="form-control" name="valor">
              </div>
              <div class="col-md-2">
                <select class="form-control" name="status">
                  <option value="">Selecione</option>
                  <option value="status_admanager" @if(session('PesquisaStatus') == 'status_admanager') selected @endif>Aprovado</option>
                  <option value="disapproved" @if(session('PesquisaStatus') == 'disapproved') selected @endif>Reprovado</option>
                  <option value="status_waiting" @if(session('PesquisaStatus') == 'status_waiting') selected @endif>Aguardando</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
              </div>
            </div>
          </form>
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
                <th scope="col">Nome</th>
                <th scope="col">Grupo</th>
                <th scope="col">Empresa</th>
                <th scope="col">CNPJ/CPF</th>
                <th scope="col">Status</th>


                <!-- <th scope="col">Apagar</th> -->
                <th scope="col">Contrato</th>



                <th scope="col">Data de Criação</th>

                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>

              @forelse($data as $dado)
              <tr class="text-center">
                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->id}}</a></th>
                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->name}}</a>
                
                <span style="display:none">
                  {{$dado->email}}
                </span>
                <span style="display:none">
                  {{$dado->dominios}}
                </span>
                </th>
                <th scope="row" style="font-size:12px">{{$dado->nameRole}}</th>
                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{$dado->company}}</a></th>
                <th scope="row" style="font-size:12px"><a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}">{{Helper::cpfcnpj($dado->CPF_CNPJ)}}</a></th>
                <th scope="row" >
                  @if($dado->status_admanager == 1)
                    <span style="font-size:12px; color:#1ecb5e;">Aprovado</span>
                  @elseif($dado->disapproved == 1)
                    <span style="font-size:12px; color:#ff0000;">Reprovado</span>
                  @elseif($dado->status_waiting == 1)
                    <span style="font-size:12px; color:#7630e4">Aguardando</span>
                  @elseif(!empty($dado->invite_admanager))
                    @if(((strtotime($dado->updated_at) - strtotime($dado->created_at) /60)/60) > 24)
                      <span style="font-size:12px; color:#7630e4">Verificar Aprovação</span>
                    @endif
                  @else
                    <span >Análise Pendente</span>
                  @endif
                </th>


                <!-- <td>
                  <form method="POST" action="/{{$principal}}/{{$rota}}/destroy/{{$dado->$primaryKey}}" id="deletar-{{$dado->$primaryKey}}" accept-charset="UTF-8">
                    {!! csrf_field() !!}
                  </form>
                  <button type="button" class="btn btn-icon btn-round btn-danger" onclick="deletar({{$dado->$primaryKey}})" title="Remover"><i class="fa fa-trash"></i></button>
                </td> -->


                <td>
                  @if(empty($dado->signature))
                    <i class="fa fa-thumbs-down" aria-hidden="true" style="color:#fb755a"></i>
                  @else
                    <i class="fa fa-thumbs-up" aria-hidden="true" style="color:#1ecb5e;"></i>
                  @endif
                </td>




                <th scope="row" style="font-size:12px">{{Helper::formatDate($dado->created_at)}}</th>

                <th scope="row">

                    <div class="dropdown show">
                      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog" aria-hidden="true"></i>
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      <a target="_blank" href="https://api.whatsapp.com/send?phone={{$dado->whatsapp}}&text=Ol%C3%A1%2C%20temos%20boas%20novas%20sobre%20a%20MonetizerAds" class="dropdown-item" title="WhatsApp">WhatsApp</a>
                      <a target="_blank" href="/{{$principal}}/{{$rota}}/alert/{{$dado->$primaryKey}}" class="dropdown-item" title="Notificação">Notificação</a>
                      <a target="_blank" href="/{{$principal}}/domain/client/{{$dado->$primaryKey}}" class="dropdown-item" title="Dominio">Dominios</a>
                      <a target="_blank" href="/{{$principal}}/{{$rota}}/auth-user/{{$dado->id}}/{{str_replace('/','',$dado->password)}}" class="dropdown-item" title="Login">Login</a>
                      <a target="_blank" href="/{{$principal}}/{{$rota}}/reset-password/{{$dado->$primaryKey}}" class="dropdown-item" title="Resetar senha">Resetar senha</a>
                      </div>
                    </div>
                </th>
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
