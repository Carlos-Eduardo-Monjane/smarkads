<?php

namespace App\Http\Controllers\Painel;
use App;
use App\Http\Controllers\Painel\StandardController;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Models\Painel\FinMovimentation;
use App\Models\Painel\FinBank;
use App\Models\Painel\FinCategory;
use App\Models\Painel\FinForm;
use App\Models\Painel\FinCurrency;
use App\Models\Painel\FinMovimentationXAdmanagerReport;
use App\Models\Painel\User;
use App\Models\Painel\AdmanagerReport;
use App\Models\Painel\FinMassPayment;
use App\Models\Painel\FinHusky;
use App\Models\Painel\Domain;
use App\Models\Painel\FinInvalid;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Defender;
use File;
use Mail;
use Helper;
use Illuminate\Support\Facades\DB;

class FinMovimentationController extends StandardController {

  protected $nameView = 'fin-movimentation';
  protected $diretorioPrincipal = 'painel';
  protected $primaryKey = 'id_fin_movimentation';

  public function __construct(Request $request, FinMovimentation $model, Factory $validator, FinMovimentationXAdmanagerReport $FMXAR, AdmanagerReport $AdmanagerReport, FinMassPayment $mp, FinHusky $husky) {
    $this->request = $request;
    $this->model = $model;
    $this->validator = $validator;
    $this->FMXAR = $FMXAR;
    $this->AR = $AdmanagerReport;
    $this->MP = $mp;
    $this->Husky = $husky;
    $this->totalItensPorPagina = 500;
  }

  public function getIndex($id_bank=null) {
    if (Defender::hasPermission("{$this->nameView}")) {


       if(isset($_GET['pagos'])){
        $status[] = 1;
        $status[] = 2;
      } else {
        $status[] = 1;;
      }

      if(isset($_GET['from'])){
        $data = $this->model
                      ->leftJoin('users as U','U.id','=','id_client')
                      ->orderBy('id_fin_movimentation','desc')
                      ->whereBetween('date_expiry', [Helper::formatData($_GET['from'],3), Helper::formatData($_GET['to'],3)], 'and')
                      ->whereIn('status',$status)
                      ->where('id_fin_bank',$id_bank)
                      ->get();
      } else {
        $data = $this->model
                      ->leftJoin('users as U','U.id','=','id_client')
                      ->orderBy('id_fin_movimentation','desc')
                      ->whereIn('status',$status)
                      ->where('id_fin_bank',$id_bank)
                      ->get();
      }
      

      $banks        = FinBank::pluck('name','id_fin_bank');
      $categories   = FinCategory::leftJoin('fin_category as F', 'F.id_fin_category','=','fin_category.fin_category_id')
                                  ->selectRaw('fin_category.*, F.name nameCategory')
                                  ->pluck('name','id_fin_category');
      $maes         = FinCategory::where('fin_category_id')->pluck('name','id_fin_category');
      $forms        = FinForm::pluck('name','id_fin_form');
      $clients      = User::pluck('name','id');
      $currencies   = FinCurrency::pluck('abbreviation','id_fin_currency');
      $mp = $this->MP->where('status','1')->limit(1)->orderBY('id_fin_mass_payment','desc')->first();

      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;
      return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('id_bank','data','banks', 'categories', 'forms', 'clients','principal', 'rota', 'currencies','primaryKey','mp'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getSubQuery($id){
    $informations = array();
      // echo $id.'<br />';
      $subitens = FinMovimentationXAdmanagerReport::where('id_fin_movimentation',$id)->pluck('id_admanager_report');
      
      if(!empty($subitens[0])) {
        
        foreach($subitens as $subiten){
          $ids[] = $subiten;
        }
        
        $ids = implode(',',$ids);
        
        $sql = "
          select
              P.id_user,
              C.company,
              C.name,
              TR.site,
              C.husky_token,
              GROUP_CONCAT(DISTINCT TR.id_admanager_report SEPARATOR ',') as ids,
              sum(TR.impressions) as impressoes,
              sum(TR.clicks) as cliques,
              sum(TR.earnings_client) as total ,
              max(TR.date) as date,
              PP.final_value
          from
              admanager_report TR
          LEFT JOIN
              domain as P ON P.name = site
          LEFT JOIN
              users as C ON P.id_user = C.id
          LEFT JOIN
              fin_pre_payment as PP ON PP.id_client = P.id_user 
          where
            id_admanager_report in ($ids)
          group by TR.site,P.id_user,C.name,C.husky_token,PP.final_value

      ";
      
        $info = DB::select($sql);
        return $info;
    } else {
      return false;
    }
  }
  
  public function getMyIndex() {
    // if (Defender::hasPermission("{$this->nameView}")) {
      $user = Auth::user();


      $data = $this->model
      ->leftJoin('users as U','U.id','=','id_client')
      ->orderBy('id_fin_movimentation','desc')
      ->where('id_client',$user->id)
      ->paginate(10000);  
      
      if(!empty($data)){

        foreach($data as $key => $info){
          $validation = $this->getSubQuery($info->id_fin_movimentation);
          if($validation){
            $informations[$key]['id_user'] = $info->id_client;
            $informations[$key]['id_fin_movimentation'] = $info->id_fin_movimentation;
            $informations[$key]['date_expiry'] = $info->date_expiry;
            $informations[$key]['value'] = $info->value;
            $informations[$key]['tax'] = $info->tax;
            $informations[$key]['status'] = $info->status;
            $informations[$key]['type'] = $info->type;
            $informations[$key]['file'] = $info->file;
            $informations[$key]['id_fin_currency'] = $info->id_fin_currency;
            $informations[$key]['report'] = $this->getSubQuery($info->id_fin_movimentation);
          }
        }

        if(isset($informations)){
          $data = $informations;
        }

        // dd($data);

        $banks        = FinBank::pluck('name','id_fin_bank');
        $categories   = FinCategory::leftJoin('fin_category as F', 'F.id_fin_category','=','fin_category.fin_category_id')
                                    ->selectRaw('fin_category.*, F.name nameCategory')
                                    ->pluck('name','id_fin_category');
        $maes         = FinCategory::where('fin_category_id')->pluck('name','id_fin_category');
        $forms        = FinForm::pluck('name','id_fin_form');
        $clients      = User::pluck('name','id');
        $currencies   = FinCurrency::pluck('abbreviation','id_fin_currency');
        $mp = $this->MP->where('status','1')->limit(1)->orderBY('id_fin_mass_payment','desc')->first();

        $principal = $this->diretorioPrincipal;
        $primaryKey = $this->primaryKey;
        $rota = $this->nameView;
        return view("{$this->diretorioPrincipal}.{$this->nameView}.my-index", compact('data','banks', 'categories', 'forms', 'clients','principal', 'rota', 'currencies','primaryKey','mp'));
      // } else {
      //   return redirect("/{$this->diretorioPrincipal}");
      // }
      }
  }

  public function getCreate($usertype=null) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $principal = $this->diretorioPrincipal;

      // Relacionamentos
      $banks        = FinBank::pluck('name','id_fin_bank');
      $categories   = FinCategory::leftJoin('fin_category as F', 'F.id_fin_category','=','fin_category.fin_category_id')
                                  ->selectRaw('fin_category.*, F.name nameCategory')
                                  ->pluck('name','id_fin_category');
      $maes         = FinCategory::where('fin_category_id')->pluck('name','id_fin_category');
      $forms        = FinForm::pluck('name','id_fin_form');
      $clients      = User::pluck('name','id');
      $currencies   = FinCurrency::pluck('name','id_fin_currency');


      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      $title = "Movimentações";

      if($usertype == 1){
        $title .= " | Despesas";
        $title_client = "Fornecedor";
        $status       = array(1=>'Em Aberto',2=>'Paga');
      } elseif($usertype == 2){
        $title .= " | Receitas";
        $title_client = "Parceiro";
        $status       = array(1=>'Em Aberto',2=>'Recebida');
      } elseif($usertype==4) {
        $title .= " | Impostos";
        $title_client = "Tipo de Imposto";
        $status       = array(1=>'Em Aberto',2=>'Pago');
      } else {
        $title .= " | Pró-labore";
        $title_client = "Colaborador";
        $status       = array(1=>'Em Aberto',2=>'Pago');
      }

      $anterior = $_SERVER['HTTP_REFERER'];

      return view("{$this->diretorioPrincipal}.{$this->nameView}.create-edit", compact('anterior','maes','usertype','title','title_client','principal', 'rota', 'primaryKey','banks','categories','forms','clients','currencies','status'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getShow($id) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $data = $this->model->findOrFail($id);
      $usertype = $data->type;
      $banks        = FinBank::pluck('name','id_fin_bank');
      $categories   = FinCategory::leftJoin('fin_category as F', 'F.id_fin_category','=','fin_category.fin_category_id')
                                  ->selectRaw('fin_category.*, F.name nameCategory')
                                  ->pluck('name','id_fin_category');
      $maes         = FinCategory::where('fin_category_id')->pluck('name','id_fin_category');
      $forms        = FinForm::pluck('name','id_fin_form');
      $clients      = User::pluck('name','id');
      $currencies   = FinCurrency::pluck('name','id_fin_currency');
      $title = "Movimentações ";
      
      if($usertype == 1){
        $title .= " | Despesas";
        $title_client = "Fornecedor";
        $status       = array(1=>'Em Aberto',2=>'Paga');
      } elseif($usertype == 2){
        $title .= " | Receitas";
        $title_client = "Parceiro";
        $status       = array(1=>'Em Aberto',2=>'Recebida');
      } elseif($usertype==4) {
        $title .= " | Impostos";
        $title_client = "Tipo de Imposto";
        $status       = array(1=>'Em Aberto',2=>'Pago');
      } else {
        $title .= " | Pró-labore";
        $title_client = "Colaborador";
        $status       = array(1=>'Em Aberto',2=>'Pago');
      }

      $data->date_expiry = $this->formatar_data($data->date_expiry,2);
      $data->date_payment = $this->formatar_data($data->date_payment,2);
      $data->value = number_format($data->value, 2, ',', '.');
      $data->tax = number_format($data->tax, 2, ',', '.');

      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;


      $anterior = $_SERVER['HTTP_REFERER'];

      return view("{$this->diretorioPrincipal}.{$this->nameView}.create-edit", compact('anterior','data','maes','usertype','title','title_client','principal', 'rota', 'primaryKey','banks','categories','forms','clients','currencies','status'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }
  
  public function getComprovante($id) {
    
      $data = $this->model
                   ->leftJoin('users as Client','Client.id','id_client')
                   ->leftJoin('fin_currency','fin_currency.id_fin_currency','fin_movimentation.id_fin_currency')
                   ->findOrFail($id);
      $usertype = $data->type;
      $banks        = FinBank::pluck('name','id_fin_bank');
      $categories   = FinCategory::leftJoin('fin_category as F', 'F.id_fin_category','=','fin_category.fin_category_id')
                                  ->selectRaw('fin_category.*, F.name nameCategory')
                                  ->pluck('name','id_fin_category');
      $maes         = FinCategory::where('fin_category_id')->pluck('name','id_fin_category');
      $forms        = FinForm::pluck('name','id_fin_form');
      $clients      = User::pluck('name','id');
      $currencies   = FinCurrency::pluck('name','id_fin_currency');
      $title = "Comprovante";
      
    
      $data->date_expiry = $this->formatar_data($data->date_expiry,2);
      $data->date_payment = $this->formatar_data($data->date_payment,2);
      $data->value = number_format($data->value, 2, ',', '.');
      $data->tax = number_format($data->tax, 2, ',', '.');

      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;
      //upload
      return view("{$this->diretorioPrincipal}.{$this->nameView}.comprovante", compact('data','maes','usertype','title','principal', 'rota', 'primaryKey','banks','categories','forms','clients','currencies'));
    
  }

  public function getCpdf($id){
    $data = $this->getComprovante($id);
    // echo $data;
    // die();
    //
    $pdf = App::make('dompdf.wrapper');
    $pdf->loadHTML($data);
    // $pdf->setOptions(['isHtml5ParserEnabled'=>true]);
    return $pdf->stream();
    die();
  }

  public function postStore() {
    if (Defender::hasPermission("{$this->nameView}")) {
      $user = Auth::user();
      $dadosForm = $this->request->all();
      unset($dadosForm['arquivo_envio']);
      $anterior = $dadosForm['anterior'];
      unset($dadosForm['anterior']);
      $dadosForm['date_expiry'] = $this->formatar_data($dadosForm['date_expiry'],1);
      $dadosForm['date_payment'] = $this->formatar_data($dadosForm['date_payment'],1);
      $dadosForm['value'] = $this->formatar_moeda($dadosForm['value']);
      $dadosForm['tax'] = $this->formatar_moeda($dadosForm['tax']);
      $dadosForm['id_client'] = $dadosForm['client_id'];
      $dadosForm['id_user'] = $user->id;

      $validator = $this->validator->make($dadosForm, $this->model->rules);
      if ($validator->fails()) {
        return redirect("/{$this->diretorioPrincipal}/{$this->nameView}/create")->withErrors($validator)->withInput();
      }
      $this->model->create($dadosForm);
      // return redirect("/{$this->diretorioPrincipal}/{$this->nameView}");
      return redirect($anterior);
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }
  public function postUpdate($id) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $user = Auth::user();
      $dadosForm = $this->request->all();
      unset($dadosForm['arquivo_envio']);
      $voltar = $dadosForm['anterior'];
      unset($dadosForm['anterior']);
      $dadosForm['date_expiry'] = $this->formatar_data($dadosForm['date_expiry'],1);
      $dadosForm['date_payment'] = $this->formatar_data($dadosForm['date_payment'],1);
      $dadosForm['value'] = $this->formatar_moeda($dadosForm['value']);
      $dadosForm['tax'] = $this->formatar_moeda($dadosForm['tax']);
      $dadosForm['id_client'] = $dadosForm['client_id'];
      $dadosForm['id_user'] = $user->id;
      $validator = $this->validator->make($dadosForm, $this->model->rules);
      if ($validator->fails()) {
        return redirect("/{$this->diretorioPrincipal}/{$this->nameView}/show/$id")->withErrors($validator)->withInput();
      }
      $this->model->findOrFail($id)->update($dadosForm);
      // return redirect("/{$this->diretorioPrincipal}/{$this->nameView}");
      return redirect($voltar);
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function cat(){
    $data = $_POST;
    unset($data['token']);
    if($data['fin_category_id'] == ''){
      unset($data['fin_category_id']);
    }
    $save = FinCategory::create($data);
    echo json_encode($save);
  }

  public function user(){
    $data = $_POST;
    unset($data['token']);
    if($data['email'] == ''){
      $data['email'] = $data['CPF_CNPJ'].'@beetads.com';
    }
    $data['password'] = "123mudar";
    $save = User::create($data);
    echo json_encode($save);
  }

  public function enviar($id=null){

    if($_FILES){
        $files = \Request::file('file');
        $file = $this->uploadFile2($files, $_FILES['file']['name'], 'painel', '/recibos/');
        if($file){
            $json = array(
                        'res'=>1,
                        'msg'=>$file,
                        'dir'=>$file
                    );
        } else {
            $json = array(
                        'res'=>2,
                        'msg'=>'erro ao enviar'
                    );
        }
        echo json_encode($json);
        exit();
    }
}

public function uploadFile2($file, $Nome, $raiz, $pasta) {

  if (Defender::hasPermission("{$this->nameView}")) {
    $urlAmigavel = $this->urlAmigavel($Nome . "-" . md5(Carbon::now() . $file->getClientOriginalName()));
    if ($file->isValid()) {
      if ($file->getClientOriginalExtension() == "pdf" || $file->getClientOriginalExtension() == "png" || $file->getClientOriginalExtension() == "jpg" || $file->getClientOriginalExtension() == "ico" || $file->getClientOriginalExtension() == "jpeg" || $file->getClientOriginalExtension() == "gif") {
        $nomeArquivo = $urlAmigavel;
        $extensao = $file->getClientOriginalExtension();
        $file->move('assets/' . $raiz . '/uploads/' . $pasta, $nomeArquivo . ".$extensao");
        return $nomeArquivo . ".$extensao";
      } else {
        $validator[] = "Permitido apenas imagem (png ou jpeg) ou pdf";
        return redirect("/{$this->diretorioPrincipal}/{$this->nameView}/create")->withErrors($validator)->withInput();
      }
    }
  } else {
    return redirect("/{$this->diretorioPrincipal}");
  }
}

public function formatar_data($data,$type){
  if($data != null){
      switch($type){
          case 1;
              $date = explode('/',$data);
              $newdate = $date[2].'-'.$date[1].'-'.$date[0];
          break;
          case 2;
              $date = explode('-',$data);
              $newdate = $date[2].'/'.$date[1].'/'.$date[0];
          break;
          case 3;
            $date = explode('-',$data);
            $newdate = $date[2].'-'.$date[1].'-'.$date[0];
          break;
      }
      return $newdate;
  }
}

public function formatar_moeda($data){
  if($data != null){
      $date = str_replace('.','',$data);
      $newdate = str_replace(',','.',$date);
      return $newdate;
  }
}


public function publisher_x_movimentation(){
  $dadosForm = $_POST;
  unset($dadosForm['_token']);
  unset($dadosForm['ids']);

  $dadosForm['date_expiry'] = date('Y-m-d');
  $dadosForm['currency'] = 1;
  $dadosForm['id_user'] = Auth::user()->id;
  $dadosForm['id_fin_bank'] = 2;
  $dadosForm['id_fin_category'] = 1;
  $dadosForm['id_fin_form'] = 3;
  $dadosForm['id_fin_currency'] = 1;
  $dadosForm['status'] = 1;
  $dadosForm['type'] = 1;

  $user = User::selectRaw('agency,agency_digit,account,digit,bank,email,name')
              ->find($dadosForm['id_client']);
  if(empty($user->account)){
    $conteudo = "{$user->name}, você deve cadastrar sua conta bancaria com urgência!";

    Mail::send('emails.notification',['observation'=>$conteudo], function ($m) use($user){
      $m->from("suporte@beetads.com", "BeetAds");
      $m->to($user->email)->subject($user->name.', precisamos de sua atenção!');
    });
  }
  
  $save = $this->model->create($dadosForm);

  $ids = explode(',',$_POST['ids']);
  foreach($ids as $key => $id){

    $inter[$key] = array(
      'id_fin_movimentation'=>$save->id_fin_movimentation,
      'id_admanager_report'=>$id
    );

    $this->AR->findOrFail($id)->update(array('status_payment'=>1));

  }

  $integration = $this->FMXAR->insert($inter);

  

  if($integration){
    return json_encode(array('status'=>200,'msg'=>'Cadastrado com sucesso'));
  } else {
    return json_encode(array('status'=>100,'msg'=>'Problemas ao cadastrar'));
  }

}

public function add_mp(){
  $data = $_POST;
  $array = array(
    'masspay_id'=>$data['id_husky'],
    'token'=>$data['token'],
    'final_value'=>$data['value'],
    'tracking_code'=>$data['id_fin_movimentation']
  );

  $retorno = $this->Husky->husky_mp_add($array,$data['currency']);

  if($retorno['meta']['code'] == 200){
    $this->model->findOrFail($data['id_fin_movimentation'])->update(array('status'=>2));
    return json_encode(array('msg'=>'Pagamento Efetuado com sucesso'));
  } else {
    return json_encode(array('msg'=>'Problemas ao efetuar o pagamento'));
  }

}

public function publisher(){
  $data=$_GET;
  if (Defender::hasPermission("fin-movimentation/publisher")) {
    $principal = $this->diretorioPrincipal;
    $primaryKey = $this->primaryKey;
    $rota = $this->nameView;

    if($data){
          $where = "TR.date >= '".$this->formatar_data($data['from'],3)."' AND TR.date <= '".$this->formatar_data($data['to'],3)."'";
          $pre = "PP.date >= '".$this->formatar_data($data['from'],3)."' AND PP.date <= '".$this->formatar_data($data['to'],3)."'";

          $where_back = "TR.date < '".$this->formatar_data($data['from'],3)."'";
          $pre_back = "PP.date < '".$this->formatar_data($data['from'],3)."'";
      

    $sql = "
        select
            P.id_user,
            C.company,
            C.name,
            TR.site,
            C.husky_token,
            GROUP_CONCAT(DISTINCT TR.id_admanager_report SEPARATOR ',') as ids,
            sum(TR.impressions) as impressoes,
            sum(TR.clicks) as cliques,
            sum(TR.earnings_client) as total ,
            max(TR.date) as date,
            MONTH(TR.date) as month,
            YEAR(TR.date) as year,
            PP.final_value
        from
            admanager_report TR
        LEFT JOIN
            domain as P ON P.name = site
        LEFT JOIN
            users as C ON P.id_user = C.id
        LEFT JOIN
            fin_pre_payment as PP ON PP.id_client = P.id_user AND $pre
        where
            $where
        AND
            status_payment = 0
        group by TR.site,year,month,P.id_user,C.name,C.husky_token,PP.final_value

    ";

    $sql_back = "
        select
            P.id_user,
            C.company,
            C.name,
            TR.site,
            C.husky_token,
            GROUP_CONCAT(DISTINCT TR.id_admanager_report SEPARATOR ',') as ids,
            sum(TR.impressions) as impressoes,
            sum(TR.clicks) as cliques,
            sum(TR.earnings_client) as total ,
            MONTH(TR.date) as date,
            YEAR(TR.date) as year,
            PP.final_value
        from
            admanager_report TR
        LEFT JOIN
            domain as P ON P.name = site
        LEFT JOIN
            users as C ON P.id_user = C.id
        LEFT JOIN
            fin_pre_payment as PP ON PP.id_client = P.id_user AND $pre_back
        where
            $where_back
        AND
            status_payment = 0
        group by TR.site,date,year,P.id_user,C.name,C.husky_token,PP.final_value

    ";
    $informations =  DB::select($sql);
    $informations_back =  DB::select($sql_back);

    $array = array();

    foreach($informations as $info){
      

      
      $invalid = FinInvalid::selectRaw('SUM(value) as total')
                          ->where('id_client',$info->id_user)
                          ->where('month',$info->month)
                          ->where('year',$info->year)
                          ->groupBy('id_client')
                          ->first();
      if(isset($invalid)){
        $valinvalid = $invalid->total;
      } else {
        $valinvalid = 0;
      }
      
      

      if($info->id_user){

        $array[$info->id_user]['id_user'] = $info->id_user;
        $array[$info->id_user]['company'] = $info->company;
        $array[$info->id_user]['name'] = $info->name;
        $array[$info->id_user]['month'] = $info->month;
        $array[$info->id_user]['year'] = $info->year;
        $array[$info->id_user]['invalid'] = $valinvalid;

        $array[$info->id_user]['report'][] = array(
          'ids'=>$info->ids,
          'id_domain'=>Domain::where('name',$info->site)->first()->id_domain,
          'domain'=>$info->site,
          'total'=>$info->total,
          'status'=>Domain::where('name',$info->site)->first()->id_domain_status,
        );


        if(empty($array[$info->id_user]['geral_ids'])){
          $array[$info->id_user]['geral_ids'] = $info->ids;
        } else {
          $array[$info->id_user]['geral_ids'] .= ','.$info->ids;
        }

        $id_domain_status = Domain::where('name',$info->site)->first()->id_domain_status;


          if(empty($array[$info->id_user]['total'])){
            $array[$info->id_user]['total'] = 0;
            $array[$info->id_user]['total'] += $info->total;
          } else {
            $array[$info->id_user]['total'] += $info->total;
          }

      }
    }
    foreach($informations_back as $info2){

      
      if($info2->id_user){

        $array2[$info2->id_user]['id_user'] = $info2->id_user;
        $array2[$info2->id_user]['company'] = $info2->company;
        $array2[$info2->id_user]['name'] = $info2->name;
        $array2[$info2->id_user]['month'] = $info2->date;
        $array2[$info2->id_user]['year'] = $info2->year;
        $array2[$info2->id_user]['report'][] = array(
          'ids'=>$info2->ids,
          'id_domain'=>Domain::where('name',$info2->site)->first()->id_domain,
          'domain'=>$info2->site,
          'total'=>$info2->total,
          'month'=>$info2->date,
          'year'=>$info2->year,
          'status'=>Domain::where('name',$info2->site)->first()->id_domain_status,
        );


        if(empty($array2[$info2->id_user]['geral_ids'])){
          $array2[$info2->id_user]['geral_ids'] = $info2->ids;
        } else {
          $array2[$info2->id_user]['geral_ids'] .= ','.$info2->ids;
        }

        $id_domain_status = Domain::where('name',$info2->site)->first()->id_domain_status;


          if(empty($array2[$info2->id_user]['total'])){
            $array2[$info2->id_user]['total'] = 0;
            $array2[$info2->id_user]['total'] += $info2->total;
          } else {
            $array2[$info2->id_user]['total'] += $info2->total;
          }

      }
    }

    if(!empty($a['total']) && !empty($b['total'])){
      usort($array, function($a,$b){
        return $a['total'] < $b['total'];
      });
    }

    if(!empty($c['total']) && !empty($d['total'])){
      usort($array2, function($c,$d){
        return $c['total'] < $d['total'];
      });
    }

    $informations = $array;

    
    if(empty($array2)){
      $array2 = [];
    }

    $informations_back = $array2;
    $aviso = null;
    } else {
      $aviso = "Selecione uma data";
      $informations = array();
      $informations_back = array();
    }

      return view("{$this->diretorioPrincipal}.{$this->nameView}.publisher", compact('aviso','informations','informations_back','principal', 'rota'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
}


  public function getMyOpened(){
        $principal = $this->diretorioPrincipal;
        $primaryKey = $this->primaryKey;
        $rota = $this->nameView;
        $adx = $this->getFinanAdx(Auth::user()->id);
      
        return view("{$this->diretorioPrincipal}.{$this->nameView}.my-opened", compact('principal','primaryKey','rota','adx'));    
  }

  public function getFinanAdx($id){
    $sql_back = "
        select
            P.id_user,
            C.company,
            C.name,
            TR.site,
            C.husky_token,
            GROUP_CONCAT(DISTINCT TR.id_admanager_report SEPARATOR ',') as ids,
            sum(TR.impressions) as impressoes,
            sum(TR.clicks) as cliques,
            sum(TR.earnings_client) as total ,
            MONTH(TR.date) as date,
            YEAR(TR.date) as year,
            PP.final_value
        from
            admanager_report TR
        LEFT JOIN
            domain as P ON P.name = site
        LEFT JOIN
            users as C ON P.id_user = C.id
        LEFT JOIN
            fin_pre_payment as PP ON PP.id_client = P.id_user
        WHERE
            P.id_user = $id
        AND
          status_payment = 0
        group by TR.site,date,year,P.id_user,C.name,C.husky_token,PP.final_value
        ORDER BY date

    ";
    
    $informations_back =  DB::select($sql_back);
    $semitotal = 0;
    foreach($informations_back as $info2){
      if($info2->id_user){

        $array2[$info2->id_user]['id_user'] = $info2->id_user;
        $array2[$info2->id_user]['company'] = $info2->company;
        $array2[$info2->id_user]['name'] = $info2->name;

        $mesano = $info2->date.'/'.$info2->year;

        $array2[$info2->id_user]['report']['dados'][$mesano]['data'][] = array(
          'ids'=>$info2->ids,
          'id_domain'=>Domain::where('name',$info2->site)->first()->id_domain,
          'domain'=>$info2->site,
          'total'=>$info2->total,
          'status'=>Domain::where('name',$info2->site)->first()->id_domain_status,
        );
        $array2[$info2->id_user]['report']['dados'][$mesano]['month'] = $info2->date;
        $array2[$info2->id_user]['report']['dados'][$mesano]['year'] = $info2->year;

        $invalid = FinInvalid::selectRaw('SUM(value) as total')
                          ->where('id_client',$info2->id_user)
                          ->where('month',$info2->date)
                          ->where('year',$info2->year)
                          ->groupBy('id_client')
                          ->first();
        
        if(isset($invalid)){
          $valinvalid = $invalid->total;
        } else {
          $valinvalid = 0;
        }

        $array2[$info2->id_user]['report']['dados'][$mesano]['invalid'] = $valinvalid;
        $array2[$info2->id_user]['report']['dados'][$mesano]['value'] = 0;
 

        if(empty($array2[$info2->id_user]['geral_ids'])){
          $array2[$info2->id_user]['geral_ids'] = $info2->ids;
        } else {
          $array2[$info2->id_user]['geral_ids'] .= ','.$info2->ids;
        }

        $id_domain_status = Domain::where('name',$info2->site)->first()->id_domain_status;


          if(empty($array2[$info2->id_user]['total'])){
            $array2[$info2->id_user]['total'] = 0;
            $array2[$info2->id_user]['total'] += $info2->total;
          } else {
            $array2[$info2->id_user]['total'] += $info2->total;
          }

      }
    }

    if(empty($array2)){
      $array2 = [];
    }

    $informations_back = $array2;


    if($informations_back){
      $adx_report = $informations_back[$id]['report']['dados'];
      foreach($adx_report as $key => $test){
      
        foreach($test as $t){
          if(is_array($t)){  
            foreach($t as $b){
              $adx_report[$key]['value'] += $b['total'];
            }
          }
        }
      }
    } else {
      $adx_report = null;
    }

    
    return $adx_report;


  }

  public function postDestroy($id) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $this->model->findOrFail($id)->delete();
      return redirect($_SERVER['HTTP_REFERER']);
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

}
