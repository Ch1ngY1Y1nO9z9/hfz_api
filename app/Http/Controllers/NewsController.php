<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class NewsController extends Controller
{
    public function index()
    {
        $news_lists = News::orderBy('id','desc')->get();
        return view('admin.news.index',compact('news_lists'));
    }
    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['date'] = date('Y/m/d');
        if($data["type"] == 'Promote'){
            $data["content"] = $data["img"];
            $data["img"] = null;
        }else{
            $linkAry = explode('.',$data['img']);
            $data['thumbnail'] = '';
            foreach($linkAry as $key => $link){
                if($key+1 == count($linkAry)){
                    $data['thumbnail'] = $link.'m.';
                }else if($key+1 != count($linkAry)){
                    $data['thumbnail'] = $data['thumbnail'].$link.'.';
                }else{
                    $data['thumbnail'] = $data['thumbnail'].$link;
                }
            }
        }


        $new_record = News::create($data);

        $new_record->save();

        return redirect('/admin/news')->with('store','store success!');

    }

    public function upload_img (Request $request)
    {
        $img = $request->src;
        $base64_string= explode(',', $img);
        $client_id="e88d27b3d1cd4f5";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => $base64_string[1]));

        $reply = curl_exec($ch);
        curl_close($ch);

        $reply = json_decode($reply);

        $link = $reply->data->link;

        return $link;
    }

    public function edit($id)
    {
        $news = News::find($id);
        return view('admin.news.edit',compact('news'));
    }

    public function update(Request $request,$id)
    {
        $item = News::find($id);
        $item->update($request->all());
        $item->save();

        return redirect('/admin/news')->with('update','update success!');
    }

    public function delete(Request $request,$id)
    {

        $items = News::find($id);

        if($items){
            $items->delete();
        }


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
        $destinationPath = public_path() . '/news_upload/';
        $original_filename = $file->getClientOriginalName();

        $filename = $file->getFilename() . '.' . $extension;
        $url = '/news_upload/' . $filename;

        $file->move($destinationPath, $filename);

        return $url;
    }

    //刪除檔案
    public function delete_file($path){
        File::delete(public_path().$path);
    }
}
