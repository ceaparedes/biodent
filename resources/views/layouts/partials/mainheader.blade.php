<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    @if (!Auth::user())
        <a href="{{ url('/login') }}" class="logo">
    @else
        <a href="{{ url('/dashboard') }}" class="logo">
    @endif
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>CDB</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">Clinica <B>Biodent</B> </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
      
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                

               
                
                @if (Auth::guest())
                   <!-- <li><a href="{{ url('/login') }}">{{ trans('Iniciar Sesión') }}</a></li> --><!--modificado para el informe-->
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">Opciones</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                
                                <p>
                                    {{Auth::user()->usu_nombres }} {{Auth::user()->usu_apellido_paterno }}</br>
                                    {{Auth::user()->usu_rut}} - {{Auth::user()->usu_dv}}</br>
                                    {{Auth::user()->usu_rol}}</br>
                                    {{ trans('Opciones a las que puede acceder') }}
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="pull-left">
                                    @if(Auth::user()->usu_rol != 'Administrador')
                                    {!!Form::open(['route'=>['usuarios.editprofile', Auth::user()->usu_id], 'method' =>'GET', 'id'=>'usuarios_update' ,'name'=>'usuarios_update'])!!}
                                    <button class="btn-btn-default btn-flat">Ver Perfil</button>
                                    {!!Form::close()!!}
                                    @else
                                    {!!Form::open(['route'=>['usuarios.edit', Auth::user()->usu_id], 'method' =>'GET', 'id'=>'usuarios_update' ,'name'=>'usuarios_update'])!!}
                                    <button class="btn-btn-default btn-flat">Ver Perfil</button>
                                    {!!Form::close()!!}
                                    @endif
                                </div>
                                <div class="pull-right">
                                    <form method="POST" action="{{route('logout')}}">
                                        {{ csrf_field()}}
                                        <button class="btn-btn-default btn-flat">Cerrar Sesión</button>
                                        
                                    <!--<a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{ trans('Cerrar Sesión') }}</a>-->
                                    </form>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                           
                        </ul>
                    </li>
                @endif

                <!-- Control Sidebar Toggle Button -->
               
            </ul>
        </div>
    </nav>
</header>
