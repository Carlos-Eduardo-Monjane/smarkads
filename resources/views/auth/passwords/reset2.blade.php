@inject('Settings', 'App\Models\Painel\Settings')
@extends('auth.layouts.app')
@section('content')
<div class="app">
   <div class="app-wrap">
      <div class="loader">
         <div class="h-100 d-flex justify-content-center">
            <div class="align-self-center">
               <img src="{{URL('/assets/painel')}}/img/loader/loader.svg" alt="loader">
            </div>
         </div>
      </div>

      <div class="app-contant">
         <div class="bg-white">
            <div class="container-fluid p-0">
               <div class="row no-gutters" style="background-color: #843e90;">
                  <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                     <div class="d-flex align-items-center h-100-vh">
                        <div class="login p-50">
                           <h1 class="mb-2">Resetar Senha</h1>
                           <form method="POST" action="{{ route('password.update') }}">
                               @csrf
                               <input type="hidden" name="token" value="{{ $token }}">
                              <div class="row">
                                <div class="col-12">
                                   <div class="form-group">
                                      <label class="control-label">E-mail*</label>
                                      <input type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" />
                                   </div>
                                </div>

                                <div class="col-12">
                                   <div class="form-group">
                                      <label class="control-label">Senha*</label>
                                      <input type="password" class="form-control" name="password" placeholder="Senha" />
                                   </div>
                                </div>

                                <div class="col-12">
                                   <div class="form-group">
                                      <label class="control-label">Repetir Senha*</label>
                                      <input type="password" class="form-control" name="password_confirmation" placeholder="Repetir Senha" />
                                   </div>
                                </div>
                                 <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary text-uppercase">Resetar Senha</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div class="col-sm-6 col-xxl-9 col-lg-7 bg-gradient o-hidden order-1 order-sm-2">
                     <div class="row align-items-center h-100">
                        <div class="col-12 mx-auto" style="text-align: right;">
                           <img class="img-fluid" src="{{URL('/assets/painel/uploads/settings')}}/{{$Settings->first()->backgroud_login}}">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
