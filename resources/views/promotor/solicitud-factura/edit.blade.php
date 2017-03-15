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
<?php $total = 0; ?>
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      <span class="text-lowercase">Solicitud Factura</span>
   </h1>
   <ol class="breadcrumb">
      <li><a href="{{ url('dashboard') }}">Admin</a></li>
      <li><a href="{{ url('solicitud/factura') }}" class="text-capitalize">Solicitud Factura</a></li>
      <li class="active">Editar</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <!-- Default box -->
         <a href="{{ url('solicitud/factura')}}"><i class="fa fa-angle-double-left"></i> Regresar  <span class="text-lowercase">Solicitud Factura</span></a><br><br>
         {!! Form::open(['url' => url('solicitud/factura/'.$data->id), 'method' => 'post', 'accept-charset' => 'UTF-8' ]) !!}
            {!! Form::hidden('user_id', \Auth::user()->id) !!}
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Vista Solicitud Factura #{{ $data->folio }}</h3>
               </div>
               <div class="box-body row">

                  @if (count($errors) > 0)
                      <div class="alert alert-danger">
                          <ul>
                              @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                              @endforeach
                          </ul>
                      </div>
                  @endif               

                  <div class="form-group col-md-6">
                     <label>Folio</label>
                     <input type="text" name="folio" value="{{ $data->folio }}" class="form-control" readonly="readonly" />
                  </div>

                  <div class="form-group col-md-6">
                     <label>Empresa</label>
                     <input type="text" name="empresa" value="{{ $data->getEmpresaName() }}" class="form-control" readonly="readonly" />
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
                           <tr>
                              <td class="razon">{{ $data->getRazon() }}</td>
                              <td class="rfcl">{{ $data->getRFCL() }}</td>
                           </tr>
                           
                           <tr><td>CALLE</td><td>N&Uacute;MERO EXTERIOR</td></tr>
                           <tr>
                              <td class="calle">{{ $data->getCalle() }}</td>
                              <td class="rfcl">{{ $data->getNExterior() }}</td><
                           </tr>

                           <tr><td>N&Uacute;MERO INTERIOR</td><td>COLONIA</td></tr>
                           <tr>
                              <td class="n_interior">{{ $data->getNInterior() }}</td>
                              <td class="colonia">{{ $data->getColonia() }}</td>
                           </tr>

                           <tr><td>ESTADO</td><td>CIUDAD</td></tr>
                           <tr>
                              <td class="estado">{{ $data->getEstado() }}</td>
                              <td class="ciudad">{{ $data->getCiudad() }}</td>
                           </tr>

                           <tr><td>MUNICIPIO</td><td>DELEGACI&Oacute;N</td></tr>
                           <tr>
                              <td class="municipio">{{ $data->getMunicipio() }}</td>
                              <td class="delegacion">{{ $data->getDelegacion() }}</td>
                           </tr>
                           
                           <tr><td>CP</td><td>CORREO ELECTR&Oacute;NICO (1)</td></tr>
                           <tr>
                              <td class="cp">{{ $data->getCP() }}</td>
                              <td class="correo_1">{{ $data->getCorreo1() }}</td>
                           </tr>

                           <tr><td>CORREO ELECTR&Oacute;NICO (2)</td><td>CORREO ELECTR&Oacute;NICO (3)</td></tr>
                           <tr>
                              <td class="correo_2">{{ $data->getCorreo2() }}</td>
                              <td class="correo_3">{{ $data->getCorreo3() }}</td>
                           </tr>
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
                           @foreach(\App\Models\ConceptoVirtual::where('solfactura',$data->id)->get()->toArray() as $conceptos)
                           <tr>
                              <td>{{ $conceptos['cantidad'] }}</td>
                              <td>{{ $conceptos['descripcion'] }}</td>
                              <td>{{ $conceptos['unidad'] }}</td>
                              <td>{{ $conceptos['valorUnitario'] }}</td>
                              <td style="text-align:right">{{ number_format($conceptos['importe'], 2) }}</td>
                              <?php $total+=$conceptos['importe']; ?>
                           </tr>
                           @endforeach
                        </tbody>
                     </TABLE>  
                  </div> 

                  <div class="form-group col-md-4">
                     <label>SUBTOTAL</label>
                     <input type="text" name="subtotal" value="{{ number_format($total , 2 ) }}" class="form-control subtotal" readonly="readonly">
                  </div>
                  <div class="form-group col-md-4">
                     <label>IVA</label>
                     <input type="text" name="iva" value="{{ number_format( $total*1.16, 2) }}" class="form-control iva" readonly="readonly">
                  </div>
                  <div class="form-group col-md-4">
                     <label>TOTAL</label>
                     <input type="text" name="total" value="{{ number_format( ($total*1.16)+$total, 2) }}" class="form-control total" readonly="readonly">
                  </div>

                  <div class="form-group col-md-12">
                     <label>RESUMEN</label>
                     <textarea class="form-control" name="resumen" readonly="readonly">{{ $data->resumen }}</textarea>
                  </div>


                  <div class="form-group col-md-4">
                     <label>FORMA DE PAGO:</label>
                     <select name="forma-pago" class="form-control" disabled="disabled">
                        <option value="1" @if($data->forma_pago==1) selected="selected" @endif>PAGO EN UNA SOLA EXHIBICION</option>
                        <option value="2" @if($data->forma_pago==2) selected="selected" @endif>PAGO DE PARCIALIDAD (Ejemplo 1/3 - 2/3 - 3/3)</option>
                        <option value="3" @if($data->forma_pago==3) selected="selected" @endif>PAGO EN PARCIAIDADES</option>
                     </select>
                  </div>

                  <div class="form-group col-md-4" >
                     <label>M&Eacute;TODO DE PAGO:</label>
                     <select name="metodo-pago" class="form-control" disabled="disabled">
                        <option value="1" @if($data->metodo_pago==1) selected="selected" @endif>NO IDENTIFICADO</option>
                        <option value="2" @if($data->metodo_pago==2) selected="selected" @endif>CHEQUE</option>
                        <option value="3" @if($data->metodo_pago==3) selected="selected" @endif>TRANSFERENCIA ELECTRONICA</option>
                        <option value="4" @if($data->metodo_pago==4) selected="selected" @endif>TARJETA</option>
                     </select>
                  </div>

                  <div class="form-group col-md-4">
                     <label>4 &Uacute;LTIMOS D&Iacute;GITOS</label>
                     <input type="text" name="digito" value="{{ $data->digito }}" class="form-control" maxlength="4" disabled="disabled">
                  </div>


               </div>


               <!-- /.box-body -->
               <!-- 
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
                     <div class="radio">
                        <label>
                        <input type="radio" name="redirect_after_save" value="current_item_edit">
                        edit the new item
                        </label>
                     </div> -->
                  </div>
                  <!-- <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> Almacenar solicitud</span></button> -->
                  <a href="{{ url('solicitud/factura') }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Regresar</span></a>
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
@endsection

@section('after_scripts')

@endsection