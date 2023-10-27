@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 style="float:left" class="card-title">Dominios</h4>
          <br>
          <a style="float:right;margin-top:-25px;" href="/{{$principal}}/{{$rota}}/create" class="btn btn-primary"><i class="fas fa-folder-plus"></i> Novo</a>
          <br>
          <!-- <form method="post" action="/painel/domain/search" style="margin-top:20px">
            {!! csrf_field() !!}
            <div class="row">
              <div class="col-md-4">
                <input type="text" class="form-control" name="name">
              </div>
              <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
              </div>
            </div>
          </form> -->
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="table" class="table mb-0">
            <thead class="thead-light">
              <tr   class="text-center">

                <th scope="col">Cód.</th>
                <th scope="col">Domínio</th>
                <th scope="col">Cliente</th>
                <th scope="col">Ações</th>

              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr class="">
                <td>{{$dado->id_domain}}</td>
                <td><a href="/{{$principal}}/{{$rota}}/view-site/{{$dado->$primaryKey}}">{{$dado->name}}</a></td>
                <td><a href="/{{$principal}}/{{$rota}}/client/{{$dado->id_user}}">{{$dado->nameClient}}</a></td>
                <td>
                
                  <div class="progress" id="button-load-create-ad-unit-{{$dado->$primaryKey}}" style="display:none">
                      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                  </div>

                  <div class="dropdown show">

                      <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog" aria-hidden="true"></i>
                      </a>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        
                         <a href="#" data-domain="{{$dado->name}}" class="dropdown-item adstxt" title="Validar ads.txt">
                            <i class="fa fa-warning"></i> Validar ads.txt
                          </a>

                          <a href="/{{$principal}}/{{$rota}}/ad-unit-positions/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                            <i class="fa fa-refresh"></i> Implantação
                          </a>


                          <a href="/{{$principal}}/{{$rota}}/ad-unit-positions-publisher/{{$dado->$primaryKey}}" class="dropdown-item" title="Blocos Manuais">
                            <i class="fa fa-link"></i> Blocos Manuais
                          </a>
                         
                          <a href="{{URL('painel/domain/blocos-fixos')}}/{{$dado->$primaryKey}}" class="dropdown-item" title="Blocos Automaticos">
                            <i class="fa fa-link"></i> Blocos Automáticos
                          </a>

                        <a href="/{{$principal}}/{{$rota}}/ad-unit-positions/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                          <i class="fa fa-sort-alpha-asc"></i> Gerenciar Blocos
                        </a>

                        <a href="/{{$principal}}/{{$rota}}/show/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                          <i class="far fa-edit"></i> Editar
                        </a>

                        <a href="/{{$principal}}/domain-notification/session-domain/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                          <i class="fa fa-bell"></i> Notificações
                        </a>

                        <a target="_blank" href="/{{$principal}}/{{$rota}}/view-site/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                          <i class="fa fa-link"></i> Analise
                        </a>

                        <a target="_blank" href="{{URL('painel/domain/download-ad-units')}}/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                            <i class="fa fa-download"></i> Download Blocos
                          </a>

                        <a target="_blank" href="{{URL('painel/domain/download-ad-units-refresh')}}/{{$dado->$primaryKey}}" class="dropdown-item" title="Atualizar/Visualizar">
                            <i class="fa fa-download"></i> Download Blocos Refresh
                          </a>
                      </div>
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

<script>
function CreateAdUnit(id_domain){
  $('#button-load-create-ad-unit-'+id_domain).show();
  $('#button-create-ad-unit-'+id_domain).hide();
  $.get("/painel/ad-manager-ad-unit/generate/"+id_domain, function(data, status){
    if(data == 1){
      $('#button-load-create-ad-unit-'+id_domain).hide();
      $('#button-create-ad-unit-'+id_domain).show();
      Swal.fire("Blocos Gerados!", "Blocos gerados com sucesso!", "success");
    }
  });
}
</script>

<script>
//
// Swal.fire({
//   title: "<i>Arquivo Gerado</i>",
//   html: " <b>CDN: </b> <br> https://beetadsscripts.nyc3.digitaloceanspaces.com/crm/p_$idDomain.js <br> <br> Slot1: <div id='3203232923029'></div>",
//   confirmButtonText: "V <u>redu</u>",
// });
//

function CreateFileDO(id_domain){
  $('#button-load-file-do-'+id_domain).show();
  $('#button-create-file-do-'+id_domain).hide();
  $.get("/painel/domain/digital-ocean/"+id_domain, function(data, status){
    //if(data == 1){
      $('#button-load-file-do-'+id_domain).hide();
      $('#button-create-file-do-'+id_domain).show();
      Swal.fire("", "Arquivo gerado com sucesso!", "success");

      var hh = "<b>test</b>";



      data = JSON.parse(data);
      var text = data.urlCDN;
      navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
      }, function(err) {
        console.error('Async: Could not copy text: ', err);
      });
  //  }
  });
}



$('.adstxt').click(function(e){
  e.preventDefault();
  var dominio = $(this).attr('data-domain');
  var info = {'domain':dominio, "_token": "{{ csrf_token() }}",};

  $.ajax({
    type: "post",
    url: "/painel/domain/adstxt/",
    data: info,
    success: function (response) {
      var retorno = JSON.parse(response);
        // console.debug($(this).attr('data-domain'));
        Swal.fire({
          title: "<i>Verificação Ads.txt</i>",
          html: retorno.msg,
          confirmButtonText: "Fechar",
        });
      
    }
  });


})
</script>

@endsection
