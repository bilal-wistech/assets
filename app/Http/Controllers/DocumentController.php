<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Helpers\Helper;
use App\Models\Actionlog;
use Carbon\Carbon;
use App\Models\User;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
       

        if($request->has('period_id'))
        {
            $periodId = request('period_id');
            $currentDate = Carbon::now();
            $expiryDate = $currentDate->copy()->addDays($periodId);
            // $user = $user->uploads->where('expiry_date', '>', $currentDate)
            //     ->where('expiry_date', '<=', $expiryDate)
            //     ->get();
                // dd($user);
                $user =Actionlog::where('expiry_date', '>', $currentDate)
                    ->where('expiry_date', '<=', $expiryDate)->get();
             //   dd($user);
           return view('documents.index')->with('user', $user);
        }
        $user = Actionlog::whereNotNull('expiry_date')
                ->get();
                //dd($user);
        return view('documents.index')->with('user', $user);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getExpiryData(Request $request)
    {
    //     $id = $request->input('id');

    //   $currentDate = Carbon::now();
    //   $sevenDaysFromNow = $currentDate->copy()->addDays(7);
     
    //   $thirtyDaysFromNow = $currentDate->copy()->addDays(30);
    //   $sixMonthsFromNow = $currentDate->copy()->addMonths(6);
    //   $oneYearFromNow = $currentDate->copy()->addYear();
  

        $id = $request->input('id');

        $currentDate = Carbon::now();
        $expiryDate = $currentDate->copy()->addDays($id);

        $user = Actionlog::where('expiry_date', '>', $currentDate)
            ->where('expiry_date', '<=', $expiryDate)
            ->get();
        //  dd($data);
        
        return response()->json(['user' => $user]);
        
    }
}
