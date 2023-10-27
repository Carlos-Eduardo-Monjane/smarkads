<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Models\Painel\Settings;
use Mail;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

  protected $nameView = 'layouts';
  protected $titulo = 'Home';
  protected $diretorioPrincipal = 'site';
  protected $Rota = 'motor-pesquisa-hu';
  protected $primaryKey = 'home';

  public function __construct(Request $request, Factory $validator) {
    $this->request = $request;
    $this->validator = $validator;
  }

  public function getIndex(){
    return redirect('painel');
  }


}
