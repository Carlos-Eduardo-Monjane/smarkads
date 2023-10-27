<?php

namespace App\Http\Middleware;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Painel\UserLog;

class DatabaseLogger {

  public function handle($request, $next) {
    DB::connection()->enableQueryLog();
    return $next($request);
  }

  public function terminate($request, $response) {
    $queries = DB::getQueryLog();
    $id = Auth::check()?Auth::id():null;

    if($id != null){
      collect($queries)->each(function ($query) use ($id) {
        $dadosForm['id_user'] = $id;
        $dadosForm['query'] = json_encode($query);
        $queryExplode = explode(" ",$query['query']);
        if(!in_array("select", $queryExplode)){
          UserLog::create($dadosForm);
        }
      });
    }
  }

}
