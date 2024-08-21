<?php

namespace App\Presenters;

/**
 * Class CategoryPresenter
 */
class AccidentPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ],
            [
                'field' => 'accident_number',
                'searchable' => true,
                'sortable' => true,
                'title' => 'Accident Number',
                'visible' => true,
               
            ],
            [
                'field' => 'asset_name',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/form.name'),
                'visible' => true,
                'formatter' => 'hardwareLinkFormatter',
            ],
            [
                'field' => 'username',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.username'),
                'visible' => true,
               
            ],

            [
                'field' => 'accident_type',
                'searchable' => true,
                'sortable' => true,
                'title' => 'Title',
                'visible' => true,
               
            ],
            [
                'field' => 'amount',
                'searchable' => false,
                'sortable' => true,
                'title' => trans('general.amount'),
                'visible' => true,
            ], 
            [
                'field' => 'accident_date',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,
                'title' =>'Accident Date',
                'formatter' => 'dateDisplayFormatter',
            ],
            [
                'field' => 'recieved',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => 'Recieved by user',
		
            ],
            
            [
                'field' => 'created_at',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,
                'title' => trans('general.created_at'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'action',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
		      'formatter' => 'accidentActionsFormatter',
            ],
           
        
        ];

        return json_encode($layout);
    }

    /**
     * Link to this categories name
     * @return string
     */
   

    /**
     * Url to view this item.
     * @return string
     */
   
}
