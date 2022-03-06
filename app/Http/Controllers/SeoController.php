<?php

namespace App\Http\Controllers;

use App\Models\Seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index() {
        $seo = Seo::where('id', 1)->first();
        return view('admin.seo.index',compact('seo'));
    }

    public function update(Request $request) {
        $data = $request->all();
        Seo::find(1)->update($data);
        return redirect('/admin/seo')->with('message','success!');
    }

}
