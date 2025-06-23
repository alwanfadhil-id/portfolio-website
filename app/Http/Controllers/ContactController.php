<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function stor(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',

        ]);

        Message::create($request->all());
        return redirect()->back()->with('success', 'Pesan pesan anda telah terkirim, terima kasih telah menghubungi kami.');
    }
}
