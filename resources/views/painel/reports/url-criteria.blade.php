@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Análises</h4>
        </div>
      </div>
      <div class="card-body">
        <form method="POST" action="/{{$principal}}/{{$rota}}/filter/url-criteria" accept-charset="UTF-8" enctype="multipart/form-data">
          @csrf
          <div class="row">

            <div class="col-md-3">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for=""> Domínio </label>
                  <select class="form-control" name="id_domain_admanager_report">
                    <option value="">Selecione </option>
                    @foreach($domains as $domain)
                    <option value="{{$domain->id_domain}}" @if(!empty(session('id_domain_admanager_report'))) @if(session('id_domain_admanager_report') == $domain->id_domain) selected="true" @endif @endif>{{$domain->name}} </option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-3">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for=""> Filtrar </label>
                  <select class="form-control" name="filter" id="filter">
                    <option value="">Selecione </option>
                    <option value="1" @if(!empty(session('filter'))) @if(session('filter') == 1) selected @endif @endif >Hoje</option>
                    <option value="2" @if(!empty(session('filter'))) @if(session('filter') == 2) selected @endif @endif>Ontem</option>
                    <option value="3" @if(!empty(session('filter'))) @if(session('filter') == 3) selected @endif @endif>Mês Atual</option>
                    <option value="4" @if(!empty(session('filter'))) @if(session('filter') == 4) selected @endif @endif>Mês Anterior</option>
                    <option value="5" @if(!empty(session('filter'))) @if(session('filter') == 5) selected @endif @endif>Data Customizada</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-md-2 custon_date" style="display: none">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Data de Inicio</label>
                  <div class="input-group date display-years" data-date-format="dd-mm-yyyy">
                    <input class="form-control" type="text" name="start_date" id="startDate" @if(!empty(session('start_date'))) value="{{session('start_date')}}" @endif>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2 custon_date" style="display: none">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="inputEmail4">Data de Termino</label>
                  <div class="input-group date display-years" data-date-format="dd-mm-yyyy">
                    <input class="form-control" type="text" name="end_date" id="endDate" @if(!empty(session('end_date'))) value="{{session('end_date')}}" @endif>
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <button type="submit" class="btn btn-primary" style="margin-top: 26px;">Filtrar</button>
                </div>
              </div>
            </div>
          </div>

          <br>
          <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
      </div>
    </div>
  </div>
</div>



<div class="row">
  <div class="col-lg-12">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="datatable-wrapper table-responsive">
          <table id="datatable" class="display compact table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">Url</th>
                <th scope="col">Impressões</th>
                <th scope="col">Cliques</th>
                <th scope="col">RPM Mobile</th>
                <th scope="col">Receita Mobile</th>
                <th scope="col">RPM Desktop</th>
                <th scope="col">Receita Desktop</th>
                <th scope="col">Receita Total</th>
              </tr>
            </thead>
            <tbody>
              @forelse($data as $dado)
              <tr>
                <td>
                  <a href="{{$dado->url}}" target="_blank" class="btn btn-icon btn-round btn-secondary" title="Atualizar/Visualizar">
                    <i class="fa fa-link"></i>
                  </a>
                </td>
                <td>{{$dado->impressions}}</td>
                <td>{{$dado->clicks}}</td>
                <td>{{$dado->ecpmMobile}}</td>
                <td>{{$dado->earningsMobile}}</td>
                <td>{{$dado->ecpmDesktop}}</td>
                <td>{{$dado->earningsDesktop}}</td>
                <td>{{$dado->earnings}}</td>
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

@endsection

@section('scripts')
<script>


// $('#datatable').DataTable({
//   "language": {
//     "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
//     "oPaginate": {
//       "sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
//     },
//   }
// });


@if(!empty(session('filter')))
@if(session('filter') == 5)
$(".custon_date").show();
@endif
@endif

$(document).ready(function(){
  $("#filter").change(function(){
    if(this.value == 1){
      $(".custon_date").hide();
      $("#startDate").val("<?php echo date('d-m-Y') ?>");
      $("#endDate").val("<?php echo date('d-m-Y') ?>");
    }else if(this.value == 2){
      $(".custon_date").hide();
      $("#startDate").val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). " - 1 days")) ?>");
      $("#endDate").val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). " - 1 days")) ?>");
    }else if(this.value == 3){
      $(".custon_date").hide();
      $("#startDate").val("<?php echo date('01-m-Y') ?>");
      $("#endDate").val("<?php echo date('t-m-Y') ?>");
    }else if(this.value == 4){
      $(".custon_date").hide();
      $("#startDate").val("<?php echo date('01-m-Y', strtotime(date('d-m-Y'). " - 1 month")) ?>");
      $("#endDate").val("<?php echo date('t-m-Y', strtotime(date('d-m-Y'). " - 1 month")) ?>");
    }else if(this.value == 5){
      $(".custon_date").show();
      $("#startDate").val("<?php echo date('01-m-Y') ?>");
      $("#endDate").val("<?php echo date('d-m-Y', strtotime(date('d-m-Y'). " - 1 days")) ?>");
    }
  });
});
</script>
@endsection
