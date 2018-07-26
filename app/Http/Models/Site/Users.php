<?php

namespace App\Http\Models\Site;

use Illuminate\Database\Eloquent\Model;
use Hash;

class Users extends Model{
    
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    protected $fillable = ['name', 'email', 'password'];
    
    public static function getById($id){
        return Users::where('id', '=', $id)->first();
    }
    
    public static function remove($request){
        return Users::where('id', '=', $request->id)->delete();
    }
    
    public static function getByEmail($email){
        return Users::where('email', '=', $email)->first();
    }
    
}