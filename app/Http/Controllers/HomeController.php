<?php

  namespace App\Http\Controllers;

  use App\Models\House;
  use Illuminate\Http\Request;

  class HomeController extends Controller{
    public function index(Request $request){
        // 最新の10件のHouseを取得
        $newHouses = House::orderBy('created_at', 'desc')->take(10)->get();

        // ビューにデータを渡す
        return view('index', ['newHouses' => $newHouses]);
    }
  }

