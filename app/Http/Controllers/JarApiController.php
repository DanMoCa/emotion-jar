<?php

namespace App\Http\Controllers;

use App\Models\Jar;
use Illuminate\Http\Request;

class JarApiController extends Controller
{

    public function show(Request $request, Jar $jar = null){
        if(isset($jar)){
            if($request->user()->id != $jar->user_id){
                return response()->json(['message'=>'unauthorized.'],401);
            }    
            return response()->json($jar,200);
        }else{
            return response()->json($request->user()->jar,200);
        }
    }

    public function store(Request $request){
        $request->validate([            
            'name' => ['required','string']
        ]);

        $jar = Jar::create(['user_id'=>$request->user()->id,'name'=>$request->name]);

        return response()->json($jar,201);
    }

    public function update(Request $request, Jar $jar){
        if($request->user()->id != $jar->user_id){
            return response()->json(['message'=>'unauthorized.'],401);
        }

        $request->validate(([            
            'name' => ['required','string']
        ]));

        
        $jar->update(['name'=>$request->name]);

        return response()->json($jar,200);
    }

    public function delete(Request $request, Jar $jar){
        if($request->user()->id != $jar->user_id){
            return response()->json(['message'=>'unauthorized.'],401);
        }
        
        $jar->delete();

        return response()->json(['message'=>'Jar deleted successfully.'],200);
    }
}
