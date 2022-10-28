<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\User;
use App\Models\Like;
use Auth;

class TestController extends Controller
{
    // only()の引数内のメソッドはログイン時のみ有効
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->only(['like', 'unlike']);
    }

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

    /**
    * 引数のIDに紐づくリプライにLIKEする
    *
    * @param $id リプライID
    * @return \Illuminate\Http\RedirectResponse
    */
    public function like($id)
    {
        Like::create([
        'test_id' => $id,
        'user_id' => Auth::id(),
        ]);

        session()->flash('success', 'you liked.');

        return redirect()->back();
    }

    /**
     * 引数のIDに紐づくリプライにUNLIKEする
     *
     * @param $id リプライID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlike($id)
    {
        $like = Like::where('test_id', $id)->where('user_id', Auth::id())->first();
        $like->delete();

        session()->flash('success', 'you unliked.');

        return redirect()->back();
    }
}
