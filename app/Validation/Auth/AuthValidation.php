<?php

namespace App\Validation\Auth;

use Illuminate\Http\Request;
//use Validator;
use Illuminate\Validation\Validator;

trait AuthValidation{
    
    //валидация входных данных от пользователя при регистрации
    private function validReg($request) : Validator {
        return \Validator::make($request->all(), [
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'alpha_dash|required|min:4|max:255',
                'name' => 'nullable|string|max:255'
            ], $this->messages()
        );
    }
    
    //валидация входных данных от пользователя при авторизации
    protected function validLogin($request) : Validator {
        return \Validator::make($request->all(), [
                'email' => 'required|email|max:255|exists:users,email',
                'password' => 'required|max:255',
            ], $this->messages());
    }
    
    protected function validEmail($request) : Validator {
        return \Validator::make($request->all(), [
                'email' => 'required|email|max:255|exists:users,email'
            ], $this->messages());
    }
    
    //сообщения об ошибках валидации
    private function messages(){
        return [
            'name.required' => 'Имя не должно быть пустым.',
            'name.alpha_dash' => 'Имя может содержать только буквы, цифры и дефисы.',
            'name.exists' => 'Такого пользователя не существует.',
            'name.unique' => 'Пользователь с таким именем уже существует.',
            'email.unique' => 'Пользователь с таким E-mail уже существует.',
            'email.required' => 'Поле E-mail не должно быть пустым.',
            'email.exists' => 'Такого пользователя не существует.',
            'password.required' => 'Поле пароля не должно быть пустым.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен иметь длину не меньше 6 символов.',
            'password.alpha_dash' => 'Пароль может содержать только буквы, цифры и дефис.',
            'password.error' => 'Ошибка, возможно вы ввели неверный пароль'
        ];
    }
    
}