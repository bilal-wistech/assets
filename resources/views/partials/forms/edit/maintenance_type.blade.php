          <!-- Improvement Type -->
          <div class="form-group {{ $errors->has('asset_maintenance_type') ? ' has-error' : '' }}">
              <label for="asset_maintenance_type" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.asset_maintenance_type') }}
              </label>
              <div class="col-md-7{{  (Helper::checkIfRequired($item, 'asset_maintenance_type')) ? ' required' : '' }}">
                  {{ Form::select('asset_maintenance_type', $assetMaintenanceType , old('asset_maintenance_type', $item->asset_maintenance_type), ['class'=>'select2', 'style'=>'min-width:350px', 'aria-label'=>'asset_maintenance_type']) }}
                  {!! $errors->first('asset_maintenance_type', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
               <div class="col-md-1 col-sm-1 text-left">
             <a href='{{ route('modal.show', 'asset_maintenance_type') }}' data-toggle="modal"  data-target="#createModal" data-dependency="supplier" data-select='supplier_select_id' class="btn btn-sm btn-primary">{{  trans('button.new') }}</a>
    </div>
          </div>
