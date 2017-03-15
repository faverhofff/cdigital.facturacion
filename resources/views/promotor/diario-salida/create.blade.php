@extends('backpack::layout')

@section('after_styles')
  <style type="text/css">
    .r-input {
      text-align: right;
    }
  </style>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Añadir <span class="text-lowercase">registro al Diario de Salida</span>
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{ url('dashboard') }}">Admin</a></li>
      <li><a href="{{ url('admin/diariosalida') }}" class="text-capitalize">Diario de Salida</a></li>
      <li class="active">Añadir</li>
   </ol>
</section>
@endsection
@section('content')
<div class="row">
   <div class="col-md-8 col-md-offset-2">
      <!-- Default box -->
      <a href="{{ url('/diario/salida/index ')}}"><i class="fa fa-angle-double-left"></i> Volver al listado de <span class="text-lowercase">diario_salidas</span></a><br><br>
      <form method="POST" action="{{ url('/diario/salida/index') }}" accept-charset="UTF-8">
         <input name="_token" type="hidden" value="{{ csrf_token() }}">
         <div class="box">
            <div class="box-header with-border">
               <h3 class="box-title">Añadir Diario de Salida</h3>
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
               <!-- text input -->
               <div class="form-group col-md-6" style="display: none;" >
                <label>Fecha Dep&oacute;sito</label>
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" class="form-control" readonly="readonly" value="{{ date('m-d-Y') }}" name="fecha_depo" id="dp">
                    <div class="input-group-addon">
                        <span class="glyphicon glyphicon-th"></span>
                    </div>
                </div>   
               </div> 
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>Movimiento</label>
                  <input type="text" name="movimiento" value="{{ old('movimiento') }}" onkeypress="return CurrencyFormat(value, id, event);" class="form-control">
               </div>     
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>Factura</label>
                  <input type="text" name="factura" value="{{ old('factura') }}" class="form-control">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6 cliente_promotor">
                  <label>Cliente Promotor</label>
                  <select name="cliente_promotor" id="cliente_promotor" promotor="1" class="form-control cliente">
                  </select>
               </div>  

               <div class="form-group col-md-6 cliente">
                  <label>Cliente</label>
                  <select name="cliente" id="cliente" class="form-control" promotor="0">
                  </select>
               </div>                 
                              
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
                  <div class="form-group col-md-6">
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
               <div class="form-group col-md-6">
                  <label>Dep&oacute;sito</label>
                  <input type="text" name="deposito" value=""  autocomplete="off" placeholder="0.00" onkeypress="return CurrencyFormat(value, id, event);" class="total form-control r-input">
               </div>                  
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>Subtotal</label>
                  <input type="text" name="subtotal" value="0.00" class="form-control subtotal r-input" readonly="readonly">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.CTE</label>
                  <input type="text" name="regcte" readonly="readonly" class="form-control regcte r-input" readonly="readonly">
               </div>   
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.PROV</label>
                  <input type="text" name="regprov" value="" class="form-control regprov r-input" readonly="readonly">
               </div>  
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.CTE percent</label>
                  <input type="text" name="regctep" value="13" class="form-control regctep r-input percent" onkeypress="return CurrencyFormat(value, id, event);" >
               </div>   
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.PROV percent</label>
                  <input type="text" name="regprovp" value="13.5" class="form-control regprovp r-input percent" onkeypress="return CurrencyFormat(value, id, event);" >
               </div>                
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>COMP.DESP</label>
                  <input type="text" name="compdesp" value="0.00" class="form-control compdesp r-input" readonly="readonly">
               </div>                                                     
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>SOFOM</label>
                  <input type="text" name="sofom" value="" class="form-control" >
               </div>

               <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">


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
                     <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false" aria-expanded="false">
                     <span class="caret"></span>
                     <span class="sr-only">Toggle Save Dropdown</span>
                     </button>
                     <ul class="dropdown-menu">
                        <li><a href="javascript:void(0);" data-value="save_and_edit">Guardar y continuar editando</a></li>
                        <li><a href="javascript:void(0);" data-value="save_and_new">Guardar y crear nuevo</a></li>
                     </ul>
                  </div>
                  <a href="{{ url('diario/salida/index') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Cancelar</a>
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

            $('.datepicker').datepicker();
            $('.total').keydown(function(){
                $('.subtotal').val( number_format($(this).val()/1.16, 2) );
                $('.regcte').val( number_format( (($(this).val()/1.16)*($('.regctep').val()/100))+($(this).val()/1.16), 2) );
                $('.regprov').val( number_format( (($(this).val()/1.16)*($('.regprovp').val()/100))+($(this).val()/1.16), 2) );
                var a=(($(this).val()/1.16)*($('.regprovp').val()/100))+($(this).val()/1.16);
                var b=(($(this).val()/1.16)*($('.regctep').val()/100))+($(this).val()/1.16);
                $('.compdesp').val( number_format(  a-b ,2) );
            });
            $('.percent').keydown(function(){
              $('.total').keydown();
            })
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