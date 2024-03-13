<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\SavedApiValues;
use App\Models\User;
use App\Services\ApiService;
use App\Services\BrApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    protected $service;
    protected $assets;
    protected $user;

    public function __construct()
    {
    }
    public function index()
    {
        $user = Auth::user();
        $this->assets = Asset::where('user_id', $user->id)->get();

        $stocks = Asset::where('user_id', $user->id)->where('type', 'stocks')->get(); 
        $reit = Asset::where('user_id', $user->id)->where('type', 'reit')->get();

        $this->service = new APIService($user);
        $processedData = $this->service->processedData();

        if (empty($processedData)) {
            return view('assets.empty-assets');
        }

        $stocksAndReitSum = $this->service->stocksAndReitSum($processedData);

        return view('assets.index', ['processedData' => $processedData, 'assets' => $this->assets, 'stocks' => $stocks, 'reit' => $reit, 'sum' => $stocksAndReitSum]);
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $assetCodes = Asset::where('user_id', $user->id)->pluck('code')->all();;
        $data = $request->all();

        if(in_array($data['code'], $assetCodes)) {
            return redirect(route('assets.index'))->with('error', 'Você já tem este ativo cadastrado!');
        }

        $data['code'] = strtoupper($data['code']);
        $data['user_id'] = $user->id;
        $data['average_price'] = preg_replace('/,(\d+)/', '.$1', $data['average_price']);
        

        $brApi = new BrApiService($user);
        $response = $brApi->fetchApiData($data['code']);
        $values = $brApi->processApiResponse( $response);
        $values[0]['user_id'] = $user->id;

        SavedApiValues::create($values[0]);
        Asset::create($data);

        return redirect(route('assets.index'));
    }

    public function edit(string $id)
    {
        $asset = Asset::findOrFail($id);
        
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);
        $asset->update($request->all());

        return redirect(route('assets.index'));
    }

    public function destroy(string $id)
    {
        $asset = Asset::findOrFail($id);
        $apiValue = SavedApiValues::where('symbol', $asset->code)
            ->where('user_id', $asset->user_id)
            ->get();
        $apiValue = $apiValue[0];

        $apiValue->delete();
        $asset->delete();

        return redirect(route('assets.index'));
    }

    public function reloadData()
    {
        $this->service = new ApiService(Auth::user());
        $this->service->saveValuesOnDB(Auth::user());

        return redirect(route('assets.index'));
    }

    public function newContribuition(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);

        $oldValue = $asset->quantity * $asset->average_price;
        $newContribuitionValue = $request['quantity'] * $request['average_price'];
        
        $asset->quantity += $request['quantity'];
        $updatedAveragePrice = ($oldValue + $newContribuitionValue) / $asset->quantity;

        $asset->average_price = $updatedAveragePrice;
        $asset->update();

        return redirect(route('assets.index'));
    }
}
