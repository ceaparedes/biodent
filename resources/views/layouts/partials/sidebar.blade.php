<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('adminlte_lang::message.header') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview">
                <a href="#"><i class="fa fa-file-o" aria-hidden="false"></i> <span>{{ trans('Pacientes') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('pacientes.create')}}">{{ trans('Crear Nuevo Paciente') }}</a></li>
                    <li><a href="{{route('pacientes.index')}}">{{ trans('Enlistar Paciente') }}</a></li>
                    <li><a href="#">{{ trans('Crear Plan de Tratamientos')}}</a></li>
                    
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class="fa fa-user-md" aria-hidden="true"></i> <span>{{ trans('Odontologos') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('odontologos.create')}}">{{ trans('Crear Nuevo Odontólogo') }}</a></li>
                    <li><a href="{{route('odontologos.index')}}">{{ trans('Enlistar Odontólogos') }}</a></li>
                    <li><a href="{{route('especialidades.create')}}">{{ trans('Crear Nueva Especialidad')}}</a></li>
                    <li><a href="{{route('especialidades.index')}}">{{ trans('Enlistar Especialidades')}}</a></li>
                    <li><a href="#">{{ trans('Asignar Especialidad a Odontologo') }}</a></li>

                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-hospital-o'></i> <span>{{ trans('Tratamientos') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('tratamientos.create')}} ">{{ trans('Crear Nuevos Tratamientos') }}</a></li>
                    <li><a href="{{route('tratamientos.index')}} ">{{ trans('Enlistar Tratamientos') }}</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='fa fa-address-book'></i> <span>{{ trans('adminlte_lang::message.multilevel') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                    <li><a href="#">{{ trans('adminlte_lang::message.linklevel2') }}</a></li>
                </ul>
            </li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
