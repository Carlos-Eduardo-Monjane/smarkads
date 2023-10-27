@extends('painel.layouts.app')
@section('content')

<div class="row">
  <div class="col-12 col-lg-12">
    <div class="card card-statistics">
      <div class="card-header">
        <div class="card-heading">
          <h4 style="float:left" class="card-title">Dominios</h4>
          <div style="float:right; margin-top:-10px">
          <a href="#" class="btn btn-primary iframe" data-site="{{Helper::removalHttp($data->name)}}">Site</a>
          <a href="#" class="btn btn-primary iframe" data-site="{{Helper::removalHttp($data->name)}}/wp-admin">WordPress</a>
          <a target="_blank" href="/painel/users/show/{{$data->id_user}}" class="btn btn-primary" >Cliente</a>
          <a target="_blank" href="/painel/domain-notification/session-domain/{{$data->id_domain}}" class="btn btn-primary" >Notificação</a>
          <a target="_blank" href="/painel/domain/ad-unit-positions/{{$data->id_domain}}" class="btn btn-primary" >Bloco</a>
          </div>
        </div>
      </div>
      <div class="card-body">
        URL: <span id="url">{{Helper::removalHttp($data->name)}}</span>
        <iframe src="{{Helper::removalHttp($data->name)}}" width="100%" height="800" frameborder="0" id="iframe"></iframe>
        <p>Atenção para o WordPress abrir você deve adicionar as informações no arquivo functions.php do theme:</p>
        <pre style="background:#f6f6fa;padding:10px; box-sizing:border-box;">
        remove_action( 'login_init', 'send_frame_options_header' );
        remove_action( 'admin_init', 'send_frame_options_header' );</pre>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')

<script>

iframe = document.getElementById('iframe');

$('.iframe').click(function(){
    iframe.src=$(this).attr('data-site');
    $('#url').html($(this).attr('data-site'));
})

</script>
@endsection




