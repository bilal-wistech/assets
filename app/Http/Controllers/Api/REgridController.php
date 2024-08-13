<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\ExpenceTypeTransformer;
use App\Http\Transformers\REgridTransformer;

use App\Models\AddExpence;
use App\Models\User;
use App\Models\TypeOfExpence;
use Illuminate\Http\Request;


class REgridController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // $this->authorize('view', Category::class);
 
        // return 'hello';
        $expence_data = AddExpence::where('user_id' , $id )->first();
           // dd($expence_data);
            return response()->json($expence_data);
         //   return (new REgridTransformer)->transformgridUser($expence_data );


    }
/**
     * @param Request $request
     * @param null $id
     * @return mixed
     */
    public function show(Request $request, $id = null)
    {
        // Expenses Base Query
        $expense = AddExpence::select('add_expences.*')->with('type', 'asset', 'userData');

        $user_id = 0;

        if ($request->filled('start_date')) {
            $expense->whereDate('created_at', '>=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $expense->whereDate('created_at', '<=', $request->input('end_date'));
        }

        if ($id !== null && $id > 0) {
            $user_id = $id;
        } else if ($request->query('user_id') && $request->query('user_id') > 0) {
            $user_id = $request->query('user_id');
        }

        if ($user_id) {
            $expense = $expense->where('user_id', $user_id);
        }


        $offset = (($expense) && ($request->get('offset') > $expense->count())) ? $expense->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');
        
        $total = $expense->count();
        $expense = $expense->skip($offset)->take($limit)->get();
        return (new REgridTransformer)->transformgrid($expense, $total);
    }

     public function approval($id)
    {
      // dd('kjhdkjehdeheh');
        $expence_data = AddExpence::find($id);

        $expence_data->update(['approved' => 1]);
        
        return redirect()->back();

    }
    public function disapproval($id)
    {
      // dd('kjhdkjehdeheh');
        $expence_data = AddExpence::find($id);

        $expence_data->update(['approved' => 0]);
        return redirect()->back();

    }

    public function ShowExpenseType()
    {
      $type = TypeOfExpence::all();
      return (new ExpenceTypeTransformer)->transformtype($type );
    }

}