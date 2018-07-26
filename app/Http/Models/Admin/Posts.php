<?php

namespace App\Http\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Hash;
use DB;

class Posts extends Model{
    
    public static function getById($id){
        return Posts::where('id', '=', $id)->first();
    }
    
    public static function remove($ids){
        return Posts::whereIn('id', $ids)->delete();
    }
    
    public static function getCount(){
        return Posts::count();
    }
    
    public static function getCountPostsByRangeDate($request){
        return Posts::select(
                    DB::raw("count(*) as count"), 
                    DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at_format")
                )
                ->whereDate('created_at', '>=', $request->startDate)
                ->whereDate('created_at', '<=', $request->endDate)
                ->groupBy('created_at_format')
                ->get();
    }
    
    public static function getData($request){
        $query = Posts::orderBy($request->sort, $request->order)
                ->leftJoin('users', 'posts.user_id', '=', 'users.id')
                ->addSelect(
                    'posts.*',
                    'users.email as user_email',
                    'users.name as user_name'
                );
        if ($request->searchValue and $request->searchField) {
            $query->where($request->searchField, 'like', '%'.$request->searchValue.'%');
        }
        return $query->offset($request->offset)->limit($request->limit)->get();
    }
    
    public static function add($request, $files = null) {
        return Posts::insert([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'files' => $files
        ]);
    }
    
    public static function edit($request, $files = null) {
        $update = [
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt
        ];
        if($files){
            $update['files'] = $files;
        }
        return Posts::where('id', $request->id)->update($update);
    }
}