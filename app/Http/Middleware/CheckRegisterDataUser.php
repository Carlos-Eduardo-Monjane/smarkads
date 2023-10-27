<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Painel\User;
use App\Models\Painel\RoleUser;

class CheckRegisterDataUser {


  public function handle($request, $next) {
    $url = explode('/', $_SERVER['REQUEST_URI']);
    if(isset($url[2]) || $_SERVER['REQUEST_URI'] == '/'){
      if($url[2] != 'profile'){
        if(Auth::check()){
          $user = User::find(Auth::user()->id);
          $Role = RoleUser::where('user_id', Auth::user()->id)->first()->role_id;
          if($Role == 4){
            $required = ['type_account','CPF_CNPJ','bank','agency','agency_digit','account','digit','doc_id_doc_envio','doc_sign_envio','doc_back_id_doc_envio','doc_pic_envio','doc_proof_of_address_envio'];
            foreach($required as $field){
              if(empty($user->$field)){
                session(['request_profile_bank' => 'Precisamos que realize o cadastro dos dados bancários']);
                return redirect('/painel/profile');
              }
            }
          }
        }
      }
    }
    return $next($request);
  }

}
