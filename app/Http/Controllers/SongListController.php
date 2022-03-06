<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use App\Models\MatchesRecords;
use App\Models\SongsLists;
use Illuminate\Http\Request;

class SongListController extends Controller
{
    public function index($stream_number)
    {
        $items = SongsLists::where('stream_id', $stream_number)->orderBy('stream_id','asc')->get();

        return view('admin.songlist.index',compact('items','stream_number'));
    }

    public function create($stream_number)
    {
        $games = MatchesRecords::where('stream_id',$stream_number)->orderBy('game','asc')->get();

        return view('admin.songlist.create',compact('stream_number','games'));
    }

    public function store(Request $request)
    {
        SongsLists::create($request->all());

        return redirect()->back()->with('store','success!');
    }

    public function edit($id)
    {

        $item = SongsLists::find($id);
        $games = MatchesRecords::where('stream_id',$item->stream_id)->orderBy('game','asc')->get();

        return view('admin.songlist.edit',compact('item','games'));
    }

    public function update(Request $request,$id)
    {
        $item = SongsLists::find($id);
        $item->update($request->all());

        $item->save();

        return redirect()->back()->with('update','success!');
    }

    public function delete(Request $request,$id)
    {
        $items = SongsLists::find($id);

        $items->delete();

        return redirect()->back();
    }

}
