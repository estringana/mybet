<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class MessagesController extends Controller
{
    public function index()
    {
           return view('messages.message');
    }

    public function store(Request $request)
    {
           $this->validate($request, [
                'message' => 'required',
            ]);

           $message = new \App\Models\Message();
           $message->message = $request->input('message');
           $message->associateUser(\Auth::user());
           $message->save();

           return redirect('/');
    }

    public function list()
    {
        $messages = \App\Models\Message::all();

        return view('admin.messages.list')->with(compact('messages'));
    }
}
