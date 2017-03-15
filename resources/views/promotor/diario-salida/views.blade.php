@extends('backpack::layout')

@section('after_styles')
  <style type="text/css">
    .r-input {
      text-align: right;
    }
  </style>
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
               <h3 class="box-title">Vista previa Diario de Salida</h3>
            </div>
            <div class="box-body row">
       
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-12" style="display: none;">
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
                  <input type="text" name="movimiento" value="{{ $data->movimiento }}" onkeypress="return CurrencyFormat(value, id, event);" class="form-control">
               </div>     
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>Factura</label>
                  <input type="text" name="factura" value="{{ $data->factura }}" class="form-control">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6 cliente_promotor">
                  <?php $data->load('cliente'); $data->load('clientePromotor'); ?>
                  <label>Cliente Promotor</label>
                  <input type="text" readonly="readonly" name="cliente_promotor" id="cliente_promotor" value="{{ $data->clientePromotor->nombre }}" promotor="1" class="form-control cliente">
               </div>  

               <div class="form-group col-md-6 cliente">
                  <label>Cliente</label>
                  <input type="text" readonly="readonly" name="cliente" id="cliente" value="{{ $data->cliente->nombre }}" class="form-control" promotor="0">
               </div>                  
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
                  <div class="form-group col-md-6">
                     <label>Empresa</label> 
                     <select name="empresa_id" class="form-control empresa">
                        <option>---------</option>
                        @foreach($empresas as $item)
                        <option value="{{$item->id}}" @if($item->empresa_id==$data->empresa_id) selected="selected" @endif>{{$item->nombre}}</option>
                        @endforeach
                     </select>
                  </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>Dep&oacute;sito</label>
                  <input type="text" name="deposito" value="{{ $data->deposito }}" placeholder="0.00" onkeypress="return CurrencyFormat(value, id, event);" class="total form-control r-input">
               </div>                  
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>Subtotal</label>
                  <input type="text" name="subtotal" value="{{ $data->subtotal }}" class="form-control subtotal r-input" readonly="readonly">
               </div>
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.CTE</label>
                  <input type="text" name="regcte" readonly="readonly" value="{{ $data->regcte }}" class="form-control regcte r-input" readonly="readonly">
               </div>   
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.PROV</label>
                  <input type="text" name="regprov" value="{{ $data->regprov }}" class="form-control regprov r-input" readonly="readonly">
               </div>  
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.CTE percent</label>
                  <input type="text" name="regctep" readonly="readonly" value="{{ $data->regctep }}" class="form-control regctep r-input" readonly="readonly">
               </div>   
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>REG.PROV percent</label>
                  <input type="text" name="regprovp" value="{{ $data->regprovp }}" class="form-control regprovp r-input" readonly="readonly">
               </div>                
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>COMP.DESP</label>
                  <input type="text" name="compdesp" value="{{ $data->compdesp }}" class="form-control compdesp r-input" readonly="readonly">
               </div>                                                     
               <!-- load the view from the application if it exists, otherwise load the one in the package -->
               <!-- text input -->
               <div class="form-group col-md-6">
                  <label>SOFOM</label>
                  <input type="text" name="sofom" value="{{ $data->sofom }}" class="form-control" >
               </div>

               <input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
               <div id="saveActions" class="form-group">
                  <input type="hidden" name="save_action" value="save_and_back">
                  <div class="btn-group">
                     <!--
                     <button type="submit" class="btn btn-success">
                     <span class="fa fa-save" role="presentation" aria-hidden="true"></span> &nbsp;
                     <span data-value="save_and_back">Guardar y regresar</span>
                     </button>
                     <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aira-expanded="false" aria-expanded="false">
                     <span class="caret"></span>
                     <span class="sr-only">Toggle Save Dropdown</span>
                     </button>
                     -->
                     <ul class="dropdown-menu">
                        <!-- <li><a href="javascript:void(0);" data-value="save_and_edit">Guardar y continuar editando</a></li> -->
                        <!-- <li><a href="javascript:void(0);" data-value="save_and_new">Guardar y crear nuevo</a></li> -->
                     </ul>
                  </div>
                  <a href="{{ url('diario/salida/index') }}" class="btn btn-default"><span class="fa fa-ban"></span> &nbsp;Regresar</a>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('input, select').attr('disabled','disabled');
            $('.total').keydown(function(){
                $('.subtotal').val( number_format($(this).val()/1.16, 2) );
                $('.regcte').val( number_format( (($(this).val()/1.16)*($('.regctep').val()/100))+($(this).val()/1.16), 2) );
                $('.regprov').val( number_format( (($(this).val()/1.16)*($('.regprovp').val()/100))+($(this).val()/1.16), 2) );
                var a=(($(this).val()/1.16)*($('.regprovp').val()/100))+($(this).val()/1.16);
                var b=(($(this).val()/1.16)*($('.regctep').val()/100))+($(this).val()/1.16);
                $('.compdesp').val( number_format(  a-b ,2) );
            });
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