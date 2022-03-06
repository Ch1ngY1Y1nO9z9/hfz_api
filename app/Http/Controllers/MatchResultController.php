<?php

namespace App\Http\Controllers;

use App\Models\Profiles;
use App\Models\MatchesRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MatchResultController extends Controller
{
    public function index($id)
    {
        $items = MatchesRecords::where('stream_id',$id)->get();
        $wrestlers_name = Profiles::select('name_short')->get();

        $records_number = count($items);

        return view('admin.matchResult.index',compact('id','items','wrestlers_name','records_number'));
    }

    public function create($id)
    {
        $wrestlers_name = Profiles::select('name_short')->get();

        return view('admin.matchResult.create',compact('id','wrestlers_name'));
    }

    public function store(Request $request)
    {
        $new_record =  MatchesRecords::create($request->all());

        $new_record->save();

        return redirect()->back()->with('store','success!');
    }

    public function edit($stream_id,$id)
    {
        $item = MatchesRecords::find($id);
        $wrestlers_name = Profiles::select('name_short')->get();

        return view('admin.matchResult.edit',compact('stream_id','item','wrestlers_name'));
    }

    public function update(Request $request,$id)
    {

        $item = MatchesRecords::find($id);
        $item->update($request->all());

        $winners_array = explode(' ',$item->result);
        $winners = '';
        foreach($winners_array as $array){
            $winners = $winners.$array;
        }

        $item->result = $winners;

        $item->save();

        return redirect()->back()->with('update','success!');
    }

    public function delete(Request $request,$id)
    {
        $items = MatchesRecords::find($id);

        $items->delete();

        return redirect()->back();
    }

    //刪除檔案
    public function delete_file($path){
        File::delete(public_path().$path);
    }
}
