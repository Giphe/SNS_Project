@extends('layouts.helloapp')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <p>{{$msg}} </p>
    @if (count($errors) > 0)
     <p>入力に問題があります。再入力してください。</p>
    @endif
    <!-- <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div> -->
    
    <table>
    <form action="/hello" method="post">
        {{csrf_field()}}
        @if ($errors->has('name') > 0)
            <tr><th>ERROR</th><td>{{$errors->first('name')}}</td></tr>
        @endif
        <tr><th>name: </th><td><input type="text"
            name="name" value="{{old('name')}}"></td></tr>
        @if ($errors->has('mail') > 0)
            <tr><th>ERROR</th><td>{{$errors->first('mail')}}</td></tr>
        @endif
        <tr><th>mail: </th><td><input type="text"
            name="mail" value="{{old('mail')}}"></td></tr>
        @if ($errors->has('age') > 0)
            <tr><th>ERROR</th><td>{{$errors->first('age')}}</td></tr>
        @endif
        <tr><th>age: </th><td><input type="text"
            name="age" value="{{old('age')}}"></td></tr>
        <tr><th></th><td><input type="submit"
            value="send"></td></tr>
        </form>
        </table>

@endsection

@section('footer')
    copyright 2019 tuyano.
@endsection