

<form method="POST" action="{{ route('register') }}" id="windowSignUp" class="{{ $active ?? '' }}">
    @csrf

    <div class="outBottomRegister"><a href="#outBottomRegister"><i class="fas fa-arrow-circle-down"></i></a></div>

    <img src="{{ asset('assets/site/brand1.png') }}" class="newLogoLoginBox">


<h1>Crie sua conta para obter acesso aos recursos da <strong>MonetizerAds</strong></h1>

<div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-grid--no-spacing">
    <input class="mdl-textfield__input" type="text" id="sample3" name="name" value="{{ old('name') }}">
    <label class="mdl-textfield__label" for="sample3"><i class="far fa-user"></i> Nome</label>
</div>

<div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="email" id="sample3" name="email" value="{{ old('email') }}">
    <label class="mdl-textfield__label" for="sample3"><i class="far fa-envelope"></i> E-mail</label>
</div>

<div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="text" id="sample3" name="whatsapp" value="{{ old('whatsapp') }}" >
    <label class="mdl-textfield__label" for="sample3"><i class="fab fa-whatsapp"></i> WhatsApp</label>
</div>

{{--  --}}

<div class="mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password" name="password" id="sample3">
    <label class="mdl-textfield__label" for="sample3"><i class="far fa-keyboard"></i> Senha</label>
</div>

<div class="mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <input class="mdl-textfield__input" type="password" id="sample3" name="password_confirmation">
    <label class="mdl-textfield__label" for="sample3"><i class="far fa-keyboard"></i> Repetir Senha</label>
</div>

<div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-grid--no-spacing">
    <input class="mdl-textfield__input" type="text" id="sample3" name="domains[1][name]">
    <label class="mdl-textfield__label" for="sample3"><i class="fas fa-sitemap"></i> Domínio</label>
</div>

{{--  --}}
<div class="mdl-grid mdl-grid--no-spacing">
<div class="mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
    <select  class="form-select" name="domains[1][id_domain_category]">
        <option value="" selected>---- Categoria ----</option>
        @foreach($DomainCategory->get() as $Category)
        <option value="{{$Category->id_domain_category}}"> {{$Category->name}} </option>
        @endforeach
    </select>
</div>

<div class="mdl-cell--6-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">

    <div class="mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-grid--no-spacing">
        <input class="mdl-textfield__input" name="domains[1][page_views]" type="text" id="sample3">
        <label class="mdl-textfield__label" for="sample3"><i class="fas fa-eye"></i> PageViews/Mês*</label>
    </div>
</div>
</div>

<!-- Colored mini FAB button -->
<button id="addRow" type="button" class="mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab mdl-button--colored">
    <i class="material-icons">add</i>
</button>

{{--  --}}


<button class="btnSignUp" type="submit"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; CRIAR UMA CONTA</button>

<a class="btnSignUpMobile" style="margin-top: -20px;text-decoration: none;" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i>   &nbsp;&nbsp; FAZER LOGIN</a>

<div id="outBottomRegister"></div>


</form>