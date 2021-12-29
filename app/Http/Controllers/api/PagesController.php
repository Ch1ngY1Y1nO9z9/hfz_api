<?php

namespace App\Http\Controllers\api;

use App\Models\Profiles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Generations;

class PagesController extends Controller
{
    public function getGenerations()
    {
        $data = Generations::all();
        return $data;
    }

    public function getAllProfiles()
    {

        $data = Profiles::all();
        return $data;
    }

    public function Profiles($gen)
    {
        if($gen == 'all')
            $data = Profiles::all();
        else{
            $data = Profiles::where('generations_id', $gen)->get();
        }


        return json_encode($data);
    }


}
