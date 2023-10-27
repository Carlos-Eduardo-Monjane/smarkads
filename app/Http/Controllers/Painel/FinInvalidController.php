<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Painel\StandardController;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Illuminate\Support\Facades\Auth;
use App\Models\Painel\FinInvalid;
use App\Models\Painel\User;
use App\Helpers\Helper;
use Defender;

class FinInvalidController extends StandardController {

  protected $nameView = 'fin-invalid';
  protected $diretorioPrincipal = 'painel';
  protected $primaryKey = 'id_fin_invalid';

  public function __construct(Request $request, FinInvalid $model, Factory $validator, User $user) {
    $this->request = $request;
    $this->model = $model;
    $this->UserModel = $user;
    $this->validator = $validator;
  }


  public function getIndex(){
    $principal = $this->diretorioPrincipal;
    $primaryKey = $this->primaryKey;
    $rota = $this->nameView;
    $data = $this->model
                 ->selectRaw('id_fin_invalid, month, year, fin_invalid.id_client, fin_invalid.id_user, value, Client.name as cliente_nome, Client.company as cliente_company, User.name as usuario_nome, fin_invalid.created_at')
                 ->leftJoin('users as Client','Client.id','fin_invalid.id_client')
                 ->leftJoin('users as User','User.id','fin_invalid.id_user')
                 ->get();  
  
    return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('principal','primaryKey','rota','data'));    
}

  public function getCreate($id_client=null,$month=null,$year=null) {
    
      $principal = $this->diretorioPrincipal;

      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      $user_dado = $this->UserModel->where('id',$id_client)->first();
      $title = "Cadastro Inválidos";
      $urlPast = $_SERVER['HTTP_REFERER'];

      return view("{$this->diretorioPrincipal}.{$this->nameView}.create-edit", compact('principal','rota','primaryKey','title','user_dado','month','year','id_client','urlPast'));

  }

  public function postStore() {

      $user = Auth::user();
      $dadosForm = $this->request->all();
      $dadosForm['value'] = Helper::moedaSys($dadosForm['value']);
      $dadosForm['id_client'] = $dadosForm['id_client'];
      $dadosForm['id_user'] = $user->id;


      $urlPast = $dadosForm['urlPast'];
      unset($dadosForm['urlPast']);

      $validator = $this->validator->make($dadosForm, $this->model->rules);
      if ($validator->fails()) {
        return back()->withErrors($validator)->withInput();
      }
      
      $this->model->create($dadosForm);
      return redirect($urlPast);
   
  }

    public function postDestroy($id) {        
        $this->model->findOrFail($id)->delete();
        return redirect("/{$this->diretorioPrincipal}/{$this->nameView}");
     }

}
