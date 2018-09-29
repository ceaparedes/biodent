<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
      

        <!-- search form (Optional) -->
        <!--<form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        @if(auth::user())
        <ul class="sidebar-menu">
            <li class="header">{{ trans('OPCIONES') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview">
                <a href="#"><i class="fas fa-users" aria-hidden="true"></i><span> {{ trans('Pacientes') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('pacientes.create')}}">{{ trans('Crear Nueva ficha de Paciente') }}</a></li>
                    <li><a href="{{route('pacientes.index')}}">{{ trans('Enlistar Pacientes') }}</a></li>                   
                </ul>
            </li>
            @if(auth::user()->usu_rol == 'Administrador')
            <li class="treeview">
                <a href="#"><i class="fa fa-user-md" aria-hidden="true"></i><span>{{ trans('Usuarios') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('usuarios.create')}}">{{ trans('Crear Nuevo Usuario') }}</a></li>
                    <li><a href="{{route('usuarios.index')}}">{{ trans('Enlistar Usuarios') }}</a></li>
                    <li><a href="{{route('especialidades.create')}}">{{ trans('Crear Nueva Especialidad')}}</a></li>
                    <li><a href="{{route('especialidades.index')}}">{{ trans('Enlistar Especialidades')}}</a></li>

                </ul>
            </li> 
            @endif
            <li class="treeview">
                <a href="#"><i class="fas fa-x-ray" aria-hidden="true"></i><span> {{ trans('Tratamientos') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('tratamientos.create')}} ">{{ trans('Crear Nuevos Tratamientos') }}</a></li>
                    <li><a href="{{route('tratamientos.index')}} ">{{ trans('Enlistar Tratamientos') }}</a></li> 
                    @if(auth::user()->usu_rol == 'Administrador')
                    <li><a href="{{route('planes-de-tratamientos.index')}}">{{ trans('Enlistar Planes de Tratamientos') }}</a></li>
                    <li><a href="#">{{ trans('Enlistar sesiones de Tratamientos') }}</a></li>
                    @endif
                    
                </ul>
            </li>


            <li class="treeview">
                <a href="#"><i class='fa fa-briefcase'></i> <span>{{ trans('Materiales o insumos') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('materiales.create')}}">{{ trans('Crear Insumo dental') }}</a></li>
                    <li><a href="{{route('materiales.index')}}">{{ trans('Enlistar Insumos dentales') }}</a></li>
                    <!--<li><a href="#">{{ trans('Crear Recepción de Insumo') }}</a></li>-->
                </ul>
            </li> 
            
            @if(auth::user()->usu_rol != 'Asistente')
            <li class="treeview">
                <a href="#"><i class='fa fa-copy'></i> <span>{{ trans('Informes') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('Ver Informes de Pagos Mensuales') }}</a></li>
                    @if(auth::user()->usu_rol == 'Administrador')
                    <li><a href="#">{{ trans('Consultar Estadisticas') }}</a></li>
                    @endif
                </ul>
            </li>
            @endif
           
           <!-- <li class="treeview">
                <a href="#"><i class='fa fa-address-book'></i> <span>{{ trans('adminlte_lang::message.multilevel') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li>-->
        </ul><!-- /.sidebar-menu -->
        @endif
    </section>
    <!-- /.sidebar -->
</aside>
