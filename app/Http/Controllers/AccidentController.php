<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Accident;
use App\Models\Location;
use App\Models\FineType;
use App\Models\AccidentType;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendPushNotification;
use Kutia\Larafirebase\Facades\Larafirebase;
use ExpoSDK\Expo;
use App\Models\ExpoToken;
use ExpoSDK\ExpoMessage;
use Image;


class AccidentController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $this->authorize('view', Accident::class);
        return view('accidents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $this->authorize('create', Accident::class);
        $assets = Asset::all()->pluck('asset_tag', 'id')->toArray();
        $users = User::all()->pluck('username', 'id')->toArray();
        $fine_type = AccidentType::all()->pluck('name', 'id')->toArray();
        $location = Location::all()->pluck('name', 'id')->toArray();
        // dd($assets);
        return view('accidents.edit', compact('assets', 'fine_type', 'location', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        //dd($data);
        // dd($request->fine_type->fine);
        if ($request->file('accident_image')) {
            $image = $request->file('accident_image');
            //  dd($image);
            $imageName = time() . '.' . $image->getClientOriginalExtension();


            $image_resize = Image::make($image->getRealPath());

            $image_resize->resize(1000, 1000);
            // dd($image_resize);
            $path = 'uploads/accidents/' . $imageName;

            $image_resize->save($path);

            $imageUri = 'uploads/accidents/' . $imageName;

            $data['accident_image'] = $path;
        }

         $fine = Accident::create($data);
        $detail = Accident::latest()->first();
        
        //   dd($detail->user_id);

        $type_name = $detail->type && $detail->type->name != null ? $detail->type->name : 'not available';
        $location_name = $detail->findLocation && $detail->findLocation->name != null ? $detail->findLocation->name : 'not available';
        $asset_name = $detail->asset && $detail->asset->asset_tag != null ? $detail->asset->asset_tag : 'not available';
        $user_name = $detail->user && $detail->user->username != null ? $detail->user->username : 'not available';
        $appUrl = config('app.url');

        //   $imageUrl = $appUrl . $detail->fine_image 
        $imageUrl = url(e($detail->fine_image));
        //   dd($imageUrl);
        //=================== latest for notification ====================

        try {

            $tokens = ExpoToken::where('user_id', $detail->user_id)->pluck('expo_token')->toArray();
            // dd($tokens);
            foreach ($tokens as $token) {
                //   dd($token);
                $messages =
                    new ExpoMessage([
                        'title' => 'Accident notification',
                        'body' => 'An accident has been reported.',
                        'data' => [
                            'user_id' => $user_name,
                            'amount' => $request->amount,
                            'accident_date' => $request->accident_date,
                            'accident_type' => $type_name,
                            'asset_id' => $asset_name,
                            'location' => $location_name,
                            'note' => $request->note,
                            'image' => $imageUrl,

                        ],

                    ]);

                (new Expo)->send($messages)->to($token)->push();
            }

            return redirect()->route('accidents')->with('success', 'Accident created successfully!');
        } catch (\Exception $e) {
            report($e);
            return redirect()->back()->with('error', 'Something goes wrong while sending notification.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Accident::find($id);
        dd($data->type->name);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update', Accident::class);
        $fine = Accident::find($id);
        $assets = Asset::all()->map(function ($asset) {
            return $asset->name . ' ' . $asset->asset_tag;
        })->toArray();
        $users = User::all()->pluck('username', 'id')->toArray();
        $fine_type = AccidentType::all()->pluck('name', 'id')->toArray();
        $location = Location::all()->pluck('name', 'id')->toArray();
        return view('accidents.edit', compact('fine', 'assets', 'users', 'fine_type', 'location'));
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

        //dd($request->all());
        // $model = Fine::find($id);
        $user = Accident::find($id);

        // Check if the user exists
        if ($user) {

            $user->accident_type = $request->accident_type;
            $user->accident_number = $request->accident_number;
            $user->amount = $request->amount;
            $user->user_id = $request->user_id;
            $user->asset_id = $request->asset_id;
            $user->location = $request->location;
            $user->accident_date = $request->accident_date;
            $user->recieved_by_user = $request->recieved_by_user;
            $user->note = $request->note;
            $user->save();
            return redirect()->route('accidents')->with('success', 'data updated successfully');
        }
        ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $this->authorize('delete', Accident::class);
        $data = Accident::find($id);
        $data->delete();
        return redirect()->route('accidents')->with('success', 'data deleted successfully');
    }
    public function getFineTypeAmount(Request $request)
    {
        $fineTypeId = $request->fine_type_id;
        $fineType = AccidentType::find($fineTypeId);
        if ($fineType) {
            return response()->json(['amount' => $fineType->amount]);
        } else {
            return response()->json(['amount' => null]);
        }
    }

    public function fetchAccidents(Request $request)
    {
        $Date = $request->input('accident_date');
        $assetId = $request->input('asset_id');
        $fineDate = Carbon::parse($Date)->format('Y-m-d H:i:s');
        $asset = Asset::where('last_checkout', $fineDate)
            ->where('id', $assetId)
            ->first();
        if ($asset) {
            $userId = $asset->user_id;
            $user = User::where('id', $userId)
                ->select('id', 'username')
                ->first();
            return response()->json([
                'success' => true,
                'message' => $user
            ]);
        } else {
            $users = User::all()->pluck('username', 'id')->toArray();
            return response()->json([

                'success' => false,
                'message' => 'There is no user for Selected datetime.',
                'users' => $users
            ]);
        }
    }
}
