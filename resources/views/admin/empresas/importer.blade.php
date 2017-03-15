@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            Importador<small>Importar XML con los datos de las empresas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">Seleccione el XML de las empresas</div>
                </div>

                <div class="box-body">

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="alert alert-info fade in alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                                <strong>¡Importante!</strong> Considere y respete el orden de las columnas en su Excel para realizar una importación exitosa de sus datos. Compruebe en el siguiente Excel como aparecen ordenadas las columnas. <a href="/uploads/EMPRESAS-FORMATO.xls" target="_blank">Consultar Modelo</a>
                            </div>
                        </div>
                    </div>

                    <br>

                    {!! Form::open(['route' => 'process_importer_empresa', 'files' => true, 'id' => 'process_importer_empresa', 'name' => 'process_importer_empresa']) !!}

                    <div class="row">

                        @include('common.errors')

                        <div class="form-group">
                            <label for="" class="col-lg-1 control-label">XML File</label>
                            <div class="col-sm-6 col-xs-12">
                                <input type="file" id="excel_file" name="excel_file" class="form-control m-b-10 excel_file" accept=".xls">
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-6 col-xs-12">
                            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>


                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')

    <script type="text/javascript">
        $(document).ready(function() {
//            $(".xml_file").on('change', function() {
//                var last_xml_file_val = $(".xml_file:last-child").val();
//                if(last_xml_file_val != "")
//                    $('.wrapper_xml_files').append('<input type="file" name="xml_files[]" class="form-control m-b-10 xml_file" accept=".xml">');
//            });
        });
    </script>
@stop