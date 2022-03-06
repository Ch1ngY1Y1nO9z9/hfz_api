<?php

namespace App\Http\Controllers;

use App\Models\Profiles;
use App\Models\WinLoseRatio;
use App\Models\WrestlerData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProfilesController extends Controller
{
    public function index()
    {
        $items = Profiles::with('gens')->get();

        return view('admin.profiles.index',compact('items'));
    }


    public function edit_data($id)
    {
        $all_wrestler = Profiles::all();

        $wrestler = Profiles::find($id);
        $item = WrestlerData::find($id);

        return view('admin.profiles.edit_data',compact('wrestler','item','all_wrestler'));
    }

    public function update_data(Request $request,$id)
    {
        $all_wrestler = Profiles::all();

        $item = WrestlerData::find($id);
        $item->update($request->all());

        $item->save();

        $wrestler = $item->data;

        if($request->toindex){

            foreach($all_wrestler as $single_data){
                $single_data->toindex = 0;
                $single_data->save();
            }


            $wrestler->toindex = 1;
        }else{
            $wrestler->toindex = 0;
        }


        if($request->isHolochampion){

            foreach($all_wrestler as $single_data){
                $single_data->isHolochampion = 0;
                $single_data->save();
            }

            $wrestler->isHolochampion = 1;
        }else{
            $wrestler->isHolochampion = 0;
        }


        if($request->isQoj){

            foreach($all_wrestler as $single_data){
                $single_data->isQoj = 0;
                $single_data->save();
            }

            $wrestler->isQoj = 1;
        }else{
            $wrestler->isQoj = 0;
        }


        if($request->isTagTeamChampion){

            foreach($all_wrestler as $single_data){
                $single_data->isTagTeamChampion = 0;
                $single_data->save();
            }

            $wrestler_teammate = Profiles::where('name_short', $request->team_mate)->first();
            $wrestler_teammate->isTagTeamChampion = 1;
            $wrestler->isTagTeamChampion = 1;
            $wrestler_teammate->save();
        }else{
            $wrestler->isTagTeamChampion = 0;
        }


        if($request->haveBriefcase){
            $wrestler->haveBriefcase = 1;
        }else{
            $wrestler->haveBriefcase = 0;
        }

        $wrestler->save();


        return redirect()->back()->with('message','success!');
    }

    public function delete(Request $request,$id)
    {
        $items = Profiles::find($id);

        if($items->image_url){
            $this->delete_file($items->image_url);
        }

        $items->delete();

        return redirect()->back();
    }

    //上傳檔案
    public function upload_file($file){
        $allowed_extensions =["png", "jpg", "gif", "PNG", "JPG", "GIF","jpeg","JPEG"];

        if ($file->getClientOriginalExtension() &&
            !in_array($file->getClientOriginalExtension(), $allowed_extensions))
        {
            return redirect()->back()->with('message','僅接受.jpg, .png, .gif, .jepg格式檔案!');
        }
        $extension = $file->getClientOriginalExtension();
        $destinationPath = public_path() . '/profiles/';
        $original_filename = $file->getClientOriginalName();

        $filename = $file->getFilename() . '.' . $extension;
        $url = '/profiles/' . $filename;

        $file->move($destinationPath, $filename);

        return $url;
    }

    //刪除檔案
    public function delete_file($path){
        File::delete(public_path().$path);
    }


    public function rank_index()
    {
        $items = Profiles::orderBy('rank','asc')->get();

        return view('admin.rank.index',compact('items'));
    }

    public function rank_update (Request $request)
    {
        $wrestlers_id = $request->wrestler_id;
        $new_rank = $request->rank;

        foreach($wrestlers_id as $key => $wrestler_id){
            $wrestler = Profiles::find($wrestler_id);

            $wrestler->last_week_rank = $wrestler->rank;
            $wrestler->rank = $new_rank[$key];

            $wrestler->save();
        }

        return redirect()->back()->with('message','success!');
    }
}
