<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Models\Admin\News;

use Image;

class NewsController extends RestController {
    
    public function index(Request $request) : Response{
        $data = News::getData($request);
        return $this->success([
            'items' => $data,
            'total' => News::getCount()
        ]);
    }
    
    public function add(Request $request) : Response{
        $filesName = '';
        if($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $type = $file->getClientOriginalExtension();
                $nameFile = md5(time().rand(100, 100000));
                $file->move('img/news/', $nameFile.'.'.$type);
                $filesName = $nameFile.'.'.$type.'|';
            }
        }
        $data = News::add($request, $filesName);
        return $this->success($data);
    }
    
    public function edit(Request $request) : Response{
        $data = News::edit($request);
        return $this->success($data);
    }
    
    public function remove(Request $request) : Response{
        $data = News::remove(explode(',', $request->ids));
        return $this->success($data);
    }
    
    public function getById(Request $request) : Response{
        $data = News::getById($request->id);
        return $this->success($data);
    }
    
    public function getCountNewsByRangeDate(Request $request) : Response{
        $data = News::getCountNewsByRangeDate($request);
        return $this->success($data);
    }
    
    public function upload(Request $request) : Response{
        $file = $request->file('file');
        $type = $file->getClientOriginalExtension();
        $nameFile = md5(time());
        $file->move('img/news/', $nameFile.'.'.$type);
        /*$path = 'img/news/'.$nameFile.'.'.$type;
        
        Image::make($file->getPathName())->save($path);*/
        
        return $this->success([]);
    }

}