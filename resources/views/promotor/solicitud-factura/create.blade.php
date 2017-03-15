@extends('backpack::layout')

@section('before_styles')
<style type="text/css">
   .data thead tr td {
      text-align: center;
   }
   table.data tr:nth-child(even) {
    font-weight: bold;
   }
   textarea {
      resize: none;
      height: 100px;
   }
   .subtotal,.iva,.total {
      text-align: right;
   }
</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Add <span class="text-lowercase">Solicitud Factura</span>
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{ url('dashboard') }}">Admin</a></li>
      <li><a href="{{ url('solicitud/factura') }}" class="text-capitalize">Solicitud Factura</a></li>
      <li class="active">Add</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <!-- Default box -->
         <a href="{{ url('solicitud/factura') }}"><i class="fa fa-angle-double-left"></i> Regresar  <span class="text-lowercase">Solicitud Factura</span></a><br><br>
         {!! Form::open(['url' => url('solicitud/factura'), 'method' => 'post' ]) !!}
            {!! Form::hidden('user_id', \Auth::user()->id) !!}
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Agregar nueva Solicitud de Factura</h3>

                  <a href="#" class="btn btn-primary ladda-button" data-toggle="modal" data-target="#upload"><span class="ladda-label"><i class="fa fa-plus"></i>Importar desde Excel</span></a>                  

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

                  <div class="form-group col-md-6">
                     <label>Folio</label>
                     <input type="text" name="folio" value="{{ old('folio') }}" class="form-control">
                  </div>

                  <div class="form-group col-md-6">
                     <label>Empresa</label>
                     <select name="empresa_id" class="form-control empresa">
                        <option>---------</option>
                        @foreach($empresas as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                     </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label>Fecha Emis&oacute;n</label>
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" class="form-control" readonly="readonly" id="dp">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div> 
                  </div>  

                  <div class="form-group col-md-12">
                     <TABLE class="table table-condensed data">
                        <tbody>
                           <tr style="display: none;"></tr>
                           <tr><td>RAZON SOCIAL</td><td>RFCL</td></tr>
                           <tr><td class="razon"></td><td class="rfcl"></td></tr>
                           <tr><td>CALLE</td><td>N&Uacute;MERO EXTERIOR</td></tr>
                           <tr><td class="calle"></td><td class="n_exterior"></td></tr>
                           <tr><td>N&Uacute;MERO INTERIOR</td><td>COLONIA</td></tr>
                           <tr><td class="n_interior"></td><td class="colonia"></td></tr>
                           <tr><td>ESTADO</td><td>CIUDAD</td></tr>
                           <tr><td class="estado"></td><td class="ciudad"></td></tr>
                           <tr><td>MUNICIPIO</td><td>DELEGACI&Oacute;N</td></tr>
                           <tr><td class="municipio"></td><td class="delegacion"></td></tr>
                           <tr><td>CP</td><td>CORREO ELECTR&Oacute;NICO (1)</td></tr>
                           <tr><td class="cp"></td><td class="correo_1"></td></tr>
                           <tr><td>CORREO ELECTR&Oacute;NICO (2)</td><td>CORREO ELECTR&Oacute;NICO (3)</td></tr>
                           <tr><td class="correo_2"></td><td class="correo_3"></td></tr>
                        </tbody>
                     </TABLE>  
                  </div> 

                  <div class="form-group col-md-12">
                     <TABLE class="table table-condensed">
                        <thead>
                           <tr>
                              <td>CANTIDAD</td>
                              <td>DESCRIPCION</td>
                              <td>UNIDAD</td>
                              <td>P.UNITARIO</td>
                              <td>IMPORTE</td>
                           </tr>
                        </thead>
                        <tbody id="facturas">
                        </tbody>
                     </TABLE>  
                     <input type="button" id="addRow" value="Agregar" >
                  </div> 

                  <div class="form-group col-md-4">
                     <label>SUBTOTAL</label>
                     <input type="text" name="subtotal" value="0.00" class="form-control subtotal" readonly="readonly">
                  </div>
                  <div class="form-group col-md-4">
                     <label>IVA</label>
                     <input type="text" name="iva" value="0.00" class="form-control iva" readonly="readonly">
                  </div>
                  <div class="form-group col-md-4">
                     <label>TOTAL</label>
                     <input type="text" name="total" value="0.00" class="form-control total" readonly="readonly">
                  </div>

                  <div class="form-group col-md-12">
                     <label>RESUMEN</label>
                     <textarea class="form-control" name="resumen">{{ old('resumen') }}</textarea>
                  </div>


                  <div class="form-group col-md-4">
                     <label>FORMA DE PAGO:</label>
                     <select name="forma_pago" class="form-control">
                        <option value="1">PAGO EN UNA SOLA EXHIBICION</option>
                        <option value="2">PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)</option>
                        <option value="3">PAGO EN PARCIAIDADES</option>
                     </select>
                  </div>

                  <div class="form-group col-md-4">
                     <label>M&Eacute;TODO DE PAGO:</label>
                     <select name="metodo_pago" class="form-control">
                        <option value="1">NO IDENTIFICADO</option>
                        <option value="2">CHEQUE</option>
                        <option value="3">TRANSFERENCIA ELECTRONICA</option>
                        <option value="4">TARJETA</option>
                     </select>
                  </div>

                  <div class="form-group col-md-4">
                     <label>4 &Uacute;LTIMOS D&Iacute;GITOS</label>
                     <input type="text" name="digito" value="{{ old('digito') }}" class="form-control" maxlength="4">
                  </div>


               </div>


               <!-- /.box-body -->
               |
               <div class="box-footer">
                  <div class="form-group">
                     <span>Desoues de guardar:</span>
                     <div class="radio">
                        <label>
                        <input type="radio" name="redirect_after_save" value="solicitud/factura" >
                        ir a la vista inicial
                        </label>
                     </div>
                     <div class="radio">
                        <label>
                        <input type="radio" name="redirect_after_save" value="solicitud/factura/create" checked="">
                        agregar otra solicitud
                        </label>
                     </div>

                  </div>
                  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Almacenar solicitud</span></button>
                  <a href="{{ url('solicitud/factura') }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancelar</span></a>
               </div>
               
               <!-- /.box-footer-->
            </div>
         {!! Form::close() !!}
         <!-- /.box -->
      </div>
   </div>
</section>
<!-- /.content -->
</div>

<!-- Modal -->
<div id="upload" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Importar Solicitudes desde Excel</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(array('url'=>'solicitud/factura/import','method'=>'POST', 'files'=>true)) !!}
        {!! Form::file('excel[]', array('multiple'=>true)) !!}
        <div class="row" style="text-align: center;">
          {!! Form::submit('Enviar', array('class'=>'btn btn-default')) !!}
        </div>
        {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('after_scripts')
<link rel="stylesheet" href="/js/bootstrap-datepicker.min.css">
<script src="/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
        
   $(document).ready(function(){
      $('.datepicker').datepicker();
      $('#facts').click(function(){
        $('table').eq(1).find('tbody').html('');
        $('.subtotal').val('0.00');
        $('.iva').val('0.00');
        $('.total').val('0.00');
        if($('#facts:checked').length>0) {
          $('#factura_id').removeAttr('disabled');
          $('#addRow').hide();
          $('.factura').change();
       } else  {
        $('#factura_id').attr('disabled','disabled');$('#addRow').show();
       }
      }).on('keydown','.subtotal-din', function(){
          var total = new Number();
          $('.subtotal-din').each(function(a,b){
            total+=new Number($(b).val());
          });
          $('.subtotal').val( number_format(total,2) );
          $('.iva').val( number_format( total*1.16,2 ));
          $('.total').val( number_format( (total*1.16)+(total), 2) );
      });
      $('#addRow').click(function(){
        $('table').eq(1).find('tbody').append('<tr><td><input type="text" name="col1[]" size="10" onkeypress="return CurrencyFormat(value, id, event);" /></td><td><input type="text" name="col2[]" /></td><td><input type="text" name="col3[]" size="10" /></td><td><input type="text" name="col4[]" size="10" onkeypress="return CurrencyFormat(value, id, event);"/></td><td><input type="text" name="col5[]" size="10" onkeypress="return CurrencyFormat(value, id, event);" onkeyup="var total = new Number();$(\'.subtotal-din\').each(function(a,b){ total+=new Number($(b).val());});$(\'.subtotal\').val( number_format(total,2) );$(\'.iva\').val( number_format( total*1.16,2 ));$(\'.total\').val( number_format( (total*1.16)+(total), 2) );" class="subtotal-din" style="text-align: right;" /></td></tr>')
      })
      $('#facts').click();
            
            
      $('.empresa').change(function(){
         // $('#facturas').find('tr').remove();
         // $('.subtotal').val('0.00');
         // $('.iva').val('0.00');
         // $('.total').val('0.00');
         // $('.factura').find('option').remove();

         if($(this).val()==0) {
            $('.razon').html('');
            $('.rfcl').html('');
            $('.calle').html('');
            $('.colonia').html('');
            $('.estado').html('');
            $('.ciudad').html('');
            $('.municipio').html('');
            $('.delegacion').html('');
            $('.cp').html('');
            $('.correo_1').html('');
            $('.correo_2').html('');
            $('.correo_3').html('');
            $('.n_exterior').html('');
            $('.n_interior').html('');
         }
         
         $.ajax({
           url: "/get/empresa/"+$(this).val(),
         }).done(function(json) {
            json = JSON.parse(json);
            $('.razon').html(json.razon);
            $('.rfcl').html(json.rfc);
            $('.calle').html(json.calle);
            $('.colonia').html(json.colonia);
            $('.estado').html(json.estado);
            $('.ciudad').html(json.ciudad);
            $('.municipio').html(json.municipio);
            $('.delegacion').html(json.delegacion);
            $('.cp').html(json.cp);
            $('.correo_1').html(json.correo_1);
            $('.correo_2').html(json.correo_2);
            $('.correo_3').html(json.correo_3);
            $('.n_exterior').html(json.noExterior);
            $('.n_interior').html(json.noInterior);           
         }); 
      });
   })

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