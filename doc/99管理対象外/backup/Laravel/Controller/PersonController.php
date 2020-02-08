<?php

namespace App\Http\Controllers;

use App\Person;
use Illuminate\Http\Request;
use Log;

class PersonController extends Controller
{
    public function index(Request $request) {
        $items = Person::all();
        return view('person.index', ['items' => $items]);
    }

    public function find(Request $request) {
        return view('person.find', ['input' => '']);
    }

    public function search(Request $request) {

        $item = Person::find($request->input);
        $param = ['input' => $request->input, 'item' => $item];

        // DEBUG
        Log::debug('$item="'.$item.'"');
        Log::debug(print_r($param, true));

        return view('person.find', $param);
    }
}
