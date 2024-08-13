@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.regrid') }}
    @parent
@stop

@section('header_right')
    <style>
        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #ccc !important;
            border-radius: 0px !important;
        }
    </style>
    
    @php
        $selectedUserId = request()->input('user_id');
    @endphp
  <div class="container" style="padding-right: 60px;">
    <div class="row">
        <form class="col-12 row">
            <div class="col-md-4 mb-3">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" class="form-control" name="start_date">
            </div>
            <div class="col-md-4 mb-3">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" class="form-control" name="end_date">
            </div>
            <div class="col-md-4 mb-3">
                <label>Select</label>
                <select class="form-control select2" id="user_id">
                    <option value="">Select</option>
                    @foreach ($users as $names)
                        <option value="{{ $names->id }}" {{ $names->id == $selectedUserId ? 'selected' : '' }}>
                            {{ $names->username }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 text-right">
            <button id="export_button" class="btn btn-primary pr-30">Export</button>
            <button id="reset_button" class="btn btn-secondary pl-30">Reset</button>
        </div>
    </div>
    <br>
</div>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="table-responsive">
                        <table data-columns="{{ \App\Presenters\ExpencePresenter::dataTableLayout() }}"
                            data-cookie-id-table="expenceTable" 
                            data-pagination="true" 
                            data-id-table="expenceTable"
                            data-search="false" 
                            data-side-pagination="server" 
                            data-show-columns="true"
                            data-show-fullscreen="true" 
                            data-show-export="false" 
                            data-show-refresh="true"
                            data-sort-order="asc" 
                            id="expenceTable" 
                            class="table table-striped snipe-table"
                            data-url="{{ url('api/show_data') }}">
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
@stop

@section('moar_scripts')
<script>
    $(document).ready(function() {
        function refreshTable() {
            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var userId = $('#user_id').val();

            var queryParams = {
                start_date: startDate,
                end_date: endDate,
                user_id: userId || '' // Send empty string if user_id is not selected
            };

            $('#expenceTable').bootstrapTable('refresh', {
                query: queryParams
            });
        }

        function resetFilters() {
            $('#start_date').val('');
            $('#end_date').val('');
            $('#user_id').val('').trigger('change'); // Reset and trigger change for select2
            refreshTable();
        }

        function initializeBootstrapTable() {
            $('.snipe-table').bootstrapTable({
                classes: 'table table-responsive table-no-bordered',
                ajaxOptions: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                stickyHeader: true,
                locale: '{{ config('app.locale') }}',
                stickyHeaderOffsetY: '0px',
                undefinedText: '',
                iconsPrefix: 'fa',
                cookie: true,
                cookieExpire: '2y',
                mobileResponsive: true,
                maintainSelected: true,
                trimOnSearch: false,
                showSearchClearButton: true,
                paginationFirstText: "First",
                paginationLastText: "Last",
                paginationPreText: "Previous",
                paginationNextText: "Next",
                pageList: ['10', '20', '30', '50', '100', '150', '200', '500'],
                pageSize: 20,
                paginationVAlign: 'both',
                formatLoadingMessage: function() {
                    return '<h2><i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Loading... please wait.... </h4>';
                },
                icons: {
                    advancedSearchIcon: 'fas fa-search-plus',
                    paginationSwitchDown: 'fa-caret-square-o-down',
                    paginationSwitchUp: 'fa-caret-square-o-up',
                    fullscreen: 'fa-expand',
                    columns: 'fa-columns',
                    refresh: 'fas fa-sync-alt',
                    export: 'fa-download',
                    clearSearch: 'fa-times'
                },
                onLoadSuccess: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                },
                url: "{{ url('api/show_data') }}"
            });
        }

        $('#start_date, #end_date, #user_id').on('change', refreshTable);

        $('#export_button').click(function(event) {
            event.preventDefault();

            var startDate = $('#start_date').val();
            var endDate = $('#end_date').val();
            var userId = $('#user_id').val();

            var searchQuery = $('#expenceTable').bootstrapTable('getOptions').queryParams.search;

            $.ajax({
                url: '{{ route('re_expense.export') }}',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate,
                    user_id: userId,
                    search: searchQuery
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    var contentType = xhr.getResponseHeader('Content-Type');
                    if (contentType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                        var blob = new Blob([response], { type: contentType });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'reimmensible-expense.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        window.URL.revokeObjectURL(link.href);
                    } else {
                        console.error('Unexpected content type:', contentType);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Export error:', textStatus, errorThrown);
                }
            });
        });

        $('#reset_button').click(function(event) {
            event.preventDefault();
            resetFilters();
        });

        initializeBootstrapTable();
    });
</script>

@include ('partials.bootstrap-table', [
    'exportFile' => 'expence-export',
    'search' => false,
    'columns' => \App\Presenters\ExpencePresenter::dataTableLayout(),
])
@stop
