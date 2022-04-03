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
        $match = MatchesRecords::create($request->all());

        // 抓取參賽者, 清除空白, 檢查是否有斜線, 若有則先炸掉斜線再存入
        $participants = $match->participants;

        // 參賽者部分去除逗號和所有空白
        $participants = trim($participants);
        $participants = preg_replace('/\s(?=)/', '', $participants);

        // 規則部分去除逗號和頭尾空白
        $match->rule = trim($match->rule);
        $match->rule = str_replace(',', '', $match->rule);

        // 贏家部分去除所有空白
        $match->result = preg_replace('/\s(?=)/', '', $match->result);

        if(strpos($participants,'/') !== false){
            $ary = [];
            $tagTeamAry = explode('/',$participants);
            foreach($tagTeamAry as $participant){
                array_push($ary, $participant);
                $match['participants'] = $ary;
            }
            $match->save();
        }else{
            $ary = [$participants];
            $match['participants'] = $ary;
            $match->save();
        }

        return redirect()->back()->with('store','success!');
    }

    public function edit($stream_id,$id)
    {
        $item = MatchesRecords::find($id);
        $wrestlers_name = Profiles::where('isVisible', '1')->select('name_short')->get();

        $participants_ary = json_decode($item->participants);
        $item->participants = '';

        foreach($participants_ary as $key => $participants){
            if($key+1 != count($participants_ary)){
                $item->participants .= $participants.'/';
            }else{
                $item->participants .= $participants;
            }
        }

        return view('admin.matchResult.edit',compact('stream_id','item','wrestlers_name'));
    }

    public function update(Request $request,$id)
    {

        $item = MatchesRecords::find($id);
        $item->update($request->all());

        // 抓取參賽者, 清除空白, 檢查是否有斜線, 若有則先炸掉斜線再存入
        $participants = $item->participants;

        // 參賽者部分去除逗號和所有空白
        $participants = trim($participants);
        $participants = preg_replace('/\s(?=)/', '', $participants);

        // 規則部分去除逗號和頭尾空白
        $item->rule = trim($item->rule);
        $item->rule = str_replace(',', '', $item->rule);

        // 贏家部分去除所有空白
        $item->result = preg_replace('/\s(?=)/', '', $item->result);

        if(strpos($participants,'/') !== false){
            $ary = [];
            $tagTeamAry = explode('/',$participants);
            foreach($tagTeamAry as $participant){
                array_push($ary, $participant);
                $item['participants'] = $ary;
            }
            $item->save();
        }else{
            $ary = [$participants];
            $item['participants'] = $ary;
            $item->save();
        }


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
