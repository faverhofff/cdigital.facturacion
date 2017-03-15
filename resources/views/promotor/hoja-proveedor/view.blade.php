@extends('backpack::layout')

@section('after_styles')
    <style type="text/css">
        .right {text-align: right;}
        .center, th {text-align: center;}
        .v-center {vertical-align: middle !important;}
        .add { 
            padding: 0px 5px 0px 5px; 
            margin-top: -4px;
        }
    </style>
    <link rel="stylesheet" href="{{ url('css/jquery.dataTables.min.css' ) }}">
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Hoja Proveedor
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

                <table class="table table-bordered lista">
                    <thead>
                        <tr>
                            <th style="width: 25px;">MOV</th>
                            <th>FECHA DEPO.</th>
                            <th>FACTURA</th>
                            <th>EMPRESA</th>
                            <th>TOTAL</th>
                            <th>SUBTOTAL</th>
                            <th>RECIBO</th>
                            <th>COM.MARGEN</th>
                            <th>INTERES</th>
                            <th>RECIBO REAL.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes->get() as $item)
                        <tr>
                            <td class="v-center">{{ $item->movimiento }}</td>
                            <td class="v-center" >{{ $item->fecha_depo }}</td>
                            <td class="v-center">{{ $item->cliente }}
                            </td>
                            <td class="v-center">{{ $item->empresaReal->nombre }}</td>
                            <td class="v-center">
                                {{ number_format($item->deposito,2) }}
                                <!-- <input type="text" key="{{ $item->id }}" maxlength="12" size="6" onkeypress="return CurrencyFormat(value, id, event);" class="right deposit" value="{{ $item->deposito }}" >  -->
                            </td>
                            <td class="v-center">
                                {{ $item->subtotal }} $
                            </td>
                            <td class="center">
                                <div id="rec">
                                    {{ number_format( ( ($item->deposito/1.16)* ($item->recibop == 0 ? 1 : $item->recibop/100 ) ) + ($item->deposito/1.16), 2 ) }}
                                </div>
                                <!-- {{ $item->recibo ? explode(',', $item->percent)[0] : 1 }} -->
                                @role(['Administrador de Área Solicitud de Facturas y Envío de Facturas','Administrador de Área Seguimiento de Facturas', 'Cliente'])
                                <input type="text" size="5" class="right percent" key="{{ $item->id }}" total="{{ $item->deposito }}" value="{{ $item->recibop > 0 ? $item->recibop : 100 }}" onkeypress="return CurrencyFormat(value, id, event);" > % 
                                @endrole
                            </td>
                            <td class="center v-center">
                                <div id="com1">
                                    {{  number_format($item->deposito-(( ($item->deposito/1.16)* ($item->recibop == 0 ? 1 : $item->recibop/100 ) ) + ($item->deposito/1.16)) , 2)  }}
                                </div>
                            </td>
                            <td class="center v-center">
                                @role(['Administrador de Área Solicitud de Facturas y Envío de Facturas','Administrador de Área Seguimiento de Facturas', 'Cliente'])
                                <input type="text" size="5" class="right interes" key="{{ $item->id }}" total="{{ $item->deposito }}" value="{{ $item->interes > 0 ? $item->interes : 0 }}" onkeypress="return CurrencyFormat(value, id, event);" > 
                                @endrole
                                
                                @role(['Administrador General'])
                                {{ $item->interes > 0 ? $item->interes : 0 }}
                                @endrole
                            </td> 
                            <td><div> {{ number_format( $item->interes + (( ($item->deposito/1.16)* ($item->recibop == 0 ? 1 : $item->recibop/100 ) ) + ($item->deposito/1.16)), 2) }}</div></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
    <link rel="stylesheet" href="/js/bootstrap-datepicker.min.css">
    <script src="/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            @role(['Administrador de Área Solicitud de Facturas y Envío de Facturas','Administrador de Área Seguimiento de Facturas', 'Cliente'])
            $(":input.percent, :input.interes").each(function(a,b){
                percent(b,false,true);            
            });
            @endrole
        });
        $(document).ready(function(){

            $('.lista').DataTable();

            $(":input.percent, :input.interes").bind('keyup mouseup', function () {
                percent(this,true);
            });

            $("[name=dp]").change(function () {
                $.ajax({
                  url: '{{ url('/hoja/proveedor/set/date/') }}/'+$(this).parent().find('input').attr('key'),
                  type: 'POST',
                  data: 'value='+$(this).parent().find('input').val(),
                  success: function(data) {
                    $('[key='+data.id+']').parent().find('button').remove();
                  },
                  error: function(data) {
                    $('[key='+data.id+']').parent().find('button').remove();
                  }
                });               
            });

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
        @role(['Administrador de Área Solicitud de Facturas y Envío de Facturas','Administrador de Área Seguimiento de Facturas', 'Cliente'])
        function percent(element, ajax, com) {
            var v = $(element).attr('total');
            var interes = 0;
            var d = 0; // %
            if ($(element).hasClass('percent')) {
                d = $(element).val();
                var t = ((v/1.16)*($(element).val()/100))+(v/1.16); // recibo
                interes = $(element).parent().parent().find('td').eq(8).find('input').val();
                $(element).parent().find('div').html( number_format(t,2) );
                $(element).parent().parent().find('td').eq(7).find('div').html( number_format(v-t,2)  );
                $(element).parent().parent().find('td').eq(9).find('div').html( number_format( interes - t, 2) );
            }
            if ($(element).hasClass('interes')) {
                var d = $(element).parent().parent().find('td').eq(6).find('input').val(); // recibo %
                var t = ((v/1.16)*(d/100))+(v/1.16); // recibo
                interes = $(element).parent().parent().find('td').eq(8).find('input').val();
                $(element).parent().parent().find('td').eq(9).find('div').html(  number_format( interes - t, 2) );
            }

            if ( ajax==true ) {
                $.ajax({
                  url: '{{ url('/hoja/proveedor/set/') }}/'+$(element).attr('key'),
                  type: 'POST',
                  data: {interes:interes,recibop: d},
                  success: function(data) {
                    
                  },
                  error: function(data) {
                    alert('error');
                  }
                });
            }
        }
        @endrole
    </script>
@stop