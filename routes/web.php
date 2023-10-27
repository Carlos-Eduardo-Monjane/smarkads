<?php

header('Access-Control-Allow-Origin: *');

if (env('APP_ENV') == 'production'){
  URL::forceScheme('https');
}

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 0);

Route::get('emailtest', function () {
    return view('emails.alert');
});


// ///////////////////////////////////
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
// /////////////////////////////////

Route::post('/register-site', 'Painel\UsersController@RegisterSite');

Route::get('auth-user/{id}/{hash}', 'Painel\UsersController@AuthUser');

Route::group(['prefix' => '/advertiser123'], function () {

  Route::get('/teste/{id}', 'Advertiser\AdvertiserController@getTeste');

  Route::get('/reports/{token}', 'Advertiser\AdvertiserController@reports');
  Route::get('/start/{idAdvertiser}/{token}', 'Advertiser\AdvertiserController@startCampaing');
  Route::get('/pause/{idAdvertiser}/{token}', 'Advertiser\AdvertiserController@pauseCampaing');
  Route::get('/approve/{idAdvertiser}/{token}', 'Advertiser\AdvertiserController@approve');
  Route::get('/update/{idAdvertiser}/{token}', 'Advertiser\AdvertiserController@updateLineItem');
  Route::get('/token/{key}', 'Advertiser\AdvertiserController@getGenerateToken');
  Route::post('/{key}', 'Advertiser\AdvertiserController@postInfo');

  Route::get('/update-teste', 'Advertiser\AdvertiserController@updateLineItemTeste');

});


Route::group(['prefix' => '/run'], function () {
  AdvancedRoute::controller('admanager', 'Painel\AdManagerController');
  Route::get('domain/update-posts', 'Painel\DomainrController@UpdatePosts');

  Route::get('admanager/advertiser/report', 'Advertiser\AdvertiserController@ReportAdvertiser');
  AdvancedRoute::controller('plugin', 'Painel\PluginController');
});

Route::group(['prefix' => '/painel', 'middleware' => ['auth']], function () {

  AdvancedRoute::controller('roles', 'Painel\RolesController');
  AdvancedRoute::controller('permissions', 'Painel\PermissionsController');
  AdvancedRoute::controller('settings', 'Painel\SettingsController');
  AdvancedRoute::controller('users', 'Painel\UsersController');
  Route::post('users/husky_create','Painel\UsersController@husky_create');
  Route::post('users/husky_destination','Painel\UsersController@husky_destination');

  // PROFILE
  Route::post('profile/upload/{key}','Painel\ProfileController@upload');
  AdvancedRoute::controller('profile', 'Painel\ProfileController');

  AdvancedRoute::controller('modal', 'Painel\ModalController');
  AdvancedRoute::controller('pages', 'Painel\PagesController');
  AdvancedRoute::controller('ticket-status', 'Painel\TicketStatusController');
  AdvancedRoute::controller('domain-status', 'Painel\DomainStatusController');
  AdvancedRoute::controller('domain-category', 'Painel\DomainCategoryController');
  AdvancedRoute::controller('department', 'Painel\DepartmentController');
  AdvancedRoute::controller('domain', 'Painel\DomainController');
  AdvancedRoute::controller('priority', 'Painel\PriorityController');
  AdvancedRoute::controller('assignment', 'Painel\AssignmentController');
  AdvancedRoute::controller('ticket', 'Painel\TicketController');
  AdvancedRoute::controller('reports', 'Painel\ReportsController');
  AdvancedRoute::controller('alert', 'Painel\AlertController');
  AdvancedRoute::controller('domain-checklist', 'Painel\DomainChecklistController');
  AdvancedRoute::controller('ad-unit-format', 'Painel\AdUnitFormatController');
  AdvancedRoute::controller('ad-manager-ad-unit', 'Painel\AdManagerAdUnitController');
  AdvancedRoute::controller('plugin', 'Painel\PluginController');
  AdvancedRoute::controller('article', 'Painel\ArticleController');
  AdvancedRoute::controller('contract', 'Painel\ContractController');
  AdvancedRoute::controller('user-type', 'Painel\UserTypeController');
  AdvancedRoute::controller('assignment-status', 'Painel\AssignmentStatusController');
  AdvancedRoute::controller('advertiser', 'Advertiser\AdvertiserController');
  AdvancedRoute::controller('ads-txt-default', 'Painel\AdsTxtDefaultController');
  AdvancedRoute::controller('domain-notification', 'Painel\DomainNotificationController');
  AdvancedRoute::controller('emails-template', 'Painel\EmailsTemplateController');
  AdvancedRoute::controller('prospection', 'Painel\ProspectionController');
  AdvancedRoute::controller('message-default', 'Painel\MessageDefaultController');
  AdvancedRoute::controller('domain-earnings-invalid', 'Painel\DomainEarningsInvalidController');
  AdvancedRoute::controller('prebid-bids', 'Painel\PrebidBidsController');
  AdvancedRoute::controller('prebid-placement', 'Painel\PrebidPlacementController');
  AdvancedRoute::controller('prebid-version', 'Painel\PrebidVersionController');

  //  FINANCEIRO
  AdvancedRoute::controller('fin-currency', 'Painel\FinCurrencyController');
  AdvancedRoute::controller('fin-bank', 'Painel\FinBankController');
  AdvancedRoute::controller('fin-form', 'Painel\FinFormController');
  AdvancedRoute::controller('fin-category', 'Painel\FinCategoryController');
  AdvancedRoute::controller('fin-invalid', 'Painel\FinInvalidController');
  AdvancedRoute::controller('fin-purchases', 'Painel\FinPurchasesController');

  Route::get('fin-husky', 'Painel\FinHuskyController@getIndex');
  Route::get('fin-husky/view/{key}', 'Painel\FinHuskyController@getView');
  Route::get('fin-husky/create_mp', 'Painel\FinHuskyController@create_mp');
  Route::get('fin-husky/close_mp/{keya}/{keyb}', 'Painel\FinHuskyController@close_mp');

  Route::post('fin-movimentation/cat', 'Painel\FinMovimentationController@cat');
  Route::post('fin-movimentation/user', 'Painel\FinMovimentationController@user');
  Route::post('fin-movimentation/enviar', 'Painel\FinMovimentationController@enviar');

  // FINANCEIRO
  Route::post('fin-movimentation/publisher', 'Painel\FinMovimentationController@publisher');
  Route::get('fin-movimentation/publisher', 'Painel\FinMovimentationController@publisher');
  Route::post('fin-movimentation/publisher_x_movimentation', 'Painel\FinMovimentationController@publisher_x_movimentation');
  Route::post('fin-movimentation/add_mp', 'Painel\FinMovimentationController@add_mp');
  AdvancedRoute::controller('fin-movimentation', 'Painel\FinMovimentationController');
  AdvancedRoute::controller('/', 'Painel\HomeController');

});

AdvancedRoute::controller('/', 'Site\HomeController');

Auth::routes();
