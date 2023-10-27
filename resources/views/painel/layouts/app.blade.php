@inject('Settings', 'App\Models\Painel\Settings')
@inject('Alert', 'App\Models\Painel\Alert')
@inject('Permissions', 'App\Models\Painel\Permissions')
@inject('Assignment', 'App\Models\Painel\Assignment')
@inject('AssignmentServiceHour', 'App\Models\Painel\AssignmentServiceHour')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <title>{{$Settings->first()->name_system}}</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="BeetAds Network." />
  <meta name="author" content="Potenza Global Solutions" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- app favicon -->
  <link rel="shortcut icon" href="{{URL('/assets')}}/favicon.ico">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <!-- plugin stylesheets -->
  <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/css/vendors.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">
  <!-- app style -->
  <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/css/style.css" id="platformTheme" />
  <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/css/menu.css" id="platformThemeMenu" />
  <!-- <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/bootstrap-sweetalert/sweet-alert.css" /> -->
  <meta name="googlebot" content="noindex">
  <meta name="robots" content="noindex">

  <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script>
    $(document).ready(function(){

      if(localStorage.getItem('plataformTheme') == 1){

        $('#themeIconSelected').removeClass('far fa-sun').addClass('far fa-moon');
        $('#theme').val(1);

        $('#platformTheme').attr('href', "{{URL('/assets/painel')}}/css/style-dark.css"); 
        $('#platformThemeMenu').attr('href', "{{URL('/assets/painel')}}/css/menu-dark.css"); 
        $('#platFormBrandTheme').attr('src', "{{ asset('assets/site/logoResize/brand2.png') }}"); 

      }

    });
  </script>

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-WX4JMREF0W"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-WX4JMREF0W');
  </script>
</head>

<body>
  <!-- begin app -->
  <div class="app">
    <!-- begin app-wrap -->
    <div class="app-wrap">
      <!-- begin pre-loader -->
      {{-- <div class="loader">
        <div class="h-100 d-flex justify-content-center">
          <div class="align-self-center">
            <img src="{{URL('/assets/painel')}}/img/loader/loader.svg" alt="loader">
          </div>
        </div>
      </div> --}}

      <!-- end pre-loader -->
      <!-- begin app-header -->
      <header class="app-header top-bar">
        <!-- begin navbar -->
        <nav class="navbar navbar-expand-md">

          <!-- begin navbar-header -->
          <div class="navbar-header d-flex align-items-center">
            <a href="javascript:void:(0)" class="mobile-toggle"><i class="fas fa-grip-horizontal"></i></a>
            <a class="navbar-brand" href="/painel" style="width: 100%;">
              <img src="{{ asset('assets/site/logoResize/brand1.png') }}" id="platFormBrandTheme" class="xlogo-desktop" alt="logo" />
            </a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-user"></i>
          </button>
          <!-- end navbar-header -->
          <!-- begin navigation -->
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="navigation d-flex">

              <ul class="navbar-nav nav-right ml-auto">
                @if(session('idLoginAdmin'))
                <li class="nav-item dropdown user-profile" style="left: -60px;">
                  <a href="/painel/users/auth-admin" class="nav-link dropdown-toggle ">
                    <i class="fa fa-reply"></i>
                  </a>
                </li>
                @endif

                <li>
                  <div class="form-group-theme">
                    <label for="" class="labelTheme"><i class="far fa-sun" id="themeIconSelected"></i></label>
                    <select name="theme" id="theme" class="form-control-theme">
                        <option value="1">Escuro</option>
                        <option value="2" selected>Claro</option>
                    </select>
                  </div>
                </li>

                <script>
                  $(document).ready(function(){

                    $('#theme').on('change', () => {

                        $('#platFormMessageTheme').text('Estamos mudando seu tema...');
                        $('.base-loading').show();

                        var obj = $('#theme').val();

                        if(obj == 1){

                          localStorage.setItem('plataformTheme', 1);
                          setTimeout(() => {
                            $('#platFormMessageTheme').text('Estamos quase lá');
                          }, 2000);

                          $('#themeIconSelected').removeClass('far fa-sun').addClass('far fa-moon');
                          $('#theme').val(1);

                          $('#platformTheme').attr('href', "{{URL('/assets/painel')}}/css/style-dark.css"); 
                          $('#platformThemeMenu').attr('href', "{{URL('/assets/painel')}}/css/menu-dark.css"); 
                          $('#platFormBrandTheme').attr('src', "{{ asset('assets/site/logoResize/brand2.png') }}"); 

                        }else{

                          localStorage.setItem('plataformTheme', 2);

                          setTimeout(() => {
                            $('#platFormMessageTheme').text('Estamos quase lá');
                          }, 2000);

                          $('#themeIconSelected').removeClass('far fa-moon').addClass('far fa-sun');
                          $('#theme').val(2);

                          $('#platformTheme').attr('href', "{{URL('/assets/painel')}}/css/style.css"); 
                          $('#platformThemeMenu').attr('href', "{{URL('/assets/painel')}}/css/menu.css"); 
                          $('#platFormBrandTheme').attr('src', "{{ asset('assets/site/logoResize/brand1.png') }}");

                        }


                        setTimeout(() => {
                          $('#platFormMessageTheme').text('Pronto!');
                          $('.base-loading').fadeOut();
                        }, 5000);

                    });

                  });
                </script>

                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fe fe-bell"></i>
                      <span class="notify">
                      <span class="blink"></span>
                      <span class="dot"></span>
                    </span>
                  </a>
              <div class="dropdown-menu extended animated fadeIn" aria-labelledby="navbarDropdown">

                <ul>
                  <li class="dropdown-header bg-gradient p-4 text-white text-left">Notificações
                    <li class="dropdown-body min-h-240 nicescroll">
                      <ul class="scrollbar scroll_dark max-h-240">
                        @foreach($Assignment->get() as $A)
                            @if($AssignmentServiceHour::where('id_user', Auth::user()->id)->where('id_assignment', $A->id_assignment)->where('end', NULL)->count() > 0)
                            <li>
                              <a href="/painel/assignment">
                                <div class="notification d-flex flex-row align-items-center">
                                  <div class="notify-icon bg-img align-self-center">
                                    <div class="bg-type bg-type-md">
                                      <span>NT</span>
                                    </div>
                                  </div>
                                  <div class="notify-message">
                                    <p class="font-weight-bold">{{$A->subject}}</p>
                                    <small>Just now</small>
                                  </div>
                                </div>
                              </a>
                            </li>
                          @endif
                        @endforeach
                      </ul>
                    </li>
                  </ul>
                </div>
              </li>


              <li class="nav-item dropdown user-profile">
                <a href="javascript:void(0)" class="nav-link dropdown-toggle " id="navbarDropdown4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img src="{{URL('/assets/painel')}}/img/avtar/10.png">
                  <span class="bg-success user-status"></span>
                </a>
                <div class="dropdown-menu animated fadeIn" aria-labelledby="navbarDropdown">
                  <div class="bg-AccountDropDown px-4 py-3">
                    <div class="d-flex align-items-center justify-content-between">
                      <div class="mr-1">
                        <h4 class="text-white mb-0">{{Auth::user()->name}}</h4>
                        <small class="text-white">{{Auth::user()->email}}</small>
                      </div>
                    </div>

                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-white font-20 tooltip-wrapper" data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout">
                      <i class="zmdi zmdi-power"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>
                  </div>
                  <div class="p-4">

                    <a class="dropdown-item d-flex nav-link" href="/painel/profile">
                      <i class="fa fa-user pr-2 text-success"></i>
                      Perfil
                    </a>

                    @if(session('recipe_beetads_day'))

                      <a href="#" class="d-flex nav-link">
                        <span class="label label-primary" style="width: 100%;height: 35px;display:flex;justify-content:flex-start;align-items:center;padding-left:15px;margin-bottom:-20px;">
                          <span style="font-size: 1.1em;"><i class="fas fa-hand-holding-usd"></i> {{number_format(session('recipe_beetads_day'),2,',','.')}}</span>
                        </span>
                      </a>
                    @endif

                    @if(session('recipe_beetads_month'))

                      <a href="#" class="d-flex nav-link">
                        <span class="label label-success" style="width: 100%;height: 35px;display:flex;justify-content:flex-start;align-items:center;padding-left:15px;">
                          <span style="font-size: 1.1em;"><i class="fas fa-hand-holding-usd"></i> {{number_format(session('recipe_beetads_month'),2,',','.')}}</span>
                        </span>
                      </a>

                    @endif

                    <a class="dropdown-item d-flex nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="tooltip" data-placement="left" title="" data-original-title="Logout">
                      <i class="fas fa-sign-out-alt"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                    </form>

                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </header>

    <div class="app-container">

      <aside class="app-navbar">
        @include('painel.includes.menu')
      </aside>

      <div class="row" id="main">

        @include('painel.includes.asideMenu')

        <div class="col-12 col-md-11 col-lg-11">

          <?php $AlertDefault = $Alert::where('id_user', NULL)->where('status', 1)->first(); ?>
          @if(isset($AlertDefault->id_alert))
          <div class="row">
            <div class="col-12 mb-2">
              <div class="alert alert-primary" role="alert">
                <b>{{$AlertDefault->title}}</b>
                <br>
                {{$AlertDefault->text}}
              </div>
            </div>
          </div>
          @endif

          @if(!empty(session('request_profile_bank')))
          <div class="row">
            <div class="col-12 mb-2">
              <div class="alert alert-primary" role="alert">
                <b>Cadastrar dados bancários.</b>
                <br>
                {{session('request_profile_bank')}}
                <?php session(['request_profile_bank' => NULL]); ?>
              </div>
            </div>
          </div>

          @endif

          <?php $AlertUser = $Alert::where('id_user', Auth::user()->id)->where('status', 1)->first(); ?>
          @if(isset($AlertUser->id_alert))
          <div class="row">
            <div class="col-12 mb-2">
              <div class="alert alert-primary" role="alert">
                <b>{{$AlertUser->title}}</b>
                <br>
                {{$AlertUser->text}}
              </div>
            </div>
          </div>
          @endif

          @yield('content')
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="row">
        <div class="col-12 col-sm-12 text-center text-sm-left">
          <p>&copy; Copyright {{date('Y')}}. Todos os direitos reservados.</p>
        </div>
      </div>
    </footer>
  </div>
</div>

<div class="base-loading">
  <div class="loading-area">
    <img src="{{ asset('assets/unnamed.gif') }}" alt="">
    <div id="platFormMessageTheme">Estamos mudando seu tema...</div>
  </div>
</div>

<script src="{{URL('/assets/painel')}}/js/vendors.js"></script>
<script src="{{URL('/assets/painel')}}/js/app.js"></script>
<script src="{{URL('/assets/painel')}}/js/signature_pad.umd.js"></script>
<!-- <script src="{{URL('/assets/painel')}}/bootstrap-sweetalert/sweet-alert.min.js"></script> -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-3d.js"></script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

@yield('sripts')

<script>
function deletar(id) {
  Swal.fire({
    title: "Você tem certeza?",
    type: "warning",
    text: 'Quer realmente Apagar essa informação?',
    showCancelButton: true,
    confirmButtonClass: 'btn-danger',
    confirmButtonText: 'Sim!',
    closeOnConfirm: false,
    //closeOnCancel: false
  }).then((result) => {
  if (result.value) {
    Swal.fire(
      'Deletado!',
      '"A informação foi apagada!',
      'success'
    );
    setTimeout(function () {
          $("#deletar-" + id).submit();
    }, 1000);
  }
});

};
</script>
@yield('scripts')

@if(count($errors) > 0)
<?php $erros = ''; ?>
@foreach($errors->all() as $error)
<?php $erros .= $error; ?>
@endforeach
<script>
window.onload = function () {
  Swal.fire({
    title: "Erros Encontrados",
    type: "error",
    text: "{!! $erros !!}",
    confirmButtonClass: 'btn-danger',
    //closeOnCancel: false
  });
}
</script>
@endif

@if(session('CadastradoSucesso'))
<script>
window.onload = function () {
  Swal.fire({
    title: "Parabéns !!!",
    type: "success",
    text: "Cadastro Realizado com sucesso!",
    confirmButtonClass: 'btn-success',
    //closeOnCancel: false
  });
}
</script>
<?php Session::forget('CadastradoSucesso'); ?>
@endif

@if(session('Notificacao'))
<script>
window.onload = function () {
  Swal.fire({
    title: "Parabéns !!!",
    type: "success",
    text: "{{session('Notificacao')}}",
    confirmButtonClass: 'btn-success',
    //closeOnCancel: false
  });
}
</script>
<?php Session::forget('Notificacao'); ?>
@endif

@if(session('Information'))
<script>
window.onload = function () {
  Swal.fire({
    title: "Atenção !!!",
    type: "info",
    text: "{{session('Information')}}",
    confirmButtonClass: 'btn-info',
    //closeOnCancel: false
    html: true
  });
}
</script>
<?php Session::forget('Information'); ?>
@endif
</body>

</html>
