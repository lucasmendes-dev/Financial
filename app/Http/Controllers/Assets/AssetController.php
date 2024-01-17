<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\ApiValues;
use App\Models\Asset;
use App\Models\User;
use App\Services\ApiService;
use App\Services\GenerateApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    protected $service;
    protected $assets;
    protected $user;

    public function __construct(User $user)
    {
    }
    public function index()
    {
        $user = Auth::user();
        $this->assets = Asset::where('user_id', $user->id)->get();

        $stocks = Asset::where('user_id', Auth::user()->id)->where('type', 'stocks')->get(); 
        $reit = Asset::where('user_id', Auth::user()->id)->where('type', 'reit')->get();

        $this->service = new APIService($user);
        $processedData = $this->service->processedData();

        if (empty($processedData)) {
            return view('assets.empty-assets');
        }

        return view('assets.index', ['processedData' => $processedData, 'assets' => $this->assets, 'stocks' => $stocks, 'reit' => $reit]);
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $assetCodes = Asset::where('user_id', Auth::user()->id)->pluck('code')->all();;
        $data = $request->all();

        if(in_array($data['code'], $assetCodes)) {
            return redirect(route('assets.index'));  //precisa ainda configurar a mensagem de retorno
        }

        $data['name'] = 'teste';
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 1;
        $data['average_price'] = preg_replace('/,(\d+)/', '.$1', $data['average_price']);
        Asset::create($data);

        $this->service = new ApiService(Auth::user());
        $this->service->saveValuesOnDB(Auth::user());

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
        $apiValue = ApiValues::where('code', $asset->code)
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
}
