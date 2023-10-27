@extends('painel.layouts.app')
@section('content')
<!-- begin container-fluid -->
<div class="row">
  <div class="col-md-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 class="card-title">Contrato</h4>
        </div>
      </div>
      <div class="card-body">

        <form method="POST" action="/{{$principal}}/{{$rota}}/signature" accept-charset="UTF-8" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="status" value="1">
          <div class="row">
            <div class="col-md-12">
              <div style="height:350px; overflow: auto;" >
                
                <?php 
$contract = str_replace('{ravShare}', $data->rev_share, $data->description); 
$contract = str_replace('{pay_time}', $data->pay_time, $contract); 
?>

{!! $contract !!}
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col-md-12">
              <label>
                Assinatura
              </label>
              <canvas id="signature-pad" class="signature-pad" style="width:100%; height=200px; border-style: solid; border-color: #0000006e;"></canvas>
              <button type="button" id="clear" class="btn btn-danger">Limpar</button>
            </div>
          </div>
          <br>
          <input type="hidden" name="id_contract_user" value="{{$data->$primaryKey}}">
          <input type="hidden" name="signature" id="signature">
          <button onclick="submitForm()" id="save" type="submit" class="btn btn-primary" disabled>Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@section('scripts')
<script>

var canvas = document.getElementById('signature-pad');

$("#signature-pad").click(function(){
  $("#save").attr("disabled", false);
});

function resizeCanvas() {
  var ratio =  Math.max(window.devicePixelRatio || 1, 1);
  canvas.width = canvas.offsetWidth * ratio;
  canvas.height = canvas.offsetHeight * ratio;
  canvas.getContext("2d").scale(ratio, ratio);
}

window.onresize = resizeCanvas;
resizeCanvas();

var signaturePad = new SignaturePad(canvas, {
  backgroundColor: 'rgb(255, 255, 255)'
});

document.getElementById('clear').addEventListener('click', function () {
  signaturePad.clear();
});

function submitForm(){
  document.getElementById('signature').value = canvas.toDataURL('image/png');
}

</script>
@endsection
