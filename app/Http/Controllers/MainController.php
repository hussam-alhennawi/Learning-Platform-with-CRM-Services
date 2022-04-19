<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;
use View;

class MainController extends Controller
{

    public function __construct(Request $request) 
    {
        $url = $request->fullUrl();
        $u = Visitor::where('url',$url)->first();
        if($u)
        {
            $u->count++;
            $u->save();
        }
        else
        {
            $u = Visitor::create(['url'=>$url , 'count'=>1]);
        }
        View::share ( 'visitors', $u->count);
    }

}