<?php
class View{


  public function login(){
    $login = '<style>

      @keyframes blink {
        0% { box-shadow: 0 0 15px #843e90; }
        50% { box-shadow: none; }
        100% { box-shadow: 0 0 15px #843e90; }
      }

      @-webkit-keyframes blink {
        0% { box-shadow: 0 0 15px #843e90; }
        50% { box-shadow: 0 0 0; }
        100% { box-shadow: 0 0 15px #843e90; }
      }

      .blink {
        -webkit-animation: blink 2s linear infinite;
        -moz-animation: blink 2s linear infinite;
        -ms-animation: blink 2s linear infinite;
        -o-animation: blink 2s linear infinite;
        animation: blink 2s linear infinite;
      }


      table {
        border-collapse: collapse;
        width: 100%;
      }

      th, td {
        text-align: left;
        padding: 8px;
      }

      .outracor { background: #ddd; }

      </style>

      <div id="poststuff">
          <div id="post-body">

            <div class="" style=" /* background-color: #843e90; */ ">

                <center>
                  <div class="postbox blink" style="width:30%; margin-top: 20px;     margin-bottom: 30%;">
                      <h3 class="hndle"><label for="title">
                        <center style="margin-top: 20px">
                          <img src="'.plugins_url("beetAds/images/logo.png").'"/>
                        </center>
                      </h3>
                      <div class="inside">
                        <div class="wpcci_blue_box"></div>

                          <form action="" method="POST" id="loginForm">
                              <input type="text" name="email" id="email" dir="ltr" style="width:100%;"  placeholder="Email">
                              <input type="password" name="password" id="password" dir="ltr" style="width:100%; margin-top: 10px" placeholder="Senha">
                              <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                              <br />
                              <div id="error" style="color:red"></div>
                              <br/>
                              <button type="button" id="login" name="wpcci_save_settings" class="button-primary">Entrar</button>

                          </form>
                        </div>
                  </div>
                </center>
            </div>
          </div>
      </div>

    <script>
      jQuery(document).ready(function($) {
        $("#login").click(function(){
          var email = $("#email").val();
          var password = $("#password").val();
          $.get("https://painel.beetads.com/painel/admin/admanager/loginplugin/{hashProject}/"+email+"/"+password, function(data, status){
            if(data == 1){
              $("#loginForm").submit();
            }else{
              $("#error").html("Login ou senha estão incorretos.");
            }
          });
        });
      });
    </script>';

    echo $login;
  }

  public function Reports()
  {

    $options = '

    <style>

      @keyframes blink {
        0% { box-shadow: 0 0 15px #843e90; }
        50% { box-shadow: none; }
        100% { box-shadow: 0 0 15px #843e90; }
      }

      @-webkit-keyframes blink {
        0% { box-shadow: 0 0 15px #843e90; }
        50% { box-shadow: 0 0 0; }
        100% { box-shadow: 0 0 15px #843e90; }
      }

      .blink {
        -webkit-animation: blink 2s linear infinite;
        -moz-animation: blink 2s linear infinite;
        -ms-animation: blink 2s linear infinite;
        -o-animation: blink 2s linear infinite;
        animation: blink 2s linear infinite;
      }


    table {
      width: 100%;
      border: 1px solid;
      padding: 10px;
      box-shadow: 5px 10px 8px 10px #888888;
    }

    .borda{
      border: 1px solid;
      padding: 10px;
      box-shadow: 5px 5px 5px 0px #888888;
    }

    th, td {
      text-align: left;
      padding: 8px;
    }

    .outracor { background: #ddd; }



    </style>

    <div id="poststuff">
        <div id="post-body">
          <div class="" style=" /* background-color: #843e90; */ ">

              <center>
                <div class="postbox borda" style="width:30%; margin-top: 20px;">
                    <h3 class="hndle"><label for="title">Filtro(s)</label></h3>
                    <div class="inside">
                      <div class="wpcci_blue_box"></div>

                        <form action="" method="POST">
                        <select style="width:100%; margin-bottom: 10px;" id="filtro">
                          <option value="">Selecione</option>
                          <option value="1">Hoje</option>
                          <option value="2">Mês Atual</option>
                          <option value="3">Mês Anterior</option>
                          <option value="4">Data Customizada</option>
                        </select>

                        <div class="custon_date" style="display: none">
                            <input type="text" class="date" id="startDate" style="width:100%;" placeholder="De Data" value="">
                            <input type="text" class="date" id="endDate" style="width:100%; margin-top: 10px;" placeholder="Até Data" value="">
                        </div>

                        <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                        <br/>
                        <button type="button" id="getData" name="wpcci_save_settings" class="button-primary" />Filtrar</button>
                        </form>
                      </div>
                </div>
              </center>
          </div>
        </div>
    </div>


    <div id="reports" style="display:none">
        <div id="post-body">
          <div class="" style=" /* background-color: #843e90; */ ">
          <center>
            <div class="postbox borda" style="width:80%; margin-top: 20px; margin-bottom: 30%; padding: 10px 10px 10px 10px;">

            <div style="margin-top: 50px; margin-bottom: 50px; overflow-x:auto;">
              <h2>RELATÓRIO GERAL</h2>

              <table border="1">
                <tr>
                    <th >Impressões</th>
                    <th >Cliques</th>
                    <th >CTR%</th>
                    <th >Active View</th>
                    <th >eCPM (U$$)	</th>
                    <th >Receita (U$$)%</th>
                </tr>
                <tbody id="tableAll">

                </tbody>
              </table>
            </div>
            </hr>
            <div style="margin-top: 50px; margin-bottom: 50px; overflow-x:auto;">
               <h2>RELATÓRIO POR DATA</h2>

               <table border="1">
                 <tr>
                     <th>Data</th>
                     <th >Impressões</th>
                     <th >Cliques</th>
                     <th >CTR%</th>
                     <th >Active View</th>
                     <th >eCPM (U$$)	</th>
                     <th >Receita (U$$)%</th>
                 </tr>
                 <tbody id="tableData">

                 </tbody>
                </table>
            </div>

             <div style="margin-top: 50px;  margin-bottom: 50px; overflow-x:auto;">
                <h2>RELTÓRIO POR BLOCOS</h2>

                 <table border="1">
                   <tr>
                       <th >AdUnit</th>
                       <th >Impressões</th>
                       <th >Cliques</th>
                       <th >CTR%</td>
                       <th >Active View</th>
                       <th >eCPM (U$$)	</th>
                       <th >Receita (U$$)%</th>
                   </tr>
                   <tbody id="tableAdUnit">

                   </tbody>
                 </table>
              </div>

            </div>
          </center>
        </div>
      </div>
    </div>

    <script>
    jQuery(document).ready(function($) {

      $("#getData").click(function(){
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var endDate = $("#endDate").val();

        $.get("https://painel.beetads.com/painel/admin/admanager/datapublisher/{hashProject}/"+startDate+"/"+endDate, function(data, status){

          $("#reports").show();
          var obj = JSON.parse(data);

          var tableAll = "";
          obj.all.forEach(function(o, index){
            if(o.clicks > 0){
              tableAll += \'<tr> <td >\'+o.impressions+\'</td> <td >\'+o.clicks+\'</td> <td >\'+o.ctr+\'</td> <td >\'+o.active_view_viewable+\'</td> <td >\'+((o.earnings_client/o.impressions)*1000).toFixed(2)+\'	</td> <td >\'+o.earnings_client+\'</td> </tr> \';
            }
          });
          $("#tableAll").html(tableAll);
          $("#tableData tr:odd").addClass("outracor");

          var tableData = "";
          obj.site.forEach(function(o, index){
            tableData += \'<tr> <td >\'+o.date+\'</td> <td >\'+o.impressions+\'</td> <td >\'+o.clicks+\'</td> <td >\'+o.ctr+\'</td> <td >\'+o.active_view_viewable+\'</td> <td >\'+((o.earnings_client/o.impressions)*1000).toFixed(2)+\'	</td> <td >\'+o.earnings_client+\'</td> </tr> \';
          });
          $("#tableData").html(tableData);
          $("#tableData tr:odd").addClass("outracor");

          var tableAdUnit = "";
          obj.adUnit.forEach(function(o, index){
            tableAdUnit += \'<tr> <td >\'+o.ad_unit+\'</td> <td >\'+o.impressions+\'</td> <td >\'+o.clicks+\'</td> <td >\'+o.ctr+\'</td> <td >\'+o.active_view_viewable+\'</td> <td >\'+((o.earnings_client/o.impressions)*1000).toFixed(2)+\'	</td> <td >\'+o.earnings_client+\'</td> </tr> \';
          });
          $("#tableAdUnit").html(tableAdUnit);
          $("#tableAdUnit tr:odd").addClass("outracor");

        });
  		});


      $("#filtro").change(function(){
  			if(this.value == 1){
  				$(".custon_date").hide();
  				$("#startDate").val("'.date('d-m-Y').'");
  				$("#endDate").val("'.date('d-m-Y').'");
  			}else if(this.value == 2){
  				$(".custon_date").hide();
  				$("#startDate").val("'.date('01-m-Y').'");
  				$("#endDate").val("'.date('d-m-Y', strtotime(date('d-m-Y'). ' - 1 days')).'");
  			}else if(this.value == 3){
  				$(".custon_date").hide();
  				$("#startDate").val("'.date('01-m-Y', strtotime(date('d-m-Y'). ' - 1 month')).'");
  				$("#endDate").val("'.date('t-m-Y', strtotime(date('d-m-Y'). ' - 1 month')).'");
  			}else if(this.value == 4){
          console.log("Aqui");
  				$(".custon_date").show();
  				$("#startDate").val("'.date('01-m-Y', strtotime(date('d-m-Y'). ' - 1 month')).'");
  				$("#endDate").val("'.date('t-m-Y', strtotime(date('d-m-Y'). ' - 1 month')).'");
  			}
  		});

      $("#login").click(function(){
        var email = $("#email").val();
        var password = $("#password").val();

        $.get("http://localhost/painel/admin/admanager/loginplugin/{hashProject}/"+email+"/"+password, function(data, status){
          // alert(data);
        });
      });

    });
    </script>

    ';
    echo $options;
  // wp_enqueue_script( 'my_plugin_script' );
  }


  public function optimize(){
    $login = '<style>

      @keyframes blink {
        0% { box-shadow: 0 0 15px #843e90; }
        50% { box-shadow: none; }
        100% { box-shadow: 0 0 15px #843e90; }
      }

      @-webkit-keyframes blink {
        0% { box-shadow: 0 0 15px #843e90; }
        50% { box-shadow: 0 0 0; }
        100% { box-shadow: 0 0 15px #843e90; }
      }

      .blink {
        -webkit-animation: blink 2s linear infinite;
        -moz-animation: blink 2s linear infinite;
        -ms-animation: blink 2s linear infinite;
        -o-animation: blink 2s linear infinite;
        animation: blink 2s linear infinite;
      }


      table {
        border-collapse: collapse;
        width: 100%;
      }

      th, td {
        text-align: left;
        padding: 8px;
      }

      .outracor { background: #ddd; }

      </style>

      <style>

        @keyframes blink {
          0% { box-shadow: 0 0 15px #843e90; }
          50% { box-shadow: none; }
          100% { box-shadow: 0 0 15px #843e90; }
        }

        @-webkit-keyframes blink {
          0% { box-shadow: 0 0 15px #843e90; }
          50% { box-shadow: 0 0 0; }
          100% { box-shadow: 0 0 15px #843e90; }
        }

        .blink {
          -webkit-animation: blink 2s linear infinite;
          -moz-animation: blink 2s linear infinite;
          -ms-animation: blink 2s linear infinite;
          -o-animation: blink 2s linear infinite;
          animation: blink 2s linear infinite;
        }


        table {
          border-collapse: collapse;
          width: 100%;
        }

        th, td {
          text-align: left;
          padding: 8px;
        }

        .outracor { background: #ddd; }

        </style>

      <div id="loginForm">
          <div id="post-body">

            <div class="" style=" /* background-color: #843e90; */ ">

                <center>
                  <div class="postbox blink" style="width:30%; margin-top: 20px;     margin-bottom: 30%;">
                      <h3 class="hndle"><label for="title">
                        <center style="margin-top: 20px">
                          <img src="'.plugins_url("beetAds/images/logo.png").'"/>
                        </center>
                      </h3>
                      <div class="inside">
                        <div class="wpcci_blue_box"></div>

                          <form action="" method="POST" id="loginForm">
                              <input type="text" name="email" id="email" dir="ltr" style="width:100%;"  placeholder="Email">
                              <input type="password" name="password" id="password" dir="ltr" style="width:100%; margin-top: 10px" placeholder="Senha">
                              <div style="border-bottom: 1px solid #dedede; height: 10px"></div>
                              <br />
                              <div id="error" style="color:red"></div>
                              <br/>
                              <button type="button" id="login" name="wpcci_save_settings" class="button-primary">Entrar</button>
                          </form>
                        </div>
                  </div>
                </center>
            </div>
          </div>
      </div>

      <div id="optimizer" style="display: none">
          <div id="post-body">

            <div class="" style=" /* background-color: #843e90; */ ">

                <center>
                  <div class="postbox " style="width:50%; margin-top: 20px;     margin-bottom: 30%;">
                      <h3 class="hndle"><label for="title">
                        <center style="margin-top: 20px">
                          <img src="'.plugins_url("beetAds/images/logo.png").'"/>
                        </center>
                      </h3>
                      <div class="inside">
                        <div class="wpcci_blue_box"></div>

                          <form action="" method="POST" id="optimize">
                              <p style="text-align:justify">O sistema de otimização de imagens da BeetAds consiste em otimizar as imagens e deixar todas no padrão web mais rápido e assim melhorar o rankeamento em motores de busca.<br />
                              </p>
                              <!--<p style="text-align:left">URL CDN: </p>
                              <input type="text" name="url" id="url" dir="ltr" style="width:100%;"  placeholder="URL">
                              <br/>-->
                              <p>Atenção após a execução todas as imagens vão ser substituidas por .webp (ação sem volta)</p>

                              <button type="button" id="login" name="wpcci_save_settings" class="button-primary">Otimizar Imagens</button>

                              <button type="button" id="clean" name="wpcci_save_settings" class="button-secondary">Limpar Imagens</button>

                              <!--<button type="button" id="cdn" name="wpcci_save_settings" class="button-secondary"> CDN Ativar</button>-->
                              <p><small style="color:red">*em breve CDN URL</small></p>

                          </form>
                          <br />
                          <div id="working" style="display:none;">
                            <p>Otimizando...<br /><img id="loader" src="/wp-admin/images/loading.gif"></p>
                            <div id="retorno" style="font-size:9px;text-align:left;border:1px solid #CCC; padding:10px;box-sizing:border-box;width:100%;max-height:500px;overflow-x:scroll"></div>
                          </div>
                        </div>
                  </div>
                </center>
            </div>
          </div>
      </div>

      <script>
        jQuery(document).ready(function($) {
          $("#login").click(function(){
            var email = $("#email").val();
            var password = $("#password").val();
            $.get("https://painel.beetads.com/run/plugin/login-adm/"+email+"/"+password, function(data, status){
              if(data == 1){
                document.getElementById("loginForm").style.display = "none";
                document.getElementById("optimizer").style.display = "block";
              }else{
                $("#error").html("Login ou senha estão incorretos.");
              }
            });
          });
        });
      </script>

    <script>
      jQuery(document).ready(function($) {
        $("#login").click(function(){
          $("#retorno").html(" ");
          $("#working").fadeIn();

          var email = $("#url").val();
          $.get("/wp-admin/admin.php?page=beetads&action=optimize-start", function(data, status){
            $("#retorno").append(data);
            $("#loader").fadeOut();
          });
        });

        $("#clean").click(function(){
          $("#retorno").html(" ");
          $("#working").fadeIn();

          var email = $("#url").val();
          $.get("/wp-admin/admin.php?page=beetads&action=optimize-clean", function(data, status){
            $("#retorno").append(data);
            $("#loader").fadeOut();
          });
        });
      });
    </script>';

    echo $login;
  }



}

?>
