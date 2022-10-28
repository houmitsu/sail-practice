<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\User;

class TestController extends Controller
{
    public function index(Request $request)
    {
        $items = Test::paginate(20);
        $search = $request->input('search');
        $query = Test::query();

        if ($search) {
            // 全角スペースを半角に変換
            $convertSpace = mb_convert_kana($search, 's');
            // 単語を半角スペースで区切り、配列にする（例："山田 翔" → ["山田", "翔"]）
            $searchWord = preg_split('/[\s,]+/', $convertSpace, -1, PREG_SPLIT_NO_EMPTY);
            // 単語をループで回し、ユーザーネームと部分一致するものがあれば、$queryとして保持される
            foreach($searchWord as $word) {
                $query->where('title', 'like', '%'.$word.'%');
            }
            $items = $query->paginate(20);
        }

        return view('test.index')
            ->with([
                'items' => $items,
                'search' => $search,
            ]);
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
