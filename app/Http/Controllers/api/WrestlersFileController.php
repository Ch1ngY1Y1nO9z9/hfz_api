<?php

namespace App\Http\Controllers\api;

use App\Models\Profiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WrestlersFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gen1 = Profiles::where('generations_id','1')->get();
        return json_encode($gen1);
    }
}
