<?php
// dd($fine->type->name)
?>

@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.add_fine') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <style>
        .input-group {
            padding-left: 0px !important;
        }
    </style>
    <!-- Selected user Modal -->
    <div class="modal fade" id="SelecteduserModal" tabindex="-1" role="dialog" aria-labelledby="SelecteduserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center font-weight-bold" id="SelecteduserModalLabel">Driver For Selected
                        Asset</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="myselecteduser" class="text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="goManuallyButton" class="btn btn-secondary" data-dismiss="modal">Go
                        Manually</button>
                    <button type="button" id="goWithSelectedUser" class="btn btn-primary">Go With Selected User</button>
                </div>
            </div>
        </div>
    </div>
    <!-- when no user found Modal -->
    <div style="display: none" class="modal fade" id="Usermodal" tabindex="-1" role="dialog"
        aria-labelledby="UsermodalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center font-weight-bold" id="UsermodalLabel">Driver For Selected Asset</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center text-danger">There is no user found for selected date and time.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="goManuallyButton" class="btn btn-primary" data-dismiss="modal">Go
                        Manually</button>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- left column -->
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <!-- <h2 class="box-title">{{ trans('general.add_fine') }} </h2> -->
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="col-md-12">
                        <form class="form-horizontal" method="post" enctype="multipart/form-data"
                            action="{{ isset($fine) ? route('fines.update', $fine->id) : route('fines.store') }}"
                            autocomplete="off">
                            @csrf
                            <!-- Date/Time -->
                            <div class="form-group">
                                {{ Form::label('fine_date', trans('general.fine_date'), ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-7 date" style="display: table">
                                    <!-- Date and Time Input -->
                                    <input type="datetime-local" id="fine_date" class="form-control"
                                        placeholder="Select Date and Time (YYYY-MM-DD HH:MM)" name="fine_date"
                                        value="{{ isset($fine) ? Carbon::parse($fine->created_at)->format('Y-m-d\TH:i') : Carbon::now()->format('Y-m-d\TH:i') }}">

                                    <!-- Seconds Dropdown -->
                                    <select id="fine_seconds" class="form-control mt-2" name="fine_seconds">
                                        @for ($i = 0; $i < 60; $i++)
                                            <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}"
                                                {{ isset($fine) && Carbon::parse($fine->created_at)->format('s') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                        @endfor
                                    </select>

                                    <span id="asset-error" class="text-danger mt-2" style="display:none;"></span>
                                </div>
                            </div>


                            <!-- asset  -->
                            <div class="form-group">
                                <label for="asset_id" class="col-md-3 control-label">{{ trans('general.asset_id') }}</label>
                                <div class="col-md-7">
                                    {{ Form::select('asset_id', isset($fine) ? [$fine->asset->name] + $assets : ['' => 'Select'] + $assets, isset($fine) ? $fine->asset->id : null, ['class' => 'form-control  select2', 'id' => 'asset_id', 'required']) }}
                                </div>
                            </div>
                            <!-- Users -->
                            <div class="form-group" style="display: none;">
                                <label for="user_id" class="col-md-3 control-label">{{ trans('general.users') }}</label>
                                <div class="col-md-7">
                                    {{ Form::select('user_id', isset($fine) ? [$fine->user->username] + $users : ['' => 'Select'] + $users, isset($fine) ? $fine->user->id : null, ['class' => 'form-control  select2', 'id' => 'user_id', 'required', 'style' => 'width: 100%;']) }}
                                </div>
                            </div>

                            <!-- Fine Number -->
                            <div style="display: none;"
                                class="form-group {{ $errors->has('fine_number') ? 'error' : '' }}">
                                {{ Form::label('fine_number', 'Fine Number', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-7">
                                    <input class="form-control" type="text" name="fine_number" id="fine_number"
                                        value="{{ isset($fine) ? $fine->fine_number : '' }}" />
                                    {!! $errors->first(
                                        'fine_number',
                                        '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>',
                                    ) !!}
                                </div>
                            </div>

                            <!-- fine type -->

                            <div style="display: none;" class="form-group">
                                <label for="fine_type" class="col-md-3 control-label">{{ trans('general.fine_type') }}
                                </label>
                                <div class="col-md-7 required">
                                    {{ Form::select('fine_type', isset($fine) ? [$fine->type->name] + $fine_type : ['' => 'Select'] + $fine_type, isset($fine) ? $fine->type->id : null, ['class' => 'form-control', 'id' => 'fine_type', 'required']) }}
                                    {!! $errors->first(
                                        'fine_type',
                                        '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>',
                                    ) !!}
                                </div>
                                <div style="display: none;" class="col-md-1 col-sm-1 text-left">
                                    <a href='{{ route('modal.show', 'fine') }}' data-toggle="modal"
                                        data-target="#createModal" data-dependency="supplier"
                                        data-select='supplier_select_id'
                                        class="btn btn-sm btn-primary">{{ trans('button.new') }}</a>
                                </div>
                            </div>



                            <!-- Amount -->
                            <div style="display: none;" class="form-group {{ $errors->has('amount') ? 'error' : '' }}">
                                {{ Form::label('amount', trans('general.amount'), ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-7">
                                    <input class="form-control" type="number" name="amount" id="amount"
                                        value="{{ isset($fine) ? $fine->amount : '0'}}" readonly />
                                    {!! $errors->first(
                                        'amount',
                                        '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>',
                                    ) !!}

                                </div>
                                <span id="amount-error" class="text-danger mt-2" style="display:none;">No amount found</span>
                            </div>


                            <!-- location       -->

                            <div style="display: none;" class="form-group">
                                <label for="location"
                                    class="col-md-3 control-label">{{ trans('general.location') }}</label>
                                <div class="col-md-7">
                                    {{ Form::select('location', isset($fine) ? [$fine->findLocation->name] + $location : ['' => 'Select'] + $location, isset($fine) ? $fine->findLocation->id : null, ['class' => 'form-control', 'id' => 'location', 'required']) }}
                                </div>
                            </div>

                            <!-- image -->
                            <div style="display: none;" class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                                {{ Form::label('Fine Image', 'Fine Image', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-7">
                                    <input type="file" name="fine_image" id="fine_image">
                                </div>
                            </div>

                            <!-- note -->

                            <div style="display: none;" class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                                {{ Form::label('note', trans('admin/hardware/form.notes'), ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-7">
                                    <textarea class="col-md-6 form-control" id="note" name="note">{{ isset($fine) ? $fine->note : '' }} </textarea>
                                    {!! $errors->first(
                                        'note',
                                        '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                                                                                                                                                                                                                                                                                                aria-hidden="true"></i> :message</span>',
                                    ) !!}
                                </div>
                            </div>
                            <div class="box-footer">
                                <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                                <button type="submit" class="btn btn-primary pull-right"><i
                                        class="fas fa-check icon-white" aria-hidden="true"></i>
                                    {{ trans('general.save') }}</button>
                            </div>
                        </form>
                    </div> <!--/.col-md-12-->
                </div> <!--/.box-body-->

            </div> <!--/.box.box-default-->
        </div>
    </div>


@stop


@section('moar_scripts')

    <script>
        $(document).ready(function() {
            var username = '';
            var userId = '';
            var dateSelected = false;
            var assetSelected = false;
            $('#fine_date').on('change', function() {
                dateSelected = true;
                $('#asset-error').hide();
                if (assetSelected) {
                    sendAjaxRequest();
                }
            });
            $('#asset_id').on('change', function() {
                assetSelected = true;
                if (dateSelected) {
                    sendAjaxRequest();
                } else {
                    $('#asset-error').text('Please select a date and time first.').show();
                }
            });

            function sendAjaxRequest() {
                var selectedDate = $('#fine_date').val();
                var selectedSeconds = $('#fine_seconds').val();
                var formattedDateTime = selectedDate + ':' + selectedSeconds;
                //alert(formattedDateTime);
                //return false;
                var selectedAssetId = $('#asset_id').val();
                $.ajax({
                    url: '{{ route('fetch-fines') }}',
                    type: 'GET',
                    data: {
                        fine_date: formattedDateTime,
                        asset_id: selectedAssetId
                    },
                    success: function(response) {
                        console.log(response.message);
                        if (response.message === 'There is no user for Selected datetime.') {
                            $('#Usermodal').modal('show');
                            var $select = $('#user_id');
                            $select.empty();
                            $select.append($('<option>', {
                                value: '',
                                text: 'Select a user'
                            }));
                            $.each(response.users, function(id, username) {
                                $select.append($('<option>', {
                                    value: id,
                                    text: username
                                }));
                            });
                        } else {
                            username = response.message.username || 'Unknown User';
                            userId = response.message.id || 'Unknown ID';
                            var text = username +
                                ' is the assigned driver for the selected asset on the chosen date and time.';
                            $('#myselecteduser').text(text);
                            $('#SelecteduserModal').modal('show');

                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
            $('#Usermodal').on('click', '#goManuallyButton', function() {
                $('#Usermodal').modal('hide');
                $('#fine_number, #fine_type, #amount, #location, #fine_image, #note, #user_id').closest(
                    '.form-group').css('display', 'block');
                $('.col-md-1.col-sm-1.text-left').css('display', 'block');
            });
            $('#SelecteduserModal').on('click', '#goManuallyButton', function() {
                $('#SelecteduserModal').modal('hide');
                $('#fine_number, #fine_type, #amount, #location, #fine_image, #note, #user_id').closest(
                    '.form-group').css('display', 'block');
                $('.col-md-1.col-sm-1.text-left').css('display', 'block');
            });
            $('#SelecteduserModal').on('click', '#goWithSelectedUser', function() {
                $('#SelecteduserModal').modal('hide');
                $('#user_id').empty();
                $('#user_id').append(new Option(username, userId));
                $('#fine_number, #fine_type, #amount, #location, #fine_image, #note, #user_id').closest(
                    '.form-group').css('display', 'block');
                $('.col-md-1.col-sm-1.text-left').css('display', 'block');
            });
        });
        // fine type code
        $('#fine_type').change(function() {
            var fineTypeId = $(this).val();
            $.ajax({
            url: '/get-fine-type-amount', 
            type: 'GET',
            data: { fine_type_id: fineTypeId },
            success: function(response) {
                if (response.amount !== undefined) {
                    $('#amount').val(response.amount); 
                    $('#amount-error').hide(); 
                } else {
                    $('#amount').val(0); 
                    $('#amount-error').show();
                }
            },
            error: function() {
                $('#amount').val(0); 
                $('#amount-error').text('Error occurred while fetching the amount').show(); 
            }
        });

        });

        //end of fine type code
        $('.select2').select2();
    </script>
@stop
