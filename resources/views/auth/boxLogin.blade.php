<form method="POST" action="{{ route('login') }}" id="windowSignIn" class="activeWindow">
    @csrf

<img src="{{ asset('assets/site/brand1.png') }}" class="newLogoLoginBox">
<h1>Faça login com sua conta da <strong>MonetizerAds</strong></h1>

<div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" autofocus type="email" id="emailuser" name="email" value="{{ old('email') }}">
    <label class="mdl-textfield__label" for="emailuser"><i class="far fa-envelope"></i> E-mail</label>
</div>

{{--  --}}

<div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password" name="password" id="passuser">
    <label class="mdl-textfield__label" for="passuser"><i class="far fa-keyboard"></i> Senha</label>
</div>

<style>

    .linkResetLogin{
        text-decoration: none;
        color: #222;
        float: right;
        padding-right: 20px;
    }
</style>

    <button type="button" id="showPassWd" class="btn-eye"><i id="passwdShowIcon" class="far fa-eye"></i> Mostrar senha</button>

    <a href="{{url('password/reset')}}" class="linkResetLogin">Recuperar senha</a>

<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="checkbox-1">
    <input type="checkbox" id="checkbox-1" class="mdl-checkbox__input" />
    <span class="mdl-checkbox__label">Lembrar - me</span>
</label>

<script>

    $(document).ready(function(){

        $('#showPassWd').on('click', () => {

            if($('#passuser').hasClass('activeShowPassword')){
                $('#passuser').attr('type', 'password').removeClass('activeShowPassword');
                $('#passwdShowIcon').removeClass('far fa-eye-slash').addClass('far fa-eye');
            }else{
                $('#passuser').attr('type', 'text').addClass('activeShowPassword');
                $('#passwdShowIcon').removeClass('far fa-eye').addClass('far fa-eye-slash');
            }
        });

        $('#checkbox-1').on('click', () => {

            if($('#checkbox-1').is(":checked") == true){
                var email = $('#emailuser').val();
                var pass  = $('#passuser').val();

                localStorage.setItem('emailuser', email);
                localStorage.setItem('passuser', pass);

                $('#emailuser').attr('value', email);
                $('#passuser').attr('value', pass);
            }else{
                localStorage.setItem('emailuser', '');
                localStorage.setItem('passuser', '');

                $('#emailuser').attr('value', '');
                $('#passuser').attr('value', '');
            }

        });

    });

    
</script>


<button class="btnSignUp" type="submit"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; ENTRAR</button>

<a class="btnSignUpMobile" style="margin-top: -20px;text-decoration: none;" href="{{ route('register') }}"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; CRIAR UMA CONTA</a>


</form>