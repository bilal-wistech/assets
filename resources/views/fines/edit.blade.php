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
                    action="{{  isset($fine)  ? route('fines.update', $fine->id) : route('fines.store') }}"
                    autocomplete="off">
               
                 @csrf

                  

                   <!-- Date/Time -->
                    <div class="form-group">
                      {{ Form::label('fine_date', trans('general.fine_date'), array('class' => 'col-md-3 control-label')) }}
                      <div class="col-md-7 date" style="display: table" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-autoclose="true">
                            <input type="text" class="form-control" placeholder="Select Date (YYYY-MM-DD)" name="fine_date" value="{{ isset($fine) ? $fine->fine_date : Carbon::now()->format('Y-m-d')}}" >
                            <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                          </div>
                    </div>
                    <!-- Fine Number -->
                  <div class="form-group {{ $errors->has('fine_number') ? 'error' : '' }}">
    {{ Form::label('fine_number', 'Fine Number', ['class' => 'col-md-3 control-label']) }}
    <div class="col-md-7">
        <input class="form-control" type="text" name="fine_number" id="fine_number"
               value="{{ isset($fine) ? $fine->fine_number : '' }}"/>
        {!! $errors->first('fine_number', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>

                    <!-- fine type -->

                  <div class="form-group">
              <label for="fine_type" class="col-md-3 control-label">{{ trans('general.fine_type') }}
              </label>
              <div class="col-md-7 required">
                  {{ Form::select('fine_type', isset($fine) ? array($fine->type->name) + $fine_type : ['' => 'Select'] + $fine_type , isset($fine) ? $fine->type->id : null ,['class' => 'form-control', 'required']) }}
                  {!! $errors->first('fine_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div> 
              <div class="col-md-1 col-sm-1 text-left">
             <a href='{{ route('modal.show', 'fine') }}' data-toggle="modal"  data-target="#createModal" data-dependency="supplier" data-select='supplier_select_id' class="btn btn-sm btn-primary">{{  trans('button.new') }}</a>
           </div>
          </div>

          <!-- asset  -->
          <div class="form-group">
                    <label for="asset_id" class="col-md-3 control-label">{{ trans('general.asset_id') }}</label>
                    <div class="col-md-7">
                        {{ Form::select('asset_id', isset($fine) ? array($fine->asset->name) + $assets : ['' => 'Select'] + $assets, isset($fine) ? $fine->asset->id :null, ['class' => 'form-control  select2', 'required']) }}
                    </div>
                </div>


        

              <!-- Users -->

               
                <div class="form-group">
                    <label for="user_id" class="col-md-3 control-label">{{ trans('general.users') }}</label>
                    <div class="col-md-7">
                        {{ Form::select('user_id',  isset($fine) ? array($fine->user->username) + $users :  ['' => 'Select'] + $users,  isset($fine) ? $fine->user->id : null, ['class' => 'form-control  select2', 'required']) }}
                    </div>
                </div>

                  <!-- Amount -->
                  <div class="form-group {{ $errors->has('amount') ? 'error' : '' }}">
                    {{ Form::label('amount', trans('general.amount'), array('class' => 'col-md-3 control-label')) }}
                    <div class="col-md-7">
                        <input class="form-control" type="number" name="amount" id="amount"
                               value="{{ isset($fine) ? $fine->amount : ''}}" step="0.01"/>
                        {!! $errors->first('amount', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                    </div>
                </div>
                

                     <!-- location       -->

              <div class="form-group">
                    <label for="location" class="col-md-3 control-label">{{ trans('general.location') }}</label>
                    <div class="col-md-7">
                        {{ Form::select('location', isset($fine) ? array($fine->findLocation->name)  + $location : ['' => 'Select'] + $location, isset($fine) ? $fine->findLocation->id : null , ['class' => 'form-control', 'required']) }}
                    </div>
                </div>

                <!-- image -->
                    <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                  {{ Form::label('Fine Image', 'Fine Image', array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-7">
                          <input type="file" name="fine_image" id="fine_image"  >
                  </div>
                </div>
                
                <!-- note -->

                <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                        {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                        <div class="col-md-7">
                            <textarea class="col-md-6 form-control" id="note" name="note">{{ isset($fine) ? $fine->note : ''}} </textarea>
                            {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times"
                                    aria-hidden="true"></i> :message</span>') !!}
                        </div>
                    </div>

          
                    
        
                    <div class="box-footer">
                      <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                      <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
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

$('.select2').select2();
</script>


@stop