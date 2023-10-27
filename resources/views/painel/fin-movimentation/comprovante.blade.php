<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo</title>
    <style>
        body{
            font-family:arial;
        }
        #cabeca > article{
            max-width:900px;
            width:100%;
            margin:0 auto;
            background:#8661f6;
            display:block;
        }
        #corpo > article{
            max-width:900px;
            width:100%;
            margin:0 auto;
            background-image: url(https://beetads.com/emails/02_banner.png);
            padding:20px;
            box-sizing:border-box;
            height:300px;
        } 
        #corpo > article > h2{
            margin:0 ;
            color:#FFF;
        } 
        #corpo > article > .data{
            background:#FFF;
            float:left;
            width:100%;
            min-height:200px;
            margin-top:10px;
            padding:20px;
            box-sizing:border-box;
        }
        #cabeca, #corpo{
            float:left;
            width:100%;
        }
    </style>
</head>
<body>
    
    <div id="cabeca">
        <article style="max-width:900px;width:100%;margin:0 auto;background:#8661f6;display:block;">
            <img src="https://beetads.com/emails/logo.png" alt="logo" width="123" height="37">
        </article>
    </div>
    <div id="corpo">
        <article>
        <img src="https://beetads.com/emails/logo.png" alt="logo" width="123" height="37">
            <h2 style="float:right">Comprovante de Pagamento</h2>
            <div class="data" style="margin-top:50px;">
                <p><strong>BEETS ADS NETWORK LLC</strong> informa: </p>
                <p>Efetuamos pagamento para <strong>{{$data->name}}  - CPF/CNPJ nº {{$data->CPF_CNPJ}}</strong>, a importância de {{$data->abbreviation}} {{$data->value}} referente à mídia digital, anuncios e publicidade vinculada.</p>
                <p>Código de pagamento #{{$data->id_fin_movimentation}} na data de {{$data->date_payment}}</p>
                <p>Parkland FL, <?php setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
echo strftime('%A, %d de %B de %Y', strtotime('today')); ?></p>
            </div>
            <br clear="all">
            <!--test-->
        </article>
    </div>
    
</body>
</html>