<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Models\Admin\Users;
use App\Http\Models\Admin\Posts;

use Image;

class PostsController extends RestController {
    
    public function index(Request $request) : Response{
        $data = Posts::getData($request);
        return $this->success([
            'items' => $data,
            'total' => Posts::getCount()
        ]);
    }
    
    public function add(Request $request) : Response{
        $filesName = '';
        if($request->hasFile('files')) {
            $filesName = $this->uploadFiles($request->file('files'));
        }
        $data = Posts::add($request, $filesName);
        return $this->success($data);
    }
    
    public function edit(Request $request) : Response{
        $filesName = '';
        if($request->hasFile('files')) {
            $filesName = $this->uploadFiles($request->file('files'));
        }
        $data = Posts::edit($request, $filesName);
        return $this->success($data);
    }
    
    public function uploadFiles($files) {
        $filesName = '';
        foreach ($files as $file) {
            $type = $file->getClientOriginalExtension();
            $nameFile = md5(time().rand(100, 100000));
            $file->move('img/posts/', $nameFile.'.'.$type);
            $filesName .= $nameFile.'.'.$type.'|';
        }
        return $nameFile.'.'.$type;
    }
    
    public function remove(Request $request) : Response{
        $data = Posts::remove(explode(',', $request->ids));
        return $this->success($data);
    }
    
    public function getById(Request $request) : Response{
        $data = Posts::getById($request->id);
        return $this->success($data);
    }
    
    public function getCountPostsByRangeDate(Request $request) : Response{
        $data = Posts::getCountPostsByRangeDate($request);
        return $this->success($data);
    }
    
}