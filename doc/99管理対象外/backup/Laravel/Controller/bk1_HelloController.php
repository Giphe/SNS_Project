<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\HelloRequest;
use Validator;

class HelloController extends Controller
{
    public function index(Request $request) 
    {
        $validator = Validator::make($request->query(), [
            'id' => 'required',
            'pass' => 'required',
        ]);
        if ($validator->fails()) {
            $msg = 'クエリーに問題があります。';
        } else {
            $msg = 'ID/PASSを受け付けました。フォームを入力してください。';
        }
        return view('hello.index', ['msg'=>$msg]);
        // return view('hello.index');
    }
    // public function post(Request $request) 
    // {
    //     $validate_rule = [
    //         'name'=> 'required',
    //         'mail'=> 'email',
    //         'age'=> 'numeric|between:0,150',
    //     ];
    //     $this->validate($request, $validate_rule);
    //     return view('hello.index', ['msg'=>'メッセージが正しく入力されました！']);
    // }

    // public function post(HelloRequest $request) 
    // {
    //     return view('hello.index', ['msg'=>'正しく入力されました！']);
    // }

    public function post(Request $request) 
    {
        $rules = [
            'name' => 'required',
            'mail' => 'email',
            //'age' => 'numeric |between:0,150',
            'age' => 'numeric',
        ];
        $messages = [
            'name.required' => '名前は必ず入力してください。',
            'mail.email' => 'メールアドレスが必要です。。',
            'age.numeric' => '年齢を整数で記入してください。',
            'age.min' => '年齢は０歳以上で入力してください',          
            'age.max' => '年齢は200歳以下で入力してください。',          
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->sometimes('age', 'min:0', function($input) {
            return !is_int($input->age);
        });
        $validator->sometimes('age', 'max:200', function($input) {
            return !is_int($input->age);
        });

        if ($validator->fails()) {
            return redirect('/hello')
            ->withErrors($validator)
            ->withInput();
        }
        return view('hello.index', ['msg'=>'正しく入力されました！']);
    }
}