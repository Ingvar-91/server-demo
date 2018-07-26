<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;

class Users extends Model{
    
    public static function getById($id){
        return Users::where('id', '=', $id)->first();
    }
    
    public static function getData($request){
        $query = Users::orderBy($request->sort, $request->order);
        if($request->searchValue and $request->searchField){
            $query->where($request->searchField, 'like', '%'.$request->searchValue.'%');
        }
        return $query->offset($request->offset)->limit($request->limit)->get();
    }
    
    public static function getUserByEmail($email){
        return Users::where('email', mb_strtolower($email, 'UTF-8'))->first();
    }
    
    public static function getCount(){
        return Users::count();
    }
    
    public static function remove($ids){
        return Users::whereIn('id', $ids)->delete();
    }
    
    public static function getAll(){
        return Users::get();
    }
    
    public static function add($request, $image = null){
        return Users::insert([
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'phone' => $request->phone,
            'email' => mb_strtolower($request->email, 'UTF-8'),
            'password' => bcrypt(mb_strtolower($request->password, 'UTF-8')),
            'image' => $image
        ]);
    }
    
    public static function edit($request, $image = null){
        $update = [
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'phone' => $request->phone,
            'email' => mb_strtolower($request->email, 'UTF-8')
        ];
        if ($request->password) {
            $update['password'] = bcrypt(mb_strtolower($request->password, 'UTF-8'));
        }
        if ($image) {
            $update['image'] = $image;
        }
        return Users::where('id', $request->id)->update($update);
    }
}