<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;

class Stats extends Model{
    
    public static function getById($id){
        return Stats::where('id', '=', $id)->first();
    }
    
    public static function remove($id){
        return Stats::where('id', '=', $id)->delete();
    }
    
    public static function getAll(){
        return Stats::get();
    }
    /*
    public static function add($request){
        return Stats::insert([
            'name' => $request->name,
            'name' => $request->name
        ]);
    }
    
    public static function edit($request, $image = null){
        $update = [
            'name' => $request->name
        ];
        return News::where('id', $request->id)->update($update);
    }
    */
}