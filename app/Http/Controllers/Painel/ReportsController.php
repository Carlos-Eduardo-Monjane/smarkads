<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Painel\StandardController;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Models\Painel\Domain;
use App\Models\Painel\AdmanagerReport;
use App\Models\Painel\AdmanagerReportUrlCriteria;
use Illuminate\Support\Facades\Auth;
use Defender;
use DB;

class ReportsController extends StandardController {

  protected $nameView = 'reports';
  protected $diretorioPrincipal = 'painel';
  protected $primaryKey = 'id_domain';

  public function __construct(Request $request, AdmanagerReport $model, Factory $validator) {
    $this->request = $request;
    $this->model = $model;
    $this->validator = $validator;
  }

  public function getMyEarnings(){
    if (Defender::hasPermission("{$this->nameView}/my-earnings")) {
      $domains = Domain::where('id_user', Auth::user()->id)->get();
      $principal = $this->diretorioPrincipal;

      $startDate = date('Y-m-d', strtotime(session('start_date')));
      $endDate = date('Y-m-d', strtotime(session('end_date')));

      $data = $this->model->join('domain','domain.name','admanager_report.site')
      ->selectRAW('admanager_report.date, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
      ->where('id_user', Auth::user()->id)
      ->whereBetween('date',[$startDate, $endDate])
      ->where('id_domain', session('id_domain_admanager_report'))
      ->groupBy('admanager_report.date')
      ->orderBy('admanager_report.date')
      ->get();

      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;
      return view("{$this->diretorioPrincipal}.{$this->nameView}.my-earnings", compact('principal','data','domains', 'rota', 'primaryKey'));
    }else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }


  public function getAdUnits(){
    if (Defender::hasPermission("{$this->nameView}/my-earnings")) {
      $domains = Domain::where('id_user', Auth::user()->id)->get();

      $startDate = date('Y-m-d', strtotime(session('start_date')));
      $endDate = date('Y-m-d', strtotime(session('end_date')));

      $data = $this->model->join('domain','domain.name','admanager_report.site')
      ->selectRAW('admanager_report.ad_unit, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
      ->where('id_user', Auth::user()->id)
      ->whereBetween('date',[$startDate, $endDate])
      ->where('id_domain', session('id_domain_admanager_report'))
      ->groupBy('admanager_report.ad_unit')
      ->orderBy('admanager_report.ad_unit')
      ->get();

      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;
      return view("{$this->diretorioPrincipal}.{$this->nameView}.ad-units", compact('principal','data','domains', 'rota', 'primaryKey'));
    }else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getDevice(){
   if (Defender::hasPermission("{$this->nameView}/device")) {

      $domains = Domain::where('id_user', Auth::user()->id)->get();

      $startDate = date('Y-m-d', strtotime(session('start_date')));
      $endDate = date('Y-m-d', strtotime(session('end_date')));

      $dataDesktop = $this->model->join('domain','domain.name','admanager_report.site')
      ->selectRAW('"Desktop" device, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
      ->where('id_user', Auth::user()->id)
      ->whereBetween('date',[$startDate, $endDate])
      ->where('id_domain', session('id_domain_admanager_report'))
      ->where('ad_unit', 'LIKE', '%_WEB_%');

      $dataMobile = $this->model->join('domain','domain.name','admanager_report.site')
      ->selectRAW('"Mobile" device, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
      ->where('id_user', Auth::user()->id)
      ->whereBetween('date',[$startDate, $endDate])
      ->where('id_domain', session('id_domain_admanager_report'))
      ->where('ad_unit', 'LIKE', '%_MOBILE_%')
      ->union($dataDesktop)
      ->get();
      $data = $dataMobile;

      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      return view("{$this->diretorioPrincipal}.{$this->nameView}.device", compact('principal','data','domains', 'rota', 'primaryKey'));
    }else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getUrlCriteria(){
    if (Defender::hasPermission("{$this->nameView}/url-criteria")) {
      $domains = Domain::where('id_user', Auth::user()->id)->get();

      $startDate = date('Y-m-d', strtotime(session('start_date')));
      $endDate = date('Y-m-d', strtotime(session('end_date')));

      $data = DB::select("SELECT a.url_id,
        a.url,
        (IFNULL(SUM(a.impressions), 0) + IFNULL(SUM(b.impressions), 0)) 'impressions',
        (IFNULL(SUM(a.clicks), 0) + IFNULL(SUM(b.clicks), 0)) 'clicks',
        SUM(a.ecpm) 'ecpmMobile',
        SUM(b.ecpm) 'ecpmDesktop',
        SUM(a.earnings) 'earningsMobile',
        SUM(b.earnings) 'earningsDesktop',
        (IFNULL(SUM(a.earnings), 0) + IFNULL(SUM(b.earnings), 0)) 'earnings'
        FROM (
          SELECT url_id,
          url,
          SUM(impressions) impressions,
          SUM(clicks) clicks,
          SUM(ecpm_client) ecpm,
          SUM(earnings_client) earnings
          FROM domain d
          INNER JOIN admanager_report_url_criteria adrc ON adrc.site = d.name
          WHERE d.id_user = ".Auth::user()->id."
          AND date BETWEEN '$startDate' AND '$endDate'
          AND d.id_domain = '".session('id_domain_admanager_report')."'
          AND earnings_client IS NOT NULL
          AND ad_unit LIKE '%MOBILE%'
          AND custon_key = 'id_post_wp'
          GROUP BY adrc.url_id, adrc.url) a
          LEFT JOIN (
            SELECT url_id,
            url,
            SUM(impressions) impressions,
            SUM(clicks) clicks,
            SUM(ecpm_client) ecpm,
            SUM(earnings_client) earnings
            FROM domain d
            INNER JOIN admanager_report_url_criteria adrc ON adrc.site = d.name
            WHERE d.id_user = ".Auth::user()->id."
            AND date BETWEEN '$startDate' AND '$endDate'
            AND d.id_domain = '".session('id_domain_admanager_report')."'
            AND earnings_client IS NOT NULL
            AND ad_unit LIKE '%WEB%'
            AND custon_key = 'id_post_wp'
            GROUP BY adrc.url_id, adrc.url) b
            ON b.url_id = a.url_id
            GROUP BY a.url_id, a.url");

            $principal = $this->diretorioPrincipal;
            $rota = $this->nameView;
            $primaryKey = $this->primaryKey;

            return view("{$this->diretorioPrincipal}.{$this->nameView}.url-criteria", compact('principal','data','domains', 'rota', 'primaryKey'));
          }else {
            return redirect("/{$this->diretorioPrincipal}");
          }
        }


        public function postFilter($page){
          if (Defender::hasPermission("{$this->nameView}/my-earnings")) {
            $dadosForm = $this->request->all();

            if(isset($dadosForm['filter'])){
              session(['filter' => $dadosForm['filter']]);
            }

            if(isset($dadosForm['id_domain_admanager_report'])){
              session(['id_domain_admanager_report' => $dadosForm['id_domain_admanager_report']]);
            }

            session(['start_date' => $dadosForm['start_date']]);
            session(['end_date' => $dadosForm['end_date']]);

            return redirect("{$this->diretorioPrincipal}/{$this->nameView}/$page");
          } else {
            return redirect("/{$this->diretorioPrincipal}");
          }
        }

        public function getAdManagerAnalytcs(){
          if (Defender::hasPermission("{$this->nameView}/ad-manager-analytcs")) {
            $startDate = date('Y-m-d', strtotime(session('start_date')));
            $endDate = date('Y-m-d', strtotime(session('end_date')));

            $data = $this->model->join('domain','domain.name','admanager_report.site')
            ->selectRAW('admanager_report.site, domain.id_domain, domain.status_checklist, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
            ->whereBetween('date',[$startDate, $endDate])
            ->groupBy('admanager_report.site')
            ->groupBy('domain.id_domain')
            ->groupBy('domain.status_checklist')
            ->get();

            $principal = $this->diretorioPrincipal;
            $rota = $this->nameView;
            $primaryKey = $this->primaryKey;

            return view("{$this->diretorioPrincipal}.{$this->nameView}.ad-manager-analytcs", compact('principal','data', 'rota', 'primaryKey'));
          } else {
            return redirect("/{$this->diretorioPrincipal}");
          }
        }

        public function getAlert(){
          if (Defender::hasPermission("{$this->nameView}/ad-manager-analytcs")) {
            $startDate = date('Y-m-d', strtotime(session('start_date')));
            $endDate = date('Y-m-d', strtotime(session('end_date')));

            $data = $this->model->join('domain','domain.name','admanager_report.site')
            ->selectRAW('admanager_report.site, domain.id_domain, domain.status_checklist, SUM(impressions) impressions, SUM(clicks) clicks, AVG(ctr) ctr, AVG(ecpm_client) ecpm, SUM(earnings_client) earnings, AVG(active_view_viewable) active_view_viewable')
            ->whereBetween('date',[$startDate, $endDate])
            ->groupBy('admanager_report.site')
            ->groupBy('domain.id_domain')
            ->groupBy('domain.status_checklist')
            ->get();

            $principal = $this->diretorioPrincipal;
            $rota = $this->nameView;
            $primaryKey = $this->primaryKey;

            return view("{$this->diretorioPrincipal}.{$this->nameView}.alert", compact('principal','data', 'rota', 'primaryKey'));
          } else {
            return redirect("/{$this->diretorioPrincipal}");
          }
        }
      }
