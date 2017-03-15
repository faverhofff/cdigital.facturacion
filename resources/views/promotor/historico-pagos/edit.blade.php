@extends('backpack::layout')

@section('after_styles')
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('header')
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         A&ntilde;adir <span class="text-lowercase">hist&oacute;rico</span>
      </h1>
      <ol class="breadcrumb">
         <li><a href="{{ url('/dashboard') }}">Admin</a></li>
         <li><a href="{{ url('historico/depositos') }}" class="text-capitalize">Histórico Depósitos</a></li>
         <li class="active">Añadir</li>
      </ol>
   </section>
@endsection

@section('content')
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            <a href="{{ url('historico/depositos') }}"><i class="fa fa-angle-double-left"></i> Volver al listado  <span class="text-lowercase">Histórico Depósitos</span></a><br><br>
            <form method="POST" action="{{ url('historico/depositos') }}" accept-charset="UTF-8">
               <input name="_token" type="hidden" value="{{ csrf_token() }}">
               <input name="user_id" type="hidden" value="{{ \Auth::user()->id }}">
               <div class="box">
                  <div class="box-header with-border">
                     <h3 class="box-title">A&ntilde;adir nuevo  hist&oacute;rico</h3>
                  </div>
                  <div class="box-body row">

                     @if ($errors->any())
                        <div class="col-md-12">
                           <div class="callout callout-danger">
                              <h4>{{ trans('backpack::crud.please_fix') }}</h4>
                              <ul>
                                 @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                 @endforeach
                              </ul>
                           </div>
                        </div>
                     @endif     

                     <div class="form-group col-md-12">
                        <label>Movimientos</label>
                        <input type="text" name="Cliente" class="form-control" readonly="readonly" value="{{ json_decode($data->movimientos) }}">
                     </div>

                     <div class="form-group col-md-12">
                        <label>Cliente</label>
                        <input type="text" name="Cliente" disabled="disabled" value="{{ $data->cliente }}" class="form-control" readonly="readonly" >
                     </div>
                     
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- text input -->
                     <div class="form-group col-md-12">
                        <label>Dep&oacute;sito</label>
                        <input type="text" name="deposito" value="{{ $data->deposito }}" class="form-control"  onkeypress="return CurrencyFormat(value, id, event);" readonly="readonly" >
                     </div>
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- textarea -->
                     <div class="form-group col-md-12">
                        <label>Res&uacute;men</label>
                        <textarea name="resumen" class="form-control" disabled="disabled">{{ $data->resumen }}</textarea>
                     </div>
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- text input -->
                     <div class="form-group col-md-12">
                        <label>Forma de pago</label>
                        <select name="forma_pago" class="form-control" readonly="readonly">
                           <option value="PAGO EN UNA SOLA EXHIBICION" @if($data->forma_pago==1) selected="selected" @endif>PAGO EN UNA SOLA EXHIBICION</option>
                           <option value="PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)" @if($data->forma_pago==2) selected="selected" @endif>PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)</option>
                           <option value="PAGO EN PARCIAIDADES" @if($data->forma_pago==3) selected="selected" @endif>PAGO EN PARCIAIDADES</option>
                        </select>
                     </div>
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- text input -->
                     <div class="form-group col-md-12">
                        <label>M&eacute;todo de pago</label>
                        <select name="metodo_pago" class="form-control" readonly="readonly">
                        <option value="NO IDENTIFICADO">NO IDENTIFICADO</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="TRANSFERENCIA ELECTRONICA">TRANSFERENCIA ELECTRONICA</option>
                        <option value="TARJETA">TARJETA</option>
                        </select>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <a href="{{ url('historico/depositos') }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Regresar</span></a>
                  </div>
                  <!-- /.box-footer-->
               </div>
            </form>
            <!-- /.box -->
         </div>
      </div>
   </section>
   <!-- /.content -->
@endsection

@section('after_scripts')
   <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
   <script type="text/javascript">
     $('#movimientos').select2({
         placeholder: "Choose tags...",
         minimumInputLength: 2,
         ajax: {
             url: '/dame/movimientos',
             dataType: 'json',
             data: function (params) {
                 return {
                     q: $.trim(params.term)
                 };
             },
             processResults: function (data) {
                 return {
                     results: data
                 };
             },
             cache: true
         }
     });   
     function CurrencyFormat(val, id, e) {
         var key = e.keyCode || e.charCode || e.which;
         var currentChar = String.fromCharCode(key);
         if (e.keyCode == 46 && e.charCode == 0 && e.which == 0) {
             $(this).val("");
             return true;
         }
         if (e.keyCode == 36 && e.charCode == 0 && e.which == 0) {
             $(this).val("");
             return true;
         }
         if (val.indexOf(currentChar) != -1 && currentChar == ".") {
             return false;
         }
        if (val.indexOf(currentChar) != -1 && currentChar == "$") {
             return false;
         }
         if (key >= 48 && key <= 57 || key == 46 || key == 36 || e.keyCode === 8 || e.keyCode === 9 || e.keyCode === 37 || e.keyCode === 35 || e.keyCode === 39) {
             $(this).val("");
             return true;
         }
         return false;
     }
   </script>
@endsection        