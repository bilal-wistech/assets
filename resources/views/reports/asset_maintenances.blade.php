@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.asset_maintenance_report') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="form-inline filter_asset_by_date">
                        <div class="form-group">
                            <label for="start_date">{{ trans('admin/asset_maintenances/form.start_date') }}</label>
                            <input type="date" id="start_date" class="form-control" name="start_date">
                        </div>
                        <div class="form-group">
                            <label
                                for="completion_date">{{ trans('admin/asset_maintenances/form.completion_date') }}</label>
                            <input type="date" id="completion_date" class="form-control" name="completion_date">
                        </div>
                        <button id="export_button" class="btn btn-primary">Export</button>
                        <button id="reset_filters" class="btn btn-secondary">Reset</button>
                    </div>

                    <div class="table-responsive">
                        <table 
                        data-cookie-id-table="maintenancesReport" 
                        data-pagination="true" 
                        data-show-footer="true"
                        data-id-table="maintenancesReport" 
                        data-search="false" 
                        data-side-pagination="server"
                        data-show-columns="true" 
                        data-show-refresh="true" data-sort-order="asc" 
                        id="maintenancesReport"
                        data-url="{{ route('api.maintenances.index') }}" 
                        class="table table-striped snipe-table">
                            <thead>
                                <tr>
                                    <th data-field="company" data-sortable="false" data-visible="false"
                                        data-formatter="companiesLinkObjFormatter">
                                        {{ trans('admin/companies/table.title') }}</th>
                                    <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}
                                    </th>
                                    <th data-sortable="true" data-field="asset_tag" data-formatter="assetTagLinkFormatter"
                                        data-visible="false">{{ trans('general.asset_tag') }}</th>
                                    <th data-sortable="false" data-field="asset_name"
                                        data-formatter="assetNameLinkFormatter">
                                        {{ trans('admin/asset_maintenances/table.asset_name') }}</th>
                                    <th data-sortable="false" data-field="supplier"
                                        data-formatter="suppliersLinkObjFormatter">{{ trans('general.supplier') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_type">
                                        {{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="title">
                                        {{ trans('admin/asset_maintenances/form.title') }}</th>
                                    <th data-searchable="true" data-sortable="false" data-field="start_date"
                                        data-formatter="dateDisplayFormatter">
                                        {{ trans('admin/asset_maintenances/form.start_date') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="completion_date"
                                        data-formatter="dateDisplayFormatter">
                                        {{ trans('admin/asset_maintenances/form.completion_date') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="asset_maintenance_time">
                                        {{ trans('admin/asset_maintenances/form.asset_maintenance_time') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="cost" class="text-right"
                                        data-footer-formatter="sumFormatter">
                                        {{ trans('admin/asset_maintenances/form.cost') }}</th>
                                    <th data-sortable="true" data-field="location"
                                        data-formatter="deployedLocationFormatter" data-visible="false">
                                        {{ trans('general.location') }}</th>
                                    <th data-sortable="true" data-field="rtd_location"
                                        data-formatter="deployedLocationFormatter" data-visible="false">
                                        {{ trans('admin/hardware/form.default_location') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="user_id"
                                        data-formatter="usersLinkObjFormatter">{{ trans('general.admin') }}</th>
                                    <th data-searchable="true" data-sortable="true" data-field="notes" data-visible="false">
                                        {{ trans('admin/asset_maintenances/form.notes') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @stop

    @section('moar_scripts')
        @include ('partials.bootstrap-table')
        <script>
            $(document).ready(function() {
                $('#start_date, #completion_date').on('change', function() {
                    var startDate = $('#start_date').val();
                    var endDate = $('#completion_date').val();
                    $('#maintenancesReport').bootstrapTable('refresh', {
                        query: {
                            start_date: startDate,
                            completion_date: endDate
                        }
                    });
                });

                $('#reset_filters').on('click', function() {
                    $('#start_date').val('');
                    $('#completion_date').val('');
                    $('#maintenancesReport').bootstrapTable('refresh', {
                        query: {
                            start_date: '',
                            completion_date: ''
                        }
                    });
                });

                $('#export_button').click(function(event) {
                    event.preventDefault();

                    var startDate = $('#start_date').val();
                    var endDate = $('#completion_date').val();

                    // Get the current search query from Bootstrap Table
                    var searchQuery = $('#maintenancesReport').bootstrapTable('getOptions').queryParams.search;

                    $.ajax({
                        url: '{{ route('reports/export/asset_maintenances') }}',
                        method: 'GET',
                        data: {
                            start_date: startDate,
                            completion_date: endDate,
                            search: searchQuery // Pass the search query along with other parameters
                        },
                        xhrFields: {
                            responseType: 'blob' // Set the response type as blob
                        },
                        success: function(response, status, xhr) {
                            // Handling export success
                            var contentType = xhr.getResponseHeader('Content-Type');
                            if (contentType ===
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                                ) {
                                var blob = new Blob([response], {
                                    type: contentType
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = 'asset_maintenance_report.xlsx';
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
            });
        </script>
    @stop
