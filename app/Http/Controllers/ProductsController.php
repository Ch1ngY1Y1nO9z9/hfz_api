<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\ProductsType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index()
    {
        $items = Products::all();
        return view('admin.products.index',compact('items'));
    }

    public function create()
    {
        $types = ProductsType::all();
        return view('admin.products.create',compact('types'));
    }

    public function store(Request $request)
    {
        $new_record =  Products::create($request->all());

        if($request->hasFile('img')){
            $new_record->fill(['img' => $this->upload_file($request->file('img'))]);
        }

        $new_record->save();

        return redirect('/admin/products');
    }

    public function edit($id)
    {
        $item = Products::find($id);
        $types = ProductsType::all();
        return view('admin.products.edit',compact('item','types'));
    }

    public function update(Request $request,$id)
    {
        $item = Products::find($id);
        $item->type = $request->type;
        $item->name_en = $request->name_en;
        $item->name_ch = $request->name_ch;
        $item->content_ch = $request->content_ch;
        $item->content_en = $request->content_en;
        $item->sort = $request->sort;

        if($request->hasFile('img')){
            $this->delete_file($item->img);
            $item->img = $this->upload_file($request->file('img'));
        }

        $item->save();

        return redirect('/admin/products');
    }

    public function delete(Request $request,$id)
    {
        $items = Products::find($id);

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
        $destinationPath = public_path() . '/products/';
        $original_filename = $file->getClientOriginalName();

        $filename = $file->getFilename() . '.' . $extension;
        $url = '/products/' . $filename;

        $file->move($destinationPath, $filename);

        return $url;
    }

    //刪除檔案
    public function delete_file($path){
        File::delete(public_path().$path);
    }
}
