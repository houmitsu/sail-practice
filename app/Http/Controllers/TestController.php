<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;

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
        return view('test.create');
    }

    public function store(Request $request)
    {
        // 画像フォームでリクエストした画像情報を取得
        $img = $request->file('img_path');
        // storage > public > img配下に画像が保存される
        $path = $img->store('img','public');
        // store処理が実行できたらDBに保存処理を実行
        if ($path) {
            // DBに登録する処理
            Test::create([
                'img_path' => $path,
            ]);
        }
        // リダイレクト
        return redirect()->route('test.index');
    }
}
