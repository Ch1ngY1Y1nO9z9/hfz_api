<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    function __construct()
    {
        $this->redirect = '/admin';
        $this->index = 'admin.banners.index';
        $this->create = 'admin.banners.create';
        $this->edit = 'admin.banners.edit';
    }

    public function index()
    {
        $items = Banners::all();

        return view($this->index,compact('items'));
    }

    public function edit($id)
    {
        $items = Banners::find($id);
        return view($this->edit,compact('items'));
    }

    public function update(Request $request,$id)
    {
        $items = Banners::find($id);
        $items -> alt = $request->alt;
        if($request->hasFile('img')){
            $this->delete_file($items->img);
            $items->img = $this->upload_file($request->file('img'));
        }

        $items -> save();

        return redirect('/admin/banner')->with('message','更新成功!');
    }

    public function delete($id)
    {
        $items = Banners::find($id);
        $this->delete_file($items->img);
        $items->delete();

        return redirect('/admin/banner')->with('message','刪除成功!');
    }

    //上傳檔案
    public function upload_file($file){
        $allowed_extensions =["png", "jpg", "gif", "PNG", "JPG", "GIF","jpeg","JPEG","pdf"];
        if ($file->getClientOriginalExtension() &&
            !in_array($file->getClientOriginalExtension(), $allowed_extensions))
        {
            return redirect()->back()->with('message','Only.jpg, .png, .gif, .jepg, .pdf!');
        }
        $extension = $file->getClientOriginalExtension();
        $destinationPath = public_path() . '/upload/banner/';
        $original_filename = $file->getClientOriginalName();

        $filename = $file->getFilename() . '.' . $extension;
        $url = '/upload/banner/' . $filename;

        $file->move($destinationPath, $filename);

        return $url;
    }

    //刪除檔案
    public function delete_file($path){
        File::delete(public_path().$path);
    }
}
