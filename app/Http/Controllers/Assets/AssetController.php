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

    public function index()
    {
        $this->service = new APIService(Auth::user());
        $api = $this->service->fetchData();
        $assets = Asset::all();
        
        return view('assets.index', ['api' => $api, 'assets' => $assets]);
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
}
