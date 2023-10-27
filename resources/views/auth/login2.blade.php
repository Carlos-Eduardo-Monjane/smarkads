@inject('Settings', 'App\Models\Painel\Settings')
@extends('auth.layouts.app')
@section('content')
<div class="app">
   <div class="app-wrap">

      {{-- <div class="loader">
         <div class="h-100 d-flex justify-content-center">
            <div class="align-self-center">
               <img src="{{URL('/assets/painel')}}/img/loader/loader.svg" alt="loader">
            </div>
         </div>
      </div> --}}

      <div class="app-contant">
         <div class="bg-white">
            <div class="container-fluid p-0">
               <!-- <div class="row no-gutters" style="background-color: #53565f;"> -->
               <div class="row no-gutters" style="background-color: #fff;">
                  <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                     <div class="d-flex align-items-center h-100-vh">
                        <div class="login p-50">
                           <center><img class="img-fluid" id="logomarcax" style="margin-left: -1700px !important;opacity:0.2 !important;" src="{{URL('/assets/painel/uploads/settings')}}/logoMonetizerAds.png" style="max-width: 100%;"></center>

                            <script>

                                $(document).ready(function(){
                                    $('#logomarcax').animate({
                                        marginLeft: '0px',
                                        opacity: 1
                                    });
                                }, 800);


                            </script>

                           {{-- <center><img class="img-fluid" src="{{URL('/assets/painel/uploads/settings')}}/{{$Settings->first()->logo_white}}" style="max-width: 100%;"></center> --}}
                           <p style="color: #000;"><br />Preencha seus dados </p>
                           <form method="POST" action="{{ route('login') }}">
                              @csrf
                              <div class="row">
                                 <div class="col-12">
                                    <div class="form-group">
                                       <label class="control-label" style="color: #000;">E-mail*</label>
                                       <input style="border-radius: 100px;" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" id="emailuser" />
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="form-group">
                                       <label class="control-label"  style="color: #000;">Senha*</label>
                                       <input type="password" style="border-radius: 100px;" name="password" id="passuser" class="form-control" placeholder="Senha" />
                                    </div>
                                 </div>
                                 <div class="col-12">
                                    <div class="d-block d-sm-flex  align-items-center">
                                       <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="gridCheck" value="password-saved">
                                          <label class="form-check-label" for="gridCheck" style="color: #000;">
                                             Lembrar login
                                          </label>

                                          <script type="text/javascript">
                                            $(document).ready(function(){

                                                $('#gridCheck').on('click', () => {

                                                    if($('#gridCheck').is(":checked") == true){
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

                                                if(localStorage.getItem('emailuser').length > 0 || localStorage.getItem('passuser').length > 0){
                                                    $('#gridCheck').attr('checked', 'true');
                                                }

                                                $('#emailuser').attr('value', localStorage.getItem('emailuser'));
                                                $('#passuser').attr('value', localStorage.getItem('passuser'));


                                            });
                                          </script>

                                       </div>
                                       <a href="{{ route('password.request') }}" class="ml-auto" style="color: #000;">Esqueceu a senha ?</a>
                                    </div>
                                 </div>
                                 <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-danger text-uppercase" style="border-radius: 100px;">Logar</button>
                                 </div>
                                 <div class="col-12  mt-3">
                                    <p style="color: #000;">Ainda não tem conta?<a href="/register"> Registrar</a></p>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-xxl-9 col-lg-7 o-hidden hidden-md-down order-1 order-sm-2">
                     <div class="row align-items-center h-100">
                        <div class="col-12 mx-auto" style="text-align: right; background-image: url('{{URL('/assets/painel/uploads/settings/mymonetize-e390011d10e8e930fcb98b534b263f17.jpg')}}'); background-size: cover; height: 100vh;background-position: left;">
                           &nbsp;
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
.xlogo{
      display:none;;
   }
@media(max-width:959px){
   .hidden-md-down{
         display:none;
   }
   .xlogo{
      display:block;
   }
}
</style>
@endsection
