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

                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- text input -->
<!--                      <div class="form-group col-md-12">
                        <label>Solicitud de Factura</label>
                        <select name="solicitud_factura_id" class="form-control">
                           @foreach($solicitudes as $item)
                           <option value="{{ $item->id }}">FOLIO:{{ $item->folio }} </option>
                           @endforeach
                        </select>
                     </div> -->

                     <div class="form-group col-md-12">
                        <label>Movimientos</label>
                        <select id="movimientos" name="movimientos[]" class="form-control" multiple="true"></select>
                     </div>

                     <div class="form-group col-md-12">
                        <label>Cliente Promotor</label>
                        <select id="cliente_promotor" name="cliente_promotor" value="" class="form-control" ></select>
                     </div>

                     <div class="form-group col-md-12">
                        <label>Cliente</label>
                        <select id="cliente" name="cliente" value="" class="form-control" ></select>
                     </div>
                     
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- textarea -->
                     <div class="form-group col-md-12">
                        <label>Res&uacute;men</label>
                        <textarea name="resumen" class="form-control"></textarea>
                     </div>
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- text input -->
                     <div class="form-group col-md-12">
                        <label>Forma de pago</label>
                        <select name="forma_pago" class="form-control">
                           <option value="PAGO EN UNA SOLA EXHIBICION">PAGO EN UNA SOLA EXHIBICION</option>
                           <option value="PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)">PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)</option>
                           <option value="PAGO EN PARCIAIDADES">PAGO EN PARCIAIDADES</option>
                        </select>
                     </div>
                     <!-- load the view from the application if it exists, otherwise load the one in the package -->
                     <!-- text input -->
                     <div class="form-group col-md-12">
                        <label>M&eacute;todo de pago</label>
                        <select name="metodo_pago" class="form-control">
                        <option value="NO IDENTIFICADO">NO IDENTIFICADO</option>
                        <option value="CHEQUE">CHEQUE</option>
                        <option value="TRANSFERENCIA ELECTRONICA">TRANSFERENCIA ELECTRONICA</option>
                        <option value="TARJETA">TARJETA</option>
                        </select>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                     <div class="form-group">
                        <span>Después de guardar:</span>
                        <div class="radio">
                           <label>
                           <input type="radio" name="redirect_after_save" value="historico/depositos" checked="">
                           ir al listado
                           </label>
                        </div>
                        <div class="radio">
                           <label>
                           <input type="radio" name="redirect_after_save" value="historico/depositos/create">
                           añadir otro item
                           </label>
                        </div>
                        <div class="radio">
                           <label>
                           <input type="radio" name="redirect_after_save" value="current_item_edit">
                           editar este item
                           </label>
                        </div>
                     </div>
                     <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Añadir</span></button>
                     <a href="http://facturacion.dev:81/historico/depositos" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancelar</span></a>
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
$('#cliente, #cliente_promotor').select2();

            $('#cliente').select2({
                     placeholder: "Seleccione cliente...",
                     minimumInputLength: 2,
                     selectOnBlur: true,
                     tags: true,
                      id: function(object) {
                        return object.text;
                      },                     
                     ajax: {
                         url: '/dame/clientes/por/',
                         dataType: 'json',
                         data: function (params) {
                             return {
                                 a: $.trim(params.term),
                                 b: $('#cliente_promotor').val()
                             };
                         },
                         processResults: function (data) {
                             return {
                                 results: data
                             };
                         },
                         cache: true
                     },
                    //Allow manually entered text in drop down.
                    createSearchChoice:function(term, data) {
                      if ( $(data).filter( function() {
                        return this.text.localeCompare(term)===0;
                      }).length===0) {
                        return {id:term, text:term};
                      }
                    }                     
                 });  

            $('#cliente_promotor').select2({
                     placeholder: "Seleccione cliente promotor...",
                     minimumInputLength: 2,
                     selectOnBlur: true,
                     tags: true,
                      id: function(object) {
                        return object.text;
                      },                     
                     ajax: {
                         url: '/dame/clientes/promotores',
                         dataType: 'json',
                         data: function (params) {
                             return {
                                 a: $.trim(params.term)
                             };
                         },
                         processResults: function (data) {
                             return {
                                 results: data
                             };
                         },
                         cache: true
                     },
                    //Allow manually entered text in drop down.
                    createSearchChoice:function(term, data) {
                      if ( $(data).filter( function() {
                        return this.text.localeCompare(term)===0;
                      }).length===0) {
                        return {id:term, text:term};
                      }
                    }                    
                 });

     $('#movimientos').select2({
         placeholder: "Seleccione movimientos...",
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