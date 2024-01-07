<?php

namespace App\Http\Controllers\Assets;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssetController extends Controller
{
    protected $service;
    protected $assets;
    protected $user;

    public function __construct()
    {
        $this->assets = Asset::all();
    }
    public function index()
    {
        $this->service = new APIService(Auth::user());
        $processedData = $this->service->processedData();
        
        return view('assets.index', ['processedData' => $processedData, 'assets' => $this->assets]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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

        return view('assets.index', ['processedData' => $processedData, 'assets' => $this->assets]);
    }
}
