<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\NetworkType;
use App\Http\Controllers\Controller;
use App\Models\Network;
use App\Models\Franchise;
use App\Models\PDV;

use App\Http\Requests;

class NetworkAPIController extends Controller
{
    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
        $this->middleware('jwt.auth');
    }

    public function getNetworkTypes()
    {
        $networktypes = NetworkType::all();
        return $networktypes;
    }

    public function getNetworks()
    {
        $networks = Network::all();
        return $networks;
    }

    public function getFranchises()
    {
        $franchises = Franchise::all();
        return $franchises;
    }

    public function getPDVs()
    {
        $pdvs = PDV::all();
        return $pdvs;
    }
}
