<?php

namespace App\Http\Controllers;

use App\Models\Profiles;
use App\Models\WrestlerClips;
use Illuminate\Http\Request;


class ClipsController extends Controller
{
    public function index($wrestler_id)
    {
        $wrestler = Profiles::find($wrestler_id);
        $items = WrestlerClips::where('wrestler_id',$wrestler_id)->with('clips')->get();

        return view('admin.clips.index',compact('wrestler','items'));
    }
    public function create($wrestler_id)
    {
        $wrestler = Profiles::find($wrestler_id);
        return view('admin.clips.create',compact('wrestler'));
    }

    public function store(Request $request)
    {
        $new_record = WrestlerClips::create($request->all());

        $new_record->save();

        return redirect()->back()->with('store','store success!');

    }

    public function edit($wrestler_id,$id)
    {
        $wrestler = Profiles::find($wrestler_id);
        $item = WrestlerClips::find($id);

        return view('admin.clips.edit',compact('wrestler', 'item'));
    }

    public function update(Request $request,$id)
    {
        $item = WrestlerClips::find($id);
        $item->update($request->all());

        return redirect()->back()->with('update','update success!');
    }

    public function delete(Request $request,$id)
    {
        $items = WrestlerClips::find($id);

        $items->delete();

        return redirect()->back();
    }

}
