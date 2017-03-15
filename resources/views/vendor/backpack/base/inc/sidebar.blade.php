@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://placehold.it/160x160/00a65a/ffffff/&text={{ mb_substr(Auth::user()->name, 0, 1) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          @role('Administrador General')
          <li class="header">{{ trans('backpack::base.administration') }}</li>
          @endrole
          @role('Cliente')
          <li class="header">Cliente</li>
          @endrole

          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>

          <!-- Users, Roles Permissions -->
          {{--<li class="treeview">--}}
            {{--<a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
            {{--<ul class="treeview-menu">--}}
              {{--<li><a href="{{ url('admin/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>--}}
              {{--<li><a href="{{ url('admin/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>--}}
              {{--<li><a href="{{ url('admin/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>--}}
            {{--</ul>--}}
          {{--</li>--}}

          @role('Administrador General')
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="glyphicon glyphicon-user"></i> <span>Users</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/clientepromotor') }}"><i class="glyphicon glyphicon-user"></i> <span>Clientes Promotor</span></a></li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/cliente') }}"><i class="glyphicon glyphicon-user"></i> <span>Clientes</span></a></li>
          @endrole

          @role(['Administrador de Área Solicitud de Facturas y Envío de Facturas','Administrador de Área Seguimiento de Facturas', 'Cliente', 'Administrador General'])
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/empresa') }}"><i class="glyphicon glyphicon-briefcase"></i> <span>Empresas</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/solicitud/factura') }}"><i class="fa fa-credit-card"></i> <span>Solicitud Factura</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/diario/salida/index') }}"><i class="glyphicon glyphicon-option-vertical"></i> <span>Diario Salidas</span></a></li>
              <ul>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/historico/depositos') }}"><i class="glyphicon glyphicon-usd"></i> <span>Hist&oacute;rico de Pagos</span></a></li>
            </ul>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/hoja/proveedor') }}"><i class="glyphicon glyphicon-file"></i> <span>Hoja de Proveedor</span></a></li>
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/seguimiento/facturacion') }}"><i class="glyphicon glyphicon-file"></i> <span>Seguimiento Facturaci&oacute;n</span></a></li>
          @endrole


          @role(['Cajero'])
          <li class="treeview">
            <a href="#"><span>Caja</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/caja/info') }}"><i class="glyphicon glyphicon-info-sign"></i> <span>Información de Caja</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/cajasalida') }}"><i class="glyphicon glyphicon-save-file"></i> <span>Caja de Salida</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/cajaentrada') }}"><i class="glyphicon glyphicon-open-file"></i> <span>Caja de Entrada</span></a></li>
            </ul>
          </li>

        @endrole

          <!-- ======================================= -->
          <li class="header">{{ trans('backpack::base.user') }}</li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></li>
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
