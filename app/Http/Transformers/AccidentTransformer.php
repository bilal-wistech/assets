<?php

namespace App\Http\Transformers;

use App\Helpers\Helper;
use App\Models\Accident;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;

class AccidentTransformer
{
    public function transformaccident($accidents, $total)
    {
        $array = [];
        foreach ($accidents as $accident) {

            $array[] = self::transform($accident);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }
    public function transform($accident)
    {

        //  dd($expData_value);

        if ($accident) {


            $array = [
                'id' => $accident->id,
                'accident_number' => $accident->accident_number ? $accident->accident_number : '',
                'asset_name' => $result = $accident->asset->name ?? $accident->asset->asset_tag ?? '',
                'username' => $accident->user != null ? $accident->user->username : 'Username is not available',
                'accident_type' => $accident->type && $accident->type->name != null ? $accident->type->name : 'not available',
                'amount' => $accident->amount,
                'recieved' => Helper::showMessage($accident->recieved_by_user),
                'accident_date' => $accident->accident_date ? Helper::getFormattedDateObject($accident->accident_date, 'datetime') : null,
                'created_at' => Helper::getFormattedDateObject($accident->created_at, 'datetime'),



            ];

            $permissions_array['available_actions'] = [
                'update' => Gate::allows('update', Accident::class),
                'delete' => Gate::allows('delete', Accident::class),
            ];

            $array += $permissions_array;


            return $array;
        }
    }
}
