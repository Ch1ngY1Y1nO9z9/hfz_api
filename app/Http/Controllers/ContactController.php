<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
        $lists = ContactUs::all();
        return view('admin.contact.index',compact('lists'));
    }

    public function show($id){
        $contact_info = ContactUs::find($id);
        return view('admin.contact.show',compact('contact_info'));
    }

    public function delete(Request $request,$id){
        $items = ContactUs::find($id);
        $items->delete();

        return redirect('/admin/contact')->with('message','成功!');
    }
}
