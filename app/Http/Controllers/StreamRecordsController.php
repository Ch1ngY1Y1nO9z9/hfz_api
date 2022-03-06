<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StreamRecordsController extends Controller
{
    public function index()
    {
        $items = Matches::orderBy('id','desc')->get();

        return view('admin.stream.index',compact('items'));
    }

    public function create()
    {
        $number = count(Matches::all());

        return view('admin.stream.create',compact('number'));
    }

    public function store(Request $request)
    {
        $new_record =  Matches::create($request->all());

        if($request->hasFile('background_image')){
            $new_record->fill(['background_image' => $this->upload_file($request->file('background_image'))]);
        }

        $new_record->save();

        return redirect('/admin/stream');
    }

    public function edit($id)
    {
        $item = Matches::find($id);

        return view('admin.stream.edit',compact('item'));
    }

    public function update(Request $request,$id)
    {

        $item = Matches::find($id);
        $item->update($request->all());

        if($request->hasFile('background_image')){
            $this->delete_file($item->background_image);
            $item->background_image = $this->upload_file($request->file('background_image'));
        }

        $item->save();

        return redirect()->back()->with('update','success!');
    }

    public function delete(Request $request,$id)
    {
        $items = Matches::find($id);

        if($items->background_image){
            $this->delete_file($items->background_image);
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
            return redirect()->back()->with('message','.jpg, .png, .gif, .jepg file only!');
        }
        $extension = $file->getClientOriginalExtension();
        $destinationPath = public_path() . '/StreamRecords/';
        $original_filename = $file->getClientOriginalName();

        $filename = $file->getFilename() . '.' . $extension;
        $url = '/StreamRecords/' . $filename;

        $file->move($destinationPath, $filename);

        return $url;
    }

    //刪除檔案
    public function delete_file($path){
        File::delete(public_path().$path);
    }
}
