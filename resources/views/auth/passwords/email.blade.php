@inject('Settings', 'App\Models\Painel\Settings')
@extends('auth.layouts.app')
@section('content')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<div class="app-auth" id="authLogin">

    <div class="mdl-grid">

        <div class="mdl-cell mdl-cell--4-col blue boxLoginPro">

            <form method="POST" action="{{ route('password.email') }}">
               @csrf
               
               <img src="{{ asset('assets/site/brand1.png') }}" class="newLogoLoginBox">
               <h1 style="margin-bottom: 5px;">Resetar sua senha <strong>MonetizerAds</strong></h1>
               <p style="margin-bottom: 30px;">Digite por favor o e-mail para a recuperação da senha.</p>

               <div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" autofocus type="email" id="emailuser" name="email" value="{{ old('email') }}">
                  <label class="mdl-textfield__label" for="emailuser"><i class="far fa-envelope"></i> E-mail</label>
               </div>

               <button class="btnSignUp" type="submit"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; RECUPERAR SENHA</button>

               <div class="allright">
                  <p>&copy; All Rights Reserved. MonetizerAds.</p>
               </div>

            </form>

        </div>

        <div class="mdl-cell mdl-cell--8-col signUpEmpty">

            <div>

                <img src="{{ asset('assets/site/logoMonetizerAds-dark.png') }}" id="logomarcax">
                <h2 id="textSignUpEmpty">Crie sua conta para obter acesso aos recursos da <strong>MonetizerAds</strong></h2>

                <a href="{{ route('login') }}" class="btnSignUp" style="margin-top: 20px;width: 300px;float:left;"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; FAZER LOGIN</a>


            </div>

        </div>
    </div>
   
</div>
@endsection