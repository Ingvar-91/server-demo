<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\RestController;
use Illuminate\Http\Request;
use Auth;

use App\Validation\Auth\AuthValidation;
use App\Http\Models\Admin\Users;

class RegisterController extends RestController {
    
    use AuthValidation;

    protected $redirectTo = '/';
	
    const tmpl = 'auth/';

    //создать юзера
    public function createUser(Request $request) {
        $validator = $this->validReg($request); //валидируем данные
        
        if ($validator->fails()) {
            return $this->error(405, 'Validation error', $validator->errors()->toArray());
        }
        
        //если загружена аватарка
        $nameImage = '';
        if($request->hasFile('file')){
            //загружаем аватарку на сервер
            $nameImage = $this->uploadImage($request->file('file'));
        }
        
        Users::add($request, $nameImage);//создаем пользователя
        
        $hasLogged = Auth::once(['email' => mb_strtolower($request->email, 'UTF-8'), 'password' => $request->password]);

        if (!$hasLogged) {
            return $this->error(401, 'Unauthorized');
        }
        
        $user = Auth::user();
        
        return $this->success($user);
    }
    
}