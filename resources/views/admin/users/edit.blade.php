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

		  {!! Form::open(array('url' => $crud->route.'/'.$entry->getKey(), 'method' => 'put', 'files'=>$crud->hasUploadFields('update', $entry->getKey()))) !!}
		  <div class="box">
		    <div class="box-header with-border">
		      <h3 class="box-title">{{ trans('backpack::crud.edit') }}</h3>
		    </div>
		    <div class="box-body row">
		      <!-- load the view from the application if it exists, otherwise load the one in the package -->
		      @if(view()->exists('vendor.backpack.crud.form_content'))
		      	@include('vendor.backpack.crud.form_content')
		      @else
					@if ($crud->model->translationEnabled())
						<input type="hidden" name="locale" value={{ $crud->request->input('locale')?$crud->request->input('locale'):App::getLocale() }}>
					@endif

					{{-- See if we're using tabs --}}
					@if ($crud->tabsEnabled())
						@include('crud::inc.show_tabbed_fields')
					@else
						@include('crud::inc.show_fields', ['fields' => $fields])
					@endif

					{{-- Define blade stacks so css and js can be pushed from the fields to these sections. --}}

				@section('after_styles')
				<!-- CRUD FORM CONTENT - crud_fields_styles stack -->
					@stack('crud_fields_styles')
				@endsection

				@section('after_scripts')
				<!-- CRUD FORM CONTENT - crud_fields_scripts stack -->
					@stack('crud_fields_scripts')

					<script>
						jQuery('document').ready(function($){

							// Save button has multiple actions: save and exit, save and edit, save and new
							var saveActions = $('#saveActions'),
									crudForm        = saveActions.parents('form'),
									saveActionField = $('[name="save_action"]');

							saveActions.on('click', '.dropdown-menu a', function(){
								var saveAction = $(this).data('value');
								saveActionField.val( saveAction );
								crudForm.submit();
							});

							// Ctrl+S and Cmd+S trigger Save button click
							$(document).keydown(function(e) {
								if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey))
								{
									e.preventDefault();
									// alert("Ctrl-s pressed");
									$("button[type=submit]").trigger('click');
									return false;
								}
								return true;
							});

							// Place the focus on the first element in the form
							@if( $crud->autoFocusOnFirstField )
									@php
										$focusField = array_first($fields, function($field) {
                                            return isset($field['auto_focus']) && $field['auto_focus'] == true;
                                        });
									@endphp

									@if ($focusField)
									window.focusField = $('[name="{{ $focusField['name'] }}"]').eq(0),
									@else
							var focusField = $('form').find('input, textarea, select').not('[type="hidden"]').eq(0),
									@endif

									fieldOffset = focusField.offset().top,
									scrollTolerance = $(window).height() / 2;

							focusField.trigger('focus');

							if( fieldOffset > scrollTolerance ){
								$('html, body').animate({scrollTop: (fieldOffset - 30)});
							}
							@endif

							// Add inline errors to the DOM
							@if ($crud->inlineErrorsEnabled() && $errors->any())

									window.errors = {!! json_encode($errors->messages()) !!};
							// console.error(window.errors);

							$.each(errors, function(property, messages){

								var field = $('[name="' + property + '"]'),
										container = field.parents('.form-group');

								container.addClass('has-error');

								$.each(messages, function(key, msg){
									// highlight the input that errored
									var row = $('<div class="help-block">' + msg + '</div>');
									row.appendTo(container);

									// highlight its parent tab
											@if ($crud->tabsEnabled())
									var tab_id = $(container).parent().attr('id');
									$("#form_tabs [aria-controls="+tab_id+"]").addClass('text-red');
									@endif
								});
							});

							@endif

							$('[name="roles_show[]"]').attr('type', 'radio');

							$('div.col-sm-4:nth-child(3n)').css('clear', 'both');

						});
					</script>
				@endsection

				@endif
		    </div><!-- /.box-body -->
		    <div class="box-footer">

			  <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.save') }}</span></button>
		      <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
		    </div><!-- /.box-footer-->
		  </div><!-- /.box -->
		  {!! Form::close() !!}
	</div>
</div>
@endsection

@section('before_styles')
	<style type="text/css">
		.checklist_dependency .row:nth-child(4), .checklist_dependency > label{
			display: none !important;
		}
	</style>
@endsection
