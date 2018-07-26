<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Api\v1\RestController;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Validation\Auth\AuthValidation;

use App\Http\Models\Admin\Users;

class LoginController extends RestController {

    use AuthValidation;

    //авторизация юзера
    public function login(Request $request) : Response {
        $validator = $this->validLogin($request);

        if ($validator->fails()) {
            return $this->error(405, 'Validation error', $validator->errors()->toArray());
        }

        $hasLogged = Auth::once(['email' => mb_strtolower($request->email, 'UTF-8'), 'password' => $request->password]);

        if (!$hasLogged) {
            return $this->error(401, 'Unauthorized');
        }

        $user = Auth::user();

        return $this->json($user);
    }

    public function getUserByEmail(Request $request): Response {
        $data = Users::getUserByEmail($request->email);
        return $this->success($data);
    }

}
