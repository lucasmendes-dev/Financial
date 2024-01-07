<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
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

        $this->service = new APIService($user);
        $processedData = $this->service->processedData();

        if (empty($processedData)) {
            return view('assets.empty-assets');
        }
        
        return view('assets.index', ['processedData' => $processedData, 'assets' => $this->assets]);
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['status'] = 1;
        $data['average_price'] = preg_replace('/,(\d+)/', '.$1', $data['average_price']);
        Asset::create($data);

        $this->service = new ApiService(Auth::user());
        $this->service->saveValuesOnDB(Auth::user());
        $processedData = $this->service->processedData();

        return view('assets.index', ['processedData' => $processedData, 'assets' => $this->assets]);
    }

    public function show(Asset $asset)
    {
        //
    }

    public function edit(Asset $asset)
    {
        //
    }

    public function update(Request $request, Asset $asset)
    {
        //
    }

    public function destroy(Asset $asset)
    {
        //
    }

    public function reloadData()
    {
        $this->service = new ApiService(Auth::user());
        $this->service->saveValuesOnDB(Auth::user());
        $processedData = $this->service->processedData();

        return view('assets.reloaded-assets');
    }
}
