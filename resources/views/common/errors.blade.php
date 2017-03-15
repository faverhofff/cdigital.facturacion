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