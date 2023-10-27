<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <title>{{$Settings->first()->name_system}}</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="description" content="BeetAds Network." />
  <meta name="author" content="Potenza Global Solutions" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <!-- app favicon -->
  <link rel="shortcut icon" href="{{URL('/assets/painel/uploads/settings')}}/{{$Settings->first()->fiv_icon}}">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
  <!-- plugin stylesheets -->
  <!-- app style -->
  <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/css/loginScreen-light.css" />
  <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/css/loginScreenMobile.css" media="screen" />


  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <!-- <link rel="stylesheet" type="text/css" href="{{URL('/assets/painel')}}/bootstrap-sweetalert/sweet-alert.css" /> -->
  <meta name="googlebot" content="noindex">
  <meta name="robots" content="noindex">
</head>
<body>
    @yield('content')
</body>
</html>
