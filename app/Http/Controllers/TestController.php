<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\User;

class TestController extends Controller
{
    public function index()
    {
        // itemsテーブルのデータを全て取得
        $items = Test::get();
        return view('test.index', compact('items'));
    }

    public function create(Request $request)
    {
        $user = User::where('id', \Auth::user()->id)->get();
        return view('test.create', compact('user'));
    }

    public function store(Request $request)
    {
        $id = $request->input('user_id');
        $title = $request->input('title');
        // 画像フォームでリクエストした画像情報を取得
        $img = $request->file('img_path');
        // storage > public > img配下に画像が保存される
        $path = $img->store('img','public');
        // store処理が実行できたらDBに保存処理を実行
        if ($path) {
            // DBに登録する処理
            Test::create([
                'user_id' => $id,
                'title' => $title,
                'img_path' => $path,
            ]);
        }
        // リダイレクト
        return redirect()->route('test.index');
    }
}
