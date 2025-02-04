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
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    public function index()
    {
        $this->assets = Asset::where('user_id', $this->user->id)->get();

        $stocks = Asset::where('user_id', $this->user->id)->where('type', 'stocks')->get(); 
        $reit = Asset::where('user_id', $this->user->id)->where('type', 'reit')->get();

        $this->service = new APIService($this->user);
        $processedData = $this->service->processData();

        if (empty($processedData)) {
            return view('assets.empty-assets');
        }

        $stockBalances = $this->getAssetBalances('stocks', $processedData);
        $reitBalances = $this->getAssetBalances('reits', $processedData);

        return view('assets.index', [
            'assets' => $this->assets,
            'stocks' => $stocks,
            'reit' => $reit,
            'processedData' => $processedData,
            'stockNames' => $stocks->pluck('code'),
            'stockBalances' => $stockBalances,
            'reitBalances' => $reitBalances
        ]);
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $assetCodes = Asset::where('user_id', $this->user->id)->pluck('code')->all();
        $data = $request->all();

        if(in_array($data['code'], $assetCodes)) {
            return redirect(route('assets.index'))->with('error', 'Você já tem este ativo cadastrado!');
        }

        $data['code'] = trim(strtoupper($data['code']));
        $data['user_id'] = $this->user->id;
        $data['average_price'] = preg_replace('/,(\d+)/', '.$1', $data['average_price']);
        

        $brApi = new BrApiService($this->user);
        $response = $brApi->fetchApiData($data['code']);
        $values = $brApi->processApiResponse($response);
        $values[0]['user_id'] = $this->user->id;

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
        $this->service = new ApiService($this->user);
        $this->service->saveValuesOnDB($this->user);

        return redirect(route('assets.index'));
    }

    public function newContribuition(Request $request, string $id)
    {
        $asset = Asset::findOrFail($id);

        $oldValue = $asset->quantity * $asset->average_price;
        $newContribuitionValue = $request['quantity'] * $request['average_price'];
        
        $asset->quantity += $request['quantity'];
        $updatedAveragePrice = ($oldValue + $newContribuitionValue) / $asset->quantity;

        $asset->average_price = round($updatedAveragePrice, 2);
        $asset->update();

        return redirect(route('assets.index'));
    }

    public function detailedView()
    {
        $this->assets = Asset::where('user_id', $this->user->id)->get();

        $stocks = Asset::where('user_id', $this->user->id)->where('type', 'stocks')->get(); 
        $reit = Asset::where('user_id', $this->user->id)->where('type', 'reit')->get();

        $this->service = new APIService($this->user);
        $processedData = $this->service->processData();

        if (empty($processedData)) {
            return view('assets.empty-assets');
        }

        $stocksAndReitSum = $this->service->stocksAndReitSum($processedData);

        return view('assets.detailed-view', [
            'assets' => $this->assets,
            'stocks' => $stocks,
            'reit' => $reit,
            'processedData' => $processedData,
            'sum' => $stocksAndReitSum
        ]);
    }

    public function getAssetBalances(string $assetType, array $processed): array
    {
        $assetBalances = [];
        foreach($this->assets as $key => $asset) {
            if ($asset->type == 'stocks' && $assetType == 'stocks') {
                $assetBalances[] = $processed[$key]['patrimony'];
            } else if ($asset->type == 'reit' && $assetType == 'reit') {
                $assetBalances[] = $processed[$key]['patrimony'];
            }
        }
        return $assetBalances;
    }
}
