@extends('backpack::layout')

@section('after_styles')
    <style type="text/css">
        .right {text-align: right;}
        .center, th {text-align: center;}
        .v-center {vertical-align: middle !important;}
        .add,.mov { 
            padding: 0px 5px 0px 5px; 
            margin-top: -4px;
        }
    </style>
    <link rel="stylesheet" href="{{ url('css/jquery.dataTables.min.css' ) }}">
@endsection

@section('header')
    <section class="content-header">
        <h1>
            Diario de Salida
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
                            <th style="width:50px;">#</th>
                            <th>FACT</th>
                            <th>CTE</th>
                            <th>EMPRESA</th>
                            <th>DEP&Oacute;SITO | SUBTOTAL</th>
                            <th>REG.CTE</th>
                            <th>REG.PROV</th>
                            <th>COM.DESP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitudes->get() as $item)
                        <tr>
                            <td class="v-center"><input type="text" name="movimiento" key="{{ $item->id }}" class="mov" size="10" value="{{ $item->movimiento }}" /></td>
                            <td class="v-center">{{ $item->factura }}</td>
                            <td class="v-center">{{ $item->cliente }}</td>
                            <td class="v-center">{{ $item->empresaReal->nombre }}</td>
                            <td class="v-center">
                                <div class="col-md-6">
                                    <input type="text" key="{{ $item->id }}" maxlength="12" size="10" onkeypress="return CurrencyFormat(value, id, event);" class="right deposit" value="{{ $item->deposito, 2 }}" > 
                                </div>
                                <div class="col-md-6 col-lg-6 col-xs-6 right">
                                    {{ number_format($item->deposito/1.16, 2) }} $
                                </div>
                            </td>
                            <td class="center">
                                <div>{{ ( (($item->percent ? explode(',', $item->percent)[0] : 1) / 100) * ($item->deposito * 1.16) ) + ($item->deposito * 1.16) }}</div>
                                <input type="text" size="5" class="right percent" key="{{ $item->id }}" value="{{ $item->percent ? explode(',', $item->percent)[0] : 1 }}" onkeypress="return CurrencyFormat(value, id, event);" > %
                            </td>
                            <td class="center">
                                <div>{{ ( (($item->percent ? explode(',', $item->percent)[1] : 1) / 100) * ($item->deposito * 1.16) ) + ($item->deposito * 1.16) }}</div>
                                <input type="text" size="5" class="right percent" key="{{ $item->id }}" value="{{ $item->percent ? explode(',', $item->percent)[1] : 1 }}" onkeypress="return CurrencyFormat(value, id, event);" > %
                            </td>
                            <td class="center v-center">
                                <div>{{ number_format(( ( ($item->regprov / 100) * ($item->deposito * 1.16) ) + ($item->deposito * 1.16) ) - ( ( ($item->regcte / 100) * ($item->deposito * 1.16) ) + ($item->deposito * 1.16) ), 2) }}</div>
    
                            </td> 
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
            $(":input.percent").each(function(a,b){
                percent(b,false);            
            });
        });
        $(document).ready(function(){

            $('.lista').DataTable();

            $('.deposit').keydown(function(event){
                $(this).parent().parent().find('div').eq(1).html(
                    number_format ($(this).val()/1.16, 2) + ' $'
                );
                if($(this).parent().find('button').length==0)
                    $(this).parent().append('<button class="add btn btn-primary">Aceptar</button');

                $(this).parent().parent().parent().find(":input.percent").each(function(a,b){
                    percent(b,false);            
                });                
                event.stopPropagation();
            });
            $('.mov').keydown(function(event){
                if($(this).parent().find('button').length==0)
                    $(this).parent().append('<button class="mov btn btn-primary">Aceptar</button');
            });

            $(":input.percent").bind('keyup mouseup', function () {
                percent(this,true);
            });

        }).on('click','.add', function(){
            $.ajax({
              url: '{{ url('/diario/salida/set/deposito/') }}/'+$(this).parent().find('input').attr('key'),
              type: 'POST',
              data: 'value='+$(this).parent().find('input').val(),
              success: function(data) {
                $('[key='+data.id+']').parent().find('button').remove();
              },
              error: function(data) {
                $('[key='+data.id+']').parent().find('button').remove();
              }
            });            
        }).on('click','.mov', function(){
            $.ajax({
              url: '{{ url('/diario/salida/set/movimiento/') }}/'+$(this).parent().find('input').attr('key'),
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
        function percent(element, ajax) {
            var p = ($(element).val()/100);
            var s = $(element).parent().parent().find('.deposit').val() / 1.16;
            $(element).parent().find('div').html( number_format( ( p * s ) + s,2 ) );

            var a1 = new Number(new String($(element).parent().parent().find('div').eq(2).html()).replace(",", ""));
            var a2 = new Number(new String($(element).parent().parent().find('div').eq(3).html()).replace(",", ""));
            var A1 = new Number(new String($(element).parent().parent().find('td').eq(5).find('input').val()).replace(",", ""));
            var A2 = new Number(new String($(element).parent().parent().find('td').eq(6).find('input').val()).replace(",", ""));
            var A3 = new Number(new String($(element).parent().parent().find('td').eq(0).find('input').val()).replace(",", ""));
            $(element).parent().parent().find('td').eq(7).find('div').html(number_format(a2-a1, 2))   

            if ( ajax==true ) {
                $.ajax({
                  url: '{{ url('/diario/salida/set/percent/') }}/'+$(element).attr('key'),
                  type: 'POST',
                  data: {v1:A1,v2:A2,v3:A3},
                  success: function(data) {
                    
                  },
                  error: function(data) {
                    alert('error');
                  }
                });
            }
        }
    </script>
@stop