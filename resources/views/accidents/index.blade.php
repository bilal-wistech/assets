@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('Accident') }}
    @parent
@stop


@section('header_right')
    @can('create', \App\Models\Fine::class)
        <a href="{{ route('accidents.create') }}" class="btn btn-primary pull-right">
            {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="table-responsive">

                        <table
                                data-columns="{{ \App\Presenters\AccidentPresenter::dataTableLayout() }}"
                                data-cookie-id-table="AccidentTable"
                                data-pagination="true"
                                data-id-table="AccidentTable"
                                data-search="true"
                                data-side-pagination="server"
                                data-show-columns="true"
                                data-show-fullscreen="true"
                                data-show-export="true"
                                data-show-refresh="true"
                                data-sort-order="asc"
                                id="AccidentTable"
                                class="table table-striped snipe-table"
                                data-url="{{ route('api.accident.index') }}"
                                data-export-options='{
              "fileName": "export-asset-assignment-{{ date('Y-m-d') }}",
              "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
              }'>
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')
@stop

