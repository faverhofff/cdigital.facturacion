{{-- Date Range Backpack CRUD filter --}}
{{-- Example Backpack CRUD filter --}}

<?php
//    dd( $filter);
?>

<li filter-name="{{ $filter->name }}"
    filter-type="{{ $filter->type }}"
    class="dropdown {{ Request::get($filter->name)?'active':'' }}">
    <a style="pointer-events: none; display: inline-block;" href="#" class="dropdown-toggle">Seleccione un rango</a>
    <input type="hidden" name="{{ $filter->name }}">
    <input type="datetime-local" id="custom_initdate" name="custom_initdate" value="<?php echo $filter->options['custom_initdate'] ?>T00:00" style="width: 150px;" />
    <input type="datetime-local" id="custom_enddate" name="custom_enddate" value="<?php echo $filter->options['custom_enddate'] ?>T00:00" style="width: 150px;" />
    <a href="#" id="date-fake" style="display: inline-block; cursor: pointer"><span class="glyphicon glyphicon-ok"></span></a>
</li>


{{-- ########################################### --}}
{{-- Extra CSS and JS for this particular filter --}}

{{-- FILTERS EXTRA CSS  --}}
{{-- push things in the after_styles section --}}

@push('crud_fields_styles')
@endpush


{{-- FILTERS EXTRA JS --}}
{{-- push things in the after_scripts section --}}


{{-- FILTER JAVASCRIPT CHECKLIST

- redirects to a new URL for standard DataTables
- replaces the search URL for ajax DataTables
- users have a way to clear this filter (and only this filter)
- filter:clear event on li[filter-name], which is called by the "Remove all filters" button, clears this filter;

END OF FILTER JAVSCRIPT CHECKLIST --}}

@push('crud_list_scripts')


<script>
    function findGetParameter(parameterName) {
        var result = null,
                tmp = [];
        location.search
                .substr(1)
                .split("&")
                .forEach(function (item) {
                    tmp = item.split("=");
                    if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
                });
        return result;
    }

    jQuery(document).ready(function($) {
        // Check if param exists
        var currentVal = findGetParameter('{{ $filter->name }}');
        var start = null;
        var end = null;
        if (currentVal !== null) {
            var values = currentVal.split('_');
            start = values[0];
            end = values[1];
        }

        // Attach date range picker

        $('#date-fake').click(function(){
            var custom_initdate = document.getElementById("custom_initdate").value;
            var custom_enddate = document.getElementById("custom_enddate").value;
            console.log(custom_initdate);
            filterClick(custom_initdate+'x'+custom_enddate);
        })


        var filterClick = function(value) {
            window.location.hred = URI();
            var parameter = '{{ $filter->name }}';
//            alert(parameter);

                    @if (!$crud->ajaxTable())
            var current_url = normalizeAmpersand("{{ Request::fullUrl() }}");
            var new_url = addOrUpdateUriParameter(current_url, parameter, value);
//            alert(new_url);

            // refresh the page to the new_url
            new_url = normalizeAmpersand(new_url.toString());
            window.location.href = new_url;
            @else
            // behaviour for ajax table
            var ajax_table = $("#crudTable").DataTable();
            var current_url = ajax_table.ajax.url();
            var new_url = addOrUpdateUriParameter(current_url, parameter, value);

            // replace the datatables ajax url with new_url and reload it
            new_url = normalizeAmpersand(new_url.toString());
            ajax_table.ajax.url(new_url).load();

            // mark this filter as active in the navbar-filters
            if (URI(new_url).hasQuery('{{ $filter->name }}', true)) {
                //$("li[filter-name={{ $filter->name }}]").removeClass('active').addClass('active');
            }
            else
            {
                //$("li[filter-name={{ $filter->name }}]").trigger("filter:clear");
            }
            @endif
        };
    });
</script>




@endpush

{{-- End of Extra CSS and JS --}}
{{-- ########################################## --}}