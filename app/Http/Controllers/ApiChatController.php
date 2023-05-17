<?php

namespace App\Http\Controllers;

use App\Events\massage;
use Illuminate\Http\Request;

class ApiChatController extends Controller
{
    public  function massage(Request $request){
        event(new massage($request->input('username'),$request->input('massage')));
        return [];
    }
}
