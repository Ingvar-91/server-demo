<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Models\Admin\Users;
use Image;

class UsersController extends RestController {
    
    public function index(Request $request) : Response{
        $data = Users::getData($request);
        return $this->success([
            'items' => $data,
            'total' => Users::getCount()
        ]);
    }
    
    public function add(Request $request) : Response{
        $fileName = '';
        if($request->hasFile('file')) {
            $fileName = $this->cropImage($request->file('file'), $request->cropData);
        }
        $data = Users::add($request, $fileName);
        return $this->success($data);
    }
    
    public function edit(Request $request) : Response{
        $fileName = '';
        if($request->hasFile('file')) {
            $fileName = $this->cropImage($request->file('file'), $request->cropData);
        }
        $data = Users::edit($request, $fileName);
        return $this->success($data);
    }
    
    public function cropImage($file, $cropData){
        $type = $file->getClientOriginalExtension();
        $nameFile = md5(time().rand(100, 10000));
        $path = 'img/users/'.$nameFile.'.'.$type;

        $cropData = json_decode($cropData);

        $originalWidth = $cropData->originalWidth;
        $originalHeight = $cropData->originalHeight;
        $maxWidth = $cropData->maxWidth;
        $maxHeight = $cropData->maxHeight;
        $ratio = $originalHeight / $maxHeight;
        $x1 = ceil($cropData->x1 * $ratio);
        $x2 = ceil($cropData->x2 * $ratio);
        $y1 = ceil($cropData->y1 * $ratio);
        $y2 = ceil($cropData->y2 * $ratio);
        $w = $y2 - $y1;
        $h = $y2 - $y1;
        Image::make($file->getPathName())->heighten($originalHeight)->crop($w, $h, $x1, $y1)->heighten(200)->save($path);
        return $nameFile.'.'.$type;
    }
    
    public function remove(Request $request) : Response{
        $data = Users::remove(explode(',', $request->ids));
        return $this->success($data);
    }
    
    public function getById(Request $request) : Response{
        $data = Users::getById($request->id);
        return $this->success($data);
    }

}