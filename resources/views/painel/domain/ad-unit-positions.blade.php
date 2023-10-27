@extends('painel.layouts.app')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Posicionamento dos Blocos</h4>
        </div>
      </div>

      <div class="card-body">
        @if(!isset($block))
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead class="thead-light">
                <tr class="text-center">
                  <th scope="col">Gerar Blocos</th>
                  <th scope="col">Blocos Manuais</th>
                  <th scope="col">Blocos Automaticos</th> 
                  <th scope="col">Disabilitar Blocos</th>
                </tr>
              </thead>
              <tbody>
                <tr class="text-center">
                  <td>
                    <button id="button-create-ad-unit-{{$idDomain}}" onclick="CreateAdUnit({{$idDomain}})" class="btn btn-icon btn-round btn-primary" title="Atualizar/Visualizar">
                      <i class="fa fa-refresh"></i>
                    </button>
                    <div class="progress" id="button-load-create-ad-unit-{{$idDomain}}" style="display:none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                    </div>
                  </td>
                  <td>
                    
                    <a href="/painel/domain/ad-unit-positions-publisher/{{$idDomain}}" class="btn btn-icon btn-round btn-info" title="Atualizar/Visualizar">
                      <i class="fa fa-link"></i>
                    </a>
                  </td>
                  <td>
                    
                    <a href="/painel/domain/blocos-fixos/{{$idDomain}}" class="btn btn-icon btn-round btn-info" title="Atualizar/Visualizar">
                      <i class="fa fa-link"></i>
                    </a>
                  </td>
                  <!-- 
                  <td>
                    <button id="button-create-file-do-{{$idDomain}}" onclick="CreateFileDO({{$idDomain}})" class="btn btn-icon btn-round btn-primary" title="Atualizar/Visualizar">
                      <i class="fa fa-code"></i>
                    </button>
                    <div class="progress" id="button-load-file-do-{{$idDomain}}" style="display:none">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                    </div>
                  </td>
                  <td>
                    <a href="/{{$principal}}/{{$rota}}/positions-prebid/{{$idDomain}}" class="btn btn-icon btn-round btn-warning" title="Atualizar/Visualizar">
                      <i class="fa fa-download"></i>
                    </a>
                  </td> -->
                  <td>
                    <a href="#" onclick="apagarFileDo({{$idDomain}})" class="btn btn-icon btn-round btn-danger" title="Atualizar/Visualizar">
                      <i class="fa fa-tasks"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        @endif



        <div class="row" id="divUrlDigitalOcean" @if(isset($domain->file_do)) @if(!empty($domain->file_do)) style="display: block;" @else style="display: none;" @endif @else style="display: none;" @endif >
          <div class="col-md-12">
            <input type="text" class="form-control" id="inputUrlDigitalOcean" readOnly @if(isset($domain->file_do)) @if(!empty($domain->file_do))  value='<script async type="text/javascript" src="https://beetadsscripts.nyc3.cdn.digitaloceanspaces.com/crm/{{$domain->id_domain}}/{{$domain->file_do}}"> </script>' @endif @endif>
          </div>
        </div>
        <br>

        <form method="POST" action="/{{$principal}}/{{$rota}}/ad-unit-positions{{$function}}/{{$idDomain}}" accept-charset="UTF-8" enctype="multipart/form-data">
          @csrf
        <div class="datatable-wrapper table-responsive">

            <table class="display compact table table-striped table-bordered">
              <thead class="thead-light">
                <tr>
                  <th scope="col">Bloco</th>
                  <th scope="col">Bids</th>
                  <th scope="col">Status</th>
                  <th scope="col">Posição</th>
                  <th scope="col">Div</th>
                  <th scope="col">Alterar Div</th>
                  <th scope="col">Lazyload</th>
                  <th scope="col">Refresh</th>
                </tr>
              </thead>
              <thead>
                <tr>
                  <td> </td>
                  <th>
                    <select class="form-control js-basic-multiple" id="bids" multiple style="width: 100px !important">
                      @foreach($bids as $bid)
                      <option value="{{$bid->id_prebid_bids}}">{{$bid->name}} </option>
                      @endforeach
                    </select>
                  </th>
                  <th> </th>
                  <td>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <select class="form-control position" id="position">
                          <option value="">Selecione</option>
                          <option value="first_paragraph">Primeiro Parágrafo</option>
                          <option value="second_paragraph">Segundo Parágrafo </option>
                          <option value="third_paragraph">Teceiro Parágrafo</option>
                          <option value="four_paragraph">Quarto Parágrafo</option>
                          <option value="five_paragraph">Quinto Parágrafo</option>
                          <option value="six_paragraph">Sexto Parágrafo</option>
                          <option value="seven_paragraph">Setimo Parágrafo</option>
                          <option value="eight_paragraph">Oitavo Parágrafo</option>
                          <option value="nine_paragraph">Nono Parágrafo</option>
                          <option value="ten_paragraph">Decimo Parágrafo</option>
                          <option value="after_the_content">Final do Conteúdo</option>
                          <option value="before_the_content"> Antes do Conteúdo</option>
                          <option value="ad_shortcode"> Shortcode </option>
                          <option value="fixedMobile"> Fixed Mobile </option>
                          <option value="elementHtml"> Element Html </option>
                          <option value="TopFixed"> Fixed Desktop </option>
                          <option value="Sidebar"> Sidebar </option>
                          <option value="div"> Div </option>
                          <option value="elementPercent"> Porcentagem </option>
                        </select>
                      </div>
                    </div>
                  </td>
                  <td> </td>
                  <td> </td>
                  <td>
                    <div class="form-row text-center">
                      <div class="form-group col-md-12">
                        <input type="checkbox" id="lazyload"/>
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="form-row text-center">
                      <div class="form-group col-md-12">
                        <input type="number" id="refresh"/>
                      </div>
                    </div>
                  </td>

                </tr>
              </thead>

              <tbody>
                @foreach($data as $dado)
                <tr>
                  <td>{{$dado->ad_unit_name}}</td>
                  <th>
                    <style>
                      .select2-container{
                        width: 100px !important;
                      }
                    </style>
                      <select class="form-control js-basic-multiple bids" id="bids-{{$dado->id_ad_unit}}" name="update[{{$dado->id_ad_unit}}][bids][]" multiple style="width: 100px !important">
                        @foreach($bids as $bid)
                        <option value="{{$bid->id_prebid_bids}}" @if($bidsSelected->where('id_ad_unit', $dado->id_ad_unit)->where('id_prebid_bids', $bid->id_prebid_bids)->count() > 0) selected @endif>{{$bid->name}} </option>
                        @endforeach
                      </select>
                  </th>
                  <th> {{$dado->ad_unit_status}}</th>
                  <td>

                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <select class="form-control position" @if(isset($block)) disabled @endif name="update[{{$dado->id_ad_unit}}][position]"  onchange="changePositon({{$dado->id_ad_unit}}, this.value)">
                          <option value="">Selecione</option>
                          <option value="first_paragraph" @if($dado->position == 'first_paragraph') selected @endif>Primeiro Parágrafo</option>
                          <option value="second_paragraph" @if($dado->position == 'second_paragraph') selected @endif>Segundo Parágrafo </option>
                          <option value="third_paragraph" @if($dado->position == 'third_paragraph') selected @endif>Teceiro Parágrafo</option>
                          <option value="four_paragraph" @if($dado->position == 'four_paragraph') selected @endif>Quarto Parágrafo</option>
                          <option value="five_paragraph" @if($dado->position == 'five_paragraph') selected @endif>Quinto Parágrafo</option>
                          <option value="six_paragraph" @if($dado->position == 'six_paragraph') selected @endif>Sexto Parágrafo</option>
                          <option value="seven_paragraph" @if($dado->position == 'seven_paragraph') selected @endif>Setimo Parágrafo</option>
                          <option value="eight_paragraph" @if($dado->position == 'eight_paragraph') selected @endif>Oitavo Parágrafo</option>
                          <option value="nine_paragraph" @if($dado->position == 'nine_paragraph') selected @endif>Nono Parágrafo</option>
                          <option value="ten_paragraph" @if($dado->position == 'ten_paragraph') selected @endif>Decimo Parágrafo</option>
                          <option value="after_the_content" @if($dado->position == 'after_the_content') selected @endif>Final do Conteúdo</option>
                          <option value="before_the_content" @if($dado->position == 'before_the_content') selected @endif> Antes do Conteúdo</option>
                          <option value="ad_shortcode" @if($dado->position == 'ad_shortcode') selected @endif> Shortcode </option>
                          <option value="fixedMobile" @if($dado->position == 'fixedMobile') selected @endif> Fixed Mobile </option>
                          <option value="elementHtml" @if($dado->position == 'elementHtml') selected @endif> Element Html </option>
                          <option value="TopFixed" @if($dado->position == 'TopFixed') selected @endif> Fixed Desktop </option>
                          <option value="Sidebar" @if($dado->position == 'Sidebar') selected @endif> Sidebar </option>
                          <option value="div" @if($dado->position == 'div') selected @endif> Div </option>
                          <option value="elementPercent" @if($dado->position == 'elementPercent') selected @endif> Porcentagem </option>
                        </select>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="form-group" app-field-wrapper="name">
                      <input type="text" class="form-control" readOnly @if(isset($dado->id_div)) value='<div id="{{$dado->id_div}}"></div>' @else value='<div id="Position_{{explode("_", $dado->ad_unit_name)[3]}}"></div>' @endif>
                    </div>
                  </td>

                  <td>
                    <div class="form-row text-center">
                      <div class="form-group col-md-12">
                        <input type="text" @if(old('id_div') != null) value="{{ old('id_div') }}" @elseif(isset($dado->id_div)) value="{{$dado->id_div}}"  @endif name="update[{{$dado->id_ad_unit}}][id_div]"/>
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="form-row text-center">
                      <div class="form-group col-md-12">
                        <input type="hidden" value="0"  name="update[{{$dado->id_ad_unit}}][lazyload]">
                        <input type="checkbox" class="lazyload" value="1" @if($dado->lazyload == 1) checked @endif name="update[{{$dado->id_ad_unit}}][lazyload]"/>
                      </div>
                    </div>
                  </td>

                  <td>
                    <div class="form-row text-center">
                      <div class="form-group col-md-12">
                        <input type="number" class="refresh" @if(old('refresh') != null) value="{{ old('refresh') }}" @elseif(isset($dado->refresh)) value="{{$dado->refresh}}"  @endif name="update[{{$dado->id_ad_unit}}][refresh]"/>
                      </div>
                    </div>
                  </td>

                </tr>
                @endforeach
              </tbody>
            </table>

        </div>
        <br
        @if(count($data) > 0 && !isset($block))
        <div class="row">
          <div class="col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </div>
        @endif
      </form>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>
$('.js-basic-multiple').select2({multiple:true});
</script>

<script>


$("#bids").change(function(){
  //$('.js-basic-multiple').select2([2,103], null, false);
  var comands = '';
  $(".bids").each(function(index, element) {
    comands += '$("#'+element.id+'").val(['+$("#bids").val()+']).trigger("change");';
  });

  var F=new Function (comands);
  return(F());
});

$("#refresh").keyup(function(){
  $('.refresh').val($("#refresh").val());
});

$("#lazyload").change(function(){
  var status = $(this).is(":checked") ? true : false;
  $(".lazyload").prop("checked",status);
});

$("#position").change(function(){
  console.log($("#position").val());
  var value = $("#position").val();
  $('.position').val(value);
});

</script>
<script>
  function apagarFileDo(id) {
    Swal.fire({
      title: "Você tem certeza?",
      type: "warning",
      text: 'Quer realmente desabilitar os blocos desse site?',
      showCancelButton: true,
      confirmButtonClass: 'btn-danger',
      confirmButtonText: 'Sim!',
      closeOnConfirm: false,
      //closeOnCancel: false
    }).then((result) => {
      if (result.value) {
        Swal.fire(
          'Desabilitado!',
          'Blocos Desabilitados!',
          'success'
        );
        setTimeout(function () {
              window.location.href = '/{{$principal}}/{{$rota}}/disable/'+id;
        }, 1000);
      }
    });
  };
</script>

<script>
function changePositon(id, value){

  if(value == 'ad_shortcode'){
    document.getElementById("shortcode-"+id).readOnly = false;
  }else{
    document.getElementById("shortcode-"+id).readOnly = true;
    document.getElementById("shortcode-"+id).value = '';
  }

  if(value == 'elementHtml'){
    document.getElementById("elementHtml-"+id).readOnly = false;
    document.getElementById("positionElement-"+id).readOnly = false;
  }else{
    document.getElementById("elementHtml-"+id).readOnly = true;
    document.getElementById("positionElement-"+id).readOnly = true;

    document.getElementById("elementHtml-"+id).value = '';
    document.getElementById("positionElement-"+id).value = '';

  }

  if(value == 'elementPercent'){
    document.getElementById("positionElement-"+id).readOnly = false;
  }else{
    document.getElementById("positionElement-"+id).readOnly = true;
    document.getElementById("positionElement-"+id).value = '';
  }

}
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
      document.getElementById('inputUrlDigitalOcean').value = data.urlCDN;
      document.getElementById('divUrlDigitalOcean').style.display = 'block';

      var text = '<script async src="'+data.urlCDN+'"><\/script>';
      navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
      }, function(err) {
        console.error('Async: Could not copy text: ', err);
      });
  });
}
</script>

@endsection
