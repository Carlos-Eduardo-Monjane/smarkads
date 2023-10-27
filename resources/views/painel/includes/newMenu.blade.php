@inject('Permissions', 'App\Models\Painel\Permissions')
@inject('PermissionsRole', 'App\Models\Painel\PermissionsRole')
@inject('RoleUser', 'App\Models\Painel\RoleUser')
@inject('Role', 'App\Models\Painel\Role')
@inject('Pages', 'App\Models\Painel\Pages')
<div class="app--containerOne--menu">
    <div class="containerNavgiation">

      <script type="text/javascript">
          function closeSubMenu(id){
            console.log(id);
              $('#'+id).fadeOut(200);
          }
      </script>

      <?php
      $IDRole = $RoleUser->where('user_id', Auth::user()->id)->first()->role_id;
      $PermissionsRole = $PermissionsRole->where('role_id', $IDRole)->get();

      foreach($PermissionsRole as $PermissionRole){
         $Permission = $Permissions->where('menu_fix', 0)->find($PermissionRole->permission_id);
         if(isset($Permission->id)){
           $idMenus[] = $Permission->id_permission;
           $idSubMenus[] = $Permission->id;
         }else{
           $Permission = $Permissions->where('menu_fix', 1)->find($PermissionRole->permission_id);
           $idMenus[] = $Permission->id;
         }
      }

      if(empty($idMenus)){
         $idMenus = [];
      }
      ?>
      
      <div class="app--container-menu">
          <div class="title--app-menu">
            <h4>Menu de Navegação</h4>
            <span class="app--close-tab"><i class="far fa-times-circle"></i></span>
          </div>

          <div class="base-app-container-search">
            <input type="text" name="searchBox" placeholder="Procure um menu aqui" class="searchBox" />
          </div>

          {{-- session one --}}
          <div class="row app--grid">

              <div class="col-md-2 col-6 col-lg-3">
                <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                    <a href="#" id="tarefas" class="app--base-url-itemMenu">
                      <i class="far fa-copy"></i>
                      <span class="app--name-menu"><h6>Tarefas</h6></span>
                    </a>

                    <div class="SubboxNavigationItem" id="tarefas-dropdown">
                        <div class="title--app-menu">
                          <h4 style="color: #222;">Sub Menu de Tarefas</h4>
                          <button class="minimize-submenu" onclick="closeSubMenu('tarefas-dropdown')">
                            FECHAR
                          </button>
                        </div>
                          <ul class="items-subMenu--App">
                            <li><a href="/painel/domain-checklist/checklist">Otimizações</a></li>
                            <li><a href="/painel/users/lead">Leads</a></li>
                            <li><a href="/painel/assignment">Todas Tarefas</a></li>
                            <li><a href="/painel/assignment/my">Minhas Tarefas</a></li>
                            <li><a href="/painel/users/setup">Setup</a></li>
                            <li><a href="/painel/contract/user">Novo Contrato</a></li>
                            <li><a href="/painel/contract/signature-admin">Contrato Assinar</a></li>
                         </ul>
                         
                        
                    </div>

                    <script>
                        $(document).ready(() => {
                            $('#tarefas').on('click', () => {
                                $('#tarefas-dropdown').toggle();
                            });
                        });
                    </script>

                </div>
              </div>

              <div class="col-md-2 col-6 col-lg-3">
                <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                    <a href="/painel/users/clients" class="app--base-url-itemMenu">
                      <i class="fas fa-users"></i>
                      <span class="app--name-menu"><h6>Clientes</h6></span>
                    </a>
                </div>
              </div>

              <div class="col-md-2 col-6 col-lg-3">
                <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                    <a href="#" class="app--base-url-itemMenu" id="dominio">
                      <i class="fas fa-sitemap"></i>
                      <span class="app--name-menu"><h6>Domínios</h6></span>
                    </a>

                    <div class="SubboxNavigationItem" id="dominio-dropdown">
                        <div class="title--app-menu">
                          <h4 style="color: #222;">Sub Menu de Domínios</h4>
                          <button class="minimize-submenu" onclick="closeSubMenu('dominio-dropdown')">
                            FECHAR
                          </button>
                        </div>
                          <ul class="items-subMenu--App">
                            <li><a href="/painel/domain">Domínios de Clientes</a></li>
                         </ul>
                         
                        
                    </div>

                    <script>
                        $(document).ready(() => {
                            $('#dominio').on('click', () => {
                                $('#dominio-dropdown').toggle();
                            });
                        });
                    </script>

                </div>
              </div>

              <div class="col-md-2 col-6 col-lg-3">
                <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                    <a href="#" class="app--base-url-itemMenu" id="suporte">
                      <i class="far fa-life-ring"></i>
                      <span class="app--name-menu"><h6>Suporte</h6></span>
                    </a>

                    <div class="SubboxNavigationItem" id="suporte-dropdown">
                        <div class="title--app-menu">
                          <h4 style="color: #222;">Sub Menu de Suporte</h4>
                          <button class="minimize-submenu" onclick="closeSubMenu('suporte-dropdown')">
                            FECHAR
                          </button>
                        </div>
                          <ul class="items-subMenu--App">
                            <li><a href="/painel/article/articles">Ajuda Online</a></li>
                            <li><a href="/painel/ticket/response">Interações</a></li>
                            <li><a href="/painel/ticket/manager">Gerenciar</a></li>
                         </ul>
                         
                        
                    </div>

                    <script>
                        $(document).ready(() => {
                            $('#suporte').on('click', () => {
                                $('#suporte-dropdown').toggle();
                            });
                        });
                    </script>

                </div>
              </div>

          </div>

          {{-- session one --}}
          <div class="row app--grid">

            <div class="col-md-2 col-6 col-lg-3">
              <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                  <a href="#" class="app--base-url-itemMenu" id="financeiro">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span class="app--name-menu"><h6>Financeiro</h6></span>
                  </a>

                    <div class="SubboxNavigationItemBottom" id="financeiro-dropdown">
                    <div class="title--app-menu">
                      <h4 style="color: #222;">Sub Menu de Financeiro</h4>
                      <button class="minimize-submenu" onclick="closeSubMenu('financeiro-dropdown')">
                        FECHAR
                      </button>
                    </div>

                      <ul class="items-subMenu--App">
                        <li>
                            <a href="/painel/fin-bank">
                               Bancos
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/fin-category">
                               Categorias
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/fin-currency">
                               Moedas
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/fin-form">
                               Formas de Pagamento
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/fin-movimentation">
                               Movimentações
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/fin-movimentation/publisher">
                               Publishers
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/fin-invalid">
                               Inválidos
                                              </a>
                         </li>
                     </ul>
                     
                    
                    </div>

                    <script>
                        $(document).ready(() => {
                            $('#financeiro').on('click', () => {
                                $('#financeiro-dropdown').toggle();
                            });
                        });
                    </script>

              </div>
            </div>

            <div class="col-md-2 col-6 col-lg-3">
              <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                  <a href="#" class="app--base-url-itemMenu" id="cadastros">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="app--name-menu"><h6>Cadastros</h6></span>
                    
                  </a>

                    <div class="SubboxNavigationItemBottom" id="cadastros-dropdown">
                    <div class="title--app-menu">
                      <h4 style="color: #222;">Sub Menu de Cadastros</h4>
                      <button class="minimize-submenu" onclick="closeSubMenu('cadastros-dropdown')">
                        FECHAR
                      </button>
                    </div>
                      <ul class="items-subMenu--App">
                        <li>
                            <a href="/painel/pages">
                               Páginas
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/modal">
                               Modal
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/ticket-status">
                               Status Ticket
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/domain-status">
                               Status Dominio
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/domain-category">
                               Categoria domínio
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/department">
                               Departamentos
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/priority">
                               Prioridade
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/article">
                               Artigo
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/contract">
                               Contrato
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/user-type">
                               Tipo Usuário
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/assignment-status">
                               Tarefa Status
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/ads-txt-default">
                               AdsTxt
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/emails-template">
                               Templates Emails
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/message-default">
                               Mensagens padrões
                                              </a>
                         </li>
                     </ul>
                     
                    
                    </div>

                    <script>
                        $(document).ready(() => {
                            $('#cadastros').on('click', () => {
                                $('#cadastros-dropdown').toggle();
                            });
                        });
                    </script>
              </div>
            </div>

            <div class="col-md-2 col-6 col-lg-3">
              <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                  <a href="/painel/profile" class="app--base-url-itemMenu">
                    <i class="fas fa-user"></i>
                    <span class="app--name-menu"><h6>Meu Perfil</h6></span>
                  </a>
              </div>
            </div>

            <div class="col-md-2 col-6 col-lg-3">
              <div class="col-md-12 col-12 col-lg-12 boxNavigationItem">
                  <a href="#" class="app--base-url-itemMenu" id="configuracoes">
                    <i class="fas fa-cogs"></i>
                    <span class="app--name-menu"><h6>Configurações</h6></span>
                  </a>

                  <div class="SubboxNavigationItemBottom" id="configuracoes-dropdown">
                    <div class="title--app-menu">
                      <h4 style="color: #222;">Sub Menu de Configurações</h4>
                      <button class="minimize-submenu" onclick="closeSubMenu('configuracoes-dropdown')">
                        FECHAR
                      </button>
                    </div>
                      <ul class="items-subMenu--App">
                        <li>
                            <a href="/painel/settings">
                               Dados Empresa
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/permissions">
                               Menus
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/roles">
                               Permissões
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/alert">
                               Alerta
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/ad-unit-format">
                               AdManager - Blocos
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/prebid-bids">
                               Prebid - Setings
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/prebid-version">
                               Prebid - Versão
                                              </a>
                         </li>
                                     <li>
                            <a href="/painel/users/colaboradores">
                               Colaboradores
                                              </a>
                         </li>
                     </ul>
                     
                    
                    </div>

                    <script>
                        $(document).ready(() => {
                            $('#configuracoes').on('click', () => {
                                $('#configuracoes-dropdown').toggle();
                            });
                        });
                    </script>
              </div>
            </div>

        </div>


      </div>

    </div>
</div>

<div class="openWindowMenu" id="openWindowMenu"><a href="#"><i class="fas fa-bars"></i></a></div>

<script>
  $(document).ready(function(){

    $('.app--close-tab').on('click', function(){
        $('.app--container-menu').animate({
        marginTop: -1800
        },300);
        $('.app--containerOne--menu').css('display', 'none');
    });

      $('#openWindowMenu').on('click', function(){

        $('.app--containerOne--menu').css('display', 'block');

        $('.app--container-menu').animate({
          marginTop: 0
        },300)

        $('.title--app-menu h4').animate({
          opacity: 0.2
        },500).animate({
          opacity: 0.3
        },400).animate({
          opacity: 0.4
        },300).animate({
          opacity: 0.8
        },200).animate({
          opacity: 1
        },100);

        // menu

        $('.boxNavigationItem').animate({
          opacity: 0.2
        },500).animate({
          opacity: 0.3
        },400).animate({
          opacity: 0.4
        },300).animate({
          opacity: 0.8
        },200).animate({
          opacity: 1
        },100);

      });
  });
</script>