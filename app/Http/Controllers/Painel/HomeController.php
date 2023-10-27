<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Painel\StandardController;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Defender;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Painel\User as Profile;
use App\Models\Painel\Modal;
use App\Models\Painel\AdmanagerReport;
use App\Models\Painel\RoleUser;
use App\Models\Painel\DomainEarningsInvalid;
use DB;
use Mail;

class HomeController extends StandardController {

  protected $nameView = 'home';
  protected $titulo = 'Home';
  protected $diretorioPrincipal = 'painel';
  protected $Rota = 'motor-pesquisa-hu';
  protected $primaryKey = 'home';

  public function __construct(Request $request, Defender $model, Factory $validator) {
    $this->request = $request;
    $this->model = $model;
    $this->validator = $validator;
  }

  public function getIndex(){

    $modal = Modal::leftJoin('modal_user as mu', function($join)
    {
      $join->on('mu.id_modal', '=', 'modal.id_modal');
      $join->on('mu.id_user','=',DB::raw(Auth::user()->id));
    })
    ->where('status', 1)
    ->whereNull('id_modal_user')
    ->selectRaw('modal.id_modal, image, id_modal_user')
    ->first();

    $Role = RoleUser::where('user_id', Auth::user()->id)->first();
    $idRole = $Role->role_id;

    if(Auth::user()->send_mail == 0){
      $this->BoasVindas();
    }

    $startDate = date('Y-m-01',strtotime(date('Y-m-d')."- 1 months"));
    $endDate = date('Y-m-d');

    if(Auth::user()->status_full_access == 1){
      $data = AdmanagerReport::selectRAW('admanager_report.date, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, SUM(earnings) earnings_total, AVG(active_view_viewable) active_view_viewable')
      ->whereBetween('date',[$startDate, $endDate])
      ->groupBy('admanager_report.date')
      ->orderBy('admanager_report.date')
      ->get();
      session(['recipe_beetads_day' => ($data->where('date', date('Y-m-d'))->SUM('earnings_total') - $data->where('date', date('Y-m-d'))->SUM('earnings'))]);
      session(['recipe_beetads_month' => ($data->where('date', '>=', date('Y-m-01'))->SUM('earnings_total') - $data->where('date', '>=', date('Y-m-01'))->SUM('earnings'))]);
    }else{
      $data = AdmanagerReport::join('domain','domain.name','admanager_report.site')
      ->selectRAW('admanager_report.date, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
      ->where('id_user', Auth::user()->id)
      ->whereBetween('date',[$startDate, $endDate])
      ->groupBy('admanager_report.date')
      ->orderBy('admanager_report.date')
      ->get();
    }

    $earningsInvalid = DomainEarningsInvalid::join('domain','domain.id_domain','domain_earnings_invalid.id_domain')
    ->join('users','users.id', 'domain.id_user')
    ->where('users.id', Auth::user()->id)
    ->where('year', date('Y', strtotime(date('Y-m-d')." -1 months")))
    ->where('month', date('m', strtotime(date('Y-m-d')." -1 months")))
    ->selectRAW('SUM(value) value')
    ->first();

    $today = $data->where('date', date('Y-m-d'))->first();
    $yesterday = $data->where('date', date('Y-m-d', strtotime(date('Y-m-d')." -1 day")))->first();
    $month = $data->whereBetween('date', [date('Y-m-01'), date('Y-m-t')])->SUM('earnings');
    $monthLast = $data->whereBetween('date', [date('Y-m-01', strtotime(date('Y-m-d')." -1 months")), date('Y-m-t', strtotime(date('Y-m-d')." -1 months"))])->SUM('earnings');

    return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('idRole','modal','data','today','yesterday','month','monthLast','earningsInvalid'));
  }

  public function BoasVindas(){
    Mail::send('emails.boas-vindas',[], function ($m){
      $m->from("contato@monetizerads.com", "Monetizer Ads");
      $m->to(Auth::user()->email)->subject(Auth::user()->name.', seja bem-vindo a Monetizer Ads');
    });
    Profile::find(Auth::user()->id)->update(['send_mail' => 1]);
  }

}
