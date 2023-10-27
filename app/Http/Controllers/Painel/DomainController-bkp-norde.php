<?php

namespace App\Http\Controllers\Painel;

use App\Http\Controllers\Painel\StandardController;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use App\Models\Painel\Domain;
use App\Models\Painel\DomainStatus;
use App\Models\Painel\DomainCategory;
use App\Models\Painel\User;
use App\Models\Painel\AdUnitRoot;
use App\Models\Painel\DomainScripts;
use App\Models\Painel\AdUnit;
use App\Models\Painel\PrebidBids;
use App\Models\Painel\PrebidPlacement;
use App\Models\Painel\PrebidVersion;
use App\Models\Painel\AdUnitBid;
use Illuminate\Support\Facades\Auth;
use Defender;
use Storage;
use App\Helpers\HunterObfuscator\HunterObfuscator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DomainController extends StandardController {

  protected $nameView = 'domain';
  protected $diretorioPrincipal = 'painel';
  protected $primaryKey = 'id_domain';

  public function __construct(Request $request, Domain $model, Factory $validator) {
    $this->request = $request;
    $this->model = $model;
    $this->validator = $validator;
  }

  public function getIndex() {
    if (Defender::hasPermission("{$this->nameView}")) {
      $data = $this->model->join('users','users.id','domain.id_user')
      ->selectRaw('domain.*, users.name nameClient')
      ->where('id_domain_status', '!=', 1)
      ->paginate(2000);

      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;
      return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('data', 'principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getViewSite($id=null,$type=null){
      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;
      $data = $this->model
                  ->join('users','users.id','domain.id_user')
                  ->selectRaw('domain.*, users.name nameClient')
                  ->where('domain.id_domain',$id)
                  ->first();
      // dd($data);
      return view("{$this->diretorioPrincipal}.{$this->nameView}.view-site", compact('data', 'principal', 'rota', 'primaryKey'));
  }


  public function postSearch() {
    if (Defender::hasPermission("{$this->nameView}")) {
      $dadosForm = $this->request->all();
      session(['name_domain' => $dadosForm['name']."%"]);

      $data = $this->model->join('users','users.id','domain.id_user')
      ->selectRaw('domain.*, users.name nameClient')
      ->where('domain.name','LIKE',"%".session('name_domain')."%")
      ->paginate($this->totalItensPorPagina);

      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;

      return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('data', 'principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getSearch() {
    if (Defender::hasPermission("{$this->nameView}")) {

      $data = $this->model->join('users','users.id','domain.id_user')
      ->selectRaw('domain.*, users.name nameClient')
      ->where('domain.name','LIKE',"%".session('name_domain')."%")
      ->paginate($this->totalItensPorPagina);

      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;

      return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('data', 'principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getMyDomains() {
    if (Defender::hasPermission("domain/my-domains")) {
      $data = $this->model->where('id_user', Auth::user()->id)->paginate($this->totalItensPorPagina);
      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;
      return view("{$this->diretorioPrincipal}.{$this->nameView}.my-domains", compact('data', 'principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getAdUnitPositionsPublisher($idDomain){
    if (Defender::hasPermission("domain/my-domains")) {
      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      $data = AdUnitRoot::join('ad_unit','ad_unit.id_ad_unit_root','ad_unit_root.id_ad_unit_root')
      ->join('domain','domain.id_domain', 'ad_unit_root.id_domain')
      ->where('ad_unit_root.id_domain', $idDomain)
      ->where('domain.id_user', Auth::user()->id)
      ->whereNotNull('ad_unit.position')
      ->selectRaw('ad_unit.*, domain.file_do')
      ->get();

      $domain = $this->model->find($idDomain);

      $block = true;

      $function = '-publisher';

      return view("{$this->diretorioPrincipal}.{$this->nameView}.ad-unit-positions", compact('data','domain','block','function','principal','rota','primaryKey','idDomain'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function postAdUnitPositionsPublisher($idDomain){
    if (Defender::hasPermission("domain/my-domains")) {

      $domain = Domain::find($idDomain);
      if(isset($domain->id_domain)){
        $dadosForm = $this->request->only('update');
        foreach ($dadosForm['update'] as $key => $data) {
          AdUnit::find($key)->update($data);
        }
        return redirect("{$this->diretorioPrincipal}/{$this->nameView}/ad-unit-positions/{$idDomain}");
      }else{
        return redirect("/{$this->diretorioPrincipal}");
      }
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }


  public function getCreate() {
    if (Defender::hasPermission("{$this->nameView}")) {
      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      $domainStatuss= DomainStatus::get();
      $domainCategorys = DomainCategory::get();
      $users = User::get();

      $accountManager = User::join('role_user','role_user.user_id','users.id')
      ->where('role_user.role_id', 3)
      ->paginate(5);
      $prebidVersions = PrebidVersion::get();

      return view("{$this->diretorioPrincipal}.{$this->nameView}.create-edit", compact('principal','prebidVersions','accountManager', 'domainStatuss','domainCategorys','users', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getShow($id) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $data = $this->model->findOrFail($id);
      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      $domainStatuss= DomainStatus::get();
      $domainCategorys = DomainCategory::get();
      $prebidVersions = PrebidVersion::get();
      $users = User::get();
      $accountManager = User::join('role_user','role_user.user_id','users.id')
      ->where('role_user.role_id', 3)
      ->paginate(5);

      $domainStatusSelected = DomainStatus::find($data->id_domain_status);
      $domainCategorySelected = DomainCategory::find($data->id_domain_category);
      $userSelected = User::find($data->id_user);
      $accountManagerSelected = User::join('role_user','role_user.user_id','users.id')
      ->where('role_user.role_id', 3)
      ->where('users.id', $data->id_account_manager)
      ->first();

      $prebidVersionSelected = PrebidVersion::find($data->id_prebid_version);


      return view("{$this->diretorioPrincipal}.{$this->nameView}.create-edit", compact('data','prebidVersions','prebidVersionSelected','accountManager','accountManagerSelected', 'domainStatusSelected', 'domainCategorySelected', 'userSelected', 'domainStatuss','domainCategorys','users','principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getScripts($idDomain) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $dataDesktop = DomainScripts::where('id_domain', $idDomain)->where('device', 1)->first();
      $dataMobile =  DomainScripts::where('id_domain', $idDomain)->where('device', 2)->first();

      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      return view("{$this->diretorioPrincipal}.{$this->nameView}.scripts", compact('dataMobile','dataDesktop', 'idDomain','principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function postScripts($idDomain){
    if (Defender::hasPermission("{$this->nameView}")) {
      $dadosForm = $this->request->all();

      DomainScripts::where('id_domain', $idDomain)->where('device', 1)->update($dadosForm['devices']['desktop']);
      DomainScripts::where('id_domain', $idDomain)->where('device', 2)->update($dadosForm['devices']['mobile']);

      return redirect("{$this->diretorioPrincipal}/{$this->nameView}/scripts/{$idDomain}");
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getAdUnitPositions($idDomain){
    if (Defender::hasPermission("{$this->nameView}")) {
      $principal = $this->diretorioPrincipal;
      $rota = $this->nameView;
      $primaryKey = $this->primaryKey;

      $data = AdUnitRoot::join('ad_unit','ad_unit.id_ad_unit_root','ad_unit_root.id_ad_unit_root')
      ->where('ad_unit_root.id_domain', $idDomain)
      ->selectRaw('ad_unit.*')
      ->get();
      $function = '';

      $adUnitIds = [];
      foreach($data as $adUnit){
        $adUnitIds[] =  $adUnit->id_ad_unit;
      }

      $bids = PrebidBids::get();
      $bidsSelected = AdUnitBid::whereIn('id_ad_unit', $adUnitIds)->get();
      $domain = $this->model->find($idDomain);

      return view("{$this->diretorioPrincipal}.{$this->nameView}.ad-unit-positions", compact('data','bids','bidsSelected','domain','function','principal','rota','primaryKey','idDomain'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function postAdUnitPositions($idDomain){
    if (Defender::hasPermission("{$this->nameView}")) {
      $dadosForm = $this->request->only('update');
      //dd($dadosForm);
      foreach ($dadosForm['update'] as $key => $data) {

        AdUnitBid::where('id_ad_unit', $key)->delete();
        if(isset($data['bids'])){
          foreach($data['bids'] as $bid){
            $adUnitBid['id_ad_unit'] = $key;
            $adUnitBid['id_prebid_bids'] = $bid;
            AdUnitBid::create($adUnitBid);
            unset($adUnitBid);
          }
        }

        AdUnit::find($key)->update($data);
      }
      return redirect("{$this->diretorioPrincipal}/{$this->nameView}/ad-unit-positions/{$idDomain}");
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getChangeStatusChecklist($idDomain){
    $this->model->find($idDomain)->update(['status_checklist' => 1]);
    return 1;
  }

  public function getClient($idClient) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $data = $this->model->join('users','users.id','domain.id_user')
      ->where('domain.id_user',$idClient)
      ->selectRaw('domain.*, users.name nameClient')
      ->paginate($this->totalItensPorPagina);

      $principal = $this->diretorioPrincipal;
      $primaryKey = $this->primaryKey;
      $rota = $this->nameView;
      return view("{$this->diretorioPrincipal}.{$this->nameView}.index", compact('data', 'principal', 'rota', 'primaryKey'));
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getDownloadAdUnits($idDomain){
    $data = $this->model->join('ad_unit_root','ad_unit_root.id_domain','domain.id_domain')
    ->join('ad_unit','ad_unit.id_ad_unit_root','ad_unit_root.id_ad_unit_root')
    ->where('domain.id_domain', $idDomain)
    ->get();

    $maior = 0;
    $cont = 0;
    $File = '///////////////////HEADER////////////////////////////////
            <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
            <script>var googletag = window.googletag || {cmd: []};</script>';

    foreach($data as $dado){

      $uniq_id = uniqid();

      if($dado->position == 'fixedMobile' && $dado->device == 2){
        $bloco = '<link rel = "stylesheet" type = "text/css"href = "https://beetads.com/externo/css/beetadsstyle.css"/>
        <script src="https://beetads.com/externo/js/beetadsscript.js"></script>

        <div class="d-block md-hidden lg-hidden xl-hidden beetmobilefixed beetmobilefixedtobottom" id="beetmobilefixed">
        <div class="w-100 text-left" style="margin-left: 10px;">
        <span onclick="beet_admob_close(); beet_admob_class_remove();" style="font-size: 30px;">×</span>
        </div>

        <script>var googletag = window.googletag || {cmd: []};</script>
        <script async src="//www.googletagservices.com/tag/js/gpt.js"></script>
        <script>
        googletag.cmd.push(function() {
          var REFRESH_KEY = "refresh";
          var REFRESH_VALUE = "true";
          googletag.defineSlot("/22013536576/'.$dado->ad_unit_root_code.'/'.$dado->ad_unit_code.'",'.$dado->sizes.', "'.$uniq_id.'").
          setTargeting(REFRESH_KEY, REFRESH_VALUE).
          addService(googletag.pubads());
          var SECONDS_TO_WAIT_AFTER_VIEWABILITY = 60;

          googletag.pubads().addEventListener("impressionViewable", function(event) {
            var slot = event.slot;
            if (slot.getTargeting(REFRESH_KEY).indexOf(REFRESH_VALUE) > -1) {
              setTimeout(function() {
                googletag.pubads().refresh([slot]);
              }, SECONDS_TO_WAIT_AFTER_VIEWABILITY * 1000);
            }
          });
          googletag.enableServices();
        });
        </script>

        <div id="'.$uniq_id.'">
          <script>
            googletag.cmd.push(function() {googletag.display("'.$uniq_id.'");});
          </script>
        </div>
        </div>';
      }else{
        $bloco ='<script>
        googletag.cmd.push(function() {
          googletag.defineSlot("/22013536576/'.$dado->ad_unit_root_code.'/'.$dado->ad_unit_code.'",'.$dado->sizes.', "'.$uniq_id.'").
          addService(googletag.pubads());
          googletag.pubads().enableLazyLoad({
            fetchMarginPercent: 200,  // Fetch slots within 5 viewports.
            renderMarginPercent: 100,  // Render slots within 2 viewports.
            mobileScaling: 2.0  // Double the above values on mobile.
          });
          googletag.enableServices();
        });
        </script>
        <center>
        <div id="'.$uniq_id.'">
          <script>
            googletag.cmd.push(function() {googletag.display("'.$uniq_id.'");});
          </script>
        </div>
        </center>';
      }


      $File .= "\n\n///////////////////////////////////////////////////////////////\n\n".$bloco;
    }

    file_put_contents('assets/painel/uploads/adunits/adUnit.txt', $File);

    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename=adUnit.txt");
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile("assets/painel/uploads/adunits/adUnit.txt");
  }

  public function getMapTags($idDomain){
    if (Defender::hasPermission("{$this->nameView}")) {
      $data = $this->model->join('ad_unit_root','ad_unit_root.id_domain','domain.id_domain')
      ->join('ad_unit','ad_unit.id_ad_unit_root','ad_unit_root.id_ad_unit_root')
      ->where('domain.id_domain', $idDomain)
      ->get();

      $maior = 0;
      $cont = 0;
      $File = '';
      foreach($data as $dado){
        $sizes = explode('],[',$dado->sizes);
        foreach($sizes as $size){
          $numbers = str_replace(['[',']',' '],'',$size);
          $total = array_sum(explode(',', $numbers));
          if($cont == 0){
            $maior = $total;
            $sizeBig = $numbers;
            $cont++;
          }elseif($total > $maior){
            $maior = $total;
            $sizeBig = $numbers;
          }
        }
        $File .= $dado->ad_unit_name.";".str_replace([','],'x',$sizeBig)."\n";
      }
      file_put_contents('assets/painel/uploads/adunits/adUnit.txt', $File);
      header("Content-type: application/zip");
      header("Content-Disposition: attachment; filename=adUnit.csv");
      header("Pragma: no-cache");
      header("Expires: 0");
      readfile("assets/painel/uploads/adunits/adUnit.txt");
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function getTeste(){
    $domains = Domain::get();
    $devices = [1,2];
    foreach ($domains as $domain) {
      foreach ($devices as $device) {
        $dataForm['header'] = '<script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
                <script>var googletag = window.googletag || {cmd: []};</script>
                <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start": new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src="https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);})(window,document,"script","dataLayer","GTM-PRDTNQK")</script>
                <script> googletag.cmd.push(function(){ googletag.pubads().setTargeting("id_post_wp", "{id_post}"); }); </script>';
        $dataForm['footer'] = '';
        $dataForm['after_body'] = '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PRDTNQK" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
        $dataForm['device'] = $device;
        $dataForm['id_domain'] = $domain->id_domain;

        $saved = DomainScripts::where('device', $device)->where('id_domain', $domain->id_domain)->first();
        if(empty($saved->id_domain)){
          DomainScripts::create($dataForm);
        }
      }
    }
  }

  public function getChangeStatus($idDomain){
    if (Defender::hasPermission("{$this->nameView}")) {
      $domain = Domain::find($idDomain);
      if($domain->id_domain_status == 4){
        $domain->update(['id_domain_status' => 5]);
      }else{
        $domain->update(['id_domain_status' => 4]);
      }
      return 1;
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function UpdatePosts(){

    $domains = $this->model->get();

    foreach($domains as $domain){
      $sitemap_URL = "http://$domain->name/sitemap.xml";
      $result = json_decode(json_encode(@simplexml_load_file($sitemap_URL) ), TRUE);

      if(isset($result['sitemap'])){
        $items = $result['sitemap'];
      }else if(isset($result['url'])){
        $items = $result['url'];
      }else{
        $items = [];
      }

      $cont = 0;
      foreach($items as $item){
        if(isset($item['lastmod'])){
            if($cont == 0){
                $lastUpdate[$domain->id_domain] = date('Y-m-d', strtotime($item['lastmod']));
                $cont++;
            }
            if(date('Y-m-d', strtotime($item['lastmod'])) > date('Y-m-d', strtotime($lastUpdate[$domain->id_domain])) ){
              $lastUpdate[$domain->id_domain] = date('Y-m-d', strtotime($item['lastmod']));
            }
          }
          unset($items);
        }
    }

    foreach($lastUpdate as $key => $value){
      $this->model->find($key)->update(['posted_at' => $value]);
    }
  }

  public function getDigitalOcean($idDomain, $hash = "", $version = ""){
    if (Defender::hasPermission("{$this->nameView}")) {

      $adUnits = AdUnitRoot::join('ad_unit','ad_unit.id_ad_unit_root','ad_unit_root.id_ad_unit_root')
      ->where('ad_unit_root.id_domain', $idDomain)
      //->whereRaw('ad_unit_name LIKE "%_WEB_%"')
      ->whereNotNull('position')
      ->selectRaw('ad_unit.*, ad_unit_root.ad_unit_root_code')
      ->get();
      // foreach($adUnits as $adUnit){
      //   echo $adUnit->sizes."<br>";
      // }

      $positionsAllowCheck = ['Position_Content1','Position_Content2','Position_Content3','Position_Content4','Position_Content5'];
      $positionsAdUnitsDesktop = [];
      $positionsAdUnitsMobile = [];

      $bids = PrebidBids::where('enable',1)->get();
      $placement = PrebidPlacement::join('prebid_bids','prebid_bids.id_prebid_bids', 'prebid_placement.id_prebid_bids')->where('enable',1)->get();
      $content['desktop'] = '';
      $content['mobile'] = '';

      //DESKTOP
      foreach ($adUnits as $adUnit) {

        $bidsSelected = AdUnitBid::join('ad_unit', 'ad_unit.id_ad_unit', 'ad_unit_bid.id_ad_unit')
                        ->join('ad_unit_root','ad_unit_root.id_ad_unit_root','ad_unit.id_ad_unit_root')
                        ->where('ad_unit_root.id_domain',$idDomain)
                        ->where('ad_unit.id_ad_unit',$adUnit->id_ad_unit)
                        ->selectRAW('ad_unit_bid.id_prebid_bids')
                        ->groupBy('ad_unit_bid.id_prebid_bids')
                        ->get();
        $idBidsAdUnit = [];
        foreach($bidsSelected as $bid){
          $idBidsAdUnit[] = $bid->id_prebid_bids;
        }

        $placement = PrebidPlacement::join('prebid_bids','prebid_bids.id_prebid_bids', 'prebid_placement.id_prebid_bids')
        ->whereIn('prebid_bids.id_prebid_bids', $idBidsAdUnit)
        ->where('enable',1)
        ->get();
        unset($idBidsAdUnit);

        $array = explode('_', $adUnit->ad_unit_code);
        if(in_array('WEB', $array)){
          $tem = false;
          foreach($bids as $bid){
            foreach($placement as $key => $placem){
              if($placem->id_prebid_bids == $bid->id_prebid_bids && $placem->slot_sizes == str_replace(' ','',$adUnit->sizes)){
                $tem = true;
              }
            }
          }

          if($tem == true){

                  if(!empty($adUnit->id_div)){
                    $uniqId = $adUnit->id_div;
                    $return['divId'][] = $adUnit->id_div;
                  }else{
                    $uniqId = "Position_".explode('_', $adUnit->ad_unit_code)[3];
                    $return['divId'][] = "Position_".$uniqId;
                  }
                    if(in_array($uniqId, $positionsAllowCheck) && $adUnit->position_element != null){
                      if(!in_array($uniqId, $positionsAdUnitsDesktop)){
                        $positionsAdUnitsDesktop[] = "'".$adUnit->position_element."x".$uniqId."'";
                      }
                    }

                    if($adUnit->lazyload == 1){
                      $lazy_loading = 1;
                      $lazy_loading_offset = 200;
                    }else{
                      $lazy_loading = 0;
                      $lazy_loading_offset = 0;
                    }

                    $refreh = $adUnit->refresh;


                    $content['desktop'] .= '{
                                  "hbm_zone": {
                                  "userid": 381,
                                  "websiteid": 1093,
                                  "zoneid": '.$adUnit->ad_unit_id.',
                                  "lazy_loading": '.$lazy_loading.',
                                  "lazy_loading_offset": '.$lazy_loading_offset.',
                                  "refresh": '.$refreh.',
                                  "refresh_limit": 0,
                                  "nontracked": 0,
                                  "outofpage": 0,
                                  "slot_code": "/22013536576/'.$adUnit->ad_unit_root_code.'/'.$adUnit->ad_unit_code.'",
                                  "slot_sizes": '.$adUnit->sizes.'
                              },
                              "code": "'.$uniqId.'",
                              "mediaTypes": {
                                  "banner": {
                                      "sizes": '.$adUnit->sizes.'
                                  }
                              },
                              "bids": [';

                              foreach($bids as $bid){
                                $cont = 0;
                                foreach($placement as $key => $placem){
                                  if($placem->id_prebid_bids == $bid->id_prebid_bids && $placem->slot_sizes == str_replace(' ','',$adUnit->sizes) && $cont == 0){

                                     $deleteKey = $key;
                                     $params = '';

                                     if(isset($placem->zoneId)){ $params .= '"zoneId": '.$placem->zoneId.',';  }
                                     if(isset($placem->placement)){ $params .= '"placement": "'.$placem->placement.'",';  }
                                     if(isset($bid->network)){ $params .= '"network": "'.$bid->network.'"'.',';  }
                                     if(isset($bid->bid_floor)){ $params .= '"bidFloor": "'.$bid->bid_floor.'"'.',';  }
                                     if(isset($placem->publisherId)){ $params .= '"publisherId": "'.$placem->publisherId.'",';  }
                                     if(isset($placem->placementId)){ $params .= '"placementId": "'.$placem->placementId.'",';  }
                                     if(isset($bid->reserve)){ $params .= '"reserve": '.$bid->reserve.',';  }
                                     if(isset($placem->region)){ $params .= '"region": "'.$placem->region.'",';  }
                                     if(isset($placem->pageId)){ $params .= '"pageId": '.$placem->pageId.',';  }

                                      $content['desktop'] .= '
                                      {
                                          "bidder": "'.$bid->bidder.'",
                                          "params": {
                                              '.rtrim($params,',').'
                                          }
                                      },';

                                      unset($params);
                                      $tem = true;
                                       $cont++;
                                  }
                                }
                                if(isset($deleteKey)){
                                    $placement->forget($deleteKey);
                                    unset($deleteKey);
                                }
                              }
                              $content['desktop'] = rtrim($content['desktop'],',');

                              $content['desktop'] .= '
                              ]
                          },';
                          unset($p);
                          $tem = false;
                }
              }
            }

            //MOBILE

            $placement = PrebidPlacement::join('prebid_bids','prebid_bids.id_prebid_bids', 'prebid_placement.id_prebid_bids')->where('enable',1)->get();

            foreach ($adUnits as $adUnit) {

              $bidsSelected = AdUnitBid::join('ad_unit', 'ad_unit.id_ad_unit', 'ad_unit_bid.id_ad_unit')
                              ->join('ad_unit_root','ad_unit_root.id_ad_unit_root','ad_unit.id_ad_unit_root')
                              ->where('ad_unit_root.id_domain',$idDomain)
                              ->where('ad_unit.id_ad_unit',$adUnit->id_ad_unit)
                              ->selectRAW('ad_unit_bid.id_prebid_bids')
                              ->groupBy('ad_unit_bid.id_prebid_bids')
                              ->get();
              $idBidsAdUnit = [];
              foreach($bidsSelected as $bid){
                $idBidsAdUnit[] = $bid->id_prebid_bids;
              }

              $placement = PrebidPlacement::join('prebid_bids','prebid_bids.id_prebid_bids', 'prebid_placement.id_prebid_bids')
              ->whereIn('prebid_bids.id_prebid_bids', $idBidsAdUnit)
              ->where('enable',1)
              ->get();
              unset($idBidsAdUnit);

              $array = explode('_', $adUnit->ad_unit_code);
              if(in_array('MOBILE', $array)){
                $tem = false;
                foreach($bids as $bid){
                  foreach($placement as $key => $placem){
                    if($placem->id_prebid_bids == $bid->id_prebid_bids && $placem->slot_sizes == str_replace(' ','',$adUnit->sizes)){
                      $tem = true;
                    }
                  }
                }

                if($tem == true){
                        if(!empty($adUnit->id_div)){
                          $uniqId = $adUnit->id_div;
                          $return['divId'][] = $adUnit->id_div;
                        }else{
                          $uniqId = "Position_".explode('_', $adUnit->ad_unit_code)[3];
                          $return['divId'][] = "Position_".$uniqId;
                        }

                          if(in_array($uniqId, $positionsAllowCheck) && $adUnit->position_element != null){
                            if(!in_array($uniqId, $positionsAdUnitsMobile)){
                              $positionsAdUnitsMobile[] = "'".$adUnit->position_element."x".$uniqId."'";
                            }
                          }

                          $lazy_loading = 1;

                          $refreh = $adUnit->refresh;

                          if($adUnit->lazyload == 1){
                            $lazy_loading = 1;
                            $lazy_loading_offset = 200;
                          }else{
                            $lazy_loading = 0;
                            $lazy_loading_offset = 0;
                          }

                          $refreh = $adUnit->refresh;


                          $content['mobile'] .= '{
                                        "hbm_zone": {
                                        "userid": 381,
                                        "websiteid": 1093,
                                        "zoneid": '.$adUnit->ad_unit_id.',
                                        "lazy_loading": '.$lazy_loading.',
                                        "lazy_loading_offset": '.$lazy_loading_offset.',
                                        "refresh": '.$refreh.',
                                        "refresh_limit": 0,
                                        "nontracked": 0,
                                        "outofpage": 0,
                                        "slot_code": "/22013536576/'.$adUnit->ad_unit_root_code.'/'.$adUnit->ad_unit_code.'",
                                        "slot_sizes": '.$adUnit->sizes.'
                                    },
                                    "code": "'.$uniqId.'",
                                    "mediaTypes": {
                                        "banner": {
                                            "sizes": '.$adUnit->sizes.'
                                        }
                                    },
                                    "bids": [';

                                    foreach($bids as $bid){
                                      $cont = 0;
                                      foreach($placement as $key => $placem){
                                        if($placem->id_prebid_bids == $bid->id_prebid_bids && $placem->slot_sizes == str_replace(' ','',$adUnit->sizes) && $cont == 0){

                                           $deleteKey = $key;
                                           $params = '';

                                           if(isset($placem->zoneId)){ $params .= '"zoneId": '.$placem->zoneId.',';  }
                                           if(isset($placem->placement)){ $params .= '"placement": '.$placem->placement.',';  }
                                           if(isset($bid->network)){ $params .= '"network": "'.$bid->network.'"'.',';  }
                                           if(isset($bid->bid_floor)){ $params .= '"bidFloor": "'.$bid->bid_floor.'"'.',';  }
                                           if(isset($placem->publisherId)){ $params .= '"publisherId": "'.$placem->publisherId.'",';  }
                                           if(isset($placem->placementId)){ $params .= '"placementId": "'.$placem->placementId.'",';  }
                                           if(isset($bid->reserve)){ $params .= '"reserve": '.$bid->reserve.',';  }
                                           if(isset($placem->region)){ $params .= '"region": "'.$placem->region.'",';  }
                                           if(isset($placem->pageId)){ $params .= '"pageId": '.$placem->pageId.',';  }

                                            $content['mobile'] .= '
                                            {
                                                "bidder": "'.$bid->bidder.'",
                                                "params": {
                                                    '.rtrim($params,',').'
                                                }
                                            },';

                                            unset($params);
                                            $tem = true;
                                             $cont++;
                                        }
                                      }
                                      if(isset($deleteKey)){
                                          $placement->forget($deleteKey);
                                          unset($deleteKey);
                                      }
                                    }
                                    $content['mobile'] = rtrim($content['mobile'],',');

                                    $content['mobile'] .= '
                                    ]
                                },';
                                unset($p);
                                $tem = false;
                      }
                    }
                  }

      if($version == ""){
        $version = PrebidVersion::where('enabled', 1)->first()->version;
      }

      $content['desktop'] =  rtrim($content['desktop'],',');

      // if($idDomain == 271)
      // {
      //   $script = str_replace('{adUnitChangeDesktop}', $content['desktop'], file_get_contents(storage_path('/prebid/version-teste.js')));
      // }else{
        $script = str_replace('{adUnitChangeDesktop}', $content['desktop'], file_get_contents(storage_path('/prebid/version-'.$version.'.js')));
      // }


      $content['mobile'] =  rtrim($content['mobile'],',');
      $script = str_replace('{adUnitChangeMobile}', $content['mobile'], $script);

      $domain = $this->model->find($idDomain);


      //start Versão 1.3

      $recaptchaScript = "(function() {
        var styleRecaptcha = document.createElement('style');
        styleRecaptcha.type = 'text/css';
        styleRecaptcha.innerHTML = '.grecaptcha-badge { z-index: 9999 !important; bottom: 160px !important;}';
        document.getElementsByTagName('head')[0].appendChild(styleRecaptcha);

        var reCAPTCHAScript = document.createElement('script');
        reCAPTCHAScript.src = 'https://www.google.com/recaptcha/api.js?render={keyReCAPTCHA}';
        var target = document.getElementsByTagName('head')[0];
        target.insertBefore(reCAPTCHAScript, target.firstChild);
      })();";

      $recapchaExec = "  try{
          var reCAPTCHAStatus = 'inválido';
          setTimeout(function(){
            grecaptcha.ready(function() {
           		grecaptcha.execute('{keyReCAPTCHA}').then(function(token) {
                reCAPTCHAStatus = 'válido';
           		});
            });

            setTimeout(function(){
              googletag.cmd.push(function(){ googletag.pubads().setTargeting('reCAPTCHA', reCAPTCHAStatus); });
            }, 2000);
          }, 1000);


          if(document.querySelector('.status-publish').getAttribute('id')){
             googletag.cmd.push(function(){ googletag.pubads().setTargeting('id_post_wp', document.querySelector('.status-publish').getAttribute('id').split('-')[1]); });
          }
        } catch (e) {}";

      if(!empty($domain->key_recaptcha)){
        $script = str_replace('{recaptchaScript}', $recaptchaScript, $script);
        $script = str_replace('{recapchaExec}', $recapchaExec, $script);
        $script = str_replace('{keyReCAPTCHA}', $domain->key_recaptcha, $script);
      }
      // end Versão 1.3

      $script = str_replace('{positionsAdUnitsDesktop}', implode(',',$positionsAdUnitsDesktop), $script);
      $script = str_replace('{positionsAdUnitsMobile}', implode(',',$positionsAdUnitsMobile), $script);

      if($hash == ""){
        $hash = uniqid();
      }else{
        $hash = str_replace(['.js','p_'],'',$hash);
      }

      // if($idDomain == 271)
      // {
      //     $hunter = new HunterObfuscator($script);
      //     $script = $hunter->Obfuscate();
      // }

      file_put_contents("script_temp.js",$script);

      if($version == '1.2'){
        $script = $this->minify();
      }

    //   protected static $metaOptions = [
    //     'CacheControl',
    //     'Expires',
    //     'StorageClass',
    //     'ServerSideEncryption',
    //     'Metadata',
    //     'ACL',
    //     'ContentType',
    //     'ContentDisposition',
    //     'ContentLanguage',
    //     'ContentEncoding',
    // ];

      $url = Storage::disk('do_spaces')->put("/crm/".$idDomain."/p_$hash.js", $script, [
              'visibility' => 'public',
              'CacheControl' => 'max-age=60',
              'ContentType' => 'application/javascript',
              'ContentEncoding' => 'gzip'
        ]);

      $this->model->find($idDomain)->update(['file_do' => "p_$hash.js"]);

      $return['urlCDN'][] = '<script async type="text/javascript" src="https://beetadsscripts.nyc3.cdn.digitaloceanspaces.com/crm/'.$idDomain.'/p_'.$hash.'.js"> </script>';
      return json_encode($return);
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }
  //// var_dump(Storage::disk('do_spaces')->files("/"));
  public function getUpdateFilesDigitalOcean($idDomain = ""){

    if(empty($idDomain)){
      $domains = $this->model->whereNotNull('file_do')->get();
    }else{
      $domains = $this->model->where('id_domain', $idDomain)->whereNotNull('file_do')->get();
    }

    foreach ($domains as $domain) {
      $PrebidVersion = PrebidVersion::where('enabled', 1)->first();
      $this->getDigitalOcean($domain->id_domain, $domain->file_do, $PrebidVersion->version);
    }
  }


  public function postUpdate($id) {
    if (Defender::hasPermission("{$this->nameView}")) {
      $dadosForm = $this->request->all();
      $validator = $this->validator->make($dadosForm, $this->model->rulesUpdate);
      if ($validator->fails()) {
        return redirect("/{$this->diretorioPrincipal}/{$this->nameView}/show/$id")->withErrors($validator)->withInput();
      }
      $data = $this->model->find($id);

      if(!empty($dadosForm['id_prebid_version']) && !empty($data->id_prebid_version)){
        if($dadosForm['id_prebid_version'] != $data->id_prebid_version){
          $PrebidVersion = PrebidVersion::find($dadosForm['id_prebid_version']);
          $this->getDigitalOcean($data->id_domain, $data->file_do, $PrebidVersion->version);
        }
      }

      $data->update($dadosForm);
      return redirect("/{$this->diretorioPrincipal}/{$this->nameView}");
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }

  public function minify(){

    //$command = storage_path('minify-google/venv/bin/python2')."  -m jsmin ".public_path('script_temp.js'); //storage_path('/prebid/version-teste.js');
    $command = "python -m jsmin ".public_path('script_temp.js'); //storage_path('/prebid/version-teste.js');

    $process = new Process($command);
    $process->run();

    if (!$process->isSuccessful()) {
        throw new ProcessFailedException($process);
    }
    return $process->getOutput();
  }

  public function getPositionsPrebid($idDomain){
    $adUnits = AdUnitRoot::join('ad_unit','ad_unit.id_ad_unit_root','ad_unit_root.id_ad_unit_root')
    ->where('ad_unit_root.id_domain', $idDomain)
    // ->whereNotNull('position')
    // ->where('position','!=','')
    ->selectRaw('ad_unit.*, ad_unit_root.ad_unit_root_code')
    ->get();

    foreach($adUnits as $adUnit){
      $array = explode('_', $adUnit->ad_unit_code);

      if(in_array('Content1', $array)){
          AdUnit::find($adUnit->id_ad_unit)->update(['position' => 'first_paragraph']);
      }elseif(in_array('Content2', $array)){
          AdUnit::find($adUnit->id_ad_unit)->update(['position' => 'second_paragraph']);
      }elseif(in_array('Content3', $array)){
          AdUnit::find($adUnit->id_ad_unit)->update(['position' => 'third_paragraph']);
      }elseif(in_array('MOBILE', $array) && in_array('Fixed', $array) && in_array('Posts', $array)){
          AdUnit::find($adUnit->id_ad_unit)->update(['position' => 'fixedMobile']);
      }elseif(in_array('TopFixed', $array) && in_array('Posts', $array)){
          AdUnit::find($adUnit->id_ad_unit)->update(['position' => 'TopFixed']);
      }elseif(in_array('Sidebar', $array) && in_array('Posts', $array)){
          AdUnit::find($adUnit->id_ad_unit)->update(['position' => 'Sidebar']);
      }else{
        AdUnit::find($adUnit->id_ad_unit)->update(['position' => null]);
      }
    }
    return back();
  }

  public function getDisable($idDomain){
    if (Defender::hasPermission("{$this->nameView}")) {
      $domain = $this->model->find($idDomain);
      Storage::disk('do_spaces')->put("/crm/".$domain->id_domain."/$domain->file_do", "", 'public');
      return back();
    } else {
      return redirect("/{$this->diretorioPrincipal}");
    }
  }


}
