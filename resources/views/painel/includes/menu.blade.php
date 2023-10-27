@inject('Permissions', 'App\Models\Painel\Permissions')
@inject('PermissionsRole', 'App\Models\Painel\PermissionsRole')
@inject('RoleUser', 'App\Models\Painel\RoleUser')
@inject('Role', 'App\Models\Painel\Role')
@inject('Pages', 'App\Models\Painel\Pages')
<div class="sidebar-nav scrollbar scroll_light">
   <ul class="metismenu" id="sidebarNav">

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

      <li >
         <a href="/painel" aria-expanded="false">
            <i class="nav-icon fa fa-home"></i>
            <span class="nav-title">Dashboard</span>
         </a>
      </li>

      @foreach($Permissions->whereIn('id',$idMenus)->orderBy('order')->get() as $Menu)
            @if($Menu->menu_fix == 0)
               <li >

                  <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                     <i class="nav-icon {{$Menu->icon}}"></i>
                     <span class="nav-title">{{$Menu->readable_name}}</span>
                  </a>

                  <ul aria-expanded="false">
                     @foreach($Permissions->where('id_permission', $Menu->id)->whereIn('id',$idSubMenus)->get() as $Permission)
                     <li>
                        <a href="/painel/{{$Permission->name}}">
                           {{$Permission->readable_name}}
                           @if($Permission->new == 1)
                              <span class="label label-danger" style="margin-left: 5px;">Novo</span>
                           @endif
                        </a>
                     </li>
                     @endforeach
                  </ul>
                  
               </li>
            @else
               <li >
                  <a href="/painel/{{$Menu->name}}" aria-expanded="false">
                     <i class="nav-icon {{$Menu->icon}}"></i>
                     <span class="nav-title">
                        {{$Menu->readable_name}}
                        @if($Menu->new == 1)
                           <span class="label label-danger">Novo</span>
                        @endif
                     </span>
                  </a>
               </li>
            @endif
      @endforeach

         @foreach($Pages->orderBy('position')->get() as $Page)
            @if($IDRole != 2 || $Page->name == "Contato")
            <li >
               <a href="/painel/pages/open-page/{{$Page->url}}" aria-expanded="false">
                  <i class="nav-icon {{$Page->icon}}"></i>
                  <span class="nav-title">
                     {{$Page->name}}
                     @if($Page->new == 1)
                        <span class="label label-danger">Novo</span>
                     @endif
                  </span>
               </a>
            </li>
            @endif
         @endforeach

   </ul>
</div>
