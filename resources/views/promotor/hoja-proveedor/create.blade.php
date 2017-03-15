@extends('backpack::layout')

@section('header')
<!-- Content Header (Page header) -->
<section class="content-header">
   <h1>
      Añadir <span class="text-lowercase">a la Hoja del Proveedor</span>
   </h1>
   <ol class="breadcrumb">
      <li><a href="http://facturacion.dev:81/dashboard">Admin</a></li>
      <li><a href="http://facturacion.dev:81/hoja/proveedor" class="text-capitalize">hoja_proveedors</a></li>
      <li class="active">Añadir</li>
   </ol>
</section>
<!-- Main content -->
@endsection

@section('content')
   <div class="row">
      <div class="col-md-8 col-md-offset-2">
         <!-- Default box -->
         <a href="http://facturacion.dev:81/hoja/proveedor"><i class="fa fa-angle-double-left"></i> Volver al listado  <span class="text-lowercase">hoja_proveedors</span></a><br><br>
         <form method="POST" action="http://facturacion.dev:81/hoja/proveedor" accept-charset="UTF-8">
            <input name="_token" type="hidden" value="DfeANDHSY9AbK2hmLd08mMrjdxzf4lKji6MZ3ANt">
            <div class="box">
               <div class="box-header with-border">
                  <h3 class="box-title">Añadir nuevo  hojaproveedor</h3>
               </div>
               <div class="box-body row">
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- text input -->
                  <div class="form-group col-md-12">
                     <label>Nofactura</label>
                     <input type="text" name="nofactura" value="" class="form-control">
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- html5 date input -->
                  <div class="form-group col-md-12">
                     <label>Fechafactura</label>
                     <input type="date" name="fechafactura" value="" class="form-control">
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- text input -->
                  <div class="form-group col-md-12">
                     <label>Empresa_id</label>
                     <select name="empresa_id" class="form-control empresa">
                        <option value="0">---------</option>
                        @foreach($empresas as $item)
                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                        @endforeach
                     </select>
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- text input -->
                  <div class="form-group col-md-12">
                     <label>Total</label>
                     <input type="text" name="total" value="" class="form-control" onkeypress="return CurrencyFormat(value, id, event);">
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- text input -->
                  <div class="form-group col-md-12">
                     <label>Intereses</label>
                     <input type="text" name="intereses" value="" class="form-control" onkeypress="return CurrencyFormat(value, id, event);">
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- textarea -->
                  <div class="form-group col-md-12">
                     <label>Comentarios</label>
                     <textarea name="comentarios" class="form-control"></textarea>
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- text input -->
                  <div class="form-group col-md-12">
                     <label>Pendientes hoy</label>
                     <input type="text" name="pendientes_hoy" value="" class="form-control" onkeypress="return CurrencyFormat(value, id, event);">
                  </div>
                  <!-- load the view from the application if it exists, otherwise load the one in the package -->
                  <!-- text input -->
                  <div class="form-group col-md-12">
                     <label>Tu comisi&oacute;n</label>
                     <input type="text" name="tucomision" value="" class="form-control" onkeypress="return CurrencyFormat(value, id, event);">
                  </div>
               </div>
               <!-- /.box-body -->
               <div class="box-footer">
                  <div class="form-group">
                     <span>Después de guardar:</span>
                     <div class="radio">
                        <label>
                        <input type="radio" name="redirect_after_save" value="hoja/proveedor" checked="">
                        ir al listado
                        </label>
                     </div>
                     <div class="radio">
                        <label>
                        <input type="radio" name="redirect_after_save" value="hoja/proveedor/create">
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
                  <a href="http://facturacion.dev:81/hoja/proveedor" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">Cancelar</span></a>
               </div>
               <!-- /.box-footer-->
            </div>
         </form>
         <!-- /.box -->
      </div>
   </div>
@endsection

@section('after_scripts')
   <script type="text/javascript">
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