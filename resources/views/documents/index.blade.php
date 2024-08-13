
<?php
use Illuminate\Support\Facades\Storage;


?>
@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @parent
@stop

{{-- Right header --}}
@section('header_right')


@stop

{{-- Page content --}}
@section('content')

                    
                   

                   

<div class="row pull-right">
	   
	        <label>Select Period</label>
	        <select class="form-control select2" id="period_id" style="width:262px !important">
	           <option >Select</option> 
           
              <option value="7" {{ Request::get('period_id') == 7 ? 'selected' : '' }}>7 days</option>
              <option value="15" {{ Request::get('period_id') == 15 ? 'selected' : '' }}>15 days</option>
              <option value="30" {{ Request::get('period_id') == 30 ? 'selected' : '' }}>30 days</option>
              <option value="60" {{ Request::get('period_id') == 60 ? 'selected' : '' }}>60 days</option>
              <option value="90" {{ Request::get('period_id') == 90 ? 'selected' : '' }}>90 days</option>
              <option value="182" {{ Request::get('period_id') == 182 ? 'selected' : '' }}>6 months</option>
              <option value="360" {{ Request::get('period_id') == 360 ? 'selected' : '' }}>1 year</option>
	        </select>
	   
 	</div>

    <div class="row">

    <div class="col-md-12">
          <div class="tab-pane" id="files">
          <div class="row">

            <div class="col-md-12 col-sm-12">
              <div class="table-responsive">
                  <table
                          data-cookie-id-table="userUploadsTable"
                          data-id-table="userUploadsTable"
                          id="userUploadsTable"
                          data-search="true"
                          data-pagination="true"
                          data-side-pagination="client"
                          data-show-columns="true"
                          data-show-fullscreen="true"
                          data-show-export="true"
                          data-show-footer="true"
                          data-toolbar="#upload-toolbar"
                          data-show-refresh="true"
                          data-sort-order="asc"
                          data-sort-name="name"
                          class="table table-striped snipe-table"
                          >

                  <thead>
                    <tr>
                        <th data-visible="true" data-field="icon" data-sortable="true">{{trans('general.file_type')}}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="image">{{ trans('general.image') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="name">{{ trans('general.name') }}</th>
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="expiry_date">{{ trans('general.expiry_date') }}</th>
                        <!-- <th class="col-md-2" data-searchable="true" data-visible="true" data-field="filename" data-sortable="true">{{ trans('general.file_name') }}</th> -->
                       
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="notes" data-sortable="true">{{ trans('general.notes') }}</th>
                       
                        <th class="col-md-2" data-searchable="true" data-visible="true" data-field="created_at" data-sortable="true">{{ trans('general.created_at') }}</th>
                        <!-- <th class="col-md-1" data-searchable="true" data-visible="true" data-field="actions">{{ trans('table.actions') }}</th> -->
                    </tr>
                  </thead>
                  <tbody>

                   
                 @foreach($user as $file)
                 <tr>
                 <td>
                    <i class="{{ Helper::filetype_icon($file->filename) }} icon-med" aria-hidden="true"></i>
                    <span class="sr-only">{{ Helper::filetype_icon($file->filename) }}</span>

                </td>
                 <td>
                
                 @if (($file->filename) && (Storage::exists('private_uploads/' . Helper::getFoldername($file->item_type) . '/' . $file->filename)))
                
                 <img src="{{ route('show/userfile', ['userId' => $file->user_id, 'fileId' => $file->id]) }}" class="img-thumbnail" style="max-width: 50px;">
                      
                    @else
                        <i class="fa fa-times text-danger" aria-hidden="true"></i>
                            {{ trans('general.file_not_found') }}
                    @endif
                   
                   
                    <td>
                    {{ $file->name }}        
                    </td>
                    <td>
                    {{ $file->expiry_date }}        
                    </td>

                    <!-- <td>
                    @if($file->filename)  
                    {{ $file->filename }}
                    @endif        
                    </td> -->
                    <td>
                    @if($file->note)  
                    {{ $file->note }}
                    @endif        
                    </td>
                    <td>
                    {{ $file->created_at }}        
                    </td>
                    <!-- <td>
                        <a class="btn delete-asset btn-danger btn-sm hidden-print" href="{{ route('userfile.destroy', [ $file->user_id, $file->id]) }}" data-content="Are you sure you wish to delete this file?" data-title="Delete {{ $file->filename }}?">
                            <i class="fa fa-trash icon-white" aria-hidden="true"></i>
                            <span class="sr-only">{{ trans('general.delete') }}</span>
                        </a>
                    </td> -->
                 </tr>
                 @endforeach

                  </tbody>
                </table>
              </div>
            </div>
          </div> <!--/ROW-->
        </div><!--/FILES-->
    </div>
          
                </div> <!-- /. tab-content -->
            </div> <!-- /.nav-tabs-custom -->
        </div> <!-- /. col-md-12 -->
    </div> <!-- /. row -->

   
  

@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table')

<script>
$(document).ready(function() {
    $('#period_id').on('change', function() {
        var periodId = $(this).val();
        var currentURL = window.location.href;

        var newURL = currentURL + '?period_id=' + periodId;

        window.location.href = newURL;
       
        
});
 var currentURL = window.location.href;

const url = new URL(currentURL);
const params = new URLSearchParams(url.search);

// console.log(`period_id?:\t${params.has("period_id")}`);



if (params.has("period_id")) {
  
    
    params.delete("period_id");
    url.search = params.toString();
  
    window.history.replaceState({}, '', url);

} else {
   
    console.log("There is some error in existing URL");
}


});

</script>
<script>
// $(document).ready(function() {
//     $('#period_id').on('change', function() {
//         var periodId = $(this).val();
        
//         if (periodId) {
//             $.ajax({
//                 url: "{{ url('/getExpiryData') }}", 
//                 type: 'POST',
//                 data: {
//                     id: periodId,
//                     _token: "{{ csrf_token() }}",
//                 },
//                 success: function(data) {
//                     console.log(data.user);
                  
// var tableBody = $('#userUploadsTable tbody');

// tableBody.empty();


// var newRow = '';
// $.each(data.user, function(index, user) {
//          newRow += `
//         <tr>
//             <td>${user.name}</td>
//             <td>${user.expiry_date}</td>
//         </tr>
//     `;
// });

// tableBody.append(newRow);

// },


//             });
//         } else {
            
//         }
//     });
// });
</script>

 

@stop
