@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Diario de Salida
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-3">
        Seleccione Mes de consulta
            <div class="box box-default">
                
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control" readonly="readonly" id="dp">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>                

            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
    <link rel="stylesheet" href="/js/bootstrap-datepicker.min.css">
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.datepicker').datepicker();

            $('#dp').change(function(){
                var d=new String($(this).val());
                D=d.split('/');
                window.location = "/diario/salida/"+D[0]+"/"+D[1]+"/"+D[2];
            })
        });
    </script>
@stop