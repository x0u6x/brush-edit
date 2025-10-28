<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class MemoController extends Controller
{
    public function index(){
        $memos = Memo::orderBy('updated_at', 'desc')->get(); //最新順
        return view('memos.index', compact('memos'));
        /*
        viewではmemosという名前を使ってDBのデータを扱ってねという意味合い
        compact('memos') は、変数名 $memos を自動で「キー memos、値 $memos」の連想配列に変換
        ['memos' => $memos]と書くのと同じ
        */    
    }

    public function create(){
        return view('memos.create');
    }

    public function store(Request $request){
        Memo::create($request->all());
        return redirect()->route('memos.index');
    }

    public function edit($id){
        $memo = Memo::find($id);
        return view('memos.edit', compact('memo'));
    }

    public function destroy($id){
    $memo = Memo::find($id);
    $memo->delete();
    return redirect()->route('memos.index');
    }
}