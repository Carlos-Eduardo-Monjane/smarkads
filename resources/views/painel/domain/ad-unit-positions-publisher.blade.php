@extends('painel.layouts.app')
@section('content')
<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Monetização de Sites</h4>
        </div>
      </div>

      <div class="card-body">
       
        <p>1 - Crie o arquivo ads.txt na raiz do seu site de modo que fica seu.dominio/ads.txt usando o conteúdo abaixo: </p>
        <div class="row" id="divUrlDigitalOcean" >
          <div class="col-md-12">
            <input type="text" class="form-control" id="inputUrlDigitalOcean" readOnly  value='google.com, pub-9625631419750709, RESELLER, f08c47fec0942fa0'>
          </div>
        </div>
        <br>
        <p>2º - Copie o código abaixo e coloque uma linha antes da tag &lt;/head&gt;</p>
        <div class="row" id="divUrlDigitalOcean" >
          <div class="col-md-12">
            <input type="text" class="form-control" id="inputUrlDigitalOcean" readOnly  value='<script id="ad-unit-load" data-post-id="&lt;?php echo get_the_ID(); ?&gt;" type="text/javascript" src="https://app.monetizerads.com/scripts/ads<?php echo $domain['id_domain']; ?>.js" async></script>'>
          </div>
        </div>
        <br />
        <p>3º - Insira os códigos abaixo no seu conteúdo. Observe os códigos tem um identificador que vai de 1 a 9 e você pode setar se é para mobile ou para web:<br />obs: mobile=0 é para web e mobile=1 é para mobile</p>
        <div class="row" id="divUrlDigitalOcean" >
          <div class="col-md-12">
            <input type="text" class="form-control" id="inputUrlDigitalOcean" readOnly  value='<div class="ad-unit" data-bloco="Content1" data-mobile="0"></div>'>
          </div>
        </div><br />
        <p>Você tem disponivel os seguintes formatos:<br >
        • Content (de 1 a 9) ex: Content1, Content2, Content3 - ([250, 250],[250, 360],[300, 250],[336, 280])<br />
        • Sidebar (de 1 a 3) ex: Sidebar1, Sidebar2, Sidebar3 - ([250, 250],[250, 360],[300, 250],[336, 280],[120, 600],[160, 600],[300, 600])<br />
        • Fixed (de 1 a 3) ex: Fixed1, Fixed2, Fixed3         - ([320, 50],[728, 90])<br />
        • Interstitial ex: Interstitial<br />
        • Native. Obs: adicione o limite de blocos nativos com a tag: data-count. ex: data-count="4" <br />
      </p>
        
        <p>• Dica você pode adicionar um para mobile e um para web juntos adicionando duas vezes o bloco.</p>
        <div class="row" id="divUrlDigitalOcean" >
          <div class="col-md-12">
            <input type="text" class="form-control" id="inputUrlDigitalOcean" readOnly  value='<div class="ad-unit" data-bloco="Content1" data-mobile="0"></div><div class="ad-unit" data-bloco="Content1" data-mobile="1"></div>'>
          </div>
        </div>
        <br />

       

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
