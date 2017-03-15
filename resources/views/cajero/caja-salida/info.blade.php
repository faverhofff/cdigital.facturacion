@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">Caja</span>
            <small><span class="">Información de Caja.</span></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">Cajero</a></li>
            <li class="active">Información de Caja</li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Default box -->
    <div class="row">

        <!-- THE ACTUAL CONTENT -->
        <div class="col-md-12">
            <div class="box">
                <div class="box-header {{ $crud->hasAccess('create')?'with-border':'' }}">

                    @include('crud::inc.button_stack', ['stack' => 'top'])

                    <div id="datatable_button_stack" class="pull-right text-right"></div>
                </div>

                <div class="box-body table-responsive">

                    {{-- Backpack List Filters --}}
                    @if ($crud->filtersEnabled())
                        @include('crud::inc.filters_navbar')
                    @endif

                    <?php
                        $tce = 0;
                        $tcs = 0;
                    ?>

                    @foreach ($entries_ce as $k => $entry)
                        <?php $tce+= $entry->total; ?>
                    @endforeach

                    @foreach ($entries_cs as $k => $entry)
                        <?php $tcs+= $entry->historicodeposito->deposito; ?>
                    @endforeach

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info fade in">
                                <h5 class="text-uppercase"><strong>Saldo en Caja Chica: <?php echo $tce - $tcs; ?></strong></h5>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h5 class="text-uppercase"><strong>Caja de Salida</strong></h5>
                    </div>

                    <table id="crudTablea" class="table table-bordered table-striped display dataTable">
                        <thead>
                        <tr>
                            <th>Movimiento(s)</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>1000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>2</th>
                            <th>1</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($entries_cs as $k => $entry)
                            <tr data-entry-id="{{ $entry->getKey() }}">
                                <?php
                                $historicodeposito = $entry->historicodeposito;
                                $diarioSalidas = $historicodeposito->diarioSalidas;
                                ?>

                                <td>
                                    @foreach($diarioSalidas as $diarioSalida)
                                        <span>- {{$diarioSalida->movimiento}} -</span>
                                    @endforeach
                                </td>
                                <td>
                                    <?php
                                        $cliente = $historicodeposito->cliente;
                                    ?>
                                    {{$historicodeposito->cliente_promotor['nombre']}} @if($cliente) ({{$cliente['nombre']}}) @endif
                                </td>
                                    <td>{{$entry->created_at}}</td>
                                <td>{{$historicodeposito->deposito}}</td>
                                <td>{{$entry->v1000}}</td>
                                <td>{{$entry->v500}}</td>
                                <td>{{$entry->v200}}</td>
                                <td>{{$entry->v100}}</td>
                                <td>{{$entry->v50}}</td>
                                <td>{{$entry->v20}}</td>
                                <td>{{$entry->v10}}</td>
                                <td>{{$entry->v5}}</td>
                                <td>{{$entry->v2}}</td>
                                <td>{{$entry->v1}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                                <th>Movimiento(s)</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>1000</th>
                                <th>500</th>
                                <th>200</th>
                                <th>100</th>
                                <th>50</th>
                                <th>20</th>
                                <th>10</th>
                                <th>5</th>
                                <th>2</th>
                                <th>1</th>
                        </tr>
                        </tfoot>
                    </table>

                    <br>
                    <div class="col-md-12">
                        <h5 class="text-uppercase"><strong>Caja de Entrada</strong></h5>
                    </div>

                    <table id="crudTablea" class="table table-bordered table-striped display dataTable">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>1000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>2</th>
                            <th>1</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($entries_ce as $k => $entry)
                            <tr data-entry-id="{{ $entry->getKey() }}">
                                <td>{{$entry->nombre}}</td>
                                <td>{{$entry->fecha}}</td>
                                <td>{{$entry->total}}</td>
                                <td>{{$entry->v1000}}</td>
                                <td>{{$entry->v500}}</td>
                                <td>{{$entry->v200}}</td>
                                <td>{{$entry->v100}}</td>
                                <td>{{$entry->v50}}</td>
                                <td>{{$entry->v20}}</td>
                                <td>{{$entry->v10}}</td>
                                <td>{{$entry->v5}}</td>
                                <td>{{$entry->v2}}</td>
                                <td>{{$entry->v1}}</td>

                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Nombre</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>1000</th>
                            <th>500</th>
                            <th>200</th>
                            <th>100</th>
                            <th>50</th>
                            <th>20</th>
                            <th>10</th>
                            <th>5</th>
                            <th>2</th>
                            <th>1</th>
                        </tr>
                        </tfoot>
                    </table>

                </div><!-- /.box-body -->

                @include('crud::inc.button_stack', ['stack' => 'bottom'])

            </div><!-- /.box -->
        </div>

    </div>

@endsection

@section('after_styles')
    <!-- DATA TABLES -->
    <link href="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/list.css') }}">

    <!-- CRUD LIST CONTENT - crud_list_styles stack -->
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    <!-- DATA TABLES SCRIPT -->
    <script src="{{ asset('vendor/adminlte/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>

    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/list.js') }}"></script>

    @if ($crud->exportButtons())
        <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.bootstrap.min.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" type="text/javascript"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js" type="text/javascript"></script>
        <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js" type="text/javascript"></script>
        <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.colVis.min.js" type="text/javascript"></script>
    @endif

    <script src="{{ asset('vendor/adminlte/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {

                    @if ($crud->exportButtons())
            var dtButtons = function(buttons){
                        var extended = [];
                        for(var i = 0; i < buttons.length; i++){
                            var item = {
                                extend: buttons[i],
                                exportOptions: {
                                    columns: [':visible']
                                }
                            };
                            switch(buttons[i]){
                                case 'pdfHtml5':
                                    item.orientation = 'landscape';
                                    break;
                            }
                            extended.push(item);
                        }
                        return extended;
                    }
                    @endif

            var table = $("#crudTable").DataTable({
                        "pageLength": {{ $crud->getDefaultPageLength() }},
                        /* Disable initial sort */
                        "aaSorting": [],
                        "language": {
                            "emptyTable":     "{{ trans('backpack::crud.emptyTable') }}",
                            "info":           "{{ trans('backpack::crud.info') }}",
                            "infoEmpty":      "{{ trans('backpack::crud.infoEmpty') }}",
                            "infoFiltered":   "{{ trans('backpack::crud.infoFiltered') }}",
                            "infoPostFix":    "{{ trans('backpack::crud.infoPostFix') }}",
                            "thousands":      "{{ trans('backpack::crud.thousands') }}",
                            "lengthMenu":     "{{ trans('backpack::crud.lengthMenu') }}",
                            "loadingRecords": "{{ trans('backpack::crud.loadingRecords') }}",
                            "processing":     "{{ trans('backpack::crud.processing') }}",
                            "search":         "{{ trans('backpack::crud.search') }}",
                            "zeroRecords":    "{{ trans('backpack::crud.zeroRecords') }}",
                            "paginate": {
                                "first":      "{{ trans('backpack::crud.paginate.first') }}",
                                "last":       "{{ trans('backpack::crud.paginate.last') }}",
                                "next":       "{{ trans('backpack::crud.paginate.next') }}",
                                "previous":   "{{ trans('backpack::crud.paginate.previous') }}"
                            },
                            "aria": {
                                "sortAscending":  "{{ trans('backpack::crud.aria.sortAscending') }}",
                                "sortDescending": "{{ trans('backpack::crud.aria.sortDescending') }}"
                            }
                        },

                        @if ($crud->ajaxTable())
                        "processing": true,
                        "serverSide": true,
                        "ajax": {
                            "url": "{{ url($crud->route.'/search').'?'.Request::getQueryString() }}",
                            "type": "POST"
                        },
                        @endif

                        @if ($crud->exportButtons())
                        // show the export datatable buttons
                        dom: '<"p-l-0 col-md-6"l>B<"p-r-0 col-md-6"f>rt<"col-md-6 p-l-0"i><"col-md-6 p-r-0"p>',
                        buttons: dtButtons([
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdfHtml5',
                            'print',
                            'colvis'
                        ]),
                        @endif
                    });

            @if ($crud->exportButtons())
            // move the datatable buttons in the top-right corner and make them smaller
            table.buttons().each(function(button) {
                if (button.node.className.indexOf('buttons-columnVisibility') == -1)
                {
                    button.node.className = button.node.className + " btn-sm";
                }
            })
            $(".dt-buttons").appendTo($('#datatable_button_stack' ));
            @endif

            $.ajaxPrefilter(function(options, originalOptions, xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');

                if (token) {
                    return xhr.setRequestHeader('X-XSRF-TOKEN', token);
                }
            });

            $('#crudTable_wrapper .row:first-child').remove();
            $('#crudTable_wrapper .row:last-child').remove();
        });
    </script>

    <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
    @stack('crud_list_scripts')
@endsection
