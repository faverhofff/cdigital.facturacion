@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::crud.edit') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'),'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">{{ trans('backpack::crud.edit') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            @if ($crud->hasAccess('list'))
                <a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
            @endif

            @include('crud::inc.grouped_errors')

            {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put', 'files'=>$crud->hasUploadFields('update', $entry->getKey()))) !!}
            <div class="box">
                <div class="box-header with-border">
                @if ($crud->model->translationEnabled())
                    <!-- Single button -->
                        <div class="btn-group pull-right">
                            <button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Language: {{ $crud->model->getAvailableLocales()[$crud->request->input('locale')?$crud->request->input('locale'):App::getLocale()] }} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                                    <li><a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}?locale={{ $key }}">{{ $locale }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <h3 class="box-title" style="line-height: 30px;">{{ trans('backpack::crud.edit') }}</h3>
                    @else
                        <h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
                    @endif
                </div>
                <div class="box-body row">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>1000</label>
                        <input type="text" name="v1000" value="{{$entry->v1000}}" class="form-control">
                    </div>
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>500</label>
                        <input type="text" name="v500" value="{{$entry->v500}}" class="form-control">
                    </div>
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>200</label>
                        <input type="text" name="v200" value="{{$entry->v200}}" class="form-control">
                    </div>


                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>100</label>
                        <input type="text" name="v100" value="{{$entry->v100}}" class="form-control">
                    </div>

                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>50</label>
                        <input type="text" name="v50" value="{{$entry->v50}}" class="form-control">
                    </div>


                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>20</label>
                        <input type="text" name="v20" value="{{$entry->v20}}" class="form-control">
                    </div>

                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>10</label>
                        <input type="text" name="v10" value="{{$entry->v10}}" class="form-control">
                    </div>

                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>5</label>
                        <input type="text" name="v5" value="{{$entry->v5}}" class="form-control">
                    </div>

                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>2</label>
                        <input type="text" name="v2" value="{{$entry->v2}}" class="form-control">
                    </div>

                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- text input -->
                    <div class="form-group col-md-12">
                        <label>1</label>
                        <input type="text" name="v1" value="{{$entry->v1}}" class="form-control">
                    </div>

                    <input type="hidden" name="historico_deposito" value="{{$entry->historico_deposito}}" class="form-control">


                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    <!-- hidden input -->
                    <div class="form-group col-md-12">
                        <input type="hidden" name="id" value="7" class="form-control">
                    </div>

                </div>

                <div class="box-footer">

                    @include('crud::inc.form_save_buttons')

                </div><!-- /.box-footer-->
            </div><!-- /.box -->
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/backpack/crud/css/edit.css') }}">
@endsection

@section('after_scripts')
    <script src="{{ asset('vendor/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('vendor/backpack/crud/js/edit.js') }}"></script>
@endsection