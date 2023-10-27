@inject('Permissions', 'App\Models\Painel\Permissions')
@inject('PermissionsRole', 'App\Models\Painel\PermissionsRole')
@inject('RoleUser', 'App\Models\Painel\RoleUser')
@inject('Role', 'App\Models\Painel\Role')
@inject('Pages', 'App\Models\Painel\Pages')
<div class="col-12 col-md-1 col-lg-1 zeroMargZeroPadded" id="newNavigatorOff">
    <div class="col-12 col-md-12 col-lg-12 zeroMargZeroPadded">
        <nav class="newNavigator-buh">
            <div class="itemsNavigator-buh">

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

                <a href="/painel" class="xxbbxx">
                    <div class="item-navigator-buh stackNav1">
                        <i class="nav-icon fa fa-home"></i> Home
                    </div>
                </a>

                @foreach($Permissions->whereIn('id',$idMenus)->orderBy('order')->get() as $Menu)
                    @if($Menu->menu_fix == 0)
                        <div class="item-navigator-buh stackNav5 itemStack{{$Menu->id}}" onclick='openSubDropDown("{{$Menu->id}}")'>
                            <i class="nav-icon {{$Menu->icon}}"></i> {{$Menu->readable_name}}
        
                            <div class="hideDropNavDown2" id="itemStack-{{$Menu->id}}">
                                <div class="dropNavDown">
                                <h6><i class="fas fa-chevron-down"></i> Opções de {{$Menu->readable_name}}</h6>
        
                                <ul>
                                    @foreach($Permissions->where('id_permission', $Menu->id)->whereIn('id',$idSubMenus)->get() as $Permission)
                                        <li class="">
                                            <a href="/painel/{{$Permission->name}}">
                                                {{$Permission->readable_name}}
                                                @if($Permission->new == 1)
                                                    <span class="label label-danger" style="margin-left: 5px;">Novo</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                                </div>
                            </div>
        
                        </div>
                    @else 
                        <a href="/painel/{{$Menu->name}}" class="xxbbxx">
                            <div class="item-navigator-buh stackNav1">
                                <i class="nav-icon {{$Menu->icon}}"></i> {{$Menu->readable_name}}
                            </div>
                        </a>
                    @endif
                @endforeach

                <script type="text/javascript">

                    function openSubDropDown(id){
                        $('#itemStack-'+id).toggle();
                    }

                </script>

                <script>
                    $(function(){
                    $('.stackNav1').animate({marginLeft: 0}, 800);
                    $('.stackNav2').animate({marginLeft: 0}, 700);
                    $('.stackNav3').animate({marginLeft: 0}, 600);
                    $('.stackNav4').animate({marginLeft: 0}, 500);
                    $('.stackNav5').animate({marginLeft: 0}, 400);
                    })
                </script>

            </div>

        </nav>
    </div>
</div>