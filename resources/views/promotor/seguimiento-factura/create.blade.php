@extends('backpack::layout')

@section('after_styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('header')
   <section class="content-header">
     <h1>
       Añadir <span class="text-lowercase">Seguimiento de Factura</span>
     </h1>
     <ol class="breadcrumb">
       <li><a href="{{ url('dashboard') }}">Admin</a></li>
       <li><a href="{{ url('seguimiento/facturacion') }}" class="text-capitalize">Seguimiento de Factura</a></li>
       <li class="active">A&ntilde;adir</li>
     </ol>
   </section>
@endsection   

@section('content')
<div class="row">
   <div class="col-md-8 col-md-offset-2">
      <!-- Default box -->
      <a href="{{ url('seguimiento/facturacion') }}"><i class="fa fa-angle-double-left"></i> Volver al listado de <span class="text-lowercase">Seguimiento de Factura</span></a><br><br>
      <form method="POST" action="{{ url('seguimiento/facturacion') }}" accept-charset="UTF-8">
         <input name="_token" type="hidden" value="{{ csrf_token() }}">
         <div class="box">
            <div class="box-header with-border">
               <h3 class="box-title">Añadir  Seguimiento de Factura</h3>
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
                  <label>Empresa</label>
                  <select name="empresa_id" class="form-control empresa">
                     <option>---------</option>
                     @foreach($empresas as $item)
                     <option value="{{$item->id}}">{{$item->nombre}}</option>
                     @endforeach
                  </select>
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}" class="form-control">
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>Movimiento</label>
                  <input type="text" name="movimiento" value="" class="form-control">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>Fecha de Pago</label>
                   <div class="input-group date" data-provide="datepicker">
                       <input type="text" class="form-control" readonly="readonly" value="{{ date('m-d-Y') }}" name="fecha_pago" id="dp">
                       <div class="input-group-addon">
                           <span class="glyphicon glyphicon-th"></span>
                       </div>
                   </div> 
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>Folio</label>
                  <input type="text" name="folio" value="" class="form-control">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>Factura</label>
                  <input type="text" name="factura" value="" class="form-control">
               </div>


               <div class="form-group col-md-12">
                  <label>Proveedores</label>
                  <select name="proveedores" id="proveedores" class="form-control" promotor="0">
                     <option>---------</option>
                     @foreach($proveedor as $item)
                     <option value="{{$item->id}}">{{$item->nombre}}</option>
                     @endforeach
                  </select>
               </div>  

               <div class="form-group col-md-12">
                  <label>Cantidad</label>
                  <input type="text" name="cantidad" value="" onkeypress="return CurrencyFormat(value, id, event);" class="form-control">
               </div>

               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>Fecha Emisi&oacute;n</label>
                     <div class="input-group date" data-provide="datepicker">
                       <input type="text" class="form-control" readonly="readonly" value="{{ date('m-d-Y') }}" name="fecha_emision" id="dp">
                       <div class="input-group-addon">
                           <span class="glyphicon glyphicon-th"></span>
                       </div>
                     </div>
               </div>

               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12 cliente_promotor">
                  <label>Cliente Promotor</label>
                  <select name="cliente_promotor" id="cliente_promotor" promotor="1" class="form-control cliente">
                  </select>
               </div>  

               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>RFC del Cliente</label>
                  <input type="text" name="rfc" value="" class="form-control">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12">
                  <label>Domicilio</label>
                  <textarea name="domicilio" class="form-control"></textarea>
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- textarea -->
               <div class="form-group col-md-12">
                  <label>Concepto</label>
                  <textarea name="concepto" class="form-control"></textarea>
               </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
               <div id="saveActions" class="form-group">
                  <input type="hidden" name="save_action" value="save_and_back">
                  <div class="btn-group">
                     <button type="submit" class="btn btn-success">
                     <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                     <span data-value="save_and_back">Guardar y regresar</span>
                     </button>
                     <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false">
                     <span class="caret"></span>
                     <span class="sr-only">Toggle Save Dropdown</span>
                     </button>
                     <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" data-value="save_and_edit">Guardar y continuar editando</a></li>
                        <li><a href="javascript:void(0);" data-value="save_and_new">Guardar y crear nuevo</a></li>
                     </ul>
                  </div>
                  <a href="http://cdigital.facturacion.dev:81/seguimiento/facturacion" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancelar</a>
               </div>
            </div>
            <!-- /.box-footer-->
         </div>
         <!-- /.box -->
      </form>
   </div>
</div>
@endsection

@section('after_scripts')
    <link rel="stylesheet" href="/js/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cliente_promotor').select2();

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

            $('.datepicker').datepicker();
        });
        function number_format (number, decimals, decPoint, thousandsSep) { 
          number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
          var n = !isFinite(+number) ? 0 : +number
          var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
          var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
          var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
          var s = ''
          var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
              .toFixed(prec)
          }
          // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
          if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
          }
          if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
          }
          return s.join(dec)
        }        
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